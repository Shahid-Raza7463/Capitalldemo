<!--Third party Styles(used by this page)-->
<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">

@extends('backEnd.layouts.layout') @section('backEnd_content')

@if(Auth::user()->role_id == 11 || Auth::user()->role_id == 16)

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal1">Add Icard</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Article Details</small>
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
            <div class="table-responsive">
                <table id="example" class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Employee Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($icardsDatas as $icardsData)
                        <tr>

                            <td> <a
                                    href="{{route('articlefiles.edit', $icardsData->id)}}">{{ $icardsData->team_member }}</a>
                            </td>
                            <td>@if($icardsData->status==0)
                                <span class="badge badge-pill badge-danger">Not Acknowledge</span>
                                @else
                                <span class="badge badge-pill badge-success">Acknowledge</span>

                                @endif
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@else

<!--/.Content Header (Page header)-->
<div id="printableArea">
    <div class="body-content">
		  @if($icardsDatas != null)
        <div class="card mb-4">
            <div class="card-header" style="background: #37A000">
                <div class="">
                    <div style="text-align: center;">
                        <h6 style="color:white;" class="fs-17 font-weight-600 mb-0">ICARD POLICY</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <p>Guidance note to Managers : Staff Identity Cards Policy</p>
                <p>Introduction </p>
                <p>
                    KGS has a duty of care to all staff concerning their safety at work. Everybody has a responsibility
                    to follow procedures in their work place for their safety. In support of this KGS operates a number
                    of security measures to ensure that persons who access KGS’S Offices have a proper reason to be
                    present.
                </p>
                <p>
                    The purpose of this identification badge policy and procedure is
                    <b>to promote security, safety, and confidence in the service </b>by ensuring all employees are
                    identified. This policy applies to all employees of KGS
                </p>
                <p>Policy</p>
                <p>It is mandatory for all the KGS staff to always wear their ID card in a visible manner at their
                    workplace .
                </p>
                <p>
                It is also mandatory to wear I Card at clients' / customers' / vendors' or any other premises, while on
                visit on behalf of company.</p>
                <p>
                ID cards are issued to staff upon engagement and are available from the IT Teams.</p>
                <p>
                Staff must never loan his /her card to another person, irrespective of whether they are also KGS staff.</p>
                <p>
                Any member of staff who persistently fails to wear their ID card, or refuses to wear it without good
                reason, in contravention of this policy will be subject to disciplinary action. </p>
                <p>
                Staff who lose their ID Cards should report about it to the IT department as soon as possible and
                request for a replacement card. Replacement card will be chargeable @INR 50 </p>
                <p>
                On exit/transfer /resignation from KGS staff are required to return their ID card to their line manager.</p>
                <p>
                It is Managers duty to ensure the adherence of this policy by their team members. </p>
                <p>
                The policy does makes it clear that any member of staff who persistently fails to wear their ID card, or
                refuses to wear it without good reason, or loans it to another person in contravention of this policy
                will be subject to disciplinary action in accordance with the KGS disciplinary procedure.</p>
                <p>
                In case of loss of your ID Card for the Second time INR 200 fine will be charged as penalty fees.
                </p>
<br>
                <hr>
				
                @if($icardsDatas->status == 0)
                <p class="text-muted">
                    <p style="text-align: center;"> <b style="font-size: 15px;">Acknowledge.</b> : </p>
            
                </p>
                <form  style="text-align: center;"  id="detailsForm" method="post" action="{{ url('/icardsconfirm')}}" enctype="multipart/form-data">
                    @csrf
                    <p class="text-muted">
                        <select name="status" id="exampleFormControlSelect1" class="">
                            <!--placeholder-->
            
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
            
                    </p>
                    <button type="submit" class="btn btn-success">Confirm</button>
                    </a>
                </form>
                @endif
		@else
		<br>
		<center>
		<div class="card" style="width:310px; color:#023568; height:310px;">
			<br><br><bR><br><br><br>
    <center>
        <h5><b>Icard <br>Not Assigned</b></h5>
    </center>

    
			</div></center>
		  @endif
            </div>
        </div>
    </div>
    <!--/.body content-->
</div>
@endif
<!--/.body content-->
<!-- Modal -->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ route('icards.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background: #37A000">
                    <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Add Icard</h5>
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
                        <label for="name" class="col-sm-4 col-form-label font-weight-600">Employee Name:</label>
                        <div class="col-sm-8">
                            <select required class="language form-control" name="teammember_id"
                                @if(Request::is('assetprocurement/*/edit'))> <option disabled
                                style="display:block">Please Select One</option>

                                @foreach($teammember as $teammemberData)
                                <option value="{{$teammemberData->id}}" @if(($assetprocurement->teammember_id) ==
                                    $teammemberData->id) selected
                                    @endif>
                                    {{ $teammemberData->team_member }} ( {{ $teammemberData->role->rolename }} )
                                </option>
                                @endforeach


                                @else
                                <option></option>
                                <option value="">Please Select One</option>
                                @foreach($teammember as $teammemberData)
                                <option value="{{$teammemberData->id}}">
                                    {{ $teammemberData->team_member }} ( {{ $teammemberData->role->rolename }} )
                                </option>

                                @endforeach
                                @endif
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
@endsection
