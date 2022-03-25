<?php

namespace App\Http\Responses;

use App\Models\Url;

class UrlResponse
{
    /**
     * @param Url $url
     *
     * @return string
     */
    public function getSuccessResponse(Url $url): string
    {
        $baseUrl = env('APP_DOMAIN').':'.env('APP_PORT');

        return response()->json([
                                    'message' => 'OK',
                                    'code' => 200,
                                    'data' => [
                                        "short_url" => "$baseUrl/{$url->getShortUrl()}",
                                    ],
                                ]);
    }

    /**
     * @param array $errors
     *
     * @return string
     */
    public function getErrorResponse(array $errors): string
    {
        return response()->json([
                                    'message' => $errors,
                                    'code' => 400,
                                    'data' => [],
                                ]);
    }
}