
<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
	@if(Auth::user()->role_id != 18)
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('teammember/create')}}">Add Teammember</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
	@endif
	   @if(Auth::user()->role_id == 18)
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a class="btn btn-info-soft btn-sm" data-toggle="modal"
                    data-target="#exampleModal1">Add TDS Excel</a></li>
			<li class="breadcrumb-item"><a class="btn btn-info-soft btn-sm" href="{{url('teammember/create')}}">Add Teammember</a></li>

        </ol>
    </nav>
    @endif
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
            <div class="media-body">
               <a href="{{url('home')}}"> <h1 class="font-weight-bold" style="color:black;">Home</h1></a>
                <small>Team List</small>
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
                        aria-controls="pills-home" aria-selected="true">Active </a>
                </li>

@if(Auth::user()->role_id != 17)
                <li class="nav-item">
                    <a class="nav-link" id="pills-user-tab" data-toggle="pill" href="#pills-user" role="tab"
                        aria-controls="pills-user" aria-selected="false">InActive</a>
                </li>
@endif
            </ul>

            <br>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="table-responsive example">

                        <div class="table-responsive">
                             <table id="examplee" class="display nowrap">
                    <thead>
                        <tr>
							  <th style="display: none;">id</th>
                                        <th>Team Member Name</th>
                                        <th>Team Role</th>
									@if(Auth::user()->role_id==18)
									 <th>Entity</th>
							@endif
                                        <th>Mobile No</th>
                                       <th>Date Of Birth</th>
							
							<th style="display: none;"></th>
                                       <th>Joining Date</th>
                                          <th>Department</th>
								@if(Auth::user()->role_id == 11 || Auth::user()->role_id == 18)
							<th>Category</th>
							<th>Cost (Hourly)</th>
							@endif
                                        <th>Email</th>
								@if(Auth::user()->role_id != 17)
                                        <th>Personal Email</th>
                                        @if(Auth::user()->role_id == 18)
							<th>Appointment Letter</th>
							<th>NDA</th>
                                        <th>User Status</th>
                                        @endif
						
                                        <th>Status</th>
                                        <th>Communication Address</th>
                                        <th>Permanent Address</th>
                                        <th>Adharcard Number</th>
                                        <th>Pancard No</th>
                                        <th>Emergencycontact Number</th>
							@endif
							 @if(Auth::user()->role_id == 18)
                            <th>Address Proof</th>
                            <th>Pancard Document</th>
                            <th>Designation</th>
                            <th>Team lead</th>   
                            <th>Qualification</th>     
                            
                            <th>Location</th> 
                            <th>Gender</th>
                            <th>Mentor</th>
							 <th>Gross Salary</th>
							 <th>TDS</th>
							 <th>PF</th>
                            @endif
							
							 			<th>Beneficiary Name</th>
                                        <th>Name Of Bank</th>
                                        <th>Bank Account Number</th>
                                        <th>Ifsc Code</th>
							 <th>Bank Verified</th>
								@if(Auth::user()->role_id != 17)
                                        <th>Mother Name</th>
                                        <th>Mother Number</th>
                                        <th>Father Name</th>
                                        <th>Father Number</th>
                                     @endif
							
                                      <!--  <th>Deactivate</th>-->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($teammemberactiveDatas as $teammemberData)
                                    <tr>
										  <td style="display: none;">{{$teammemberData->id }}</td>
                                        <td>
											@if(Auth::user()->role_id == 18 || Auth::user()->teammember_id == 74)
											<a href="{{route('teammember.edit', $teammemberData->id)}}"> 
												
												@endif
												{{$teammemberData->team_member}}
												@if(Auth::user()->role_id == 18)
											</a>@endif
										</td>
									
                                        <td>{{$teammemberData->role->rolename ??''}}</td>
												@if(Auth::user()->role_id==18)
									 <td>{{$teammemberData->entity ??''}}</td>
							@endif
                                        <td>{{$teammemberData->mobile_no}}</td>
										
                                          @if($teammemberData->dateofbirth == null)
                            <td></td>
                            @else
                          <td>{{ date('F d,Y', strtotime($teammemberData->dateofbirth)) }}</td>
                            @endif
										<td style="display: none;">{{$teammemberData->joining_date ??''}}</td>
                              @if($teammemberData->joining_date == null)
                            <td></td>
                            @else
										
                          <td>{{ date('F d,Y', strtotime($teammemberData->joining_date)) }}</td>
                            @endif
							
                                       <td>{{$teammemberData->department ??''}}</td>
											@if(Auth::user()->role_id == 11 || Auth::user()->role_id == 18)
										 <td>{{$teammemberData->category ??''}}</td>
										 <td>{{$teammemberData->cost_hour ??''}}</td>
										@endif
										
                                        <td><a href="mailto:{{$teammemberData->emailid}}">{{$teammemberData->emailid ??''}}</a></td>
											@if(Auth::user()->role_id != 17)
                                        <td><a href="mailto:{{$teammemberData->personalemail}}">{{$teammemberData->personalemail ??''}}</a></td>
									
                                        @if(Auth::user()->role_id == 18)
										<td><a href="{{asset('backEnd/image/teammember/appointmentletter/'.$teammemberData->appointment_letter)}}">{{ $teammemberData->appointment_letter ??''}}</a></td>
										<td>
    <?php
    $ndaPath = 'backEnd/image/teammember/nda/'.$teammemberData->nda;
    if (file_exists(public_path($ndaPath))) {
        ?>
        <a href="{{ asset($ndaPath) }}">{{ $teammemberData->nda ?? '' }}</a>
        <?php
    } else {
        ?>
        <a target="_blank" href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $teammemberData->nda, now()->addMinutes(30)) }}">
            {{ $teammemberData->nda ?? 'Not Uploaded' }}
        </a>
        <?php
    }
    ?>
