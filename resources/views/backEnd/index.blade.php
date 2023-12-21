@extends('backEnd.layouts.layout') @section('backEnd_content')
    <!--Content Header (Page header)-->
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-home-outline mr-2"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Dashboard</h1>
                    <small>From now on you will start your activities.</small>
                </div>
            </div>
        </div>
    </div>
    <!--/.Content Header (Page header)-->
    @if (Auth::user()->role_id == 13 || Auth::user()->role_id == 14)
        <div class="body-content">
            <div class="row">

                <div class="col-md-6 col-lg-3">
                    <!--Active users indicator-->
                    <div class="p-2 bg-primary text-white rounded mb-3 p-3 shadow-sm text-center">
                        <a href="{{ url('assignmentmapping') }}">
                            <div style="color:white;"
                                class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Open Assignment
                            </div>
                            <div style="color:white;" class="fs-32 text-monospace">{{ $assignmentcount }}</div>
                            <small style="color:white;"> Assignment</small>
                        </a>
                    </div>
                </div>
                {{-- <div class="col-md-6 col-lg-3">
            <!--Active users indicator-->
            <div class="p-2 bg-success text-white rounded mb-3 p-3 shadow-sm text-center">
                <a href="{{url('tender')}}" >
                <div style="color:white;" class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Tender</div>
                <div style="color:white;" class="fs-32 text-monospace">{{ $tender ??''}}</div>
                <small style="color:white;" >latest tender</small>
                </a>
            </div>
        </div> --}}
                {{--   <div class="col-md-6 col-lg-3">
            <!--Active users indicator-->
            <div class="p-2 text-white rounded mb-3 p-3 shadow-sm text-center" style="background-color: darkcyan;">
				   <a href="{{url('notification')}}" >
                <div style="color:white;" class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Notification</div>
                <div style="color:white;" class="fs-32 text-monospace">{{ $notification }}</div>
                <small style="color:white;">Latest Notification</small>
				</a>
            </div>
        </div> --}}

            </div>


        </div>
    @endif
    @if (Auth::user()->role_id == 15)
        <div class="body-content">
            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <!--Active users indicator-->
                    <div class="p-2 bg-primary text-white rounded mb-3 p-3 shadow-sm text-center">
                        <a href="{{ url('assignmentmapping') }}">
                            <div style="color:white;"
                                class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Total Assignment
                            </div>
                            <div style="color:white;" class="fs-32 text-monospace">{{ $assignmentcount }}</div>
                            <small style="color:white;"> Assignment</small>
                        </a>
                    </div>
                </div>
                {{--  <div class="col-md-6 col-lg-3">
            <!--Active users indicator-->
            <div class="p-2 text-white rounded mb-3 p-3 shadow-sm text-center" style="background-color: darkcyan;">
                <div class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Notification</div>
                <div class="fs-32 text-monospace">{{ $notification }}</div>
                <small>Latest Notification</small>
            </div>
        </div> --}}

            </div>


        </div>
    @endif
    @if (Auth::user()->role_id == 12)
        <div class="body-content">
            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <!--Active users indicator-->
                    <div class="p-2 bg-info text-white rounded mb-3 p-3 shadow-sm text-center">
                        <a href="{{ url('assignmentmapping') }}">
                            <div style="color:white;"
                                class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Assignment</div>
                            <div style="color:white;" class="fs-32 text-monospace">{{ $assignmentcount }}</div>
                            <small style="color:white;">Latest Assignment</small>
                            <a></a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <!--Active users indicator-->
                    <div class="p-2 bg-primary text-white rounded mb-3 p-3 shadow-sm text-center">
                        <a href="{{ url('client') }}">
                            <div style="color:white;"
                                class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Client</div>
                            <div style="color:white;" class="fs-32 text-monospace">{{ $client }}</div>
                            <small style="color:white;">active clients</small>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <!--Active users indicator-->
                    <div class="p-2 bg-success text-white rounded mb-3 p-3 shadow-sm text-center">
                        <a href="{{ url('teammember') }}">
                            <div style="color:white;"
                                class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Team Member</div>
                            <div style="color:white;" class="fs-32 text-monospace">{{ $teammember }}</div>
                            <small style="color:white;">active Member</small>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <!--Active users indicator-->
                    <div class="p-2 text-white rounded mb-3 p-3 shadow-sm text-center" style="background-color: darkcyan;">
                        <a href="{{ url('notification') }}">
                            <div style="color:white;"
                                class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Notification</div>
                            <div style="color:white;" class="fs-32 text-monospace">{{ $notification }}</div>
                            <small style="color:white;">Latest Notification</small>
                        </a>
                    </div>
                </div>

            </div>


        </div>
    @endif
    @if (Auth::user()->role_id == 11)
        <div class="body-content">
            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <!--Active users indicator-->
                    <div class="p-2 bg-info text-white rounded mb-3 p-3 shadow-sm text-center">
                        <a href="{{ url('assignmentmapping') }}">
                            <div style="color:white;"
                                class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Assignment</div>
                            <div style="color:white;" class="fs-32 text-monospace">{{ $assignmentcount }}</div>
                            <small style="color:white;">Latest Assignment</small>
                            <a></a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <!--Active users indicator-->
                    <div class="p-2 bg-primary text-white rounded mb-3 p-3 shadow-sm text-center">
                        <a href="{{ url('client') }}">
                            <div style="color:white;"
                                class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Client</div>
                            <div style="color:white;" class="fs-32 text-monospace">{{ $client }}</div>
                            <small style="color:white;">active clients</small>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <!--Active users indicator-->
                    <div class="p-2 bg-success text-white rounded mb-3 p-3 shadow-sm text-center">
                        <a href="{{ url('teammember') }}">
                            <div style="color:white;"
                                class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Team Member</div>
                            <div style="color:white;" class="fs-32 text-monospace">{{ $teammember }}</div>
                            <small style="color:white;">active Member</small>
                        </a>
                    </div>
                </div>
                {{--  <div class="col-md-6 col-lg-3">
            <!--Active users indicator-->
            <div class="p-2 text-white rounded mb-3 p-3 shadow-sm text-center" style="background-color: darkcyan;">
                  <a href="{{url('notification')}}" >
                <div style="color:white;" class="opacity-50 header-pretitle fs-11 font-weight-bold text-uppercase">Notification</div>
                <div style="color:white;" class="fs-32 text-monospace">{{ $notification }}</div>
                <small style="color:white;">Latest Notification</small>
                </a>
            </div>
        </div>-- }}

    </div>


