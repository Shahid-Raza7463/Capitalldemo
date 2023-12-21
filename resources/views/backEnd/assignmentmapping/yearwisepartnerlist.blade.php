<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
       <!-- <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('assignmentmapping/create')}}">Add Assignmentmapping</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>-->
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Assignment List</small>
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
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                        aria-controls="pills-home" aria-selected="true">Assigned Partner</a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" id="pills-user-tab" data-toggle="pill" href="#pills-user" role="tab"
                        aria-controls="pills-user" aria-selected="false">Other Partner</a>
                </li>

            </ul>

            <br>
            <hr>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="table-responsive">
                        <table class="table display table-bordered table-striped table-hover basic">
                            <thead>
                                <tr>
                                     <th>Assignment Id</th>
                                    <th>Assignment</th>
                                    <th>Client</th>
                                    <th>Deadline</th>
                                    <th>Period End</th>
                                     <th>Assigned Partner</th>
                                    <th>Other Partner</th>
                                    <th>Teammember</th>
                                    @if(auth()->user()->role_id != 15 && Auth::user()->role_id != 11)
                                     <th>Edit</th>
                                     @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assigned as $assignmentmappingDatas)
                                   <tr>
                                    
                                    <td> <a href="{{url('/viewassignment/'.$assignmentmappingDatas->assignmentgenerate_id)}}">{{$assignmentmappingDatas->assignmentgenerate_id}}</a></td>
                                    <td>
                                        {{$assignmentmappingDatas->assignment_name}} @if($assignmentmappingDatas->assignmentname !=  null)( {{ $assignmentmappingDatas->assignmentname }} )@endif</td>
                                        <td> {{$assignmentmappingDatas->client_name}}</td>
                                       <td>
                                           @if($assignmentmappingDatas->duedate != null)
                                           {{ date('d-m-Y', strtotime($assignmentmappingDatas->duedate)) }}
                                       @endif
                                       </td>
                                         <td> @if($assignmentmappingDatas->periodend != null)
                                             {{ date('d-m-Y', strtotime($assignmentmappingDatas->periodend)) }}
                                             @endif
                                       </td>
                                      <td>{{ App\Models\Teammember::select('team_member')->where('id',$assignmentmappingDatas->leadpartner)->first()->team_member ?? ''}}</td>   
                                             <td>{{ App\Models\Teammember::select('team_member')->where('id',$assignmentmappingDatas->otherpartner)->first()->team_member ?? ''}}</td>  
                                    <td>
                                        @foreach(DB::table('assignmentmappings')
                                        ->leftjoin('assignmentteammappings','assignmentteammappings.assignmentmapping_id','assignmentmappings.id')
                                        ->leftjoin('teammembers','teammembers.id','assignmentteammappings.teammember_id')->where('assignmentmappings.id',$assignmentmappingDatas->id)->get()
                                        as $sub)
        
                                     @if($sub->profilepic == NULL)
        <a class="avatar avatar-xs" data-toggle="tooltip"
        title="{{$sub->team_member}}">
        <img src="{{url('backEnd/image/dummy.png')}}"
            class="avatar-img rounded-circle" alt="...">
                                     
        @else
        <a class="avatar avatar-xs" data-toggle="tooltip"
        title="{{$sub->team_member}}">
        <img src="{{asset('backEnd/image/teammember/profilepic/'.$sub->profilepic)}}"
            class="avatar-img rounded-circle" alt="...">
                                                @endif
                                            @endforeach
                                    </td>
                                   @if(auth()->user()->role_id != 15 && Auth::user()->role_id != 11)
                                     <td>
                                        <a href="{{url('/assignmentlist/'.$assignmentmappingDatas->assignmentgenerate_id)}}"
                                            class="btn btn-info-soft btn-sm"><i class="far fa-edit"></i></a>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-user" role="tabpanel" aria-labelledby="pills-user-tab">
                    <div class="table-responsive">
                        <table class="table display table-bordered table-striped table-hover basic">
                            <thead>
                                <tr>
                                     <th>Assignment Id</th>
                                    <th>Assignment</th>
                                    <th>Client</th>
                                    <th>Deadline</th>
                                    <th>Period End</th>
                                     <th>Assigned Partner</th>
                                    <th>Other Partner</th>
                                    <th>Teammember</th>
                                    @if(auth()->user()->role_id != 15 && Auth::user()->role_id != 11)
                                     <th>Edit</th>
                                     @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($otherassigned as $assignmentmappingDatas)
                                   <tr>
                                    
                                    <td> <a href="{{url('/viewassignment/'.$assignmentmappingDatas->assignmentgenerate_id)}}">{{$assignmentmappingDatas->assignmentgenerate_id}}</a></td>
                                    <td>
                                        {{$assignmentmappingDatas->assignment_name}} @if($assignmentmappingDatas->assignmentname !=  null)( {{ $assignmentmappingDatas->assignmentname }} )@endif</td>
                                        <td> {{$assignmentmappingDatas->client_name}}</td>
                                       <td>
                                           @if($assignmentmappingDatas->duedate != null)
                                           {{ date('d-m-Y', strtotime($assignmentmappingDatas->duedate)) }}
                                       @endif
                                       </td>
                                         <td> @if($assignmentmappingDatas->periodend != null)
                                             {{ date('d-m-Y', strtotime($assignmentmappingDatas->periodend)) }}
                                             @endif
                                       </td>
                                      <td>{{ App\Models\Teammember::select('team_member')->where('id',$assignmentmappingDatas->leadpartner)->first()->team_member ?? ''}}</td>   
                                             <td>{{ App\Models\Teammember::select('team_member')->where('id',$assignmentmappingDatas->otherpartner)->first()->team_member ?? ''}}</td>  
                                    <td>
                                        @foreach(DB::table('assignmentmappings')
                                        ->leftjoin('assignmentteammappings','assignmentteammappings.assignmentmapping_id','assignmentmappings.id')
                                        ->leftjoin('teammembers','teammembers.id','assignmentteammappings.teammember_id')->where('assignmentmappings.id',$assignmentmappingDatas->id)->get()
                                        as $sub)
        
                                     @if($sub->profilepic == NULL)
        <a class="avatar avatar-xs" data-toggle="tooltip"
        title="{{$sub->team_member}}">
        <img src="{{url('backEnd/image/dummy.png')}}"
            class="avatar-img rounded-circle" alt="...">
                                     
        @else
        <a class="avatar avatar-xs" data-toggle="tooltip"
        title="{{$sub->team_member}}">
        <img src="{{asset('backEnd/image/teammember/profilepic/'.$sub->profilepic)}}"
            class="avatar-img rounded-circle" alt="...">
                                                @endif
                                            @endforeach
                                    </td>
                                   @if(auth()->user()->role_id != 15 && Auth::user()->role_id != 11)
                                     <td>
                                        <a href="{{url('/assignmentlist/'.$assignmentmappingDatas->assignmentgenerate_id)}}"
                                            class="btn btn-info-soft btn-sm"><i class="far fa-edit"></i></a>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!--/.body content-->
@endsection