Dear Sir/Madam
<br><br>
<p>Your request for Timesheet Submission Form has been @if($status==0)
    <span><b>Created</b></span>
    @elseif($status==1)
    <span><b>Approved</b></span> valid to {{ date('F d,Y', strtotime($date)) }}
    @else
    <span ><b>Rejected</b></span>
   
    @endif  @if($status==2)Please Click <a href="{{url('timesheetrequestlist')}}">
        here </a> to check the reason for rejection @endif</p>
