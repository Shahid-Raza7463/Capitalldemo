  <!--Third party Styles(used by this page)-->
  <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">


  @extends('backEnd.layouts.layout') @section('backEnd_content')
      <div class="body-content">
          <div class="row">
              <div class="col-md-12 col-lg-12">
                  <div class="card mb-4">
                      <form method="post" action="{{ route('timesheet.store') }}" enctype="multipart/form-data"
                          id="timesheet-form">
                          @csrf
                          <div class="card-header" style="background:#37A000">
                              <div class="d-flex justify-content-between align-items-center">
                                  <div class="col-md-6">
                                      <h6 style="color: white" class="fs-17 font-weight-600 mb-0">Add Timesheet</h6>
                                  </div>
                                  <div class="col-md-1">
                                  </div>
                                  <div class="col-md-5">
                                      <p style="float: right;color: white"><b>Select Date : </b> <input type="text"
                                              id="datepickers" name="date" value="{{ date('d-m-Y') }}" readonly></p>
                                  </div>
                              </div>
                          </div>
                          <div class="card-body">

                              @component('backEnd.components.alert')
                              @endcomponent
                              <div style="
    text-align: center;
"> <span style="color:red;">Please fill timesheet from
                                      11/09/2023, Monday Onwards</span></div>
                              <hr>
                              <br>
                              @include('backEnd.timesheet.form')


                              <hr class="my-4">

                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
      <!--/.body content-->
  @endsection
  {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
      //   $(document).ready(function() {
      $("#timesheet-form").submit(function(e) {
          // Check if the "Client Name" dropdown is selected
          if ($("#client1").val() != "Select Client" && $("#client1").val() != "") {
              // If a client is selected, make the following fields required
              $("#assignment1").prop("required", true);
              $("#partner1").prop("required", true);
              $("#assignment2").prop("required", true);
          }
      });
      //   });
  </script> --}}


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <script type="text/javascript">
      $(document).ready(function() {
          var maxField = 10; //Input fields increment limitation
          var addButton = $('.add_button'); //Add button selector
          var wrapper = $('.field_wrapper'); //Input field wrapper
          var x = 1;

          var fieldHTML =
              '<div class="row row-sm "><div class="col-3"><div class="form-group"><label class="font-weight-600">Client Name</label><select class="language form-control" name="client_id[]" id="client' +
              x +
              '" ><option>Select Client</option>@foreach ($client as $clientData)<option value="{{ $clientData->id }}" @if (!empty($store->financial) && $store->financial == $clientData->id) selected @endif>{{ $clientData->client_name }}</option>@endforeach</select></div></div><div class="col-2"><div class="form-group"><label class="font-weight-600">Assignment Name</label><select class="form-control key" name="assignment_id[]" id="assignment' +
              x +
              '"><option disabled style="display:block">Select Assignment</option></select></div></div><div class="col-2"><div class="form-group"><label class="font-weight-600" style="width:100px;">Work Item </label><input type="text" name="workitem[]" id="key" value="{{ $timesheet->workitem ??
                  '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ' }}" class="form-control key"></div></div><div class="col-2"> <div class="form-group"> <label class="font-weight-600"> Billable Status </label><select class="form-control key" name="billable_status[]" id="key" value="" > <option value="Billable">Billable</option> <option value="Non Billable">Non Billable</option> </select> </div> </div><div class="col-2"><div class="form-group"><label class="font-weight-600">Hour </label><input type="text" class="form-control key" name="hour[]" id="endTime" value="{{ $timesheet->hour ??
                  '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ' }}"></div></div><a style="margin-top: 36px;" href="javascript:void(0);" class="remove_button"><img src="{{ url('
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                backEnd / image / remove - icon.png ') }}"/></a></div></div>'; //New input field html 
          //Initial field counter is 1

          //Once add button is clicked
          $(addButton).click(function() {
              //Check maximum number of input fields
              if (x < maxField) {
                  x++; //Increment field counter
                  $(wrapper).append(fieldHTML); //Add field html
              }
          });

          //Once remove button is clicked
          $(wrapper).on('click', '.remove_button', function(e) {
              e.preventDefault();
              $(this).parent('div').remove(); //Remove field html
              x--; //Decrement field counter
          });
      });
  </script>
  <script type="text/javascript">
      function sum() {

          var hour1 = document.getElementById('hour1').value;
          // alert(hour1);
          var hour2 = document.getElementById('hour2').value;
          var hour3 = document.getElementById('hour3').value;
          var hour4 = document.getElementById('hour4').value;
          var hour5 = document.getElementById('hour5').value;
          //  alert(hour2);
          var result = parseFloat(hour1) + parseFloat(hour2) + parseFloat(hour3) + parseFloat(hour4) + parseFloat(
              hour5);
          //alert(result);
          if (!isNaN(result)) {
              document.getElementById('totalhours').value = result;
          }
      }
  </script>

  {{-- select box validation for timesheet create --}}
  <script>
      $(function() {

          $('#partner1').on('change', function() {
              var patnervaluenew = $(this).val();
              $('.workItem1').prop('required', true);
              $('.location1').prop('required', true);
              $('.hour1').prop('required', true);
          });

          $('#partner2').on('change', function() {
              var patnervaluenew = $(this).val();
              $('.workItem2').prop('required', true);
              $('.location2').prop('required', true);
              $('.hour2').prop('required', true);
          });
          $('#partner3').on('change', function() {
              var patnervaluenew = $(this).val();
              $('.workItem3').prop('required', true);
              $('.location3').prop('required', true);
              $('.hour3').prop('required', true);
          });
          $('#partner4').on('change', function() {
              var patnervaluenew = $(this).val();
              $('.workItem4').prop('required', true);
              $('.location4').prop('required', true);
              $('.hour4').prop('required', true);
          });
          // select client 1
          $('#timesheet-form').on('submit', function(e) {
              var clientvalue = $('#client1').val();
              var assmentvalue = $('#assignment1').val();
              var partnervalue = $('#partner1').val();

              if (clientvalue != "" || clientvalue != "Select Client") {
                  if (assmentvalue == "Select Assignment" || assmentvalue == "") {
                      alert("Please select a assignment");
                      e.preventDefault();
                      $('#assignment1').focus();
                  } else if (partnervalue == "Select Partner" || partnervalue == "") {
                      alert("Please select a partner");
                      e.preventDefault();
                      $('#partner1').focus();
                  }
                  //    else if (partnervalue == "Select Partner" && assmentvalue == "Select Assignment") {
                  //       alert("Please select a partnervalue");
                  //       e.preventDefault();
                  //       $('#assignment1').focus();
                  //   }
              }
          });

          // select client 2
          $('#timesheet-form').on('submit', function(e) {
              var clientvalue2 = $('#client2').val();
              var assmentvalue2 = $('#assignment2').val();
              var partnervalue2 = $('#partner2').val();

              if (clientvalue2 != "" || clientvalue2 != "Select Client") {
                  if (assmentvalue2 == "Select Assignment" || assmentvalue2 == "") {
                      alert("Please select a assignment");
                      e.preventDefault();
                      $('#assignment2').focus();
                  } else if (partnervalue2 == "Select Partner" || partnervalue2 == "") {
                      alert("Please select a partner");
                      e.preventDefault();
                      $('#partner2').focus();
                  }
              }
          });
          // select client 3
          $('#timesheet-form').on('submit', function(e) {
              var clientvalue3 = $('#client3').val();
              var assmentvalue3 = $('#assignment3').val();
              var partnervalue3 = $('#partner3').val();
              4
              if (clientvalue3 != "" || clientvalue3 != "Select Client") {
                  if (assmentvalue3 == "Select Assignment" || assmentvalue3 == "") {
                      alert("Please select a assignment");
                      e.preventDefault();
                      $('#assignment3').focus();
                  } else if (partnervalue3 == "Select Partner" || partnervalue3 == "") {
                      alert("Please select a partner");
                      e.preventDefault();
                      $('#partner3').focus();
                  }
              }
          });
          // select client 4
          $('#timesheet-form').on('submit', function(e) {
              var clientvalue4 = $('#client4').val();
              var assmentvalue4 = $('#assignment4').val();
              var partnervalue4 = $('#partner4').val();

              if (clientvalue4 != "" || clientvalue4 != "Select Client") {
                  if (assmentvalue4 == "Select Assignment" || assmentvalue4 == "") {
                      alert("Please select a assignment");
                      e.preventDefault();
                      $('#assignment4').focus();
                  } else if (partnervalue4 == "Select Partner" || partnervalue4 == "") {
                      alert("Please select a partner");
                      e.preventDefault();
                      $('#partner4').focus();
                  }
              }
          });
          // end select client 4
      });
  </script>

  <script>
      $(function() {
          $('#client').on('change', function() {
              var cid = $(this).val();
              // alert(category_id);
              $.ajax({
                  type: "get",
                  url: "{{ url('timesheet/create') }}",
                  data: "cid=" + cid,
                  success: function(res) {
                      $('#assignment').html(res);
                  },
                  error: function() {},
              });
          });
          $('#assignment').on('change', function() {
              var assignment = $(this).val();
              // alert(category_id);
              $.ajax({
                  type: "get",
                  url: "{{ url('timesheet/create') }}",
                  data: "assignment=" + assignment,
                  success: function(res) {
                      $('#partner').html(res);
                  },
                  error: function() {},
              });
          });
      });
  </script>
  <script>
      $(function() {

          $('#client1').on('change', function() {
              var cid = $(this).val();


              $.ajax({
                  type: "get",
                  url: "{{ url('timesheet/create') }}",
                  data: "cid=" + cid,
                  success: function(res) {
                      $('#assignment1').html(res);
                  },
                  error: function() {},
              });

          });

          $('#assignment1').on('change', function() {
              var assignment = $(this).val();

              $.ajax({
                  type: "get",
                  url: "{{ url('timesheet/create') }}",
                  data: "assignment=" + assignment,
                  success: function(res) {
                      $('#partner1').html(res);
                  },
                  error: function() {},
              });
          });
      });
  </script>
  <script>
      $(function() {
          $('#client2').on('change', function() {
              var cid = $(this).val();

              $.ajax({
                  type: "get",
                  url: "{{ url('timesheet/create') }}",
                  data: "cid=" + cid,
                  success: function(res) {
                      console.log(res);
                      $('#assignment2').html(res);
                  },
                  error: function() {},
              });
          });
          $('#assignment2').on('change', function() {
              var assignment = $(this).val();
              $.ajax({
                  type: "get",
                  url: "{{ url('timesheet/create') }}",
                  data: "assignment=" + assignment,
                  success: function(res) {
                      $('#partner2').html(res);
                  },
                  error: function() {},
              });
          });
      });
  </script>
  <script>
      $(function() {
          $('#client3').on('change', function() {
              var cid = $(this).val();


              $.ajax({
                  type: "get",
                  url: "{{ url('timesheet/create') }}",
                  data: "cid=" + cid,
                  success: function(res) {
                      $('#assignment3').html(res);
                  },
                  error: function() {},
              });
          });
          $('#assignment3').on('change', function() {
              var assignment = $(this).val();

              $.ajax({
                  type: "get",
                  url: "{{ url('timesheet/create') }}",
                  data: "assignment=" + assignment,
                  success: function(res) {
                      $('#partner3').html(res);
                  },
                  error: function() {},
              });
          });
      });
  </script>
  <script>
      $(function() {
          $('#client4').on('change', function() {
              var cid = $(this).val();

              $.ajax({
                  type: "get",
                  url: "{{ url('timesheet/create') }}",
                  data: "cid=" + cid,
                  success: function(res) {
                      $('#assignment4').html(res);
                  },
                  error: function() {},
              });
          });
          $('#assignment4').on('change', function() {
              var assignment = $(this).val();


              $.ajax({
                  type: "get",
                  url: "{{ url('timesheet/create') }}",
                  data: "assignment=" + assignment,
                  success: function(res) {
                      $('#partner4').html(res);
                  },
                  error: function() {},
              });
          });
      });
  </script>


  <script>
      $(function() {
          $('input[name="daterange"]').daterangepicker({
              opens: 'left'
          }, function(start, end, label) {
              console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end
                  .format('YYYY-MM-DD'));
          });
      });
  </script>


  <!--Page Active Scripts(used by this page)-->
  <script src="{{ url('backEnd/dist/js/pages/forms-basic.active.js') }}"></script>
  <!--Page Scripts(used by all page)-->
  <script src="{{ url('backEnd/dist/js/sidebar.js') }}"></script>
