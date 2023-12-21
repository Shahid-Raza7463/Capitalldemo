@extends('client.layouts.layout') @section('client_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('task/create')}}">Add task</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>task
                    List</small>
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
            <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:450px;">
                <div class="card-body">
                    <fieldset    class="form-group">

                        <table class="table display table-bordered table-striped table-hover">

                            <tbody>

                                <tr>
                                    <td><b>Task Name : </b></td>
                                    <td>{{ $task->taskname}}</td>

                                    <td><b>Due Date :</b></td>
                                    <td>{{ date('F d,Y', strtotime($task->duedate)) }}</td>

                                </tr>
                                <tr>
                                    <td><b>Reminder : </b></td>
                                    <td>{{ $task->reminder}}</td>
                                    <td><b>Description : </b></td>
                                    <td>{!! $task->description !!}</td>

                                </tr>
                               
                                <tr>
                                    <td><b>Status : </b></td>
                                    <td>@if($task->status ==  1)
                                        <span >open</span>
                                        @else
                                        <span>limited</span>
                                        @endif</td>
                                     <td><b>Createdby : </b></td>
                                     <td>{{ App\Models\Teammember::select('team_member')->where('id',$task->createdby)->first()->team_member ?? ''}}</td>
                                </tr>
                             
                               

                            </tbody>
                           
                        </table>
                        <div class="card mb-4" >
                           
                            <div class="card-body">
                                <form method="post" action="{{ url('task/complete')}}" enctype="multipart/form-data">
                                    @csrf
                              @component('backEnd.components.alert')
            
                              @endcomponent
                              <div class="row row-sm">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="font-weight-600"> Status *</label>
                                        <select name="status" id="exampleFormControlSelect1" class="form-control">
                                            <!--placeholder-->
                                            @if(Request::is('view/task/*')) >
                                            @if($task->status=='0')
                                            <option value="0">pending</option>
                                            <option value="1">completed</option>
                            
                                            @else
                                            <option value="1">completed</option>
                                            <option value="0">pending</option>
                                           
                            
                                            @endif
                                            @else
                            
                                            <option value="">Please Select One</option>
                                            <option value="0">pending</option>
                                            <option value="1">completed</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="font-weight-600">Remark  *</label>
                                        <input type="text" name="remark" value="{{ $task->remark ?? ''}}" class="form-control"
                                            placeholder="Enter Remark">
                                        <input type="text" hidden name="rid" value="{{ $id ?? ''}}" class="form-control"
                                            placeholder="Enter Nature of Services">
                                    </div>
                                </div>
                              </div>
                              @if($task->status == 0)
                            <div class="form-group">
                                <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
                                <a class="btn btn-secondary" href="{{ url('task') }}">
                                    Back</a>
                            
                            </div>
                            @endif
                            </form>
               
                            <hr class="my-4">
                            </div>
                        </div>
                       
                        
                    </fieldset>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
