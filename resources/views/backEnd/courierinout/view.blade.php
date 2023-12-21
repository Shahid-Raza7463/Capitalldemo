<!--Third party Styles(used by this page)-->
<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">

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

            <li> <a class="btn btn-success ml-2" href="{{ url('courierinout') }}">
                    Back</a></li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Correspondence Details</small>
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
                                @if($courierinout->type == 0)
                                <tr>
                                    <td><b>Courier / Item Name :</b></td>
                                    <td>{{$courierinout->courier_item_name ??''}}</td>
                                    <td><b>Assigned to : </b></td>
                                    <td>{{$courierinout->team_member ??''}} ({{$courierinout->rolename ??''}})</td>
                                </tr>
								 <tr>
                                    <td><b>Attachment :</b></td>
                                    <td><a target="blank"
                                        href="{{url('/backEnd/image/courier/'.$courierinout->attachment)}}">
                                        {{$courierinout->attachment ??''}}</a></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><b>Address : </b></td>
                                    <td>{{ $courierinout->address ??'' }}</td>
                                    <td><b>Priority :</b></td>
                                    <td>
                                        @if($courierinout->priority==0)
                                        <span class="badge badge-info">Urgent</span>
                                        @else
                                        <span class="badge badge-success">Normal</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Status : </b></td>
                                    <td>@if($courierinout->status==0)
                                        <span class="badge badge-info">Assigned</span>
                                        @elseif($courierinout->status==1)
                                        <span class="badge badge-success">Processing</span>
                                        @elseif($courierinout->status==2)
                                        <span class="badge badge-danger">Delivered</span>
                                        @else
                                        <span class="badge badge-warning">Revert Back</span>
                                        @endif
                                    </td>
                                    <td><b>Courier Service :</b></td>
                                    <td>{{$courierinout->courier_service ??''}}</td>
                                </tr>
                                <tr>
                                    <td><b>Courier Charges :</b></td>
                                    <td>{{$courierinout->courier_charges ??''}}</td>
                                    <td><b>Estimated Date / Delivery Date :</b></td>
                                    <td>@if ($courierinout->estimated_date_of_delivery_date !=  null)
                                        {{ date('F d,Y', strtotime($courierinout->estimated_date_of_delivery_date)) }}
                                    @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Tracking Image :</b></td>
                                    <td><a target="blank"
                                            href="{{url('/backEnd/image/courier/'.$courierinout->tracking_image)}}">
                                            {{$courierinout->tracking_image ??''}}</a></td>
                                   
                                     <td><b>Tracking No :</b></td>
                                     <td>{{$courierinout->tracking ??''}}</td>
                                    </tr>
                                @else
                                <tr>
                                    <td><b>Courier / Item Name :</b></td>
                                    <td>{{$courierinoutData->courier_item_name ??''}}</td>
                                    <td><b>Handover to : </b></td>
                                    <td>{{$courierinoutData->team_member ??''}} ({{$courierinoutData->rolename ??''}})
                                    </td>
                                </tr>
								 <tr>
                                    <td><b>Attachment :</b></td>
                                    <td><a target="blank"
                                        href="{{url('/backEnd/image/courier/'.$courierinout->attachment)}}">
                                        {{$courierinout->attachment ??''}}</a></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><b>Date Time : </b></td>
                                    <td>{{ date('F d,Y', strtotime($courierinoutData->date_time)) }}</td>

                                    <td><b>Status : </b></td>
                                    <td>
                                        @if($courierinoutData->in_status==1)
                                        <span class="badge badge-success">Acknowledge</span>
                                        @else
                                        <span class="badge badge-danger">Not Acknowledge</span>
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td><b>Createdby</b></td>
                                    <td>{{ App\Models\Teammember::select('team_member')->where('id',$courierinout->createdby)->first()->team_member ?? ''}}</td>
                                    <td><b>Created Date</b></td>
                                    <td>{{ date('F d,Y', strtotime($courierinoutData->created_at)) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </fieldset>
                    @if($courierinout->type==0)
                    @if($courierinout->status==0)
                    @if($courierinout->assignedto  ==  Auth::user()->teammember_id)
                    <form method="post" action="{{ url('courierinout/update', $courierinout->id)}}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Courier Service</label>
                                    <input type="text" name="courier_service" placeholder="Enter Courier Service"
                                        value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Courier Charges</label>
                                    <input type="number" name="courier_charges" placeholder="Enter Courier Charges"
                                        value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Estimated Date / Delivery Date</label>
                                    <input type="date" name="estimated_date_of_delivery_date"
                                        placeholder="Enter Estimated Date / Delivery Date" value=""
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Tracking Image</label>
                                    <input type="file" name="tracking_image" value="" class="form-control">
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
                            <a class="btn btn-secondary" href="{{ url('courierinout') }}">Back</a>

                        </div>
                    </form>
                    @endif
                    @else
                    @if($courierinout->assignedto  ==  Auth::user()->teammember_id)
                    <form method="post" action="{{ url('courierinout/sender', $courierinoutData->id)}}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Status</label>
                                    <select required class="form-control key" name="status">
                                        <option value="">Please Select One</option>
                                        <option value="2">Delivered</option>
                                        <option value="3">Revert Back</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
                            <a class="btn btn-secondary" href="{{ url('courierinout') }}">Back</a>

                        </div>
                    </form>
                    @endif
                    @endif
                    @else
                    @if($courierinout->in_status==0)
                    @if($courierinout->handover_to  ==  Auth::user()->teammember_id)
                    <form method="post" action="{{ url('courierinout/receiver', $courierinoutData->id)}}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Status</label>
                                    <select class="form-control key" name="in_status">
                                        <option value="">Please Select One</option>
                                        <option value="1">Acknowledge</option>
                                        <option value="0">Not Acknowledge</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
                            <a class="btn btn-secondary" href="{{ url('courierinout') }}">Back</a>

                        </div>
                    </form>
                    @endif
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
