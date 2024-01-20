<h3>Dear Sir/Madam</h3>
<br><br>
<p>You have been assigned a new assignment . Please click <a href="{{url('assignmentmapping')}}">here</a> to check</p>
<p>Client Name : {{ $clientname ??''}}</p>
<p>Assignment Name : {{ $assignment_name }} {{ $assignmentname ??''}}</p>
<p>Assignment Partner : {{ $assignmentpartner ??''}}</p>
<p>Team Leader :  @foreach($teamleader as $teamleaderDatas) {{ $teamleaderDatas->team_member ??''}} @endforeach</p>