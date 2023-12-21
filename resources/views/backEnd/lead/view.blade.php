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
<time class="fs-13 font-weight-600 text-muted" datetime="1988-10-24">{{ $lead->team_member}}</time>
</div>
</div>
<hr>
<div class="row align-items-center">
    <div class="col">
        <h6 class="mb-0 font-weight-600">Assign Date</h6>
    </div>
    <div class="col-auto">
        <time class="fs-13 font-weight-600 text-muted" datetime="1988-10-24">
            <td>{{ date('d/m/Y', strtotime($lead->created_at)) }}</td>

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
            @if($lead->status==0)
            <span>open</span>
            @elseif($lead->status==1)
            <span>working</span>
            @elseif($lead->status==2)
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
                    <div class="card-header"
                        style="margin-top: -15px;margin-left: -15px;width: 114%;background: #37A000;color: white;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="row">
                                <h6 class="fs-17 font-weight-600 mb-0">Lead Status Data</h6>
                                <a style="background: aliceblue;margin-left: 9px;margin-top: -4px;"
                                    href="{{url('/lead/'.$lead->id.'/edit')}}" class="btn btn-danger-soft btn-sm"><i
                                        class="fas fa-edit"></i></a>

                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="    padding: 0.5rem;">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 font-weight-600">Client </h6>
                            </div>
                            <div class="col-auto">
                                <time class="fs-13 font-weight-600 text-muted" datetime="1988-10-24">
                                    @if(!empty($lead->client_name)){{ $lead->client_name ??'' }}@else
                                    {{ $lead->client_names ??'' }}@endif
                                </time>
                            </div>
                        </div>
                        <hr>
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 font-weight-600">Created by </h6>
                            </div>
                            <div class="col-auto">
                                <time class="fs-13 font-weight-600 text-muted"
                                    datetime="1988-10-24">{{ $lead->team_member}}
                                </time>
                            </div>
                        </div>

                        <hr>
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 font-weight-600">Observer</h6>
                            </div>
                            <div class="col-auto">
                                <time class="fs-13 font-weight-600 text-muted" datetime="1988-10-24">
                                    @php
                                    $Observer = DB::table('teammembers')
                                    ->where('id', $lead->teammember_id)->first();
                                    @endphp
                                    {{ $Observer->team_member ??''}}
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
                                    @if($lead->status==3)
                                    <span class="badge badge-pill badge-warning">Follow Up</span>
                                    @elseif($lead->status==1)
                                    <span class="badge badge-pill badge-info">Proposal Sent</span>
                                    @elseif($lead->status==0)
                                    <span class="badge badge-pill badge-success">Fresh</span>

                                    @else
                                    <span class="badge badge-pill badge-danger">Decline</span>
                                    @endif
                                </time>
                            </div>
                        </div>
                        <hr>
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 font-weight-600">Contact Details</h6>
                            </div>
                            <div class="col-auto">
                                <time class="fs-13 font-weight-600 text-muted" datetime="1988-10-24">
                                    <span> {{ $lead->contactperson ??'' }}</span><br>
                                    <span> {{ $lead->contactemail ??'' }}</span><br>
                                    <span> {{ $lead->contactphone ??'' }}</span><br>
                                    <span> {{ $lead->designation ??'' }}</span>
                                </time>
                            </div>
                        </div>
                        <hr>
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 font-weight-600">Address</h6>
                            </div>
                            <div class="col-auto">
                                <time class="fs-13 font-weight-600 text-muted" datetime="1988-10-24">
                                    {!! $lead->address !!}
                                </time>
                            </div>
                        </div>
                        <hr>
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0 font-weight-600">Description</h6>
                            </div>
                            <div class="col-auto">
                                <time class="fs-13 font-weight-600 text-muted" datetime="1988-10-24">
                                    {!! $lead->description !!}
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
                    {{-- <div class="inbox-avatar-text ml-sm-3 mb-2 mb-sm-0">
                        <div class="avatar-name" style="
    color: white;
"><strong></strong>
                            #{{ $lead->generateticket_id}} -- {{ $lead->subject}}
                </div>

            </div> --}}
            <div class="inbox-date ml-auto">
                <div>@if($lead->status==3)
                    <span class="badge badge-pill badge-warning">Follow Up</span>
                    @elseif($lead->status==1)
                    <span class="badge badge-pill badge-info">Proposal Sent</span>
                    @elseif($lead->status==0)
                    <span class="badge badge-pill badge-success">Fresh</span>

                    @else
                    <span class="badge badge-pill badge-danger">Decline</span>
                    @endif</div>
                <div><small>{{ date('F jS', strtotime($lead->created_at)) }},
                        {{ date('H:i A', strtotime($lead->created_at)) }}</small></div>
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
 <div class="inbox-avatar-wrap p-3 border-btm d-sm-flex">
                        <div class="inbox-avatar-text ml-sm-3 mb-2 mb-sm-0">
                            <div class="avatar-name"><strong></strong>
                                
                                <b>  {{ $lead->team_member}}</b>
                            </div>
                            <p>   @if(!empty($lead->client_name)){{ $lead->client_name ??'' }}@else
                                {{ $lead->client_names ??'' }}@endif</p>
                                @php
                                $leadfiles = DB::table('leadfiles')->where('leadid',$lead->id)->get();
   
                             @endphp

                            @if($leadfiles->isNotEmpty())

                            <h5> <i class="fa fa-paperclip"></i> Attachments </h5>
                            <div class="row">
                            @foreach($leadfiles as $leadfilesData)
                        <div class="col-3 col-lg-2">
                            <a download  data-toggle="tooltip"  title="{{ $leadfilesData->file }}" target="blank"
                            href="{{ Storage::disk('s3')->temporaryUrl('lead/'.$leadfilesData->file, now()->addMinutes(10)) }}" target="blank"> <img
                            class="img-thumbnail img-responsive" alt="attachment"
                            src="{{url('/backEnd/fileicon.jpg')}}"> </a> , <br>
                        </div>
                           @endforeach
                            </div>
                            @endif
                           
                        </div>
                        <div class="inbox-date ml-auto">
                           
                            <div><small>{{ date('F jS', strtotime($lead->created_at)) }},
                                    {{ date('h:i A', strtotime($lead->created_at)) }}</small>
                            </div>
                        </div>
                    </div>
                    @foreach($leadData as $leads)
                    <div class="inbox-avatar-wrap p-3 border-btm d-sm-flex">
                        <div class="inbox-avatar-text ml-sm-3 mb-2 mb-sm-0">
                            <div class="avatar-name"><strong></strong>
                                <b>{{ $leads->team_member ??''}}</b>

                            </div>
                            <p>{!! $leads->remark !!}</p>
                            @if($leads->attachment != null)

                            <h5> <i class="fa fa-paperclip"></i> Attachments </h5>
                            <div class="row">
                                <div class="col-3 col-lg-2">
                                    <a download target="blank"
                                        href="{{url('/backEnd/image/lead/'.$leads->attachment)}}"><img
                                            class="img-thumbnail img-responsive" alt="attachment"
                                            src="{{url('/backEnd/image/lead/'.$leads->attachment)}}">
                                    </a>
                                </div>

                            </div>
                            @endif
                        </div>
                        <div class="inbox-date ml-auto">
                            <div>@if($leads->status==3)
                                <span class="badge badge-pill badge-warning">Follow Up</span>
                                @elseif($leads->status==1)
                                <span class="badge badge-pill badge-info">Proposal Sent</span>
                                @elseif($leads->status==0)
                                <span class="badge badge-pill badge-success">Fresh</span>

                                @else
                                <span class="badge badge-pill badge-danger">Decline</span>
                                @endif</div>
                            <div><small>{{ date('F jS', strtotime($leads->updated_at)) }},
                                    {{ date('h:i A', strtotime($leads->updated_at)) }}</small></div>
                        </div>
                    </div>

                    @endforeach
                    <div id="panel" class="mt-3 p-3">

                        <form method="post" action="{{ url('lead/observer') }}" enctype="multipart/form-data">
                            @csrf
                            <p><textarea class="centered form-control" rows="5" name="remark" value=""
                                    placeholder="Enter Remark"></textarea><br>
                                <div class="row">
                                    <div class="col-4">
                                        <select name="status" class="form-control">
                                            <!--placeholder-->
                                            @if(Request::is('lead/*/edit')) >
                                            @if($lead->status=='0')
                                            <option value="0">fresh</option>
                                            <option value="1">proposal sent</option>
                                            <option value="2">decline</option>
                                            <option value="3">followup</option>

                                            @elseif($lead->status=='1')
                                            <option value="1">proposal sent</option>
                                            <option value="2">decline</option>
                                            <option value="0">fresh</option>
                                            <option value="3">followup</option>

                                            @elseif($lead->status=='2')
                                            <option value="2">decline</option>
                                            <option value="1">proposal sent</option>
                                            <option value="0">fresh</option>
                                            <option value="3">followup</option>


                                            @else
                                            <option value="3">followup</option>
                                            <option value="2">decline</option>
                                            <option value="1">proposal sent</option>
                                            <option value="0">fresh</option>

                                            @endif
                                            @else
                                            <option value="1">proposal sent</option>
                                            <option value="2">decline</option>
                                            <option value="0">fresh</option>
                                            <option value="3">followup</option>
                                            @endif
                                        </select></div>
                                    <div class="col-1">
                                        <input hidden class="form-control" name="lead_id" value="{{ $id}}" type="text">
                                    </div>
                                    <div class="col-3">
                                        <input class="form-control" name="attachment" type="file">
                                    </div>
                                    <div class="col-4">
                                        <button type="submit" class="btn btn-success" style="float:right">
                                            Submit</button>
                                        <a style="margin-left: 82px;" class="btn btn-secondary"
                                            href="{{ url('lead') }}">
                                            Back</a>
                                    </div>

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
