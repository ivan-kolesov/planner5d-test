<?php declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;

trait ThrowIfHttpError
{
    /**
     * @throws RequestException
     */
    protected function throwIfHttpError(Response $response)
    {
        $response->throw(fn(Response $response, RequestException $e) => $this->error($e->getMessage()));
    }
}
