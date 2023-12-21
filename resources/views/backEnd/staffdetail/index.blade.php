@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    @if(Auth::user()->role_id == 18 || Auth::user()->role_id == 11)
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('staffdetail/create')}}">Add Tender Staffdetail</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    @endif
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Staffdetail List</small>
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
                <table id="example" class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Teammember</th>
                            <th>Type</th>
                            <th>Qualification</th>
                            <th>Membership No</th>
                            <th>Date of Association with the Firm</th>
                            <th>Experience</th>
                            <th>Date of Joining</th>
                            <th>Createdby</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($staffdetailDatas as $staffdetailData)
                        <tr>
                            <td> {{$staffdetailData->team_member}}</a></td>
                            <td>@if($staffdetailData->type==0)
                                <span class="badge badge-pill badge-warning">Partner</span>
                                @elseif($staffdetailData->type==1)
                                <span class="badge badge-pill badge-success">Qualified</span>
                             
                                @elseif($staffdetailData->type==2)
                                <span class="badge badge-pill badge-info">Article Trainee</span>
                               
                                @else
                                <span class="badge badge-pill badge-danger">Other Staff</span>
                                @endif
                            </td>
                            <td>{{$staffdetailData->qualification}}</td>
                            <td>{{$staffdetailData->membership_no}}</td>
                            <td>@if($staffdetailData->date_of_association !=  null)
                                {{ date('F d,Y', strtotime($staffdetailData->date_of_association)) }}
                            @endif</td>
                            <td>{{$staffdetailData->experience}}</td>
                            <td>@if($staffdetailData->dateofjoining !=  null)
                                {{ date('F d,Y', strtotime($staffdetailData->dateofjoining)) }}
                            @endif</td>
                            <td>{{ App\Models\Teammember::select('team_member')->where('id',$staffdetailData->createdby)->first()->team_member ?? '' }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div><!--/.body content-->

@endsection

