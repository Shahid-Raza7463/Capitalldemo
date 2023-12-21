{{-- <style>
    #Div2 {
        display: none;
    }

</style> --}}
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js"></script>
@if(Request::is('invoice/*/edit') && Auth::user()->role_id == 17)
<div class="row row-sm">

    @if($invoice->companydetails_id == null)
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Company *</label>
            <select class="language form-control" id="company" required name="companydetails_id"
                @if(Request::is('ass/*/edit'))> <option disabled style="display:block">Please Select One
                </option>

                @foreach($company as $clientData)
                <option value="{{$clientData->id}}"
                    {{$invoice->companydetails_id== $clientData->id??'' ?'selected="selected"' : ''}}>
                    {{$clientData->company_name }}</option>
                @endforeach



                @else
                <option></option>
                <option value="0">Please Select One</option>

                @foreach($company as $companyData)
                <option value="{{$companyData->id}}">
                    {{ $companyData->company_name }}</option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
    @endif
	 <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Financial Year *</label>
            <select id="financialyear" name="financialyear" class="form-control">
                <!--placeholder-->
                @if(Request::is('invoice/*/edit')) >
                @if($invoice->financialyear=='21-22')
                <option value="21-22">21-22</option>
                <option value="22-23">22-23 </option>
				 <option value="23-24">23-24 </option>
				
				 @elseif($invoice->financialyear=='22-23')
				 <option value="22-23">22-23 </option>
                <option value="21-22">21-22</option>
                <option value="23-24">23-24 </option>

                @else
				<option value="23-24">23-24 </option>
                <option value="22-23">22-23 </option>
                <option value="21-22">21-22</option>
				
                @endif
                @else
                 <option value="">Please Select One </option>
                 <option value="21-22">21-22</option>
                 <option value="22-23">22-23 </option>
                <option value="23-24">23-24 </option>
    
    
                @endif
            </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Invoice No.</label>
            <div class="input-group mb-2 mr-sm-2">
                <div class="input-group-prepend">
                    <div class="input-group-text"><input readonly id="company_code" name="companycode" style="
                        border: aliceblue;
                        width: 41px;
                        height: 25px;
                        background: #F4F4F5;
                    "></input></div>
                </div>
                <input readonly type="text" id="invocieno" value="{{ $invoice->invoice_id ??'' }}" name="invoice_id"
                    class="form-control" placeholder="Enter Invoice No">
            </div>
        </div>
    </div>
</div>
@endif
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Client *</label>
            <select class="form-control" id="category" name="client_id" @if(Request::is('invoice/*/edit'))> <option
                disabled style="display:block">Please Select One</option>

                @foreach($client as $clientData)
                <option value="{{$clientData->id}}"
                    {{$invoice->client_id == $clientData->id ??'' ?'selected="selected"' : ''}}>
                    {{$clientData->client_name }}</option>
                @endforeach


                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($client as $clientData)
                <option value="{{$clientData->id}}">
                    {{ $clientData->client_name }}</option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
	 <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Assignment  @if(Auth::user()->role_id != 11)* @endif</label>
            <select class="form-control" @if(Auth::user()->role_id != 11 || Auth::user()->role_id != 17) required @endif id="subcategory_id" name="assignment_id"
               > 
               @if(!empty($invoice->assignment_id))
               <option value="{{ $invoice->assignment_id }}">
                   {{ App\Models\Assignment::where('id',$invoice->assignment_id)->first()->assignment_name??'' }}
               </option>

               @endif
            </select>
        </div>
    </div>
    {{-- <div class="col-5" id="Div2">
        <div class="form-group">
            <label class="font-weight-600">Client Name </label>
            <input type="text" name="client_name" value="{{ $asset->client_name ?? ''}}" class="form-control"
    placeholder="Enter Client Name">
</div>
</div>
<div class="col-1">
    <div class="form-group" style="margin-top: 36px;">
        <a id="Button1" class="add_button" title="Add field" onclick="switchVisible();"><img
                src="{{ url('backEnd/image/add-icon.png')}}" /></a>
    </div>
</div> --}}


