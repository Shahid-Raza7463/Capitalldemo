<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">

@extends('backEnd.layouts.layout') @section('backEnd_content')
<style>
    .example:hover {
        overflow-y: scroll;
        /* Add the ability to scroll */

    }
    /* Hide scrollbar for IE, Edge and Firefox */
    .example {
       height: 180px;
        margin: 0 auto;
        overflow: hidden;
    }

</style>
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('discuss')}}">Back</a></li>
			
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
            <div class="media-body">
               <a href="{{url('home')}}"> <h1 class="font-weight-bold" style="color:black;">Home</h1></a>
                <small>Discussion</small>
            </div>
        </div>
    </div>
</div>
<div class="body-content">
    <div class="mailbox">
        <div class="mailbox-body">
            <div class="row m-0">
                <div class="col-lg-3 p-0 inbox-nav d-none d-lg-block">
                    <div class="mailbox-sideber">
                        <div class="card-header"
                            style="margin-top: -15px;margin-left: -15px;width: 114%;background: #37A000;color: white;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="row">
                                    <h6 class="fs-17 font-weight-600 mb-0">Discussion </h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                           
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="mb-0 font-weight-600">Topic.</h6>
                                </div>
								
								     <a data-target="#modal8" data-toggle="modal" class="text-danger">
                                    <i class="fa fa-pen"></i></a>
                                <div class="col-auto">
                                    <time class="fs-13 font-weight-600 text-muted" datetime="1988-10-24">
                                        <td>{{ $discuses->topic ??'' }}</td>

                                    </time>
                                </div>
                            </div>
                            <hr>
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="mb-0 font-weight-600">Created By.</h6>
                                </div>
                                <div class="col-auto">
                                    <time class="fs-13 font-weight-600 text-muted" datetime="1988-10-24">
                                        <td>
                                        {{ App\Models\Teammember::select('team_member')->where('id',$discuses->createdby)->first()->team_member ?? ''}}
                                        </td>

                                    </time>
                                </div>
                            </div>
                            <hr>
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="mb-0 font-weight-600">Created Date</h6>
                                </div>
                                <div class="col-auto">
                                    <time class="fs-13 font-weight-600 text-muted" datetime="1988-10-24">
                                        <td>{{ date('F d,Y', strtotime($discuses->created_at ??'')) }}</td>

                                    </time>
                                </div>
                            </div>
                            <hr>
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="mb-0 font-weight-600">Discuss With</h6>
                                </div>
								<a data-target="#modal7" data-toggle="modal" class="text-danger">
                                    <i class="fa fa-pen"></i></a>
                                <div class="col-auto">
                                    <time class="fs-13 font-weight-600 text-muted" datetime="1988-10-24">
                                @php
                             $discusswithteamData = DB::table('discusswithteams')
                                ->leftjoin('teammembers','teammembers.id','discusswithteams.teammember_ids')
                                ->select('discusswithteams.*','teammembers.team_member')
                                ->where('discusswithteams.discuss_id',$discuses->id)->get()  
                                @endphp
                                    <td>
                                        @foreach($discusswithteamData as $sub)

                                        <span class="badge badge-info">{{$sub->team_member ??''}}</span>
                        
                    @endforeach
                                        </td>

                                    </time>
                                </div>
                            </div>
                            <hr>
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="mb-0 font-weight-600">Participate</h6>
									
                                </div>
								<a data-target="#modal6" data-toggle="modal" class="text-danger">
                                    <i class="fa fa-pen"></i></a>
                                <div class="col-auto">
                                    <time class="fs-13 font-weight-600 text-muted" datetime="1988-10-24">
                                    <td>
                                    @php
                             $discusesteammebersData = DB::table('discusesteammebers')
                                ->leftjoin('teammembers','teammembers.id','discusesteammebers.teammember_id')
                                ->select('discusesteammebers.*','teammembers.team_member as teammember')
                                ->where('discusesteammebers.discuss_id',$discuses->id)->get()  
                                @endphp
                                    <td>
                                        @foreach($discusesteammebersData as $subData)

                                        <span class="badge badge-info">{{$subData->teammember ??''}}</span>
                        
                    @endforeach
                    </td>
                                    </time>
                                </div>
                            </div>
                            <hr>
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="mb-0 font-weight-600">Related To</h6>
                                </div>
                                <div class="col-auto">
                                    <time class="fs-13 font-weight-600 text-muted" datetime="1988-10-24">
                                    <td>
                                    @if($discuses->relatedto==0)
                                        {{ App\Models\Assignment::select('assignment_name')->where('id',$discuses->related_id)->first()->assignment_name ?? ''}}
                                        (Assignment Name)
                                        @elseif($discuses->relatedto==1)
                                        {{ App\Models\Client::select('client_name')->where('id',$discuses->related_ids)->first()->client_name ?? ''}}
                                        (Client Name)
                                        @else
                                            {{$discuses->other}}(Other)    
                                    @endif    
                                    </td>
                                    </time>
                                </div>
                            </div>
                            <hr>
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="mb-0 font-weight-600">Description</h6>
                                </div>
								    <a data-target="#modal9" data-toggle="modal" class="text-danger">
                                    <i class="fa fa-pen"></i></a>
                                <div class="col-auto">
                                    <time class="fs-13 font-weight-600 text-muted" datetime="1988-10-24">
                                        <td>
                                    {!! $discuses->description !!}
                                 </td>
                                    </time><br>
									
                                </div>
								<a data-toggle="modal"
                                        data-target="#modaldemo1" class="btn ripple btn-success text-white btn-icon" title="Assign Task" >
                                        Uploaded Documents</a>
                            </div>
                        </div>
                    </div>
                </div>
                    
                <div class="col-md-12 col-lg-9 p-0 inbox-mail">
                <!-- @component('backEnd.components.alert')

                @endcomponent -->
                    <div class="inbox-avatar-wrap p-3 border-btm d-sm-flex"
                        style="color: white;height: 77px;margin-top: -16px;background: #37A000;">
                        <!-- <div class="inbox-avatar-text ml-sm-3 mb-2 mb-sm-0">
                       <div class="avatar-name" style="color: white;"><strong></strong>
                          #{{ $discuses->topic ??''}}
                    </div>

                </div> -->
						
               <div class="inbox-date ml-auto" >        
				   
                <div >
					<a data-toggle="modal" data-target="#modaldemo2" class="btn ripple btn-secondary text-white btn-icon">Import</a>&nbsp;&nbsp;
					<i class="typcn typcn-mail" style='font-size:35px;'></i>
               
                    <input data-id="{{$discuses->id}}"  class="toggle-class" type="checkbox" data-onstyle="info" data-offstyle="danger" data-toggle="toggle" data-on="ON" data-off="OFF" {{ $discuses->status ? 'checked' : '' }}>
                </div>
              </div>
            </div>


            <div class="inbox-mail-details p-3">
                <div class="row">
                    <div class="card" style="width: 100%;box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2)">
                   @php 
                    $disjj = DB::table('discusstopics')
                    ->leftjoin('teammembers','teammembers.id','discusstopics.createdby') 
                    ->where('discusstopics.discuss_id', $discuses->id)
                    ->select('discusstopics.*','teammembers.team_member')
                    ->get();
   
                 //  dd($disjj);
                @endphp
                   
                        @foreach($disjj as $disjjData) 
                        @php
                        $disatt = DB::table('discussattachements')
                        ->leftjoin('discusstopics','discusstopics.id','discussattachements.topic_id') 
                       // ->where('discussattachements.discuss_id', $disjjData->id)
                        ->where('discussattachements.topic_id',  $disjjData->id)
                        
                        ->get();
               // dd($disatt);
                        @endphp
                        <div class="inbox-avatar-wrap p-3 border-btm d-sm-flex">
                            <div class="inbox-avatar-text col-md-10">
                                <div class="avatar-name"><strong></strong>
									<b> {{ $disjjData->team_member ??''}}</b>
                                    <p>{!! $disjjData->discuss_topic !!}</p>
                                    <small>{{ date('F jS', strtotime($disjjData->updated_at??'')) }},
                                        {{ date('h:i A', strtotime($disjjData->updated_at??'')) }}</small>
                                </div>
                            </div>
                           @foreach($disatt as $disatt)
                                 <div class="row">
                             <div class="col-8 col-lg-8">
                                 <a target="blank" target="blank" data-toggle="tooltip"
                                 title="{{$disatt->attachment}}"
                                 href="{{ url('backEnd/image/discuss/'.$disatt->attachment ??'') }}">
                                 <img style="width:60px;" class="img-thumbnail img-responsive" alt="attachment"
                                         src="{{url('backEnd/image/discuss/'.$disatt->attachment ??'')}}">
                                 </a>
                             </div>
                                 </div>
                                 @endforeach
                                  <div class="inbox-date ml-auto">
                                 
                                  <div>
                                  <a data-toggle="modal" data-id="{{ $disjjData->id }}"
                                        data-target="#Modal4" onclick="tasks({{ $disjjData->id }});" class="btn ripple btn-success text-white btn-icon" title="Assign Task" >
                                        <i class="fa fa-tasks"></i></a> 
                                        <a data-toggle="modal" data-id="{{ $disjjData->id }}"
                                        data-target="#Modal5" onclick="task({{ $disjjData->id }});" class="btn ripple btn-success text-white btn-icon" title="Edit" >
                                        <i class="fa fa-edit"></i></a> 
                                 
                                     <a href="{{url('discuss/delete',$disjjData->id)}}" onclick="return confirm('Are you sure you want to delete this item?');" 
                                         class="btn ripple btn-danger text-white btn-icon" title="Delete" data-toggle="tooltip">
                                         <i class="fa fa-trash"></i></a>
                                    </div>
                                   
                        </div>

                        </div>
                        @endforeach
                        <div class="mt-3 p-3">
                            <form method="post" action="{{url('discuss/update')}}"
                                enctype="multipart/form-data">
                                @csrf
                                <p><textarea required class="centered form-control"
                                        rows="7" name="discuss_topic" value="" placeholder="" id="editor1"></textarea><br>
                                    <div class="row">
                                        <div class="col-4">
											<input type="file" id="localconveyance-img" name="attachment[]" multiple="multiple"
                                          class="form-control">
                                        </div>
                                        <div class="col-4">  
											<input type="text" hidden name="discuss_id" value="{{ $discuses->id }}">
          
                                        </div>
                                        <div class="col-4">
                                            <button type="submit" class="btn btn-success" style="float:right">
                                                Submit</button></div>
                                    </div>
                                </p>
                            </form>
                        </div>
                      
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
</div>
</div>
<!-- Modal Start -->
<div class="modal fade" id="Modal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
 aria-hidden="true">
 <div class="modal-dialog" role="document">
     <div class="modal-content">
           <div class="modal-header" style="background:#37A000">
               <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel1">Assign Task</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <form method="post" action="{{ route('task.store')}}" enctype="multipart/form-data">
              
               @csrf   
           <div class="modal-body">
               <div class="row row-sm">
               <div class="col-12">
          <div class="form-group">
            <label class="font-weight-600">Assign</label>
            <select required class="form-control basic-multiple" multiple="multiple" 
            name="teammember_id[]" >
                <option value="">Please Select One</option>
                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}">
                    {{ $teammemberData->team_member }} ( {{ $teammemberData->rolename}} ) ( {{ $teammemberData->emailid ??''}} ) </option>

                @endforeach
               
            </select>
        </div>
    </div>
               <div class="col-12">
            <div class="form-group"> 
                <label class="font-weight-600">Task Name</label><br>
            <input class="form-control" value="" id="discusstopics" name="taskname" type="text">
            </div>
            </div>
            <div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Due Date <span class="tx-danger">*</span></label>
            <input required type="date" name="duedate" value="" class="form-control"
                placeholder="Enter Mobile No">
        </div>
    </div>
	  <div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Support By *</label>
            <select required class="language form-control" id="exampleFormControlSelect1" name="supportby" @if(Request::is('task/*/edit'))>
                <option disabled style="display:block">Please Select One</option>

                  @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}" @if(Request::is('task/*/edit')) @foreach($taskassign as
                    $team) {{ $teammemberData->id == $team->teammember_id ? 'selected' : '' }} @endforeach   @endif>
                {{ $teammemberData->team_member }} (
                    {{ $teammemberData->role->rolename}} ) ( {{ $teammemberData->emailid ??''}} )</option>
                @endforeach


                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}">
                    {{ $teammemberData->team_member }} ( {{ $teammemberData->rolename}} ) ( {{ $teammemberData->emailid ??''}} ) </option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
	 <div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Attachment</label>
            <input type="file" name="attachment" class="form-control"
                placeholder="Enter Attachment">
        </div>
    </div>
                   <div class="col-12">
                       <div class="form-group">   
                        <label class="font-weight-600">Description</label><br>
                        <textarea rows="6" name="description" class="centered form-control" id="editor"
                                placeholder="Enter Description"></textarea>
                    </div>
                   </div>
                   
                   </div>
                   <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
               <button type="submit" style="float: right" class="btn btn-success">Save </button>
           </div>
           </form>
       </div>
   </div>
