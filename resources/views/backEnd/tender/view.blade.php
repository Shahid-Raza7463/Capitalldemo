
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('tender/create')}}">Add tender</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>tender
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
            <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);">
                <div class="card-body">
					 @if(Auth::user()->role_id == 11)
                    <a style="float: left;  margin-top: -27px;" data-toggle="modal" data-target="#log" class="btn btn-success-soft btn-sm">Log</a>
                    @endif
                       @if(Auth::user()->role_id == 11 || Auth::user()->role_id == 12 || $tender->createdby ==
                    Auth::user()->teammember_id)
                    @if($tender->status != 4 && $tender->status != 5 && $tender->status != 2)
                    <a style="float: right;  margin-top: -27px;" href="{{route('tender.edit', $tender->id)}}" class="btn btn-info-soft btn-sm"><i
                            class="far fa-edit"></i></a>

                    @endif
                    @endif
                    <hr>
                    <fieldset class="form-group">

                        <table class="table display table-bordered table-striped table-hover">

                            <tbody>

                                <tr>
                                    <td><b>Tender Offered By : </b></td>
                                    <td>{{ $tender->tenderofferedby}}</td>

                                    <td><b>Nature of Services :</b></td>
                                    <td>{{ $tender->services}}</td>

                                </tr>
                                <tr>
                                    <td><b>Tender Published Date : </b></td>
                                    <td>@if($tender->tenderpublishdate !=  null){{ date('F d,Y', strtotime($tender->tenderpublishdate)) }}@endif</td>
                                    <td><b>Prebid Date of Meeting : </b></td>
                                    <td>@if($tender->prebidmeetingdate !=  null){{ date('F d,Y', strtotime($tender->prebidmeetingdate)) }}@endif</td>

                                </tr>
                                <tr>
                                    <td><b>Organisation : </b></td>
                                    <td>{{ $tender->organisation }}</td>
                                    <td><b>Last Year Public domain fees </b></td>
                                    <td>@if($tender->lastyear !=  null){{ date('F d,Y', strtotime($tender->lastyear)) }}@endif</td>

                                </tr>
                                <tr>
                                    <td><b>Tender Type : </b></td>
                                    <td>@if($tender->tendertype ==  1)
                                        <span >open</span>
                                        @else
                                        <span>limited</span>
                                        @endif</td>
                                    <td><b>Tender Nature  : </b></td>
                                    <td>@if($tender->nature ==  1)
                                        <span>Empanelment</span>
                                        @else
                                        <span>Appointment</span>
                                        @endif
                                    </td>

                                </tr>
                                <tr>
                                    <td><b>Organisation Website  : </b></td>
                                    <td>{{ $tender->organisationwebsite }}</td>
                                    <td><b> Tender Id : </b></td>
                                    <td>{{ $tender->tenderid }}</td>

                                </tr>
                                <tr>
                                    <td><b>Tender Fees (in Rs.) : </b></td>
                                    <td>{{ $tender->tenderfees }}</td>
                                    <td><b>Tender Submission Due Date : </b></td>
                                    <td>@if($tender->tenderdate !=  null)
										{{ date('F d,Y', strtotime($tender->tenderdate)) }}@endif</td>

                                </tr>
                                <tr>
                                    <td><b>Tender Submission Required : </b></td>
                                    <td> @if($tender->tenderhardcopy=='1')
                                         <span >Hard Copy</span>
                                        @elseif($tender->tenderhardcopy=='2')
                                        <span>Hard and Soft Copy</span>
                                        @else
                                        <span>Soft Copy</span>
                                        @endif</td>
                                    <td><b>Stamp Paper Required : </b></td>
                                    <td> @if($tender->tenderhardcopy=='1')
                                        <span >Yes</span>
                                       @else
                                       <span>No</span>
                                       @endif</td>

                                </tr>
                                <tr>
                                    <td><b>EMD (in Rs.): </b></td>
                                    <td>{{ $tender->emd }}</td>
                                    <td><b>Tender Opening Date : </b></td>
                                    <td>{{ $tender->openingtenderdate }}</td>

                                </tr>
                                <tr>
                                    <td><b>Linkedin link : </b></td>
                                    <td>{{ $tender->linkedinlink }}</td>
                                    <td><b>Period of Assignment  : </b></td>
                                    <td>{{ $tender->daterange }}</td>

                                </tr>
                                <tr>
                                    <td><b>Details of Previous Auditors : </b></td>
                                    <td>{{ $tender->previousauditors }}</td>
                                    <td><b>Details of Current Auditors : </b></td>
                                    <td>{{ $tender->currentauditors }}</td>

                                </tr>
                                <tr>
                                    <td><b>Existing or Previous Relationships</b></td>
                                    <td>{{ $tender->existing }}</td>
                                  <td>Tender Document</td>
                                  <td> <a data-toggle="modal" data-target="#exampleModal1" 
                                    >View</a></td>

                                </tr>
                               
                                <tr>
                                    <td><b>Contact Person</b></td>
                                    <td>{{ $tender->contactperson }}</td>
                                    <td><b>Email </b></td>
                                    <td>{{ $tender->email }}</td>

                                </tr>
                                <tr>
                                    <td><b>Phone No </b></td>
                                    <td>{{ $tender->phoneno }}</td>
                                    <td><b>Address </b></td>
                                    <td>{{ $tender->address }}</td>

                                </tr>
                                @if($tender->status == 2)
                                <tr>
                                    <td><b>Reject </b></td>
                                    <td>{{ $tender->remarks }}</td>
                                    <td></td>
                                    <td></td>

                                </tr>
                                @endif
                             
                                @if($tender->tendersubmitstatus != null)
                                <tr>
                                    <td><b>Tender Submit Status  </b></td>
                                    <td> @if($tender->tendersubmitstatus=='1')
                                        <span >Yes</span>
                                       @else
                                       <span>No</span>
                                       @endif</td>
                                       @if($tender->acknowledgementofsubmission != null)
                                    <td><b>Acknowledgement of submission</b></td>
                                    <td><a href="{{asset('backEnd/image/tender/'.$tender->acknowledgementofsubmission)}}">view</a></td>
