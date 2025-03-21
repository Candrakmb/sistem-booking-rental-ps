<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental PS</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Rental PS</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Registrasi</a>
                </li>
            </ul>
        </div>
    </nav>

    <header class="bg-dark text-white text-center py-5">
        <h1>Welcome to Rental PS</h1>
        <p>Your ultimate destination for PlayStation rentals</p>
    </header>

    <section class="container my-5 text-center">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <img src="{{ asset('asset/logo ps.png') }}" class="card-img-top" alt="PS4">
                    <div class="card-body">
                        <h5 class="card-title">PlayStation 4</h5>
                        <p class="card-text">Rent the latest PlayStation 4 games and consoles.</p>
                        <a href="#" class="btn btn-primary">Rent Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="{{ asset('asset/logo ps.png') }}" class="card-img-top" alt="PS5">
                    <div class="card-body">
                        <h5 class="card-title">PlayStation 5</h5>
                        <p class="card-text">Experience the next-gen gaming with PlayStation 5.</p>
                        <a href="#" class="btn btn-primary">Rent Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container my-5">
        <h2 class="text-center">Keunggulan Rental PS</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Harga Terjangkau</h5>
                        <p class="card-text">Kami menawarkan harga sewa yang kompetitif dan terjangkau untuk semua kalangan.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Koleksi Terbaru</h5>
                        <p class="card-text">Kami selalu menyediakan koleksi game dan konsol terbaru untuk pengalaman bermain yang maksimal.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Layanan Pelanggan</h5>
                        <p class="card-text">Layanan pelanggan kami siap membantu Anda dengan segala kebutuhan dan pertanyaan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2023 PS Rental. All rights reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
