
@extends('layouts.app')
<style>
    /* Large devices (laptops/desktops, 992px and up) */
@media only screen and (min-width: 992px) {
  .panel {width: 400px;}
} 

/* Extra large devices (large laptops and desktops, 1200px and up) */
@media only screen and (min-width: 1200px) {
  .panel {width: 400px;}
}
</style>
@section('content')
<div class="d-flex align-items-center justify-content-center text-center h-100vh" style="background-image:url('backEnd/image/unnamed.jpg');">
    <div class="form-wrapper m-auto">
        <div class="form-container my-4" >
            <div class="panel" style="background:#37A000;">
            @component('backEnd.components.alert')

           @endcomponent
                 @if(session()->has('error'))
                <div class="alert alert-danger">
                     {{ session()->get('error') }}
                 </div>
             @endif
              <div class="register-logo text-center mb-4">
                <h1 style="margin:0px;font-weight: 600;color:white;">CapITall</h1>
                <span style="color: white;font-size:12px;">Powered by K G Somani and Co LLP</span>
            </div><br>
                <form  method="POST" action="{{ route('student.login') }}">
					     <div>
                        @if(session()->has('status'))
                        <div class="alert alert-success" style="background:white;">
                            @if(is_array(session()->get('status')))
                            @foreach (session()->get('status') as $message)
                            <p>{{ $message }}</p>
                            @endforeach
                            @else
                            <p>{{ session()->get('success') }}</p>
                            @endif
                        </div>  
                        @endif
                        @if(session()->has('statuss'))
                        <div class="alert alert-danger">
                          @if(is_array(session()->get('statuss')))
                          @foreach (session()->get('statuss') as $message)
                              <p>{{ $message }}</p>
                          @endforeach
                          @else
                              <p>{{ session()->get('success') }}</p>
                          @endif
                        </div>
                    @endif
                        <div>
                            <ul>
                                @foreach ($errors->all() as $e)
                                <li style="color:red;">{{$e}}</li>
                                @endforeach
                            </ul>
                        </div></div>
                    @csrf
                    <div class="form-group">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="emial" placeholder="Enter client email"  value="{{ old('email') }}" required autocomplete="email" autofocus>
                       
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
                        <label style="color: white" class="custom-control-label" for="customCheck1">    {{ __('Remember Me') }} next time </label>
                    </div>
                    <button type="submit" style="background: #218838" class="btn btn-success btn-block">Sign in</button>
                    </form>
                    <span><a href="{{url('forgetpassword')}}" style="color: white; float:left;" class="font-weight-500">Forgotten password?</a></span>
                        <span><a href="{{url('student/register')}}" style="color: white; float:right;" class="font-weight-500">Signup</a></span>
            </div>
           
        </div>
    </div>
</div>
<script>
    document.onkeydown = function(e) {
            if (e.ctrlKey && 
                (e.keyCode === 85 )) {
                return false;
            }
    };
    document.addEventListener('contextmenu', event => event.preventDefault());
    </script>
@endsection