<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Menampilkan daftar buku
    public function index()
    {
        $books = Book::all();
        return view('backend.books.list_book', compact('books'));
    }

    // Menampilkan form untuk membuat buku baru
    public function create()
    {
        return view('backend.books.create_book');
    }

    // Menyimpan buku baru ke database
    public function store(Request $request)
    {
        $book = new Book([
            'kode_buku' => $request->get('kode_buku'),
            'judul_buku' => $request->get('judul_buku'),
            'penulis' => $request->get('penulis'),
            'tahun_terbit' => $request->get('tahun_terbit'),
            'stok' => $request->get('stok')
        ]);
        $book->save();
        return Redirect()->route('book.index')->with('success', 'Book created successfully!');
    }

    // Menampilkan detail buku
    public function show($id)
    {
        $book = Book::find($id);
        return view('books.show', compact('book'));
    }

    // Menampilkan form untuk mengedit buku
    public function edit($id)
    {
        $book = Book::find($id);
        return view('backend.books.edit_book', compact('book'));
    }

    // Mengupdate buku yang sudah ada di database
    public function update(Request $request, $id)
    {
        $book = Book::find($id);
        $book->kode_buku = $request->get('kode_buku');
        $book->judul_buku = $request->get('judul_buku');
        $book->penulis = $request->get('penulis');
        $book->tahun_terbit = $request->get('tahun_terbit');
        $book->stok = $request->get('stok');
        $book->save();
        return redirect()->route('book.index')->with('success', 'Buku berhasil diperbarui!');
    }

    // Menghapus buku dari database
    public function destroy($id)
    {
        $book = Book::find($id);
        $book->delete();
        return redirect()->route('book.index')->with('success', 'Buku berhasil dihapus!');
    }
}
