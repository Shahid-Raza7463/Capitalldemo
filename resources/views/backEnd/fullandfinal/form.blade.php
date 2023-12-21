<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Name of Employee/Article Assistant  *</label>
            <select class="language form-control" id="teammember"  name="Name" @if(Request::is('fullandfinal/*/edit'))>
                <option disabled style="display:block">Please Select One</option>

                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}" @if(($fullandfinal->Name) == $teammemberData->id) selected
                    @endif>{{ $teammemberData->team_member }} ( {{ $teammemberData->role->rolename }} )
                </option>
                @endforeach


                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}">
					{{ $teammemberData->team_member }} ( {{ $teammemberData->role->rolename }} )</option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Designation </label>
            <select name="Designation" id="exampleFormControlSelect1" class="form-control">
                <!--placeholder-->
                @if(Request::is('fullandfinal/*/edit')) >
                @if($fullandfinal->Designation=='0')
                <option value="0">Article</option>
                <option value="1">Partner</option>
                <option value="2">Manager</option>
                <option value="3">Auditor</option>
                <option value="4">C.A.</option>

                @elseif($fullandfinal->Designation=='1')
              
                <option value="1">Partner</option>
                <option value="0">Article</option>
                <option value="2">Manager</option>
                <option value="3">Auditor</option>
                <option value="4">C.A.</option>

                @elseif($fullandfinal->Designation=='2')
                <option value="2">Manager</option>
                <option value="1">Partner</option>
                <option value="0">Article</option>
               
                <option value="3">Auditor</option>
                <option value="4">C.A.</option>

                @elseif($fullandfinal->Designation=='3')
                <option value="3">Auditor</option>
                <option value="2">Manager</option>
                <option value="1">Partner</option>
                <option value="0">Article</option>
                <option value="4">C.A.</option>

                @else
                <option value="4">C.A.</option>
                <option value="3">Auditor</option>
                <option value="2">Manager</option>
                <option value="1">Partner</option>
                <option value="0">Article</option>
                



                @endif
                @else

                <option value="">Please Select One</option>
                <option value="0">Article</option>
                <option value="1">Partner</option>
                <option value="2">Manager</option>
                <option value="3">Auditor</option>
                <option value="4">C.A.</option>
                @endif
            </select>
        </div>
    </div>
  



</div>
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Reporting Head </label>
            <select class="language form-control"  name="Reporting_Head" @if(Request::is('fullandfinal/*/edit'))>
                <option disabled style="display:block">Please Select One</option>

                @foreach($reportinghead as $teammemberData)
                <option value="{{$teammemberData->id}}" @if(($fullandfinal->Reporting_Head) == $teammemberData->id) selected
                    @endif>{{ $teammemberData->team_member }} ( {{ $teammemberData->role->rolename }} )
                </option>
                @endforeach


                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($reportinghead as $teammemberData)
                <option value="{{$teammemberData->id}}">
					{{ $teammemberData->team_member }} ( {{ $teammemberData->role->rolename }} )</option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Date of Joining. *</label>
            <input type="date" id="Date_of_Joining" name="Date_of_Joining" value="{{ $fullandfinal->Date_of_Joining ?? ''}}"
                class="form-control" placeholder="Enter Date of Joining">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Date of Resignation </label>
            <input type="date"  id="resignation"  name="Date_of_Resignation" value="{{ $fullandfinal->Date_of_Resignation ?? ''}}"
                class="form-control" placeholder="Enter Date of Resignation .">
        </div>
    </div>
   

</div>
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Date of Leaving </label>
            <input type="date" id="leavingdate" name="Date_of_Leaving" value="{{ $fullandfinal->Date_of_Leaving ?? ''}}"
                class="form-control" placeholder="Enter Date of Leaving .">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Notice Period Served </label>
            <input type="text" id="noticeperiod" name="Notice_Period_Served" value="{{ $fullandfinal->Notice_Period_Served ?? ''}}"
                class="form-control" placeholder="Enter Notice Period Served">
        </div>
    </div>


    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Status of Leaving. *</label>
            <select name="Status" id="exampleFormControlSelect1" class="form-control">
                <!--placeholder-->
                @if(Request::is('fullandfinal/*/edit')) >
                @if($fullandfinal->Status=='0')
                <option value="0">Voluntary</option>
                <option value="1">In Voluntary</option>

                @else
                <option value="1">In Voluntary</option>
                <option value="0">Voluntary</option>



                @endif
                @else

                <option value="">Please Select One</option>
                <option value="0">Voluntary</option>
                <option value="1">In Voluntary</option>
                @endif
            </select>
        </div>
    </div>
  
</div>

