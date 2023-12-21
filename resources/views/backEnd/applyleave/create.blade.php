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
                                 <h6 style="color: white;" class="fs-17 font-weight-600 mb-0">Add Apply Leave</h6>
                             </div>
                         </div>
                     </div>
                     <div class="card-body">
                         <form method="post" id="formLeaveCreate" action="{{ route('applyleave.store') }}"
                             enctype="multipart/form-data">
                             @csrf
                             @component('backEnd.components.alert')
                             @endcomponent
                             @include('backEnd.applyleave.form')
                         </form>

                         <hr class="my-4">

                     </div>
                 </div>
             </div>
         </div>
     </div>
     <!--/.body content-->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

     <script type="text/javascript">
         //jQuery.noConflict();
         function readURL(input) {
             if (input.files && input.files[0]) {

                 var reader = new FileReader();

                 reader.onload = function(e) {
                     jQuery('#profile-img-tag').attr('src', e.target.result);
                 }
                 reader.readAsDataURL(input.files[0]);
             }
         }
         jQuery("#profile-img").change(function() {
             readURL(this);
         });
     </script>

     <script>
         // Add event listener for 'To' date input
         document.getElementById('to').addEventListener('change', function() {
             var fromDate = new Date(document.getElementById('from').value);
             var toDate = new Date(this.value);

             // Compare the dates
             if (toDate < fromDate) {
                 alert('The "To" date must be greater than the "From" date.');
                 this.value = '';
             }
         });
     </script>
     <script>
         // Function to count the number of words in a string
         function countWords(str) {
             str = str.trim();
             if (str === '') {
                 return 0;
             }
             return str.split(/\s+/).length;
         }

         // Add event listener for form submission
         document.getElementById('formLeaveCreate').addEventListener('submit', function(event) {
             var reasonInput = document.getElementById('reasonleave');
             var reasonValue = reasonInput.value;
             var wordCount = countWords(reasonValue);

             // Check if word count exceeds the limit
             if (wordCount > 10) {
                 alert('The reason for leave should not exceed 10 words.');
                 event.preventDefault(); // Prevent form submission
             }
         });

         // Add event listener for reason input
         document.getElementById('reasonleave').addEventListener('input', function() {
             var reasonValue = this.value;
             var wordCount = countWords(reasonValue);

             // Update word count display
             document.getElementById('wordCount').textContent = wordCount;

             // Check if word count exceeds the limit and show a warning if needed
             if (wordCount > 10) {
                 document.getElementById('wordCount').classList.add('text-danger');
             } else {
                 document.getElementById('wordCount').classList.remove('text-danger');
             }
         });
     </script>

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
 @endsection
