<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimony;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;

class TestimonyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posttestimony= Testimony::orderBy('created_at','desc')->get();
        return view('AdminPageView.AdminPageViewHome.AdminPageViewTestimony.adminpageviewtestimony', compact('posttestimony'), ["title" => "Home"]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminPageView.AdminPageViewHome.AdminPageViewTestimony.adminpageviewtestimonycreate', ["title" => "Home"]);
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
        $posttestimony = Testimony::find($id);
        return view('AdminPageView.AdminPageViewHome.AdminPageViewTestimony.adminpageviewtestimonyedit', compact('posttestimony'), ["title" => "Home"]);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
