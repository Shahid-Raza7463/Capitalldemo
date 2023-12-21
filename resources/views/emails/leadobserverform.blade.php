Dear Sir/Madam
<br><br>
<h3><b> @if(!empty($lead->client_name)){{ $lead->client_name ??'' }}@else
    {{ $lead->client_names ??'' }}@endif </b> of lead status has been changed</h3>
click <a href="{{route('lead.show', $id)}}">here</a>
