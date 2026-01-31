<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;

class EventController extends Controller
{
    /* =========================================================================
       SECTION A — LANDING PAGE (Public)
       ========================================================================= */

    public function index()
    {
        $postevent = Event::orderBy('start', 'desc')->get();
        return view('landing-page.event.index', compact('postevent'), ["title" => "Kegiatan"]);
    }

    public function show($id)
    {
        $postevent = Event::find($id);
        return view('landing-page.event.detail', compact('postevent'), ["title" => "Kegiatan"]);
    }

    /* =========================================================================
       SECTION B — ADMIN AREA (with RESTful routing)
       ========================================================================= */

    public function indexAdmin(Request $request)
    {
        $events = Event::searchAdminEvents($request);
        $divisions = Event::getDivisions();
        $tableConfig = Event::getTableConfig();

        if ($request->ajax()) {
            return response()->json([
                'tableBody' => view('components.admin-index.index-table', [
                    'items' => $events,
                    'tableConfig' => $tableConfig,
                ])->render(),
                'pagination' => $events->appends($request->query())->links()->render(),
                'total' => $events->total(),
                'from' => $events->firstItem(),
                'to' => $events->lastItem()
            ]);
        }

        return view('admin-page.event.index', compact('events', 'divisions', 'tableConfig'))
            ->with('title', 'Events');
    }

    public function create()
    {
        return view('admin-page.event.create')
            ->with('title', 'Create Event');
    }

    public function store(Request $request)
    {
        try {
            Event::saveModel($request);

            return redirect()->route('admin.event.index')
                ->with('success', 'Event has been created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('failed', true)
                ->withErrors(['error' => 'Error creating event: ' . $e->getMessage()]);
        }
    }

    public function showAdmin($id)
    {
        $event = Event::findOrFail($id);
        return view('admin-page.event.view', compact('event'))
            ->with('title', 'View Event');
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('admin-page.event.update', compact('event'))
            ->with('title', 'Edit Event');
    }

    public function update(Request $request, $id)
    {
        try {
            $event = Event::findOrFail($id);
            $event->updateModel($request);

            return redirect()->route('admin.event.index')
                ->with('success', 'Event has been updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('failed', true)
                ->withErrors(['error' => 'Error updating event: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $event = Event::findOrFail($id);
            $event->deleteModel();

            return response()->json([
                'success' => true,
                'message' => 'Event has been deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting event: ' . $e->getMessage()
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
                    'message' => 'No events selected for deletion'
                ], 400);
            }

            Event::bulkDeleteModel($ids);

            return response()->json([
                'success' => true,
                'message' => 'Selected events have been deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting events: ' . $e->getMessage()
            ], 500);
        }
    }
}
