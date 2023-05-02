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
    public function indexprofilecheck(Request $id)
    {
        $query = Profile::where('user_id', Auth::id())->first();
        if ($query == null) {
            return view('landing-page.profile.create', ["title" => "Profilku"]);
        } else {
            $postprofile= Profile::find($id);
            return view('landing-page.profile.index', compact('postprofile'), ["title" => "Profilku"]);
        }
    }

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

    public function edit($id)
    {
        return view('landing-page.profile.update', ["title" => "Profilku"]);
    }

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
