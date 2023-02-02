<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;

class CelenganSyahidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $postevent = Event::orderBy('dateevent','desc')->get();
        return view('LandingPageView.LandingPageViewLayanan.LandingPageViewLayananCelenganSyahid.landingpageview-layanan-celengansyahid',["title" => "Layanan"]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($nameCampaign)
    {
        return view('LandingPageView.LandingPageViewLayanan.LandingPageViewLayananCelenganSyahid.landingpageview-layanan-celengansyahid-show',["title" => "Layanan"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function donasiSekarang($nameCampaign)
    {
        return view('LandingPageView.LandingPageViewLayanan.LandingPageViewLayananCelenganSyahid.landingpageview-layanan-celengansyahid-show-donasi-sekarang',["title" => "Layanan"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($nameCampaign)
    {
        return view('LandingPageView.LandingPageViewLayanan.LandingPageViewLayananCelenganSyahid.landingpageview-layanan-celengansyahid-show-donasi-sekarang-status',["title" => "Layanan"]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    public function indexAdminCampaign()
    {
        $postcampaign = Campaign::orderBy('created_at','desc')->get();
        return view('AdminPageView.AdminPageViewService.AdminPageViewServiceCelenganSyahid.AdminPageViewServiceCelenganSyahidCampaign.adminpageviewservicecelsyahcamp',compact('postcampaign'), ["title" => "Celengan Syahid"]);
    }

    public function createAdminCampaign()
    {
        return view('AdminPageView.AdminPageViewService.AdminPageViewServiceCelenganSyahid.AdminPageViewServiceCelenganSyahidCampaign.adminpageviewservicecelsyahcampcreate', ["title" => "Celengan Syahid"]);
    }
}
