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
                    <form method="post" action="{{ route('edit') }}">
                        @csrf
                        @method('PUT')
                    <div class="px-3 pt-4 pb-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <img style="width: 50px" class="me-3 avatar-sm rounded-circle"
                                    src="https://api.dicebear.com/6.x/fun-emoji/svg?seed=Mario" alt="Mario Avatar" />
                                <div>

                                        <div>
                                            <input type="text" name="hunterName" class ="form-control" id="hunterName"
                                                value="{{ Auth::user()->hunter->name }}"> </input>
                                        </div>

                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label for="weapon" class="fw-bold">ARMA</label>
                                <select name="weapon" id="weapon" class="select-control">
                                    @foreach ($weapons as $weapon)
                                        <option value="{{$weapon->id}}"> {{ $weapon->name }} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col">
                                <label for="armor" class="fw-bold">ARMADURA</label>
                                <select name="armor" id="armor" class="select-control">
                                    @foreach ($armors as $armor)
                                        <option value="{{$armor->id}}"> {{ $armor->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="px-2 mt-4">
                            <h5 class="fs-5">Bio :</h5>

                            <textarea style="resize: none" name="bio" id="" cols="50" rows="3">

                            {{ Auth::user()->hunter->bio }}
                        </textarea>

                            
                            <div class="mt-3">
                                <button  type="submit" class="btn btn-primary btn-sm">EDITAR</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <hr />




                <div class="mt-3">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex align-items-start">
                                <img style="width: 35px" class="me-2 avatar-sm rounded-circle"
                                    src="https://api.dicebear.com/6.x/fun-emoji/svg?seed=Luigi" alt="Luigi Avatar" />
                                <div class="w-100">
                                    <div class="d-flex justify-content-between">
                                        <h6 class=""></h6>
                                    </div>
                                    <p class="fs-6 mt-3 fw-light">

                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



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
