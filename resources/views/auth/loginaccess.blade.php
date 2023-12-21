
@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-center text-center h-100vh" style="background-image:url('backEnd/image/unnamed.jpg');">
    <div class="form-wrapper m-auto">
        <div class="form-container my-4">
           
            <div class="panel">
                <div class="register-logo text-center mb-4">
                   <img src="{{ url('backEnd/image/kgsomanillp.png')}}" style="width: 80%;height: 70%;" alt="">
            </div><br>
            <div class="form-group row">
                <div class="col-md-6">
                    <b><i style="font-size:100px;color: #88a187;" class="fas fa-users"></i></b>
                    <a href="{{url('login')}}" class="btn btn-success btn-block">Login as Staff</a></div>
           
             <div class="col-md-6"> 
                <b><i style="font-size:100px;color: #88a187;" class="fas fa-user-friends"></i></b>
             <a href="{{url('clientlogin')}}" class="btn btn-success btn-block">Login as Client</a>
             </div>
            </div>
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