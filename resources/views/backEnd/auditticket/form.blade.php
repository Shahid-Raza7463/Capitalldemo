<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Name of Employee *</label>
            <input required type="text" readonly name="createdby" value="{{ App\Models\Teammember::where('id',
                auth()->user()->teammember_id)->pluck('team_member')->first() ??''}}({{ auth()->user()->email}})"
                class="form-control" placeholder="Enter Name">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Audit Query <span class="tx-danger">*</span></label>
            <input required type="text" name="taskname" value="{{ $task->taskname ?? ''}}" class="form-control"
                placeholder="Enter Name">
        </div>
    </div>
	<div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Client *</label>
            <select class="language form-control" id="exampleFormControlSelect1" name="client_id"
                @if(Request::is('assignmentbudgeting/*/edit'))> <option disabled style="display:block">Please Select One
                </option>

                @foreach($client as $clientData)
                <option value="{{$clientData->id}}"
                    {{$task->client->id== $clientData->id??'' ?'selected="selected"' : ''}}>
                    {{$clientData->client_name }} (  {{$clientData->gstno }} )</option>
                @endforeach


                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($client as $clientData)
                <option value="{{$clientData->id}}">
                    {{ $clientData->client_name }} (  {{$clientData->gstno }} )</option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-4" style="display:none;">
        <div class="form-group">
            <label class="font-weight-600">To *</label>
            <input required type="text" readonly name="too" value="secretarial@kgsomani.com"
                class="form-control" placeholder="Enter Name">
        </div>
    </div>

</div>
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Timeline <span class="tx-danger">*</span></label>
            <input required type="date" name="duedate" value="{{ $task->duedate ?? ''}}" class="form-control">
        </div>
    </div>
	<div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Priority <span class="tx-danger">*</span></label>
            <select name="priority" class="form-control">
                                            <option>Select Priority</option>
                                            <option value="0">High</option>
                                            <option value="1">Medium</option>
                                            <option value="2">Low</option>
                                        </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Attachment </label>
            <input type="file" name="file[]" multiple="" value="" class="form-control">
        </div>
    </div>

</div>
<div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Description of Query <span class="tx-danger">*</span></label>
            <textarea rows="14" name="description" value="" class="centered form-control" id="editor"
                placeholder="Enter Description">{!! $task->description ??'' !!}</textarea>
        </div>
    </div>
</div>
{{-- <div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Additional Details </label>
            <textarea rows="3" name="addtional_details" value="" class="centered form-control"
                placeholder="Enter Text">{!! $task->addtional_details ??'' !!}</textarea>
        </div>
    </div>
</div> --}}


<div class="row row-sm">
 <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">CC To *</label>
            <select class="form-control basic-multiple" multiple="multiple" name="teammember_id[]"
                @if(Request::is('task/*/edit'))> <option disabled style="display:block">Please Select </option>

                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}" @if(Request::is('secretaryoftask/*/edit')) @foreach($taskassign
                    as $team) {{ $teammemberData->id == $team->teammember_id ? 'selected' : '' }} @endforeach @endif>
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


<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('secretaryoftask') }}">
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
