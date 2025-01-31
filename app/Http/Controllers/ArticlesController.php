<?php 

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::with(['category', 'source'])
            ->when($request->keyword, fn($q) => $q->where('title', 'LIKE', "%{$request->keyword}%"))
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id))
            ->when($request->source_id, fn($q) => $q->where('source_id', $request->source_id))
            ->when($request->published_at, fn($q) => $q->whereDate('published_at', $request->published_at))
            ->paginate(10);

        return response()->json($articles);
    }

    public function show($id)
    {
        $article = Article::with(['category', 'source'])->findOrFail($id);
        return response()->json($article);
    }
}
