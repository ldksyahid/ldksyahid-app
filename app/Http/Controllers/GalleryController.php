<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Services\GoogleDrive;
use RealRashid\SweetAlert\Facades\Alert;

class GalleryController extends Controller
{
    public $pathGalleryGDrive = '1d_ZOMfeFVkATb6gWYVFtttTNE-k0nCsv';

    public function index()
    {
        $postgallery = Gallery::orderBy('created_at','desc')->get();
        return view('landing-page.about.gallery', compact('postgallery'),["title" => "Tentang Kami"]);
    }

    public function indexadmin()
    {
        $postgallery = Gallery::orderBy('created_at','desc')->get();
        return view('admin-page.about.gallery.index', compact('postgallery'), ["title" => "About Us"]);
    }

    public function create()
    {
        return view('admin-page.about.gallery.create', ["title" => "About Us"]);
    }

    public function store(Request $request)
    {
        $gdriveService = new GoogleDrive($this->pathGalleryGDrive);

        $fileNameGroupPhoto = time() . '_groupPhoto_' . $request->file('groupPhoto')->getClientOriginalName();
        $filePathGroupPhoto = $this->pathGalleryGDrive . '/' . $fileNameGroupPhoto;
        $uploadResultGroupPhoto = $gdriveService->uploadImage($request->file('groupPhoto'), $fileNameGroupPhoto, $filePathGroupPhoto);

        $photos = [];
        for ($i = 1; $i <= 12; $i++) {
            $photoKey = 'photo' . $i;
            if ($request->file($photoKey)) {
                $fileName = time() . '_' . $photoKey . '_' . $request->file($photoKey)->getClientOriginalName();
                $filePath = $this->pathGalleryGDrive . '/' . $fileName;

                $uploadResult = $gdriveService->uploadImage($request->file($photoKey), $fileName, $filePath);

                $photos[$photoKey] = [
                    'fileName' => !empty($uploadResult) ? $uploadResult['fileName'] : null,
                    'gdriveID' => !empty($uploadResult) ? $uploadResult['gdriveID'] : null
                ];
            } else {
                $photos[$photoKey] = ['fileName' => null, 'gdriveID' => null];
            }
        }

        $galleryData = [
            "eventName" => $request->input("eventName"),
            "eventTheme" => $request->input("eventTheme"),
            "eventDescription" => $request->input("eventDescription"),
            "linkEmbedYoutube" => $request->input("linkEmbedYoutube"),
            'groupPhoto' => !empty($uploadResultGroupPhoto) ? $uploadResultGroupPhoto['fileName'] : null,
            'gdrive_id' => !empty($uploadResultGroupPhoto) ? $uploadResultGroupPhoto['gdriveID'] : null,
        ];

        for ($i = 1; $i <= 12; $i++) {
            $photoKey = 'photo' . $i;
            $gdriveKey = 'gdrive_id_' . $i;
            $galleryData[$photoKey] = $photos[$photoKey]['fileName'];
            $galleryData[$gdriveKey] = $photos[$photoKey]['gdriveID'];
        }

        Gallery::create($galleryData);

        Alert::success('Success', 'Gallery has been uploaded!');
        return redirect('/admin/about/gallery');
    }

    public function edit($id)
    {
        $postgallery = Gallery::find($id);
        return view('admin-page.about.gallery.update',  compact('postgallery'),["title" => "About Us"]);
    }

    public function showInAdmin($id)
    {
        $postgallery = Gallery::find($id);
        return view('admin-page.about.gallery.view',  compact('postgallery'),["title" => "About Us"]);
    }

    public function update(Request $request, $id)
    {
        $gdriveService = new GoogleDrive($this->pathGalleryGDrive);
        $gallery = Gallery::findOrFail($id);

        if ($request->file('groupPhoto')) {
            $fileNameGroupPhoto = time() . '_groupPhoto_' . $request->file('groupPhoto')->getClientOriginalName();
            $filePathGroupPhoto = $this->pathGalleryGDrive . '/' . $fileNameGroupPhoto;

            $uploadResultGroupPhoto = $gdriveService->uploadImage($request->file('groupPhoto'), $fileNameGroupPhoto, $filePathGroupPhoto);

            if (!empty($uploadResultGroupPhoto)) {
                $oldGdriveID = $gallery->gdrive_id;
                if ($oldGdriveID) {
                    $gdriveService->deleteImage($oldGdriveID);
                }

                $gallery->update([
                    'groupPhoto' => $uploadResultGroupPhoto['fileName'],
                    'gdrive_id' => $uploadResultGroupPhoto['gdriveID'],
                ]);
            }
        }


        for ($i = 1; $i <= 12; $i++) {
            $photoKey = 'photo' . $i;
            $gdriveKey = 'gdrive_id_' . $i;

            if ($request->file($photoKey)) {
                $fileNamePhoto = time() . '_' . $photoKey . '_' . $request->file($photoKey)->getClientOriginalName();
                $filePathPhoto = $this->pathGalleryGDrive . '/' . $fileNamePhoto;

                $uploadResultPhoto = $gdriveService->uploadImage($request->file($photoKey), $fileNamePhoto, $filePathPhoto);

                if (!empty($uploadResultPhoto)) {
                    $oldGdriveID = $gallery->$gdriveKey;
                    if ($oldGdriveID) {
                        $gdriveService->deleteImage($oldGdriveID);
                    }

                    $gallery->update([
                        $photoKey => $uploadResultPhoto['fileName'],
                        $gdriveKey => $uploadResultPhoto['gdriveID'],
                    ]);
                }
            }
        }

        $gallery->update([
            "eventName" => $request["eventName"],
            "eventTheme" => $request["eventTheme"],
            "eventDescription" => $request["eventDescription"],
            "linkEmbedYoutube" => $request["linkEmbedYoutube"],
        ]);

        toast('Gallery has been edited!', 'success')->autoClose(1500)->width('400px');
        return redirect('/admin/about/gallery');
    }



    public function destroy($id)
    {
        $gdriveService = new GoogleDrive($this->pathGalleryGDrive);

        $gallery = Gallery::findOrFail($id);

        if ($gallery->gdrive_id) {
            $gdriveService->deleteImage($gallery->gdrive_id);
        }

        for ($i = 1; $i <= 12; $i++) {
            $gdriveKey = 'gdrive_id_' . $i;
            if ($gallery->$gdriveKey) {
                $gdriveService->deleteImage($gallery->$gdriveKey);
            }
        }

        $gallery->delete();


        return redirect()->back()->with('success', 'Gallery has been deleted successfully!');
    }

}
