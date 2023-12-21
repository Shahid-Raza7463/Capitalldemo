<div class="row row-sm ">
    <div class="col-12">
        <div class="form-group">
            <label class="fs-17 font-weight-600 mb-0"><b>Client Details</b></label>
        </div>
    </div>
</div>
<hr>
<div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Name of Client</label>
            <select class="language form-control" id="client" name="client_id"
                @if(Request::is('outstationconveyance/*/edit'))> <option readonly style="display:block">Please Select
                One
                </option>

                @foreach($client as $clientData)
                <option value="{{$clientData->id}}"
                    {{$outstationconveyance->client_id== $clientData->id??'' ?'selected="selected"' : ''}}>
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
            <label class="font-weight-600">Advance Transaction Number</label>
            <input type="text" readonly id="assignmentgenerate_id" name="assignmentgenerate_id"
                value="{{ $outstationconveyance->assignmentgenerate_id ?? '0'}}" class="form-control">
        </div>
    </div>
    <div class="col-2">
        <div class="form-group">
            <label class="font-weight-600">Assignment Name*</label>
            <select class="form-control key" required name="assignment_id" id="assignment_id">
                @if(!empty($outstationconveyance->assignment_id))
                <option value="{{ $outstationconveyance->assignment_id }}">
                    {{ App\Models\Assignment::where('id',$outstationconveyance->assignment_id)->first()->assignment_name??'' }}
                </option>

                @endif </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Data & Assignment Appraisal Submited</label>
            <select class="form-control" name="Assignment">
                @if(Request::is('outstationconveyance/*/edit')) >
                @if($outstationconveyance->Assignment=='Yes')
                <option value="Yes">Yes</option>
                <option value="No">No</option>


                @else
                <option value="No">No</option>
                <option value="Yes">Yes</option>



                @endif
                @else

                <option value="">Please Select One</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>

                @endif

            </select>
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
            <label class="fs-17 font-weight-600 mb-0"><b>Audit Period</b></label>
        </div>
    </div>
</div>
<hr>
<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Audit Period from Date</label>
            <input type="date" required id="example-date-input" name="Audit_from_date"
                value="{{ $outstationconveyance->Audit_from_date ?? ''}}" class="form-control">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Audit Period to Date</label>
            <input type="date" required id="example-date-input" name="Audit_period_date"
                value="{{ $outstationconveyance->Audit_period_date ?? ''}}" class="form-control">
        </div>
    </div>
</div>
<div class="row row-sm ">
    <div class="col-12">
        <div class="form-group">
            <label class="fs-17 font-weight-600 mb-0"><b>Visiting Period</b></label>
        </div>
    </div>
</div>
<hr>
<div class="row row-sm">

    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Visiting Period from Date</label>
            <input type="date" required id="Visiting_from_date" name="Visiting_from_date"
                value="{{ $outstationconveyance->Visiting_from_date ?? ''}}" class="form-control">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Visiting Period to Date</label>
            <input type="date" required id="Visiting_date" name="Visiting_date"
                value="{{ $outstationconveyance->Visiting_date ?? ''}}" class="form-control">
        </div>
    </div>

</div>

<div class="row row-sm ">
    <div class="col-12">
        <div class="form-group">
            <label class="fs-17 font-weight-600 mb-0"><b>Conveyance</b></label>
        </div>
    </div>
</div>
<hr>
<div class="row row-sm">
   
    <div class="col-4" id="conveyancegen"
      @if(Request::is('outstationconveyance/*/edit') && $outstationconveyance->assignmentgenerate_id != null)
        @else   style="display: none"  @endif>
        <div class="form-group">
            <label class="font-weight-600">Choose Conveyance *</label>
            <select class="form-control key" id="conveyance" name="conveyance">
                @if(!empty($outstationconveyance->conveyance))
                <option value="{{ $outstationconveyance->conveyance }}">
                    {{ App\Models\outstationconveyance::
                    where('id',$id)->first()->conveyance??'' }}
                </option>
                @endif </select>
        </div>
    </div>
  
    <div class="col-4" id="conveyancenongenerate" 
     @if(Request::is('outstationconveyance/*/edit') && $outstationconveyance->assignmentgenerate_id == null)
     @else  style="display: none"
        @endif>
        <div class="form-group">
            <label class="font-weight-600">Choose Conveyance. *</label>
            <select name="chooseconveyance" id="conveyancenongenerateconveyance" class="form-control">
                <!--placeholder-->
                @if(Request::is('outstationconveyance/*/edit')) >
                @if($outstationconveyance->chooseconveyance=='Local Conveyance')
                <option value="Local Conveyance">Local Conveyance</option>
                <option value="Outstation Conveyance">Outstation Conveyance</option>

                @else
                <option value="Outstation Conveyance">Outstation Conveyance</option>
                <option value="Local Conveyance">Local Conveyance</option>
               

                @endif
                @else

                <option value="">Please Select One</option>
                <option value="Local Conveyance">Local Conveyance</option>
                <option value="Outstation Conveyance">Outstation Conveyance</option>
                @endif
            </select>
        </div>
    </div>

