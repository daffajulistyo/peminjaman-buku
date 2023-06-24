<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all();
        return response()->json($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_buku' => 'required|unique:books',
            'judul_buku' => 'required',
            'penulis' => 'required',
            'tahun_terbit' => 'required',
            'stok' => 'required|numeric',
        ]);

        $book = new Book();
        $book->kode_buku = $request->kode_buku;
        $book->judul_buku = $request->judul_buku;
        $book->penulis = $request->penulis;
        $book->tahun_terbit = $request->tahun_terbit;
        $book->stok = $request->stok;
        $book->save();

        return response()->json($book, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($code)
    {
        $book = Book::where('kode_buku', $code)->first();
        if ($book) {
            return response()->json($book);
        } else {
            return response()->json(['message' => 'Book not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $code)
    {
        $request->validate([
            'judul_buku' => 'required',
            'tahun_terbit' => 'required',
            'penulis' => 'required',
            'stok' => 'required|numeric',
        ]);

        $book = Book::where('kode_buku', $code)->first();
        if ($book) {
            $book->judul_buku = $request->judul_buku;
            $book->tahun_terbit = $request->tahun_terbit;
            $book->penulis = $request->penulis;
            $book->stok = $request->stok;
            $book->save();

            return response()->json($book);
        } else {
            return response()->json(['message' => 'Book not found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($code)
    {
        $book = Book::where('kode_buku', $code)->first();
        if ($book) {
            $book->delete();
            return response()->json(['message' => 'Book deleted']);
        } else {
            return response()->json(['message' => 'Book not found'], 404);
        }
    }
}
