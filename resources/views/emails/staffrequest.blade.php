Dear Sir/Madam
<br><br>
<h3>{{ $authnames }} has assigned you a new staff request</h3>
<p>Client : <a href="{{url('staffrequest')}}">{{ $ganttchart_id ??'' }}</a></p>
<p>No of Staff : {{ $noofstaff ??'' }}</p>
<p>Comment : {{ $comment ??'' }}</p>
<p>Start Date : {{ date('F d,Y', strtotime($startdate)) ??'' }}</p>
<p>End Date : {{ date('F d,Y', strtotime($enddate)) ??'' }}</p>


