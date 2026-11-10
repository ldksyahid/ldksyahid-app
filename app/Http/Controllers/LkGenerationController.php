<?php

namespace App\Http\Controllers;

use App\Models\LkGeneration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LkGenerationController extends Controller
{
    /**
     * Display a listing of generations for the admin panel.
     */
    public function indexAdmin(Request $request)
    {
        $generations = LkGeneration::searchAdminGeneration($request);
        $tableConfig = LkGeneration::getTableConfig();

        if ($request->ajax()) {
            return response()->json([
                'tableBody' => view('components.admin-index.index-table', [
                    'items' => $generations,
                    'tableConfig' => $tableConfig,
                ])->render(),
                'pagination' => $generations->appends($request->query())->links()->render(),
                'total' => $generations->total(),
                'from' => $generations->firstItem(),
                'to' => $generations->lastItem(),
            ]);
        }

        return view('admin-page.master.generation.index', compact('generations', 'tableConfig'))
            ->with('title', 'Master Generation');
    }

    /**
     * Store a newly created generation in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'year'           => 'required|digits:4|unique:lk_generation,year',
            'generationName' => 'required|string|max:100',
        ], [
            'year.required'           => 'Year is required.',
            'year.digits'             => 'Year must be a 4-digit number (e.g. 2026).',
            'year.unique'             => 'This year already exists in master generations.',
            'generationName.required' => 'Generation name is required.',
            'generationName.max'      => 'Generation name may not be greater than 100 characters.',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                    'errors'  => $validator->errors(),
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $generation = LkGeneration::create([
            'year'           => trim($request->year),
            'generationName' => trim($request->generationName),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Generation '{$generation->generationName}' ({$generation->year}) created successfully.",
                'data'    => $generation,
            ]);
        }

        return redirect()->route('admin.master.generation.index')
            ->with('success', "Generation '{$generation->generationName}' ({$generation->year}) created successfully.");
    }

    /**
     * Show generation details (used by AJAX for edit modal).
     */
    public function edit($id)
    {
        $generation = LkGeneration::withCount('getKtaData')->findOrFail($id);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'data'    => $generation,
            ]);
        }

        return redirect()->route('admin.master.generation.index');
    }

    /**
     * Update the specified generation in storage.
     */
    public function update(Request $request, $id)
    {
        $generation = LkGeneration::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'year'           => 'required|digits:4|unique:lk_generation,year,' . $id,
            'generationName' => 'required|string|max:100',
        ], [
            'year.required'           => 'Year is required.',
            'year.digits'             => 'Year must be a 4-digit number (e.g. 2026).',
            'year.unique'             => 'This year already exists in master generations.',
            'generationName.required' => 'Generation name is required.',
            'generationName.max'      => 'Generation name may not be greater than 100 characters.',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                    'errors'  => $validator->errors(),
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $generation->update([
            'year'           => trim($request->year),
            'generationName' => trim($request->generationName),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Generation '{$generation->generationName}' ({$generation->year}) updated successfully.",
                'data'    => $generation,
            ]);
        }

        return redirect()->route('admin.master.generation.index')
            ->with('success', "Generation '{$generation->generationName}' ({$generation->year}) updated successfully.");
    }

    /**
     * Remove the specified generation from storage.
     */
    public function destroy($id)
    {
        $generation = LkGeneration::withCount('getKtaData')->findOrFail($id);

        if ($generation->get_kta_data_count > 0) {
            return response()->json([
                'success' => false,
                'message' => "Cannot delete Generation '{$generation->generationName}' ({$generation->year}) because it is used by {$generation->get_kta_data_count} KTA member card(s).",
            ], 422);
        }

        $generationName = $generation->generationName;
        $generationYear = $generation->year;
        $generation->delete();

        return response()->json([
            'success' => true,
            'message' => "Generation '{$generationName}' ({$generationYear}) deleted successfully.",
        ]);
    }

    /**
     * Bulk delete generations.
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids) || !is_array($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'No generations selected.',
            ], 400);
        }

        $inUse = LkGeneration::whereIn('id', $ids)
            ->has('getKtaData')
            ->withCount('getKtaData')
            ->get();

        if ($inUse->isNotEmpty()) {
            $inUseNames = $inUse->map(fn($g) => "'{$g->generationName}' ({$g->get_kta_data_count} KTA members)")->implode(', ');
            return response()->json([
                'success' => false,
                'message' => "Cannot delete the following generation(s) because they are in use: {$inUseNames}.",
            ], 422);
        }

        $deletedCount = LkGeneration::whereIn('id', $ids)->delete();

        return response()->json([
            'success' => true,
            'message' => "{$deletedCount} generation(s) deleted successfully.",
        ]);
    }
}
