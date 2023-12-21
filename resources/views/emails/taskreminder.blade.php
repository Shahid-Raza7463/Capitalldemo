Dear Sir/Madam
<br><br>
<h3>you have a new task reminder</h3>
<p>Task :<a href="{{ url('task')}}">{{ $taskname ??'' }}</a></p>
<p>Due Date  : {{ date('F d,Y', strtotime($duedate)) ??'' }}</p>
<p>Description : {!! $description ??'' !!}</p>

