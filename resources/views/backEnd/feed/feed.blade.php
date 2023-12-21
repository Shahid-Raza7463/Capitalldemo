@extends('backEnd.layouts.layout')
@section('backEnd_content')

@php 
$feed=Feed::loadRss('https://economictimes.indiatimes.com/industry/banking/finance/rssfeeds/13358259.cms');
//$feed_ind=Feed::loadRss('https://indiankanoon.org/feeds/latest/delhi/');
//$feed_sebi=Feed::loadRss('https://www.sebi.gov.in/sebirss.xml');
$feed_press=Feed::loadRss('https://rbi.org.in/pressreleases_rss.xml');
$feed_noti=Feed::loadRss('https://rbi.org.in/notifications_rss.xml');
$feed_tender=Feed::loadRss('https://rbi.org.in/tenders_rss.xml');

@endphp
{{--dd($feed_tender)--}}

    <style>
    .scroll {
    max-height: 300px;
    overflow-y: auto;
}
  </style>
  
  <style>
   .slider {
    top: 1em;
    position: relative;
    box-sizing: border-box;
    animation: slider 15s linear infinite;
    list-style-type: none;
    text-align: center;
}

.slider:hover {
    animation-play-state: paused;
}

@keyframes slider {
    0%   { top:   10em }
    100% { top: -14em }
}

.blur .slider {
  	margin: 0;
    padding: 0 1em;
    line-height: 1.5em;
}

.blur:before, .blur::before,
.blur:after,  .blur::after {
    left: 0;
    z-index: 1;
    content: '';
    position: absolute;
    width: 100%; 
    height: 2em;
    background-image: linear-gradient(180deg, #FFF, rgba(255,255,255,0));
}

.blur:after, .blur::after {
    bottom: 0;
    transform: rotate(180deg);
}

.blur:before, .blur::before {
    top: 0;
}
  </style>


 <!--/.Content Header (Page header)--> 
 <div class="body-content">
     <div class="row">
        <div class="col-md-1"></div>
    <div class="card mb-4 col-md-5">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 font-weight-600 mb-0">Economic Times Rss Feed </h6>
                </div>
              
            </div>
        </div>
        <div class="card-body scroll">
            @foreach($feed->item as $item)
            <div class="slider">
            <div><a href="{{$item->link}}">{{$item->title}}
            <small class="small">{{date("d/m/Y", strtotime($item->pubDate))}}</small></a></div>
            <div>{!!$item->description!!}</div></div>
           <br>
            @endforeach
        </div>
    </div>
    <br>
    <div class="col-md-1"></div>
    <div class="card mb-4 col-md-5" style="margin-left: -60px;">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 font-weight-600 mb-0"> RBI for Press Releases Rss Feed</h6>
                </div>
               
            </div>
        </div>
        <div class="card-body scroll">
            @foreach($feed_press->item as $item)
            <div class="slider">
            <div><a href="{{$item->link}}">{{$item->title}}</a></div></div>
            
            <br>
            @endforeach
        </div>
    </div>
     </div>
     <div class="row">
        <div class="col-md-1"></div>
       {{-- <div class="card mb-4 col-md-5">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0">Sebi Rss Feed </h6>
                    </div>
                  
                </div>
            </div>
            <div class="card-body scroll">
                @foreach($feed_sebi->item as $item)
                <div class="slider"> 
                 <div><a href="{{$item->link}}">{{$item->title}}
                <small class="small">{{date("d/m/Y", strtotime($item->pubDate))}}</small></a></div>
                </div>
             <br>
                @endforeach
            </div>
        </div> --}}
        <div class="col-md-1"></div>
        <div class="card mb-4 col-md-5" style="margin-left: -60px;">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0">RBI for notifications Rss Feed </h6>
                    </div>
                  
                </div>
            </div>
            <div class="card-body scroll">
                @foreach($feed_noti->item as $item)
                <div class="slider">
                 <div><a href="{{$item->link}}">{{$item->title}}
                <small class="small">{{date("d/m/Y", strtotime($item->pubDate))}}</small></a></div>
                </div>
             <br>
                @endforeach
            </div>
        </div>
     </div>
 </div>
      
        <!--/.body content-->
{{--dd($feed)--}}
@endsection