</div>
<div id="local" @if(Request::is('outstationconveyance/*/edit') && $outstationconveyance->Total_Value != null)
    @else style="display:none;" @endif>
    <div class="row row-sm ">
        <div class="col-12">
            <div class="form-group">
                <label class="fs-17 font-weight-600 mb-0"><b>Amount Details</b></label>
            </div>
        </div>
    </div>
    <hr>
    <div class="row row-sm">

        <div class="col-4">
            <div class="form-group">
                <label class="font-weight-600">Approved Rate of TA/Day. *</label>
                <input type="number" onchange="calcc();" id="localapprovedrate" name="localapprovedrate"
                    value="{{ $outstationconveyance->localapprovedrate ??'0' }}" class="form-control"
                    placeholder="Enter Approved Rate of TA/Day">
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label class="font-weight-600">No of Days Present. *</label>
                <input type="number" onchange="calcc();" id="localnoofday" name="localnoofday" 
                value="{{ $outstationconveyance->localnoofday ??'0' }}"
                    class="form-control" placeholder="Enter No of Days.">
            </div>
        </div>
    </div>
    <div class="row row-sm">

        <div class="col-4">
            <div class="form-group">
                <label class="font-weight-600">Travel. *</label>
                <input type="number" onchange="calcc();" id="localtravel" name="localtravel"
                    value="{{ $outstationconveyance->localtravel ??'0' }}" class="form-control"
                    placeholder="Enter Total Value">
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label class="font-weight-600"> Supporting File. *</label>
                <input type="file" id='Travelsupportingfile' name="Travelsupportingfile" value="{{ $outstationconveyance->travelfood ??'0' }}"
                    class="form-control" placeholder="Enter Total Value">
            </div>
        </div>
        {{-- <div class="col-4">
            <div class="form-group">
                <label class="font-weight-600">Remarks. </label>
                <input type="text" name="travelremark" value="{{ $outstationconveyance->travelremark ??'' }}"
                    class="form-control" placeholder="Enter Remarks">
            </div>
        </div> --}}
    </div>
    <div class="row row-sm">
        <div class="col-4">
            <div class="form-group">
                <label class="font-weight-600"> Food. *</label>
                <input type="number" onchange="calcc();" id="localfood" name="localfood"
                    value="{{ $outstationconveyance->localfood ??'0' }}" class="form-control"
                    placeholder="Enter Total Value">
            </div>
        </div>
        <div class="col-4" id="Travelfoodsupportingfile" style="display: none;">
            <div class="form-group">
                <label class="font-weight-600"> Supporting File. *</label>
                <input type="file" id='Travelfoodsupportingfiler' name="Travelfoodsupportingfile" value="{{ $outstationconveyance->travelfood ??'0' }}"
                    class="form-control" placeholder="Enter Total Value">
            </div>
        </div>
        {{-- <div class="col-4">
            <div class="form-group">
                <label class="font-weight-600">Remarks. </label>
                <input type="text" name="travelfoodremark" value="{{ $outstationconveyance->travelfoodremark ??'' }}"
                    class="form-control" placeholder="Enter Remarks">
            </div>
        </div> --}}
    </div>
    <div class="row row-sm">

        <div class="col-3">
            <div class="form-group">
                <label class="font-weight-600">Miscellaneous. *</label>
                <input type="number" onchange="calcc();" id="travelMiscellaneous" name="travelMiscellaneous"
                    value="{{ $outstationconveyance->travelMiscellaneous ??'0' }}" class="form-control"
                    placeholder="Enter Total Value">
            </div>
        </div>
        <div class="col-3" id="TravelMiscellaneoussupportingfile" style="display: none;">
            <div class="form-group">
                <label class="font-weight-600"> Supporting File. *</label>
                <input type="file" id='TravelMiscellaneoussupportingfiler' name="TravelMiscellaneoussupportingfile"
                    value="{{ $outstationconveyance->TravelMiscellaneoussupportingfile ??'0' }}" class="form-control"
                    placeholder="Enter Total Value">
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label class="font-weight-600">Remarks. </label>
                <input type="text" name="travelMiscellaneousremark" value="{{ $outstationconveyance->travelMiscellaneousremark ??'' }}"
                    class="form-control" placeholder="Enter Remarks">
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label class="font-weight-600">Total Value. *</label>
                <input type="number" id="totalvalue" name="Total_Value"
                    value="{{ $outstationconveyance->Total_Value ??'0' }}" class="form-control"
                    placeholder="Enter Total Value">
            </div>
        </div>
    </div>
    <div class="row row-sm">
        <div class="col-3">
            <div class="form-group">
                <label class="font-weight-600">Approved Conveyance (Rs). *</label>
                <input type="number" onchange="calcc();" id="Approved" name="Approved_Conveyance"
                    value="{{ $outstationconveyance->Approved_Conveyance ??'' }}" class="form-control"
                    placeholder="Enter Approved Conveyance (Rs)">
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label class="font-weight-600">Bill Paid By. *</label>
                <select class="form-control" name="billpaid">

                    @if(Request::is('outstationconveyance/*/edit')) >
                    @if($outstationconveyance->billpaid=='Office')
                    <option value="Office">Office</option>
                    <option value="Client">Client</option>
                    <option value="Self">Self</option>

                    @elseif($outstationconveyance->billpaid=='Client')
                    <option value="Client">Client</option>
                    <option value="Office">Office</option>
                    <option value="Self">Self</option>

                    @else
                    <option value="Self">Self</option>
                    <option value="Office">Office</option>
                    <option value="Client">Client</option>


                    @endif
                    @else

                    <option value="">Please Select One</option>
                    <option value="Office">Office</option>
                    <option value="Client">Client</option>
                    <option value="Self">Self</option>
                    @endif
                </select>
            </div>
        </div>
        {{-- <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Copy of Supporting files *</label>
            <input type="file" id="localconveyance-img" name="attachment[]" multiple="multiple"
                class="form-control"
                placeholder="Enter Copy of Supporting files">
        </div>
    </div> --}}
        <div class="col-3">
            <div class="form-group">
                <label class="font-weight-600">Recoverable from Client</label>
                <select class="form-control" id='Recoverable' name="Recoverable">

                    @if(Request::is('outstationconveyance/*/edit')) >
                    @if($outstationconveyance->Recoverable=='Yes')
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>


                    @else
                    <option value="No">No</option>
                    <option value="Yes">Yes</option>



                    @endif
                    @else

                    <option value="">Please Select One</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>

                    @endif
                </select>
            </div>
        </div>

    </div>
