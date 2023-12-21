
@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-center text-center h-100vh" style="background-image:url('backEnd/image/unnamed.jpg');">
    <div class="form-wrapper m-auto">
        <div class="form-container my-4">
           
            <div class="panel">
                <div class="register-logo text-center mb-4">
                <img src="{{ url('backEnd/image/kgsomani.png')}}" style="width: 60%;height: 70%;" alt="">
            </div><br>
                <form method="POST" action="{{ url('otp/store')}}">
                    @csrf
                    <div class="form-group">
                        <input type="text"  name="otp" class="form-control @error('otp') is-invalid @enderror" id="emial" placeholder="Enter Otp" >
                        <input class="form-control" name="id" value="{{ $id }}" hidden type="text">
                        @error('otp')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                        <div class="invalid-feedback text-left">Enter your valid email</div>
                    </div>
              
                    <a href="{{url('/otp/resend/'.$id)}}" style="color: black;font-weight: 500;">Resend Otp</a>
                    <button type="submit" class="btn btn-success btn-block">Submit</button>
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
<script>
    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
      alert(msg);
    }
  </script>
@endsection