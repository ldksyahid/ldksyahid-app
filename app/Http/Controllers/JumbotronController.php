<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jumbotron;
use RealRashid\SweetAlert\Facades\Alert;


class JumbotronController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $postjumbotron= Jumbotron::orderBy('created_at','desc')->get();
        return view('AdminPageView.AdminPageViewHome.AdminPageViewJumbotron.adminpageviewjumbotron', compact('postjumbotron'), ["title" => "Home"]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminPageView.AdminPageViewHome.AdminPageViewJumbotron.adminpageviewjumbotroncreate', ["title" => "Home"]);
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

        $postjumbotron = Jumbotron::create([
            "title" => $request["title"],
            "subtitle" => $request["subtitle"],
            "sentence" => $request["sentence"],
            "btnname" => $request["buttonname"],
            "btnlink" => $request["buttonlink"],
            'picture' => $new_gambar,
            "textalign" => $request["textalign"],
        ]);

        $gambar->move('Images/uploads/jumbotrons/',$new_gambar);
        Alert::success('Success', 'Jumbotron has been uploaded !');
        return redirect('/admin/jumbotron');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $postjumbotron = Jumbotron::find($id);
        return view('AdminPageView.AdminPageViewHome.AdminPageViewJumbotron.adminpageviewjumbotronpreview', compact('postjumbotron'), ["title" => "Home"]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $postjumbotron = Jumbotron::find($id);
        return view('AdminPageView.AdminPageViewHome.AdminPageViewJumbotron.adminpageviewjumbotronedit', compact('postjumbotron'), ["title" => "Home"]);
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

        $update = Jumbotron::where("id", $id)-> update([
            "title" => $request["title"],
            "subtitle" => $request["subtitle"],
            "sentence" => $request["sentence"],
            "btnname" => $request["buttonname"],
            "btnlink" => $request["buttonlink"],
            'picture' => $new_gambar,
            "textalign" => $request["textalign"],
        ]);

        toast('Jumbotron has been edited !', 'success')->autoClose(1500)->width('400px');
        $gambar->move('images/uploads/jumbotrons/',$new_gambar);
        return redirect('/admin/jumbotron');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Jumbotron::destroy($id);
        // toast('Jumbotron has been deleted !', 'success')->autoClose(1500)->width('400px');
        // return redirect('/admin/jumbotron');
        $data = Jumbotron::findOrFail($id);
        $data->delete();
        // return redirect('/admin/jumbotron');
    }
}
