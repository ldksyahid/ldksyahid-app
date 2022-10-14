<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

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
        $filename = time().$request->file('picture')->getClientOriginalName();
        $path = $request->file('picture')->storeAs('Images/uploads/schedule',$filename);

        $postschedule = Schedule::create([
            "title" => $request["title"],
            "month" => $request["month"],
            "year" => $request["year"],
            'picture' => $path,
        ]);

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
        if ($request->file('picture')) {
            $filename = time().$request->file('picture')->getClientOriginalName();
            $path = $request->file('picture')->storeAs('Images/uploads/schedule',$filename);

            // hapus file
            $gambar = Schedule::where('id',$id)->first();
            File::delete($gambar->picture);

            // upload file
            $update = Schedule::where("id", $id)-> update([
                'picture' => $path,
            ]);
        }

        $updateschedule = Schedule::where("id", $id)-> update([
            "title" => $request["title"],
            "month" => $request["month"],
            "year" => $request["year"],
        ]);

        toast('Schedule has been edited !', 'success')->autoClose(1500)->width('400px');
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
         // hapus file
         $gambar = Schedule::where('id',$id)->first();
         File::delete($gambar->picture);

         // hapus data
         Schedule::where('id',$id)->delete();
         return redirect()->back();
    }
}
