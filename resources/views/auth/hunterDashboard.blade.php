@extends('compartidos.headerAndFooter')


@section('content')

    <div class="container py-4">
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-12 col-md-2 mb-3">
                <div class="card overflow-hidden shadow">
                    <div class="card-body pt-3">
                        <ul class="nav nav-link-secondary flex-column fw-bold gap-2 text-start nav-item">
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="/rooms">
                                    <span><img class="icon" src="{{ URL('storage/roomIcon.svg') }}" /></span>
                                    <span class="link">Salas</span></a>
                            </li>
                            <li class="nav-item border-top">
                                @if ($hunter->guild_id == null)
                                    <a class="nav-link text-dark" href="/guilds">
                                        <span><img class="icon" src="{{ URL('storage/guildIcon.svg') }}" /></span>
                                        <span class="link">Guild</span>
                                    </a>
                                @else
                                    <a class="nav-link text-dark" href="/guild/{{ $hunter->guild_id }}">
                                        <span><img class="icon" src="{{ URL('storage/guildIcon.svg') }}" /></span>
                                        <span class="link">Guild</span></a>
                                @endif
                            </li>
                            <li class="nav-item border-top">
                                <a class="nav-link text-dark" href="/edit">
                                    <span><img class="icon" src="{{ URL('storage/settingIcon.svg') }}" /></span>
                                    <span class="link">Ajustes</span></a>
                            </li>
                            <li class="nav-item border-top">
                                <a class="nav-link text-dark" href="/friends">
                                    <span><img class="icon" src="{{ URL('storage/userIcon.svg') }}" /></span>
                                    <span class="link">Amigos</span>
                                    @if ($hunter->hasPendingRequest())
                                        <span class="badge bg-warning">Nueva solicitud</span>
                                    @endif
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8 mb-3">
                <div class="card shadow">
                    <div class="px-3 pt-4 pb-2">
                        <div class="d-flex align-items-center justify-content-between border-bottom">
                            <div class="d-flex align-items-center">
                                <img class="avatar mb-1" src="{{ URL('storage/' . $hunter->img) }}" />
                                <div class="ms-3">
                                    <h3 class="card-title mb-2 nombrePerfil">
                                        <p> {{ $hunter->name }} </p>
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <span><img class="avatar" src="{{ URL('storage/weaponIcon.svg') }}" /></span>
                                <label for="armadura" class="fw-bold">ARMA</label>
                                <p>{{ $hunter->weapon->name }}</p>
                            </div>

                            <div class="col">
                                <span><img class="avatar" src="{{ URL('storage/armorIcon.svg') }}" /></span>
                                <label for="armadura" class="fw-bold">ARMADURA</label>
                                <p>{{ $hunter->armor->name }}</p>
                            </div>

                            <div class="col">
                                <span><img class="avatar" src="{{ URL('storage/guildIcon.svg') }}" /></span>
                                <label for="" class="fw-bold">GUILD</label>

                                @isset($hunter->guild)
                                    <p> <a class="nav-item nav-link"
                                            href="/guild/{{ $hunter->guild->id }}">{{ $hunter->guild ? $hunter->guild->name : '' }}
                                        </a> </p>
                                @else
                                @endisset
                            </div>
                        </div>
                        <div class="px-2 mt-4 border-top">
                            <h5 class="fs-5 mt-2 fw-bold">Bio :</h5>
                            <p class="fs-6 fw-light">
                                {{ $hunter->bio }}
                            </p>
                        </div>
                    </div>
                </div>


                @foreach ($comments as $comment)
                    <div class="mt-3">
                        <div class="card mb-3 shadow">
                            <div class="card-body">
                                <div class="d-flex align-items-center border-bottom">
                                    <img class="avatar mb-1" src="{{ URL('storage/' . $comment->hunter->img) }}" />
                                    <div class="ms-3">
                                        <h3 class="card-title mb-2">
                                            <a class="link nombrePerfil" href="/hunter/{{ $comment->hunter->id }}">
                                                {{ $comment->hunter->name }}
                                            </a>
                                        </h3>
                                    </div>
                                </div>
                                <div>
                                    <p class="fs-6 mt-3 fw-light">
                                        {{ $comment->msg }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            @isset($hunter->room)
                <div class="col-12 col-md-2 mb-3">
                    <div class="card shadow" style="width: 18rem;">
                        <div class="mx-2 my-2 d-flex justify-content-between">
                            <div class="d-flex justify-content-center flex-grow-1">
                                <h3 class="card-title fw-bold">Codigo: {{ $hunter->room->room_number }}</h3>
                            </div>
                            <div>
                                <form action="{{ route('hunter.leaveRoom') }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-cerrar">Salir</button>
                                </form>
                            </div>
                        </div>

                        <div style="background-color: white; border-radius: 5px;" class="mx-2 my-2">
                            <img style="" class="card-img-top avatarMonsterRoom mx-1 my-2"
                                src="{{ URL('storage/' . $hunter->room->monster->img) }}" />
                        </div>
                        <div class="card-body">
                            <div class="list-unstyled d-flex align-items-center">
                                <img class="avatarRoom" src="{{ URL('storage/monsterIcon.svg') }}" />
                                <h5 class="card-title mx-2 my-2">{{ $hunter->room->monster->name }}</h5>
                            </div>
                            <h5 class="mx-2 my-2 border-bottom">Cazadores</h5>
                            <ul>
                                @foreach ($hunter->room->hunters as $hunterInRoom)
                                    @if ($hunterInRoom->id != Auth::user()->hunter->id)
                                        <li class="list-unstyled">
                                            <div class=" d-flex align-items-center mx-2 my-2">
                                                <img class="avatarRoom" src="{{ URL('storage/' . $hunterInRoom->img) }}" />
                                                <a href="/hunter/{{ $hunterInRoom->id }}" class="nav-link ms-3 link">
                                                    {{ $hunterInRoom->name }}</a>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>

                        </div>
                    </div>
                </div>
            @else
            @endisset
        </div>
    </div>
@endsection
