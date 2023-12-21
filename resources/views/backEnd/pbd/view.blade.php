 <!--Third party Styles(used by this page)--> 
 <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">

@extends('backEnd.layouts.layout') @section('backEnd_content')

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
                    @if($task->createdby == Auth::user()->teammember_id || Auth::user()->role_id == 11)
                    <div class="card-head" style="width:930px;height: 10px;">
						<a style="margin-top: -17px;"
                data-toggle="modal" data-target="#exampleModal12"
                    class="btn btn-info-soft btn-sm">Mail <i class="far fa-envelope"></i></a>
                        <b style="float:right;margin-top: -17px;"><a onclick="return confirm('Are you sure you want to delete this item?');"
                                href="{{url('task/delete', $task->id)}}" 
                                class="btn btn-info-soft btn-sm"><i class="far fa-trash-alt"></i></a></b>
                    </div>
                    <hr>
@endif
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


<!-- Modal -->
<div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('/task/reminder')}}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background:#37A000;color:white;">
                    <h5 class="modal-title font-weight-600" id="exampleModalLabel4">Send Reminder Mail</h5>
                    <div>
                        <ul>
                            @foreach ($errors->all() as $e)
                            <li style="color:red;">{{$e}}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button style="color: white" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row row-sm">
                        {{-- <label for="name" class="col-sm-3 col-form-label font-weight-600">Name :</label> --}}
                        <div class="col-sm-6">
                            <input placeholder=" Enter Subject" value="Kgs Task Reminder" class="form-control" name="subject" type="text">
                            <input hidden placeholder=" Enter Subject" value="{{ $id }}" class="form-control" name="taskid" type="text">
                        </div>
                        <div class="col-sm-6">
                            <select class="form-control basic-multiple"  multiple="multiple"
                            name="email[]">
                            @if(Request::is('view/task/*'))
                            @foreach ($taskassign as $taskassignData)
                            @foreach($teammember as $teammemberData)
                            <option value="{{ $teammemberData->emailid }}" @if($teammemberData->id==$taskassignData->teammember_id) 
                                selected @endif>{{ $teammemberData->emailid }}</option>
                            @endforeach
                            
                            @endforeach
                            @endif
                        </select>
                        </div>
                    </div>
                  <br>
                    <div class="row row-sm">
                        <div class="col-sm-12"> 
                            <textarea rows="6" name="msg" class="centered form-control" id="editor"
                                placeholder="Enter Description">
                                Dear Sir/Madam
                            <br> <br><b>you have a pending task reminder request</b></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
						   <a onclick="myFunction()" style="margin-right: 243px;color:#37A000;">View Trial</a>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
            </form>
				        <div class="table-responsive" id="panel" style="display: none;">

                <table class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($taskreminderDatas as $taskData)
                        <tr>
                            <td>{{ $taskData->description}}</td>
                            <td>{{ date('F d,Y', strtotime($taskData->created_at)) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    function myFunction() {
      document.getElementById("panel").style.display = "block";
    }
	</script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="{{ url('backEnd/ckeditor/ckeditor.js')}}"></script>
    
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
            })
            .then(editor => {
                window.editor = editor;
            })
            .catch(err => {
                console.error(err.stack);
            });
    
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor1'), {
                // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
            })
            .then(editor => {
                window.editor = editor;
            })
            .catch(err => {
                console.error(err.stack);
            });
    
    </script>
    
@endsection

<!--Page Active Scripts(used by this page)-->
<script src="{{ url('backEnd/dist/js/pages/forms-basic.active.js')}}"></script>
<!--Page Scripts(used by all page)-->
<script src="{{ url('backEnd/dist/js/sidebar.js')}}"></script>
