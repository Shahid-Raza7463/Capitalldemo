<div class="row row-sm">
  <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Company Name. *</label>
            <input type="text" id="example-date-input" name="companyname" value="{{ $profile->companyname ?? ''}}" class="form-control"
            placeholder="Enter Company Name">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Service. *</label>
            <input type="text" id="example-date-input" name="service" value="{{ $profile->service ?? ''}}" class="form-control"
            placeholder="Enter Service">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Sent Date </label>
            <input type="date" id="example-date-input" name="sentdate" value="{{ $profile->sentdate ?? ''}}" class="form-control"
                placeholder="Enter Sent Date .">
        </div>
        </div>
         
</div>
<div class="row row-sm">
        @if(Auth::user()->role_id == 11 || Auth::user()->role_id == 12)
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Staff *</label>
            <select  class="language form-control" id="exampleFormControlSelect1" name="teammember_id"
            @if(Request::is('profile/*/edit'))> <option disabled style="display:block">Please Select One</option>

            @foreach($teammember as $teammemberData)
            <option value="{{$teammemberData->id}}"
                {{$profile->teammemberid== $teammemberData->id??'' ?'selected="selected"' : ''}}>
                {{$teammemberData->team_member }}( {{$teammemberData->role->rolename }} )</option>
            @endforeach


            @else
            <option></option>
            <option value="">Please Select One</option>
            @foreach($teammember as $teammemberData)
            <option value="{{$teammemberData->id}}">
                {{ $teammemberData->team_member }}  ( {{$teammemberData->role->rolename }} )</option>

            @endforeach
            @endif
        </select>
        </div>
    </div>
    @endif
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Attachment</label>
            <input type="file" id="profile-img" name="attachment" value="{{ $profile->attachment ?? ''}}" class="form-control"
                placeholder="Enter Profile Pic">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <img alt="Responsive image" style="width:40%"  id="profile-img-tag"
                @if(Request::is('attachment/*/edit')) src="{{ $profile->attachment ?? ''}}" @endif>
        </div>
    </div>
 
   </div>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('profile') }}">
        Back</a>

</div>
