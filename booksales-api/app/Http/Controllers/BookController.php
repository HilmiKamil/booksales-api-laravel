<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $books = Book::with('genre', 'author')->get();

        if ($books->isEmpty()) {
            return response()->json([
                "success" => true,
                "message" => "Resource Data Not Found!"
            ], 200);
        }

        return response()->json([
            "success" => true,
            "message" => "Get All Books",
            "data" => $books,
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
            'title'       => 'required|string|max:100',
            'description' => 'required|string',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'cover_photo' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'genre_id'    => 'required|exists:genres,id',
            'author_id'   => 'required|exists:authors,id'
        ]);

        // 2. check validator error
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        // 3. upload image
        $image = $request->file('cover_photo');
        $image->store('books', 'public');

        // 4. insert data
        $book = Book::create([
            'title'       => $request->title,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'cover_photo' => $image->hashName(),
            'genre_id'    => $request->genre_id,
            'author_id'   => $request->author_id,
        ]);

        // 5. response
        return response()->json([
            'success' => true,
            'message' => 'Resource added successfully!',
            'data'    => $book
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $book = Book::find($id);


        if (!$book) {
            return response()->json([
                "success" => false,
                "message" => "Resource Not Found!"
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get Detail Resource',
            'data'    => $book
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
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                "success" => false,
                "message" => "Resource Not Found!"
            ], 404);
        }

        // 2. validator
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:100',
            'description' => 'required|string',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'cover_photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'genre_id'    => 'required|exists:genres,id',
            'author_id'   => 'required|exists:authors,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        // 3. Siapkan data yang ingin diupdate
        $data = [
            'title'       => $request->title,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'genre_id'    => $request->genre_id,
            'author_id'   => $request->author_id,
        ];

        // 4. Updata Image & Delete Image
        if ($request->hasFile('cover_photo')) {
            $image = $request->file('cover_photo');
            $image->store('books', 'public');

            if ($book->cover_photo) {
                Storage::disk('public')->delete('books/' . $book->cover_photo);
            }

            $data['cover_photo'] = $image->hashName();
        }

        // 5. Update data ke Database
        $book->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Resource Update Succesfully',
            'data'    => $book
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                "success" => false,
                "message" => "Resource Not Found!"
            ], 404);
        }

        if ($book->cover_photo) {
            //delete file
            Storage::disk('public')->delete('books/' . $book->cover_photo);
        };

        $book->delete();

        return response()->json([
            'success' => true,
            'message' => 'Delete Resource Succesfully',
            'data'    => $book
        ]);
    }
}
