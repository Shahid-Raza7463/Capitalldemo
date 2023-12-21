<div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Assign *</label>
            <select required class="form-control basic-multiple"  multiple="multiple" id="category" name="teammember_id[]" @if(Request::is('penality/*/edit'))>
                <option disabled style="display:block">Please Select One</option>

                  @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}" @if(Request::is('penality/*/edit')) @foreach($taskassign as
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
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Penalty Name <span class="tx-danger">*</span></label>
            <input required type="text" name="taskname" value="{{ $task->taskname ?? ''}}" class="form-control"
                placeholder="Enter Name">
        </div>
    </div>
     <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Amount <span class="tx-danger">*</span></label>
            <input required type="text" name="amount" value="{{ $task->amount ?? ''}}" class="form-control"
                placeholder="Enter Amount">
        </div>
    </div>
	  {{-- <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Support By *</label>
            <select class="language form-control" id="exampleFormControlSelect1" name="supportby" @if(Request::is('task/*/edit'))>
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
    </div> --}}
	 <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Attachment</label>
            <input type="file" name="attachment" class="form-control"
                placeholder="Enter Attachment">
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Description <span class="tx-danger">*</span></label>
            <textarea  rows="14" name="description" value="" class="centered form-control" id="editor"
                placeholder="Enter Description">{!! $task->description ??'' !!}</textarea>
        </div>
    </div>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('task') }}">
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
<script>
    ClassicEditor
        .create(document.querySelector('#editor1'), {
            // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
        })
        .then(editor => {
            window.editor = editor;
        })
        .catch(err => {
            console.error(err.stack);
        });

</script>
