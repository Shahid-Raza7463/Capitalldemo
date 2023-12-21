<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('development/create')}}">Add Development</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
            <div class="media-body">
               <a href="{{url('home')}}"> <h1 class="font-weight-bold" style="color:black;">Home</h1></a>
                <small>Development List</small>
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
                            <th>Task Name</th>
                            <th>Testing By</th>
							 <th>Testing Date</th>
							 <th>Due Date</th>
                            <th>Task Given By</th>
							<th>Remarks</th>
                            <th>Status</th>
                             
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($developmentDatas as $developmentData)
                        <tr>
							<td style="display: none;">{{$developmentData->id }}</td>
                            <td><a href="{{route('development.show', $developmentData->id)}}">{{$developmentData->taskname ??''}}</a></td>
                            <td> {{$developmentData->team_member ??'' }} ( {{$developmentData->rolename}} )</td>
                            <td>{{ date('F d,Y', strtotime($developmentData->testingdate)) }}</td> 
                            <td>{{ date('F d,Y', strtotime($developmentData->duedate)) }}</td> 
							<td>{{ App\Models\Teammember::select('team_member')->where('id',$developmentData->createdby)->first()->team_member ?? '' }}</td>
							<td>{!! $developmentData->remarks ??'' !!}</td>
                          <td>@if($developmentData->status ==  0)
                            <span class="badge badge-pill badge-warning">Active</span>
                            @else
                            <span class="badge badge-pill badge-success">Inactive</span> 
                            @endif</td>    
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
    $('#exampleee').DataTable( {
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