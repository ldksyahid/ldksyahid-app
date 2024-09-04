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

    public function index()
    {
        $postarticle = Article::orderBy('dateevent','desc')->get();
        return view('landing-page.article.index', compact('postarticle'),["title" => "Artikel"]);
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
        return view('landing-page.article.detail',  compact('postarticle'),["title" => "Artikel"]);
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
