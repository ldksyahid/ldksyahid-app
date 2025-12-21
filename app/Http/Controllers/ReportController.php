<?php

namespace App\Http\Controllers;

use App\Models\LkReport;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $reports = LkReport::orderBy('createdDate', 'desc')->get();

        return view('landing-page.report.index', compact('reports'))
            ->with('title', 'Lainnya');
    }
}
