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
                                <th>Total Hour</th>
                                <th>Status</th>
                                {{-- @if (Auth::user()->role_id == 11)
                                    <th>Action</th>
                                @endif --}}
                                @if (Auth::user()->role_id == 14 || Auth::user()->role_id == 15)
                                    <th>Action</th>
                                @endif

                                {{-- @if (Auth::user()->role_id == 13)
                                    @foreach ($client_id as $item)
                                        @if ($item->status == 2)
                                            <th>Action</th>
                                        @endif
                                    @endforeach
                                @endif --}}

                            </tr>
                        </thead>
                        <tbody>

                            {{-- @php
                                dd(Auth::user());
                            @endphp --}}
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

                                        <td>{{ $total }}</td>

                                        <td>
                                            {{-- @php
                                                dd($client_id);
                                            @endphp --}}
                                            @foreach ($client_id as $item)
                                                @if ($item->status == 0)
                                                    <span class="badge badge-pill badge-warning">saved</span>
                                                @elseif ($item->status == 1)
                                                    <span class="badge badge-pill badge-danger">submit</span>
                                                @elseif ($item->status == 3)
                                                    <span class="badge badge-pill badge-info">Submitted</span>
                                                @else
                                                    <span class="badge badge-pill badge-secondary">Rejected</span>
                                                @endif
                                            @endforeach
                                        </td>
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
                                        @if (Auth::user()->role_id == 14 || Auth::user()->role_id == 15)
                                            <td>
                                                @foreach ($client_id as $item)
                                                    @if ($item->status == 2)
                                                        <a href="{{ url('/timesheetreject/edit/' . $item->timesheetid) }}"
                                                            class="btn btn-info-soft btn-sm"><i class="far fa-edit"></i></a>
                                                    @endif
                                                @endforeach
                                            </td>
                                        @endif
                                        {{-- @if (Auth::user()->role_id == 13)
                                            <td>
                                                <a class="btn btn-success" style="color:white;" data-toggle="modal"
                                                    data-target="#exampleModal1"><i class="far fa-edit"></i></a>
                                            </td>
                                        @endif --}}
                                        {{-- @if (Auth::user()->role_id == 13)
                                            <td>
                                                <a class="btn btn-success" style="color:white;" data-toggle="modal"
                                                    data-target="#exampleModal1"><i class="far fa-edit"></i></a>
                                            </td>
                                        @endif --}}

                                        {{-- <td>
                                            @if ($applyleaveDatas->leavetype == 11)
                                                <button class="btn btn-danger" data-toggle="modal"
                                                    style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                                                    data-target="#requestModal{{ $applyleaveDatas->id }}">Request</button>
                                            @endif
                                        </td> --}}
                                </tr>
                                <div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel4" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form id="detailsForm" method="post" action="{{ url('/timesheet/submit') }}"
                                                enctype="multipart/form-data" style="margin-bottom: 0px;">
                                                @csrf
                                                <div class="modal-header" style="background:#37A000;color:white; m-5">
                                                    <h5 class="modal-title font-weight-600" id="exampleModalLabel4">Update
                                                        Timesheet</h5>
                                                    <div>
                                                        <ul>
                                                            @foreach ($errors->all() as $e)
                                                                <li style="color:red;">{{ $e }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <button style="color: white" type="button" class="close"
                                                        data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="row row-sm">
                                                        {{-- <label for="name" class="col-sm-3 col-form-label font-weight-600">Name :</label> --}}
                                                        <div class="col-sm-12">
                                                            <input type="text" readonly id="teamname"
                                                                class="form-control" placeholder="Enter Name">
                                                            <input hidden class="form-control" id="timesheetid"
                                                                name="timesheetid" type="text">
                                                        </div>
                                                    </div>

                                                    <br>
                                                    @php

                                                        $clientlist = DB::table('clients')
                                                            ->select('clients.client_name', 'clients.id')
                                                            ->get();
                                                        $partner = DB::table('teammembers')
                                                            ->select('teammembers.team_member', 'teammembers.id')
                                                            ->get();
                                                        // dd($partner);
                                                        $assignmentlist = DB::table('assignments')
                                                            ->select('assignments.assignment_name', 'assignments.id')
                                                            ->get();
                                                    @endphp
                                                    <br>
                                                    {{-- <div class="row row-sm">
                                                        <div class="col-sm-12">
                                                            <input required type="date" name="date" id="date"
                                                                class="form-control" placeholder="Enter Name">


                                                        </div>
                                                    </div> --}}
                                                    {{-- <br> --}}
                                                    <div class="row row-sm">
                                                        {{-- <label for="name" class="col-sm-3 col-form-label font-weight-600">Name :</label> --}}
                                                        <div class="col-sm-6">
                                                            <label for="">Select Client</label>
                                                            <select class="form-control" name="client_id" id="client_id">
                                                                <option value="">Select Client</option>
                                                                @foreach ($clientlist as $city)
                                                                    <option value="{{ $city->id }}">
                                                                        {{ $city->client_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        {{-- <label for="name" class="col-sm-3 col-form-label font-weight-600">Name :</label> --}}
                                                        <div class="col-sm-6">
                                                            <label for="">Select Assignment</label>
                                                            <select class="form-control" name="assignment_id"
                                                                id="assignment_id">
                                                                <option value="">Select Assignment</option>
                                                                @foreach ($assignmentlist as $assignmentlistData)
                                                                    <option value="{{ $assignmentlistData->id }}">
                                                                        {{ $assignmentlistData->assignment_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <br>

                                                    <div class="row row-sm">
                                                        {{-- <label for="name" class="col-sm-3 col-form-label font-weight-600">Name :</label> --}}
                                                        <div class="col-sm-6">
                                                            <label for="">Select Partner</label>
                                                            <select class="form-control" name="partner" id="partner">
                                                                <option value="">Select Partner</option>
                                                                @foreach ($partner as $partnerData)
                                                                    <option value="{{ $partnerData->id }}">
                                                                        {{ $partnerData->team_member }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="">Employee Name</label>
                                                            <input required type="text" name="workitem" id="workitem"
                                                                class="form-control" placeholder="Enter Employee Name">
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row row-sm">
                                                        <div class="col-sm-6">
                                                            <label for="">Location</label>
                                                            <input required type="text" name="location" id="location"
                                                                class="form-control" placeholder="Enter Location">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="">Work Item</label>
                                                            <input required type="text" name="totalhour"
                                                                id="totalhour" class="form-control"
                                                                placeholder="Enter Name">
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row row-sm">
                                                        <div class="col-sm-6">
                                                            <label for="">Total Hour</label>
                                                            <input required type="text" name="location" id="location"
                                                                class="form-control" placeholder="Enter Location">
                                                        </div>
                                                    </div>
                                                    <br>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-success">Submit</button>
                                                    </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>



                                {{-- 2222222222222222222 --}}
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Add this script to the end of your HTML body or in a script section -->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <script>
            $(document).ready(function() {
                // Add a click event listener to the edit button
                $('.btn-success').on('click', function() {
                    // Get the corresponding row data
                    var rowData = $(this).closest('tr').find('td').map(function() {
                        return $(this).text();
                    }).get();

                    // Populate the form fields in the modal with the retrieved data
                    $('#teamname').val(rowData[0]); // Assuming the team name is in the first column
                    // ... Populate other fields as needed

                    // Show the modal
                    $('#exampleModal12').modal('show');
                });
            });
        </script>


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
