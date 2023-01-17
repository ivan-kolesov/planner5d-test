<?php declare(strict_types=1);

namespace App\Console\Commands\Extractors;

class TitleExtractor implements Extractor
{
    private const PROJECT_TITLE_PATTERN = '/<h1.*?>(.+)<\/h1>/mis';

    public function extract(string $body): string
    {
        preg_match(static::PROJECT_TITLE_PATTERN, $body, $matches);
        if (empty($matches[1])) {
            throw new \Exception('Title missed');
        }
        return trim($matches[1]);
    }
}
