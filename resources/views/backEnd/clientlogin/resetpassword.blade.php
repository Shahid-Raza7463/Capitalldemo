@extends('backEnd.layouts.layout') @section('backEnd_content')
<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
   
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">Reset Client Password</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="@if(Request::is('clientuserlogin/resetpassword/*'))
                    {{ url('clientuserlogin/password/update/'.$id) }} @endif" enctype="multipart/form-data">
                        @csrf
                  @component('backEnd.components.alert')

                  @endcomponent
                  <div class="row row-sm">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="font-weight-600">Email </label>
                            <input type="text" name="email" value="{{ $clientlogin->email ?? ''}}" class="form-control"
                                placeholder="Enter Email">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="font-weight-600">Password.</label>
                            <input type="password" name="password" class="form-control"
                                placeholder="Enter Password">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="font-weight-600">Confirm Password.</label>
                            <input type="password" name="confirm_password" class="form-control"
                                placeholder="Enter Confirm Password">
                        </div>
                    </div>
                
                </div>
                
                <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                   
                    <hr class="my-4">

                </div>
            </div>
        </div>
    </div>
</div>
<!--/.body content-->

@endsection

<!--Page Active Scripts(used by this page)-->
<script src="{{ url('backEnd/dist/js/pages/forms-basic.active.js')}}"></script>
<!--Page Scripts(used by all page)-->
<script src="{{ url('backEnd/dist/js/sidebar.js')}}"></script>



