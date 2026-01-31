<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\LibraryFunctionController as LFC;

class UserController extends Controller
{
    /* =========================================================================
       SECTION — ADMIN AREA (with RESTful routing)
       ========================================================================= */

    /**
     * Display a listing of users (Admin Index)
     */
    public function indexAdmin(Request $request)
    {
        $users = User::searchAdminUsers($request);
        $roles = User::getRoles();
        $tableConfig = User::getTableConfig();

        if ($request->ajax()) {
            return response()->json([
                'tableBody' => view('components.admin-index.index-table', [
                    'items' => $users,
                    'tableConfig' => $tableConfig,
                ])->render(),
                'pagination' => $users->appends($request->query())->links()->render(),
                'total' => $users->total(),
                'from' => $users->firstItem(),
                'to' => $users->lastItem()
            ]);
        }

        return view('admin-page.user.index', compact('users', 'roles', 'tableConfig'))
            ->with('title', 'User');
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin-page.user.create', compact('roles'))
            ->with('title', 'Create User');
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $result = User::saveModel($request);

        if ($request->ajax()) {
            if (!$result['success']) {
                return response()->json(['error' => $result['errors']]);
            }
            return response()->json([
                'success' => true,
                'message' => $result['message']
            ]);
        }

        if (!$result['success']) {
            return redirect()->back()
                ->withInput()
                ->withErrors($result['errors']);
        }

        return redirect()->route('admin.user.index')
            ->with('success', $result['message']);
    }

    /**
     * Display the specified user (Admin Preview)
     */
    public function showAdmin($id)
    {
        $user = User::findOrFail($id);
        $roleName = LFC::getRoleName($user->getRoleNames()) ?? 'User';

        return view('admin-page.user.view', compact('user', 'roleName'))
            ->with('title', 'View User');
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        if ($user->isProtected()) {
            return redirect()->route('admin.user.index')
                ->with('error', "You can't edit this protected account.");
        }

        $roles = Role::all();
        $currentRole = LFC::getRoleName($user->getRoleNames());

        return view('admin-page.user.update', compact('user', 'roles', 'currentRole'))
            ->with('title', 'Edit User');
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $result = $user->updateModel($request);

        if ($request->ajax()) {
            if (!$result['success']) {
                return response()->json(['error' => $result['errors']]);
            }
            return response()->json([
                'success' => true,
                'message' => $result['message']
            ]);
        }

        if (!$result['success']) {
            return redirect()->back()
                ->withInput()
                ->withErrors($result['errors']);
        }

        return redirect()->route('admin.user.index')
            ->with('success', $result['message']);
    }

    /**
     * Remove the specified user
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $result = $user->deleteModel();

            return response()->json($result, $result['success'] ? 200 : 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting user: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk delete users
     */
    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);

            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No users selected for deletion'
                ], 400);
            }

            $result = User::bulkDeleteModel($ids);

            return response()->json($result, $result['success'] ? 200 : 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting users: ' . $e->getMessage()
            ], 500);
        }
    }
}
