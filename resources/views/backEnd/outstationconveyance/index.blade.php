<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('outstationconveyance/create')}}">Add Conveyance</a>
            </li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small> Conveyance List</small>
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
                        aria-controls="pills-home" aria-selected="true">Local Conveyance</a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" id="pills-user-tab" data-toggle="pill" href="#pills-user" role="tab"
                        aria-controls="pills-user" aria-selected="false">Outstation Conveyance</a>
                </li>

            </ul>

            <br>
            <hr>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="table-responsive example">
 <form  method="post" >
                            @csrf
                        <div class="table-responsive">
                            <table id="examplee" class="display nowrap">
                                <thead>
                                    <tr>
                                        <th style="display: none;">id</th>
										  @if(Auth::user()->role_id == 17)
                                        <th><button type="submit"
                                             onclick="return confirm('Are you sure you want to process this item?');"
                                              formaction="conveyanceneft" class="btn btn-danger-soft btn-sm">NEFT</button>
                                              <input type="checkbox" id="chkAll">
                                            <i class="os-icon os-icon-trash"></i></th>
                                            @endif
										  <th>Unique Id</th>
                                        <th>Employee Name</th>
                                        <th>Raise Date</th>
										<th>Approved Date</th>
										                            <th>Paid Date</th>
                            <th>Processing Date</th>
                                        <th>Status</th>
										<th>Status Of Advance Adjustment</th>
                                        <th>Client Name</th>
                                        <th>Assignment</th>
                                        <th>Date & Assignment Appraisal Submited</th>
                                        <th>Audit Period from Date</th>
                                        <th>Audit Period to Date</th>
                                        <th>Visiting Period from Date</th>
                                        <th>Visiting Period to Date</th>
                                        <th>Approved Rate of TA/Day </th>
                                        <th>No of Days Present</th>
                                        <th>Travel</th>
                                        <th>Travel File</th>
                                        <th>Travel Remark</th>
                                        <th>Food</th>
                                        <th>Food File</th>
                                        <th>Food Remark</th>
                                        <th>Miscellaneous</th>
                                        <th>Miscellaneous File</th>
                                        <th>Miscellaneous Remark</th>
                                        <th>Total Value</th>
                                        <th>Approved Conveyance</th>
                                        <th>billpaid</th>
                                        <th>Recoverable from Client</th>
                                        <th>Advance Amount Requested</th>
                                        <th>Advance Amount Given</th>
                                        <th>Net Receivable / Payable</th>
                                        <th>Mark only one oval</th>
                                        <th>Advance Share Remarks</th>
                                        <th>Advance Details Comment </th>
                                        <th>Total Travelling BILL </th>
                                        <th>Invoice Number</th>
										<th>Final Amount</th>
										<th>Final Remarks</th>
										<th>Paid From</th>
										<th>Payment Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($outstationData as $outstationData)
                                    <tr>
                                        <td style="display: none;">{{$outstationData->id }}</td>
										 @if(Auth::user()->role_id == 17)
                                        <td><input type="checkbox" name="ids[]" style="width: 18px;margin-left: 16px;"
                                        class="selectbox" value="{{$outstationData->id}}"></td>
                                        @endif
										 <td>{{$outstationData->uniqueid }}</td>
                                        <td><a
                                                href="{{route('outstationconveyance.show', $outstationData->id)}}">{{ App\Models\Teammember::select('team_member')->where('id',$outstationData->createdby)->first()->team_member ?? ''}}</a>
                                        </td>
                                        <td> {{ date('F d,Y', strtotime($outstationData->created_at)) }}</td>
										    @if($outstationData->approveddate == null)
                            <td></td>
                            @else
                          <td>{{ date('F d,Y', strtotime($outstationData->approveddate)) }}</td>
                            @endif
										        <td>@if($outstationData->paiddate != null){{ date('F d,Y', strtotime($outstationData->paiddate)) }}@endif</td>
                            <td>@if($outstationData->processingdate != null){{ date('F d,Y', strtotime($outstationData->processingdate)) }}@endif</td>  
                                        <td>
                                            @if(Auth::user()->role_id == 17)
											@if($outstationData->Status > 0)
											<a id="editCompany" data-toggle="modal" data-id="{{ $outstationData->id }}"
                                        data-target="#modaldemo1">
                                                @endif
												 @endif
                                                @if($outstationData->Status==0)
                                            <span class="badge badge-info">Created</span>
                                            @elseif($outstationData->Status==1)
                                            <span class="badge badge-success">Approved</span>
                                            @elseif($outstationData->Status==2)
                                            <span class="badge badge-danger">Rejected</span>
                                            @elseif($outstationData->Status==4)
                                            <span class="badge badge-secondary">Pending For
                                                Correction/Clarification</span>
                                                @elseif($outstationData->Status==5)
                                                <span class="badge badge-primary">Processing Amount</span>
                                                @elseif($outstationData->Status==6)
                                                <span class="badge badge-success">Paid</span>
                                            @else
                                            <span class="badge badge-warning">Submitted</span>
                                            @endif
                                            @if(Auth::user()->role_id == 17)
												@if($outstationData->Status > 0)
											</a>
											@endif
										@endif</td>
										  <td>@if($outstationData->localsreceivable_payable == null)
											   <span>Not applied for advance claim</span>
											  @else
											  @if($outstationData->adjustablestatus == 0)
                                        <span>Not Adjusted Yet</span>
                                        @else
                                        <span>Adjusted</span>
                                        @endif
											  @endif</td>
                                        <td>{{ $outstationData->client_name }} </td>

                                        <td>
                                            @if($outstationData->assignmentsname !=
                                            null){{ $outstationData->assignmentsname }}@else
                                            @endif</td>
                                        <td>{{ $outstationData->Assignment ??'' }}</td>
                                        <td>@if($outstationData->Audit_from_date!=null)
                                            {{ date('F d,Y', strtotime($outstationData->Audit_from_date)) }}
                                            @else
                                            @endif</td>
                                        <td>@if($outstationData->Audit_period_date!=null)
                                            {{ date('F d,Y', strtotime($outstationData->Audit_period_date)) }}
                                            @else
                                            @endif</td>
                                        <td>@if($outstationData->Visiting_from_date!=null)
                                            {{ date('F d,Y', strtotime($outstationData->Visiting_from_date)) }}
                                            @else
                                            @endif</td>
                                        <td>@if($outstationData->Visiting_date!=null){{ date('F d,Y', strtotime($outstationData->Visiting_date)) }}
                                            @else
                                            @endif</td>
                                        <td>{{$outstationData->localapprovedrate ??'0' }}</td>
                                        <td>{{$outstationData->localnoofday ??'0' }}</td>
                                        <td>{{$outstationData->localtravel ??'' }}</td>
                                        <td><a download target="blank"
                                                href="{{url('/backEnd/image/outstationconveyance/'.$outstationData->Travelsupportingfile)}}">{{ $outstationData->Travelsupportingfile ??''}}</a>
                                        </td>
                                        <td>{{$outstationData->travelremark ??'' }}</td>
                                        <td>{{$outstationData->localfood ??'' }}</td>
                                        <td><a download target="blank"
                                                href="{{url('/backEnd/image/outstationconveyance/'.$outstationData->Travelfoodsupportingfile)}}">{{ $outstationData->Travelfoodsupportingfile ??''}}</a>
                                        </td>
                                        <td>{{$outstationData->travelfoodremark ??'' }}</td>
                                        <td>{{$outstationData->travelMiscellaneous ??'' }}</td>
                                        <td><a download target="blank"
                                                href="{{url('/backEnd/image/outstationconveyance/'.$outstationData->TravelMiscellaneoussupportingfile)}}">{{ $outstationData->TravelMiscellaneoussupportingfile ??''}}</a>
                                        </td>
                                        <td>{{$outstationData->travelMiscellaneousremark ??'' }}</td>
                                        <td>{{$outstationData->Total_Value ??'' }}</td>
                                        <td>{{$outstationData->Approved_Conveyance ??'0'}}</td>
                                        <td>{{$outstationData->billpaid ??''}}</td>
                                        <td>{{$outstationData->Recoverable ??'' }}</td>
                                        <td>{{$outstationData->advanceamountrequired ??'0' }}</td>
                                        <td>{{$outstationData->AdvanceAmountgiven ??'0' }}</td>
                                        <td>@if($outstationData->localsreceivable_payable != null){{$outstationData->localsreceivable_payable ??''}}@else
											{{$outstationData->Total_Value}}
											@endif</td>
                                        <td>{{$outstationData->oval ??'' }}</td>
                                        <td>{{$outstationData->Remarks ??'' }}</td>
                                        <td>{{$outstationData->anycomment ??'' }}</td>
                                        <td>{{$outstationData->bill ??'' }}</td>
                                        <td>{{$outstationData->invoiceno ??'' }}</td>
                                         <td>{{$outstationData->finalamount ??'' }}</td>
										 <td>{{$outstationData->finalremarks ??'' }}</td>
										 <td>{{$outstationData->paidfrom ??'' }}</td>
  <td>{{$outstationData->payment ??'' }}</td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

   </form>
                    </div>
                </div>

                <br>
                <div class="tab-pane fade" id="pills-user" role="tabpanel" aria-labelledby="pills-user-tab">

                    <div class="table-responsive">
						 <form  method="post" >
                            @csrf
                        <table id="exampleee" class="display nowrap">
                            <thead>
                                <tr>
                                    <th style="display: none;">id</th>
									   @if(Auth::user()->role_id == 17)
                                    <th><button type="submit"
                                        onclick="return confirm('Are you sure you want to process this item?');"
                                         formaction="conveyanceneft" class="btn btn-danger-soft btn-sm">NEFT</button>
                                         <input type="checkbox" id="chkAlls">
                                       <i class="os-icon os-icon-trash"></i></th>
                                       @endif
									   <th>Unique Id</th>
                                    <th>Employee Name</th>
                                    <th>Raise Date</th>
									  <th>Approved Date</th>
									                            <th>Paid Date</th>
                            <th>Processing Date</th>
                                    <th>Status</th>
									<th>Status Of Advance Adjustment</th>
                                    <th>Client Name</th>
                                    <th>Assignment</th>
                                    <th>Date & Assignment Appraisal Submited</th>
                                    <th>Audit Period from Date</th>
                                    <th>Audit Period to Date</th>
                                    <th>Visiting Period from Date</th>
                                    <th>Visiting Period to Date</th>
                                    <th>Tickets Booked By</th>
                                    <th>Ticket / Fare</th>
                                    <th>Conveyance Charges</th>
                                    <th>During Journey</th>
                                    <th>Miscellaneous Exp</th>
                                    <th>Food Expenses</th>
                                    <th>Approved Rate of TA/Day</th>
                                    <th>No of Days Present</th>
                                    <th>TA Claimed </th>
                                    <th>Total Travelling BILL </th>
                                    <th>Advance Amount Requested</th>
                                    <th>Advance Amount Given</th>
                                    <th>Net Receivable / Payable</th>
                                    <th>Mark only</th>
