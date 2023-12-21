@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
   
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
			 @if($reimbursement->Approver == Auth::user()->teammember_id)
			 @if($reimbursement->Status=='0')
            <li class="btn btn-info ml-2"><a href="{{route('reimbursementclaim.edit', $reimbursement->id ??'')}}" style="color:white;">Edit
                    </a></li>
			   @endif
			   @endif
			<li>     <a class="btn btn-success ml-2" href="{{ url('reimbursementclaim') }}">
          Back</a></li>

        </ol>
    </nav>
 
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>reimbursement
                    Details</small>
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

            <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:290px;">
                <div class="card-body">
                    
                    <fieldset class="form-group">

                        <table class="table display table-bordered table-striped table-hover">

                            <tbody>

                                <tr>
                                    <td><b>Date of Expense : </b></td>
                                    <td>{{ date('F d,Y', strtotime($reimbursement->Date_of_Expense ??'')) }}</td>
                                    <td><b>Type of Expense : </b></td>
                                    <td>{{$reimbursement->Type_of_Expense }}</td>
                                </tr>
                                <tr>
                                    <td><b>Approved Amount : </b></td>
                                    <td>{{$reimbursement->Approved_Amount }}</td>
                                    <td><b>Actual Amount : </b></td>
                                    <td>{!! $reimbursement->Actual_Amount !!}</td>

                                </tr>

                                <tr>
                                    <td><b>Location : </b></td>
                                    <td>{{ $reimbursement->Location}}</td>
                                    <td><b>File : </b></td>
                                    <td><a target="blank" href="{{url('/backEnd/image/claim/'.$reimbursement->attachment)}}">{{ $reimbursement->attachment ??''}}</a></td>

                                </tr>
                                <tr>
                                    <td><b>Approver : </b></td>
                                    <td>{{ $reimbursement->team_member }} ( {{ $reimbursement->rolename }} )</td>
                                    <td><b>Status: </b></td>
                                    <td>@if($reimbursement->Status==0)
                                        <span class="badge badge-info">Created</span>
                                        @elseif($reimbursement->Status==1)
                                        <span class="badge badge-success">Approved</span>
                                        @elseif($reimbursement->Status==2)
                                        <span class="badge badge-danger">Rejected</span>
										 @elseif($reimbursement->Status==4)
                                <span class="badge badge-primary">Processing Amount</span>
                                @elseif($reimbursement->Status==5)
                                <span class="badge badge-success">Paid</span>
                                        @else
                                        <span class="badge badge-warning">Submitted</span>
                                        @endif</td>

                                </tr>
                                @if($reimbursement->reason != null)
								<tr>
									  <td><b>Reason For rejection : </b></td>
                                    <td>{!! $reimbursement->reason !!}</td>
								</tr>
								@endif
                                @if(Request::is('reimbursementclaim/*'))  
                                @if($reimbursement->Approver == Auth::user()->teammember_id || Auth::user()->teammember_id == 23)
                                
                                <tr>
                                    @if($reimbursement->Status=='0')
                                    <td><b>Action :</b></td>
                                    <td>  
                                        <div class="row">
                                  
                                    <form method="post" action="{{ route('reimbursementclaim.update', $reimbursement->id)}}"  enctype="multipart/form-data">
                                        @method('PATCH') 
                                        @csrf   
                                    <button type="submit" class="btn btn-success" > Approve</button>
                                    <input type="text" hidden id="example-date-input" name="Status" value="1" class="form-control"
                                    placeholder="Enter Location">
                                    </form>
                                 
                                    <button style="margin-left:11px;height: 35px;" data-toggle="modal" data-target=".bd-example-modal-sm" class="btn btn-danger" > Reject</button>
                                   
                                  
                                    @endif
                                    </div>
                                    </td>
                                    {{-- <td><b> </b></td>
                                    <td> @if($reimbursement->Status=='0')
                                        <button type="submit" class="btn btn-success" > Submit</button>
                                        @endif</td> --}}

                                </tr>
                              
                           
                            @endif
                            @endif
                            </tbody>

                        </table>


                    </fieldset>

                </div>

            </div>


        </div>
    </div>

</div>
@endsection
  <!-- Small modal -->
  <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background:#37A000">
                <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel1">Reason For Rejection</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ route('reimbursementclaim.update', $reimbursement->id)}}"  enctype="multipart/form-data">
                @method('PATCH') 
                @csrf   
            <div class="modal-body">
                <div class="row row-sm">
                    <div class="col-12">
                        <div class="form-group">
                            <textarea rows="6" name="reason" class="form-control"
                                placeholder="Enter Reason"></textarea>
                                <input hidden type="text" id="example-date-input" name="Status" value="2" class="form-control"
                                placeholder="Enter Location">
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