<?php namespace App\Http\Controllers;

use App\Services\NewsApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsApiController extends Controller
{
    protected $newsApiService;

    public function __construct(NewsApiService $newsApiService)
    {
        $this->newsApiService = $newsApiService;
    }

    /**
     * Fetch top headlines.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function topHeadlines(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'query' => 'nullable|string',
            'country' => 'nullable|string|size:2', // ISO 3166-1 alpha-2 country code
            'category' => 'nullable|string',
        ]);

        $query = $validatedData['query'] ?? 'latest';
        $country = $validatedData['country'] ?? 'us';
        $category = $validatedData['category'] ?? null;

        try {
            $data = $this->newsApiService->getTopHeadlines($query, null, $country, $category);
            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Fetch all articles.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function allArticles(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'query' => 'nullable|string',
        ]);

        $query = $validatedData['query'] ?? 'latest';

        try {
            $data = $this->newsApiService->getEverything($query);
            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Fetch news sources.
     *
     * @return JsonResponse
     */
    public function sources(): JsonResponse
    {
        try {
            $data = $this->newsApiService->getSources();
            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
