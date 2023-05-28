<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CallKestari;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class CallKestariController extends Controller
{
    public function index()
    {
        $data = CallKestari::all();
        return view('landing-page.service.call-kestari.index')->with([
            'data' => $data,
            "title" => "Layanan"
        ]);
    }

    public function indexadmin()
    {
        $data = CallKestari::all();
        return view('admin-page.service.call-kestari.index')->with([
            'data' => $data,
            "title" => "Service"
        ]);
    }

    public function read()
    {
        $data = CallKestari::all();
        return view('admin-page.service.call-kestari.read')->with([
            'data' => $data,
            "title" => "Service"
        ]);
    }

    public function create()
    {
        return view('admin-page.service.call-kestari.create', ["title" => "Service"]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'buttonName' => 'required',
            'link' => 'required',
        ]);

        if ($validator->passes()) {
            $data['buttonName'] = $request->buttonName;
            $data['appear'] = 'Up';
            $data['link'] = $request->link;
            CallKestari::insert($data);
            Alert::success('Success', 'Call Kestari created successfully !');
        }

        return response()->json(['error'=>$validator->errors()->all()]);
    }

    public function edit($id)
    {
        $data = CallKestari::findOrFail($id);
        return view('admin-page.service.call-kestari.update')->with([
            'data' => $data,
            "title" => "Service"
        ]);
    }

    public function showInAdmin($id)
    {
        $data = CallKestari::findOrFail($id);
        return view('admin-page.service.call-kestari.view')->with([
            'data' => $data,
            "title" => "Service"
        ]);
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'buttonName' => 'required',
            'link' => 'required',
        ]);

        if ($validator->passes()) {
            $data = CallKestari::findOrFail($id);
            $data['buttonName'] = $request->buttonName;
            $data['appear'] = 'Up';
            $data['link'] = $request->link;
            $data->save();
            toast('Call Kestari has been updated !', 'success')->autoClose(1500)->width('350px');
        }

        return response()->json(['error'=>$validator->errors()->all()]);
    }

    public function destroy($id)
    {
        $data = CallKestari::findOrFail($id);
        $data->delete();
    }
}
