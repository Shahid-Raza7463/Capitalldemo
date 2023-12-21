<div class="row row-sm">
    <!--  <div class="col-3">
       <div class="form-group">
           <label class="font-weight-600">Main Branch ( Client ) </label>
           <select class="language form-control" id="category" name="parent_id"
               @if(Request::is('client/*/edit'))>  <option 
           style="display:block" value="0">Please Select One</option>

               @foreach($clients as $clientData)
               <option value="{{$clientData->id}}"
                   {{$clientData->parent_id== $clientData->id??'' ?'selected="selected"' : ''}}>
                   {{$clientData->client_name }} (  {{$clientData->gstno }} )</option>
               @endforeach


               @else
               <option></option>
               <option value="">Please Select One</option>
               @foreach($clients as $clientData)
               <option value="{{$clientData->id}}">
                   {{ $clientData->client_name }} (  {{$clientData->gstno }} )</option>

               @endforeach
               @endif
           </select>
       </div>
   </div> -->
   <div class="col-3">
       <div class="form-group">
           <label class="font-weight-600">Company Name *</label>
           <input type="text" @if(Request::is('client/*/edit')) @if($clientcheck !=  null) readonly @endif @endif name="client_name" id="client_name" required value="{{ $client->client_name ?? ''}}" class="form-control"
               placeholder="Enter Company Name">
       </div>
   </div>
   {{-- <div class="col-3">
       <div class="form-group">
           <label class="font-weight-600"> Name *</label>
           <input type="text" name="name" id="name" value="{{ $client->name ?? ''}}" class="form-control"
               placeholder="Enter Name">
       </div>
   </div>
   
   <div class="col-3">
       <div class="form-group">
           <label class="font-weight-600">Mobile *</label>
           <input type="text" name="mobileno" id="mobileno" value="{{ $client->mobileno ?? ''}}" class="form-control"
               placeholder="Enter Mobile No">
       </div>
   </div>
   <div class="col-3">
       <div class="form-group">
           <label class="font-weight-600">Email Id *</label>
           <input type="email" name="emailid" id= "emailid" value="{{ $client->emailid ?? ''}}" class="form-control"
               placeholder="Enter Email">
       </div>
   </div> --}}
</div>
<div class="row row-sm">
   <div class="col-12">
       <div class="form-group">
           <label class="font-weight-600">Communication Address  *</label>
           <textarea rows="4" name="c_address" id="c_address" value="{{ $client->c_address ?? ''}}" class="form-control"
               placeholder="Enter Communication Address">{!! $client->c_address ??'' !!}</textarea>
       </div>
   </div>
</div>
<div class="row row-sm">
   <!--<div class="col-3">
       <div class="form-group">
           <label class="font-weight-600">Associated From *</label>
           <input type="date" id="associatedfrom" name="associatedfrom" value="{{ $client->associatedfrom ?? ''}}"
               class="form-control" placeholder="Enter Associated From">
       </div>
   </div>
  
   <div class="col-3">
       <div class="form-group">
           <label class="font-weight-600">Kind Attention *</label>
           <input type="text" name="kind_attention" id="kind_attention" value="{{ $client->kind_attention ?? ''}}" class="form-control"
               placeholder="Enter kind attention">
       </div>
   </div>
   <div class="col-3">
       <div class="form-group">
           <label class="font-weight-600"> Designation</label>
           <input type="text" name="clientdesignation" id="clientdesignation" value="{{ $client->clientdesignation ?? ''}}" class=" form-control"
           placeholder="Enter Client Designation">
       </div>
   </div> -->
  <!-- <div class="col-3">
       <div class="form-group">
           <label class="font-weight-600">State *</label>
           <select class="language form-control" name="c_state"
           @if(Request::is('client/*/edit'))> <option disabled
           style="display:block">Please Select One</option>

           @foreach($state as $stateData)
           <option value="{{$stateData->id}}"
           @if(($client->c_state) == $stateData->id) selected @endif>
          {{ $stateData->statename }}</option>
           @endforeach


           @else
           <option></option>
           <option value="">Please Select One</option>
           @foreach($state as $stateData)
           <option value="{{$stateData->id}}">
               {{ $stateData->statename }}</option>

           @endforeach
           @endif
       </select>
       </div>
   </div> -->
</div>

