@extends('dashboard.layouts.main')

@section('container')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Uji</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Data uji</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Data uji Berdasarkan Dataset</h2>
                <p class="section-lead">
                    Berikut adalah data uji yang telah dihitung menggunakan metode Naive Bayes dan c4.5 untuk menentukan
                    status BBLR.
                </p>

                <div class="row">
                    <div class="col-12">
                        @if (session()->has('success'))
                            <div class="alert alert-primary alert-dismissible show fade">
                                <div class="alert-body">
                                    <button class="close" data-dismiss="alert">
                                        <span>&times;</span>
                                    </button>
                                    {{ session('success') }}
                                </div>
                            </div>
                        @endif
                        @if (session()->has('error'))
                            <div class="alert alert-danger alert-dismissible show fade">
                                <div class="alert-body">
                                    <button class="close" data-dismiss="alert">
                                        <span>&times;</span>
                                    </button>
                                    {{ session('error') }}
                                </div>
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Uji</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped text-center" id="table-1">
                                        <thead class="text-bold">
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama Ibu</th>
                                                <th>Umur</th>
                                                <th>LILA</th>
                                                <th>Tinggi Badan</th>
                                                <th>Status BBLR Naive Bayes</th>
                                                <th>Status BBLR C4.5</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dataujis as $datauji)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $datauji->nama }}</td>
                                                    <td>{{ $datauji->umur }} Tahun</td>
                                                    <td>{{ $datauji->lila }} cm</td>
                                                    <td>{{ $datauji->tinggi }} cm</td>
                                                    <td>{{ $datauji->bblr_nb ? 'Ya' : 'Tidak' }}</td>
                                                    <td>{{ $datauji->bblr_c45 ? 'Ya' : 'Tidak' }}</td>
                                                    <td class="text-right">
                                                        <div class="btn-group">
                                                            <a href="{{ route('dashboard.dataujis.edit', $datauji->id) }}"
                                                                type="button" class="btn btn-primary btn-action mr-1"
                                                                data-toggle="tooltip" title="Edit">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </a>
                                                            <a href="#" type="button"
                                                                class="btn btn-info btn-action mr-1 btn-detail"
                                                                data-toggle="modal" data-target="#exampleModal"
                                                                data-id="{{ $datauji->id }}" title="Detail">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <form id="delete"
                                                                action="{{ route('dashboard.dataujis.destroy', $datauji->id) }}"
                                                                method="POST" style="display: inline-block;">
                                                                @method('delete')
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger btn-action"
                                                                    data-toggle="tooltip" title="Delete"
                                                                    data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?"
                                                                    data-confirm-yes="deleteButton()">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data BBLR Berdasarkan Perhitungan Naive Bayes dan C4.5</h4>
                            </div>
                            <div class="card-body">
                                {!! $chartbar->container() !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data BBLR Naive Bayes</h4>
                            </div>
                            <div class="card-body">
                                {!! $chart_nb_pie->container() !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data BBLR C4.5</h4>
                            </div>
                            <div class="card-body">
                                {!! $chart_c45_pie->container() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- modal info --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ asset('dashmin/img/bayi.svg') }}" alt="Baby Image" class="img-fluid rounded mb-3">

                    <div class="mb-3 row justify-content-center">
                        <div class="col-12">
                            <label for="naiveBayesStatus" class="font-weight-bold">Status BBLR Berdasarkan Naive
                                Bayes</label>
                        </div>
                        <div class="col-12 d-flex justify-content-center" role="group" aria-label="Status"
                            id="naiveBayesStatus">
                            <button type="button" id="nbButton" class="btn btn-danger">Teridentifikasi
                                BBLR</button>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-12">
                            <label for="c45Status" class="font-weight-bold">Status BBLR Berdasarkan C4.5</label>
                        </div>
                        <div class="col-12 d-flex justify-content-center" role="group" aria-label="Status"
                            id="c45Status">
                            <button type="button" class="btn btn-success" id="c45Button">Tidak Teridentifikasi
                                BBLR</button>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-whitesmoke br d-flex justify-content-between">
                    <a href="#" id="simpanNB" class="btn btn-info text-left">Simpan Hasil Naive Bayes Ke
                        Dataset</a>
                    <a href="#" id="simpanC45" class="btn btn-info text-right">Simpan Hasil C4.5 Ke Dataset</a>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Info --}}

    <script>
        $(document).ready(function() {
            // Tangani acara klik tombol detail
            $('.btn-detail').on('click', function() {
                // Dapatkan ID data dari atribut data-id
                var dataId = $(this).data('id');

                // Temukan data yang sesuai dari $dataujis
                var dataUji = {!! json_encode($dataujis) !!}.find(d => d.id === dataId);

                // Setel data modal sesuai dengan dataUji yang ditemukan
                $('#exampleModal').find('.modal-title').text('Status Bayi Ibu ' + dataUji.nama);
                // Ubah teks tombol berdasarkan kondisi
                var c45ButtonText = dataUji.bblr_c45 ? 'Teridentifikasi BBLR' :
                    'TIdak Teridentifikasi BBLR';
                $('#c45Button').text(c45ButtonText);
                $('#simpanNB').attr('href', '/dashboard/datauji/simpannb/' + dataUji.id);
                var nbButtonText = dataUji.bblr_nb ? 'Teridentifikasi BBLR' :
                    'TIdak Teridentifikasi BBLR';
                $('#nbButton').text(nbButtonText);
                $('#simpanC45').attr('href', '/dashboard/datauji/simpanc45/' + dataUji.id);

                // Ubah kelas tombol menjadi btn-danger jika bblr_c45 bernilai true
                if (dataUji.bblr_c45) {
                    $('#c45Button').removeClass('btn-success').addClass('btn-danger');
                } else {
                    $('#c45Button').removeClass('btn-danger').addClass('btn-success');
                }
                if (dataUji.bblr_nb) {
                    $('#nbButton').removeClass('btn-success').addClass('btn-danger');
                } else {
                    $('#nbButton').removeClass('btn-danger').addClass('btn-success');
                }

                // Tampilkan modal
                $('#exampleModal').modal('show');
            });
        });
    </script>



    <script>
        function deleteButton() {
            event.preventDefault();
            const form = document.getElementById("delete");
            form.submit();
        }
    </script>
    <script src="{{ $chartbar->cdn() }}"></script>
    <script src="{{ $chart_nb_pie->cdn() }}"></script>
    <script src="{{ $chart_c45_pie->cdn() }}"></script>

    {{ $chartbar->script() }}
    {{ $chart_nb_pie->script() }}
    {{ $chart_c45_pie->script() }}
@endsection
