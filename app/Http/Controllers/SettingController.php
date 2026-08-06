<?php

namespace App\Http\Controllers;

use App\Models\MsSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $grouped = MsSetting::getAllGrouped();

        return view('admin-page.setting.index', compact('grouped'))
            ->with('title', 'Setting');
    }

    public function update(Request $request)
    {
        $affected = MsSetting::updateByKey(
            $request->input('key1', ''),
            $request->input('key2', ''),
            $request->input('value1', ''),
            $request->input('value2', '')
        );

        if ($affected === 0) {
            return response()->json([
                'success' => false, 
                'message' => 'Gagal memperbarui setting: Key tidak ditemukan atau data tidak berubah.'
            ], 400);
        }

        return response()->json([
            'success' => true, 
            'message' => 'Setting updated.'
        ]);
    }
}