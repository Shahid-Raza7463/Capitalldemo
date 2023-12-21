Dear Sir/Madam
<br><br>
<p>Your request for an Local Conveyance has been  @if($status==0)
    <span><b>Created</b></span>
    @elseif($status==1)
    <span><b>Approved</b></span>
    @elseif($status==2)
    <span ><b>Rejected</b></span>
    @else
    <span><b>Submitted</b></span>
    @endif. Please click <a href="{{url('/localconveyance/'.$id)}}"> here </a> to view record</p>