</div>
<!-- End Modal -->

<!-- Modal Start -->
<div class="modal fade" id="Modal5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
 aria-hidden="true">
 <div class="modal-dialog" role="document">
     <div class="modal-content">
           <div class="modal-header" style="background:#37A000">
               <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel1">Edit Discuss</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <form method="post" action="{{url('discuss/editupdate')}}" enctype="multipart/form-data">
              
               @csrf   
           <div class="modal-body">
               <div class="row row-sm">
            
                   <div class="col-12">
                       <div class="form-group">   
                        <label class="font-weight-600">Description</label><br>
                        <textarea rows="6" name="description" class="centered form-control" id="discusstopics1"
                                placeholder="Enter Description"></textarea>
                            <input class="form-control" value="" id="iddata" name="id" hidden type="text">     
                    </div>
                   </div>
                   
                   </div>
                   <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
               <button type="submit" style="float: right" class="btn btn-success">Save </button>
           </div>
           </form>
       </div>
   </div>
</div>
<!-- End Modal -->

<!-- Modal Start -->
<div class="modal fade" id="Modal6" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
 aria-hidden="true">
 <div class="modal-dialog" role="document">
     <div class="modal-content">
           <div class="modal-header" style="background:#37A000">
               <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel1">Edit Participate</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <form method="post" action="{{url('participate/update')}}" enctype="multipart/form-data">
              
               @csrf   
           <div class="modal-body">
            <div class="row row-sm">
            @php
            $discusesteammebersData = DB::table('discusesteammebers')
            ->leftjoin('teammembers','teammembers.id','discusesteammebers.teammember_id')
            ->select('discusesteammebers.*','teammembers.team_member as teammember')
            ->where('discusesteammebers.discuss_id',$discuses->id)->get()  
            @endphp
            <div class="col-12">
          <div class="form-group">
            <label class="font-weight-600">Discuss With</label>
            <select required class="form-control basic-multiple" multiple="multiple" 
            name="teammember_id[]">
                <option value="">Please Select One</option>
                @foreach(App\Models\Teammember::get() as $i => $sub)
                         <option value="{{ $sub->id }}" 
                             @foreach($discusesteammebersData as $discusesData){{$discusesData->teammember_id == $sub->id ? 'selected': ''}}   @endforeach>
                             {{ $sub->team_member }}({{ $sub->emailid }})</option>
                         @endforeach
            </select>
            <input class="form-control" hidden value="{{ $discuses->id }}" name="discuss_id" type="text">
        </div>
    </div>
        </div>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
               <button type="submit" style="float: right" class="btn btn-success">Save </button>
           </div>
           </form>
       </div>
   </div>
