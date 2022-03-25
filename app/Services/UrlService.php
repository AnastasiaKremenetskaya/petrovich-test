<?php

namespace App\Services;

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
    public function getShortForUrl(string $url): Url
    {
        $urlModel = $this->urlGateway->getByUrl($url);

        if ($urlModel->getId()) {
            return $urlModel;
        } else {
            do {
                $shortUrl = $this->generateShortUrl($url);
            } while (!$this->isShortUrlUnique($shortUrl));

            return $this->urlGateway->create([
                                                 'url' => $url,
                                                 'short_url' => $shortUrl,
                                             ]);
        }
    }

    /**
     * @param string $url
     * @return string
     */
    private function generateShortUrl(string $url): string
    {
        return hash("crc32", $url . time());
    }

    /**
     * @param string $shortUrl
     * @return string
     * @throws InternalServerException
     */
    private function isShortUrlUnique(string $shortUrl): string
    {
        $urlModel = $this->urlGateway->getByShortUrl($shortUrl);

        return empty($urlModel->getId());
    }
}