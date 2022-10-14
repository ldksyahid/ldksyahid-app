<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jumbotron;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;


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
        $filename = time().$request->file('picture')->getClientOriginalName();
        $path = $request->file('picture')->storeAs('Images/uploads/jumbotrons',$filename);
        $postjumbotron = Jumbotron::create([
            "title" => $request["title"],
            "subtitle" => $request["subtitle"],
            "sentence" => $request["sentence"],
            "btnname" => $request["buttonname"],
            "btnlink" => $request["buttonlink"],
            'picture' => $path,
            "textalign" => $request["textalign"],
        ]);

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
        if ($request->file('picture')) {
            $filename = time().$request->file('picture')->getClientOriginalName();
            $path = $request->file('picture')->storeAs('Images/uploads/jumbotrons',$filename);

            // hapus file
            $gambar = Jumbotron::where('id',$id)->first();
            File::delete($gambar->picture);

            // upload file
            $update = Jumbotron::where("id", $id)-> update([
                'picture' => $path,
            ]);
        }

        $update = Jumbotron::where("id", $id)-> update([
            "title" => $request["title"],
            "subtitle" => $request["subtitle"],
            "sentence" => $request["sentence"],
            "btnname" => $request["buttonname"],
            "btnlink" => $request["buttonlink"],
            "textalign" => $request["textalign"],
        ]);

        toast('Jumbotron has been edited !', 'success')->autoClose(1500)->width('400px');
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
        // hapus file
        $gambar = Jumbotron::where('id',$id)->first();
        File::delete($gambar->picture);

        // hapus data
        Jumbotron::where('id',$id)->delete();
        return redirect()->back();
    }
}
