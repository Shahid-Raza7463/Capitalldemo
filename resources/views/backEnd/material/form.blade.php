<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Type</label>
            <select class="form-control key" id="type" name="type">
                <option value="">Please Select One</option>
                <option value="0">In</option>
                <option value="1">Out</option>
            </select>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Item Name *</label>
            <input type="text" name="item_name" placeholder="Enter Item name" value="" class="form-control">
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Quantity *</label>
            <input type="number" name="quantity" placeholder="Enter quantity" value="" class="form-control">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Date Time *</label>
            <input type="datetime-local" name="date_time" value="" class="form-control">
        </div>
    </div>
</div>
<div class="row row-sm" id="In" style="display: none">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Sender Name</label>
            <input type="text" name="sender_name" placeholder="Enter Sender Name" value="" class="form-control">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Item Value</label>
            <input type="text" name="item_value" placeholder="Enter Item Value" value="" class="form-control">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Receiver</label>
            <select class="language form-control" id="key1" name="receiver">
                <option value="">Please Select One</option>
                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}">
                    {{ $teammemberData->team_member }} ({{ $teammemberData->role->rolename }} )</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row row-sm" id="Out" style="display: none">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Price</label>
            <input type="number" name="price" placeholder="Enter price" value="" class="form-control">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Item Details</label>
            <input type="text" name="item_detail" placeholder="Enter Item Value" value="" class="form-control">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Approver</label>
            <select class="language form-control" id="key" name="approved">
                <option value="">Please Select One</option>
                @foreach($partner as $partnerData)
                <option value="{{$partnerData->id}}">
                    {{ $partnerData->team_member }} ({{ $partnerData->role->rolename }} )</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Item Type</label>
            <select class="form-control key" id="itemtype" name="item_type">
                <option value="">Please Select One</option>
                <option value="0">Rentable</option>
                <option value="1">Non-Rentable</option>
            </select>
        </div>
    </div>

</div>

<div class="row row-sm" id="rentable" style="display: none">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Expected Date</label>
            <input type="date" name="expected_date" placeholder="Enter Expected Date" value="" class="form-control">
        </div>
    </div>
</div>
<br>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('courierinout') }}">Back</a>

</div>
