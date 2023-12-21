@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('tender/create')}}">Add tender</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>tender
                    List</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
@if(Auth::user()->role_id == 11 || Auth::user()->teammember_id == 99)
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
                                href="{{ url('tender/list/'.'3')}}">
                                <i class="far fa-folder badge badge-pill badge-success"> <b> Allocated to Staff</b></i></a>
                               
                                <hr>
                                <a style="font-size: 19px;"
                                href="{{ url('tender/list/'.'1')}}">
                                <i class="far fa-folder badge badge-pill badge-warning"> <b> Pending for Allocation</b></i></a>
                             
                                <hr>
                                <a style="font-size: 19px;"
                                href="{{ url('tender/list/'.'4')}}">
                                <i class="far fa-folder badge badge-pill badge-primary"> <b>Tender Submitted</b></i></a>
                               
                                <hr>
                                <a style="font-size: 19px;"
                                href="{{ url('tender/list/'.'5')}}">
                                <i class="far fa-folder badge badge-pill badge-info"> <b>Tender Close</b></i></a>
                                <hr>
                                <a style="font-size: 19px;"
                                href="{{ url('tender/list/'.'2')}}">
                                <i class="far fa-folder badge badge-pill badge-danger"> <b> Reject</b></i></a>
                                 <hr>
                                <a style="font-size: 19px;"
                                href="{{ url('tenderexpirelist')}}">
                                <i class="far fa-folder badge badge-pill badge-secondary"> <b> Tender expire not submitted</b></i></a>
                            </td>
                        </tr>
                     
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@else
<div class="body-content">
    <div class="card mb-4">

        <div class="card-body">
            @component('backEnd.components.alert')

            @endcomponent
            <div class="table-responsive">
                <table id="example" class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                          <th>Tender Offered By</th>
                            <th>Date of Entry</th>
                            <th>Last Date of Submission</th>
                            <th>Assign To</th>
                            <th>Status</th>
                            @if(Auth::user()->role_id != 13 )
                            <th>Edit</th>
                         @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tenderDatas as $tenderData)
                        <tr>
                           <td><a href="{{ url('/tender/view', $tenderData->id)}}" >{{$tenderData->tenderofferedby }}</a></td>
                            <td>{{ date('F d,Y', strtotime($tenderData->tenderpublishdate)) }}</td>
                            <td>{{ date('F d,Y', strtotime($tenderData->tenderdate)) }}</td>
                            <td>{{$tenderData->teammember->team_member ??'' }}</td>
                            <td>@if($tenderData->status ==  3)
                                <span class="badge badge-pill badge-success">approved</span>
                                @elseif($tenderData->status ==  1)
                                <span class="badge badge-pill badge-warning">pending</span>
                                @elseif($tenderData->status ==  4)
                                <span class="badge badge-pill badge-primary">submit</span>
                                @elseif($tenderData->status ==  6)
                                <span class="badge badge-pill badge-primary">submitted</span>
                                @elseif($tenderData->status ==  5)
                                <span class="badge badge-pill badge-info">close</span>
                                @else
                                <span class="badge badge-pill badge-danger">reject</span>
                                @endif</td>
                                <td>@if($tenderData->status != 4 && $tenderData->status != 5) 
                                <a href="{{route('tender.edit', $tenderData->id)}}" class="btn btn-info-soft btn-sm"><i
                                        class="far fa-edit"></i></a>
                                        @else
                                      Not Allowed @endif</td>
                         
                                         
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endif
<!--/.body content-->
@endsection