<th>Final Amount</th>
										<th>Final Remarks</th>
									<th>Payment Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($outstationDatas as $outstationData)
                                <tr>
                                    <td style="display: none;">{{$outstationData->id }}</td>
									   @if(Auth::user()->role_id == 17)
                                    <td><input type="checkbox" name="ids[]" style="width: 18px;margin-left: 16px;"
                                        class="selectboxs" value="{{$outstationData->id}}"></td>
                                        @endif
									 <td>{{$outstationData->uniqueid }}</td>
                                    <td><a
                                            href="{{route('outstationconveyance.show', $outstationData->id)}}">{{ App\Models\Teammember::select('team_member')->where('id',$outstationData->createdby)->first()->team_member ?? ''}}</a>
                                    </td>
                                    <td> {{ date('F d,Y', strtotime($outstationData->created_at)) }}</td>
									  @if($outstationData->approveddate == null)
                            <td></td>
                            @else
                          <td>{{ date('F d,Y', strtotime($outstationData->approveddate)) }}</td>
                            @endif
									        <td>@if($outstationData->paiddate != null){{ date('F d,Y', strtotime($outstationData->paiddate)) }}@endif</td>
                            <td>@if($outstationData->processingdate != null){{ date('F d,Y', strtotime($outstationData->processingdate)) }}@endif</td>  
                                       <td>
                                        @if(Auth::user()->role_id == 17)
										   @if($outstationData->Status > 0)
										   <a id="editCompanys" data-toggle="modal" data-id="{{ $outstationData->id }}"
                                    data-target="#modaldemo2">
                                            @endif
											   @endif
                                            @if($outstationData->Status==0)
                                        <span class="badge badge-info">Created</span>
                                        @elseif($outstationData->Status==1)
                                        <span class="badge badge-success">Approved</span>
                                        @elseif($outstationData->Status==2)
                                        <span class="badge badge-danger">Rejected</span>
                                        @elseif($outstationData->Status==4)
                                        <span class="badge badge-secondary">Pending For Correction/Clarification</span>
                                        @elseif($outstationData->Status==5)
                                        <span class="badge badge-primary">Processing Amount</span>
                                        @elseif($outstationData->Status==6)
                                        <span class="badge badge-success">Paid</span>
                                        @else
                                        <span class="badge badge-warning">Submitted</span>
                                        @endif
                                        @if(Auth::user()->role_id == 17)
										   @if($outstationData->Status > 0)
										   </a>
                                            @endif
										    @endif
                                    </td>
									 <td>@if($outstationData->outstationnnreceivable_payable == null)
											   <span>Not applied for advance claim</span>
											  @else
										 @if($outstationData->adjustablestatus == 0)
                                        <span>Not Adjusted Yet</span>
                                        @else
                                        <span>Adjusted</span>
                                        @endif
										 @endif</td>
                                    <td>{{ $outstationData->client_name }} </td>

                                    <td>
                                        @if($outstationData->assignmentsname !=
                                        null){{ $outstationData->assignmentsname }}@else
                                        @endif</td>
                                    <td>{{ $outstationData->Assignment ??'' }}</td>
                                    <td>@if($outstationData->Audit_from_date!=null)
                                        {{ date('F d,Y', strtotime($outstationData->Audit_from_date)) }}
                                        @else
                                        @endif</td>
                                    <td>@if($outstationData->Audit_period_date!=null)
                                        {{ date('F d,Y', strtotime($outstationData->Audit_period_date)) }}
                                        @else
                                        @endif</td>
                                    <td>@if($outstationData->Visiting_from_date!=null)
                                        {{ date('F d,Y', strtotime($outstationData->Visiting_from_date)) }}
                                        @else
                                        @endif</td>
                                    <td>@if($outstationData->Visiting_date!=null){{ date('F d,Y', strtotime($outstationData->Visiting_date)) }}
                                        @else
                                        @endif</td>
                                    <td>{{$outstationData->Tickets_Booked_By ??''}}</td>
                                    <td>{{$outstationData->Fare ??''}}</td>
                                    <td>{{$outstationData->Conveyance_Charges ??''}}</td>
                                    <td>{{$outstationData->During_Journey ??'0'}}</td>
                                    <td>{{$outstationData->Miscellaneous_Exp ??''}}</td>
                                    <td>{{$outstationData->Food_Expenses ??''}}</td>
                                    <td>{{$outstationData->Approved_Rate ??''}}</td>
                                    <td>{{$outstationData->outstationnoofday ??''}}</td>
                                    <td>{{$outstationData->TA_Claimed ??''}}</td>
                                    <td>{{$outstationData->Travelling_BILL ??'0'}}</td>
                                    <td>{{$outstationData->advanceamountrequired ??'0'}}</td>
                                    <td>{{$outstationData->AdvanceAmountgiven ??'0'}}</td>
                                    <td>@if($outstationData->outstationnnreceivable_payable != null){{$outstationData->outstationnnreceivable_payable ??''}}@else
											{{$outstationData->Travelling_BILL ??'0'}}
											@endif</td>
                                    <td>{{$outstationData->oval ??''}}</td>
 <td>{{$outstationData->finalamount ??'' }}</td>
										 <td>{{$outstationData->finalremarks ??'' }}</td>
  <td>{{$outstationData->payment ??'' }}</td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
							        </form>
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
<!-- Modal -->
<div class="modal fade bd-example-modal-sm"  id="modaldemo1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background: #37A000">
                <h5  style="color: white"class="modal-title font-weight-600" id="exampleModalLabel1">Update Local Conveyance Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" method="post" action="{{ url('outstationconveyanceupdate')}}"
            enctype="multipart/form-data">
                        @csrf     
            <div class="modal-body">
                <select name="Status" required id="exampleFormControlSelect11" class="form-control">
                
                   
                    <option value="">Please Select One</option>
                    <option value="5">Processing Amount</option>
                    <option value="6">Paid</option>
               
                </select>
                <input class="form-control" hidden value="" name="outstationconveyanceid" id="id" type="text">
				 <br>
                <div class="form-group" id="bachelorcertificate" style="display: none">
                    
                      <input type="text" name="payment" id="bachelorcertificates" class="form-control"
                      placeholder="Enter NEFT/CHEQUE/RTGS Details">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
    $('#exampleFormControlSelect11').on('change', function() {
      if ( this.value == '6')
      {
        $("#bachelorcertificate").show();
        document.getElementById("bachelorcertificates").required = true;  
      }
      else
      {
        $("#bachelorcertificate").hide();
      }
    });
  });
  </script>
