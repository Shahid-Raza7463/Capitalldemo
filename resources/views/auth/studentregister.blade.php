
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
            <form method="POST" action="{{ url('student/store') }}">
                        @csrf
                        <div class="form-group row ">
                            <!-- <div class="col-md-12"> -->
                            <div class="col-md-6">
                        
                            <input id="name" type="text" placeholder="Enter Name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                              </div>
                                <div class="col-md-6">
                              
                                <input id="email" type="email" placeholder="Enter Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            <!-- </div> -->
                            </div>
                        </div>

                        <!-- <div class="form-group row">
                            <div class="col-md-12">
                            <label for="email" class="col-form-label text-md-left">{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email" placeholder="Enter Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> -->

                        <div class="form-group row">
                            <div class="col-md-12">
                           
                                <input id="number" type="number" placeholder="Enter Phone Number" class="form-control @error('phoneno') is-invalid @enderror" name="phoneno" value="{{ old('phoneno') }}" required autocomplete="phoneno">

                                @error('phoneno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                            
                                <input id="password" type="password" placeholder="Enter Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                                <div class="col-md-6">
                          
                            <input id="password-confirm" type="password" placeholder="Enter Confirm Password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                            <!-- </div> -->
                        </div>

                        <!-- <div class="form-group row">
                            <div class="col-md-6">
                            <label for="password-confirm" class="col-form-label text-md-left">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" placeholder="Enter Confirm Password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div> -->
                        <!-- <div class="form-group row">
                            <div class="col-md-12">
                            <button type="submit" class="btn btn-primary col-md-12">
                                    {{ __('Signup') }}
                                </button>
                            </div>
                        </div> -->
                        <button type="submit" style="background: #218838" class="btn btn-success btn-block">{{ __('Submit') }}</button>
                       <span> Login to <a href="{{url('student/login')}}" style="color: white" class="font-weight-500">Continue</a></span>
                    </form>
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