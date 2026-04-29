<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $transaction = Transaction::with('user', 'book')->get();

        if ($transaction->isEmpty()) {
            return response()->json([
                "success" => true,
                "message" => "Resource Data Not Found!"
            ], 200);
        }

        return response()->json([
            "success" => true,
            "message" => "Get All Transaction",
            "data" => $transaction,
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
        // 1. validator & cek validator
        $validator = Validator::make($request->all(), [
            'book_id'  => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'data'    => $validator->errors()
            ], 422);
        }

        // 2. generate orderNumber -> unique | ORD-023948302
        $uniqueCode = "ORD-" . strtoupper(uniqid());

        // 3. ambil user yang sedang login & cek login (apakah ada data user?)
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized!'
            ], 401);
        }

        // 4. mencari data buku dari request
        $book = Book::find($request->book_id);

        // 5. cek stok buku
        if ($book->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stock Barang Tidak Cukup'
            ], 400);
        }

        // 6. hitung total harga = price * quantity
        $totalAmount = $book->price * $request->quantity;

        //  7. kurangi stok buku (update)
        $book->stock -= $request->quantity;
        $book->save();

        // 8. simpan data transaksi
        $transactions = Transaction::create([
            'order_number' => $uniqueCode,
            'customer_id'  => $user->id,
            'book_id'      => $request->book_id,
            'total_amount' => $totalAmount
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Transaction created successfully!',
            'data'    => $transactions
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $transaction = Transaction::with('user', 'book')->find($id);

        if (!$transaction) {
            return response()->json([
                "success" => false,
                "message" => "Resource Not Found!"
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get Detail Transaction',
            'data'    => $transaction
        ], 200);
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
        // 1. cari transaction
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                "success" => false,
                "message" => "Resource Not Found!"
            ], 404);
        }

        // 2. validasi
        $validator = Validator::make($request->all(), [
            'book_id'  => 'required|exists:books,id',
            'quantity' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        // 3. ambil buku lama & kembalikan stok
        $oldBook = Book::find($transaction->book_id);
        $oldBook->stock += ($transaction->total_amount / $oldBook->price);
        $oldBook->save();

        // 4. ambil buku baru
        $newBook = Book::find($request->book_id);

        // 5. cek stok
        if ($newBook->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stock Barang Tidak Cukup'
            ], 400);
        }

        // 6. hitung total baru
        $totalAmount = $newBook->price * $request->quantity;

        // 7. kurangi stok baru
        $newBook->stock -= $request->quantity;
        $newBook->save();

        // 8. update transaction
        $transaction->update([
            'book_id'      => $request->book_id,
            'total_amount' => $totalAmount
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Transaction Updated Successfully',
            'data'    => $transaction
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                "success" => false,
                "message" => "Resource Not Found!"
            ], 404);
        }

        // 1. kembalikan stok
        $book = Book::find($transaction->book_id);

        if ($book) {
            $quantity = $transaction->total_amount / $book->price;
            $book->stock += $quantity;
            $book->save();
        }

        // 2. hapus transaction
        $transaction->delete();

        return response()->json([
            'success' => true,
            'message' => 'Transaction Deleted Successfully',
            'data'    => $transaction
        ], 200);
    }
}
