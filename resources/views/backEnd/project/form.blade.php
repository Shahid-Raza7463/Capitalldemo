
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-300">Client Name</label>
            <select class="language form-control" name="client_id"
                @if(Request::is('project/*/edit'))> <option disabled style="display:block">Select
                Client
                </option>

                @foreach($client as $clientData)
                <option value="{{$clientData->id}}"
                    {{$project->client_id== $clientData->id??'' ?'selected="selected"' : ''}}>
                    {{$clientData->client_name }}</option>
                @endforeach


                @else
                <option></option>
                <option value="">Select Client</option>
                @foreach($client as $clientData)
                <option value="{{$clientData->id}}">
                    {{ $clientData->client_name }}</option>

                @endforeach
                @endif
            </select>
            
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-300">Project Name</label>
            <input type="text" name="project_name"
            value="{{ $project->project_name ?? ''}}" class="form-control">   
            
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-300">Project Head</label>
            <select class="language form-control" name="teammember_id"
                @if(Request::is('project/*/edit'))> <option disabled style="display:block">Select
                    Project Head
                </option>

                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}"
                    {{$project->teammember_id== $teammemberData->id??'' ?'selected="selected"' : ''}}>
                    {{$teammemberData->team_member }}   ( {{ $teammemberData->role->rolename }} )</option>
                @endforeach


                @else
                <option></option>
                <option value="">Select  Project Head</option>
                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}">
                    {{ $teammemberData->team_member }}   ( {{ $teammemberData->role->rolename }} )</option>

                @endforeach
                @endif
            </select>
           
            
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-300">Project Manager</label>
            <select class="language form-control" name="projectmanager"
            @if(Request::is('project/*/edit'))> <option disabled style="display:block">Select
                Project Manager
            </option>

            @foreach($teammember as $teammemberData)
            <option value="{{$teammemberData->id}}"
                {{$project->teammember_id== $teammemberData->id??'' ?'selected="selected"' : ''}}>
                {{$teammemberData->team_member }}   ( {{ $teammemberData->role->rolename }} )</option>
            @endforeach


            @else
            <option></option>
            <option value="">Select Project Manager</option>
            @foreach($teammember as $teammemberData)
            <option value="{{$teammemberData->id}}">
                {{ $teammemberData->team_member }}   ( {{ $teammemberData->role->rolename }} )</option>

            @endforeach
            @endif
        </select>
            
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-300">Project User</label>
            <select class="language form-control" name="projectuser"
                @if(Request::is('project/*/edit'))> <option disabled style="display:block">Select
                User
                </option>

                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->team_member}}"
                    {{$project->projectuser== $teammemberData->team_member??'' ?'selected="selected"' : ''}}>
                    {{$teammemberData->team_member }}   ( {{ $teammemberData->role->rolename }} )</option>
                @endforeach


                @else
                <option></option>
                <option value="">Select user</option>
                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->team_member}}">
                    {{ $teammemberData->team_member }}   ( {{ $teammemberData->role->rolename }} )</option>

                @endforeach
                @endif
            </select>

            <!-- <select class="language form-control" id="key" name="projectuser">

<option>Please Select One</option>
@foreach($teammember as $teammemberData)
<option value="{{$teammemberData->team_member}}" @if(!empty($store->
    financial) && $store->
    financial==$teammemberData->team_member) selected @endif>
      {{ $teammemberData->title->title ??''}}. {{ $teammemberData->team_member }}  ( {{ $teammemberData->role->rolename }} )</option>
@endforeach
</select>    -->
            
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-300">Description</label>
            <textarea type="text" name="description"
                value="" class="form-control">{{ $project->description ?? ''}}</textarea> 
            
        </div>
    </div>
</div>
<hr>



<div class="form-group">
    
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('project') }}">
        Back</a>

</div>

