{!! $msg ??''!!}
<p>Task :<a href="{{ url('task')}}">{{ $taskname ??'' }}</a></p>
<p>Due Date  : {{ date('F d,Y', strtotime($duedate)) ??'' }}</p>
<p>Description : {!! $description ??'' !!}</p>

