<div class="row row-sm ">
    <div class="col-12">
        <div class="form-group">
            <label class="fs-17 font-weight-600 mb-0"><b>Client Details</b></label>
        </div>
    </div>
</div>
<hr>
<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Name of Client (Full Name). *</label>
            <select class="language form-control" id="exampleFormControlSelect1" name="client_id"
                @if(Request::is('localconveyance/*/edit'))> <option disabled style="display:block">Please Select One
                </option>

                @foreach($client as $clientData)
                <option value="{{$clientData->id}}"
                    {{$localconveyance->client_id== $clientData->id??'' ?'selected="selected"' : ''}}>
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
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Date & Assignment Appraisal Submited. *</label>
            <select class="form-control" name="dateassignment">
                
                @if(Request::is('localconveyance/*/edit')) >
                @if($localconveyance->dateassignment=='Yes')
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
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Audit Place. *</label>
            <input type="text" id="example-date-input" name="place" value="{{ $localconveyance->place ??'' }}" class="form-control"
                placeholder="Enter Audit Place.">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Nature/Type of Audit/Work *</label>
            <input type="text" id="example-date-input" name="Nature" value="{{ $localconveyance->Nature ??'' }}" class="form-control"
                placeholder="Enter Nature/Type of Audit/Work">
        </div>
    </div>
</div>
<br>
<div class="row row-sm ">
    <div class="col-12">
        <div class="form-group">
            <label class="fs-17 font-weight-600 mb-0"><b>Audit Period</b></label>
        </div>
    </div>
</div>
<hr>
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Audit Period from Date. *</label>
            <input type="date" id="example-date-input" name="Audit_from_date" value="{{ $localconveyance->Audit_from_date ??'' }}" class="form-control">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Audit Period to Date. *</label>
            <input type="date" id="example-date-input" name="Audit_period_date" value="{{ $localconveyance->Audit_period_date ??'' }}" class="form-control">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Remarks (If Any). *</label>
            <input type="text" id="localconveyance-img" name="Remarks" value="{{ $localconveyance->Remarks ??'' }}" class="form-control"
                placeholder="Enter Remarks">
        </div>
    </div>
</div>
<br>
<div class="row row-sm">

    <div class="col-12">
        <div class="form-group">
            <label class="fs-17 font-weight-600 mb-0"><b>Attendance</b></label>
        </div>
    </div>
</div>
<hr>

   <div class="row row-sm ">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Visiting Period from Date. *</label>
            <input type="date" onchange="calc();" id="dateInput1" name="Visiting_from_date" value="{{ $localconveyance->Visiting_from_date ??'' }}" class="form-control">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Visiting Period to Date. *</label>
            <input type="date" onchange="calc();" id="dateInput2" name="Visiting_date" value="{{ $localconveyance->Visiting_date ??'' }}" class="form-control">
        </div>
    </div>

    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Leave Day’s. *</label>
            <input type="number" onchange="calc();" id="leave" name="leave_day" value="{{ $localconveyance->leave_day ??'' }}" class="form-control"
                placeholder="Enter Leave Day’s">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Total Number of Day’s Spent. *</label>
            <input type="number" id="total" name="totaldays" value="{{ $localconveyance->totaldays ??'' }}" class="form-control"
                placeholder="Enter Total Number of Day’s Spent">
        </div>
    </div>

</div>
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
            <label class="font-weight-600">Approved Conveyance (Rs). *</label>
            <input type="number" onchange="cal();" id="Approved" name="Approved_Conveyance" value="{{ $localconveyance->Approved_Conveyance ??'' }}" class="form-control"
                placeholder="Enter Approved Conveyance (Rs)">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Total Value. *</label>
            <input type="number" id="totalvalue" name="Total_Value" value="{{ $localconveyance->Total_Value ??'' }}" class="form-control"
                placeholder="Enter Total Value">
        </div>
    </div>

    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Bill Paid By. *</label>
            <select class="form-control" name="billpaid">
               
                @if(Request::is('localconveyance/*/edit')) >
                @if($localconveyance->billpaid=='Office')
                <option value="Office">Office</option>
                <option value="Client">Client</option>
                <option value="Self">Self</option>

                @elseif($localconveyance->billpaid=='Client')
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


