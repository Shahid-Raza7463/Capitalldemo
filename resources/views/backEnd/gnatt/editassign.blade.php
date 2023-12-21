@extends('backEnd.layouts.layout') @section('backEnd_content')
<!--Content Header (Page header)-->

<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">Edit Staff Assign</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="@if(Request::is('gnattchart/editassign/*'))
{{ url('gnattchart/assign/update/'.$id) }} @endif" enctype="multipart/form-data">

                        @csrf
                        @component('backEnd.components.alert')

                        @endcomponent
                        <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Client Name</label>
                                    <select class="form-control" name="clientname"
                                    @if(Request::is('gnattchart/editassign/*'))> <option disabled style="display:block">Please Select One
                                    </option>
                    
                                    @foreach($ganttcharts as $clientData)
                                    <option value="{{$clientData->id}}"
                                        {{$assign->clientname == $clientData->id??'' ?'selected="selected"' : ''}}>
                                        {{$clientData->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Staff</label>
                                    <select class="form-control" id="client" name="ganttstaff_id"
                                    @if(Request::is('gnattchart/editassign/*'))> <option disabled style="display:block">Please Select One
                                    </option>
                    
                                    @foreach($ganttstaffs as $ganttstaffData)
                                    <option value="{{$ganttstaffData->id}}"
                                        {{$assign->ganttstaff_id == $ganttstaffData->id??'' ?'selected="selected"' : ''}}>
                                        {{$ganttstaffData->team_member }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Start Date</label>
                                    <input type="date" name="startdate" value="{{ $assign->startdate ?? ''}}" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">End Date</label>
                                    <input type="date" name="enddate" value="{{ $assign->enddate ?? ''}}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
                            <a class="btn btn-secondary" href="{{ url('gnattchart/assignlist') }}">
                                Back</a>
                        
                        </div>

                    </form>
                    <hr class="my-4">

                </div>
            </div>
        </div>
    </div>
</div>
<!--/.body content-->

@endsection

<!--Page Active Scripts(used by this page)-->
<script src="{{ url('backEnd/dist/js/pages/forms-basic.active.js')}}"></script>
<!--Page Scripts(used by all page)-->
<script src="{{ url('backEnd/dist/js/sidebar.js')}}"></script>
