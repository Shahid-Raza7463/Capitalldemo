@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('lead/create')}}">Add Lead</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
            <div class="media-body">
                <a href="{{url('home')}}">
                    <h1 class="font-weight-bold" style="color:black;">Home</h1>
                </a>
                <small>Lead List</small>
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
                            <th>Client</th>
                            <th>Contact</th>
							<th>Commercials</th>
							<th>Last Meeting Date</th>
							<th>Concern Partner</th>
							
                            <th>Created Date</th>
                            <th>Service Type</th>
							 <th>Documents</th>
                            <th>Status</th>
                            <th>Created By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leadDatas as $leadData)
                        <tr>
                        <td><a href="{{url('lead/view', $leadData->id)}}">
                                @if(empty($leadData->client_id)){{ $leadData->client_names ??'' }}@else
                                {{ $leadData->client_name ??'' }}@endif</a>
							</td>
							    <td>
                            <span><b>Contact Person :</b> {{ $leadData->contactperson ??'' }}</span><br>
                            <span><b>Contact Email :</b> {{ $leadData->contactemail ??'' }}</span><br>
                            <span><b>Contact Phone :</b> {{ $leadData->contactphone ??'' }}</span><br>
                            <span><b>Contact Designation :</b> {{ $leadData->designation ??'' }}</span>
                        </td>
							<td>
								{{ $leadData->commercials ??'' }}
							</td>
							 <td>
								 @if($leadData->lastmeetingdate !=  null)
								 {{ date('F d,Y', strtotime($leadData->lastmeetingdate)) }}
								 @endif
							</td>
							  @php
$teammembersconcern = DB::table('teammembers')->where('id',$leadData->concernpartner)->first();
                                    @endphp
							<td>
								{{ $teammembersconcern->team_member ??'' }}
							</td>
                    

                        <td>{{ date('F d,Y', strtotime($leadData->created_at)) }}</td>
                        <td>{{ $leadData->servicetype ??'' }}</td>
							  @php
                           $leadfiles = DB::table('leadfiles')->where('leadid',$leadData->id)->get();

                        @endphp
                        <td>
                             @foreach($leadfiles as $leadfilesData)
                        <span><a href="{{ Storage::disk('s3')->temporaryUrl('lead/'.$leadfilesData->file, now()->addMinutes(10)) }}" target="blank">
  {{ $leadfilesData->file}}</a>  , <br></span>
                             @endforeach
                        </td>
                        <td>@if($leadData->status==3)
                            <span class="badge badge-pill badge-warning">Follow Up</span>
                            @elseif($leadData->status==1)
                            <span class="badge badge-pill badge-info">Proposal Sent</span>
                            @elseif($leadData->status==0)
                            <span class="badge badge-pill badge-success">Fresh</span>

                            @else
                            <span class="badge badge-pill badge-danger">Decline</span>
                            @endif
                        </td>
                        <td>{{ $leadData->team_member ??'' }}</td>
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
