Dear Sir/Madam
<br><br>
<p>The request for Local Conveyance which has been made by<b>{{ $name ??''}}</b> has been 
    @if($status==0)
    <span><b>Created</b></span>
    @elseif($status==1)
    <span><b>Approved</b></span>
    @elseif($status==2)
    <span ><b>Rejected</b></span>
    @else
    <span><b>Submitted</b></span>
    @endif.click <a href="{{url('/localconveyance/'.$id)}}">
        here </a> to view the details and proceed for payment.</p>
