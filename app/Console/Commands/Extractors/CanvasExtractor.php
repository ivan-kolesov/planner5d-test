<?php declare(strict_types=1);

namespace App\Console\Commands\Extractors;

class CanvasExtractor implements Extractor
{
    private const CANVAS_PATTERN = '/href="(.+\/v\?key=\w+&viewMode=[^\"]+)"/u';

    public function extract(string $body): string
    {
        preg_match(static::CANVAS_PATTERN, $body, $matches);
        if (empty($matches[1])) {
            throw new \Exception('Canvas missed');
        }
        return trim($matches[1]);
    }
}
