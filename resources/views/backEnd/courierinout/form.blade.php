<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Type</label>
            <select class="form-control key" id="type" name="type">
                <option value="">Please Select One</option>
                <option value="0">Sender</option>
                <option value="1">Receiver</option>
            </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Courier / Item Name</label>
            <input type="text" name="courier_item_name" placeholder="Enter Courier / Item name" value=""
                class="form-control">
        </div>
    </div>
	  <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Attachment</label>
            <input type="file" name="attachment" placeholder="Enter Courier / Item name" value=""
                class="form-control">
        </div>
    </div>
</div>
<div class="row row-sm" id="sender" style="display: none">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Assigned to</label>
            <select class="language form-control" id="keys" name="assignedto">

                <option value="">Please Select One</option>
                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}" @if(!empty($courierinout->
                    assignedto) && $courierinout->
                    assignedto==$teammemberData->id) selected @endif>
                    {{ $teammemberData->team_member }} (
                    {{ $teammemberData->role->rolename }} )</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Priority</label>
            <select class="form-control key" name="priority">
                <option value="">Please Select One</option>
                <option value="0">Urgent</option>
                <option value="1">Normal</option>
            </select>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Tracking No</label>
            <input type="text" name="tracking" placeholder="Enter Tracking No" value="" class="form-control">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Address</label>
            <textarea type="text" name="address" placeholder="Enter Address" value="" class="form-control"></textarea>
        </div>
    </div>
</div>
<div class="row row-sm" id="receiver" style="display: none">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Handover to</label>
            <select class="language form-control" id="key" name="handover_to">

                <option value="">Please Select One</option>
                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}" @if(!empty($courierinout->
                    handover_to) && $courierinout->
                    handover_to==$teammemberData->id) selected @endif>{{ $teammemberData->team_member }} (
                    {{ $teammemberData->role->rolename }} )</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Date Time</label>
            <input type="datetime-local" name="date_time" value="" class="form-control">
        </div>
    </div>

</div>
<br>

<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('courierinout') }}">Back</a>

</div>
