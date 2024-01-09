@extends('compartidos.adminHeaderAndFooter')


@section('content')
    <div class="container">

        <div class="row">
            <div class="col px-4 py-3">

                <div class="card">
                    <div class="card-details">
                        <div>
                            <img class="img-fluid rounded" src="{{ URL('storage/usersBanner.jpg') }}">
                        </div>
                    </div>
                    <a class="card-button nav-link" href ="/usersAdmin">Usuarios</a>
                </div>

            </div>

            <div class="col px-4 py-3">

                <div class="card">
                    <div class="card-details">
                        <div>
                            <img class="img-fluid rounded" src="{{ URL('storage/armorsBanner.jpg') }}">
                        </div>
                    </div>
                    <a class="card-button nav-link" href ="/armorsAdmin">Armaduras</a>
                </div>

            </div>
        </div>


        <div class="row">
            <div class="col px-4 py-3">

                <div class="card">
                    <div class="card-details">
                        <div>
                            <img class="img-fluid rounded" src="{{ URL('storage/weaponsBanner.jpg') }}">
                        </div>
                    </div>
                    <a class="card-button nav-link" href ="/weaponsAdmin">Armas</a>
                </div>

            </div>

            <div class="col px-4 py-3">

                <div class="card">
                    <div class="card-details">
                        <div>
                            <img class="img-fluid rounded" src="{{ URL('storage/monsterBanner.webp') }}">
                        </div>
                    </div>
                    <a class="card-button nav-link" href ="/monstersAdmin">Monstruos</a>
                </div>

            </div>
        </div>
    </div>
@endsection
