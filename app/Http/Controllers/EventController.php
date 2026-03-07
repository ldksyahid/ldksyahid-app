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

    public function index(Request $request)
    {
        $query = Event::query();

        // Search by title or division
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('division', 'like', "%{$search}%");
            });
        }

        // Filter by division
        if ($request->filled('division')) {
            $query->whereIn('division', (array) $request->division);
        }

        // Filter by year (based on start date)
        if ($request->filled('year')) {
            $years_filter = (array) $request->year;
            $query->where(function ($q) use ($years_filter) {
                foreach ($years_filter as $yr) {
                    $q->orWhereYear('start', $yr);
                }
            });
        }

        // Filter by status (upcoming / ongoing / past)
        if ($request->filled('status')) {
            $statuses = (array) $request->status;
            $now = Carbon::now();
            $query->where(function ($q) use ($statuses, $now) {
                foreach ($statuses as $status) {
                    if ($status === 'upcoming') {
                        $q->orWhere(function ($sq) use ($now) {
                            $sq->whereNotNull('start')->where('start', '>', $now);
                        });
                    } elseif ($status === 'ongoing') {
                        $q->orWhere(function ($sq) use ($now) {
                            $sq->whereNotNull('start')->whereNotNull('finished')
                               ->where('start', '<=', $now)->where('finished', '>=', $now);
                        });
                    } elseif ($status === 'past') {
                        $q->orWhere(function ($sq) use ($now) {
                            $sq->where(function ($inner) use ($now) {
                                $inner->whereNotNull('finished')->where('finished', '<', $now);
                            })->orWhereNull('start')->orWhereNull('finished');
                        });
                    }
                }
            });
        }

        // Sort
        $sort = $request->input('sort', 'newest');
        if ($sort === 'title') {
            $query->orderBy('title', 'asc');
        } else {
            $query->orderByRaw('COALESCE(start, created_at) DESC');
        }

        $postevent = $query->paginate(9);
        $divisions = Event::getDivisions();
        $years     = Event::getYears();

        if ($request->ajax()) {
            return view('landing-page.event.components._event-cards', compact('postevent'));
        }

        return view('landing-page.event.index', compact('postevent', 'divisions', 'years'))
            ->with('title', 'Kegiatan');
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
