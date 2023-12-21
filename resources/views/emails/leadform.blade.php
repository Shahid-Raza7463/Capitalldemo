Dear Sir/Madam
<br><br>
<h3>you have a new lead assign for Client : @if(!empty($lead->client_name)){{ $lead->client_name ??'' }}@else
    {{ $lead->client_names ??'' }}@endif <b></b> </h3>
click <a href="{{route('lead.show', $id)}}">here</a>
