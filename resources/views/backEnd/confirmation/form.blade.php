<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Title <span class="tx-danger">*</span></label>
            <input type="text" name="title" value="{{ $template->title ?? ''}}" class="form-control"
                placeholder="Enter Name">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Type<span class="tx-danger">*</span></label>
            <select name="type"  class="form-control">
                <!--placeholder-->
                @if(Request::is('template/*/edit')) >
                @if($template->type=='1')
                <option value="1">Debtor</option>
                <option value="2">Creditor</option>
                <option value="3">Bank</option>

                @elseif($template->type=='2')
                <option value="2">Creditor</option>
                <option value="1">Debtor</option>
                <option value="3">Bank</option>

                @else
                <option value="3">Bank</option>
                 <option value="1">Debtor</option>
                <option value="2">Creditor</option>
               
                @endif
                @else
                <option value="1">Debtor</option>
                <option value="2">Creditor</option>
                <option value="3">Bank</option>
                @endif
            </select>
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Description <span class="tx-danger">*</span></label>
            <textarea rows="14" name="description" value="" class="centered form-control" id="editor"
                placeholder="Enter Description">{!! $template->description ??'' !!}</textarea>
        </div>
    </div>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('template') }}">
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
