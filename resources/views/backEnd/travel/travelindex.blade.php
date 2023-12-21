<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('travel/create')}}">Add Advance Claim Form</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Advance Claim Form
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
                <table id="examplee" class="display nowrap">
                    <thead>
                        <tr>
                            <th style="display: none;">id</th>
                            <th>Employee Name</th>
                            <th>Raised Date</th>
                            <th>Conveyance Type</th>
                            <th>Approver </th>
                            <th>Approvel Status</th>
                            <th>Client Name</th>
                            <th>Advance Transaction Number</th>
                            <th>Assignment Name</th>
                            <th>Start Date</th>
                            <th>End Date </th>
                            <th>Advance Amount Required </th>
                            @if(Auth::user()->role_id == 11 || Auth::user()->role_id == 17 ||
                            Auth::user()->role_id == 18)
                            <th>Advance Amount Given </th>
                            <th>Status Of Payment</th>
                            <th>Status Of Advance Adjustment</th>
                            @endif
                            <th>Net Receivable / Payable</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($travelDatas as $travelData)
                        <tr>
                            <td style="display: none;">{{$travelData->id }}</td>
                            <td> <a href="{{route('travel.show', $travelData->id)}}">
                                    {{ App\Models\Teammember::select('team_member')->where('id',$travelData->createdby)->first()->team_member ?? ''}}</a>
                            </td>
                            <td>{{ date('F d,Y', strtotime($travelData->created_at ??'')) }}</td>
                            <td>{{ $travelData->chooseconveyance ??'' }}</td>
                            <td>{{ $travelData->team_member }}</td>
                            <td>@if($travelData->travelstatus == 0)
                                <span class="badge badge-pill badge-warning">Created</span>
                                @elseif($travelData->travelstatus == 1)
                                <span class="badge badge-pill badge-success">Approved</span>
                                @else
                                <span class="badge badge-pill badge-danger">Reject</span>
                                @endif
                            </td>
                            <td>
                                {{$travelData->client_name ??''}}</td>
                            <td>{{ $travelData->assignmentgenerate_id }}</td>
                            <td> @if($travelData->Nature_of_Assignment !=
                                null){{ $travelData->Nature_of_Assignment }}@else
                                {{ $travelData->assignmentsname ??''}} @endif</td>

                            @if($travelData->Expected_date_of_departure != null)
                            <td>{{ date('F d,Y', strtotime($travelData->Expected_date_of_departure ??'')) }}
                            </td>
                            @else
                            <td></td>
                            @endif
                            @if($travelData->Expected_date_of_arrival != null)
                            <td>{{ date('F d,Y', strtotime($travelData->Expected_date_of_arrival ??'')) }}
                            </td>
                            @else
                            <td></td>
                            @endif

                            <td>{{ $travelData->advanceamount }}</td>
                            @if(Auth::user()->role_id == 11 || Auth::user()->role_id == 17 ||
                            Auth::user()->role_id == 18)
                            <td>{{ $travelData->Advance_Amount }}</td>


                            <td>@if($travelData->Status == 2)
                                <span>Pending</span>

                                @elseif($travelData->Status == 0)
                                <span>Paid</span>


                                @else
                                <span>On Hold</span>
                                @endif</td>


                            <td>@if($travelData->adjustablestatus == 0)
                                <span>Not Adjusted Yet</span>
                                @else
                                <span>Adjusted</span>
                                @endif</td>
                            @endif
                            <td>{{ $travelData->adjust ??'0'}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
            $(document).ready(function () {
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