<div class="row row-sm">
   <div class="col-4">
       <div class="form-group">
           <label class="font-weight-600">Legal Status *</label>
            <select name="legalstatus" id="exampleFormControlSelect1" class="form-control"
               @if(Request::is('client/*/edit')) >
               @if($client->legalstatus=='2')
               <option value="2">Individual</option>
               <option value="3">Proprietorship</option>
               <option value="4">Firm</option>
               <option value="5">Private Limited Company</option>
               <option value="6">Public Company</option>
               <option value="7">Listed Company</option>
               <option value="8">Society</option>
               <option value="9">Trust</option>
               <option value="10">Section 8 Company</option>
               <option value="11">AOP</option>
               <option value="12">Foreign Company</option>
               <option value="13">LLP</option>
                <option value="14">HUF</option>

               @elseif($client->legalstatus=='3')
               <option value="3">Proprietorship</option>
               <option value="2">Individual</option>

               <option value="4">Firm</option>
               <option value="5">Private Limited Company</option>
               <option value="6">Public Company</option>
               <option value="7">Listed Company</option>
               <option value="8">Society</option>
               <option value="9">Trust</option>
               <option value="10">Section 8 Company</option>
               <option value="11">AOP</option>
               <option value="12">Foreign Company</option>
               <option value="13">LLP</option> 
            <option value="14">HUF</option>

               @elseif($client->legalstatus=='4')
               <option value="4">Firm</option>
               <option value="3">Proprietorship</option>
               <option value="2">Individual</option>
               <option value="5">Private Limited Company</option>
               <option value="6">Public Company</option>
               <option value="7">Listed Company</option>
               <option value="8">Society</option>
               <option value="9">Trust</option>
               <option value="10">Section 8 Company</option>
               <option value="11">AOP</option>
               <option value="12">Foreign Company</option>
               <option value="13">LLP</option>
                <option value="14">HUF</option>

               @elseif($client->legalstatus=='5')
               <option value="5">Private Limited Company</option>
               <option value="3">Proprietorship</option>
               <option value="2">Individual</option>
               <option value="4">Firm</option>
               <option value="6">Public Company</option>
               <option value="7">Listed Company</option>
               <option value="8">Society</option>
               <option value="9">Trust</option>
               <option value="10">Section 8 Company</option>
               <option value="11">AOP</option>
               <option value="12">Foreign Company</option>
               <option value="13">LLP</option>
                <option value="14">HUF</option>

               @elseif($client->legalstatus=='6')
               <option value="6">Public Company</option>
               <option value="3">Proprietorship</option>
               <option value="2">Individual</option>
               <option value="4">Firm</option>
               <option value="5">Private Limited Company</option>
               <option value="7">Listed Company</option>
               <option value="8">Society</option>
               <option value="9">Trust</option>
               <option value="10">Section 8 Company</option>
               <option value="11">AOP</option>
               <option value="12">Foreign Company</option>
               <option value="13">LLP</option>
                <option value="14">HUF</option>

               @elseif($client->legalstatus=='7')
               <option value="7">Listed Company</option>
               <option value="6">Public Company</option>
               <option value="3">Proprietorship</option>
               <option value="2">Individual</option>
               <option value="4">Firm</option>
               <option value="5">Private Limited Company</option>
               <option value="8">Society</option>
               <option value="9">Trust</option>
               <option value="10">Section 8 Company</option>
               <option value="11">AOP</option>
               <option value="12">Foreign Company</option>
               <option value="13">LLP</option>
                <option value="14">HUF</option>

               @elseif($client->legalstatus=='8')
               <option value="8">Society</option>
               <option value="7">Listed Company</option>
               <option value="6">Public Company</option>
               <option value="3">Proprietorship</option>
               <option value="2">Individual</option>
               <option value="4">Firm</option>
               <option value="5">Private Limited Company</option>
               <option value="9">Trust</option>
               <option value="10">Section 8 Company</option>
               <option value="11">AOP</option>
               <option value="12">Foreign Company</option>
               <option value="13">LLP</option>
                <option value="14">HUF</option>

               @elseif($client->legalstatus=='9')
               <option value="9">Trust</option>
               <option value="7">Listed Company</option>
               <option value="6">Public Company</option>
               <option value="3">Proprietorship</option>
               <option value="2">Individual</option>
               <option value="4">Firm</option>
               <option value="5">Private Limited Company</option>
               <option value="8">Society</option>
               <option value="10">Section 8 Company</option>
               <option value="11">AOP</option>
               <option value="12">Foreign Company</option>
               <option value="13">LLP</option>
                <option value="14">HUF</option>

               @elseif($client->legalstatus=='10')
               <option value="10">Section 8 Company</option>
               <option value="7">Listed Company</option>
               <option value="6">Public Company</option>
               <option value="3">Proprietorship</option>
               <option value="2">Individual</option>
               <option value="4">Firm</option>
               <option value="5">Private Limited Company</option>
               <option value="8">Society</option>
               <option value="9">Trust</option>
               <option value="11">AOP</option>
               <option value="12">Foreign Company</option>
               <option value="13">LLP</option>
                <option value="14">HUF</option>

               @elseif($client->legalstatus=='11')
               <option value="11">AOP</option>
               <option value="10">Section 8 Company</option>
               <option value="7">Listed Company</option>
               <option value="6">Public Company</option>
               <option value="3">Proprietorship</option>
               <option value="2">Individual</option>
               <option value="4">Firm</option>
               <option value="5">Private Limited Company</option>
               <option value="8">Society</option>
               <option value="9">Trust</option>
               <option value="12">Foreign Company</option>
               <option value="13">LLP</option>
                <option value="14">HUF</option>

               @elseif($client->legalstatus=='12')
               <option value="12">Foreign Company</option>
               <option value="11">AOP</option>
               <option value="10">Section 8 Company</option>
               <option value="7">Listed Company</option>
               <option value="6">Public Company</option>
               <option value="3">Proprietorship</option>
               <option value="2">Individual</option>
               <option value="4">Firm</option>
               <option value="5">Private Limited Company</option>
               <option value="8">Society</option>
               <option value="9">Trust</option>
                <option value="13">LLP</option>
                <option value="14">HUF</option>

                @elseif($client->legalstatus=='13')
                <option value="13">LLP</option>
                <option value="12">Foreign Company</option>
                <option value="11">AOP</option>
                <option value="10">Section 8 Company</option>
                <option value="7">Listed Company</option>
                <option value="6">Public Company</option>
                <option value="3">Proprietorship</option>
                <option value="2">Individual</option>
                <option value="4">Firm</option>
                <option value="5">Private Limited Company</option>
                <option value="8">Society</option>
                <option value="9">Trust</option>
                 <option value="14">HUF</option>


               @else
               
               <option value="14">HUF</option>     
               <option value="13">LLP</option>
                          <
                <option value="12">Foreign Company</>
               <option value="11">AOP</option>
              
               <option value="10">Section 8 Company</option>
               <option value="7">Listed Company</option>
               <option value="6">Public Company</option>
               <option value="3">Proprietorship</option>
               <option value="2">Individual</option>
               <option value="4">Firm</option>
               <option value="5">Private Limited Company</option>
               <option value="8">Society</option>
               <option value="9">Trust</option>
             

               @endif
               @else
               <option>Please Select One</option>
               <option value="2">Individual</option>
               <option value="3">Proprietorship</option>
               <option value="4">Firm</option>
               <option value="5">Private Limited Company</option>
               <option value="6">Public Company</option>
               <option value="7">Listed Company</option>
               <option value="8">Society</option>
               <option value="9">Trust</option>
               <option value="10">Section 8 Company</option>
               <option value="11">AOP</option>
               <option value="12">Foreign Company</option>
               <option value="13">LLP</option>
                <option value="14">HUF</option>  
                             @endif
           </select>
       </div>
   </div>
  <!--  <div class="col-4">
       <div class="form-group">
           <label class="font-weight-600">Date of Incorporation</label>
           <input type="date" id="dateofincorporation" name="dateofincorporation"
               value="{{ $client->dateofincorporation ?? ''}}" class="form-control" placeholder="Enter fathername">
       </div>
   </div>
   <div class="col-4">
       <div class="form-group">
           <label class="font-weight-600">Client Date of Birth</label>
           <input type="date" id="clientdob" name="clientdob" value="{{ $client->clientdob ?? ''}}"
               class="form-control" placeholder="Enter dateofbirth">
       </div>
   </div> -->
