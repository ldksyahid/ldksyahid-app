<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\LibraryFunctionController as LFC;
use Exception;

class GoogleController extends Controller
{
    /**
     * Arahkan user ke halaman login Google.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Tangani callback dari Google setelah login/registrasi.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Exception $e) { // @phpstan-ignore-line
            return redirect()->route('login')
                ->with('error', 'Gagal login dengan Google. Silakan coba lagi.');
        }

        // Cari user berdasarkan googleID dulu
        $user = User::where('googleID', $googleUser->getId())->first();

        if ($user) {
            // User sudah terhubung dengan Google → langsung login
            Auth::login($user, true);
            return $this->redirectAfterLogin($user);
        }

        // Cari berdasarkan email (user sudah ada tapi belum link Google)
        $existingUser = User::where('email', $googleUser->getEmail())->first();

        if ($existingUser) {
            // Link Google account to existing user
            $existingUser->update(['googleID' => $googleUser->getId()]);

            // Save avatar to profile if not already set
            if ($existingUser->profile) {
                if (!$existingUser->profile->googleAvatar) {
                    $existingUser->profile->update(['googleAvatar' => $googleUser->getAvatar()]);
                }
            } else {
                Profile::create([
                    'user_id'     => $existingUser->id,
                    'googleAvatar' => $googleUser->getAvatar(),
                ]);
            }

            Auth::login($existingUser, true);
            return $this->redirectAfterLogin($existingUser);
        }

        // New user → create account automatically
        $userRole = Role::where('name', 'User')->first();

        $newUser = User::create([
            'name'              => $googleUser->getName(),
            'email'             => $googleUser->getEmail(),
            'googleID'          => $googleUser->getId(),
            'password'          => null,
            'email_verified_at' => now(),
        ]);

        if ($userRole) {
            $newUser->assignRole($userRole);
        }

        // Create profile with Google avatar
        Profile::create([
            'user_id'      => $newUser->id,
            'googleAvatar' => $googleUser->getAvatar(),
        ]);

        Auth::login($newUser, true);
        return $this->redirectAfterLogin($newUser);
    }

    /**
     * Tentukan redirect setelah login berdasarkan role.
     */
    private function redirectAfterLogin(User $user)
    {
        if (LFC::cekRoleAdmin($user)) {
            return redirect()->route('admin');
        }

        return redirect()->intended('/');
    }
}
