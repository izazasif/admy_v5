<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/bikash/get-token',
        '/bkash/create-payment',
        '/bkash/execute-payment',
        '/bkash/query-payment',
        '/bkash/success',
        '/bkash/error',
        'web/bikash/get-token',
        'web/bkash/create-payment',
        'web/bkash/execute-payment',
        'web/bkash/query-payment',
        'web/bkash/success',
        'web/bkash/error',
    ];
}