</div>
<div class="row row-sm">


   <div class="col-4">
       <div class="form-group">
           <label class="font-weight-600">Pan Card No. *</label>
           <input required type="text" id="pan_number" name="panno" value="{{ $client->panno ?? ''}}" class="form-control"
               placeholder="Enter Pan Card No">
           <span id="pan_error_message" style="color: red;"></span>
       </div>
   </div>

   <div class="col-4">
       <div class="form-group">
           <label class="font-weight-600">Tan No.</label>
           <input type="text" id="tanno" name="tanno" value="{{ $client->tanno ?? ''}}" class="form-control"
               placeholder="Enter Tan No">
       </div>
   </div>
   <div class="col-4">
       <div class="form-group">
           <label class="font-weight-600">GST No *</label>
           <input required type="text" id="gstno" name="gstno"  value="{{ $client->gstno ?? ''}}" class="form-control"
               placeholder="Enter GST No" >
       </div>
   </div>
</div>
<div class="row row-sm">
     <!-- <div class="col-4">
       <div class="form-group">
           <label class="font-weight-600">Capital </label>
           <input required type="number" id="capital" name="capital"  value="{{ $client->capital ?? ''}}" class="form-control"
               placeholder="Enter capital" >
       </div>
   </div>
       <div class="col-4">
       <div class="form-group">
           <label class="font-weight-600">Borrowings</label>
           <input required type="number" id="borrowings" name="borrowings"  value="{{ $client->borrowings ?? ''}}" class="form-control"
               placeholder="Enter Borrowings" >
       </div>
   </div>
       <div class="col-4">
       <div class="form-group">
           <label class="font-weight-600">Net Worth</label>
           <input required type="number" id="networth" name="networth"  value="{{ $client->networth ?? ''}}" class="form-control"
               placeholder="Enter Net Worth" >
       </div>
   </div> -->
   <div class="col-4">
       <div class="form-group">
           <label class="font-weight-600">Status</label>
           <select name="status" id="exampleFormControlSelect1" class="form-control">
               <!--placeholder-->
               @if(Request::is('client/*/edit')) >
               @if($client->status=='1')
               <option value="1">Active</option>
               <option value="2">Inactive</option>


               @else
               <option value="2">Inactive</option>
               <option value="1">Active</option>

               @endif
               @else

               <option value="1">Active</option>
               <option value="2">Inactive</option>
               @endif
           </select>
       </div>
   </div>
   <div class="col-4">
       <div class="form-group">
           <label class="font-weight-600">Client Classification </label>
           <select name="classification" id="classification" class="form-control">
               <!--placeholder-->
               @if(Request::is('client/*/edit')) >
               @if($client->classification=='1')
               <option value="1">NFRA</option>
               <option value="2">Quality Review</option>
               <option value="3">Peer Review</option>
               <option value="4">Others</option>

               @elseif($client->classification=='2')
               <option value="2">Quality Review</option>
               <option value="1">NFRA</option>
              
               <option value="3">Peer Review</option>
               <option value="4">Others</option>

               @elseif($client->classification=='3')
               <option value="1">NFRA</option>
               <option value="2">Quality Review</option>
              
               <option value="4">Others</option>
               <option value="3">Peer Review</option>

               @else
               <option value="4">Others</option>
               <option value="1">NFRA</option>
               <option value="2">Quality Review</option>
              
               
               <option value="3">Peer Review</option>

               @endif
               @else
               <option value="">Please Select One</option>
               <option value="1">NFRA</option>
               <option value="2">Quality Review</option>
               <option value="3">Peer Review</option>
               <option value="4">Others</option>
               @endif
           </select>
       </div>
   </div>
   <div class="col-4" id='otherclassification' style="display: none;">
       <div class="form-group">
           <label class="font-weight-600">Other *</label>
           <input type="text" name="otherclassification"  value="{{ $client->otherclassification ?? ''}}" class="form-control"
           placeholder="Enter" >
       </div>
   </div>
