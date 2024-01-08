@extends('compartidos.adminHeaderAndFooter')


@section('content')

    <div class="container py-4">

        <form action="{{route('monsters')}}" method="get"> 
          <div class="input-group mb-4 w-25" id="search-box">
            <input name="search" type="search" class="form-control" placeholder="Search" />
            <button type="submit" class="btn btn-dark">search</button>
          </div>
        </form>
      
      
          <table class="table table-hover table-borderless">
              <tr class="table-dark ">
                <th class="text-center">Nombre</th>
                <th class="text-center">Cazador</th>
                <th class="text-center">Email</th>
                <th class="text-center">Bloqueado</th>
                <th class="text-center">Accion</th>
              </tr>
          
              @foreach ($users as $user )
              @if (Auth::user()->id == $user->id)
              @continue

              @endif        
              <tr>
                <td class="align-middle text-center">{{$user->name}}</td>
                <td class="align-middle text-center">{{$user->hunter->name}}</td>
                <td class="align-middle text-center">{{$user->email}}</a></td>


                @if ($user->blocked)
                <td class="align-middle text-center">Sí</td>
                <td class="align-middle text-center">

                    <form action="{{route('unBlockUser', ['id' => $user->id])}}"  method="post">
                        @csrf
                        @method('put')
                        <button class="btn btn-sm btn-success" type="submit">Desbloquear</button>
                    </form>

                </td>
                @else
                <td class="align-middle text-center">NO</td>
                <td class="align-middle text-center">

                    <form action="{{route('blockUser', ['id' => $user->id])}}" method="post">
                        @csrf
                        @method('put')
                        <button class="btn btn-sm btn-primary" type="submit">Bloquear</button>
                    </form>

                </td>
                @endif
              </tr>
              @endforeach
          </table>
      
          {{$users->links()}}
      </div>

@endsection