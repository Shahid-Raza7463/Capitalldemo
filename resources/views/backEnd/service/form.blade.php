<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Service Name</label>
            <input type="text" name="servicename" value="{{ $service->servicename ?? ''}}" class="form-control"
                placeholder="Enter Service Name">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Brif.</label>
            <input type="text" name="brif" value="{{ $service->brif ?? ''}}" class="form-control"
                placeholder="Enter Brif">
        </div>
    </div>
</div>
<div class="form-group">
                                <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
                                <a class="btn btn-secondary" href="{{ url('service') }}">
                                    Back</a>

                            </div>
