<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimony;
use RealRashid\SweetAlert\Facades\Alert;
use App\Services\GoogleDrive;

class TestimonyController extends Controller
{

    public $pathTestimonyGDrive = '1w2pq-EYLmaeJ7irJ-KQaXZS0iJvn1pNY';

    public function index()
    {
        $posttestimony= Testimony::orderBy('created_at','desc')->get();
        return view('admin-page.home.testimony.index', compact('posttestimony'), ["title" => "Home"]);
    }

    public function create()
    {
        return view('admin-page.home.testimony.create', ["title" => "Home"]);
    }

    public function store(Request $request)
    {
        $gdriveService = new GoogleDrive($this->pathTestimonyGDrive);

        $fileName = time() . '_testimony_' . $request->file('picture')->getClientOriginalName();
        $filePath = $this->pathTestimonyGDrive . '/' . $fileName;

        $uploadResult = $gdriveService->uploadImage($request->file('picture'), $fileName, $filePath);

        Testimony::create([
            "name" => $request["name"],
            "profession" => $request["profession"],
            "testimony" => $request["testimony"],
            'picture' => $uploadResult['fileName'],
            'gdrive_id' => $uploadResult['gdriveID'],
        ]);

        Alert::success('Success', 'Testimony has been uploaded !');
        return redirect('/admin/testimony');
    }

    public function edit($id)
    {
        $posttestimony = Testimony::find($id);
        return view('admin-page.home.testimony.update', compact('posttestimony'), ["title" => "Home"]);
    }

    public function show($id)
    {
        $posttestimony = Testimony::find($id);
        return view('admin-page.home.testimony.view', compact('posttestimony'), ["title" => "Home"]);
    }

    public function update(Request $request, $id)
    {
        $testimonyModel = Testimony::find($id);

        if ($request->file('picture')) {
            $gdriveService = new GoogleDrive($this->pathTestimonyGDrive);

            $fileName = time() . '_testimony_' . $request->file('picture')->getClientOriginalName();
            $filePath = $this->pathTestimonyGDrive . '/' . $fileName;

            $uploadResult = $gdriveService->uploadImage($request->file('picture'), $fileName, $filePath);

            $oldGdriveID = $testimonyModel->gdrive_id;

            if ($oldGdriveID) {
                $gdriveService->deleteImage($oldGdriveID);
            }

            $testimonyModel->update([
                'picture' => $uploadResult['fileName'],
                'gdrive_id' => $uploadResult['gdriveID'],
            ]);
        }

        $testimonyModel->update([
            "name" => $request["name"],
            "profession" => $request["profession"],
            "testimony" => $request["testimony"],
        ]);

        toast('Testimony has been edited !', 'success')->autoClose(1500)->width('400px');
        return redirect('/admin/testimony');
    }

    public function destroy($id)
    {
        $testimonyModel = Testimony::find($id);
        $gdriveService = new GoogleDrive($this->pathTestimonyGDrive);

        if ($testimonyModel->gdrive_id) {
            $gdriveService->deleteImage($testimonyModel->gdrive_id);
        }

        $testimonyModel->delete();
        return redirect()->back();
    }
}
