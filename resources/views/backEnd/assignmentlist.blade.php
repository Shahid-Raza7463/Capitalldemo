
 <!--Third party Styles(used by this page)--> 
  <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">


@extends('backEnd.layouts.layout') @section('backEnd_content')

<div class="body-content">
    <div class="card mb-4">
        @component('backEnd.components.alert')

        @endcomponent
        <div class="card-header">

            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <h6 class="fs-17 font-weight-600 mb-0">{{ $assignmentList->assignment_name }}</h6>
                </div>

            </div>
        </div>
        <div class="card-body">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                        aria-controls="pills-home" aria-selected="true">Assignment Overview</a>
                </li>
                  {{--    <li class="nav-item">
                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
                        aria-controls="pills-profile" aria-selected="false">File</a>
                </li>
           <li class="nav-item">
                    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab"
                        aria-controls="pills-contact" aria-selected="false">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-user-tab" data-toggle="pill" href="#pills-user" role="tab"
                        aria-controls="pills-user" aria-selected="false">User Activity</a>
                </li>  --}}
                <li class="nav-item">
                    <a class="nav-link" id="pills-member-tab" data-toggle="pill" href="#pills-member" role="tab"
                        aria-controls="pills-member" aria-selected="false">Team Member</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);">
                        <div class="card-body">
                            @if(auth()->user()->role_id != 15)
                            <div class="card-head" style="width:930px;height: 10px;">
                                  <b style="float:right;margin-top: -17px;">Edit <a href="{{url('/assignmentmapping/edit/'.$assignmentList->id)}}" 
                                    class="btn btn-info-soft btn-sm"><i class="far fa-edit"></i></a></b>
                            </div>
                            @endif
                            <hr>
                            <fieldset class="form-group">

                                <table class="table display table-bordered table-striped table-hover">

                                    <tbody>

                                        <tr>
                                            <td><b>Client Name : </b></td>
                                            <td>{{ $assignmentList->client_name}}</td>
                                            <td><b>Assignment Code :</b></td>
                                            <td>{{ $assignmentList->assignmentgenerate_id}}</td>
                                            <td></td>
											<td></td>
                                        </tr>
                                        <tr>

                                            <td><b>Due Date : </b></td>
                                            <td>{{ date('F d,Y', strtotime($assignmentList->duedate)) }}</td>

                                            <td><b>Role Over Assignment :</b></td>
                                            <td>@if($assignmentList->billingfrequency==1)
                                                <span>No</span>
                                                @else
                                                <span>Yes</span>
                                                @endif</td>
                                           <!-- <td><b>Bill Date :</b></td>
                                            <td>{{ date('F d,Y', strtotime($assignmentList->billdate)) }}</td> -->

                                        </tr>
                                        <tr>
                                            <td></td>
											<td></td>
                                            <td><b>Period End : </b></td>
                                            <td>{{ date('F d,Y', strtotime($assignmentList->periodend)) }}</td>
                                            <td><b>Est Hours : </b></td>
                                            <td>{{ $assignmentList->esthours }}</td>


                                        </tr>
                                        <tr>
                                            <td><b>Std Cost : </b></td>
                                            <td>{{ $assignmentList->stdcost}}</td>
                                            <td><b>Est Cost : </b></td>
                                            <td>{{ $assignmentList->estcost }}</td>
                                            <td><b>Status : </b></td>
                                            <td>@if($assignmentList->status==2)
                                                <span class="badge badge-success">SUBMITTED</span>
                                                @elseif($assignmentList->status==3)
                                                <span class=" badge badge-warning">REVIEW-TL</span>
                                                @elseif($assignmentList->status==4)
                                                <span class=" badge badge-danger">CLOSE</span>
                                                @else
                                                <span class="badge badge-primary">OPEN</span>
                                                @endif</td>


                                        </tr>
                                    </tbody>
                                </table>
                            </fieldset>
                        </div>
                    </div>
                </div>
               <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="table-responsive example">
                        
                    <table class="table display table-bordered table-striped table-hover basic">
                            <thead>
                                <tr>
                                    <th>Audit Name</th>
                                    <th>Document Name</th>
                                    <th>Uploaded by</th>
                                      <th style="width: 189px;">File</th>
                                    <th>Date</th>
                                  

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($checklistfile as $checklistfiledata)
                                <tr>
                                    <td>{{$checklistfiledata->auditprocedure }}</td>
                                    <td>{{$checklistfiledata->refdocument }}</td>
                                    <td>{{$checklistfiledata->team_member }} ( {{$checklistfiledata->rolename }} )</td>
                                    @if (pathinfo($checklistfiledata->refdocument, PATHINFO_EXTENSION) == 'png')
                                    <td><a class="btn btn-success btn" target="blank"
                                            href="{{ asset('backEnd/image/client/document/'.$checklistfiledata->refdocument) }}"><i
                                                class="fas fa-file" style="margin-right: 4px;"></i>Open</a> <a
                                            class="btn btn-success btn" target="blank"
                                            href="{{ asset('backEnd/image/client/document/'.$checklistfiledata->refdocument) }}"><i
                                                class="fas fa-download" style="margin-right: 4px;"></i>Download</a></td>
                                    @elseif(pathinfo($checklistfiledata->refdocument, PATHINFO_EXTENSION) == 'jpeg')
                                    <td><a class="btn btn-success btn" target="blank"
                                            href="{{ asset('backEnd/image/client/document/'.$checklistfiledata->refdocument) }}"><i
                                                class="fas fa-file" style="margin-right: 4px;"></i>Open </a> <a
                                            class="btn btn-success btn" target="blank"
                                            href="{{ asset('backEnd/image/client/document/'.$checklistfiledata->refdocument) }}"><i
                                                class="fas fa-download" style="margin-right: 4px;"></i>Download</a></td>
                                    @elseif(pathinfo($checklistfiledata->refdocument, PATHINFO_EXTENSION) == 'jpg')
                                    <td><a class="btn btn-success btn" target="blank"
                                            href="{{ asset('backEnd/image/client/document/'.$checklistfiledata->refdocument) }}"><i
                                                class="fas fa-file" style="margin-right: 4px;"></i>Open </a> <a
                                            class="btn btn-success btn" target="blank"
                                            href="{{ asset('backEnd/image/client/document/'.$checklistfiledata->refdocument) }}"><i
                                                class="fas fa-download" style="margin-right: 4px;"></i>Download</a></td>
                                    @else
                                    <td><a class="btn btn-primary btn" target="blank"
                                            href="https://docs.google.com/gview?url={{ asset('backEnd/image/client/document/'.$checklistfiledata->refdocument) }}"><i
                                                class="fas fa-file-excel" style="margin-right: 4px;"></i>Open</a> <a
                                            class="btn btn-success btn" target="blank"
                                            href="{{ asset('backEnd/image/client/document/'.$checklistfiledata->refdocument) }}"><i
                                                class="fas fa-download" style="margin-right: 4px;"></i>Download</a></td>
                                    @endif
                                    <td>{{ date('F d,Y', strtotime($checklistfiledata->created_at)) }}</td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
                </div>
                {{--  <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                    <div class="table-responsive example">
                        <table class="table display table-bordered table-striped table-hover basic">
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
                                    <td><a href="tel:={{$contactData->clientphone }}">{{$contactData->clientphone }}</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> --}}
                <div class="tab-pane fade" id="pills-user" role="tabpanel" aria-labelledby="pills-user-tab">
                    <div class="table-responsive example">
                        
                        <table class="table display table-bordered table-striped table-hover basic">
                            <thead>
                                <tr>
                                    <th>Member</th>
                                    <th>Description</th>
                                    <th>Audit name</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($audittrail as $audittrailData)
                                <tr>
                                    <td>{{$audittrailData->team_member }}</td>
                                    <td>{{$audittrailData->desc }}</td>
                                    <td>{{$audittrailData->auditprocedure }}</td>
                                         <td>{{ date('F d,Y', strtotime($audittrailData->created_at)) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-member" role="tabpanel" aria-labelledby="pills-member-tab">
                    <div class="table-responsive">
                        @if(auth()->user()->role_id != 15)
                        <div class="card-head" style="width:950px;">
                            <br>
                            <b style="float:right;margin-top: -21px;">New Member <a data-toggle="modal" data-target="#exampleModal1"      class="btn btn-info-soft btn-sm"><i class="fa fa-plus"></i></a></b>
                            
                                    
                        </div>
                        @endif
                        <hr>
                        <table class="table display table-bordered table-striped table-hover basic">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Mobile No</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teammemberDatas as $teammemberData)
                                <tr>
                                    <td>{{$teammemberData->team_member }}</td>
                                    <td>@if($teammemberData->type==0)
                                        <span>Team Leader</span>
                                        @else
                                        <span>Staff</span>
                                        @endif</td>
                                    <td><a
                                            href="tel:={{$teammemberData->mobile_no }}">{{$teammemberData->mobile_no }}</a>
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


</div>
<!--/.body content-->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('teammapping/update') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title font-weight-600" id="exampleModalLabel4">Add Team Member</h5>
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
                                <label class="font-weight-600">Name</label>
                                <select class="language form-control" id="exampleFormControlSelect1" name="teammember_id">

                                    <option value="">Please Select One</option>
                                    @foreach($teammember as $teammemberData)
                                    <option value="{{$teammemberData->id}}">{{ $teammemberData->team_member }} (
                                        {{ $teammemberData->role->rolename }} )</option>
                                    @endforeach
                                </select>
                                <input type="text" hidden name="assignmentmapping_id" value="{{$assignmentList->id}}"
                                    class=" form-control" placeholder="Enter Client Name">
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label class="font-weight-600">Type</label>
                                <select class="form-control key" id="key" name="type">

                                    <option value="">Please Select One</option>
									<option value="0">Team Leader</option>
                                    <option value="2">Staff</option>
                                </select>
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
