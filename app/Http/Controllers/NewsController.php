<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use RealRashid\SweetAlert\Facades\Alert;

class NewsController extends Controller
{
    /**
     * Landing page - Display all news
     */
    public function index()
    {
        $postnews = News::orderBy('datepublish', 'desc')->get();
        return view('landing-page.news.index', compact('postnews'), ["title" => "Berita"]);
    }

    /**
     * Landing page - Show single news detail
     */
    public function show($id)
    {
        $postnews = News::find($id);
        return view('landing-page.news.detail', compact('postnews'), ["title" => "Berita"]);
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

        return view('admin-page.news.index', compact('items', 'tableConfig'))
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