{{-- 
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Team*</label>
            <select class="language form-control" id="category" name="company_id"
                @if(Request::is('assignmentmapping/*/edit'))> <option disabled style="display:block">Please Select One
                </option>

                @foreach($client as $clientData)
                <option value="{{$clientData->id}}"
{{$assignmentmapping->Companydetail->id== $clientData->id??'' ?'selected="selected"' : ''}}>
{{$clientData->company_name }}</option>
@endforeach


@else
<option></option>
<option value="">Please Select One</option>

@foreach($team as $teamData)
<option value="{{$teamData->id}}">
    {{ $teamData->team_member}}</option>

@endforeach
@endif
</select>
</div>
</div> --}}
{{-- 


    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Invoice Number</label>
            <input type="text" name="invoicenumber" value="" class=" form-control" placeholder="Enter Invoice Number">

        </div>
    </div> --}}
{{-- <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Started Date</label>
            <input type="date" name="starteddate" value="" class=" form-control" placeholder="Enter Perio End">
        </div>
    </div> --}}
{{-- <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Ended Date</label>
            <input type="date" name="endeddate" value="" class=" form-control" placeholder="Enter Perio End">
        </div>
    </div> --}}
<div class="col-4">
    <div class="form-group">
        <label class="font-weight-600">GST no </label>
        <input type="text" name="gstno" id="gstno" class="form-control" value="{{ $invoice->gstno??'' }}"
            placeholder="Enter GST number">
    </div>
</div>
	<div class="col-4">
    <div class="form-group">
        <label class="font-weight-600">PAN NO </label>
        <input required type="text" name="panno" id="panno" class="form-control" value="{{ $invoice->panno??'' }}"
            placeholder="Enter PAN number">
    </div>
</div>
<div class="col-6">
    <div class="form-group">
        <label class="font-weight-600">Client Address </label>
        <input type="text" id="c_address" name="clientaddress" class="form-control"
            value="{{ $invoice->clientaddress ??'' }}" placeholder="Enter Client Address">
    </div>
</div>
<div class="col-6">
    <div class="form-group">
        <label class="font-weight-600">Contact Name </label>
        <input type="text" name="contactname" id="name" class="form-control" value="{{ $invoice->contactname ??'' }}"
            placeholder="Enter Contact Name">
    </div>
</div>
<div class="col-4">
    <div class="form-group">
        <label class="font-weight-600">Contact Email </label>
        <input type="email" name="contactemail" id="emailid" class="form-control"
            value="{{ $invoice->contactemail ??'' }}" placeholder="Enter Contact Email">
    </div>
</div>
<div class="col-4">
    <div class="form-group">
        <label class="font-weight-600">Client Phone </label>
        <input type="text" name="phone" id="mobileno" class="form-control" value="{{ $invoice->phone ??'' }}"
            placeholder="Enter Phone ">
    </div>
</div>

<div class="col-4">
    <div class="form-group">
        <label class="font-weight-600">State and State code </label>
          <select class="form-control" onchange="gstshow()" id="statecode" name="statecode"
            @if(Request::is('invoice/*/edit'))> <option value="">Please Select One</option>

            @foreach($statecode as $statecodeData)
            <option value="{{$statecodeData->statecode}}"
            @if(($invoice->statecode) == $statecodeData->statecode) selected @endif>
          {{ $statecodeData->statecode }} ( {{ $statecodeData->statename}} )</option>
            @endforeach


            @else
            <option></option>
            <option value="">Please Select One</option>
            @foreach($statecode as $statecodeData)
            <option value="{{$statecodeData->statecode}}">
                {{ $statecodeData->statecode }} ( {{ $statecodeData->statename}} )</option>

            @endforeach
            @endif
        </select>
    </div>
</div>
<div class="col-4">
    <div class="form-group">
        <label class="font-weight-600">Place of supply </label>
        <input type="text" name="supply" class="form-control" value="{{ $invoice->supply ??'' }}"
            placeholder="Enter Place of supply">
    </div>
