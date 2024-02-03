@extends('compartidos.headerAndFooter')

@section('content')

<div class="container py-4">

  <form action="{{route('monsters')}}" method="get"> 
    @csrf
    <div class="input-group mb-4 w-25" id="search-box">
      <input name="search" type="search" class="form-control" placeholder="Search" />
      <button type="submit" class="btn btn-aceptar">search</button>
    </div>
  </form>

  <h2 class="tituloTabla">Lista de monstruos</h2>
  <div class="table-responsive table-responsive-stack">
    <table class="table table-hover table-borderless">
      <tr class="table-dark ">
        <th class="text-center">Img</th>
        <th class="text-center">Monstruo</th>
        <th class="text-center">Elemento</th>
        <th class="text-center">Debilidad</th>
      </tr>
  
      @foreach ($monsters as $monster )        
      <tr class="">
        <td data-label="Imagen" class="d-flex justify-content-center border-bottom"> <img src="{{URL('storage/' . $monster->img)}}" class="monsterTable" alt=""></td>
        <td data-label="Monstruo" class="align-middle text-center border-bottom"><a href="/monster/{{$monster->id}} " class="linkTabla">{{$monster->name}}</a></td>
        <td data-label="Elemento" class="align-middle text-center border-bottom">{{$monster->element}}</td>
        <td data-label="Debilidad" class="align-middle text-center border-bottom">{{$monster->weakness}}</td>
      </tr>
      @endforeach
    </table>
  </div>
  
      
    {{$monsters->links()}}
</div>

@endsection