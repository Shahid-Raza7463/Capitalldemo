<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Date of Successful Call <span class="tx-danger">*</span></label>
            <input type="date" name="Date_of_Successful_Call" value="{{ $pbd->Date_of_Successful_Call ?? ''}}" class="form-control"
                placeholder="Enter Date of Successful Call">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Contact Name <span class="tx-danger">*</span></label>
            <input type="text" name="Contact_Name" value="{{ $pbd->Contact_Name ?? ''}}" class="form-control"
                placeholder="Enter Contact Name">
        </div>
    </div>

    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Company  <span class="tx-danger">*</span></label>
            <input type="text" name="company" value="{{ $pbd->company ?? ''}}" class="form-control"
                placeholder="Enter Company">
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Designation <span class="tx-danger">*</span></label>
            <input type="text" name="Designation" value="{{ $pbd->Designation ?? ''}}" class="form-control"
                placeholder="Enter Designation">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Minutes of the meeting/Call <span class="tx-danger">*</span></label>
            <input type="text" name="minutes_of__the_meeting" value="{{ $pbd->minutes_of_the_meeting ?? ''}}" class="form-control"
                placeholder="Enter Minutes of the meeting/Call">
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Short Term Business Opportunity <span class="tx-danger">*</span></label>
            <input type="text" name="short_time_business" value="{{ $pbd->short_time_business ?? ''}}" class="form-control"
                placeholder="Enter Short Term Business Opportunity">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Indicative date for next follow-up <span class="tx-danger">*</span></label>
            <input type="date" name="Indicative_date_for_next_follow_up" value="{{ $pbd->Indicative_date_for_next_follow_up ?? ''}}" class="form-control"
                placeholder="Enter Indicative date for next follow-up">
        </div>
    </div>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('pbd') }}">
        Back</a>

</div>
