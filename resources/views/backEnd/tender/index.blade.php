@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
           @if(Auth::user()->role_id != 14 && Auth::user()->role_id != 13 )
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('tender/create')}}">Add tender</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    @endif
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
<div class="body-content">
     <div class="card mb-4">
            @if($id ==  3)
            <div class="card-header" style="background:#28A745;">
                @endif
              @if($id ==  1)
             <div class="card-header" style="background:#FFC107;">
                @endif
            @if($id ==  4)
            <div class="card-header" style="background:#007BFF;">
                @endif
              @if($id ==  5)
         <div class="card-header" style="background:#17A2B8;">
            @endif
              @if($id ==  2)
           <div class="card-header" style="background:#DC3545;">
              @endif
            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <h6 class="fs-17 font-weight-600 mb-0">
                        @if($id ==  3)
                        <span style="color:white;"> Allocated to Staff</span>
                        @endif
                        @if($id ==  1 )
                        <span style="color:white;"> Pending for Allocation</span>
                        @endif
                        @if($id ==  4)
                        <span style="color:white;"> Tender Submitted</span>
                        @endif
                        @if($id ==  5)
                        <span style="color:white;">Tender Close</span>
                        @endif
                        @if($id ==  2)
                        <span style="color:white;">Tender Reject</span>
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
                              <th>Tender Offered By</th>
                            <th>Date of Entry</th>
                            <th>Last Date of Submission</th>
                            <th>Assign To</th>
                            <th>Nature of Services</th>
                     
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tenderDatas as $tenderData)
                        <tr>
                            <td><a href="{{ url('/tender/view', $tenderData->id)}}" >{{$tenderData->tenderofferedby }}</a></td>
                            <td>{{ date('F d,Y', strtotime($tenderData->tenderpublishdate)) }}</td>
                            <td>{{ date('F d,Y', strtotime($tenderData->tenderdate)) }}</td>
                            <td>{{$tenderData->team_member }}</td>
                            <td>{{$tenderData->services }}</td>
                            

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
