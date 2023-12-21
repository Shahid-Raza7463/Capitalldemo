
    <div class="form-group">
        <label class="font-weight-600">Name</label>
        <input type="text" name="tabname" value="{{ $tab->tabname ?? ''}}" class="form-control" placeholder="Enter name">
    </div>
    <div class="form-group">
        <label class="font-weight-600">Color</label>
        <input type="text" name="tabcolor"  value="{{ $tab->tabcolor ?? ''}}" class="jscolor form-control" placeholder="Color">
    </div>
    <div class="form-group">
        <label class="font-weight-600">Sequence</label>
        <input type="text" name="sequence" value="{{ $tab->sequence ?? ''}}" class=" form-control" placeholder="Enter Sequence">
    </div>
    <button type="submit" class="btn btn-success">Submit</button>
