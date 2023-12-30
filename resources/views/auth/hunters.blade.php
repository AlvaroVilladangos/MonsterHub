@extends('compartidos.headerAndFooter')

@section('content')
    <div class="container py-4">

        <form action="{{ route('hunters') }}" method="get">
            <div class="input-group mb-4 w-25" id="search-box">
                <input name="search" type="search" class="form-control" placeholder="Search" />
                <button type="submit" class="btn btn-dark">search</button>
            </div>
        </form>


        <table class="table table-hover table-borderless">
            <tr class="table-dark ">
                <th class="text-center">Hunter</th>
                <th class="text-center">Guild</th>
                <th class="text-center"></th>
            </tr>


            @foreach ($hunters as $hunter)
                <tr>
                    <td class="align-middle text-center"><a
                            href="/hunter/{{ $hunter->id }}  "class="nav-link text-decoration-underline">{{ $hunter->name }}</a>
                    </td>
                    @isset($hunter->guild)
                        <td class="align-middle text-center"><a href="/guild/{{$hunter->guild->id}}">{{ $hunter->guild->name }}</a>
                            </td>
                    @else
                        <td class="align-middle text-center">N/A</td>
                    @endisset
                    <td class="align-middle text-center"></td>
                </tr>
            @endforeach
        </table>

        {{ $hunters->links() }}
    </div>
@endsection
