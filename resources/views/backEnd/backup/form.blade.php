<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Title</label>
                <select class="form-control" id="exampleFormControlSelect1" name="title_id"
                @if(Request::is('teammember/*/edit'))> <option disabled
                style="display:block">Please Select One</option>

                @foreach($title as $titleData)
                <option value="{{$titleData->id}}"
                    {{$teammember->title->id== $titleData->id??'' ?'selected="selected"' : ''}}>
                    {{$titleData->title }}</option>
                @endforeach


                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($title as $titleData)
                <option value="{{$titleData->id}}">
                    {{ $titleData->title }}</option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Team Member</label>
            <input type="text" name="team_member" value="{{ $teammember->team_member ?? ''}}" class="form-control"
                placeholder="Enter team member">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Mobile No.</label>
            <input type="text" name="mobile_no" value="{{ $teammember->mobile_no ?? ''}}" class="form-control"
                placeholder="Enter mobile no">
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Email Id.</label>
            <input type="email" name="emailid" value="{{ $teammember->emailid ?? ''}}" class="form-control"
                placeholder="Enter Email">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Profilepic</label>
            <input type="file" name="profilepic" value="{{ $teammember->profilepic ?? ''}}" class="form-control"
                placeholder="Enter Profilepic">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <img alt="Responsive image" style="width:40%"  id="profile-img-tag"
                @if(Request::is('teammember/*/edit')) src="{{ $teammember->profilepic ?? ''}}" @endif>
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Father Name</label>
            <input type="text" name="fathername" value="{{ $teammember->fathername ?? ''}}" class="form-control"
                placeholder="Enter fathername">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Date of Birth</label>
            <input type="date" id="example-date-input" name="dateofbirth" value="{{ $teammember->dateofbirth ?? ''}}" class="form-control"
                placeholder="Enter dateofbirth">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Team Level</label>
            <select class="form-control" id="exampleFormControlSelect1" name="teamlevel_id"
            @if(Request::is('teammember/*/edit'))> <option disabled
            style="display:block">Please Select One</option>

            @foreach($teamlevel as $teamlevelData)
            <option value="{{$teamlevelData->id}}"
                {{$teammember->teamlevel->id== $teamlevelData->id??'' ?'selected="selected"' : ''}}>
                {{$teamlevelData->title }}</option>
            @endforeach


            @else
            <option></option>
            <option value="">Please Select One</option>
            @foreach($teamlevel as $teamlevelData)
            <option value="{{$teamlevelData->id}}">
                {{ $teamlevelData->title }}</option>

            @endforeach
            @endif
        </select>
        </div>
    </div>
</div>
<div class="row row-sm">

    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Address Proof</label>
            <input type="text" name="address_proof" value="{{ $teammember->address_proof ?? ''}}" class="form-control"
                placeholder="Enter address_proof">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Address Upload</label>
            <input type="file" name="addressupload" value="{{ $teammember->addressupload ?? ''}}" class="form-control"
                placeholder="Enter address_upload">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <img alt="Responsive image" style="width:40%"  id="profile-img-tag"
                @if(Request::is('teammember/*/edit')) src="{{ $teammember->addressupload ?? ''}}" @endif>
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Pan Card No.</label>
            <input type="text" name="pancardno" value="{{ $teammember->pancardno ?? ''}}" class="form-control"
                placeholder="Enter pancardno">
        </div>
    </div>
   
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Pan Upload</label>
            <input type="file" name="panupload" value="{{ $teammember->panupload ?? ''}}" class="form-control"
                placeholder="Enter panupload">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <img alt="Responsive image" style="width:40%"  id="profile-img-tag"
                @if(Request::is('teammember/*/edit')) src="{{ $teammember->panupload ?? ''}}" @endif>
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Team lead</label>
            <input type="text" name="teamlead" value="{{ $teammember->teamlead ?? ''}}" class="form-control"
                placeholder="Enter teamlead">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Qualification</label>
            <input type="text" name="qualification" value="{{ $teammember->qualification ?? ''}}" class="form-control"
                placeholder="Enter qualification">
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Permanent Address</label>
            <input type="text" name="permanentaddress" value="{{ $teammember->permanentaddress ?? ''}}" class="form-control"
                placeholder="Enter permanentaddress">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Communication Address</label>
            <input type="text" name="communicationaddress" value="{{ $teammember->communicationaddress ?? ''}}" class="form-control"
                placeholder="Enter communicationaddress">
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Joining Date</label>
            <input type="date" id="example-date-input" name="joining_date" value="{{ $teammember->joining_date ?? ''}}" class="form-control"
                placeholder="Enter joining_date">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Date of Resign</label>
            <input type="date" id="example-date-input" name="dateofresign" value="{{ $teammember->dateofresign ?? ''}}" class="form-control"
                placeholder="Enter dateofresign">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Status</label>
            <select name="status" id="exampleFormControlSelect1" class="form-control">
                <!--placeholder-->
                @if(Request::is('teammember/*/edit')) >
                @if($teammember->status=='1')
                <option value="1">Active</option>
                <option value="2">Inactive</option>


                @else
                <option value="2">Inactive</option>
                <option value="1">Active</option>

                @endif
                @else

                <option value="1">Active</option>
                <option value="2">Inactive</option>
                @endif
            </select>
        </div>
    </div>
</div>

<button type="submit" class="btn btn-success">Submit</button>
