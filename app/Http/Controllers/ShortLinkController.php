<?php

namespace App\Http\Controllers;

use AshAllenDesign\ShortURL\Models\ShortURL;
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
        $url->url_key = request()->url;
        $url->delete();
        return back()->with('success', 'URL deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');

        if (!empty($ids)) {
            ShortURL::whereIn('id', $ids)->delete();
            foreach ($ids as $id) {
                $shortUrl = ShortURL::find($id);
                if ($shortUrl) {
                    $shortUrl->url_key = null;
                    $shortUrl->save();
                }
            }
            return response()->json(['success' => 'Selected shortlinks have been deleted!']);
        }

        return response()->json(['error' => 'No items selected for deletion.'], 400);
    }

    public function redirect($shortURLKey)
    {
        $shortURL = ShortURL::where('url_key', $shortURLKey)->firstOrFail();
        return Redirect::to($shortURL->destination_url);
    }
}
