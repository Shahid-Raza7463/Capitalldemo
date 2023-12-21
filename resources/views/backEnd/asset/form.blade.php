<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Staff *</label>
            <select class="form-control" id="exampleFormControlSelect1" name="teammember_id"
            @if(Request::is('asset/*/edit'))> <option disabled style="display:block">Please Select One</option>

            @foreach($teammember as $teammemberData)
            <option value="{{$teammemberData->id}}"
                {{$asset->teammember->id== $teammemberData->id??'' ?'selected="selected"' : ''}}>
                {{$teammemberData->team_member }}</option>
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
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Item *</label>
            <select name="item" id="exampleFormControlSelect1" class="form-control">
                <option value="">Select</option>
                <option value="0">Laptop</option>
                <option value="1">Mobile</option>
            </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Assign Date </label>
            <input type="date" id="example-date-input" name="dateassign" value="{{ $asset->dateassign ?? ''}}" class="form-control"
                placeholder="Enter Assign Date">
        </div>
        </div>
</div>
<div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Description</label>
           <textarea id="some-textarea" rows="14" name="description" value="{{ $asset->description ?? ''}}" class="form-control"
                placeholder="Enter Description">{!! $asset->description ??'' !!}</textarea>
        </div>
    </div>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('asset') }}">
        Back</a>

</div>
