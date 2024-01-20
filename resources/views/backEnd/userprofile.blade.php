@extends('backEnd.layouts.layout') @section('backEnd_content')
    <div class="main-content">
        <div class="body-content">
            <div class="row">
                <div class="col-sm-10 col-xl-10">
                    <div class="media d-flex m-1 ">
                        <div class="align-left p-1">
                            <a href="#" class="profile-image">
                                <img src="{{ $userInfo->profilepic ?? '' }}"
                                    class="avatar avatar-xl rounded-circle img-border height-100" alt="Card image">
                            </a>
                        </div>
                        <div class="media-body text-left ml-3 mt-1">
                            <h3 class="font-large-1 white">{{ $userInfo->team_member ?? '' }}

                            </h3>
                            {{--   <p class="white">
                            <i class="fas fa-map-marker-alt"></i> {{$userInfo->permanentaddress ??''}} </p>
                      <p class="white text-bold-300 d-none d-sm-block">Lorem ipsum dolor sit amet, consectetur
                            adipiscing elit. Nunc sed odio risus. Integer sit amet dolor elit. Suspendisse
                            ac neque in lacus venenatis convallis. Sed eu lacus odio</p> --}}

                        </div>
                    </div>
                </div>
                @php
                    $staff = DB::table('staffappointmentletters')
                        ->where('teammember_id', Auth::user()->teammember_id)
                        ->first();
                @endphp
                @if ($staff != null)
                    <div class="col-sm-2 col-xl-2">
                        <div class="media d-flex m-1 ">
                            <a href="{{ url('appointmentletters') }}" style="float: right;"
                                class="btn btn-success ml-2">Appointment Letter</a>
                        </div>
                    </div>
                @endif
            </div>
            <div class="row">
                {{-- <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 font-weight-600">Title</h6>
                            </div>
                            <div class="col-auto">
                                <time class="fs-13 font-weight-600 text-muted">{{ App\Models\Title::select('title')->where('id',$userInfo->title_id)->first()->title ?? ''}}</time>
                            </div>
                        </div>
                        <hr>
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 font-weight-600">Birthday</h6>
                            </div>
                            <div class="col-auto">
                                <time class="fs-13 font-weight-600 text-muted" datetime="1988-10-24">{{$userInfo->dateofbirth ??''}}</time>
                            </div>
                        </div>
                        <hr>
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 font-weight-600">Date Of Joining</h6>
                            </div>
                            <div class="col-auto">
                                <time class="fs-13 font-weight-600 text-muted" datetime="2018-10-28">{{ date('d-M-y', strtotime($userInfo->joining_date)) }}</time>
                            </div>
                        </div>
                        <hr>
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 font-weight-600">Address</h6>
                            </div>
                            <div class="col-auto">
                                <span class="fs-13 font-weight-600 text-muted">{{$userInfo->address_proof ??''}}</span>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fs-17 font-weight-600 mb-0">Asset</h6>
                            </div>
                        </div>
                    </div>
                    @if ($asset == null)
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col" style="text-align: center">
                                <h6 class="mb-0 font-weight-600">Not Assign</h6>
                            </div>
                           
                        </div>
                    </div>
                    @else
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 font-weight-600">Asset Type</h6>
                            </div>
                            <div class="col-auto">
                                <time class="fs-13 font-weight-600 text-muted" datetime="1988-10-24">@if ($asset->item == 0 ?? '')
                                    <span >Laptop</span>
                                    @else
                                    <span>Mobile</span>
                                    @endif</time>
                            </div>
                        </div>
                        <hr>
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 font-weight-600">Assign Date</h6>
                            </div>
                            <div class="col-auto">
                                <time class="fs-13 font-weight-600 text-muted" datetime="1988-10-24">
                                    <td>{{ date('d-M-y', strtotime($asset->updated_at)) }}</td>
                     
                                </time>
                            </div>
                        </div>
                        <hr>
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 font-weight-600">Description</h6>
                            </div>
                            <div class="col-auto">
                                <time class="fs-13 font-weight-600 text-muted" datetime="1988-10-24">
                                    {!! $asset->description !!}
                                </time>
                            </div>
                        </div>
                        <hr>
                        <div class="row align-items-center">
                            <div class="col" style="text-align: center">
                            <a href="{{url('/generateticket/'.$asset->id)}}"" class="btn btn-primary w-100p mb-2 mr-1">Create Ticket</a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fs-17 font-weight-600 mb-0">Ticket</h6>
                            </div>
                        </div>
                    </div>
                   
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table display table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="font-weight-600">Ticket</th>
                                        <th class="font-weight-600">Date</th>
                                        <th class="font-weight-600">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assetticket as $assetticketData)
                                    <tr>
                                        <td>{{$assetticketData->generateticket_id }}</td>
                                       <td>{{ date('d-M-y', strtotime($assetticketData->created_at)) }}</td>
                                        <td>@if ($assetticketData->status == 0)
                                            <span >open</span>
                                            @elseif($assetticketData->status==1)
                                            <span>working</span>
                                            @elseif($assetticketData->status==2)
                                            <span>close</span>
                                            @else
                                            <span>reject</span>
                                            @endif
                                        </td>
                                    </tr>
                                  @endforeach
                                </tbody>
                            </table>
                       
                    </div>
                    </div>
                </div>
            </div> --}}
                <div class="col-lg-12">
                    <div class="card">
                        @component('backEnd.components.alert')
                        @endcomponent
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fs-17 font-weight-600 mb-0">Edit Profile</h6>

                                </div>
                                <h6 id="profileCompletion"></h6>
                                @if ($teamprofile != null)
                                    <div>
                                        <a class="btn btn-success"
                                            href="{{ url('teamprofile/' . $teamprofile->id . '/edit') }}">
                                            edit resume</a>
                                    </div>
                                @endif
                                <!--<div>
                                                    <a class="btn btn-success" href="{{ url('profileimage/' . Auth::user()->teammember_id) }}">Generate Id</a>
                                                    </div> -->
                            </div>
                        </div>
                        <form method="post" action="{{ url('userprofile/update') }}" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <ul>
                                    @foreach ($errors->all() as $e)
                                        <li style="color:red;">{{ $e }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="font-weight-600">Title</label>
                                            <select class="form-control" id="exampleFormControlSelect1" name="title_id"
                                                @if (Request::is('userprofile/*')) > <option disabled
                                        style="display:block">Please Select One</option>
                        
                                        @foreach ($title as $titleData)
                                        <option value="{{ $titleData->id }}"
                                            {{ $userInfo->title_id == $titleData->id ?? '' ? 'selected="selected"' : '' }}>
                                            {{ $titleData->title }}</option>
                                        @endforeach @endif
                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="font-weight-600">Name</label>
                                            <input type="text" name="id" hidden class="form-control"
                                                placeholder="Username" value="{{ $userInfo->id }}">
                                            <input type="text" name="team_member" class="form-control"
                                                placeholder="Username" value="{{ $userInfo->team_member ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Employee Code</label>

                                            <input type="text" readonly class="form-control" placeholder="Username"
                                                value="{{ $userInfo->staffcode ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 pr-md-1">
                                        <div class="form-group">
                                            <label class="font-weight-600">Email address</label>
                                            <input type="email" readonly name="emailid" class="form-control"
                                                value="{{ $userInfo->emailid ?? '' }}" placeholder="Enter Email address">
                                        </div>
                                    </div>
                                    <div class="col-md-4 pr-md-1">
                                        <div class="form-group">
                                            <label class="font-weight-600">Personal Email Address</label>
                                            <input type="email" name="personalemail" class="form-control"
                                                value="{{ $userInfo->personalemail ?? '' }}"
                                                placeholder="Enter Personal Email address">
                                        </div>
                                    </div>
                                    <div class="col-md-4 pl-md-1">
                                        <div class="form-group">
                                            <label class="font-weight-600">Mobile Number</label>
                                            <input type="text" name="mobile_no" class="form-control"
                                                placeholder="Enter Mobile Number" value="{{ $userInfo->mobile_no ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 pr-md-1">
                                        <div class="form-group">
                                            <label class="font-weight-600">Date Of Birth</label>
                                            <input type="date" name="dateofbirth" class="form-control"
                                                value="{{ $userInfo->dateofbirth ?? '' }}"
                                                placeholder="Enter Date Of Birth">
                                        </div>
                                    </div>
                                    <!--   <div class="col-md-4 pl-md-1">
                                                            <div class="form-group">
                                                                <label class="font-weight-600">Qualification</label>
                                                                <input type="text" name="qualification" class="form-control" placeholder="Enter Qualification" value="{{ $userInfo->qualification ?? '' }}">
                                                            </div>
                                                        </div> -->
                                    <!-- <div class="col-md-4 pr-md-1">
                                                            <div class="form-group">
                                                                <label class="font-weight-600">Address Proof</label>
                                                                <input type="text" name="address_proof" class="form-control" placeholder="Enter Address Proof"
                                                                    value="{{ $userInfo->address_proof ?? '' }}">
                                                            </div>
                                                            
                                                        </div> -->
                                    <div class="col-md-2 pl-md-1">
                                        <div class="form-group">
                                            <label class="font-weight-600">Aadhaar No</label>
                                            <input type="text" name="adharcardnumber" class="form-control"
                                                placeholder="Enter Aadhaar No"
                                                value="{{ $userInfo->adharcardnumber ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4  pl-md-1">
                                        <div class="form-group">
                                            <label class="font-weight-600">Aadhaar Upload</label>
                                            <input type="file" name="aadharupload" class="form-control"
                                                placeholder="City" value="Mike">
                                        </div>
                                    </div>
                                    @if ($userInfo->aadharupload ?? '')
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label class="font-weight-600"></label><br><br>

                                                <a href="{{ url('backEnd/image/teammember/aadharupload/', $userInfo->aadharupload) }}"
                                                    target="blank" data-toggle="tooltip"
                                                    title="{{ $userInfo->aadharupload ?? '' }}"
                                                    class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-4 pr-md-1">
                                        <div class="form-group">
                                            <label class="font-weight-600">PAN No</label>
                                            <input type="text" name="pancardno" class="form-control"
                                                placeholder="Enter Pan No" value="{{ $userInfo->pancardno ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2 pl-md-1">
                                        <div class="form-group">
                                            <label class="font-weight-600">PAN Upload</label>
                                            <input type="file" name="panupload" class="form-control"
                                                placeholder="ZIP Code">
                                        </div>
                                    </div>
                                    @if ($userInfo->panupload ?? '')
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label class="font-weight-600"></label><br><br>

                                                <a href="{{ $userInfo->panupload }}" target="blank"
                                                    data-toggle="tooltip" title="{{ $userInfo->panupload ?? '' }}"
                                                    class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-md-2 pl-md-1">
                                        <div class="form-group">
                                            <label class="font-weight-600">Profile Picture</label>
                                            <input type="file" name="profilepic" class="form-control">
                                        </div>
                                    </div>
                                    @if ($userInfo->profilepic ?? '')
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label class="font-weight-600"></label><br><br>

                                                <a href="{{ $userInfo->profilepic }}" target="blank"
                                                    data-toggle="tooltip" title="{{ $userInfo->profilepic ?? '' }}"
                                                    class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <!--
                         @if ($userInfo->nda === null)
    <div class="row">
                                                        <div class="col-6 pl-md-1">
                                                            <div class="form-group">
                                                                <label class="font-weight-600">NDA (Non-Disclosure Agreement) *</label>
                                                                <input type="file" name="nda" required class="form-control"
                                                                    value="" />
                                                            </div>
                                                        </div>
                                                        <div class="col-6 pl-md-1">
                                                            <div class="form-group">
                                                                <label class="font-weight-600">NDA</label><br>
                                                               @if (
                                                                   $userInfo->role['rolename'] === 'Staff' ||
                                                                       ($userInfo->entity === 'K G Somani & Co LLP' && $userInfo->role['rolename'] === 'Intern'))
    <a download href="{{ url('backEnd/NDA-Trainee.pdf') }}" class="btn btn-success btn">
                                                                        <i class="fa fa-file-pdf-o"></i> Download
                                                                    </a>
@elseif($userInfo->entity == 'Capitall India Pvt. Ltd.')
    <a download href="{{ url('backEnd/NDA-Capitall.pdf') }}" class="btn btn-success btn">
                                                                    <i class="fa fa-file-pdf-o"></i> Download
                                                                </a>
@elseif($userInfo->entity == 'Womennovator')
    <a download href="{{ url('backEnd/NDA-Womennovator.pdf') }}" class="btn btn-success btn">
                                                                        <i class="fa fa-file-pdf-o"></i> Download
                                                                    </a>
@elseif($userInfo->entity == 'KGS Advisors LLP')
    <a download href="{{ url('backEnd/NDA-KgsAdvisors.pdf') }}" class="btn btn-success btn">
                                                                        <i class="fa fa-file-pdf-o"></i> Download
                                                                    </a>
@else
    <a download href="{{ url('backEnd/NDA-kgs.pdf') }}" class="btn btn-success btn">
                                                                    <i class="fa fa-file-pdf-o"></i> Download
                                                                </a>
    @endif
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
    @endif
                              -->
                                <div class="row row-sm">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="font-weight-600">Mother Name</label>
                                            <input type="text" name="mothername"
                                                value="{{ $userInfo->mothername ?? '' }}" class="form-control"
                                                placeholder="Enter Mother Name">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="font-weight-600">Mother Contact No. </label>
                                            <input type="text" name="mothernumber"
                                                value="{{ $userInfo->mothernumber ?? '' }}" class="form-control"
                                                placeholder="Enter Mother Contact No. ">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="font-weight-600">Father Name</label>
                                            <input type="text" name="fathername"
                                                value="{{ $userInfo->fathername ?? '' }}" class="form-control"
                                                placeholder="Enter Father Name">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="font-weight-600">Father Contact No. </label>
                                            <input type="text" name="fathernumber"
                                                value="{{ $userInfo->fathernumber ?? '' }}" class="form-control"
                                                placeholder="Enter Father Contact No. ">
                                        </div>
                                    </div>
                                </div>
                                <div class="row row-sm">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Joining Date</label>
                                            <input type="date" id="example-date-input" name="joining_date"
                                                value="{{ $userInfo->joining_date ?? '' }}" class="form-control"
                                                placeholder="Enter joining_date">
                                        </div>
                                    </div>
                                   <!-- <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Leaving Date</label>
                                            <input type="date" id="example-date-input" name="leavingdate"
                                                value="{{ $userInfo->leavingdate ?? '' }}" class="form-control"
                                                placeholder="Enter Leaving Date">
                                        </div>
                                    </div> -->
                                    <div class="col-md-4  pl-md-1">
                                        <div class="form-group">
                                            <label class="font-weight-600">Address Upload</label>
                                            <input type="file" name="addressupload" class="form-control"
                                                placeholder="City" value="Mike">
                                        </div>
                                    </div>
                                    @if ($userInfo->addressupload ?? '')
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label class="font-weight-600"></label><br><br>

                                                <a href="{{ $userInfo->addressupload }}" target="blank"
                                                    data-toggle="tooltip" title="{{ $userInfo->addressupload ?? '' }}"
                                                    class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-600">Permanent Address</label>
                                            <textarea rows="4" cols="80" name="permanentaddress" class="form-control"
                                                placeholder="Enter Permanent Address">{{ $userInfo->permanentaddress ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-600">Communication Address</label>
                                            <textarea rows="4" cols="80" name="communicationaddress" class="form-control"
                                                placeholder="Enter Communication Address">{{ $userInfo->communicationaddress ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div id="qulification_add">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-600">Qualification</label>
                                                <input type="text" class="form-control key" name="qualification[]"
                                                    id="key" value="" placeholder="Enter Qualification">
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label class="font-weight-600">Document</label>
                                                <input type="file" class="form-control key" name="document_file[]"
                                                    id="key" value="" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="form-group" style="margin-top: 36px;">
                                             <!--   <a href="javascript:void(0);" id="add_button" title="Add field"><img
                                                        src="{{ url('backEnd/image/add-icon.png') }}" /></a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                              <!--  <button type="submit" style="float:right;"
                                    class="btn btn-fill btn-primary">Save</button> -->
                            </div>
                            <br>
                        </form>
                    </div>
                    <br>
                    <div class="card">
                        @component('backEnd.components.alert')
                        @endcomponent
                        <div class="card-header" style="background: #37A000;margin-top: -17px;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 style="color: white" class="fs-17 font-weight-600 mb-0">Document Details</h6>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table display table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Qualification</th>
                                            <th>Document File</th>
                                            <!--<th>Action</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($teamqualification as $teamqualificationData)
                                            <tr>

                                                <td>{{ $teamqualificationData->qualification ?? '' }}</td>
                                                <td><a target="blank" target="blank" data-toggle="tooltip"
                                                        title="{{ $teamqualificationData->document_file }}"
                                                        href="{{ url('backEnd/image/teammember/document_file/' . $teamqualificationData->document_file ?? '') }}">
                                                        {{ $teamqualificationData->document_file ?? '' }}</a>
                                                </td>
                                                <!-- <td>
                                                        <a href="{{ url('qualification/delete/' . $teamqualificationData->id) }}"
                                                        onclick="return confirm('Are you sure you want to delete this item?');"
                                                        class="btn btn-danger-soft btn-sm"><i class="far fa-trash-alt"></i></a>
                                                    </td> -->
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                    <br>
                    <div class="card">
                        @component('backEnd.components.alert')
                        @endcomponent
                        <div class="card-header" style="background: #37A000;margin-top: -17px;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 style="color: white" class="fs-17 font-weight-600 mb-0">Bank Details</h6>
                                </div>
                                @if ($teamprofile != null)
                                    <div>
                                        <a class="btn btn-success"
                                            href="{{ url('teamprofile/' . $teamprofile->id . '/edit') }}">
                                            edit resume</a>
                                    </div>
                                @endif
                                <!--<div>
                                                    <a class="btn btn-success" href="{{ url('profileimage/' . Auth::user()->teammember_id) }}">Generate Id</a>
                                                    </div> -->
                            </div>
                        </div>
                        <form method="post" action="{{ url('userprofile/update') }}" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <ul>
                                    @foreach ($errors->all() as $e)
                                        <li style="color:red;">{{ $e }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6 pr-md-1">
                                        <div class="form-group">
                                            <label class="font-weight-600"> Name As Per Bank Account</label>
                                            <input type="text" name="nameasperbank" class="form-control"
                                                placeholder="Enter Benificiary Name"
                                                value="{{ $userInfo->nameasperbank ?? '' }}">

                                        </div>
                                    </div>
                                    <div class="col-md-6 pl-md-1">
                                        <div class="form-group">
                                            <label class="font-weight-600">Bank Name</label>
                                            <input type="text" name="nameofbank" class="form-control"
                                                placeholder="Enter Bank Details"
                                                value="{{ $userInfo->nameofbank ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 pr-md-1">
                                        <div class="form-group">
                                            <label class="font-weight-600">Bank Account Number</label>
                                            <input type="text" name="bankaccountnumber" class="form-control"
                                                placeholder="Enter Bank Account Number"
                                                value="{{ $userInfo->bankaccountnumber ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 pl-md-1">
                                        <div class="form-group">
                                            <label class="font-weight-600">IFSC Code</label>
                                            <input type="text" name="ifsccode"
                                                value="{{ $userInfo->ifsccode ?? '' }}" class="form-control"
                                                placeholder="Enter IFSC Code">
                                            <input hidden type="text" name="verify" value="1"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-2 pl-md-1">
                                        <div class="form-group">
                                            <label class="font-weight-600">Bank Proof </label>
                                            <input type="file" name="cancelcheque" class="form-control"
                                                placeholder="Enter IFSC Code">
                                        </div>
                                    </div>
                                    @if ($userInfo->cancelcheque ?? '')
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label class="font-weight-600"></label><br><br>

                                                <a href="{{ url('backEnd/image/teammember/cancelcheque/' . $userInfo->cancelcheque) }}"
                                                    target="blank" data-toggle="tooltip"
                                                    title="{{ $userInfo->cancelcheque ?? '' }}"
                                                    class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="row">


                                </div>
                                @if ($userInfo->verify != 1)
                                <!--    <div class="card-footer">
                                        <button type="submit" style="float:right;"
                                            class="btn btn-fill btn-primary">Please Verify</button>
                                    </div> -->
                                @else
                                 <!--   <div class="card-footer">
                                        <button style="float:right;" class="btn btn-fill btn-primary">Verified</button>
                                    </div> -->
                                @endif
                                <br>
                        </form>
                    </div>
                </div>
                @php
                    $totalFields = 23;
                    $filledFields = 0;

                    $filledFields += !empty($userInfo->id) ? 1 : 0;
                    $filledFields += !empty($userInfo->team_member) ? 1 : 0;
                    $filledFields += !empty($userInfo->staffcode) ? 1 : 0;
                    $filledFields += !empty($userInfo->emailid) ? 1 : 0;
                    $filledFields += !empty($userInfo->personalemail) ? 1 : 0;
                    $filledFields += !empty($userInfo->mobile_no) ? 1 : 0;
                    $filledFields += !empty($userInfo->dateofbirth) ? 1 : 0;
                    $filledFields += !empty($userInfo->adharcardnumber) ? 1 : 0;
                    $filledFields += !empty($userInfo->aadharupload) ? 1 : 0;
                    $filledFields += !empty($userInfo->pancardno) ? 1 : 0;
                    $filledFields += !empty($userInfo->panupload) ? 1 : 0;
                    $filledFields += !empty($userInfo->profilepic) ? 1 : 0;
                    $filledFields += !empty($userInfo->mothername) ? 1 : 0;
                    $filledFields += !empty($userInfo->mothernumber) ? 1 : 0;
                    $filledFields += !empty($userInfo->fathername) ? 1 : 0;
                    $filledFields += !empty($userInfo->fathernumber) ? 1 : 0;
                    $filledFields += !empty($userInfo->joining_date) ? 1 : 0;
                    // $filledFields += !empty($userInfo->leavingdate) ? 1 : 0; // 2
                    // $filledFields += !empty($userInfo->addressupload) ? 1 : 0; //1
                    $filledFields += !empty($userInfo->permanentaddress) ? 1 : 0;
                    $filledFields += !empty($userInfo->communicationaddress) ? 1 : 0;
                    // $filledFields += !empty($teamqualificationData->qualification) ? 1 : 0;//3
                    $filledFields += !empty($userInfo->nameasperbank) ? 1 : 0; //4
                    $filledFields += !empty($userInfo->nameofbank) ? 1 : 0;
                    $filledFields += !empty($userInfo->bankaccountnumber) ? 1 : 0;
                    $filledFields += !empty($userInfo->cancelcheque) ? 1 : 0;

                    $profileCompletionPercentage = ($filledFields / $totalFields) * 100;
                    $formattedProfileCompletion = number_format($profileCompletionPercentage, 2);
                @endphp
                <script>
                    $(document).ready(function() {
                        var profileCompletionPercentage = {{ $formattedProfileCompletion }};
                        var profileCompletionElement = $('#profileCompletion');

                        if (profileCompletionPercentage == 100) {
                            profileCompletionElement.text(profileCompletionPercentage + '%').css("color", "green");
                        } else {
                            profileCompletionElement.text(profileCompletionPercentage + '%').css("color", "red");
                        }
                    });
                </script>

            </div>
        </div>
        <!--/.body content-->
    </div>
    <!--/.main content-->
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {

        var count = 1;

        $(document).on('click', '#add_button', function() {
            count++;
            //$('#total_item').val(count);
            var html_code = '';
            html_code += '<div id="row_id_' + count + '">';
            html_code +=
                '<div class="row"><div class="col-md-6"> <div class="form-group"><input type="text" class="form-control key" name="qualification[]" id="qualification" value="" placeholder="Enter Qulification"></div></div>';
            html_code +=
                '<div class="col-md-5"> <div class="form-group"> <input type="file" class="form-control key" name="document_file[]" id="document_file" value=""></div></div><a style="margin-top: 9px;margin-left: 13px;" href="javascript:void(0);" class="remove_row" name="remove_row" id="' +
                count + '"><img src="{{ url('backEnd/image/remove-icon.png') }}"/></a></div>';
            html_code += '</div>';
            $('#qulification_add').append(html_code);
        });

        $(document).on('click', '.remove_row', function() {
            var row_id = $(this).attr("id");
            $('#row_id_' + row_id).remove();
            count--;
        });







    });
</script>