</div>
<!-- End Modal -->
<!-- Modal Start -->
<div class="modal fade" id="Modal7" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
 aria-hidden="true">
 <div class="modal-dialog" role="document">
     <div class="modal-content">
           <div class="modal-header" style="background:#37A000">
 <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel1">Edit Discuss With</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <form method="post" action="{{url('Discussteam/update')}}" enctype="multipart/form-data">
            @csrf   
           <div class="modal-body">
            <div class="row row-sm">
            @php
            $discuseswithData = DB::table('discusswithteams')
            ->leftjoin('teammembers','teammembers.id','discusswithteams.teammember_ids')
            ->select('discusswithteams.*','teammembers.team_member as teammember')
            ->where('discusswithteams.discuss_id',$discuses->id)->get()  
            @endphp
            <div class="col-12">
          <div class="form-group">
            <label class="font-weight-600">Participate</label>
            <select required class="form-control basic-multiple" multiple="multiple" 
            name="teammember_id[]">
                <option value="">Please Select One</option>
                @foreach(App\Models\Teammember::get() as $i => $sub)
                         <option value="{{ $sub->id }}" 
                             @foreach($discuseswithData as $discuseswithDatas){{$discuseswithDatas->teammember_ids == $sub->id ? 'selected': ''}}   @endforeach>
                             {{ $sub->team_member }}({{ $sub->emailid }})</option>
                         @endforeach
            </select>
            <input class="form-control" hidden value="{{ $discuses->id }}" name="discuss_id" type="text">
        </div>
    </div>
    </div>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" style="float: right" class="btn btn-success">Save </button>
    </div>
    </form>
       </div>
   </div>