</div>
@endif
<div class="body-content">
    <div class="row">
        @if ($pageid == 1)
       {{-- <div class="col-md-12 col-lg-4">
            <div class="card mb-4" style="height: 310px;">
                <div class="card-header" style="    background-color: #5ab5ee59;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0"><i style="font-size: 20px;padding:10px;"
                                    class="typcn typcn-ticket"></i>Support Ticket</h6>
                        </div>

                    </div>
                </div>
                <div class="list-group list-group-flush">
                    <ul class="list-unstyled">
                            @if (count($assetticket) > 0)
                        @foreach ($assetticket as $assetticketData)

                        <li class="list-group-item list-group-item-action">
                            <a href="{{url('/ticket/'.$assetticketData->id)}}">
                                <span class="text-muted text-sm">#{{$assetticketData->generateticket_id}} - -
                                    {{$assetticketData->subject}}</span>
                                <h5><a href="{{url('/ticket/'.$assetticketData->id)}}"
                                        class="d-block fs-15 font-weight-600 text-sm mb-0"><span
                                            style="color:#007bff;font-size: small;">created by</span>
                                        {{$assetticketData->team_member}} <span
                                            class="badge badge-info">@if ($assetticketData->status == 0)
                                            <span>open</span>
                                            @elseif($assetticketData->status==1)
                                            <span>working</span>
                                            @elseif($assetticketData->status==2)
                                            <span>close</span>
                                            @else
                                            <span>reject</span>
                                            @endif</span></a></h5>
                                <small class="text-muted"><i class="far fa-clock mr-1"></i>
                                    {{ date('H:i A', strtotime($assetticketData->created_at)) }},
                                    {{ date('F jS', strtotime($assetticketData->created_at)) }}</small>
                            </a>
                        </li>

                        @endforeach
						 <div class="dropdown-footer" style="margin-top: -10px;"><a href="{{url('ticketsupport')}}">View All Ticket</a></div>
                           @else
                                                <li class="list-group-item list-group-item-action">
                                                    <br><br><br>
                                                    <h5 style="text-align: center"><span>No Data</span></h5>
                                                      <br><br><br>   <br>
                                                </li>
                                              
                                                @endif
                    </ul>
                </div>

            </div>

        </div> --}}
    @endif
    {{-- <div class="col-md-12 col-lg-4">
            <div class="card mb-4">
                <div class="card-header" style="background-color:#ff000029;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0"> <i style="font-size: 20px;padding:10px;"
                                    class="typcn typcn-bell"></i>Notification</h6>
                        </div>

                    </div>
                </div>
                <div class="list-group list-group-flush">
                    <ul class="list-unstyled">
                        @foreach ($notificationDatas as $notificationData)
                        <li class="list-group-item list-group-item-action">
                            <a href="{{url('/ticket/'.$assetticketData->id)}}">
                                <span class="text-muted text-sm">#{{$assetticketData->generateticket_id}} - -
                                    {{$assetticketData->subject}}</span>
                                <h5><a href="{{url('/ticket/'.$assetticketData->id)}}"
                                        class="d-block fs-15 font-weight-600 text-sm mb-0">
                                            {{ $notificationData->title}} <span
                                            class="badge badge-info">@if ($assetticketData->status == 0)
                                            <span>open</span>
                                            @elseif($assetticketData->status==1)
                                            <span>working</span>
                                            @elseif($assetticketData->status==2)
                                            <span>close</span>
                                            @else
                                            <span>reject</span>
                                            @endif</span></a></h5>
                                            <small class="text-muted"><i
                                                class="far fa-clock mr-1"></i>{{ date('F jS', strtotime($notificationData->created_at)) }},
                                            {{ date('H:i A', strtotime($notificationData->created_at)) }}</span>
                            </a>
                        </li>

                        @endforeach
                    </ul>
                </div>
                <div class="dropdown-footer"><a href="">View All Notifications</a></div>
                <br>
            </div>

        </div> --}}
    {{-- <div class="col-md-12 col-lg-4">
            <div class="card mb-4" style="height: 310px;">
                <div class="card-header" style="background-color:#ff000029;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0"> <i style="font-size: 20px;padding:10px;"
                                    class="typcn typcn-bell"></i>Notification</h6>
                        </div>

                    </div>
                </div>
                <div class="notification-list">
                  @if (count($notificationDatas) > 0)
                        @foreach ($notificationDatas as $notificationData)
<div class="card-body" style="height: 86px;">
                        <div class="media new">

                            <div class="media-body">
                                <h6> {{ $notificationData->title}} <a 
                                    class="d-block fs-15 font-weight-600 text-sm mb-0"><span
                                        style="color:#007bff;font-size: small;">created by <b style="color: black;">{{ $notificationData->team_member}}</b></span>
                                  </a></h6>
                                <span> <small class="text-muted"><i class="far fa-clock mr-1"></i>
                                    {{ date('H:i A', strtotime($notificationData->created_at)) }},
                                    {{ date('F jS', strtotime($notificationData->created_at)) }}</small></span>
                            </div>
                        </div>
                    </div>
                     
                        @endforeach
                         <div class="dropdown-footer" style="    margin-top: 22px"><a href="{{url('notification')}}">View All Notifications</a></div>
                     @else
                                                <li class="list-group-item list-group-item-action">
                                                    <br><br><br>
                                                    <h5 style="text-align: center"><span>No Data</span></h5>
                                                      <br><br><br>   <br>
                                                </li>
                                              
                                                @endif
                </div>
              
                <br>
            </div>

        </div> --}}
    <!----Mentor---->


    @if (auth()->user()->role_id == 11 or auth()->user()->role_id == 12)
    @else
        @if ($mentor != null)
            <div class="col-md-12 col-lg-4">
                <div class="card mb-4" style="height: 310px;">
                    <div class="card-header" style="    background-color: #5ab5ee59;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>


                                <h6 class="fs-17 font-weight-600 mb-0"><i style="font-size: 20px;padding:10px;"
                                        class="typcn typcn-user-outline mr-2"></i> Your Mentor</h6>

                            </div>

                        </div>
                    </div>
                    <div class="list-group list-group-flush">
                        <ul class="list-unstyled">

                            @if ($mentor != null)
                                @if ($mentor->mentor_id == auth()->user()->teammember_id)
                                @elseif($mentor != null)
                                    <li class="list-group-item list-group-item-action">
                                        <label for="">Name : </label>
                                        <span class="text-muted text-sm">{{ $mentor->team_member }}
                                        </span>
                                        <br>
                                        <label for="">Designation : </label>
                                        <span class="text-muted text-sm">{{ $mentor->designation ?? '' }}
                                        </span>
                                        <br>
                                        <label for="">Email : </label>
                                        <span class="text-muted text-sm">{{ $mentor->emailid ?? '' }}
                                        </span>


                                    </li>
                                @else
                                    <li class="list-group-item list-group-item-action">
                                        <br><br><br>
                                        <h5 style="text-align: center"><span>No Data</span></h5>
                                        <br><br><br> <br>
                                    </li>
                                @endif
                            @endif

                        </ul>
                    </div>

                </div>

            </div>

        @endif
    @endif


    <!---mentor end --->

    <!----Mentee---->


    @if (auth()->user()->role_id == 11 or auth()->user()->role_id == 12)
    @else
        @if ($mentees != null)
            <div class="col-md-12 col-lg-4">
                <div class="card mb-4" style="height: 310px;">
                    <div class="card-header" style="    background-color: #5ab5ee59;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>


                                <h6 class="fs-17 font-weight-600 mb-0"><i style="font-size: 20px;padding:10px;"
                                        class="typcn typcn-user-outline mr-2"></i> Your Mentees</h6>

                            </div>

                        </div>
                    </div>
                    <div class="list-group list-group-flush">
                        <ul class="list-unstyled">

                            @if ($mentees != null)
                                @foreach ($mentees as $mentee)
                                    <li class="list-group-item list-group-item-action">
                                        <label for="">Name : </label>
                                        <span class="text-muted text-sm">{{ $mentee->team_member }}
                                        </span>
                                        <br>
                                        <label for="">Designation : </label>
                                        <span class="text-muted text-sm">{{ $mentee->designation ?? '' }}
                                        </span>
                                        <br>
                                        <label for="">Email : </label>
                                        <span class="text-muted text-sm">{{ $mentee->emailid ?? '' }}
                                        </span>


                                    </li>
                                @endforeach
                            @endif

                        </ul>
                    </div>

                </div>

            </div>

        @endif
    @endif


    <!---mentee end --->
    <div class="row">
        <div class="col-md-12 col-lg-4">
            <div class="card mb-4" style="height: 310px;">
                <div class="card-header" style="    background-color: #9fc45d6e;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0"><i style="font-size: 20px;padding:10px;"
                                    class="typcn typcn-edit"></i>Assignment</h6>
                        </div>

                    </div>
                </div>
                <div class="list-group list-group-flush">
                    <ul class="list-unstyled">
                        @if (count($assignment) > 0)
                            {{-- @php
                                dd($assignment);
                            @endphp --}}

                            @foreach ($assignment as $assignmentData)
                                <li class="list-group-item list-group-item-action">
                                    <a href="#">

                                        <h5><a href="{{ url('/viewassignment/' . $assignmentData->assignmentgenerate_id) }}"
                                                class="d-block fs-15 font-weight-600 text-sm mb-0">
                                                {{ $assignmentData->client_name ?? '' }} (
                                                {{ $assignmentData->assignment_name }} ) (
                                                {{ $assignmentData->assignmentname }} /
                                                {{ $assignmentData->assignmentgenerate_id }} )</a></h5>

                                    </a>
                                </li>
                            @endforeach
                            <div class="dropdown-footer"><a href="{{ url('assignmentmapping') }}">View All Assignment</a>
                            </div>
                        @else
                            <li class="list-group-item list-group-item-action">
                                <br><br><br>
                                <h5 style="text-align: center"><span>No Data</span></h5>
                                <br><br><br> <br>
                            </li>
                        @endif
                    </ul>

                </div>

                <br>
            </div>

        </div>



        <div class="col-md-12 col-lg-4">
            <div class="card mb-4" style="height: 310px;">
                <div class="card-header" style="background-color:#e7ff0029;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">
                                <i style="font-size: 20px;padding:10px;" class="fas fa-birthday-cake"></i>Birthday
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="notification-list" style="height: 190px; overflow-y: auto;">
                    <div class="card-body">
                        <h6><b style="color:#007bff;">Today</b></h6>
                        <div class="scroll-container">
                            @if ($todayBirthdays->count() > 0)
                                @foreach ($todayBirthdays as $birthday)
                                    <div class="media new">
                                        <div class="media-body">
                                            <h6>Happy Birthday, {{ $birthday->team_member }}</h6>
                                            <span>
                                                <small class="text-muted">
                                                    <i class="fas fa-birthday-cake mr-1"></i>
                                                    {{ \Carbon\Carbon::parse($birthday->dateofbirth)->format('d M') }}
                                                </small>
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="media new">
                                    <div class="media-body">
                                        <h6>No birthdays today.</h6>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <hr>

                        <h6><b style="color:#007bff;">Upcoming</b></h6>
                        <div class="scroll-container">

                            @if ($upcomingBirthdays != null)
                                @foreach ($upcomingBirthdays as $birthday)
                                    <div class="media new">
                                        <div class="media-body">
                                            <h6>{{ $birthday->team_member }}</h6>
                                            <span>
                                                <small class="text-muted">
                                                    <i class="fas fa-birthday-cake mr-1"></i>
                                                    {{ \Carbon\Carbon::parse($birthday->dateofbirth)->format('d M') }}
                                                </small>
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="media new">
                                    <div class="media-body">
                                        <h6>No upcoming birthdays.</h6>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                {{-- <div class="dropdown-footer" style="margin-top: 22px">
                        <a href="{{ url('birthday') }}">View All Birthdays</a>
                    </div> --}}
            </div>
        </div>


        <!---work anniversary card--->
        <!---work anniversaries--->
        {{--  <div class="col-md-12 col-lg-4">
                <div class="card mb-4" style="height: 310px;">
                    <div class="card-header" style="background-color:#ff000029;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fs-17 font-weight-600 mb-0">
                                    <i style="font-size: 20px;padding:10px;" class="fas fa-calendar-alt"></i>Work Anniversary
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="notification-list" style="height: 190px; overflow-y: auto;">
                        <div class="card-body">
                            <div class="scroll-container">
                                @if ($workAnniversaries->isEmpty())
                                <li class="list-group-item list-group-item-action">
                                    <br><br>
                                    <h6 style="text-align: center"><span>No Work Anniversary</span></h6>
                                    <br><br>
                                </li>
                                @else
                                    @foreach ($workAnniversaries as $anniversary)
                                        <div class="media new">
                                            <div class="media-body">
                                                <h6>Congratulations, {{ $anniversary->team_member }}</h6>
                                                <span>
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar-alt mr-1"></i>
                                                        {{ \Carbon\Carbon::parse($anniversary->joining_date)->diffInYears() }} Years
                                                    </small>
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            </div> --}}

        <!---upcoming holidays--->
        <!---upcoming holidays--->
        <div class="col-md-12 col-lg-4">
            <div class="card mb-4" style="height: 310px;">
                <div class="card-header" style="background-color:#000cff29;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">
                                <i style="font-size: 20px;padding:10px;" class="fas fa-calendar-check"></i>Upcoming
                                Holidays
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="notification-list">
                    @foreach ($upcomingHolidays as $holiday)
                        <div class="card-body" style="height: 86px;">
                            <div class="media new">
                                <div class="media-body">
                                    <h6>{{ $holiday->holidayname }}</h6>
                                    <span>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-check mr-1"></i>
                                            {{ $holiday->startdate }}
                                        </small>
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="dropdown-footer" style="margin-top: 22px">
                        <a href="{{ url('holidays') }}?year={{ date('Y') }}">View All Holidays</a>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>

    </div>
    </div>

    <script>
        var msg = '{{ Session::get('alert') }}';
        var exist = '{{ Session::has('alert') }}';
        if (exist) {
            alert(msg);
        }
    </script>
@endsection
