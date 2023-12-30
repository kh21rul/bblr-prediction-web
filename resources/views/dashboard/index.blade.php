@extends('dashboard.layouts.main')

@section('container')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-database"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Dataset</h4>
                            </div>
                            <div class="card-body">
                                {{ $total_dataset }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-pencil-ruler"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Data Uji</h4>
                            </div>
                            <div class="card-body">
                                {{ $total_data_uji }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
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
                            <h4>Data Uji</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped text-center" id="table-2">
                                    <thead class="text-bold">
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Ibu</th>
                                            <th>Umur</th>
                                            <th>LILA</th>
                                            <th>Tinggi Badan</th>
                                            <th>Status BBLR Naive Bayes</th>
                                            <th>Status BBLR C4.5</th>
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
    <script src="{{ $chartbar->cdn() }}"></script>
    <script src="{{ $chart_nb_pie->cdn() }}"></script>
    <script src="{{ $chart_c45_pie->cdn() }}"></script>

    {{ $chartbar->script() }}
    {{ $chart_nb_pie->script() }}
    {{ $chart_c45_pie->script() }}
@endsection
