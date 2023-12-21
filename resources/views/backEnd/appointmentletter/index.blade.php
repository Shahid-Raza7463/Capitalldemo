@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('appointmentletter/create')}}">Add appointmentletter</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>appointmentletter
                    List</small>
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
                            <th>Client Name</th>
                            <th>Nature of service</th>
                            <th>Financial Year</th>
                            <th>Appointment start date</th>
                            <th>Appointment end date</th>
                            <th>Period of Appointment</th>
                            <th>Assigned</th>
                            <th>Attachment</th>


                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointmentletterDatas as $appointmentletterData)
                        <tr>
                            <td>
                                <a href="{{route('appointmentletter.edit', $appointmentletterData->id)}}">
                                @if($appointmentletterData->Name != null) {{$appointmentletterData->Name }} @else {{$appointmentletterData->client_name }}@endif</a></td>
                            <td>
                                @if($appointmentletterData->Nature_of_service != null)  {{$appointmentletterData->Nature_of_service }}
                            @else
                            {{$appointmentletterData->assignment_name }}
                        @endif
                        </td>

                            <td>{{ $appointmentletterData->Financial_Year }}</td>
                            @if($appointmentletterData->Appointment_start_date != null)
                            <td>{{ date('F d,Y', strtotime($appointmentletterData->Appointment_start_date ??'')) }}</td>
                            @else
                            <td></td>
                            @endif
                            @if($appointmentletterData->Appointment_end_date != null)
                            <td>{{ date('F d,Y', strtotime($appointmentletterData->Appointment_end_date ??'')) }}</td>
                            @else
                            <td></td>
                            @endif
                            <td>{{ $appointmentletterData->Period_of_Appointment }}</td>
                            <td>
                                {{$appointmentletterData->team_member }}</td>
                            @if($appointmentletterData->attachment != null)
                            <td><a target="blank"
                                    href="{{ Storage::disk('s3')->temporaryUrl('invoice/'.$appointmentletterData->attachment, now()->addMinutes(3)) }}"><i
                                        class="fas fa-file-pdf"> {{ $appointmentletterData->attachment}}</i></a></td>
                            @else
                            <td></td>
                            @endif
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
