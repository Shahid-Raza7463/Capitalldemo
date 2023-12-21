Dear Sir/Madam
<br><br>
<h3>you have a new tender reminder request</h3>
<p>Tender Offered by :{{ $tenderofferedby ??'' }}</p>
<p>Nature of Service : {{ $services ??'' }}</p>
<p>Due date of submission : {{ date('F d,Y', strtotime($duedate)) ??'' }}</p>

