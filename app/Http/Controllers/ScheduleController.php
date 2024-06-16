<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use RealRashid\SweetAlert\Facades\Alert;
use App\Services\GoogleDrive;

class ScheduleController extends Controller
{
    public $pathScheduleGDrive = '16hEKrP0GhcA1Qrga1_s4dsNaLbIbcdIt';

    public function index()
    {
        $postschedule = Schedule::orderBy('created_at','desc')->get();
        return view('landing-page.schedule.index', compact('postschedule'),["title" => "Jadwal"]);
    }

    public function indexadmin()
    {
        $postschedule = Schedule::orderBy('created_at','desc')->get();
        return view('admin-page.schedule.index', compact('postschedule'), ["title" => "Schedule"]);
    }

    public function create()
    {
        return view('admin-page.schedule.create', ["title" => "Schedule"]);
    }

    public function store(Request $request)
    {
        $gdriveService = new GoogleDrive($this->pathScheduleGDrive);

        $fileName = time() . '_schedule_' . $request->file('picture')->getClientOriginalName();
        $filePath = $this->pathScheduleGDrive . '/' . $fileName;

        $uploadResult = $gdriveService->uploadImage($request->file('picture'), $fileName, $filePath);

        Schedule::create([
            "title" => $request["title"],
            "month" => $request["month"],
            "year" => $request["year"],
            'picture' => $uploadResult['fileName'],
            'gdrive_id' => $uploadResult['gdriveID'],
        ]);

        Alert::success('Success', 'Schedule has been uploaded !');
        return redirect('/admin/schedule');
    }

    public function edit($id)
    {
        $postschedule = Schedule::find($id);
        return view('admin-page.schedule.update',  compact('postschedule'),["title" => "Schedule"]);
    }

    public function showInAdmin($id)
    {
        $postschedule = Schedule::find($id);
        return view('admin-page.schedule.view',  compact('postschedule'),["title" => "Schedule"]);
    }

    public function update(Request $request, $id)
    {
        $scheduleModel = Schedule::find($id);

        if ($request->file('picture')) {
            $gdriveService = new GoogleDrive($this->pathScheduleGDrive);

            $fileName = time() . '_schedule_' . $request->file('picture')->getClientOriginalName();
            $filePath = $this->pathScheduleGDrive . '/' . $fileName;

            $uploadResult = $gdriveService->uploadImage($request->file('picture'), $fileName, $filePath);

            $oldGdriveID = $scheduleModel->gdrive_id;

            if ($oldGdriveID) {
                $gdriveService->deleteImage($oldGdriveID);
            }

            $scheduleModel->update([
                'picture' => $uploadResult['fileName'],
                'gdrive_id' => $uploadResult['gdriveID'],
            ]);
        }

        $scheduleModel->update([
            "title" => $request["title"],
            "month" => $request["month"],
            "year" => $request["year"],
        ]);

        toast('Schedule has been edited !', 'success')->autoClose(1500)->width('400px');
        return redirect('/admin/schedule');
    }

    public function destroy($id)
    {
        $scheduleModel = Schedule::find($id);
        $gdriveService = new GoogleDrive($this->pathScheduleGDrive);

        if ($scheduleModel->gdrive_id) {
            $gdriveService->deleteImage($scheduleModel->gdrive_id);
        }

        $scheduleModel->delete();
        return redirect()->back();
    }
}
