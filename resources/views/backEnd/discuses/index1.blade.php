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
			@if(Auth::user()->role_id == 11 || Auth::user()->teammember_id == $discuses->createdby)
			  <li class="breadcrumb-item"><a href="">Edit</a></li>
			@endif
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
                                    <h6 class="mb-0 font-weight-600">Topic.</h6>
                                </div>
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
                                    <h6 class="mb-0 font-weight-600">Raised Date</h6>
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
                                <div class="col-auto">
                                    <time class="fs-13 font-weight-600 text-muted" datetime="1988-10-24">
                                        <td>
                                    {!! $discuses->description !!}
                                 </td>
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
                        style="color: white;height: 61px;margin-top: -16px;background: #37A000;">
                        <!-- <div class="inbox-avatar-text ml-sm-3 mb-2 mb-sm-0">
                       <div class="avatar-name" style="color: white;"><strong></strong>
                          #{{ $discuses->topic ??''}}
                    </div>

                </div> -->
                <div class="inbox-date ml-auto" >
                    <div>  </div>
                    <!-- <div><small>{{ date('F jS', strtotime($discuses->created_at ??'')) }},
                            {{ date('H:i A', strtotime($discuses->created_at??'')) }}</small></div> -->
                
                </div>
            </div>

            <div class="inbox-mail-details p-3">
                <div class="row">
                    <div class="card" style="width: 100%;box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2)">
                    @php 
                                $disjj = DB::table('discusstopics')
                               ->where('discuss_id',$discuses->id)->get();
                            //    dd($disjj);
                                @endphp
                        @foreach($disjj as $disjjData) 
                        <div class="inbox-avatar-wrap p-3 border-btm d-sm-flex">
                            <div class="inbox-avatar-text ml-sm-3 mb-2 mb-sm-0">
                                <div class="avatar-name"><strong></strong>
                                    <p>{!! $disjjData->discuss_topic !!}</p><br>
                                    <small>{{ date('F jS', strtotime($disjjData->updated_at??'')) }},
                                        {{ date('h:i A', strtotime($disjjData->updated_at??'')) }}</small>
                                </div>
                            </div>
                           
                               
                                <div class="actions">
                                 <a href="#" class="action-item"><i class="ti-reload"></i></a>
                                  <div class="dropdown action-item" data-toggle="dropdown" aria-expanded="false">
                                  <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                  <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(30px, 21px, 0px);">
                                    <a href="#" class="dropdown-item">Assign Task</a>
                                    <a href="#" class="dropdown-item">Edit</a>
                                     <a href="#" class="dropdown-item">Delete</a>
                                    </div>
                                    </div>
                                  </div>
                              
                           
                        </div>
                        @endforeach
                        <div class="mt-3 p-3">
                            <form method="post" action="{{url('discuss/update')}}"
                                enctype="multipart/form-data">
                                @csrf
                                <p><textarea required class="centered form-control"
                                        rows="7" name="discuss_topic" value="" placeholder=""></textarea><br>
                                    <div class="row">
                                        <div class="col-4">
                                        <input type="text" hidden name="discuss_id" value="{{ $discuses->id }}">
                                        </div>
                                        <div class="col-4">  
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
                    var img = '<img class="img-thumbnail img-responsive" src="{{ url('/backEnd/image/task/')}}/'+response.attachment+'" width="1000">';
                    var clientimg = '<img class="img-thumbnail img-responsive" src="{{ url('/backEnd/image/task/')}}/'+response.clientattachment+'" width="1000">';
                    var imgdwnld = '<a download href="{{ url('/backEnd/image/task/')}}/'+response.attachment+'"  class="btn btn-success"><i class="fa fa-download"> Download</i></a>';
                    var clientimgdwnld = '<a download href="{{ url('/backEnd/image/task/')}}/'+response.clientattachment+'"  class="btn btn-success"><i class="fa fa-download"> Download</i></a>';
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
