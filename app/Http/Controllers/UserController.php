<?php

namespace App\Http\Controllers;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::all();
        return view('AdminPageView.AdminPageViewUsers.adminpageviewusers')->with([
            'data' => $data,
            "title" => "User"
        ]);
    }

    public function read()
    {
        $data = User::all();
        return view('AdminPageView.AdminPageViewUsers.adminpageviewusersread')->with([
            'data' => $data,
            "title" => "User"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AdminPageView.AdminPageViewUsers.adminpageviewuserscreate', ["title" => "User"]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $passwordcr = Hash::make($request->password);
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = $passwordcr;
        $data['is_admin'] = $request->boolean('is_admin');
        User::insert($data);
        Alert::success('Success', 'User created successfully !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = User::findOrFail($id);
        return view('AdminPageView.AdminPageViewUsers.adminpageviewusersedit')->with([
            'data' => $data,
            "title" => "User"
        ]);
    }

    public function preview($id)
    {
        $data = User::findOrFail($id);
        return view('AdminPageView.AdminPageViewUsers.adminpageviewuserspreview')->with([
            'data' => $data,
            "title" => "User"
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
        // $passwordcr = Hash::make($request->password);

        $data = User::findOrFail($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = $request->password;
        $data['is_admin'] = $request->boolean('is_admin');
        $data->save();
        toast('User has been edited !', 'success')->autoClose(1500)->width('350px');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = User::findOrFail($id);
        if ($data->profile == !null) {
            File::delete($data->profile->profilepicture);
        }
        $data->delete();

    }
}
