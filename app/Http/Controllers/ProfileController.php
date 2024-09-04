<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use App\Services\GoogleDrive;

class ProfileController extends Controller
{
    public $pathProfileGDrive = '1iIQcU849CZSZ5sCCuguq_bhfVGCHv0pX';

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
            $gdriveService = new GoogleDrive($this->pathProfileGDrive);

            $fileName = time() . '_profile_' . $request->file('profilepicture')->getClientOriginalName();
            $filePath = $this->pathProfileGDrive . '/' . $fileName;

            $uploadResult = $gdriveService->uploadImage($request->file('profilepicture'), $fileName, $filePath);

            Profile::create([
                'profilepicture' => $uploadResult['fileName'],
                'gdrive_id' => $uploadResult['gdriveID'],
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
            Profile::create([
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
        $profileModel = Profile::find($id);

        if ($request->file('profilepicture')) {
            $gdriveService = new GoogleDrive($this->pathProfileGDrive);

            $fileName = time() . '_profile_' . $request->file('profilepicture')->getClientOriginalName();
            $filePath = $this->pathProfileGDrive . '/' . $fileName;

            $uploadResult = $gdriveService->uploadImage($request->file('profilepicture'), $fileName, $filePath);

            $oldGdriveID = $profileModel->gdrive_id;

            if ($oldGdriveID) {
                $gdriveService->deleteImage($oldGdriveID);
            }

            $profileModel->update([
                'profilepicture' => $uploadResult['fileName'],
                'gdrive_id' => $uploadResult['gdriveID'],
            ]);
        }

        $profileModel->update([
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

        $profileModel = Profile::find($id);
        $gdriveService = new GoogleDrive($this->pathProfileGDrive);

        if($profileModel->gdrive_id) {
            $gdriveService->deleteImage($profileModel->gdrive_id);
        }

        $profileModel->where("user_id", $id)->update([
            'profilepicture' => null,
        ]);

        return redirect()->back();

    }
}
