 <!--Third party Styles(used by this page)--> 
 <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">

@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('timesheet/create')}}">Add Time sheet</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Time sheet
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
            <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:650px;">
              
                <div class="card-body">
                   
                    <div class="card-head" style="width:930px;height: 10px;">
						<!-- <a style="margin-top: -17px;"
                data-toggle="modal" data-target="#exampleModal12"
                    class="btn btn-info-soft btn-sm">Mail <i class="far fa-envelope"></i></a> -->
                        <b style="float:right;margin-top: -17px;"><a href="{{route('timesheet.edit', $timesheet->id)}}"  class="btn btn-info-soft btn-sm"> 
                                <i class="far fa-edit"></i></a></b>
                    </div>
                     <hr>
                    <fieldset class="form-group">

                        <table class="table display table-bordered table-striped table-hover">

                            <tbody>
                           
                                <tr>
                                    <td><b>Client Name : </b></td>
                                    @php
                                    $timesheetData = DB::table('timesheets')
            ->leftjoin('clients','clients.id','timesheets.client_id')
            ->where('timesheets.id',$timesheet->id)->select('timesheets.*','clients.client_name')->get();
                  
                         @endphp
                             <td>@foreach($timesheetData as $timesheetDatas) {{ $timesheetDatas->client_name ??''}}
                             @endforeach
                             </td>
                                   
                                    <td><b>Assignment Name : </b></td>
                                    @php
                                    $timesheetData = DB::table('timesheets')
            ->leftjoin('assignments','assignments.id','timesheets.assignment_id')
            ->where('timesheets.id',$timesheet->id)->select('timesheets.*','assignments.assignment_name')->get();
                  
                         @endphp
                             <td>@foreach($timesheetData as $timesheetDatas) {{ $timesheetDatas->assignment_name ??''}}
                             @endforeach
                             </td>          
                                </tr>
                                <tr>
                                    <td><b>Work Item : </b></td>
                                    <td>{{ $timesheet->workitem}}</td>
                                    <td><b>Status :</b></td>
                                    <td>{{$timesheet->billable_status }}</td>
                                </tr>
                                <tr>
                                    <td><b>Hour :</b></td>
                                    <td>{{$timesheet->hour }}</td>
                                    <td><b></b>Createdby</td>
                                    <td>{{ App\Models\Teammember::select('team_member')->where('id',$timesheet->createdby)->first()->team_member ?? ''}}</td>
                                </tr>
                            </tbody>
                        </table>
                          
                            <div class="form-group">
                               
                                <a class="btn btn-secondary" href="{{ url('timesheet') }}">
                                    Back</a>
                           
                           
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
						   <a onclick="myFunction()" style="margin-right: 243px;color:#37A000;">View Trail</a>
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
