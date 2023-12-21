<div class="row row-sm">
    <div class="col-2">
        <div class="form-group">
            <label class="font-weight-600">Title <span class="tx-danger">*</span></label>
            <select class="form-control" id="exampleFormControlSelect1" name="title_id"
                @if (Request::is('teammember/*/edit')) > <option disabled
                style="display:block">Please Select One</option>

                @foreach ($title as $titleData)
                <option value="{{ $titleData->id }}"
                    {{ $teammember->title_id == $titleData->id ?? '' ? 'selected="selected"' : '' }}>
                    {{ $titleData->title }}</option>
                @endforeach


                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach ($title as $titleData)
                <option value="{{ $titleData->id }}">
                    {{ $titleData->title }}</option>

                @endforeach @endif
                </select>
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Name <span class="tx-danger">*</span></label>
            <input type="text" name="team_member" value="{{ $teammember->team_member ?? '' }}" class="form-control"
                placeholder="Enter Team Member">
        </div>
    </div>
    <div class="col-2">
        <div class="form-group">
            <label class="font-weight-600">Mobile No <span class="tx-danger">*</span></label>
            <input type="text" name="mobile_no" value="{{ $teammember->mobile_no ?? '' }}" class="form-control"
                placeholder="Enter Mobile No">
        </div>
    </div>
    <div class="col-2">
        <div class="form-group">
            <label class="font-weight-600">Emergency Mobile No <span class="tx-danger">*</span></label>
            <input type="text" name="emergencycontactnumber" value="{{ $teammember->emergencycontactnumber ?? '' }}"
                class="form-control" placeholder="Enter Emergency Mobile No">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Entity<span class="tx-danger">*</span></label>
            <select class="form-control" id="entitySelect" name="entity">
                <option disabled value="">Please Select An Entity</option>
                <option value="K G Somani & Co LLP"
                    {{ ($teammember ?? null) && $teammember->entity == 'V. SANKAR AIYAR & CO' ? 'selected' : '' }}>V.
                    SANKAR AIYAR & CO</option>
                <!--  <option value="CapiTall India Pvt. Ltd." {{ ($teammember ?? null) && $teammember->entity == 'Capitall India Pvt. Ltd.' ? 'selected' : '' }}>CapiTall India Pvt. Ltd.</option>
                <option value="KGS Advisors LLP" {{ ($teammember ?? null) && $teammember->entity == 'KGS Advisors LLP' ? 'selected' : '' }}>KGS Advisors LLP</option>
                <option value="Womennovator" {{ ($teammember ?? null) && $teammember->entity == 'Womennovator' ? 'selected' : '' }}>Womennovator</option> -->
            </select>
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Email Id <span class="tx-danger">*</span></label>
            <input type="email" name="emailid" value="{{ $teammember->emailid ?? '' }}" class="form-control"
                placeholder="Enter Email">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Personal Email Id <span class="tx-danger">*</span></label>
            <input type="email" name="personalemail" value="{{ $teammember->personalemail ?? '' }}"
                class="form-control" placeholder="Enter Email">
        </div>
    </div>

    <div class="col-2">
        <div class="form-group">
            <label class="font-weight-600">Gender</label>
            <select name="gender" id="exampleFormControlSelect1" class="form-control">
                <!--placeholder-->
                @if (Request::is('teammember/*/edit')) >
                    @if ($teammember->gender == 'Male')
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    @elseif($teammember->gender == 'Female')
                        <option value="Female">Female</option>
                        <option value="Male">Male</option>
                    @else
                        <option value="">Please select one</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    @endif
                @else
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                @endif
            </select>
        </div>
    </div>
    <div class="col-2">
        <div class="form-group">
            <label class="font-weight-600">Profilepic</label>
            <input type="file" name="profilepic" value="{{ $teammember->profilepic ?? '' }}" class="form-control"
                placeholder="Enter Profile Pic">
        </div>
    </div>
    <div class="col-2">
        <!--
        <div class="form-group">
            <img alt="Responsive image" style="width:40%"  id="profile-img-tag"
                @if (Request::is('teammember/*/edit')) src="{{ $teammember->profilepic ?? '' }}" @endif>
        </div> -->
    </div>
