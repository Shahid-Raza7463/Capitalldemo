
<!--Third party Styles(used by this page)-->
<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">

@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/clientuserlogin/create/'.$id)}}">Add Clientlogin</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Client Login List</small>
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>phoneno</th>
                            <th>permission</th>
                            <th>Status</th>
							<th>Client Assigned</th>
							 <th>Portal Permission</th>
                            <th>Reset Pswd</th>
							 <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clientloginDatas as $clientloginData)
                        <tr>
                             <td> <a data-toggle="modal" style="color: green" id="editCompany"
                                    data-id="{{ $clientloginData->id }}"
                                    data-target="#exampleModal1">{{$clientloginData->name }}</td>
                            <td>{{$clientloginData->email }}</td>
                            <td>{{$clientloginData->phoneno }}</td>
                            <td>@if($clientloginData->permission==2)
                                <span>limited ( {{$clientloginData->limitedaccess }})</span>
                                @else
                                <span>unlimited </span>
                                @endif</td>
<td> <input type="checkbox" class="toggle-class" data-id="{{$clientloginData->id}}" checked="" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Active"
    data-off="InActive" {{ $clientloginData->status ? 'checked' : '' }}></td>
                            {{-- <td> <input data-id="{{$clientData->id}}" class="toggle-class" type="checkbox"
                                    data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active"
                                    data-off="InActive" {{ $clientData->status ? 'checked' : '' }}>
                            </td> --}}
							    @php
$clientassign = DB::table('clientassignlogins')
->leftjoin('clients','clients.id','clientassignlogins.client_id')
->where('clientassignlogins.clientlogin_id',$clientloginData->id)->select('clients.client_name')->get();
//dd($clientassign);
$permission = DB::table('staffpermission')
->where('staffpermission.clientlogin_id',$clientloginData->id)->where('staffpermission.client_id',$clientloginData->client_id)->get();
//dd($permission);
                            @endphp
                            <td> @foreach($clientassign as $clientassig)
<span> {{ $clientassig->client_name }},</span>
                                @endforeach
                            </td>
							   <td> @if($permission->isEmpty())<a data-toggle="modal" style="color: green" id="staffpermission"
                                data-id="{{ $clientloginData->id }}"
                                data-target="#exampleModal11">
                                <span class="badge badge-pill badge-primary">click assign</span></a>
                                @else
                                @foreach ($permission as $permissionData)
                                @if($permissionData->writes==1)
                                <span class="badge badge-pill badge-info">writes</span>
                                @endif
                                @if($permissionData->deletes==1)
                                <span class="badge badge-pill badge-info">delete</span>
                                @endif
                                @if($permissionData->staffallocate==1)
                                <span class="badge badge-pill badge-info">staff sllocation</span>
                                @endif
								    @if($permissionData->checklistupload==1)
                                <span class="badge badge-pill badge-info">checklistupload</span>
                                @endif
                                @endforeach
                            @endif</td>
                            <td> <a href="{{url('/clientuserlogin/resetpassword/'.$clientloginData->id)}}"
                                    class="btn btn-info-soft btn-sm"><i class="fas fa-unlock-alt"></i></a></td>
							 <td>{{ date('F d,Y', strtotime($clientloginData->created_at)) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!--/.body content-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>

<script>
    $(function() {
   $('.toggle-class').change(function() {
       var status = $(this).prop('checked') == true ? 1 : 0; 
       var user_id = $(this).data('id'); 
        
       $.ajax({
             type: "GET",
             dataType: "json",
             url: "{{ url('/changeclientloginStatus') }}",
             data: {'status': status, 'user_id': user_id},
             success: function(data){
               console.log(data.success)
             }
         });
     })
   })
 </script>

<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('client/assign')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background: #37A000">
                    <h5 style="color: white;" class="modal-title font-weight-600" id="exampleModalLabel4">Add Client
                        Assign</h5>
                    <div>
                        <ul>
                            @foreach ($errors->all() as $e)
                            <li style="color:red;">{{$e}}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="details-form-field form-group row">
                        <label for="name" class="col-sm-3 col-form-label font-weight-600">Client:</label>
                        <div class="col-sm-9">
                            <select class="language form-control" id="company" required name="client_id">

                                <option value="0">Please Select One</option>

                                @foreach($client as $companyData)
                                <option value="{{$companyData->id}}">
                                    {{ $companyData->client_name }}</option>

                                @endforeach
                            </select>
                            <input id="clientid" hidden class="form-control" name="clientlogin_id" value="" type="text">
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal11" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('client/permissionstore')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background: #37A000">
                    <h5 style="color: white;" class="modal-title font-weight-600" id="exampleModalLabel4">Add Permission</h5>
                    <div>
                        <ul>
                            @foreach ($errors->all() as $e)
                            <li style="color:red;">{{$e}}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="details-form-field form-group row">
                        
                        <div class="col-4">
                        <div class="form-group form-check">
                            <input type="checkbox" name="writes" value="1" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Write</label>
                        </div>
                        </div>
                        <div class="col-4">
                        <div class="form-group form-check">
                            <input type="checkbox" name="deletes" value="1" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Delete</label>
                        </div>
                        </div>
                        <div class="col-4">
                        <div class="form-group form-check">
                            <input type="checkbox" name="staffallocate" value="1" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Staff Allocation</label>
                        </div>
                        </div>
						 <div class="col-4">
                        <div class="form-group form-check">
                            <input type="checkbox" name="checklistupload" value="1" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Checklist Uplaod</label>
                        </div>
                        </div>
                        <input hidden id="clientuserid" class="form-control" name="clientlogin_id" value="" type="text">
                        <input hidden id="client_id" class="form-control" name="client_id" value="" type="text">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('body').on('click', '#editCompany', function (event) {
            var id = $(this).data('id');
            $.ajax({
                type: "GET",

                url: "{{ url('client/loginid') }}",
                data: "id=" + id,

                success: function (response) {
                    $("#clientid").val(response.id);
                },
                error: function () {

                },
            });
        });

    });

</script>
<script>
    $(function () {
        $('body').on('click', '#staffpermission', function (event) {
            var id = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "{{ url('client/staffpermission') }}",
                data: "id=" + id,

                success: function (response) {
                    $("#clientuserid").val(response.id);
                    $("#client_id").val(response.client_id);
                },
                error: function () {

                },
            });
        });

    });

</script>
@endsection
