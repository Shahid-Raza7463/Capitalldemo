@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('employeereferral.edit', $employeereferral->id)}}">Edit
                    employeereferral</a></li>
<li class="breadcrumb-item"> <a  href="{{ url('employeereferral') }}">
        back</a></li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>employeereferral
                    Details</small>
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

            <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:420px;">
                <div class="card-body">
                    <a style="float: right;" href="{{route('employeereferral.edit', $employeereferral->id)}}"
                        class="btn btn-info-soft btn-sm"><i class="far fa-edit"></i></a>
                    <br><br>
                    <fieldset class="form-group">

                        <table class="table display table-bordered table-striped table-hover">

                            <tbody>

                                <tr>
                                    <td><b>Name of Candidate : </b></td>
                                    <td>{{ $employeereferral->Name}}</td>
                                    <td><b>Contact Number of Candidate : </b></td>
                                    <td>{!! $employeereferral->Contact !!}</td>
                                </tr>
                                <tr>
                                    <td><b>Position Referred For : </b></td>
                                    <td>{{ $employeereferral->Position_Referred}}</td>
                                    <td><b>Current Organization. : </b></td>
                                    <td>{!! $employeereferral->Current_Organization !!}</td>

                                </tr>

                                <tr>
                                    <td><b>Relationship with Candidate : </b></td>
                                    <td>{{ $employeereferral->Relationship}}</td>
                                    <td><b>Email Address of Candidate : </b></td>
                                    <td>{!! $employeereferral->Email !!}</td>

                                </tr>
                                <tr>
                                    <td><b>Department Referred For : </b></td>
                                    <td>{{ $employeereferral->Department}}</td>
                                    <td><b>Current Designation : </b></td>
                                    <td>{!! $employeereferral->Designation !!}</td>

                                </tr>
                                <tr>
                                    <td><b>Comment : </b></td>
                                    <td>{{ $employeereferral->Comment }}</td>
									<td><b>Attachment</b></td>
									<td><a target="blank" href="{{url('/backEnd/image/employeereferralresume/'.$employeereferral->attachresume ??'')}}">{{ $employeereferral->attachresume ??''}} </a></td>
                                </tr>

                            </tbody>

                        </table>


                    </fieldset>

                </div>

            </div>


        </div>
    </div>

</div>
@endsection
