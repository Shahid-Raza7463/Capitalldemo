@extends('backEnd.layouts.layout') @section('backEnd_content')
    <!--Content Header (Page header)-->
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            @if (Auth::user()->role_id == 11 || Auth::user()->role_id == 18)
                <a href="{{ url('leave/teamapplication/') }}" style="float: right;" class="btn btn-success ml-2">Team
                    Application</a>
            @endif
            {{-- <a href="{{ url('applyleave/create/') }}" style="float: right;" class="btn btn-success ml-2">Apply Leave</a> --}}
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Home</h1>
                    <small>Exam leave revert</small>
                </div>
            </div>
        </div>
    </div>
    <div class="body-content">

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
                            aria-controls="pills-home" aria-selected="true">My Leave Revert</a>
                    </li>

                    @if (Auth::user()->role_id == 13)
                        <li class="nav-item">
                            <a class="nav-link" id="pills-user-tab" data-toggle="pill" href="#pills-user" role="tab"
                                aria-controls="pills-user" aria-selected="false">Team Leave Revert</a>
                        </li>
                    @endif
                </ul>

                <br>
                <hr>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="table-responsive example">

                            @if (session('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table id="examplee" class="table display table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th style="display: none;">id</th>
                                            <th>Employee</th>
                                            <th>Status</th>
                                            <th>Leave Type</th>
                                            <th>Date</th>
                                            <th>Approver</th>
                                            <th>Reason</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($timesheetrequestsDatas as $timesheetrequestsData)
                                            <tr>
                                                <td style="display: none;">{{ $timesheetrequestsData->id }}</td>
                                                {{-- <td>{{ $timesheetrequestsData->createdbyauth }}</td> --}}
                                                @if (auth()->user()->role_id == 11)
                                                    <td>
                                                        {{-- <a href="{{ route('applyleave.show', $applyleaveDatas->id) }}"> --}}
                                                        <a href="{{ url('examleaverequest', $timesheetrequestsData->id) }}">
                                                            {{ $timesheetrequestsData->createdbyauth ?? '' }}</a>
                                                    </td>
                                                @else
                                                    <td>{{ $timesheetrequestsData->createdbyauth }}</td>
                                                @endif
                                                <td>
                                                    @if ($timesheetrequestsData->status == 0)
                                                        <span class="badge badge-pill badge-warning">Created</span>
                                                    @elseif($timesheetrequestsData->status == 1)
                                                        <span class="badge badge-pill badge-success">Approved</span>
                                                    @else
                                                        <span class="badge badge-pill badge-danger">Rejected</span>
                                                    @endif
                                                </td>
                                                <td>{{ $timesheetrequestsData->name }}</td>

                                                <td>{{ date('d-m-Y', strtotime($timesheetrequestsData->created_at)) }}</td>

                                                <td>{{ $timesheetrequestsData->team_member }}</td>
                                                <td>{{ $timesheetrequestsData->reason }}</td>
                                                {{-- <td>{{ $timesheetrequestsData->remark }}</td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="tab-pane fade" id="pills-user" role="tabpanel" aria-labelledby="pills-user-tab">

                        <div class="table-responsive">
                            <table id="examplee" class="table display table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="display: none;">id</th>
                                        <th>Employee</th>
                                        <th>Status</th>
                                        <th>Leave Type</th>
                                        <th>Date</th>
                                        <th>Approver</th>
                                        <th>Reason</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($myteamtimesheetrequestsDatas as $timesheetrequestsDatass)
                                        <tr>
                                            <td style="display: none;">{{ $timesheetrequestsDatass->id }}</td>
                                            {{-- <td>{{ $timesheetrequestsData->createdbyauth }}</td> --}}
                                            {{-- @if (auth()->user()->role_id == 11) --}}
                                            @if (auth()->user()->role_id == 13)
                                                <td>
                                                    {{-- <a href="{{ route('applyleave.show', $applyleaveDatas->id) }}"> --}}
                                                    <a href="{{ url('examleaverequest', $timesheetrequestsDatass->id) }}">
                                                        {{ $timesheetrequestsDatass->createdbyauth ?? '' }}</a>
                                                </td>
                                            @else
                                                <td>{{ $timesheetrequestsDatass->createdbyauth }}</td>
                                            @endif
                                            <td>
                                                @if ($timesheetrequestsDatass->status == 0)
                                                    <span class="badge badge-pill badge-warning">Created</span>
                                                @elseif($timesheetrequestsDatass->status == 1)
                                                    <span class="badge badge-pill badge-success">Approved</span>
                                                @else
                                                    <span class="badge badge-pill badge-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td>{{ $timesheetrequestsDatass->name }}</td>

                                            <td>{{ date('d-m-Y', strtotime($timesheetrequestsData->created_at)) }}</td>

                                            <td>{{ $timesheetrequestsDatass->team_member }}</td>
                                            <td>{{ $timesheetrequestsDatass->reason }}</td>
                                            {{-- <td>{{ $timesheetrequestsData->remark }}</td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                    </div>
                    <div>
                    </div>
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
        $('#examplee').DataTable({
            "pageLength": 10,
            "dom": 'Bfrtip',
            "order": [
                [1, "desc"]
            ],

            buttons: [{
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                },
                text: 'Export to Excel',
                className: 'btn-excel',
            }, ]
        });

        $('.btn-excel').hide();
    });
</script>
