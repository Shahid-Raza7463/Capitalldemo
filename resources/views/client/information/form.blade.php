<div class="row row-sm">
 <div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Question : </label>
            <input id="questions" readonly name="question" style="width:90%;border: 1px solid #FFFFFF;" type="text">
        </div>
    </div>

</div>
<div class="details-form-field form-group row">
    <label class="font-weight-600" style="    margin-left: 11px;">Attachment :</label>
<div class="col-sm-4">
   <input id="name" class="form-control" name="document[]" multiple="multiple" type="file">
  <input  id="ilrid"  class="form-control" hidden   name="id" value="{{ $id ??''}}" type="text">
</div>
<div class="col-sm-8"></div>
</div> 
<div class="details-form-field form-group row">
    <label class="font-weight-600" style="    margin-left: 11px;">Remarks :</label>
<div class="col-sm-12">
    <textarea rows="4" name="remark" class="form-control"
        placeholder="Enter Remarks"></textarea>
</div>
</div> 
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
	<br>
   {{-- <a class="btn btn-secondary" href="{{ url('informationresources') }}">
        Back</a> --}}

</div>
