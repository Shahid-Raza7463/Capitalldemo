@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    @if(Auth::user()->role_id == 15 || Auth::user()->role_id == 14)
   <!-- <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <!--<li class="breadcrumb-item"><a href="{{url('assignmentevaluation/create')}}">Add Assignment Evaluation</a></li>
            <li class="breadcrumb-item active">+</li>
            
        </ol>
    </nav>-->
    @endif

    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Performance Appraisal List</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="card mb-4">

        <div class="card-body">
            @component('backEnd.components.alert')

            @endcomponent
           <div class="table-responsive">
                <table id="example"  class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            
                            <th>Employee Name</th>
							                      
                             <th>Name of Client </th>
                             <th>Name of Assignment </th>
						     <th>Name of Assignment Partner </th>
							
							 <th>Assignment  date </th>
							
                             <th>Status of Assignment Evaluation</th>
                            <th>Evaluation Done By</th>
                             <th>Self Rating</th>
                            @if(auth()->user()->role_id==18||auth()->user()->role_id==11||auth()->user()->role_id==12
                            ||auth()->user()->role_id==13)
                                  <th>Rating By Partner</th>
                            @endif
                            
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appraisal as $appraisals)
									

                        @php
						$appraisaldata= $appraisal = DB::table('invoices')
    ->leftJoin('clients', 'clients.id', '=', 'invoices.client_id')
    ->leftJoin('teammembers', 'teammembers.id', '=', 'invoices.createdby')
    ->leftJoin('assignments', 'assignments.id', '=', 'invoices.assignment_id')
    ->where('invoices.financialyear', '22-23')
    ->where('invoices.assignmentgenerate_id', $appraisals)
    ->select('invoices.*', 'clients.client_name', 'teammembers.team_member', 'assignments.assignment_name', 'invoices.client_id as client_id', 'assignments.assignment_name', 'assignments.id as assignmentid')
  ->first();
					//	dd($appraisaldata);
						
              $assignmentmappingid=DB::table('assignmentmappings')
         // ->where('assignmentgenerate_id',521308508088)
		 ->where('assignmentgenerate_id',$appraisals)
         ->orderBy('created_at','DESC')
          ->select('id')->pluck('id')->first();
            //dd($assignmentmappingid);
        //  $teamids=explode (",",$assignmentmappingid);

        //dd($appraisals->assignmentgenerate_id);
        
           // dd($assignmentmappingid);
      $team = DB::table('assignmentteammappings')
			->join('teammembers','teammembers.id','assignmentteammappings.teammember_id')
    ->where('assignmentmapping_id', $assignmentmappingid)
						->where('teammembers.status',1)
    ->select('teammember_id')
    ->distinct() // add distinct() to remove duplicates
    ->orderBy('assignmentteammappings.created_at', 'DESC')
    ->get();

	//dd($team);
         // $teamids=explode(",",$team);
        // echo"<pre>";
         //   print_r($assignmentmappingid);
         // print_r( $team);

                        @endphp
                       
                        @if($assignmentmappingid!=null)
                        @foreach($team as $teams)
						@php
						 $assignmentDatas=DB::table('assignmentevaluations')
                        
                        //->leftjoin('teammembers','teammembers.id','assignmentevaluations.createdby')
                        // ->leftjoin('roles','roles.id','teammembers.role_id')
                        ->where('clients_name',$appraisaldata->client_id)
                        ->where('nature_of_assignment',$appraisaldata->assignmentid)
                        //->where('assignment_partner',$appraisaldata->partner)
						->where('assignmentevaluations.createdby',$teams->teammember_id)
                        ->select('assignmentevaluations.*')
                       ->first();

                      $partner=DB::table('assignmentevaluations')
                        ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
						 ->leftjoin('roles','roles.id','teammembers.role_id')
						->where('clients_name',$appraisaldata->client_id)
                        ->where('nature_of_assignment',$appraisaldata->assignmentid)
                        ->where('assignment_partner',$appraisaldata->partner)
						->where('assignmentevaluations.createdby',$teams->teammember_id) 
						->select('teammembers.team_member','roles.rolename')
						->first();
						
                       
                        $role=DB::table('teammembers')
                            ->join('roles','roles.id','teammembers.role_id')
                            ->where('teammembers.id',$teams->teammember_id)
                            ->select('rolename')->pluck('rolename')
                            ->first();
                           
						@endphp
						
						@if($role!="Partner")
                        <tr>
                            <td>
                            @if($assignmentDatas!=null)
                            <a href="{{url('view/assignmentevaluation/'.$assignmentDatas->id)}}"> 
                                {{App\Models\Teammember::where('id',$teams->teammember_id)
                                ->pluck('team_member')->first() ??''}} ({{$role ??''}})</a>
                            @else
                            
                            {{App\Models\Teammember::where('id',$teams->teammember_id)
                                ->pluck('team_member')->first() ??''}}({{$role ??''}})

                            @endif
                            </td>
							                           
                            
                            <td>{{$appraisaldata->client_name ??''}}</td>
                            <td>{{$appraisaldata->assignment_name ??''}}</td>
							
							
                            <td>  @if($assignmentDatas!=null)
                            {{ $partner->team_member ?? ''}}
                          ({{$partner->rolename ??''}})
                            
                            @endif
                        </td>
	 <td><b>Start Date :</b> {{$assignmentDatas->start_date_of_assignment ??''}} <br><b>End Date :</b>{{$assignmentDatas->end_date_of_assignment ??''}} </td>
                         
                            
                            <td>
                                @if($assignmentDatas==null)
                                <span class="badge badge-pill badge-secondary">Not Submitted</span>
                            @else
                            @if($assignmentDatas->status == '0')
                            <span class="badge badge-pill badge-warning">Pending For Evaluation</span>
                            @endif
                            @if($assignmentDatas->status == '1')
                            <span class="badge badge-pill badge-success">Evaluated</span>
                            @endif
                        	@if($assignmentDatas->status == '3')
                            <span class="badge badge-pill badge-info">Assignment Evaluation Created</span>
                            @endif
                     	   @if($assignmentDatas->status == '4')
                            <span class="badge badge-pill badge-secondary">Not Submitted</span>
                            @endif
                       
                            @endif
                        
                            </td>
                            <td>

                            @if($assignmentDatas!=null)
                            {{ $partner->team_member ?? ''}}
                          ({{$partner->rolename ??''}})
                            
                            @endif
                        
                            </td>
                            <td>
                            @if($assignmentDatas!=null)
                            {{ $assignmentDatas->rate_over_all_performance }}/10
                            @endif
                        </td>
                        @if(auth()->user()->role_id==18||auth()->user()->role_id==11||auth()->user()->role_id==12
                            ||auth()->user()->role_id==13)
                           
                            <td>
                               
                                @if($assignmentDatas!=null)
                                {{ $assignmentDatas->rate_over_all_performance_partner }}/10
                                @endif
                                </td>
                                @endif
                           
                        
                        </tr>
						@endif
                        @endforeach
                        @else
						@php
						$appraisaldata= $appraisal = DB::table('invoices')
    ->leftJoin('clients', 'clients.id', '=', 'invoices.client_id')
    ->leftJoin('teammembers', function($join) {
        $join->on('teammembers.id', '=', 'invoices.createdby')
             ->where('teammembers.status', 1); // add where clause to filter based on status
    })
    ->leftJoin('assignments', 'assignments.id', '=', 'invoices.assignment_id')
    ->where('invoices.financialyear', '22-23')
    ->where('invoices.assignmentgenerate_id', $appraisals)
    ->select('invoices.*', 'clients.client_name', 'teammembers.team_member', 'assignments.assignment_name', 'invoices.client_id as client_id', 'assignments.assignment_name', 'assignments.id as assignmentid')
    ->first();

