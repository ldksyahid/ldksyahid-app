<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use App\Services\GoogleDrive;

class EventController extends Controller
{
    public $pathEventGDrive = '1iQgMUHmSTJVXG7LbmKvXjFPNz4gmyYak';

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
        $gdriveService = new GoogleDrive($this->pathEventGDrive);

        $fileName = time() . '_event_' . $request->file('poster')->getClientOriginalName();
        $filePath = $this->pathEventGDrive . '/' . $fileName;

        $uploadResult = $gdriveService->uploadImage($request->file('poster'), $fileName, $filePath);

        Event::create([
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
            'poster' => $uploadResult['fileName'],
            'gdrive_id' => $uploadResult['gdriveID'],
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
        $eventModel = Event::find($id);

        if ($request->file('poster')) {
            $gdriveService = new GoogleDrive($this->pathEventGDrive);

            $fileName = time() . '_event_' . $request->file('poster')->getClientOriginalName();
            $filePath = $this->pathEventGDrive . '/' . $fileName;

            $uploadResult = $gdriveService->uploadImage($request->file('poster'), $fileName, $filePath);

            $oldGdriveID = $eventModel->gdrive_id;

            if ($oldGdriveID) {
                $gdriveService->deleteImage($oldGdriveID);
            }

            $eventModel->update([
                'poster' => $uploadResult['fileName'],
                'gdrive_id' => $uploadResult['gdriveID'],
            ]);
        }

        $eventModel->update([
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
        $eventModel = Event::find($id);
        $gdriveService = new GoogleDrive($this->pathEventGDrive);

        if ($eventModel->gdrive_id) {
            $gdriveService->deleteImage($eventModel->gdrive_id);
        }

        $eventModel->delete();
        return redirect()->back();
    }
}
