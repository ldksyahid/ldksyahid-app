<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

        if (!empty($request->file('profilepicture'))) {
            $gdriveService = new GoogleDrive($this->pathProfileGDrive);

            $fileName = time() . '_profile_' . $request->file('profilepicture')->getClientOriginalName();
            $filePath = $this->pathProfileGDrive . '/' . $fileName;

            $uploadResult = $gdriveService->uploadImage($request->file('profilepicture'), $fileName, $filePath);

            $oldGdriveId = $profileModel->gdrive_id;

            if ($oldGdriveId) {
                try {
                    $gdriveService->deleteImage($oldGdriveId);
                } catch (\Exception $e) {
                    Log::error('[ProfileController] update GDrive delete failed: ' . $e->getMessage(), [
                        'profile_id' => $id,
                        'gdrive_id'  => $oldGdriveId,
                    ]);
                }
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
        $profileModel = Profile::where('user_id', $id)->first();

        if ($profileModel->gdrive_id) {
            try {
                $gdriveService = new GoogleDrive($this->pathProfileGDrive);
                $gdriveService->deleteImage($profileModel->gdrive_id);
            } catch (\Exception $e) {
                Log::error('[ProfileController] destroy GDrive delete failed: ' . $e->getMessage(), [
                    'profile_id' => $id,
                    'gdrive_id'  => $profileModel->gdrive_id,
                ]);
            }
        }

        $profileModel->where('user_id', $id)->update([
            'profilepicture' => null,
            'gdrive_id'      => null,
        ]);

        return redirect()->back();
    }
}
