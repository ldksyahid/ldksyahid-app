<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimony;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;

class TestimonyController extends Controller
{

    public function index()
    {
        $posttestimony= Testimony::orderBy('created_at','desc')->get();
        return view('admin-page.home.testimony.index', compact('posttestimony'), ["title" => "Home"]);
    }

    public function create()
    {
        return view('admin-page.home.testimony.create', ["title" => "Home"]);
    }

    public function store(Request $request)
    {
        $filename = time().$request->file('picture')->getClientOriginalName();
        $path = $request->file('picture')->storeAs('Images/uploads/testimonies',$filename);
        $posttestimony = Testimony::create([
            "name" => $request["name"],
            "profession" => $request["profession"],
            "testimony" => $request["testimony"],
            'picture' => $path,
        ]);

        Alert::success('Success', 'Testimony has been uploaded !');
        return redirect('/admin/testimony');
    }

    public function edit($id)
    {
        $posttestimony = Testimony::find($id);
        return view('admin-page.home.testimony.update', compact('posttestimony'), ["title" => "Home"]);
    }

    public function show($id)
    {
        $posttestimony = Testimony::find($id);
        return view('admin-page.home.testimony.view', compact('posttestimony'), ["title" => "Home"]);
    }

    public function update(Request $request, $id)
    {
        if ($request->file('picture')) {
            $filename = time().$request->file('picture')->getClientOriginalName();
            $path = $request->file('picture')->storeAs('Images/uploads/testimonies',$filename);

            // hapus file
            $gambar = Testimony::where('id',$id)->first();
            File::delete($gambar->picture);

            // upload file
            $update = Testimony::where("id", $id)-> update([
                'picture' => $path,
            ]);
        }

        $update = Testimony::where("id", $id)-> update([
            "name" => $request["name"],
            "profession" => $request["profession"],
            "testimony" => $request["testimony"],
        ]);

        toast('Testimony has been edited !', 'success')->autoClose(1500)->width('400px');
        return redirect('/admin/testimony');
    }

    public function destroy($id)
    {
        // hapus file
        $gambar = Testimony::where('id',$id)->first();
        File::delete($gambar->picture);

        // hapus data
        Testimony::where('id',$id)->delete();
        return redirect()->back();
    }
}
