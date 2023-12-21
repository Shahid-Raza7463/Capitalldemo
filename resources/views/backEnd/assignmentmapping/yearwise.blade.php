@extends('backEnd.layouts.layout') @section('backEnd_content')
    <!--Content Header (Page header)-->
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('clientassignmentlist/' . $clientid) }}">Back</a></li>
            </ol>
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
    {{-- <div class="body-content">
    <div class="card mb-4">

        <div class="card-body">
            @component('backEnd.components.alert')

            @endcomponent
            <div class="table-responsive">
                <table class="table display table-bordered table-striped table-hover basic">
                    <thead>
                        <tr>
                            <th>Assignment Id</th>
                            <th>Assignment</th>
                            <th>Deadline</th>
							 <th>Assigned Partner</th>
                            <th>Teammember</th>
                            @if (auth()->user()->role_id != 15)
                             <th>Edit</th>
                             @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assignmentmappingData as $assignmentmappingDatas)
                        <tr>
                              @php
                                 $random = substr(md5(mt_rand()), 0, 10);
                            @endphp
                            <td> <a href="{{url('/viewassignment/'.$assignmentmappingDatas->assignmentgenerate_id.'b'.$random)}}">{{$assignmentmappingDatas->assignmentgenerate_id}}</a></td>
                            <td><span><b> Client Name :</b></span>
                                {{$assignmentmappingDatas->client_name}}<br><span><b>Assignment :</b></span>
                                {{$assignmentmappingDatas->assignment_name}}</td>
                            <td>{{$assignmentmappingDatas->duedate}}</td>
							   <td>{{ App\Models\Teammember::select('team_member')->where('id',$assignmentmappingDatas->leadpartner)->first()->team_member ?? ''}}</td>
                            <td>
                                @foreach (DB::table('assignmentmappings')->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')->where('assignmentmappings.id', $assignmentmappingDatas->id)->get() as $sub)

                             @if ($sub->profilepic == null)
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
                           @if (auth()->user()->role_id != 15)
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

</div> --}}
    <!--/.body content-->
    <div class="body-content">
        <div class="card mb-4">
            {{-- @php
                dd($assignmentmappingData);
            @endphp --}}
            <div class="card-body">
                @component('backEnd.components.alert')
                @endcomponent
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
                                <th>Team Leader</th>
                                <th>Teammember</th>
                                @if (auth()->user()->role_id != 15)
                                    <th>Edit</th>
                                @endif
                                {{-- @if (auth()->user()->role_id != 15)
                                    <th>Status</th>
                                @endif --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assignmentmappingData as $assignmentmappingDatas)
                                <tr>
                                    <td>
                                        {{-- @if ($assignmentmappingDatas->status == 1)
                                            {{ $assignmentmappingDatas->assignmentgenerate_id }}
                                        @else --}}
                                        <a
                                            href="{{ url('/viewassignment/' . $assignmentmappingDatas->assignmentgenerate_id) }}">{{ $assignmentmappingDatas->assignmentgenerate_id }}
                                        </a>
                                        {{-- @endif --}}
                                    </td>
                                    <td>
                                        {{ $assignmentmappingDatas->assignment_name }} @if ($assignmentmappingDatas->assignmentname != null)
                                            ({{ $assignmentmappingDatas->assignmentname }})
                                        @endif
                                    </td>
                                    <td> {{ $assignmentmappingDatas->client_name }}</td>
                                    <td>
                                        @if ($assignmentmappingDatas->duedate != null)
                                            {{ date('d-m-Y', strtotime($assignmentmappingDatas->duedate)) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($assignmentmappingDatas->periodend != null)
                                            {{ date('d-m-Y', strtotime($assignmentmappingDatas->periodend)) }}
                                        @endif
                                    </td>
                                    <td>{{ App\Models\Teammember::select('team_member')->where('id', $assignmentmappingDatas->leadpartner)->first()->team_member ?? '' }}
                                    </td>
                                    <td>{{ App\Models\Teammember::select('team_member')->where('id', $assignmentmappingDatas->otherpartner)->first()->team_member ?? '' }}
                                    </td>

                                    <td>
                                        @foreach (DB::table('assignmentmappings')->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')->where('assignmentmappings.id', $assignmentmappingDatas->id)->where('assignmentteammappings.type', 0)->get() as $sub)
                                            @if ($sub->profilepic == null)
                                                <a class="avatar avatar-xs" data-toggle="tooltip"
                                                    title="{{ $sub->team_member }}">
                                                    <img src="{{ url('backEnd/image/dummy.png') }}"
                                                        class="avatar-img rounded-circle" alt="...">
                                                @else
                                                    <a class="avatar avatar-xs" data-toggle="tooltip"
                                                        title="{{ $sub->team_member }}">
                                                        <img src="{{ asset('backEnd/image/teammember/profilepic/' . $sub->profilepic) }}"
                                                            class="avatar-img rounded-circle" alt="...">
                                            @endif
                                        @endforeach
                                    </td>

                                    <td>
                                        @foreach (DB::table('assignmentmappings')->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')->where('assignmentmappings.id', $assignmentmappingDatas->id)->where('assignmentteammappings.type', 2)->get() as $sub)
                                            @if ($sub->profilepic == null)
                                                <a class="avatar avatar-xs" data-toggle="tooltip"
                                                    title="{{ $sub->team_member }}">
                                                    <img src="{{ url('backEnd/image/dummy.png') }}"
                                                        class="avatar-img rounded-circle" alt="...">
                                                @else
                                                    <a class="avatar avatar-xs" data-toggle="tooltip"
                                                        title="{{ $sub->team_member }}">
                                                        <img src="{{ asset('backEnd/image/teammember/profilepic/' . $sub->profilepic) }}"
                                                            class="avatar-img rounded-circle" alt="...">
                                            @endif
                                        @endforeach
                                    </td>
                                    @if (auth()->user()->role_id != 15)
                                        <td>
                                            {{-- @if ($assignmentmappingDatas->status != 1) --}}
                                            <a href="{{ url('/assignmentlist/' . $assignmentmappingDatas->assignmentgenerate_id) }}"
                                                class="btn btn-info-soft btn-sm"><i class="far fa-edit"></i></a>
                                            {{-- @endif --}}
                                        </td>
                                    @endif
                                    {{-- @if (auth()->user()->role_id != 15)
                                        <td>
                                            @if ($assignmentmappingDatas->status == 1)
                                                <span class="badge badge-pill badge-danger">Rejected</span>
                                            @endif
                                        </td>
                                    @endif --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
