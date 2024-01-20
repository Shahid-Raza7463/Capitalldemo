@extends('backEnd.layouts.layout') @section('backEnd_content')
<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
   
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
  <div class="card-header" style="background: #37A000">

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="col-md-6">
                            <h6 style="color: white" class="fs-17 font-weight-600 mb-0">Reset Member Password</h6>
                        </div>
                        <div class="col-md-6">
                           <!-- <p style="float: right;color:white;"><a data-toggle="modal"
                                    data-target="#exampleModal1"><b>Log</b></a></p> -->
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ url('authpassword/update/'.$id) }}" enctype="multipart/form-data">
                        @csrf
                  @component('backEnd.components.alert')

                  @endcomponent
                  <div class="row row-sm">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="font-weight-600">Team Member </label>
                            <input type="text" readonly name="emailid" value="{{ $teammember->emailid ?? ''}}" class="form-control"
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
                            <input type="password" name="password_confirmation" class="form-control"
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

<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header" style="background: #37A000">
                <h5 style="color:white" class="modal-title font-weight-600" id="exampleModalLabel4">Password log</h5>
                <div>
                    <ul>
                        @foreach ($errors->all() as $e)
                        <li style="color:red;">{{$e}}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">

                    <table class="table display table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Teammember</th>
                                <th>Description</th>

                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($traillog as $traillogData)
                            <tr>
                                <td>{{ $traillogData->team_member ??''}}</td>
                                <td>{{ $traillogData->description ??''}}</td>

                                <td>{{ date('F d,Y', strtotime($traillogData->created_at)) }}
                                    {{ date('h:i A', strtotime($traillogData->created_at)) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

<!--Page Active Scripts(used by this page)-->
<script src="{{ url('backEnd/dist/js/pages/forms-basic.active.js')}}"></script>
<!--Page Scripts(used by all page)-->
<script src="{{ url('backEnd/dist/js/sidebar.js')}}"></script>



