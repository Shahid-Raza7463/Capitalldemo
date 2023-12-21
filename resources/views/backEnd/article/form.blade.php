<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Subject <span style="color: red;">*</span></label>
            <input type="text" name="subject" value="{{ $article->subject ?? ''}}" class="form-control"
            placeholder="Enter subject">
            <input hidden type="text" name="related_to" value="{{ $id ?? ''}}" class="form-control"
            placeholder="Related To">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">File *</label>
            <input type="file" class="form-control key" name="file" value=""
                placeholder="Enter Document Name">
        </div>
    </div>
</div>
<div class="row row-sm">
<div class="col-12">
    <div class="form-group">
        
                    <label class="font-weight-600">Description <span style="color: red;">*</span></label>
                    <textarea id="summernote" rows="14" class="form-control" name="description" value=""
                      >{!! $article->description ??'' !!}</textarea>
                      
                      
            
    </div>
</div>
</div>
   

<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('article') }}">
        Back</a>

</div>
