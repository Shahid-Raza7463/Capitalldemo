@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('travelfeedback')}}"> FEEDBACK LIST</a></li>
            <li class="breadcrumb-item"><a href="{{url('travelform/create')}}">ADD TRAVEL REQUEST FORM</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>TRAVEL REQUEST FORM LIST</small>
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
                            <th>Budget</th>
                            <th>Food</th>
                            <th>Destination</th>
                            <th>Duration From</th>
                            <th>Duration To</th>
                            <th>Team Member Name & Designation</th>
                            <th>Accomodation</th>
                            <th>No of Rooms</th>
                            <th>Hotel Type</th>
                            <th>Budget</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Hotel Location</th>
                            <th>Meal Plan</th>
                            <th> Status</th>
                            <th> Billed To Client</th>
                            <th> Attachment</th>
                            <th>Feedback</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($travelformDatas as $travelformData)
                        <tr>
                            <td hidden> {{ $travelformData->id }}</td>
                            <td><a href="{{route('travelform.show', $travelformData->id)}}">{{ $travelformData->createdname ??''}}
                                    ( {{ $travelformData->createdrole??''}} )</td>

                            <td> {{ $travelformData->client_name }}</td>
                            <td> {{ $travelformData->assignment_name }}</td>
                            <td> {{ $travelformData->team_member }}({{ $travelformData->rolename }})</td>
                            <td>@if($travelformData->mode_of_transport==0)
                                <span>Flight</span>
                                @elseif($travelformData->mode_of_transport==1)
                                <span>Train</span>
                                @endif
                            </td>
                            <!-- <td> {{ $travelformData->mode_of_transport }}</td> -->
                            <td> {{ $travelformData->budget }}</td>
                            <td> {{ $travelformData->flightfood1 }}</td>
                            <td> {{ $travelformData->destination }}</td>
                            <td> {{ date('F d,Y', strtotime($travelformData->duration_from)) }}</td>
                            <td> {{ date('F d,Y', strtotime($travelformData->duration_to)) }}</td>
                            @php
                            $travelformmemberData = DB::table('travelformmembers')
                            ->leftjoin('teammembers','teammembers.id','travelformmembers.member_name')
                            ->leftjoin('roles','roles.id','teammembers.role_id')
                            ->where('travelformmembers.travelform_id',$travelformData->id)
                            ->select('teammembers.team_member','roles.rolename')
                            ->get();

                            $travelattachment = DB::table('travelformattachment')
                            ->where('travelform_id',$travelformData->id)
                            ->select('travelformattachment.*')
                            ->get();

                            @endphp
                            <td> @foreach($travelformmemberData as $travelformmember)
                                <span>
                                    {{ $travelformmember->team_member ??''}} ({{ $travelformmember->rolename ??''}})
                                </span><br>
                                @endforeach</td>
                            <td>@if($travelformData->accomodation==0)
                                <span>Arrange by Self</span>
                                @elseif($travelformData->accomodation==1)
                                <span>Arrange by client</span>

                                @endif
                            </td>
                            <!-- <td> {{ $travelformData->accomodation }}</td> -->
                            <td> {{ $travelformData->no_of_rooms }}</td>
                            <td>@if($travelformData->no_of_hotel_type == 1)
                                <span>3 Star</span>
                                @elseif ($travelformData->no_of_hotel_type == 3)
                                <span>5 Star</span>
                                @elseif($travelformData->no_of_hotel_type == 2)
                                <span>1 Star</span>
                                @endif</td>
                            <td> {{ $travelformData->hotel_budget }}</td>
                            <td>@if ( $travelformData->hotel_from != null)
                                {{ date('F d,Y', strtotime($travelformData->hotel_from)) }}
                                @endif </td>
                            <td> @if ( $travelformData->hotel_to != null)
                                {{ date('F d,Y', strtotime($travelformData->hotel_to)) }}
                                @endif </td>
                            <td> {{ $travelformData->hotellocation }}</td>
                            <td>@if($travelformData->meal_plan==1)
                                <span>Breakfast Include</span>
                                @elseif($travelformData->meal_plan==2)
                                <span>Breakfast Exclude</span>
                                @endif
                            </td>
                            <td>@if($travelformData->travelstatus==0)
                                <span class="badge badge-info">Created</span>
                                @elseif($travelformData->travelstatus==1)
                                <span class="badge badge-success">Approved</span>
                                @else
                                <span class="badge badge-danger">Rejected</span>
                                @endif</td>
                            <td>@if($travelformData->billedtoclient==1)
                                <span>Yes</span>
                                @elseif($travelformData->billedtoclient==2)
                                <span>No</span>
                                @endif
                            </td>
                            <td> @foreach($travelattachment as $travelformmember)
                                <a target="blank"
                                    href="{{url('/backEnd/image/travelform/'.$travelformmember->file ??'')}}">
                                    {{ $travelformmember->file ??''}} </a> , <br>
                                @endforeach</td>
                            <td>
                                @if($travelformData->createdby == Auth::user()->teammember_id)
                                @if($travelformData->feedback==null)
                                <a style="margin-left:11px;height: 55px;color:White" id="editCompany"
                                    data-toggle="modal" data-id="{{ $travelformData->id }}" data-target="#Modal4"
                                    class="feedback btn btn-success">
                                    Click Here</a>
                                @else
                                <span class="badge badge-success">Submit</span>
                                @endif
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!--/.body content-->
<div class="modal fade" id="Modal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:#37A000">
                <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel1">Travel Form
                    Feedback </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ url('feedbackinsert')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-600">Mode of Transport <span
                                        style="color:red;">*</span></label>
                                <select name="mode_of_transport" required id="modeoftransport" class="form-control">

                                    <option value="">Please Select One</option>
                                    <option value="0">Good</option>
                                    <option value="1">Average</option>
                                    <option value="2">Excellent</option>
                                    <option value="3">Other</option>

                                </select>
                                <input hidden class="form-control" id="id" name="travelform_id" type="text">
                            </div>
                            <div class="form-group" id="mode_of_transportother" style="display: none">

                                <!-- <input class="form-control"  id="email" name="email" type="text"> -->
                                <textarea rows="4" name="mode_of_transportothers" id="mode_of_transportothers"
                                    class="form-control" placeholder=""></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-600">ACCOMODATION <span style="color:red;">*</span> (IF
                                    APPLICABLE) </label>
                                <select name="accomodation" required id="accomodation" class="form-control">

                                    <option value="">Please Select One</option>
                                    <option value="0">Good</option>
                                    <option value="1">Average</option>
                                    <option value="2">Excellent</option>
                                    <option value="3">Other</option>

                                </select>
                            </div>
                            <div class="form-group" id="accomodationother" style="display: none">

                                <!-- <input class="form-control"  id="email" name="email" type="text"> -->
                                <textarea rows="4" id="accomodationothers" name="accomodationothers"
                                    class="form-control" placeholder=""></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-600">EXPERIANCE WITH COODINATOR <span
                                        style="color:red;">*</span></label>
                                <select name="experience" required id="experience" class="form-control">

                                    <option value="">Please Select One</option>
                                    <option value="0">Good</option>
                                    <option value="1">Average</option>
                                    <option value="2">Excellent</option>
                                    <option value="3">Other</option>

                                </select>
                            </div>
                            <div class="form-group" id="experienceother" style="display: none">

                                <!-- <input class="form-control"  id="email" name="email" type="text"> -->
                                <textarea rows="4" name="experienceothers" id="experienceothers" class="form-control"
                                    placeholder=""></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" style="float: right" class="btn btn-success">Save </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('#modeoftransport').on('change', function () {
            if (this.value == '3') {
                $("#mode_of_transportother").show();
                document.getElementById("mode_of_transportothers").required = true;

            } else {
                $("#mode_of_transportother").hide();

            }
        });
    });

</script>
<script>
    $(document).ready(function () {
        $('#accomodation').on('change', function () {
            if (this.value == '3') {
                $("#accomodationother").show();
                document.getElementById("accomodationothers").required = true;

            } else {
                $("#accomodationother").hide();

            }
        });
    });

</script>
<script>
    $(document).ready(function () {
        $('#experience').on('change', function () {
            if (this.value == '3') {
                $("#experienceother").show();
                document.getElementById("experienceothers").required = true;

            } else {
                $("#experienceother").hide();

            }
        });
    });

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(function () {
        $('body').on('click', '#editCompany', function (event) {
            //        debugger;
            var id = $(this).data('id');
            debugger;
            $.ajax({
                type: "GET",

                url: "{{ url('travelformfeedback') }}",
                data: "id=" + id,
                success: function (response) {
                    // alert(res);
                    debugger;
                    $("#id").val(response.id);


                },
                error: function () {

                },
            });
        });
    });

</script>
<script>
    var msg = '{{Session::get('
    alert ')}}';
    var exist = '{{Session::has('
    alert ')}}';
    if (exist) {
        alert(msg);
    }

</script>
@endsection
