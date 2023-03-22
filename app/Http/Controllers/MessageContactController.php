<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MessageContact;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class MessageContactController extends Controller
{
    public function index()
    {
        $data = MessageContact::all();
        return view('AdminPageView.AdminPageViewAboutUs.AdminPageViewAboutUsContactUs.adminpageviewaboutuscontactus')->with([
            'data' => $data,
            "title" => "About Us"
        ]);
    }

    public function store(Request $request)
    {
        $messagecontact = MessageContact::create([
            "name" => $request->name,
            "email" => $request->email,
            "subject" => $request->subject,
            "message" => $request->message,
        ]);
        Alert::success('Pesan Kamu Berhasil Dikirim', 'Terimakasih, Kami akan Menindaklanjuti Pesan kamu secepatnya!')->autoClose(5000)->width('40%');
        return redirect()->back();
    }

    public function show($id)
    {
        $data = MessageContact::findOrFail($id);
        return view('AdminPageView.AdminPageViewAboutUs.AdminPageViewAboutUsContactUs.adminpageviewaboutuscontactuspreview')->with([
            'data' => $data,
            "title" => "About Us"
        ]);
    }

    public function destroy($id)
    {
        $data = MessageContact::findOrFail($id);
        $data->delete();
    }
}
