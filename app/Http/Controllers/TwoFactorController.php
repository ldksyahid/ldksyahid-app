<?php

namespace App\Http\Controllers;

use App\Helpers\TwoFaHelper;
use App\Models\CelsyahidAuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use PragmaRX\Google2FA\Google2FA;
use RealRashid\SweetAlert\Facades\Alert;

class TwoFactorController extends Controller
{
    /* ================================================================
       SETUP — GET /admin/security/2fa
       ================================================================ */

    public function showSetup()
    {
        if (!TwoFaHelper::isAllowed(auth()->user())) {
            abort(403);
        }

        $user = auth()->user();

        if ($user->google2fa_enabled) {
            return view('admin-page.security.two-factor.setup', [
                'enabled' => true,
                'user'    => $user,
                'title'   => 'Security',
            ]);
        }

        // Generate fresh secret and store in session for this setup flow
        $secret = session('2fa_setup_secret') ?? TwoFaHelper::generateSecret();
        session(['2fa_setup_secret' => $secret]);

        $qrUrl  = TwoFaHelper::qrCodeUrl($user, $secret);
        $qrSvg  = TwoFaHelper::renderQrSvg($qrUrl);

        // Format secret in groups of 4 for readability
        $secretFormatted = implode(' ', str_split($secret, 4));

        return view('admin-page.security.two-factor.setup', [
            'enabled'         => false,
            'user'            => $user,
            'qrSvg'           => $qrSvg,
            'secretFormatted' => $secretFormatted,
            'title'           => 'Security',
        ]);
    }

    /* ================================================================
       ENABLE — POST /admin/security/2fa/enable
       ================================================================ */

    public function enable(Request $request)
    {
        if (!TwoFaHelper::isAllowed(auth()->user())) {
            abort(403);
        }

        $request->validate(['code' => 'required|digits:6']);

        $user   = auth()->user();
        $secret = session('2fa_setup_secret');

        if (!$secret) {
            Alert::error('Session Expired', 'Setup session expired. Please start again.');
            return redirect()->route('admin.security.2fa');
        }

        $google2fa = new Google2FA();
        $timestamp = $google2fa->verifyKeyNewer($secret, $request->code, null, 1);

        if ($timestamp === false) {
            Alert::error('Invalid Code', 'The code is incorrect. Please check your authenticator app and try again.');
            return redirect()->route('admin.security.2fa');
        }

        $user->update([
            'google2fa_secret'  => encrypt($secret),
            'google2fa_enabled' => true,
            'two_fa_last_ts'    => $timestamp,
            'two_fa_enabled_at' => now(),
        ]);

        session()->forget('2fa_setup_secret');

        CelsyahidAuditLog::record('2fa.setup', 'user', $user->id, 'User enabled 2FA successfully.');

        Alert::success('2FA Enabled', 'Two-Factor Authentication is now active on your account.');
        return redirect()->route('admin.security.2fa');
    }

    /* ================================================================
       DISABLE — POST /admin/security/2fa/disable
       ================================================================ */

    public function disable(Request $request)
    {
        if (!TwoFaHelper::isAllowed(auth()->user())) {
            abort(403);
        }

        $request->validate(['code' => 'required|digits:6']);

        $user = auth()->user();

        if (!TwoFaHelper::verify($user, $request->code)) {
            Alert::error('Invalid Code', 'The code is incorrect or expired. Please try again.');
            return redirect()->route('admin.security.2fa');
        }

        $user->update([
            'google2fa_secret'  => null,
            'google2fa_enabled' => false,
            'two_fa_last_ts'    => null,
        ]);

        CelsyahidAuditLog::record('2fa.disabled', 'user', $user->id, 'User disabled 2FA.');

        Alert::success('2FA Disabled', 'Two-Factor Authentication has been deactivated.');
        return redirect()->route('admin.security.2fa');
    }

    /* ================================================================
       VERIFY — POST /admin/security/2fa/verify (AJAX)
       ================================================================ */

    public function verify(Request $request)
    {
        if (!TwoFaHelper::isAllowed(auth()->user())) {
            return response()->json(['valid' => false, 'message' => 'Forbidden'], 403);
        }

        $request->validate(['code' => 'required|digits:6']);

        $user  = auth()->user();
        $valid = TwoFaHelper::verify($user, $request->code);

        if ($valid) {
            CelsyahidAuditLog::record('2fa.verify_success', 'user', $user->id, '2FA verified successfully from IP: ' . $request->ip());
        } else {
            $attempts = 5 - TwoFaHelper::rateLimitAttemptsLeft($user);
            CelsyahidAuditLog::record('2fa.verify_failed', 'user', $user->id, '2FA failed (attempt #' . $attempts . ') from IP: ' . $request->ip());
        }

        return response()->json([
            'valid'        => $valid,
            'attemptsLeft' => TwoFaHelper::rateLimitAttemptsLeft($user),
        ]);
    }

    /* ================================================================
       LIST USERS — GET /admin/security/2fa/users
       ================================================================ */

    public function listUsers()
    {
        if (!TwoFaHelper::isAllowed(auth()->user())) {
            abort(403);
        }

        $users = User::select('id', 'name', 'email', 'google2fa_enabled', 'two_fa_enabled_at', 'two_fa_last_used_at', 'two_fa_last_used_ip')
            ->get();

        return view('admin-page.security.two-factor.users', [
            'users' => $users,
            'title' => 'Security',
        ]);
    }

    /* ================================================================
       FORCE REVOKE — POST /admin/security/2fa/users/{id}/revoke
       ================================================================ */

    public function forceRevoke(string $id)
    {
        if (!TwoFaHelper::isAllowed(auth()->user())) {
            abort(403);
        }

        $target = User::findOrFail($id);

        $target->update([
            'google2fa_secret'  => null,
            'google2fa_enabled' => false,
            'two_fa_last_ts'    => null,
        ]);

        CelsyahidAuditLog::record(
            '2fa.force_revoke',
            'user',
            $target->id,
            'Superadmin ' . auth()->user()->name . ' force-revoked 2FA for: ' . $target->email
        );

        Alert::success('Done', '2FA has been revoked for ' . $target->name . '. They must set up 2FA again.');
        return redirect()->route('admin.security.2fa.users');
    }
}
