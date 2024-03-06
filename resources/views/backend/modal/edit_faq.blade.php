<div class="modal fade" id="editFaqModal{{ $faq->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit FAQ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" action="{{ route('faq.update', ['id' => $faq->id]) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="question" class="col-md-3 col-form-label text-right">Pertanyaan</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="question" name="question"
                                    placeholder="Masukkan Pertanyaan" value="{{ $faq->question }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="question_image" class="col-md-3 col-form-label text-right"></label>
                            <div class="col-md-9">
                                @if ($faq->question_image)
                                    <img src="{{ asset('apps/public/images/' . $faq->question_image) }}"
                                        alt="Gambar Pertanyaan" style="max-width: 100px;">
                                @else
                                    <p>-</p>
                                @endif
                                <input type="file" class="form-control-file mt-2" id="question_image"
                                    name="question_image">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="answer" class="col-md-3 col-form-label text-right">Jawaban</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="answer" name="answer" rows="5" placeholder="Masukkan Jawaban" required>{{ $faq->answer }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="answer_image" class="col-md-3 col-form-label text-right"></label>
                            <div class="col-md-9">
                                @if ($faq->answer_image)
                                    <img src="{{ asset('apps/public/images/' . $faq->answer_image) }}" alt="Gambar Jawaban"
                                        style="max-width: 100px;">
                                @else
                                    <p>-</p>
                                @endif
                                <input type="file" class="form-control-file mt-2" id="answer_image"
                                    name="answer_image">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-info">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