</div>
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Department</label>
            <input type="text" name="department" value="{{ $teammember->department ?? '' }}" class="form-control"
                placeholder="Enter Department">
        </div>
    </div>
    <!--
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Father Name</label>
            <input type="text" name="fathername" value="{{ $teammember->fathername ?? '' }}" class="form-control"
                placeholder="Enter Father Name">
        </div>
    </div>-->
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Date of Birth</label>
            <input type="date" id="example-date-input" name="dateofbirth"
                value="{{ $teammember->dateofbirth ?? '' }}" class="form-control" placeholder="Enter dateofbirth">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600"><b>Assign Role <span class="tx-danger">*</span></b></label>
            <select class="form-control" required id="exampleFormControlSelect1" name="role_id"
                @if (Request::is('teammember/*/edit')) > <option disabled
            style="display:block">Please Select One</option>

            @foreach ($teamrole as $teamroleData)
            <option value="{{ $teamroleData->id }}"
                {{ $teammember->role->id == $teamroleData->id ?? '' ? 'selected="selected"' : '' }}>
                {{ $teamroleData->rolename }}</option>
            @endforeach


            @else
            <option></option>
            <option value="">Please Select One</option>
            @foreach ($teamrole as $teamroleData)
            <option value="{{ $teamroleData->id }}">
                {{ $teamroleData->rolename }}</option>

            @endforeach @endif
                </select>
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Aadhaar Number</label>
            <input type="text" name="adharcardnumber" value="{{ $teammember->adharcardnumber ?? '' }}"
                class="form-control" placeholder="Enter Aadhaar Number">
        </div>
    </div>


    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Address Proof</label>
            <input type="text" name="address_proof" value="{{ $teammember->address_proof ?? '' }}"
                class="form-control" placeholder="Enter Address Proof">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Address Upload</label>
            <input type="file" name="addressupload" value="{{ $teammember->addressupload ?? '' }}"
                class="form-control" placeholder="Enter address_upload">
        </div>
    </div>
    <div class="col-3">
        <!--
        <div class="form-group">
            <img alt="Responsive image" style="width:40%"  id="profile-img-tag"
                @if (Request::is('teammember/*/edit')) src="{{ $teammember->addressupload ?? '' }}" @endif>
        </div> -->
    </div>
</div>
<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Pan Card No <span class="tx-danger">*</span></label>
            <input type="text" name="pancardno" value="{{ $teammember->pancardno ?? '' }}" class="form-control"
                placeholder="Enter Pan Card No.">
        </div>
    </div>

    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Pan Upload</label>
            <input type="file" name="panupload" value="{{ $teammember->panupload ?? '' }}" class="form-control"
                placeholder="Enter panupload">
        </div>
    </div>
    <div class="col-3">
        <!--
        <div class="form-group">
            <img alt="Responsive image" style="width:40%"  id="profile-img-tag"
                @if (Request::is('teammember/*/edit')) src="{{ $teammember->panupload ?? '' }}" @endif>
        </div> -->
    </div>
</div>
<div class="row row-sm">
    <div class="col-2">
        <div class="form-group">
            <label class="font-weight-600">Appointment Letter </label>
            <input type="file" name="appointment_letter" value="{{ $teammember->appointment_letter ?? '' }}"
                class="form-control" placeholder="Enter address_upload">
        </div>
    </div>
    <!--
 <div class="col-2">
        <div class="form-group">
            <label class="font-weight-600">NDA </label>
            <input type="file" name="nda" value="{{ $teammember->nda ?? '' }}" class="form-control"
                placeholder="Enter NDA">
        </div>
    </div>
    <div class="col-2">
        <div class="form-group">
            <label class="font-weight-600">Team lead</label>
            <input type="text" name="teamlead" value="{{ $teammember->teamlead ?? '' }}" class="form-control"
                placeholder="Enter Team lead">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Qualification</label>
            <input type="text" name="qualification" value="{{ $teammember->qualification ?? '' }}" class="form-control"
                placeholder="Enter Qualification">
        </div>
    </div>-->
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Designation</label>
            <input type="text" name="designation" value="{{ $teammember->designation ?? '' }}"
                class="form-control" placeholder="Enter Designation">
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Permanent Address</label>
            <input type="text" name="permanentaddress" value="{{ $teammember->permanentaddress ?? '' }}"
                class="form-control" placeholder="Enter Permanent Address">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Communication Address</label>
            <input type="text" name="communicationaddress" value="{{ $teammember->communicationaddress ?? '' }}"
                class="form-control" placeholder="Enter Communication Address">
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Mother Name</label>
            <input type="text" name="mothername" value="{{ $teammember->mothername ?? '' }}"
                class="form-control" placeholder="Enter Mother Name">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Mother Number </label>
            <input type="text" name="mothernumber" value="{{ $teammember->mothernumber ?? '' }}"
                class="form-control" placeholder="Enter Mother Number">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Father Name</label>
            <input type="text" name="fathername" value="{{ $teammember->fathername ?? '' }}"
                class="form-control" placeholder="Enter Father Name">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Father Number </label>
            <input type="text" name="fathernumber" value="{{ $teammember->fathernumber ?? '' }}"
                class="form-control" placeholder="Enter Father Number">
        </div>
    </div>
