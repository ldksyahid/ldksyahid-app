<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\LibraryFunctionController as LFC;



class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }



    public function login(Request $request)
    {
        $input = $request->only('email', 'password');

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->has('remember');

        if (auth()->attempt($input, $remember)) {
            if (LFC::cekRoleAdmin(auth()->user())) {
                return redirect()->route('admin');
            } else {
                return redirect()->back();
            }
        } else {
            Alert::error('Tidak Berhasil Masuk', 'Coba Lagi, Email dan Password Belum Benar');
            return redirect()->route('login');
        }
    }

    public function showLoginForm()
    {
        $title = 'Masuk';

        return view('auth.login', compact('title'));
    }
}
