<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Assign *</label>
            <select class="language form-control"  id="category" name="teammember_id"
            @if(Request::is('task/*/edit'))> <option disabled
            style="display:block">Please Select One</option>

            @foreach($teammember as $teammemberData)
            <option value="{{$teammemberData->id}}"
            @if(($task->teammember_id) == $teammemberData->id) selected @endif>
                {{ $teammemberData->title->title }}. {{ $teammemberData->team_member }}( {{ $teammemberData->role->rolename}} )</option>
            @endforeach


            @else
            <option></option>
            <option value="">Please Select One</option>
            @foreach($teammember as $teammemberData)
            <option value="{{$teammemberData->id}}">
                {{ $teammemberData->team_member }} ( {{ $teammemberData->role->rolename}} )</option>

            @endforeach
            @endif
        </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Task Name <span class="tx-danger">*</span></label>
            <input type="text" name="taskname" value="{{ $task->taskname ?? ''}}" class="form-control"
                placeholder="Enter Name">
        </div>
    </div>
      <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Due Date <span class="tx-danger">*</span></label>
            <input type="date" name="duedate" value="{{ $task->duedate ?? ''}}" class="form-control"
                placeholder="Enter Mobile No">
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Description <span class="tx-danger">*</span></label>
            <textarea rows="14" name="description" value="" class="centered form-control"  id="editor"
            placeholder="Enter Description">{!! $task->description ??'' !!}</textarea>
        </div>
    </div>
</div>
<div class="form-group">
                                <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
                                <a class="btn btn-secondary" href="{{ url('task') }}">
                                    Back</a>

                            </div>
                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script><script src="{{ url('backEnd/ckeditor/ckeditor.js')}}"></script>

                            <script>
                                ClassicEditor
                                    .create( document.querySelector( '#editor' ), {
                                        // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
                                    } )
                                    .then( editor => {
                                        window.editor = editor;
                                    } )
                                    .catch( err => {
                                        console.error( err.stack );
                                    } );
                            </script>
                            <script>
                                ClassicEditor
                                    .create( document.querySelector( '#editor1' ), {
                                        // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
                                    } )
                                    .then( editor => {
                                        window.editor = editor;
                                    } )
                                    .catch( err => {
                                        console.error( err.stack );
                                    } );
                            </script>