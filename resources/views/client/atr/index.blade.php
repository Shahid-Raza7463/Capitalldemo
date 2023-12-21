@extends('client.layouts.layout') @section('client_content')
<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">

    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>ATR List</small>
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
                <table class="table display table-bordered table-striped table-hover basic">
                    <thead>
                        <tr>
                            <th>FY</th>
                            <th>Quarter</th>
                            <th>Area</th>
                            <th>Observations</th>
                            <th>Management Comments</th>
                            <th>Responsible Person</th>
                            <th>Due Date for Closure</th>
                            <th>Attachments</th>
                            <th>Auditors Final Comments</th>
                            <th>Status</th>
                            <th>Further remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($atrData as $atrDatas)
                        <tr>

                            <td><a target="blank"
                                    href="{{url('client/atrview/'.$atrDatas->id)}}">{{ $atrDatas->fy }}</a></td>
                            <td> {{ $atrDatas->quarter }}</td>
                            <td> {{ $atrDatas->area }}</td>
                            <td> {{ $atrDatas->observations }}</td>
                            <td> {{ $atrDatas->management_comments }}</td>
                            <td>
                                @if($atrDatas->responsible_person == null)
                                <a style="width: 126px;color:white;" class="btn btn-success" id="editCompany"
                                    data-toggle="modal" data-id="{{ $atrDatas->id }}" data-target="#exampleModal12">
                                    choose member</a>
                                @else
                                {{ $atrDatas->clientlogin->name }}
                                @endif
                            </td>
                            <td>@if($atrDatas->duedate_for_closure != null)
                                {{ date('F d,Y', strtotime($atrDatas->duedate_for_closure)) }}
                                @endif
                            </td>
                            <td>
                                @foreach ($atrDatas->atrfile as $atrfileDatas)
                                <a target="blank"
                                    href="{{ Storage::disk('s3')->temporaryUrl('atr/'.$atrfileDatas->attachments, now()->addMinutes(3)) }}">
                                    <span class="badge badge-pill badge-success">
                                        {{ $atrfileDatas->attachments }}</span> </a>
                                @endforeach

                            </td>
                            <td> {{ $atrDatas->auditors_final_comments }}</td>
                            <td>@if($atrDatas->status==0)
                                <span class="badge badge-pill badge-success">OPEN</span>
                                @elseif($atrDatas->status==2)
                                <span class="badge badge-pill badge-info">SUBMITTED</span>
                                @else
                                <span class="badge badge-pill badge-danger">CLOSED</span>
                                @endif
                            </td>
                            <td> {{ $atrDatas->further_remarks }}</td>

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
