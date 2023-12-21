Dear Sir/Madam
<br><br>
<h3>Your Task has been Completed !</h3>
<p>Task :<a href="{{ url('secretaryoftask')}}">{{ $taskname ??'' }}</a></p>
<p>Assign By :{{$assignbyname}}
<p>Timeline  : {{ date('F d,Y', strtotime($duedate)) ??'' }}</p>
<p>Description : {!! $description ??'' !!}</p>

