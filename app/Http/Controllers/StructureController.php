<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Structure;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;

class StructureController extends Controller
{
    public function index()
    {
        $poststructure = Structure::orderBy('created_at','desc')->get();
        return view('landing-page.about.management-structur', compact('poststructure'),["title" => "Tentang Kami"]);
    }

    public function indexadmin()
    {
        $poststructure = Structure::orderBy('created_at','desc')->get();
        return view('admin-page.about.management-structure.index', compact('poststructure'), ["title" => "About Us"]);
    }

    public function create()
    {
        return view('admin-page.about.management-structure.create', ["title" => "About Us"]);
    }

    public function store(Request $request)
    {
        $filenameLogo = time().$request->file('structureLogo')->getClientOriginalName();
        $pathLogo = $request->file('structureLogo')->storeAs('Images/uploads/structure/logostructure',$filenameLogo);

        $filenameImage = time().$request->file('structureImage')->getClientOriginalName();
        $pathImage = $request->file('structureImage')->storeAs('Images/uploads/structure/imagestructure',$filenameImage);

        $poststructure = Structure::create([
            "batch" => $request["batch"],
            "period" => $request["period"],
            "structureName" => $request["structureName"],
            "structureDescription" => $request["structureDescription"],
            'structureLogo' => $pathLogo,
            'structureImage' => $pathImage,
        ]);

        Alert::success('Success', 'Structure has been uploaded !');
        return redirect('/admin/about/structure');
    }

    public function edit($id)
    {
        $poststructure = Structure::find($id);
        return view('admin-page.about.management-structure.update', compact('poststructure'), ["title" => "About Us"]);
    }

    public function update(Request $request, $id)
    {
        if ($request->file('structureLogo')) {
            $filenameLogo = time().$request->file('structureLogo')->getClientOriginalName();
            $pathLogo = $request->file('structureLogo')->storeAs('Images/uploads/structure/logostructure',$filenameLogo);

            // hapus file
            $gambar = Structure::where('id',$id)->first();
            File::delete($gambar->structureLogo);

            // upload file
            $update = Structure::where("id", $id)-> update([
                'structureLogo' => $pathLogo,
            ]);
        }

        if ($request->file('structureImage')) {
            $filenameImage = time().$request->file('structureImage')->getClientOriginalName();
            $pathImage = $request->file('structureImage')->storeAs('Images/uploads/structure/imagestructure',$filenameImage);

            // hapus file
            $gambar = Structure::where('id',$id)->first();
            File::delete($gambar->structureImage);

            // upload file
            $update = Structure::where("id", $id)-> update([
                'structureImage' =>  $pathImage,
            ]);
        }

        $updatestructure = Structure::where("id", $id)-> update([
            "batch" => $request["batch"],
            "period" => $request["period"],
            "structureName" => $request["structureName"],
            "structureDescription" => $request["structureDescription"],
        ]);

        toast('Structure has been edited !', 'success')->autoClose(1500)->width('400px');
        return redirect('/admin/about/structure');
    }

    public function destroy($id)
    {
        // hapus file
        $gambar = Structure::where('id',$id)->first();
        File::delete($gambar->structureImage);
        File::delete($gambar->structureLogo);

        // hapus data
        Structure::where('id',$id)->delete();
        return redirect()->back();
    }
}
