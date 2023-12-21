
<script src="{{ url('backEnd/ckeditordocument/ckeditor.js')}}"></script>
	<script src="{{ url('backEnd/ckeditordocument/samples/js/sample.js')}}"></script>
    @if(Auth::user()->role_id == 11 || Auth::user()->role_id == 16)
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Team Member *</label>
            <select class="language form-control"  id="category" name="teammember_id"
            @if(Request::is('teamprofile/*/edit'))> <option disabled
            style="display:block">Please Select One</option>

            @foreach($teammember as $teammemberData)
            <option value="{{$teammemberData->id}}"
            @if(($teamprofile->teammember_id) == $teammemberData->id) selected @endif>
                {{ $teammemberData->title->title }}. {{ $teammemberData->team_member }}( {{ $teammemberData->role->rolename}} )</option>
            @endforeach


            @else
            <option></option>
            <option value="">Please Select One</option>
            @foreach($teammember as $teammemberData)
            <option value="{{$teammemberData->id}}">
                {{ $teammemberData->team_member }} ( {{ $teammemberData->role->rolename}} )</option>

            @endforeach
            @endif
        </select>
        </div>
    </div>
   
</div>
@endif
<div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Description <span class="tx-danger">*</span></label>
            <textarea rows="14" name="description" value="" class="centered form-control"  id="editor"
            placeholder="Enter Description">{!! $teamprofile->description ??'' !!}</textarea>
        </div>
    </div>
</div>
<div class="form-group">
                                <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
                                <a class="btn btn-secondary" href="{{ url('teamprofile') }}">
                                    Back</a>

                            </div>
                            <script>
                                initSample();
                            </script>
                      