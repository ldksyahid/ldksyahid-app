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

        if ($request->ajax()) {
            return response()->json([
                'tableBody' => view('admin-page.finance-report.components._index._index-table', compact('financeReports'))->render(),
                'pagination' => $financeReports->appends($request->query())->links()->render(),
                'total' => $financeReports->total(),
                'from' => $financeReports->firstItem(),
                'to' => $financeReports->lastItem()
            ]);
        }

        return view('admin-page.finance-report.index', compact('financeReports', 'ldkTags'))
            ->with('title', 'Finance Reports');
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function showAdmin(MsCatalogBook $book)
    {

    }

    public function edit(MsCatalogBook $book)
    {

    }

    public function update(Request $request, MsCatalogBook $book)
    {

    }

    public function destroy(MsCatalogBook $book)
    {

    }

    public function bulkDelete(Request $request)
    {

    }
}
