<?php

namespace App\Http\Controllers;

use App\Models\ITSupport;
use App\Services\GoogleDrive;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ITSupportController extends Controller
{
    public $pathITSupportGDrive = '1gE3j9fXZIicfqeFqTYuc5JFpJe-FbSBs';

    public function index()
    {
        $postitsupport = ITSupport::orderBy('created_at','desc')->get();
        return view('landing-page.it-support.index', compact('postitsupport'),["title" => "Tentang Kami"]);
    }

    public function indexadmin()
    {
        $postitsupport = ITSupport::orderBy('created_at','desc')->get();
        return view('admin-page.about.it-support.index', compact('postitsupport'),["title" => "About Us"]);
    }

    public function create()
    {
        return view('admin-page.about.it-support.create', ["title" => "About Us"]);
    }

    public function store(Request $request)
    {
        $gdriveService = new GoogleDrive($this->pathITSupportGDrive);

        $fileName = time() . '_it-supports_' . $request->file('photoProfile')->getClientOriginalName();
        $filePath = $this->pathITSupportGDrive . '/' . $fileName;

        $uploadResult = $gdriveService->uploadImage($request->file('photoProfile'), $fileName, $filePath);

        ITSupport::create([
            "name" => $request["name"],
            "forkat" => $request["forkat"],
            "position" => $request["position"],
            "linkInstagram" => $request["linkInstagram"],
            "linkLinkedin" => $request["linkLinkedin"],
            'gdrive_id' => $uploadResult['gdriveID'],
            'photoProfile' => $uploadResult['fileName'],
        ]);

        Alert::success('Success', 'IT Support has been uploaded !');
        return redirect('/admin/about/itsupport');
    }

    public function edit($id)
    {
        $postitsupport = ITSupport::find($id);
        return view('admin-page.about.it-support.update',  compact('postitsupport'),["title" => "About Us"]);
    }

    public function showInAdmin($id)
    {
        $postitsupport = ITSupport::find($id);
        return view('admin-page.about.it-support.view',  compact('postitsupport'),["title" => "About Us"]);
    }

    public function update(Request $request, $id)
    {
        $itSupportModel = ITSupport::find($id);

        if ($request->file('photoProfile')) {
            $gdriveService = new GoogleDrive($this->pathITSupportGDrive);

            $fileName = time() . '_it-supports_' . $request->file('photoProfile')->getClientOriginalName();
            $filePath = $this->pathITSupportGDrive . '/' . $fileName;

            $uploadResult = $gdriveService->uploadImage($request->file('photoProfile'), $fileName, $filePath);

            $oldGdriveID = $itSupportModel->gdrive_id;

            if ($oldGdriveID) {
                $gdriveService->deleteImage($oldGdriveID);
            }

            $itSupportModel->update([
                'photoProfile' => $uploadResult['fileName'],
                'gdrive_id' => $uploadResult['gdriveID'],
            ]);
        }

        ITSupport::where("id", $id)-> update([
            "name" => $request["name"],
            "forkat" => $request["forkat"],
            "position" => $request["position"],
            "linkInstagram" => $request["linkInstagram"],
            "linkLinkedin" => $request["linkLinkedin"],
        ]);

        toast('IT Support has been edited !', 'success')->autoClose(1500)->width('400px');
        return redirect('/admin/about/itsupport');
    }

    public function destroy($id)
    {
        $itSupportModel = ITSupport::find($id);
        $gdriveService = new GoogleDrive($this->pathITSupportGDrive);

        if ($itSupportModel->gdrive_id) {
            $gdriveService->deleteImage($itSupportModel->gdrive_id);
        }

        $itSupportModel->delete();
        return redirect()->back();
    }
}
