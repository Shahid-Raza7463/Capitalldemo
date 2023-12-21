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

            {{-- @if($assetprocurements->Status=='0')
            <li class="breadcrumb-item"><a href="{{route('assetprocurement.edit', $assetprocurements->id ??'')}}">Edit
                    assetprocurements</a></li>
            @endif --}}
            <li class="breadcrumb-item"><a href="{{url('assetprocurement')}}">Back</a></li>
        </ol>
    </nav>

    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>assetprocurements
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

            <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:750px;">
                <div class="card-body">

                    <fieldset class="form-group">

                        <table class="table display table-bordered table-striped table-hover">

                            <tbody>

                                <tr>
                                    <td><b>Company Name : </b></td>
                                    <td>{{ $assetprocurements->companyname ??''}}</td>
                                    <td><b>Created By : </b></td>
                                    <td>   {{ App\Models\Teammember::select('team_member')->where('id',$assetprocurements->createdby)->first()->team_member ?? ''}}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Item Name : </b></td>
                                    <td>{{$assetprocurements->itemname ??''}}</td>
                                    <td><b>Place Of Purchase : </b></td>
                                    <td>{{ $assetprocurements->placeofpurchase ??'' ??''}}
                                    </td>

                                </tr>

                                <tr>
                                    <td><b>Start date : </b></td>
                                    <td>{{ date('F d,Y', strtotime($assetprocurements->startdate)) ??''}}
                                    </td>
                                    <td><b>End Date : </b></td>
                                    <td>{{ date('F d,Y', strtotime($assetprocurements->enddate)) ??''}}
                                    </td>


                                </tr>
                                <tr>
                                    <td><b>Amount : </b></td>
                                    <td>{{ $assetprocurements->amount ??''}}
                                    </td>
                                    <td><b>Bill / PO : </b></td>
                                    <td><a target="blank" href="{{url('/backEnd/image/assetprocurements/'.$assetprocurements->bill ??'')}}">
                                        {{ $assetprocurements->bill ??''}}</a></td>


                                </tr>
                                <tr>
                                    <td><b>Payment Type : </b></td>
                                    <td>@if($assetprocurements->paymenttype == 0)
                                        <span >Reimbursement</span>
                                       
                                        @else
                                        <span>Advance</span>
                                        @endif
                                    </td>
                                    @if($assetprocurements->remark != null)
                                    <td><b>Remarks : </b></td>
                                    <td>{{ $assetprocurements->remark ??''}}
@endif
                                </tr>
                                <tr>
                                    <td><b>Status : </b></td>
                                    <td>    @if($assetprocurements->Status==0)
                                        <span class="badge badge-info">Created</span>
                                        @elseif($assetprocurements->Status==1)
                                        <span class="badge badge-success">Approved</span>
                                        @elseif($assetprocurements->Status==2)
                                        <span class="badge badge-danger">Rejected</span>
                                        @endif</td>
                             
                                </tr>
                                <tr>
                                    
                                    @if($assetprocurements->remark != null)
                                    <td><b>Reason For Rejection : </b></td>
                                    <td>{{ $assetprocurements->remark ??''}}</td>
                                    @endif
                                </tr>
                             
                                @if($assetprocurements->teammember_id == Auth::user()->teammember_id)

                                <tr>
                                    @if($assetprocurements->Status =='0')
                                    <td><b>Action :</b></td>
                                    <td>
                                        <div class="row">

                                            <form method="post"
                                                action="{{ route('assetprocurement.update', $assetprocurements->id)}}"
                                                enctype="multipart/form-data">
                                                @method('PATCH')
                                                @csrf
                                                <button type="submit" class="btn btn-success"> Approve</button>
                                                <input type="text" hidden id="example-date-input"
                                                    name="Status" value="1" class="form-control"
                                                    placeholder="Enter Location">
                                            </form>

                                            <button style="margin-left:11px;height: 35px;" data-toggle="modal"
                                                data-target="#exampleModal12" class="btn btn-danger">
                                                Reject</button>


                                            @endif
                                        </div>
                                    </td>

                                </tr>


                              
                                @endif
                            </tbody>

                        </table>


                    </fieldset>
                   
                </div>

            </div>


        </div>
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
            <form method="post" action="{{ route('assetprocurement.update', $assetprocurements->id)}}"
                enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="modal-body">
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <textarea rows="6" name="remark" class="form-control" placeholder=""></textarea>
                                <input hidden type="text" id="example-date-input" name="Status"
                                    value="2" class="form-control" placeholder="Enter Location">
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
