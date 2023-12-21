  <!-- Sidebar  -->
 
  <nav class="sidebar sidebar-bunker">
    <div class="sidebar-header" style="    background-color:#F4F4F5;">
        <!--<a href="index.html" class="logo"><span>bd</span>task</a>-->
        <a href="{{url('home')}}" class="logo"><img src="{{ url('backEnd/image/kgsomanillp.png')}}" style="width: 211px;" alt=""></a>
    </div><!--/.sidebar header-->
    <a href="#" class="profile-element d-flex align-items-center flex-shrink-0">
      
        <div class="avatar online">
            <img src="{{ asset('img/banner/default.png') }}" class="img-fluid rounded-circle" alt="">
        </div>
        <div class="profile-text">
            <h6 class="m-0">{{ DB::table('clientlogins')->select('name')->where('id',Auth::user()->id ??'')->first()->name ?? ''}}</h6>
            <span>{{ DB::table('clients')->select('client_name')->where('id',Auth::user()->client_id ??'')->first()->client_name ?? ''}}</span>
        </div>
    </a><!--/.profile element-->
    <div class="sidebar-body">
        <nav class="sidebar-nav">
            <ul class="metismenu">
                <li class="nav-label">Main Menu</li>
                @if(auth()->user()->client_id == 72)   
                <li class="mm-active">
                    <a class="material-ripple" href="{{route('client.home')}}">
                        <i class="typcn typcn-home-outline mr-2"></i>
                        Dashboard
                    </a>
                   
                </li>
				{{-- <li>
				     <a class="material-ripple" href="{{url('client/ilralllist')}}">
                        <i class="fa fa-file mr-2"></i>
                        Sitemap
                    </a>
                   
                </li> --}}
              @elseif(auth()->user()->client_id == 95)   
                <li><a href="{{url('client/mis')}}"><i class="typcn typcn-document-text outline mr-2"></i>MIS-Photoshop</a></li>
              @else
                @if(auth()->user()->client_id != 72)   
                <li class="mm-active">
                    <a class="material-ripple" href="{{route('client.home')}}">
                        <i class="typcn typcn-home-outline mr-2"></i>
                        Dashboard
                    </a>
                   
                </li>
                    <li><a href="{{url('client/filelist')}}"><i class="typcn typcn-folder mr-2"></i> File Upload by kgsomani</a></li>
                    <li><a href="{{url('client/information')}}"><i class="typcn typcn-book mr-2"></i> Information resource ( IRL )</a></li>
				@endif
				@endif
				 @if(auth()->user()->id == 30 || auth()->user()->id == 31)   
				 <li><a href="{{url('client/internalaudit')}}"><i class="typcn typcn-edit d-block mr-2"></i>Internal Audit</a></li>
				
				@endif
{{--                 
                  <li><a href="{{url('userprofile/'.Auth::user()->id)}}"><i class="typcn typcn-user-outline mr-2"></i> My Profile</a></li>
                  <li><a href="{{url('article')}}"><i class="typcn typcn-book mr-2"></i> Knowledge Base</a></li>
           --}}
				     @php
                $login = DB::table('clientassignlogins')
                 ->leftjoin('clients','clients.id','clientassignlogins.client_id')
   ->where('clientassignlogins.clientlogin_id',auth()->user()->id)->select('clients.id','clients.client_name')->get();
        @endphp
                @if(1<count($login))
                <li>
                    <a class="has-arrow material-ripple" href="#">
                        <i class="typcn typcn-user-add-outline mr-2"></i>
                        Switch Account
                    </a>
                    <ul class="nav-second-level">
                        @foreach($login as $loginclient)
                        <li><a href="{{ url('client/switchaccount/'. $loginclient->id) }}">{{ $loginclient->client_name}}</a></li>
                    @endforeach
                    </ul>
                </li>
                @endif
          </ul>
        </nav>
    </div><!-- sidebar-body -->
</nav>