<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <!-- <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('courierinout/create')}}">Add Courier</a>
            </li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav> -->
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Student Exam List</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="card mb-4">

        <div class="card-body">
        <div class="table-responsive example">
                        <div class="table-responsive">
                            <table id="exampleee" class="display nowrap">
                                <thead>
                                    <tr>
                                
                                        <th>Student Name</th>
                                        <th>Total Question</th>
										<th>Total Question Attempt</th>
										<th>Total Obtain Marks</th>
                                        <th>P/F</th>
                                         <th>Action</th>
                                       
                                    </tr>
                                </thead>
                                @php
                                      $question = DB::table('questions')
                                      ->count();
                                   //   dd($questionattempt);
                                      @endphp
                                <tbody>
                                    @foreach($studentlist as $studentlistData)
                                    <tr>
                                      @php
                                      $questionattempt = DB::table('exam_answers')->where('student_id',$studentlistData->studentid)
                                      ->count();
                                      $attemptmark = DB::table('exam_answers')->where('student_id',$studentlistData->studentid)
                                         ->leftjoin('answers','answers.id','exam_answers.answer_id') 
                                         ->select('exam_answers.*','answers.is_correct_answer')
                                      ->get();
                                      $correctans=0;
                                      if($attemptmark!=null)
                                      {
                                     foreach($attemptmark as $attemptmarks)
                                     {
                                         if($attemptmarks->is_correct_answer==1)
                                         $correctans=$correctans+1;
                                     }
                                    }
                                  //    dd($attemptmark);
                                        
                                  $questionpass = ($correctans * 100)/50 ;
                                 
                                      @endphp
                                        <td>{{$studentlistData->name??''}}</td>
                                        <td>{{$question}}</td>
                                        <td>{{$questionattempt ??''}}</td>
                                        <td>
                                            {{$correctans ??''}}
                                        
                                            </td>
                                        <td>
                                            @if($questionpass < 40)
                                              FAIL
                                            @else
PASS
                                            @endif
                                        
                                            </td>
                                        <td>@if($studentlistData->attempt==1)
                                        <a href="{{url('/examanswer/edit', $studentlistData->studentid)}}">
                                 Review Question</a>
                                            @else
                                                   Not Attempt Exam
                                            @endif
                                            
								 </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
          

           
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
<script>
    $(document).ready(function () {
        $('#exampleee').DataTable({
				"pageLength": 50,
            dom: 'Bfrtip',
            "order": [
                [0, "desc"]
            ],

            buttons: [

                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 5]
                    }
                },
                'colvis'
            ]
        });
    });

</script>
<script>
    $(document).ready(function () {
        $('#examplee').DataTable({
				"pageLength": 50,
            dom: 'Bfrtip',
            "order": [
                [0, "desc"]
            ],

            buttons: [

                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 5]
                    }
                },
                'colvis'
            ]
        });
    });

</script>