</div>
<div class="col-4">
    <div class="form-group">
        <label class="font-weight-600">Nature of Assignment</label>
        <input type="text" name="natureofassignment" class="form-control"
            value="{{ $invoice->natureofassignment ??'' }}" placeholder="Enter Nature of Assignment">
    </div>
</div>
<div class="col-4">
    <div class="form-group">
        <label class="font-weight-600">Period of Assignment</label>
        <input type="text" name="periodassignment" class="form-control" value="{{ $invoice->periodassignment ??'' }}"
            placeholder="Enter Period of Assignment">
    </div>
</div>
<div class="col-3">
    <div class="form-group">
        <label class="font-weight-600">SAC Code</label>
        <input type="text" required name="saccode" class="form-control" value="{{ $invoice->saccode ??'' }}"
            placeholder="Enter SAC Code">
    </div>
</div>
<div class="col-3">
    <div class="form-group">
        <label class="font-weight-600">Out Of Pocket Expense Amount</label>
        <input type="number" required name="pocketexpenseamount" onchange="calc();" id="pocketexpenseamount" class="form-control"
            value="{{ $invoice->pocketexpenseamount ??'' }}" placeholder="Enter Out Of Pocket Expense Amount">
    </div>
</div>
	<div class="col-2" id="pocket" style="display: none;">
    <div class="form-group">
        <label class="font-weight-600">Pocket Expense File *</label>
        <input type="file" name="pocketexpensefile"  class="form-control"
            value="{{ $invoice->pocketexpenseamount ??'' }}" placeholder="Enter Out Of Pocket Expense Amount">
    </div>
</div>
@if($invoice->pocketexpensefile ??'')
<div class="col-2">
    <div class="form-group">
        <label class="font-weight-600"></label><br><br>
        
        <a href="{{ Storage::disk('s3')->temporaryUrl('invoice/'.$invoice->pocketexpensefile, now()->addMinutes(3)) }}" target="blank" data-toggle="tooltip"
        title="{{ $invoice->pocketexpensefile ??'' }}" class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
    </div>
</div>
@endif
<div class="col-4">
    <div class="form-group">
        <label class="font-weight-600">Invoice Date *</label>
        <input type="text" id="datepicker" name="invoicedate" class="form-control"
            value="{{ $invoice->invoicedate ??'' }}" placeholder="Enter Invoice Date">
    </div>
</div>
@if(Request::is('invoice/*/edit') && Auth::user()->role_id == 17)
<div class="col-4">
    <div class="form-group">
        <label class="font-weight-600">Status</label>
        <select name="status" id="invoicereject" class="form-control">
            <!--placeholder-->
            @if(Request::is('invoice/*/edit')) >
            @if($invoice->status=='0')
            <option value="0">pending</option>
            <option value="1">reject</option>
            <option value="2">approved</option>
            <option value="3">pending for approvel</option>
            <option value="4">approved by partner</option>
            <option value="5">cancel</option>
			
            @elseif($invoice->status=='1')
            <option value="1">reject</option>
            <option value="2">approved</option>
            <option value="0">pending</option>
            <option value="3">pending for approvel</option>
            <option value="4">approved by partner</option>
           <option value="5">cancel</option>
			
            @elseif($invoice->status=='3')
            <option value="3">pending for approvel</option>
            <option value="1">reject</option>
            <option value="2">approved</option>
            <option value="0">pending</option>
            <option value="4">approved by partner</option>
<option value="5">cancel</option>
			
            @elseif($invoice->status=='4')
            <option value="4">approved by partner</option>
            <option value="3">pending for approvel</option>
            <option value="1">reject</option>
            <option value="2">approved</option>
            <option value="0">pending</option>
            <option value="5">cancel</option>

			@elseif($invoice->status=='5')
            <option value="5">cancel</option>
            <option value="4">approved by partner</option>
            <option value="3">pending for approvel</option>
            <option value="1">reject</option>
            <option value="2">approved</option>
            <option value="0">pending</option>
			
            @else
            <option value="2">approved</option>
            <option value="4">approved by partner</option>
            <option value="3">pending for approvel</option>
            <option value="1">reject</option>
            <option value="0">pending</option>
            <option value="5">cancel</option>
			
            @endif
            @else
            <option value="0">pending</option>
            <option value="1">reject</option>
            <option value="2">approved</option>
            <option value="4">approved by partner</option>
            <option value="3">pending for approvel</option>
            <option value="5">cancel</option>
			
            @endif
        </select>
    </div>
