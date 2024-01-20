@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
      
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Timesheet
                    </small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    
    <div class="card mb-4">

        <div class="card-body">
            @component('backEnd.components.alert')

            @endcomponent
            <div class="table-responsive">
                <table class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Timesheet</th>
                        </tr>
                    </thead>
                    <tbody>
                     
                        
                            <tr>
                                <td>

                                    <a style="font-size: 19px;" href="{{ url('timesheet/fulllist/') }}">
                                        <i class="far fa-folder badge badge-pill badge-success"> <b> Timesheet</b></i></a>

                                    <hr>

                                    <a style="font-size: 19px;" href="{{ url('timesheet/allteamsubmitted/') }}">
                                        <i class="far fa-folder badge badge-pill badge-primary"> <b> Submitted
                                                Timesheet</b></i></a>
                                    <hr>
                                    <a style="font-size: 19px;" href="{{ url('rejectedlist/') }}">
                                        <i class="far fa-folder badge badge-pill badge-danger"> <b> Rejected Submitted
                                                Timesheet</b></i></a>
                                    <hr>
                                   
                            </tr>
                     
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!--/.body content-->
@endsection
