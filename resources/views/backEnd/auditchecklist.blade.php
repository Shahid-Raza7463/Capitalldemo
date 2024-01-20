
<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">

@extends('backEnd.layouts.layout') @section('backEnd_content')
<div class="content-header row align-items-center m-0">

    <nav aria-label="breadcrumb" class="col-sm-6 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            @php
            $status = App\Models\Checklistanswer::
            leftJoin('statuses',function ($join)
            {$join->on('checklistanswers.status','statuses.id'); })
            ->where('steplist_id',$stepname->id)
            ->where('financialstatemantclassfication_id',$financialname->id)
            ->where('subclassfied_id',$subclassficationname->id)
            ->where('assignment_id',$assignmentbudget->assignmentgenerate_id)->select('statuses.*')->orderBy('id',
            'asc')->first();
            $count = App\Models\Checklistanswer::
            leftJoin('statuses',function ($join)
            {$join->on('checklistanswers.status','statuses.id'); })
            ->where('steplist_id',$stepname->id)
            ->where('financialstatemantclassfication_id',$financialname->id)
            ->where('subclassfied_id',$subclassficationname->id)
            ->where('assignment_id',$assignmentbudget->assignmentgenerate_id)->select('statuses.*')->get();
            $countauditanswer = count($count);


            @endphp

@if(Auth::user()->role_id == 13 || Auth::user()->role_id ==14)
            @if( $countauditanswer == $countauditquestion)
            @if($status)

            @if($status->name != 'CLOSE')
			   @if($assignmentbudget->status == 1)
            <li class="breadcrumb-item"><a class="btn btn-info-soft btn-sm" data-toggle="modal"
                    data-target="#exampleModal1">Add Question</a></li>
			@endif
            @endif

            @else
            <span class="badge badge-primary">OPEN</span>
            @endif
            @else
			   @if($assignmentbudget->status == 1)
            <li class="breadcrumb-item"><a class="btn btn-info-soft btn-sm" data-toggle="modal"
                    data-target="#exampleModal1">Add Question</a></li>
			@endif
            @endif
			@endif

        </ol>
    </nav>

    <div class="col-sm-6 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Checklist </small>
            </div>
        </div>
    </div>
</div>

<div class="body-content">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">Checklist Task</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body" >
                    <fieldset class="form-group">

                        <table class="table display table-bordered table-striped table-hover">

                            <tbody>
                                <tr>
                                    <td><b>Client Name : </b></td>
                                    <td>{{ $assignmentbudget->client_name }}</td>
                                    <td><b>Assignment Code :</b></td>
                                    <td>{{ $assignmentbudget->assignmentgenerate_id }}</td>

                                </tr>
                                <tr>
                                    <td><b>Assignment Name : </b></td>
                                    <td>{{ $auditChecklistDatas->assignment_name}}</td>
                                    <td><b>Financial Statement Classification Name :</b></td>
                                    <td>{{$financialname->financial_name}}</td>

                                </tr>
                              
                                <tr>
                                    <td><b>Sub  Financial Classfication Name :</b></td>
                                    <td>{{ $subclassficationname->subclassficationname}}</td>
                                    <td><b>Steplist Name :</b></td>
                                    <td>{{$stepname->stepname}}</td>

                                </tr>
                                <tr>
                                    <td><b>Period End : </b></td>
                                    <td style="color: cornflowerblue;">{{ $auditChecklistDatas->periodend }}</td>
                                    <td><b>Status :</b></td>
                                    <td> 
                                     
                                    @if( $countauditanswer == $countauditquestion)
                                    @if($status)
										   @if(auth::user()->role_id == 13 && $status->name == 'REVIEW-TL')
                                    <a  onclick="return confirm('Are you sure you want to Close these item?');" href="{{ url('/assignmentclosed?'.'steplist_id='.$stepname->id.'&&'.'assignment_id='.$assignmentbudget->assignmentgenerate_id.'&&'.'subclassfied_id='.$subclassficationname->id.'&&'.'financialid='.$subclassficationname->financialstatemantclassfication_id)}}">
                                        @endif
										
                                          <span class="{{ $status->color ??'' }}">{{ $status->name ??''}}</span>
										  @if(auth::user()->role_id == 13)
                                        </a>
										@endif
                                          @else
                                          <span class="badge badge-primary">OPEN</span>
                                          @endif
                                         @else
                                          <span class="badge badge-primary">OPEN</span>   @endif
                                    </td>

                                </tr>
                                 
                               
                            </tbody>
                        </table>
                    </fieldset>
                <div class="row row-sm">
                  
              
                <div class="table-responsive">
					  <form  method="post" >
                                @csrf
                                <table id="examplee" class="display nowrap">
                        <thead>
                            <tr>
								
								    @if($assignmentbudget->status == 1)
								   @if(Auth::user()->role_id == 15 || Auth::user()->role_id == 14)
								 @if ($authteamtl !=  null || $authteamid !=  null)
                                        <th><button type="submit"
                                            onclick="return confirm('Are you sure you want to N/A these item?');"
                                             formaction="assignmentna" class="btn btn-danger-soft btn-sm" style="font-size: 11px;">
                                             @if($authteamid !=  null)
                                             Mark As N/A
                                             @elseif($authteamtl !=  null)
                                             Mark As Reviewed
                                             @endif
                                            </button>
                                             <input type="checkbox" id="chkAll">
                                           <i class="os-icon os-icon-trash"></i>
                                           <input type="text" hidden name="steplist_id" value="{{ $stepname->id }}">
                                           <input type="text" hidden name="assignment_id" value="{{ $assignmentbudget->assignmentgenerate_id }}">
                                           <input type="text" hidden name="subclassfied_id" value="{{ $subclassficationname->id }}">
                                           <input type="text" hidden name="financialid" value=" {{ $subclassficationname->financialstatemantclassfication_id }}">
                                           @if($authteamid !=  null)
                                           <input type="text" hidden name="status" value="2">
                                       @endif
                                        @if($authteamtl !=  null)
                                           <input type="text" hidden name="status" value="3">
                                       @endif
                                        </th>
