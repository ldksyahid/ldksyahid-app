<?php

namespace App\Http\Controllers;

use App\Models\MsShortlink;
use AshAllenDesign\ShortURL\Classes\Resolver;
use Illuminate\Http\Request;

class ShortLinkController extends Controller
{
    /**
     * Display a listing of shortlinks
     */
    public function index(Request $request)
    {
        $items = MsShortlink::searchAdminShortlink($request);
        $tableConfig = MsShortlink::getTableConfig();

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

        return view('admin-page.service.short-link.index', compact('items', 'tableConfig'))
            ->with('title', 'Services');
    }

    /**
     * Create a new shortlink
     */
    public function shorten(Request $request)
    {
        $result = MsShortlink::createShortlink($request->url);

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'errors' => $result['errors']
            ], $result['status'] ?? 422);
        }

        return response()->json([
            'success' => true,
            'message' => $result['message']
        ]);
    }

    /**
     * Update an existing shortlink
     */
    public function update(Request $request, $id)
    {
        $result = MsShortlink::updateShortlink(
            $id,
            $request->url,
            $request->destination
        );

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'errors' => $result['errors']
            ], $result['status'] ?? 422);
        }

        return response()->json([
            'success' => true,
            'message' => $result['message']
        ]);
    }

    /**
     * Delete a shortlink
     */
    public function destroy($id)
    {
        $result = MsShortlink::deleteShortlink($id);

        return response()->json($result);
    }

    /**
     * Bulk delete shortlinks
     */
    public function bulkDelete(Request $request)
    {
        $result = MsShortlink::bulkDeleteShortlinks($request->input('ids', []));

        if (!$result['success']) {
            return response()->json($result, $result['status'] ?? 400);
        }

        return response()->json($result);
    }

    /**
     * Redirect shortlink to destination
     */
    public function redirect($shortURLKey, Resolver $resolver)
    {
        $shortURL = MsShortlink::where('url_key', $shortURLKey)->firstOrFail();
        $resolver->handleVisit(request(), $shortURL);
        return view('landing-page.service.short-link.redirect', [
            'destination' => $shortURL->destination_url,
        ]);
    }
}
