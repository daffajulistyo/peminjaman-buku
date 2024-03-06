<?php

namespace App\Http\Controllers\Backend;

use App\Models\Faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::all();
        return view('backend.faq.add_faq', compact('faqs'));
    }

    public function show()
    {
        $faqs = Faq::all();
        return view('backend.faq.faq', compact('faqs'));
    }

    public function create()
    {
        return view('backend.faq.add_faq');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
            'question_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // validasi untuk gambar pertanyaan
            'answer_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // validasi untuk gambar jawaban
        ]);

        $questionImage = null;
        $answerImage = null;

        // Menyimpan gambar pertanyaan
        if ($request->hasFile('question_image')) {
            $questionImage = $request->file('question_image')->getClientOriginalName();
            $request->file('question_image')->move(public_path('images'), $questionImage);
        }

        // Menyimpan gambar jawaban
        if ($request->hasFile('answer_image')) {
            $answerImage = $request->file('answer_image')->getClientOriginalName();
            $request->file('answer_image')->move(public_path('images'), $answerImage);
        }

        // Membuat FAQ baru dengan data yang disimpan
        Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
            'question_image' => $questionImage,
            'answer_image' => $answerImage,
        ]);

        return redirect()->route('faqs.index')->with('success', 'FAQ Berhasil Ditambahkan');
    }


    public function update(Request $request, $id)
    {
        $faq = Faq::find($id);

        // Validasi input
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'question_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'answer_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Hapus gambar pertanyaan lama jika ada gambar baru yang diunggah
        if ($request->hasFile('question_image') && $faq->question_image) {
            unlink(public_path('images/' . $faq->question_image));
        }

        // Hapus gambar jawaban lama jika ada gambar baru yang diunggah
        if ($request->hasFile('answer_image') && $faq->answer_image) {
            unlink(public_path('images/' . $faq->answer_image));
        }

        // Menyimpan gambar pertanyaan yang baru diunggah
        if ($request->hasFile('question_image')) {
            $questionImage = $request->file('question_image');
            $questionImageName = time() . '_' . $questionImage->getClientOriginalName();
            $questionImage->move(public_path('images'), $questionImageName);
            $faq->question_image = $questionImageName;
        }

        // Menyimpan gambar jawaban yang baru diunggah
        if ($request->hasFile('answer_image')) {
            $answerImage = $request->file('answer_image');
            $answerImageName = time() . '_' . $answerImage->getClientOriginalName();
            $answerImage->move(public_path('images'), $answerImageName);
            $faq->answer_image = $answerImageName;
        }

        // Update entri FAQ
        $faq->update([
            'question' => $request->input('question'),
            'answer' => $request->input('answer'),
        ]);

        return redirect()->route('faqs.index')->with('success', 'FAQ berhasil diperbarui!');
    }


    public function destroy($id)
    {
        $faq = Faq::find($id);

        // Hapus gambar pertanyaan jika ada
        if ($faq->question_image) {
            unlink(public_path('images/' . $faq->question_image));
        }

        // Hapus gambar jawaban jika ada
        if ($faq->answer_image) {
            unlink(public_path('images/' . $faq->answer_image));
        }

        // Hapus entri FAQ dari database
        $faq->delete();

        return redirect()->route('faqs.index')->with('success', 'FAQ berhasil dihapus!');
    }
}
