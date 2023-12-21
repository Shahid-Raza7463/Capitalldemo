<div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Client *</label>
            <select class="language form-control" id="exampleFormControlSelect1" name="client_id"
                @if(Request::is('assignmentbudgeting/*/edit'))> <option disabled style="display:block">Please Select One
                </option>

                @foreach($client as $clientData)
                <option value="{{$clientData->id}}"
                    {{$assignmentbudgeting->client->id== $clientData->id??'' ?'selected="selected"' : ''}}>
                    {{$clientData->client_name }}</option>
                @endforeach


                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($client as $clientData)
                <option value="{{$clientData->id}}">
                    {{ $clientData->client_name }} </option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Assignment *</label>
            <select class="form-control" id="exampleFormControlSelect1" name="assignment_id"
                @if(Request::is('assignmentbudgeting/*/edit'))> <option disabled style="display:block">Please Select One
                </option>

                @foreach($assignment as $assignmentData)
                <option value="{{$assignmentData->id}}"
                    {{$assignmentbudgeting->assignment->id== $assignmentData->id??'' ?'selected="selected"' : ''}}>
                    {{$assignmentData->assignment_name }}</option>
                @endforeach


                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($assignment as $assignmentData)
                <option value="{{$assignmentData->id}}">
                    {{ $assignmentData->assignment_name }}</option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
	   <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Assignment Name</label>
            <input required type="text" name="assignmentname" value="{{ $assignmentbudgeting->assignmentname ?? ''}}"
                class=" form-control" placeholder="Enter Assignment Name">
        </div>
    </div>
  <!--  <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Billing Frequency *</label>
            <select class="form-control" id="exampleFormControlSelect1" name="billingfrequency">
                <option value="">Please Select One</option>
                <option value="0">Monthly</option>
                <option value="1">Quarterly</option>
                <option value="2">Half Yearly</option>
                <option value="3">Yearly</option>
				<option value="4">One Time</option>

            </select>
        </div>
    </div>-->

</div>
<div class="row row-sm">
	   <!-- <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Billing Amount</label>
            <input required type="text" name="billlingamount" value="{{ $assignmentbudgeting->billing_amount ?? ''}}"
                class=" form-control" placeholder="Enter Billing Amount">
        </div>
    </div> -->
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Due Date</label>
            <input type="date" required id="example-date-input" name="duedate" value="{{ $assignmentbudgeting->date ?? ''}}"
                class=" form-control" placeholder="Enter Date" required>
        </div>
    </div>
    <!--<div class="col-4">
        <div class="form-group">
            <label class="font-weight-600"> Expected Draft Report Date</label>
            <input type="date" required id="example-date-input" name="draftreportdate" value="{{ $assignmentbudgeting->draftreportdate ?? ''}}"
                class=" form-control" placeholder="Enter Billing Amount">
        </div>
    </div>  -->
  <!--  <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Bill Date</label>
            <input type="date" id="example-date-input" name="billdate" value="{{ $assignmentbudgeting->billdate ?? ''}}"
                class=" form-control" placeholder="Enter Date">
        </div>
    </div> -->
</div>
<!--<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Expected Final Report Date</label>
            <input type="date" required id="example-date-input" name="finalreportdate" value="{{ $assignmentbudgeting->finalreportdate ?? ''}}"
                class=" form-control" placeholder="Enter Date">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Money Received Date</label>
            <input type="date" id="example-date-input" name="moneyreceiveddate" value="{{ $assignmentbudgeting->moneyreceiveddate ?? ''}}"
                class=" form-control" placeholder="Enter Date">
        </div>
    </div>
</div>-->
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('assignmentbudgeting') }}">
        Back</a>

</div>
