<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexprofilecheck(Request $id)
    {
        $query = Profile::where('user_id', Auth::id())->first();
        if ($query == null) {
            return view('LandingPageView.LandingPageViewProfile.landingpageviewprofilecreate', ["title" => "Profilku"]);
        } else {
            $postprofile= Profile::find($id);
            return view('LandingPageView.LandingPageViewProfile.landingpageviewprofile', compact('postprofile'), ["title" => "Profilku"]);
        }
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ($request->file('profilepicture')) {
            $filename = time().$request->file('profilepicture')->getClientOriginalName();
            $path = $request->file('profilepicture')->storeAs('Images/uploads/profiles',$filename);

            // upload file
            $upload = Profile::create([
                'profilepicture' => $path,
                "namapanggilan" => $request["namapanggilan"],
                "sifat" => $request["sifat"],
                "tentangdiri" => $request["tentangdiri"],
                "universitas" => $request["universitas"],
                "nim" => $request["nim"],
                "fakultas" => $request["fakultas"],
                "programstudi" => $request["programstudi"],
                "forkat" => $request["forkat"],
                "nomoranggota" => $request["nomoranggota"],
                "akuninstagram" => $request["akuninstagram"],
                "akunlinkedin" => $request["akunlinkedin"],
                "mottohidup" => $request["mottohidup"],
                "user_id" => Auth::id()
            ]);
            return redirect('/profile');
        } else{
            $post = Profile::create([
                "namapanggilan" => $request["namapanggilan"],
                "sifat" => $request["sifat"],
                "tentangdiri" => $request["tentangdiri"],
                "universitas" => $request["universitas"],
                "nim" => $request["nim"],
                "fakultas" => $request["fakultas"],
                "programstudi" => $request["programstudi"],
                "forkat" => $request["forkat"],
                "nomoranggota" => $request["nomoranggota"],
                "akuninstagram" => $request["akuninstagram"],
                "akunlinkedin" => $request["akunlinkedin"],
                "mottohidup" => $request["mottohidup"],
                "user_id" => Auth::id()
            ]);

            return redirect('/profile');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('LandingPageView.LandingPageViewProfile.landingpageviewprofileedit', ["title" => "Profilku"]);
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

        if ($request->file('profilepicture')) {
            $filename = time().$request->file('profilepicture')->getClientOriginalName();
            $path = $request->file('profilepicture')->storeAs('Images/uploads/profiles',$filename);

            // hapus file
            $gambar = Profile::where('id',$id)->first();
            File::delete($gambar->profilepicture);

            // upload file
            $update = Profile::where("id", $id)-> update([
                'profilepicture' => $path,
            ]);
        }

        $update = Profile::where("id", $id)-> update([
            "namapanggilan" => $request["namapanggilan"],
            "sifat" => $request["sifat"],
            "tentangdiri" => $request["tentangdiri"],
            "universitas" => $request["universitas"],
            "nim" => $request["nim"],
            "fakultas" => $request["fakultas"],
            "programstudi" => $request["programstudi"],
            "forkat" => $request["forkat"],
            "nomoranggota" => $request["nomoranggota"],
            "akuninstagram" => $request["akuninstagram"],
            "akunlinkedin" => $request["akunlinkedin"],
            "mottohidup" => $request["mottohidup"],
            "user_id" => Auth::id()
        ]);
        return redirect('/profile');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Request $request, $id)
    {

        // hapus file
        $gambar = Profile::where('user_id',$id)->first();
        File::delete($gambar->profilepicture);

        // hapus dengan cara edit menjadi null
        $update = Profile::where("user_id", $id)-> update([
            'profilepicture' => $request->NULL,
        ]);
        return redirect()->back();

    }
}
