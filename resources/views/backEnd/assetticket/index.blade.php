<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('createticket')}}">Generate Ticket</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Ticket Support List</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
 
    <div class="card mb-4">
    
        <div class="card-body">
            <div class="table-responsive">
             <table id="examplee" class="display nowrap">
                    <thead>
                        <tr>
							  <th style="display: none;">id</th>
                            <th>Ticket</th>
                          <th>Asset</th>
                            <th>Created By</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ticketDatas as $ticketData)
                        <tr>
							  <td style="display: none;">{{$ticketData->id }}</td>
                            <td> <a href="{{url('/ticket/'.$ticketData->id)}}"><b>#{{$ticketData->generateticket_id }}</b> - - {{$ticketData->subject }}<br>
                         <!--   <span> @if($ticketData->item==0)
                                <span >Laptop</span>
                                @else
                                <span>Mobile</span>
                                @endif</span>-->
								( @if($ticketData->priority==0 )
                                <span >High</span>
                                @elseif($ticketData->priority==1 )
                                <span>Medium</span>
                                @else
                                <span>Low</span>
								@endif)</a></td>
                                 @php
$asset = App\Models\Financerequest::where('id',$ticketData->asset_id)->first();
						//	dd($asset);
                           @endphp
                            <td>{{$asset->modal_name ??''}} {{$asset->sno ??''}}</td>
                            <td>{{$ticketData->team_member }}</td>
                            <td>{{ date('d-M-Y', strtotime($ticketData->created_at)) }}</td>
                            <td>@if($ticketData->status==0)
                                <span class="badge badge-success">open</span>
                                @elseif($ticketData->status==1)
                                <span   class="badge badge-success">working</span>
                                @elseif($ticketData->status==2)
                                <span class="badge badge-danger">close</span>
                                @else
                                <span>reject</span>
                                @endif
                            </td>
                            
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div><!--/.body content-->

@endsection
   <script src="https://code.jquery.com/jquery-3.5.1.js"></script>                               
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>                               
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>                               
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>                               
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>                               
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>                               
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>                               
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>    
<script>$(document).ready(function() {
    $('#examplee').DataTable( {
        dom: 'Bfrtip',
        "order": [[ 0, "desc" ]],
        
        buttons: [
            
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, ':visible' ]
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
                    columns: [ 0, 1, 2, 5 ]
                }
            },
            'colvis'      
    ]  
    } );
} );</script>                                



