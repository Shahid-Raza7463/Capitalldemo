@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
       
        <a href="{{ url('proposal/create/') }}" style="float: right;" class="btn btn-success ml-2">Add Proposal</a>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>From now on you will start your activities.</small>
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

                    <div class="table-responsive example">

                        <div class="table-responsive">
                            <table class="table display table-bordered table-striped table-hover basic">
                                <thead>
                                    <tr>
                                        <th>Sent By</th>
										  <th>Name Of Service</th>
                                        <th>To</th>
                                        <th>Profile</th>
                                        <th>Status</th>
                                        <th>Createdby</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($proposalDatas as $proposalData)
                                    <tr>
                                        <td> <a href="{{route('proposal.show', $proposalData->id)}}">
                                                {{ $proposalData->team_member ??''}}</a></td>
										  <td>{{ $proposalData->nameofservice ??'' }} </td>
                                        <td>{{ $proposalData->to ??'' }} </td>
                                        <td>
                                        @foreach(DB::table('proposaattachments')
											 ->where('proposaattachments.proposal_id',$proposalData->id)
                              ->get()
                                as $sub)    
											 @if (pathinfo($sub->attachment,
                                         PATHINFO_EXTENSION)
                                         == 'pptx')
                                        <a  target="blank"
                                                href="https://view.officeapps.live.com/op/view.aspx?src={{url('/backEnd/image/proposal/'.$sub->attachment)}}">{{ $sub->attachment ??''}}</a>
											@else
											  <a  target="blank"
                                                href="{{url('/backEnd/image/proposal/'.$sub->attachment)}}">{{ $sub->attachment ??''}}</a>
											@endif
                                @endforeach    
                                        </td>
                                        <td>@if($proposalData->status==0)
                                                <span class="badge badge-pill badge-warning">Pending</span>
                                                @elseif($proposalData->status==1)
                                                <span class="badge badge-success">Win</span>
                                                @elseif($proposalData->status==2)
                                                <span class="badge badge-danger">Loss</span>
                                                @endif
                                            </td>
                                            <td>{{ App\Models\Teammember::select('team_member')->
                                      where('id',$proposalData->createdby)->first()->team_member ?? ''}}</td>

                                         
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                <div>
                </div>
            </div>
        </div>
    </div>

</div>
<!--/.body content-->
@endsection
