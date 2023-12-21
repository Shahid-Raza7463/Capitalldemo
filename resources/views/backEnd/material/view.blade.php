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
            
             <li> <a class="btn btn-success ml-2" href="{{ url('material') }}">
                     Back</a></li>
         </ol>
     </nav>
     <div class="col-sm-8 header-title p-0">
         <div class="media">
             <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
             <div class="media-body">
                 <h1 class="font-weight-bold">Home</h1>
                 <small>Material List</small>
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
             <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);">

                 <div class="card-body">

                     <fieldset class="form-group">

                         <table class="table display table-bordered table-striped table-hover">

                             <tbody>
                             @if($material->type == 0)
                                 <tr>
                                     <td><b>Item Name :</b></td>
                                     <td>{{$material->item_name ??''}}</td>
                                     <td><b>Quantity :</b></td>
                                     <td>{{$material->quantity ??''}}</td>
                                   
                                 </tr>
                                 <tr>
                                     <td><b>Date Time :</b></td>
                                     <td>{{ date('F d,Y', strtotime($material->date_time)) }} {{ date('h:i A', strtotime($materialoutData->date_time)) }}</td>
                                     <td><b>Sender Name : </b></td>
                                     <td>{{ $material->sender_name ??'' }}</td>
                                 </tr>
                                 <tr> 
                                 <td><b>Item Value : </b></td>
                                     <td>{{ $material->item_value ??'' }}</td>
                                       <td><b>Receiver : </b></td>
                                     <td>{{$material->team_member ??''}} ({{$material->rolename ??''}})</td> 
                                </tr>
                                <tr> 
                                <td><b>Status : </b></td>
                                     <td>@if($material->status==0)
                                        <span class="badge badge-info">Created</span>
                                        @else
                                        <span class="badge badge-warning">Revcive</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Created By : </b></td>
                                    <td>{{ App\Models\Teammember::select('team_member')->where('id',$materialoutData->createdby)->first()->team_member ?? ''}}</td>
                                    <td><b>Created Date</b></td>
                                    <td>{{ date('F d,Y', strtotime($materialoutData->created_at)) }}</td>
                               </tr>
                            @else
                                   <tr>
                                   <td><b>Item Name :</b></td>
                                     <td>{{$materialoutData->item_name ??''}}</td>
                                     <td><b>Quantity :</b></td>
                                     <td>{{$materialoutData->quantity ??''}}</td>
                                 </tr>
                                 <tr>
                                     <td><b>Date Time : </b></td>
                                     <td>{{ date('F d,Y', strtotime($materialoutData->date_time)) }} {{ date('h:i A', strtotime($materialoutData->date_time)) }}</td>
                                     <td><b>Price :</b></td>
                                     <td>{{$materialoutData->price ??''}}</td>
                                   
                                 </tr>
                                 <tr>
                                     <td><b>Item Details : </b></td>
                                     <td>{{$materialoutData->item_detail ??''}}</td>
                                     <td><b>Approver : </b></td>
                                     <td>{{$materialoutData->team_member ??''}} ({{$materialoutData->rolename ??''}})</td> 
                                 </tr>
                                 <tr>
                                     <td><b>Item Type : </b></td>
                                     <td> @if($materialoutData->item_type==0)
                                        <span class="badge badge-warning">Rentable</span> <br>
                                        <span><b>Expected Date</b> : {{ date('F d,Y', strtotime($materialoutData->expected_date)) }}</span>
                                     @else
                                        <span class="badge badge-danger">Non Rentable</span>
                                    @endif
                                    </td>
                                     <td><b>Expected Date : </b></td>
                                     <td>{{ date('F d,Y', strtotime($materialoutData->expected_date)) }}</td>
                                 </tr>
                                 <tr>
                                     <td><b>Status : </b></td>
                                     <td>@if($materialoutData->out_status==0)
                                        <span class="badge badge-info">Not Acknowledge</span>
                                        @elseif($materialoutData->out_status==1)
                                        <span class="badge badge-success">Acknowledge</span>
                                        @else
                                        <span class="badge badge-danger">Rejected</span>
                                        @endif</td>
                                        @if($materialoutData->reject_for_reaction !=  null)
                                     <td><b>Reject for Reaction : </b></td>
                                     <td>{{$materialoutData->reject_for_reaction ??'' }}</td>
                                     @endif
                                </tr>
                                <tr>
                                    <td><b>Created By : </b></td>
                                    <td>{{ App\Models\Teammember::select('team_member')->where('id',$materialoutData->createdby)->first()->team_member ?? ''}}</td>
                                    <td><b>Created Date</b></td>
                                    <td>{{ date('F d,Y', strtotime($materialoutData->created_at)) }}</td>
                               </tr>
                                @endif
                               
                                @if($materialoutData->type==0)
                                @if($material->status==0 )
                                @if($material->status==0 )
                                <tr>
                                    <td><b>Action :</b></td>
                                    <td>
                                        <div class="row">

                                            <form method="post"
                                                action="{{ url('material/receiver', $material->id)}}"
                                                enctype="multipart/form-data">
                                              
                                                @csrf
                                                <button type="submit" class="btn btn-success">Acknowledge</button>
                                                <input type="text" hidden id="example-date-input" name="status"
                                                    value="1" class="form-control">
                                            </form>
                                    </div>
                                         </td>
                                    
                                  </tr>
                                  @endif
                                  @endif
                              @else
                              <tr>
                              @if($material->out_status==0)
                                    <td><b>Action :</b></td>
                                    <td>
                                        <div class="row">

                                            <form method="post"
                                                action="{{ url('material/update', $material->id)}}"
                                                enctype="multipart/form-data">
                                                
                                                @csrf
                                                <button type="submit" class="btn btn-success"> Acknowledge</button>
                                                <input type="text" hidden id="example-date-input" name="out_status"
                                                    value="1" class="form-control">   
                                            </form>  
                                            
                                         
                                    </div>
                                   
                                    </td>
                                @endif    
                                  </tr>
                                @endif
                             </tbody>
                         </table>
                     </fieldset>
 
                 </div>
             </div>
         </div>
     </div>

 </div>

<!--Modal start-->
 <div class="modal fade" id="Modal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
 aria-hidden="true">
 <div class="modal-dialog" role="document">
     <div class="modal-content">
           <div class="modal-header" style="background:#37A000">
               <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel1">Reject for Reaction</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <form method="post" action="{{ url('material/update', $material->id)}}" enctype="multipart/form-data">
              
               @csrf   
           <div class="modal-body">
               <div class="row row-sm"> 
                   <div class="col-12">
                       <div class="form-group">   
                        <label class="font-weight-600">Remark</label><br>
                        <textarea rows="6" name="reject_for_reaction" class="centered form-control" id="editor"
                                placeholder="Enter Description"></textarea>
                        <input type="text" hidden id="example-date-input" name="out_status"
                                                    value="2" class="form-control">
                    </div>
                   </div>
                   
                   </div>
                   <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
               <button type="submit" style="float: right" class="btn btn-success">Save </button>
           </div>
           </form>
       </div>
   </div>
</div>
 @endsection

