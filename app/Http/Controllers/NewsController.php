<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $postnews = News::orderBy('datepublish','desc')->get();
        return view('LandingPageView.LandingPageViewNews.landingpageviewnews', compact('postnews'), ["title" => "Berita"]);
    }

    public function indexadmin()
    {
        $postnews = News::orderBy('created_at','desc')->get();
        return view('AdminPageView.AdminPageViewNews.adminpageviewnews', compact('postnews'), ["title" => "News"]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminPageView.AdminPageViewNews.adminpageviewnewscreate', ["title" => "News"]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $gambar = $request->picture;
        $new_gambar = time() . ' . ' . $gambar->getClientOriginalName();

        $postnews = News::create([
            "datepublish" => $request["datepublish"],
            "publisher" => $request["publisher"],
            "title" => $request["title"],
            "reporter" => $request["reporter"],
            "editor" => $request["editor"],
            'picture' => $new_gambar,
            "descpicture" => $request["descpicture"],
            "body" => $request["body"],
        ]);

        $gambar->move('Images/uploads/news/',$new_gambar);
        Alert::success('Success', 'News has been uploaded !');
        return redirect('/admin/news');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dt = Carbon::now();
        $postnews = News::find($id);
        return view('LandingPageView.LandingPageViewNews.landingpageviewnewsshow', compact('postnews'), ["title" => "Berita"]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $postnews = News::find($id);
        return view('AdminPageView.AdminPageViewNews.adminpageviewnewsedit', compact('postnews'), ["title" => "News"]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $gambar = $request->picture;
        $new_gambar = time() . ' . ' . $gambar->getClientOriginalName();

        $updatenews = News::where("id", $id)-> update([
            "datepublish" => $request["datepublish"],
            "publisher" => $request["publisher"],
            "title" => $request["title"],
            "reporter" => $request["reporter"],
            "editor" => $request["editor"],
            'picture' => $new_gambar,
            "descpicture" => $request["descpicture"],
            "body" => $request["body"],
        ]);

        toast('News has been edited !', 'success')->autoClose(1500)->width('400px');
        $gambar->move('Images/uploads/news/',$new_gambar);
        return redirect('/admin/news');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = News::findOrFail($id);
        $data->delete();
    }
}
