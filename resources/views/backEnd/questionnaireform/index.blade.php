
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
   
    <div class="col-sm-12 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
            <div class="media-body">
               <a href="{{url('home')}}"> <h1 class="font-weight-bold" style="color:black;">Home</h1></a>
                <small>Questionnaireform List</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="card mb-4">
     @component('backEnd.components.alert')

        @endcomponent
        <div class="card-body">
            <div class="table-responsive">
                <table class="table display table-bordered table-striped table-hover basic">
                    <thead>
                        <tr>
                            <th>Name</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Attachment</th>
                            <th>What do you know about our company’s services?</th>
                            <th>Describe a tough experience you had with a colleague or a
                                    manager and how you handled it.</th>
							 <th>How versatile are you working with software systems in
                                    HR? Which software you found effective and why ?</th>
                            <th>How have you coped leading a hiring team? Describe a
                                    practical experience.</th>
							<th>How have you handled cost reduction efforts as an HR
                                    employee?</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($questionnaireformDatas as $questionnaireform)
                        <tr>
							<td>{{ $questionnaireform->name ??'' }}</td>
							<td>{{ $questionnaireform->email ??'' }}</td>
							<td>{{ $questionnaireform->phone ??'' }}</td>
							<td>   <a href="{{ url('backEnd/image/questionnaireform/'.$questionnaireform->file ??'')}}"
                                                target="blank">{{ $questionnaireform->file ??'' }}</a></td>
                            <td>{{ $questionnaireform->services ??'' }}</td>
                            <td>{{ $questionnaireform->experience  ??''}}</td>
                            <td>{{ $questionnaireform->systems  ??''}}</td>
                            <td>{{ $questionnaireform->leadings  ??''}}</td>
                            <td>{{ $questionnaireform->handled  ??''}}</td>
                            <td>{{ date('F d,Y', strtotime($questionnaireform->created_at)) }}</td>

                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div><!--/.body content-->

@endsection


