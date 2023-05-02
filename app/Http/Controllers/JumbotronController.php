<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jumbotron;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;


class JumbotronController extends Controller
{
    public function index()
    {
        $postjumbotron= Jumbotron::orderBy('created_at','desc')->get();
        return view('admin-page.home.jumbotron.index', compact('postjumbotron'), ["title" => "Home"]);
    }

    public function create()
    {
        return view('admin-page.home.jumbotron.create', ["title" => "Home"]);
    }

    public function store(Request $request)
    {
        $filename = time().$request->file('picture')->getClientOriginalName();
        $path = $request->file('picture')->storeAs('Images/uploads/jumbotrons',$filename);
        $postjumbotron = Jumbotron::create([
            "title" => "none",
            "subtitle" => "none",
            "sentence" => "none",
            "btnname" => $request["buttonname"],
            "btnlink" => $request["buttonlink"],
            'picture' => $path,
            "textalign" => "start",
        ]);

        Alert::success('Success', 'Jumbotron has been uploaded !');
        return redirect('/admin/jumbotron');
    }

    public function show($id)
    {
        $postjumbotron = Jumbotron::find($id);
        return view('admin-page.home.jumbotron.view', compact('postjumbotron'), ["title" => "Home"]);
    }

    public function edit($id)
    {
        $postjumbotron = Jumbotron::find($id);
        return view('admin-page.home.jumbotron.update', compact('postjumbotron'), ["title" => "Home"]);
    }

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
            "title" => "none",
            "subtitle" => "none",
            "sentence" => "none",
            "btnname" => $request["buttonname"],
            "btnlink" => $request["buttonlink"],
            "textalign" => "start",
        ]);

        toast('Jumbotron has been edited !', 'success')->autoClose(1500)->width('400px');
        return redirect('/admin/jumbotron');
    }

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
