Dear Sir/Madam,
<br><br>
{{ $teammembername ??''}} has made a leave request from {{ date('F d,Y', strtotime($from)) }} to {{ date('F d,Y', strtotime($to)) }}. 
<br>Please click <a href="{{url('/applyleave/'.$id)}}">here</a>  to approve/reject.