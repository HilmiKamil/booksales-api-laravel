<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $genres = Genre::all();

        if ($genres->isEmpty()) {
            return response()->json([
                "success" => true,
                "message" => "Resource Data Not Found!"
            ], 200);
        }


        return response()->json([
            "success" => true,
            "message" => "Get All Genres",
            "data" => $genres,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // 1. validator
        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // 2. check validator error
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        // 4. insert data
        $genre = Genre::create([
            'name'       => $request->name,
            'description' => $request->description,
        ]);

        // 5. response
        return response()->json([
            'success' => true,
            'message' => 'Resource added successfully!',
            'data'    => $genre
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $genre = Genre::find($id);


        if (!$genre) {
            return response()->json([
                "success" => false,
                "message" => "Resource Not Found!"
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get Detail Resource',
            'data'    => $genre
        ], 201);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 1. Mencari ID
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json([
                "success" => false,
                "message" => "Resource Not Found!"
            ], 404);
        }

        // 2. validator
        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        // 3. Siapkan data yang ingin diupdate
        $data = [
            'name'       => $request->name,
            'description' => $request->description,
        ];

        // 4. Update data ke Database
        $genre->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Resource Update Succesfully',
            'data'    => $genre
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json([
                "success" => false,
                "message" => "Resource Not Found!"
            ], 404);
        }

        $genre->delete();

        return response()->json([
            'success' => true,
            'message' => 'Delete Resource Succesfully',
            'data'    => $genre
        ]);
    }
}
