<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')
    <!--Content Header (Page header)-->
    <div class="content-header row align-items-center m-0">

        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
                <div class="media-body">
                    <a href="{{ url('home') }}">
                        <h1 class="font-weight-bold" style="color:black;">Home</h1>
                    </a>
                    <small>Timesheet Request List</small>
                </div>
            </div>
        </div>
    </div>
    <!--/.Content Header (Page header)-->
    <div class="body-content">
        <div class="card mb-4">
            @component('backEnd.components.alert')
            @endcomponent
            <div class="card-body">
                <div class="table-responsive">
                    <table id="exampleee" class="display nowrap">
                        <thead>
                            <tr>
                                <th style="display: none;">id</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Created By</th>
                                <th>Approver</th>
                                <th>Reason</th>
                                <th>Reason for Reject</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($timesheetrequestsDatas as $timesheetrequestsData)
                                <tr>
                                    <td style="display: none;">{{ $timesheetrequestsData->id }}</td>
                                    <td>
                                        @if ($timesheetrequestsData->status == 0)
                                            <span class="badge badge-pill badge-warning">Created</span>
                                        @elseif($timesheetrequestsData->status == 1)
                                            <span class="badge badge-pill badge-success">Approved</span>
                                        @else
                                            <span class="badge badge-pill badge-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>{{ date('d-m-Y', strtotime($timesheetrequestsData->created_at)) }}</td>
                                    <td>{{ date('h-m-s', strtotime($timesheetrequestsData->created_at)) }}</td>
                                    <td><a href="{{ url('timesheetrequest/view', $timesheetrequestsData->id) }}">
                                            {{ $timesheetrequestsData->createdbyauth }}</a></td>
                                    <td>{{ $timesheetrequestsData->team_member }}</td>
                                    <td>{{ $timesheetrequestsData->reason }}</td>
                                    <td>{{ $timesheetrequestsData->remark }}</td>
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
        $('#exampleee').DataTable({
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
