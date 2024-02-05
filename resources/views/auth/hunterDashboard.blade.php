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
                <div class="card cardOpciones overflow-hidden shadow ">
                    <div class="cardOpciones-body pt-3">
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
                        <div class="card cardOpciones mb-3 shadow">
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
            <x-hunter-room :hunter="$hunter"/>
            @else
            @endisset
        </div>
    </div>
@endsection
