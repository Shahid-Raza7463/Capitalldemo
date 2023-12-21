<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('courierinout/create')}}">Add Correspondence</a>
            </li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Correspondence List</small>
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
                        aria-controls="pills-home" aria-selected="true">Out Part</a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" id="pills-user-tab" data-toggle="pill" href="#pills-user" role="tab"
                        aria-controls="pills-user" aria-selected="false">In part</a>
                </li>

            </ul>

            <br>
            <hr>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="table-responsive example">
                        <div class="table-responsive">
                            <table id="exampleee" class="display nowrap">
                                <thead>
                                    <tr>
                                        <th>Created Date</th>
                                        <th>Createdby</th>
                                        <th>status</th>
                                        <th>Priority</th>
                                        <th>Courier/Item Name</th>
                                        <th>Tracking No.</th>
                                        <th>Assigned to</th>
                                        <th>Address</th>
                                        <th>Courier Charges</th>
                                        <th>Estimated Date / Delivery Date</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($courierDatas as $courierData)
                                    <tr>
                                        <td>{{ date('F d,Y', strtotime($courierData->created_at)) }}</td>
                                        <td>{{ App\Models\Teammember::select('team_member')->where('id',$courierData->createdby)->first()->team_member ?? ''}}
                                        </td>
                                        
                                        <td>
                                            @if($courierData->status==0)
                                            <span class="badge badge-info">Assigned</span>
                                            @elseif($courierData->status==1)
                                            <span class="badge badge-warning">Processing</span>
                                            @elseif($courierData->status==2)
                                            <span class="badge badge-success">Delivered</span>
                                            @else
                                            <span class="badge badge-danger">Revert Back</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($courierData->priority==0)
                                            <span class="badge badge-info">Urgent</span>
                                            @else
                                            <span class="badge badge-success">Normal</span>
                                            @endif
                                        </td>
                                        <td><a href="{{route('courierinout.show', $courierData->id)}}">
                                                {{$courierData->courier_item_name }}</a>
                                        </td>
                                        <td>{{$courierData->tracking }} </td>
                                        <td>{{$courierData->team_member }} ({{$courierData->rolename }})</td>
                                        <td>{{$courierData->address }}</td>
                                        <td>{{$courierData->courier_charges }}</td>
                                        <td>@if ($courierData->estimated_date_of_delivery_date !=  null)
                                            {{ date('F d,Y', strtotime($courierData->estimated_date_of_delivery_date)) }}
                                        @endif</td>
                                      
                                        
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
                        <table id="examplee" class="display nowrap">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    <th>Createdby</th>
                                    <th>Courier/Item Name</th>
                                    <th>Handover to</th>
                                    <th>Date Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($courierreceiverDatas as $courierreceiverData)
                                <tr>
                                    <td>
                                        @if($courierreceiverData->in_status==0)
                                        <span class="badge badge-danger"> Not Acknowledge</span>
                                        @elseif($courierreceiverData->in_status ==1)
                                        <span class="badge badge-success">Acknowledge</span>
                                        @endif
                                    </td>
                                    <td> {{ date('F d,Y', strtotime($courierreceiverData->created_at)) }}</td>
                                    <td>{{ App\Models\Teammember::select('team_member')->where('id',$courierreceiverData->createdby)->first()->team_member ?? ''}}
                                    </td>
                                    <td><a href="{{route('courierinout.show', $courierreceiverData->id)}}">
                                            {{$courierreceiverData->courier_item_name }}</a>
                                    </td>
                                    <td>{{$courierreceiverData->team_member }} ({{$courierreceiverData->rolename }})
                                    </td>
                                    <td> {{ date('F d,Y', strtotime($courierreceiverData->date_time)) }} {{ date('h:i A', strtotime($courierreceiverData->date_time)) }}</td>
                                  
                                  
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
    $(document).ready(function () {
        $('#exampleee').DataTable({
            "pageLength": 50,
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
        $('#examplee').DataTable({
            "pageLength": 50,
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