</div>
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Copy of Supporting files</label>
            <input type="file" id="localconveyance-img" name="attachment[]" multiple="multiple"
                class="form-control"
                placeholder="Enter Copy of Supporting files">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Recoverable from Client</label>
            <select class="form-control" name="Recoverable">
                
                    @if(Request::is('localconveyance/*/edit')) >
                    @if($localconveyance->Recoverable=='Yes')
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
<div class="row row-sm ">
    <div class="col-12">
        <div class="form-group">
            <label class="fs-17 font-weight-600 mb-0"><b>For Office Use</b></label>
        </div>
    </div>
</div>
<hr>
<div class="row row-sm">

    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Passed By</label>
            <input type="text" id="example-date-input" name="Passed" value="{{ $localconveyance->Passed ??'' }}" class="form-control"
                placeholder="Enter Passed By">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Approved By</label>
            <input type="text" id="example-date-input" name="Approved" value="{{ $localconveyance->Approved ??'' }}" class="form-control"
                placeholder="Enter Approved By">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Total Amount Payable/(Recoverable)</label>
            <input type="text" id="example-date-input" name="Total_Amount_Payable" value="{{ $localconveyance->Total_Amount_Payable ??'' }}" class="form-control"
                placeholder="Enter Total Amount Payable/(Recoverable)">
        </div>
    </div>
</div>
<div class="row row-sm">

    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Client Invoice Number</label>
            <input type="text" id="example-date-input" name="Client_Invoice_Number" value="{{ $localconveyance->Client_Invoice_Number ??'' }}" class="form-control"
                placeholder="Enter Client Invoice Number">
        </div>
    </div>
    @if(Request::is('localconveyance/*/edit'))  
    @if(23 == Auth::user()->teammember_id)
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Status</label>
            <select name="Status" id="exampleFormControlSelect1" class="form-control">
                <!--placeholder-->
                @if(Request::is('localconveyance/*/edit')) >
                @if($localconveyance->Status=='0')
                <option value="0">Created</option>
                <option value="1">Approved</option>
                <option value="2">Rejected</option>
                <option value="3">Submitted</option>
                @elseif($localconveyance->Status=='1')
                <option value="1">Approved</option>
                <option value="0">Created</option>
               
                <option value="2">Rejected</option>
                <option value="3">Submitted</option>

                @elseif($localconveyance->Status=='2')
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
    @if(Request::is('localconveyance/create')) 
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    @endif
    @if(Request::is('localconveyance/*/edit')) 
    @if($localconveyance->Status=='0' || $localconveyance->Status=='4')
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    @endif
    @if(Auth::user()->role_id == 17)
    @if($localconveyance->Status != '3')
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    @endif
    @endif
    @endif
    <a class="btn btn-secondary" href="{{ url('localconveyance') }}">
        Back</a>

</div>
<script>
    function calc() {
        var dateI1 = document.getElementById('dateInput1').value;

        var dateI2 = document.getElementById('dateInput2').value;
        var leave = document.getElementById('leave').value;
         //define two date object variables to store the date values
         var date1 = new Date(dateI1);
         var date2 = new Date(dateI2);
         var leav = parseInt(leave);

         //calculate time difference
         var time_difference = date2.getTime() - date1.getTime();

          //calculate days difference by dividing total milliseconds in a day
          var totalnumber = time_difference / (1000 * 60 * 60 * 24);
          
          var result = totalnumber - leav;

        document.getElementById('total').value = result;
    }
</script>
<script>
    function cal() {
        var Approved = document.getElementById('Approved').value;
        var total = document.getElementById('total').value;
         var Approved1 = parseInt(Approved);
         var total2 = parseInt(total);
          var result = Approved1 * total2;

        document.getElementById('totalvalue').value = result;
    }
</script>