</td>


                                          <td><a id="editCompany" data-toggle="modal" data-id="{{ $teammemberData->id }}" data-target="#exampleModal11">
                                             @if($teammemberData->status==0)
                                            <span class="badge badge-danger">In Active</span>
                                            @else
                                            <span class="badge badge-success">Active</span>
                                            @endif
                                           </a>
                                        </td>
                                        @endif
                                         <td>    <input data-id="{{$teammemberData->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $teammemberData->status ? 'checked' : '' }}></td>
                                   <td>{{$teammemberData->communicationaddress ??''}}</td>
                                         <td>{{$teammemberData->permanentaddress ??''}}</td>
                                         <td>{{$teammemberData->adharcardnumber ??''}}</td>
                                         <td>{{$teammemberData->pancardno ??''}}</td>
                                         <td>{{$teammemberData->emergencycontactnumber ??''}}</td>
										@endif
										
										 @if(Auth::user()->role_id == 18)
                                        <td><img alt="Responsive image" style="width: 60px; height: 40px;"
                                                                src="{{ url('backEnd/image/teammember/addressupload/'.$teammemberData->addressupload )}}">
                                        </td>
                                       @if($teammemberData->role_id==15)
										<td><a target="blank"
                                    href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/'.$teammemberData->panupload, now()->addMinutes(30)) }}">
                                    {{ $teammemberData->panupload ??'Not Uploaded'}} </a></td>

										@else
                                        <td><a target="blank"
                                      href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/'.$teammemberData->panupload, now()->addMinutes(30)) }}">
                                      {{ $teammemberData->panupload ??'Not Uploaded'}} </a>
                              </td>
										@endif
                                  <td>{{$teammemberData->designation ??''}}</td>
                                            <td>{{$teammemberData->teamlead ??''}}</td>
                                            <td>{{$teammemberData->qualification ??''}}</td>
                                            
                                           
							<td>{{$teammemberData->location ??''}}</td>
                                            <td>{{$teammemberData->gender ??''}}</td>
                                            <td>{{App\Models\Teammember::where('id',$teammemberData->mentor_id)->pluck('team_member')->first() ??''}}</td>
										
										<td>{{$teammemberData->taxgrosssalary ??''}}</td>
										<td>{{$teammemberData->taxtds ??''}}</td>
										<td>{{$teammemberData->taxpf ??''}}</td>
                                    @endif
										  <td>{{$teammemberData->nameasperbank ??''}}</td>
										
                                         <td>{{$teammemberData->nameofbank ??''}}</td>
                                         <td>{{$teammemberData->bankaccountnumber ??''}}</td>
                                         <td>{{$teammemberData->ifsccode ??''}}</td>
										 <td> @if($teammemberData->verify==1)
                                <span class="badge badge-success">Yes</span>
                             
                                @else
                                <span class="badge badge-danger">No</span>
                                @endif
                            </td>
											@if(Auth::user()->role_id != 17)
                                         <td>{{$teammemberData->mothername ??''}}</td>
                                         <td>{{$teammemberData->mothernumber ??''}}</td>
                                         <td>{{$teammemberData->fathername ??''}}</td>
                                        <td>{{$teammemberData->fathernumber ??''}}</td>
                                        @endif
								
                                      <!--   <td> <form action="{{ route('teammember.destroy', $teammemberData->id) }}" method="POST">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                              <a  onclick="return confirm('Are you sure you want to deactivate this item?');" class="btn btn-danger-soft btn-sm"><i
                                            class="fa fa-user-times"></i></a>
                                        </form></td>-->
                                    </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>

                <br>
                <div class="tab-pane fade" id="pills-user" role="tabpanel" aria-labelledby="pills-user-tab">

                    <div class="table-responsive">
                        <table id="exampleees" class="display nowrap">
                            <thead>
                                <tr>
									<th  style="display: none;"></th>
                                    <th>Tea Member Name</th>
                                    <th>Team Role</th>
											@if(Auth::user()->role_id==18)
									 <th>Entity</th>
							@endif
                                    <th>Mobile No</th>
                                     <th>Date Of Birth</th>  
									@if(Auth::user()->role_id == 11 || Auth::user()->role_id == 18)
									<th>Category</th>
									<th>Cost Hourly</th>
									@endif
                            		<th>Joining Date</th>									
									<th>Leaving Date</th>									
                                    <th>Department</th>
                                    <th>Email</th>
                                    <th>Personal Email</th>
                                    @if(Auth::user()->role_id == 18)
                                    <th>User Status</th>
                                    @endif
                                    <th>Status</th>
                                    <th>Communication Address</th>
                                    <th>Permanent Address</th>
                                    <th>Adharcard Number</th>
                                    <th>Pancard No</th>
                                    <th>Emergencycontact Number</th>
									 @if(Auth::user()->role_id == 18)
                            <th>Address Proof</th>
                            <th>Pancard Document</th>
                            <th>Designation</th>
                            <th>Team lead</th>   
                            <th>Qualification</th>     
                            
                            <th>Location</th> 
                            <th>Gender</th>
                            <th>Mentor</th>
                            @endif
							
                                    <th>Name Of Bank</th>
                                    <th>Bank Account Number</th>
                                    <th>Ifsc Code</th>
                                    <th>Mother Name</th>
                                    <th>Mother Number</th>
                                    <th>Father Name</th>
                                    <th>Father Number</th>
                                 <th>Reason Of Leaving</th>
									@if(auth()->user()->role_id==18)
                                    <th>Status of Leaving</th>
                                	@endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teammemberinactiveDatas as $teammemberData)
                                <tr>
									<td style="display:none;">{{$teammemberData->id}}</td>
                                    <td>
										@if(Auth::user()->role_id == 18)
										<a href="{{route('teammember.edit', $teammemberData->id)}}">
											@endif
											{{$teammemberData->team_member}}
											
										</a>
									</td>
                                    <td>{{$teammemberData->role->rolename ??''}}</td>
											@if(Auth::user()->role_id==18)
									 <td>{{$teammemberData->entity ??''}}</td>
							@endif
                                    <td>{{$teammemberData->mobile_no}}</td>
                                        
                          <td>
							  @if($teammemberData->dateofbirth == null)
                       @else
							  {{ date('F d,Y', strtotime($teammemberData->dateofbirth)) }}
                            @endif
							</td>		
																		@if(Auth::user()->role_id == 11 || Auth::user()->role_id == 18)
										 <td>{{$teammemberData->category ??''}}</td>
										 <td>{{$teammemberData->cost_hour ??''}}</td>
										@endif
                            
                          <td>
							  @if($teammemberData->joining_date == null)
                            @else							  
							  {{ date('F d,Y', strtotime($teammemberData->joining_date)) }}
                            @endif
							</td>

                          <td>
							   @if($teammemberData->leavingdate == null)
                        		@else
							  {{ date('F d,Y', strtotime($teammemberData->leavingdate)) }}
                            @endif
									</td>
                                   <td>{{$teammemberData->department ??''}}</td>
                                    <td><a href="mailto:{{$teammemberData->emailid}}">{{$teammemberData->emailid ??''}}</a></td>
                                    <td><a href="mailto:{{$teammemberData->personalemail}}">{{$teammemberData->personalemail ??''}}</a></td>
                                    @if(Auth::user()->role_id == 18)
                                      <td> @if($teammemberData->status==0)
                                        <span class="badge badge-danger">In Active</span>
                                        @else
                                        <span class="badge badge-success">Active</span>
                                        @endif
                                    </td>
                                    @endif
                                     <td>    <input data-id="{{$teammemberData->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $teammemberData->status ? 'checked' : '' }}></td>
                               <td>{{$teammemberData->communicationaddress ??''}}</td>
                                     <td>{{$teammemberData->permanentaddress ??''}}</td>
                                     <td>{{$teammemberData->adharcardnumber ??''}}</td>
                                     <td>{{$teammemberData->pancardno ??''}}</td>
                                     <td>{{$teammemberData->emergencycontactnumber ??''}}</td>
									 @if(Auth::user()->role_id == 18)
                                        <td><img alt="Responsive image" style="width: 60px; height: 40px;"
                                                                src="{{ url('backEnd/image/teammember/addressupload/'.$teammemberData->addressupload )}}">
                                        </td>
                                       
                                        <td><img alt="Responsive image" style="width: 60px; height: 40px;"
                                                                src="{{ url('backEnd/image/teammember/panupload/'.$teammemberData->panupload )}}">
                                            </td>
                                            <td>{{$teammemberData->designation ??''}}</td>
                                            <td>{{$teammemberData->teamlead ??''}}</td>
                                            <td>{{$teammemberData->qualification ??''}}</td>
                                            
                                           
							<td>{{$teammemberData->location ??''}}</td>
                                            <td>{{$teammemberData->gender ??''}}</td>
                                            <td>{{App\Models\Teammember::where('id',$teammemberData->mentor_id)->pluck('team_member')->first() ??''}}</td>
										             
                                    @endif
										
                                     <td>{{$teammemberData->nameofbank ??''}}</td>
                                     <td>{{$teammemberData->bankaccountnumber ??''}}</td>
                                     <td>{{$teammemberData->ifsccode ??''}}</td>
                                     <td>{{$teammemberData->mothername ??''}}</td>
                                     <td>{{$teammemberData->mothernumber ??''}}</td>
                                     <td>{{$teammemberData->fathername ??''}}</td>
                                    <td>{{$teammemberData->fathernumber ??''}}</td>
                                     <td>{{$teammemberData->reasonofleaving	 ??''}}</td>
										@if(auth()->user()->role_id==18)
									<td> @if($teammemberData->relievingstatus==0)
                                        <span class="badge badge-success">Voluntary</span>
                                        @elseif($teammemberData->relievingstatus==1)
                                        <span class="badge badge-danger">In Voluntary</span>
                                        @else
                                        <span class="badge badge-danger">Not selected</span>
                                     @endif
                                        @endif
                                    </td>
										
                                  <!--   <td> <form action="{{ route('teammember.destroy', $teammemberData->id) }}" method="POST">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                          <a  onclick="return confirm('Are you sure you want to deactivate this item?');" class="btn btn-danger-soft btn-sm"><i
                                        class="fa fa-user-times"></i></a>
                                    </form></td>-->
                                </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
                <div>
                </div>
            </div>
        </div>
    </div>

