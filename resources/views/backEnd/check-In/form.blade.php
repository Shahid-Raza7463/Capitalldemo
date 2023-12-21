<div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600"> Checking in from</label>
           <select name="checkin_from" id="checkin_from" class="language form-control" id="" required
           >
            <option value="">Please Select One</option>
            <option value="Office">Office</option>
            <option value="Client Place">Client Place</option>
            <option value="Work From Home">Work From Home</option>
            <option value="Leave">Leave<a></option>
            
           </select>
        </div>
    </div>
    <div class="col-3" id="type" style="display: none;">
        <div class="form-group">
            <label class="font-weight-600">Type</label>
           <select name="typeval" id="typeval" class="language form-control" id="" required
           >
            <option value="">Please Select One</option>
            <option value="Allocated">Allocated</option>
            <option value="Unallocated">Unallocated</option>
            
           </select>
        </div>
    </div>
   
         <div class="col-3" >
        <div class="form-group">

        @php
        $Date=Carbon\Carbon::now();
        $date=$Date->setTimezone(new DateTimeZone('Asia/Kolkata'));
       // dd($Date);
            @endphp
          
            <label class="font-weight-600">Date</label>
           <input type="text" readonly   class="language form-control" value="{{$Date->format('d-m-Y')}}" name="date">
        </div>
    </div>
    <div class="col-3" >
        <div class="form-group">
            <label class="font-weight-600">Time</label>
            
           <input type="text" readonly   class="language form-control" value="{{Carbon\Carbon::now()->format('h:i a')}}" name="time">
        </div>
    </div>
	
	<div class="col-4" id="client" style="display: none;">
        <div class="form-group">
            <label class="font-weight-600">Select Client</label>
            <select  class="language form-control" id="client_id" name="client_id"
                @if(Request::is('check-In/*/edit'))> <option disabled style="display:block">Please Select One</option>

                @foreach($client as $clientData)
                <option value="{{$clientData->id}}"
                    {{$checkInData->client_id == $clientData->id??'' ?'selected="selected"' : ''}}>
                    {{$clientData->name }}</option>
                @endforeach


                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($client as $clientData)
                <option value="{{$clientData->id}}">
                    {{ $clientData->client_name ??''}}</option>

                @endforeach
                @endif
            </select>
                  </div>
    </div>

    <div class="col-3" id="assignment" style="display: none;">
        <div class="form-group">
            <label class="font-weight-600">Select Assignment</label>
            <select  class="language form-control" id="assignment_id" name="assignment_id"
                > 
            
            </select>
                  </div>
    </div>


    <div class="col-5" id="clientplace" style="display: none; height: 100px;">
        <div class="form-group">
            <label class="font-weight-600">Client Place <small>Eg: Delhi/Mumbai </small></label>
            <input  name="place" id="clientplaceadd"  class="form-control"
            placeholder="Enter Client Place">
        </div>
    </div>
</div>
<br>
<br>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('check-In') }}">
        Back</a>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  
<script>
$(document).ready(function() {
  var client = $("#client");
  var clientPlace = $("#clientplace");
  var type = $("#type");
  var clientId = $("#client_id");
  var clientPlaceAdd = $("#clientplaceadd");
  var typeVal = $("#typeval");
  var assignment = $("#assignment");
  var select = $("#checkin_from");

  select.on("change", function() {
    if (this.value == "Client Place") {
      client.show();
      clientPlace.show();
      assignment.show();
      type.hide();
      clientId.prop("required", true);
      clientPlaceAdd.prop("required", true);
      typeVal.prop("required", false);
    } else if (this.value == "Office") {
      type.show();
      client.show();
      clientPlace.show();
      assignment.show();
      clientId.prop("required", false);
      clientPlaceAdd.prop("required", false);
      typeVal.prop("required", true);
    } else {
      client.show();
      clientPlace.hide();
      type.hide();
      assignment.show();
      clientId.prop("required", false);
      clientPlaceAdd.prop("required", false);
      typeVal.prop("required", false);
    }

    // Check if the selected value is "Leave"
    if (this.value == "Leave") {
      // Redirect the user to the desired URL
      window.location.href = "{{url('applyleave/create')}}";
    }
  });

  typeVal.on("change", function() {
    if (this.value == "Unallocated") {
      client.hide();
      clientPlace.hide();
      assignment.hide();
    } else {
      client.show();
      clientPlace.show();
      assignment.show();
    }
  });
});
</script>




<script>
   $(document).ready( function() {
    $('#datePicker').val(new Date().toDateInputValue());
});​

</script>
