@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
           @if(Auth::user()->role_id != 14 && Auth::user()->role_id != 13 )
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('staffrequest /create')}}">Add Staffrequest </a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    @endif
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Staffrequest 
                    List</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
     <div class="card mb-4">
            @if($id ==  1)
            <div class="card-header" style="background:#28A745;">
                @endif
              @if($id ==  0)
             <div class="card-header" style="background:#FFC107;">
                @endif
            
              @if($id ==  2)
           <div class="card-header" style="background:#DC3545;">
              @endif
            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <h6 class="fs-17 font-weight-600 mb-0">
                        @if($id ==  0)
                        <span style="color:white;">Request Raised</span>
                        @endif
                        @if($id ==  1 )
                        <span style="color:white;">Approved</span>
                        @endif
                     
                        @if($id ==  2)
                        <span style="color:white;"> Reject</span>
                        @endif
                    </h6>
                </div>

            </div>
        </div>
        <div class="card-body">
            @component('backEnd.components.alert')

            @endcomponent
            <div class="table-responsive">
                <table class="table display table-bordered table-striped table-hover basic">
                    <thead>
                        <tr>
                            <th> Client</th>
                            <th>No of Staff</th>
							  <th>Raised By</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Reason</th>
                            {{-- <th>Edit</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($staffrequestDatas as $staffrequestData)
                        <tr>
                            <td><a href="{{url('/viewstaff/'.$staffrequestData->id)}}">{{$staffrequestData->name }}</a></td>
                            <td>{{$staffrequestData->noofstaff }}</td>
							 <td>{{$staffrequestData->team_member }}</td>
                            <td>{{ date('F d,Y', strtotime($staffrequestData->startdate)) }}</td>
                            <td>{{ date('F d,Y', strtotime($staffrequestData->enddate)) }}</td>
                            <td>{{$staffrequestData->comment }}</td>
                           
                         {{-- <td>  <a href="{{route('client.edit', $staffrequestData->id)}}"  class="btn btn-info-soft btn-sm"><i
                                class="far fa-edit"></i></a></td> --}}
                        
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!--/.body content-->

@endsection
