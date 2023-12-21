  <!--Third party Styles(used by this page)--> 
  <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">

@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-4 mb-sm-0 p-0 ">
       <a style="float: right;color:white;" class="btn btn-success ml-2"><span><b>Total Outstanding</b> = <span>Rs.{{ number_format($total)}}/-</span></span></a>
<a target="blank"  style="float: right;" class="btn btn-success ml-2" href="{{ url('outstandingdashboard')}}">Dashboard</a>
			
   
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Outstanding
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
         <table id="example" class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr>

                            <th>BILL NO</th>
                            <th> CLIENT NAME</th>
                            <th>AMOUNT</th>
							<th>NOTIONAL INTEREST</th>
                            @if(Auth::user()->role_id == 11 || Auth::user()->role_id == 17)
                            <th>PARTNER</th>
                            @endif
                            <th>DATE</th>
                            <th>STATUS</th>
                            <th>PENDING DAYS</th>
							<th>REMINDER</th>
                            {{-- <th>Edit</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($outstandingDatas as $outstandingData)
                        <tr>
                   @php
                   $invoice = App\Models\Invoice::where('invoice_id',$outstandingData->BILL_NO)->first();
                           $invoiceid = App\Models\Invoice::select('id')->where('invoice_id',$outstandingData->BILL_NO)->first();
                   @endphp
                   @if( $invoice == null)
                            <td>{{$outstandingData->BILL_NO }}</td>
                            @else
                            @if(Auth::user()->role_id == 17)
                            <td><a href="{{ url('payment/create/'. $invoice->id) }}">{{$outstandingData->BILL_NO }}</a></td>
							 @elseif(Auth::user()->role_id == 11)
                            <td><a href="{{url('/invoiceview/'.$invoiceid->id )}}">{{$outstandingData->BILL_NO }}</a></td>
                            @else
                            <td>{{$outstandingData->BILL_NO }}</td>
                            @endif
                            @endif
                            <td>{{$outstandingData->CLIENT_NAME ??''}}</td>
							  @php
  $current=Carbon\Carbon::now();    
        $formatted_dt1=Carbon\Carbon::parse($current);
							  $pendingdays=$formatted_dt1->diffInDays($outstandingData->DATE);
                         
                            @endphp
                            <td>{{ number_format($outstandingData->AMT) }}</td>
							<td>{{ number_format($outstandingData->AMT * $pendingdays *10/36500) }}</td>
                            @if(Auth::user()->role_id == 11 || Auth::user()->role_id == 17)
                            <td>{{$outstandingData->team_member }}</td>
                            @endif
                            <td>{{ date('F d,Y', strtotime($outstandingData->DATE)) }}</td>
                            <td>{{$outstandingData->Status }}</td>
                          
                            <td>@if($pendingdays>90)<span class="badge badge-pill badge-danger">{{ $pendingdays }} </span>
                                @else
                                {{ $pendingdays }} 
                                @endif
                            </td>
							  <td style="text-align: center;"><span>
                                    <a style="font-size:20px;" id="editCompany" data-toggle="modal" data-id="{{ $outstandingData->id }}"
                                        data-target="#exampleModal12"><i class="far fa-envelope"
                                            style="color:#37A000"></i></a></span>
                            </td>
                            {{-- <td>  <a href="{{route('client.edit', $outstandingData->id)}}" class="btn btn-info-soft
                            btn-sm"><i class="far fa-edit"></i></a></td> --}}

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!--/.body content-->

<!-- Modal -->
<div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('/outstanding/reminder')}}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background:#37A000;color:white;">
                    <h5 class="modal-title font-weight-600" id="exampleModalLabel4">Send Reminder Mail</h5>
                    <div>
                        <ul>
                            @foreach ($errors->all() as $e)
                            <li style="color:red;">{{$e}}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button style="color: white" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row row-sm">
                        {{-- <label for="name" class="col-sm-3 col-form-label font-weight-600">Name :</label> --}}
                        <div class="col-sm-6">
                            <input placeholder=" Enter Subject"  class="form-control" name="subject" type="text">
                        </div>
                        <div class="col-sm-6">
                            <input id="contactemail" placeholder=" Enter Email" class="form-control" name="email"
                                type="text">
							 <input id="outstandingid" hidden placeholder=" Enter Email" class="form-control" name="outstandingid"
                                type="text">
                        </div>
                    </div>
					 <br>
                    <div class="row row-sm">
                        {{-- <label for="name" class="col-sm-3 col-form-label font-weight-600">Name :</label> --}}
                        <div class="col-sm-12">
                            <select class="form-control basic-multiple"  multiple="multiple" name="teammember_id[]">

                                <option>Please Select Cc Mail</option>
                                @foreach($teammember as $teammemberData)
                                <option value="{{$teammemberData->id}}" @if(!empty($store->
                                    financial) && $store->
                                    financial==$teammemberData->id) selected @endif>
                                 {{ $teammemberData->team_member }}  ( {{ $teammemberData->role->rolename }} )</option>
                                @endforeach
                            </select>
                         </div>
                    </div>
                  <br>
                    <div class="row row-sm">
                        <div class="col-sm-12"> 
                            <textarea rows="6" name="description" value="  " class="centered form-control" id="summernote"
                                placeholder="Enter Description"><p id="editors"></p></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
						   <a onclick="myFunction()" style="margin-right: 243px;color:#37A000;">View Trail</a>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
            </form>
				        <div class="table-responsive" id="panel" style="display: none;">

                <table class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody id="out_id">
                      
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="{{ url('backEnd/ckeditor/ckeditor.js')}}"></script>

<script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
        })
        .then(editor => {
            window.editor = editor;
        })
        .catch(err => {
            console.error(err.stack);
        });

