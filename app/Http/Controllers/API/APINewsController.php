<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\News;
use App\Http\Resources\NewsResource;
use Illuminate\Support\Facades\File;

class APINewsController extends Controller
{
    public function index()
    {
        $data = News::latest()->get();
        return response()->json([NewsResource::collection($data), 'News fetched.']);
    }

    public function show($id)
    {
        $program = News::find($id);
        if (is_null($program)) {
            return response()->json('Data not found', 404);
        }
        return response()->json([new NewsResource($program)]);
    }

    public function destroy($id)
    {
        // hapus file
        $gambar = News::where('id',$id)->first();
        File::delete($gambar->picture);

        // hapus data
        News::where('id',$id)->delete();

        return response()->json('News deleted successfully');
    }

    public function store(Request $request)
    {
        $filename = time().$request->file('picture')->getClientOriginalName();
        $path = $request->file('picture')->storeAs('Images/uploads/news',$filename);


        $data = News::create([
            "datepublish" => $request["datepublish"],
            "publisher" => $request["publisher"],
            "title" => $request["title"],
            "reporter" => $request["reporter"],
            "editor" => $request["editor"],
            'picture' => $path,
            "descpicture" => $request["descpicture"],
            "body" => $request["body"],
        ]);

        return response()->json(['News created successfully.', new NewsResource($data)]);
    }

    public function update(Request $request, $id)
    {
        if ($request->file('picture')) {
            $filename = time().$request->file('picture')->getClientOriginalName();
            $path = $request->file('picture')->storeAs('Images/uploads/news',$filename);

            // hapus file
            $gambar = News::where('id',$id)->first();
            File::delete($gambar->picture);

            // upload file
            $update = News::where("id", $id)-> update([
                'picture' => $path,
            ]);
        }

        $data = News::where("id", $id)-> update([
            "datepublish" => $request["datepublish"],
            "publisher" => $request["publisher"],
            "title" => $request["title"],
            "reporter" => $request["reporter"],
            "editor" => $request["editor"],
            "descpicture" => $request["descpicture"],
            "body" => $request["body"],
        ]);

        return response()->json(['News updated successfully.', new NewsResource($data)]);
    }
}
