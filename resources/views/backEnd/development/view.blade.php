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
            
             <li> <a class="btn btn-success ml-2" href="{{ url('development') }}">
                     Back</a></li>
         </ol>
     </nav>
     <div class="col-sm-8 header-title p-0">
         <div class="media">
             <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
             <div class="media-body">
                 <h1 class="font-weight-bold">Home</h1>
                 <small>Development List</small>
             </div>
         </div>
     </div>
 </div>
 <!--/.Content Header (Page header)-->
 <div class="body-content">
     <div class="card mb-4">
         @component('backEnd.components.alert')

         @endcomponent
         <div class="card-body">
             <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:600px;">

                 <div class="card-body">

                     <fieldset class="form-group">

                         <table class="table display table-bordered table-striped table-hover">

                             <tbody>
                                 <tr>
                                     <td><b>Task Name :</b></td>
                                     <td>{{$development->taskname ??''}}</td>
                                     <td><b>Testing By : </b></td>
                                     <td>{{ App\Models\Teammember::select('team_member')->where('id',$development->testingby)->first()->team_member ?? '' }}</td> 
                                 </tr>
                                 <tr>
                                     <td><b>Testing Date : </b></td>
                                     <td>{{ $development->testingdate ??'' }}</td>
                                     <td><b>Due Date :</b></td>
                                     <td>{{$development->duedate ??''}}</td>
                                 </tr>
                                 <tr> 
                                    <td><b>Task Given By :</b></td>
                                    <td>{{ App\Models\Teammember::select('team_member')->where('id',$development->taskgivenby)->first()->team_member ?? '' }}</td> 
                                    <td><b>Status :</b></td>
                                     <td>
                                     @if($development->status==0)
                                            <span class="badge badge-info">Active</span>
                                            @else
                                            <span class="badge badge-success">Inactive</span>
                                            @endif
                                     </td>
                                </tr>
                                <tr> 
                                <td><b>Remarks :</b></td>
                                     <td>{!! $development->remarks ??''!!}</td>
                                   
                                </tr>
                             </tbody>
                         </table>
                     </fieldset>
 
                 </div>
             </div>
         </div>
     </div>

 </div>

 @endsection

