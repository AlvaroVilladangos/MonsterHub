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
    <table class="table table-hover table-borderless">
        <tr class="table-dark ">
          <th class="text-center">Imagen</th>
          <th class="text-center"> Monstruo</th>
          <th class="text-center">Elemento</th>
          <th class="text-center">Debilidad</th>
        </tr>
    
        @foreach ($monsters as $monster )        
        <tr class="border-bottom">
          <td class="d-flex justify-content-center"> <img src="{{URL('storage/' . $monster->img)}}" style="width:150px; height:auto;" alt=""></td>
          <td class="align-middle text-center"><a href="/monster/{{$monster->id}} " class="linkTabla">{{$monster->name}}</a></td>
          <td class="align-middle text-center">{{$monster->element}}</td>
          <td class="align-middle text-center">{{$monster->weakness}}</td>
        </tr>
        @endforeach
    </table>

    {{$monsters->links()}}
</div>

@endsection