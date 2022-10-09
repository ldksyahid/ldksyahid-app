<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexprofilecheck()
    {
        $query = Profile::where('user_id', Auth::id())->first();
        if ($query == null) {
            return view('LandingPageView.LandingPageViewProfile.landingpageviewprofilecreate', ["title" => "Profilku"]);
        } else {
            $postprofile= Profile::orderBy('created_at','desc')->get();
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

        $new_gambar = null;

        if ($gambar = $request->profilepicture) {
            $new_gambar = time() . ' . ' . $gambar->getClientOriginalName();
            $gambar->move('Images/uploads/profiles/',$new_gambar);
        }
        // $gambar = $request->profilepicture;
        // $new_gambar = time() . ' . ' . $gambar->getClientOriginalName();
        // $gambar->move('Images/uploads/profiles/',$new_gambar);

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
            'profilepicture' => $new_gambar,
            "user_id" => Auth::id()
        ]);

        return redirect('/profile');
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
        $new_gambar = null;

        if ($gambar = $request->profilepicture) {
            $new_gambar = time() . ' . ' . $gambar->getClientOriginalName();
            $gambar->move('Images/uploads/profiles/',$new_gambar);
        }
        // $gambar = $request->profilepicture;
        // $new_gambar = time() . ' . ' . $gambar->getClientOriginalName();
        // $gambar->move('Images/uploads/profiles/',$new_gambar);
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
            'profilepicture' => $new_gambar,
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
    public function destroy($id)
    {
        //
    }
}
