<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class ArticleController extends Controller
{
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
        $filename = time().$request->file('poster')->getClientOriginalName();
        $path = $request->file('poster')->storeAs('Images/uploads/articlesposter',$filename);

        $postarticle = Article::create([
            "title" => $request["title"],
            "theme" => $request["theme"],
            "dateevent" => $request["datearticle"],
            "writer" => $request["writer"],
            "editor" => $request["editor"],
            'poster' => $path,
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

    public function update(Request $request, $id)
    {
        if ($request->file('poster')) {
            $filename = time().$request->file('poster')->getClientOriginalName();
            $path = $request->file('poster')->storeAs('Images/uploads/articlesposter',$filename);

            // hapus file
            $gambar = Article::where('id',$id)->first();
            File::delete($gambar->poster);

            // upload file
            $update = Article::where("id", $id)-> update([
                'poster' => $path,
            ]);
        }

        $update = Article::where("id", $id)-> update([
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
        // hapus file
        $gambar = Article::where('id',$id)->first();
        File::delete($gambar->poster);

        // hapus data
        Article::where('id',$id)->delete();
        return redirect()->back();
    }
}
