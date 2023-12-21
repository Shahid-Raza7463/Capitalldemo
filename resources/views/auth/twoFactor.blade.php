
@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-center text-center h-100vh" style="background-image:url('backEnd/image/unnamed.jpg');">
    <div class="form-wrapper m-auto">
        <div class="form-container my-4">
           
            <div class="panel">
                <div class="register-logo text-center mb-4">
                <img src="{{ url('backEnd/image/vlogo.png')}}" style="width: 100%;" alt="">
            </div><br>
            @if(session()->has('message'))
    <p class="alert alert-info">
        {{ session()->get('message') }}
    </p>
@endif
            <form method="POST" action="{{ route('verify.store') }}">
                {{ csrf_field() }}
                    <div class="form-group">
                        <p class="text-muted">
                            You have received an email which contains two factor login code.
                            If you haven't received it, press <a href="{{ route('verify.resend') }}"><b>here</b></a>.
                        </p>
                        
                        <input name="two_factor_code" type="password" 
                        class="form-control{{ $errors->has('two_factor_code') ? ' is-invalid' : '' }}" 
                        required autofocus placeholder="Two Factor Code">
                    @if($errors->has('two_factor_code'))
                        <div class="invalid-feedback" style="color: black">
                            {{ $errors->first('two_factor_code') }}
                        </div>
                    @endif
                    </div>
                 
                    <button type="submit" class="btn btn-success btn-block">Verify</button>
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