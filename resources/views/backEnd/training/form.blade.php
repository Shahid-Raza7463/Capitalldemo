<div class="row row-sm">

    <div class="col-12">
        <div class="form-group">
            <div class="details-form-field form-group row">
                <label for="name" class="col-md-1 col-form-label font-weight-600">Module : </label>

                <div class="col-md-11 row" style="margin-top: 9px;">
                    @foreach($pages as $page)
                    <div class="form-group" style="padding-left: 40px;">
                        <label for="exampleInputPassword1"
                            style="font-size: 14px;"><b>{{ ucfirst($page->pagename) ??''}}</b></label>

                        <div class=" form-check">
                            <input type="checkbox" name="page_id[]" value="{{ $page->id ??''}}" @if(Request::is('training/list/*')) @foreach($trainingDatas as
                            $team) {{ $page->id == $team->page_id ? 'checked=checked' : '' }} @endforeach @endif class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Understood</label>
                        </div>

                    </div>
                    @endforeach

                </div>

            </div>
        </div>
    </div>
</div>
@if(Request::is('training/create'))
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>

</div>
@endif
