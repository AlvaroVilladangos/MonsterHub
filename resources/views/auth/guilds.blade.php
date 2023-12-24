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
                <form action="{{route('guilds.index')}}" method="get"> 
                    <div class="input-group mb-4 w-25" id="search-box">
                    <input name="search" type="search" class="form-control" placeholder="Search" />
                    <button type="submit" class="btn btn-dark">search</button>
                    </div>
                </form>
                <table class="table table-hover table-borderless">
                    <tr class="table-dark">
                      <th class="text-center">Guild</th>
                      <th class="text-center">Lider</th>
                      <th class="text-center">Miembros</th>
                      <th></th>
                    </tr>
                
                    @foreach ($guilds as $guild )        
                    <tr>
                      <td class="d-flex justify-content-center">{{$guild->name}}</td>
                      <td class="align-middle text-center"><a href=""class="nav-link text-decoration-underline"> {{$guild->leader->name}}</a></td>
                      <td class="align-middle text-center"> {{$guild->memberCount()}}</td>
                      @if ($guild->memberCount() >= 1)
                        <td></td>
                      @else
                      <td><button class="btn btn-success">Unirse</button></td>
                      @endif  
                    </tr>
                    @endforeach
                </table>
            </div>


            <div class="col-auto">
                <button type="button" class="btn btn-info btn-lg" data-bs-toggle="modal" data-bs-target="#guildModal">
                    CREA TU GUILD AQUÍ
                </button>
            </div>
            
            <div class="modal fade" id="guildModal" tabindex="-1" aria-labelledby="guildModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title" id="guildModalLabel">Crear Guild</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">

                    <form method="post" action="{{route('guilds.store')}}">
                        @csrf
                      <div class="mb-3">
                        <label for="name" class="form-label">Nombre del Guild</label>
                        <input name="name" type="text" class="form-control" id="name">
                      </div>
                      <div class="mb-3">
                        <label for="info" class="form-label">Información</label>
                        <input name="info" type="text" class="form-control" id="info">
                      </div>
                      <div>
                        <input name="leader_id" type="text" value="{{Auth::user()->hunter->id}}" hidden>
                      </div>
                      <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                  </div>
                </div>
              </div>
            </div>
        </div>


    </div>
@endsection
