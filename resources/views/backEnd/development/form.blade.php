<div class="row row-sm">
<div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Task Name <span class="tx-danger">*</span></label>
            <input required type="text" name="taskname" value="{{ $development->taskname ?? ''}}" class="form-control"
                placeholder="Enter Name">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Testing By </label>
            <select class="language form-control" name="testingby" @if(Request::is('task/*/edit'))>
                <option disabled style="display:block">Please Select One</option>

                  @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}" @if(Request::is('task/*/edit')) @foreach($taskassign as
                    $team) {{ $teammemberData->id == $team->teammember_id ? 'selected' : '' }} @endforeach   @endif>
                {{ $teammemberData->team_member }} (
                    {{ $teammemberData->role->rolename}} ) ( {{ $teammemberData->emailid ??''}} )</option>
                @endforeach

                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}">
                    {{ $teammemberData->team_member }} ( {{ $teammemberData->role->rolename}} ) ( {{ $teammemberData->emailid ??''}} ) </option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Testing Date <span class="tx-danger">*</span></label>
            <input type="date" name="testingdate" value="{{ $task->duedate ?? ''}}" class="form-control"
                placeholder="Enter Mobile No">
        </div>
    </div>
    </div>
    <div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Due Date <span class="tx-danger">*</span></label>
            <input required type="date" name="duedate" value="{{ $task->duedate ?? ''}}" class="form-control"
                placeholder="Enter Mobile No">
        </div>
    </div>
	  <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Task Given By *</label>
            <select required class="language form-control" id="exampleFormControlSelect1" name="taskgivenby" @if(Request::is('task/*/edit'))>
                <option disabled style="display:block">Please Select One</option>

                  @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}" @if(Request::is('task/*/edit')) @foreach($taskassign as
                    $team) {{ $teammemberData->id == $team->teammember_id ? 'selected' : '' }} @endforeach   @endif>
                {{ $teammemberData->team_member }} (
                    {{ $teammemberData->role->rolename}} ) ( {{ $teammemberData->emailid ??''}} )</option>
                @endforeach


                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}">
                    {{ $teammemberData->team_member }} ( {{ $teammemberData->role->rolename}} ) ( {{ $teammemberData->emailid ??''}} ) </option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
	 <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Status</label>
            <select name="status" class="form-control">
                <!--placeholder-->
                @if(Request::is('development/*/edit')) >
             @if($development->status=='0')
                <option value="0">Active</option>
                <option value="1">Inactive</option>
    
               
                @else
                
                <option value="1">Inactive</option>
                <option value="0">Active</option>
              
               
                @endif
                @else
                <option value="">Please Select One</option>
                <option value="0">Active</option>
                <option value="1">Inactive</option>
               
    
                @endif
            </select>
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Remarks <span class="tx-danger">*</span></label>
            <textarea rows="14" name="remarks" value="" class="centered form-control" id="editor"
                placeholder="Enter Remark">{!! $task->description ??'' !!}</textarea>
        </div>
    </div>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('development') }}">
        Back</a>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
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
