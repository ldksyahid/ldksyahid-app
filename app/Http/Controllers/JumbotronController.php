<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jumbotron;
use RealRashid\SweetAlert\Facades\Alert;
use App\Services\GoogleDrive;

class JumbotronController extends Controller
{
    public $pathJumbotronGDrive = '1RflrHwMXU-QZfh-unZyfL5UGD8fvEWz8';

    public function index()
    {
        $postjumbotron = Jumbotron::orderBy('created_at', 'desc')->get();
        return view('admin-page.home.jumbotron.index', compact('postjumbotron'), ["title" => "Home"]);
    }

    public function create()
    {
        return view('admin-page.home.jumbotron.create', ["title" => "Home"]);
    }

    public function store(Request $request)
    {
        $gdriveService = new GoogleDrive($this->pathJumbotronGDrive);

        $fileName = time() . '_jumbotron_' . $request->file('picture')->getClientOriginalName();
        $filePath = $this->pathJumbotronGDrive . '/' . $fileName;

        $uploadResult = $gdriveService->uploadImage($request->file('picture'), $fileName, $filePath);

        Jumbotron::create([
            "title" => "none",
            "subtitle" => "none",
            "sentence" => "none",
            "btnname" => $request["buttonname"],
            "btnlink" => $request["buttonlink"],
            'picture' => $uploadResult['fileName'],
            'gdrive_id' => $uploadResult['gdriveID'],
            "textalign" => "start",
        ]);

        Alert::success('Success', 'Jumbotron has been uploaded !');
        return redirect('/admin/jumbotron');
    }

    public function show($id)
    {
        $postjumbotron = Jumbotron::find($id);
        return view('admin-page.home.jumbotron.view', compact('postjumbotron'), ["title" => "Home"]);
    }

    public function edit($id)
    {
        $postjumbotron = Jumbotron::find($id);
        return view('admin-page.home.jumbotron.update', compact('postjumbotron'), ["title" => "Home"]);
    }

    public function update(Request $request, $id)
    {
        $jumbotron = Jumbotron::find($id);
        $gdriveService = new GoogleDrive($this->pathJumbotronGDrive);

        if ($request->file('picture')) {
            $fileName = time() . '_jumbotron_' . $request->file('picture')->getClientOriginalName();
            $filePath = $this->pathJumbotronGDrive . '/' . $fileName;

            $uploadResult = $gdriveService->uploadImage($request->file('picture'), $fileName, $filePath);

            $oldGdriveID = $jumbotron->gdrive_id;
            if ($oldGdriveID) {
                $gdriveService->deleteImage($oldGdriveID);
            }

            $jumbotron->update([
                'picture' => $uploadResult['fileName'],
                'gdrive_id' => $uploadResult['gdriveID'],
            ]);
        }

        $jumbotron->update([
            "title" => "none",
            "subtitle" => "none",
            "sentence" => "none",
            "btnname" => $request["buttonname"],
            "btnlink" => $request["buttonlink"],
            "textalign" => "start",
        ]);

        toast('Jumbotron has been edited!', 'success')->autoClose(1500)->width('400px');
        return redirect('/admin/jumbotron');
    }

    public function destroy($id)
    {
        $jumbotron = Jumbotron::find($id);
        $gdriveService = new GoogleDrive($this->pathJumbotronGDrive);

        if ($jumbotron->gdrive_id) {
            $gdriveService->deleteImage($jumbotron->gdrive_id);
        }

        $jumbotron->delete();
        return redirect()->back();
    }
}