</div>


<div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Name As Per Bank Account</label>
            <input type="text" name="nameasperbank" value="{{ $teammember->nameasperbank ?? '' }}"
                class="form-control" placeholder="Enter Name As Per Bank Account">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Bank Name</label>
            <input type="text" name="nameofbank" value="{{ $teammember->nameofbank ?? '' }}"
                class="form-control" placeholder="Enter Permanent Address">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Bank Account Number</label>
            <input type="text" name="bankaccountnumber" value="{{ $teammember->bankaccountnumber ?? '' }}"
                class="form-control" placeholder="Enter Permanent Address">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">IFSC Code</label>
            <input type="text" name="ifsccode" value="{{ $teammember->ifsccode ?? '' }}" class="form-control"
                placeholder="Enter Permanent Address">
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Joining Date</label>
            <input type="date" id="example-date-input" name="joining_date"
                value="{{ $teammember->joining_date ?? '' }}" class="form-control" placeholder="Enter joining_date">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Leaving Date</label>
            <input type="date" id="example-date-input" name="leavingdate"
                value="{{ $teammember->leavingdate ?? '' }}" class="form-control leaveDate"
                placeholder="Enter Leaving Date">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Date of Resign</label>
            <input type="date" id="example-date-input" name="dateofresign"
                value="{{ $teammember->dateofresign ?? '' }}" class="form-control" placeholder="Enter dateofresign">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Status</label>
            <select name="status" id="exampleFormControlSelect1" class="form-control">
                <!--placeholder-->
                @if (Request::is('teammember/*/edit')) >
                    @if ($teammember->status == '0')
                        <option value="0">InActive</option>
                        <option value="1">Active</option>
                    @else
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    @endif
                @else
                    <option value="0">InActive</option>
                    <option value="1">Active</option>
                @endif
            </select>
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Location <span class="tx-danger"></span></label>
            <input type="text" name="location" value="{{ $teammember->location ?? '' }}" class="form-control"
                placeholder="Enter Location">
        </div>
    </div>

    <!-- <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600"><b>Mentor <span class="tx-danger"></span></b></label>
            <select class="form-control" id="exampleFormControlSelect1" name="mentor_id"
            @if (Request::is('teammember/*/edit')) > <option 
            style="display:block" value="0">Please Select One</option>

            @foreach ($mentor as $teamroleData)
            <option value="{{ $teamroleData->id }}"
                {{ $teammember->mentor_id == $teamroleData->id ?? '' ? 'selected="selected"' : '' }}>
                {{ $teamroleData->team_member }} ( {{ $teamroleData->rolename }} )  </option>
            @endforeach


            @else
           
            <option value="0"></option>
				<option value="0">Please Select One</option>
            @foreach ($mentor as $teamroleData)
            <option value="{{ $teamroleData->id }}">
                {{ $teamroleData->team_member }} ( {{ $teamroleData->rolename }} ) </option>

            @endforeach @endif
        </select>
        </div>
    </div> -->

</div>

<br>

<div class="row">
    <div class="col-12 ">
        <h5 class="mt-1"><b>Qualifications</b></h5>
    </div>
</div>
<hr>
<div id="qulification_add">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="font-weight-600">Qualifications</label>
                <input type="text" class="form-control key" name="qualification[]" id="key" value=""
                    placeholder="Enter Qualification">
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label class="font-weight-600">Document</label>
                <input type="file" class="form-control key" name="document_file[]" id="key" value=""
                    placeholder="">
            </div>
        </div>
        <div class="col-1">
            <div class="form-group" style="margin-top: 36px;">
                <a href="javascript:void(0);" id="add_button" title="Add field"><img
                        src="{{ url('backEnd/image/add-icon.png') }}" /></a>
            </div>
        </div>
    </div>
</div>
<br>
@if (Request::is('teammember/*/edit'))
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
@endif

<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('teammember') }}">
        Back</a>

</div>

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
                '<div class="row"><div class="col-md-6"> <div class="form-group"><label class="font-weight-600">Qualification</label><input type="text" class="form-control key" name="qualification[]" id="qualification" value="" placeholder="Enter Qulification"></div></div>';
            html_code +=
                '<div class="col-md-5"> <div class="form-group"><label class="font-weight-600">Document</label> <input type="file" class="form-control key" name="document_file[]" id="document_file" value=""></div></div><a style="margin-top: 9px;margin-left: 13px;" href="javascript:void(0);" class="remove_row" name="remove_row" id="' +
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