</script>
	<script>
    function myFunction() {
      document.getElementById("panel").style.display = "block";
    }
	</script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor1'), {
            // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
        })
        .then(editor => {
            window.editor = editor;
        })
        .catch(err => {
            console.error(err.stack);
        });

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(function () {
        $('body').on('click', '#editCompany', function (event) {
    //        debugger;
  $("#editors").html('');
 $("#contactemail").val('');
            var id = $(this).data('id');
     debugger;
            $.ajax({
                type: "GET",

                url: "{{ url('reminder/sendmail') }}",
                data: "id=" + id,

                success: function (response) {
                    $("#contactemail").val(response.contactemail);
					$("#outstandingid").val(response.outstandingid);
                    var amt = response.amount;
                    var client = response.clientname;
                    var date = response.date;
                  var desc="<h3>Kind Attn :<strong >&nbsp;" + client + "</strong></h3><h6>&nbsp;</h6><p>Dear Sir,</p><h6>&nbsp;</h6><p>This is a reminder of the outstanding of Rs { Enter Amount } in connection with Due Diligence of the project &ldquo;DUE DILIGENCE&rdquo; of " + client +" for the review period 31st May 2021 to "+ date +".</p><p>Request you to process the payment on urgent basis.</p><p><strong>For KG Somani &amp; Co.</strong></p><p><strong>Chartered Accountants</strong></p><p>Authorised Signatory</p>";
                            
                    $("#editors").html(desc);
                       
                },
                error: function () {

                },
            });
        });
    });

</script>
	<script>
    $(function () {
        $('body').on('click', '#editCompany', function (event) {
    //        debugger;
  $("#editors").html('');
 $("#contactemail").val('');
            var id = $(this).data('id');
     debugger;
            $.ajax({
                type: "GET",

                url: "{{ url('reminder/mailshow') }}",
                data: "id=" + id,
                success : function(res){
           // alert(res);
            $('#out_id').html(res);

            
        },
                error: function () {

                },
            });
        });
    });

</script>
@endsection
