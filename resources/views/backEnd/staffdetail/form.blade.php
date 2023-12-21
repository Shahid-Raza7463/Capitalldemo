<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Teammember *</label>
            <select class="language form-control"  id="teammember" name="teammember_id"
                @if(Request::is('staffdetail/*/edit'))> <option disabled style="display:block">Please Select One
                </option>

                @foreach($client as $teammemberData)
                <option value="{{$teammemberData->id}}"
                    {{$staffdetail->id== $teammemberData->id??'' ?'selected="selected"' : ''}}>
                    {{ $teammemberData->team_member }} (  {{$teammemberData->rolename }} )</option>
                @endforeach


                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}">
                    {{ $teammemberData->team_member }} (  {{$teammemberData->rolename }} )</option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
  
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Type *</label>
            <select class="form-control" id="type" required name="type">
                <option value="">Please Select One</option>
                <option value="0">Partner</option>
                <option value="1">Qualified</option>
                <option value="2">Article Trainee</option>
                <option value="3">Other Staff</option>

            </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Qualification</label>
            <input required type="text" name="qualification" value="{{ $staffdetail->qualification ?? ''}}"
                class=" form-control" placeholder="Enter Qualification">
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-4" id="membership" style="display: none">
        <div class="form-group">
            <label class="font-weight-600">Membership No</label>
            <input type="text" name="membership_no" value="{{ $staffdetail->membership_no ?? ''}}"
                class=" form-control" placeholder="Enter Membership No">
        </div>
    </div>
    <div class="col-4" id="experience" style="display: none">
        <div class="form-group">
            <label class="font-weight-600">Experience</label>
            <input type="text" name="experience" value="{{ $staffdetail->experience ?? ''}}"
                class=" form-control" placeholder="Enter Experience">
        </div>
    </div>
    <div class="col-4" id="dateofassociate" style="display: none">
        <div class="form-group">
            <label class="font-weight-600">Date of Association with the Firm</label>
            <input type="date"  name="date_of_association" value="{{ $staffdetail->date_of_association ?? ''}}"
                class=" form-control" placeholder="Enter Date of Association with the Firm">
        </div>
    </div>
    <div class="col-4" id="dateofjoining" style="display: none">
        <div class="form-group">
            <label class="font-weight-600">Date of Joining</label>
            <input type="date"  id="Date_of_Joining" name="dateofjoining" value="{{ $staffdetail->dateofjoining ?? ''}}"
                class=" form-control" placeholder="Enter Date of Joining">
        </div>
    </div>
  
</div>

<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('staffdetail') }}">
        Back</a>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
  $(document).ready(function(){
  $('#type').on('change', function() {
    if ( this.value == '0')
    {
      $("#membership").show();
      document.getElementById("membership").required = true;
      $("#experience").show();
      document.getElementById("experience").required = true;
      $("#dateofassociate").show();
      document.getElementById("dateofassociate").required = true;
      $("#dateofjoining").hide();
   
    }
    
    else if ( this.value == '1')
    {
      $("#membership").show();
      document.getElementById("membership").required = true;
      $("#experience").show();
      document.getElementById("experience").required = true;
      $("#dateofjoining").show();
      document.getElementById("dateofjoining").required = true;
      $("#dateofassociate").hide();
    }
    else if ( this.value == '2')
    {
      $("#dateofjoining").show();
		  document.getElementById("dateofjoining").required = true;
      $("#membership").hide();
      $("#experience").hide();
      $("#dateofassociate").hide();	
    }
    else if ( this.value == '3')
    {
      $("#experience").show();
		  document.getElementById("experience").required = true;
      $("#dateofjoining").show();
		  document.getElementById("dateofjoining").required = true;
      $("#dateofassociate").hide();
      $("#membership").hide();
    }
    else
    {
        $("#membership").hide();
        $("#experience").hide();
        $("#dateofjoining").hide();
        $("#dateofassociate").hide();
      
    }
  });
});
</script>
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
 
 </script>