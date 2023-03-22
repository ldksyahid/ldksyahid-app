<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsComment;
use Illuminate\Support\Facades\Auth;

class NewsCommentController extends Controller
{
    public function addnewscomment(Request $request)
    {
        $this->validate($request, [
            "body" => 'required|between:1,250'
        ]);

        $newscomment = NewsComment::create([
            "body" => $request->body,
            "news_id" => $request->postnews,
            "user_id" => Auth::id(),
        ]);

        return redirect()->route('news.show', $request->postnews);
    }

    public function destroy($id)
    {
         // hapus data
         NewsComment::where('id',$id)->delete();
         return redirect()->back();
    }
}
