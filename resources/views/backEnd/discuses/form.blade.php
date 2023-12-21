 <div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
        <label class="font-weight-600">Topic</label>
        <input type="text" name="title" value="" class="form-control">     
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
        <label class="font-weight-600">Discuss With</label>
        <select class="form-control basic-multiple language" multiple="multiple" name="teammember_ids[]" @if(Request::is('task/*/edit'))>
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
    </div>
    <div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
        <label class="font-weight-600">Participate</label>
        <select class="form-control basic-multiple" multiple="multiple" name="teammember_id[]" @if(Request::is('task/*/edit'))>
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
  
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Related To </label>
            <select name="relatedto" id="related" class="form-control">
                <option value="">Please Select One</option>
                <option value="0">Assignment</option>
                <option value="1">Client</option>
                <option value="2">Other</option>
            </select>
        </div>
    </div> 
</div>
<div class="row row-sm">                  
    <div class="col-6" id="assignment" style="display: none">
      <div class="form-group">
          <label class="font-weight-600">Assignment Name</label>
            <select name="related_id" id="assignment_id" class="form-control" @if(Request::is('task/*/edit'))>
                <option disabled style="display:block">Please Select </option>
           
            @foreach($assignment as $assignmentData)
             <option value="{{$assignmentData->id}}" @if(Request::is('discuses/*/edit')) 
               @foreach($taskassign as $team) 
              {{ $assignmentData->id == $team->teammember_id ? 'selected' : '' }} @endforeach   @endif>
              {{ $teammemberData->team_member }}
            </option>
           @endforeach

         @else
              <option></option>
              <option value="">Please Select One</option>
              @foreach($assignment as $assignmentData)
              <option value="{{$assignmentData->id}}">
              {{ $assignmentData->assignment_name }} </option>

            @endforeach
        @endif           
    </select>
      </div>
      </div>
      </div>
      <div class="row row-sm">                                 
    <div class="col-6" id="client" style="display: none">
      <div class="form-group">
          <label class="font-weight-600">Client Name</label>
            <select name="related_ids" id="assignment_id" class="form-control" @if(Request::is('task/*/edit'))>
                <option disabled style="display:block">Please Select </option>
           
            @foreach($assignment as $assignmentData)
             <option value="{{$assignmentData->id}}" @if(Request::is('discuses/*/edit')) 
               @foreach($taskassign as $team) 
              {{ $assignmentData->id == $team->teammember_id ? 'selected' : '' }} @endforeach   @endif>
              {{ $teammemberData->team_member }}
            </option>
           @endforeach

         @else
              <option></option>
              <option value="">Please Select One</option>
              @foreach($client as $clientData)
              <option value="{{$clientData->id}}">
              {{ $clientData->client_name }} </option>

            @endforeach
        @endif               
    </select>
      </div>
      </div>
      <!-- <div class="col-6" id="hr" style="display: none">
        <div class="form-group">
        <label class="font-weight-600">HR</label>
        <input type="text" name="hr" value="" class="form-control">     
        </div>
    </div>
    <div class="col-6" id="it" style="display: none">
        <div class="form-group">
        <label class="font-weight-600">IT</label>
        <input type="text" name="it" value="" class="form-control">     
        </div>
    </div> -->
    <div class="col-6" id="other" style="display: none">
        <div class="form-group">
        <label class="font-weight-600">Other</label>
        <input type="text" name="other" value="" class="form-control">     
        </div>
    </div>
    
    
</div>
  <div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
        <label class="font-weight-600">Description</label>
        <textarea rows="14" name="description" value="" class="centered form-control" id="editor"
                placeholder="Enter Description">{!! $task->description ??'' !!}</textarea>
        </div>
    </div>
    </div>
<br>

<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('discuses') }}">Back</a>

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