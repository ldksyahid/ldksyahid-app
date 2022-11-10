<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsComment;
use Illuminate\Support\Facades\Auth;

class NewsCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function addnewscomment(Request $request)
    {
        // dd($request->all());
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         // hapus data
         NewsComment::where('id',$id)->delete();
         return redirect()->back();
    }
}
