@extends('backEnd.layouts.layout') @section('backEnd_content')
<style>
    .example:hover {
        overflow-y: scroll;
        /* Add the ability to scroll */

    }


    /* Hide scrollbar for IE, Edge and Firefox */
    .example {
        height: 157px;
        margin: 0 auto;
        overflow: hidden;
    }

</style>
<style>
    .examplee:hover {
        overflow-y: scroll;
        /* Add the ability to scroll */

    }


    /* Hide scrollbar for IE, Edge and Firefox */
    .examplee {
        height: 175px;
        margin: 0 auto;
        overflow: hidden;
    }

</style>
<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
	 
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
       <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
		 
		    <li ><a class="btn btn-info" href="{{url('/yearwise?'.'year='.$assignmentbudgetingDatas->year.'&&'.'clientid='.$assignmentbudgetingDatas->client_id)}}">Back</a></li>
			
			<li style="margin-left: 13px;"> <a class="btn btn-primary"  href="{{url('assignmentfolders/'.$assignmentbudgetingDatas->assignmentgenerate_id)}}">
        All Files And Folders</a></li>

		   @if(auth()->user()->role_id == 11)
         <!--   <li class="breadcrumb-item"><a href="{{url('assignmentcosting/'.$assignmentbudgetingDatas->assignmentgenerate_id)}}">Assignment Costing Data</a></li> -->
     @endif
        </ol>
    </nav>
	
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Assignment List</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="card mb-4">
        <div class="card-body">
            <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:260px;">
                <div class="card-body">
                    <fieldset class="form-group">

                        <table class="table display table-bordered table-striped table-hover">

                            <tbody>

                                <tr>
                                    <td><b>Assignment Name : </b></td>
                                    <td>{{ $assignmentbudgetingDatas->assignment_name}}</td>

                                    <td><b>Assignment Code :</b></td>
                                    <td>{{ $assignmentbudgetingDatas->assignmentgenerate_id}}</td>

                                </tr>
                                <tr>
                                    <td><b>Client Name : </b></td>
                                    <td>{{ $assignmentbudgetingDatas->client_name}}</td>
                                    <td><b>Period End : </b></td>
                                    <td style="color: cornflowerblue;">{{ $assignmentbudgetingDatas->periodend}}</td>

                                </tr>
								<!--
								<tr>
                                    <td><b>File Creation Date : </b></td>
                                    <td>@if(!empty($assignmentbudgetingDatas->filecreationdate))
                                        {{ date('F d,Y', strtotime($assignmentbudgetingDatas->filecreationdate)) }}@endif</td>

                                    <td><b>Modified Date :</b></td>
                                    <td>@if(!empty($assignmentbudgetingDatas->modifieddate))
                                        {{ date('F d,Y', strtotime($assignmentbudgetingDatas->modifieddate)) }}@endif</td>

                                </tr>
                                <tr>
                                    <td><b>Audit Completion Date : </b></td>
                                    <td>@if(!empty($assignmentbudgetingDatas->auditcompletiondate))
                                        {{ date('F d,Y', strtotime($assignmentbudgetingDatas->auditcompletiondate)) }}@endif</td>

                                    <td><b>Documentaion Date :</b></td>
                                    <td>@if(!empty($assignmentbudgetingDatas->documentationdate))
                                        {{ date('F d,Y', strtotime($assignmentbudgetingDatas->documentationdate)) }}@endif</td>

                                </tr> -->
                                <tr>
                                    <td><b>Status : </b></td>
                                   <td>
                                        @if(Auth::user()->role_id == 13)
                                        @if($assignmentbudgetingDatas->status != 0)
                                        <a id="editCompanys" data-id="{{ $assignmentbudgetingDatas->assignmentgenerate_id }}" data-toggle="modal" data-target="#exampleModal134">
                                   >
                                            @if($assignmentbudgetingDatas->status==1)
                                            <span class="badge badge-primary">OPEN</span>
                                            @else
                                            <span class="badge badge-danger">CLOSED</span>
                                            @endif
                                        </a>
									   @else
									                                         
                                            @if($assignmentbudgetingDatas->status==1)
                                            <span class="badge badge-primary">OPEN</span>
                                            @else
                                            <span class="badge badge-danger">CLOSED</span>
                                            @endif
                                  
                                        @endif
                                        @else
                                       @if($assignmentbudgetingDatas->status==1)
                                            <span class="badge badge-primary">OPEN</span>
                                            @else
                                            <span class="badge badge-danger">CLOSED</span>
                                            @endif
                                     
                                        @endif
                                    </td>
                                    <td><b>Billing Frequency : </b></td>
                                    <td>@if($assignmentbudgetingDatas->billingfrequency==0)
                                        <span>Monthly</span>
                                        @elseif($assignmentbudgetingDatas->billingfrequency==1)
                                        <span>Quarterly</span>
                                        @elseif($assignmentbudgetingDatas->billingfrequency==2)
                                        <span>Half Yearly</span>
                                        @else
                                        <span>Yearly</span>
                                        @endif
                                    </td>

                                </tr>

                            </tbody>
                        </table>
                    </fieldset>
                </div>
            </div>
            </br>
            <div class="row">
                <div class="col-md-5">
                    <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:250px;">
                        <div class="card-body">
                            <div class="card-head">
                                <b>Teammember List</b>
                            </div>
                            <hr>
                            <div class="table-responsive example">
                                <table class="table display table-bordered table-striped table-hover ">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Role</th>
                                             <th>Mobile No</th>
                                                @if (auth()->user()->role_id == 13 || auth()->user()->role_id == 11)
                                                    <th>Status</th>
                                                @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($teammemberDatas as $teammemberData)
                                        <tr>
                                            <td>{{$teammemberData->title }} {{$teammemberData->team_member }}</td>
                                            <td>@if($teammemberData->type==0)
                                                <span >Team Leader</span>
                                                @else
                                                <span >Staff</span>
                                                @endif</td>
                                            <td><a
                                                    href="tel:={{$teammemberData->mobile_no }}">{{$teammemberData->mobile_no }}</a>
                                            </td>
   @if (auth()->user()->role_id == 13 || auth()->user()->role_id == 11)
                                                        <td>
                                                            @if ($teammemberData->assignmentteammappingsStatus == 0)
                                                                <a href="{{ url('/assignment/reject/' . $teammemberData->assignmentteammappingsId . '/1/' . $teammemberData->id) }}"
                                                                    onclick="return confirm('Are you sure you want to Active this teammember?');">
                                                                    <button class="btn btn-danger" data-toggle="modal"
                                                                        style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                                                                        data-target="#requestModal">Inactive</button>
                                                                </a>
                                                            @else
                                                                <a href="{{ url('/assignment/reject/' . $teammemberData->assignmentteammappingsId . '/0/' . $teammemberData->id) }}"
                                                                    onclick="return confirm('Are you sure you want to Inactive this teammember?');">
                                                                    <button class="btn btn-primary" data-toggle="modal"
                                                                        style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                                                                        data-target="#requestModal">Active</button>
                                                                </a>
                                                            @endif
                                                        </td>
                                                    @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card " style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:250px;">
                        <div class="card-body">

                            <div class="card-head">
                                <b>Client Contact</b>
                                <a data-toggle="modal" data-target="#exampleModal1" style="float:right;width:20px;"><img
                                        src="{{ url('backEnd/image/add-icon.png')}}" /></a>
                            </div>
                            <hr>
                            <div class="table-responsive example">
                                <table class="table display table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Designation</th>
                                            <th>Phone</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($contactDatas as $contactData)
                                        <tr>
                                            <td>{{$contactData->clientname }}</td>
                                            <td>{{$contactData->clientemail }}</td>
                                            <td>{{$contactData->clientdesignation }}</td>
                                            <td><a
                                                    href="tel:={{$contactData->clientphone }}">{{$contactData->clientphone }}</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <br>
		 <br>
		
     @if (Auth::user()->role_id == 13 ||
                        $assignmentbudgetingDatas->type == 0 ||
                        $assignmentbudgetingDatas->status == 1 ||
                        ($assignmentbudgetingDatas->type != 0 && $assignmentbudgetingDatas->status == 0))
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:250px;">
                                <div class="card-body">

                                    <div class="card-head">
                                        <b>UDIN List</b>
                                       @if (Auth::user()->role_id == 13 ||
                        $assignmentbudgetingDatas->type == 0 ||
                        $assignmentbudgetingDatas->status == 1 ||
                        ($assignmentbudgetingDatas->type != 0 && $assignmentbudgetingDatas->status == 0))
                                            <a data-toggle="modal" data-target="#exampleModal12"
                                                style="float:right;width:20px;"><img
                                                    src="{{ url('backEnd/image/add-icon.png') }}" /></a>
                                        @endif
                                    </div>
                                    <!-- Display success massage for user-->
                                    @if (session('message'))
                                        <div class="alert alert-success">
                                            {{ session('message') }}
                                        </div>
                                    @endif
                                    <hr>

                                    <div class="table-responsive example">
                                        <table class="table display table-bordered table-striped table-hover ">
                                            <thead>
                                                <tr>
                                                    <th>UDIN</th>
                                                    <th>Partner</th>
                                                    <th>Created by</th>
                                                    <th>Created Date</th>
                                                    @if (
                                                        (Auth::user()->role_id != 11 && $assignmentbudgetingDatas->type == 0 && $assignmentbudgetingDatas->status == 1) ||
                                                            (Auth::user()->role_id == 14 && $assignmentbudgetingDatas->status == 1))
                                                        <th>Action</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($udinDatas as $udinData)
                                                    <tr>
                                                        <td>{{ $udinData->udin }}</td>
                                                        <td>{{ App\Models\Teammember::where('id', $udinData->partner)->select('team_member')->pluck('team_member')->first() }}
                                                        </td>
                                                        <td>{{ $udinData->team_member }} ( {{ $udinData->rolename ?? '' }}
                                                            )</td>
                                                        <td>{{ date('d-m-Y', strtotime($udinData->created)) }},
                                                            {{ date('H:i A', strtotime($udinData->created)) }}</td>

                                                        @if (
                                                            (Auth::user()->role_id != 11 && $assignmentbudgetingDatas->type == 0 && $assignmentbudgetingDatas->status == 1) ||
                                                                (Auth::user()->role_id == 14 && $assignmentbudgetingDatas->status == 1))
                                                            <td>
                                                                <form
                                                                    action="{{ route('uidindata.delete', ['id' => $udinData->assignmentbudgetingudinsid]) }}"
                                                                    method="post" class="form1">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="deleteButton btn btn-sm btn-danger mx-2"
                                                                        style="height: 21px; width: 3rem; font-size: 8px;">
                                                                        Delete
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
		<!--Success message on Deleted -->
                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                <script>
                    $(document).ready(function() {
                        // Display success message for user
                        @if (session('message'))
                            // Use JavaScript to display the success message in the modal
                            $('#successMessage').text("{{ session('message') }}");
                            $('#successModal').modal('show');
                        @endif
                    });
                </script>
            <br>
        </div>
    </div>
    @foreach($assignmentcheckDatas as $assignmentcheckData)
    <div class="card mb-4">
        <div class="card-body">

            <div class="card-head">
                <b>{{ $assignmentcheckData->financial_name }}</b>
            </div>
            <hr>
            <div class="row">
                @php
 $assignmentcheckk = 
     DB::table('subfinancialclassfications')
     ->where('assignmentgenerate_id', $assignmentbudgetingDatas->assignmentgenerate_id)
     ->select('assignmentgenerate_id')->first();
    // dd($assignmentcheckk); die;
   if( $assignmentcheckk == null){
    $ssub=App\Models\Subfinancialclassfication::where('financialstatemantclassfication_id',$assignmentcheckData->id)
    ->where('assignmentgenerate_id', null)
                ->get();
              
   }
   else{
    $ssub=App\Models\Subfinancialclassfication::where('financialstatemantclassfication_id',$assignmentcheckData->id)
                ->get();
             
   }
  
                @endphp
                @foreach($ssub as $ssub)
                <div class="col-md-3" style="
    padding: 10px;