@endif
                                </tr>
                                @if($tender->documentsubmit != null)
                                <tr>
                                    <td><b>Document Submit</b></td>
                                    <td><a href="{{asset('backEnd/image/tender/'.$tender->documentsubmit)}}">view</a></td>
                                    <td></td>
                                    <td></td>

                                </tr>
                                @endif
                                <tr>
                                    <td><b>Enrollment Of Payment </b></td>
                                    <td> @if($tender->enrollmentofpayment=='1')
                                        <span >NEFT</span>
                                       @else
                                       <span>DD</span>
                                       @endif
                                    </td>
                                       @if($tender->enrollmentofpayment == 2)
                                    <td><b>DD No </b></td>
                                    <td>{{ $tender->ddno }}</td>
                                    @endif
                                </tr>
                                @if($tender->enrollmentofpayment == 2)
                                <tr>
                                    <td><b>Issue Date </b></td>
                                    <td>@if($tender->issuedate !=  null)
										{{ date('F d,Y', strtotime($tender->issuedate)) }}@endif</td>
                                    <td><b>Issue Bank </b></td>
                                    <td>{{ $tender->issuebank }}</td>

                                </tr>
                                <tr>
                                    <td><b>Infavour Of </b></td>
                                    <td>{{ $tender->infavourofdd }}</td>
                                    <td><b>Date Of Expiry* </b></td>
                                    <td>@if($tender->dateofexpiry !=  null)
										{{ date('F d,Y', strtotime($tender->dateofexpiry)) }}@endif</td>

                                </tr>
                                @endif
                                @endif
                                @if($tender->enrollmentofpayment == 1)
                                <tr>
                                    <td><b>Transaction Id</b></td>
                                    <td>{{ $tender->transactionid }}</td>
                                    <td><b>Date  </b></td>
                                    <td>@if($tender->date !=  null)
										{{ date('F d,Y', strtotime($tender->date)) }}@endif</td>

                                </tr>
                                <tr>
                                    <td><b>Infavour Of </b></td>
                                    <td>{{ $tender->infavourof }}</td>
                                    <td><b>Pair Bank* </b></td>
                                    <td>{{ $tender->pairbank }}</td>

                                </tr>
                                @endif
                                <tr>
                                    <td><b>CFO </b></td>
                                    <td><a data-toggle="modal" data-target="#exampleModal11" 
                                        >View</a></td>
                                    <td><b>Board Members </b></td>
                                    <td><a data-toggle="modal" data-target="#exampleModal12" 
                                        >View</a></td>

                                </tr>
                                @if ($tender->detailofwinner != null)
                                <tr>
                                    <td><b>Result </b></td>
                                    <td>{{ $tender->result }}</td>
                                    <td><b>Emd Refund Status </b></td>
                                    <td>{{ $tender->refundstatus }}</td>
                                </tr>
                                <tr>
                                    <td><b>Remark /Comment on result </b></td>
                                    <td>{{ $tender->remarkresult }}</td>
                                    <td><b>Detail of Winner and Fees </b></td>
                                    <td><a data-toggle="modal" data-target="#exampleModal121" 
                                        >View</a></td>
                                </tr>
                                <tr>
                                    @if($tender->endrefund != null)
                                    <td><b>Letter for end Refund </b></td>
                                    <td>
                                        <a href="{{asset('backEnd/image/tender/'.$tender->endrefund)}}">view</a></td>
                                        @endif
                                    <td><b>EMD Status</b></td>
                                    <td> @if($tender->emdstatus=='3')
                                        <span >Paid</span>
                                     @elseif($tender->emdstatus=='2')
                                        <span >Rejected</span>
                                       @else
                                       <span>Processed</span>
                                       @endif
                                    </td>
                                   
                                </tr>
                                <tr>
                                    <td><b>L1 Company</b></td>
                                    <td>{{ $tender->lonecpmny ??''}}</td>
                                    <td><b>L1 Amount</b></td>
                                    <td>{{ $tender->loneamt ??''}}</td>
                                </tr>
                                <tr>
                                    <td><b>L2 Company</b></td>
                                    <td>{{ $tender->ltwocpmny ??''}}</td>
                                    <td><b>L2 Amount</b></td>
                                    <td>{{ $tender->ltwoamt ??''}}</td>
                                </tr>
                                <tr>
                                    <td><b>L3 Company</b></td>
                                    <td>{{ $tender->lthreecpmny ??''}}</td>
                                    <td><b>L3 Amount</b></td>
                                    <td>{{ $tender->lthreeamt ??''}}</td>
                                </tr>
                                   @endif
                                @if($tender->teammember_id == Auth::user()->teammember_id)
                                @if ($tender->status == 1)
                                <form method="post" action="{{ url('tender/assigned')}}" enctype="multipart/form-data">
                                    @csrf	
                                <tr>
                                    <td><b>Status </b></td>
                                    <td> <select name="status" id="exampleFormControlSelect3" class="form-control">
                                            <!--placeholder-->
                                            @if(Request::is('tender/view/*')) >
                                            @if($tender->status=='1')
                                            <option value="1">pending</option>
                                            <option value="2">reject</option>
                                            <option value="3">approved</option>
                                            <option value="4">submit</option>
                                            <option value="5">close</option>

                                            @elseif($tender->status=='2')
                                            <option value="2">reject</option>
                                            <option value="3">approved</option>
                                            <option value="1">pending</option>
                                            <option value="4">submit</option>
                                            <option value="5">close</option>

                                            @elseif($tender->status=='3')
                                            <option value="3">approved</option>
                                            <option value="2">reject</option>
                                             <option value="1">pending</option>
                                            <option value="4">submit</option>
                                            <option value="5">close</option>

                                            @elseif($tender->status=='4')
                                            <option value="4">submit</option>
                                            <option value="2">reject</option>
                                            <option value="3">approved</option>
                                            <option value="1">pending</option>
                                            <option value="5">close</option>

                                            @else
                                            <option value="5">close</option>
                                            <option value="4">submit</option>
                                            <option value="3">approved</option>
                                            <option value="1">pending</option>
                                            <option value="2">reject</option>

                                            @endif
                                            @else
                                            <option value="1">pending</option>
                                            <option value="2">reject</option>
                                            <option value="3">approved</option>
                                            <option value="5">close</option>
                                            <option value="4">submit</option>

                                            @endif
                                        </select>
                                        <input hidden type="text" name="rid" value="{{ $id }}" class="form-control"
                                        placeholder="Enter End Date">
                                    </td>
                                    <td id='designationn' style="display: none;">   <input type="text" name="remarks" value="{{ $tender->remarks ?? ''}}" class="form-control"
                                        placeholder="Enter Remarks"></td>
                                
                                    <td>
                                        <button type="submit" class="btn btn-success" style="float:right">
                                            Submit</button>
                                    </td>

                                </tr>
                            </form>
                            @endif
                            @endif

                            </tbody>
                           
                        </table>
                     
                        <div class="card mb-4" >
                           
                            <div class="card-body">
                                
                           @if(17 == Auth::user()->role_id || $tender->createdby == Auth::user()->teammember_id)
                            @if($tender->status == 3)
                            <form method="post" action="{{ url('tenderssigned/store')}}" enctype="multipart/form-data">
                                @csrf
                          @component('backEnd.components.alert')
        
                          @endcomponent
                            <div class="row row-sm" >
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="font-weight-600">EMD Status*</label>
                                        <select required name="emdstatus" id="emd" class="form-control">
                                            <!--placeholder-->
                                            @if(Request::is('tender/view/*')) >
                                            @if($tender->emdstatus=='1')
                                            <option value="1">Processed</option>
                                            <option value="2">Rejected</option>
                                            <option value="3">Paid</option>

                                            @elseif($tender->emdstatus=='2')
                                            <option value="2">Rejected</option>
                                            <option value="1">Processed</option>
                                            <option value="3">Paid</option>
                            
                                            @else
                                            <option value="3">Paid</option>
                                            <option value="2">Rejected</option>
                                            <option value="1">Processed</option>
                                            
                            
                                            @endif
                                            @else
                            
                                            <option value="">Please Select One</option>
                                            <option value="1">Processed</option>
                                            <option value="2">Rejected</option>
                                            <option value="3">Paid</option>
                                            @endif
                                        </select>
                                        <input type="text" hidden name="rid" value="{{ $id ?? ''}}" class="form-control"
                                        placeholder="Enter Nature of Services">
                                    </div>
                                </div>
                                <div class="col-3"   id="emdstatus" style="display: none;">
                                    <div class="form-group">
                                        <label class="font-weight-600">EMD Rejection Remarks *</label>
                                        <input type="text" name="emdremarks" value="{{ $tender->emdremarks ?? ''}}" class="form-control"
                                        placeholder="Enter EMD Rejection Remarks">
                                        
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="font-weight-600">Enrollment Of Payment*</label>
                                        <select name="enrollmentofpayment" id="template" class="form-control">
                                            <!--placeholder-->
                                            @if(Request::is('tender/view/*')) >
                                            @if($tender->enrollmentofpayment=='1')
                                            <option value="1">NEFT</option>
                                            <option value="2">DD</option>
                            
                                            @else
                                            <option value="2">DD</option>
                                            <option value="1">NEFT</option>
                            
                                            @endif
                                            @else
                            
                                            <option value="">Please Select One</option>
                                            <option value="2">DD</option>
                                            <option value="1">NEFT</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                              <div class="row row-sm" id="div1" >
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="font-weight-600">Transaction Id *</label>
                                        <input type="text" name="transactionid" value="{{ $tender->transactionid ?? ''}}" class="form-control"
                                        placeholder="Enter Transaction Id">
                                       
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label class="font-weight-600">Date  *</label>
                                        <input type="date" name="date" value="{{ $tender->date ?? ''}}" class="form-control"
                                            placeholder="Enter Date">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="font-weight-600">Infavour Of  *</label>
                                        <input type="text" name="infavourof" value="{{ $tender->infavourof ?? ''}}" class="form-control"
                                            placeholder="Enter Infavour Of">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="font-weight-600">Pair Bank*</label>
                                        <input type="text" name="pairbank" value="{{ $tender->pairbank ?? ''}}" class="form-control"
                                        placeholder="Enter Pair Bank">
                                    </div>
                                </div>
                            </div>
                              <div class="row row-sm" id="div2">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="font-weight-600">DD No. *</label>
                                        <input type="text" name="ddno" value="{{ $tender->ddno ?? ''}}" class="form-control"
                                        placeholder="Enter DD No">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label class="font-weight-600">Issue Date  *</label>
                                        <input type="date" name="issuedate" value="{{ $tender->issuedate ?? ''}}" class="form-control"
                                            placeholder="Enter Issue Date">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label class="font-weight-600">Issue Bank  *</label>
                                        <input type="text" name="issuebank" value="{{ $tender->issuebank ?? ''}}" class="form-control"
                                            placeholder="Enter Issue Bank">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label class="font-weight-600">Infavour Of  *</label>
                                        <input type="text" name="infavourofdd" value="{{ $tender->infavourofdd ?? ''}}" class="form-control"
                                            placeholder="Enter Infavour Of">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="font-weight-600">Date Of Expiry*</label>
                                        <input type="date" name="dateofexpiry" value="{{ $tender->dateofexpiry ?? ''}}" class="form-control"
                                        placeholder="Enter Date Of Expiry">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
                                <a class="btn btn-secondary" href="{{ url('tender') }}">
                                    Back</a>
                            
                            </div>
                            </form>
               
                            <hr class="my-4">
                            </div>
                        </div>
                        @endif
                        @endif
                     @if($tender->createdby == Auth::user()->teammember_id)
                        @if($tender->status == 4)
                        <div class="card mb-4">

                            <div class="card-body">
                                <form method="post" action="{{ url('tenderSubmit/store')}}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @component('backEnd.components.alert')

                                    @endcomponent
                                    <div class="row row-sm">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="font-weight-600">Tender Submit Status *</label>
                                                <select name="tendersubmitstatus" id="exampleFormControlSelect1"
                                                    class="form-control">
                                                    <!--placeholder-->
                                                    @if(Request::is('tender/view/*')) >
                                                    @if($tender->tendersubmitstatus=='1')
                                                    <option value="1">Yes</option>
                                                    <option value="2">No</option>

                                                    @else
                                                    <option value="2">No</option>
                                                    <option value="1">Yes</option>

                                                    @endif
                                                    @else

                                                    <option value="">Please Select One</option>
                                                    <option value="2">No</option>
                                                    <option value="1">Yes</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label class="font-weight-600">Document Submit *</label>
                                                <input type="file" name="documentsubmit"
                                                    value="{{ $tender->services ?? ''}}" class="form-control"
                                                    placeholder="Enter Nature of Services">
                                                <input type="text" hidden name="rid" value="{{ $id ?? ''}}"
                                                    class="form-control" placeholder="Enter Nature of Services">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label class="font-weight-600">Acknowledgement of submission *</label>
                                                <input type="file" name="acknowledgementofsubmission"
                                                    value="{{ $tender->tenderpublishdate ?? ''}}" class="form-control"
                                                    placeholder="Enter Due Date">
                                            </div>
                                        </div>

                                    </div>

                                  
                               
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success" style="float:right">
                                            Submit</button>
                                        <a class="btn btn-secondary" href="{{ url('tender') }}">
                                            Back</a>

                                    </div>
                                </form>

                                <hr class="my-4">
                            </div>
                        </div>
                        @endif
                        @endif
                        @if($tender->createdby == Auth::user()->teammember_id)
                        @if($tender->status == 6)
                        <div class="card mb-4">

                            <div class="card-body">
                                <form method="post" action="{{ url('tendercreatedby/store')}}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @component('backEnd.components.alert')

                                    @endcomponent
                                
                                    <div class="row row-sm">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="font-weight-600">Result *</label>
                                                <input type="text" name="result" value="{{ $tender->result ?? ''}}"
                                                    class="form-control" placeholder="Enter Result">
                                                <input hidden type="text" name="rid" value="{{ $id }}"
                                                    class="form-control" placeholder="Enter End Date">
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="font-weight-600">Emd Refund Status*</label>
                                                <input type="text" name="refundstatus"
                                                    value="{{ $tender->refundstatus ?? ''}}" class="form-control"
                                                    placeholder="Enter Emd Refund Status">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="font-weight-600">Remark /Comment on result*</label>
                                                <input type="text" name="remarkresult"
                                                    value="{{ $tender->remarkresult ?? ''}}" class="form-control"
                                                    placeholder="Enter Remark /Comment on result">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="font-weight-600">Letter for end Refund </label>
                                                <input type="file" name="endrefund"
                                                    value="{{ $tender->endrefund  ?? ''}}" class="form-control"
                                                    placeholder="Enter Detail of Winner and Fees">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row row-sm">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="font-weight-600">Detail of Winner and Fees </label>

                                                <textarea rows="14" name="detailofwinner" value=""
                                                    class="centered form-control" id="editor"
                                                    placeholder="Enter Detail of Winner and Fees">{!! $tender->detailofwinner  ??'' !!}</textarea>
                                            </div>

                                        </div>
                                    </div>
                                    <br>
                                    <div class="row row-sm ">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="fs-17 font-weight-600 mb-0"><b>Awardees</b></label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row row-sm">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="font-weight-600">L1 Company </label>
                                                <input type="text" name="lonecpmny"
                                                    value="{{ $tender->lonecpmny  ?? ''}}" class="form-control"
                                                    placeholder="Enter L1 Company ">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="font-weight-600">L1 Amount </label>
                                                <input type="text" name="loneamt" value="{{ $tender->loneamt  ?? ''}}"
                                                    class="form-control" placeholder="Enter L1 Amount">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row row-sm">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="font-weight-600">L2 Company </label>
                                                <input type="text" name="ltwocpmny"
                                                    value="{{ $tender->ltwocpmny  ?? ''}}" class="form-control"
                                                    placeholder="Enter L2 Company ">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="font-weight-600">L2 Amount </label>
                                                <input type="text" name="ltwoamt" value="{{ $tender->ltwoamt  ?? ''}}"
                                                    class="form-control" placeholder="Enter L2 Amount">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row row-sm">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="font-weight-600">L3 Company </label>
                                                <input type="text" name="lthreecpmny"
                                                    value="{{ $tender->lthreecpmny  ?? ''}}" class="form-control"
                                                    placeholder="Enter L3 Company ">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="font-weight-600">L3 Amount </label>
                                                <input type="text" name="lthreeamt"
                                                    value="{{ $tender->lthreeamt  ?? ''}}" class="form-control"
                                                    placeholder="Enter L3 Amount">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success" style="float:right">
                                            Submit</button>
                                        <a class="btn btn-secondary" href="{{ url('tender') }}">
                                            Back</a>

                                    </div>
                                </form>

                                <hr class="my-4">
                            </div>
                        </div>
                        @endif
                        @endif
                    </fieldset>
                </div>
            </div>
        </div>
    </div>