</div>
<!-- End Modal -->
<!-- Modal Start -->
<div class="modal fade" id="Modal8" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
 aria-hidden="true">
 <div class="modal-dialog" role="document">
     <div class="modal-content">
           <div class="modal-header" style="background:#37A000">
 <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel1">Edit Topic</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <form method="post" action="{{url('distopic/update')}}" enctype="multipart/form-data">
            @csrf   
           <div class="modal-body">
            <div class="row row-sm">
          
            <div class="col-12">
          <div class="form-group">
            <label class="font-weight-600">Topic</label>
            <input class="form-control" value="{{ $discuses->topic}}" name="topic" type="text">
            <input class="form-control" hidden value="{{ $discuses->id}}" name="id" type="text">
        </div>
    </div>
    </div>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" style="float: right" class="btn btn-success">Save </button>
    </div>
    </form>
       </div>
   </div>
</div>
<!-- End Modal -->
<!-- Modal Start -->
<div class="modal fade" id="Modal9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
 aria-hidden="true">
 <div class="modal-dialog" role="document">
     <div class="modal-content">
           <div class="modal-header" style="background:#37A000">
 <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel1">Edit Description</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <form method="post" action="{{url('description/update')}}" enctype="multipart/form-data">
            @csrf   
           <div class="modal-body">
            <div class="row row-sm">
          
            <div class="col-12">
          <div class="form-group">
            <label class="font-weight-600">Description</label>
            <textarea rows="6" name="description" class="centered form-control"
                                id="editor2" placeholder="Enter Description">{!! $discuses->description !!}</textarea>
            <input class="form-control" hidden value="{{ $discuses->id}}" name="id" type="text">
        </div>
    </div>
    </div>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" style="float: right" class="btn btn-success">Save </button>
    </div>
    </form>
       </div>
   </div>
