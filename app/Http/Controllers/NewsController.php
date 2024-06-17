<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use App\Services\GoogleDrive;

class NewsController extends Controller
{
    public $pathNewsGDrive = '1GyqmtdKal2IxSxAryjfO3CZKfYk6NUB8';

    public function index()
    {
        $postnews = News::orderBy('datepublish','desc')->get();
        return view('landing-page.news.index', compact('postnews'), ["title" => "Berita"]);
    }

    public function indexadmin()
    {
        $postnews = News::orderBy('created_at','desc')->get();
        return view('admin-page.news.index', compact('postnews'), ["title" => "News"]);
    }

    public function create()
    {
        return view('admin-page.news.create', ["title" => "News"]);
    }

    public function store(Request $request)
    {
        $gdriveService = new GoogleDrive($this->pathNewsGDrive);

        $fileName = time() . '_news_' . $request->file('picture')->getClientOriginalName();
        $filePath = $this->pathNewsGDrive . '/' . $fileName;

        $uploadResult = $gdriveService->uploadImage($request->file('picture'), $fileName, $filePath);


        News::create([
            "datepublish" => $request["datepublish"],
            "publisher" => $request["publisher"],
            "title" => $request["title"],
            "reporter" => $request["reporter"],
            "editor" => $request["editor"],
            'picture' => $uploadResult['fileName'],
            'gdrive_id' => $uploadResult['gdriveID'],
            "descpicture" => $request["descpicture"],
            "body" => $request["body"],
        ]);

        Alert::success('Success', 'News has been uploaded !');
        return redirect('/admin/news');
    }

    public function show($id)
    {
        $dt = Carbon::now();
        $postnews = News::find($id);

        return view('landing-page.news.detail', compact('postnews'), ["title" => "Berita"]);
    }

    public function edit($id)
    {
        $postnews = News::find($id);
        return view('admin-page.news.update', compact('postnews'), ["title" => "News"]);
    }

    public function showInAdmin($id)
    {
        $postnews = News::find($id);
        return view('admin-page.news.view', compact('postnews'), ["title" => "News"]);
    }

    public function update(Request $request, $id)
    {
        $newsModel = News::find($id);

        if ($request->file('picture')) {
            $gdriveService = new GoogleDrive($this->pathNewsGDrive);

            $fileName = time() . '_news_' . $request->file('picture')->getClientOriginalName();
            $filePath = $this->pathNewsGDrive . '/' . $fileName;

            $uploadResult = $gdriveService->uploadImage($request->file('picture'), $fileName, $filePath);

            $oldGdriveID = $newsModel->gdrive_id;

            if ($oldGdriveID) {
                $gdriveService->deleteImage($oldGdriveID);
            }

            $newsModel->update([
                'picture' => $uploadResult['fileName'],
                'gdrive_id' => $uploadResult['gdriveID'],
            ]);
        }

        $newsModel->update([
            "datepublish" => $request["datepublish"],
            "publisher" => $request["publisher"],
            "title" => $request["title"],
            "reporter" => $request["reporter"],
            "editor" => $request["editor"],
            "descpicture" => $request["descpicture"],
            "body" => $request["body"],
        ]);

        toast('News has been edited !', 'success')->autoClose(1500)->width('400px');
        return redirect('/admin/news');
    }

    public function destroy($id)
    {
        $newsModel = News::find($id);
        $gdriveService = new GoogleDrive($this->pathNewsGDrive);

        if ($newsModel->gdrive_id) {
            $gdriveService->deleteImage($newsModel->gdrive_id);
        }

        $newsModel->delete();
        return redirect()->back();
    }
}
