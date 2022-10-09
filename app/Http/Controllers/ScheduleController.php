<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $postschedule = Schedule::orderBy('created_at','desc')->get();
        return view('LandingPageView.LandingPageViewSchedule.landingpageviewschedule', compact('postschedule'),["title" => "Jadwal"]);
    }

    public function indexadmin()
    {
        $postschedule = Schedule::orderBy('created_at','desc')->get();
        return view('AdminPageView.AdminPageViewSchedule.adminpageviewschedule', compact('postschedule'), ["title" => "Schedule"]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminPageView.AdminPageViewSchedule.adminpageviewschedulecreate', ["title" => "Schedule"]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $gambar = $request->picture;
        $new_gambar = time() . ' . ' . $gambar->getClientOriginalName();

        $postschedule = Schedule::create([
            "title" => $request["title"],
            "month" => $request["month"],
            "year" => $request["year"],
            'picture' => $new_gambar,
        ]);

        $gambar->move('Images/uploads/schedule/',$new_gambar);
        Alert::success('Success', 'Schedule has been uploaded !');
        return redirect('/admin/schedule');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $postschedule = Schedule::find($id);
        return view('AdminPageView.AdminPageViewSchedule.adminpageviewscheduleedit',  compact('postschedule'),["title" => "Schedule"]);
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
        $gambar = $request->picture;
        $new_gambar = time() . ' . ' . $gambar->getClientOriginalName();

        $updateschedule = Schedule::where("id", $id)-> update([
            "title" => $request["title"],
            "month" => $request["month"],
            "year" => $request["year"],
            'picture' => $new_gambar,
        ]);

        toast('Schedule has been edited !', 'success')->autoClose(1500)->width('400px');
        $gambar->move('Images/uploads/schedule/',$new_gambar);
        return redirect('/admin/schedule');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Schedule::findOrFail($id);
        $data->delete();
    }
}