</div>
<!-- End Modal -->
<!-- Basic modal -->
<div class="modal" id="modaldemo1">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
               <div class="modal-header">
                    <h6 class="modal-title">Documents:</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
          
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th class="wd-10p border-bottom-0">Sl.No</th>
                                   
                                    <th class="wd-10p border-bottom-0">Attachment</th>
                                </tr>
                            </thead>
                            <tbody>
                          @php
                               $attachmentData = DB::table('discussattachements')
                               
                             ->where('discussattachements.discuss_id', $discuses->id)
                                
                                 ->get();
                      //    dd($attachmentData);
            
                             $i=1;
                    @endphp
                            @foreach($attachmentData as $attachmentDatas)
                                <tr>
                                <td>{{$i++}}</td>
                                    <td><i class="fa fa-paperclip"></i>&nbsp;
                                   <a href="{{ asset('backEnd/image/discuss/'.$attachmentDatas->attachment?? '')}}" target="blank">View</a>/
										<a href="{{ asset('backEnd/image/discuss/'.$attachmentDatas->attachment?? '')}}" download >Download</a>
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
<!-- End Basic modal -->
<!-- Basic modal -->
<div class="modal" id="modaldemo2">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
        <div class="modal-header" style="background:#37A000">
 <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel1">Add New Point :</h6>
 <button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
            <form method="post" action="{{ url('discuss/excel')}}" enctype="multipart/form-data">  
              @csrf
              <div class="modal-body">
                  <div class="details-form-field form-group row">
                      <label for="name" class="col-sm-3 col-form-label font-weight-600">Upload Excel :</label>
                      <div class="col-sm-6">
                          <input id="name" class="form-control" name="file" type="file">
                          <input class="form-control" hidden name="discuss_id" type="text" value="{{$discuses->id}}">
                      </div>
                  </div>
                  <div class="details-form-field form-group row">
                      <label for="name" class="col-sm-3 col-form-label font-weight-600">Sample Excel :</label>
                      <div class="col-sm-6">
                          <a href="{{ url('backEnd/discussimport.xlsx')}}" class="btn btn-success btn">Download<i class="fas fa-file-excel" style="margin-left: 3px;font-size: 20px;"></i></a>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button class="btn ripple btn-success" type="submit">Save</button>
                      <button class="btn ripple btn-danger" data-dismiss="modal" type="button">Close</button>
                  </div>
              </div>
          </form>
        </div>
    </div>
