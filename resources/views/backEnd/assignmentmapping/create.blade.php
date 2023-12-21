  <!--Third party Styles(used by this page)-->
  <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">

  @extends('backEnd.layouts.layout') @section('backEnd_content')
      <div class="body-content">
          <div class="row">
              <div class="col-md-12 col-lg-12">
                  <div class="card mb-4">
                      <div class="card-header" style="background: #37A000">
                          <div class="d-flex justify-content-between align-items-center">
                              <div>
                                  <h6 style="color:white;" class="fs-17 font-weight-600 mb-0">Add Assignment Mapping</h6>
                              </div>
                          </div>
                      </div>
                      <div class="card-body">
                          <form method="post" action="{{ route('assignmentmapping.store') }}"
                              enctype="multipart/form-data">
                              @csrf
                              @component('backEnd.components.alert')
                              @endcomponent
                              @include('backEnd.assignmentmapping.form')
                          </form>

                          <hr class="my-4">

                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!--/.body content-->
  @endsection


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


  <script>
      $(document).ready(function() {
          $("#key").change(function() {
              var air_id = $(this).val();
              $("#teammemberrole").val(air_id);
          });
      });
  </script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

  <script type="text/javascript">
      $(document).ready(function() {
          var maxField = 60; //Input fields increment limitation
          var addButton = $('.add_buttonn'); //Add button selector
          var wrapper = $('.field_wrapper'); //Input field wrapper
          var fieldHTML =
              '<div class="row row-sm "><div class="col-6"><div class="form-group"><label class="font-weight-600">Name</label><select class="language form-control" name="teammember_id[]" id="key"><option>Please Select One</option>@foreach ($teammember as $teammemberData)<option value="{{ $teammemberData->id }}" @if (!empty($store->financial) && $store->financial == $teammemberData->id) selected @endif>  {{ $teammemberData->team_member }} ( {{ $teammemberData->role->rolename }} ) ( {{ $teammemberData->staffcode }} )</option>@endforeach</select></div></div><div class="col-5"><div class="form-group"><label class="font-weight-600">Type</label><select class="form-control key" name="type[]" id="key"><option>Please Select One</option><option value="0">Team Leader</option><option value="2">Staff</option></select></div></div><a style="margin-top: 36px;" href="javascript:void(0);" class="remove_button"><img src="{{ url('backEnd/image/remove-icon.png') }}" /></a></div></div>'; //New input field html 
          var x = 1; //Initial field counter is 1

          // Initialize Select2 for existing select boxes
          $('.language').select2();

          // Once add button is clicked
          $(addButton).click(function() {
              // Check maximum number of input fields
              if (x < script maxField) {
                  x++; // Increment field counter
                  $(wrapper).append(fieldHTML); // Add field html
                  // Initialize Select2 for the newly added select box
                  $(wrapper).find('.language').select2();
              }
          });

          // Once remove button is clicked
          $(wrapper).on('click', '.remove_button', function(e) {
              e.preventDefault();
              $(this).parent('div').remove(); // Remove field html
              x--; // Decrement field counter
          });
      });
  </script>
  {{-- get this data from AssignmentmappingController/create methode --}}
  <script>
      $(function() {
          $('#category').on('change', function() {
              var category_id = $(this).val();
              console.log(category_id);
              $.ajax({
                  type: "GET",
                  url: "{{ url('assignmentmapping/create') }}",
                  data: "category_id=" + category_id,
                  success: function(res) {
                      $('#subcategory_id').html(res);
                  },
                  error: function() {

                  },
              });
          });
      });
  </script>
