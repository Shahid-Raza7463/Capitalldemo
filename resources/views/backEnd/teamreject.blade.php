<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Responsive Bootstrap 4 Admin &amp; Dashboard Template">
        <meta name="author" content="Bdtask">
        <title>K.G.Somani</title>
        
         <!-- stylesheet start -->
    @include('backEnd.layouts.includes.stylesheet')
    <!-- stylesheet end -->
    </head>
    <body class="bg-white" >
        @if($status == 1)
        <div class="d-flex align-items-center justify-content-center text-center h-100vh" style="background-image:url('backEnd/image/unnamed.jpg');">
            <div class="form-wrapper m-auto">
                <div class="form-container my-4">
                   
                    <div class="panel">
                        <div class="register-logo text-center mb-4">
                       <h4><b>Please Confirm the Balance Recoverable</b></h4>
                    </div>
                    <div>
                        @if(session()->has('success'))
                        <div class="alert alert-success">
                            @if(is_array(session()->get('success')))
                            @foreach (session()->get('success') as $message)
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
                        <form method="POST" action="{{ url('confirmation/confirm') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <input type="number"  name="amount" class="form-control @error('email') is-invalid @enderror" placeholder="Enter Amount"  >
                                <input type="number" hidden name="clientid" class="form-control @error('email') is-invalid @enderror" value="{{ $clientid}}"  >
                                <input type="number" hidden name="debtorid" class="form-control @error('email') is-invalid @enderror" value="{{ $debtorid}}"   >
                               
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                                <div class="invalid-feedback text-left">Enter your valid email</div>
                            </div>
                            <div class="form-group">
                                <textarea name="remark" rows="3" class="form-control" placeholder="Enter Remark"></textarea>
                                 
                                  @error('email')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                                  <div class="invalid-feedback text-left">Enter your valid email</div>
                              </div>
                            <div class="form-group">
                                <input type="file" class="form-control" name="file" >
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                            @if($debtorconfirm == null)
                            <button type="submit" class="btn btn-success btn-block">Submit</button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="d-flex align-items-center justify-content-center text-center h-100vh" style="background-image:url('backEnd/image/unnamed.jpg');">
            <div class="form-wrapper m-auto">
                <div class="form-container my-4">
                   
                    <div class="panel">
                        <div class="register-logo text-center mb-4">
                       <h4><b>Please Confirm the Balance Recoverable</b></h4>
                    </div>
                    <div>
                        @if(session()->has('success'))
                        <div class="alert alert-success">
                            @if(is_array(session()->get('success')))
                            @foreach (session()->get('success') as $message)
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
                        <form method="POST" action="{{ url('confirmation/confirm') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <input type="number"  name="amount" class="form-control @error('email') is-invalid @enderror" placeholder="Enter Amounst"  >
                                <input type="number" hidden name="clientid" class="form-control @error('email') is-invalid @enderror" value="{{ $clientid}}"  >
                                <input type="number" hidden  name="debtorid" class="form-control @error('email') is-invalid @enderror" value="{{ $debtorid}}"   >
                               
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                                <div class="invalid-feedback text-left">Enter your valid email</div>
                            </div>
                            <div class="form-group">
                              <textarea name="remark" rows="3" class="form-control" placeholder="Enter Remark"></textarea>
                               
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                                <div class="invalid-feedback text-left">Enter your valid email</div>
                            </div>
                            <div class="form-group">
                                <input type="file" class="form-control" name="file" >
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                            @if($debtorconfirm == null)
                            <button type="submit" class="btn btn-success btn-block">Submit</button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
 <!--/.main content-->

<!-- js bar start-->
@include('backEnd.layouts.includes.js')
<!-- js bar end -->
</body>
</html>
