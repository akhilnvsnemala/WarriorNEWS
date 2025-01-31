<?php

namespace App\Services;

use jcobhams\NewsApi\NewsApi;

class NewsApiService
{
    protected $newsApi;

    public function __construct()
    {
        $apiKey = env('NEWS_API_KEY');
        $this->newsApi = new NewsApi($apiKey);
    }

    /**
     * Get top headlines.
     *
     * @param string|null $query
     * @param string|null $sources
     * @param string|null $country
     * @param string|null $category
     * @param int|null $pageSize
     * @param int|null $page
     * @return array
     */
    public function getTopHeadlines(
        ?string $query,
        ?string $sources = null,
        ?string $country = null,
        ?string $category = null,
        ?int $pageSize = 10,
        ?int $page = 1
    ): array {
        $response = $this->newsApi->getTopHeadlines(
            $query,
            $sources,
            $country,
            $category,
            $pageSize,
            $page
        );

        // Force convert to array
        return is_object($response) ? (array) $response : (array) json_decode(json_encode($response), true);
    }

    /**
     * Get all articles.
     */
    public function getEverything(
        ?string $query,
        ?string $sources = null,
        ?string $domains = null,
        ?string $excludeDomains = null,
        ?string $from = null,
        ?string $to = null,
        ?string $language = 'en',
        ?string $sortBy = 'publishedAt',
        ?int $pageSize = 10,
        ?int $page = 1
    ): array {
        $response = $this->newsApi->getEverything(
            $query,
            $sources,
            $domains,
            $excludeDomains,
            $from,
            $to,
            $language,
            $sortBy,
            $pageSize,
            $page
        );

        // Force convert to array
        return is_object($response) ? (array) $response : (array) json_decode(json_encode($response), true);
    }

    /**
     * Get available sources.
     */
    public function getSources(
        ?string $category = null,
        ?string $language = 'en',
        ?string $country = null
    ): array {
        $response = $this->newsApi->getSources($category, $language, $country);

        // Force convert to array
        return is_object($response) ? (array) $response : (array) json_decode(json_encode($response), true);
    }
}
