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
    

    </a><!--/.profile element-->
    <div class="sidebar-body">
        <nav class="sidebar-nav">
            <ul class="metismenu">
                <li class="nav-label">Main Menu</li>
   
                <li class="mm-active">
                    <a class="material-ripple" href="{{route('students.home')}}">
                        <i class="typcn typcn-home-outline mr-2"></i>
                        Dashboard
                    </a>
                   
                </li>
                <!-- <li>
                    <a class="has-arrow material-ripple" href="#">
                        <i class="typcn typcn-document mr-2"></i>
                       Student Exam
                    </a>
                    <ul class="nav-second-level">
                         <li><a href="{{url('students/studentexam')}}">Start Exam</a></li>
                       
                      
                    </ul>
                </li> -->
          </ul>
        </nav>
    </div><!-- sidebar-body -->
</nav>