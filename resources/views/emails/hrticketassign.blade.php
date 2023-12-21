Dear Sir/Madam
<br><br>
<p> {{ $authnames }} has created a new ticket </p>
<p>Ticket  :<a href="{{ url('hrticket')}}">{{ $taskname ??'' }}</a></p>
<p>Timeline  : {{ date('F d,Y', strtotime($duedate)) ??'' }}</p>
<p>Description : {!! $description ??'' !!}</p>

