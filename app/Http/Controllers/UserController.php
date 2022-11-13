<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use \Yajra\Datatables\Datatables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        // $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                        $btn = '
                        <button class="btn btn-sm btn-primary" onClick="edit({{ $item->id }})"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-sm btn-primary" onClick="destroyuser({{ $item->id }})"><i class="fa fa-trash"></i></button>
                        <button class="btn btn-sm btn-primary" onClick="preview({{ $item->id }})"><i class="fa fa-eye"></i></button>
                        ';
                        // $btn = '
                        // <a class="btn btn-sm btn-primary" onClick="preview({{ $item->id }})"><i class="fa fa-eye"></i></a>
                        // ';

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('AdminPageView.AdminPageViewUsers.adminpageviewusers')->with(["title" => "User"]);
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
        $passwordcr = Hash::make($request->password);
        $data = User::findOrFail($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = $passwordcr;
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

// BACKUP START
// class UserController extends Controller
// {
//     /**
//      * Display a listing of the resource.
//      *
//      * @return \Illuminate\Http\Response
//      */
//     public function index()
//     {
//         $data = User::all();
//         return view('AdminPageView.AdminPageViewUsers.adminpageviewusers')->with([
//             'data' => $data,
//             "title" => "User"
//         ]);
//     }

//     public function read()
//     {
//         $data = User::all();
//         return view('AdminPageView.AdminPageViewUsers.adminpageviewusersread')->with([
//             'data' => $data,
//             "title" => "User"
//         ]);
//     }

//     /**
//      * Show the form for creating a new resource.
//      *
//      * @return \Illuminate\Http\Response
//      */
//     public function create()
//     {
//         return view('AdminPageView.AdminPageViewUsers.adminpageviewuserscreate', ["title" => "User"]);
//     }

//     /**
//      * Store a newly created resource in storage.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @return \Illuminate\Http\Response
//      */
//     public function store(Request $request)
//     {
//         $passwordcr = Hash::make($request->password);
//         $data['name'] = $request->name;
//         $data['email'] = $request->email;
//         $data['password'] = $passwordcr;
//         $data['is_admin'] = $request->boolean('is_admin');
//         User::insert($data);
//         Alert::success('Success', 'User created successfully !');
//     }

//     /**
//      * Display the specified resource.
//      *
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function show($id)
//     {
//         //
//     }

//     /**
//      * Show the form for editing the specified resource.
//      *
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function edit($id)
//     {
//         $data = User::findOrFail($id);
//         return view('AdminPageView.AdminPageViewUsers.adminpageviewusersedit')->with([
//             'data' => $data,
//             "title" => "User"
//         ]);
//     }

//     public function preview($id)
//     {
//         $data = User::findOrFail($id);
//         return view('AdminPageView.AdminPageViewUsers.adminpageviewuserspreview')->with([
//             'data' => $data,
//             "title" => "User"
//         ]);
//     }


//     /**
//      * Update the specified resource in storage.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function update(Request $request, $id)
//     {
//         // $passwordcr = Hash::make($request->password);
//         // $data = User::findOrFail($id);
//         // $passwordcr = Hash::make($request->password);
//         // $data['name'] = $request->name;
//         // $data['email'] = $request->email;
//         // $data['password'] = $passwordcr;
//         // $data['is_admin'] = $request->boolean('is_admin');
//         // User::save($data);
//         // toast('User has been edited !', 'success')->autoClose(1500)->width('350px');

//         $passwordcr = Hash::make($request->password);
//         $data = User::findOrFail($id);
//         $data->name = $request->name;
//         $data->email = $request->email;
//         $data->password = $passwordcr;
//         $data['is_admin'] = $request->boolean('is_admin');
//         $data->save();
//         toast('User has been edited !', 'success')->autoClose(1500)->width('350px');
//     }

//     /**
//      * Remove the specified resource from storage.
//      *
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function destroy($id)
//     {
//         $data = User::findOrFail($id);

//         if ($data->id == 2) {
//             Alert::error('Delete Failed', "^_^ Sory You Can't Delete Ucup ^_^");
//             return redirect('/admin/user');
//         } else {
//             if ($data->profile == !null) {
//                 File::delete($data->profile->profilepicture);
//             }
//             $data->delete();
//         }
//     }
// }
// BACKUP END
