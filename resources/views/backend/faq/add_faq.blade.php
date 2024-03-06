@extends('backend.layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Tambah FAQ</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="{{ route('faqs.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="question" class="col-md-3 col-form-label text-right">Pertanyaan</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="question" name="question"
                                    placeholder="Masukkan Pertanyaan" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="question_image" class="col-md-3 col-form-label text-right"></label>
                            <div class="col-md-9">
                                <input type="file" class="form-control-file" id="question_image" name="question_image">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="answer" class="col-md-3 col-form-label text-right">Jawaban</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="answer" name="answer" rows="5" placeholder="Masukkan Jawaban" required></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="answer_image" class="col-md-3 col-form-label text-right"></label>
                            <div class="col-md-9">
                                <input type="file" class="form-control-file" id="answer_image" name="answer_image">
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <div class="form-group row">
                            <div class="offset-md-3 col-md-9">
                                <button type="submit" class="btn btn-info">Tambahkan</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-footer -->
                </form>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header info">
                    <h3 class="card-title">Daftar FAQ</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pertanyaan</th>
                                <th>Gambar</th>
                                <th>Jawaban</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($faqs as $faq)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $faq->question }}</td>
                                    <td>
                                        @if ($faq->question_image)
                                            <img src="{{ asset('images/' . $faq->question_image) }}"
                                                alt="Gambar Pertanyaan" style="max-width: 100px;">
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $faq->answer }}</td>
                                    <td>
                                        @if ($faq->answer_image)
                                            <img src="{{ asset('images/' . $faq->answer_image) }}"
                                                alt="Gambar Jawaban" style="max-width: 100px;">
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="" class="btn btn-sm btn-info mr-1" data-toggle="modal" data-target="#editFaqModal{{ $faq->id }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('faq.delete', ['id' => $faq->id]) }}" class="btn btn-sm btn-danger mr-1" id="delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                    

                                </tr>

                                @include('backend.modal.edit_faq', ['faqId' => $faq->id])
                            @endforeach

                        </tbody>

                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
