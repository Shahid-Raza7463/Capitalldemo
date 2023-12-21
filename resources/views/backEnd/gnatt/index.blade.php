 <style>
     .SumoSelect
     {
        width: 151px;
     }
 </style>
@extends('backEnd.layouts.layout') @section('backEnd_content')
<!--Third party Styles(used by this page)--> 
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>

<!--Third party Styles(used by this page)--> 
<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">
<link href="{{ url('backEnd/dist/css/select.css')}}" rel="stylesheet" type="text/css">

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
   
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Calendar</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="card mb-4">
        @if(Auth::user()->role_id == 11 || Auth::user()->role_id == 12 || Auth::user()->teammember_id == 23)
        <div class="card-header">
            @component('backEnd.components.alert')

            @endcomponent   
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 font-weight-600 mb-0"><a data-toggle="modal" data-target="#exampleModal1">Add Excel <i class="fas fa-file-excel" style="margin-left: 3px;font-size: 20px;"></i></a></h6>
                </div>
            </div>
        </div>
        @endif
        <div class="card-body">
            <div class="row">
              
                <div class="col-lg-12 col-xl-4">
                    @if(Auth::user()->role_id == 11 || Auth::user()->role_id == 12 || Auth::user()->teammember_id == 23)
                    <div class="card mb-4">
                      
                        <div class="card-body">
                            <div id='external-events'>
                                <h4 class="fs-19 mb-3">Users  <a href=" {{ url('gnattchart')}}" style="margin-right: 35px;float: right;" class="action-item"><i class="ti-reload"></i></a></h4>
                              
                                <form method="post" action=" {{ url('gnattchart/store')}}"
                                 enctype="multipart/form-data">
                                @csrf
                                <div id='external-events-list'>
                                    <select class="search_test" id="exampleFormControlSelect1" name="title_id"
                                  >
                                    <option value="">Please Select One</option>
                                    @foreach($staff as $staffData)
                                    <option value="{{$staffData->id}}">
                                        {{ $staffData->team_member }}</option>
                    
                                    @endforeach
                                </select> <button type="submit" style="margin-top: -11px;height: 35px;" class="btn btn-info-soft btn-md"><i class="fas fa-search"></i></button>
                                   </form>
                                <br>
                                <br>
                                <h4 class="fs-19 mb-3">Client <a data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fa fa-plus" style="margin-left: 3px;font-size: 20px;"></i></a></h4>
                                <form method="post" action=" {{ url('gnattchart/store')}}"
                                enctype="multipart/form-data">
                               @csrf
                                <select class="search_test" id="exampleFormControlSelect1" name="client"
                              > 
                                <option></option>
                                <option value="">Please Select One</option>
                                @foreach($client as $clientData)
                                <option value="{{$clientData->id}}">
                                    {{ $clientData->name }}</option>
                
                                @endforeach
                               
                            </select> <button type="submit" style="margin-top: -11px;height: 35px;" class="btn btn-info-soft btn-md"><i class="fas fa-search"></i></button>
                                </form>
                        </div>
                                <br>
                               
                            
                            </div>
                        </div>
                    </div>
                    @endif
                    @if( count($tasks) > 0)
                    <div class="card mb-4">
    
                        <div class="card-body">
                            @component('backEnd.components.alert')
                
                            @endcomponent   
                            <div class="table-responsive">
                                <table class="table display table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tasks as $task)
                                        <tr>
                                            <td>{{$task->name }}</td>
                                            <td>{!! $task->startdate !!}</td>
                                            <td>{!! $task->enddate !!}</td>
                                          
                                        </tr>
                                      @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                </div>
              
                <div class="col-lg-12 col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <!-- calender -->
                            <div id='calendar'></div>
                        </div>
                    </div>
                </div>
            </div>
        
        </div>
    </div>