</div>
@endif
@if(Request::is('invoice/*/edit') && Auth::user()->role_id == 13)
<div class="col-4">
    <div class="form-group">
        <label class="font-weight-600">Status</label>
        <select name="status" id="invoicereject" class="form-control">
            <!--placeholder-->
            @if(Request::is('invoice/*/edit')) >
         @if($invoice->status=='1')
            <option value="1">reject</option>
           
            <option value="3">pending for approvel</option>
            <option value="4">approved by partner</option>

           
            @elseif($invoice->status=='4')
            <option value="4">approved by partner</option>
            <option value="1">reject</option>
           
            <option value="3">pending for approvel</option>
           
            @else
           
            <option value="3">pending for approvel</option>
            <option value="4">approved by partner</option>
            <option value="1">reject</option>
           
            @endif
            @else
            <option value="0">pending</option>
            <option value="1">reject</option>
            <option value="2">approved</option>
            <option value="4">approved by partner</option>
            <option value="3">pending for approvel</option>

            @endif
        </select>
    </div>
</div>
@endif
@if(Auth::user()->role_id == 17 || Auth::user()->role_id == 14 || Auth::user()->role_id == 11)
<div class="col-4">
    <div class="form-group">
        <label class="font-weight-600">Partner *</label>
        <select class="form-control" name="partner" @if(Request::is('invoice/*/edit'))> <option disabled
            style="display:block">Please Select One</option>

            @foreach($teammember as $teammemberData)
            <option value="{{$teammemberData->id}}" @if(!empty($invoice->
                partner) && $invoice->
                partner==$teammemberData->id) selected @endif>
                {{ $teammemberData->team_member }}</option>
            @endforeach


            @else
            <option></option>
            <option value="">Please Select One</option>
            @foreach($teammember as $teammemberData)
            <option value="{{$teammemberData->id}}">
                {{ $teammemberData->team_member }}</option>

            @endforeach
            @endif
        </select>
    </div>
</div>
@endif
<div class="col-4">
    <div class="form-group">
        <label class="font-weight-600">EXPORT/SEZ *</label>
        <select name="export" id="currency"  class="form-control">
            <!--placeholder-->
            @if(Request::is('invoice/*/edit')) >
            @if($invoice->export=='1')
            <option value="1">EXPORT </option>
            <option value="2">SEZ </option>
            <option value="3">NA</option>

            @elseif($invoice->export=='2')
            <option value="2">SEZ </option>
            <option value="3">NA</option>
            <option value="1">EXPORT</option>

            @else
            <option value="3">NA</option>
            <option value="1">EXPORT </option>
            <option value="2">SEZ </option>

            @endif
            @else
			 <option value="">Please Select One </option>
            <option value="1">EXPORT </option>
            <option value="2">SEZ </option>
            <option value="3">NA</option>


            @endif
        </select>
    </div>
</div>
	<div class="col-4" id='currencychange'  @if(Auth::user()->role_id != 17 ) style="display: none;" @endif>
    <div class="form-group">
        <label class="font-weight-600">Currency *</label>
         <select class="form-control" name="currency" id="currency_id">
            @if(!empty($invoice->currency))
            <option value="{{ $invoice->currency }}">
                {{ App\Models\Currency::where('id',$invoice->currency)->first()->code??'' }}
            </option>

            @endif </select>
    </div>
</div>
<div class="col-4" id='designationn' style="display: none;">
    <div class="form-group">
        <label class="font-weight-600">Remark </label>
        <input type="text" name="remark" class="form-control" value="{{ $invoice->remark ??'' }}"
            placeholder="Enter Remark">
    </div>
