  <!-- Sidebar  -->
  @php
      $getuser = DB::table('teammembers')
          ->join('roles', 'roles.id', 'teammembers.role_id')
          ->where('teammembers.id', auth()->user()->teammember_id)
          ->select('roles.rolename', 'teammembers.team_member', 'teammembers.staffcode', 'teammembers.profilepic')
          ->first();
      $getrole = App\Models\Permission::select('page_id')
          ->where('role_id', Auth::user()->role_id ?? '')
          ->get();
      //dd($getrole);
  @endphp
  <nav class="sidebar sidebar-bunker">
      <div class="sidebar-header" style="    background-color:#FFFFFF;">
          <!--<a href="index.html" class="logo"><span>bd</span>task</a>-->
          <a class="logo"><img src="{{ url('backEnd/image/vlogo.png') }}" style="width: 215px;height:54px;"
                  alt=""></a>
      </div>
      <!--/.sidebar header-->
      <a href="{{ url('userprofile/' . Auth::user()->id) }}"
          class="profile-element d-flex align-items-center flex-shrink-0">

          @if ($getuser != null)
              <div class="avatar online">
                  <img src="{{ asset('backEnd/image/teammember/profilepic/' . $getuser->profilepic ?? '') }}"
                      class="img-fluid rounded-circle" alt="">
              </div>
          @endif
          <div class="profile-text">
              <h6 class="m-0">{{ $getuser->team_member ?? '' }} <br> ( {{ $getuser->staffcode ?? '' }} )</h6>
              <span>{{ $getuser->rolename ?? '' }}</span>
          </div>
      </a>
      <!--/.profile element-->
      <div class="sidebar-body">
          <nav class="sidebar-nav">
              <ul class="metismenu">
                  <li class="nav-label">Main Menu</li>
                  <li>
                      <a class="material-ripple" href="{{ url('home') }}">
                          <i class="typcn typcn-home-outline mr-2"></i>
                          Dashboard
                      </a>

                  </li>
                  @foreach ($getrole as $getroledata)
                      @if ($getroledata->page_id == 1)
                          <li>
                              <a class="has-arrow material-ripple" href="#">
                                  <i class="typcn typcn-group-outline d-block mr-2"></i>
                                  Client
                              </a>

                              <ul class="nav-second-level">
                                  <li>
                                      <a class="has-arrow" href="#" aria-expanded="false">Client </a>
                                      <ul class="nav-third-level">
                                          @if (auth()->user()->role_id != 15 || auth()->user()->role_id != 19)
                                              <li><a href="{{ url('client') }}">Client List</a></li>
                                          @endif
                                          {{-- @if (auth()->user()->role_id == 11)
                                  <li><a href="{{url('assignmentevaluation')}}">File Directory</a>
                          </li>
                          @endif --}}
                                          <li><a href="{{ url('assignmentmapping') }}">Assignment List</a></li>

                                      </ul>
                                  </li>
                                  {{-- @if (Auth::user()->role_id == 11)
                          <li>
                              <a class="has-arrow" href="#" aria-expanded="false">P & L Report</a>
                              <ul class="nav-third-level">

                                  <li><a href="{{url('pandl/'.'21-22')}}">FY 21-22</a></li>
                  <li><a href="{{url('pandl/'.'22-23')}}">FY 22-23</a></li>
                  <li><a href="{{url('pandl/'.'23-24')}}">FY 23-24</a></li>
              </ul>
              </li>
              @endif --}}
                                  @if (auth()->user()->role_id == 11 || auth()->user()->role_id == 13)
                                      <li>
                                          <a class="has-arrow" href="#" aria-expanded="false">Assignment </a>
                                          <ul class="nav-third-level">

                                              <li><a href="{{ url('assignmentbudgeting') }}">Assignment Budgeting</a>
                                              </li>
                                              <li><a href="{{ url('assignmentmapping/create') }}">Assignment
                                                      Mapping</a></li>

                                          </ul>
                                      </li>
                                      <li>
                                          <a class="has-arrow" href="#" aria-expanded="false">Report </a>
                                          <ul class="nav-third-level">

                                              <li><a href="{{ url('assignment_report') }}">Assignment Report</a></li>

                                          </ul>
                                      </li>
                                  @endif
                                  @if (auth()->user()->role_id == 11 || auth()->user()->teammember_id == 533)
                                      <li>
                                          <a class="has-arrow" href="#" aria-expanded="false">Configuration </a>
                                          <ul class="nav-third-level">

                                              <li><a href="{{ url('assignment') }}">Assignment Name</a></li>
                                              <li><a href="{{ url('step/create') }}">Add Checklist</a></li>

                                          </ul>
                                      </li>
                                  @endif

                                  {{-- @if ($getroledata->page_id == 17)

                          <li><a href="{{url('appointmentletter')}}">
              Appointment letter</a>
              </li>
              @endif --}}
                                  @if (auth()->user()->role_id == 11)
                                      <li><a href="{{ url('appointmentletter') }}">
                                              Appointment letter</a></li>
                                  @endif
                                  {{-- <li><a href="{{url('knowledgebase')}}"> Knowledge Base</a></li> --}}
                              </ul>

                          </li>
                      @elseif ($getroledata->page_id == 4)
                          <li>
                              <a class="has-arrow material-ripple" href="#">
                                  <i class="typcn typcn-user-add-outline mr-2"></i>
                                  Team
                              </a>
                              <ul class="nav-second-level">
                                  <li><a href="{{ url('teammember') }}">Team</a></li>
                                  @if (auth()->user()->role_id == 11 or auth()->user()->role_id == 12)
                                      <!--  <li><a href="{{ url('teamlevel') }}">Team Role</a></li> -->

                                      <li><a href="{{ url('teamlogin/create') }}">Team Login</a></li>
                                  @endif
                              </ul>
                          </li>
                      @elseif ($getroledata->page_id == 6)
                          {{--    <li>
                  <a class="has-arrow material-ripple" href="#">
                      <i class="typcn typcn-pen mr-2"></i>
                      Communication
                  </a>

                  <ul class="nav-second-level">
                     <!-- <li><a href="{{url('task')}}"> Task</a></li>
                      @if (auth()->user()->role_id == 11)
                      <li><a href="{{url('taskreport')}}"> Task Report</a></li>
                      @endif-->
                       <li><a href="{{url('notification')}}"> Notification List</a>
              </li>
              <li><a href="{{url('knowledgebase')}}"> Knowledge Base</a></li>
              <li><a href="{{url('feed')}}">RSS Feed</a></li>
              <li>
                  <a class="has-arrow" href="#" aria-expanded="false">Meeting </a>
                  <ul class="nav-third-level">
                      @if (auth()->user()->role_id != 15)
                      <li><a href="{{url('pbd')}}">Minutes of Meeting/Discussion</a></li>

                      @endif
                  </ul>
              </li> 
              @if (auth()->user()->role_id == 11)
              <li><a href="{{url('clientcontact')}}"> Phone Directory</a></li>
              @endif

              </ul>
              </li> --}}
                      @elseif ($getroledata->page_id == 7)
                          <li>
                              <a class="has-arrow material-ripple" href="#">
                                  <i class="typcn typcn-document mr-2"></i>
                                  Finance
                              </a>
                              <ul class="nav-second-level">
                                  <li><a href="{{ url('invoice') }}">Invoice Raised</a></li>
                                  <li><a href="{{ url('outstanding') }}">Outstanding Pending</a></li>
                                  @if (Auth::user()->role_id == 11 ||
                                          Auth::user()->role_id == 17 ||
                                          Auth::user()->teammember_id == 99 ||
                                          auth()->user()->teammember_id == 161 ||
                                          Auth::user()->teammember_id == 550)
                                      <li><a href="{{ url('payment') }}">Outstanding Received</a></li>
                                  @endif
                                  @if (Auth::user()->role_id == 11 || Auth::user()->role_id == 17)
                                      <li><a href="{{ url('creditnote') }}">Credit Note</a></li>
                                      <li><a href="{{ url('balance') }}">Balance</a></li>
                                  @endif
                                  @if (Auth::user()->role_id == 11 ||
                                          Auth::user()->role_id == 13 ||
                                          Auth::user()->role_id == 14 ||
                                          Auth::user()->role_id == 17 ||
                                          Auth::user()->role_id == 16 ||
                                          Auth::user()->role_id == 18)
                                      <li><a href="{{ url('tax') }}">Investment Declaration</a></li>
                                  @endif
                              </ul>
                          </li>
                      @elseif ($getroledata->page_id == 8)

                      @elseif ($getroledata->page_id == 9)
                          <li><a href="{{ url('assetassign') }}"><i class="typcn typcn-document-text mr-2"></i> Assign
                                  Asset</a>
                          </li>
                      @elseif ($getroledata->page_id == 10)
                          <li>
                              <a class="has-arrow material-ripple" href="#">
                                  <i class="typcn typcn-calendar-outline mr-2"></i>
                                  Calendar
                              </a>
                              <ul class="nav-second-level">
                                  <li><a href="{{ url('gnattchart') }}">Assign Calendar</a></li>
                                  @if (Auth::user()->role_id == 11 || Auth::user()->role_id == 12 || Auth::user()->teammember_id == 23)
                                      <li><a href="{{ url('gnattchart/assignlist') }}">Assigned List</a></li>
                                  @endif
                              </ul>
                          @elseif ($getroledata->page_id == 11)

                          @elseif ($getroledata->page_id == 12)

                          @elseif ($getroledata->page_id == 13)
                          <li>
                              <a class="has-arrow material-ripple" href="#">
                                  <i class="typcn typcn-contacts mr-2"></i>
                                  Profile
                              </a>

                              <ul class="nav-second-level">
                                  <li><a href="{{ url('profile') }}"><i class="fas fa-user mr-2"></i> Profile</a></li>
                                  @if (Auth::user()->role_id == 16 || Auth::user()->role_id == 11)
                                      <li><a href="{{ url('teamprofile') }}"><i
                                                  class="typcn typcn-document-delete outline mr-2"></i>Team
                                              Profile</a></li>
                                  @endif
                              </ul>
                          </li>
                      @elseif ($getroledata->page_id == 14)
                          <li><a href="{{ url('asset') }}"><i class="typcn typcn-shopping-bag mr-2"></i>Asset</a></li>
                      @elseif ($getroledata->page_id == 15)
                          {{-- 
                  <li><a href="{{url('teamprofile')}}"><i class="typcn typcn-document-delete outline mr-2"></i>Team
              Profile</a></li> --}}
                      @elseif ($getroledata->page_id == 16)
                          <li>
                              <a class="has-arrow material-ripple" href="#">
                                  <i class="typcn typcn-chart-pie-outline mr-2"></i>
                                  Help Desk
                              </a>
                              <ul class="nav-second-level">
                                  <li><a href="{{ url('ticketsupport') }}">Ticket Support</a></li>
                                  <li><a href="{{ url('auditticket') }}">Audit Query</a> </li>
                                  <li><a href="{{ url('hrticket') }}">Hr Query</a> </li>
                                  <li><a href="{{ url('dataanalytics') }}">Data Analytics Query</a> </li>
                              </ul>
                          </li>
                      @elseif ($getroledata->page_id == 18)
                          <li><a href="{{ url('conversion') }}"><i
                                      class="typcn typcn-document-delete outline mr-2"></i>
                                  Conversion List</a></li>
                      @elseif ($getroledata->page_id == 19)
                          <li>
                              <a class="has-arrow material-ripple" href="#">
                                  <i class="typcn typcn-info-large-outline d-block mr-2"></i>
                                  Human Resources
                              </a>
                              <ul class="nav-second-level">
                                  <!-- <li><a href="{{ url('travel') }}"> Advance Claim Form</a></li>

                      <li>
                          <a class="has-arrow" href="#" aria-expanded="false"> Conveyance</a>
                          <ul class="nav-third-level">
                              <li><a href="{{ url('outstationconveyance') }}">Conveyance Form</a></li>
                             
                          </ul>
                      </li> -->
                                  @if (Auth::user()->role_id == 18 ||
                                          Auth::user()->role_id == 11 ||
                                          Auth::user()->role_id == 17 ||
                                          Auth::user()->teammember_id == 550 ||
                                          auth()->user()->teammember_id == 556)
                                      @if (Auth::user()->teammember_id != 556 || Auth::user()->teammember_id == 550 || auth()->user()->teammember_id == 556)
                                          <!--   <li>
                          <a class="has-arrow" href="#" aria-expanded="false"> Payroll</a>
                          <ul class="nav-third-level">
                              @if (Auth::user()->teammember_id == 160 ||
                                      Auth::user()->teammember_id == 173 ||
                                      Auth::user()->teammember_id == 550 ||
                                      auth()->user()->teammember_id == 556)
