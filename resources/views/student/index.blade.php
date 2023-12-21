 <!--Third party Styles(used by this page)-->
 <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">

 @extends('student.layouts.layout') @section('student_content')
 <style>
     .table-bordered td,
     .table-bordered th {
         word-break: break-all;
     }
 </style>
 <!--Content Header (Page header)-->
 <div class="content-header row align-items-center m-0">
     <div class="col-sm-8 header-title p-0">
         <div class="media">
             <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
             <div class="media-body">
                 <h1 class="font-weight-bold">Home</h1>
                 <small>Exam</small>
             </div>
         </div>
     </div>
 </div>
 <!--/.Content Header (Page header)-->
 <div class="body-content">
     <div class="card mb-4">
         <div class="card-header" style="background:#37A000 ">


             <h6 class="fs-17 font-weight-600 mb-0" style="color:white;text-align:center;">
                 <span>Question Paper Specific Instructions</span>

             </h6>
             <div class="d-flex justify-content-between">

                 <div>
                 </div>

             </div>
         </div>
         <div class="card-body">
             <h3 style="color:red; font-size:18px;">Please read each of the following instruction carefully before
                 attempting question:</h3>
             <br>
             <p style="color:#0099ca;font-size:16px;">
                 1. Candidate will have 90 minutes for completing the Test. Please make sure you complete it in
                 stipulated time else it will be submitted &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;automatically.
             </p>
             <p style="color:#0099ca;font-size:16px;">
                 2. Your test contains multiple choice questions with only one answer. There are total 50 questions
             </p>
             <p style="color:#0099ca;font-size:16px;">
                 3. Candidate may review and Edit their answer before final Submission.
             </p>
             <p style="color:#0099ca;font-size:16px;">
                 4. Candidate have to ensure that there may not be any Network issues during the Test.
             </p>
             <p style="color:#0099ca;font-size:16px;">
                 5. There is no Negative marking for wrong answer.
             </p>
             <p style="color:#0099ca;font-size:16px;">
                 6. Candidates are not allowed to re-login.
             </p>
             <p style="color:#0099ca;font-size:16px;">
                 7. Candidate can Finish this test any time using 'Submit' button.
             </p>
             <p style="color:#0099ca;font-size:16px;">
                 8. Candidate can see their Result just after submitting the Test.
             </p>
             <p style="color:#0099ca;font-size:16px;">
                 9. Passing criteria would be 40%.
             </p>
             <br>
             <p style="color:#0099ca;font-size:16px; text-align:center;">
                 Thanks and wish you luck.
             </p>
             <div class="card-footer text-center">
                 <a class="btn btn-success ml-2" style="font-size:18px;" href="{{ url('students/studentexam') }}">Start
                     Exam</a>

             </div>
         </div>
     </div>

 </div>

 @endsection