<?php

namespace App\Helpers;

trait ResponseHelpers
{
    public function sendResponse(
        string $message = '',
        array $data = [],
        int $statusCode = 200,
        $headers = []
    )
    {
        $body = [
            'message' => $message,
            'data' => $data
        ];

        return response()->json($body, $statusCode, $headers);
    }
}
