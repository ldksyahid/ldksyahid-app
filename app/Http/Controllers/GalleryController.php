<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{
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
        $filenameGroupPhoto = time().$request->file('groupPhoto')->getClientOriginalName();
        $pathGroupPhoto = $request->file('groupPhoto')->storeAs('Images/uploads/gallery/GroupPhoto',$filenameGroupPhoto);

        $pathPhoto1 = null;
        if ($request->file('photo1')) {
            $filenamePhoto1 = time().'1'.$request->file('photo1')->getClientOriginalName();
            $pathPhoto1 = $request->file('photo1')->storeAs('Images/uploads/gallery/OtherPhoto',$filenamePhoto1);
        }

        $pathPhoto2 = null;
        if ($request->file('photo2')) {
            $filenamePhoto2 = time().'2'.$request->file('photo2')->getClientOriginalName();
            $pathPhoto2 = $request->file('photo2')->storeAs('Images/uploads/gallery/OtherPhoto',$filenamePhoto2);
        }

        $pathPhoto3 = null;
        if ($request->file('photo3')) {
            $filenamePhoto3 = time().'3'.$request->file('photo3')->getClientOriginalName();
            $pathPhoto3 = $request->file('photo3')->storeAs('Images/uploads/gallery/OtherPhoto',$filenamePhoto3);
        }

        $pathPhoto4 = null;
        if ($request->file('photo4')) {
            $filenamePhoto4 = time().'4'.$request->file('photo4')->getClientOriginalName();
            $pathPhoto4 = $request->file('photo4')->storeAs('Images/uploads/gallery/OtherPhoto',$filenamePhoto4);
        }

        $pathPhoto5 = null;
        if ($request->file('photo5')) {
            $filenamePhoto5 = time().'5'.$request->file('photo5')->getClientOriginalName();
            $pathPhoto5 = $request->file('photo5')->storeAs('Images/uploads/gallery/OtherPhoto',$filenamePhoto5);
        }

        $pathPhoto6 = null;
        if ($request->file('photo6')) {
            $filenamePhoto6 = time().'6'.$request->file('photo6')->getClientOriginalName();
            $pathPhoto6 = $request->file('photo6')->storeAs('Images/uploads/gallery/OtherPhoto',$filenamePhoto6);
        }

        $pathPhoto7 = null;
        if ($request->file('photo7')) {
            $filenamePhoto7 = time().'7'.$request->file('photo7')->getClientOriginalName();
            $pathPhoto7 = $request->file('photo7')->storeAs('Images/uploads/gallery/OtherPhoto',$filenamePhoto7);
        }

        $pathPhoto8 = null;
        if ($request->file('photo8')) {
            $filenamePhoto8 = time().'8'.$request->file('photo8')->getClientOriginalName();
            $pathPhoto8 = $request->file('photo8')->storeAs('Images/uploads/gallery/OtherPhoto',$filenamePhoto8);
        }

        $pathPhoto9 = null;
        if ($request->file('photo9')) {
            $filenamePhoto9 = time().'9'.$request->file('photo9')->getClientOriginalName();
            $pathPhoto9 = $request->file('photo9')->storeAs('Images/uploads/gallery/OtherPhoto',$filenamePhoto9);
        }

        $pathPhoto10 = null;
        if ($request->file('photo10')) {
            $filenamePhoto10 = time().'10'.$request->file('photo10')->getClientOriginalName();
            $pathPhoto10 = $request->file('photo10')->storeAs('Images/uploads/gallery/OtherPhoto',$filenamePhoto10);
        }

        $pathPhoto11 = null;
        if ($request->file('photo11')) {
            $filenamePhoto11 = time().'11'.$request->file('photo11')->getClientOriginalName();
            $pathPhoto11 = $request->file('photo11')->storeAs('Images/uploads/gallery/OtherPhoto',$filenamePhoto11);
        }

        $pathPhoto12 = null;
        if ($request->file('photo12')) {
            $filenamePhoto12 = time().'12'.$request->file('photo12')->getClientOriginalName();
            $pathPhoto12 = $request->file('photo12')->storeAs('Images/uploads/gallery/OtherPhoto',$filenamePhoto12);
        }


        $postgallery = Gallery::create([
            "eventName" => $request["eventName"],
            "eventTheme" => $request["eventTheme"],
            "eventDescription" => $request["eventDescription"],
            "linkEmbedYoutube" => $request["linkEmbedYoutube"],
            'groupPhoto' => $pathGroupPhoto,
            'photo1' => $pathPhoto1,
            'photo2' => $pathPhoto2,
            'photo3' => $pathPhoto3,
            'photo4' => $pathPhoto4,
            'photo5' => $pathPhoto5,
            'photo6' => $pathPhoto6,
            'photo7' => $pathPhoto7,
            'photo8' => $pathPhoto8,
            'photo9' => $pathPhoto9,
            'photo10' => $pathPhoto10,
            'photo11' => $pathPhoto11,
            'photo12' => $pathPhoto12,


        ]);

        Alert::success('Success', 'Gallery has been uploaded !');
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
        if ($request->file('groupPhoto')) {
            $filenameGroupPhoto = time().$request->file('groupPhoto')->getClientOriginalName();
            $pathGroupPhoto = $request->file('groupPhoto')->storeAs('Images/uploads/gallery/GroupPhoto',$filenameGroupPhoto);

            // hapus file
            $gambar = Gallery::where('id',$id)->first();
            File::delete($gambar->groupPhoto);

            // upload file
            $update = Gallery::where("id", $id)-> update([
                'groupPhoto' => $pathGroupPhoto,
            ]);
        }

        if ($request->file('photo1')) {
            $filenamePhoto1 = time().'1'.$request->file('photo1')->getClientOriginalName();
            $pathPhoto1 = $request->file('photo1')->storeAs('Images/uploads/gallery/OtherPhoto',$filenamePhoto1);

            // hapus file
            $gambar = Gallery::where('id',$id)->first();
            File::delete($gambar->photo1);

            // upload file
            $update = Gallery::where("id", $id)-> update([
                'photo1' => $pathPhoto1,
            ]);
        }

        if ($request->file('photo2')) {
            $filenamePhoto2 = time().'2'.$request->file('photo2')->getClientOriginalName();
            $pathPhoto2 = $request->file('photo2')->storeAs('Images/uploads/gallery/OtherPhoto',$filenamePhoto2);

            // hapus file
            $gambar = Gallery::where('id',$id)->first();
            File::delete($gambar->photo2);

            // upload file
            $update = Gallery::where("id", $id)-> update([
                'photo2' => $pathPhoto2,
            ]);
        }

        if ($request->file('photo3')) {
            $filenamePhoto3 = time().'3'.$request->file('photo3')->getClientOriginalName();
            $pathPhoto3 = $request->file('photo3')->storeAs('Images/uploads/gallery/OtherPhoto',$filenamePhoto3);

            // hapus file
            $gambar = Gallery::where('id',$id)->first();
            File::delete($gambar->photo3);

            // upload file
            $update = Gallery::where("id", $id)-> update([
                'photo3' => $pathPhoto3,
            ]);
        }

        if ($request->file('photo4')) {
            $filenamePhoto4 = time().'4'.$request->file('photo4')->getClientOriginalName();
            $pathPhoto4 = $request->file('photo4')->storeAs('Images/uploads/gallery/OtherPhoto',$filenamePhoto4);

            // hapus file
            $gambar = Gallery::where('id',$id)->first();
            File::delete($gambar->photo4);

            // upload file
            $update = Gallery::where("id", $id)-> update([
                'photo4' => $pathPhoto4,
            ]);
        }

        if ($request->file('photo5')) {
            $filenamePhoto5 = time().'5'.$request->file('photo5')->getClientOriginalName();
            $pathPhoto5 = $request->file('photo5')->storeAs('Images/uploads/gallery/OtherPhoto',$filenamePhoto5);

            // hapus file
            $gambar = Gallery::where('id',$id)->first();
            File::delete($gambar->photo5);

            // upload file
            $update = Gallery::where("id", $id)-> update([
                'photo5' => $pathPhoto5,
            ]);
        }

        if ($request->file('photo6')) {
            $filenamePhoto6 = time().'6'.$request->file('photo6')->getClientOriginalName();
            $pathPhoto6 = $request->file('photo6')->storeAs('Images/uploads/gallery/OtherPhoto',$filenamePhoto6);

            // hapus file
            $gambar = Gallery::where('id',$id)->first();
            File::delete($gambar->photo6);

            // upload file
            $update = Gallery::where("id", $id)-> update([
                'photo6' => $pathPhoto6,
            ]);
        }

        if ($request->file('photo7')) {
            $filenamePhoto7 = time().'7'.$request->file('photo7')->getClientOriginalName();
            $pathPhoto7 = $request->file('photo7')->storeAs('Images/uploads/gallery/OtherPhoto',$filenamePhoto7);

            // hapus file
            $gambar = Gallery::where('id',$id)->first();
            File::delete($gambar->photo7);

            // upload file
            $update = Gallery::where("id", $id)-> update([
                'photo7' => $pathPhoto7,
            ]);
        }

        if ($request->file('photo8')) {
            $filenamePhoto8 = time().'8'.$request->file('photo8')->getClientOriginalName();
            $pathPhoto8 = $request->file('photo8')->storeAs('Images/uploads/gallery/OtherPhoto',$filenamePhoto8);

            // hapus file
            $gambar = Gallery::where('id',$id)->first();
            File::delete($gambar->photo8);

            // upload file
            $update = Gallery::where("id", $id)-> update([
                'photo8' => $pathPhoto8,
            ]);
        }

        if ($request->file('photo9')) {
            $filenamePhoto9 = time().'9'.$request->file('photo9')->getClientOriginalName();
            $pathPhoto9 = $request->file('photo9')->storeAs('Images/uploads/gallery/OtherPhoto',$filenamePhoto9);

            // hapus file
            $gambar = Gallery::where('id',$id)->first();
            File::delete($gambar->photo9);

            // upload file
            $update = Gallery::where("id", $id)-> update([
                'photo9' => $pathPhoto9,
            ]);
        }

        if ($request->file('photo10')) {
            $filenamePhoto10 = time().'10'.$request->file('photo10')->getClientOriginalName();
            $pathPhoto10 = $request->file('photo10')->storeAs('Images/uploads/gallery/OtherPhoto',$filenamePhoto10);

            // hapus file
            $gambar = Gallery::where('id',$id)->first();
            File::delete($gambar->photo10);

            // upload file
            $update = Gallery::where("id", $id)-> update([
                'photo10' => $pathPhoto10,
            ]);
        }

        if ($request->file('photo11')) {
            $filenamePhoto11 = time().'11'.$request->file('photo11')->getClientOriginalName();
            $pathPhoto11 = $request->file('photo11')->storeAs('Images/uploads/gallery/OtherPhoto',$filenamePhoto11);

            // hapus file
            $gambar = Gallery::where('id',$id)->first();
            File::delete($gambar->photo11);

            // upload file
            $update = Gallery::where("id", $id)-> update([
                'photo11' => $pathPhoto11,
            ]);
        }

        if ($request->file('photo12')) {
            $filenamePhoto12 = time().'12'.$request->file('photo12')->getClientOriginalName();
            $pathPhoto12 = $request->file('photo12')->storeAs('Images/uploads/gallery/OtherPhoto',$filenamePhoto12);

            // hapus file
            $gambar = Gallery::where('id',$id)->first();
            File::delete($gambar->photo12);

            // upload file
            $update = Gallery::where("id", $id)-> update([
                'photo12' => $pathPhoto12,
            ]);
        }

        $updategallery = Gallery::where("id", $id)-> update([
            "eventName" => $request["eventName"],
            "eventTheme" => $request["eventTheme"],
            "eventDescription" => $request["eventDescription"],
            "linkEmbedYoutube" => $request["linkEmbedYoutube"],
        ]);

        toast('Gallery has been edited !', 'success')->autoClose(1500)->width('400px');
        return redirect('/admin/about/gallery');
    }

    public function destroy($id)
    {
         // hapus file GroupPhoto dan OtherPhoto
         $gambar = Gallery::where('id',$id)->first();
         File::delete($gambar->groupPhoto);
         File::delete($gambar->photo1);
         File::delete($gambar->photo2);
         File::delete($gambar->photo3);
         File::delete($gambar->photo4);
         File::delete($gambar->photo5);
         File::delete($gambar->photo6);
         File::delete($gambar->photo7);
         File::delete($gambar->photo8);
         File::delete($gambar->photo9);
         File::delete($gambar->photo10);
         File::delete($gambar->photo11);
         File::delete($gambar->photo12);

         // hapus data
         Gallery::where('id',$id)->delete();
         return redirect()->back();
    }
}
