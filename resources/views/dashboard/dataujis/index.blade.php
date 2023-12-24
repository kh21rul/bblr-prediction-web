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
                                                            <a href="{{ route('dashboard.dataujis.show', $datauji->id) }}"
                                                                type="button" class="btn btn-info btn-action mr-1"
                                                                data-toggle="tooltip" title="Detail">
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
            </div>
        </section>
    </div>
    <script>
        function deleteButton() {
            event.preventDefault();
            const form = document.getElementById("delete");
            form.submit();
        }
    </script>
@endsection
