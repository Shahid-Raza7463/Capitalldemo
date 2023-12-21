Dear Sir/Madam
<br><br>
<p>Your request for New Assetprocurement Form has been @if($status==0)
    <span><b>Created</b></span>
    @elseif($status==1)
    <span><b>Approved</b></span>
    @else
    <span ><b>Rejected</b></span>
   
    @endif @if($status==2)Please Click <a href="{{url('/assetprocurement/'.$id)}}">
        here </a> to check the reason for rejection @endif</p>
