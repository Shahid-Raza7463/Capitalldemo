<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600"> Client *</label>
            <select required class="language form-control"  id="ganttchart_id" name="ganttchart_id"
            @if(Request::is('staffrequest/*/edit'))> <option disabled
            style="display:block">Please Select One</option>

            @foreach($teammember as $stateData)
            <option value="{{$stateData->id}}"
            @if(($staffrequest->leadpartner) == $stateData->id) selected @endif>
                {{ $stateData->title->title }}. {{ $stateData->team_member }}</option>
            @endforeach


            @else
            <option></option>
            <option value="">Please Select One</option>
            @foreach($ganttchart as $ganttchartData)
            <option value="{{$ganttchartData->id}}">
                {{ $ganttchartData->name }}</option>

            @endforeach
            @endif
        </select>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">No of Staff *</label>
            <input required type="number" name="noofstaff" value="{{ $staffrequest->noofstaff ?? ''}}" class="form-control"
                placeholder="Enter No of Staff">
        </div>
    </div>
  
</div>
<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Start Date</label>
            <input required type="date" id="example-date-input" name="startdate" value="{{ $staffrequest->startdate ?? ''}}"
            class="form-control" placeholder="Enter Associated From">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">End Date *</label>
            <input required type="date" id="example-date-input" name="enddate" value="{{ $staffrequest->enddate ?? ''}}"
                class="form-control" placeholder="Enter Associated From">
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Reason</label>
            <textarea  required rows="4" name="comment" value="{{ $staffrequest->comment ?? ''}}" class="form-control"
                placeholder="Enter Comment">{!! $staffrequest->comment ??'' !!}</textarea>
        </div>
    </div>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('staffrequest') }}">
        Back</a>

</div>
