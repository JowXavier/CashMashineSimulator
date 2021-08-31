<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class ApiException extends Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report($e)
    {
        Log::error($e->getMessage());
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->json(
            [
                'error' => [
                    'message' => 'Ocorreu um erro interno, estamos trabalhando para corrigir, tente novamente mais tarde'
                ]
            ]
        );
    }
}