@endif 	@endif @endif
								<th style="display: none;">id</th>
                                <th class="font-weight-600">Sr No.</th>
                                <th class="font-weight-600">Audit Procedure</th>
                                <th class="font-weight-600">Status</th>
                                <th class="font-weight-600">Update by</th>
                                  <th class="font-weight-600">Critical Notes</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($auditprocedure as $sub => $value)
                            <tr>
								   @if($assignmentbudget->status == 1)
								  @if(Auth::user()->role_id == 15 || Auth::user()->role_id == 14)
								  @if ($authteamtl !=  null || $authteamid !=  null)

                                        <td><input type="checkbox" name="ids[]" style="width: 18px;margin-left: 16px;"
                                            class="selectbox" value="{{$value->id}}">
                                        </td>
								@endif
                                            @endif
								@endif
                                            <td style="display: none;">{{$value->id }}</td>
                                <td> {{ $sub+1}}</td>
                                <td> <a href="{{url('/auditchecklistanswer?'.'auditid='.$value->id.'&&'.'assignmentid='.$assignmentbudget->assignmentgenerate_id)}}"  >{{$value->auditprocedure }}</a></td>
                                
                               
 
                                <td>
                                    @forelse(App\Models\Checklistanswer::
                                    leftJoin('statuses',function ($join)
                        {$join->on('checklistanswers.status','statuses.id'); })
                                    ->where('audit_id',$value->id)
        ->where('assignment_id',$assignmentbudget->assignmentgenerate_id)->get() as $status )
                                     <span class="{{$status->color}}">{{ $status->name }}</span>
                                        <span><i class="typcn typcn-media-record text-success"></i></span>
                                    @empty
                                    <span class="badge badge-primary">OPEN</span>
                                    @endforelse
                                </td>
                                <td>  {{ DB::table('audittrails')
                                            ->leftjoin('checklistanswers','checklistanswers.id','audittrails.auditanswer_id')
                                            ->leftjoin('teammembers','teammembers.id','audittrails.created_by')
                                            ->where('checklistanswers.assignment_id', $assignmentbudget->assignmentgenerate_id)->
                                            where('checklistanswers.audit_id', $value->id)->
                                            select('teammembers.team_member','audittrails.id'
                                            )->orderBy('id', 'DESC')->pluck('teammembers.team_member')->first() ??''}}
                                            </td>
                                      @php
$critical = App\Models\Criticalnote::where('assignmentgenerateid',$assignmentbudget->assignmentgenerate_id)->
                                    where('auditquestionid',$value->id)->first();
                                @endphp
                                    @if($critical == NUll)
                                <td> </td>
                                @else
                                <td>  <a href="{{url('/criticalnotes?'.'auditid='.$value->id.'&&'.'assignmentid='.$assignmentbudget->assignmentgenerate_id)}}"   class="btn btn-success-soft btn-sm mr-1"><i class="far fa-eye"></i></a></td>
                                @endif
                            </tr>
                          @endforeach
                        </tbody>
                        
                    </table>
                 </form>
                </div>

                </div>
                {{-- <div class="row row-sm">
                    <div class="col-12">
                        <div class="form-group">
                           <textarea id="summernote" rows="14" name="c_address" value="" class="form-control"
                                placeholder="Enter Communication Address"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row row-sm">
                    <div class="col-8">
                        <div class="form-group">
                            <label class="font-weight-600"><b>Checklist Notice :</b></label>
                           <textarea  rows="4" name="c_address" value="" class="form-control"
                               ></textarea>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <br>
                            <label class="font-weight-600"><b>Refrence Document :</b></label>
                            
                            <span><input type="file" name="file"  value="" ></span>
                        </div>
                        <div class="form-group">
                          
                            <label class="font-weight-600"><b>Partner :</b></label>
                            
                            <span>Prashant</span>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>
</div>
<!--/.body content-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
    $(function () {
        $("#chkAll").click(function () {
            $("input[name='ids[]']").attr("checked", this.checked);
        });
        $('#example11').DataTable({
        });
    });
</script>
@endsection

<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('checklist/upload')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background: #37A000">
                    <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Add Question
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="details-form-field form-group row">

                        <div class="col-sm-12">
                            <input required class="form-control" name="checklist" type="text" placeholder="Enter Question">
                            <input class="form-control" hidden name="financialid" value="{{ $financialname->id ??'' }}"
                                type="text">
                            <input class="form-control" hidden name="subclassfied"
                                value="{{ $subclassficationname->id ??''}}" type="text">
                            <input class="form-control" hidden name="steplist" value="{{ $stepname->id ??''}}"
                                type="text">
                            <input class="form-control" hidden name="assignmentid" value="{{ $assignmentid ??''}}"
                                type="text">

                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


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
        "pageLength": 100,
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



