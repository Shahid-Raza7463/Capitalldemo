@extends('backEnd.layouts.layout') @section('backEnd_content')
    <!--/.Content Header (Page header)-->
    <div class="body-content">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fs-17 font-weight-600 mb-0">Edit Assignmentmapping</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('assignmentmapping.update', $assignmentmapping->id) }}"
                            enctype="multipart/form-data">
                            @method('PATCH')
                            @csrf
                            @component('backEnd.components.alert')
                            @endcomponent
                            <div class="row row-sm">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="font-weight-600">Period End</label>
                                        <input type="date" name="periodend"
                                            value="{{ $assignmentmapping->periodend ?? '' }}"
                                            class=" form-control leaveDate" placeholder="Enter Perio End">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="font-weight-600">Is Role Over Assignment</label>
                                        <select class="form-control" id="exampleFormControlSelect1" name="roleassignment">

                                            @if (Request::is('assignmentmapping/edit/*'))
                                                >
                                                @if ($assignmentmapping->roleassignment == '1')
                                                    <option value="1">No</option>
                                                    <option value="2">Yes</option>
                                                @else
                                                    <option value="2">Yes</option>
                                                    <option value="1">No</option>
                                                @endif
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row row-sm">

                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="font-weight-600">Est Hours</label>
                                        <input type="text" name="esthours"
                                            value="{{ $assignmentmapping->esthours ?? '' }}" class=" form-control"
                                            placeholder="Enter Est Hours">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="font-weight-600">Std Cost</label>
                                        <input type="text" name="stdcost" value="{{ $assignmentmapping->stdcost ?? '' }}"
                                            class=" form-control" placeholder="Enter Std Cost">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="font-weight-600">Est Cost</label>
                                        <input type="text" name="estcost" value="{{ $assignmentmapping->estcost ?? '' }}"
                                            class=" form-control" placeholder="Enter Est Cost">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
                                <a class="btn btn-secondary" href="{{ url('assignmentmapping') }}">
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
<script src="{{ url('backEnd/dist/js/pages/forms-basic.active.js') }}"></script>
<!--Page Scripts(used by all page)-->
<script src="{{ url('backEnd/dist/js/sidebar.js') }}"></script>

{{-- validation for year only one date  --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.leaveDate').on('change', function() {
            var leaveDate = $('.leaveDate');
            var leaveDateValue = $('.leaveDate').val();
            //  console.log(leaveDateValue);
            var leaveDateGet = new Date(leaveDateValue);
            var leaveyear = leaveDateGet.getFullYear();
            // console.log(startyear);
            var leaveyearLength = leaveyear.toString().length;
            if (leaveyearLength > 4) {
                alert('Enter four digits for the year');
                leaveDate.val('');
            }
        });
    });
</script>