</div>

<!--/.body content-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>

<script>
     $(function() {
    $('.toggle-class').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0; 
        var user_id = $(this).data('id'); 
         
        $.ajax({
              type: "GET",
              dataType: "json",
              url: "{{ url('/changeteamStatus') }}",
              data: {'status': status, 'user_id': user_id},
              success: function(data){
                console.log(data.success)
              }
          });
      })
    })
  </script>

<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form  method="post" action="{{ url('tax/upload')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background: #37A000">
                    <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Add Excel</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="details-form-field form-group row">
                        <label for="name" class="col-sm-3 col-form-label font-weight-600">Upload Excel:</label>
                        <div class="col-sm-9">
                            <input class="form-control" name="file" type="file">

                        </div>

                    </div>

                    <div class="details-form-field form-group row">
                        <label for="address" class="col-sm-3 col-form-label font-weight-600">Sample Excel:</label>
                        <div class="col-sm-9">
                            <a href="{{ url('backEnd/payrolluploadsheets.xlsx')}}"
                                class="btn btn-success btn">Download<i class="fas fa-file-excel"
                                    style="margin-left: 3px;font-size: 20px;"></i></a>

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
        $('#exampleees').DataTable({
            dom: 'Bfrtip',
            "order": [
                [4, "desc"]
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
<script>$(document).ready(function() {
    $('#examplee').DataTable( {
        dom: 'Bfrtip',
        "order": [[ 5, "desc" ]],
        
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
     <!-- Modal -->
<div class="modal fade" id="exampleModal11" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editpayment" method="post" action="{{ url('/teamupdate')}}"
            enctype="multipart/form-data">
            @csrf
          
            <div class="modal-header" style="background: #37A000">
                <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Update Details</h5>
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
                        <label for="name" class="col-sm-3 col-form-label font-weight-600">Leaving Date:</label>
                        <div class="col-sm-9">
                        <input class="form-control" id="leavingdate" name="leavingdate" type="date">
                        <input class="form-control" hidden id="teamid" name="teamid" type="text">
                        </div>
                    </div> 
                    <div class="details-form-field form-group row">
                        <label for="name" class="col-sm-3 col-form-label font-weight-600">Reason of Leaving:</label>
                        <div class="col-sm-9">
               <textarea rows="6" name="reasonofleaving" class=" form-control" 
                                placeholder="Enter Reason"></textarea>
                        </div>
                    </div>
				<div class="details-form-field form-group row">
                        <label for="name" class="col-sm-3 col-form-label font-weight-600">status of Leaving:</label>
                        <div class="col-sm-9">
                        <select name="relievingstatus" id="exampleFormControlSelect1" class="form-control">
                <!--placeholder-->
                <option value="0">Voluntary</option>
                <option value="1">In Voluntary</option>
                    </select>

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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(function () {
        $('body').on('click', '#editCompany', function (event) {
    //        debugger;
 
            var id = $(this).data('id');
     debugger;
            $.ajax({
                type: "GET",

                url: "{{ url('teammemberupdatedetail') }}",
                data: "id=" + id,

                success: function (response) {
                    $("#teamid").val(response.id);
                  //  $("#leavingdate").val(response.leavingdate);
					     debugger;
                },
                error: function () {

                },
            });
        });
    });

</script>