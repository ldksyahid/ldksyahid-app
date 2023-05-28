<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class EventController extends Controller
{
    public function index()
    {
        $postevent = Event::orderBy('created_at','desc')->get();
        return view('landing-page.event.index', compact('postevent'), ["title" => "Kegiatan"]);
    }

    public function indexadmin()
    {
        $postevent = Event::orderBy('created_at','desc')->get();
        return view('admin-page.event.index', compact('postevent'), ["title" => "Event"]);
    }

    public function create()
    {
        return view('admin-page.event.create', ["title" => "Event"]);
    }

    public function store(Request $request)
    {
        $filename = time().$request->file('poster')->getClientOriginalName();
        $path = $request->file('poster')->storeAs('Images/uploads/eventsposter',$filename);
        $postevent = Event::create([
            "title" => $request["title"],
            "division" => $request["division"],
            "broadcast" => $request["broadcast"],
            "tag" => $request["tag"],
            "closeRegist" => $request["closeRegist"],
            "linkRegist" => $request["linkRegist"],
            "start" => $request["start"],
            "finished" => $request["finished"],
            "location" => $request["location"],
            "linkLocation" => $request["linkLocation"],
            "place" => $request["place"],
            "linkDoc" => $request["linkDoc"],
            "linkPresent" => $request["linkPresent"],
            "cntctPrsn1" => $request["cntctPrsn1"],
            "cntctPrsn2" => $request["cntctPrsn2"],
            "nameCntctPrsn1" => $request["nameCntctPrsn1"],
            "nameCntctPrsn2" => $request["nameCntctPrsn2"],
            "linkembedgform" => null,
            "dateevent" => '2023/01/01',
            'poster' => $path
        ]);
        Alert::success('Success', 'Event has been uploaded !');
        return redirect('/admin/event');
    }

    public function show($id)
    {
        $dt = Carbon::now();
        $postevent = Event::find($id);
        return view('landing-page.event.detail', compact('postevent'), ["title" => "Kegiatan"]);
    }

    public function showInAdmin($id)
    {
        $dt = Carbon::now();
        $postevent = Event::find($id);
        return view('admin-page.event.view', compact('postevent'), ["title" => "Kegiatan"]);
    }

    public function edit($id)
    {
        $postevent = Event::find($id);
        return view('admin-page.event.update', compact('postevent'), ["title" => "Event"]);
    }

    public function update(Request $request, $id)
    {
        if ($request->file('poster')) {
            $filename = time().$request->file('poster')->getClientOriginalName();
            $path = $request->file('poster')->storeAs('Images/uploads/eventsposter',$filename);

            // hapus file
            $gambar = Event::where('id',$id)->first();
            File::delete($gambar->poster);

            // upload file
            $update = Event::where("id", $id)-> update([
                'poster' => $path,
            ]);
        }

        $update = Event::where("id", $id)-> update([
            "title" => $request["title"],
            "division" => $request["division"],
            "broadcast" => $request["broadcast"],
            "tag" => $request["tag"],
            "closeRegist" => $request["closeRegist"],
            "linkRegist" => $request["linkRegist"],
            "start" => $request["start"],
            "finished" => $request["finished"],
            "location" => $request["location"],
            "linkLocation" => $request["linkLocation"],
            "place" => $request["place"],
            "linkDoc" => $request["linkDoc"],
            "linkPresent" => $request["linkPresent"],
            "cntctPrsn1" => $request["cntctPrsn1"],
            "cntctPrsn2" => $request["cntctPrsn2"],
            "nameCntctPrsn1" => $request["nameCntctPrsn1"],
            "nameCntctPrsn2" => $request["nameCntctPrsn2"],
            "linkembedgform" => null,
            "dateevent" => '2023/01/01',
        ]);

        toast('Event has been edited !', 'success')->autoClose(1500)->width('400px');
        return redirect('/admin/event');
    }

    public function destroy($id)
    {

        // hapus file
        $gambar = Event::where('id',$id)->first();
        File::delete($gambar->poster);

        // hapus data
        Event::where('id',$id)->delete();
        return redirect()->back();
    }
}
