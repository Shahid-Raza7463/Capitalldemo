<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
	   
    <nav aria-label="breadcrumb" class="col-sm-6 order-sm-last mb-3 mb-sm-0 p-0 ">
		 @if(Auth::user()->teammember_id == 543)
		   <a href="{{ url('invoiceassignmentreport') }}" style="float: right;" class="btn btn-success ml-2"><i
                        class="typcn typcn-plus mr-1"></i>Assignment Report</a>
		@endif
       @if(Auth::user()->role_id != 18)
		   <a href="{{ url('invoice/create') }}" style="float: right;" class="btn btn-success ml-2"><i
                        class="typcn typcn-plus mr-1"></i>Add Invoice</a>
		@endif
		 @if(Auth::user()->role_id == 11 || Auth::user()->role_id == 17)
		   <a href="{{ url('payment') }}" style="float: right;" class="btn btn-success ml-2">Outstanding Received</a>
		@endif
		 <a target ="blank" href="{{ url('invoiceassignmentreport/barchart') }}" style="float: right;" class="btn btn-success ml-2">Invoice Dashboard</a>
    </nav>
	
    <div class="col-sm-6 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Invoice List</small>
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
                            <th style="padding-right: 56px;">Invoice No.</th>
                            <th>Client</th>
							  <th>Partner</th>
							  <th>Assignment</th>
                            <th>Invoice Date</th>
							    <th>Amount</th>
							<th>Payment Status</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoiceData as $invoiceDatas)
                        <tr>
							   <td style="display: none;">{{$invoiceDatas->id }}</td>
                            <td><a href="{{url('/invoiceview/'.$invoiceDatas->id )}}" >{{$invoiceDatas->invoice_id }}</a></td>
                            <td> <a href="{{route('invoice.edit', $invoiceDatas->id)}}">{{$invoiceDatas->client_name }}</a></td>
							<td>{{$invoiceDatas->team_member }}</td>
                              <td>  @if($invoiceDatas->assignment_name != null)
                              {{$invoiceDatas->assignment_name  ??''}}
                                @endif
							</td>
                            <td>{{ date('F d,Y', strtotime($invoiceDatas->invoicedate)) }}</td>
							    <td>{{ number_format($invoiceDatas->total) ??'' }}
							 @if ($invoiceDatas->paymentstatus == 'Partially Received')
                                    @php
$tds = DB::table('payments')->where('invoiceid',$invoiceDatas->invoice_id)->sum('tds');
$roundoff = DB::table('payments')->where('invoiceid',$invoiceDatas->invoice_id)->sum('roundoff');
$tdscgst = DB::table('payments')->where('invoiceid',$invoiceDatas->invoice_id)->sum('tdscgst');
$tdsigst = DB::table('payments')->where('invoiceid',$invoiceDatas->invoice_id)->sum('tdsigst');
$tdssgst = DB::table('payments')->where('invoiceid',$invoiceDatas->invoice_id)->sum('tdssgst');
$amountreceived = DB::table('payments')->where('invoiceid',$invoiceDatas->invoice_id)->sum('amountreceived');
//dd($invoiceDatas->total);
if ($amountreceived != null) {
    $left = $tds + $roundoff + $tdscgst + $tdsigst + $tdssgst + $amountreceived;
}


                                    @endphp
                                    ( Received = {{   $left ??''}})
                                @endif
							</td>
							<td>@if($invoiceDatas->paymentstatus==null)<b style="color:red;">Not Received</b>
							@else
								<b style="color:#28A745;">{{$invoiceDatas->paymentstatus ??'' }}</b>
								@endif
							</td>
                            <td>@if($invoiceDatas->status==0)
                                <span class="badge badge-pill badge-warning">Pending</span>
                                @elseif($invoiceDatas->status==2)
                                <span class="badge badge-pill badge-success">Approved</span>
                             
                                @elseif($invoiceDatas->status==3)
                                <span class="badge badge-pill badge-info">Pending for Approvel</span>
                               
                                @elseif($invoiceDatas->status==4)
                                <span class="badge badge-pill badge-secondary">Approved by Partner</span>
								 @elseif($invoiceDatas->status==5)
                                <span class="badge badge-pill badge-danger">Cancel</span>
								 @elseif($invoiceDatas->status==6)
                                <span class="badge badge-pill badge-primary">Credit Note Issued</span>
                                @else
                                <span class="badge badge-pill badge-danger">Reject</span>
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

