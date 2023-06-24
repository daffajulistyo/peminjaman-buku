<?php

namespace App\Http\Controllers\Backend;

use App\Models\LoanRequest;
use Illuminate\Http\Request;

class LoanRequestController extends \App\Http\Controllers\Controller
{
    public function index()
    {
        $loanRequests = LoanRequest::with('user', 'book')->get();
        return view('backend.loan.index', compact('loanRequests'));
    }

    public function approve(LoanRequest $loanRequest)
    {
        $loanRequest->update(['approved' => true]);

        $book = $loanRequest->book;
        $book->decrement('stok');

        return redirect()->route('loan.index')
            ->with('success', 'Pengajuan berhasil disetujui');
    }

    public function reject(LoanRequest $loanRequest)
    {
        $loanRequest->update(['approved' => false]);

        return redirect()->route('loan.index')
            ->with('success', 'Pengajuan Peminjaman ditolak');
    }
}
