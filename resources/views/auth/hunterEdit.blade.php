@extends('compartidos.headerAndFooter')


@section('content')
    <div class="container py-4">
        @if (session('error'))
            <div class="position-absolute top-50 start-50 translate-middle" style="z-index: 1;">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-2 mb-3">

            </div>
            <div class="col-8 mb-3">

                <div class="card">
                    <form enctype="multipart/form-data" method="post" action="{{ route('edit') }}">
                        @csrf
                        @method('PUT')
                        <div class="px-3 pt-4 pb-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img style="width: 50px" class="me-3 avatar-sm rounded-circle"
                                        src="{{ URL('storage/' . Auth::user()->hunter->img) }}" />

                                    <div>
                                        <input type="text" name="hunterName" class ="form-control" id="hunterName"
                                            value="{{ Auth::user()->hunter->name }}"> </input>
                                    </div>

                                </div>
                            </div>

                            <div>
                                <label for=""> Imagen de perfil</label>
                                <input type="file" name="img" class="form-control">
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label for="weapon" class="fw-bold">ARMA</label>
                                    <select size="1" name="weapon" id="weapon" class="select-control">
                                        @foreach ($weapons as $weapon)
                                            <option value="{{ $weapon->id }}"> {{ $weapon->name }} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col">
                                    <label for="armor" class="fw-bold">ARMADURA</label>
                                    <select size="1" name="armor" id="armor" class="select-control">
                                        @foreach ($armors as $armor)
                                            <option value="{{ $armor->id }}"> {{ $armor->name }} </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="px-2 mt-4">
                                <h5 class="fs-5">Bio :</h5>

                                <textarea style="resize: none" name="bio" id="" cols="30" rows="3">{{ Auth::user()->hunter->bio }}
                        </textarea>


                                <div class="mt-3">
                                    <button type="submit" class="btn btn-dark btn-sm">EDITAR</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <hr />

                @foreach ($comments as $comment)
                    <div class="mt-3">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <img style="width: 50px" class="me-2 avatar-sm rounded-circle"
                                        src="{{ URL('storage/' . $comment->hunter->img) }}" />
                                    <div class="w-100">
                                        <div class="d-flex justify-content-between">
                                            <h4 class="">{{ $comment->hunter->name }}</h4>
                                            <form id="deleteForm-{{ $comment->id }}"
                                                action="{{ route('comment.destroy', $comment->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="button" class="btn btn-sm btn-primary"
                                                    onclick="confirmDelete({{ $comment->id }})">Borrar</button>
                                            </form>
                                        </div>
                                        <p class="fs-6 mt-3 fw-light">
                                            {{ $comment->msg }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
            <div class="col-2 mb-3">

            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        function confirmDelete(commentId) {
            Swal.fire({
                title: '¿Estás seguro que quieres borrar el comentario?',
                text: "No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm-' + commentId).submit();
                }
            })
        }
    </script>
@endsection
