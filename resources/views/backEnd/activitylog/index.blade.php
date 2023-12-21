
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-time d-block"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Activity Log</small>
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
                            <th>Description</th>
                            <th>Page Title</th>
                            <th> Ip Address</th>
                            <th>Date</th>
                            <th>Member</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activitylogDatas as $activitylogData)
                        <tr>
                            <td>{{$activitylogData->description }}</td>
                            <td>{{$activitylogData->activitytitle }}</td>
                            <td>{{$activitylogData->ip_address }}</td>
                            <td>{{ date('F d,Y', strtotime($activitylogData->created_at)) }}</td>
                            <td>{{$activitylogData->team_member }} ( {{$activitylogData->rolename }} )</td>
                           
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div><!--/.body content-->

@endsection