<script>
    $(function () {
        $('body').on('click', '#editCompany', function (event) {
    //        debugger;
            var id = $(this).data('id');
     debugger;
            $.ajax({
                type: "GET",

                url: "{{ url('conveyacnelocal') }}",
                data: "id=" + id,
                success : function(response){
           // alert(res);
           debugger;
           $("#id").val(response.id);

            
        },
                error: function () {

                },
            });
        });
    });

</script>
    <!-- Modal -->
<div class="modal fade bd-example-modal-sm"  id="modaldemo2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background: #37A000">
                <h5  style="color: white"class="modal-title font-weight-600" id="exampleModalLabel1">Update Outstation Conveyance Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" method="post" action="{{ url('outstationconveyanceupdate')}}"
            enctype="multipart/form-data">
                        @csrf     
            <div class="modal-body">
                <select name="Status" required id="exampleFormControlSelect1" class="form-control">
                
                   
                    <option value="">Please Select One</option>
                    <option value="5">Processing Amount</option>
                    <option value="6">Paid</option>
               
                </select>
                <input hidden class="form-control" value="" name="outstationconveyanceid" id="ids" type="text">
				  <br>
                <div class="form-group" id="bachelorcertificatee" style="display: none">
                    
                      <input type="text" name="payment" id="bachelorcertificatess" class="form-control"
                      placeholder="Enter NEFT/CHEQUE/RTGS Details">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
    $('#exampleFormControlSelect1').on('change', function() {
      if ( this.value == '6')
      {
        $("#bachelorcertificatee").show();
        document.getElementById("bachelorcertificatess").required = true;  
      }
      else
      {
        $("#bachelorcertificate").hide();
      }
    });
  });
  </script>
