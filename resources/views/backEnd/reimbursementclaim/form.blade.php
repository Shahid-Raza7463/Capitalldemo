<div class="row row-sm">
  <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Date of Expense. *</label>
            <input type="date" id="example-date-input" required name="Date_of_Expense" value="{{ $reimbursementclaim->Date_of_Expense ?? ''}}" class="form-control"
            placeholder="Enter Date of Expense">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Type of Expense. *</label>
            <input type="text" id="example-date-input" required name="Type_of_Expense" value="{{ $reimbursementclaim->Type_of_Expense ?? ''}}" class="form-control"
            placeholder="Enter Type of Expense">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Approved Amount (If Any). *</label>
            <input type="number" id="example-date-input" required name="Approved_Amount" value="{{ $reimbursementclaim->Approved_Amount ?? ''}}" class="form-control"
                placeholder="Enter Approved Amount.">
        </div>
        </div>
         
</div>
<div class="row row-sm">
  <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Actual Amount. *</label>
            <input type="number" id="example-date-input" required name="Actual_Amount" value="{{ $reimbursementclaim->Actual_Amount ?? ''}}" class="form-control"
            placeholder="Enter Actual Amount">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Location. </label>
            <input type="text" id="example-date-input" name="Location" value="{{ $reimbursementclaim->Location ?? ''}}" class="form-control"
            placeholder="Enter Location">
        </div>
    </div>
    <div class="col-3">
    <div class="form-group">
            <label class="font-weight-600">Bill/Supporting Document. *</label>
            <input type="file" id="reimbursementclaim-img" name="attachment" required value="{{ $reimbursementclaim->attachment ?? ''}}" class="form-control"
                placeholder="Enter Bill/Supporting Document">
        </div>
        </div>
           @if(!empty($reimbursementclaim->attachment))
    <div class="col-2">
        <div class="form-group">
            <label class="font-weight-600"></label><br><br>
            <a  target="blank" href="{{url('/backEnd/image/claim/'.$reimbursementclaim->attachment)}}" href= class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View Attachment</a>
        </div>
    </div>
	@endif
</div>
<div class="row row-sm">

    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Select Approver *</label>
            <select  class="language form-control" required id="exampleFormControlSelect1" name="Approver"
            @if(Request::is('reimbursementclaim/*/edit'))> <option disabled style="display:block">Please Select One</option>

            @foreach($teammember as $teammemberData)
            <option value="{{$teammemberData->id}}"
                {{$reimbursementclaim->Approver == $teammemberData->id??'' ?'selected="selected"' : ''}}>
                {{$teammemberData->team_member }}( {{$teammemberData->role->rolename }} )</option>
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
  
    @if(Request::is('reimbursementclaim/*/edit'))  
    @if($reimbursementclaim->Approver == Auth::user()->teammember_id)
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Status</label>
            <select name="Status" id="exampleFormControlSelect1" class="form-control">
                <!--placeholder-->
                @if(Request::is('reimbursementclaim/*/edit')) >
                @if($reimbursementclaim->Status=='0')
                <option value="0">Created</option>
                <option value="1">Approved</option>
                <option value="2">Rejected</option>
                <option value="3">Submitted</option>
				
                @elseif($reimbursementclaim->Status=='1')
                <option value="1">Approved</option>
                <option value="0">Created</option>
               
                <option value="2">Rejected</option>
                <option value="3">Submitted</option>

                @elseif($reimbursementclaim->Status=='2')
                <option value="2">Rejected</option>
                <option value="0">Created</option>
                <option value="1">Approved</option>               
                <option value="3">Submitted</option>

                @else
                <option value="3">Submitted</option>
                <option value="2">Rejected</option>
                <option value="1">Approved</option>
                <option value="0">Created</option>
                

                @endif
                @else

                <option value="0">Created</option>
                <option value="1">Approved</option>
                <option value="2">Rejected</option>
                <option value="3">Submited</option>
                @endif
            </select>
        </div>
    </div>
    @endif
    @endif
</div>


<div class="form-group">
    @if(Request::is('reimbursementclaim/create')) 
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    @endif
    @if(Request::is('reimbursementclaim/*/edit')) 
    @if($reimbursementclaim->Status=='0')
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    @endif
    @if(Auth::user()->role_id == 17)
    @if($reimbursementclaim->Status != '3')
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    @endif
    @endif
    @endif
    <a class="btn btn-secondary" href="{{ url('reimbursementclaim') }}">
        Back</a>

</div>
