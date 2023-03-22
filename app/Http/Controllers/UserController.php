<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\LibraryFunctionController as LFC;
class UserController extends Controller
{
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

    public function create()
    {
        return view('AdminPageView.AdminPageViewUsers.adminpageviewuserscreate', ["title" => "User"]);
    }

    public function store(Request $request)
    {
        $roleName = Role::where('name', $request['roleName'])->first();

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        $user->assignRole($roleName);

        Alert::success('Success', 'User created successfully !');
    }

    public function edit($id)
    {
        $dataUser = User::findOrFail($id);
        return view('AdminPageView.AdminPageViewUsers.adminpageviewusersedit')->with([
            'dataUser' => $dataUser,
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

    public function update(Request $request, $id)
    {   $roleName = Role::where('name', $request['roleName'])->first();
        $data = User::findOrFail($id);
        $dataRoleName =  LFC::getRoleName($data->getRoleNames());
        if ($dataRoleName != null) {
            $data->removeRole($dataRoleName);
        }
        $data->name = $request->name;
        $data->email = $request->email;
        if ($request->password != null) {
            $data->password = Hash::make($request->password);
        }
        $data['updated_at'] = date("Y-m-d H:i:s");
        $data->save();
        $data->assignRole($roleName);
        toast('User has been edited !', 'success')->autoClose(1500)->width('350px');
    }

    public function destroy($id)
    {
        $data = User::findOrFail($id);

        if ($data->id == 2) {
            Alert::error('Delete Failed', "^_^ Sory You Can't Delete Ucup ^_^");
            return redirect('/admin/user');
        } else {
            if ($data->profile == !null) {
                File::delete($data->profile->profilepicture);
            }
            $data->delete();
        }
    }
}

