<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReqShortlink;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RequestShortlinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ReqShortlink::all();
        return view('AdminPageView.AdminPageViewRequestService.AdminPageViewRequestServiceShortlink.adminpageviewrequestserviceshortlink')->with([
            'data' => $data,
            "title" => "Request Services"
        ]);
    }

    public function read()
    {
        $data = ReqShortlink::all();
        return view('AdminPageView.AdminPageViewRequestService.AdminPageViewRequestServiceShortlink.adminpageviewrequestserviceshortlinkread')->with([
            'data' => $data,
            "title" => "Request Services"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('LandingPageView.LandingPageViewLayanan.LandingPageViewLayananShortlink.landingpageviewlayananshortlink', ["title" => "Layanan"]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reqshortlinkstore = ReqShortlink::create([
            "name" => $request->name,
            "email" => $request->email,
            "whatsapp" => $request->whatsapp,
            "defaultLink" => $request->defaultLink,
            "customLink" => $request->customLink,
            "note" => $request->note,
        ]);
        Alert::success('Permintaan Perpendek URL berhasil dikirim', 'Kami akan menghubungimu melalui Whatsapp yang telah di daftarkan setelah Shortlink berhasil kami buat')->autoClose(15000)->width('40%');
        return redirect('/service/shortlink');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = ReqShortlink::findOrFail($id);
        return view('AdminPageView.AdminPageViewRequestService.AdminPageViewRequestServiceShortlink.adminpageviewrequestserviceshortlinkpreview')->with([
            'data' => $data,
            "title" => "Request Services"
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addFixCustomLinkEdit($id)
    {
        $data = ReqShortlink::findOrFail($id);
        return view('AdminPageView.AdminPageViewRequestService.AdminPageViewRequestServiceShortlink.adminpageviewrequestserviceshortlinkaddcustomlink')->with([
            'data' => $data,
            "title" => "Request Services"
        ]);
    }

    public function addFixCustomLinkUpdate(Request $request, $id)
    {

        $data = ReqShortlink::findOrFail($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->whatsapp = $request->whatsapp;
        $data->defaultLink = $request->defaultLink;
        $data->customLink = $request->customLink;
        $data->note = $request->note;
        $data->fixCustomLink = $request->fixCustomLink;
        $data->save();
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = ReqShortlink::findOrFail($id);
        $data->delete();
    }
}