<div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Reason of Leaving. *</label>
            <textarea rows="2" id="reasonofleaving" name="Reason_of_Leaving" value="{{ $fullandfinal->Reason_of_Leaving ?? ''}}" class="form-control"
                placeholder="Enter Reason of Leaving">{!! $fullandfinal->Reason_of_Leaving ??'' !!}</textarea>
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Full and Final (Days) to be released  *</label>
            <input type="text" id="example-date-input" name="Full_and_Final_to_be_released" value="{{ $fullandfinal->Full_and_Final_to_be_released ?? ''}}"
                class="form-control" placeholder="Enter Full and Final (Days) to be released">
        </div>
    </div>
	<div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">E-KYC Status *</label>
            <select name="kycstatus" id="kycstatus" class="form-control" required>
                <!--placeholder-->
               @if(Request::is('fullandfinal/*/edit')) >
                @if($fullandfinal->kycstatus=='0')
                <option value="0">No</option>
                <option value="1">Yes</option>
				<option value="2">Not Applicable</option>

                @elseif($fullandfinal->kycstatus=='1')
                <option value="1">Yes</option>
				<option value="2">Not Applicable</option>
                <option value="0">No</option>

				@elseif($fullandfinal->kycstatus=='2')
                <option value="1">Yes</option>
				<option value="2">Not Applicable</option>
                <option value="0">No</option>
				
				@endif


                
               
                @else

                <option value="">Please Select One</option>
                <option value="0">No</option>
                <option value="1">Yes</option>
				<option value="2">Not Applicable</option>
                @endif 
            </select>
        </div>
    </div>

    
    @if(Request::is('fullandfinal/*/edit'))
    @if(Auth::user()->role_id == 17 || Auth::user()->role_id == 18)
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Final Status of Full and Final. *</label>
            <select name="Final_Status_of_Full_and_Final" id="fullandfinal" class="form-control">
                <!--placeholder-->
                @if(Request::is('fullandfinal/*/edit')) >
                @if($fullandfinal->Final_Status_of_Full_and_Final=='0')
                <option value="0">Done</option>
                <option value="1">On Hold</option>
                <option value="2">Not Done</option>

                @elseif($fullandfinal->Final_Status_of_Full_and_Final=='1')
                <option value="1">On Hold</option>
                <option value="0">Done</option>
                <option value="2">Not Done</option>

                @else
                <option value="2">Not Done</option>
                <option value="1">On Hold</option>
                <option value="0">Done</option>

                @endif
                @else

                <option value="">Please Select One</option>
                <option value="0">Done</option>
                <option value="1">On Hold</option>
                <option value="2">Created</option>
                @endif
            </select>
        </div>
    </div>
    
   @endif
   <div class="col-4" id='full' @if(!empty($fullandfinal->remark)) @else style="display: none;" @endif>
    <div class="form-group">
        <label class="font-weight-600">Remark*</label>
        <input type="text" name="remark" value="{{ $fullandfinal->remark ?? ''}}"
            class="form-control" placeholder="Remark">
    </div>
</div>
   @endif
</div>

<div class="form-group">
    @if(Request::is('fullandfinal/*/edit') && $fullandfinal->Final_Status_of_Full_and_Final == 2)
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    @endif
    @if(Request::is('fullandfinal/create'))
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
@endif
    <a class="btn btn-secondary" href="{{ url('fullandfinal') }}">
        Back</a>

</div>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
       function calc() {
        var value1 = document.getElementById('resignation').value;

        var value2 = document.getElementById('leaving').value;
       
        function getDifferenceInDays(value1, value2) {
  const diffInMs = Math.abs(value2 - value1);
  return diffInMs / (1000 * 60 * 60 * 24);
}
       
        document.getElementById('total').value = noticeperiod;
    }

</script> --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(function(){
        $('#teammember').on('change', function () {
            var category_id = $(this).val();
           debugger;
        $.ajax({
            type: "GET",
            url: "{{ url('fullandfinalajax/create') }}",
            data: "category_id="+category_id,
            success: function (response) {
              
                    $("#Date_of_Joining").val(response.joining_date);
                   
                    $("#leavingdate").val(response.leavingdate);
				$("#reasonofleaving").val(response.reasonofleaving);
                    debugger;
				


                },
            error : function(){

            },
        });
       });
     }); 


     $(function(){
        $('#leavingdate').on('change', function () {
           
                   
               
                    var value4 = document.getElementById('leavingdate').value;
                    var value5 = document.getElementById('resignation').value;
                    debugger;
                    var day1 = new Date(value5); 
var day2 = new Date(value4);

var difference= Math.abs(day2-day1);
var days = difference/(1000 * 3600 * 24)

document.getElementById('noticeperiod').value = days;
debugger;

                  
				
       });
     
     }); 
 </script>