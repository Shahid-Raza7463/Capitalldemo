@extends('backEnd.layouts.layout') @section('backEnd_content')
    <!--Content Header (Page header)-->
    <div class="content-header row align-items-center m-0">

    </div>
    <!--/.Content Header (Page header)-->
    <div class="body-content">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card mb-4">
                    <div class="card-header" style="background: #37A000">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 style="color:white;" class="fs-17 font-weight-600 mb-0">Add Team Member</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('teammember.store') }}" enctype="multipart/form-data">
                            @csrf
                            @component('backEnd.components.alert')
                            @endcomponent
                            @include('backEnd.teammember.form')
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.leaveDate').on('change', function() {
            var leaveDate = $(this);
            var leaveDateValue = leaveDate.val();
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
