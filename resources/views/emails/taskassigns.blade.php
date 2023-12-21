Dear Sir/Madam
<br><br>
<p> {{ $authnames }} has given instruction on task</p>
<p>Task :<a href="{{ url('task')}}">{{ $taskname ??'' }}</a></p>
<p>Due Date  : {{ date('F d,Y', strtotime($duedate)) ??'' }}</p>
<p>Description : {!! $description ??'' !!}</p>

