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

    private function denyAccess()
    {
        Alert::error('Access Denied', 'You do not have permission to access this feature.');
        return redirect()->route('admin.dashboard');
    }

    public function showSetup()
    {
        if (!TwoFaHelper::isAllowed(auth()->user())) {
            return $this->denyAccess();
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
            return $this->denyAccess();
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
            return $this->denyAccess();
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

    public function listUsers(\Illuminate\Http\Request $request)
    {
        if (!TwoFaHelper::isAllowed(auth()->user())) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Access denied.'], 403);
            }
            return $this->denyAccess();
        }

        $activeCount   = User::where('google2fa_enabled', true)->count();
        $inactiveCount = User::where('google2fa_enabled', false)->count();

        $query = User::select('id', 'name', 'email', 'google2fa_enabled', 'two_fa_enabled_at', 'two_fa_last_used_at', 'two_fa_last_used_ip')
            ->orderByDesc('google2fa_enabled')
            ->orderBy('name');

        if ($search = trim($request->input('search', ''))) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        if ($status = $request->input('status')) {
            $query->where('google2fa_enabled', $status === 'active');
        }

        $users = $query->paginate(15)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'tableBody'      => view('admin-page.security.two-factor.components._users-table', compact('users'))->render(),
                'total'          => $users->total(),
                'from'           => $users->firstItem() ?? 0,
                'to'             => $users->lastItem() ?? 0,
                'current_page'   => $users->currentPage(),
                'last_page'      => $users->lastPage(),
                'active_count'   => $activeCount,
                'inactive_count' => $inactiveCount,
            ]);
        }

        return view('admin-page.security.two-factor.users', [
            'users'         => $users,
            'activeCount'   => $activeCount,
            'inactiveCount' => $inactiveCount,
            'title'         => 'Security',
        ]);
    }

    /* ================================================================
       FORCE REVOKE — POST /admin/security/2fa/users/{id}/revoke
       ================================================================ */

    public function forceRevoke(\Illuminate\Http\Request $request, string $id)
    {
        if (!TwoFaHelper::isAllowed(auth()->user())) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Access denied.'], 403);
            }
            return $this->denyAccess();
        }

        $target = User::findOrFail($id);

        if (TwoFaHelper::isPrimaryAdmin($target)) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'The primary administrator\'s 2FA cannot be revoked.',
                ], 403);
            }
            Alert::error('Not Allowed', 'The primary administrator\'s 2FA cannot be revoked.');
            return redirect()->route('admin.security.2fa.users');
        }

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

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => '2FA has been revoked for ' . $target->name . '. They must set up 2FA again.',
            ]);
        }

        Alert::success('Done', '2FA has been revoked for ' . $target->name . '. They must set up 2FA again.');
        return redirect()->route('admin.security.2fa.users');
    }
}
