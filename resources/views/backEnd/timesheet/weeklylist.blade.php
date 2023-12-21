{{-- library  --}}
<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">

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
                    {{-- filter functionality --}}
                    <div class="row row-sm">
                        <div class="col-4">
                            <div class="form-group">
                                <label class="font-weight-600">Client Name</label>


                                <select class="language form-control" id="filter1" name="clientname">
                                    <option value="">Please Select One</option>
                                    @php
                                        $displayedValues = [];
                                    @endphp
                                    @foreach ($timesheetData as $timesheetDatas)
                                        @php
                                            $client_id = DB::table('timesheetusers')
                                                ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
                                                ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
                                                ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.partner')
                                                ->where('timesheetusers.timesheetid', $timesheetDatas->timesheetid)
                                                ->select('clients.client_name', 'clients.id', 'timesheetusers.hour', 'timesheetusers.location', 'timesheetusers.status', 'assignments.assignment_name', 'billable_status', 'workitem', 'teammembers.team_member')
                                                ->get();
                                        @endphp

                                        @foreach ($client_id as $item)
                                            @if (!in_array($item->client_name, $displayedValues))
                                                <option value="{{ $item->id }}">
                                                    {{ $item->client_name }}
                                                </option>
                                                @php
                                                    $displayedValues[] = $item->client_name;
                                                @endphp
                                            @endif
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="font-weight-600">Assignment Name</label>
                                <select class="language form-control" id="filter2" name="assignmentname">
                                    <option value="">Please Select One</option>
                                    @php
                                        $displayedValues = [];
                                    @endphp
                                    @foreach ($timesheetData as $timesheetDatas)
                                        @php
                                            $client_id = DB::table('timesheetusers')
                                                ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
                                                ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
                                                ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.partner')
                                                ->where('timesheetusers.timesheetid', $timesheetDatas->timesheetid)
                                                ->select('clients.client_name', 'timesheetusers.hour', 'timesheetusers.assignment_id', 'timesheetusers.location', 'timesheetusers.status', 'assignments.assignment_name', 'billable_status', 'workitem', 'teammembers.team_member')
                                                ->get();
                                        @endphp
                                        @foreach ($client_id as $item)
                                            @if (!in_array($item->assignment_name, $displayedValues))
                                                <option value="{{ $item->assignment_id }}">
                                                    {{ $item->assignment_name }}
                                                </option>
                                                @php
                                                    $displayedValues[] = $item->assignment_name;
                                                @endphp
                                            @endif
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

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

                                <th>Total Hour</th>
                                <th>Status</th>
                                {{-- @php
                                    dd($timesheetData[0]->createdby);
                                @endphp --}}

                                {{-- @php
                                    $data_createdby = DB::table('timesheetusers')
                                        ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
                                        ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
                                        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.partner')
                                        ->where('timesheetusers.timesheetid', $timesheetDatas->timesheetid)
                                        ->select('clients.client_name', 'timesheetusers.hour', 'timesheetusers.location', 'timesheetusers.*', 'assignments.assignment_name', 'billable_status', 'workitem', 'teammembers.team_member', 'timesheetusers.timesheetid')
                                        ->get();
                                    // dd($data_createdby);
                                    // dd(Auth::user()->teammember_id);
                                @endphp --}}
                                {{-- @if (Auth::user()->role_id == 11 || Auth::user()->teammember_id != $data_createdby[0]->createdby)
                                    <th>Action</th>
                                @endif --}}
                                @if (Auth::user()->role_id == 11 || Auth::user()->teammember_id != $timesheetData[0]->createdby)
                                    <th>Action</th>
                                @endif
                                {{-- @if (Auth::user()->role_id == 11)
                                    <th>Action</th>
                                @endif --}}
                            </tr>
                        </thead>
                        <tbody>

                            {{-- @php
                                dd($timesheetData);
                            @endphp --}}
                            @foreach ($timesheetData as $timesheetDatas)
                                <tr>
                                    @php
                                        $timeid = DB::table('timesheetusers')
                                            ->where('timesheetusers.timesheetid', $timesheetDatas->timesheetid)
                                            ->first();
                                        //! old code
                                        // $client_id = DB::table('timesheetusers')
                                        //     ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
                                        //     ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
                                        //     ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.partner')
                                        //     ->where('timesheetusers.timesheetid', $timesheetDatas->timesheetid)

                                        //     ->select('clients.client_name', 'timesheetusers.hour', 'timesheetusers.location', 'timesheetusers.status', 'assignments.assignment_name', 'billable_status', 'workitem', 'teammembers.team_member')
                                        //     ->get();
                                        // //dd($client_id);

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

                                        <td>{{ $total }}</td>

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
                                        {{-- *for admin  --}}
                                        {{-- @if (Auth::user()->role_id == 11)
                                            <td>
                                                @foreach ($client_id as $item)
                                                    <a href="  {{ url('/timesheet/reject/' . $item->id) }}"
                                                        onclick="return confirm('Are you sure you want to Reject this timesheet?');">
                                                        <button class="btn btn-danger" data-toggle="modal"
                                                            style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                                                            data-target="#requestModal">Reject</button>
                                                    </a>
                                                   
                                                @endforeach
                                            </td>
                                        @endif --}}

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

                                        {{-- @if (Auth::user()->role_id == 13)
                                            <td>
                                                @foreach ($client_id as $item)
                                                    @if ($item->status == 2)
                                                        <a href="{{ url('/assignmentmapping/edit/' . $item->id) }}"
                                                            class="btn btn-info-soft btn-sm"><i class="far fa-edit"></i></a>
                                                    @endif
                                                @endforeach
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
    <!--/.body content-->
@endsection

{{-- filter on weekly list --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script>
    $(document).ready(function() {
        //   all partner
        $('#filter1').change(function() {
            var search1 = $(this).val();
            var search2 = $('#filter2').val();
            // console.log(search1);

            var urlParams = new URLSearchParams(window.location.search);
            // Access values from the URL
            var id = urlParams.get('id');
            var teamid = urlParams.get('teamid');
            var partnerid = urlParams.get('partnerid');
            var startdate = urlParams.get('startdate');
            var enddate = urlParams.get('enddate');



            $.ajax({
                type: 'GET',
                url: '/filter-weeklist',
                data: {
                    clientname: search1,
                    assignmentname: search2,
                    id: id,
                    teamid: teamid,
                    partnerid: partnerid
                },
                success: function(data) {
                    // Clear the table body
                    $('table tbody').html("");

                    if (data.length === 0) {
                        // If no data is found, display a "No data found" message
                        $('table tbody').append(
                            '<tr><td colspan="10" class="text-center">No data found</td></tr>'
                        );
                    } else {
                        $.each(data, function(index, item) {
                            var dayOfWeek = moment(item.date).format('dddd');
                            var formattedDate = moment(item.date).format(
                                'DD-MM-YYYY');
                            var statusBadge = item.status == 0 ?
                                '<span class="badge badge-pill badge-warning">saved</span>' :
                                '<span class="badge badge-pill badge-danger">submit</span>';
                            // Add the rows to the table


                            $('table tbody').append('<tr>' +
                                '<td>' + item.team_member + '</td>' +
                                '<td>' + formattedDate + '</td>' +
                                '<td>' + dayOfWeek + '</td>' +
                                '<td>' + item.client_name + '</td>' +
                                '<td>' + item.assignment_name + '</td>' +
                                '<td>' + item.workitem + '</td>' +
                                '<td>' + item.location + '</td>' +
                                '<td>' + item.partnername_name + '</td>' +
                                '<td>' + item.hour + '</td>' +
                                '<td>' + statusBadge + '</td>' +
                                // Add more columns here
                                '</tr>');
                        });

                        //   remove pagination after filter
                        $('.paging_simple_numbers').remove();
                        $('.dataTables_info').remove();
                    }
                }
            });
        });



        //** start date
        $('#filter2').change(function() {
            var search2 = $(this).val();
            var search1 = $('#filter1').val();
            console.log(search2);
            var urlParams = new URLSearchParams(window.location.search);
            // Access values from the URL
            var id = urlParams.get('id');
            var teamid = urlParams.get('teamid');
            var partnerid = urlParams.get('partnerid');
            var startdate = urlParams.get('startdate');
            var enddate = urlParams.get('enddate');
            $.ajax({
                type: 'GET',
                url: '/filter-weeklist',
                data: {
                    assignmentname: search2,
                    clientname: search1,
                    id: id,
                    teamid: teamid,
                    partnerid: partnerid
                },
                success: function(data) {
                    // Replace the table body with the filtered data
                    $('table tbody').html(""); // Clear the table body

                    if (data.length === 0) {
                        // If no data is found, display a "No data found" message
                        $('table tbody').append(
                            '<tr><td colspan="10" class="text-center">No data found</td></tr>'
                        );
                    } else {
                        $.each(data, function(index, item) {
                            var dayOfWeek = moment(item.date).format('dddd');
                            var formattedDate = moment(item.date).format(
                                'DD-MM-YYYY');
                            var statusBadge = item.status == 0 ?
                                '<span class="badge badge-pill badge-warning">saved</span>' :
                                '<span class="badge badge-pill badge-danger">submit</span>';
                            // Add the rows to the table


                            $('table tbody').append('<tr>' +
                                '<td>' + item.team_member + '</td>' +
                                '<td>' + formattedDate + '</td>' +
                                '<td>' + dayOfWeek + '</td>' +
                                '<td>' + item.client_name + '</td>' +
                                '<td>' + item.assignment_name + '</td>' +
                                '<td>' + item.workitem + '</td>' +
                                '<td>' + item.location + '</td>' +
                                '<td>' + item.partnername_name + '</td>' +
                                '<td>' + item.hour + '</td>' +
                                '<td>' + statusBadge + '</td>' +
                                // Add more columns here
                                '</tr>');
                        });
                        //   remove pagination after filter
                        $('.paging_simple_numbers').remove();
                        $('.dataTables_info').remove();
                    }
                }
            });
        });
        //shahid
    });
</script>
