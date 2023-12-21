<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
		 @if(Auth::user()->teammember_id != 310)
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('auditticket/create')}}">Add Audit Query</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
	@endif
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
            <div class="media-body">
               <a href="{{url('home')}}"> <h1 class="font-weight-bold" style="color:black;">Home</h1></a>
                <small>Audit Query List</small>
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
                            <th>Name of Employee</th>
                            {{-- <th>Official Email</th> --}}
							  <th>Client</th>
                            <th>Audit  Query</th>
							 <th>Priority</th>
							<th>Timeline</th>
                            <th>Created Date</th>
                            <th>Status</th>
                             
                        </tr>
                    </thead>
                   
                    <tbody>

            
                        @foreach($taskDatas as $taskData)

                        @php
                        $emp=App\Models\Teammember::join('roles','roles.id','teammembers.role_id')
                        ->where('teammembers.id',$taskData->createdby)->first();
                        
                        @endphp
                        <tr>
							   <td style="display: none;">{{$taskData->id }}</td>
                            <td>{{ $emp->team_member ?? '' }} ({{$emp->rolename ??''}})</td>
                           
                           {{-- <td>{{ App\Models\Teammember::select('emailid')->where('id',$taskData->createdby)->pluck('emailid')->first()}}</td> --}}
                          <td>{{ App\Models\Client::select('client_name')->where('id',$taskData->client_id)->pluck('client_name')->first()}}</td>
  <td><a href="{{url('view/auditticket', $taskData->id)}}" >{{$taskData->taskname ??''}}</a></td>
							<td> @if($taskData->priority == 0 )
                                <span class="badge badge-pill badge-success">High</span>
                                @elseif($taskData->priority == 1 )
                                <span class="badge badge-pill badge-primary">Medium</span>
                                @else
                                <span class="badge badge-pill badge-info">Low</span>
								@endif</td>
                            <td>{{ date('F d,Y', strtotime($taskData->duedate)) }}</td>
                            <td>{{ date('F d,Y', strtotime($taskData->created_at)) }}</td>
                          <td>@if($taskData->status ==  0)
                            <span class="badge badge-pill badge-warning">Pending</span>
                            @else
                            <span class="badge badge-pill badge-danger">Completed</span>
                            @endif
                        </td>
                            <!-- @php
                        $taskassig = DB::table('taskassign')
        ->leftjoin('teammembers','teammembers.id','taskassign.teammember_id')
        ->leftjoin('roles','roles.id','teammembers.role_id')
        ->where('taskassign.task_id',$taskData->id)->select('teammembers.team_member','roles.rolename')->get();
                  //  dd($taskassig);
                    @endphp
                            @if($taskData->createdby ==  Auth::user()->teammember_id)
                            <td> @foreach($taskassig as $taskassign)<span><a  >{{$taskassign->team_member ??'' }} ( {{$taskassign->rolename}} )</a></span>,@endforeach</td>
                          @else
							 <td>@foreach($taskassig as $taskassign)<span>{{$taskassign->team_member ??'' }} ( {{$taskassign->rolename}} )</span> ,@endforeach</td>
							@endif
							
							<td>{{ App\Models\Teammember::select('team_member')->where('id',$taskData->createdby)->first()->team_member ?? '' }}</td>
							
                            -->
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
} );
</script>
