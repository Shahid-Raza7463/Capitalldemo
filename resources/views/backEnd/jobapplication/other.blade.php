<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">

@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>All Other Applications</small>
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
							 <th>Applied On</th>
                             <th>Name</th>
							 <th>Email</th>
							 <th>Phone No.</th>
                            <th>Qualifications</th>
                             <th>Position</th>
                            <th>Experience</th>
                           
                            <th>Resume</th>
                        </tr>
                    </thead>
                    <tbody>
                           @foreach($others as $othersDatas)
                        <tr>
                             <td style="display: none;">{{$othersDatas->sno }}</td>
							   <td>{{ date('F d,Y', strtotime($othersDatas->applied_on)) }} {{ date('h:i A', strtotime($othersDatas->applied_on)) }}</td>
                            <td>{{$othersDatas->name }}</td>
							 <td>{{$othersDatas->email }}</td>
							 <td>{{$othersDatas->contact_no }}</td>
                            <td>{{$othersDatas->qualification }}</td>
                            <td>{{$othersDatas->position_applied }}</td>
                            <td>{{$othersDatas->work_experience }}</td>
                         
                            	<td><a target='blank' href= "{{'https://kgsomani.com/media/'.$othersDatas->resume ??'' }}">{{$othersDatas->resume ??'' }}</a></td>
                           
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

