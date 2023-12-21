<div class="row row-sm">
  <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">CLIENT_NAME. *</label>
            <input type="text" id="example-date-input" name="Name" value="{{ $appointmentletter->Name ?? ''}}" class="form-control"
            placeholder="Enter Client Name">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Nature of service. *</label>
            <input type="text" id="example-date-input" name="Nature_of_service" value="{{ $appointmentletter->Nature_of_service ?? ''}}" class="form-control"
            placeholder="Enter Nature of service">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Financial Year </label>
            <input type="text" id="example-date-input" name="Financial_Year" value="{{ $appointmentletter->Financial_Year ?? ''}}" class="form-control"
                placeholder="Enter Financial Year .">
        </div>
        </div>
         
</div>
<div class="row row-sm">
  <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Appointment start date. *</label>
            <input type="date" id="example-date-input" name="Appointment_start_date" value="{{ $appointmentletter->Appointment_start_date ?? ''}}" class="form-control"
            placeholder="Enter Appointment start date">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Appointment end date. *</label>
            <input type="date" id="example-date-input" name="Appointment_end_date" value="{{ $appointmentletter->Appointment_end_date ?? ''}}" class="form-control"
            placeholder="Enter Appointment end date">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Period of Appointment </label>
            <input type="text" id="example-date-input" name="Period_of_Appointment" value="{{ $appointmentletter->Period_of_Appointment ?? ''}}" class="form-control"
                placeholder="Enter Period of Appointment .">
        </div>
        </div>
       
</div>
<div class="row row-sm">
  <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Types of Industry. *</label>
            <input type="text" id="example-date-input" name="types_of_industry" value="{{ $appointmentletter->types_of_industry ?? ''}}" class="form-control"
            placeholder="Enter types of industry">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Attachment. *</label>
            <input type="file" id="example-date-input" name="attachment" value="{{ $appointmentletter->attachment ?? ''}}" class="form-control"
            placeholder="Enter Attachment">
        </div>
    </div>
	   <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Assign *</label>
            <select class="language form-control"  name="teammember_id" @if(Request::is('appointmentletter/*/edit'))>
                <option disabled style="display:block">Please Select One</option>

                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}" @if(($appointmentletter->teammember_id) == $teammemberData->id) selected
                    @endif>
                    {{ $teammemberData->title->title }}. {{ $teammemberData->team_member }}
                </option>
                @endforeach


                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}">
                    {{ $teammemberData->team_member }}</option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('appointmentletter') }}">
        Back</a>

</div>
