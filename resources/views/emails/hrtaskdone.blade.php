Dear Sir/Madam
<br><br>
<h3>Your Ticket has been Closed !</h3>
<p>Ticket :<a href="{{ url('secretaryoftask')}}">{{ $taskname ??'' }}</a></p>
<p>Assign By :{{$assignbyname}}
<p>Timeline  : {{ date('F d,Y', strtotime($duedate)) ??'' }}</p>
<p>Description : {!! $description ??'' !!}</p>

