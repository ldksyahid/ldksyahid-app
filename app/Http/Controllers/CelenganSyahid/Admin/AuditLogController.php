<?php

namespace App\Http\Controllers\CelenganSyahid\Admin;

use App\Http\Controllers\Controller;
use App\Models\CelsyahidAuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function indexAuditLog(Request $request)
    {
        $query = CelsyahidAuditLog::with('user');

        if ($request->filled('action_type')) {
            $query->where('action', 'like', '%' . $request->input('action_type') . '%');
        }

        if ($request->filled('entity_type')) {
            $query->where('entity_type', $request->input('entity_type'));
        }

        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->input('search') . '%');
        }

        $logs = $query->orderBy('created_at', 'desc')
            ->paginate(20)
            ->appends($request->query());

        $stats = [
            'total'  => CelsyahidAuditLog::count(),
            'create' => CelsyahidAuditLog::where('action', 'like', '%create%')->count(),
            'update' => CelsyahidAuditLog::where('action', 'like', '%update%')->count(),
            'delete' => CelsyahidAuditLog::where('action', 'like', '%delete%')->count(),
        ];

        if ($request->ajax()) {
            return response()->json([
                'tableBody' => view('admin-page.service.celengan-syahid.audit-log.components._table-rows', compact('logs'))->render(),
                'pagination' => [
                    'from'         => $logs->firstItem() ?? 0,
                    'to'           => $logs->lastItem() ?? 0,
                    'total'        => $logs->total(),
                    'current_page' => $logs->currentPage(),
                    'last_page'    => $logs->lastPage(),
                    'base_url'     => $logs->url(1),
                ],
                'stats' => $stats,
            ]);
        }

        return view('admin-page.service.celengan-syahid.audit-log.index', [
            'logs'  => $logs,
            'stats' => $stats,
            'title' => 'Celengan Syahid',
        ]);
    }
}
