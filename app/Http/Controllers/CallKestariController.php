<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CallKestari;
use RealRashid\SweetAlert\Facades\Alert;

class CallKestariController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = CallKestari::all();
        return view('LandingPageView.LandingPageViewLayanan.LandingPageViewLayananCallKestari.landingpageviewlayanancallkestari')->with([
            'data' => $data,
            "title" => "Layanan"
        ]);
    }

    public function indexadmin()
    {
        $data = CallKestari::all();
        return view('AdminPageView.AdminPageViewService.AdminPageViewServiceCallKestari.adminpageviewservicecallkestari')->with([
            'data' => $data,
            "title" => "Service"
        ]);
    }

    public function read()
    {
        $data = CallKestari::all();
        return view('AdminPageView.AdminPageViewService.AdminPageViewServiceCallKestari.adminpageviewservicecallkestariread')->with([
            'data' => $data,
            "title" => "Service"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminPageView.AdminPageViewService.AdminPageViewServiceCallKestari.adminpageviewservicecallkestaricreate', ["title" => "Service"]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data['buttonName'] = $request->buttonName;
        $data['appear'] = $request->appear;
        $data['link'] = $request->link;
        CallKestari::insert($data);
        Alert::success('Success', 'Call Kestari created successfully !');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = CallKestari::findOrFail($id);
        return view('AdminPageView.AdminPageViewService.AdminPageViewServiceCallKestari.adminpageviewservicecallkestariedit')->with([
            'data' => $data,
            "title" => "Service"
        ]);
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
        $data = CallKestari::findOrFail($id);
        $data['buttonName'] = $request->buttonName;
        $data['appear'] = $request->appear;
        $data['link'] = $request->link;
        $data->save();
        toast('Call Kestari has been updated !', 'success')->autoClose(1500)->width('350px');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = CallKestari::findOrFail($id);
        $data->delete();
    }
}
