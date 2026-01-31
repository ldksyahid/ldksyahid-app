<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (UnauthorizedException $e, $request) {
            if (!auth()->check()) {
                alert()->info('Maaf', 'Harap Masuk Terlebih Dahulu!')->showConfirmButton('Ok', '#00a79d');
                return redirect()->route('login');
            }

            // User logged in but doesn't have the required role/permission
            alert()->error('Akses Ditolak', 'Anda tidak memiliki izin untuk mengakses halaman ini.')->showConfirmButton('Ok', '#00a79d');

            $user = auth()->user();
            if ($user->hasAnyRole(['Superadmin', 'HelperAdmin', 'HelperCelsyahid', 'HelperEventMart', 'HelperSPAM', 'HelperMedia', 'HelperLetter'])) {
                return redirect('/admin/dashboard');
            }

            return redirect()->back()->withInput();
        });
    }
}
