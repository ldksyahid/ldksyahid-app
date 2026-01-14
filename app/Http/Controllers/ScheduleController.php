<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use RealRashid\SweetAlert\Facades\Alert;

class ScheduleController extends Controller
{
    /**
     * Display a listing of schedules (Landing Page)
     */
    public function index()
    {
        $postschedule = Schedule::orderBy('created_at', 'desc')->get();
        return view('landing-page.schedule.index', compact('postschedule'), ["title" => "Lainnya"]);
    }

    /**
     * Display a listing of schedules (Admin Index)
     */
    public function indexAdmin(Request $request)
    {
        $items = Schedule::searchAdminSchedules($request);
        $tableConfig = Schedule::getTableConfig();

        if ($request->ajax()) {
            return response()->json([
                'tableBody' => view('components.admin-index.index-table', [
                    'items' => $items,
                    'tableConfig' => $tableConfig,
                ])->render(),
                'pagination' => $items->appends($request->query())->links()->render(),
                'total' => $items->total(),
                'from' => $items->firstItem(),
                'to' => $items->lastItem()
            ]);
        }

        return view('admin-page.schedule.index', compact('items', 'tableConfig'))
            ->with('title', 'Schedule');
    }

    /**
     * Show the form for creating a new schedule
     */
    public function create()
    {
        return view('admin-page.schedule.create')
            ->with('title', 'Schedule');
    }

    /**
     * Store a newly created schedule
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'month' => 'required|string|max:255',
            'year' => 'required|string|max:10',
            'picture' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        try {
            Schedule::saveModel($request);
            Alert::success('Success', 'Schedule has been created!');
            return redirect()->route('admin.schedule.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to create schedule: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified schedule (Admin Preview)
     */
    public function showAdmin($id)
    {
        $schedule = Schedule::findOrFail($id);

        return view('admin-page.schedule.view', compact('schedule'))
            ->with('title', 'Schedule');
    }

    /**
     * Show the form for editing the specified schedule
     */
    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);

        return view('admin-page.schedule.update', compact('schedule'))
            ->with('title', 'Schedule');
    }

    /**
     * Update the specified schedule
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'month' => 'required|string|max:255',
            'year' => 'required|string|max:10',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        try {
            $schedule = Schedule::findOrFail($id);
            $schedule->updateModel($request);
            Alert::success('Success', 'Schedule has been updated!');
            return redirect()->route('admin.schedule.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to update schedule: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified schedule
     */
    public function destroy($id)
    {
        try {
            $schedule = Schedule::findOrFail($id);
            $schedule->deleteModel();

            return response()->json([
                'success' => true,
                'message' => 'Schedule has been deleted!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting schedule: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk delete schedules
     */
    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);

            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No schedules selected for deletion'
                ], 400);
            }

            $deleted = Schedule::bulkDeleteModel($ids);

            return response()->json([
                'success' => true,
                'message' => "{$deleted} schedule(s) have been deleted!"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting schedules: ' . $e->getMessage()
            ], 500);
        }
    }
}
