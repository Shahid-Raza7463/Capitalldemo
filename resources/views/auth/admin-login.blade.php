
@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-center text-center h-100vh" style="background-image:url('backEnd/image/unnamed.jpg');">
    <div class="form-wrapper m-auto">
        <div class="form-container my-4">
         
            <div class="panel">
                 @if(session()->has('error'))
                <div class="alert alert-danger">
                     {{ session()->get('error') }}
                 </div>
             @endif
              <div class="register-logo text-center mb-4">
                <img src="{{ url('backEnd/image/kgsomani.png')}}" style="width: 60%;height: 70%;" alt="">
            </div><br>
                <form  method="POST" action="{{ route('admin.login') }}">
                    @csrf
                    <div class="form-group">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="emial" placeholder="Enter email"  value="{{ old('email') }}" required autocomplete="email" autofocus>
                       
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                        <div class="invalid-feedback text-left">Enter your valid email</div>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" id="pass" placeholder="Password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                    <div class="custom-control custom-checkbox mb-3">
                        <input class="custom-control-input" id="customCheck1" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="customCheck1">    {{ __('Remember Me') }} next time </label>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Sign in</button>
                </form>
            </div>
            {{-- <div class="bottom-text text-center my-3">
                Don't have an account? <a href="register.html" class="font-weight-500">Sign Up</a><br>
                Remind 
                @if (Route::has('password.request'))
                <a  href="{{ route('password.request') }}" class="font-weight-500">Password</a>
                @endif
            </div> --}}
        </div>
    </div>
</div>
@endsection