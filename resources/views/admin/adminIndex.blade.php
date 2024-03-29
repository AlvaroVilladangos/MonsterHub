@extends('compartidos.headerAndFooter')


@section('content')
    <div class="container">
        <div class="mx-4">

        
        <div class="row">
            <div class="col px-4 py-3 d-flex justify-content-center align-items-center">

                <div class="cardAdmin">
                    <div class="cardAdmin-details">
                        <div>
                            <img class="img-fluid rounde imgBorder" src="{{ asset('img/bannersIconos/usersBanner.jpg') }}">
                        </div>
                    </div>
                    <a class="cardAdmin-button nav-link" href ="/usersAdmin">Usuarios</a>
                </div>

            </div>

            <div class="col px-4 py-3 d-flex justify-content-center align-items-center">

                <div class="cardAdmin">
                    <div class="cardAdmin-details">
                        <div>
                            <img class="img-fluid rounded imgBorder" src="{{ asset('img/bannersIconos/armorsBanner.jpg') }}">
                        </div>
                    </div>
                    <a class="cardAdmin-button nav-link" href ="/armorsAdmin">Armaduras</a>
                </div>

            </div>
        </div>


        <div class="row">
            <div class="col px-4 py-3 d-flex justify-content-center align-items-center">

                <div class="cardAdmin">
                    <div class="cardAdmin-details">
                        <div>
                            <img class="img-fluid rounded imgBorder" src="{{ asset('img/bannersIconos/weaponsBanner.webp') }}">
                        </div>
                    </div>
                    <a class="cardAdmin-button nav-link" href ="/weaponsAdmin">Armas</a>
                </div>

            </div>

            <div class="col px-4 py-3 d-flex justify-content-center align-items-center">

                <div class="cardAdmin">
                    <div class="cardAdmin-details">
                        <div>
                            <img class="img-fluid rounded imgBorder" src="{{ asset('img/bannersIconos/monstersBanner.jpg') }}">
                        </div>
                    </div>
                    <a class="cardAdmin-button nav-link" href ="/monstersAdmin">Monstruos</a>
                </div>

            </div>
        </div>


        <div class="row">
            <div class="col px-4 py-3 d-flex justify-content-center align-items-center">
                <div class="cardAdmin">
                    <div class="cardAdmin-details">
                        <div>
                            <img class="img-fluid rounded imgBorder" src="{{ asset('img/bannersIconos/guildsBanner.jpeg') }}">
                        </div>
                    </div>
                    <a class="cardAdmin-button nav-link" href ="/guildsAdmin">Guilds</a>
                </div>
            </div>
        </div>

    </div>
    </div>
@endsection
