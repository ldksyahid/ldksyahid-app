<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;

class ScheduleController extends Controller
{

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

    public function create()
    {
        return view('AdminPageView.AdminPageViewSchedule.adminpageviewschedulecreate', ["title" => "Schedule"]);
    }

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

    public function edit($id)
    {
        $postschedule = Schedule::find($id);
        return view('AdminPageView.AdminPageViewSchedule.adminpageviewscheduleedit',  compact('postschedule'),["title" => "Schedule"]);
    }

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