</div>
	<div class="col-4" id='deb' @if(!empty($invoice->notes)) @else style="display: none;" @endif>
    <div class="form-group">
        <label class="font-weight-600">Cancel Note </label>
        <textarea rows="2" name="notes" class="form-control"
        placeholder="Enter Note">{{ $invoice->notes ??'' }}</textarea>
    </div>
</div>
</div>
<div class="row row-sm">
	<div class="col-2">
    <div class="form-group">
        <label class="font-weight-600">Due Date Of Recovery *</label>
        <input type="date" required name="duedateofrecovery" class="form-control" value="{{ $invoice->duedateofrecovery ??'' }}"
            placeholder="Enter Due Date Of Recovery">
    </div>
</div>
    <div class="col-2">
        <div class="form-group">
            <label class="font-weight-600">Final Report *</label>
            <input type="file"  name="finalreport" class="form-control"> 
        </div>
    </div>
	 <div class="col-2">
        <div class="form-group">
            <label class="font-weight-600">Final Report Date*</label>
            <input type="date" required name="finalreportdate" value="{{ $invoice->finalreportdate ??'' }}" class="form-control"> 
        </div>
    </div>
    @if($invoice->finalreport ??'')
    <div class="col-2">
        <div class="form-group">
            <label class="font-weight-600"></label><br><br>
			
            <a href="{{ Storage::disk('s3')->temporaryUrl('invoice/'.$invoice->finalreport, now()->addMinutes(3)) }}" target="blank" data-toggle="tooltip"
            title="{{ $invoice->finalreport ??'' }}" class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
        </div>
    </div>
    @endif
    <div class="col-2">
        <div class="form-group">
            <label class="font-weight-600">Appointment Letter *</label>
            <input type="file"  name="appointmentletter" @if(Request::is('invoice/create')) required @endif class="form-control">
        </div>
    </div>
    @if($invoice->appointmentletter ??'')
    <div class="col-2">
        <div class="form-group">
            <label class="font-weight-600"></label><br><br>
			
            <a href="{{ Storage::disk('s3')->temporaryUrl('invoice/'.$invoice->appointmentletter, now()->addMinutes(3)) }}" target="blank" data-toggle="tooltip"
            title="{{ $invoice->appointmentletter ??'' }}" class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
        </div>
    </div>
    @endif
	 <div class="col-2">
        <div class="form-group">
            <label class="font-weight-600">Annexure</label>
            <input type="file"  name="annexure" class="form-control">
        </div>
    </div>
    @if($invoice->annexure ??'')
    <div class="col-2">
        <div class="form-group">
            <label class="font-weight-600"></label><br><br>
			
            <a href="{{ Storage::disk('s3')->temporaryUrl('invoice/'.$invoice->annexure, now()->addMinutes(3)) }}" target="blank" data-toggle="tooltip"
            title="{{ $invoice->annexure ??'' }}" class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
        </div>
    </div>
    @endif
</div>
<div class="row row-sm">
<div class="col-4">
    <div class="form-group">
        <label class="font-weight-600">Client Data Uploaded *</label>
        <select required name="clientdata" id="clientdata" class="form-control">
            <!--placeholder-->
            @if(Request::is('invoice/*/edit')) >
            @if($invoice->clientdata=='0')
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
<div class="col-4">
    <div class="form-group">
        <label class="font-weight-600">Audit Documentation Status *</label>
        <select required name="auditdocument" id="auditdocument"  class="form-control">
            <!--placeholder-->
            @if(Request::is('invoice/*/edit')) >
            @if($invoice->auditdocument=='0')
            <option value="0">Done</option>
            <option value="1">Not Done</option>
            <option value="2">Partially Done</option>

            @elseif($invoice->auditdocument=='1')
            <option value="1">Not Done</option>
            <option value="0">Done</option>
            <option value="2">Partially Done</option>

            @else
			 <option value="2">Partially Done</option>
			  <option value="0">Done</option>
            <option value="1">Not Done</option>
           
			@endif
            @else
            <option value="">Please Select One</option>
            <option value="0">Done</option>
            <option value="1">Not Done</option>
            <option value="2">Partially Done</option>
			
            @endif
        </select>
    </div>
