
<div id="success_message" style="display: none;"></div>

<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
        <label class="font-weight-600">Name of Employee</label>     
        <select class="form-control language " id="employee" name="teammember_ids" @if(Request::is('task/*/edit'))>
                <option disabled style="display:block">Please Select </option>

                  @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}" @if(Request::is('secretaryoftask/*/edit')) 
                    @foreach($taskassign as $team) 
                    {{ $teammemberData->id == $team->teammember_id ? 'selected' : '' }} @endforeach   @endif>
                {{ $teammemberData->team_member }}
                    ( {{ $teammemberData->emailid ??''}} )</option>
                @endforeach

                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}">
                    {{ $teammemberData->team_member }} ( {{ $teammemberData->emailid ??''}} ) </option>

                @endforeach
                @endif
            </select>
    </div>
    </div>
    <div class="col-4">
        <div class="form-group">
        <label class="font-weight-600">Month</label>
        <select class="form-control" id="month" name="month">
        <option value="">select month</option>
        <option value="January">January</option>
  <option value="February">February</option>
  <option value="March">March</option>
  <option value="April">April</option>
  <option value="May">May</option>
  <option value="June">June</option>
  <option value="July">July</option>
  <option value="August">August</option>
  <option value="September">September</option>
  <option value="October">October</option>
  <option value="November">November</option>
  <option value="December">December</option>
</select>
        </div>
    </div>
    <div class="col-4" style="display:none;">
        <div class="form-group">
        <label class="font-weight-600">Employee Status</label>
        <select class="form-control basic-multiple language" name="role_id">
                <option value="">Please Select One</option>
                @foreach($roledata as $roleDatas)
                <option value="{{$roleDatas->id}}">
                    {{ $roleDatas->rolename }} 
                </option>

                @endforeach
            </select>
        </div>
    </div>
    </div>
<div class="row row-sm">
<div class="col-4">
        <div class="form-group">
        <label class="font-weight-600">Range</label>
        <input type="text" readonly name="range"  id="range" value="" class="form-control">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
        <label class="font-weight-600">Monthly Gross Salary</label>     
        <input type="text" readonly name="monthly_gross_salary" id="monthly_gross_salary" value="" class="form-control">
    </div>
</div>
    <div class="col-4">
        <div class="form-group">
        <label class="font-weight-600">Number of days in month</label>
        <input type="text" readonly name="total_days" id="total_days" value="" class="form-control">
        </div>
   </div>
</div>
<b style="font-weight: 800;font-size: 18px;">Attendance Details</b>
<hr>
<div class="row row-sm">
<div class="col-4">
        <div class="form-group">
        <label class="font-weight-600">No of days Present</label>
        <input type="text" readonly name="dayspresent" id="dayspresent" value="" class="form-control">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
        <label class="font-weight-600">Casual Leave</label>     
        <input type="text" readonly name="cl" value="" id="cl" class="form-control">
    </div>
</div>
    <div class="col-4">
        <div class="form-group">
        <label class="font-weight-600">Sick Leave</label>
        <input type="text" readonly name="sl" value="" id="sl" class="form-control">
        </div>
   </div>
</div>
<div class="row row-sm">
<div class="col-4">
        <div class="form-group">
        <label class="font-weight-600">Compensatory Off (CO)</label>
        <input type="text" readonly name="co" value="" id="co" class="form-control">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
        <label class="font-weight-600">Birthday Leave</label>     
        <input type="text" readonly name="birthday" value="" id="birthday" class="form-control">
    </div>
</div>
    <div class="col-4">
        <div class="form-group">
        <label class="font-weight-600">LWP (Leave Without Pay)</label>
        <input type="text" readonly name="lwp" value="" id="lwp" class="form-control">
        </div>
   </div>
</div>
<div class="row row-sm">
<div class="col-4">
        <div class="form-group">
        <label class="font-weight-600">Total Days to be paid</label>
        <input type="text" readonly name="total_days_to_be_paid" id="totalDaysToBePaid" value="" class="form-control">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
        <label class="font-weight-600">Amount</label>     
        <input type="text" readonly name="amount"  id="amount" value="" class="form-control">
    </div>
</div>
    <div class="col-4">
        <div class="form-group">
        <label class="font-weight-600">PF (Y/N)</label>
        <input type="text" readonly id="pf_applicable" name="name_employee" value="" class="form-control">
        </div>
   </div>
</div>
<b style="font-weight: 800;font-size: 18px;">Provident Fund</b>
<hr>
<div class="row row-sm">
<div class="col-6">
        <div class="form-group">
        <label class="font-weight-600">Employee Contribution</label>
        <input type="text" readonly name="employee_contri" id="pfAmount" value="" class="form-control">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
        <label class="font-weight-600">Employer Contribution</label>     
        <input type="text" readonly name="employer_contri" id="pfAmount_employer" value="" class="form-control">
    </div>
</div>
</div>
<div class="row row-sm">
<div class="col-4">
        <div class="form-group">
        <label class="font-weight-600">Advance</label>
        <input type="text" name="advance" id="advance" value="" class="form-control">
        </div>
   </div>
<div class="col-4">
        <div class="form-group">
        <label class="font-weight-600">TDS</label>
        <input type="text" name="tds" id="tds" value="" class="form-control">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
        <label class="font-weight-600">Arrear</label>     
        <input type="text" name="arrear" id="arrear" value="" class="form-control">
    </div>
</div>
</div>
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
        <label class="font-weight-600">Bonus</label>
        <input type="text" name="bonus" id="bonus" value="" class="form-control">
        </div>
   </div>
   <div class="col-4">
        <div class="form-group">
        <label class="font-weight-600">Total Amount to paid</label>
        <input type="text" readonly name="total_amount" id="total_amount" value="" class="form-control">
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
        <label class="font-weight-600">Remarks (If Any)</label>     
        <textarea rows="3"  name="remark" value="" class="centered form-control"
                placeholder="Enter Remarks"></textarea>
    </div>
</div>
</div>
<br>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('employeepayroll') }}">Back</a>

</div>
<script src="{{ url('backEnd/ckeditor/ckeditor.js')}}"></script>

<script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
        })
        .then(editor => {
            window.editor = editor;
        })
        .catch(err => {
            console.error(err.stack);
        });

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
  $(document).ready(function(){
  $('#related').on('change', function() {
    if ( this.value == '0')
    {
      $("#assignment").show();
      document.getElementById("assignment").required = true;
      $("#client").hide();
      $("#other").hide();	  
    }
    
    else if ( this.value == '1')
    {
      $("#client").show();
		  document.getElementById("client").required = true;
      $("#assignment").hide();
      $("#other").hide();
    }
   
    else if ( this.value == '2')
    {
      $("#other").show();
		  document.getElementById("other").required = true;
      $("#assignment").hide();
      $("#client").hide();
    }
    else
    {
      $("#assignment").hide();
      $("#client").hide();
      $("#other").hide();
    }
  });
});
</script>
<script>
      $(function () {
          $('#client1').on('change', function () {
              var cid = $(this).val();
              // alert(category_id);
              $.ajax({
                  type: "get",
                  url: "{{ url('discuss/create') }}",
                  data: "cid=" + cid,
                  success: function (res) {
                      $('#assignment1').html(res);
                  },
                  error: function () {},
              });
          });
      });

  </script>