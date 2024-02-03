@extends('compartidos.headerAndFooter')

@section('content')

<div class="container py-4">

  <form action="{{route('armors')}}" method="get">
    @csrf
    <div class="input-group mb-4 w-25" id="search-box">
      <input name="search" type="search" class="form-control" placeholder="Search" />
      <button type="submit" class="btn btn-aceptar">search</button>
    </div>
  </form>

    <h2 class="tituloTabla">Lista de armaduras</h2>
    <table class="table table-hover table-borderless">
        <tr class="table-dark">
          <th class="text-center">Img</th>
          <th class="text-center">Armadura</th>
          <th class="text-center">Defensa</th>
        </tr>
    
        @foreach ($armors as $armor )        
        <tr class="">
          <td class="d-flex justify-content-center border-bottom"> <img src="{{URL('storage/' . $armor->img)}}" style="width:150px; height:auto;" alt=""></td>
          <td class="align-middle text-center border-bottom"><a href="/armor/{{$armor->id}}  "class="linkTabla">{{$armor->name}}</a></td>
          <td class="align-middle text-center border-bottom">{{$armor->def}}  <img class="icon" src="{{ URL('storage/blackShieldIcon.svg') }}" /></td>
        </tr>
        @endforeach
    </table>

    {{$armors->links()}}
</div>

@endsection