</div>
	@if(Request::is('invoice/*/edit') && Auth::user()->role_id == 17)
<div class="col-4">
    <div class="form-group">
        <label class="font-weight-600">Bank *</label>
        <select class="form-control" name="bank_id" @if(Request::is('invoice/*/edit'))> <option disabled
            style="display:block">Please Select One</option>

            @foreach($bank as $teammemberData)
            <option value="{{$teammemberData->id}}" @if(!empty($invoice->
                bank_id) && $invoice->
                bank_id==$teammemberData->id) selected @endif>
                {{ $teammemberData->bankname }}</option>
            @endforeach


            @else
            <option></option>
            <option value="">Please Select One</option>
            @foreach($bank as $teammemberData)
            <option value="{{$teammemberData->id}}">
                {{ $teammemberData->bankname }}</option>

            @endforeach
            @endif
        </select>
    </div>
</div>
@endif
</div>
<div class="row row-sm">
    <div class="col-12">
        <table class="table table-bordered" id="dynamicAddRemove">
            <tr style="background: #37A000;color:#F4F4F5;">
                <th>Service</th>
                <th>Amount</th>
                <!-- <th>Tax</th>-->
            </tr>
            <tbody>
                <td><textarea required rows="3" name="service" class="form-control"
                        placeholder="Enter Service">{{ $invoice->service ??'' }}</textarea></td>
                <td><input type="number" onchange="calc();" value="{{ $invoice->amount ??'' }}" id="amount"
                        name="amount" placeholder="Enter Amount" class="form-control" /><br>
                    <div class="row">
                        <div class="col-3"><b>No GST</b> : </div>
                        <div class="col-9"> <input id="myCheck" onclick="myFunction()" value="1" @if(Request::is('invoice/*/edit')){{  ($invoice->nogst == 1 ? ' checked' : '') }}@endif type="checkbox" name="nogst" />
                            <div>
                            </div>
                        </div>
                    </div>
                </td>
                <!--  <td>   <select name="tax" id="tax" onchange= "calc();" class="form-control">
        @if(Request::is('invoice/*/edit')) >
        @if($invoice->tax=='9')
        <option value="9"><span style="color:black;">9.00%</span> CGST</option>
        <option value="9"><span style="color:black;">9.00%</span> SGST</option>
        <option value="18"><span style="color:black;">18.00% </span> IGST</option>

        @else
        <option value="18"><span style="color:black;">18.00% </span> IGST</option>
        <option value="9"><span style="color:black;">9.00%</span> CGST</option>
        <option value="9"><span style="color:black;">9.00%</span> SGST</option>
       
        @endif
        @else

        <option value="">Please Select One</option>
        <option value="9"><span style="color:black;">9.00%</span> CGST</option>
        <option value="9"><span style="color:black;">9.00%</span> SGST</option>
        <option value="18"><span style="color:black;">18.00% </span> IGST</option>
        @endif
     
    </select><br>
   <div class="row">
    <div class="col-2"><b>Total</b> : </div>
    <div class="col-10">  <input type="number" name="total" readonly id="total" value="{{ $invoice->total ??'' }}" placeholder="Enter Amount" class="form-control" /><div>
         </div>
    </div>
</td>-->
                {{-- <td><a type="button" name="add" id="add-btn"><img
        src="{{ url('backEnd/image/add-icon.png')}}" /></a></td> --}}
            </tbody>
        </table>
    </div>
