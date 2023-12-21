
@extends('student.layouts.layout') @section('student_content')

@php

 $time = explode(':',$examtime->time);
@endphp
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
    @php
                    $i=1;
                    @endphp
   
                <br>
                <h2 style="text-align:center;"><b>Test Paper</b></h2>
                <hr>
                 <div class="card-body">
         
                    <h2 class="text-right time">{{$examtime->time}}</h2>
                    <br>
                    <form method="post" action="{{route('studentexam.store')}}" id="exam-form1" enctype="multipart/form-data">
                    @csrf
                    <input name="studentid" hidden value="{{auth()->user()->id}}" type="text">
                   
                    @foreach($question as $questionData)
                            
                            <h5><strong>Q.{{$i++}}&nbsp;&nbsp;
                            {{$questionData->question }}</h5>
                            <input name="question[]" hidden value="{{$questionData->id}}">
                          
    @php
        $answerData = DB::table('questions')
        ->leftjoin('answers','answers.question_id','questions.id')
        ->where('questions.id',$questionData->id)->select('questions.*','answers.answer','answers.id')
        ->get();
           //  dd($answerData); 
     @endphp
     @php
                $ia=0;
                @endphp
              
                             <div class="row">
                             <input name="answer_{{$i-1}}" hidden type="text" id="answer_{{$i-1}}">
                             @foreach($answerData as $answerDatas)
                           
                            <div class="col-lg-6">
                           
                                <input name="radio_{{$i-1}}" value="{{$answerDatas->id}}" type="radio" data-id="{{$i-1}}" class="select_ans">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <small style="font-size:16px;">{{$answerDatas->answer??''}}</small>
                              
                            </div>
                            <br>
                            @endforeach
                        </div>
                        <br>
                        <br>
                        @endforeach
                        <br><br>
 
 <!-- <div class="text-center">
     <input type="submit" class="ml-auto btn btn-main-primary pd-x-20 mg-t-10">

</div> -->
       <div class="card-footer text-center">
        <input type="submit" style="float:center;" class="btn btn-fill btn-primary">
        </div>

</form>
</div>
            </div>
        </div>
  
<!--/.body content-->
@endsection
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>


<script>
    $(document).ready(function(){
     
     $('.select_ans').click(function(){
       var no = $(this).attr('data-id');
       $('#answer_'+no).val($(this).val());
     });
    
    var time = @json($time);
    $('.time').text(time[0]+':'+time[1]+':00');

    var seconds = 60;
    var hours = parseInt(time[0]);
    var minutes = parseInt(time[1]);

    var timer = setInterval(() => {

        if(hours == 0 && minutes == 0 && seconds == 0){
          clearInterval(timer);
          $('#exam-form1').submit();
        }
        console.log(hours+" -:- "+minutes+" -:- "+seconds);

        if(seconds <= 0){
        minutes--;
        seconds = 60;
        }
        if(minutes <= 0 && hours !=0){
        hours--;
        minutes = 59;
        seconds = 60;
        }

        let tempHours = hours.toString().lenght > 1? hours:'0'+hours;
        let tempMinutes = minutes.toString().lenght > 1? minutes:'0'+minutes;
        let tempSeconds = seconds.toString().lenght > 1? seconds:'0'+seconds;

        $('.time').text(hours+':'+minutes+':'+seconds);
        seconds--;
    }, 1000);
      
    });
    function isValid() {
        var result = true;
        var qlength = parseInt("{{$i}}")-1;
      //  alert(qlength);
        $('.error_msg').remove();
        for(let i = 1; i<= qlength; i++){
        if($('#answer_'+i).val() == ""){
            result = false;
            $('#answer_'+i).parent().append('<span style="color:red;" class="error_msg">Please Select Answer.</span>');
            setTimeout(() => {
             $('.error_msg').remove();
            }, 5000);
            
        }
        }
        return result;
    }
</script>