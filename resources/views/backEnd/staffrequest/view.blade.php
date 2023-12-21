@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('staffrequest/create')}}">Add staffrequest</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>staffrequest
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
            <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:550px;">
                <div class="card-body">
					       @if(Auth::user()->role_id == 11)
                    <b style="margin-top: -17px;"><a onclick="return confirm('Are you sure you want to delete this item?');"
                        href="{{url('staffrequest/delete', $staffrequest->id)}}" 
                        class="btn btn-info-soft btn-sm"><i class="far fa-trash-alt"></i></a></b>
                        @endif
					 <div class="card-head" style="width:930px;height: 10px;"><a  data-toggle="modal" data-target="#exampleModal1">
                        <b style="float:right;margin-top: -17px;">View Log</b></a>
                    </div>
                    <fieldset    class="form-group">

                        <table class="table display table-bordered table-striped table-hover">

                            <tbody>

                                <tr>
                                    <td><b>Client Name : </b></td>
                                    <td>{{ DB::table('ganttcharts')->select('name')->where('id',$staffrequest->ganttchart_id)->first()->name ?? ''}}</td>

                                    <td><b>No Of Staff :</b></td>
                                    <td>{{ $staffrequest->noofstaff}}</td>

                                </tr>
                                <tr>
                                    <td><b>Start Date : </b></td>
                                    <td>{{ date('F d,Y', strtotime($staffrequest->startdate)) }}</td>
                                    <td><b>End Date :</b></td>
                                    <td>{{ date('F d,Y', strtotime($staffrequest->enddate)) }}</td>

                                </tr>
                               
                                <tr>
                                    <td><b>Reason  : </b></td>
                                    <td>{{ $staffrequest->comment}}</td>
                                     <td></td>
                                     <td></td>
                                </tr>
                                 
                               

                            </tbody>
                           
                        </table>
                        <div class="card mb-4" >
                           
                            <div class="card-body">
                                <form method="post" action="{{ url('staffrequest/complete')}}" enctype="multipart/form-data">
                                    @csrf
                              @component('backEnd.components.alert')
            
                              @endcomponent
                                <div class="row row-sm">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="font-weight-600"> Client *</label>
                                        <select class="form-control" id="exampleFormControlSelect1" name="clientname"
                                        
                                         @if(Request::is('viewstaff/*'))> <option disabled
                                         style="display:block">Please Select One</option>
                         
                                         @foreach($client as $clientData)
                                         <option value="{{$clientData->id}}"
                                             {{$staffrequest->ganttchart_id == $clientData->id??'' ?'selected="selected"' : ''}}>
                                             {{$clientData->name }}</option>
                                         @endforeach
                                        @endif             
                         
                                     </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="font-weight-600"> Status *</label>
                                        <select name="status" id="exampleFormControlSelect1" class="form-control">
                                            <!--placeholder-->
                                            @if(Request::is('viewstaff/*')) >
                                            @if($staffrequest->status=='0')
                                            <option value="0">Pending</option>
                                            <option value="1">Approved</option>
                                            <option value="2">Reject</option>
                            
                                            @elseif($staffrequest->status=='1')
                                            <option value="1">Approved</option>
                                            <option value="2">Reject</option>
                                            <option value="0">Pending</option>
                            
                                            @endif
                                            @else
                                            <option value="2">Reject</option>
                                            <option value="1">Approved</option>
                                            <option value="0">Pending</option>

                                            @endif
                                        </select>
                                        <input type="text" hidden name="rid" value="{{ $id }}"
                                        class="form-control" placeholder="Enter Associated From">
                                    </div>
                                </div>
                           
                              </div>
									@if(Auth::user()->role_id == 11 || Auth::user()->id == 27 || Auth::user()->role_id == 18)
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
									@endif
                              @if($staffrequest->status == 0)
                            <div class="form-group">
                                <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
                                <a class="btn btn-secondary" href="{{ url('staffrequest') }}">
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
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
         
                <div class="modal-header">
                    <h5 class="modal-title font-weight-600" id="exampleModalLabel4">Staffrequest log</h5>
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
                    <div class="table-responsive">

                        <table class="table display table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Teammember</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stafflog as $stafflogdata)
                              <tr>
                                  <td>{{ $stafflogdata->description ??''}}</td>
                                  <td>{{ $stafflogdata->team_member ??''}}</td>
                                  <td>{{ date('F d,Y', strtotime($stafflogdata->created_at)) }}   {{ date('h:i A', strtotime($stafflogdata->created_at)) }}</td>
                              </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
           
        </div>
    </div>
</div>
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