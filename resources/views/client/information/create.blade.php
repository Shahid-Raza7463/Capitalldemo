
@extends('client.layouts.layout') @section('client_content')
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
<div class="body-content">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                     
                        <div class="col-md-6">
                            <h6 class="fs-17 font-weight-600 mb-0">Add Information Answer</h6>
                        </div>
                        <div class="col-md-6">
							<p style="float: right;"><a data-toggle="modal" data-target="#exampleModal1" ><b>ILR Log</b></a></p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ url('client/information/store')}}" enctype="multipart/form-data">
                        @csrf
              <div>
    @if(session()->has('success'))
    <div class="alert alert-success">
        @if(is_array(session()->get('success')))
        @foreach (session()->get('success') as $message)
        <p>{{ $message }}</p>
        @endforeach
        @else
        <p>{{ session()->get('success') }}</p>
        @endif
    </div>
    @endif
    @if(session()->has('statuss'))
    <div class="alert alert-danger">
      @if(is_array(session()->get('statuss')))
      @foreach (session()->get('statuss') as $message)
          <p>{{ $message }}</p>
      @endforeach
      @else
          <p>{{ session()->get('success') }}</p>
      @endif
    </div>
@endif
    <div>
        <ul>
            @foreach ($errors->all() as $e)
            <li style="color:red;">{{$e}}</li>
            @endforeach
        </ul>
    </div></div>
                        @include('client.information.form')
                    </form>
                   
                    <hr class="my-4">
                    <div class="table-responsive">
                <table class="table display table-bordered table-striped table-hover basic">
                    <thead>
                        <tr>
                             <th>Attachment</th>
                             <th>Remark</th>
							  <th>Uploaded by</th>
                             <th>Date</th>
                             
                                               
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ilranswers as $ilranswer)
                        <tr>
                           {{-- <td><a class="files" target="blank"
                                href="{{ url('storage/app/backEnd/image/document/'. $ilranswer->url) }}" download>
                                {{$ilranswer->url??''}}</a></td> --}}
							<td><a 
                                    href="{{ url('client/ilr/download/'. Crypt::encrypt($ilranswer->id)) }}"
                                    >
                                    {{$ilranswer->url??''}}</a></td> 
                            <td>{{$ilranswer->remark }}</td>
							 <td>@if($ilranswer->team_member != null){{$ilranswer->team_member }}
								 @else{{$ilranswer->name }}@endif</td>
                            <td>{{ date('h:i a F d,Y', strtotime($ilranswer->updated_at)) }}</td>
                            

                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
           {{-- <button onclick="initiatedownload(event)" class="btn mr-2" style="float:right; background: grey; border-radius: 0.3rem;"> Download All</button> --}}
                </div>
            </div>
        </div>
    </div>
</div>
<!--/.body content-->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="height:340px;">
         
                <div class="modal-header" style="background: #37A000">
                    <h5 class="modal-title font-weight-600" id="exampleModalLabel4" style="color: white">ILR log</h5>
                    <div>
                        <ul>
                            @foreach ($errors->all() as $e)
                            <li style="color:red;">{{$e}}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
              <div class="modal-body">
                <div class="form-group">
                    
                    <div class="mb-4 example" style="height: 250px;">
                        <div class="list-group list-group-flush ">
                            <ul class="list-unstyled " >
                                @if(count($ilrlog)>0)
                                @foreach($ilrlog as $ilrlogData)
                                <li class="list-group-item list-group-item-action " >
                                    <h5>
                                        <small>{{$ilrlogData->description}} </small>
                                        <span
                                            style="color:#007bff;font-size: small;">{{$ilrlogData->team_member}}
                                        </span>
                                        <span
                                            style="color:#007bff;font-size: small;">{{$ilrlogData->name}}
                                        </span>
                                    </h5>
                                    <small class="text-muted"><i class="far fa-clock mr-1"></i>
                                        {{ date('h:i a', strtotime($ilrlogData->created_at)) }},
                                        {{ date('F jS', strtotime($ilrlogData->created_at)) }}</small>
                                </li>
                                @endforeach
                                @else
                                <li class="list-group-item list-group-item-action">
                                    <br><br><br>
                                    <h5 style="text-align: center"><span>No Data</span></h5>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                </div>
           
        </div>
    </div>
</div>
<script type="text/javascript">
    function initiatedownload(event)
    {
        event.preventDefault();
        $('.files')
    }
</script>

@endsection
