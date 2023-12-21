
<div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Question *</label>
            <textarea class="centered form-control"  name="question" rows="4" 
            placeholder="Enter Question"></textarea> 
        </div>
    </div>
    </div>
    <div class="row row-sm">
    <div class="col-4">
        <div class="form-group mg-b-0">
            <label class="form-label">Option 1: <span class="tx-danger">*</span></label>
            <input class="form-control" name="answer[]" value=""
                placeholder="Enter Option 1" type="text">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group mg-b-0">
            <label class="form-label">Option 2: <span class="tx-danger">*</span></label>
            <input class="form-control" name="answer[]" value=""
                placeholder="Enter Option 2" type="text">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group mg-b-0">
            <label class="form-label"> Option 3: <span class="tx-danger">*</span></label>
            <input class="form-control" name="answer[]" placeholder="Enter Option 3"
                value="" type="text">
        </div>
    </div>
</div>
<div class="row row-sm">
<div class="col-6">
        <div class="form-group mg-b-0">
            <label class="form-label">Option 4: <span class="tx-danger">*</span></label>
            <input class="form-control" name="answer[]" value=""
                placeholder="Enter Option 4" type="text">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group mg-b-0">
            <label class="form-label">Correct Answer: <span class="tx-danger">*</span></label>
            <input class="form-control" name="correctanswer" value=""
                placeholder="EnterCorrect Answer" type="text">
        </div>
    </div>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('/questionpaper') }}">
        Back</a>

</div>
