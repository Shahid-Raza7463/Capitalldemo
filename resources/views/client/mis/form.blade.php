<div class="row row-sm">
	<div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Property No. <span class="tx-danger">*</span></label>
            <input type="text" name="pictureno" value="{{ $mis->pictureno ?? ''}}" class="form-control"
                placeholder="Enter Property No">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Attachment <span class="tx-danger">*</span></label>
            <input type="file" name="attachment[]" value="{{ $mis->attachment ?? ''}}" multiple="multiple" class="form-control"
                placeholder="Enter Attachment">
			<span>multiple image upload </span>
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Instruction <span class="tx-danger">*</span></label>
            <textarea rows="14" name="instruction" value="" class="centered form-control" id="editor"
                placeholder="Enter Instruction">{!! $mis->instruction ??'' !!}</textarea>
        </div>
    </div>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('client/mis') }}">
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
