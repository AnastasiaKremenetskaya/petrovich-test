<?php

namespace App\Models;

class Url
{
    private $id;
    private $url;
    private $shortUrl;

    public function __construct(array $data = null)
    {
        $this->id = $data['id'] ?? null;
        $this->url = $data['url'] ?? null;
        $this->shortUrl = $data['short_url'] ?? null;
    }

    /**
     * @return int
     */
    public function getId() : ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUrl() : ?string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getShortUrl() : ?string
    {
        return $this->shortUrl;
    }
}
