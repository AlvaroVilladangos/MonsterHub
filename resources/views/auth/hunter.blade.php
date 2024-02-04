

@extends('compartidos.headerAndFooter')


@section('content')


<div class="container py-4">
    <div class="row">
        <div class="col-2 mb-3">

        </div>
        <div class="col-12 col-md-8 mb-3">
            <div class="card shadow">
                <div class="px-3 pt-4 pb-2">
                    <div class="d-flex align-items-center justify-content-between border-bottom">
                        <div class="d-flex align-items-center">
                            <img class="avatar mb-1" src="{{ URL('storage/' . $hunter->img) }}" />
                            <div class="ms-3">
                                <h3 class="card-title mb-2 nombrePerfil">
                                    <p> {{ $hunter->name }} </p>
                                </h3>
                            </div>
                        </div>
                        @if (auth()->user()->hunter && !auth()->user()->hunter->isInRelation($hunter->id))
                        <div class="mt-3">
                            <form action="{{ route('addfriend', ['requesterId' => auth()->user()->hunter->id, 'receiverId' => $hunter->id]) }}" method="post">
                                @csrf
                                <button class="btn btn-aceptar btn-sm" type="submit">Agregar</button>
                            </form>
                        </div>
                        @endif
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <span><img class="avatar" src="{{ URL('storage/weaponIcon.svg') }}" /></span>
                            <label for="armadura" class="fw-bold">ARMA</label>
                            <p>{{ $hunter->weapon->name }}</p>
                        </div>
        
                        <div class="col">
                            <span><img class="avatar" src="{{ URL('storage/armorIcon.svg') }}" /></span>
                            <label for="armadura" class="fw-bold">ARMADURA</label>
                            <p>{{ $hunter->armor->name }}</p>
                        </div>
        
                        <div class="col">
                            <span><img class="avatar" src="{{ URL('storage/guildIcon.svg') }}" /></span>
                            <label for="" class="fw-bold">GUILD</label>
                            @isset($hunter->guild)
                                <p> <a class="nav-item nav-link"
                                        href="/guild/{{ $hunter->guild->id }}">{{ $hunter->guild ? $hunter->guild->name : '' }}
                                    </a> </p>
                            @else
                            @endisset
                        </div>
                    </div>
                    <div class="px-2 mt-4 border-top">
                        <h5 class="fs-5 mt-2 fw-bold">Bio :</h5>
                        <p class="fs-6 fw-light">
                            {{ $hunter->bio }}
                        </p>
                        <div class="mt-3">
                            @if (auth()->user()->hunter)
                            <button x-data x-on:click="$dispatch('open-modal')" class="btn btn-aceptar btn-sm">Comentar</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div data-hunter-id="{{ $hunter->id }}">
                <x-modal-comment>
                </x-modal-comment>
            </div>
            
                 
            @foreach ($comments as $comment )
                
            <div class="mt-3">
                <div  class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <img style="width: 50px" class="me-2 avatar-sm rounded-circle"
                                src="{{URL('storage/' . $comment->hunter->img)}}" />
                            <div class="w-100">
                                <div class="d-flex justify-content-between">
                                    <h4><a class="nav-item nav-link" href="/hunter/{{ $comment->hunter->id }} " > {{$comment->hunter->name}}</a></h4>
                                </div>
                                <p class="fs-6 mt-3 fw-light">
                                    {{$comment->msg}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
           

            {{ $comments->links() }}


        </div>
        <div class="col-2 mb-3">
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js"></script>

@endsection