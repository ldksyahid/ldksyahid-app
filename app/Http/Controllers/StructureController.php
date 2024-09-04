<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Structure;
use RealRashid\SweetAlert\Facades\Alert;
use App\Services\GoogleDrive;

class StructureController extends Controller
{
    public $pathStructureGDrive = '1q4xH2GI8i7nd4LJoW97zP4CNWYa8RjZr';

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
        $gdriveService = new GoogleDrive($this->pathStructureGDrive);

        $fileNameLogo = time() . '_structure-logo_' . $request->file('structureLogo')->getClientOriginalName();
        $filePathLogo = $this->pathStructureGDrive . '/' . $fileNameLogo;
        $uploadResultLogo = $gdriveService->uploadImage($request->file('structureLogo'), $fileNameLogo, $filePathLogo);

        $fileNameImage = time() . '_structure-image_' . $request->file('structureImage')->getClientOriginalName();
        $filePathImage = $this->pathStructureGDrive . '/' . $fileNameImage;
        $uploadResultImage = $gdriveService->uploadImage($request->file('structureImage'), $fileNameImage, $filePathImage);

        Structure::create([
            "batch" => $request["batch"],
            "period" => $request["period"],
            "structureName" => $request["structureName"],
            "structureDescription" => $request["structureDescription"],
            'structureLogo' => $uploadResultLogo['fileName'],
            'gdrive_id' => $uploadResultLogo['gdriveID'],
            'structureImage' => $uploadResultImage['fileName'],
            'gdrive_id_2' => $uploadResultImage['gdriveID'],
        ]);

        Alert::success('Success', 'Structure has been uploaded !');
        return redirect('/admin/about/structure');
    }

    public function edit($id)
    {
        $poststructure = Structure::find($id);
        return view('admin-page.about.management-structure.update', compact('poststructure'), ["title" => "About Us"]);
    }

    public function showInAdmin($id)
    {
        $poststructure = Structure::find($id);
        return view('admin-page.about.management-structure.view', compact('poststructure'), ["title" => "About Us"]);
    }

    public function update(Request $request, $id)
    {
        $structureModel = Structure::find($id);

        if ($request->file('structureLogo')) {
            $gdriveService = new GoogleDrive($this->pathStructureGDrive);

            $fileNameLogo = time() . '_structure-logo_' . $request->file('structureLogo')->getClientOriginalName();
            $filePathLogo = $this->pathStructureGDrive . '/' . $fileNameLogo;

            $uploadResultLogo = $gdriveService->uploadImage($request->file('structureLogo'), $fileNameLogo, $filePathLogo);

            $oldGdriveID = $structureModel->gdrive_id;

            if ($oldGdriveID) {
                $gdriveService->deleteImage($oldGdriveID);
            }

            $structureModel->update([
                'structureLogo' => $uploadResultLogo['fileName'],
                'gdrive_id' => $uploadResultLogo['gdriveID'],
            ]);
        }

        if ($request->file('structureImage')) {
            $gdriveService = new GoogleDrive($this->pathStructureGDrive);

            $fileNameImage = time() . '_structure-image_' . $request->file('structureImage')->getClientOriginalName();
            $filePathImage = $this->pathStructureGDrive . '/' . $fileNameImage;

            $uploadResultImage = $gdriveService->uploadImage($request->file('structureImage'), $fileNameImage, $filePathImage);

            $oldGdriveID = $structureModel->gdrive_id_2;

            if ($oldGdriveID) {
                $gdriveService->deleteImage($oldGdriveID);
            }

            $structureModel->update([
                'structureImage' => $uploadResultImage['fileName'],
                'gdrive_id_2' => $uploadResultImage['gdriveID'],
            ]);
        }

        $structureModel->update([
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
        $structureModel = Structure::find($id);
        $gdriveService = new GoogleDrive($this->pathStructureGDrive);

        if ($structureModel->gdrive_id) {
            $gdriveService->deleteImage($structureModel->gdrive_id);
        }

        if ($structureModel->gdrive_id_2) {
            $gdriveService->deleteImage($structureModel->gdrive_id_2);
        }

        $structureModel->delete();
        return redirect()->back();
    }
}
