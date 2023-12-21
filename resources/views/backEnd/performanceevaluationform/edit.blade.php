 <!--Third party Styles(used by this page)--> 
 <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">


@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
   
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header" >
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4><strong class="fs-30 font-weight-600 mb-0" style="color:rgb(0,31,95); line-height:10px;">K G SOMANI & CO. LLP</strong></h4>
                                 <small style="color:rgb(0,31,95); font-size:12px;">
                                 Formerly K G Somani & Co
                                </small><br><br>
                    <h4 style="color:green;" class="fs-24 font-weight-600 mb-0">PERFORMANCE EVALUATION FORM</h4>
                  <strong><h4 style="color:black;" class="fs-16 font-weight-600 mb-0">REVIEW PERIOD – April 2022 to March 2023</h4></strong>
                </div>
                    </div>
                </div>
                <div class="card-body">
                <form method="post" action="{{ route('performanceevaluationform.update', $performanceevaluation->id)}}"  enctype="multipart/form-data">
                        @method('PATCH') 
                        @csrf            
                        @component('backEnd.components.alert')

                        @endcomponent   
                        @include('backEnd.performanceevaluationform.form')
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script>
      $(document).ready(function(){
       
        var count = 1;
        
        $(document).on('click', '#add_row', function(){
          count++;

          var html_code = '';
          html_code += '<tr id="row_id_'+count+'">';
          html_code += '<td><span id="sr_no">'+count+'</span></td>';
          html_code += '<td><input type="text" name="key_responsibility[]" id="key_responsibility'+count+'" data-srno="'+count+'" class="form-control" placeholder="Enter key Responsibility" /></td>';
          html_code += '<td><input type="text" name="outcome_achievement[]" id="outcome_achievement'+count+'" data-srno="'+count+'" class="form-control" placeholder="Enter Outcome Achievement"/></td>';
          html_code += '<td><input type="number" name="self_rating[]" id="self_rating'+count+'" data-srno="'+count+'" class="form-control" placeholder="Enter Self Rating"/></td>';
          html_code += '<td><input type="number" name="reporting_rating[]" id="reporting_rating'+count+'" data-srno="'+count+'" class="form-control" placeholder="Enter Reporting Manager Rating"/></td>';
          html_code += '<td><button type="button" name="remove_row" id="'+count+'" class="btn btn-danger btn-xs remove_row">X</button></td>';
          html_code += '</tr>';
          $('#performanceevaluation').append(html_code);
        });
        
        $(document).on('click', '.remove_row', function(){
          var row_id = $(this).attr("id");
          $('#row_id_'+row_id).remove();
          count--;
       //   $('#total_item').val(count);
        });
      });
    
</script>
<script>
    $(document).ready(function() {
    var count = 1;

    // Attach click event to table for all future remove buttons
    $('#performancesector').on('click', '.remove_row1', function() {
        var row_id = $(this).attr('id');
        $('#row_id_' + row_id).remove();
        count--;
        // $('#total_item').val(count);
    });

    $(document).on('click', '#add_row1', function() {
        count++;

        var html_code = '';
        html_code += '<tr id="row_id_' + count + '">';
        html_code += '<td><span id="sr_no">' + count + '</span></td>';
        html_code +=
            '<td><input type="text" name="development[]" id="key_responsibility' +
            count +
            '" data-srno="' +
            count +
            '" class="form-control" placeholder="Enter Development Goals/Purpose" /></td>';
        html_code +=
            '<td><input type="text" name="priority[]" id="outcome_achievement' +
            count +
            '" data-srno="' +
            count +
            '" class="form-control" placeholder="Enter Priority"/></td>';
        html_code +=
            '<td><button type="button" name="remove_row1" id="' +
            count +
            '" class="btn btn-danger btn-xs remove_row1">X</button></td>';
        html_code += '</tr>';
        $('#performancesector').append(html_code);
    });
});

</script>

