Dear Sir/Madam
<br><br>
<p> {{ $authnames }} has assigned you a new task </p>
<p>Task :<a href="{{ url('secretaryoftask')}}">{{ $taskname ??'' }}</a></p>
<p>Timeline  : {{ date('F d,Y', strtotime($duedate)) ??'' }}</p>
<p>Description : {!! $description ??'' !!}</p>

