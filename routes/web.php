<?php
/**
 * This file contains all the routes for the project
 */

use App\Http\Controllers\UrlController;
use App\Services\UrlService;
use Pecee\SimpleRouter\SimpleRouter;

SimpleRouter::get('/', [UrlController::class, 'show']);

foreach ((new UrlService())->all() as $url) {
    SimpleRouter::redirect($url->getShortUrl(), $url->getUrl());
}

SimpleRouter::error(function() {
    return response()->httpCode(404);
});
