<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $authors = Author::all();

        if ($authors->isEmpty()) {
            return response()->json([
                "success" => true,
                "message" => "Resource Data Not Found!"
            ], 200);
        }

        return response()->json([
            "success" => true,
            "message" => "Get All Authors",
            "data" => $authors,
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
            'name'       => 'required|string|max:100',
            'photo' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'bio' => 'required|string',
        ]);

        // 2. check validator error
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        // 3. upload image
        $image = $request->file('photo');
        $image->store('authors', 'public');

        // 4. insert data
        $author = Author::create([
            'name'       => $request->name,
            'bio' => $request->bio,
            'photo' => $image->hashName(),
        ]);

        // 5. response
        return response()->json([
            'success' => true,
            'message' => 'Resource added successfully!',
            'data'    => $author
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                "success" => false,
                "message" => "Resource Not Found!"
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get Detail Resource',
            'data'    => $author
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
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                "success" => false,
                "message" => "Resource Not Found!"
            ], 404);
        }

        // 2. validator
        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'bio' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        // 3. Siapkan data yang ingin diupdate
        $data = [
            'name' => $request->name,
            'bio' => $request->bio,
        ];

        // 4. Updata Image & Delete Image
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $image->store('authors', 'public');

            if ($author->photo) {
                Storage::disk('public')->delete('authors/' . $author->photo);
            }

            $data['photo'] = $image->hashName();
        }

        // 5. Update data ke Database
        $author->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Resource Update Succesfully',
            'data'    => $author
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                "success" => false,
                "message" => "Resource Not Found!"
            ], 404);
        }

        if ($author->photo) {
            //delete file
            Storage::disk('public')->delete('authors/' . $author->photo);
        };

        $author->delete();

        return response()->json([
            'success' => true,
            'message' => 'Delete Resource Succesfully',
            'data'    => $author
        ]);
    }
}
