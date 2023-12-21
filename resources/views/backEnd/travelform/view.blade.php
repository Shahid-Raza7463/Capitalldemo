@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
         
            <li class="breadcrumb-item"><a href="{{url('travelform')}}">Back</a></li>
        </ol>


    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>TRAVEL FORM</small>
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
            <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);">

                <div class="card-body">

                    <fieldset class="form-group">

                        <table class="table display table-bordered table-striped table-hover">

                            <tbody>

                                <tr>
                                    <td><b>Client : </b></td>
                                    <td>{{ $travelform->client_name}}</td>
                                    <td><b>Assignment Name :</b></td>
                                    <td>{{ $travelform->assignment_name }}</td>
                                </tr>
                                <tr>
                                    <td><b>Partner : </b></td>
                                    <td>{{ $travelform->team_member}}({{ $travelform->rolename}})</td>
                                    <td><b>Mode of Transport :</b></td>
                                    <td>@if($travelform->mode_of_transport==0)
                                        <span>Flight</span>
                                        @elseif($travelform->mode_of_transport==1)
                                        <span>Train</span>

                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Budget : </b></td>
                                    <td>{{ $travelform->budget}}</td>
                                    <td><b>Food :</b></td>
                                    <td>{{ $travelform->flightfood1 }}</td>
                                </tr>
                                <tr>
                                    <td><b>Destination : </b></td>
                                    <td>{{ $travelform->destination}}</td>
                                    <td><b>Duration From :</b></td>
                                    <td>{{ date('F d,Y', strtotime($travelform->duration_from)) }}</td>
                                </tr>
                                <tr>
                                    <td><b>Duration To : </b></td>
                                    <td>{{ date('F d,Y', strtotime($travelform->duration_to)) }}</td>
                                    <td><b>Employee Name :</b></td>
                                    <td>{{ App\Models\Teammember::select('team_member')->where('id',$travelform->createdby)->first()->team_member ?? ''}}
                                    </td>
                                </tr>

                                <tr>
                                    <td><b>Accomodation : </b></td>
                                    <td>@if($travelform->accomodation==0)
                                        <span>Arrange by Self</span>
                                        @elseif($travelform->accomodation==1)
                                        <span>Arrange by client</span>

                                        @endif
                                    </td>
                                    @if($travelform->accomodation==0)
                                    <td><b>No of Rooms : </b></td>
                                    <td>{{ $travelform->no_of_rooms}}
                                    </td>
									@endif
                                </tr>
								  @if($travelform->accomodation==0)
                                <tr>
                                    <td><b>Hotel Type :</b></td>
                                    <td>@if($travelform->no_of_hotel_type==3)
                                        <span>5 Star</span>
                                        @elseif($travelform->no_of_hotel_type==1)
                                        <span>3 Star</span>
                                        @elseif($travelform->no_of_hotel_type == 2)
                                        <span>1 Star</span>
                                        @endif</td>
                                        <td><b>Budget : </b></td>
                                        <td>{{ $travelform->hotel_budget}}</td>
                                </tr>
                                <tr>
                                  
                                    <td><b>From :</b></td>
                                    <td>@if($travelform->hotel_from != null)
                                        {{ date('F d,Y', strtotime($travelform->hotel_from)) }}
                                        @endif</td>
                                        <td><b>To : </b></td>
                                        <td>@if($travelform->hotel_to != null)
                                            {{ date('F d,Y', strtotime($travelform->hotel_to)) }}
                                            @endif</td>
                                </tr>
								
                                <tr>
                                   
                                    <td><b>Meal Plan :</b></td>
                                    <td>@if($travelform->meal_plan==1)
                                        <span>Breakfast Include</span>
                                        @elseif($travelform->meal_plan==2)
                                        <span>Breakfast Exclude</span>
                                        @endif</td>
                                    <td><b>Hotel Location</b></td>
                                    <td> {{ $travelform->hotellocation }}</td>
                                </tr>
								@endif
                                <tr>
                                    <td><b> Status</b></td>
                                    <td>@if($travelform->travelstatus == 0)
                                        <span class="badge badge-pill badge-info">Created</span>
                                        @elseif($travelform->travelstatus == 1)
                                        <span class="badge badge-pill badge-success">Approved</span>
                                        @else
                                        <span class="badge badge-pill badge-danger">Reject</span>
                                        @endif
                                    </td>

                                    <td><b>Team Member Name :</b></td>
                                    @php
                                    $travelformmemberData = DB::table('travelformmembers')
                                    ->leftjoin('teammembers','teammembers.id','travelformmembers.member_name')
                                    ->leftjoin('roles','roles.id','teammembers.role_id')
                                    ->where('travelformmembers.travelform_id',$travelform->id)->select('travelformmembers.*','teammembers.team_member','roles.rolename')->get();
                                    // dd($travelformmemberData);
                                    @endphp
                                    <td>@foreach($travelformmemberData as $travelformmember)
                                        <span>
                                            {{ $travelformmember->team_member ??''}}
                                            ({{ $travelformmember->rolename ??''}})
                                        </span><br>
                                        @endforeach</td>

                                </tr>

                                <tr>
                                    @if(Request::is('travelform/*'))
                                    @if($travelform->partener == Auth::user()->teammember_id)


                                    @if($travelform->travelstatus=='0')
                                    <td><b>Action :</b></td>
                                    <td>
                                        <div class="row">

                                            <form method="post"
                                                action="{{ route('travelform.update', $travelform->id)}}"
                                                enctype="multipart/form-data">
                                                @method('PATCH')
                                                @csrf
                                                <button type="submit" class="btn btn-success"> Approve</button>
                                                <input type="text" hidden id="example-date-input" name="travelstatus"
                                                    value="1" class="form-control" placeholder="Enter Location">
                                            </form>

                                            <button style="margin-left:11px;height: 35px;" data-toggle="modal"
                                                data-target="#exampleModal12" class="btn btn-danger">
                                                Reject</button>

                                            @endif
                                        </div>
                                    </td>

                                    @endif
                                    @endif
                                </tr>
                            </tbody>

                        </table>
                    </fieldset>

                </div>
            </div>
        </div>
        @if(427 == Auth::user()->teammember_id)
        @if($travelform->travelstatus == 1)
        <div class="card-body">

            <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);">
                <div class="card-body">
                    <form method="post" style="    margin-top: -19px;
                    " action="{{ url('travelform/update')}}" enctype="multipart/form-data">
                        @csrf
                        @component('backEnd.components.alert')

                        @endcomponent

                        <b style="font-weight: 800;font-size: 18px; ">Update Details</b>

                        <hr>


                        <div class="row row-sm">
                            <div class="col-5">
                                <div class="form-group">
                                    <label class="font-weight-600">Billed To Clients *</label>
                                    <select name="billedtoclient" required class="form-control">

                                        <option value="">Please Select One</option>
                                        <option value="1">Yes</option>
                                        <option value="2">No</option>
                        
                                    </select>
                                    <input hidden type="text" name="id" class="form-control"
                                        value="{{ $id ??'' }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Attachment *</label>
                                    <input type="file" required name="file[]" multiple class="form-control"
                                       >
                                </div>
                            </div>
                            <div class="col-1">
                                <div class="form-group" style="
                                margin-top: 10px;
                            ">
                                 <br>
                                    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
            </form>

        </div>
        @endif
        @endif
    </div>

</div>


@endsection
<!-- Small modal -->
<div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:#37A000">
                <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel1">Reason For
                    Rejection</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ route('travelform.update', $travelform->id)}}" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="modal-body">
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <textarea rows="6" name="remark" class="form-control" placeholder=""></textarea>
                                <input hidden type="text" id="example-date-input" name="travelstatus" value="2"
                                    class="form-control" placeholder="Enter Location">
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