</div><!--/.body content-->
<script>
    $(document).ready(function() {
        // page is now ready, initialize the calendar...
        $('#calendar').fullCalendar({
            // put your options and callbacks here
            events : [
                @foreach($tasks as $task)
                {
                    title : '{{ $task->name }}',
                    start : '{{ $task->startdate ??''}}',
                    end : '{{ $task->enddate ??''}}', 
                    color : '{{ $task->color}}'
                },
                @endforeach
            ]
        })
    });
    </script>
     <!-- Third Party Scripts(used by this page)-->
      <script src="{{ url('backEnd/plugins/select2/dist/js/select2.min.js')}}"></script>
      <script src="{{ url('backEnd/plugins/jquery.sumoselect/jquery.sumoselect.min.js')}}"></script>
      <!--Page Active Scripts(used by this page)-->
      <script src="{{ url('backEnd/dist/js/pages/demo.select2.js')}}"></script>
      <script src="{{ url('backEnd/dist/js/pages/demo.jquery.sumoselect.js')}}"></script>
      <script src="{{ url('backEnd/dist/js/pages/newsletter.active.js')}}"></script>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="detailsForm" method="post" action="{{ url('ganttchart/upload')}}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-600" id="exampleModalLabel4">Add Excel</h5>
                        <div >
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
                                     <label for="name" class="col-sm-3 col-form-label font-weight-600">Upload Excel:</label>
                                <div class="col-sm-9">
                                    <input id="name" class="form-control" name="file" type="file">
                                </div>
                                   
                            </div> 
                        
                            <div class="details-form-field form-group row">
                            <label for="address" class="col-sm-3 col-form-label font-weight-600">Sample Excel:</label>
                            <div class="col-sm-9">
                                <a href="{{ url('backEnd/kgsomaniclientt.xlsx')}}" 
                                class="btn btn-success btn"  >Download<i class="fas fa-file-excel" style="margin-left: 3px;font-size: 20px;"></i></a>
                           
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
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width:50%;">
                <div class="modal-content">
                    <form id="detailsForm" method="post" action="{{ url('ganttchart/client/store')}}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-600" id="exampleModalLabel4">Add Client</h5>
                        <div >
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
                                     <label for="name" class="col-sm-2 col-form-label font-weight-600">Name:</label>
                                <div class="col-sm-10">
                                    <select class=" form-control" id="exampleFormControlSelect1" name="clientname"
                                   >
                                    <option value="">Please Select One</option>
                                    @foreach($client as $clientData)
                                    <option value="{{$clientData->id}}">
                                        {{ $clientData->name }}</option>
                    
                                    @endforeach
                                </select>
                                </div>
                                   
                            </div>
                            <div class="field_wrapper">
                                <div class="row row-sm">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="font-weight-600">Start Date</label>
                                            <input type="date" class="form-control key" name="startdate[]" id="key" value=""
                                                placeholder="Enter Start Date">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="font-weight-600">End Date *</label>
                                            <input type="date" class="form-control key" name="enddate[]" id="key" value=""
                                                placeholder="Enter End Date">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="form-group">
                                            <label class="font-weight-600"> Staff *</label>
                                            <select  class="form-control key" name="ganttstaff_id[]" id="key" value="" id="exampleFormControlSelect1">
                                               >
                                                <option></option>
                                                <option value="">Please Select One</option>
                                                @foreach($staff as $clientData)
                                                <option value="{{$clientData->id}}">
                                                    {{ $clientData->team_member }} ( {{ $clientData->role->rolename }} )</option>
                                
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                            
                                    <div class="col-1">
                                        <div class="form-group" style="margin-top: 36px;">
                                            <a href="javascript:void(0);" class="add_button" title="Add field"><img
                                                    src="{{ url('backEnd/image/add-icon.png')}}" /></a>
                                        </div>
                                    </div>
                            
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
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = '<div class="row row-sm "><div class="col-3"><div class="form-group"><label class="font-weight-600">Start Date </label><input type="date" class="form-control key" name="startdate[]" id="key" value=""  placeholder="Enter Document Name"></div></div><div class="col-3"> <div class="form-group"> <label class="font-weight-600">End Date * </label>  <input type="date" class="form-control key" name="enddate[]" id="key" value=""  placeholder="Enter Document Name"> </div> </div><div class="col-5"> <div class="form-group"> <label class="font-weight-600"> staff </label><select class="form-control key" name="ganttstaff_id[]" id="key" value="" id="exampleFormControlSelect1"><option></option> <option value="">Please Select One</option> @foreach($staff as $clientData) <option value="{{$clientData->id}}"> {{ $clientData->team_member }} ( {{ $clientData->role->rolename }} )</option> @endforeach</select> </div> </div><a style="margin-top: 36px;" href="javascript:void(0);" class="remove_button"><img src="{{ url('backEnd/image/remove-icon.png')}}"/></a></div></div>'; //New input field html 
        var x = 1; //Initial field counter is 1
        
        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){ 
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });
        
        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });
    </script>

