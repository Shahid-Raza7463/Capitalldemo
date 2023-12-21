<div class="row row-sm">
<div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Sent By</label>
            <select required class="language form-control" id="exampleFormControlSelect1" name="sendby"
                @if(Request::is('proposal/*/edit'))> 
                <option disabled style="display:block">Please Select One</option>

                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}"
                    {{$applyleave->Approver == $teammemberData->id??'' ?'selected="selected"' : ''}}>
                    {{$teammemberData->team_member }}( {{$teammemberData->role->rolename }} )</option>
                @endforeach


                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}">
                    {{ $teammemberData->team_member }} ( {{$teammemberData->role->rolename }} , {{ $teammemberData->emailid }}  )</option>

                @endforeach
                @endif
            </select>
        </div>
    </div> 
	 <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Name Of Service</label>
            <input type="text" required name="nameofservice" value="{{ $applyleave->nameofservice ??''}}" class="form-control"
                placeholder="">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">To</label>
            <input type="text" required name="to" value="{{ $applyleave->reasonleave ??''}}" class="form-control"
                placeholder="">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Profile</label>
            <input type="file" id="localconveyance-img" name="attachment[]" multiple="multiple"
                class="form-control"
                placeholder="Enter Copy of Supporting files">
			<span style="
    color: green;
    font-size: 11px;
">Upload PPT File Only</span>
        </div>
    </div>   
</div>
<br>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('applyleave') }}">
        Back</a>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  

<script>
      $(function () {
          $('#client').on('change', function () {
              var cid = $(this).val();
              // alert(category_id);
              $.ajax({
                  type: "get",
                  url: "{{ url('reportsection') }}",
                  data: "cid=" + cid,
                  success: function (res) {
                      $('#assignment').html(res);
                  },
                  error: function () {},
              });
          });
          $('#assignment').on('change', function () {
              var ass_id = $(this).val();
              // alert(category_id);
              $.ajax({
                  type: "get",
                  url: "{{ url('reportsection') }}",
                  data: "ass_id=" + ass_id,
                  success: function (res) {
                      $('#partner').html(res);
                  },
                  error: function () {},
              });
          });
      });

  </script>
  

<script>
    $(document).ready(function () {
        $('.dropdown').select2();
    });

</script>
