

<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Job Name</label>
            <input type="text" name="job_name"
                value="{{$job->job_name ?? ''}}" class="form-control">   
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Project Name</label>
            <select class="form-control key" name="project_id" id="key"
                @if(Request::is('job/*/edit'))><option disabled style="display:block">Select
                project
                </option>
                @foreach($project as $projectData)
                <option value="{{$projectData->id}}"
                    {{$job->project_id== $projectData->id??'' ?'selected="selected"' : ''}}>
                    {{$projectData->project_name }}</option>
                @endforeach


                @else
                <option></option>
                <option value="">Select Project</option>
                @foreach($project as $projectData)
                <option value="{{$projectData->id}}">
                    {{ $projectData->project_name }}</option>

                @endforeach
                @endif
            </select>   
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Start Date</label>
            <input type="date" name="startdate"
                value="{{$job->startdate ?? ''}}" class="form-control">   
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">End Date</label>
            <input type="date" name="enddate"
                value="{{$job->enddate ?? ''}}" class="form-control">    
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
        <label class="font-weight-600">Billable Status</label>
            <select class="form-control key" name="billable_status" id="key" id="exampleFormControlSelect1">
                @if(Request::is('job/*/edit')) >
                @if($job->billable_status=='Billable')
                <option value="Billable">Billable</option>
                <option value="Non Billable">Non Billable</option>


                @else
                <option value="Non Billable">Non Billable</option>
                <option value="Billable">Billable</option>



                @endif
                @else
                <option value="Billable">Billable</option>
                <option value="Non Billable">Non Billable</option>

                @endif
            </select>
    
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Description</label>
            <textarea type="text" name="description" value="" class="form-control">{{$job->description ?? ''}}</textarea>   
        </div>
    </div>
  
</div>
<hr>



<div class="form-group">
    
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('job') }}">
        Back</a>

</div>