<li><a href="{{ url('payroll') }}">Payroll Sheet</a></li>

                              <li><a href="{{ url('payrollneft') }}">Payroll Neft</a></li>
@endif
                              <li><a href="{{ url('payrollarticle') }}">Payroll Article Stipend</a></li>

                              <li><a href="{{ url('payrollarticleneft') }}">Payroll Article Neft</a></li>
                              <li><a href="{{ url('employeepayroll') }}">Employee Payroll</a></li>

                          </ul>
                      </li>-->
                                      @endif
                                  @endif
                                  <!--  <li><a href="{{ url('employeereferral') }}">Employee Referral</a></li>
                    <li><a href="{{ url('reimbursementclaim') }}">Reimbursement Claim</a></li>-->
                                  <!--   <li><a href="{{ url('recruitmentform') }}">Recruitment Form</a></li>-->
                                  {{-- @if (auth()->user()->role_id == 11 || auth()->user()->role_id == 18 || auth()->user()->role_id == 16)
                      <li><a href="{{url('performanceevaluationform')}}">Performance Evaluation Form</a></li>
                      @endif
                      <li>
                          <a class="has-arrow" href="#" aria-expanded="false"> Assignment Evaluation</a>
                          <ul class="nav-third-level">
                              <li><a href="{{url('assignmentevaluation')}}">Evaluation Form</a></li>

                              @if (auth()->user()->role_id == 18)
                              <li><a href="{{url('performanceappraisal')}}">Evaluation Status</a></li>
                              @endif
                          </ul>
                      </li> --}}

                                  @if (Auth::user()->role_id == 18 ||
                                          Auth::user()->role_id == 11 ||
                                          Auth::user()->role_id == 13 ||
                                          Auth::user()->role_id == 14 ||
                                          Auth::user()->role_id == 17 ||
                                          Auth::user()->role_id == 15 ||
                                          Auth::user()->role_id == 16 ||
                                          Auth::user()->role_id == 12)
                                      <li><a href="{{ url('applyleave') }}">Apply Leave</a></li>
                                  @endif

                                  @if (Auth::user()->role_id == 18 ||
                                          Auth::user()->role_id == 11 ||
                                          Auth::user()->role_id == 13 ||
                                          Auth::user()->role_id == 14 ||
                                          Auth::user()->role_id == 17 ||
                                          Auth::user()->role_id == 15 ||
                                          Auth::user()->role_id == 16 ||
                                          Auth::user()->role_id == 12)
                                      <li><a href="{{ url('examleaverequestlist') }}">Revert Leave</a></li>
                                  @endif



                                  <!-- <li><a href="{{ url('policy') }}">Policy</a></li> -->
                                  <li><a href="{{ url('timesheet') }}">Timesheet</a></li>
                                  @if (Auth::user()->role_id == 18 ||
                                          Auth::user()->role_id == 11 ||
                                          Auth::user()->role_id == 13 ||
                                          Auth::user()->role_id == 14 ||
                                          Auth::user()->role_id == 15)
                                      <li><a href="{{ url('timesheetrequestlist') }}">Timesheet Request List</a></li>
                                  @endif
                                  @if (Auth::user()->role_id == 18 || Auth::user()->role_id == 11)
                                      <li><a href="{{ url('attendance') }}">Attendance</a></li>
                                      <!--<li><a href="{{ url('check-In') }}">Check In/Out</a></li>-->
                                  @endif
                                  <li><a href="{{ url('notification') }}"> Notification List</a>
                                  <li><a href="{{ url('knowledgebase') }}">Knowledge Base</a>
                                  <li><a href="{{ url('holiday') }}">Holiday</a></li>
                                  @if (Auth::user()->teammember_id == 157 || Auth::user()->teammember_id == 155)
                                      <li><a href="{{ url('staffappointmentletter') }}">Staffappointment Letter</a>
                                      </li>
                                  @endif
                                  @if (Auth::user()->teammember_id == 427 ||
                                          Auth::user()->role_id == 13 ||
                                          Auth::user()->role_id == 14 ||
                                          Auth::user()->role_id == 18 ||
                                          Auth::user()->role_id == 11)
                                      <!--<li><a href="{{ url('travelform') }}">Travel Form</a></li>-->
                                  @endif
                                  <!--
                      @if (Auth::user()->role_id == 17)
