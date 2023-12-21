 <!--Third party Styles(used by this page)--> 
  <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">

@extends('backEnd.layouts.layout') @section('backEnd_content')

<div class="body-content">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header" style="background: #37A000">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 style="color: white;" class="fs-17 font-weight-600 mb-0">TRAVEL REQUEST FORM</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('travelform.store')}}" enctype="multipart/form-data">
                        @csrf
                  @component('backEnd.components.alert')

                  @endcomponent
                        @include('backEnd.travelform.form')
                    </form>
                   
                    <hr class="my-4">

                </div>
            </div>
        </div>
    </div>
</div>
<!--/.body content-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script>
      $(function () {
          $('#client').on('change', function () {
              var cid = $(this).val();
              // alert(category_id);
              $.ajax({
                  type: "get",
                  url: "{{ url('travelform/create') }}",
                  data: "cid=" + cid,
                  success: function (res) {
                      $('#assignment').html(res);
                  },
                  error: function () {},
              });
          });
      });

  </script>
  <script>
      $(function () {
          $('#assignment').on('change', function () {
              var sid = $(this).val();
              // alert(category_id);
              $.ajax({
                  type: "get",
                  url: "{{ url('travelform/create') }}",
                  data: "sid=" + sid,
                  success: function (res) {
                      $('#partener').html(res);
                  },
                  error: function () {},
              });
          });
      });

  </script>
<script>
  $(document).ready(function(){
  $('#modeoftransport').on('change', function() {
    if ( this.value == '0')
    {
      $("#flightfood").show();
      document.getElementById("flightfood").required = true;
       
    }
    
    else if ( this.value == '1')
    {
      $("#flightfood").show();
      document.getElementById("flightfood").required = true;
        
    }
    else
    {
     
      $("#flightfood").hide();
      
    }
  });
});
</script>
<script>
  $(document).ready(function(){
  $('#accomodation').on('change', function() {
    if ( this.value == '0')
    {
      $("#noofhotel").show();
      document.getElementById("noofhotel").required = true; 
      $("#hotellocation").show();
      document.getElementById("hotellocation").required = true; 
      $("#noofrooms").show();
      document.getElementById("noofrooms").required = true; 
      $("#budget").show();
      document.getElementById("budget").required = true; 
      $("#from").show();
      document.getElementById("from").required = true; 
      $("#to").show();
      document.getElementById("to").required = true; 
      $("#plan").show();
      document.getElementById("plan").required = true;  
    }

    else
    {
      $("#noofhotel").hide();
      $("#hotellocation").hide();
      $("#noofrooms").hide();
      $("#budget").hide();
      $("#from").hide();
      $("#to").hide();
      $("#plan").hide();
      
    }
  });
});
</script>
<script type="text/javascript">
  $(document).ready(function(){
      var maxField = 10; //Input fields increment limitation
      var addButton = $('.add_button'); //Add button selector
      var wrapper = $('.field_wrapper'); //Input field wrapper
      var fieldHTML = '<div class="row row-sm "><div class="col-6"><div class="form-group"><label class="font-weight-600">Team Member Name <span style="color:red;">*</span></label><select required class="language form-control" name="member_name[]"<option></option><option value="">Please Select One</option><option value="">Please Select One</option> @foreach($teammember as $teammemberData)<option value="{{$teammemberData->id}}">{{ $teammemberData->team_member }} </option>@endforeach </select></div></div><a style="margin-top: 36px;" href="javascript:void(0);" class="remove_button"><img src="{{ url('backEnd/image/remove-icon.png')}}"/></a></div></div>'; //New input field html 
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
@endsection
