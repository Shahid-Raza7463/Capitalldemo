<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('material/create')}}">Add Material</a>
            </li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Material List</small>
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
                        aria-controls="pills-home" aria-selected="true">In Part</a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" id="pills-user-tab" data-toggle="pill" href="#pills-user" role="tab"
                        aria-controls="pills-user" aria-selected="false">Out Part</a>
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
                                        <th>Status</th>
                                        <th>Createdby</th>
                                        <th>Created Date</th>
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                        <th>Date Time</th>
                                        <th>Sender Name</th>
                                        <th>Item Value</th>
                                        <th>Receiver</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($materialDatas as $materialData)
                                    <tr>
                                        <td>
                                            @if($materialData->status==0)
                                            <span class="badge badge-danger">Not Acknowledge</span>
                                            @elseif($materialData->status==1)
                                            <span class="badge badge-success">Acknowledge</span>
                                            @endif
                                        </td>
                                        <td>{{ App\Models\Teammember::select('team_member')->where('id',$materialData->createdby)->first()->team_member ?? ''}}
                                        </td>
                                        <td>{{ date('F d,Y', strtotime($materialData->created_at)) }}</td>
                                        <td><a href="{{route('material.show', $materialData->id)}}">
                                                {{$materialData->item_name }}</a>
                                        </td>
                                        <td>{{$materialData->quantity }}</td>
                                        <td>{{$materialData->date_time }}</td>
                                        <td>{{$materialData->sender_name }}</td>
                                        <td>{{$materialData->item_value }}</td>
                                        <td>{{$materialData->team_member }} ({{$materialData->rolename }})</td>

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
                                    <th>Createdby</th>
                                    <th>Created Date</th>
                                    <th>Item Name</th>
                                    <th>Quantity</th>
                                    <th>Date Time</th>
                                    <th>Price</th>
                                    <th>Item Details</th>
                                    <th>Item Type</th>
                                    <th>Approver</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($materialoutDatas as $materialoutData)
                                <tr>
                                    <td>
                                        @if($materialoutData->out_status==0)
                                        <span class="badge badge-danger">Not Acknowledge</span>
                                        @elseif($materialoutData->out_status==1)
                                        <span class="badge badge-success">Acknowledge</span>

                                        @endif
                                    </td>
                                    <td>{{ App\Models\Teammember::select('team_member')->where('id',$materialoutData->createdby)->first()->team_member ?? ''}}
                                    </td>
                                    <td>{{ date('F d,Y', strtotime($materialoutData->created_at)) }}</td>
                                    <td><a href="{{route('material.show', $materialoutData->id)}}">
                                            {{$materialoutData->item_name }}</a>
                                    </td>
                                    <td>{{$materialoutData->quantity }}</td>

                                    <td>{{ date('F d,Y', strtotime($materialoutData->date_time)) }}
                                        {{ date('H:i A', strtotime($materialoutData->date_time)) }} </td>
                                    <td>{{$materialoutData->price }}</td>
                                    <td>{{$materialoutData->item_detail }}</td>
                                    <td>
                                        @if($materialoutData->item_type==0)
                                        <span>Rental</span> <br>
                                        <span><b>Expected Date</b> :
                                            {{ date('F d,Y', strtotime($materialoutData->expected_date)) }}</span>
                                        @else
                                        <span>Non-Rentable</span>
                                        @endif
                                    </td>
                                    <td>{{$materialoutData->team }} ({{$materialoutData->rolename }})</td>
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
