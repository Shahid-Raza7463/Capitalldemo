<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
           
            <li> <a class="btn btn-success ml-2" href="{{ url('proposal') }}">
                    Back</a></li>

        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Proposal</small>
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
                                    <td><b>Sendby : </b></td>
                                    <td>{{ $proposal->team_member}}</td>
                                    <td><b>To :</b></td>
                                    <td>{{ $proposal->to }}</td>
                                </tr>
                                <tr>  
                            @php
                             $proposalData = DB::table('proposaattachments')
                                ->where('proposaattachments.proposal_id',$proposal->id)->get()  
                             @endphp
                                   
                                    <td><b>Attachment : </b></td>
                                    <td>
                                        @foreach($proposalData as $sub)

                                        <a download target="blank"
                                                href="{{url('/backEnd/image/proposal/'.$sub->attachment)}}">{{ $sub->attachment ??''}}</a>
                    @endforeach
                            </td>
                                    <td><b>Createdby :</b></td>
                                    <td>{{ App\Models\Teammember::select('team_member')->
                                        where('id',$proposal->createdby)->first()->team_member ?? ''}}</td>
                                </tr>
                    
                                <tr>
                                    <td><b>Status : </b></td>
                                    <td>@if($proposal->status==0)
                                        <span class="badge badge-info">Pending</span>
                                        @elseif($proposal->status==1)
                                        <span class="badge badge-success">Win</span>
                                        @else
                                        <span class="badge badge-danger">Loss</span>
                                        @endif
                                    </td>
                                    @if(Request::is('proposal/*'))
                                    @if($proposal->createdby == Auth::user()->teammember_id)

                                    @if($proposal->status=='0')
                                    <td><b>Action :</b></td>
                                    <td>
                                        <div class="row">

                                            <form method="post"
                                                action="{{ route('proposal.update', $proposal->id)}}"
                                                enctype="multipart/form-data">
                                                @method('PATCH')
                                                @csrf
                                                <button type="submit" class="btn btn-success"> Win</button>
                                                <input type="text" hidden id="example-date-input" name="status"
                                                    value="1" class="form-control" placeholder="Enter Location">
                                            </form> 
                                            <a  data-target="#modal7" data-toggle="modal" class="btn btn-danger" style="height:35px;color:white;">
                                                  Loss</a>

                                            @endif
                                           
                                        </div>
                                    </td>
                                    @endif
                                    @endif

                            </tbody>

                        </table>


                    </fieldset>

                </div>
            </div>
        </div>
    </div>

</div>
<!-- Modal Start -->
<div class="modal fade" id="Modal7" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
 aria-hidden="true">
 <div class="modal-dialog" role="document">
     <div class="modal-content">
           <div class="modal-header" style="background:#37A000">
 <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel1">Remark</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <form method="post" action="{{ url('proposal/status')}}" enctype="multipart/form-data">
            @csrf   
           <div class="modal-body">
            <div class="row row-sm">
            <div class="col-12">
          <div class="form-group">
            <label class="font-weight-600">Remarks</label>
            <textarea class="form-control" name="remark" ></textarea>
            <input hidden type="text" id="example-date-input" name="status"
                value="2" class="form-control" placeholder="Enter Location">
                                            
            <input class="form-control" hidden value="{{ $proposal->id }}" name="id" type="text">
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
<!-- End Modal -->

@endsection