</div>
<div class="row row-sm">
    <div class="col-6">
    </div>

    <div class="col-6">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <small>Out of expense</small>

                        </td>
                        <td></td>
                        <td>

                            <input type="number" value="{{ $invoice->pocketexpenseamount ??'' }}"
                                style="background-color: #FFFFFF;border: 1px solid #FFFFFF;" id="outtotal"
                                class="form-control" readonly />


                        </td>
                    </tr>
                    <tr>
                        <td style="width:20%;">
                            <small>CGST%</small>

                        </td>
                        <td style="width:20%;"><small><input type="number" width="50%" id="cgst" onchange="calc();"
                                    name="cgst" class="form-control" value="{{ $invoice->cgst ??'' }}"
                                    placeholder="CGST"></small></td>
                        <td>

                            <input type="number" style="background-color: #FFFFFF;border: 1px solid #FFFFFF;"
                                id="cgsttotal" class="form-control" readonly />


                        </td>
                    </tr>
                    <tr>
                        <td style="width:20%;">
                            <small>SGST%</small>

                        </td>
                        <td style="width:20%;"><input type="number" id="sgst" onchange="calc();" name="sgst"
                                class="form-control" value="{{ $invoice->sgst ??'' }}" placeholder="SGST"></td>
                        <td>

                            <input type="number" style="background-color: #FFFFFF;border: 1px solid #FFFFFF;"
                                id="sgsttotal" class="form-control" readonly />


                        </td>
                    </tr>
                    <tr>
                        <td style="width:20%;">
                            <small>IGST</small>

                        </td>

                        <td style="width:20%;"><input type="number" id="igst" onchange="calc();" name="igst"
                                class="form-control" value="{{ $invoice->igst ??'' }}" placeholder="IGST"></td>
                        <td>

                            <input type="number" style="background-color: #FFFFFF;border: 1px solid #FFFFFF;"
                                id="igsttotal" class="form-control" readonly />


                        </td>
                    </tr>

                    <tr>
                        <td>
                            <small>Total</small>

                        </td>
                        <td></td>
                        <td><input style="background-color: #FFFFFF;border: 1px solid #FFFFFF;" type="text" readonly
                                id="total" name="total" class="form-control" value="{{ $invoice->total ??'' }}"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
<div class="form-group">
    @if(Request::is('invoice/*/edit'))
    @if($invoice->status == 1 && Auth::user()->teammember_id == $invoice->updatedby and Auth::user()->role_id != 17)
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    @endif
    @if(Auth::user()->role_id == 13)
    @if($invoice->status == 3)
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    @endif
    @endif
    @if(Auth::user()->role_id == 17)
    @if($invoice->status == 0 || $invoice->status == 4 || $invoice->status == 2)
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    @endif
    @endif
	   @if(Auth::user()->role_id == 11)
    @if($invoice->status == 0 || $invoice->status == 4 || $invoice->status == 2 || $invoice->status == 3)
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    @endif
    @endif
    @endif
    @if(Request::is('invoice/create'))
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    @endif
    <a class="btn btn-secondary" href="{{ url('invoice') }}">
        Back</a>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $(document).keypress(
        function (event) {
            if (event.which == '13') {
                event.preventDefault();
            }
        });

</script>
<script>
    function myFunction() {
        var checkBox = document.getElementById("myCheck");
        var value1 = document.getElementById('amount').value;

        var value3 = document.getElementById('pocketexpenseamount').value;
        if (checkBox.checked == true) {
            document.getElementById('cgst').value = 0;
            document.getElementById('sgst').value = 0;
            document.getElementById('igst').value = 0;
            document.getElementById('sgsttotal').value = 0;
            document.getElementById('igsttotal').value = 0;
            document.getElementById('cgsttotal').value = 0;
            var value7 = parseInt(value1);
            var value9 = parseInt(value3);
            var addition = value7 + value9;
            document.getElementById('total').value = addition;
        } else {
            gstshow()
        }
    }

</script>
<script>
    gstshow();
 myFunction()
    function gstshow() {
        var statecode = document.getElementById('statecode').value;

        if (statecode == '07') {
            document.getElementById('cgst').value = 9;
            document.getElementById('sgst').value = 9;
            document.getElementById('igst').value = 0;
        } else {
            document.getElementById('igst').value = 18;
            document.getElementById('cgst').value = 0;
            document.getElementById('sgst').value = 0;

        }
        calc();

    }

    function calc() {
        var value1 = document.getElementById('amount').value;

        var value3 = document.getElementById('pocketexpenseamount').value;
        var value4 = document.getElementById('igst').value;
        var value5 = document.getElementById('cgst').value;
        var value6 = document.getElementById('sgst').value;

        var value7 = parseInt(value1);
        var value9 = parseInt(value3);
        var value10 = parseInt(value4);
        var value11 = parseInt(value5);
        var value12 = parseInt(value6);


        var addition = value7 + value9;
        //  debugger;


        var igst = addition * value10 / 100;

        var cgst = addition * value11 / 100;
        var sgst = addition * value12 / 100;

        document.getElementById('sgsttotal').value = sgst;
        document.getElementById('igsttotal').value = igst;
        document.getElementById('cgsttotal').value = cgst;
        document.getElementById('outtotal').value = value9;

        var result = igst + cgst + sgst + addition;
        //    alert(result);
        document.getElementById('total').value = result;
    }