</div>
@if(Request::is('client/*/edit'))
<div class="row row-sm ">
   <div class="col-12">
       <div class="form-group">
           <label class="fs-17 font-weight-600 mb-0" style=" text-decoration: underline;">Edit Document </label>
       </div>
   </div>
</div>
@else
<br>
{{--<div class="row row-sm ">
   <div class="col-12">
       <div class="form-group">
           <label class="fs-17 font-weight-600 mb-0" style=" text-decoration: underline;">Add Document </label>
       </div>
   </div>
</div>--}}
<br>
@endif
{{--<div class="field_wrapper">
   <div class="row row-sm ">
       <div class="col-4">
           <div class="form-group">
               <label class="font-weight-600">Document Name </label>
               <input type="text" class="form-control key" name="document_name[]" id="key" value=""
                   placeholder="Enter Document Name">
           </div>
       </div>
       <div class="col-3">
           <div class="form-group">
               <label class="font-weight-600">File </label>
               <input type="file" class="form-control key" name="filess[]" id="key" value=""
                   placeholder="Enter Document Name">
           </div>
       </div>
       <div class="col-4">
           <div class="form-group">
               <label class="font-weight-600"> Document Type </label>
               <select class="form-control key" name="type[]" id="key" value="" id="exampleFormControlSelect1">
                   <option value="0">Permanent</option>
                   <option value="1">Temporary</option>
               </select>
           </div>
       </div>

       <div class="col-1">
           <div class="form-group" style="margin-top: 36px;">
               <a href="javascript:void(0);" class="add_button" title="Add field"><img
                       src="{{ url('backEnd/image/add-icon.png')}}" /></a>
           </div>
       </div>

   </div>
</div> --}}
<br>
@if(Request::is('client/*/edit'))
@if(session()->has('statuss'))
<div class="alert alert-danger">
   @if(is_array(session()->get('statuss')))
   @foreach (session()->get('statuss') as $message)
   <p>{{ $message }}</p>
   @endforeach
   @else
   <p>{{ session()->get('success') }}</p>
   @endif