">
                    <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:292px;">
                        <form>
                            <div class="card-body">
                                <div class="card-head">
                                    <b>{{ $ssub->subclassficationname }}</b>
                                </div>
                                <hr>
                                <ul class="todo-list examplee">
                                    @php
 $auditquestionscheck = DB::table('auditquestions')
     ->where('assignmentgenerate_id', $assignmentbudgetingDatas->assignmentgenerate_id)
   ->select('assignmentgenerate_id')->first();
  // dd($auditquestionscheck);
  if( $auditquestionscheck == null){
    $subb = App\Models\Auditquestion::leftJoin('subfinancialclassfications',function
                                    ($join)
                                    {$join->on('auditquestions.subclassfied_id','subfinancialclassfications.id'); })
                                    ->leftJoin('steplists',function ($join)
                                    {$join->on('auditquestions.steplist_id','steplists.id'); })
                                    ->where('auditquestions.subclassfied_id',$ssub->id)
                                    ->where('auditquestions.financialstatemantclassfication_id',$assignmentcheckData->id)
                                    ->where('auditquestions.assignmentgenerate_id', null)
                                    ->select('stepname','steplists.id')->distinct()->get();
  }else
  {
   $subb = App\Models\Auditquestion::leftJoin('subfinancialclassfications',function
                                    ($join)
                                    {$join->on('auditquestions.subclassfied_id','subfinancialclassfications.id'); })
                                    ->leftJoin('steplists',function ($join)
                                    {$join->on('auditquestions.steplist_id','steplists.id'); })
                                    ->where('auditquestions.subclassfied_id',$ssub->id)
                                    ->where('auditquestions.financialstatemantclassfication_id',$assignmentcheckData->id)
                                    ->select('stepname','steplists.id')->distinct()->get();
  }
                                    @endphp
                                    @foreach($subb as $sub )
                                    <li>
                                        <label for="todo1"> <a
                                                href="{{url('/auditchecklist?'.'steplist='.$sub->id.'&&'.'subclassfied='.$ssub->id.'&&'.'assignmentid='.$assignmentbudgetingDatas->assignmentgenerate_id.'&&'.'financialid='.$ssub->financialstatemantclassfication_id)}}">{{ $sub->stepname}}</a>
                                         

                                            @php
                                            $status = App\Models\Checklistanswer::
                                            leftJoin('statuses',function ($join)
                                            {$join->on('checklistanswers.status','statuses.id'); })
                                            ->where('steplist_id',$sub->id)
                                            ->where('financialstatemantclassfication_id',$ssub->financialstatemantclassfication_id)
                                            ->where('subclassfied_id',$ssub->id)
                                            ->where('assignment_id',$assignmentbudgetingDatas->assignmentgenerate_id)->select('statuses.*')->orderBy('id',
                                            'asc')->first();

                                            $count = App\Models\Auditquestion::where('steplist_id',$sub->id)
                                            ->where('financialstatemantclassfication_id',$ssub->financialstatemantclassfication_id)
                                            ->where('subclassfied_id',$ssub->id)->select('id')->get();
                                            $countauditqstn = count($count);

                                            $countan = App\Models\Checklistanswer::
                                            leftJoin('statuses',function ($join)
                                            {$join->on('checklistanswers.status','statuses.id'); })
                                            ->where('steplist_id',$sub->id)
                                            ->where('financialstatemantclassfication_id',$ssub->financialstatemantclassfication_id)
                                            ->where('subclassfied_id',$ssub->id)
                                            ->where('assignment_id',$assignmentbudgetingDatas->assignmentgenerate_id)->select('statuses.*')->get();
                                            $countauditanswer = count($countan);

                                            @endphp
                                            @if( $countauditanswer == $countauditqstn)
                                            @if($status)
                                            <span class="{{ $status->color ??'' }}">{{ $status->name ??''}}</span>
                                            @else
                                            <span class="badge badge-primary">OPEN</span>
                                            @endif
                                            @else
                                            <span class="badge badge-primary">OPEN</span> @endif
                                        </label>
                                    </li>

                                    @endforeach
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
                <br>
                @endforeach


            </div>
            <br>
        </div>
    </div>
    @endforeach
