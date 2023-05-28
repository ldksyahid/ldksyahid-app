<?php

namespace App\Http\Controllers;

use App\Models\ITSupport;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;

class ITSupportController extends Controller
{
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
        $filename = time().$request->file('photoProfile')->getClientOriginalName();
        $path = $request->file('photoProfile')->storeAs('Images/uploads/itsupport',$filename);

        $postitsupport = ITSupport::create([
            "name" => $request["name"],
            "forkat" => $request["forkat"],
            "position" => $request["position"],
            "linkInstagram" => $request["linkInstagram"],
            "linkLinkedin" => $request["linkLinkedin"],
            'photoProfile' => $path,
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
        if ($request->file('photoProfile')) {
            $filename = time().$request->file('photoProfile')->getClientOriginalName();
            $path = $request->file('photoProfile')->storeAs('Images/uploads/itsupport',$filename);

            // hapus file
            $gambar = ITSupport::where('id',$id)->first();
            File::delete($gambar->photoProfile);

            // upload file
            $update = ITSupport::where("id", $id)-> update([
                'photoProfile' => $path,
            ]);
        }

        $update = ITSupport::where("id", $id)-> update([
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
        // hapus file
        $gambar = ITSupport::where('id',$id)->first();
        File::delete($gambar->photoProfile);

        // hapus data
        ITSupport::where('id',$id)->delete();
        return redirect()->back();
    }
}
