<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Attachment <span class="tx-danger">*</span></label>
            <input type="file" name="kgsattachment" value="{{ $mis->kgsattachment ?? ''}}" class="form-control"
                placeholder="Enter Attachment">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Remark <span class="tx-danger">*</span></label>
            <input type="date" name="remark" value="{{ $mis->remark ?? ''}}" class="form-control"
                placeholder="Enter Remark">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Action <span class="tx-danger">*</span></label>
            <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
        </div>
    </div>
</div>
{{-- <div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('mis') }}">
        Back</a>

</div> --}}
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
