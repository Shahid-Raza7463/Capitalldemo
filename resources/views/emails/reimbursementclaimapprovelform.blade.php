Dear Sir/Madam
<br><br>
<p>Your request for New Reimbursement Claim request has been @if($status==0)
    <span><b>Created</b></span>
    @elseif($status==1)
    <span><b>Approved</b></span>
    @elseif($status==2)
    <span ><b>Rejected</b></span>
    @else
    <span><b>Submitted</b></span>
    @endif @if($status==2)Please Click <a href="{{url('/reimbursementclaim/'.$id)}}">
        here </a> to check the reason for rejection @endif</p>
