@extends('dashboard.layouts.main')

@section('container')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dataset</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Dataset</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Dataset BBLR</h2>
                <p class="section-lead">
                    Berikut adalah dataset BBLR yang telah diinputkan.
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
                                <h4>Dataset Ibu Melahirkan</h4>
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
                                                <th>Status BBLR</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($datasets as $dataset)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $dataset->nama }}</td>
                                                    <td>{{ $dataset->umur }} Tahun</td>
                                                    <td>{{ $dataset->lila }} cm</td>
                                                    <td>{{ $dataset->tinggi }} cm</td>
                                                    <td>{{ $dataset->bblr ? 'Ya' : 'Tidak' }}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="{{ route('dashboard.datasets.edit', $dataset->id) }}"
                                                                type="button" class="btn btn-primary btn-action mr-1"
                                                                data-toggle="tooltip" title="Edit"><i
                                                                    class="fas fa-pencil-alt"></i></a>
                                                            <form id="delete"
                                                                action="{{ route('dashboard.datasets.destroy', $dataset->id) }}"
                                                                method="POST">
                                                                @method('delete')
                                                                @csrf
                                                                <button class="btn btn-danger btn-action"
                                                                    data-toggle="tooltip" title="Delete"
                                                                    data-confirm="Apakah Kamu Yakin?|This action can not be undone. Do you want to continue?"
                                                                    data-confirm-yes="deleteButton()"><i
                                                                        class="fas fa-trash"></i></button>
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
