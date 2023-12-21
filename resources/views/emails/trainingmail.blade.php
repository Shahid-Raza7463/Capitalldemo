Dear Sir/Madam
<br><br>
<h3>You have not submit the declaration for this module :</h3>
@foreach($module as $name) <p>{{ $name->pagename ??''}}</p>  @endforeach