</div>
@endif
<div class="table-responsive">
   <table class="table display table-bordered table-striped table-hover">
       <thead>
           <tr>
               <th class="font-weight-600">Document Name</th>
               <th class="font-weight-600">Uploaded by</th>
               <th class="font-weight-600">Type</th>

               <th class="font-weight-600">Date</th>
               <th class="font-weight-600">File</th>
               <th class="font-weight-600">Action</th>
           </tr>
       </thead>
       <tbody>
           @foreach($clientdocument as $clientDocument)
           <tr>
               <td>{{$clientDocument->document_name }}</td>
               <td>
                   {{$clientDocument->team_member }}
               </td>
               <td>@if($clientDocument->type==0)
                   <span>Permanent</span>
                   @else
                   <span>Temporary</span>
                   @endif
               </td>

               <td>{{ date('d-M-y', strtotime($clientDocument->created_at)) }}</td>
               @if (pathinfo($clientDocument->filess, PATHINFO_EXTENSION) == 'png')
               <td><a class="btn btn-success btn" target="blank"
                       href="{{ asset('backEnd/image/client/document/'.$clientDocument->filess) }}"><i
                           class="fas fa-download" style="margin-right: 4px;"></i>Open</a> <a
                       class="btn btn-primary btn" target="blank"
                       href="{{ asset('backEnd/image/client/document/'.$clientDocument->filess) }}"><i
                           class="fas fa-download" style="margin-right: 4px;"></i>Download</a></td>
               @elseif(pathinfo($clientDocument->filess, PATHINFO_EXTENSION) == 'jpeg')
               <td><a class="btn btn-success btn" target="blank"
                       href="{{ asset('backEnd/image/client/document/'.$clientDocument->filess) }}"><i
                           class="fas fa-download" style="margin-right: 4px;"></i>Open</a> <a
                       class="btn btn-primary btn" target="blank"
                       href="{{ asset('backEnd/image/client/document/'.$clientDocument->filess) }}"><i
                           class="fas fa-download" style="margin-right: 4px;"></i>Download</a></td>
               @elseif(pathinfo($clientDocument->filess, PATHINFO_EXTENSION) == 'jpg')
               <td><a class="btn btn-success btn" target="blank"
                       href="{{ asset('backEnd/image/client/document/'.$clientDocument->filess) }}"><i
                           class="fas fa-download" style="margin-right: 4px;"></i>Open</a> <a
                       class="btn btn-primary btn" target="blank"
                       href="{{ asset('backEnd/image/client/document/'.$clientDocument->filess) }}"><i
                           class="fas fa-download" style="margin-right: 4px;"></i>Download</a></td>
               @else
               <td><a class="btn btn-success btn" target="blank"
                       href="https://docs.google.com/gview?url={{ asset('backEnd/image/client/document/'.$clientDocument->filess) }}"><i
                           class="fas fa-file-excel" style="margin-right: 4px;"></i>Open</a> <a
                       class="btn btn-primary btn" target="blank"
                       href="{{ asset('backEnd/image/client/document/'.$clientDocument->filess) }}"><i
                           class="fas fa-download" style="margin-right: 4px;"></i>Download</a></td>
               @endif
               <td><a href="{{url('/clientdocument/destroy/'.$clientDocument->id)}}"
                       onclick="return confirm('Are you sure you want to delete this item?');"
                       class="btn btn-danger-soft btn-sm"><i class="far fa-trash-alt"></i></a></td>
           </tr>
           @endforeach
       </tbody>
   </table>