</script>
<script>
    function switchVisible() {
        if (document.getElementById('Div1')) {

            if (document.getElementById('Div1').style.display == 'none') {
                document.getElementById('Div1').style.display = 'block';
                document.getElementById('Div2').style.display = 'none';
            } else {
                document.getElementById('Div1').style.display = 'none';
                document.getElementById('Div2').style.display = 'block';
            }
        }
    }

</script>
<script type="text/javascript">
    var i = 0;
    $("#add-btn").click(function () {
        ++i;
        $("#dynamicAddRemove").append('<tr><td><input type="text" name="moreFields[' + i +
            '][title]" placeholder="Enter Service" class="form-control" /></td><td><input type="number" name="moreFields[' +
            i +
            '][title]" placeholder="Enter Amount" class="form-control" /></td><td><a type="button" class="remove-tr"><img src="{{ url('
            backEnd / image / remove - icon.png ')}}"/></a></td></tr>');
    });
    $(document).on('click', '.remove-tr', function () {
        $(this).parents('tr').remove();
    });

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(function () {
        $('#category').on('change', function () {
            var category_id = $(this).val();

            $.ajax({
                type: "GET",
                url: "{{ url('invoiceajax/create') }}",
                data: "category_id=" + category_id,
                success: function (response) {
                    $("#mobileno").val(response.mobileno);
                    $("#gstno").val(response.gstno);
					 $("#panno").val(response.panno);
                    $("#name").val(response.name);
                    $("#emailid").val(response.emailid);
                    $("#c_address").val(response.c_address);


                },
                error: function () {

                },
            });
        });
        $('#financialyear').on('change', function () {
            var category_id = document.getElementById("company").value; 
            var selectedvalue = $(this).val();

            if (category_id == 0) {
                var vale = null;
                $("#invocieno").val(vale);
                alert('please select company');
            } else {
                $.ajax({
                    type: "GET",
                    url: "{{ url('invoicecompany/create') }}",
                     data:{
                        category_id:category_id, 
                  selectedvalue:selectedvalue
                },
              
                    success: function (response) {

                        if (response.invocieno == null) {
                            // debugger;
                            //   document.getElementById('invocieno').value = 1001;
                            $("#invocieno").val(01);
                        } else {
                            $("#invocieno").val(response.invocieno);
                        }


                    },
                    error: function () {

                    },
                });
            }


        });
        $('#company').on('change', function () {
            var category_id = $(this).val();

            $.ajax({
                type: "GET",
                url: "{{ url('companycode/create') }}",
                data: "category_id=" + category_id,
                success: function (response) {
                    $("#company_code").val(response.company_code);

                },
                error: function () {

                },
            });
        });
    });

</script>
<script>
    $(function(){
       $('#currency').on('change',function(){
           var category_id =$(this).val();
           debugger;
        $.ajax({
            type: "GET",
            url: "{{ url('invoice/create') }}",
            data: "category_id="+category_id,
            success : function(res){
            
                $('#currency_id').html(res);

                
            },
            error : function(){

            },
        });
       });
     }); 
 </script>
 <script>
        $(function(){
           $('#category').on('change',function(){
               var category_id =$(this).val();
    
            $.ajax({
                type: "GET",
                url: "{{ url('invoiceassignment') }}",
                data: "category_id="+category_id,
                success : function(res){
                
                    $('#subcategory_id').html(res);
    
                    
                },
                error : function(){
    
                },
            });
           });
         }); 
     </script>