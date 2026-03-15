<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class ArticleController extends Controller
{
    /**
     * Display a listing of articles (Landing Page)
     */
    public function index(Request $request)
    {
        // Sort order
        $sortParam = $request->get('sort', 'newest');
        $query = Article::query();
        if ($sortParam === 'title') {
            $query->orderBy('title', 'asc');
        } else {
            $query->orderBy('dateevent', 'desc');
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('theme', 'like', "%{$search}%")
                ->orWhere('writer', 'like', "%{$search}%")
                ->orWhere('editor', 'like', "%{$search}%")
                ->orWhereYear('created_at', $search);
            });
        }

        if ($request->filled('theme')) {
            $themes = (array) $request->theme;
            $query->whereIn('theme', $themes);
        }

        if ($request->filled('writer')) {
            $writers = (array) $request->writer;
            $query->whereIn('writer', $writers);
        }

        if ($request->filled('editor')) {
            $editors = (array) $request->editor;
            $query->whereIn('editor', $editors);
        }

        if ($request->filled('created_year')) {
            $years = (array) $request->created_year;
            $query->whereRaw('YEAR(created_at) IN (' . implode(',', array_map('intval', $years)) . ')');
        }

        $postarticle = $query->paginate(9)->withQueryString();

        $themes  = Article::select('theme')->distinct()->orderBy('theme')->pluck('theme');
        $writers = Article::select('writer')->distinct()->orderBy('writer')->pluck('writer');
        $editors = Article::select('editor')->distinct()->orderBy('editor')->pluck('editor');
        $years   = Article::selectRaw('YEAR(created_at) as year')->distinct()->orderByDesc('year')->pluck('year');

        // AJAX request — return JSON with rendered cards partial
        if ($request->ajax()) {
            return response()->json([
                'html'  => view('landing-page.article.components._article-cards',
                                compact('postarticle'))->render(),
                'total' => $postarticle->total(),
                'from'  => (int) $postarticle->firstItem(),
                'to'    => (int) $postarticle->lastItem(),
            ]);
        }

        return view('landing-page.article.index', compact('postarticle', 'themes', 'writers', 'editors', 'years'), [
            "title" => "Artikel"
        ]);
    }

    /**
     * Display the specified article (Landing Page)
     */
    public function show($article)
    {
        $postarticle = is_numeric($article)
            ? Article::findOrFail($article)
            : Article::where('slug', $article)->firstOrFail();

        $relatedArticles = Article::where('id', '!=', $postarticle->id)
            ->latest()
            ->take(5)
            ->get();
        return view('landing-page.article.detail', compact('postarticle', 'relatedArticles'), ["title" => "Artikel"]);
    }

    /**
     * Display a listing of articles (Admin Index)
     */
    public function indexAdmin(Request $request)
    {
        $items = Article::searchAdminArticles($request);
        $tableConfig = Article::getTableConfig();

        if ($request->ajax()) {
            return response()->json([
                'tableBody' => view('components.admin-index.index-table', [
                    'items' => $items,
                    'tableConfig' => $tableConfig,
                ])->render(),
                'pagination' => $items->appends($request->query())->links()->render(),
                'total' => $items->total(),
                'from' => $items->firstItem(),
                'to' => $items->lastItem()
            ]);
        }

        $themeOptions = Article::select('theme')->distinct()->orderBy('theme')->pluck('theme', 'theme')->toArray();
        $writerOptions = Article::select('writer')->distinct()->orderBy('writer')->pluck('writer', 'writer')->toArray();
        $editorOptions = Article::select('editor')->distinct()->orderBy('editor')->pluck('editor', 'editor')->toArray();

        return view('admin-page.article.index', compact('items', 'tableConfig', 'themeOptions', 'writerOptions', 'editorOptions'))
            ->with('title', 'Article');
    }

    /**
     * Show the form for creating a new article
     */
    public function create()
    {
        return view('admin-page.article.create')
            ->with('title', 'Article');
    }

    /**
     * Store a newly created article
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'theme' => 'required|string|max:255',
            'datearticle' => 'required|date',
            'writer' => 'required|string|max:255',
            'editor' => 'required|string|max:255',
            'poster' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'embedpdf' => 'required|url',
        ]);

        try {
            Article::saveModel($request);
            Alert::success('Success', 'Article has been created!');
            return redirect()->route('admin.article.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to create article: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified article (Admin Preview)
     */
    public function showAdmin($id)
    {
        $article = Article::findOrFail($id);

        return view('admin-page.article.view', compact('article'))
            ->with('title', 'Article');
    }

    /**
     * Show the form for editing the specified article
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);

        return view('admin-page.article.update', compact('article'))
            ->with('title', 'Article');
    }

    /**
     * Update the specified article
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'theme' => 'required|string|max:255',
            'datearticle' => 'required|date',
            'writer' => 'required|string|max:255',
            'editor' => 'required|string|max:255',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'embedpdf' => 'required|url',
        ]);

        try {
            $article = Article::findOrFail($id);
            $article->updateModel($request);
            Alert::success('Success', 'Article has been updated!');
            return redirect()->route('admin.article.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to update article: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified article
     */
    public function destroy($id)
    {
        try {
            $article = Article::findOrFail($id);
            $article->deleteModel();

            return response()->json([
                'success' => true,
                'message' => 'Article has been deleted!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting article: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk delete articles
     */
    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);

            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No articles selected for deletion'
                ], 400);
            }

            $deleted = Article::bulkDeleteModel($ids);

            return response()->json([
                'success' => true,
                'message' => "{$deleted} article(s) have been deleted!"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting articles: ' . $e->getMessage()
            ], 500);
        }
    }
}
