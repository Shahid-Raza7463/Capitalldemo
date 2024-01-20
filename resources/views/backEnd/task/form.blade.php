<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Assign *</label>
            <select required class="form-control basic-multiple" multiple="multiple" id="category"
                name="teammember_id[]" @if(Request::is('task/*/edit'))> <option disabled style="display:block">Please
                Select One</option>

                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}" @if(Request::is('task/*/edit')) @foreach($taskassign as $team)
                    {{ $teammemberData->id == $team->teammember_id ? 'selected' : '' }} @endforeach @endif>
                    {{ $teammemberData->team_member }} (
                    {{ $teammemberData->role->rolename}} ) ( {{ $teammemberData->emailid ??''}} )</option>
                @endforeach


                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}">
                    {{ $teammemberData->team_member }} ( {{ $teammemberData->role->rolename}} ) (
                    {{ $teammemberData->emailid ??''}} ) </option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Task Name <span class="tx-danger">*</span></label>
            <input required type="text" name="taskname" value="{{ $task->taskname ?? ''}}" class="form-control"
                placeholder="Enter Name">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Due Date <span class="tx-danger">*</span></label>
            <input required type="date" name="duedate" value="{{ $task->duedate ?? ''}}" class="form-control"
                placeholder="Enter Mobile No">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Support By </label>
            <select class="language form-control" id="exampleFormControlSelect1" name="supportby"
                @if(Request::is('task/*/edit'))> <option disabled style="display:block">Please Select One</option>

                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}" @if(Request::is('task/*/edit')) @foreach($taskassign as $team)
                    {{ $teammemberData->id == $team->teammember_id ? 'selected' : '' }} @endforeach @endif>
                    {{ $teammemberData->team_member }} (
                    {{ $teammemberData->role->rolename}} ) ( {{ $teammemberData->emailid ??''}} )</option>
                @endforeach


                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}">
                    {{ $teammemberData->team_member }} ( {{ $teammemberData->role->rolename}} ) (
                    {{ $teammemberData->emailid ??''}} ) </option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Attachment</label>
            <input type="file" name="attachment" class="form-control" placeholder="Enter Attachment">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Related To *</label>
            <select required name="relatedto" id="related" class="form-control">
                <option value="">Please Select One</option>
                <option value="3">Assignment</option>
                <option value="1">Dataroom</option>
                <option value="2">Other</option>
            </select>
        </div>
    </div>
</div>
<div class="row row-sm" id="assignment" style="display: none">

    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Client *</label>
            <select class="form-control" id="categorys" name="kgsclient_id" @if(Request::is('invoice/*/edit'))> <option
                disabled style="display:block">Please Select One</option>

                @foreach($client as $clientData)
                <option value="{{$clientData->id}}"
                    {{$invoice->client_id == $clientData->id ??'' ?'selected="selected"' : ''}}>
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
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Assignment  *</label>
            <select id="subcategory" class="form-control" @if(Auth::user()->role_id != 11 || Auth::user()->role_id !=
                17)
             @endif name="assignment_id"
                >
                @if(!empty($invoice->assignment_id))
                <option value="{{ $invoice->assignment_id }}">
                    {{ App\Models\Assignment::where('id',$invoice->assignment_id)->first()->assignment_name??'' }}
                </option>

                @endif
            </select>
        </div>
    </div>

</div>
<div class="row row-sm">
    <div class="col-4" id="clients" style="display: none">
        <div class="form-group">
            <label class="font-weight-600">Client Name *</label>
            <select name="dataroomclient_id"class="form-control">

                <option value="">Please Select One</option>
                @foreach($dataroom as $clientData)
                <option value="{{$clientData->id}}">
                    {{ $clientData->client_name }} </option>

                @endforeach
            </select>
        </div>
    </div>
    <div class="col-4" id="otherss" style="display:none;">
        <div class="form-group">
            <label class="font-weight-600">Other *</label>
            <input type="text"  name="other" value="" class="form-control">
        </div>
    </div>

</div>
<div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Description <span class="tx-danger">*</span></label>
            <textarea rows="14" name="description" value="" class="centered form-control" id="editor"
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
<script>
    $(document).ready(function () {
        $('#related').on('change', function () {
            if (this.value == '3') {
                $("#assignment").show();
                $("#clients").hide();
                $("#otherss").hide();
            } 
            else if (this.value == '1') {

                $("#clients").show();
                $("#assignment").hide();
                $("#otherss").hide();
            }
             else if (this.value == '2') {

                $("#otherss").show();

                $("#assignment").hide();
                $("#clients").hide();
            } else {
                $("#assignment").hide();
                $("#clients").hide();
                $("#otherss").hide();
            }
        });
    });

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(function () {
        $('#categorys').on('change', function () {
            var category_id = $(this).val();

            $.ajax({
                type: "GET",
                url: "{{ url('taskassignment') }}",
                data: "category_id=" + category_id,
                success: function (res) {

                    $('#subcategory').html(res);


                },
                error: function () {

                },
            });
        });

    });

</script>
