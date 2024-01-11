@extends('compartidos.headerAndFooter')


@section('content')


    <div  class="container py-4">
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-2 mb-3">
                <div class="card overflow-hidden">
                    <div class="card-body pt-3">
                        <ul class="nav nav-link-secondary flex-column fw-bold gap-2 text-start">
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="/rooms">
                                    <span>Salas</span></a>
                            </li>
                            <li class="nav-item">
                                @if ($hunter->guild_id == null)
                                    <a class="nav-link text-dark" href="/guilds"> <span>Guild</span></a>
                                @else
                                    <a class="nav-link text-dark" href="/guild/{{ $hunter->guild_id }}">
                                        <span>Guild</span></a>
                                @endif
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="/edit">
                                    <span>Ajustes</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="/friends">
                                    <span>Amigos</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-8 mb-3">
                <div class="card">
                    <div class="px-3 pt-4 pb-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <img style="width: 50px" class="me-3 avatar-sm rounded-circle"
                                    src="{{ URL('storage/' . $hunter->img) }}" />
                                <div>
                                    <h3 class="card-title mb-0">
                                        <p> {{ $hunter->name }} </p>
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label for="armadura" class="fw-bold">ARMA</label>
                                <p>{{ $hunter->weapon->name }}</p>
                            </div>

                            <div class="col">
                                <label for="armadura" class="fw-bold">ARMADURA</label>
                                <p>{{ $hunter->armor->name }}</p>
                            </div>


                            <div class="col">
                                <label for="" class="fw-bold">GUILD</label>

                               @isset($hunter->guild)
                               <p> <a class="nav-item nav-link" href="/guild/{{$hunter->guild->id}}">{{ $hunter->guild ? $hunter->guild->name : '' }} </a> </p>
                               @else
                               @endisset
                            </div>
                        </div>
                        <div class="px-2 mt-4">
                            <h5 class="fs-5">Bio :</h5>
                            <p class="fs-6 fw-light">
                                {{ $hunter->bio }}
                            </p>
                            <div class="mt-3">

                            </div>
                        </div>
                    </div>
                </div>


                @foreach ($comments as $comment)
                    <div class="mt-3">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <img style="width: 50px" class="me-2 avatar-sm rounded-circle"
                                        src="{{ URL('storage/' . $comment->hunter->img) }}" />
                                    <div class="w-100">
                                        <div class="d-flex justify-content-between">
                                            <h4 class=""><a class="nav-item nav-link"  href="/hunter/{{ $comment->hunter->id }}">
                                                    {{ $comment->hunter->name }}</a> </h4>
                                        </div>
                                        <p class="fs-6 mt-3 fw-light">
                                            {{ $comment->msg }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            @isset($hunter->room)
                <div class="col-2 mb-3">
                     <div class="card" style="width: 18rem;">
                        <img style="" class="card-img-top"
                        src="{{ URL('storage/' . $hunter->room->monster->img) }}" />
                        <div class="card-body">
                          <h5 class="card-title">Codigo: {{ $hunter->room->room_number }}</h5>
                          <h2>Cazadores</h2>
                          <ul>
                              @foreach ($hunter->room->hunters as $hunterInRoom)
                                  @if ($hunterInRoom->id != Auth::user()->hunter->id)
                                      <li><a
                                              href="/hunter/{{ $hunterInRoom->id }}"class="nav-link text-decoration-underline">
                                              {{ $hunterInRoom->name }}</a></li>
                                  @endif
                              @endforeach
                          </ul>
                          <form action="{{ route('hunter.leaveRoom') }}" method="post">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-primary">Salir</button>
                        </form>
                        </div>
                      </div>
                      
                  
                </div>
            @else
            @endisset
        </div>
    </div>
@endsection
