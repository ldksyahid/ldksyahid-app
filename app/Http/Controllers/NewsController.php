<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use RealRashid\SweetAlert\Facades\Alert;

class NewsController extends Controller
{
    /**
     * Landing page - Display news with search, filter, sort, pagination
     */
    public function index(Request $request)
    {
        $query = News::query();

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter by publisher
        if ($request->filled('publisher')) {
            $query->whereIn('publisher', (array)$request->publisher);
        }

        // Filter by reporter
        if ($request->filled('reporter')) {
            $query->whereIn('reporter', (array)$request->reporter);
        }

        // Filter by editor
        if ($request->filled('editor')) {
            $query->whereIn('editor', (array)$request->editor);
        }

        // Filter by year (from datepublish)
        if ($request->filled('year')) {
            $years = (array)$request->year;
            $query->where(function ($q) use ($years) {
                foreach ($years as $y) {
                    $q->orWhereYear('datepublish', (int)$y);
                }
            });
        }

        // Sort
        $sort = $request->input('sort', 'newest');
        if ($sort === 'title') {
            $query->orderBy('title', 'asc');
        } else {
            $query->orderBy('datepublish', 'desc');
        }

        $postnews = $query->paginate(9)->appends($request->query());

        if ($request->ajax()) {
            return response()->json([
                'html'  => view('landing-page.news.components._news-cards', compact('postnews'))->render(),
                'total' => $postnews->total(),
                'from'  => $postnews->firstItem(),
                'to'    => $postnews->lastItem(),
            ]);
        }

        // Filter options
        $publishers = News::select('publisher')->distinct()->orderBy('publisher')->pluck('publisher');
        $reporters  = News::select('reporter')->distinct()->orderBy('reporter')->pluck('reporter');
        $editors    = News::select('editor')->distinct()->orderBy('editor')->pluck('editor');
        $years      = News::selectRaw('YEAR(datepublish) as year')
                         ->distinct()
                         ->orderByRaw('year DESC')
                         ->pluck('year');

        return view('landing-page.news.index', compact(
            'postnews', 'publishers', 'reporters', 'editors', 'years'
        ))->with('title', 'Berita');
    }

    /**
     * Landing page - Show single news detail with related news
     */
    public function show($id)
    {
        $postnews    = News::findOrFail($id);
        $relatedNews = News::where('id', '!=', $id)
                           ->orderBy('datepublish', 'desc')
                           ->limit(4)
                           ->get();

        return view('landing-page.news.detail', compact('postnews', 'relatedNews'))
                   ->with('title', $postnews->title);
    }

    /**
     * Admin - Display news list with AJAX support
     */
    public function indexAdmin(Request $request)
    {
        $items = News::searchAdminNews($request);
        $tableConfig = News::getTableConfig();

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

        $publisherOptions = News::select('publisher')->distinct()->orderBy('publisher')->pluck('publisher', 'publisher')->toArray();
        $reporterOptions = News::select('reporter')->distinct()->orderBy('reporter')->pluck('reporter', 'reporter')->toArray();
        $editorOptions = News::select('editor')->distinct()->orderBy('editor')->pluck('editor', 'editor')->toArray();

        return view('admin-page.news.index', compact('items', 'tableConfig', 'publisherOptions', 'reporterOptions', 'editorOptions'))
            ->with('title', 'News');
    }

    /**
     * Admin - Show create form
     */
    public function create()
    {
        return view('admin-page.news.create', ["title" => "News"]);
    }

    /**
     * Admin - Store new news
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'datepublish' => 'required|date',
            'publisher' => 'required|string|max:255',
            'reporter' => 'required|string|max:255',
            'editor' => 'required|string|max:255',
            'picture' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'descpicture' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        try {
            News::saveModel($request);
            Alert::success('Success', 'News has been created!');
            return redirect()->route('admin.news.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to create news: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Admin - Show edit form
     */
    public function edit($id)
    {
        $news = News::findOrFail($id);
        return view('admin-page.news.update', compact('news'), ["title" => "News"]);
    }

    /**
     * Admin - Show news detail (view mode)
     */
    public function showAdmin($id)
    {
        $news = News::findOrFail($id);
        return view('admin-page.news.view', compact('news'), ["title" => "News"]);
    }

    /**
     * Admin - Update news
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'datepublish' => 'required|date',
            'publisher' => 'required|string|max:255',
            'reporter' => 'required|string|max:255',
            'editor' => 'required|string|max:255',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'descpicture' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        try {
            $news = News::findOrFail($id);
            $news->updateModel($request);
            Alert::success('Success', 'News has been updated!');
            return redirect()->route('admin.news.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to update news: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Admin - Delete news
     */
    public function destroy($id)
    {
        try {
            $news = News::findOrFail($id);
            $news->deleteModel();

            return response()->json([
                'success' => true,
                'message' => 'News has been deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete news: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Admin - Bulk delete news
     */
    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);

            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No news selected for deletion'
                ], 400);
            }

            $deleted = News::bulkDeleteModel($ids);

            return response()->json([
                'success' => true,
                'message' => "{$deleted} news have been deleted!"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting news: ' . $e->getMessage()
            ], 500);
        }
    }
}
