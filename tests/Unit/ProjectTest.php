<?php declare(strict_types=1);

namespace Tests\Unit;

use App\Console\Commands\Extractors\CanvasExtractor;
use App\Console\Commands\Extractors\ProjectLinksExtractor;
use App\Console\Commands\Extractors\TitleExtractor;
use PHPUnit\Framework\TestCase;

class ProjectTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function test_ProjectLinksExtractor(): void
    {
        $expected = [
            'https://planner5d.com/gallery/floorplans/LPbLcZ/floorplans-furniture-living-room-renovation-3d',
            'https://planner5d.com/gallery/floorplans/LPaPOZ/floorplans-kitchen-outdoor-apartment-3d',
            'https://planner5d.com/gallery/floorplans/LPJaZZ/floorplans-house-terrace-furniture-decor-3d',
            'https://planner5d.com/gallery/floorplans/LPJGSZ/floorplans-house-living-room-garage-landscape-household-3d',
            'https://planner5d.com/gallery/floorplans/LPJPaZ/floorplans-living-room-3d',
            'https://planner5d.com/gallery/floorplans/LPJPLZ/floorplans-house-outdoor-architecture-3d',
            'https://planner5d.com/gallery/floorplans/LPJZHZ/floorplans-house-furniture-decor-outdoor-lighting-3d',
            'https://planner5d.com/gallery/floorplans/LPJLZZ/floorplans-apartment-house-bathroom-3d',
            'https://planner5d.com/gallery/floorplans/LPJOfZ/floorplans-house-terrace-bedroom-living-room-architecture-3d',
            'https://planner5d.com/gallery/floorplans/LPJOGZ/floorplans-house-3d',
            'https://planner5d.com/gallery/floorplans/LPXdJZ/floorplans-house-3d',
            'https://planner5d.com/gallery/floorplans/LPXdSZ/floorplans-house-furniture-decor-kitchen-outdoor-3d',
            'https://planner5d.com/gallery/floorplans/LPTSXZ/floorplans-house-kitchen-renovation-dining-room-3d',
            'https://planner5d.com/gallery/floorplans/LPTZfZ/floorplans-house-decor-diy-lighting-3d',
            'https://planner5d.com/gallery/floorplans/LPGbaZ/floorplans-diy-bedroom-kids-room-3d',
            'https://planner5d.com/gallery/floorplans/LPGPHZ/floorplans-apartment-bathroom-bedroom-living-room-kitchen-3d'
        ];
        $body = file_get_contents(__DIR__ . '/gallery_mock.html');
        $extracted = (new ProjectLinksExtractor())->extract($body);

        sort($extracted);
        sort($expected);

        $this->assertEquals($expected, $extracted);
    }

    /**
     * @throws \Exception
     */
    public function test_TitleExtractor(): void
    {
        $expected = 'Title of the project';
        $body = <<<END
            <h1 class="class">$expected</h1>
        END;
        $extracted = (new TitleExtractor())->extract($body);

        $this->assertEquals($expected, $extracted);
    }

    /**
     * @throws \Exception
     */
    public function test_TitleExtractorMultiline(): void
    {
        $expected = 'Title of the project';
        $body = <<<END
            <h1 class="class">
                $expected
            </h1>
        END;
        $extracted = (new TitleExtractor())->extract($body);

        $this->assertEquals($expected, $extracted);
    }

    /**
     * @throws \Exception
     */
    public function test_CanvasExtractor(): void
    {
        $expected = 'https://planner5d.com/v?key=a714c641de5a85d1c19eafc7754b1a20&viewMode=3d';
        $body = <<<END
            <a href="$expected">Link to canvas</a>
        END;
        $extracted = (new CanvasExtractor())->extract($body);

        $this->assertEquals($expected, $extracted);
    }

    /**
     * @throws \Exception
     */
    public function test_CanvasExtractorMultiline(): void
    {
        $expected = 'https://planner5d.com/v?key=a714c641de5a85d1c19eafc7754b1a20&viewMode=2d';
        $body = <<<END
            <a href="$expected" class="class">
                Link to canvas
            </a>
        END;
        $extracted = (new CanvasExtractor())->extract($body);

        $this->assertEquals($expected, $extracted);
    }
}
