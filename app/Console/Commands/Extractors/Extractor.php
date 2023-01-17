<?php declare(strict_types=1);

namespace App\Console\Commands\Extractors;

interface Extractor
{
    /**
     * @throws \Exception
     */
    public function extract(string $body);
}
