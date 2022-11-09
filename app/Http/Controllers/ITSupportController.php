<?php

namespace App\Http\Controllers;

use App\Models\ITSupport;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;

class ITSupportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $postitsupport = ITSupport::orderBy('created_at','desc')->get();
        return view('LandingPageView.LandingPageViewITSupport.landingpageviewitsupport', compact('postitsupport'),["title" => "Tentang Kami"]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexadmin()
    {
        $postitsupport = ITSupport::orderBy('created_at','desc')->get();
        return view('AdminPageView.AdminPageViewAboutUs.AdminPageViewAboutUsITSupport.adminpageviewaboutusitsupport', compact('postitsupport'),["title" => "About Us"]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminPageView.AdminPageViewAboutUs.AdminPageViewAboutUsITSupport.adminpageviewaboutusitsupportcreate', ["title" => "About Us"]);
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ITSupport  $iTSupport
     * @return \Illuminate\Http\Response
     */
    public function edit(ITSupport $iTSupport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ITSupport  $iTSupport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ITSupport $iTSupport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ITSupport  $iTSupport
     * @return \Illuminate\Http\Response
     */
    public function destroy(ITSupport $iTSupport)
    {
        //
    }
}
