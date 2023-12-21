
<div class="row row-sm">
   
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Select Your Reporting Partner *</label>
            <select required class="language form-control" id="category" name="partner"
            @if(Request::is('trainingassetsments/*/edit'))> <option disabled
            style="display:block">Please Select One</option>

            @foreach($partner as $teammemberData)
            <option value="{{$teammemberData->id}}"
            @if(($trainingassetsments->leadpartner) == $teammemberData->id) selected @endif>
              {{ $teammemberData->team_member }}</option>
            @endforeach


            @else
            <option></option>
            <option value="">Please Select One</option>
            @foreach($partner as $teammemberData)
            <option value="{{$teammemberData->id}}">
             {{ $teammemberData->team_member }}</option>

            @endforeach
            @endif
        </select>
        </div>
    </div>
</div>
<br>
<div class="row row-sm ">
    <div class="col-12">
        <div class="form-group">
            <label class="fs-17 font-weight-600 mb-0"><b>Please Share Training Requirement Of Your Team</b></label>
        </div>
    </div>
</div>
<hr>
<div class="field_wrapper">
    <div class="row row-sm">
      
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600">Name of Team Member*</label>
                <select required class="language form-control" id="teammemberid" name="teammemberid">

                    <option>Please Select One</option>
                    @foreach($teammember as $teammemberData)
                    <option value="{{$teammemberData->id}}" @if(!empty($store->
                        financial) && $store->
                        financial==$teammemberData->id) selected @endif>
                      {{ $teammemberData->team_member }}  ( {{ $teammemberData->role->rolename }} )</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label class="font-weight-600">Please Mention Topic For Technical Training *</label>
                <input required type="text" id="trainingtype" name="trainingtype" value="{{ $assignmentmapping->stdcost ?? ''}}" class=" form-control key"
                placeholder="Enter Training Type">
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label class="font-weight-600">Select Topics for Soft Skills Training *</label>
                <select required class="form-control basic-multiple"  multiple="multiple" id="softskillstraining" name="softskillstraining[]"
                @if(Request::is('trainingassetsments/*/edit'))> <option disabled
                style="display:block">Please Select One</option>
    
                @foreach($softskillstraining as $softskillstrainingData)
                <option value="{{$softskillstrainingData->id}}"
                @if(($trainingassetsments->leadpartner) == $softskillstrainingData->id) selected @endif>
                   {{ $softskillstrainingData->name }}</option>
                @endforeach
    
    
                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($softskillstraining as $softskillstrainingData)
                <option value="{{$softskillstrainingData->id}}">
                    {{ $softskillstrainingData->name }}</option>
    
                @endforeach
                @endif
            </select>
            </div>
        </div>
        <div class="col-3" id="keyother" style="display: none;">
            <div class="form-group">
                <label class="font-weight-600">Other Skills</label>
                <input type="text" id="Other" name="other" value="{{ $assignmentmapping->stdcost ?? ''}}" class=" form-control key"
                placeholder="Enter Other Skills">
            </div>
        </div>
        {{-- <div class="col-1">
            <div class="form-group">
                <label class="font-weight-600">Add</label>
                <br>
                <button type="submit" class="btn btn-primary" id="butsave">Add</button>
            </div>
        </div> --}}
       
   
</div>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
 <a class="btn btn-secondary" href="{{ url('trainingassetsments') }}">
        Back</a>

</div>

<script>
    $(document).ready(function() {
       
        $('#butsave').on('click', function() {
          var partner = $('#partner').val();
          var teammemberid = $('#teammemberid').val();
          var trainingtype = $('#trainingtype').val();
          var softskillstraining = $('#softskillstraining').val();
          var password = $('#other').val();
          if(partner!="" && email!="" && phone!="" && city!=""){
            /*  $("#butsave").attr("disabled", "disabled"); */
              $.ajax({
                  url: "/userData",
                  type: "POST",
                  data: {
                      _token: $("#csrf").val(),
                      type: 1,
                      name: name,
                      email: email,
                      phone: phone,
                      city: city
                  },
                  cache: false,
                  success: function(dataResult){
                      console.log(dataResult);
                      var dataResult = JSON.parse(dataResult);
                      if(dataResult.statusCode==200){
                        window.location = "/userData";				
                      }
                      else if(dataResult.statusCode==201){
                         alert("Error occured !");
                      }
                      
                  }
              });
          }
          else{
              alert('Please fill all the field !');
          }
      });
    });
    </script>