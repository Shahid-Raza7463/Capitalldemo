<div class="row row-sm">
  <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Model Name. *</label>
            <input type="text" id="example-date-input" name="modal_name" value="{{ $finance->modal_name ?? ''}}" class="form-control"
            placeholder="Enter Model Name">
        </div>
    </div>
   
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Company Name </label>
            <input type="text" id="example-date-input" name="company_name" value="{{ $finance->company_name ?? ''}}" class="form-control"
                placeholder="Enter Company Name.">
        </div>
        </div>
             <div class="col-3">
            <div class="form-group">
                <label class="font-weight-600">Name *</label>
                <select  class="language form-control" id="exampleFormControlSelect1" name="teammemberid"
                @if(Request::is('assetassign/*/edit'))> <option disabled style="display:block">Please Select One</option>
    
                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}"
                    {{$finance->teammemberid == $teammemberData->id??'' ?'selected="selected"' : ''}}>
                    {{$teammemberData->team_member }}( {{$teammemberData->role->rolename ??''}} )</option>
                @endforeach
    
    
                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}">
                    {{ $teammemberData->team_member }}  ( {{$teammemberData->role->rolename ??''}} )</option>
    
                @endforeach
                @endif
            </select>
            </div>
        </div>
	<div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Date Of Procurement </label>
            <input type="date"  name="dateofprocurement" value="{{ $finance->dateofprocurement ?? ''}}" class="form-control"
                placeholder="Enter Date Of Procurement">
        </div>
        </div>
</div>
<div class="row row-sm">
  
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Kgs. *</label>
            <input type="text" id="example-date-input" name="kgs" value="{{ $finance->kgs ?? ''}}" class="form-control"
            placeholder="Enter Kgs">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Sno </label>
            <input type="text" id="example-date-input" name="sno" value="{{ $finance->sno ?? ''}}" class="form-control"
                placeholder="Enter Sno.">
        </div>
        </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Mac Address </label>
            <input type="text" id="example-date-input" name="mac_address" value="{{ $finance->mac_address ?? ''}}" class="form-control"
                placeholder="Enter Mac Address.">
        </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label class="font-weight-600">Status</label>
                 <select name="assetstatus" id="exampleFormControlSelect2" class="form-control">
                    <!--placeholder-->
                    @if(Request::is('assetassign/*/edit'))
                    @if($finance->assetstatus=='0')
                    <option value="0">Assigned</option>
                    <option value="1">Return</option>
                    <option value="2">Discard</option>
					 <option value="3">In Office</option>

                    @elseif($finance->assetstatus=='1')
                    <option value="1">Return</option>
                    <option value="0">Assigned</option>
                    <option value="3">In Office</option>
                    <option value="2">Discard</option>
					 
					  @elseif($finance->assetstatus=='2')
					   <option value="2">Discard</option>
                    <option value="1">Return</option>
                    <option value="0">Assigned</option>
                    <option value="3">In Office</option>
                  
                  
                   
                    @else
					   <option value="3">In Office</option>
                    <option value="2">Discard</option>
                    <option value="0">Assigned</option>
                    <option value="1">Return</option>
                    
                    
        
                    @endif
                    @else
        
                    <option value="">Please Select One</option>
                    <option value="0">Assigned</option>
                    <option value="1">Return</option>
                    <option value="2">Discard</option>
					   <option value="3">In Office</option>
                    @endif
                </select>
            </div>
            </div>
   </div>
   <div class="row row-sm">
    <div class="col-12">
    <div class="form-group">
        <label class="font-weight-600">Description</label>
        <textarea rows="3" name="description" class="form-control"
            placeholder="Enter Description">{!! $finance->description ??'' !!}</textarea>
    </div>
    </div>
   </div>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('finance') }}">
        Back</a>

</div>
