<div class="row row-sm">
<div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Type </label>
            <select name="type" class="form-control"> 
                <option value="">Please Select One</option>
                <option value="0">Articleship</option>
                <option value="1">Internship</option>
                <option value="2">Chartered Accountant</option>
                <option value="3">For others</option>
               
            </select>
        </div>
    </div>
<div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Applied On </label>
            <input required type="date" name="applied_on" value="{{ $development->taskname ?? ''}}" class="form-control"
                placeholder="Enter Applied On">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">MRN/NRO/CRO/WRO No. (if CA) </label>
            <input required type="text" name="mrn_nro_cro_wro" value="{{ $development->taskname ?? ''}}" class="form-control"
                placeholder="Enter MRN/NRO/CRO/WRO No. (if CA)">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Name </label>
            <input required type="text" name="name" value="{{ $task->duedate ?? ''}}" class="form-control"
                placeholder="Enter Name">
        </div>
    </div>
    </div>
    <div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Email </label>
            <input required type="email" name="email" value="{{ $task->duedate ?? ''}}" class="form-control"
                placeholder="Enter Email">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Phone No. </label>
            <input required type="number" name="contact_no" value="{{ $task->duedate ?? ''}}" class="form-control"
                placeholder="Enter Contact No">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Age </label>
            <input required type="number" name="age" value="{{ $task->duedate ?? ''}}" class="form-control"
                placeholder="Enter Age">
        </div>
    </div>
</div>
<div class="row row-sm">
<div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Scheme</label>
            <select name="scheme" class="form-control">
                <option value="">Please Select One</option>
                <option value="Intermediate Single Group">Intermediate Single Group</option>
                <option value="Intermediate Both Groups">Intermediate Both Groups</option>
                <option value="Direct Entry">Direct Entry</option>
               
            </select>
        </div>
    </div>
<div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Job Profile </label>
            <input required type="text" name="jobprofile" value="{{ $task->duedate ?? ''}}" class="form-control"
                placeholder="Enter Job Profile">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Highest Qualification</label>
            <input required type="text" name="highest_qualification" value="{{ $task->duedate ?? ''}}" class="form-control"
                placeholder="Enter Highest Qualification">
        </div>
    </div>
</div>

<div class="row row-sm">
<div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Other Certification Courses (if any)</label>
            <input required type="text" name="other_certification_course" value="{{ $task->duedate ?? ''}}" class="form-control"
                placeholder="Enter Other Certification Courses (if any)">
        </div>
    </div>
<div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Total Work Experience </label>
            <input required type="text" name="experience" value="{{ $task->duedate ?? ''}}" class="form-control"
                placeholder="Enter Total Work Experience">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Reference (if any)</label>
            <input required type="text" name="reference" value="{{ $task->duedate ?? ''}}" class="form-control"
                placeholder="Enter Reference">
        </div>
    </div>
</div>
<div class="row row-sm">
<div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Resume</label>
            <input required type="file" name="resume" value="{{ $task->duedate ?? ''}}" class="form-control"
                placeholder="Enter Resume">
        </div>
    </div>
<div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Comment of HR</label>
            <input required type="text" name="hrcomment" value="{{ $task->duedate ?? ''}}" class="form-control"
                placeholder="Enter Comment of HR">
        </div>
    </div>
<!-- <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Interviewer 1</label>
            <select required class="language form-control" name="interviewerone" @if(Request::is('task/*/edit'))>
                <option disabled style="display:block">Please Select One</option>

                  @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}" @if(Request::is('task/*/edit')) @foreach($taskassign as
                    $team) {{ $teammemberData->id == $team->teammember_id ? 'selected' : '' }} @endforeach   @endif>
                {{ $teammemberData->team_member }} (
                    {{ $teammemberData->role->rolename}} ) ( {{ $teammemberData->emailid ??''}} )</option>
                @endforeach

                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}">
                    {{ $teammemberData->team_member }} ( {{ $teammemberData->role->rolename}} ) ( {{ $teammemberData->emailid ??''}} ) </option>

                @endforeach
                @endif
            </select>
        </div>
    </div> -->
</div>
<!-- <div class="row row-sm">
<div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Interviewer 1 Rating</label>
            <input required type="number" name="ratingone" value="{{ $task->duedate ?? ''}}" class="form-control"
                placeholder="">
        </div>
 </div>
<div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Interviewer 1 Feedback</label>
                <textarea rows="5" style="height:45px;" name="feedbackone" value="" class="form-control"
                placeholder=""></textarea>
        </div>
    </div>
<div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Interviewer 2</label>
            <select required class="language form-control" name="interviewertwo" @if(Request::is('task/*/edit'))>
                <option disabled style="display:block">Please Select One</option>

                  @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}" @if(Request::is('task/*/edit')) @foreach($taskassign as
                    $team) {{ $teammemberData->id == $team->teammember_id ? 'selected' : '' }} @endforeach   @endif>
                {{ $teammemberData->team_member }} (
                    {{ $teammemberData->role->rolename}} ) ( {{ $teammemberData->emailid ??''}} )</option>
                @endforeach

                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}">
                    {{ $teammemberData->team_member }} ( {{ $teammemberData->role->rolename}} ) ( {{ $teammemberData->emailid ??''}} ) </option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
</div>
<div class="row row-sm">
<div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Interviewer 2 Rating</label>
            <input required type="number" name="ratingtwo" value="{{ $task->duedate ?? ''}}" class="form-control"
                placeholder="">
        </div>
 </div>
<div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Interviewer 2 Feedback</label>
            <textarea rows="5" style="height:45px;" name="feedbacktwo" value="" class="form-control"
                placeholder=""></textarea>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Interview Status </label>
            <select name="status" class="form-control">
             
                @if(Request::is('development/*/edit')) >
             @if($development->status=='0')
                <option value="0">Shortlisted</option>
                <option value="1">Selected</option>
                <option value="2">On Hold</option>
                <option value="3">Rejected</option>
              
                @elseif($development->status=='1')
                <option value="1">Selected</option>
                <option value="0">Shortlisted</option>
                <option value="2">On Hold</option>
                <option value="3">Rejected</option>

                @elseif($development->status=='2')
                <option value="2">On Hold</option>
                <option value="0">Shortlisted</option>
                <option value="1">Selected</option>
                <option value="3">Rejected</option>

                @else
                <option value="0">Shortlisted</option>
                <option value="1">Selected</option>
                <option value="2">On Hold</option>
                <option value="3">Rejected</option>
            
                @endif
                @else
                <option value="">Please Select One</option>
                <option value="0">Shortlisted</option>
                <option value="1">Selected</option>
                <option value="2">On Hold</option>
                <option value="3">Rejected</option>
               
                @endif
            </select>
        </div>
    </div>
</div> -->
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ URL::previous()}}">
        Back</a>

</div>