</div>
<!--/.body content-->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('viewassignment/contactupdate') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title font-weight-600" id="exampleModalLabel4">Add Client Contact</h5>
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

                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-600"> Name</label>
                                <input type="text" name="clientname" value="" class=" form-control"
                                    placeholder="Enter Client Name">
                                <input type="text" name="client_id" hidden
                                    value="{{$assignmentbudgetingDatas->client_id}}" class=" form-control"
                                    placeholder="Enter Client Name">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-600"> Email</label>
                                <input type="text" name="clientemail" value="" class=" form-control"
                                    placeholder="Enter Client Email">
                            </div>
                        </div>
                    </div>

                    <div class="details-form-field form-group row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-600"> Phone</label>
                                <input type="text" name="clientphone" value="" class=" form-control"
                                    placeholder="Enter Client Phone">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-600"> Designation</label>
                                <input type="text" name="clientdesignation" value="" class=" form-control"
                                    placeholder="Enter Client Designation">
                            </div>
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
<!-- Modal -->
<div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{url('assignmentudin/store')}}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background:#37A000;color:white;">
                    <h5 class="modal-title font-weight-600" id="exampleModalLabel4">Add UDIN</h5>
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
                <div class="field_wrapper">   
             <div class="row row-sm ">
    <div class="col-10">
        <div class="form-group">
            <label class="font-weight-600">UDIN</label>
            <input type="text" name="udin[]" value="" class=" form-control" placeholder="Enter Udin">
            <input type="text" name="assignment_generate_id" hidden value="{{ $assignmentbudgetingDatas->assignmentgenerate_id}}" class=" form-control">
        </div>
    </div>
                <a href="javascript:void(0);" style="margin-top: 36px;" class="add_button" title="Add field"><img
                        src="{{ url('backEnd/image/add-icon.png')}}" /></a>
          
        </div>
        </div>
       
   <div class="row row-sm ">
            <div class="col-10">
                <div class="form-group">
                    <label class="font-weight-600">Partner </label>
                    <select class="form-control" name="partner"> 
                        <option value="">Please Select One</option>
                        @foreach($partner as $teammemberData)
                        <option value="{{$teammemberData->id}}">
                            {{ $teammemberData->team_member }}</option>
            
                        @endforeach
                    </select>
                </div>
            </div>
                    
                  
                </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
            </form>
				   
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = '<div class="row row-sm "><div class="col-10"><div class="form-group"><input type="text" class="form-control key" name="udin[]" id="key" value=""  placeholder="Enter Udin"></div></div><a style="margin-top:9px;" href="javascript:void(0);" class="remove_button"><img src="{{ url('backEnd/image/remove-icon.png')}}"/></a></div></div>'; //New input field html 
        var x = 1; //Initial field counter is 1
        
        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){ 
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });
        
        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });
    </script>
