<div class="row row-sm">
    <div class="col-3">
    </div>

    <div class="col-6 card" style="padding:20px;">

        <div class="form-group" style="text-align: center">
            <label class="font-weight-600"> @if(Request::is('teamlevel/edit/*')) Edit Role Name @else Add Role Name * @endif</label>
            <input type="text" name="rolename" @if(Request::is('teamlevel/edit/*')) value="{{ $teamrole->rolename }}"
               @endif class="form-control" placeholder="Enter Name">
        </div>
        <div class="form-group form-check">
            <label class="font-weight-600">Assign Permission *</label>
            <ul>
                @foreach($page as $pageData)
                <li>
                    <label class="form-check-label" for="exampleCheck1">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="page_id[]"
                            value=" {{ $pageData->id }}" @if(Request::is('teamlevel/edit/*')) @foreach($teamlevel as
                            $team) {{ $pageData->id == $team->page_id ? 'checked=checked' : '' }} @endforeach @endif>
                        {{ $pageData->pagename }}</label>
                </li>

                @endforeach
            </ul>

        </div>

        <button type="submit" class="btn btn-success">Submit</button>
    </div>
    <div class="col-3">
    </div>
</div>
