 <!--Third party Styles(used by this page)-->
 <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">

 @extends('backEnd.layouts.layout') @section('backEnd_content')
<style>
	.table-bordered td, .table-bordered th {
    word-break: break-all;
}
	</style>
 <!--Content Header (Page header)-->
 <div class="content-header row align-items-center m-0">
     <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
         <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
             @if(Auth::user()->teammember_id == 23 || Auth::user()->teammember_id == $outstationconveyance->createdby)
             @if($outstationconveyance->Status==0 || $outstationconveyance->Status==4)
             <li class="btn btn-info ml-2"><a
                     href="{{route('outstationconveyance.edit', $outstationconveyance->id ??'')}}"
                     style="color:white;">Edit
                 </a></li>
             @endif
             @endif
             <li> <a class="btn btn-success ml-2" href="{{ url('outstationconveyance') }}">
                     Back</a></li>
 <li> <a style="color: white" class="btn btn-primary ml-2" data-toggle="modal" data-target="#exampleModal1234">
                     Log</a></li>
         </ol>
     </nav>
     <div class="col-sm-8 header-title p-0">
         <div class="media">
             <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
             <div class="media-body">
                 <h1 class="font-weight-bold">Home</h1>
                 <small>Outstation Conveyance
                     List</small>
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
             <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:1100px;">

                 <div class="card-body">

                     <div class="card-head" style="width:930px;height: 10px;">
                         <!-- <a style="margin-top: -17px;"
                data-toggle="modal" data-target="#exampleModal12"
                    class="btn btn-info-soft btn-sm">Mail <i class="far fa-envelope"></i></a> -->

                     </div>
                     <fieldset class="form-group">

                         <table class="table display table-bordered table-striped table-hover">

                             <tbody>

                                 <tr>
                                     <td><b>Name of Client : </b></td>
                                     <td>{{ $outstationconveyance->client_name ??''}}</td>
                                     <td><b>Assignment Name :</b></td>
                                     <td>{{$outstationconveyance->assignment_name ??''}}</td>
                                     <td><b>Advance Transaction Number : </b></td>
                                     <td>{{ $outstationconveyance->assignmentgenerate_id ??'' }}</td>
                                     <td><b>Conveyance : </b></td>
                                     <td>{{ $outstationconveyance->conveyance ??'' }}</td>




                                 </tr>
                                 <tr>
                                     <td><b>Data & Assignment Appraisal Submited :</b></td>
                                     <td>{{$outstationconveyance->Assignment ??''}}</td>
                                     <td><b>Audit Period from Date : </b></td>
                                     <td>{{ date('F d,Y', strtotime($outstationconveyance->Audit_from_date ??'')) }}
                                     </td>
                                     <td><b>Audit Period to Date : </b></td>
                                     <td>{{ date('F d,Y', strtotime($outstationconveyance->Audit_period_date ??'')) }}
                                     </td>

                                     <td><b>Visiting from Date : </b></td>
                                     <td>{{ date('F d,Y', strtotime($outstationconveyance->Visiting_from_date)) }}</td>

                                 </tr>
                                 <tr>
                                     <td><b>Visiting Period to Date :</b></td>
                                     <td>{{ date('F d,Y', strtotime($outstationconveyance->Visiting_date)) }}</td>
                                     <td><b>Approved Rate of TA/Day : </b></td>
                                     <td>@if($outstationconveyance->conveyance == 'Local Conveyance')
                                        {{$outstationconveyance->localapprovedrate ??'' }}
                                        @else{{$outstationconveyance->Approved_Rate ??'' }}
                                        @endif</td>
                                     <td><b>No of Days : </b></td>
                                     <td>@if($outstationconveyance->conveyance == 'Local Conveyance')
                                        {{$outstationconveyance->localnoofday ??'' }}@else{{$outstationconveyance->outstationnoofday ??'' }}
                                    @endif</td>
                                    @if($outstationconveyance->conveyance == 'Local Conveyance')
                                    <td><b>Invoice Attachment : </b></td>
                                    <td><a style="color: #37A000" data-toggle="modal"
                                            data-target="#exampleModal1">View</a></td>
									 @else
									    <td><b>Invoice Attachment : </b></td>
                                            <td><a style="color: #37A000" data-toggle="modal"
                                                    data-target="#exampleModal1">View</a></td>
                                            @endif
                                 </tr>

                                 
                                 <tr>
                                     <td><b>Advance Details Comment : </b></td>
                                     <td>{{ $outstationconveyance->anycomment ??''}}</td>
                                     <td><b>Claimable From Client :</b></td>
                                     <td> @if($outstationconveyance->bill=='Yes')
                                  <span>Yes</span>
									 @else
									 <span>No</span>
									 @endif</td>


                                     <td><b>Remarks : </b></td>
                                     <td>{{ $outstationconveyance->Remarks}}</td>
                                     <td><b>Invoice Number : </b></td>
                                     <td>{{ $outstationconveyance->invoiceno}}</td>
                                 </tr>
                             </tbody>
                         </table>
                     </fieldset>
                                 <fieldset class="form-group">

                                    <table class="table display table-bordered table-striped table-hover">
            
                                        <tbody>
                                 @if($outstationconveyance->conveyance == 'Outstation Conveyance')
                                 <tr>
                                     <td><b>Tickets Booked By : </b></td>
                                     <td>{{ $outstationconveyance->Tickets_Booked_By ??''}}</td>
                                     <td><b>Fare :</b></td>
                                     <td>{{$outstationconveyance->Fare ??''}}</td>
                             

                                     <td><b>Conveyance Charges : </b></td>
                                     <td>{{ $outstationconveyance->Conveyance_Charges }}</td>
                                     <td><b>During Journey : </b></td>
                                     <td>{{ $outstationconveyance->During_Journey}}</td>

                                 </tr>

                                 <tr>
                                     <td><b>Approved Rate of TA/Day: </b></td>
                                     <td>{{ $outstationconveyance->Approved_Rate}}</td>
                                     <td><b>Conveyance Charge File :</b></td>
                                     <td><a target="blank"
                                        href="{{url('/backEnd/image/outstationconveyance/'.$outstationconveyance->Conveyance_file)}}">{{ $outstationconveyance->Conveyance_file ??''}}</a></td>
                                     
                             
                                     <td><b>Food Expenses : </b></td>
                                     <td>{{ $outstationconveyance->Food_Expenses}}</td>
                                     <td><b>Food Expenses File : </b></td>
                                     <td><a target="blank"
                                        href="{{url('/backEnd/image/outstationconveyance/'.$outstationconveyance->Food_Expensesfile)}}">{{ $outstationconveyance->Food_Expensesfile ??''}}</a></td>

                                 </tr>
                                 <tr>
                                    <td><b>Miscellaneous Exp :</b></td>
                                     <td>{{$outstationconveyance->Miscellaneous_Exp }}</td>
                                     <td><b>Miscellaneous Expenses File : </b></td>
                                     <td><a target="blank"
                                        href="{{url('/backEnd/image/outstationconveyance/'.$outstationconveyance->Miscellaneous_Expfile)}}">{{ $outstationconveyance->Miscellaneous_Expfile ??''}}</a></td>
                                        <td><b>DuringJourney File : </b></td>
                                        <td><a target="blank"
                                           href="{{url('/backEnd/image/outstationconveyance/'.$outstationconveyance->During_Journeyfile)}}">{{ $outstationconveyance->During_Journeyfile ??''}}</a></td>
                                     <td><b>TA_Claimed : </b></td>
                                     <td>{{ $outstationconveyance->TA_Claimed}}</td>

                                 </tr>
                                 <tr>
                                    
                                     <td><b>Travelling BILL :</b></td>
                                     <td>{{$outstationconveyance->Travelling_BILL }}</td>
                               
                                     @if($outstationconveyance->correction != null)
                                     <td>
                                         <b>Correction/Clarification : </b></td>
                                     <td>{{ $outstationconveyance->correction}}</td>
                                     @endif
                                
                                     <td><b>Attachment : </b></td>
                                     <td><a style="color: #37A000" data-toggle="modal"
                                             data-target="#exampleModal1">View</a></td>
                                     <td><b>Createdby : </b></td>
                                     <td>{{ App\Models\Teammember::select('team_member')->where('id',$outstationconveyance->createdby)->first()->team_member ?? ''}}
                                     </td>
                                     <td><b>Mark only one oval : </b></td>
                                     <td>{{ $outstationconveyance->oval}}</td>
                                 </tr>
                                 @endif
                                 <tr>
                                    <td><b> Advance Amount Requested : </b></td>
                                    <td>{{ $outstationconveyance->advanceamountrequired ??'0'}}</td>
                                    <td><b>Advance Amount Given :</b></td>
                                    <td>{{$outstationconveyance->AdvanceAmountgiven ??'0'}}</td>
                                    <td><b>Net Receivable / Payable :</b></td>
                                    <td>  @if($outstationconveyance->localsreceivable_payable != null)
										@if($outstationconveyance->localsreceivable_payable != null)
                                        {{$outstationconveyance->localsreceivable_payable ??''}}
										@else
										{{ $outstationconveyance->Total_Value }}
										@endif
                                        @else
										@if($outstationconveyance->outstationnnreceivable_payable != null)
                                        {{$outstationconveyance->outstationnnreceivable_payable ??''}} 
										@else
										{{$outstationconveyance->Travelling_BILL }}
										@endif
                                        @endif
                                    </td>

                                  
                                    <td><b>Advanced Shared Remarks : </b></td>
                                    <td>{{ $outstationconveyance->Remarks}}</td>
                                </tr>
                                 <tr>
                                    @if($outstationconveyance->rejectremarks != null)
                                    <td><b>Reason For Rejection : </b></td>
                                    <td>{{ $outstationconveyance->rejectremarks ??''}}</td>
                                   @endif
                                    @if($outstationconveyance->correction != null)
                                    <td><b>Reason For Correction/Clarification : </b></td>
                                    <td>{{ $outstationconveyance->correction ??''}}</td>
                                   @endif
                                     <td><b>Status : </b></td>
                                     <td>@if($outstationconveyance->Status==0)
                                         <span class="badge badge-info">Created</span>
                                         @elseif($outstationconveyance->Status==1)
                                         <span class="badge badge-success">Approved</span>
                                         @elseif($outstationconveyance->Status==2)
                                         <span class="badge badge-danger">Rejected</span>
                                         @elseif($outstationconveyance->Status==4)
                                         <span class="badge badge-secondary">Pending For Correction/Clarification</span>

                                         @else
                                         <span class="badge badge-warning">Submitted</span>
                                         @endif</td>
                                 </tr>


                             </tbody>

                         </table>



                     </fieldset>
                     <fieldset class="form-group">

                        <table class="table display table-bordered table-striped table-hover">

                            <tbody>
                     @if($outstationconveyance->conveyance == 'Local Conveyance')
                     <tr>
                         <td><b>Travel :</b></td>
                         <td>{{$outstationconveyance->localtravel ??''}}</td>
                         <td><b>Travel File : </b></td>
                         <td>   @if (pathinfo($outstationconveyance->Travelsupportingfile, PATHINFO_EXTENSION) == 'xlsx')
							 <a target="blank"
								 href="https://view.officeapps.live.com/op/view.aspx?src={{url('/backEnd/image/outstationconveyance/'.$outstationconveyance->Travelsupportingfile)}}"
								>
								    @elseif (pathinfo($outstationconveyance->Travelsupportingfile, PATHINFO_EXTENSION) == 'csv')
							 <a target="blank"
								 href="https://drive.google.com/viewer?url={{url('/backEnd/image/outstationconveyance/'.$outstationconveyance->Travelsupportingfile)}}"
								>
								    @elseif (pathinfo($outstationconveyance->Travelsupportingfile, PATHINFO_EXTENSION) == 'pptx')
							 <a target="blank"
								 href="https://view.officeapps.live.com/op/view.aspx?src={{url('/backEnd/image/outstationconveyance/'.$outstationconveyance->Travelsupportingfile)}}"
								>
								   @elseif (pathinfo($outstationconveyance->Travelsupportingfile, PATHINFO_EXTENSION) == 'docx')
							 <a target="blank"
								 href="https://view.officeapps.live.com/op/view.aspx?src={{url('/backEnd/image/outstationconveyance/'.$outstationconveyance->Travelsupportingfile)}}"
								>
								 
								 
								 @else
								  <a target="blank"
								 href="{{url('/backEnd/image/outstationconveyance/'.$outstationconveyance->Travelsupportingfile)}}"
								>
								 @endif
								 {{ $outstationconveyance->Travelsupportingfile ??''}}</a>
                         </td>


                         {{-- <td><b>Travel Remark : </b></td>
                         <td>{{$outstationconveyance->travelremark ??'' }}</td> --}}
                         <td><b>Food :</b></td>
                         <td>{{$outstationconveyance->localfood }}</td>
                         <td><b>Food File : </b></td>
                         <td><a target="blank"
                                 href="{{url('/backEnd/image/outstationconveyance/'.$outstationconveyance->Travelfoodsupportingfile)}}">{{ $outstationconveyance->Travelfoodsupportingfile ??''}}</a>
                         </td>
                     </tr>

                     <tr>
                         <td><b>Food File : </b></td>
                         <td><a target="blank"
                                 href="{{url('/backEnd/image/outstationconveyance/'.$outstationconveyance->Travelfoodsupportingfile)}}">{{ $outstationconveyance->Travelfoodsupportingfile ??''}}</a>
                         </td>


                         {{-- <td><b>Food Remark : </b></td>
                         <td>{{$outstationconveyance->travelfoodremark ??'' }}</td> --}}
                         <td><b>Miscellaneous : </b></td>
                         <td>{{$outstationconveyance->travelMiscellaneous ??'' }}</td>
                         <td><b>Miscellaneous File:</b></td>
                         <td><a target="blank"
                                 href="{{url('/backEnd/image/outstationconveyance/'.$outstationconveyance->TravelMiscellaneoussupportingfile)}}">{{ $outstationconveyance->TravelMiscellaneoussupportingfile ??''}}</a>
                         </td>
                         <td><b>Miscellaneous Remark : </b></td>
                         <td>{{$outstationconveyance->travelMiscellaneousremark ??'' }}</td>
                     </tr>
                     <tr>
                         {{-- <td><b>Miscellaneous Remark : </b></td>
                         <td>{{$outstationconveyance->travelMiscellaneousremark ??'' }}</td> --}}
                         <td><b>Total Value</b></td>
                         <td>{{$outstationconveyance->Total_Value ??'' }}</td>

                         <td><b>Approved Conveyance (Rs). : </b></td>
                         <td>{{$outstationconveyance->Approved_Conveyance ??'' }}</td>
                         <td><b>billpaid</b></td>
                         <td>{{$outstationconveyance->billpaid ??'' }}</td>
                         <td><b>Recoverable from Client : </b></td>
                         <td>{{$outstationconveyance->Recoverable ??'' }}</td>
                     </tr>
                   
                     @endif
								<tr>
									<td><b>Employee Name</b></td>
									<td>{{ App\Models\Teammember::select('team_member')->where('id',$outstationconveyance->createdby)->first()->team_member ?? ''}}</td>
									@if($outstationconveyance->finalamount != null)
									 <td><b>Final Amount : </b></td>
                                     <td>{{ $outstationconveyance->finalamount}}</td>
                                     <td><b>Final Remarks : </b></td>
                                     <td>{{ $outstationconveyance->finalremarks}}</td>
									@endif
								</tr>
                    </tbody>

                </table>



            </fieldset>
                     <div class="table-responsive">
                         <table class="table display table-bordered table-striped table-hover">
                             <thead>
                                 <tr>

                                     <th>Name</th>
                                     <th>Amount</th>

                                 </tr>
                             </thead>
                             <tbody>
                                 @foreach($outstationconveyanceData as $outstationconveyances)
                                 <tr>
                                     <td>{{$outstationconveyances->team_member }}</td>
                                     <td>{{$outstationconveyances->amount }}</td>

                                 </tr>
                                 @endforeach
                             </tbody>
                         </table>
                     </div>
                     <fieldset class="form-group">

                         <table class="table display table-bordered table-striped table-hover">

                             <tbody>

                                 <tr>
                                     @if(Request::is('outstationconveyance/*'))
                                     @if(Auth::user()->teammember_id == 23)

                                     @if($outstationconveyance->Status=='0' || $outstationconveyance->Status=='4')
                                     <td><b>Action :</b></td>
                                     <td>
                                         <div class="row">

                                            <button style="margin-left:11px;height: 35px;" data-toggle="modal"
                                                 data-target="#exampleModal1112" class="btn btn-success"> Approve</button>
                                             <button style="margin-left:11px;height: 35px;" data-toggle="modal"
                                                 data-target="#exampleModal112" class="btn btn-danger"> Reject</button>
                                             <button style="margin-left:11px;height: 35px;" data-toggle="modal"
                                                 data-target="#exampleModal12"
                                                 class="btn btn-info">Clarification</button>
                                             @endif
                                         </div>
                                     </td>



                                     @endif
                                     @endif
                                 </tr>
                             </tbody>
                         </table>
                     </fieldset>
                 </div>
             </div>
         </div>
     </div>

 </div>


 <script>
     function myFunction() {
         document.getElementById("panel").style.display = "block";
     }

 </script>
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
<div class="modal fade" id="exampleModal1234" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
     
            <div class="modal-header"  style="background:#37A000">
                <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Conveyance log</h5>
                <div>
                    <ul>
                        @foreach ($errors->all() as $e)
                        <li style="color:red;">{{$e}}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
          <div class="modal-body">
                <div class="table-responsive">

                    <table class="table display table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Name</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($Conveyancelog as $invoicelogdata)
                          <tr>
                              <td>{{ $invoicelogdata->description ??''}}</td>
                              <td>{{ $invoicelogdata->team_member ??''}}</td>
                              <td>{{ date('F d,Y', strtotime($invoicelogdata->created_at)) }}   {{ date('h:i A', strtotime($invoicelogdata->created_at)) }}</td>
                          </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
       
    </div>
