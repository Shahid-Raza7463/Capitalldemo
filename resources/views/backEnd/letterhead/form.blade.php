<div class="row row-sm">
 
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">letterhead Name <span class="tx-danger">*</span></label>
            <input type="text" name="letterheadname" value="{{ $letterhead->letterheadname ?? ''}}" class="form-control"
                placeholder="Enter Name">
        </div>
    </div>
   
</div>
<div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Description <span class="tx-danger">*</span></label>
            <textarea rows="14" name="description" value="" class="centered form-control" id="editor"
                placeholder="Enter Description">{!! $letterhead->description ??'' !!}</textarea>
        </div>
    </div>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('letterhead') }}">
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
