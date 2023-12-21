@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
       @if(auth()->user()->teammember_id == 157 || auth()->user()->role_id == 550 )   
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('penality/create')}}">Add Penalty</a></li>
       
        </ol>
        @endif
        @if(auth()->user()->role_id == 11 || auth()->user()->role_id == 18 )   
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('penality/create')}}">Add Penalty</a></li>
           
        </ol>
        @endif
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Penalty
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
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                     
                        <tr>
                            <td>
                               
                                <a style="font-size: 19px;"
                                href="{{ url('penality/list/'.'0')}}">
                                <i class="far fa-folder badge badge-pill badge-success"> <b>OPEN</b></i></a>
                               
                                <hr>
                             
                                <a style="font-size: 19px;"
                                href="{{ url('penality/list/'.'1')}}">
                                <i class="far fa-folder badge badge-pill badge-danger"> <b> CLOSE</b></i></a>
                                  </td>
                        </tr>
                     
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!--/.body content-->
@endsection