$assignmentDatas=DB::table('assignmentevaluations')
    ->leftjoin('teammembers','teammembers.id','assignmentevaluations.createdby')
    ->leftjoin('roles','roles.id','teammembers.role_id')
    ->where('clients_name',$appraisaldata->client_id)
    ->where('nature_of_assignment',$appraisaldata->assignmentid)
    ->where('assignment_partner',$appraisaldata->partner)
    ->where('assignmentevaluations.createdby',$appraisaldata->createdby)
    ->select('assignmentevaluations.*','teammembers.team_member','roles.rolename')
    ->first();

$partner=DB::table('assignmentevaluations')
    ->leftjoin('teammembers','teammembers.id','assignmentevaluations.assignment_partner')
    ->leftjoin('roles','roles.id','teammembers.role_id')
    ->where('clients_name',$appraisaldata->client_id)
    ->where('nature_of_assignment',$appraisaldata->assignmentid)
    ->where('assignment_partner',$appraisaldata->partner)
    ->where('assignmentevaluations.createdby',$appraisaldata->createdby)
    ->select('teammembers.team_member','roles.rolename')
    ->first();


$role=DB::table('teammembers')
    ->join('roles','roles.id','teammembers.role_id')
    ->where('teammembers.id',$appraisaldata->createdby)
    ->select('rolename')
    ->pluck('rolename')
    ->first();
