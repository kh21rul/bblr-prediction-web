@extends('layouts.main')

@section('container')
    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container">
            <h1 class="display-3 mb-4 animated slideInDown">503 Error</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">503 Error</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- 503 Start -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <i class="bi bi-exclamation-triangle display-1 text-primary"></i>
                    <h1 class="display-1">503</h1>
                    <h1 class="mb-4">Service Unavailable</h1>
                    <p class="mb-4">The server is temporarily unable to service your request due to maintenance downtime
                        or capacity problems. Please try again later.</p>
                    <a class="btn btn-primary py-3 px-5" href="{{ route('home') }}">Go Back To Home</a>
                </div>
            </div>
        </div>
    </div>
    <!-- 503 End -->
@endsection
