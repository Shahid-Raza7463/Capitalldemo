
@extends('backEnd.layouts.layout')
 @section('backEnd_content')
 <div class="body-content">
 <div class="mailbox">
    
    <div class="mailbox-body">
        <div class="row m-0">
            
            <div class="col-md-12 col-lg-12 p-0 inbox-mail">
                <div class="inbox-avatar-wrap p-3 border-btm d-sm-flex">
                  
                    <div class="inbox-avatar-text ml-sm-3 mb-2 mb-sm-0">
                        <div class="avatar-name"><strong>Subject: </strong>
                           {{$article->subject}}
                        </div>
                        <div><small><strong>Related To : </strong> {{$article->name}}</small></div>
                    </div>
                    <div class="inbox-date ml-auto">
                        <div><span class="badge badge-info">Created On </span></div>
                        <div><small>{{date('d-M-Y', strtotime($article->created_at))}}</small></div>
                    </div>
                </div>
                <div class="inbox-mail-details p-3">
                    {!!$article->description!!}
                  
                   
                    
                </div>
            </div>
        </div>
    </div>
</div>
 </div>
@endsection