<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArticleComment;
use Illuminate\Support\Facades\Auth;

class ArticleCommentController extends Controller
{

    public function addarticlecomment(Request $request)
    {
        $this->validate($request, [
            "body" => 'required|between:1,250'
        ]);

        $articlecomment = ArticleComment::create([
            "body" => $request->body,
            "articles_id" => $request->postarticle,
            "user_id" => Auth::id(),
        ]);

        return redirect()->route('article.show', $request->postarticle);
    }

    public function destroy($id)
    {
        ArticleComment::where('id',$id)->delete();
        return redirect()->back();
    }
}
