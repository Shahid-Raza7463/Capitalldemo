<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">

<!--Third party Styles(used by this page)-->
<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">


@extends('backEnd.layouts.layout') @section('backEnd_content')
    <!--Content Header (Page header)-->
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('timesheet/create') }}">Add Timesheet</a>
                </li>
                <!--  <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal1">Upload File</a></li>-->
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Home</h1>
                    <small>Time sheet List</small>
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
                    <table id="examplee" class="display nowrap">
                        <thead>

                            <tr>
                                <th style="display: none;">id</th>
                                <th>Employee Name</th>
                                <th>Date</th>
                                <th>Day</th>
                                <th>Client Name</th>
                                <th>Assignment Name</th>

                                <th>Work Item</th>
                                <th>Partner</th>
                                <th>Billing Status</th>
                                <th>Hour</th>
                                <th>Total Hour</th>
                                @if (Auth::user()->role_id == 18)
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($timesheetData as $timesheetDatas)
                                <tr>
                                    @php

                                        $client_id = DB::table('timesheetusers')
                                            ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
                                            ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
                                            ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.partner')
                                            ->where('timesheetusers.timesheetid', $timesheetDatas->id)

                                            ->select('clients.client_name', 'timesheetusers.hour', 'assignments.assignment_name', 'billable_status', 'workitem', 'teammembers.team_member')
                                            ->get();
                                        //dd($client_id);
                                        $total = DB::table('timesheetusers')

                                            ->where('timesheetusers.timesheetid', $timesheetDatas->id)
                                            ->sum('hour');

                                        $dates = date('l', strtotime($timesheetDatas->date));
                                    @endphp
                                    <td style="display: none;">{{ $timesheetDatas->id }}</td>
                                    <td>{{ $timesheetDatas->team_member ?? '' }} </td>
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
                                                {{ $item->team_member ?? '' }} @if ($item->team_member != null)
                                                    ,
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($client_id as $item)
                                                {{ $item->billable_status ?? '' }} @if ($item->billable_status != null)
                                                    ,
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($client_id as $item)
                                                {{ $item->hour ?? '' }} @if ($item->hour != null)
                                                    ,
                                                @endif
                                            @endforeach
                                        </td>






                                        <td>{{ $total }}</td>
                                        @if (Auth::user()->role_id == 18)
                                            <td> <a href="{{ url('/timesheet/destroy/' . $timesheetDatas->id) }}"
                                                    onclick="return confirm('Are you sure you want to delete this item?');"
                                                    class="btn btn-danger-soft btn-sm"><i class="far fa-trash-alt"></i></a>
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
    <!-- Modal -->
    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="detailsForm" method="post" action="{{ url('timesheetexcel/store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header" style="background: #37A000">
                        <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Add Excel</h5>
                        <div>
                            <ul>
                                @foreach ($errors->all() as $e)
                                    <li style="color:red;">{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="details-form-field form-group row">
                            <label for="name" class="col-sm-3 col-form-label font-weight-600">Upload Excel:</label>
                            <div class="col-sm-9">
                                <input id="name" class="form-control" name="file" type="file">
                                <input hidden value="{{ $clientid->client_id ?? '' }}" class="form-control"
                                    name="client_id" type="text">
                                <input hidden value="{{ $id ?? '' }}" class="form-control" name="ilrfolder_id"
                                    type="text">
                            </div>

                        </div>

                        <div class="details-form-field form-group row">
                            <label for="address" class="col-sm-3 col-form-label font-weight-600">Sample Excel:</label>
                            <div class="col-sm-9">
                                <a href="{{ url('backEnd/timesheetformats.xlsx') }}" class="btn btn-success btn">Download<i
                                        class="fas fa-file-excel" style="margin-left: 3px;font-size: 20px;"></i></a>

                            </div>
                        </div>
                        <div class="details-form-field form-group row">
                            <label for="address" class="col-sm-3 col-form-label font-weight-600">Instruction <span
                                    style="color:red;">*</span></label>
                            <div class="col-sm-9" style="  margin-top: 10px; ">

                                <span>
                                    Please note the Client Name (click <a target="blank"
                                        href="{{ url('clientassignmentlist') }}"> here</a> to see clients), Assignment Name
                                    (click <a target="blank" href="{{ url('clientassignmentlist') }}"> here</a> to
                                    see assignments) and Partner Name (click <a target="blank"
                                        href="{{ url('clientassignmentlist') }}"> here</a> to
                                    see Partner) should be as same as it is updated on Portal (KGS Capitall). Date (M/D/Y) ,
                                    Hour
                                    format should be as same as mentioned
                                    in the Timesheet Format. If you have not worked on non working day (holiday/2nd or 4th
                                    Sat/Sunday, please skip/do not mention those dates in your excel sheet when uploading
                                    the
                                    excel sheet. </span>


                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="exampleModal21" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="detailsForm" method="post" action="{{ url('timesheetrequest/store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header" style="background: #37A000">
                        <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Add Request
                        </h5>
                        <div>
                            <ul>
                                @foreach ($errors->all() as $e)
                                    <li style="color:red;">{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="details-form-field form-group row">
                            <label for="name" class="col-sm-3 col-form-label font-weight-600">Client:</label>
                            <div class="col-sm-9">
                                <select required class="language form-control" name="client_id" id="client"
                                    @if (Request::is('timesheet/*/edit')) > <option disabled style="display:block">Select
                                Client
                                </option>

                                @foreach ($client as $clientData)
                                <option value="{{ $clientData->id }}"
                                    {{ $timesheet->client_id == $clientData->id ?? '' ? 'selected="selected"' : '' }}>
                                    {{ $clientData->client_name }}</option>
                                @endforeach


                                @else
                                <option></option>
                                <option value="">Select Client</option>
                                @foreach ($client as $clientData)
                                <option value="{{ $clientData->id }}">
                                    {{ $clientData->client_name }}</option>

                                @endforeach @endif
                                    </select>

                            </div>

                        </div>
                        <div class="details-form-field form-group row">
                            <label for="name" class="col-sm-3 col-form-label font-weight-600">Assignment:</label>
                            <div class="col-sm-9">
                                <select required class="form-control key" name="assignment_id" id="assignment">
                                    @if (!empty($timesheet->assignment_id))
                                        <option value="{{ $timesheet->assignment_id }}">
                                            {{ App / Models / Assignment::where('id', $timesheet->assignment_id)->first()->assignment_name ?? '' }}
                                        </option>
                                    @endif
                                </select>

                            </div>

                        </div>
                        <div class="details-form-field form-group row">
                            <label for="name" class="col-sm-3 col-form-label font-weight-600">Partner :</label>
                            <div class="col-sm-9">
                                <select class="language form-control" id="category" name="partner">
                                    <option value="">Please Select One</option>
                                    @foreach ($partner as $teammemberData)
                                        <option value="{{ $teammemberData->id }}">
                                            {{ $teammemberData->team_member }}</option>
                                    @endforeach
                                </select>

                            </div>

                        </div>
                        <div class="details-form-field form-group row">
                            <label for="name" class="col-sm-3 col-form-label font-weight-600">Reason :</label>
                            <div class="col-sm-9">
                                <textarea rows="4" name="reason" class="form-control" placeholder="Enter Reason"></textarea>

                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $(function() {
            $('#client').on('change', function() {
                var cid = $(this).val();
                // alert(category_id);
                $.ajax({
                    type: "get",
                    url: "{{ url('timesheet/create') }}",
                    data: "cid=" + cid,
                    success: function(res) {
                        $('#assignment').html(res);
                    },
                    error: function() {},
                });
            });
        });
    </script>
@endsection
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            dom: 'Bfrtip',
            "order": [
                [0, "desc"]
            ],

            buttons: [

                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 5]
                    }
                },
                'colvis'
            ]
        });
    });
</script>
