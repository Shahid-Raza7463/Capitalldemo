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
                <div class="card-header" style="background: #37A000;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 style="color:white;" class="fs-17 font-weight-600 mb-0">Add Declaration Form</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('declarationform.store')}}" enctype="multipart/form-data">
                        @csrf
                  @component('backEnd.components.alert')

                  @endcomponent
                        @include('backEnd.declarationform.form')
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
<!-- <script type="text/javascript">
    var i = 0;
    $("#add-btn").click(function () {
        ++i;
        $("#declaration").append('<tr><td><input type="text" name="moreFields[' + i +
            '][title]" placeholder="Enter Service" class="form-control" /></td><td><input type="text" name="moreFields[' +
            i +
            '][title]" placeholder="Enter Amount" class="form-control" /></td><td><a type="button" class="remove-tr"><img src="{{ url('
            backEnd / image / remove - icon.png ')}}"/></a></td></tr>');
    });
    $(document).on('click', '.remove-tr', function () {
        $(this).parents('tr').remove();
    });

</script> -->
<script>
      $(document).ready(function(){
       
        var count = 1;
        
        $(document).on('click', '#add_row', function(){
          count++;
          
          var html_code = '';
          html_code += '<tr id="row_id_'+count+'">';
          html_code += '<td><span id="sr_no">'+count+'</span></td>';
          html_code += '<td><input type="text" name="company_name[]" id="order_item_quantity'+count+'" data-srno="'+count+'" class="form-control" placeholder="Enter Names of the Companies" /></td>';
          html_code += '<td><input type="text" name="interest[]" id="order_item_quantity'+count+'" data-srno="'+count+'" class="form-control" placeholder="Enter Nature of interest or concern"/></td>';
          html_code += '<td><input type="text" name="shareholding[]" id="order_item_quantity'+count+'" data-srno="'+count+'" class="form-control" placeholder="Enter Shareholding"/></td>';
          html_code += '<td><input type="date" name="date[]" id="order_item_quantity'+count+'" data-srno="'+count+'" class="form-control" placeholder="Enter Date"/></td>';
          html_code += '<td><button type="button" name="remove_row" id="'+count+'" class="btn btn-danger btn-xs remove_row">X</button></td>';
          html_code += '</tr>';
          $('#declaration').append(html_code);
        });
        
        $(document).on('click', '.remove_row', function(){
          var row_id = $(this).attr("id");
          $('#row_id_'+row_id).remove();
          count--;
          $('#total_item').val(count);
        });
      });
    
</script>

