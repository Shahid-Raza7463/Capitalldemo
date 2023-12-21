 <!--Third party Styles(used by this page)-->
 <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">

 @extends('backEnd.layouts.layout') @section('backEnd_content')
<style>
	.table-bordered td, .table-bordered th {
    word-break: break-all;
}
	</style>
 <!--Content Header (Page header)-->
 <div class="content-header row align-items-center m-0">
     <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
         <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
           
             <li> <a class="btn btn-success ml-2" href="{{ url('notification') }}">
                     Back</a></li>
         </ol>
     </nav>
     <div class="col-sm-8 header-title p-0">
         <div class="media">
             <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
             <div class="media-body">
                 <h1 class="font-weight-bold">Home</h1>
                 <small>Announcement  Details</small>
             </div>
         </div>
     </div>
 </div>
 <!--/.Content Header (Page header)-->
 <div class="body-content">
  
 <div class="card mb-4">
            <div class="card-header" style="background: #37A000">
                <div class="">
                    <div style="text-align: center;">
                        <h5 style="color:white;" class="fs-17 font-weight-600 mb-0">{{ $notificationData->title ??''}}</h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
				<br>
 {!! $notificationData->mail_content !!}
            </div>
        </div>
 </div>

 @endsection
