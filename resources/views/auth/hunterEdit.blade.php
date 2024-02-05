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

        @error('hunterName')
            <div class="position-absolute top-50 start-50 translate-middle" style="z-index: 1;">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @enderror


        <div class="row">
            <div class="col-12 col-md-2 mb-3">

            </div>
            <div class="col-12 col-md-8 mb-3">
                <div class="card shadow">
                    <form id="formEditHunter" enctype="multipart/form-data" method="post" action="{{ route('edit') }}">
                        @csrf
                        @method('PUT')
                        <div class="px-3 pt-4 pb-2">
                            <div class="d-flex align-items-center justify-content-between border-bottom">
                                <div class="d-flex align-items-center">
                                    <img class="avatar mb-1" src="{{ URL('storage/' . Auth::user()->hunter->img) }}" />
                                    <div class="ms-3">
                                        <h3 class="card-title mb-2 nombrePerfil"></h3>
                                        <input type="text" name="hunterName" class="form-control" id="hunterName"
                                            value="{{ Auth::user()->hunter->name }}">
                                    </div>
                                </div>
                                <div class="d-flex align-items-center ml-auto">

                                </div>
                            </div>
                            <div>
                                <label class="my-2" for=""> Imagen de perfil</label>
                                <input type="file" name="img" class="form-control">
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <span><img class="avatar" src="{{ URL('storage/weaponIcon.svg') }}" /></span>
                                    <label for="weapon" class="fw-bold">ARMA</label>
                                    <select size="1" name="weapon" id="weapon" class="select-control">
                                        @foreach ($weapons as $weapon)
                                            <option value="{{ $weapon->id }}"> {{ $weapon->name }} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col">
                                    <span><img class="avatar" src="{{ URL('storage/armorIcon.svg') }}" /></span>
                                    <label for="armor" class="fw-bold">ARMADURA</label>
                                    <select size="1" name="armor" id="armor" class="select-control">
                                        @foreach ($armors as $armor)
                                            <option value="{{ $armor->id }}"> {{ $armor->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="px-2 mt-4 border-top">
                                <h5 class="fs-5 mt-2 fw-bold">Bio :</h5>
                                <textarea style="resize: none" name="bio" id="" cols="30" rows="3">{{ Auth::user()->hunter->bio }}</textarea>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-aceptar">EDITAR</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>

                @foreach ($comments as $comment)
                    <div class="mt-3">
                        <div class="card mb-3 shadow">
                            <div class="card-body">
                                <div class="d-flex align-items-center border-bottom">
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <h3 class="card-title mb-2">
                                            <img class="avatar mb-1" src="{{ URL('storage/' . $comment->hunter->img) }}" />
                                            <a class="link nombrePerfil" href="/hunter/{{ $comment->hunter->id }}">
                                                {{ $comment->hunter->name }}
                                            </a>
                                        </h3>
                                        <form id="deleteForm-{{ $comment->id }}"
                                            action="{{ route('comment.destroy', $comment->id) }}" method="post"
                                            class="ml-auto">
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="btn btn-cerrar"
                                                onclick="confirmDelete({{ $comment->id }})">Borrar</button>
                                        </form>
                                    </div>
                                </div>
                                <div>
                                    <p class="fs-6 mt-3 fw-light">
                                        {{ $comment->msg }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>


            <div class="col-12 col-md-2 mb-3">
                <form id="deleteUserForm-{{ Auth::user()->id }}" action="{{ route('user.destroy', Auth::user()->id) }}"
                    method="post">
                    @csrf
                    @method('delete')
                    <button type="button" class="btn btn-cerrar btn-lg"
                        onclick="confirmDeleteUser({{ Auth::user()->id }})">Eliminar Usuario</button>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection


@section('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js"></script>


    <script>
        function confirmDelete(commentId) {

            Swal.fire({
                title: '¿Estás seguro que quieres borrar el comentario?',
                text: "No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#26555b',
                cancelButtonColor: '#d62b36',
                confirmButtonText: 'Sí',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm-' + commentId).submit();
                }
            })
        }

        function confirmDeleteUser(userId) {
            console.log(userId)
            Swal.fire({
                title: '¿Estás seguro que quieres borrar el usuario?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#26555b',
                cancelButtonColor: '#d62b36',
                confirmButtonText: 'Sí',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteUserForm-' + userId).submit();
                }
            })
        }
    </script>


    <script>
        $(document).ready(function() {
            $("#formEditHunter").validate({
                rules: {
                    hunterName: {
                        required: true,
                        minlength: 3,
                        maxlength: 15,
                        regex: /^[A-ZÁÉÍÓÚÑ][a-zA-ZáéíóúÁÉÍÓÚÑñ\s]*$/
                    },
                    img: {
                        extension: "jpeg|jpg|png|webp"
                    },
                    weapon: {
                        required: true
                    },
                    armor: {
                        required: true
                    },
                    bio: {
                        required: true,
                        minlength: 10
                    }
                },
                messages: {
                    hunterName: {
                        required: "Por favor, introduce tu nombre.",
                        maxlength: "Tu nombre debe tener como máximo 15 caracteres.",
                        minlength: "Tu nombre debe tener al menos 3 caracteres."
                    },
                    img: {
                        extension: "Por favor, selecciona una imagen válida (jpeg, jpg, png, gif)."
                    },
                    weapon: {
                        required: "Por favor, selecciona un arma."
                    },
                    armor: {
                        required: "Por favor, selecciona una armadura."
                    },
                    bio: {
                        required: "Por favor, introduce tu biografía.",
                        minlength: "Tu biografía debe tener al menos 10 caracteres."
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
            $.validator.addMethod("regex", function(value, element, regexpr) {
                return regexpr.test(value);
            }, "Por favor, introduce un valor válido, que empiece por mayúscula");
        });
    </script>
@endsection
