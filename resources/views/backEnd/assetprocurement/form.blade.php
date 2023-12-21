<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Employee Name </label>
            <select class="language form-control" id="category" 
            @if(Request::is('assetprocurement/*/edit'))> <option disabled
            style="display:block">Please Select One</option>

            @foreach($authteammember as $teammemberData)
            <option value="{{$teammemberData->id}}"
            @if(($assetprocurement->createdby) == $teammemberData->id) selected @endif>
                {{ $teammemberData->title->title ??''}}. {{ $teammemberData->team_member }}</option>
            @endforeach


            @else
            <option></option>
            <option value="">Please Select One</option>
            @foreach($authteammember as $teammemberData)
            <option value="{{$teammemberData->id}}"   @if((Auth::user()->teammember_id) == $teammemberData->id) selected @endif>
                {{ $teammemberData->title->title ??''}}. {{ $teammemberData->team_member }}</option>

            @endforeach
            @endif
        </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Company Name </label>
            <input type="text"  required name="companyname" value="{{ $assetprocurement->companyname ?? ''}}" class="form-control"
                placeholder="Enter Company Name ">
        </div>
        </div>
</div>
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Item Name </label>
            <input type="text"  required name="itemname" value="{{ $assetprocurement->itemname ?? ''}}" class="form-control"
                placeholder="Enter Item Name ">
        </div>
        </div>
  {{-- <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Purpose of visit. *</label>
            <input type="text" id="example-date-input" name="Purpose_of_visit" value="{{ $assetprocurement->Purpose_of_visit ?? ''}}" class="form-control"
            placeholder="Enter Purpose of visit">
        </div>
    </div> --}}
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Start date </label>
            <input required type="date" id="example-date-input" name="startdate" value="{{ $assetprocurement->Expected_date_of_departure ?? ''}}" class="form-control"
                placeholder="Enter Expected date of departure.">
        </div>
        </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">End date. *</label>
            <input required type="date" id="example-date-input" name="enddate" value="{{ $assetprocurement->Expected_date_of_arrival ?? ''}}" class="form-control"
            placeholder="Enter Expected date of arrival">
        </div>
    </div>
    {{-- <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Expected duration in days </label>
            <input type="text" id="example-date-input" name="Expected_duration_in_days" value="{{ $assetprocurement->Expected_duration_in_days ?? ''}}" class="form-control"
                placeholder="Enter Expected duration in days.">
        </div>
        </div> --}}
       
</div>
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Place Of Purchase </label>
            <input required type="text" id="example-date-input" name="placeofpurchase" value="{{ $assetprocurement->placeofpurchase ?? ''}}" class="form-control"
                placeholder="Enter Place of Purchase ">
        </div>
        </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Select Approver *</label>
            <select required class="language form-control"   name="teammember_id" @if(Request::is('assetprocurement/*/edit'))>
                <option disabled style="display:block">Please Select One</option>

                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}" @if(($assetprocurement->teammember_id) == $teammemberData->id) selected
                    @endif>
                  {{ $teammemberData->team_member }}  (  {{ $teammemberData->role->rolename }} )
                </option>
                @endforeach


                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}">
                    {{ $teammemberData->team_member }} (  {{ $teammemberData->role->rolename }} )</option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600"> Amount Required </label>
            <input type="text" required name="amount" value="{{ $assetprocurement->amount ?? ''}}" class="form-control"
                placeholder="Enter Amount Required">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600"> Bill/PO </label>
            <input type="file" required name="bill" class="form-control"
                placeholder="Enter Amount Required">
        </div>
    </div>
   
  <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Payment Type. *</label>
            <select name="paymenttype" id="exampleFormControlSelect1" class="form-control">
                <!--placeholder-->
                @if(Request::is('assetprocurement/*/edit')) >
                @if($assetprocurement->Billable=='0')
                <option value="0">Reimbursement</option>
                <option value="1">Advance</option>

                @else
                <option value="1">Advance</option>
                <option value="0">Reimbursement</option>
               

                @endif
                @else

                <option value="">Please Select One</option>
                <option value="0">Reimbursement</option>
                <option value="1">Advance</option>
                @endif
            </select>
        </div>
    </div>
   
</div>
<br>

<div class="row row-sm">
    @if(Request::is('assetprocurement/*/edit'))
    @if(Auth::user()->teammember_id == $assetprocurement->teammember_id)
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Action. *</label>
            <select name="assetprocurementstatus" class="form-control">
                <!--placeholder-->
                @if(Request::is('assetprocurement/*/edit')) >
                @if($assetprocurement->assetprocurementstatus=='0')
                <option value="0">Created</option>
                <option value="1">Approved</option>
                <option value="2">Reject</option>

                @elseif($assetprocurement->assetprocurementstatus=='1')
                <option value="1">Approved</option>
                <option value="0">Created</option>
                <option value="2">Reject</option>

                @else
                <option value="2">Reject</option>
                <option value="1">Approved</option>
                <option value="0">Created</option>
               

                @endif
                @else

                <option value="">Please Select One</option>
                <option value="0">Created</option>
                <option value="1">Approved</option>
                <option value="2">Reject</option>

                @endif
            </select>
        </div>
    </div>
    @endif
    @endif
    @if(Request::is('assetprocurement/*/edit'))
    @if($assetprocurement->assetprocurementstatus == 1)

    @if(Auth::user()->role_id == 17 || $assetprocurement->Advance_Amount  != null)
    <div class="col-4">
          <div class="form-group">
              <label class="font-weight-600">Advance Amount Given. *</label>
              <input type="number" name="Advance_Amount" value="{{ $assetprocurement->Advance_Amount ?? ''}}" class="form-control"
              placeholder="Enter Advance Amount">
          </div>
      </div>
      <div class="col-4">
          <div class="form-group">
              <label class="font-weight-600">Status. *</label>
              <select name="Status" id="exampleFormControlSelect1" class="form-control">
                <!--placeholder-->
                @if(Request::is('assetprocurement/*/edit')) >
                @if($assetprocurement->Status=='0')
                <option value="0">Paid</option>
                <option value="1">On Hold</option>

                @else
                <option value="1">On Hold</option>
                <option value="0">Paid</option>
              
               

                @endif
                @else

                <option value="">Please Select One</option>
                <option value="0">Paid</option>
                <option value="1">On Hold</option>
                @endif
            </select>
          </div>
      </div>
           
  </div>
  <div class="row row-sm">
    <div class="col-12">
        <label class="font-weight-600">Comment (Reason for hold) </label>
        <textarea rows="3" name="comment" value="" class="form-control"
        placeholder="Enter Comment (Reason for hold)">{!! $assetprocurement->comment ??'' !!}</textarea>
    </div>
    @endif
    @endif
    @endif
  </div>
  
  <br>
  
<div class="form-group">
    @if(Request::is('assetprocurement/create'))
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    @endif
    @if(Request::is('assetprocurement/*/edit'))
    @if($assetprocurement->createdby == Auth::user()->teammember_id && $assetprocurement->assetprocurementstatus == 0)
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    @endif
   
    @if($assetprocurement->teammember_id == Auth::user()->teammember_id && $assetprocurement->assetprocurementstatus == 0)
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    @endif
    @if(Auth::user()->role_id == 17 && $assetprocurement->assetprocurementstatus == 1)
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    @endif
    @endif
    <a class="btn btn-secondary" href="{{ url('assetprocurement') }}">
        Back</a>

</div>

@include('backEnd.ajax')
