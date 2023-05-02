<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReqShortlink;
use RealRashid\SweetAlert\Facades\Alert;

class RequestShortlinkController extends Controller
{

    public function index()
    {
        $data = ReqShortlink::orderBy('created_at','desc')->get();
        return view('admin-page.service-request.short-link.index')->with([
            'data' => $data,
            "title" => "Request Services"
        ]);
    }

    public function read()
    {
        $data = ReqShortlink::orderBy('created_at','desc')->get();
        return view('admin-page.service-request.short-link.read')->with([
            'data' => $data,
            "title" => "Request Services"
        ]);
    }

    public function create()
    {
        return view('landing-page.service.short-link.index', ["title" => "Layanan"]);
    }

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

    public function show($id)
    {
        $data = ReqShortlink::findOrFail($id);
        return view('admin-page.service-request.short-link.view')->with([
            'data' => $data,
            "title" => "Request Services"
        ]);
    }

    public function addFixCustomLinkEdit($id)
    {
        $data = ReqShortlink::findOrFail($id);
        return view('admin-page.service-request.short-link.add-custom-link')->with([
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

    public function destroy($id)
    {
        $data = ReqShortlink::findOrFail($id);
        $data->delete();
    }
}
