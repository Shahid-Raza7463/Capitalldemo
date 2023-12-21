Dear Sir/Madam
<br><br>
<h3>you are assigned on for this client : </h3>
<p>Client : {{ $client ??'' }}</p>
<p>Start Date : {{ date('F d,Y', strtotime($startdate)) ??'' }}</p>
<p>End Date : {{ date('F d,Y', strtotime($enddate)) ??'' }}</p>


