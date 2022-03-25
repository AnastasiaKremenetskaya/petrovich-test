<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlRequest;
use App\Http\Responses\UrlResponse;
use App\Services\UrlService;
use Exception;

class UrlController
{
    /**
     * @var UrlRequest
     */
    private UrlRequest $urlRequest;

    /**
     * @var UrlResponse
     */
    private UrlResponse $urlResponse;

    public function __construct()
    {
        $this->urlRequest = new UrlRequest();
        $this->urlResponse = new UrlResponse();
    }

    /**
     * Return short url
     *
     * @return string
     */
    public function show(): string
    {
        $validation = $this->urlRequest->validate(input()->all());

        if ($validation->fails()) {
            return $this->urlResponse->getErrorResponse($validation->errors()->all());
        } else {
            try {
                $validData = $validation->getValidData();
                $url = (new UrlService())->getShortForUrl($validData['url']);

                return $this->urlResponse->getSuccessResponse($url);
            } catch (Exception $e) {
                return $this->urlResponse->getErrorResponse([$e->getMessage()]);
            }
        }
    }
}
