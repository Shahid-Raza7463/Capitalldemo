@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">

    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>TRAVEL FEEDBACK LIST</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="card mb-4">

        <div class="card-body">
            @component('backEnd.components.alert')

            @endcomponent
            <div class="table-responsive">
                <table id="example" class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th hidden>Id</th>
                            <th> Name </th>
                            <th>Client</th>
                            <th>Assignment Name</th>
                            <th>Partner</th>
                            <th>Mode of Transport </th>
                            <th>ACCOMODATION *(IF APPLICABLE)</th>
                            <th>EXPERIANCE WITH COODINATOR </th>
                            <th>Created Date </th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($travelfeedbacks as $travelformData)
                        <tr>
                            <td hidden> {{ $travelformData->id }}</td>
                            <td>{{ $travelformData->createdby ??''}}</td>

                            <td> {{ $travelformData->client_name }}</td>
                            <td> {{ $travelformData->assignment_name }}</td>
                            <td> {{ $travelformData->team_member }}</td>
                            <td>@if($travelformData->mode_of_transport==0)
                                <span>Good</span>
                                @elseif($travelformData->mode_of_transport==1)
                                <span>Average</span>
                                @elseif($travelformData->mode_of_transport==2)
                                <span>Excellent</span>
                                @elseif($travelformData->mode_of_transport==3)
                                <span>Other</span><br>
                                {{ $travelformData->mode_of_transportothers }}
                                @endif
                            </td>
                            <td>@if($travelformData->accomodation==0)
                                <span>Good</span>
                                @elseif($travelformData->accomodation==1)
                                <span>Average</span>
                                @elseif($travelformData->accomodation==2)
                                <span>Excellent</span>
                                @elseif($travelformData->accomodation==3)
                                <span>Other</span><br>
                                {{ $travelformData->accomodationothers }}
                                @endif
                            </td>
                            <td>@if($travelformData->experience==0)
                                <span>Good</span>
                                @elseif($travelformData->experience==1)
                                <span>Average</span>
                                @elseif($travelformData->experience==2)
                                <span>Excellent</span>
                                @elseif($travelformData->experience==3)
                                <span>Other</span><br>
                                {{ $travelformData->experienceothers }}
                                @endif
                            </td>
                            <td> {{ date('F d,Y', strtotime($travelformData->created_at)) }}</td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!--/.body content-->
@endsection