</div>

<div class="row row-sm " id="outstationn"   @if(Request::is('outstationconveyance/*/edit')
 && $outstationconveyance->Travelling_BILL > 0) 
    @else style="display: none;" @endif>
    <div class="col-12">
        <div class="form-group">
            <label class="fs-17 font-weight-600 mb-0"><b>Tickets Details</b></label>
        </div>
    </div>

    <hr>
    <div class="row row-sm">
        <div class="col-6">
            <div class="form-group">
                <label class="font-weight-600">Tickets Booked By</label>
                <select class="form-control" id="Tickets_Booked_By" name="Tickets_Booked_By">
                    @if(Request::is('outstationconveyance/*/edit')) >
                    @if($outstationconveyance->Tickets_Booked_By=='Office')
                    <option value="Office">Office</option>
                    <option value="Client">Client</option>
                    <option value="Self">Self</option>

                    @elseif($outstationconveyance->Tickets_Booked_By=='Client')
                    <option value="Client">Client</option>
                    <option value="Office">Office</option>
                    <option value="Self">Self</option>

                    @else
                    <option value="Self">Self</option>
                    <option value="Office">Office</option>
                    <option value="Client">Client</option>


                    @endif
                    @else

                    <option value="">Please Select One</option>
                    <option value="Office">Office</option>
                    <option value="Client">Client</option>
                    <option value="Self">Self</option>
                    @endif

                </select>
            </div>
        </div>
        <div class="col-6" id='tickets' style="display: none;" >
            <div class="form-group">
                <label class="font-weight-600">Fare (Total Ticket Value in Rs.)</label>
                <input type="number" onchange="calc();" id="ticket" name="Fare"
                    value="{{ $outstationconveyance->Fare ?? '0'}}" class="form-control" placeholder="Enter Fare">
            </div>
        </div>

    </div>