</div>
<!--/.body content-->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('viewassignment/contactupdate') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background: #37A000">
                    <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Tender Document List</h5>
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
                                    <th>Document Name</th>
                                    <th>File</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tenderDatas as $tenderdata)
                                <tr>
                                    <td>{{$tenderdata->tenderdocument }}</td>
                                    @if (pathinfo($tenderdata->tenderdocument, PATHINFO_EXTENSION) == 'png')
                                    <td><a class="btn btn-success btn" target="blank"
                                            href="{{ asset('backEnd/image/tender/'.$tenderdata->tenderdocument) }}"><i
                                                class="fas fa-file" style="margin-right: 4px;"></i>Open</a> <a
                                            class="btn btn-success btn" target="blank"
                                            href="{{ asset('backEnd/image/tender/'.$tenderdata->tenderdocument) }}"><i
                                                class="fas fa-download" style="margin-right: 4px;"></i>Download</a></td>
                                    @elseif(pathinfo($tenderdata->tenderdocument, PATHINFO_EXTENSION) == 'jpeg')
                                    <td><a class="btn btn-success btn" target="blank"
                                            href="{{ asset('backEnd/image/tender/'.$tenderdata->tenderdocument) }}"><i
                                                class="fas fa-file" style="margin-right: 4px;"></i>Open </a> <a
                                            class="btn btn-success btn" target="blank"
                                            href="{{ asset('backEnd/image/tender/'.$tenderdata->tenderdocument) }}"><i
                                                class="fas fa-download" style="margin-right: 4px;"></i>Download</a></td>
                                    @elseif(pathinfo($tenderdata->tenderdocument, PATHINFO_EXTENSION) == 'jpg')
                                    <td><a class="btn btn-success btn" target="blank"
                                            href="{{ asset('backEnd/image/tender/'.$tenderdata->tenderdocument) }}"><i
                                                class="fas fa-file" style="margin-right: 4px;"></i>Open </a> <a
                                            class="btn btn-success btn" target="blank"
                                            href="{{ asset('backEnd/image/tender/'.$tenderdata->tenderdocument) }}"><i
                                                class="fas fa-download" style="margin-right: 4px;"></i>Download</a></td>
                                    @else
                                    <td><a class="btn btn-primary btn" target="blank"
                                            href="https://docs.google.com/gview?url={{ asset('backEnd/image/tender/'.$tenderdata->tenderdocument) }}"><i
                                                class="fas fa-file-excel" style="margin-right: 4px;"></i>Open</a> <a
                                            class="btn btn-success btn" target="blank"
                                            href="{{ asset('backEnd/image/tender/'.$tenderdata->tenderdocument) }}"><i
                                                class="fas fa-download" style="margin-right: 4px;"></i>Download</a></td>
                                    @endif
                                  

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
<div class="modal fade" id="exampleModal11" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('viewassignment/contactupdate') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title font-weight-600" id="exampleModalLabel4">CFO List</h5>
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
                  {!! $tender->cfo !!}
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('viewassignment/contactupdate') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title font-weight-600" id="exampleModalLabel4">Board Member List</h5>
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
                {!! $tender->boardmembers !!}
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal121" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('viewassignment/contactupdate') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title font-weight-600" id="exampleModalLabel4">Tender Document List</h5>
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
                {!! $tender->detailofwinner !!}
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="log" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
         
                <div class="modal-header" style="background: #37A000">
                    <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Tender log</h5>
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
                                    <th>Teammember</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tenderlog as $tenderlogdata)
                              <tr>
                                  <td>{{ $tenderlogdata->description ??''}}</td>
                                  <td>{{ $tenderlogdata->team_member ??''}}</td>
                                  <td>{{ date('F d,Y', strtotime($tenderlogdata->created_at)) }}   {{ date('h:i A', strtotime($tenderlogdata->created_at)) }}</td>
                              </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
           
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script><script src="{{ url('backEnd/ckeditor/ckeditor.js')}}"></script>

<script>
	ClassicEditor
		.create( document.querySelector( '#editor' ), {
			// toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
		} )
		.then( editor => {
			window.editor = editor;
		} )
		.catch( err => {
			console.error( err.stack );
		} );
</script>
@endsection
