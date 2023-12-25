@extends('dashboard.layouts.main')

@section('container')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Dataset</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Tambah Dataset</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Tambah Dataset</h2>
                <p class="section-lead">
                    Tambahkan dataset BBLR baru.
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <form action="{{ route('dashboard.datasets.store') }}" method="POST">
                                @csrf
                                <div class="card-header">
                                    <h4>Form Tambah Dataset</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"
                                            for="nama">Nama Ibu</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="text" id="nama" name="nama" value="{{ old('nama') }}"
                                                autofocus required placeholder="Masukkan nama ibu"
                                                class="form-control @error('nama') is-invalid @enderror">
                                            @error('nama')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"
                                            for="umur">Umur Ibu</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="number" id="umur" name="umur" value="{{ old('umur') }}"
                                                required placeholder="Masukkan umur ibu"
                                                class="form-control @error('umur') is-invalid @enderror">
                                            @error('umur')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"
                                            for="lila">Lingkar Lengan Atas</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="text"id="lila" name="lila" value="{{ old('lila') }}"
                                                required placeholder="Masukkan lingkar lengan atas"
                                                class="form-control @error('lila') is-invalid @enderror">
                                            @error('lila')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"
                                            for="tinggi">Tinggi Badan</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="number" id="tinggi" name="tinggi" value="{{ old('tinggi') }}"
                                                required placeholder="Masukkan tinggi badan"
                                                class="form-control @error('tinggi') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"
                                            for="bblr">Teridentifikasi BBLR</label>
                                        <label class="custom-switch mt-2" for="bblr">
                                            @if (old('bblr') == 1)
                                                <input type="checkbox" id="bblr" name="bblr"
                                                    class="custom-switch-input" value="1" checked>
                                            @else
                                                <input type="checkbox" id="bblr" name="bblr"
                                                    class="custom-switch-input" value="1">
                                            @endif
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">Geser jika teridentifikasi</span>
                                        </label>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                        <div class="col-sm-12 col-md-7">
                                            <button type="submit" class="btn btn-primary">Tambah Data</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
