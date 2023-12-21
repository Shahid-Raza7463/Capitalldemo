
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('teammember/create')}}">Add Teammember</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Team</h1>
                <small>Tab List</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="card mb-4">
    
        <div class="card-body">
            <div class="table-responsive">
                <table class="table display table-bordered table-striped table-hover basic">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Team Member Name</th>
                            <th>Team Level</th>
                            <th>Address</th>
                            <th>Mobile No</th>
                            <th>Joining Date</th>
                            <th>Email</th>
                           
                            <th>Status</th>
                        
                            <th>Deactivate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teammemberDatas as $teammemberData)
                        <tr>
                            <td>{{$teammemberData->id }}</td>
                            <td><a href="{{route('teammember.edit', $teammemberData->id)}}" >{{$teammemberData->title->title ??'' }}. {{$teammemberData->team_member}}</a></td>
                            <td>{{$teammemberData->teamlevel->title ??''}}</td>
                            <td>{{$teammemberData->communicationaddress}}</td>
                            <td>{{$teammemberData->mobile_no}}</td>
                            <td>{{ date('F d,Y', strtotime($teammemberData->joining_date)) }}</td>
                            <td>{{$teammemberData->emailid}}</td>
                            
                            <td>@if($teammemberData->status==1)
                                <span class="btn btn-success btn">Active</span>
                                @else
                                <span class="btn btn-danger btn">Inactive</span>
                                @endif
                            </td>
                           
                             <td> <form action="{{ route('teammember.destroy', $teammemberData->id) }}" method="POST">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button  onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-info">Delete</button>
                            </form></td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div><!--/.body content-->

@endsection


