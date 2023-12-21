
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Employee *</label>
            <select class="form-control basic-multiple" id="employee" name="teammember_id" 
            @if(Request::is('neft/*/edit'))> <option
                disabled style="display:block">Please Select One</option>

                @foreach($teammember as $teamData)
                <option value="{{$teamData->id}}"
                    {{$neft->teammember_id == $teamData->id ??'' ?'selected="selected"' : ''}}>
                    {{$teamData->team_member }}( {{ $teamData->role->rolename}} )</option>
                @endforeach

                @else
                <option value="">Please Select One</option>
                @foreach($teammember as $teamData)
                <option value="{{$teamData->id}}">
                    {{ $teamData->team_member }}( {{ $teamData->role->rolename}} )</option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-4">
    <div class="form-group">
        <label class="font-weight-600">Name As Per Bank Account </label>
        <input type="text" name="name_as_per_bankaccount" class="form-control" value="{{ $neft->name_as_per_bankaccount ??'' }}"
            placeholder="Enter Bank Account">
    </div>
</div>
	 <div class="col-4">
        <div class="form-group">
        <label class="font-weight-600">Name of Bank </label>
        <input type="text" name="nameofbank" id="nameofbank" class="form-control" value="{{ $neft->nameofbank??'' }}"
            placeholder="Enter Name of Bank">  
        </div>
    </div>
    
</div>
<div class="row row-sm">
<div class="col-4">
    <div class="form-group">
        <label class="font-weight-600">Bank Account </label>
        <input type="text" name="bankaccountnumber" id="bankaccountnumber" class="form-control" value="{{ $neft->bankaccountnumber??'' }}"
            placeholder="Enter Bank Account">
    </div>
</div>	
<div class="col-4">
        <div class="form-group">
        <label class="font-weight-600">IFSC Code </label>
        <input type="text" name="ifsccode" id="ifsccode" class="form-control" value="{{ $neft->ifsccode??'' }}"
            placeholder="Enter IFSC Code">  
        </div>
    </div>
    <div class="col-4">
    <div class="form-group">
        <label class="font-weight-600">Payment Type</label>
        <select name="paymenttype" id="paymenttype" class="form-control">
            <!--placeholder-->
            @if(Request::is('neft/*/edit')) >
            @if($neft->paymenttype=='0')
            <option value="0">Conveyance</option>
            <option value="1">Salary</option>
            <option value="2">Reimbursement</option>
            <option value="3">Asset Procurement</option>
            
            @elseif($neft->paymenttype=='1')
            <option value="1">Salary</option>
            <option value="0">Conveyance</option>
            <option value="2">Reimbursement</option>
            <option value="3">Asset Procurement</option>
			
            @elseif($neft->paymenttype=='2')
            <option value="2">Reimbursement</option>
            <option value="0">Conveyance</option>
            <option value="1">Salary</option>
            <option value="3">Asset Procurement</option>
			
            @else
            <option value="2">Reimbursement</option>
            <option value="0">Conveyance</option>
            <option value="1">Salary</option>
            <option value="3">Asset Procurement</option>
			
            @endif
            @else
            <option value="">Please Select One</option>
            <option value="0">Conveyance</option>
            <option value="1">Salary</option>
            <option value="2">Reimbursement</option>
            <option value="3">Asset Procurement</option>
            @endif
        </select>
    </div>
</div>
</div>
<div class="row row-sm">
	    
<div class="col-4" id="payment" style="display: none">
    <div class="form-group">
        <label class="font-weight-600">Local Conveyance </label>
        <select class="form-control basic-multiple" multiple="multiple" name="localconveyance_id[]" 
            @if(Request::is('neft/*/edit'))> <option
                disabled style="display:block">Please Select One</option>

                @foreach($localconveyance as $localconveyanceData)
                <option value="{{$localconveyanceData->id}}"
                    {{$neft->localconveyance_id == $localconveyanceData->id ??'' ?'selected="selected"' : ''}}>
                    {{$localconveyanceData->Nature }}</option>
                @endforeach

                @else
                <option value="">Please Select One</option>
                @foreach($localconveyance as $localconveyanceData)
                <option value="{{$localconveyanceData->id}}">
                    {{ $localconveyanceData->Nature }}</option>

                @endforeach
                @endif
            </select>
    </div>
</div>	
</div>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('/neft') }}">
        Back</a>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(function () {
        $('#employee').on('change', function () {
            var employee_id = $(this).val();

            $.ajax({
                type: "GET",
                url: "{{ url('neftajax/create') }}",
                data: "employee_id=" + employee_id,
                success: function (response) {
                //  debugger;
                    $("#nameofbank").val(response.nameofbank);
					 $("#bankaccountnumber").val(response.bankaccountnumber);
                    $("#ifsccode").val(response.ifsccode);
                   
                },
                error: function () {

                },
            });
        });
 
    });

</script>

<script>
  $(document).ready(function(){
  $('#paymenttype').on('change', function() {
    if ( this.value == '0')
    {
      $("#payment").show();
      document.getElementById("bachelorcertificate").required = true;
      	  
    }
    
    else
    {
      $("#payment").hide();
     
      
    }
  });
});
</script>