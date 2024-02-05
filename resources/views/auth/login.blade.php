@extends('compartidos.headerAndFooter')




@section('content')

@if ($errors->any())
    <div class="position-fixed top-50 start-50 translate-middle-x" style="z-index: 9999;">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if (session('success'))
<div class="position-fixed top-50 start-50 translate-middle-x" style="z-index: 9999;">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8 col-md-6">
                <div class="card mx-3 my-3 shadow">
                    <div class="row">
                        <
                        <div class="col-12 my-3 col-md-5 text-center">
                            <img class="avatarLogin" src="{{ URL('storage/monsterHub.svg') }}" />
                            <h3 class="tituloCard">¡Cazar acompañado siempre es mejor!</h3>
                        </div>

                      
                        <div class="col-12 col-md-6">
                            <form class="form my-3" action="{{ route('login') }}" method="post">
                                @csrf
                                <h3 class="tituloCard">Login</h3>
                                <div class="form-group">
                                    <label for="email" class="fw-bold fs-5">Email:</label><br>
                                    <input type="email" name="email" id="email" class="form-control">
                                    @error('email')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mt-3">
                                    <label for="password" class="fw-bold fs-5">Password:</label><br>
                                    <input type="password" name="password" id="password" class="form-control">
                                    @error('password')
                                        <span class="error">{{ $message }}</span>
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
        </div>
        
        
    </div>
@endsection