</div>
<div>
    <div class="row row-sm " id="outstation" 
    @if(Request::is('outstationconveyance/*/edit') && $outstationconveyance->Travelling_BILL > 0) 
       @else style="display: none;" @endif>
        <div class="col-12">
            <div class="form-group">
                <label class="fs-17 font-weight-600 mb-0"><b>Other Incidental Expenses</b></label>
            </div>
        </div>

        <hr>
        <div class="row row-sm">
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600">Approved Rate of TA/Day</label>
                    <input type="number" onchange="calc();" id="ApprovedRate" name="Approved_Rate"
                        value="{{ $outstationconveyance->Approved_Rate ?? '0'}}" class="form-control"
                        placeholder="Enter Approved Rate of TA/Day">
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600">No of Days Present</label>
                    <input type="number" onchange="calc();" id="outstationnoofday" name="outstationnoofday"
                        value="{{ $outstationconveyance->outstationnoofday ?? '0'}}" class="form-control"
                        placeholder="Enter No of Days">
                </div>
            </div>
            
            <div class="col-1">
                <div class="form-group">
                    <label class="font-weight-600">TA Claimed </label>
                    <input type="number" onchange="calc();" id="claimed" name="TA_Claimed"
                        value="{{ $outstationconveyance->TA_Claimed ?? '0'}}" class="form-control"
                        placeholder="Enter TA Claimed">
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600">Conveyance Charges (Rs.)</label>
                    <input type="number" onchange="calc();" id="conveyances" name="Conveyance_Charges"
                        value="{{ $outstationconveyance->Conveyance_Charges ?? '0'}}" class="form-control"
                        placeholder="Enter Conveyance Charges">
                </div>
            </div>
            <div class="col-2"  id="Conveyance_file" style="display: none;">
                <div class="form-group">
                    <label class="font-weight-600">Conveyance File</label>
                    <input type="file" name="Conveyance_file" class="form-control"
                        placeholder="Enter Conveyance Charges">
                </div>
            </div>

            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600">During Journey (In Rs.)</label>
                    <input type="number" onchange="calc();" id="journey" name="During_Journey"
                        value="{{ $outstationconveyance->During_Journey ?? '0'}}" class="form-control"
                        placeholder="Enter During Journey">
                </div>
            </div>
            <div class="col-2" id="During_Journeyfile" style="display: none;">
                <div class="form-group">
                    <label class="font-weight-600">During Journey File</label>
                    <input type="file" name="During_Journeyfile" class="form-control"
                        placeholder="Enter During Journey">
                </div>
            </div>

            <div class="col-3">
                <div class="form-group">
                    <label class="font-weight-600">Miscellaneous Exp In Rs.(Please Specify)</label>
                <input type="number" onchange="calc();" id="miscellaneous" name="Miscellaneous_Exp"
                        value="{{ $outstationconveyance->Miscellaneous_Exp ?? '0'}}" class="form-control"
                        placeholder="Enter Miscellaneous Exp In Rs">
                </div>
            </div>

            <div class="col-3" id="Miscellaneous_Expfile" style="display: none;">
                <div class="form-group">
                    <label class="font-weight-600">Miscellaneous Exp In File</label>
                    <input type="file" id="Miscellaneous_Expfile" name="Miscellaneous_Expfile" class="form-control"
                        placeholder="Enter Miscellaneous Exp In Rs">
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600">Food Expenses with Bill </label>
                    <input type="number" onchange="calc();" id="food" name="Food_Expenses"
                        value="{{ $outstationconveyance->Food_Expenses ?? '0'}}" class="form-control"
                        placeholder="Enter Food Expenses with Bill">
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600">Food Expenses File </label>
                    <input type="file" name="Food_Expensesfile"
                        value="{{ $outstationconveyance->Food_Expenses ?? '0'}}" class="form-control"
                        placeholder="Enter Food Expenses with Bill">
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600">Total Travelling BILL</label>
                    <input type="number" onchange="calc();" id="total" name="Travelling_BILL"
                        value="{{ $outstationconveyance->Travelling_BILL ?? '0'}}" class="form-control"
                        placeholder="Enter Travelling BILL">
                </div>
            </div>
        </div>
    </div>

  
    <div class="row row-sm " id="Advancedetails" 
    @if(Request::is('outstationconveyance/*/edit') && $outstationconveyance->advanceamountrequired != null) 
       @else style="display: none" @endif>
        <div class="col-12">
            <div class="form-group">
                <label class="fs-17 font-weight-600 mb-0"><b>Advance Details</b></label>
            </div>
        </div>
    </div>
    <hr>
    <div class="row row-sm" id="Advancedetailsform"  @if(Request::is('outstationconveyance/*/edit') && $outstationconveyance->advanceamountrequired != null) 
        @else style="display: none" @endif>
        <div class="col-3">
            <div class="form-group">
                <label class="font-weight-600">Advance Amount Requested.</label>
                <input type="number" readonly id="advanceamount" name="advanceamountrequired"
                    value="{{ $outstationconveyance->advanceamountrequired ?? ''}}" class="form-control"
                    placeholder="Enter Advance Amount Requested.">
            </div>
        </div>

        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600">Advance Amount Given.</label>
                <input type="number" onchange="calc();" readonly id="Advance_Amount" name="AdvanceAmountgiven"
                    value="{{ $outstationconveyance->AdvanceAmountgiven ?? '0'}}" class="form-control"
                    placeholder="Enter Advance Amount Given.">
            </div>
        </div>
        <div class="col-2" id="locals" style="display:none;">
            <div class="form-group">
                <label class="font-weight-600">Net Receivable / Payable</label>
                <input type="number" name="localsreceivable_payable" id="netreceivablep" class="form-control">
            </div>
        </div>
        <div class="col-2">
            <div class="form-group" id="outstationnn" style="display: none;">
                <label class="font-weight-600">Net Receivable / Payable</label>
                <input type="number" name="outstationnnreceivable_payable" id="netreceivablepout" class="form-control">
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label class="font-weight-600">Mark only one oval.</label>
                <select class="form-control" name="oval">
                    @if(Request::is('outstationconveyance/*/edit')) >
                    @if($outstationconveyance->oval=='Cash')
                    <option value="Cash">Cash</option>
                    <option value="Bank Account">Bank Account</option>


                    @else
                    <option value="Bank Account">Bank Account</option>
                    <option value="Cash">Cash</option>



                    @endif
                    @else

                    <option value="">Please Select One</option>
                    <option value="Cash">Cash</option>
                    <option value="Bank Account">Bank Account</option>

                    @endif
                </select>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600">Any Comment.</label>
                <input type="text" name="anycomment" value="{{ $outstationconveyance->anycomment ?? ''}}"
                    class="form-control" placeholder="Enter Any Comment.">
            </div>
        </div>

    </div>
    <div class="row row-sm " id="localadvacneheading">
        <div class="col-12">
            <div class="form-group">
                <label class="fs-17 font-weight-600 mb-0"><b>Advance shared with Employees</b></label>
            </div>
        </div>
    </div>
    <hr>
    @if(Request::is('outstationconveyance/create'))
    <div class="field_wrapper" id="localadvacne">
        <div class="row row-sm">
            <div class="col-6">
                <div class="form-group">
                    <label class="font-weight-600">Name</label>
                    <select class="language form-control" id="key" name="teammember_id[]">

                        <option value="">Please Select One</option>
                        @foreach($teammember as $teammemberData)
                        <option value="{{$teammemberData->id}}" @if(!empty($store->
                            financial) && $store->
                            financial==$teammemberData->id) selected @endif>
                            {{ $teammemberData->title->title ??''}}. {{ $teammemberData->team_member }} (
                            {{ $teammemberData->role->rolename }} )</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-5">
                <div class="form-group">
                    <label class="font-weight-600">Amount</label>
                    <input type="number" id="key" name="amount[]" value="{{ $outstationconveyance->amount ?? ''}}"
                        class="form-control" placeholder="Enter Amount">
                </div>
            </div>

            <div class="col-1">
                <div class="form-group" style="margin-top: 36px;">
                    <a href="javascript:void(0);" class="add_buttonn" title="Add field"><img
                            src="{{ url('backEnd/image/add-icon.png')}}" /></a>
                </div>
            </div>


        </div>
    </div>
    @endif
    @if(Request::is('outstationconveyance/*/edit'))
    <div class="table-responsive">
        <table class="table display table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th class="font-weight-600">Name</th>
                    <th class="font-weight-600">Amount </th>

                </tr>
            </thead>
            <tbody>
                @foreach($outstationconveyancesemployee as $outstationconveyancesemployeeData)
                <tr>
                    <td>{{$outstationconveyancesemployeeData->team_member }}</td>
                    <td>{{$outstationconveyancesemployeeData->amount }}</td>

                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    @endif
    <div class="row row-sm">
        <div class="col-3" id="bill">
            <div class="form-group">
                <label class="font-weight-600">Claimable From Client</label>
                <select class="form-control" name="bill">
                    @if(Request::is('outstationconveyance/*/edit')) >
                    @if($outstationconveyance->bill=='Yes')
                    <option value="Yes">Yes
                    </option>
                    <option value="No">No</option>
                    

                     @else
                     <option value="No">No</option>
                    <option value="Yes">Yes
                    </option>
                   



                    @endif
                    @else

                    <option value="">Please Select One</option>
                    <option value="Yes">Yes
                    </option>
                    <option value="No">No</option>
                    
                    @endif

                </select>
            </div>
        </div>
        <div class="col-3" id="Supporting">
            <div class="form-group">
                <label class="font-weight-600">Invoice Attachment</label>
                <input required type="file" id="attachment" name="attachment[]" multiple="multiple"
                    value="{{ $outstationconveyance->attachment ?? ''}}" class="form-control"
                    placeholder="Enter Copy of Supporting files">
            </div>
        </div>
        {{-- <div class="col-3" id="Remarks" >
            <div class="form-group">
                <label class="font-weight-600">Remarks</label>
                <input type="text"name="Remarks"
                    value="{{ $outstationconveyance->Remarks ?? ''}}" class="form-control" placeholder="Enter Remarks">
            </div>
        </div> --}}
        <div class="col-3">
            <div class="form-group">
                <label class="font-weight-600">Invoice Number</label>
                <input required type="text" id="example-date-input" name="invoiceno"
                    value="{{ $outstationconveyance->invoiceno ?? ''}}" class="form-control"
                    placeholder="Enter Invoice no">
            </div>
        </div>
    </div>
    <div class="form-group">
        @if(Request::is('outstationconveyance/*/edit'))
        @if(23 == Auth::user()->teammember_id)
        <div class="col-4">
            <div class="form-group">
                <label class="font-weight-600">Status</label>
                <select name="Status" id="exampleFormControlSelect1" class="form-control">
                    <!--placeholder-->
                    @if(Request::is('outstationconveyance/*/edit')) >
                    @if($outstationconveyance->Status=='0')
                    <option value="0">Created</option>
                    <option value="1">Approved</option>
                    <option value="2">Rejected</option>
                    <option value="3">Submitted</option>
                    @elseif($outstationconveyance->Status=='1')
                    <option value="1">Approved</option>
                    <option value="0">Created</option>

                    <option value="2">Rejected</option>
                    <option value="3">Submitted</option>

                    @elseif($outstationconveyance->Status=='2')
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
        @if(Request::is('outstationconveyance/create'))
        <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
        @endif
        @if(Request::is('outstationconveyance/*/edit'))
        @if($outstationconveyance->Status=='0' || $outstationconveyance->Status=='4')
        <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
        @endif
        @if(Auth::user()->role_id == 17)
        @if($outstationconveyance->Status != '3')
        <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
        @endif
        @endif
        @endif
        <a class="btn btn-secondary" href="{{ url('outstationconveyance') }}">
            Back</a>

    </div>
    <script>
        function calc() {
            // debugger;
            var value1 = 0;
            var value2 = 0;
            var value4 = 0;
            var value5 = 0;
            var value6 = 0;
            var value7 = 0;
            var value15 = 0;
            var value17 = 0;
            var value25 = 0;
            value1 = document.getElementById('ticket').value;
            debugger;
            value2 = document.getElementById('conveyances').value;
            value4 = document.getElementById('journey').value;
            value5 = document.getElementById('miscellaneous').value;
            value6 = document.getElementById('food').value;
            value7 = document.getElementById('claimed').value;
            value17 = document.getElementById('ApprovedRate').value;
            value25 = document.getElementById('outstationnoofday').value;
            value16 = document.getElementById('total').value;
            debugger;
            var value18 = document.getElementById('Advance_Amount').value;
            var value20 = parseInt(value1);
            var value9 = parseInt(value2);

            var value11 = parseInt(value4);
            var value12 = parseInt(value5);
            var value13 = parseInt(value6);
            var value14 = parseInt(value7);
            var value21 = parseInt(value17);
            var value26 = parseInt(value25);
            debugger;
            var totaltaclaimed = value21 * value26;
            debugger;
            if(totaltaclaimed != 0){
                value14=totaltaclaimed;
            }
            else{
                totaltaclaimed=  value14;
            }
            debugger;
           
            var result = value20 + value9 + value11 + value12 + value13 + value14;
            debugger;
            var netreceivable = result - value18;
            document.getElementById('netreceivablepout').value = netreceivable;
            document.getElementById('total').value = result;
            document.getElementById('claimed').value = totaltaclaimed;
        }

    </script>
    <script>
        function calcc() {
            //    debugger;
            var value50 = 0;
            var value51 = 0;
            var value53 = 0;
            var value17 = 0;
            var value25 = 0;
            value50 = document.getElementById('localtravel').value;
            value53 = document.getElementById('localfood').value;
            value51 = document.getElementById('travelMiscellaneous').value;
            var value18 = document.getElementById('Advance_Amount').value;
            value17 = document.getElementById('localapprovedrate').value;
            value25 = document.getElementById('localnoofday').value;
            var value4 = parseInt(value50);
            var value8 = parseInt(value51);
            var value9 = parseInt(value53);
            var value21 = parseInt(value17);
            var value26 = parseInt(value25);

            var totallocaltravel = value21 * value26;
            debugger;
            if(totallocaltravel != 0){
                value4=totallocaltravel;
            }
            else{
                totallocaltravel=  value4;
            }
            debugger;

            var result = value4 + value8 + value9;
            var totalvalue = result;
            var netreceivable = result - value18;
            document.getElementById('totalvalue').value = totalvalue;
            document.getElementById('netreceivablep').value = netreceivable;
            document.getElementById('localtravel').value = totallocaltravel;

        }

    </script>
    <script>
       Visiting_from_date =  document.getElementById('Visiting_from_date').value;
       Visiting_date = document.getElementById('Visiting_date').value;
 
        </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        $(function () {
            $('#client').on('change', function () {
                var cid = $(this).val();
                // alert(category_id);
                $.ajax({
                    type: "get",
                    url: "{{ url('assignmentfunctionn') }}",
                    data: "cid=" + cid,
                    success: function (res) {

                        $('#assignment_id').html(res);
                        debugger;
                    },
                    error: function () {},
                });
            });
        });

    </script>
	<script>
        $(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});
        </script>
    <script>
        $(function () {
            $('#client').on('change', function () {
                var cid = $(this).val();

                // alert(category_id);
                $.ajax({
                    type: "get",
                    url: "{{ url('assignmentoutstation') }}",
                    data: "cid=" + cid,
                    success: function (response) {
                        debugger;
                        //    alert(response.assignmentgenerate_id);
                        $("#assignmentgenerate_id").val(response.assignmentgenerate_id);
                        $("#Advance_Amount").val(response.Advance_Amount);
                        $("#advanceamount").val(response.advanceamount);

                        if (response.assignmentgenerate_id == null) {
                            $("#Advancedetails").hide();
                            $("#Advancedetailsform").hide();
                            $("#conveyancenongenerate").show();
							  document.getElementById("conveyancenongenerateconveyance").required = true;
                            $("#conveyancegen").hide();
                        } else {
                            $("#Advancedetails").show();
                            $("#Advancedetailsform").show();
                            $("#conveyancegen").show();
							  document.getElementById("conveyance").required = true;
                            $("#conveyancenongenerate").hide();
                        }
                    },
                    error: function () {},
                });
            });
        });

    </script>
