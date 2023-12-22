@extends('compartidos.headerAndFooter')

@section('content')

<div class="container py-4">
    <table class="table table-hover table-bordered  ">
        <tr class="table-dark">
          <th class="text-center">Imagen</th>
          <th class="text-center"> Monstruo</th>
          <th class="text-center">Elemento</th>
          <th class="text-center">Debilidad</th>
        </tr>
    
        @foreach ($monsters as $monster )        
        <tr>
          <td class="d-flex justify-content-center"> <img src="{{URL('storage/' . $monster->img)}}" style="width:150px; height:auto;" alt=""></td>
          <td class="align-middle text-center"><a href="/monster/{{$monster->id}}  "class="nav-link">{{$monster->name}}</a></td>
          <td class="align-middle text-center">{{$monster->element}}</td>
          <td class="align-middle text-center">{{$monster->weakness}}</td>
        </tr>
        @endforeach
    </table>

    {{$monsters->links()}}
</div>

@endsection