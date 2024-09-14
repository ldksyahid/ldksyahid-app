<?php

namespace App\Http\Controllers;

use AshAllenDesign\ShortURL\Models\ShortURL;
use AshAllenDesign\ShortURL\Models\ShortURLVisit;
use AshAllenDesign\ShortURL\Classes\Resolver;
use AshAllenDesign\ShortURL\Classes\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ShortLinkController extends Controller
{
    public function index()
    {
        $urls = ShortURL::latest()->get();
        return view('admin-page.service.short-link.index', compact('urls'))->with("title", "Services");
    }

    public function shorten(Request $request)
    {
        $builder = new Builder();
        $shortURLObject = $builder->destinationUrl($request->url)->make();
        $shortURL = $shortURLObject->default_short_url;
        return back()->with('success', 'URL shortened successfully.');
    }

    public function update(Request $request, $id)
    {
        $url = ShortURL::find($id);
        $url->url_key = $request->url;
        $url->destination_url = $request->destination;
        $url->default_short_url = config('app.url') . '/' . $request->url;
        $url->save();
        return back()->with('success', 'URL updated successfully.');
    }

    public function destroy($id)
    {
        $url = ShortURL::find($id);
        if (!empty($url)) {
            $url->url_key = request()->url;
            $visits = ShortURLVisit::where('short_url_id', $url->id)->get();
            if (!empty($visits)) {
                foreach ($visits as $visit) {
                    $visit->delete();
                }
            }
            $url->delete();
        }
        return back()->with('success', 'URL deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');

        if (!empty($ids)) {
            foreach ($ids as $id) {
                $url = ShortURL::find($id);
                if (!empty($url)) {
                    $visits = ShortURLVisit::where('short_url_id', $url->id)->get();
                    if (!empty($visits)) {
                        foreach ($visits as $visit) {
                            $visit->delete();
                        }
                    }
                    foreach ($visits as $visit) {
                        $visit->delete();
                    }
                    $url->delete();
                }
            }
            return response()->json(['success' => 'Selected shortlinks have been deleted!']);
        }
        return response()->json(['error' => 'No items selected for deletion.'], 400);
    }

    public function redirect($shortURLKey, Resolver $resolver)
    {
        $shortURL = ShortURL::where('url_key', $shortURLKey)->firstOrFail();

        if (!empty($shortURL)) {
            $resolver->handleVisit(request(), $shortURL);
        }

        return Redirect::to($shortURL->destination_url);
    }
}
