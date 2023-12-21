<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Client *</label>
            <select class="form-control" id="category" name="client_id" @if(Request::is('creditnote/*/edit'))> <option
                disabled style="display:block">Please Select One</option>

                @foreach($client as $clientData)
                <option value="{{$clientData->id}}"
                    {{$creditnote->client_id == $clientData->id ??'' ?'selected="selected"' : ''}}>
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
            <label class="font-weight-600">GST no </label>
            <input type="text" name="gstno" id="gstno" class="form-control" value="{{ $creditnote->gstno??'' }}"
                placeholder="Enter GST number">
        </div>
    </div>
    <div class="col-5">
        <div class="form-group">
            <label class="font-weight-600">Client Address </label>
            <input type="text" id="c_address" name="clientaddress" class="form-control"
                value="{{ $creditnote->clientaddress ??'' }}" placeholder="Enter Client Address">
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Contact Name </label>
            <input type="text" name="contact_person" id="name" class="form-control" value="{{ $creditnote->contactname ??'' }}"
                placeholder="Enter Contact Name">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Contact Email </label>
            <input type="email" name="contact_mail" id="emailid" class="form-control"
                value="{{ $creditnote->contactemail ??'' }}" placeholder="Enter Contact Email">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Client Phone </label>
            <input type="text" name="contact_number" id="mobileno" class="form-control" value="{{ $creditnote->phone ??'' }}"
                placeholder="Enter Phone ">
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Invoice No </label>
            <select class="form-control" id="subcategory_id" name="invoice_id">
           
            </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Invoice Date </label>
          
            <input type="text" id="invoicedate" name="invoice_date" class="form-control" value="{{ $creditnote->phone ??'' }}"
            placeholder="Enter Phone ">
        </div>
    </div>
    <div class="col-4">
    <div class="form-group">
        <label class="font-weight-600">State and State code </label>
          <select required class="form-control" onchange="gstshow()" id="statecode" name="statecode"
            @if(Request::is('creditnote/*/edit'))> <option disabled
            style="display:block">Please Select One</option>

            @foreach($statecode as $statecodeData)
            <option value="{{$statecodeData->statecode}}"
            @if(($creditnote->statecode) == $statecodeData->statecode) selected @endif>
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
</div>
<div class="row row-sm">
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
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">CreditNote No.</label>
            <div class="input-group mb-2 mr-sm-2">
                <div class="input-group-prepend">
                    <div class="input-group-text"><input readonly id="company_code" name="companycode" style="
                        border: aliceblue;
                        width: 41px;
                        height: 25px;
                        background: #F4F4F5;
                    "></input></div>
                </div>
                <input readonly type="text" id="creditno" value="{{ $creditnote->credit_note_number ??'' }}" name="creditno"
                    class="form-control" placeholder="Enter Credit No">
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Credit Date.</label>
            <input type="date" name="credit_date" class="form-control" value="{{ $creditnote->credit_date ??'' }}"
            placeholder="Enter Phone ">
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Place of supply.</label>
            <input type="text" name="supply" id="supply" class="form-control" value="{{ $creditnote->supply ??'' }}"
            placeholder="Enter Place of supply ">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">SAC Code</label>
            <input type="text" name="saccode" id="saccode" class="form-control" value="{{ $creditnote->saccode ??'' }}"
            placeholder="Enter Place of supply ">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Out Of Pocket Expense Amount </label>
            <input type="number" required name="pocketexpenseamount" onchange="calc();" id="pocketexpenseamount" class="form-control"
            value="{{ $creditnote->pocketexpenseamount ??'' }}" placeholder="Enter Out Of Pocket Expense Amount">
        </div>
    </div>
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
                <td><textarea rows="3" id="service" name="service" class="form-control"
                        placeholder="Enter Service">{{ $invoice->service ??'' }}</textarea></td>
                <td><input type="number" onchange="calc();" value="{{ $invoice->amount ??'' }}" id="amount"
                        name="amount" placeholder="Enter Amount" class="form-control" /><br>
                   
                </td>
         
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
   <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
 <a class="btn btn-secondary" href="{{ url('creditnote') }}">
        Back</a>

</div>
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
                    $("#name").val(response.name);
                    $("#emailid").val(response.emailid);
                    $("#c_address").val(response.c_address);


                },
                error: function () {

                },
            });
        });
        $('#category').on('change',function(){
           var category_id =$(this).val();

        $.ajax({
            type: "GET",
            url: "{{ url('creditnote/create') }}",
            data: "category_id="+category_id,
            success : function(res){
            
                $('#subcategory_id').html(res);

                
            },
            error : function(){

            },
        });
       });
        $('#subcategory_id').on('change',function(){
           var category_id =$(this).val();

        $.ajax({
            type: "GET",
            url: "{{ url('creditnoteinvoice') }}",
            data: "category_id="+category_id,
            success: function (response) {
              
                    $("#invoicedate").val(response.client.invoicedate);
                    $("#cgst").val(response.client.cgst);
                    $("#sgst").val(response.client.sgst);
                    $("#igst").val(response.client.igst);
                  
                    $("#service").val(response.client.service);
                    $("#supply").val(response.client.supply);
                    $("#saccode").val(response.client.saccode);
                    $("#pocketexpenseamount").val(response.client.pocketexpenseamount);

                   $totalamount =  response.totalamountcheck;
                   $amount =  parseInt(response.client.amount);
                   $totalinvoice =  parseInt(response.client.total);
                    debugger;
                   if($totalamount > 0 ){
                        var remainingamount =  $totalinvoice - $totalamount;
                        var  remainamount = remainingamount  / 1.18;       
                       document.getElementById('amount').value = remainamount;
                       debugger;
                      
                    }
                    else{
                        
                        $("#amount").val(response.client.amount);
                    }
                   
                   
                 
                },
                error: function () {

                },
        });
       });
       $('#company').on('change', function () {
            var category_id = $(this).val();
            debugger;
            if (category_id == 0) {
                var vale = null;
                $("#invocieno").val(vale);
                alert('please select company');
            } else {
                $.ajax({
                    type: "GET",
                    url: "{{ url('creditnoteinvoice/create') }}",
                    data: "category_id=" + category_id,
                   
                    success: function (response) {

                        if (response.creditno == null) {
                            debugger;
                            //   document.getElementById('invocieno').value = 1001;
                            $("#creditno").val(01);
                        } else {
                            $("#creditno").val(response.creditno);
                        }
debugger;

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
    gstshow();
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