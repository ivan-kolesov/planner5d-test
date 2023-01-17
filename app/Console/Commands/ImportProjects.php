<?php declare(strict_types=1);

namespace App\Console\Commands;

use App\Console\Commands\Extractors\CanvasExtractor;
use App\Console\Commands\Extractors\ProjectLinksExtractor;
use App\Console\Commands\Extractors\TitleExtractor;
use App\Models\Project;
use GuzzleHttp\Promise\Each;
use Illuminate\Http\Client\Response;
use Illuminate\Console\Command;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ImportProjects extends Command
{
    use ThrowIfHttpError;

    private const CONCURRENCY_LIMIT = 4;
    private const LIST_PROJECTS_URL = 'https://planner5d.com/gallery/floorplans';
    private const LIST_FETCH_PAGES = 3;

    protected $signature = 'import:projects';
    protected $description = 'Import projects';
    private int $index = 0;

    public function handle(): int
    {
        DB::table((new Project())->getTable())->truncate();

        try {
            collect()
                ->range(1, static::LIST_FETCH_PAGES)
                ->each(fn(int $page) => $this->fetchPage($page));
            return Command::SUCCESS;
        } catch (RequestException $e) {
            return Command::FAILURE;
        }
    }

    /**
     * @throws RequestException
     */
    private function fetchPage(int $number): void
    {
        $this->line('Fetching page ' . $number);
        $response = Http::get(static::LIST_PROJECTS_URL, ['page' => $number]);
        $this->throwIfHttpError($response);
        try {
            $projectLinks = (new ProjectLinksExtractor())->extract($response->body());
            Http::pool(fn(Pool $pool) => $this->producePoolPromises($pool, $projectLinks));
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

    private function producePoolPromises(Pool $pool, array $projectLinks): array
    {
        return [
            Each::ofLimit(
                (function () use ($pool, $projectLinks) {
                    foreach ($projectLinks as $projectLink) {
                        $project = new Project();
                        $project->order_pos = $this->index++;
                        $this->line('Fetching project: ' . $projectLink);

                        yield $pool->async()
                            ->get($projectLink)
                            ->then(function (Response $response) use ($project) {
                                $this->throwIfHttpError($response);
                                try {
                                    $this->populateProjectWithDetails($project, $response->body());
                                    $project->save();
                                } catch (\Exception $exception) {
                                    $this->error($exception->getMessage());
                                }
                            });
                    }
                })(),
                static::CONCURRENCY_LIMIT
            )
        ];
    }

    /**
     * @throws \Exception
     */
    private function populateProjectWithDetails(Project $project, string $body): void
    {
        $canvasLink = (new CanvasExtractor())->extract($body);
        $canvasLink = str_ireplace('viewMode=3d', 'viewMode=2d', $canvasLink);
        $project->canvas_link = $canvasLink;
        $project->title = (new TitleExtractor())->extract($body);
    }
}
