<?php

namespace App\Services;

use App\Exceptions\Gateway\RecordNotFoundException;
use App\Exceptions\InternalServerException;
use App\Gateways\UrlGateway;
use App\Models\Url;

class UrlService
{
    /**
     * @var UrlGateway
     */
    private UrlGateway $urlGateway;

    public function __construct()
    {
        $this->urlGateway = new UrlGateway();
    }

    /**
     * Get all urls for redirecting
     *
     * @return Url[]
     */
    public function all(): array
    {
        try {
            return $this->urlGateway->all();
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Get short url
     *
     * @param string $url
     * @return Url
     * @throws InternalServerException
     */
    public function getShortUrl(string $url): Url
    {
        try {
            return $this->urlGateway->getByUrl($url);
        } catch (RecordNotFoundException $e) {
            $shortUrl = $this->generateShortUrl($url);

            return $this->urlGateway->create([
                                          'url' => $url,
                                          'short_url' => $shortUrl,
                                      ]);
        }
    }

    private function generateShortUrl(string $url): string
    {
        return hash("crc32", $url . time());
    }
}