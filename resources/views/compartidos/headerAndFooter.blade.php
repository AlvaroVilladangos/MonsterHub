<!DOCTYPE html>
<html lang="ES">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>MonsterHub</title>
    @vite('/resources/css/bootstrap.min.css')

    <link rel="icon" href="{{ URL('storage/favicon.jpg') }}">

    @vite('resources/js/app.js')
    @vite('resources/css/app.css')

    <style>
        body {
            font-family: 'Helvetica';
            background-image: url('/storage/fondoPrueba.png');
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>

</head>


<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg colorNavBar">
        <span><img class="avatar mx-3 my-2" src="{{ URL('storage/monsterHub.svg') }}" /></span>
        @if (auth()->check())
            @if (auth()->user()->admin)
                <a class="navbar-brand navbarTitle" href="/indexAdmin">MonsterHub</a>
            @else
                <a class="navbar-brand navbarTitle" href="/dashboard">MonsterHub</a>
            @endif
        @else
            <a class="navbar-brand navbarTitle" href="/">MonsterHub</a>
        @endif
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link opcionNavBar mx-2" href="/monsters">Monstruos</a>
                <a class="nav-item nav-link opcionNavBar mx-2" href="/weapons">Armas</a>
                <a class="nav-item nav-link opcionNavBar mx-2" href="/armors">Armaduras</a>

                @if (auth()->check() && auth()->user()->hunter)
                    <a class="nav-item nav-link opcionNavBar mx-2" href="/guilds">Guilds</a>
                    <a class="nav-item nav-link opcionNavBar mx-2" href="/hunters">Cazadores</a>
                @endif
            </div>

            <div class="ms-auto d-flex align-items-center">
                @if (auth()->check())
                    @if (!auth()->user()->admin)
                        <div class="navbar-nav mx-2">
                            <img class="avatar mx-2" src="{{ URL('storage/' . auth()->user()->hunter->img) }}" />
                            <a class="nav-item nav-link navbarName"
                                href="/dashboard">{{ auth()->user()->hunter->name }}</a>
                        </div>
                    @else
                        <div class="navbar-nav">
                            <a class="nav-item nav-link" href="/indexAdmin">{{ auth()->user()->name }}</a>
                        </div>
                    @endif
                    <div class="navbar-nav">
                        <form method="post" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-cerrar mx-2" type="submit">Logout</button>
                        </form>
                    </div>
                @else
                    <a class="btn btn-light mx-3" href="/login">Login</a>
                    <a class="btn btn-light mx-3" href="/registrar">Registrar</a>
                @endif
            </div>

        </div>
    </nav>

    {{-- contenido --}}
    <div class="principal">
        @yield('content')
    </div>



    <footer class="mt-auto colorNavBar">
        <div class="colorNavBar text-light">
            <div class="col-md-4 d-flex  mx-3 my-3">
                <span class="mb-3 mb-md-0 text-light">© 2023 MonsterHub <a href="#" class="mx-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white"
                            class="bi bi-twitter" viewBox="0 0 16 16">
                            <path
                                d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15" />
                        </svg>
                    </a></span>
            </div>
        </div>
    </footer>


    @yield('scripts')


</body>

</html>
