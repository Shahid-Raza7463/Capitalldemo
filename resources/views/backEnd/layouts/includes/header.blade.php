<nav class="navbar-custom-menu navbar navbar-expand-lg m-0">
    <div class="sidebar-toggle-icon" id="sidebarCollapse">
        sidebar toggle<span></span>
    </div>
    <!--/.sidebar toggle icon-->
    <div class="d-flex flex-grow-1">
        <ul class="navbar-nav flex-row align-items-center ml-auto">
            {{-- <li class="nav-item dropdown quick-actions">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                    <i class="typcn typcn-th-large-outline"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="nav-grid-row row">
                        <a href="#" class="icon-menu-item col-4">
                            <i class="typcn typcn-cog-outline d-block"></i>
                            <span>Settings</span>
                        </a>
                        <a href="#" class="icon-menu-item col-4">
                            <i class="typcn typcn-group-outline d-block"></i>
                            <span>Users</span>
                        </a>
                        <a href="#" class="icon-menu-item col-4">
                            <i class="typcn typcn-puzzle-outline d-block"></i>
                            <span>Components</span>
                        </a>
                        <a href="#" class="icon-menu-item col-4">
                            <i class="typcn typcn-chart-bar-outline d-block"></i>
                            <span>Profits</span>
                        </a>
                        <a href="#" class="icon-menu-item col-4">
                            <i class="typcn typcn-time d-block"></i>
                            <span>New Event</span>
                        </a>
                        <a href="#" class="icon-menu-item col-4">
                            <i class="typcn typcn-edit d-block"></i>
                            <span>Tasks</span>
                        </a>
                    </div>
                </div>
            </li> --}}
            <!--/.dropdown-->

            {{-- ! old code  --}}
            {{-- @php
                if (auth()->user()->role_id == 11 || auth()->user()->role_id == 18) {
                    $clientnotification = DB::table('notifications')
                        ->latest()
                        ->paginate(10);
                    // dd($clientnotification);
                } elseif (auth()->user()->role_id == 13) {
                    $clientnotification = DB::table('notifications')
                        ->leftjoin('teammembers', 'teammembers.id', 'notifications.created_by')
                        ->leftjoin('notificationtargets', 'notificationtargets.notification_id', 'notifications.id')
                        ->Where('targettype', '3')
                        ->orWhere('targettype', '2')
                        ->orwhere('notificationtargets.teammember_id', auth()->user()->teammember_id)
                        ->select('notifications.*')
                        ->latest()
                        ->get();
                } elseif (auth()->user()->role_id == 14) {
                    //	dd(auth()->user()->role_id);
                    $clientnotification = DB::table('notifications')
                        ->leftjoin('teammembers', 'teammembers.id', 'notifications.created_by')
                        ->leftjoin('notificationtargets', 'notificationtargets.notification_id', 'notifications.id')
                        ->Where('targettype', '4')
                        ->orWhere('targettype', '2')
                        ->orwhere('notificationtargets.teammember_id', auth()->user()->teammember_id)
                        ->select('notifications.*')
                        ->latest()
                        ->get();
                    //dd(auth()->user()->role_id);
                } elseif (auth()->user()->role_id == 15) {
                    $clientnotification = DB::table('notifications')
                        ->leftjoin('teammembers', 'teammembers.id', 'notifications.created_by')
                        ->leftjoin('notificationtargets', 'notificationtargets.notification_id', 'notifications.id')
                        ->Where('targettype', '5')
                        ->orWhere('targettype', '2')
                        ->orwhere('notificationtargets.teammember_id', auth()->user()->teammember_id)
                        ->select('notifications.*')
                        ->latest()
                        ->get();
                } elseif (auth()->user()->role_id == 16) {
                    $clientnotification = DB::table('notifications')
                        ->leftjoin('teammembers', 'teammembers.id', 'notifications.created_by')
                        ->leftjoin('notificationtargets', 'notificationtargets.notification_id', 'notifications.id')
                        ->Where('targettype', '6')
                        ->orWhere('targettype', '2')
                        ->orwhere('notificationtargets.teammember_id', auth()->user()->teammember_id)
                        ->select('notifications.*')
                        ->latest()
                        ->get();
                } elseif (auth()->user()->role_id == 17) {
                    $clientnotification = DB::table('notifications')
                        ->leftjoin('teammembers', 'teammembers.id', 'notifications.created_by')
                        ->leftjoin('notificationtargets', 'notificationtargets.notification_id', 'notifications.id')
                        ->Where('targettype', '7')
                        ->orWhere('targettype', '2')
                        ->orwhere('notificationtargets.teammember_id', auth()->user()->teammember_id)
                        ->select('notifications.*')
                        ->latest()
                        ->get();
                } else {
                    //  $notificationDatas = Notification::Where('targettype','1')->orWhere('targettype','2')->get();
                    $clientnotification = DB::table('notifications')
                        ->leftjoin('teammembers', 'teammembers.id', 'notifications.created_by')
                        ->leftjoin('notificationtargets', 'notificationtargets.notification_id', 'notifications.id')
                        ->where('notifications.targettype', '2')
                        ->orwhere('notificationtargets.teammember_id', auth()->user()->teammember_id)
                        ->select('notifications.*', 'teammembers.team_member', 'teammembers.profilepic')
                        ->latest()
                        ->get();
                }
                $getuser = App\Models\User::where('role_id', Auth::user()->role_id ?? '')
                    ->with('teammember')
                    ->first();

            @endphp

            @if (count($clientnotification) > 0)
                <li class="nav-item dropdown notification">
                    <a class="nav-link dropdown-toggle badge-dot" href="#" data-toggle="dropdown">
                        <i class="typcn typcn-bell"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <h6 class="notification-title">Notifications</h6>
                        <p class="notification-text">You have {{ count($clientnotification) }} unread notification</p>
                        <div class="notification-list">
                            @foreach ($clientnotification as $clientnotificationdata)
                                <div class="media new">
                                    <a href="{{ url('notification/' . $clientnotificationdata->id) }}">
                                        <div class="media-body">
                                            <h6>{{ $clientnotificationdata->title }}</h6>
                                            <span>{{ date('F d', strtotime($clientnotificationdata->created_at)) }}
                                                {{ date('h:ia', strtotime($clientnotificationdata->created_at)) }}</span>
                                        </div>
                                    </a>
                                </div>
                                <!--/.media -->
                            @endforeach
                        </div>
                        <!--/.notification -->
                        <div class="dropdown-footer"><a href="{{ url('notification') }}">View All Notification</a></div>
                    </div>
                    <!--/.dropdown-menu -->
                </li>
                <!--/.dropdown-->
            @endif --}}

            {{-- ! notification read or unread functionality --}}
            @php
                if (auth()->user()->role_id == 11 || auth()->user()->role_id == 18) {
                    $userId = auth()->user()->teammember_id;
                    $clientnotification = DB::table('notifications')
                        ->leftjoin('notificationreadorunread', function ($join) use ($userId) {
                            $join->on('notificationreadorunread.notifications_id', 'notifications.id')->where('notificationreadorunread.readedby', $userId);
                        })

                        ->select('notifications.*', 'notificationreadorunread.status as readstatus')
                        ->latest()
                        ->paginate(10);
                } elseif (auth()->user()->role_id == 13) {
                    $userId = auth()->user()->teammember_id;

                    $clientnotification = DB::table('notifications')
                        ->leftjoin('teammembers', 'teammembers.id', 'notifications.created_by')
                        ->leftjoin('notificationtargets', 'notificationtargets.notification_id', 'notifications.id')
                        ->leftjoin('notificationreadorunread', function ($join) use ($userId) {
                            $join->on('notificationreadorunread.notifications_id', 'notifications.id')->where('notificationreadorunread.readedby', $userId);
                        })
                        ->Where(function ($query) {
                            $query->where('targettype', '3')->orWhere('targettype', '2');
                        })
                        ->orWhere(function ($query) use ($userId) {
                            $query->where('notificationtargets.teammember_id', $userId)->where('notificationreadorunread.readedby', $userId);
                        })
                        ->select('notifications.*', 'notificationreadorunread.status as readstatus')
                        ->latest()
                        ->get();
                } elseif (auth()->user()->role_id == 14) {
                    $userId = auth()->user()->teammember_id;

                    $clientnotification = DB::table('notifications')
                        ->leftjoin('teammembers', 'teammembers.id', 'notifications.created_by')
                        ->leftjoin('notificationtargets', 'notificationtargets.notification_id', 'notifications.id')
                        ->leftjoin('notificationreadorunread', function ($join) use ($userId) {
                            $join->on('notificationreadorunread.notifications_id', 'notifications.id')->where('notificationreadorunread.readedby', $userId);
                        })
                        ->where(function ($query) use ($userId) {
                            $query
                                ->where('targettype', '4')
                                ->orWhere('targettype', '2')
                                ->orWhere(function ($innerQuery) use ($userId) {
                                    $innerQuery->where('notificationtargets.teammember_id', $userId);
                                });
                        })
                        ->select('notifications.*', 'notificationreadorunread.status as readstatus')
                        ->latest()
                        ->get();
                } elseif (auth()->user()->role_id == 15) {
                    $userId = auth()->user()->teammember_id;

                    $clientnotification = DB::table('notifications')
                        ->leftjoin('teammembers', 'teammembers.id', 'notifications.created_by')
                        ->leftjoin('notificationtargets', 'notificationtargets.notification_id', 'notifications.id')
                        ->leftjoin('notificationreadorunread', function ($join) use ($userId) {
                            $join->on('notificationreadorunread.notifications_id', 'notifications.id')->where('notificationreadorunread.readedby', $userId);
                        })
                        ->where(function ($query) use ($userId) {
                            $query
                                ->where('targettype', '5')
                                ->orWhere('targettype', '2')
                                ->orWhere(function ($innerQuery) use ($userId) {
                                    $innerQuery->where('notificationtargets.teammember_id', $userId);
                                });
                        })
                        ->select('notifications.*', 'notificationreadorunread.status as readstatus')
                        ->latest()
                        ->get();
                } elseif (auth()->user()->role_id == 16) {
                    $userId = auth()->user()->teammember_id;

                    $clientnotification = DB::table('notifications')
                        ->leftjoin('teammembers', 'teammembers.id', 'notifications.created_by')
                        ->leftjoin('notificationtargets', 'notificationtargets.notification_id', 'notifications.id')
                        ->leftjoin('notificationreadorunread', function ($join) use ($userId) {
                            $join->on('notificationreadorunread.notifications_id', 'notifications.id')->where('notificationreadorunread.readedby', $userId);
                        })
                        ->where(function ($query) use ($userId) {
                            $query
                                ->where('targettype', '6')
                                ->orWhere('targettype', '2')
                                ->orWhere(function ($innerQuery) use ($userId) {
                                    $innerQuery->where('notificationtargets.teammember_id', $userId);
                                });
                        })
                        ->select('notifications.*', 'notificationreadorunread.status as readstatus')
                        ->latest()
                        ->get();
                } elseif (auth()->user()->role_id == 17) {
                    $userId = auth()->user()->teammember_id;

                    $clientnotification = DB::table('notifications')
                        ->leftjoin('teammembers', 'teammembers.id', 'notifications.created_by')
                        ->leftjoin('notificationtargets', 'notificationtargets.notification_id', 'notifications.id')
                        ->leftjoin('notificationreadorunread', function ($join) use ($userId) {
                            $join->on('notificationreadorunread.notifications_id', 'notifications.id')->where('notificationreadorunread.readedby', $userId);
                        })
                        ->where(function ($query) use ($userId) {
                            $query
                                ->where('targettype', '7')
                                ->orWhere('targettype', '2')
                                ->orWhere(function ($innerQuery) use ($userId) {
                                    $innerQuery->where('notificationtargets.teammember_id', $userId);
                                });
                        })
                        ->select('notifications.*', 'notificationreadorunread.status as readstatus')
                        ->latest()
                        ->get();
                } else {
                    $userId = auth()->user()->teammember_id;

                    $clientnotification = DB::table('notifications')
                        ->leftjoin('teammembers', 'teammembers.id', 'notifications.created_by')
                        ->leftjoin('notificationtargets', 'notificationtargets.notification_id', 'notifications.id')
                        ->leftjoin('notificationreadorunread', function ($join) use ($userId) {
                            $join->on('notificationreadorunread.notifications_id', 'notifications.id')->where('notificationreadorunread.readedby', $userId);
                        })
                        ->where(function ($query) use ($userId) {
                            $query->where('notifications.targettype', '2')->orWhere('notificationtargets.teammember_id', $userId);
                        })
                        ->select('notifications.*', 'teammembers.team_member', 'teammembers.profilepic', 'notificationreadorunread.status as readstatus')
                        ->latest()
                        ->get();
                }
                $getuser = App\Models\User::where('role_id', Auth::user()->role_id ?? '')
                    ->with('teammember')
                    ->first();

            @endphp

            @if (count($clientnotification) > 0)
                @php
                    $hasUnreadNotification = false;
                    foreach ($clientnotification as $clientnotificationdata) {
                        if ($clientnotificationdata->readstatus == 0) {
                            $hasUnreadNotification = true;
                            break;
                        }
                    }
                @endphp

                <li class="nav-item dropdown notification">
                    <a class="nav-link dropdown-toggle {{ $hasUnreadNotification ? 'badge-dot' : '' }}" href="#"
                        data-toggle="dropdown">
                        <i class="typcn typcn-bell"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <h6 class="notification-title">Notifications</h6>
                        <p class="notification-text">You have {{ count($clientnotification) }} unread notification</p>
                        <div class="notification-list">
                            @foreach ($clientnotification as $clientnotificationdata)
                                <div class="media new">
                                    <a href="{{ url('notification/' . $clientnotificationdata->id) }}"
                                        style="color: {{ $clientnotificationdata->readstatus == 1 ? 'Black' : 'red' }}">
                                        <div class="media-body">
                                            <h6>{{ $clientnotificationdata->title }}</h6>
                                            <span>{{ date('F d', strtotime($clientnotificationdata->created_at)) }}
                                                {{ date('h:ia', strtotime($clientnotificationdata->created_at)) }}</span>
                                        </div>
                                    </a>
                                </div>
                                <!--/.media -->
                            @endforeach
                        </div>
                        <!--/.notification -->
                        <div class="dropdown-footer"><a href="{{ url('notification') }}">View All Notification</a></div>
                    </div>
                    <!--/.dropdown-menu -->
                </li>
                <!--/.dropdown-->
            @endif







            <!-- <li class="nav-item dropdown user-menu">
   
                <a class="nav-link dropdown-toggle" style="width: auto" href="{{ url('check-In/create') }}" >
                    <!--<img src="assets/dist/img/user2-160x160.png')}}" alt="">--
                   <span style="font-weight: 500;"><i style="color:green;" class="far fa-clock mr-1"></i>&nbsp;Check-In </span>
                </a>
   </li>-->
            <li class="nav-item dropdown user-menu">

                <a class="nav-link dropdown-toggle" style="width: auto" href="#" data-toggle="dropdown">
                    <!--<img src="assets/dist/img/user2-160x160.png')}}" alt="">-->
                    <span style="font-weight: 500;">Sign Out</span>
                </a>
                <div class="dropdown-menu dropdown-menu-left">
                    <div class="dropdown-header d-sm-none">
                        <a href="" class="header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                    </div>

                    <a href="{{ url('resetpasswords/' . Auth::user()->teammember_id) }}" class="dropdown-item"><i
                            class="typcn typcn-cog-outline"></i> Password Settings</a>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
document.getElementById('logout-form').submit();"
                        class="dropdown-item"><i class="typcn typcn-key-outline"></i> Sign
                        Out</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
                <!--/.dropdown-menu -->
            </li>
        </ul>
        <!--/.navbar nav
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