<li><a href="{{ url('fullandfinal') }}">Full and Final</a></li>
@endif
                      @if (Auth::user()->role_id == 13 || Auth::user()->role_id == 16)
<li><a href="{{ url('fullandfinal') }}">HandOver Approval</a></li>
@endif-->
                                  {{-- @if (Auth::user()->teammember_id == 155)
                      <li>
                          <a class="has-arrow" href="#" aria-expanded="false"> OnBoarding</a>
                          <ul class="nav-third-level">
                              <li><a href="{{url('candidateboarding')}}">Candidate Onboarding</a></li>
                              <li><a href="{{url('employeeonboarding')}}">Employee Onboarding</a></li>
                              <li><a href="{{url('articleonboarding')}}">Article Onboarding</a></li>
                              <li><a href="{{url('draftemail')}}">Draft Email list</a></li>

                          </ul>
                      </li>
                      @endif --}}
                                  @if (Auth::user()->role_id == 18 || Auth::user()->role_id == 11)
                                      <!--  <li><a href="{{ url('fullandfinal') }}">Full and Final</a></li>
                      <li><a href="{{ url('leavetype') }}">Leave Type</a></li>-->
                                      {{-- <li>
                          <a class="has-arrow" href="#" aria-expanded="false">ATS</a>
                          <ul class="nav-third-level">
                              <li><a href="{{url('articleship-applications')}}">Articleship</a></li>
                              <li><a href="{{url('internship-applications')}}">Internship</a></li>
                              <a href="{{url('ca-applications')}}">Chartetred Accountant</a>
                              <li><a href="{{url('other-applications')}}">Other Applications</a></li>
                          </ul>
                      </li>
                      <li>
                          <a class="has-arrow" href="#" aria-expanded="false">Direct Application</a>
                          <ul class="nav-third-level">
                              <li><a href="{{url('direct_internship-applications')}}">Articleship</a></li>
                              <li><a href="{{url('direct_internship-applications')}}">Internship</a></li>
                              <a href="{{url('direct_ca-applications')}}">Chartetred Accountant</a>
                              <li><a href="{{url('direct_other-applications')}}">Other Applications</a></li>
                          </ul>
                      </li> 
                      <li>
                          <a class="has-arrow" href="#" aria-expanded="false">Report</a>
                          <ul class="nav-third-level">
                              <li><a href="{{url('reportsection')}}">Timesheet</a></li>
                              <li><a href="{{url('assignmentevaluationreport')}}">Assignment Evaluation</a></li>
                              <!--<a href="{{url('ca-applications')}}">Chartetred Accountant</a>
                            <li><a href="{{url('other-applications')}}">Other Applications</a></li>-->
                          </ul>
                      </li>
                      <li>
                          <a class="has-arrow" href="#" aria-expanded="false"> OnBoarding</a>
                          <ul class="nav-third-level">
                              <li><a href="{{url('candidateboarding')}}">Candidate Onboarding</a></li>
                              <li><a href="{{url('employeeonboarding')}}">Employee Onboarding</a></li>
                              <!--<li><a href="{{url('articleonboarding')}}">Article Onboarding</a></li>-->
                              <li><a href="{{url('draftemail')}}">Draft Email list</a></li>
                              @if (Auth::user()->teammember_id != 447)
                              <li><a href="{{url('staffappointmentletter')}}">Staffappointment Letter</a></li>
                              @endif
                          </ul>
                      </li> --}}
                                  @endif
                                  @if (Auth::user()->role_id == 17 || Auth::user()->role_id == 16)
                                      <li>
                                          <a class="has-arrow" href="#" aria-expanded="false"> OnBoarding</a>
                                          <ul class="nav-third-level">

                                              <li><a href="{{ url('employeeonboarding') }}">Employee Onboarding</a>
                                              </li>
                                          </ul>
                                      </li>
                                  @endif
                                  @if (Auth::user()->role_id == 15 || Auth::user()->role_id == 11 || Auth::user()->role_id == 18)
                                      <!--   <li><a href="{{ url('articlefiles') }}">Article File</a></li>-->
                                  @endif
                                  @if (Auth::user()->role_id == 17 || Auth::user()->role_id == 11 || Auth::user()->role_id == 18)
                                      <!--  <li><a href="{{ url('neft') }}">NEFT</a></li>-->
                                  @endif
                                  {{-- <li><a href="{{url('trainingassetsments')}}">Training Assessment
                              Form</a></li> --}}
                                  @if (auth()->user()->role_id == 11 ||
                                          auth()->user()->role_id == 16 ||
                                          auth()->user()->role_id == 17 ||
                                          auth()->user()->role_id == 18)
                                      <!--     <li>
                          <a class="has-arrow" href="#" aria-expanded="false">Exit </a>
                          <ul class="nav-third-level">
                              <li><a href="{{ url('relieve/teammember') }}">Exited Employee</a></li>
                          </ul>
                      </li>-->
                                  @endif
                                  {{-- @if (Auth::user()->role_id == 13 || Auth::user()->role_id == 11 || Auth::user()->role_id == 18 || Auth::user()->role_id == 14)
                      <li><a href="{{url('staffrequest')}}"> Staff Request</a></li>
                      @endif --}}
                              </ul>
                          </li>
                      @elseif ($getroledata->page_id == 20)
                          <li>
                              <a class="has-arrow material-ripple" href="#">
                                  <i class="typcn typcn-archive d-block mr-2"></i>
                                  Pipeline
                              </a>
                              <ul class="nav-second-level">
                                  <li><a href="{{ url('lead') }}">Lead Raised</a></li>
                                  <li><a href="{{ url('tender') }}"> Tender</a></li>
                                  @if (auth()->user()->role_id == 11 ||
                                          auth()->user()->role_id == 16 ||
                                          auth()->user()->role_id == 17 ||
                                          auth()->user()->role_id == 18)
                                      <li><a href="{{ url('staffdetail') }}">Tender
                                              Details</a></li>
                                  @endif
                                  <li><a href="{{ url('proposal') }}">Proposal</a></li>
                                  <li><a href="{{ url('connection') }}">Connection</a>
                                  </li>
                              </ul>
                          </li>
                      @elseif ($getroledata->page_id == 21)

                      @elseif ($getroledata->page_id == 22)
                          <li><a href="{{ url('contract') }}"><i class="typcn typcn-edit d-block mr-2"></i> Contract
                                  And
                                  Subscription</a></li>
                      @elseif ($getroledata->page_id == 23)
                          <li>
                              <a class="has-arrow material-ripple" href="#">
                                  <i class="typcn typcn-user-add-outline"></i>
                                  Admin
                              </a>
                              <ul class="nav-second-level">
                                  <li><a href="{{ url('assetprocurement') }}"></i>Asset Procurement
                                          Form</a></li>
                                  <li><a href="{{ url('icards') }}">Icards</a></li>
                                  <li><a href="{{ url('vendorlist') }}">Vendor</a></li>
                                  @if (Auth::user()->role_id != 15)
                                      <li><a href="{{ url('material') }}">Material</a></li>
                                      <li><a href="{{ url('courierinout') }}">Correspondence
                                              In/Out</a></li>
                                  @endif
                              </ul>
                          </li>
                      @elseif ($getroledata->page_id == 24)

                      @elseif ($getroledata->page_id == 25)

                      @elseif ($getroledata->page_id == 26)

                      @elseif ($getroledata->page_id == 27)
                          @if (auth()->user()->role_id == 11 ||
                                  auth()->user()->role_id == 13 ||
                                  auth()->user()->role_id == 14 ||
                                  auth()->user()->role_id == 16)
                              <li>
                                  <a class="has-arrow material-ripple" href="#">
                                      <i class="typcn typcn-globe-outline d-block mr-2"></i>
                                      Corporate Governance
                                  </a>

                                  <ul class="nav-second-level">
                                      <li><a href="{{ url('meetingfolder') }}"><i
                                                  class="typcn typcn-folder mr-2"></i>Board Meeting</a>
                                      </li>
                                      <li><a href="{{ url('discuss') }}"><i
                                                  class="typcn typcn-group-outline d-block mr-2"></i>Discussion</a>
                                      </li>

                                  </ul>
                              </li>
                          @endif

                          @if (auth()->user()->role_id == 11)
                              <li>
                                  <a class="has-arrow material-ripple" href="#">
                                      <i class="typcn typcn-folder mr-2"></i>
                                      Miscellaneous
                                  </a>

                                  <ul class="nav-second-level">
                                      <li><a href="{{ url('clientfile') }}">File Directory</a></li>
                                      <li><a href="{{ url('backup') }}"> Database Backup</a></li>

                                      <li><a href="{{ url('activitylog') }}">Activity Log</a>
                                      </li>
                                      <li><a href="{{ url('userlog') }}">User Log</a></li>

                                  </ul>

                              </li>
                              <li><a href="{{ url('connection') }}"><i
                                          class="typcn typcn-news d-block mr-2"></i>Connection</a></li>
                              <li><a href="{{ url('traininglist') }}"><i
                                          class="typcn typcn-pencil d-block mr-2"></i>Training
                                      List</a></li>
                          @endif
                      @endif

                  @endforeach
                  @if (auth()->user()->teammember_id == 99)
                      <li><a href="{{ url('teammember') }}"><i class="typcn typcn-user-add-outline mr-2"></i>Team</a>
                      </li>
                      <li>
                          <a class="has-arrow material-ripple" href="#">
                              <i class="typcn typcn-cog-outline mr-2"></i>
                              Configuration
                          </a>
                          <ul class="nav-second-level">
                              <li><a href="{{ url('assignment') }}">Assignment Name</a></li>
                          </ul>
                      </li>
                  @endif

                  {{-- @if (auth()->user()->teammember_id == 157 || auth()->user()->teammember_id == 550)
              <li><a href="{{url('penality')}}"><i class="typcn typcn-document-text mr-2"></i>Penalty</a></li>
              @endif
              @if (auth()->user()->role_id == 11 || auth()->user()->role_id == 18)
              <li><a href="{{url('penality')}}"><i class="typcn typcn-document-text mr-2"></i>Penalty</a></li>
              @endif --}}


                  @php
                      $ifcs = DB::table('atrs')
                          ->where('responsible_person', auth()->user()->teammember_id)
                          ->first();
                  @endphp
                  @if ($ifcs != null)
                      <li><a href="{{ url('atrlists') }}"><i class="typcn typcn-document-text outline mr-2"></i>
                              ATR</a>
                      </li>
                  @endif

                  {{-- 

              @php
              $staffassignsDatas = DB::table('staffassigns')
              ->where('staff_id',auth()->user()->teammember_id)->first();
              // dd($staffassignsDatas);
              @endphp
              @if ($staffassignsDatas != null)
              <li><a href="{{url('client')}}"><i class="typcn typcn-edit d-block mr-2"></i>Client</a></li>
              @endif
              @if (auth()->user()->teammember_id == 343)
              <li><a href="{{url('appointmentletter')}}"><i class="typcn typcn-edit d-block mr-2"></i> Appointment
                      letter</a></li>
              @endif
              <!--<li><a href="{{url('atr')}}"><i class="typcn typcn-document-text outline mr-2"></i>ATR Control</a></li> -->
              @if (auth()->user()->role_id == 18)
              <li><a href="{{url('teammember')}}"><i class="typcn typcn-user-add-outline mr-2"></i>Team</a></li>
              <li><a href="{{url('staffdetail')}}"><i class="typcn typcn-pen mr-2"></i> Tender Details</a></li>
              @endif
              @if (auth()->user()->teammember_id == 510)
              <li><a href="{{url('staffdetail')}}"><i class="typcn typcn-pen mr-2"></i> Tender Details</a></li>
              @endif
              @if (auth()->user()->role_id != 15)
              <li><a href="{{url('secretaryoftask')}}"><i class="fas fa-tasks mr-2"></i> Secretarial Task</a></li>
              @endif
              @if (auth()->user()->teammember_id == 310)
              <li><a href="{{url('secretaryoftask')}}"><i class="fas fa-tasks mr-2"></i> Secretarial Task</a></li>
              @endif


              @if (auth()->user()->teammember_id != 6)
              @php
              $training = App\Models\Training::where('teammember_id', auth()->user()->teammember_id ??'')->first();
              @endphp
              @if ($training == null)
              <li><a href="{{url('training/create')}}"><i class="typcn typcn-group-outline d-block mr-2"></i>Training
                      Declaration </a></li>
              @endif
              @endif
              @php
              $ifcs = DB::table('ifcs')
              ->where('assign_member',auth()->user()->teammember_id)->first();
              @endphp
              @if ($ifcs != null)
              <li><a href="{{url('ifcfolders')}}"><i class="typcn typcn-document-text outline mr-2"></i> IFC</a>
              </li>
              @endif --}}
              </ul>
          </nav>
      </div><!-- sidebar-body -->
  </nav>