</div>
<!-- End Basic modal -->
<script src="{{ url('backEnd/ckeditor/ckeditor.js')}}"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor2'), {
            // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
        })
        .then(editor => {
            window.editor = editor;
        })
        .catch(err => {
            console.error(err.stack);
        });

</script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
        })
        .then(editor => {
            window.editor = editor;
        })
        .catch(err => {
            console.error(err.stack);
        });

</script>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
     $(function() {
    $('.toggle-class').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0; 
        var user_id = $(this).data('id'); 
         
        $.ajax({
              type: "GET",
              dataType: "json",
              url: "{{ url('/discussstatus') }}",
              data: {'status': status, 'user_id': user_id},
              success: function(data){
                console.log(data.success)
              }
          });
      })
    })
  </script>
<script>
    function tasks(id)
 {
     
    //var assignment = $(this).val();
              // alert(category_id);
              $.ajax({
                  type: "get",
                  url: "{{ url('discussfilter') }}",
                  data: "id=" + id,
                  success: function (response) {
                    //  $('#discusstopics').html(response);
                 //      var res =  JSON.parse(response);
                 //     alert(res);
                 $('#discusstopics').val(response.discuss_topic);
              //   alert(response.discuss_topic);
                  },
                  error: function () {},
              });
 }
  </script>
  <script>
    function task(id)
 {
     debugger;
  //  var id = $(this).val();
     //        alert(id);
              $.ajax({
                  type: "get",
                  url: "{{ url('discussfilter1') }}",
                  data: "id=" + id,
                  success: function (response) {
                    //  $('#discusstopics').html(response);
                 //      var res =  JSON.parse(response);
                 //     alert(res);
                 $('#discusstopics1').val(response.discuss_topic);
                 $('#iddata').val(response.id);
              //   alert(response.discuss_topic);
                  },
                  error: function () {},
              });
 }
  </script>
