<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Team Member List</label>
                <select class="language form-control" id="aircraft_name"  name="teammember_id"
                @if(Request::is('teamlogin/*/edit'))> <option disabled
                style="display:block">Please Select One</option>

                @foreach($teammemberlist as $teammemberlistData)
                <option value="{{$teammemberlistData->id}}"
                    {{$teammember->teammemberlist->id== $teammemberlistData->id??'' ?'selected="selected"' : ''}}>
                    {{$teammemberlistData->teammemberlist }}</option>
                @endforeach


                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($teammemberlist as $teammemberlistData)
                <option value="{{$teammemberlistData->emailid}}">
                    {{ $teammemberlistData->team_member }}</option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Login Name</label>
            <input type="text" readonly name="email" id="aircraft_id" value="{{ $teammember->email ?? ''}}" class="form-control"
                placeholder="Enter Email">
        </div>
    </div>
   <!-- <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Password.</label>
            <input type="password" required name="password" value="{{ $teammember->password ?? ''}}" class="form-control"
                placeholder="Enter Password">
        </div>
    </div>-->

</div>

<button type="submit" class="btn btn-success">Submit</button>

