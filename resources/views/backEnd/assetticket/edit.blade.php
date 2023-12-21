@extends('backEnd.layouts.layout') @section('backEnd_content')
{{-- <style>
    #panel {
        display: none;
    }

</style> --}}
<div class="body-content">
    {{-- <div class="row">
<div class="col-md-12 col-lg-4">
<div class="card mb-4">
<div class="card-header">
<div class="d-flex justify-content-between align-items-center">
<div>
<h6 class="fs-17 font-weight-600 mb-0">Ticket Informtion</h6>
</div>
</div>
</div>
<div class="card-body">
<div class="row align-items-center">
<div class="col">
<h6 class="mb-0 font-weight-600">Created by </h6>
</div>
<div class="col-auto">
<time class="fs-13 font-weight-600 text-muted" datetime="1988-10-24">{{ $ticketDatas->team_member}}</time>
</div>
</div>
<hr>
<div class="row align-items-center">
    <div class="col">
        <h6 class="mb-0 font-weight-600">Assign Date</h6>
    </div>
    <div class="col-auto">
        <time class="fs-13 font-weight-600 text-muted" datetime="1988-10-24">
            <td>{{ date('d/m/Y', strtotime($ticketDatas->created_at)) }}</td>

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
            @if($ticketDatas->status==0)
            <span>open</span>
            @elseif($ticketDatas->status==1)
            <span>working</span>
            @elseif($ticketDatas->status==2)
            <span>close</span>
            @else
            <span>reject</span>
            @endif
        </time>
    </div>
</div>

</div>
</div>
</div>
<div class="col-md-12 col-lg-8">

</div>
</div> --}}
<div class="mailbox">
    {{-- <div class="mailbox-header d-flex align-items-center justify-content-between">
<div class="inbox-avatar-wrap d-flex align-items-center"><img src="assets\dist\img\avatar-1.jpg" class="inbox-avatar border-green" alt="">
<div class="inbox-avatar-text d-none d-sm-inline-block ml-3">
<h6 class="avatar-name mb-0">Naeem Khan</h6>
<span>Mailbox</span>
</div>
</div>
<div class="inbox-toolbar btn-toolbar">
<div class="btn-group">
<a href="compose.html" class="btn btn-success"><i class="far fa-edit"></i></a>
</div>
<div class="btn-group ml-1">
<a href="" class="btn btn-secondary"><span class="fa fa-reply"></span></a>
<a href="" class=" btn btn-secondary d-none d-lg-block"><span class="fa fa-reply-all"></span></a>
<a href="" class="btn btn-secondary"><span class="fa fa-share"></span></a>
</div>
<div class="btn-group ml-1">
<button type="button" class="btn btn-secondary" onclick="myFunction()"><span class="fa fa-print"></span></button>
</div>
<div class="btn-group ml-1 d-none d-lg-flex">
<button type="button" class="text-center btn btn-danger"><span class="fa fa-exclamation"></span></button>
<button type="button" class="btn btn-danger"><span class="fa fa-trash"></span></button>
</div>
</div>
</div> --}}
    <div class="mailbox-body">
        <div class="row m-0">
            <div class="col-lg-3 p-0 inbox-nav d-none d-lg-block">
                <div class="mailbox-sideber">
                    <div class="card-header" style="
    margin-top: -15px;
    margin-left: -15px;
    width: 114%;
    background: #37A000;
    color: white;
">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fs-17 font-weight-600 mb-0">Ticket Informtion</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 font-weight-600">Created by </h6>
                            </div>
                            <div class="col-auto">
                                <time class="fs-13 font-weight-600 text-muted"
                                    datetime="1988-10-24">{{ $ticketDatas->team_member}}
                                    ({{ $ticketDatas->rolename }})</time>
                            </div>
                        </div>
                        <hr>
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 font-weight-600">Created Date</h6>
                            </div>
                            <div class="col-auto">
                                <time class="fs-13 font-weight-600 text-muted" datetime="1988-10-24">
                                    <td>{{ date('F d,Y', strtotime($ticketDatas->created_at)) }}   {{ date('h:i A', strtotime($ticketDatas->created_at)) }}</td>

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
                                    @if($ticketDatas->status==0)
                                    <span class="badge badge-success">open</span>
                                    @elseif($ticketDatas->status==1)
                                    <span class="badge badge-Warning">working</span>
                                    @elseif($ticketDatas->status==2)
                                    <span class="badge badge-primary">close</span>
                                    @else
                                    <span class="badge badge-danger">reject</span>
                                    @endif
                                </time>
                            </div>
                        </div>
						<hr>
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 font-weight-600">Priority</h6>
                            </div>
                            <div class="col-auto">
                                <time class="fs-13 font-weight-600 text-muted" datetime="1988-10-24">
                                  @if($ticketDatas->priority==0 )
                                <span >High</span>
                                @elseif($ticketDatas->priority==1 )
                                <span>Medium</span>
                                @else
                                <span>Low</span>
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
                <div class="inbox-avatar-wrap p-3 border-btm d-sm-flex" style="
    color: white;
    margin-top: -21px;
    background: #37A000;
">
                    <div class="inbox-avatar-text ml-sm-3 mb-2 mb-sm-0">
                        <div class="avatar-name" style="
    color: white;
