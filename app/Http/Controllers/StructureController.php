<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Structure;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;

class StructureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $poststructure = Structure::orderBy('created_at','desc')->get();
        return view('LandingPageView.LandingPageViewTentang.landingpageviewtentangstrukturpengurus', compact('poststructure'),["title" => "Tentang Kami"]);
    }

    public function indexadmin()
    {
        $poststructure = Structure::orderBy('created_at','desc')->get();
        return view('AdminPageView.AdminPageViewAboutUs.AdminPageViewAboutUsStructure.adminpageviewaboutusstructure', compact('poststructure'), ["title" => "About Us"]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminPageView.AdminPageViewAboutUs.AdminPageViewAboutUsStructure.adminpageviewaboutusstructurecreate', ["title" => "About Us"]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $poststructure = Structure::find($id);
        return view('AdminPageView.AdminPageViewAboutUs.AdminPageViewAboutUsStructure.adminpageviewaboutusstructureedit', compact('poststructure'), ["title" => "About Us"]);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
