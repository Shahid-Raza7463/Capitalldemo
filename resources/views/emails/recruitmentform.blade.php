<h3>Dear Sir/Madam</h3>
<br><br>
<p> {{ $authnames }} has a new request for Resource Hiring for “{{ $categoryname ??'' }}”.
</p>
<p>Required Experience :  {{ $required_experience }}<br>
     Required for Client  : @foreach ($client as $cl)
     {{ $cl->client_name }} ,
     @endforeach  <br>
     Required for Assignment/Project  :  {{ $assignment_project }}<br>
     Number of Vacancies :  {{ $number_of_vacancies }}<br>
     Timeline :  {{ date('F d,Y', strtotime($timeline)) }}<br>
</p>
    <p> Please click  <a href="{{url('/view/recruitmentform/'.$id)}}"> here </a> view records </p>