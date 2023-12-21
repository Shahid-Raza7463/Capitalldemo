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
                <small>Assignment Report List</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="card mb-4">
    
        <div class="card-body">
			{{-- <form action="{{ url('/search')}}" method="GET" role="search">
          
                 <div class="input-group">
                     <input type="text" class="form-control" name="q"
                         placeholder="Search invoice by amount , invoice no , partner , client"> <span class="input-group-btn">
                         <button type="submit" style="font-size: 17px;" class="btn btn-success">
                            <i class="fas fa-search"></i>
                         </button>
                       
                     </span>
                 </div>
             </form> --}}
             <br>
            @component('backEnd.components.alert')

            @endcomponent   
			 @if(isset($invoiceData))
            <div class="table-responsive">
                 <table id="examplee" class="display nowrap">
                    <thead>
                        <tr>
							  <th style="display: none;">id</th>
                            <th>Client</th>
							 <th>Assignment</th>
							 <th>Partner</th>
							
                            <th>Invoice Date</th>
							  <th>Client Data Uploaded</th>
							  <th>Audit Documentation Status</th>
							 <th>Final Report Date</th>
							    <th>Final Report</th>
							  <th>Due Date Of Recovery</th>
							<th>Appointment Letter</th>
                            <th>Annexure</th>
							<th>Difference Between invoice date and final report date</th>
							<th>Difference Between Due date of recovery and invoice date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoiceData as $invoiceDatas)
                        <tr>
							   <td style="display: none;">{{$invoiceDatas->id }}</td>
							<td>{{$invoiceDatas->client_name }}</td>
							<td>
                                @if($invoiceDatas->assignment_name != null)
                                <span>{{$invoiceDatas->assignment_name  ??''}}</span>
                                @endif</td>
							<td>{{$invoiceDatas->team_member }}</td>
							
                            <td>{{ date('m/d/Y', strtotime($invoiceDatas->invoicedate)) }}</td>
							@php
							$clientdata = DB::table('invoices')->where('id',$invoiceDatas->id)->first();
							@endphp
							 <td>
								 @if($clientdata->clientdata == '1')
								 <span>No</span>
                                @endif
								  @if($clientdata->clientdata == '0')
								 <span>Yes</span>
                                @endif
                            </td>				 <td> 
							
							
							@if($clientdata->auditdocument == '0')
								 <span> Done</span>
                                @endif
							@if($clientdata->auditdocument == '1')
								 <span>Not Done</span>
                                @endif
									@if($clientdata->auditdocument == '2')
								 <span>Partially Done</span>
                                @endif	
                            </td>
							     <td>@if($invoiceDatas->finalreportdate != null){{ date('m/d/Y', strtotime($invoiceDatas->finalreportdate)) }}@endif</td>
							
							    <td>  <a href="{{ Storage::disk('s3')->temporaryUrl('invoice/'.$invoiceDatas->finalreport, now()->addMinutes(3)) }}" target="blank" data-toggle="tooltip"
                                    title="{{ $invoiceDatas->finalreport ??'' }}" >{{ $invoiceDatas->finalreport }}</a></td>
										     <td>@if($invoiceDatas->duedateofrecovery != null){{ date('m/d/Y', strtotime($invoiceDatas->duedateofrecovery)) }}@endif</td>
                                    <td> <a href="{{ Storage::disk('s3')->temporaryUrl('invoice/'.$invoiceDatas->appointmentletter, now()->addMinutes(3)) }}" target="blank" data-toggle="tooltip"
                                        title="{{ $invoiceDatas->appointmentletter ??'' }}" >{{ $invoiceDatas->appointmentletter }}</a></td>
                                        <td> <a href="{{ Storage::disk('s3')->temporaryUrl('invoice/'.$invoiceDatas->annexure, now()->addMinutes(3)) }}" target="blank" data-toggle="tooltip"
                                            title="{{ $invoiceDatas->annexure ??'' }}" >{{ $invoiceDatas->annexure }}</a></td>
							@php 
							 $current=$invoiceDatas->invoicedate;    
        $formatted_dt1=Carbon\Carbon::parse($current);
							  $ifdate=$formatted_dt1->diffInDays($invoiceDatas->finalreportdate);
							
							 $duedateofrecovery=$invoiceDatas->duedateofrecovery;    
        $formatted_dt1=Carbon\Carbon::parse($duedateofrecovery);
							  $duedateofrecoveryinvoice=$formatted_dt1->diffInDays($invoiceDatas->invoicedate);
                         
							@endphp
							 <td>@if($invoiceDatas->finalreportdate != null)
                                @if(date('Y', strtotime($invoiceDatas->invoicedate)) > date('Y', strtotime($invoiceDatas->finalreportdate)))
                                {{  $ifdate  ??''}}
								  @elseif(date('Y', strtotime($invoiceDatas->invoicedate)) < date('Y', strtotime($invoiceDatas->finalreportdate)))
                                {{  -$ifdate  ??''}}
                                @elseif(date('m/d/Y', strtotime($invoiceDatas->invoicedate)) > date('m/d/Y', strtotime($invoiceDatas->finalreportdate)))
                                {{  $ifdate  ??''}}
                                @else
                                {{ -$ifdate  ??''}}
                                @endif
                               
                                @endif
                            </td>
							<td>@if($invoiceDatas->duedateofrecovery != null)
								{{ $duedateofrecoveryinvoice ??''}}
							@endif
							</td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
			   {{-- {!! $invoiceData->render() !!} --}}
            </div>
			  @elseif(isset($message))
			<p>{{ $message }}</p>
			
                    @endif
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

