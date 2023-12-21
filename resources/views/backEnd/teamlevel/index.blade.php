@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('teamlevel/create')}}">Add Team Role</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Team Role List</small>
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
                            <th>Role Name</th>
                            <th> Permission Access</th>
                            <th>Edit </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teamlevelDatas as $teamlevelData)
                        <tr>
                            <td>{{$teamlevelData->rolename }}</td>
                                    <td>   @foreach(App\Models\Permission::leftJoin('pages',function ($join)
                                        {$join->on('permissions.page_id','pages.id'); })
                                       ->where('permissions.role_id',$teamlevelData->id)
                                       ->select('pages.pagename')->distinct()->get() as $sub )
                                       
                                      <span class="badge badge-info" style="font-size:small;"> {{ $sub->pagename }} </span>
                                       @endforeach
                                       </td>
                         
                                       <td> <a href="{{url('/teamlevel/edit/'.$teamlevelData->id)}}"
                                        class="btn btn-info-soft btn-sm"><i class="far fa-edit"></i></a>
                                    </td>
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
