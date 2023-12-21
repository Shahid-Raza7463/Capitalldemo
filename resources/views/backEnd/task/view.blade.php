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
            <li class="breadcrumb-item"><a href="{{url('task')}}">Back</a></li>
            @if(Auth::user()->teammember_id == $task->createdby)
            <li class="breadcrumb-item">
                <a href="{{url('/task/delete/'.$task->id)}}"
                    onclick="return confirm('Are you sure you want to delete this task?');">Delete</a>
            </li>
			<!--<li class="breadcrumb-item">
                <a href="{{url('/task/repeat/'.$task->id)}}"
                    onclick="return confirm('Are you sure you want to repeat this task?');">Repeat Task</a>
            </li>-->
            @endif
            {{-- @if(Auth::user()->role_id == 11 || Auth::user()->teammember_id == $task->createdby)
            <li class="breadcrumb-item"><a href="{{url('task/'. $task->id.'/edit')}}">Edit</a></li>
            @endif --}}
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
            <div class="media-body">
                <a href="{{url('home')}}">
                    <h1 class="font-weight-bold" style="color:black;">Home</h1>
                </a>
                <small>Task Details</small>
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
                                    <h6 class="fs-17 font-weight-600 mb-0">Task Details </h6>
                                    <!-- <a data-toggle="tooltip"
                                        style="background: aliceblue;margin-left: 9px;margin-top: -4px;"
                                        title="only for delete within 6 hours"
                                        href="{{url('/client/task/destroy/')}}"
                                        onclick="return confirm('Are you sure you want to delete this item?');"
                                        class="btn btn-danger-soft btn-sm"><i class="far fa-trash-alt"></i></a> -->


                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="mb-0 font-weight-600">Task.</h6>
                                </div>
                                <div class="col-auto">
                                    <time class="fs-13 font-weight-600 text-muted" datetime="1988-10-24">
                                        <td>{{ $task->taskname ??'' }}</td>

                                    </time>
                                </div>
                            </div>
                            <hr>
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="mb-0 font-weight-600">Assigned By.</h6>
                                </div>
                                <div class="col-auto">
                                    <time class="fs-13 font-weight-600 text-muted" datetime="1988-10-24">
                                        <td>{{ $task->team_member }}</td>

                                    </time>
                                </div>
                            </div>
                            <hr>
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="mb-0 font-weight-600">Raised Date</h6>
                                </div>
                                <div class="col-auto">
                                    <time class="fs-13 font-weight-600 text-muted" datetime="1988-10-24">
                                        <td>{{ date('F d,Y', strtotime($task->created_at)) }}</td>

                                    </time>
                                </div>
                            </div>
                            <hr>
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="mb-0 font-weight-600">Due Date</h6>
                                </div>
                                <div class="col-auto">
                                    <time class="fs-13 font-weight-600 text-muted" datetime="1988-10-24">
                                        <td>{{ date('F d,Y', strtotime($task->duedate)) }}</td>

                                    </time>
                                </div>
                            </div>
                            <hr>
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="mb-0 font-weight-600">Status</h6>
                                </div>
                                <div class="col-auto">
                                    <time class="fs-13 font-weight-600 text-muted" datetime="1988-10-24">
                                        @if($task->status == 0)
                                        <span class="badge badge-pill badge-info">open</span>
										  @elseif($task->status == 2)
                                        <span class="badge badge-pill badge-primary">Cancelled Due to Non Completion</span>
                                        @else
                                        <span class="badge badge-pill badge-danger">close</span>


                                        @endif
                                    </time>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-9 p-0 inbox-mail">
                    @component('backEnd.components.alert')

                    @endcomponent
                    <div class="inbox-avatar-wrap p-3 border-btm d-sm-flex"
                        style="color: white;margin-top: -22px;background: #37A000;">
                        {{-- <div class="inbox-avatar-text ml-sm-3 mb-2 mb-sm-0">
<div class="avatar-name" style="color: white;"><strong></strong>
#{{ $ticketDatas->generateticket_id}} -- {{ $ticketDatas->subject}}
                    </div>

                </div> --}}
                <div class="inbox-date ml-auto">
                    <div> @if($task->status == 0)
                        <span class="badge badge-pill badge-info">open</span>
						 @elseif($task->status == 2)
                        <span class="badge badge-pill badge-primary">Cancelled Due to Non Completion</span>
                        @else
                        <span class="badge badge-pill badge-danger">close</span>


                        @endif</div>
                    <div><small>{{ date('F jS', strtotime($task->created_at)) }},
                            {{ date('H:i A', strtotime($task->created_at)) }}</small></div>


                </div>
            </div>


            <div class="inbox-mail-details p-3">
                <div class="row">
                    <div class="card" style="width: 100%;box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2)">
                        <div class="inbox-avatar-wrap p-3 border-btm d-sm-flex">
                            <div class="inbox-avatar-text ml-sm-3 mb-2 mb-sm-0">
                                <div class="avatar-name"><strong></strong>

                                    <b
                                        style="font-size: 15px;">{{ App\Models\Teammember::select('team_member')->where('id',$task->createdby)->first()->team_member ?? ''}}</b>
                                </div>
                                <p>{!! $task->description !!}</p>
								
								 
                                 @if ($task->file != null)
                                 <h5> <i class="fa fa-paperclip"></i> Attachments </h5>
                                 <div class="row">
                                      
                           
                             <div class="col-3 col-lg-2">
                                 <a target="blank" target="blank" data-toggle="tooltip"
                                 title="{{$task->file}}"
                                 href="{{ url('backEnd/image/task/'.$task->file ??'') }}"><img style="max-width: 400%;"
                                         class="img-thumbnail img-responsive" alt="attachment"
                                         src="{{url('/backEnd/documents.png')}}">
                                 </a>
                             </div>
                        
                                 </div> 
                                 @endif
								
                            </div>
                            <div class="inbox-date ml-auto">
                                <div><span>@if($task->status==0)
                                        <span class="badge badge-info">Open</span>
									
									@elseif($task->status == 2)
                                        <span class="badge badge-primary">Cancelled Due to Non Completion</span>

                                        @else
                                        <span class="badge badge-danger">Close</span>
                                        @endif</span></div>
                                <div><small>{{ date('F jS', strtotime($task->created_at)) }},
                                        {{ date('h:i A', strtotime($task->created_at)) }}</small>
                                </div>
                            </div>
                        </div>
                        @foreach($tasktrails as $tasktrailsData)
                        <div class="inbox-avatar-wrap p-3 border-btm d-sm-flex">
                            <div class="inbox-avatar-text ml-sm-3 mb-2 mb-sm-0">
                                <div class="avatar-name"><strong></strong>

                                    <b> {{ $tasktrailsData->team_member ??''}}</b>
                                </div>
                                <p>{!! $tasktrailsData->remark !!}</p>
                            </div>
                            <div class="inbox-date ml-auto">
                                <div><span class="badge badge-info"></span></div>
                                <div><small></small>
                                </div>
                            </div>
                            <div class="inbox-date ml-auto">
                                <div><span>@if($tasktrailsData->status==0)
                                        <span class="badge badge-info">Open</span>
									@elseif($tasktrailsData->status==2)
                                       <span class="badge badge-primary">Cancelled Due to Non Completion</span>

                                        @else
                                        <span class="badge badge-danger">Close</span>
                                        @endif</span></div>
                                <div><small>{{ date('F jS', strtotime($tasktrailsData->created_at)) }},
                                        {{ date('h:i A', strtotime($tasktrailsData->created_at)) }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <div class="mt-3 p-3">
                            <form method="post" action="{{ url('tasktrail/update')}}" enctype="multipart/form-data">
                                @csrf

                                <p><textarea required class="centered form-control" rows="3" name="remark" value=""
                                        placeholder=""></textarea><br>
                                    <div class="row">
                                        <div class="col-4">
                                            <select required name="status" class="form-control">
                                                <!--placeholder-->

                                                <option value="">Please Select One</option>
                                                <option value="0">Open</option>
                                                <option value="1">Close</option>
												  @if(Auth::user()->teammember_id == $task->createdby)
                                                <option value="2">Cancelled Due to Non Completion</option>
                                                @endif
                                            </select>
                                            <input type="text" hidden name="task_id" value="{{ $id }}">
                                        </div>
                                        <div class="col-4">

                                            <input type="text" hidden name="tasksno" value="">
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
<!--/.body content-->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #37A000">
                <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Preview</h5>

                <button type="button" class="close" data-distasks="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body" id="attachment">

                </div>
            </div>


            <span id="imgdwnld" style="text-align: center"></span>
            <br>
        </div>
    </div>
</div>
<div class="modal fade bd-examplee-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleeModalLabel3"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #37A000">
                <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Prview</h5>

                <button type="button" class="close" data-distasks="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body" id="clientattachment">

                </div>
            </div>


            <span id="clientimgdwnld" style="text-align: center"></span>
            <br>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(function () {
        $('body').on('click', '#editCompany', function (event) {
            var id = $(this).data('id');
            debugger;
            $.ajax({
                type: "GET",

                url: "{{ url('/client/taskimage') }}",
                data: "id=" + id,

                success: function (response) {
                    var img = '<img class="img-thumbnail img-responsive" src="{{ url(' /
                        backEnd / image / task / ')}}/' + response.attachment +
                        '" width="1000">';
                    var clientimg =
                        '<img class="img-thumbnail img-responsive" src="{{ url(' / backEnd /
                        image / task / ')}}/' + response.clientattachment +
                        '" width="1000">';
                    var imgdwnld = '<a download href="{{ url(' / backEnd / image / task /
                        ')}}/' + response.attachment +
                        '"  class="btn btn-success"><i class="fa fa-download"> Download</i></a>';
                    var clientimgdwnld = '<a download href="{{ url(' / backEnd / image /
                        task / ')}}/' + response.clientattachment +
                        '"  class="btn btn-success"><i class="fa fa-download"> Download</i></a>';
                    debugger;
                    $("#attachment").html(img);
                    $("#clientattachment").html(clientimg);
                    $("#imgdwnld").html(imgdwnld);
                    $("#clientimgdwnld").html(clientimgdwnld);


                },
                error: function () {

                },
            });
        });

    });

</script>
<script>
    function myFunction() {
        document.getElementById("panel").style.display = "block";
    }

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="{{ url('backEnd/ckeditor/ckeditor.js')}}"></script>

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
<script>
    ClassicEditor
        .create(document.querySelector('#editor1'), {
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

<!--Page Active Scripts(used by this page)-->
<script src="{{ url('backEnd/dist/js/pages/forms-basic.active.js')}}"></script>
<!--Page Scripts(used by all page)-->
<script src="{{ url('backEnd/dist/js/sidebar.js')}}"></script>
