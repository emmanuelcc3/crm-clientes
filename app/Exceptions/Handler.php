<?php

use Symfony\Component\HttpKernel\Exception\HttpException;

public function render($request, Throwable $exception)
{
    if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
        abort(403);
    }

    return parent::render($request, $exception);
}
