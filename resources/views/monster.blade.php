@extends('compartidos.headerAndFooter')

@section('content')
    <div class="px-4 py-4">

        <div class="row">

            <div class="col-12 col-md-4 mb-3">
                <div class="bg-dark list-group">
                    <h5 class="text-center text-light my-2 fw-bold">{{ $monster->name }}</h5>
                </div>

                <div style="background-color: #fcfcfc;">
                    <img style="max-height: 650px;" class="card-img-top py-3 px-3" src="{{ URL('storage/' . $monster->img) }}"
                        alt="Card image cap">
                </div>

                <ul class="bg-dark list-group mb-3 shadow">
                    <h5 class="card-title text-center text-light fw-bold">INFO</h5>
                    <li class="list-group-item list-group-item d-flex justify-content-between align-items-center lista">
                        <span class="mx-5">Elemento: </span> <span class="mx-5">
                            {{ $monster->element }}
                            @switch($monster->element)
                                @case('Fuego')
                                    <img class="icon" src="{{ URL('storage/fireIcon.png') }}" />
                                @break

                                @case('Agua')
                                    <img class="icon" src="{{ URL('storage/waterIcon.png') }}" />
                                @break

                                @case('Hielo')
                                    <img class="icon" src="{{ URL('storage/iceIcon.png') }}" />
                                @break

                                @case('Eléctrico')
                                    <img class="icon" src="{{ URL('storage/thunderIcon.png') }}" />
                                @break

                                @case('Dragón')
                                    <img class="icon" src="{{ URL('storage/dragonIcon.png') }}" />
                                @break

                                @case('Neutro')
                                    -
                                @break
                            @endswitch
                        </span>
                    </li>
                    <li class="list-group-item list-group-item d-flex justify-content-between align-items-center lista">
                        <span class="mx-5"> Debilidad:</span> <span class="mx-5">
                            {{ $monster->weakness }}
                            @switch($monster->weakness)
                                @case('Fuego')
                                    <img class="icon" src="{{ URL('storage/fireIcon.png') }}" />
                                @break

                                @case('Agua')
                                    <img class="icon" src="{{ URL('storage/waterIcon.png') }}" />
                                @break

                                @case('Hielo')
                                    <img class="icon" src="{{ URL('storage/iceIcon.png') }}" />
                                @break

                                @case('Eléctrico')
                                    <img class="icon" src="{{ URL('storage/thunderIcon.png') }}" />
                                @break

                                @case('Dragón')
                                    <img class="icon" src="{{ URL('storage/dragonIcon.png') }}" />
                                @break

                                @case('Neutro')
                                    -
                                @break
                            @endswitch
                        </span>
                    </li>
                    <li class="list-group-item list-group-item d-flex justify-content-between align-items-center lista">
                        <span class="mx-5">Arma:</span>
                        @isset($weapon)
                            <a href="{{ route('weapon.show', $weapon->id) }}"
                                class="link nombrePerfil mx-5">{{ $weapon->name }} <img class="avatarRoom"
                                    src="{{ URL('storage/weaponIcon.svg') }}" /></a>
                        @else
                            <span class="nav-link mx-5">N/A <img class="avatarRoom"
                                    src="{{ URL('storage/weaponIcon.svg') }}" /></span>
                        @endisset
                    </li>
                    <li class="list-group-item list-group-item d-flex justify-content-between align-items-center lista">
                        <span class="mx-5">Armadura:</span>
                        @isset($armor)
                            <a href="{{ route('armor.show', $armor->id) }}" class="link nombrePerfil mx-5">{{ $armor->name }}
                                <img class="avatarRoom" src="{{ URL('storage/armorIcon.svg') }}" /></a>
                        @else
                            <span class="nav-link mx-5">N/A <img class="avatarRoom"
                                    src="{{ URL('storage/armorIcon.svg') }}" /></span></span>
                        @endisset
                    </li>
                </ul>
            </div>

            <div class="col-12 col-md-8">
                <div class="card flex-grow-1" style="background-color:transparent;">
                    <div class="bg-card shadow my-3 mx-3">
                        <h2 class="border-bottom my-3 mx-3 tituloCard">Fisiología</h2>
                        <p class="fs-5 my-3 mx-3 flex-grow-1"> {{ $monster->physiology }} </p>

                        <h2 class="border-bottom my-3 mx-3 tituloCard">Habilidades</h2>
                        <p class="fs-5 my-3 mx-3 flex-grow-1"> {{ $monster->abilities }} </p>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
