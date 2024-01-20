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
                <small>Team Workbook List</small>
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
                <table class="table display table-bordered table-striped table-hover basic">
                    <thead>
                        <tr>
                            <th>Team Name</th>
                            <th>Period Date ( Monday To Saturday )</th>
                            <th>Total Timesheet Filled Day</th>
                            <th>Total Hour</th>
                            <th>Partner</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($get_date as $jobDatas)
                        <tr>
                            <td><a  href="{{url('/weeklylist?'.'id='.$jobDatas->id.'&&'.'teamid='.$jobDatas->teamid.'&&'.'partnerid='.$jobDatas->partnerid.
                            '&&'.'startdate='.$jobDatas->startdate.'&&'.'enddate='.$jobDatas->enddate)}}">{{$jobDatas->team_member }}</a></td>
                            <td>{{$jobDatas->week }}</td>
                            <td>{{$jobDatas->totaldays }}</td>
                            <td>{{$jobDatas->totaltime }}</td>
                            <td>{{$jobDatas->partnername }}</td>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!--/.body content-->
@endsection
