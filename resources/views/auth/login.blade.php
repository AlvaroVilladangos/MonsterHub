
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
            <form class="form mt-5" action="{{ route('login') }}" method="post">
                @csrf
                <h3 class="text-center text-dark">Login</h3>
                <div class="form-group">
                    <label for="email" class="text-dark">Email:</label><br>
                    <input type="email" name="email" id="email" class="form-control">
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="password" class="text-dark">Password:</label><br>
                    <input type="password" name="password" id="password" class="form-control">
                    @error('password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="remember-me" class="text-dark"></label><br>
                    <input type="submit" name="submit" class="btn btn-dark btn-md" value="submit">
                </div>
                <div class="text-right mt-2">
                    <a href="/register" class="text-dark">Register here</a>
                </div>
            </form>
        </div>
    </div>
</div>



 @endsection