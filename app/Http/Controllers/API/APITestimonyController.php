<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimony;
use Illuminate\Support\Facades\File;

class APITestimonyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Testimony::getAPITestimony()->paginate(5);
        return response()->json($data);
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

        $validasi=$request->validate([
            'picture'=>'required|file|mimes:jpeg,jpg,png',
            'testimony'=>'required',
            'name'=>'required',
            'profession'=>'required',
        ]);

        try {
            $filename = time().$request->file('picture')->getClientOriginalName();
            $path = $request->file('picture')->storeAs('Images/uploads/testimonies',$filename);
            $validasi['picture']=$path;
            $response = Testimony::create($validasi);
            return response()->json([
                'success' => true,
                'message' => 'success',
                'data' => $response
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Error',
                'errors' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Testimony::find($id);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Testimony::find($id);
        return response()->json($data);
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
        $validasi=$request->validate([
            'picture'=>'',
            'testimony'=>'required',
            'name'=>'required',
            'profession'=>'required',
        ]);

        try {
            if ($request->file('picture')) {
                $filename = time().$request->file('picture')->getClientOriginalName();
                $path = $request->file('picture')->storeAs('Images/uploads/testimonies',$filename);
                $validasi['picture']=$path;

                // hapus file
                $gambar = Testimony::where('id',$id)->first();
                File::delete($gambar->picture);
            }
            $response = Testimony::find($id);
            $response->update($validasi);
            return response()->json([
                'success' => true,
                'message' => 'success',
                'data' => $response
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Error',
                'errors' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            // hapus file
            $gambar = Testimony::where('id',$id)->first();
            File::delete($gambar->picture);

            $testimony=Testimony::find($id);
            $testimony->delete();
            return response()->json([
                'success'=>true,
                'message'=>'Delete Success'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Error',
                'errors' => $e->getMessage()
            ]);
        }
    }
}
