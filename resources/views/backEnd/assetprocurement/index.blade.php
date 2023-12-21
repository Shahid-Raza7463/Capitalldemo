<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('assetprocurement/create')}}">Add Asset Procurement Form</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Asset Procurement Form
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
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                        aria-controls="pills-home" aria-selected="true">My Application</a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" id="pills-user-tab" data-toggle="pill" href="#pills-user" role="tab"
                        aria-controls="pills-user" aria-selected="false">Team Application</a>
                </li>

            </ul>

            <br>
            <hr>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="table-responsive example">

                        <div class="table-responsive">
                            <table id="examplee" class="display nowrap">
                                <thead>
                                    <tr>
                                        <th style="display: none;">id</th>
                                        <th>Employee Name</th>
                                        <th>Raised Date</th>
										  <th>Paid Date</th>
                                        <th>Status</th>
                                        <th>Approver </th>
                                        <th>Company Name</th>
                                        <th>Item Name</th>
                                     
                                        <th>Start Date</th>
                                        <th>End Date </th>
                                        <th>Place Of Purchase</th>
                                        <th>Amount Required </th>
                                        <th>Bill / PO</th>
                                        <th>Payment Type</th>
                                      

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($assetprocurementDatas as $assetprocurementData)
                                    <tr>
                                        <td style="display: none;">{{$assetprocurementData->id }}</td>
                                        <td> <a href="{{route('assetprocurement.show', $assetprocurementData->id)}}">
                                                {{ App\Models\Teammember::select('team_member')->where('id',$assetprocurementData->createdby)->first()->team_member ?? ''}}</a>
                                        </td>
                                        <td>{{ date('F d,Y', strtotime($assetprocurementData->created_at ??'')) }}</td>
										  	<td> @if($assetprocurementData->processingdate != null)
								{{ date('F d,Y', strtotime($assetprocurementData->processingdate ??'')) }}
							@endif</td>
                                        <td>    @if($assetprocurementData->Status==0)
                                            <span class="badge badge-info">Created</span>
                                            @elseif($assetprocurementData->Status==1)
                                            <span class="badge badge-success">Approved</span>
                                            @elseif($assetprocurementData->Status==2)
                                            <span class="badge badge-danger">Rejected</span>
											 @elseif($assetprocurementData->Status==3)
                                <span class="badge badge-primary">Paid</span>
                                            @endif</td>
                                        <td>{{ $assetprocurementData->team_member }}</td>
                                       
                                            <td>{{ $assetprocurementData->companyname ??''}}</td>
                                            <td>{{ $assetprocurementData->itemname ??''}}</td>
                                          
                                            <td>  @if($assetprocurementData->startdate != null)
                                                {{ date('F d,Y', strtotime($assetprocurementData->startdate ??'')) }}@endif
                                            </td>
                                            <td>  @if($assetprocurementData->enddate != null)
                                                {{ date('F d,Y', strtotime($assetprocurementData->enddate ??'')) }}@endif
                                            </td>
                                            <td>{{ $assetprocurementData->placeofpurchase ??''}}</td>
                                            <td>{{ $assetprocurementData->amount ??''}}</td>
                                            <td><a target="blank" href="{{url('/backEnd/image/assetprocurements/'.$assetprocurementData->bill ??'')}}">
                                                {{ $assetprocurementData->bill ??''}}</a></td>

                                        <td>@if($assetprocurementData->paymenttype == 0)
                                            <span >Reimbursement</span>
                                           
                                            @else
                                            <span>Advance</span>
                                            @endif
                                        </td>
                                     
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
                        <table id="exampleee" class="display nowrap">
                            <thead>
                                <tr>
                                    <th style="display: none;">id</th>
                                    <th>Employee Name</th>
                                    <th>Status</th>
                                    <th>Raised Date</th>
                                    <th>Approver </th>
                                    <th>Company Name</th>
                                    <th>Item Name</th>
                                 
                                    <th>Start Date</th>
                                    <th>End Date </th>
                                    <th>Place Of Purchase</th>
                                    <th>Amount Required </th>
                                    <th>Bill / PO</th>
                                    <th>Payment Type</th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assetprocurementapprovedDatas as $assetprocurementData)
                                <tr>
                                    <td style="display: none;">{{$assetprocurementData->id }}</td>
                                    <td> <a href="{{route('assetprocurement.show', $assetprocurementData->id)}}">
                                            {{ App\Models\Teammember::select('team_member')->where('id',$assetprocurementData->createdby)->first()->team_member ?? ''}}</a>
                                    </td>
                                    <td>    @if($assetprocurementData->Status==0)
                                        <span class="badge badge-info">Created</span>
                                        @elseif($assetprocurementData->Status==1)
                                        <span class="badge badge-success">Approved</span>
                                        @elseif($assetprocurementData->Status==2)
                                        <span class="badge badge-danger">Rejected</span>
                                        @endif</td>
                                    <td>{{ date('F d,Y', strtotime($assetprocurementData->created_at ??'')) }}</td>
                                    <td>{{ $assetprocurementData->team_member }}</td>
                                 
                                        <td>{{ $assetprocurementData->companyname ??''}}</td>
                                        <td>{{ $assetprocurementData->itemname ??''}}</td>
                                      
                                        <td>  @if($assetprocurementData->startdate != null)
                                            {{ date('F d,Y', strtotime($assetprocurementData->startdate ??'')) }}@endif
                                        </td>
                                        <td>  @if($assetprocurementData->enddate != null)
                                            {{ date('F d,Y', strtotime($assetprocurementData->enddate ??'')) }}@endif
                                        </td>
                                        <td>{{ $assetprocurementData->placeofpurchase ??''}}</td>
                                        <td>{{ $assetprocurementData->amount ??''}}</td>
                                        <td><a target="blank" href="{{url('/backEnd/image/assetprocurements/'.$assetprocurementData->bill ??'')}}">
                                            {{ $assetprocurementData->bill ??''}}</a></td>

                                    <td>@if($assetprocurementData->paymenttype == 0)
                                        <span >Reimbursement</span>
                                       
                                        @else
                                        <span>Advance</span>
                                        @endif
                                    </td>
                                
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
        <script>
            $(document).ready(function () {
                $('#exampleee').DataTable({
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
