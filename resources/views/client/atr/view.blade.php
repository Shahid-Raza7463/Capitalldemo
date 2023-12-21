@extends('client.layouts.layout') @section('client_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">

    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">

            <li> <a class="btn btn-primary" href="{{ url('client/atrlist') }}">Back</a></li>

        </ol>
    </nav>

    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>ATR Details</small></a>
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

            <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2); ">
                <div class="card-body">

                    <fieldset class="form-group">

                        <table class="table display table-bordered table-striped table-hover">

                            <tbody>

                                <tr>
                                    <td><b>FY : </b></td>

                                    <td>{{ $atr->fy }}</td>
                                    <td><b>Quarter : </b></td>
                                    <td>{{$atr->quarter ??'' }}</td>
                                </tr>

                                <tr>
                                    <td><b>Area : </b></td>
                                    <td>{{ $atr->area ??''}}

                                    </td>
                                    <td><b>Observations : </b></td>
                                    <td>{{ $atr->observations ??''}}

                                    </td>

                                </tr>
                                @if($atr->management_comments != null)
                                <tr>
                                    <td><b>Management Comments : </b></td>
                                    <td>{{ $atr->management_comments ??''}}</td>
                                    <td><b>Responsible Person : </b></td>
                                    <td>{{ $atr->name ??''}}</td>

                                </tr>
                                <tr>
                                    <td><b>Due Date for Closure : </b></td>
                                    <td>{{ date('F d,Y', strtotime($atr->duedate_for_closure)) }}</td>
                                    <td><b>Attachments : </b></td>
                                    <td>
                                        @foreach ($atrfile as $atrfileDatas)
                                        <a target="blank"
                                            href="{{ Storage::disk('s3')->temporaryUrl('atr/'.$atrfileDatas->attachments, now()->addMinutes(3)) }}">
                                            <span class="badge badge-pill badge-success">
                                                {{ $atrfileDatas->attachments }}</span> </a>
                                        @endforeach

                                    </td>

                                </tr>
                                @endif
                                <tr>
                                    <td><b>Further remarks : </b></td>
                                    <td>{{$atr->further_remarks ??''}}</td>

                                    <td><b>Status : </b></td>
                                    <td>@if($atr->status==0)
                                        <span class="badge badge-pill badge-success">OPEN</span>
                                        @elseif($atr->status==2)
                                        <span class="badge badge-pill badge-info">SUBMITTED</span>
                                        @else
                                        <span class="badge badge-pill badge-danger">CLOSED</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Auditors Final Comments : </b></td>
                                    <td>{{$atr->auditors_final_comments ??''}}</td>
                                    <td><b> </b></td>
                                    <td></td>
                                </tr>

                            </tbody>

                        </table>


                    </fieldset>

                </div>

            </div>


        </div>
        @if($atr->responsible_person == Auth::user()->id)
        @if($atr->status == 0 )
        <div class="card-body">

            <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);">
                <div class="card-body">
                    <form method="post" style="    margin-top: -19px;
                    " action="{{ url('client/atr/update')}}" enctype="multipart/form-data">
                        @csrf
                        @component('backEnd.components.alert')

                        @endcomponent

                        <b style="font-weight: 800;font-size: 18px; ">Update Details</b>

                        <hr>


                        <div class="row row-sm">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Management Comments *</label>
                                    <input type="text" required name="management_comments" class="form-control"
                                        value="{{ $atr->management_comments ??'' }}" placeholder="Enter Comments">
                                    <input hidden type="text" name="id" class="form-control"
                                        value="{{ $atr->id ??'' }}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Due Date Of Closure *</label>
                                    <input type="date" required name="duedate_for_closure" class="form-control"
                                        value="{{ $atr->duedate_for_closure ??'' }}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Attachments *</label>
                                    <input type="file" multiple name="attachments[]" class="form-control"
                                        value="{{ $atr->attachments ??'' }}">
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-12">
                                <label class="font-weight-600"> Further Remarks ( If Any ) </label>
                                <textarea rows="2" name="further_remarks" class="form-control"
                                    placeholder="Enter Remarks">{{ $atr->further_remarks ??'' }}</textarea>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" style="float:right"> Submit</button>


                        </div>

                </div>
            </div>
            </form>

        </div>
        @endif
        @endif
    </div>

</div>
</div>

</div>



@endsection
