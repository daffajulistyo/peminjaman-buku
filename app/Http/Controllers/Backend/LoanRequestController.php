<?php

namespace App\Http\Controllers\Backend;

use App\Models\Book;
use App\Models\LoanRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanRequestController extends \App\Http\Controllers\Controller
{
    public function index()
    {
        $loanRequests = LoanRequest::with('user', 'book')->get();
        return view('backend.loan.index', compact('loanRequests'));
    }

    public function approve(LoanRequest $loanRequest)
    {
        // dd($loanRequest);
        $loanRequest->update(['approved' => true, 'status' => 'approved']);

        $book = $loanRequest->book;
        $book->decrement('stok');

        return redirect()->route('loan.index')
            ->with('success', 'Pengajuan berhasil disetujui');
    }

    public function reject(LoanRequest $loanRequest)
    {
        $loanRequest->update(['approved' => false]);

        return redirect()->route('loan.index')
            ->with('error', 'Pengajuan Peminjaman ditolak');
    }

    public function create()
    {
        $books = Book::all();
        $users = User::all();
        return view('backend.loan.create_loan', compact('books', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'required|date|after:tanggal_peminjaman',
        ]);

        $loanRequest = LoanRequest::create([
            'user_id' => auth()->user()->id,
            'book_id' => $request->book_id,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
        ]);

        return redirect()->route('member.book.index')
            ->with('success', 'Pengajuan peminjaman buku berhasil ditambahkan silahkan tunggu admin approve peminjaman');
    }

    public function list()
    {
        $loans = LoanRequest::where('approved', true)->where('status', '!=', 'returned')->with('user', 'book')->get();
        return view('backend.loan.list_loan', compact('loans'));
    }

    public function returnBook(LoanRequest $loanRequest)
    {
        $book = $loanRequest->book;

        if ($book) {
            $loanRequest->update(['status' => 'returned']);
            $book->increment('stok');

            $loanRequest->delete();

            return redirect()->route('list.loans.index')
                ->with('success', 'Buku telah dikembalikan');
        } else {
            return redirect()->route('list.loans.index')
                ->with('error', 'Buku tidak ditemukan');
        }
    }

    public function listBookMember()
    {
        $user = auth()->user();
        $loanRequests = LoanRequest::where('user_id', $user->id)->with('book')->get();
        return view('backend.loan.list_book_member', compact('loanRequests'));
    }
}
