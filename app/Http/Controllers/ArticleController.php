<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use App\Services\GoogleDrive;

class ArticleController extends Controller
{
    public $pathArticleGDrive = '1dSj_B3bkhbCM1S4CuZtO4-6Hq00sHdpD';

    public function index(Request $request)
    {
        $query = Article::query()->orderBy('dateevent', 'desc');

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

        $themes = Article::select('theme')->distinct()->orderBy('theme')->pluck('theme');
        $writers = Article::select('writer')->distinct()->orderBy('writer')->pluck('writer');
        $editors = Article::select('editor')->distinct()->orderBy('editor')->pluck('editor');
        $years = Article::selectRaw('YEAR(created_at) as year')->distinct()->orderByDesc('year')->pluck('year');

        return view('landing-page.article.index', compact('postarticle', 'themes', 'writers', 'editors', 'years'), [
            "title" => "Artikel"
        ]);
    }


    public function indexadmin()
    {
        $postarticle = Article::orderBy('created_at','desc')->get();
        return view('admin-page.article.index', compact('postarticle'), ["title" => "Article"]);
    }

    public function create()
    {
        return view('admin-page.article.create', ["title" => "Article"]);
    }

    public function store(Request $request)
    {
        $gdriveService = new GoogleDrive($this->pathArticleGDrive);

        $fileName = time() . '_article_' . $request->file('poster')->getClientOriginalName();
        $filePath = $this->pathArticleGDrive . '/' . $fileName;

        $uploadResult = $gdriveService->uploadImage($request->file('poster'), $fileName, $filePath);

        Article::create([
            "title" => $request["title"],
            "theme" => $request["theme"],
            "dateevent" => $request["datearticle"],
            "writer" => $request["writer"],
            "editor" => $request["editor"],
            'poster' => $uploadResult['fileName'],
            'gdrive_id' => $uploadResult['gdriveID'],
            "embedpdf" => $request["embedpdf"],
        ]);

        Alert::success('Success', 'Article has been uploaded !');
        return redirect('/admin/article');
    }

    public function show($id)
    {
        $dt = Carbon::now();
        $postarticle = Article::find($id);
        $relatedArticles = Article::where('id', '!=', $postarticle->id)
            ->latest()
            ->take(5)
            ->get();
        return view('landing-page.article.detail',  compact('postarticle', 'relatedArticles'),["title" => "Artikel"]);
    }

    public function edit($id)
    {
        $postarticle = Article::find($id);
        return view('admin-page.article.update', compact('postarticle'), ["title" => "Article"]);
    }

    public function showInAdmin($id)
    {
        $postarticle = Article::find($id);
        return view('admin-page.article.view', compact('postarticle'), ["title" => "Article"]);
    }

    public function update(Request $request, $id)
    {
        $articleModel = Article::find($id);

        if ($request->file('poster')) {
            $gdriveService = new GoogleDrive($this->pathArticleGDrive);

            $fileName = time() . '_article_' . $request->file('poster')->getClientOriginalName();
            $filePath = $this->pathArticleGDrive . '/' . $fileName;

            $uploadResult = $gdriveService->uploadImage($request->file('poster'), $fileName, $filePath);

            $oldGdriveID = $articleModel->gdrive_id;

            if ($oldGdriveID) {
                $gdriveService->deleteImage($oldGdriveID);
            }

            $articleModel->update([
                'poster' => $uploadResult['fileName'],
                'gdrive_id' => $uploadResult['gdriveID'],
            ]);
        }

        $articleModel->update([
            "title" => $request["title"],
            "theme" => $request["theme"],
            "dateevent" => $request["datearticle"],
            "writer" => $request["writer"],
            "editor" => $request["editor"],
            "embedpdf" => $request["embedpdf"],
        ]);

        toast('Article has been edited !', 'success')->autoClose(1500)->width('400px');
        return redirect('/admin/article');
    }

    public function destroy($id)
    {
        $articleModel = Article::find($id);
        $gdriveService = new GoogleDrive($this->pathArticleGDrive);

        if ($articleModel->gdrive_id) {
            $gdriveService->deleteImage($articleModel->gdrive_id);
        }

        $articleModel->delete();
        return redirect()->back();
    }
}
