Dear Sir/Madam
<br><br>
<h3>Your invoice no : {{ $invoice_id }} of client ( {{ $client_name }} ) is generated</h3>
@php
$random = substr(md5(mt_rand()), 0, 10);
@endphp
<p> please click on link for view <a href="{{url('/downloadpdf/'.$id.'b'.$random )}}">{{ $invoice_id }}</a></p>



