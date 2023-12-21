@extends('backEnd.layouts.layout') @section('backEnd_content')
<style>
    .table-bordered td,
    .table-bordered th {
        word-break: break-all;
    }

</style>
<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">

    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">

          
            <li class="breadcrumb-item"><a href="{{route('fullandfinal.edit', $fullandfinal->id ??'')}}">Edit
                Fullandfinal</a></li>
         
            <li class="breadcrumb-item"><a href="{{url('fullandfinal')}}">Back</a></li>
        </ol>
    </nav>

    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Full and Final
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

            <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);">
                <div class="card-body">

                    <fieldset class="form-group">

                        <table class="table display table-bordered table-striped table-hover">

                            <tbody>

                                <tr>
                                    <td><b>Employee Name : </b></td>
                                    <td>{{ $fullandfinal->Name ??''}}</td>
                                    <td><b>Role : </b></td>
                                    <td>@if($fullandfinal->Designation == 0)
                                        <span>Article</span>
                                        @elseif($fullandfinal->Designation == 1)
                                        <span>Partner</span>
                                        @elseif($fullandfinal->Designation == 2)
                                        <span>Manager</span>
                                        @elseif($fullandfinal->Designation == 3)
                                        <span>Auditor</span>
                                        @else
                                        <span>C.A</span>
                                        @endif</td>
                                    <td><b>Reporting Head : </b></td>
                                    <td>{{ App\Models\Teammember::select('team_member')->where('id',$fullandfinal->Reporting_Head)->first()->team_member ?? ''}}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Date of Joining : </b></td>
                                    <td>{{ date('F d,Y', strtotime($fullandfinal->Date_of_Joining)) ??''}}</td>
                                    <td><b>Date of Resignation : </b></td>
                                    <td>{{ date('F d,Y', strtotime($fullandfinal->Date_of_Resignation)) ??''}}</td>
                                    <td><b>Date of Leaving : </b></td>
                                    <td>{{ date('F d,Y', strtotime($fullandfinal->Date_of_Leaving)) ??''}}</td>

                                </tr>

                                <tr>
                                    <td><b>Notice Period Served : </b></td>
                                    <td>{{ $fullandfinal->Notice_Period_Served ??''}}</td>
                                    <td><b>Status of Leaving : </b></td>
                                    <td> @if($fullandfinal->Status=='0')
                                        <span>Voluntary</span>
                                        @else
                                        <span>In Voluntary</span>
                                        @endif</td>
                                    <td><b>Assignment/Data Handover : </b></td>
                                    <td> @if($fullandfinal->Assignment_Data_Hanover=='0')
                                        <span>Done</span>
                                        @else
                                        <span>Pending</span>
                                        @endif</td>


                                </tr>
                                <tr>
                                    <td><b>Laptop Handover : </b></td>
                                    <td> @if($fullandfinal->Laptop_Hanover=='0')
                                        <span>Yes</span>
                                        @else
                                        <span>No</span>
                                        @endif</td>
                                    <td><b>Reason of Leaving : </b></td>
                                    <td>{{ $fullandfinal->Reason_of_Leaving ??''}}</td>
                                    <td><b>Full and Final (Days) to be released : </b></td>
                                    <td>{{ $fullandfinal->Full_and_Final_to_be_released ??''}}</td>

                                </tr>

                                @if(Request::is('fullandfinal/*'))
                                @if($fullandfinal->Reporting_Head == Auth::user()->teammember_id)
                                @if($fullandfinal->Assignment_Data_Hanover == null)
                                <tr>
                                    <td><b>Assignment/Data Hanover :</b></td>
                                    <td>
                                        <div class="row">

                                            <form method="post"
                                                action="{{ url('fullandfinal/updatestatus', $fullandfinal->id)}}"
                                                enctype="multipart/form-data">
                                               
                                                @csrf
                                                <button type="submit" class="btn btn-success"> Done</button>
                                                <input type="text" hidden name="Assignment_Data_Hanover" value="0"
                                                    class="form-control" placeholder="Enter Location">
                                            </form>

                                        </div>
                                        
                                    </td>
                                    <td><div class="row">

                                        <form method="post"
                                            action="{{ url('fullandfinal/updatestatus', $fullandfinal->id)}}"
                                            enctype="multipart/form-data">
                                           
                                            @csrf
                                            <button type="submit" class="btn btn-success"> Pending</button>
                                            <input type="text" hidden name="Assignment_Data_Hanover" value="1"
                                                class="form-control" placeholder="Enter Location">
                                        </form>

                                    </div></td>
                                </tr>


                                @endif
                                @endif
                                @endif
                                @if(Request::is('fullandfinal/*'))
                                @if( 16 == Auth::user()->role_id)
                                @if($fullandfinal->Laptop_Hanover == null)
                                <tr>
                                    <td><b>Laptop Handover :</b></td>
                                    <td>
                                        <div class="row">

                                            <form method="post"
                                                action="{{ url('fullandfinal/updatestatus', $fullandfinal->id)}}"
                                                enctype="multipart/form-data">
                                               
                                                @csrf
                                                <button type="submit" class="btn btn-success"> Yes</button>
                                                <input type="text" hidden name="Laptop_Hanover" value="0"
                                                    class="form-control" placeholder="Enter Location">
                                            </form>


                                        </div>
                                     
                                    </td>
                                    <td>
                                        <div class="row">

                                            <form method="post"
                                                action="{{ url('fullandfinal/updatestatus', $fullandfinal->id)}}"
                                                enctype="multipart/form-data">
                                               
                                                @csrf
                                                <button type="submit" class="btn btn-success"> No</button>
                                                <input type="text" hidden name="Laptop_Hanover" value="1"
                                                    class="form-control" placeholder="Enter Location">
                                            </form>

                                        </div>
                                    </td>
                                </tr>


                                @endif
                                @endif
                                @endif
                              
                             
                              
                            </tbody>

                        </table>


                    </fieldset>

                </div>

            </div>
           

        </div>
        @if(Request::is('fullandfinal/*'))
        @if( 17 == Auth::user()->role_id)
        @if($fullandfinal->fnfstatus == null)
        <div class="card-body">

            <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);">
                <div class="card-body">
                    <form method="post"  action="{{ url('fullandfinal/updatestatus', $fullandfinal->id)}}"
                        enctype="multipart/form-data">
                        @csrf
                      
                        <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Account Clearance</label>
                                    <select class="form-control" name="fnfstatus" id="key" value=""
                                        id="exampleFormControlSelect1">
                                        <option value="">Please Select One</option>
                                        <option value="0">Done</option>
                                        <option value="1">Pending</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Status Of Full And Final</label>
                                    <select class="form-control" name="Final_Status_of_Full_and_Final" id="key" value=""
                                        id="exampleFormControlSelect1">
                                        <option value="">Please Select One</option>
                                        <option value="0">Done</option>
                                        <option value="1">On Hold</option>
                                        <option value="2">Not Done</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
                            <a class="btn btn-secondary" href="{{ url('fullandfinal') }}">
                                back</a>

                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
        @endif
        @endif
    </div>

</div>
@endsection
