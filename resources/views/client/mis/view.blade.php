@extends('client.layouts.layout') @section('client_content')
@php

$infotime = Carbon\Carbon::parse(date('Y-m-d H:i',strtotime($mis->created_at )));
$currenttime = Carbon\Carbon::parse(date('Y-m-d H:i'));
$currenttmng = $currenttime->diffInMinutes($infotime);
@endphp
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
                                    <h6 class="fs-17 font-weight-600 mb-0">Update MIS Data</h6>
                                    @if($currenttmng < 360) <a data-toggle="tooltip"
                                        style="background: aliceblue;margin-left: 9px;margin-top: -4px;"
                                        title="only for delete within 6 hours"
                                        href="{{url('/client/mis/destroy/'.$mis->id)}}"
                                        onclick="return confirm('Are you sure you want to delete this item?');"
                                        class="btn btn-danger-soft btn-sm"><i class="far fa-trash-alt"></i></a>

                                        @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                
                                <a data-toggle="modal"id="editCompany" data-id="{{ $mis->misphoto['0']->id }}" data-target=".bd-example-modal-lg"><img
                                        class="img-thumbnail img-responsive" alt="attachment"
                                        src="{{url('/backEnd/image/compressmis/'.$mis->misphoto['0']->attachment)}}"> </a>
                            </div>
                            <hr>
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="mb-0 font-weight-600">S No.</h6>
                                </div>
                                <div class="col-auto">
                                    <time class="fs-13 font-weight-600 text-muted" datetime="1988-10-24">
                                        <td>{{ $mis->sno }}</td>

                                    </time>
                                </div>
                            </div>
                            <hr>
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="mb-0 font-weight-600">Picture No.</h6>
                                </div>
                                <div class="col-auto">
                                    <time class="fs-13 font-weight-600 text-muted" datetime="1988-10-24">
                                        <td>{{ $mis->pictureno }}</td>

                                    </time>
                                </div>
                            </div>
                            <hr>
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="mb-0 font-weight-600">Submitted Date</h6>
                                </div>
                                <div class="col-auto">
                                    <time class="fs-13 font-weight-600 text-muted" datetime="1988-10-24">
                                        <td>{{ date('F d,Y', strtotime($mis->submitdate)) }}</td>

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
                                        @if($mis->status == 0)
                                        <span class="badge badge-pill badge-primary">Created</span>
                                        @elseif($mis->status == 2)
                                        <span class="badge badge-pill badge-warning">Re Submitted</span>

                                        @elseif($mis->status == 1)
                                        <span class="badge badge-pill badge-info">Submitted</span>
                                        @else
                                        <span class="badge badge-pill badge-success">Approved</span>
                                        @endif
                                    </time>
                                </div>
                            </div>
                            <hr>
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="mb-0 font-weight-600">Instruction : </h6>
                                </div>
                                <div class="col-auto">
                                    <time class="fs-13 font-weight-600 text-muted" datetime="1988-10-24">
                                        <td>{!! $mis->instruction !!}</td>

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
                        style="color: white;margin-top: -21px;background: #37A000;">
                        {{-- <div class="inbox-avatar-text ml-sm-3 mb-2 mb-sm-0">
<div class="avatar-name" style="color: white;"><strong></strong>
#{{ $ticketDatas->generateticket_id}} -- {{ $ticketDatas->subject}}
                    </div>

                </div> --}}
                <div class="inbox-date ml-auto">
                    <div><span class="badge badge-info">@if($mis->status==0)
                            <span>Created</span>
                            @elseif($mis->status==2)
                            <span>Re Submitted</span>
                            @elseif($mis->status==1)
                            <span> Submitted</span>
                            @else
                            <span>Approved</span>
                            @endif</span></span></div>
                    <div><small>{{ date('F jS', strtotime($mis->created_at)) }},
                            {{ date('H:i A', strtotime($mis->created_at)) }}</small></div>
                </div>
            </div>


            <div class="inbox-mail-details p-3">
                <div class="row">
                    <div class="card" style="width: 100%;box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2)">
                        <div class="inbox-avatar-wrap p-3 border-btm d-sm-flex">
                            <div class="inbox-avatar-text ml-sm-3 mb-2 mb-sm-0">
                                <div class="avatar-name"><strong></strong>
                                    
                                    <b> {{ $mis->clientlogin->name ??''}}</b>
                                </div>
                                <p>{!! $mis->instruction !!}</p>


                                @if($mis->misphoto['0'] != null)

                                <h5> <i class="fa fa-paperclip"></i> Attachments </h5>
                                <div class="row">
                                @foreach($mis->misphoto as $misphotos)
                                 
                                     
                            @if (pathinfo($misphotos->attachment, PATHINFO_EXTENSION) == 'psd')
                            <div class="col-3 col-lg-2">
                                <a download target="blank"
                                href="{{url('/backEnd/image/mis/'.$misphotos->attachment)}}"><img
                                        class="img-thumbnail img-responsive" alt="attachment"
                                        src="{{url('/backEnd/dist/img/psd.png')}}">
                                </a>
                            </div>
                            @else
                            <div class="col-3 col-lg-2">
                                <a data-toggle="modal"id="editCompany" data-id="{{ $misphotos->id }}" data-target=".bd-example-modal-lg"><img
                                        class="img-thumbnail img-responsive" alt="attachment"
                                        src="{{url('/backEnd/image/compressmis/'.$misphotos->attachment)}}">
                                </a>
                            </div>
                          @endif
                               @endforeach
                                </div>
                                @endif
                               
                            </div>
                            <div class="inbox-date ml-auto">
                                <div><span class="badge badge-info">{{ $mis->serailno }}</span></div>
                                <div><small>{{ date('F jS', strtotime($mis->created_at)) }},
                                        {{ date('h:i A', strtotime($mis->created_at)) }}</small>
                                </div>
                            </div>
                        </div>
                        @foreach($misLists as $misList)
                        <div class="inbox-avatar-wrap p-3 border-btm d-sm-flex">
                            <div class="inbox-avatar-text ml-sm-3 mb-2 mb-sm-0">
                                <div class="avatar-name"><strong></strong>
                                 
                                    <b> {{ $misList->teammemberlogin->team_member ??''}}</b>
                               
                                  
                                </div>
                                <p>{!! $misList->remark !!}</p>


                                @if(!empty($misList->misphoto['0']->attachment))
 
                                <h5> <i class="fa fa-paperclip"></i> Attachments </h5>
                                <div class="row">
                                    @foreach($misList->misphoto as $misphotos)
                                    @if($misphotos->attachment != null)
                          
                            @if (pathinfo($misphotos->attachment, PATHINFO_EXTENSION) == 'psd')
                            <div class="col-3 col-lg-2">
                                <a download target="blank"
                                href="{{url('/backEnd/image/mis/'.$misphotos->attachment)}}"><img
                                        class="img-thumbnail img-responsive" alt="attachment"
                                        src="{{url('/backEnd/dist/img/psd.png')}}">
                                </a>
                            </div>
                            @else
                            <div class="col-3 col-lg-2">
                                <a data-toggle="modal"id="editCompany" data-id="{{ $misphotos->id }}" data-target=".bd-example-modal-lg"><img
                                        class="img-thumbnail img-responsive" alt="attachment"
                                        src="{{url('/backEnd/image/compressmis/'.$misphotos->attachment)}}">
                                </a>
                            </div>
                          @endif
                            @endif
                       @endforeach
                                </div>
                                @endif
                                @if($misList->remarks != null)
                                <hr>
                                <div class="avatar-name"><strong></strong>
                                 
                                    <b> {{ $misList->clientlogin->name ??''}}</b>
                                </div>
                                <p>{!! $misList->remarks !!}</p>
                                 @endif
                                  @if($misList->misphoto != null)

                     
                        <div class="row">
                            @foreach($misList->misphoto as $misphotos)
                            @if($misphotos->clientattachment != null)
                            @if (pathinfo($misphotos->clientattachment, PATHINFO_EXTENSION) == 'psd')
                            <div class="col-3 col-lg-2">
                                <a download target="blank"
                                href="{{url('/backEnd/image/mis/'.$misphotos->clientattachment)}}"><img
                                        class="img-thumbnail img-responsive" alt="attachment"
                                        src="{{url('/backEnd/dist/img/psd.png')}}">
                                </a>
                            </div>
                            @else
                            <div class="col-3 col-lg-2">
                                <a data-toggle="modal"id="editCompany" data-id="{{ $misphotos->id }}" data-target=".bd-examplee-modal-lg"><img
                                        class="img-thumbnail img-responsive" alt="attachment"
                                        src="{{url('/backEnd/image/compressmis/'.$misphotos->clientattachment)}}">
                                </a>
                            </div>
                          @endif
                          @endif
                       @endforeach
                        </div>
                        @endif
                            </div>
                            <div class="inbox-date ml-auto">
                                <div><span class="badge badge-info">{{ $misList->serailno }}</span></div>
                                <div><small>{{ date('F jS', strtotime($misList->created_at)) }},
                                        {{ date('h:i A', strtotime($misList->created_at)) }}</small>
                                </div>
                            </div>
                        </div>

                        @endforeach
                        @if($mis->status != 3)
                        <div id="panel" class="mt-3 p-3">
                            <form method="post" action="{{ url('client/misclient/update')}}"
                                enctype="multipart/form-data">
                                @csrf

                                <p><textarea id='designationnn' style="display: none;" class="centered form-control"
                                        rows="5" name="remarks" value="" placeholder="Enter Remark"></textarea><br>
                                    <div class="row">

                                        <div class="col-4">
                                            <select name="status" id="clientmis" class="form-control">
                                                <!--placeholder-->
                                                @if(Request::is('client/mis/details/*')) >
                                                @if($mis->status=='0')
                                                <option value="0">Created</option>
                                                <option value="3">Approved</option>
                                                <option value="2">Re Submitted</option>

                                                @elseif($mis->status=='3')
                                                <option value="3">Approved</option>
                                                <option value="2">Re Submitted</option>
                                                <option value="0">Created</option>

                                                @else
                                                <option value="2">Re Submitted</option>
                                                <option value="3">Approved</option>
                                               <option value="0">Created</option>

                                                @endif
                                                @else

                                                <option value="">Please Select One</option>
                                                <option value="0">Created</option>
                                                <option value="3">Approved</option>
                                                <option value="2">Re Submitted</option>
                                                @endif
                                            </select>
                                            <input type="text" hidden name="missno" value="{{ $mis->sno }}">
                                        </div>
                                        <div class="col-4" id='designationn' style="display:none;">
                                            <input class="form-control" name="clientattachment[]" multiple="multiple" type="file">
                                        </div>
                                        <div class="col-4">
                                            <button type="submit" class="btn btn-success" style="float:right">
                                                Submit</button></div>
                                    </div>
                                </p>
                            </form>
                        </div>
                        @endif
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
</div>

</div>
<!--/.body content-->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #37A000">
                <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Preview</h5>
         
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
<div class="modal fade bd-examplee-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleeModalLabel3" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #37A000">
                <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Prview</h5>
         
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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

                url: "{{ url('/client/misimage') }}",
                data: "id=" + id,

                success: function (response) {
                    var img = '<img class="img-thumbnail img-responsive" src="{{ url('/backEnd/image/mis/')}}/'+response.attachment+'" width="1000">';
                    var clientimg = '<img class="img-thumbnail img-responsive" src="{{ url('/backEnd/image/mis/')}}/'+response.clientattachment+'" width="1000">';
                    var imgdwnld = '<a download href="{{ url('/backEnd/image/mis/')}}/'+response.attachment+'"  class="btn btn-success"><i class="fa fa-download"> Download</i></a>';
                    var clientimgdwnld = '<a download href="{{ url('/backEnd/image/mis/')}}/'+response.clientattachment+'"  class="btn btn-success"><i class="fa fa-download"> Download</i></a>';
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
