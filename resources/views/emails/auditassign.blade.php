Dear Sir/Madam
<br><br>
<p> {{ $authnames }} has created a new ticket </p>
<p>Ticket  :<a href="{{ url('auditticket')}}">{{ $taskname ??'' }}</a></p>
<p>Timeline  : {{ date('F d,Y', strtotime($duedate)) ??'' }}</p>
<p>Description : {!! $description ??'' !!}</p>

