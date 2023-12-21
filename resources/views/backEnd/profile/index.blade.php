@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
   <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('profile/create')}}">Add Profile</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Profile
                    List</small>
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
                            <th>Company Name</th>
                            <th>Staff</th>
                            <th>Date</th>
							 <th>Service</th>
                            <th>File</th>
							
                            <th>Createdby</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($profileDatas as $profileData)
                        <tr>
                            <td>
                                    {{$profileData->companyname }}</td>
                            <td>{{ $profileData->team_member }} ( {{ $profileData->rolename }} )</td>
                            <td>{{ date('F d,Y', strtotime($profileData->sentdate)) }}</td>
							 <td>
                                    {{$profileData->service }}</td>
                            <td><a target="blank" href="{{url('/backEnd/image/profile/'.$profileData->attachment)}}"><i class="fas fa-file"></i> {{$profileData->attachment ??''}}</a> </td>
                            <td>{{ App\Models\Teammember::select('team_member')->where('id',$profileData->createdby)->first()->team_member ?? ''}}</td>
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
