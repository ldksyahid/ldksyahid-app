<?php

namespace App\Http\Controllers;

use App\Models\LkReport;
use App\Models\MsFinanceReport;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = LkReport::orderBy('createdDate', 'desc')->paginate(12);

        return view('landing-page.report.index', compact('reports'))
            ->with('title', 'Lainnya');
    }

    public function financeReport(Request $request)
    {
        $reports = MsFinanceReport::getReports();

        return view('landing-page.report.finance-report.index', compact('reports'))
            ->with('title', 'Lainnya');
    }
}
