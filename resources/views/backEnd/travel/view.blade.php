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
            
    @if($travel->travelstatus=='0')
			<li class="breadcrumb-item"><a href="{{route('travel.edit', $travel->id ??'')}}">Edit
                    travel</a></li>
			   @endif
  <li class="breadcrumb-item"><a href="{{url('travel')}}">Back</a></li>
        </ol>
    </nav>
 
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>travel
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

            <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:750px;">
                <div class="card-body">

                    <fieldset class="form-group">

                        <table class="table display table-bordered table-striped table-hover">

                            <tbody>

                                <tr>
                                    <td><b>Client Name : </b></td>
                                    <td>{{ $travel->client_name ??''}}</td>
                                    <td><b>Nature of Assignment : </b></td>
                                    <td>@if($travel->Nature_of_Assignment != null){{ $travel->Nature_of_Assignment }}@else
                                        {{ $travel->assignmentsname ??''}} @endif</td>
                                </tr>
                                <tr>
                                    <td><b>Place of Visit : </b></td>
                                    <td>{{$travel->Place_of_visit ??''}}</td>
                                    <td><b>Approver : </b></td>
                                    <td>{{ $travel->team_member ??'' ??''}}
                                    </td>

                                </tr>

                                <tr>
                                    <td><b>Start date : </b></td>
                                    <td>{{ $travel->Expected_date_of_departure ??''}}</td>
                                    <td><b>End Date : </b></td>
                                    <td>{{ date('F d,Y', strtotime($travel->Expected_date_of_arrival)) ??''}}</td>
                                   

                                </tr>
                                <tr>
                                    <td><b> Travel Status</b></td>
                                    <td>@if($travel->travelstatus == 0)
                                        <span class="badge badge-pill badge-warning">Created</span>
                                        @elseif($travel->travelstatus == 1)
                                        <span class="badge badge-pill badge-success">Approved</span>
                                        @else
                                        <span class="badge badge-pill badge-danger">Reject</span>
                                        @endif</td>
                                        <td><b>Billable : </b></td>
                                        <td>@if($travel->Billable == 0)
                                            <span class="badge badge-pill badge-success">Yes</span>
                                            @else
                                            <span class="badge badge-pill badge-danger">No</span>
                                            @endif</td>

                                </tr>
                                <tr>
                                    <td><b>Status : </b></td>
                                    <td>@if($travel->Status == 2)
                                        <span>Pending</span>
                                        
                                    @elseif($travel->Status == 0)
                                        <span>Paid</span>
                                        @else
                                        <span>On Hold</span>
                                        @endif</td>
                                        <td><b>Advance Amount Required : </b></td>
                                        <td>{{ $travel->advanceamount ??''}}</td>
                                </tr>
                                <tr>
                                    <td><b>Advance Transaction Number : </b></td>
                                    <td><b>{{ $travel->assignmentgenerate_id ??''}} </b></td>
                                    @if($travel->remark  != null)
                                    <td><b>Reason For Rejection : </b></td>
                                    <td>{{ $travel->remark ??''}}</td>
                                    @endif
                                </tr>
                                @if($travel->Advance_Amount  != null)
                                <tr>
                                    <td><b>Advance Amount Given : </b></td>
                                    <td>{{ $travel->Advance_Amount ??'0'}}</td>
                                    @if($travel->comment  != null)
                                    <td><b>Comment (Reason for hold): </b></td>
                                    <td>{{ $travel->comment ??''}}</td>
                                    @endif

                                </tr>
                                @endif
                                @if(Request::is('travel/*'))
                                @if($travel->teammember_id == Auth::user()->teammember_id)

                                <tr>
                                    @if($travel->travelstatus=='0')
                                    <td><b>Action :</b></td>
                                    <td>
                                        <div class="row">

                                            <form method="post"
                                                action="{{ route('travel.update', $travel->id)}}"
                                                enctype="multipart/form-data">
                                                @method('PATCH')
                                                @csrf
                                                <button type="submit" class="btn btn-success"> Approve</button>
                                                <input type="text" hidden id="example-date-input" name="travelstatus"
                                                    value="1" class="form-control" placeholder="Enter Location">
                                            </form>
                                          
                                                <button style="margin-left:11px;height: 35px;" data-toggle="modal"    data-target="#exampleModal12"  class="btn btn-danger">
                                                    Reject</button>
                                             
                                          
                                            @endif
                                        </div>
                                    </td>
                                    {{-- <td><b> </b></td>
                                    <td> @if($travel->travelstatus=='0')
                                        <button type="submit" class="btn btn-success" > Submit</button>
                                        @endif</td> --}}

                                </tr>


                                @endif
                                @endif
                            </tbody>

                        </table>


                    </fieldset>
                    @if(Request::is('travel/*'))
                    @if($travel->Status == 2 && Auth::user()->role_id == 17)
                
                    @if(Auth::user()->role_id == 17 || $travel->Advance_Amount  != null)
                        <div class="">
                            <form method="post" action="{{ route('travel.update', $travel->id)}}"  enctype="multipart/form-data">
                                @method('PATCH') 
                                @csrf            
                                @component('backEnd.components.alert')
        
                                @endcomponent   
                                <div class="row row-sm">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="font-weight-600">Advance Amount Given. *</label>
                                        <input type="number" required name="Advance_Amount" value="{{ $travel->Advance_Amount ?? ''}}" class="form-control"
                                        placeholder="Enter Advance Amount">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="font-weight-600">Status. *</label>
                                        <select name="Status" id="exampleFormControlSelect1" class="form-control">
                                          <!--placeholder-->
                                          @if(Request::is('travel/*')) >
                                          @if($travel->Status=='0')
                                          <option value="0">Paid</option>
                                          <option value="1">On Hold</option>
                          
                                          @else
                                          <option value="1">On Hold</option>
                                          <option value="0">Paid</option>
                                        
                                         
                          
                                          @endif
                                          @else
                          
                                          <option value="">Please Select One</option>
                                          <option value="0">Paid</option>
                                          <option value="1">On Hold</option>
                                          @endif
                                      </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-12">
                                    <label class="font-weight-600">Comment (Reason for hold) </label>
                                    <textarea rows="3" name="comment" value="" class="form-control"
                                    placeholder="Enter Comment (Reason for hold)">{!! $travel->comment ??'' !!}</textarea>
                                </div>
                            </div>
                            <br>
                            @if(Auth::user()->role_id == 17 && $travel->Status == 2)
                            <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
                            @endif
                        </form>
        
                    </div>
                    @endif
                    @endif
                    @endif
                </div>

            </div>


        </div>
    </div>

</div>
@endsection

 <!-- Small modal -->
 <div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
 aria-hidden="true">
 <div class="modal-dialog" role="document">
     <div class="modal-content">
           <div class="modal-header" style="background:#37A000">
               <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel1">Reason For Rejection</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <form method="post"   action="{{ route('travel.update', $travel->id)}}"  enctype="multipart/form-data">
               @method('PATCH') 
               @csrf   
           <div class="modal-body">
               <div class="row row-sm">
                   <div class="col-12">
                       <div class="form-group">
                           <textarea rows="6" name="remark" class="form-control"
                               placeholder=""></textarea>
                               <input hidden type="text" id="example-date-input" name="travelstatus"
                               value="2" class="form-control"
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