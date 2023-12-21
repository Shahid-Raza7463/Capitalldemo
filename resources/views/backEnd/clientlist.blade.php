<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<div class="body-content">
    <div class="card mb-4">
        @component('backEnd.components.alert')

        @endcomponent
        <div class="card-header">

            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <h6 class="fs-17 font-weight-600 mb-0">{{ $clientList->client_name }} ( {{ $clientList->client_code }} )</h6>
                </div>

            </div>
        </div>
        <div class="card-body">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                        aria-controls="pills-home" aria-selected="true">Client Overview</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab"
                        aria-controls="pills-contact" aria-selected="false">Assignment</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-user-tab" data-toggle="pill" href="#pills-user" role="tab"
                        aria-controls="pills-user" aria-selected="false">File Directory</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-member-tab" data-toggle="pill" href="#pills-member" role="tab"
                        aria-controls="pills-member" aria-selected="false">Phone Directory</a>
                </li>
               <!--   <li class="nav-item">
                      <a class="nav-link" href="{{url('/confirmation/'.$id)}}" >Confirmation</a>
                </li>
               <li class="nav-item">
                    <a class="nav-link" id="pills-client-tab" data-toggle="pill" href="#pills-client" role="tab"
                        aria-controls="pills-client" aria-selected="false">File ( Upload by Client )</a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link" id="pills-login-tab" data-toggle="pill" href="#pills-login" role="tab"
                        aria-controls="pills-login" aria-selected="false">Tracking</a>
                </li>-->
				<!--
                  <li class="nav-item">
                <a class="nav-link" href="{{url('/information/'.$id)}}" >Information resource</a>
                </li>
				 <li class="nav-item">
                <a class="nav-link" href="{{url('/atr/'.$id)}}" >ATR</a>
                </li>-->
				  @if(Auth::user()->role_id == 11 || Auth::user()->role_id == 13 || Auth::user()->role_id == 14 || Auth::user()->role_id == 15)
				
				<!--  <li class="nav-item">
               <a class="nav-link" href="{{url('/ifcfolder/'.$id)}}" >IFC</a>
                </li>
              -->
                @endif
                @if(Auth::user()->role_id == 11 || Auth::user()->teammember_id == 33)
			<!--	  <li class="nav-item">
                <a class="nav-link" href="{{url('/clientstaffassign/'.$id)}}" >Staff Assign</a>
                </li>
                   <li class="nav-item">
                <a class="nav-link" href="{{url('/clientuserlogin/'.$id)}}" >Client login</a>
                </li> -->
                @endif
				
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);">
                        <div class="card-body">
                            @if(auth()->user()->role_id == 11 || auth()->user()->role_id == 13)
                            <div class="card-head" style="width:930px;height: 10px;">
                                <b style="float:right;margin-top: -17px;">Edit <a
                                        href="{{route('client.edit', $clientList->id)}}"
                                        class="btn btn-info-soft btn-sm"><i class="far fa-edit"></i></a></b>
                            </div>
                            @endif
                            <hr>
                            <fieldset class="form-group">

                                <table class="table display table-bordered table-striped table-hover">

                                    <tbody>
                                        <tr>
                                           
                                            <td><b>Legal Status : </b></td>
                                            <td> @if($clientList->legalstatus=='2')
                                                <option value="2">Individual</option>

                                                @elseif($clientList->legalstatus=='3')
                                                <option value="3">Proprietorship</option>

                                                @elseif($clientList->legalstatus=='4')
                                                <option value="4">Firm</option>

                                                @elseif($clientList->legalstatus=='5')
                                                <option value="5">Private Limited Company</option>

                                                @elseif($clientList->legalstatus=='6')
                                                <option value="6">Public Company</option>
                                                @elseif($clientList->legalstatus=='7')
                                                <option value="7">Listed Company</option>
                                                @elseif($clientList->legalstatus=='8')
                                                <option value="8">Society</option>
                                                @elseif($clientList->legalstatus=='9')
                                                <option value="9">Trust</option>
                                                @elseif($clientList->legalstatus=='10')
                                                <option value="10">Section 8 Company</option>
												  @elseif($clientList->legalstatus=='12')
                                                 <option value="12">Foreign Company</option>
                                                @else
                                                <option value="11">AOP</option>

                                                @endif</td>

                                            <td><b>Pan Card No. :</b></td>
                                            <td>{{ $clientList->panno }}</td>
											<td></td>
											<td></td>
                                        </tr>
                                        <tr>
                                            <td><b>Tan No. : </b></td>
                                            <td>{{ $clientList->tanno}}</td>
                                            <td><b>GST No : </b></td>
                                            <td>{{ $clientList->gstno }}</td>
                                            <td></td>
                                            <td></td>


                                        </tr>
                                        <tr>
											    <td><b>Status : </b></td>
                                            <td> @if($clientList->status=='1')
                                                <option value="1">Active</option>


                                                @else
                                                <option value="2">Inactive</option>

                                                @endif</td>
                                            <td> </td>
											<td></td>
                                            <td></td>
											<td></td>
                                        
                                        </tr>
                                        <tr>
											    @if($clientList->classification != null)
                                            <td><b>Client Classification : </b></td>
                                            <td>@if($clientList->classification == 1)
                                                <span>NFRA</span>
                                                @elseif($clientList->classification == 2)
                                                <span>Quality Review</span>
                                                @elseif($clientList->classification == 3)
                                                <span>Peer Review</span>
                                                @elseif($clientList->classification == 4)
                                                <span>Others {{ $clientList->otherclassification }}</span>
                                                @endif
                                            </td>
                                      @endif
                                            <td><b>Communication Address : </b></td>
                                            <td>{{ $clientList->c_address }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                    <div class="table-responsive example">
                        <table class="table display table-bordered table-striped table-hover basic">
                            <thead>
                                <tr>
                                    <th>Assignment Id</th>
                                    <th>Assignment</th>
                                  	<th>Period Start</th>
										<th>Period End</th>
									  <th>Deadline</th>
							 <th>Assigned Partner</th>
							<th>Other Partner</th>
                            <th>Team Leader</th>
                                    <th>Teammember</th>
                                 <!--   <th>Edit</th>-->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clientassignment as $clientassignmentDatas)
                                <tr>
                                    <td> <a href="{{url('/viewassignment/'.$clientassignmentDatas->assignmentgenerate_id)}}">{{$clientassignmentDatas->assignmentgenerate_id}}</a></td>
                                    <td><span><b> Client Name :</b></span>
                                        {{$clientassignmentDatas->client_name}}<br><span><b>Assignment :</b></span>
                                        {{$clientassignmentDatas->assignment_name}} </td>
                                    
									 <td> @if($clientassignmentDatas->periodstart != null)
									 {{ date('d-m-Y', strtotime($clientassignmentDatas->periodstart)) }}
									 @endif
							   </td>
									   <td> @if($clientassignmentDatas->periodend != null)
									 {{ date('d-m-Y', strtotime($clientassignmentDatas->periodend)) }}
									 @endif
							   </td>
									<td>{{$clientassignmentDatas->duedate}}</td>
							  <td>{{ App\Models\Teammember::select('team_member')->where('id',$clientassignmentDatas->leadpartner)->first()->team_member ?? ''}}</td>   
							   	  <td>{{ App\Models\Teammember::select('team_member')->where('id',$clientassignmentDatas->otherpartner)->first()->team_member ?? ''}}</td>  
                                     <td>@foreach(DB::table('assignmentmappings')
                                        ->leftjoin('assignmentteammappings','assignmentteammappings.assignmentmapping_id','assignmentmappings.id')
                                        ->leftjoin('teammembers','teammembers.id','assignmentteammappings.teammember_id')
                                        ->where('assignmentmappings.id',$clientassignmentDatas->id)
                                        ->where('assignmentteammappings.type',0)->get()
                                        as $sub)
                                        
                                      
                                        @if($sub->profilepic == NULL)
                                        <a class="avatar avatar-xs" data-toggle="tooltip" title="{{$sub->team_member}}">
                                            <img src="{{url('backEnd/image/dummy.png')}}"
                                                class="avatar-img rounded-circle" alt="...">

                                            @else
                                            <a class="avatar avatar-xs" data-toggle="tooltip"
                                                title="{{$sub->team_member}}">
                                                <img src="{{asset('backEnd/image/teammember/profilepic/'.$sub->profilepic)}}"
                                                    class="avatar-img rounded-circle" alt="...">
                                                @endif

                                        @endforeach</td>  
                                    <td>
                                        @foreach(DB::table('assignmentmappings')
                                        ->leftjoin('assignmentteammappings','assignmentteammappings.assignmentmapping_id','assignmentmappings.id')
                                        ->leftjoin('teammembers','teammembers.id','assignmentteammappings.teammember_id')->where('assignmentmappings.id',$clientassignmentDatas->id)
										 ->where('assignmentteammappings.type',2)->get()
                                        as $sub)

                                        @if($sub->profilepic == NULL)
                                        <a class="avatar avatar-xs" data-toggle="tooltip" title="{{$sub->team_member}}">
                                            <img src="{{url('backEnd/image/dummy.png')}}"
                                                class="avatar-img rounded-circle" alt="...">

                                            @else
                                            <a class="avatar avatar-xs" data-toggle="tooltip"
                                                title="{{$sub->team_member}}">
                                                <img src="{{asset('backEnd/image/teammember/profilepic/'.$sub->profilepic)}}"
                                                    class="avatar-img rounded-circle" alt="...">
                                                @endif
                                                @endforeach
                                    </td>
                                   
                                  <!--  <td>
                                        <a href="{{url('/assignmentlist/'.$clientassignmentDatas->assignmentgenerate_id)}}"
                                            class="btn btn-info-soft btn-sm"><i class="far fa-edit"></i></a>
                                    </td>-->
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-user" role="tabpanel" aria-labelledby="pills-user-tab">
                    <div class="table-responsive example">
						<br>
 @if(auth()->user()->role_id == 11 || auth()->user()->role_id == 13 || auth()->user()->role_id == 14)
                            <div class="card-head" style="width:930px;height: 10px;">
                                <b style="float:right;margin-top: -17px;">Add <a
                                        href="{{ url('/client/add-document/' . $id) }}" target="blank"
                                        class="btn btn-info-soft btn-sm"><i class="fa fa-plus"></i></a></b>
                            </div>
                            @endif
						<hr>
                        <table class="table display table-bordered table-striped table-hover basic">
                            <thead>
                                <tr>
                                    <th>Document Name</th>
                                    <th>Uploaded by</th>
                                    <th>Document Type</th>
									<th>Created Date</th>
									<th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clientfileDatas as $clientfileData)
                                <tr>
                                    <td><a href="{{ asset('backEnd/image/client/document/'.$clientfileData->filess) }}">{{$clientfileData->document_name }}</a></td>
									@php
									$teamuser = DB::table('clientdocuments')
        ->leftjoin('users','users.id','clientdocuments.created_by')
									->leftjoin('teammembers','teammembers.id','users.teammember_id')
									->where('clientdocuments.id',$clientfileData->id)
									->first();
									
								//	dd($teamuser);
									
									@endphp
									
                                    <td>{{$teamuser->team_member}}</td>
                                    <td>@if($clientfileData->type==0)
                                        <span>Permanent</span>
                                        @else
                                        <span>Temporary</span>
                                        @endif
                                    </td>
									<td>{{ date('d-m-Y', strtotime($clientfileData->created_at)) }}   {{ date('h:i A', strtotime($clientfileData->created_at)) }}</td>
									<td>   <a href="{{url('/clientfile/delete/'.$clientfileData->id)}}"
                                    onclick="return confirm('Are you sure you want to delete this item?');"
                                    class="btn btn-danger-soft btn-sm"><i class="far fa-trash-alt"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-member" role="tabpanel" aria-labelledby="pills-member-tab">
                    <div class="table-responsive">
                        <br>
   @if(auth()->user()->role_id == 11 || auth()->user()->role_id == 13 || auth()->user()->role_id == 14)
                            <div class="card-head" style="width:930px;height: 10px;">
                                <b style="float:right;margin-top: -17px;">Add <a
                                        href="{{url('/client/contactedit', $clientList->id)}}"
                                        class="btn btn-info-soft btn-sm"><i class="fa fa-plus"></i></a></b>
                            </div>
                            @endif
                        <hr>
                        <table class="table display table-bordered table-striped table-hover basic">
                            <thead>
                                <tr>
                                    <th>Client Name</th>
                                    <th>Designation</th>
                                    <th>Email</th>
                                    <th>Mobile No</th>
									<th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clientcontactList as $clientcontactlistdata)
                                <tr>
                                    <td>{{$clientcontactlistdata->clientname }}</td>
                                    <td>{{$clientcontactlistdata->clientdesignation }}</td>
                                    <td>{{$clientcontactlistdata->clientemail }}</td>
                                    <td><a
                                            href="tel:={{$clientcontactlistdata->clientphone }}">{{$clientcontactlistdata->clientphone }}</a>
                                    </td>
									<td>   <a href="{{url('/clientcontact/delete/'.$clientcontactlistdata->id)}}"
                                    onclick="return confirm('Are you sure you want to delete this item?');"
                                    class="btn btn-danger-soft btn-sm"><i class="far fa-trash-alt"></i></a></td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                 
                  <div class="tab-pane fade" id="pills-client" role="tabpanel" aria-labelledby="pills-client-tab">
                    <div class="table-responsive example">
    <br>
                       <div class="card-head" style="width:930px;height: 10px;">
                        <b style="float:right;margin-top: -17px;">Add <a
                            data-toggle="modal" data-target="#exampleModal1234" 
                                class="btn btn-info-soft btn-sm"><i class="fa fa-plus"></i></a></b>
                    </div>
                    <hr>
                        <table class="table display table-bordered table-striped table-hover basic">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($clientfile as $clientfileData)
                                <tr>
  <td><a style="font-size: 16px;" target="blank"
                                    href="{{ url('folderlist', $clientfileData->id)}}"><i
                                        class="far fa-folder"> <b>{{$clientfileData->name }}</b></i></a></td>
                              <td>{{ date('d-m-Y', strtotime($clientfileData->created_at)) }}</td>
                              
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                  <div class="tab-pane fade" id="pills-login" role="tabpanel" aria-labelledby="pills-login-tab">
                    <div class="table-responsive example">

                        <table id="exampleee" class="display nowrap">
                            <thead>
                                <tr>
                                    <th style="display: none;">id</th>
                                    <th>IP Address</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th style="width: 189px;">Last login</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($clientlogin as $clientloginData)
                                <tr>
                                    <td style="display: none;">{{ $clientloginData->id }}</td>
                                    <td>{{ $clientloginData->ip_address }}</td>
                                    <td>{{ $clientloginData->name ??''}}</td>
                                    <td>{{ $clientloginData->email ??''}}</td>
                                    <td>{{ date('F d,Y', strtotime($clientloginData->lastlogindateandtime)) }}   {{ date('h:i A', strtotime($clientloginData->lastlogindateandtime)) }}</td>
                                </tr>
                                   @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<!--/.body content-->
