
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
	@if(Auth::user()->role_id != 18)
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('staffrequest/create')}}">Add Staffrequest</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
	@endif
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Staffrequestt</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
@if(Auth::user()->role_id == 11)
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
                                href="{{ url('staffrequest/list/'.'0')}}">
                                <i class="far fa-folder badge badge-pill badge-warning"> <b> Request Raised</b></i></a>
                               
                                <hr>
                                <a style="font-size: 19px;"
                                href="{{ url('staffrequest/list/'.'1')}}">
                                <i class="far fa-folder badge badge-pill badge-success"> <b> Approved</b></i></a>
                             
                                <hr>
                                <a style="font-size: 19px;"
                                href="{{ url('staffrequest/list/'.'2')}}">
                                <i class="far fa-folder badge badge-pill badge-danger"> <b> Reject</b></i></a>
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
                            <th> Client</th>
                            <th>No of Staff</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Reason</th>
							<th>Raised By</th>
                            <th>Status</th>
                            {{-- <th>Edit</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($staffrequestDatas as $staffrequestData)
                        <tr>
                            <td><a href="{{url('/viewstaff/'.$staffrequestData->id)}}">{{$staffrequestData->name }}</a></td>
                            <td>{{$staffrequestData->noofstaff }}</td>
                            <td>{{ date('F d,Y', strtotime($staffrequestData->startdate)) }}</td>
                            <td>{{ date('F d,Y', strtotime($staffrequestData->enddate)) }}</td>
                            <td>{{$staffrequestData->comment }}</td>
							 <td>{{$staffrequestData->team_member }}</td>
                            <td>
                                @if($staffrequestData->status ==  0)
                                <span class="badge badge-pill badge-warning">Pending</span>
                                @elseif($staffrequestData->status ==  1)
                                <span class="badge badge-pill badge-success">Approved</span>
                                @else
                                <span class="badge badge-pill badge-danger">Reject</span>
                                @endif
                            </td>
                         {{-- <td>  <a href="{{route('client.edit', $staffrequestData->id)}}"  class="btn btn-info-soft btn-sm"><i
                                class="far fa-edit"></i></a></td> --}}
                        
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div><!--/.body content-->
@endif
@endsection


