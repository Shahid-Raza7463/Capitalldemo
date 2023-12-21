@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('project/create')}}">Add Project</a>
            </li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Project List</small>
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
                            <th>Client Name</th>
                            <th>Project Name</th>
                            <th>Project Head</th>
                            <th>Project Manager</th>
                            <th>Project User</th>
                            <th>Description</th>
                            <th>createdby</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projectData as $projectData)
                        <tr>
                        <td><a href="{{url('view/project', $projectData->id)}}">{{ $projectData->client_name }} </td>
                        <td>{{ $projectData->project_name }} </td>
                            <td>{{ $projectData->team_member }} </td>
                            <td>{{ App\Models\Teammember::select('team_member')->where('id',$projectData->projectmanager)->first()->team_member ?? ''}}</td>
                          
                             <td>{{ $projectData->projectuser}}</td>
                             <td>{{ $projectData->description}}</td>
                            <td>{{ App\Models\Teammember::select('team_member')->where('id',$projectData->createdby)->first()->team_member ?? ''}}
                            </td>
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