<!-- Modal -->
         <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="detailsForm" method="post" action="{{ url('debtor/excel')}}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-600" id="exampleModalLabel4">Add Excel</h5>
                        <div >
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
                       
                            <div class="details-form-field form-group row">
                                     <label for="name" class="col-sm-3 col-form-label font-weight-600">Type:</label>
                                <div class="col-sm-9">
                                    <select name="type" id="exampleFormControlSelect1" class="form-control">
                                        <!--placeholder-->
                                        <option value="">Please Select One</option>
                                        <option value="1">Debtor</option>
                                        <option value="2">Creditor</option>
                                        <option value="3">Bank</option>
                                    </select>
                                </div>
                                   
                            </div> 
                            <div class="details-form-field form-group row">
                                     <label for="name" class="col-sm-3 col-form-label font-weight-600">Upload Excel:</label>
                                <div class="col-sm-9">
                                    <input id="name" class="form-control" name="file" type="file">
                                    <input id="name" hidden class="form-control" name="clientid" type="text" value="{{$clientList->id}}">
                                </div>
                                   
                            </div> 
                        
                            <div class="details-form-field form-group row">
                            <label for="address" class="col-sm-3 col-form-label font-weight-600">Sample Excel:</label>
                            <div class="col-sm-9">
                                <a href="{{ url('backEnd/debtor.xlsx')}}" 
                                class="btn btn-success btn"  >Download<i class="fas fa-file-excel" style="margin-left: 3px;font-size: 20px;"></i></a>
                           
                                </div>
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
        
<div class="modal fade" id="exampleModal1234" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <form id="detailsForm" method="post" action="{{ url('/clientfolder/folderstore')}}"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title font-weight-600" id="exampleModalLabel4">Add Name</h5>
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

                <div class="details-form-field form-group row">
                    <label for="name" class="col-sm-3 col-form-label font-weight-600">Name :</label>
                    <div class="col-sm-9">
                        <input id="name" class="form-control" name="name" type="text">
                        <input id="name" hidden class="form-control" name="client_id" type="text" value="{{$clientList->id}}">
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
    var msg = '{{Session::get('
    alert ')}}';
    var exist = '{{Session::has('
    alert ')}}';
    if (exist) {
        alert(msg);
    }

</script>
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
} );</script>                                
