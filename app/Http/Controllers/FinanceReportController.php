<?php

namespace App\Http\Controllers;

use App\Models\MsCatalogBook;
use App\Models\LkLDK;
use App\Models\MsFinanceReport;
use Illuminate\Http\Request;

class FinanceReportController extends Controller
{
    /* =========================================================================
       SECTION B — ADMIN AREA (with RESTful routing)
       ========================================================================= */
    public function indexAdmin(Request $request)
    {
        $financeReports = MsFinanceReport::searchAdminFinanceReport($request);
        $ldkTags = LkLDK::orderBy('ldkTag')->pluck('ldkTag')->unique();
        $tableConfig = MsFinanceReport::getTableConfig();

        if ($request->ajax()) {
            return response()->json([
                'tableBody' => view('components.admin-index.index-table', [
                    'items' => $financeReports,
                    'tableConfig' => $tableConfig,
                ])->render(),
                'pagination' => $financeReports->appends($request->query())->links()->render(),
                'total' => $financeReports->total(),
                'from' => $financeReports->firstItem(),
                'to' => $financeReports->lastItem()
            ]);
        }

        return view('admin-page.finance-report.index', compact('financeReports', 'ldkTags', 'tableConfig'))
            ->with('title', 'Reports');
    }

    public function create()
    {
        $ldkTags = LkLDK::orderBy('ldkTag')->get();
        return view('admin-page.finance-report.create', compact('ldkTags'))
            ->with('title', 'Add Finance Report');
    }

    public function store(Request $request)
    {
        $validated = MsFinanceReport::validateRequest($request);

        try {
            MsFinanceReport::saveModel($request);

            return redirect()->route('admin.finance-report.index')
                ->with('success', 'Finance report has been added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('failed', true)
                ->withErrors(['error' => 'Error adding finance report: ' . $e->getMessage()]);
        }
    }

    public function showAdmin(MsFinanceReport $financeReport)
    {
        $financeReport->load('ldk');
        $ldkTags = LkLDK::orderBy('ldkTag')->get();
        return view('admin-page.finance-report.view', compact('financeReport', 'ldkTags'))
            ->with('title', 'View Finance Report');
    }

    public function edit(MsFinanceReport $financeReport)
    {
        $ldkTags = LkLDK::orderBy('ldkTag')->get();
        return view('admin-page.finance-report.edit', compact('financeReport', 'ldkTags'))
            ->with('title', 'Edit Finance Report');
    }

    public function update(Request $request, MsFinanceReport $financeReport)
    {
        $validated = MsFinanceReport::validateRequest($request, $financeReport->financeReportID);

        try {
            $financeReport->updateModel($request);

            return redirect()->route('admin.finance-report.index')
                ->with('success', 'Finance report has been updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('failed', true)
                ->withErrors(['error' => 'Error updating finance report: ' . $e->getMessage()]);
        }
    }

    public function destroy(MsFinanceReport $financeReport)
    {
        try {
            $financeReport->deleteModel();

            return response()->json([
                'success' => true,
                'message' => 'Finance report has been deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting finance report: ' . $e->getMessage()
            ], 500);
        }
    }

    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);

            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No reports selected for deletion'
                ], 400);
            }

            MsFinanceReport::bulkDeleteModel($ids);

            return response()->json([
                'success' => true,
                'message' => 'Selected finance reports have been deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting finance reports: ' . $e->getMessage()
            ], 500);
        }
    }
}
