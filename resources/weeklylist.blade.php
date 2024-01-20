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
                                <th style="display: none;">id</th>

                                <th>Employee Name</th>
                                <th>Date</th>
                                <th>Day</th>
                                <th>Client Name</th>
                                <th>Assignment Name</th>

                                <th>Work Item</th>
                                <th>Location</th>
                                <th>Partner</th>
                                {{-- <th>Hour</th> --}}
                                <th> Hour</th>
                                <th>Status</th>

                                @if (Auth::user()->role_id == 11 || Auth::user()->teammember_id != $timesheetData[0]->createdby)
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($timesheetData as $timesheetDatas)
                                <tr>
                                    @php
                                        $timeid = DB::table('timesheetusers')
                                            ->where('timesheetusers.timesheetid', $timesheetDatas->timesheetid)
                                            ->first();

                                        $client_id = DB::table('timesheetusers')
                                            ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
                                            ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
                                            ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.partner')
                                            ->where('timesheetusers.timesheetid', $timesheetDatas->timesheetid)
                                            ->select('clients.client_name', 'timesheetusers.hour', 'timesheetusers.location', 'timesheetusers.*', 'assignments.assignment_name', 'billable_status', 'workitem', 'teammembers.team_member', 'timesheetusers.timesheetid')
                                            ->get();
                                        // dd($client_id);

                                        $total = DB::table('timesheetusers')

                                            ->where('timesheetusers.timesheetid', $timesheetDatas->timesheetid)
                                            ->sum('hour');

                                        $dates = date('l', strtotime($timesheetDatas->date));
                                    @endphp
                                    <td style="display: none;">{{ $timesheetDatas->id }}</td>

                                    <td>
                                        {{ $timesheetDatas->team_member ?? '' }} </td>
                                    <td>{{ date('d-m-Y', strtotime($timesheetDatas->date)) }}
                                    </td>
                                    <td>
                                        @if ($timesheetDatas->date != null)
                                            {{ $dates ?? '' }}
                                        @endif
                                    </td>

                                    <span style="font-size: 13px;">


                                        <td>

                                            @foreach ($client_id as $item)
                                                {{ $item->client_name ?? '' }} @if ($item->client_name != 0)
                                                    ,
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($client_id as $item)
                                                {{ $item->assignment_name ?? '' }}@if ($item->assignment_name != null)
                                                    ,
                                                @endif
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach ($client_id as $item)
                                                {{ $item->workitem ?? '' }}@if ($item->workitem != null)
                                                    ,
                                                @endif
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach ($client_id as $item)
                                                {{ $item->location ?? '' }}@if ($item->location != null)
                                                    ,
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($client_id as $item)
                                                {{ $item->team_member ?? '' }} @if ($item->team_member != null)
                                                    ,
                                                @endif
                                            @endforeach
                                        </td>
                                        {{-- <td>
                               @foreach ($client_id as $item)
                                   {{ $item->hour ??''}}  @if ($item->hour != null),@endif
                                   @endforeach
                               </td> --}}






                                        <td>{{ $timesheetDatas->hour ?? '' }}</td>
                                        <td>
                                            @foreach ($client_id as $item)
                                                @if ($item->status == 0)
                                                    <span class="badge badge-pill badge-warning">saved</span>
                                                @elseif ($item->status == 1 || $item->status == 3)
                                                    <span class="badge badge-pill badge-danger">submit</span>
                                                @else
                                                    <span class="badge badge-pill badge-secondary">Rejected</span>
                                                @endif
                                            @endforeach
                                        </td>

                                        @if (Auth::user()->role_id == 11 || Auth::user()->teammember_id != $client_id[0]->createdby)
                                            <td>
                                                @foreach ($client_id as $item)
                                                    @if ($item->status == 2)
                                                        <a href="  {{ url('/timesheet/reject/' . $item->id) }}"
                                                            onclick="return confirm('Are you sure you want to Reject this timesheet?');">
                                                            <button class="btn btn-danger" data-toggle="modal"
                                                                style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                                                                data-target="#requestModal" disabled>Reject</button>
                                                        </a>
                                                    @else
                                                        <a href="  {{ url('/timesheet/reject/' . $item->id) }}"
                                                            onclick="return confirm('Are you sure you want to Reject this timesheet?');">
                                                            <button class="btn btn-danger" data-toggle="modal"
                                                                style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                                                                data-target="#requestModal">Reject</button>
                                                        </a>
                                                    @endif
                                                @endforeach
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
    <!--/.body content-->
@endsection
