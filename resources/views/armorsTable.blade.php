@extends('compartidos.headerAndFooter')

@section('content')

<div class="container py-4">

  <form action="{{route('armors')}}" method="get">
    @csrf
    <div class="input-group mb-4 w-25" id="search-box">
      <input name="search" type="search" class="form-control" placeholder="Search" />
      <button type="submit" class="btn btn-dark">search</button>
    </div>
  </form>


    <table class="table table-hover table-borderless">
        <tr class="table-dark">
          <th class="text-center">Imagen</th>
          <th class="text-center">Armadura</th>
          <th class="text-center">Defensa</th>
        </tr>
    
        @foreach ($armors as $armor )        
        <tr>
          <td class="d-flex justify-content-center"> <img src="{{URL('storage/' . $armor->img)}}" style="width:150px; height:auto;" alt=""></td>
          <td class="align-middle text-center"><a href="/armor/{{$armor->id}}  "class="nav-link text-decoration-underline">{{$armor->name}}</a></td>
          <td class="align-middle text-center">{{$armor->def}}</td>
        </tr>
        @endforeach
    </table>

    {{$armors->links()}}
</div>

@endsection