</div>
</div>
 @endsection

 <!--Page Active Scripts(used by this page)-->
 <script src="{{ url('backEnd/dist/js/pages/forms-basic.active.js')}}"></script>
 <!--Page Scripts(used by all page)-->
 <script src="{{ url('backEnd/dist/js/sidebar.js')}}"></script>

 <!-- Small modal -->
 <div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
     aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header" style="background:#37A000">
                 <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel1">Ask for Correction/Clarification</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form method="post" action="{{ route('outstationconveyance.update', $outstationconveyance->id)}}"
                 enctype="multipart/form-data">
                 @method('PATCH')
                 @csrf
                 <div class="modal-body">
                     <div class="row row-sm">
                         <div class="col-12">
                             <div class="form-group">
                                 <textarea rows="6" name="correction" class="form-control" placeholder=""></textarea>
                                 <input hidden type="text" id="example-date-input" name="Status" value="4"
                                     class="form-control" placeholder="Enter Location">
                             </div>
                         </div>
                     </div>
                     <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                     <button type="submit" style="float: right" class="btn btn-success">Save </button>
                 </div>
             </form>
         </div>
     </div>
 </div>
 <!-- Small modal -->
 <div class="modal fade" id="exampleModal112" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
     aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header" style="background:#37A000">
                 <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel1">Reason For Rejection</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form method="post" action="{{ route('outstationconveyance.update', $outstationconveyance->id)}}"
                 enctype="multipart/form-data">
                 @method('PATCH')
                 @csrf
                 <div class="modal-body">
                     <div class="row row-sm">
                         <div class="col-12">
                             <div class="form-group">
                                 <textarea rows="6" name="rejectremarks" class="form-control" placeholder=""></textarea>
                                 <input hidden type="text" id="example-date-input" name="Status" value="2"
                                     class="form-control" placeholder="Enter Location">
                             </div>
                         </div>
                     </div>
                     <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                     <button type="submit" style="float: right" class="btn btn-success">Save </button>
                 </div>
             </form>
         </div>
     </div>
 </div>
 <div class="modal fade" id="exampleModal1112" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
     aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header" style="background:#37A000">
                 <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel1">Final Detail</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form method="post" action="{{ route('outstationconveyance.update', $outstationconveyance->id)}}"
                 enctype="multipart/form-data">
                 @method('PATCH')
                 @csrf
                 <div class="modal-body">
                     <div class="row row-sm">
                         <div class="col-12">
                             <div class="form-group">
                                 <input type="text" id="example-date-input" name="finalamount"
                                     class="form-control" placeholder="Enter Final Amount">
                             </div>
                             <div class="form-group">
                                 <textarea rows="6" name="finalremarks" class="form-control" placeholder="Enter Remarks"></textarea>
                                 <input hidden type="text" id="example-date-input" name="Status" value="1"
                                     class="form-control" >
                             </div>
							  <div class="form-group">
                                <input type="text" id="example-date-input" name="paidfrom"
                                    class="form-control" placeholder="Enter Paid From">
                            </div>
                         </div>
                     </div>
                     <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                     <button type="submit" style="float: right" class="btn btn-success">Save </button>
                 </div>
             </form>
         </div>
     </div>
 </div>
 <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
     aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <form id="detailsForm" method="post" action="{{ url('viewassignment/contactupdate') }}"
                 enctype="multipart/form-data">
                 @csrf
                 <div class="modal-header" style="background:#37A000 ">
                     <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Invoice
                         Files</h5>
                     <div>
                         <ul>
                             @foreach ($errors->all() as $e)
                             <li style="color:red;">{{$e}}</li>
                             @endforeach
                         </ul>
                     </div>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">
                     <div class="table-responsive">

                         <table class="table display table-bordered table-striped table-hover">
                             <thead>
                                 <tr>
                                     <th>File</th>

                                 </tr>
                             </thead>
                             <tbody>
                                 @foreach($outstationconveyancefile as $outstationconveyancefiles)
                                 <tr>
                                     <td><a target="blank"
                                             href="{{url('/backEnd/image/outstationconveyance/'.$outstationconveyancefiles->attachment)}}">{{ $outstationconveyancefiles->attachment??''}}</a>
                                     </td>

                                 </tr>
                                 @endforeach
                             </tbody>
                         </table>
                     </div>
                 </div>
             </form>
         </div>
     </div>
 </div>
