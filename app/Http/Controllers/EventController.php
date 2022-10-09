<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

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
        $gambar = $request->poster;
        $new_gambar = time() . ' . ' . $gambar->getClientOriginalName();

        $postevent = Event::create([
            "title" => $request["title"],
            "division" => $request["division"],
            "broadcast" => $request["broadcast"],
            "linkembedgform" => $request["linkembedgform"],
            "dateevent" => $request["dateevent"],
            'poster' => $new_gambar
        ]);

        $gambar->move('Images/uploads/eventsposter/',$new_gambar);
        Alert::success('Success', 'Event has been uploaded !');
        return redirect('/admin/event');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dt = Carbon::now();
        $postevent = Event::find($id);
        return view('LandingPageView.LandingPageViewEvent.landingpagevieweventshow', compact('postevent'), ["title" => "Event"]);
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
        $gambar = $request->poster;
        $new_gambar = time() . ' . ' . $gambar->getClientOriginalName();

        $update = Event::where("id", $id)-> update([
            "title" => $request["title"],
            "division" => $request["division"],
            "broadcast" => $request["broadcast"],
            "linkembedgform" => $request["linkembedgform"],
            "dateevent" => $request["dateevent"],
            'poster' => $new_gambar
        ]);

        toast('Event has been edited !', 'success')->autoClose(1500)->width('400px');
        $gambar->move('Images/uploads/eventsposter/',$new_gambar);
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
        $data = Event::findOrFail($id);
        $data->delete();
    }
}
