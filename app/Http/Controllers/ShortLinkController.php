<?php

namespace App\Http\Controllers;

use AshAllenDesign\ShortURL\Models\ShortURL;
use AshAllenDesign\ShortURL\Models\ShortURLVisit;
use AshAllenDesign\ShortURL\Classes\Resolver;
use AshAllenDesign\ShortURL\Classes\Builder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ShortLinkController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');

        $allowedSorts = [
            'url_key',
            'destination_url',
            'default_short_url',
            'created_by',
            'created_at',
            'visits_count'
        ];

        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }

        $urls = ShortURL::withCount('visits')
            ->when($request->filled('url_key'), function ($query) use ($request) {
                $query->where('url_key', 'like', '%' . $request->url_key . '%');
            })
            ->when($request->filled('destination_url'), function ($query) use ($request) {
                $query->where('destination_url', 'like', '%' . $request->destination_url . '%');
            })
            ->when($request->filled('default_short_url'), function ($query) use ($request) {
                $query->where('default_short_url', 'like', '%' . $request->default_short_url . '%');
            })
            ->when($request->filled('created_by'), function ($query) use ($request) {
                $query->where('created_by', 'like', '%' . $request->created_by . '%');
            })
            ->when($request->filled('visits_count'), function ($query) use ($request) {
                $query->having('visits_count', '=', $request->visits_count);
            })
            ->when($request->filled('created_at_start') && $request->filled('created_at_end'), function ($query) use ($request) {
                $start = Carbon::createFromFormat('d-m-Y', $request->created_at_start)->startOfDay();
                $end = Carbon::createFromFormat('d-m-Y', $request->created_at_end)->endOfDay();
                $query->whereBetween('created_at', [$start, $end]);
            })
            ->orderBy($sortBy, $sortOrder)
            ->paginate(15)
            ->appends($request->all());

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin-page.service.short-link._index_table', compact('urls'))->render(),
                'pagination' => (string) $urls->links(),
                'total' => $urls->total(),
                'showing' => [
                    'first' => $urls->firstItem(),
                    'last' => $urls->lastItem()
                ]
            ]);
        }

        return view('admin-page.service.short-link.index')->with('title', 'Services');
    }

    public function shorten(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|url'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $builder = new Builder();
        $shortURLObject = $builder->destinationUrl($request->url)->make();

        return response()->json([
            'success' => true,
            'message' => 'URL shortened successfully.'
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'url' => [
                'required',
                'string',
                'alpha_dash',
                Rule::unique('short_urls', 'url_key')->ignore($id),
            ],
            'destination' => 'required|url',
        ], [
            'url.required' => 'URL Key is required.',
            'url.alpha_dash' => 'URL Key may only contain letters, numbers, dashes, and underscores.',
            'url.unique' => 'This URL Key is already taken. Please choose another.',
            'destination.required' => 'Destination URL is required.',
            'destination.url' => 'The destination must be a valid URL.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $url = ShortURL::findOrFail($id);
        $url->url_key = $request->url;
        $url->destination_url = $request->destination;
        $url->default_short_url = config('app.url') . '/' . $request->url;
        $url->save();

        return response()->json([
            'success' => true,
            'message' => 'URL updated successfully.'
        ]);
    }

    public function destroy($id)
    {
        $url = ShortURL::findOrFail($id);
        ShortURLVisit::where('short_url_id', $url->id)->delete();
        $url->delete();

        return response()->json([
            'success' => true,
            'message' => 'URL deleted successfully.'
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'No items selected for deletion.'
            ], 400);
        }

        ShortURL::whereIn('id', $ids)->delete();
        ShortURLVisit::whereIn('short_url_id', $ids)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Selected shortlinks have been deleted!'
        ]);
    }

    public function redirect($shortURLKey, Resolver $resolver)
    {
        $shortURL = ShortURL::where('url_key', $shortURLKey)->firstOrFail();
        $resolver->handleVisit(request(), $shortURL);
        return Redirect::to($shortURL->destination_url);
    }
}
