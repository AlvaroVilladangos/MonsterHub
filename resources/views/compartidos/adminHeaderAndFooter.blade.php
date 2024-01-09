<!DOCTYPE html>
<html lang="ES">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>MonsterHub</title>
    @vite('/resources/css/bootstrap.min.css')
    <link href="bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />

        <style>
            background-image: url("/storage/fondo.jpeg");
            body {
                background-image: url();
                background-repeat: no-repeat;
                background-size: cover;
            }
        </style>


@vite('resources/js/app.js')
@vite('resources/css/app.css')
@vite('resources/css/admin.css')
</head>


{{-- d-flex flex-column min-vh-100
 --}}<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        @if (auth()->check())
        <a class="navbar-brand" href="/indexAdmin">MonsterHub</a>
        @else
        <a class="navbar-brand" href="/">MonsterHub</a>
        @endif
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
            </div>

            <div class="ms-auto">
                @if (auth()->check())
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-primary mx-3" type="submit">Logout</button>
                </form>
                @else
                <a class="btn btn-light mx-3" href="/login">Login</a>
                <a class="btn btn-light mx-3" href="/registrar">Registrar</a>
                @endif
            
            </div>
        </div>
    </nav>



    {{--contenido--}}

    @yield('content')

   
    <footer class="mt-auto bg-dark">
        <div class="container text-light">
            <div class="col-md-4 d-flex ">
                <span class="mb-3 mb-md-0 text-light">© 2023 MonsterHub</span>
            </div>
            <a href="#">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white"
                    class="bi bi-twitter" viewBox="0 0 16 16">
                    <path
                        d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15" />
                </svg>
            </a>
        </div>
    </footer>

    <div id="cb-cookie-banner" class="alert alert-dark text-center bg-dark mb-0" role="alert">
        <p class="text-light"> 🍪 Esta paginautiliza cookies para un mejor uso de la página. </p>
        <a class="text-light" href="https://www.cookiesandyou.com/" target="blank">Aprender más</a>
        <button type="button" class="btn btn-primary btn-sm ms-3" onclick="window.cb_esconderCookieBanner()">
            Entendido
        </button>
    </div>


    @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

</body>

</html>