@endphp
						@if($role !="Partner")
                        <tr>
                            <td>
                            @if($assignmentDatas!=null )
                            <a href="{{url('view/assignmentevaluation/'.$assignmentDatas->id)}}"> 					{{App\Models\Teammember::where('id',$appraisaldata->createdby)
                                ->pluck('team_member')->first() ??''}}</a>

                            @else
                            {{App\Models\Teammember::where('id',$appraisaldata->createdby)
                                ->pluck('team_member')->first() ??''}}
                            @endif
                           
                            </td>
							                            <td>
                           
                            {{$role ??''}}
                        
                            </td>
                            
                            <td>{{$appraisaldata->client_name ??''}}</td>
                            <td>{{$appraisaldata->assignment_name ??''}}</td>
						
                            <td>  @if($assignmentDatas!=null)
                            {{ $partner->team_member ?? ''}}
                          ({{$partner->rolename ??''}})
                            
                            @endif
                        </td>
                              
                            
                            <td>
                                @if($assignmentDatas==null)
                                <span class="badge badge-pill badge-secondary">Not Submitted</span>
                            @else
                            @if($assignmentDatas->status == '0')
                            <span class="badge badge-pill badge-warning">Pending For Evaluation</span>
                            @endif
                            @if($assignmentDatas->status == '1')
                            <span class="badge badge-pill badge-success">Evaluated</span>
                            @endif
                      		  @if($assignmentDatas->status == '3')
                            <span class="badge badge-pill badge-info">Assignment Evaluation Created</span>
                            @endif
                        @if($assignmentDatas->status == '4')
                            <span class="badge badge-pill badge-secondary">Not Submitted</span>
                            @endif
                       
                            @endif
                        
                            </td>
                            <td>

                            @if($assignmentDatas!=null)
                            {{ $partner->team_member ?? ''}}
                          ({{$partner->rolename ??''}})
                            
                            @endif
                        
                            </td>
                            <td>
                            @if($assignmentDatas!=null)
                            {{ $assignmentDatas->rate_over_all_performance }}/10
                            @endif
                        </td>
                        @if(auth()->user()->role_id==18||auth()->user()->role_id==11||auth()->user()->role_id==12
                            ||auth()->user()->role_id==13)
                           
                            <td>
                               
                                @if($assignmentDatas!=null)
                                {{ $assignmentDatas->rate_over_all_performance_partner }}/10
                                @endif
                                </td>
                                @endif
                           
                        </tr>
						@endif
                        @endif
                       @endforeach
                       @php
                      // die;
                       @endphp
                      </tbody>
                </table>
                
            </div>
        </div>
    </div>

</div>
<!--/.body content-->
@endsection
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    function calcDiff(){
        var date1 = new Date($("2020/04/22").val());
        var date2 = new Date($("2020/04/20").val());
   alert(date1);
        var timedifference = date2.gettime() - date1.gettime();
        
        var millisecondsInOneSecond = 1000;
        var secondInOneHour = 3600;
        var hourInOneDay = 24;

        var daysDiff = timedifference/(millisecondsInOneSecond * secondInOneHour * hourInOneDay);
      //    alert(daysDiff);
    }
    </script> -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

    <script>$(document).ready(function() {
    $('#examplee').DataTable( {
        "pageLength": 20,            
        dom: 'Bfrtip',
        "order": [[ 0, "desc" ]],
        
        buttons: [
            
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, ':visible' ]
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
                    columns: [ 0, 1, 2, 5 ]
                }
            },
            'colvis'      
    ]  
    } );
} );</script>                                

