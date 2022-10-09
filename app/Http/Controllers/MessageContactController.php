<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MessageContact;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class MessageContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MessageContact::all();
        return view('AdminPageView.AdminPageViewAboutUs.AdminPageViewAboutUsContactUs.adminpageviewaboutuscontactus')->with([
            'data' => $data,
            "title" => "About Us"
        ]);
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
         // dd($request->all());
        $messagecontact = MessageContact::create([
            "name" => $request->name,
            "email" => $request->email,
            "subject" => $request->subject,
            "message" => $request->message,
        ]);
        Alert::success('Pesan Kamu Berhasil Dikirim', 'Terimakasih, Kami akan Menindaklanjuti Pesan kamu secepatnya!')->autoClose(5000)->width('40%');
        return redirect('/about/contact');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = MessageContact::findOrFail($id);
        return view('AdminPageView.AdminPageViewAboutUs.AdminPageViewAboutUsContactUs.adminpageviewaboutuscontactuspreview')->with([
            'data' => $data,
            "title" => "About Us"
        ]);
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
        $data = MessageContact::findOrFail($id);
        $data->delete();
    }
}
