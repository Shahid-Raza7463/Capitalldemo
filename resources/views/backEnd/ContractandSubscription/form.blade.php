<div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">KGS Entity</label>
            <select required class="language form-control" name="kgsentity" @if(Request::is('contract/*/edit'))> <option
                disabled style="display:block">Select
                KGS Entity
                </option>

                @foreach($kgsentity as $kgsentityData)
                <option value="{{$kgsentityData->id}}"
                    {{$contractDatas->kgsentity== $kgsentityData->id??'' ?'selected="selected"' : ''}}>
                    {{$kgsentityData->name }}</option>
                @endforeach


                @else

                <option value="">Please Select One</option>
                @foreach($kgsentity as $kgsentityData)
                
                <option value="{{$kgsentityData->id}}">
                    {{ $kgsentityData->name }}</option>

                @endforeach
                @endif
            </select>

        </div>
    </div>

    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600"> Nature of Item</label>
            <input type="text" required name="natureofitem" class="form-control" value="" />
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Services</label>
            <input type="text" name="services" required class="form-control"
                value="{{ $recruitmentform->enddate ??''}}" />

        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Date of Contract</label>
            <input type="date" name="dateofcontact" class="form-control"
                value="{{ $recruitmentform->enddate ??''}}" />
        </div>
    </div>
</div>
<div class="row row-sm">
    
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Expiry Date / Renewal Due </label>
            <input type="date" required name="expirydate" class="form-control"
                value="{{ $recruitmentform->enddate ??''}}" />

        </div>
    </div>
   
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Company Name</label>
            <input type="text" required name="companyname" class="form-control"
                value="{{ $recruitmentform->enddate ??''}}" />

        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Amount</label>
            <input type="number" name="amount" class="form-control"
                value="{{ $recruitmentform->enddate ??''}}" />

        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600"> Contact Email</label>
            <input type="email" name="contactemailid" class="form-control"
                value="{{ $recruitmentform->enddate ??''}}" />

        </div>
    </div>
</div>
<div class="row row-sm">
   
   
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600"> Contact Person</label>
            <input type="text" name="contactperson" class="form-control"
                value="{{ $recruitmentform->enddate ??''}}" />

        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">After Sale Services</label>
            <select name="saleservices" id="invoicereject" class="form-control">
                <!--placeholder-->
                @if(Request::is('contract/*/edit')) >
             @if($invoice->status=='0')
                <option value="0">Included</option>
                <option value="1">Not Included</option>
    
               
                @else
                
                <option value="1">Not Included</option>
                <option value="0">Included</option>
              
               
                @endif
                @else
                <option value="">Please Select One</option>
                <option value="0">Included</option>
                <option value="1">Not Included</option>
               
    
                @endif
            </select>

        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600"> Warranty</label>
            <select name="warranty" id="invoicereject" class="form-control">
                <!--placeholder-->
                @if(Request::is('contract/*/edit')) >
             @if($invoice->status=='0')
                <option value="0">Yes</option>
                <option value="1">No</option>
    
               
                @else
                <option value="1">No</option>
                <option value="0">Yes</option>
              
              
               
                @endif
                @else
                <option value="">Please Select One</option>
                <option value="0">Yes</option>
                <option value="1">No</option>
               
    
                @endif
            </select>

        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Approval </label>
            <select required class="form-control basic-multiple" name="teammember_id"
                @if(Request::is('contract/*/edit'))> @foreach($teammember as $teammemberData) <option
                value="{{$teammemberData->id}}" @if(($contractDatas->teammember_id) == $teammemberData->id) selected
                @endif>
                {{ $teammemberData->title->title }}. {{ $teammemberData->team_member }}(
                {{ $teammemberData->role->rolename}} )</option>
                @endforeach

                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}">
                    {{ $teammemberData->team_member }} ( {{ $teammemberData->role->rolename}} )</option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('contract') }}">
        back</a>

</div>