<script type="text/javascript">
    $(function () {
        $('body').on('click', '#editCompanys', function (event) {
    //        debugger;
            var id = $(this).data('id');
     debugger;
            $.ajax({
                type: "GET",

                url: "{{ url('conveyacneoutstation') }}",
                data: "id=" + id,
                success : function(response){
           // alert(res);
           debugger;
           $("#ids").val(response.id);

            
        },
                error: function () {

                },
            });
        });
    });

</script>
<script type="text/javascript">
    $.('.selectall').click(function(){
        $.('selectboxs').prop('checked',$(this).prop('checked'));
    })
    $('.selectboxs').change(function(){
        var total=$.('.selectboxs').length;
        var number=$.('.selecbox:checked').length;
        if(total==number)
        {
            $('.selectall').prop('checked',true);
        }
        else
        $('.selectall').prop('checked',false);
       
    });
    </script>
<script type="text/javascript">
    $.('.selectall').click(function(){
        $.('selectbox').prop('checked',$(this).prop('checked'));
    })
    $('.selectbox').change(function(){
        var total=$.('.selectbox').length;
        var number=$.('.selecbox:checked').length;
        if(total==number)
        {
            $('.selectall').prop('checked',true);
        }
        else
        $('.selectall').prop('checked',false);
       
    });
    </script>
    <script type="text/javascript">
        $(function () {
            $("#chkAll").click(function () {
                $("input[name='ids[]']").attr("checked", this.checked);
            });
            $('#example11').DataTable({
            });
        });
    </script>
    <script type="text/javascript">
        $(function () {
            $("#chkAlls").click(function () {
                $("input[name='ids[]']").attr("checked", this.checked);
            });
            $('#example11').DataTable({
            });
        });
    </script>