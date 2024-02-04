@extends('compartidos.headerAndFooter')




@section('content')
    @if (session('error'))
        <div class="position-absolute top-50 start-50 translate-middle">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8 col-md-6">
                <div class="card mx-3 my-3 shadow">
                    
                    <form class="form mx-3 my-3" action="{{ route('login') }}" method="post">
                        @csrf   
                        <div class="text-center">
                            <img class="avatarLogin" src="{{ URL('storage/monsterHub.svg') }}" />
                        </div>
                        <h3 class="text-center tituloCard">Login</h3>
                        <div class="form-group">
                            <label for="email" class="fw-bold fs-5">Email:</label><br>
                            <input type="email" name="email" id="email" class="form-control">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="password" class="fw-bold fs-5">Password:</label><br>
                            <input type="password" name="password" id="password" class="form-control">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="remember-me" class="text-dark"></label><br>
                            <input type="submit" name="submit" class="btn btn-aceptar btn-md" value="Iniciar sesión">
                        </div>
                        <div class="text-right mt-2">
                            <a href="/register" class="text-light">Register here</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