@endsection
<div class="modal fade" id="exampleModal134" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <form id="detailsForm" method="post" action="{{ url('assignmentotp/store')}}" enctype="multipart/form-data">
            @csrf
            <div class="modal-header" style="background: #37A000">
                <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Enter
                    Verification OTP</h5>
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
                   
                    <div class="col-sm-12">
                        <div style="text-align: center;color: #37A000" id="otp-message"></div>
                        <br>
                        <input type="number" required name="otp" class="form-control" placeholder="Enter OTP">
                        <input hidden type="text" name="assignmentgenerateid" id="assignmentgenerateid" 
                        class="form-control">
                 {{-- <div style="text-align: center;"><a href="{{url('assignmentotp')}}"  class="font-weight-500">Resend Otp</a></div> --}}
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
    $('body').on('click', '#editCompanys', function (event) {
        //        debugger;
        var id = $(this).data('id');
        debugger;
        $.ajax({
            type: "GET",

            url: "{{ url('assignmentotp') }}",
            data: "id=" + id,
            success: function (response) {
                // alert(res);
                debugger;
                $("#assignmentgenerateid").val(response.assignmentgenerate_id);


                if (response !== null) {
                  // Show the message that the OTP has been sent to the email
                  $('#otp-message').html('OTP send to your email please check');
                }
            },
            error: function () {

            },
        });
    });
});

</script>