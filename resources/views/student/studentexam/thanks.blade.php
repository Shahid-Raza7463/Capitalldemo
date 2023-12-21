 <!--Third party Styles(used by this page)-->
 <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">

 @extends('student.layouts.layout') @section('student_content')
<style>
	.table-bordered td, .table-bordered th {
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
                 <!-- <small>Courier List</small> -->
             </div>
         </div>
     </div>
 </div>
 <!--/.Content Header (Page header)-->
 <div class="body-content">
     <div class="card mb-4">
        
         <div class="card-body">
             <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:600px;">

                 <div class="card-body">

                 <div class="text-center">
                    <h2>Thanks for Submit Your Exam, {{ Auth::user()->name }}</h2>
               
         
                    <a href="{{url('/students/result',auth()->user()->id)}}" class="btn btn-info">Show Result</a>
                      </div>
 
                 </div>
             </div>
         </div>
     </div>

 </div>

 @endsection

