  <!--Third party Styles(used by this page)-->
  <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">

  @extends('backEnd.layouts.layout') @section('backEnd_content')
      <!--Content Header (Page header)-->
      <div class="content-header row align-items-center m-0">
          <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">

          </nav>
          <div class="col-sm-8 header-title p-0">
              <div class="media">
                  <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                  <div class="media-body">
                      <h1 class="font-weight-bold">Home</h1>
                      <small>Team Workbook List</small>
                  </div>
              </div>
          </div>
      </div>
      <!--/.Content Header (Page header)-->
      <div class="body-content">
          <div class="card mb-4">
              {{-- @php
                  dd($get_date);
              @endphp --}}



              <div class="card-body">
                  @component('backEnd.components.alert')
                  @endcomponent
                  <div class="table-responsive">
                      {{-- filtering functionality --}}

                      {{-- ! runnig for patner --}}
                      {{-- <div class="row row-sm">
                          <div class="col-2">
                              <div class="form-group">
                                  <label class="font-weight-600">All Partner</label>
                                  <select class="language form-control" id="category1" name="partnersearch">
                                      <option value="">Please Select One</option>
                                      @foreach ($partner as $teammemberData)
                                          <option value="{{ $teammemberData->id }}">
                                              {{ $teammemberData->team_member }}
                                          </option>
                                      @endforeach
                                  </select>

                              </div>
                          </div>

                          <div class="col-2">
                              <div class="form-group">
                                  <label class="font-weight-600">Start Date</label>
                                  <input type="date" class="form-control" id="start" name="start">

                              </div>
                          </div>
                          <div class="col-2">
                              <div class="form-group">
                                  <label class="font-weight-600">End Date</label>
                                  <input type="date" class="form-control" name="end" id="end">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label class="font-weight-600">Total Timesheet Filled Day</label>
                                  <select class="language form-control" id="category3" name="totaldays">
                                      <option value="">Please Select One</option>
                                      @php
                                          $displayedValues = [];
                                      @endphp
                                      @foreach ($get_date as $jobDatas)
                                          @if (!in_array($jobDatas->totaldays, $displayedValues))
                                              <option value="{{ $jobDatas->totaldays }}">
                                                  {{ $jobDatas->totaldays }}
                                              </option>
                                              @php
                                                  $displayedValues[] = $jobDatas->totaldays;
                                              @endphp
                                          @endif
                                      @endforeach
                                  </select>
                              </div>
                          </div>

                          <div class="col-3">
                              <div class="form-group">
                                  <label class="font-weight-600">Total Hour</label>
                                  <select class="language form-control" id="category4" name="totalhours">
                                      <option value="">Please Select One</option>
                                      @php
                                          $displayedValues = [];
                                      @endphp
                                      @foreach ($get_date as $jobData)
                                          @if (!in_array($jobData->totaltime, $displayedValues))
                                              <option value="{{ $jobData->totaltime }}">
                                                  {{ $jobData->totaltime }}
                                              </option>
                                              @php
                                                  $displayedValues[] = $jobData->totaltime;
                                              @endphp
                                          @endif
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                      </div> --}}
                      <div class="row row-sm">
                          <div class="col-3">
                              <div class="form-group">
                                  <label class="font-weight-600">Team Name</label>
                                  <select class="language form-control" id="category7" name="teamname">
                                      <option value="">Please Select One</option>
                                      @php

                                          $displayedValues = [];
                                      @endphp
                                      @foreach ($get_date as $jobDatas)
                                          @if (!in_array($jobDatas->team_member, $displayedValues))
                                              <option value="{{ $jobDatas->teamid }}">
                                                  {{ $jobDatas->team_member }}
                                              </option>
                                              @php
                                                  $displayedValues[] = $jobDatas->team_member;
                                              @endphp
                                          @endif
                                      @endforeach
                                  </select>
                              </div>
                          </div>


                          <div class="col-3">
                              <div class="form-group">
                                  <label class="font-weight-600">Start Date</label>
                                  <input type="date" class="form-control" id="start" name="start">

                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label class="font-weight-600">End Date</label>
                                  <input type="date" class="form-control" name="end" id="end">
                              </div>
                          </div>
                          {{-- <div class="col-3">
                              <div class="form-group">
                                  <label class="font-weight-600">Total Timesheet Filled Day</label>
                                  <select class="language form-control" id="category3" name="totaldays">
                                      <option value="">Please Select One</option>
                                      @php
                                          $displayedValues = [];
                                      @endphp
                                      @foreach ($get_date as $jobDatas)
                                          @if (!in_array($jobDatas->totaldays, $displayedValues))
                                              <option value="{{ $jobDatas->totaldays }}">
                                                  {{ $jobDatas->totaldays }}
                                              </option>
                                              @php
                                                  $displayedValues[] = $jobDatas->totaldays;
                                              @endphp
                                          @endif
                                      @endforeach
                                  </select>
                              </div>
                          </div> --}}

                          <div class="col-3">
                              <div class="form-group">
                                  <label class="font-weight-600">Total Hour</label>
                                  <select class="language form-control" id="category4" name="totalhours">
                                      <option value="">Please Select One</option>
                                      @php
                                          $displayedValues = [];
                                      @endphp
                                      @foreach ($get_date as $jobData)
                                          @if (!in_array($jobData->totaltime, $displayedValues))
                                              <option value="{{ $jobData->totaltime }}">
                                                  {{ $jobData->totaltime }}
                                              </option>
                                              @php
                                                  $displayedValues[] = $jobData->totaltime;
                                              @endphp
                                          @endif
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          {{-- <div class="col-2">
                              <div class="form-group">
                                  <label class="font-weight-600">Partner</label>
                                  <select class="language form-control" id="category1" name="partnersearch">
                                      <option value="">Please Select One</option>
                                      @php
                                          $displayedValues = [];
                                      @endphp
                                      @foreach ($get_date as $jobDatas)
                                          @if (!in_array($jobDatas->partnername, $displayedValues))
                                              <option value="{{ $jobDatas->partnerid }}">
                                                  {{ $jobDatas->partnername }}
                                              </option>
                                              @php
                                                  $displayedValues[] = $jobDatas->partnername;
                                              @endphp
                                          @endif
                                      @endforeach
                                  </select> --}}

                          {{-- <select class="language form-control" id="category1" name="partnersearch">
                                    <option value="">Please Select One</option>
                                    @foreach ($partner as $teammemberData)
                                        <option value="{{ $teammemberData->id }}">
                                            {{ $teammemberData->team_member }}
                                        </option>
                                    @endforeach
                                </select> --}}
                          {{-- 
                              </div>
                          </div> --}}
                      </div>

                      <table class="table display table-bordered table-striped table-hover basic">
                          <thead>
                              <tr>
                                  <th>Team Name</th>
                                  <th>Period Date ( Monday To Saturday )</th>
                                  <th>Total Timesheet Filled Day</th>
                                  <th>Total Hour</th>
                                  {{-- <th>Partner</th> --}}
                              </tr>
                          </thead>
                          <tbody>
                              @foreach ($get_date as $jobDatas)
                                  <tr>
                                      <td><a
                                              href="{{ url(
                                                  '/weeklylist?' .
                                                      'id=' .
                                                      $jobDatas->id .
                                                      '&&' .
                                                      'teamid=' .
                                                      $jobDatas->teamid .
                                                      '&&' .
                                                      'partnerid=' .
                                                      $jobDatas->partnerid .
                                                      '&&' .
                                                      'startdate=' .
                                                      $jobDatas->startdate .
                                                      '&&' .
                                                      'enddate=' .
                                                      $jobDatas->enddate,
                                              ) }}">{{ $jobDatas->team_member }}</a>
                                      </td>
                                      <td>{{ $jobDatas->week }}</td>
                                      <td>{{ $jobDatas->totaldays }}</td>
                                      <td>{{ $jobDatas->totaltime }}</td>
                                      {{-- <td>{{ $jobDatas->partnername }}</td> --}}
                              @endforeach
                          </tbody>
                      </table>
                  </div>

              </div>
          </div>

      </div>
      <!--/.body content-->
  @endsection

  {{-- filter on timesheet submitted --}}
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  {{-- ! runnig code --}}

  {{-- <script>
      $(document).ready(function() {
        
          //   all partner
          $('#category1').change(function() {
              var search1 = $(this).val();
              var search4 = $('#category4').val();
              var search3 = $('#category3').val();
              var search2 = $('#category2').val();
              //   console.log(search1);
              // Send an AJAX request to fetch filtered data based on the selected partner
              $.ajax({
                  type: 'GET',
                  url: '/filter-dataadmin',
                  data: {
                      partnersearch: search1,
                      searchdate: search2,
                      totaldays: search3,
                      totalhours: search4
                  },
                  success: function(data) {
                      // Clear the table body
                      $('table tbody').html("");

                      if (data.length === 0) {
                          // If no data is found, display a "No data found" message
                          $('table tbody').append(
                              '<tr><td colspan="5" class="text-center">No data found</td></tr>'
                          );
                      } else {
                          $.each(data, function(index, item) {

                              // Create the URL dynamically
                              var url = '/weeklylist?id=' + item.id +
                                  '&teamid=' + item.teamid +
                                  '&partnerid=' + item.partnerid +
                                  '&startdate=' + item.startdate +
                                  '&enddate=' + item.enddate;

                              // Add the rows to the table
                              $('table tbody').append('<tr>' +
                                  '<td><a href="' + url + '">' + item
                                  .team_member +
                                  '</a></td>' +
                                  '<td>' + item.week + '</td>' +
                                  '<td>' + item.totaldays + '</td>' +
                                  '<td>' + item.totaltime + '</td>' +
                                  '<td>' + item.partnername + '</td>' +
                                  '</tr>');
                          });
                      }
                  }
              });
          });
          
          //** end date
          $('#end').change(function() {
              var search9 = $(this).val();
              var search8 = $('#start').val();
              console.log(search9)
              $.ajax({
                  type: 'GET',
                  url: '/filter-dataadmin',
                  data: {
                      end: search9,
                      start: search8
                  },
                  success: function(data) {
                      // Replace the table body with the filtered data
                      $('table tbody').html(""); // Clear the table body

                      if (data.length === 0) {
                          // If no data is found, display a "No data found" message
                          $('table tbody').append(
                              '<tr><td colspan="5" class="text-center">No data found</td></tr>'
                          );
                      } else {
                          $.each(data, function(index, item) {

                              // Create the URL dynamically
                              var url = '/weeklylist?id=' + item.id +
                                  '&teamid=' + item.teamid +
                                  '&partnerid=' + item.partnerid +
                                  '&startdate=' + item.startdate +
                                  '&enddate=' + item.enddate;

                              // Add the rows to the table
                              $('table tbody').append('<tr>' +
                                  '<td><a href="' + url + '">' + item
                                  .team_member +
                                  '</a></td>' +
                                  '<td>' + item.week + '</td>' +
                                  '<td>' + item.totaldays + '</td>' +
                                  '<td>' + item.totaltime + '</td>' +
                                  '<td>' + item.partnername + '</td>' +
                                  '</tr>');
                          });
                      }
                  }
              });
          });
          //   days wise
          $('#category3').change(function() {
              var search3 = $(this).val();
              var search4 = $('#category4').val();
              var search2 = $('#category2').val();
              var search1 = $('#category1').val();
              // Send an AJAX request to fetch filtered data based on the selected partner
              $.ajax({
                  type: 'GET',
                  url: '/filter-dataadmin',
                  data: {
                      partnersearch: search1,
                      searchdate: search2,
                      totaldays: search3,
                      totalhours: search4
                  },
                  success: function(data) {
                      // Replace the table body with the filtered data
                      $('table tbody').html(""); // Clear the table body

                      if (data.length === 0) {
                          // If no data is found, display a "No data found" message
                          $('table tbody').append(
                              '<tr><td colspan="5" class="text-center">No data found</td></tr>'
                          );
                      } else {
                          $.each(data, function(index, item) {

                              // Create the URL dynamically
                              var url = '/weeklylist?id=' + item.id +
                                  '&teamid=' + item.teamid +
                                  '&partnerid=' + item.partnerid +
                                  '&startdate=' + item.startdate +
                                  '&enddate=' + item.enddate;

                              // Add the rows to the table
                              $('table tbody').append('<tr>' +
                                  '<td><a href="' + url + '">' + item
                                  .team_member +
                                  '</a></td>' +
                                  '<td>' + item.week + '</td>' +
                                  '<td>' + item.totaldays + '</td>' +
                                  '<td>' + item.totaltime + '</td>' +
                                  '<td>' + item.partnername + '</td>' +
                                  '</tr>');
                          });
                      }
                  }
              });
          });

          //   total hour wise
          $('#category4').change(function() {
              var search4 = $(this).val();
              var search3 = $('#category3').val();
              var search2 = $('#category2').val();
              var search1 = $('#category1').val();
              // Send an AJAX request to fetch filtered data based on the selected partner
              $.ajax({
                  type: 'GET',
                  url: '/filter-dataadmin',
                  data: {
                      partnersearch: search1,
                      searchdate: search2,
                      totaldays: search3,
                      totalhours: search4
                  },
                  success: function(data) {
                      // Replace the table body with the filtered data
                      $('table tbody').html(""); // Clear the table body
                      if (data.length === 0) {
                          // If no data is found, display a "No data found" message
                          $('table tbody').append(
                              '<tr><td colspan="5" class="text-center">No data found</td></tr>'
                          );
                      } else {
                          $.each(data, function(index, item) {

                              // Create the URL dynamically
                              var url = '/weeklylist?id=' + item.id +
                                  '&teamid=' + item.teamid +
                                  '&partnerid=' + item.partnerid +
                                  '&startdate=' + item.startdate +
                                  '&enddate=' + item.enddate;

                              // Add the rows to the table
                              $('table tbody').append('<tr>' +
                                  '<td><a href="' + url + '">' + item
                                  .team_member +
                                  '</a></td>' +
                                  '<td>' + item.week + '</td>' +
                                  '<td>' + item.totaldays + '</td>' +
                                  '<td>' + item.totaltime + '</td>' +
                                  '<td>' + item.partnername + '</td>' +
                                  '</tr>');
                          });
                      }
                  }
              });
          });
          //shahid
      });
  </script> --}}

  <script>
      $(document).ready(function() {

          //   all partner
          $('#category1').change(function() {
              var search1 = $(this).val();
              var search4 = $('#category4').val();
              var search7 = $('#category7').val();
              //   console.log(search1);
              // Send an AJAX request to fetch filtered data based on the selected partner
              $.ajax({
                  type: 'GET',
                  url: '/filter-dataadmin',
                  data: {
                      partnersearch: search1,
                      totalhours: search4,
                      teamname: search7
                  },
                  success: function(data) {
                      // Clear the table body
                      $('table tbody').html("");

                      if (data.length === 0) {
                          // If no data is found, display a "No data found" message
                          $('table tbody').append(
                              '<tr><td colspan="5" class="text-center">No data found</td></tr>'
                          );
                      } else {
                          $.each(data, function(index, item) {

                              // Create the URL dynamically
                              var url = '/weeklylist?id=' + item.id +
                                  '&teamid=' + item.teamid +
                                  '&partnerid=' + item.partnerid +
                                  '&startdate=' + item.startdate +
                                  '&enddate=' + item.enddate;

                              // Add the rows to the table
                              $('table tbody').append('<tr>' +
                                  '<td><a href="' + url + '">' + item
                                  .team_member +
                                  '</a></td>' +
                                  '<td>' + item.week + '</td>' +
                                  '<td>' + item.totaldays + '</td>' +
                                  '<td>' + item.totaltime + '</td>' +
                                  '<td>' + item.partnername + '</td>' +
                                  '</tr>');
                          });
                          //   remove pagination after filter
                          $('.paging_simple_numbers').remove();
                          $('.dataTables_info').remove();
                      }
                  }
              });
          });

          //** start date
          $('#start').change(function() {
              var search8 = $(this).val();
              var search9 = $('#end').val();
              var search7 = $('#category7').val();
              var search4 = $('#category4').val();
              var search1 = $('#category1').val();

              $.ajax({
                  type: 'GET',
                  url: '/filter-dataadmin',
                  data: {
                      end: search9,
                      start: search8,
                      totalhours: search4,
                      teamname: search7,
                      partnersearch: search1
                  },
                  success: function(data) {
                      // Replace the table body with the filtered data
                      $('table tbody').html(""); // Clear the table body

                      if (data.length === 0) {
                          // If no data is found, display a "No data found" message
                          $('table tbody').append(
                              '<tr><td colspan="5" class="text-center">No data found</td></tr>'
                          );
                      } else {
                          $.each(data, function(index, item) {

                              // Create the URL dynamically
                              var url = '/weeklylist?id=' + item.id +
                                  '&teamid=' + item.teamid +
                                  '&partnerid=' + item.partnerid +
                                  '&startdate=' + item.startdate +
                                  '&enddate=' + item.enddate;

                              // Add the rows to the table
                              $('table tbody').append('<tr>' +
                                  '<td><a href="' + url + '">' + item
                                  .team_member +
                                  '</a></td>' +
                                  '<td>' + item.week + '</td>' +
                                  '<td>' + item.totaldays + '</td>' +
                                  '<td>' + item.totaltime + '</td>' +
                                  '<td>' + item.partnername + '</td>' +
                                  '</tr>');
                          });
                          //   remove pagination after filter
                          $('.paging_simple_numbers').remove();
                          $('.dataTables_info').remove();
                      }
                  }
              });
          });

          //** end date
          $('#end').change(function() {
              var search9 = $(this).val();
              var search8 = $('#start').val();
              var search7 = $('#category7').val();
              var search4 = $('#category4').val();
              var search1 = $('#category1').val();

              $.ajax({
                  type: 'GET',
                  url: '/filter-dataadmin',
                  data: {
                      end: search9,
                      start: search8,
                      totalhours: search4,
                      teamname: search7,
                      partnersearch: search1
                  },
                  success: function(data) {
                      // Replace the table body with the filtered data
                      $('table tbody').html(""); // Clear the table body

                      if (data.length === 0) {
                          // If no data is found, display a "No data found" message
                          $('table tbody').append(
                              '<tr><td colspan="5" class="text-center">No data found</td></tr>'
                          );
                      } else {
                          $.each(data, function(index, item) {

                              // Create the URL dynamically
                              var url = '/weeklylist?id=' + item.id +
                                  '&teamid=' + item.teamid +
                                  '&partnerid=' + item.partnerid +
                                  '&startdate=' + item.startdate +
                                  '&enddate=' + item.enddate;

                              // Add the rows to the table
                              $('table tbody').append('<tr>' +
                                  '<td><a href="' + url + '">' + item
                                  .team_member +
                                  '</a></td>' +
                                  '<td>' + item.week + '</td>' +
                                  '<td>' + item.totaldays + '</td>' +
                                  '<td>' + item.totaltime + '</td>' +
                                  '<td>' + item.partnername + '</td>' +
                                  '</tr>');
                          });
                          //   remove pagination after filter
                          $('.paging_simple_numbers').remove();
                          $('.dataTables_info').remove();
                      }
                  }
              });
          });
          //   total hour wise
          $('#category4').change(function() {
              var search4 = $(this).val();
              var search7 = $('#category7').val();
              var search1 = $('#category1').val();
              // Send an AJAX request to fetch filtered data based on the selected partner
              $.ajax({
                  type: 'GET',
                  url: '/filter-dataadmin',
                  data: {
                      totalhours: search4,
                      teamname: search7,
                      partnersearch: search1
                  },
                  success: function(data) {
                      // Replace the table body with the filtered data
                      $('table tbody').html(""); // Clear the table body
                      if (data.length === 0) {
                          // If no data is found, display a "No data found" message
                          $('table tbody').append(
                              '<tr><td colspan="5" class="text-center">No data found</td></tr>'
                          );
                      } else {
                          $.each(data, function(index, item) {

                              // Create the URL dynamically
                              var url = '/weeklylist?id=' + item.id +
                                  '&teamid=' + item.teamid +
                                  '&partnerid=' + item.partnerid +
                                  '&startdate=' + item.startdate +
                                  '&enddate=' + item.enddate;

                              // Add the rows to the table
                              $('table tbody').append('<tr>' +
                                  '<td><a href="' + url + '">' + item
                                  .team_member +
                                  '</a></td>' +
                                  '<td>' + item.week + '</td>' +
                                  '<td>' + item.totaldays + '</td>' +
                                  '<td>' + item.totaltime + '</td>' +
                                  '<td>' + item.partnername + '</td>' +
                                  '</tr>');
                          });
                          //   remove pagination after filter
                          $('.paging_simple_numbers').remove();
                          $('.dataTables_info').remove();
                      }
                  }
              });
          });

          //   team name wise
          $('#category7').change(function() {
              var search7 = $(this).val();
              var search4 = $('#category4').val();
              var search1 = $('#category1').val();

              // Send an AJAX request to fetch filtered data based on the selected partner
              $.ajax({
                  type: 'GET',
                  url: '/filter-dataadmin',
                  data: {
                      teamname: search7,
                      partnersearch: search1,
                      totalhours: search4
                  },
                  success: function(data) {
                      // Replace the table body with the filtered data
                      $('table tbody').html(""); // Clear the table body
                      if (data.length === 0) {
                          // If no data is found, display a "No data found" message
                          $('table tbody').append(
                              '<tr><td colspan="5" class="text-center">No data found</td></tr>'
                          );
                      } else {
                          $.each(data, function(index, item) {

                              // Create the URL dynamically
                              var url = '/weeklylist?id=' + item.id +
                                  '&teamid=' + item.teamid +
                                  '&partnerid=' + item.partnerid +
                                  '&startdate=' + item.startdate +
                                  '&enddate=' + item.enddate;

                              // Add the rows to the table
                              $('table tbody').append('<tr>' +
                                  '<td><a href="' + url + '">' + item
                                  .team_member +
                                  '</a></td>' +
                                  '<td>' + item.week + '</td>' +
                                  '<td>' + item.totaldays + '</td>' +
                                  '<td>' + item.totaltime + '</td>' +
                                  '<td>' + item.partnername + '</td>' +
                                  '</tr>');
                          });
                          //   remove pagination after filter
                          $('.paging_simple_numbers').remove();
                          $('.dataTables_info').remove();
                      }
                  }
              });
          });
          //shahid
      });
  </script>


  {{-- validation for comparision date and block year for 4 disit --}}
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
      $(document).ready(function() {
          var startDateInput = $('#start');
          var endDateInput = $('#end');

          function compareDates() {
              var startDate = new Date(startDateInput.val());
              var endDate = new Date(endDateInput.val());

              if (startDate > endDate) {
                  alert('End date should be greater than or equal to the Start date');
                  endDateInput.val(''); // Clear the end date input
              }
          }

          startDateInput.on('input', compareDates);
          endDateInput.on('blur', compareDates);
      });
  </script>

  {{-- validation for block 4 digit to  year --}}
  <script>
      $(document).ready(function() {
          $('#start').on('change', function() {
              var startclear = $(this);
              var startDateInput1 = startclear.val();
              var startDate = new Date(startDateInput1);
              var startyear = startDate.getFullYear();
              var yearLength = startyear.toString().length;
              if (yearLength > 4) {
                  alert('Enter four digits for the year');
                  startclear.val('');
              }
          });
          $('#end').on('change', function() {
              var endclearvalue = $(this);
              var endDateInput1 = endclearvalue.val();
              var endtDate = new Date(endDateInput1);
              var endyear = endtDate.getFullYear();
              var endyearLength = endyear.toString().length;
              if (endyearLength > 4) {
                  alert('Enter four digits for the year');
                  endclear.val('');
              }
          });
      });
  </script>
