

@extends('compartidos.headerAndFooter')


@section('content')

<div class="container py-4">
    <div class="row">
        <div class="col-auto mb-3">
            <div class="card overflow-hidden">
                <div class="card-body pt-3">
                    <ul class="nav nav-link-secondary flex-column fw-bold gap-2 text-start">
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="/salas">
                                <span>Salas</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="/guilds"> <span>Guild</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="/edit">
                                <span>Ajustes</span></a>
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
                                src="https://api.dicebear.com/6.x/fun-emoji/svg?seed=Mario" alt="Mario Avatar" />
                            <div>
                                <h3 class="card-title mb-0"><p> {{Auth::user()->hunter->name}} </p></h3>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <label for="armadura" class="fw-bold">ARMA</label>
                            <a class="nav-link" href="#">{{$weapon->name}}</a>
                        </div>

                        <div class="col">
                            <label for="armadura" class="fw-bold">ARMADURA</label>
                            <a class="nav-link" href="#">{{$armor->name}}</a>
                        </div>
                    </div>
                    <div class="px-2 mt-4">
                        <h5 class="fs-5">Bio :</h5>
                        <p class="fs-6 fw-light">
                            {{Auth::user()->hunter->bio}}
                        </p>
                        <div class="mt-3">
                            <button class="btn btn-primary btn-sm">Comentar</button>
                        </div>
                    </div>
                </div>
            </div>
            <hr />


            @foreach ($comments as $comment )
                
            <div class="mt-3">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <img style="width: 35px" class="me-2 avatar-sm rounded-circle"
                                src="https://api.dicebear.com/6.x/fun-emoji/svg?seed=Luigi" alt="Luigi Avatar" />
                            <div class="w-100">
                                <div class="d-flex justify-content-between">
                                    <h6 class="">{{$comment->hunter->name}}</h6>
                                </div>
                                <p class="fs-6 mt-3 fw-light">
                                    {{$comment->msg}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach


        </div>
        <div class="col-auto mb-3">
            <div class="card overflow-hidden">
                <div class="card-body pt-3">
                    <table class="table table-hover text-center">
                        <thead>
                          <tr class="table-dark">
                            <th scope="col">Amigos</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td> Miembro </td>
                          </tr>
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection