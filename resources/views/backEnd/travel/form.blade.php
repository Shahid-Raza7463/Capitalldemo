<div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Employee Name </label>
            <select class="language form-control" id="category" 
            @if(Request::is('travel/*/edit'))> <option disabled
            style="display:block">Please Select One</option>

            @foreach($authteammember as $teammemberData)
            <option value="{{$teammemberData->id}}"
            @if(($travel->createdby) == $teammemberData->id) selected @endif>
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
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Client Name. *</label>
       
			<select required class="language form-control" id="client" name="client_id"
                @if(Request::is('travel/*/edit'))> <option disabled style="display:block">Please Select One
                </option>

                @foreach($client as $clientData)
                <option value="{{$clientData->id}}"
                    {{$travel->client_id == $clientData->id??'' ?'selected="selected"' : ''}}>
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
            <label class="font-weight-600" >Advance Transaction Number </label>
            <input type="text" id="assignmentgenerate_id" readonly  name="assignmentgenerate_id" value="{{ $travel->assignmentgenerate_id ?? ''}}" class="form-control"
                placeholder="  .">
        </div>
        </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Assignment Name*</label>
           
            <select class="form-control key" required name="assignment_id" id="assignment_id">
                @if(!empty($travel->assignment_id))
                <option value="{{ $travel->assignment_id }}">
                    {{ App\Models\Assignment::where('id',$travel->assignment_id)->first()->assignment_name??'' }}
                </option>

                @endif </select>
     
        </div>
        </div>
       
         
</div>
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Place of Visit </label>
            <input type="text" id="example-date-input" name="Place_of_visit" value="{{ $travel->Place_of_visit ?? ''}}" class="form-control"
                placeholder="Enter Place of Visit  .">
        </div>
        </div>
  {{-- <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Purpose of visit. *</label>
            <input type="text" id="example-date-input" name="Purpose_of_visit" value="{{ $travel->Purpose_of_visit ?? ''}}" class="form-control"
            placeholder="Enter Purpose of visit">
        </div>
    </div> --}}
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Start date </label>
            <input required type="date" id="example-date-input" name="Expected_date_of_departure" value="{{ $travel->Expected_date_of_departure ?? ''}}" class="form-control"
                placeholder="Enter Expected date of departure.">
        </div>
        </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">End date. *</label>
            <input required type="date" id="example-date-input" name="Expected_date_of_arrival" value="{{ $travel->Expected_date_of_arrival ?? ''}}" class="form-control"
            placeholder="Enter Expected date of arrival">
        </div>
    </div>
    {{-- <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Expected duration in days </label>
            <input type="text" id="example-date-input" name="Expected_duration_in_days" value="{{ $travel->Expected_duration_in_days ?? ''}}" class="form-control"
                placeholder="Enter Expected duration in days.">
        </div>
        </div> --}}
       
</div>
<div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Choose Conveyance. *</label>
            <select name="chooseconveyance" required class="form-control">
                <!--placeholder-->
                @if(Request::is('travel/*/edit')) >
                @if($travel->chooseconveyance=='Local Conveyance')
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
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Select Approver *</label>
            <select required class="language form-control"   name="teammember_id" @if(Request::is('travel/*/edit'))>
                <option disabled style="display:block">Please Select One</option>

                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}" @if(($travel->teammember_id) == $teammemberData->id) selected
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
     {{-- <div class="col-2">
        <div class="form-group">
            <label class="font-weight-600">Attachment. </label>
            <input type="file" name="attachment[]" value="{{ $travel->attachment ?? ''}}" multiple="multiple" class="form-control"
            placeholder="Enter Expected date of arrival">
			<span>upload multiple attachment</span>
        </div>
    </div>
	   @if(!empty($travel->travelattachment['0']->attachment))
    <div class="col-2">
        <div class="form-group">
            <label class="font-weight-600"></label><br><br>
            <a  data-toggle="modal" data-target="#exampleModal1" class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
        </div>
    </div>
	@endif --}}
   
  <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Billable. *</label>
            <select name="Billable" id="exampleFormControlSelect1" class="form-control">
                <!--placeholder-->
                @if(Request::is('travel/*/edit')) >
                @if($travel->Billable=='0')
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
            <label class="font-weight-600">Advance Amount Required </label>
            <input type="text" required name="advanceamount" value="{{ $travel->advanceamount ?? ''}}" class="form-control"
                placeholder="Enter Advance Amount Required">
        </div>
    </div>
</div>
<br>
<div id='travels' @if(!empty($travel->total)) @else style="display: none;" @endif>
<div class="row row-sm ">
    <div class="col-12">
        <div class="form-group">
            <label class="fs-17 font-weight-600 mb-0">Advance Amount Required </label>
        </div>
    </div>
</div>
<hr>
<div class="row row-sm">
    <div class="col-4">
          <div class="form-group">
              <label class="font-weight-600">Train/Flight Ticket. *</label>
              <input type="number" name="Train_Flight" onchange="calc();" id="ticket" value="{{ $travel->Train_Flight ?? ''}}" class="form-control"
              placeholder="Enter Train/Flight Ticket">
          </div>
      </div>
      <div class="col-2">
          <div class="form-group">
              <label class="font-weight-600">Food. *</label>
              <input type="number" onchange="calc();" id="food" name="Food" value="{{ $travel->Food ?? ''}}" class="form-control"
              placeholder="Enter Food">
          </div>
      </div>
      <div class="col-2">
          <div class="form-group">
              <label class="font-weight-600">Conveyance </label>
              <input type="number" onchange="calc();" id="conveyance" name="Conveyance" value="{{ $travel->Conveyance ?? ''}}" class="form-control"
                  placeholder="Enter Conveyance .">
          </div>
          </div>
      <div class="col-2">
          <div class="form-group">
              <label class="font-weight-600">Other (Specify) </label>
              <input type="number" onchange="calc();" id="other" name="Other" value="{{ $travel->Other ?? ''}}" class="form-control"
                  placeholder="Enter Other .">
          </div>
          </div>
          <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600">Total </label>
                <input type="text" name="total" readonly id="total" value="{{ $travel->total ?? ''}}" class="form-control"
                    placeholder="">
            </div>
            </div>
           
  </div>
</div>

<div class="row row-sm">
    @if(Request::is('travel/*/edit'))
    @if(Auth::user()->teammember_id == $travel->teammember_id)
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Action. *</label>
            <select name="travelstatus" class="form-control">
                <!--placeholder-->
                @if(Request::is('travel/*/edit')) >
                @if($travel->travelstatus=='0')
                <option value="0">Created</option>
                <option value="1">Approved</option>
                <option value="2">Reject</option>

                @elseif($travel->travelstatus=='1')
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
    @if(Request::is('travel/*/edit'))
    @if($travel->travelstatus == 1)

    @if(Auth::user()->role_id == 17 || $travel->Advance_Amount  != null)
    <div class="col-4">
          <div class="form-group">
              <label class="font-weight-600">Advance Amount Given. *</label>
              <input type="number" name="Advance_Amount" value="{{ $travel->Advance_Amount ?? ''}}" class="form-control"
              placeholder="Enter Advance Amount">
          </div>
      </div>
      <div class="col-4">
          <div class="form-group">
              <label class="font-weight-600">Status. *</label>
              <select name="Status" id="exampleFormControlSelect1" class="form-control">
                <!--placeholder-->
                @if(Request::is('travel/*/edit')) >
                @if($travel->Status=='0')
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
        placeholder="Enter Comment (Reason for hold)">{!! $travel->comment ??'' !!}</textarea>
    </div>
    @endif
    @endif
    @endif
  </div>
  
  <br>
  
<div class="form-group">
    @if(Request::is('travel/create'))
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    @endif
    @if(Request::is('travel/*/edit'))
    @if($travel->createdby == Auth::user()->teammember_id && $travel->travelstatus == 0)
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    @endif
   
    @if($travel->teammember_id == Auth::user()->teammember_id && $travel->travelstatus == 0)
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    @endif
    @if(Auth::user()->role_id == 17 && $travel->travelstatus == 1)
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    @endif
    @endif
    <a class="btn btn-secondary" href="{{ url('travel') }}">
        Back</a>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
       function calc() {
        var value1 = document.getElementById('ticket').value;

        var value2 = document.getElementById('food').value;
        var value3 = document.getElementById('conveyance').value;
        var value4 = document.getElementById('other').value;
    //    debugger;
        var value5 = parseInt(value1);
        var value6 = parseInt(value2);
        var value7 = parseInt(value3);
        var value8 = parseInt(value4);
  // debugger;

        var result = value5 + value6 + value7 + value8;
    //      debugger;
        //    alert(result);
        document.getElementById('total').value = result;
    }

</script>
@include('backEnd.ajax')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(function(){
       $('#client').on('change',function(){
           var cid =$(this).val();
       // alert(category_id);
        $.ajax({
            type: "get",
            url: "{{ url('transaction') }}",
            data: "cid="+cid,
            success: function (response) {
                if (response.assignmentgenerate_id == null) {
                           
                            $("#assignmentgenerate_id").val(01);
                        } else {
                            debugger;
                           var add = parseInt(response.assignmentgenerate_id);
                            var result = add + 1;
                           debugger;
                           document.getElementById('assignmentgenerate_id').value = result;
                           debugger;
                        }

            },
            error : function(){
            },
        });
       });
     }); 
 </script>