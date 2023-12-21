Dear Sir/Madam
<br><br>
<h3>you have a new tender reject</h3>
<p>Tender Offered by : <a href="{{ url('tender/view/'.$tenderid)}}">{{ $tenderofferedby ??'' }}</a></p>
<p>Nature of Service : {{ $services ??'' }}</p>
<p>Due date of submission : {{ date('F d,Y', strtotime($duedate)) ??'' }}</p>


