<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LkFaculty;
use App\Models\LkGeneration;
use App\Models\LkMajor;
use App\Models\MsKTALDKSyahid;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MsKTALDKSyahidController extends Controller
{
    public function indexAdmin()
    {
        $ktaData = MsKTALDKSyahid::with('getFaculty', 'getMajor', 'getGeneration')->orderBy('created_at', 'desc')->get();
        return view('admin-page.kta-ldksyahid.index', compact('ktaData'), ["title" => "KTA"]);
    }

    public function show($link)
    {
        $ktaData = MsKTALDKSyahid::where('linkProfile', $link)->with(['getFaculty', 'getMajor', 'getGeneration'])->orderBy('created_at', 'desc')->first();
        return view('landing-page.kta-ldksyahid.index', compact('ktaData'), ["title" => "KTA"]);
    }

    public function create()
    {
        $facultyModel = LkFaculty::pluck('facultyName', 'id');
        $generationModel = LkGeneration::pluck('generationName', 'id');
        return view('admin-page.kta-ldksyahid.create', compact(['facultyModel', 'generationModel']),  ["title" => "KTA"]);
    }

    public function store(Request $request)
    {
        MsKTALDKSyahid::createKTA($request);
        Alert::success('Success', 'KTA has been uploaded !');
        return redirect('/admin/ktaldksyahid');
    }

    public function preview($id)
    {
        $ktaData = MsKTALDKSyahid::with('getFaculty', 'getMajor', 'getGeneration')->find($id);
        return view('admin-page.kta-ldksyahid.view', compact('ktaData'), ["title" => "KTA"]);
    }

    public function edit($id)
    {
        $ktaData = MsKTALDKSyahid::with('getFaculty', 'getMajor', 'getGeneration')->find($id);
        $facultyModel = LkFaculty::pluck('facultyName', 'id');
        $generationModel = LkGeneration::pluck('generationName', 'id');
        return view('admin-page.kta-ldksyahid.update', compact(['ktaData', 'facultyModel', 'generationModel']), ["title" => "KTA"]);
    }

    public function update(Request $request, $id)
    {
        MsKTALDKSyahid::updateKTA($request, $id);
        Alert::success('Success', 'KTA has been updated !');
        return redirect('/admin/ktaldksyahid');
    }

    public function destroy($id)
    {
        MsKTALDKSyahid::destroyKTA($id);
        return redirect()->back();
    }

    public function getMajor(request $request)
    {
        $majorModel = LkMajor::where('facultyID', $request['id'])->pluck('majorName', 'id');
        return response()->json($majorModel);
    }
}
