<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Subject</label>
            <input type="text" name="title" value="{{ $notification->title ?? '' }}" class="form-control"
                placeholder="Enter Subject">
        </div>
    </div>
    {{-- <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Target.</label>
            <select class="form-control" id="exampleFormControlSelect1" name="targettype">
                <option>Please Select One</option>
                <option value="1">Individual</option>
                <option value="2">All Member</option>
                <option value="3">Partner</option>
                <option value="4">Manager</option>
                <option value="5">Staff</option>
                <option value="6">IT Department</option>
                <option value="7">Accountant</option>
            </select>
        </div>
    </div> --}}

    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Target.</label>

            <select class="form-control basic-multiple" multiple="multiple" id="exampleFormControlSelect1"
                name="targettype[]">
                <option value="" disabled> Please Select One</option>
                <option value="1">Individual</option>
                <option value="2">All Member</option>
                <option value="3">Partner</option>
                <option value="4">Manager</option>
                <option value="5">Staff</option>
                <option value="6">IT Department</option>
                <option value="7">Accountant</option>
            </select>
        </div>
    </div>


</div>
<div class="row row-sm">
    <!-- <div class="col-6"  style='display:none;' id='designation'>
        <div class="form-group">
        <label class="font-weight-600">Employee </label>
            <select class="form-control " multiple="multiple" name="teammember_id[]">
                <option value="">Please Select One</option>
                @foreach ($teammember as $teammemberData)
<option value="{{ $teammemberData->id }}">
                    {{ $teammemberData->team_member }} ( {{ $teammemberData->emailid ?? '' }} ) </option>
@endforeach
    
            </select>
        </div>
    </div> -->
    <div class="col-6" style='display:none;' id='designation'>
        <div class="form-group">
            <label class="font-weight-600">Employee</label>
            <select class="language form-control" multiple="" name="teammember_id[]" id="designation">
                @foreach ($teammember as $teammemberData)
                    <option value="{{ $teammemberData->id }}">
                        {{ $teammemberData->team_member }} ( {{ $teammemberData->emailid ?? '' }} )
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">File Upload</label>
            <input type="file" name="attachment" class="form-control" placeholder="Upload file">
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Announcement Content</label>
            <textarea rows="4" name="mail_content" class="centered form-control" id="summernote"
                placeholder="Enter Description" id="editors" style="height:500px;"></textarea>
        </div>
    </div>
</div>
<br>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right">Send</button>
    <a class="btn btn-secondary" href="{{ url('notification') }}">
        Back</a>

</div>
<script src="{{ url('backEnd/ckeditor/ckeditor.js') }}"></script>
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
<script type="text/javascript" src="http://www.datejs.com/build/date.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
