<?php

namespace App\Providers;

use Illuminate\Support\{ServiceProvider, Facades\Response};

class ResponseServiceProvider extends ServiceProvider
{
    function boot(): void
    {
        Response::macro('message', function (?string $message = null, ?int $response_status = 200, $data = null, ...$args) {
            $response = [
                'status' => in_array($response_status, [200, 201])
            ] + $args;

            if (!is_null($data)) {
                $response['data'] = $data;
            }

            if (!is_null($message)) {
                $response['message'] = $message;
            }

            return Response::json($response, $response_status);
        });
    }
}