</div>
@endif
<div class="form-group">
   <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
   <a class="btn btn-secondary" href="{{ url('client') }}">
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
                   $("#emailid").val(response.emailid);
                    $("#panno").val(response.panno);
                    $("#tanno").val(response.tanno);
                    $("#associatedfrom").val(response.associatedfrom);
                    $("#dateofincorporation").val(response.dateofincorporation);
                   $("#name").val(response.name);
                   $("#kind_attention").val(response.kind_attention);
                   $("#clientdesignation").val(response.clientdesignation);
                   $("#client_name").val(response.client_name);
                   $("#clientdob").val(response.clientdob);
                   $("#emailid").val(response.emailid);
                   $("#c_address").val(response.c_address);
                   $("#capital").val(response.capital);
                   $("#borrowings").val(response.borrowings);


               },
               error: function () {

               },
           });
       });
     
   });

</script>

{{-- <script>
 function checkPanNumber() {
   var panNumber = $("#pan_number").val();
   var prevPanNumber = localStorage.getItem("panNumber");
   var errorMessageSpan = $("#pan_error_message");

   // Check if PAN number is 10 digits
   if (panNumber.length !== 10) {
       errorMessageSpan.text("PAN number must be 10 digits");
       $("#save").attr("disabled", "disabled");
       return false;
   } else {
       errorMessageSpan.text(""); // Clear error message
   }

   // Check if PAN number is duplicate
   $.ajax({
       url: "{{ url('clientpan') }}",
       data: "panNumber=" + panNumber,
       type: "GET",
       success: function(data) {
           if (!data.success) {
               var duplicateClientName = data.duplicateClientName;
               errorMessageSpan.text("PAN number is a duplicate for client: " + duplicateClientName);
               $("#save").attr("disabled", "disabled");
           } else {
               if (panNumber === prevPanNumber) {
                   errorMessageSpan.text("PAN number is the same as the previously entered PAN number");
                   $("#save").attr("disabled", "disabled");
               } else {
                   errorMessageSpan.text(""); // Clear error message
                   $("#save").removeAttr("disabled");
               }
           }
       },
       error: function(error) {
           console.log(error);
       }
   });

   // The PAN number is not duplicate, so allow the form to be submitted
   return true;
}


 </script> --}}

 <script>
    
    $(document).ready(function() {
        // Adding a submit event handler to the form
        $(".clientAddForm").submit(function(event) {
            event.preventDefault(); // Prevent  default form submission
    
            var panNumber = $("#pan_number").val();
            var prevPanNumber = localStorage.getItem("panNumber");
            var errorMessageSpan = $("#pan_error_message");
    
            // Check if PAN number is 10 digits
            if (panNumber.length !== 10) {
                errorMessageSpan.text("PAN number must be 10 digits");
                return false; // Prevent form submission
            } else {
                errorMessageSpan.text(""); // Clear error message
            }
    
            // Check if PAN number is duplicate
            $.ajax({
                url: "{{ url('clientpan') }}",
                data: "panNumber=" + panNumber,
                type: "GET",
                success: function(data) {
                    if (!data.success) {
                        var duplicateClientName = data.duplicateClientName;
                        errorMessageSpan.text("PAN number is a duplicate for client: " + duplicateClientName);
                        return false; // Prevent form submisssion
                    } else {
                        if (panNumber === prevPanNumber) {
                            errorMessageSpan.text("PAN number is the same as the previously entered PAN number");
                            return false; // Prevent  submission
                        } else {
                            errorMessageSpan.text(""); // Clear error message
                            $("#save").removeAttr("disabled");
                            // You can optionally submit the form here if all validation passes
                             $(".clientAddForm").off("submit").submit(); 
                        }
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
    
            
            return false;
        });
    });
    </script>
    