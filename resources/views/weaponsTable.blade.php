@extends('compartidos.headerAndFooter')

@section('content')

<div class="container py-4">

  <form action="{{route('weapons')}}" method="get"> 
    @csrf
    <div class="input-group mb-4 w-25" id="search-box">
      <input name="search" type="search" class="form-control" placeholder="Search" />
      <button type="submit" class="btn btn-dark">search</button>
    </div>
  </form>


    <table class="table table-hover table-borderless">
        <tr class="table-dark">
          <th class="text-center">Imagen</th>
          <th class="text-center">Arma</th>
          <th class="text-center">Elemento</th>
          <th class="text-center">Ataque</th>
          <th class="text-center">Crítico</th>
        </tr>
    
        @foreach ($weapons as $weapon )        
        <tr>
          <td class="d-flex justify-content-center"> <img src="{{URL('storage/' . $weapon->img)}}" style="width:150px; height:auto;" alt=""></td>
          <td class="align-middle text-center"><a href="/weapon/{{$weapon->id}}  "class="nav-link text-decoration-underline">{{$weapon->name}}</a></td>
          <td class="align-middle text-center">{{$weapon->element}}</td>
          <td class="align-middle text-center">{{$weapon->atk}}</td>
          <td class="align-middle text-center">{{$weapon->crit}}</td>
        </tr>
        @endforeach
    </table>

    {{$weapons->links()}}
</div>

@endsection