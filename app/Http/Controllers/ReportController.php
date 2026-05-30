<?php

namespace App\Http\Controllers;

use App\Constants\SettingKey\Key1;
use App\Constants\SettingKey\Key2;
use App\Models\LkReport;
use App\Models\MsFinanceReport;
use App\Models\MsSetting;
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

        $cpName  = MsSetting::getSettingValue1(Key1::LAPORAN_KEUANGAN, Key2::CpFinanceReportName)
                   ?? 'Kestari LDK Syahid';
        $cpPhone = MsSetting::getSettingValue1(Key1::LAPORAN_KEUANGAN, Key2::CpFinanceReportPhone)
                   ?? '';

        return view('landing-page.report.finance-report.index', compact('reports', 'cpName', 'cpPhone'))
            ->with('title', 'Lainnya');
    }
}