"><strong></strong>
                            #{{ $ticketDatas->generateticket_id}} -- {{ $ticketDatas->subject}}
                        </div>

                    </div>
                    <div class="inbox-date ml-auto">
                        <div><span class="badge badge-info">@if($ticketDatas->status==0)
                                <span>open</span>
                                @elseif($ticketDatas->status==1)
                                <span>working</span>
                                @elseif($ticketDatas->status==2)
                                <span>close</span>
                                @else
                                <span>reject</span>
                                @endif</span></div>
                        <div><small>{{ date('F jS', strtotime($ticketDatas->created_at)) }},
                                {{ date('H:i A', strtotime($ticketDatas->created_at)) }}</small></div>
                    </div>
                </div>
               <!-- <div class="inbox-avatar-wrap p-3 border-btm d-sm-flex" style="background-color: lightgray">
                    <div class="inbox-avatar-text ml-sm-3 mb-2 mb-sm-0">
                        <a href="" class="btn btn-secondary"><span class="fa fa-reply"></span> reply</a>
                    </div>
                    <div class="inbox-date ml-auto">
                        <p class="btn btn-secondary" onclick="myFunction()"><span class="fas fa-plus"></span></p>

                    </div>
                </div>-->
                
                <div class="inbox-mail-details p-3">
                    <div class="row">
                        <div class="card" style="width: 100%;box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2)">
                            <div class="inbox-avatar-wrap p-3 border-btm d-sm-flex" >
                                <div class="inbox-avatar-text ml-sm-3 mb-2 mb-sm-0">
                                    <div class="avatar-name"><strong></strong>
                                        <b>{{ $ticketDatas->team_member}}</b>
                                        ({{ $ticketDatas->rolename }})
                                        <p>{{ $ticketDatas->message}}</p>
                                        
                                @if($ticketDatas->attachment != null)
                                <h5> <i class="fa fa-paperclip"></i> Attachments </h5>
                                <div class="row">
                                    <div class="col-3 col-lg-2">
                                        <a href="#"><img class="img-thumbnail img-responsive" alt="attachment"
                                                src="{{ asset('backEnd/image/ticketattachment/'.$ticketDatas->attachment) }}">
                                        </a>
                                    </div>
                                </div>
                                @endif
                                    </div>
            
                                </div>
                                <div class="inbox-date ml-auto">
                                
                                    <div><small>{{ date('F jS', strtotime($ticketDatas->created_at)) }},
                                            {{ date('h:i A', strtotime($ticketDatas->created_at)) }}</small></div>
                                </div>
                            </div>
                            <br>
                            @foreach($ticketreply as $ticketreplyData)
                            <div class="inbox-avatar-wrap p-3 border-btm d-sm-flex">
                                <div class="inbox-avatar-text ml-sm-3 mb-2 mb-sm-0">
                                    <div class="avatar-name"><strong></strong>
                                     <b>   {{ $ticketreplyData->team_member}}</b>
                                     
                                    </div>
                                    <p>{{ $ticketreplyData->reply}}</p>

                              
                                    @if($ticketreplyData->attachment != null)
                                
                                    <h5> <i class="fa fa-paperclip"></i> Attachments </h5>
                                    <div class="row">
                                        <div class="col-3 col-lg-2">
                                            <a href="#"><img class="img-thumbnail img-responsive" alt="attachment"
                                                    src="{{ asset('backEnd/image/ticketreplyattachment/'.$ticketreplyData->attachment) }}">
                                            </a>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="inbox-date ml-auto">
                                   
                                    <div><small>{{ date('F jS', strtotime($ticketreplyData->created_at)) }},
                                            {{ date('h:i A', strtotime($ticketreplyData->created_at)) }}</small></div>
                                </div>
                            </div>
                           
                            @endforeach
                            <div id="panel" class="mt-3 p-3">
                                <form method="post" action="{{ url('ticket/reply') }}" enctype="multipart/form-data">
                                    @csrf
                                <p ><textarea class="centered form-control" rows="5" name="reply" value="" 
                                        placeholder="Enter Reply Communication"></textarea><br>
                                        <div class="row">
                                            <div class="col-4"> 
                                                <input class="form-control" name="attachment" type="file">
                                                <input hidden class="form-control" name="ticketid" value="{{ $ticketDatas->generateticket_id}}" type="text"></div>
                                                <div class="col-4">         
                                                <select name="status" id="exampleFormControlSelect2" class="form-control">
                                                    <!--placeholder-->
                                                    @if(Request::is('ticket/*'))
                                                    @if($ticketDatas->status=='0')
                                                    <option value="0">Open</option>
                                                    <option value="1">Working</option>
                                                    <option value="2">Close</option>
                                                   
                                                    @elseif($ticketDatas->status=='1')
                                                    <option value="1">Working</option>
                                                    <option value="0">Open</option>
                                                   <option value="2">Close</option>

                                                    @else
                                                    <option value="2">Close</option>
                                                    <option value="1">Working</option>
                                                    <option value="0">Open</option>
                                                   
                                                    
                                        
                                                    @endif
                                                    @else
                                        
                                                    <option value="">Please Select One</option>
                                                    <option value="0">Assigned</option>
                                                    <option value="1">Return</option>
                                                    @endif
                                                </select></div>
                                                 <div class="col-4"> 
													     @if($ticketDatas->status!='2')<button type="submit" class="btn btn-success" style="float:right"> Submit</button>@endif</div>
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
<script>
    function myFunction() {
        document.getElementById("panel").style.display = "block";
    }

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script><script src="{{ url('backEnd/ckeditor/ckeditor.js')}}"></script>

<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ), {
            // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
        } )
        .then( editor => {
            window.editor = editor;
        } )
        .catch( err => {
            console.error( err.stack );
        } );
</script>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor1' ), {
            // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
        } )
        .then( editor => {
            window.editor = editor;
        } )
        .catch( err => {
            console.error( err.stack );
        } );
</script>
@endsection

<!--Page Active Scripts(used by this page)-->
<script src="{{ url('backEnd/dist/js/pages/forms-basic.active.js')}}"></script>
<!--Page Scripts(used by all page)-->
<script src="{{ url('backEnd/dist/js/sidebar.js')}}"></script>
