<?php declare(strict_types=1);

namespace App\Console\Commands\Extractors;

class ProjectLinksExtractor implements Extractor
{
    private const PROJECTS_PATTERN = '/href="(.+\/gallery\/floorplans\/\w+\/[^\"]+)">[^<]+/iu';

    public function extract(string $body): array
    {
        preg_match_all(static::PROJECTS_PATTERN, $body, $matches);
        if (empty($matches[1])) {
            throw new \Exception('Projects are empty');
        }
        return $matches[1];
    }
}
