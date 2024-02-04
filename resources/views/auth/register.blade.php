@extends('compartidos.headerAndFooter')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8 col-md-6">
                <div class="card mx-3 my-3 shadow">
                    <form class="form mx-3 my-3" action="{{ route('registrar.store') }}" method="post">
                        @csrf

                        <div class="text-center">
                            <img class="avatarLogin" src="{{ URL('storage/monsterHub.svg') }}" />
                        </div>
                        <h3 class="text-center tituloCard">Register</h3>
                        <div class="form-group">
                            <label for="name" class="fw-bold fs-5">Nombre:</label><br>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="email" class="fw-bold fs-5">Email:</label><br>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="password" class="fw-bold fs-5">Password:</label><br>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="password_confirmation" class="fw-bold fs-5">Confirm Password:</label><br>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="remember-me" class="text-dark"></label><br>
                            <input type="submit" name="submit" class="btn btn-aceptar btn-md" value="Registrar" required>
                        </div>
                        <div class="text-right mt-2">
                            <a href="/login" class="text-light">Login here</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function() {
            jQuery.validator.addMethod("customemail", function(value, element) {
                return this.optional(element) || /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+(com|es)$/.test(value);
            }, "Por favor, introduce una dirección de correo válida con dominio .com o .es");

            $(".form").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 2,
                        maxlength: 15
                    },
                    email: {
                        required: true,
                        customemail: true
                    },
                    password: {
                        required: true,
                        minlength: 5
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
                    }
                },
                messages: {
                    name: {
                        required: "Por favor, introduce tu nombre",
                        minlength: "Tu nombre debe tener al menos 2 caracteres"
                    },
                    email: {
                        required: "Por favor, introduce tu correo electrónico",
                        customemail: "Por favor, introduce una dirección de correo válida con dominio .com o .es"
                    },
                    password: {
                        required: "Por favor, introduce tu contraseña",
                        minlength: "Tu contraseña debe tener al menos 5 caracteres"
                    },
                    password_confirmation: {
                        required: "Por favor, confirma tu contraseña",
                        equalTo: "Las contraseñas no coinciden"
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
    </script>
@endsection
