
<div class="row row-sm">
<div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Team Member </label>
            <select class="form-control basic-multiple" name="teammember_id" 
            @if(Request::is('staffappointmentletter/*/edit'))> <option
                disabled style="display:block">Please Select One</option>

                @foreach($teammember as $teamData)
                <option value="{{$teamData->id}}"
                    {{$staffappointment->teammember_id == $teamData->id ??'' ?'selected="selected"' : ''}}>
                    {{$teamData->team_member }}( {{ $teamData->role->rolename}} )</option>
                @endforeach

                @else
                <option value="">Please Select One</option>
                @foreach($teammember as $teamData)
                <option value="{{$teamData->id}}">
                    {{ $teamData->team_member }}( {{ $teamData->role->rolename}} )</option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
	 <div class="col-4">
        <div class="form-group">
        <label class="font-weight-600">Appointment Letter Date </label>
        <input type="date" name="appointmentletterdate" class="form-control" value="{{ $staffappointment->appointmentletterdate ??'' }}"
            placeholder="">  
        </div>
    </div>
    <div class="col-4">
    <div class="form-group">
        <label class="font-weight-600">Designation</label>
        <input type="text" name="designation" class="form-control" value="{{ $staffappointment->designation ??'' }}"
            placeholder="Enter Designation">
    </div>
</div>
</div>
<div class="row row-sm">
<div class="col-4">
        <div class="form-group">
        <label class="font-weight-600">Employee Effective Date</label>
        <input type="date" name="employeeeffectivedate" class="form-control" value="{{ $staffappointment->employeeeffectivedate ??'' }}"
            placeholder="Enter Employee Effective Date">  
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
        <label class="font-weight-600">Organization</label>
        <select class="form-control basic-multiple" name="organization" 
            @if(Request::is('staffappointmentletter/*/edit'))> <option
                disabled style="display:block">Please Select One</option>

                @foreach($organization as $organizationData)
                <option value="{{$organizationData->id}}"
                    {{$staffappointment->organizationid == $organizationData->id ??'' ?'selected="selected"' : ''}}>
                    {{$organizationData->company_name }}</option>
                @endforeach

                @else
                <option value="">Please Select One</option>
                @foreach($organization as $organizationData)
                <option value="{{$organizationData->id}}">
                    {{ $organizationData->company_name }}</option>

                @endforeach
                @endif
            </select> 
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
        <label class="font-weight-600">Location</label>
        <input type="text" name="location" class="form-control" value="{{ $staffappointment->location ??'' }}"
            placeholder="Enter Location">  
        </div>
    </div>
</div>
<div class="row row-sm">
<div class="col-4">
        <div class="form-group">
        <label class="font-weight-600">Salary</label>
        <input type="text" name="salary" class="form-control" value="{{ $staffappointment->salary ??'' }}"
            placeholder="Enter Salary">  
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
        <label class="font-weight-600">Salary Remarks</label>
        <input type="text" name="salaryremarks" class="form-control" value="{{ $staffappointment->salaryremarks ??'' }}"
            placeholder="Enter Salary Remarks">  
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
        <label class="font-weight-600">Notice Period</label>
        <input type="number" name="noticeperiod" class="form-control" value="{{ $staffappointment->noticeperiod ??'' }}"
            placeholder="Enter Notice Period">  
        </div>
    </div>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('/staffappointmentletter') }}">
        Back</a>

</div>

