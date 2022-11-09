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
        return view('LandingPageView.LandingPageViewITSupport.landingpageviewitsupport', ["title" => "Tentang Kami"]);
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
     * @param  \App\Models\ITSupport  $iTSupport
     * @return \Illuminate\Http\Response
     */
    public function show(ITSupport $iTSupport)
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
