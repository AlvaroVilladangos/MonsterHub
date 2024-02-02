@extends('compartidos.headerAndFooter')

@section('content')

<div class="container py-4">

  <form action="{{route('weapons')}}" method="get"> 
    @csrf
    <div class="input-group mb-4 w-25" id="search-box">
      <input name="search" type="search" class="form-control" placeholder="Search" />
      <button type="submit" class="btn  btn-aceptar">search</button>
    </div>
  </form>

  <h2 class="tituloTabla">Lista de armas</h2>
    <table class="table table-hover table-borderless">
        <tr class="table-dark">
          <th class="text-center">Imagen</th>
          <th class="text-center">Arma</th>
          <th class="text-center">Elemento</th>
          <th class="text-center">Ataque</th>
          <th class="text-center">Crítico</th>
        </tr>
    
        @foreach ($weapons as $weapon )        
        <tr class="border-bottom">
          <td class="d-flex justify-content-center"> <img src="{{URL('storage/' . $weapon->img)}}" style="width:150px; height:auto;" alt=""></td>
          <td class="align-middle text-center"><a href="/weapon/{{$weapon->id}}  "class="linkTabla">{{$weapon->name}}</a></td>
          <td class="align-middle text-center">{{$weapon->element}}</td>
          <td class="align-middle text-center">{{$weapon->atk}}  <img class="icon" src="{{ URL('storage/blackSwordIcon.svg') }}" /></td>
          <td class="align-middle text-center">{{$weapon->crit}}</td>
        </tr>
        @endforeach
    </table>

    {{$weapons->links()}}
</div>

@endsection