
<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('student.layouts.layout') @section('student_content')


<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <!-- <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('courierinout/create')}}">Add Courier</a>
            </li>
            <li class="breadcrumb-item active">+</li>
        </ol> -->
    </nav>
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
        <div class="row">
        <div class="col-lg-4">
          @php
          $correctcount=0;
foreach($resultreview as $resultreviewData)
{
if($resultreviewData->answerss->is_correct_answer==1)
{
    $correctcount=$correctcount+1;
}
} 
			$questionpass = ($correctcount * 100)/50 ;
 @endphp
        <h2 style="text-align:left; font-size:18px;"><b>Total Question :</b> <b style="color:green;"> {{$totalquestion}}</b>
       <br> <b>Question Attempt :</b> <b style="color:green;"> {{$questionattempt ??''}}</b>
       <br> <b>Total Marks :</b> <b style="color:green;">{{$correctcount ??''}} </b>
       </h2>
        </div>
        <div class="col-lg-4">
                <h2 style="text-align:center; color:#3858f9; font-size:26px;""><b>Your Test Result</b></h2>
                
                </div>
                <div class="col-lg-4">
              @if($questionpass < 40)
                <p style="text-align:right; font-size:18px;""><b>Status :</b> <b style="color:red;">FAIL</b></p>
              @else
                <p style="text-align:right; font-size:18px;""><b>Status :</b> <b style="color:green;">PASS</b></p>
             @endif
                <!-- <p style="text-align:right; font-size:18px;""><b>Status :</b> <b style="color:green;">Pass</b></p> -->
                
                </div>
                </div>
             </div>
                <hr>
                <p style="text-align:center; color:green; font-size:20px;"><b>Correct and incorrect answers are shown below :</b></p>
              
                 <div class="card-body">
                
       
                    @php
                    $i=1;
                    @endphp
                    <div class="row">
                               
                    @foreach($resultreview as $resultreviewData)
                            
                            <h5><strong>Q.{{$i++}}&nbsp;&nbsp;
                            {{$resultreviewData->questionss->question ??''}}</h5>
                            <div class="col-lg-12">
                            <h5><strong>Ans :-&nbsp;
                            <small style="font-size:16px;">{{$resultreviewData->answerss->answer ??''}}</small> &nbsp;
                            @if($resultreviewData->answerss->is_correct_answer==1)
                             <span class="fa fa-close" style="color:green;"><i class="fa fa-check"></i></span>
                             @elseif($resultreviewData->answerss->is_correct_answer==0)
                            <span class="fa fa-close" style="color:red;"><i class="fa fa-times"></i></span>
                                @endif 
                            </h5>
                          </div> <br> 
                        @endforeach
                        
                        </div>  
                        <br>
                        <br> 
 
</div>
            </div>
        </div>
  
<!--/.body content-->
@endsection
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
