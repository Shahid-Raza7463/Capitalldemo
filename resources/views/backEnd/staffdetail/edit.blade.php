  <!--Third party Styles(used by this page)--> 
  <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">
  
@extends('backEnd.layouts.layout') @section('backEnd_content')
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header" style="background: #37A000">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 style="color:white;" class="fs-17 font-weight-600 mb-0">Edit Assignmentbudgeting</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('assignmentbudgeting.update', $assignmentbudgeting->id)}}"
                        enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                        @component('backEnd.components.alert')

                        @endcomponent
                        <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Billing Frequency</label>
                                    <select class="form-control" id="exampleFormControlSelect1" name="billingfrequency"
                                        @if(Request::is('assignmentbudgeting/*/edit'))>
                                        @if($assignmentbudgeting->billingfrequency=='0')
                                        <option value="0">Monthly</option>
                                        <option value="1">Quarterly</option>
                                        <option value="2">Half Yearly</option>
                                        <option value="3">Yearly</option>
                                        @elseif($assignmentbudgeting->billingfrequency=='1')
                                        <option value="1">Quarterly</option>
                                        <option value="0">Monthly</option>
                                        <option value="2">Half Yearly</option>
                                        <option value="3">Yearly</option>
                                        @elseif($assignmentbudgeting->billingfrequency=='2')
                                        <option value="2">Half Yearly</option>
                                        <option value="1">Quarterly</option>
                                        <option value="0">Monthly</option>
                                        <option value="3">Yearly</option>
                                        @else
                                        <option value="3">Yearly</option>
                                        <option value="2">Half Yearly</option>
                                        <option value="1">Quarterly</option>
                                        <option value="0">Monthly</option>
                                        @endif
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Billing Amount</label>
                                    <input type="text" name="billlingamount"
                                        value="{{ $assignmentbudgeting->billlingamount ?? ''}}" class=" form-control"
                                        placeholder="Enter Billing Amount">
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Due Date</label>
                                    <input type="date" id="example-date-input" name="duedate"
                                        value="{{ $assignmentbudgeting->duedate ?? ''}}" class=" form-control"
                                        placeholder="Enter Date">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Draft Report Date</label>
                                    <input type="date" id="example-date-input" name="draftreportdate"
                                        value="{{ $assignmentbudgeting->draftreportdate ?? ''}}" class=" form-control"
                                        placeholder="Enter Billing Amount">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Bill Date</label>
                                    <input type="date" id="example-date-input" name="billdate"
                                        value="{{ $assignmentbudgeting->billdate ?? ''}}" class=" form-control"
                                        placeholder="Enter Date">
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Final Report Date</label>
                                    <input type="date" id="example-date-input" name="finalreportdate"
                                        value="{{ $assignmentbudgeting->finalreportdate ?? ''}}" class=" form-control"
                                        placeholder="Enter Date">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Money Received Date</label>
                                    <input type="date" id="example-date-input" name="moneyreceiveddate"
                                        value="{{ $assignmentbudgeting->moneyreceiveddate ?? ''}}" class=" form-control"
                                        placeholder="Enter Date">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
                            <a class="btn btn-secondary" href="{{ url('assignmentbudgeting') }}">
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
