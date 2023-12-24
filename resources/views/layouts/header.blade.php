<!-- Spinner Start -->
<div id="spinner"
    class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
</div>
<!-- Spinner End -->


<!-- Navbar Start -->
<div class="container-fluid fixed-top px-0 wow fadeIn" data-wow-delay="0.1s">
    <div class="top-bar row gx-0 align-items-center d-none d-lg-flex">
        <div class="col-lg-6 px-5 text-start">
            <small><i class="fa fa-map-marker-alt text-primary me-2"></i>Lhoksemuawe, Aceh, Indonesia</small>
            <small class="ms-4"><i class="fa fa-clock text-primary me-2"></i>{{ date('H:i - d M Y') }}</small>
        </div>
        <div class="col-lg-6 px-5 text-end">
            <small><i class="fa fa-envelope text-primary me-2"></i>anindya@unimal.ac.id</small>
            <small class="ms-4"><i class="fa fa-phone-alt text-primary me-2"></i>+62 812 6408 0741</small>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light py-lg-0 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
        <a href="{{ route('home') }}" class="navbar-brand ms-4 ms-lg-0">
            <h1 class="display-5 text-primary m-0">SiKecilSehat</h1>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="{{ route('home') }}" class="nav-item nav-link active">Home</a>
                @auth
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                                class="fas fa-user-alt text-primary me-2"></i> {{ auth()->user()->name }}</a>
                        <div class="dropdown-menu border-light m-0">
                            <a href="{{ route('dashboard') }}" class="dropdown-item"><i
                                    class="fas fa-columns text-primary me-2"></i>Dashboard</a>
                            <a href="{{ route('logout') }}" class="dropdown-item"><i
                                    class="fas fa-sign-out-alt text-primary me-2"></i> Logout</a>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="nav-item nav-link"><i
                            class="fas fa-sign-in-alt text-primary me-2"></i> Login</a>
                @endauth
            </div>
        </div>
    </nav>
</div>
<!-- Navbar End -->
