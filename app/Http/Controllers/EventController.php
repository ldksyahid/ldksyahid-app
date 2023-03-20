<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $postevent = Event::orderBy('dateevent','desc')->get();
        return view('LandingPageView.LandingPageViewEvent.landingpageviewevent', compact('postevent'), ["title" => "Kegiatan"]);
    }

    public function indexadmin()
    {
        $postevent = Event::orderBy('created_at','desc')->get();
        return view('AdminPageView.AdminPageViewEvent.adminpageviewevent', compact('postevent'), ["title" => "Event"]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminPageView.AdminPageViewEvent.adminpagevieweventcreate', ["title" => "Event"]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $filename = time().$request->file('poster')->getClientOriginalName();
        $path = $request->file('poster')->storeAs('Images/uploads/eventsposter',$filename);
        $postevent = Event::create([
            "title" => $request["title"],
            "division" => $request["division"],
            "broadcast" => $request["broadcast"],
            "linkembedgform" => $request["linkembedgform"],
            "dateevent" => $request["dateevent"],
            'poster' => $path
        ]);
        Alert::success('Success', 'Event has been uploaded !');
        return redirect('/admin/event');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $title)
    {
        $dt = Carbon::now();
        $postevent = Event::find($id);
        return view('LandingPageView.LandingPageViewEvent.landingpagevieweventshow', compact('postevent'), ["title" => "Kegiatan"]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $postevent = Event::find($id);
        return view('AdminPageView.AdminPageViewEvent.adminpagevieweventedit', compact('postevent'), ["title" => "Event"]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
            "linkembedgform" => $request["linkembedgform"],
            "dateevent" => $request["dateevent"],
        ]);

        toast('Event has been edited !', 'success')->autoClose(1500)->width('400px');
        return redirect('/admin/event');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
