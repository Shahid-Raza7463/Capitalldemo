<nav class="navbar-custom-menu navbar navbar-expand-lg m-0">
    <div class="sidebar-toggle-icon" id="sidebarCollapse">
        sidebar toggle<span></span>
    </div>
    <!--/.sidebar toggle icon-->
    <div class="d-flex flex-grow-1">
        <ul class="navbar-nav flex-row align-items-center ml-auto">
        
            <!--/.dropdown-->
@php
$count = DB::table('clientlogins')->select('limitedaccess','permission')->where('id',Auth::user()->id ??'')->first();
@endphp
     @if($count->permission == 2)
          <li class="nav-item dropdown quick-actions" style="width: 175px;">
                <a class="nav-link dropdown-toggle" style="width: 175px;" href="#" data-toggle="dropdown">
                 Login left ( {{ $count->limitedaccess }} )
                </a>
            
            </li>
            @endif
            <li class="nav-item dropdown user-menu">
                <a class="nav-link dropdown-toggle" style="width: auto" href="#" data-toggle="dropdown">
                    <!--<img src="assets/dist/img/user2-160x160.png')}}" alt="">-->
                   <span style="font-weight: 500;">Client</span>
                </a>
                <div class="dropdown-menu dropdown-menu-left">
                    <div class="dropdown-header d-sm-none">
                        <a href="" class="header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                    </div>
               <a href="{{url('client/resetpassword/'.Crypt::encrypt(Auth::user()->id))}}" class="dropdown-item"><i class="typcn typcn-cog-outline"></i> Password Settings</a>
                  {{--  <a href="#" class="dropdown-item"><i class="typcn typcn-user-outline"></i> My Profile</a> --}}
                   <a href="{{ route('client.logout') }}" onclick="event.preventDefault();
document.getElementById('logout-form').submit();" class="dropdown-item"><i class="typcn typcn-key-outline"></i> Sign
                        Out</a>
                    <form id="logout-form" action="{{ route('client.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
                <!--/.dropdown-menu -->
            </li>
        </ul>
        <!--/.navbar nav-->
        <div class="nav-clock">
            <div class="time">
                <span class="time-hours"></span>
                <span class="time-min"></span>
                <span class="time-sec"></span>
            </div>
        </div><!-- nav-clock -->
    </div>
</nav>
<!--/.navbar-->

