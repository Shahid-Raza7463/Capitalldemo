 <!--Third party Styles(used by this page)--> 
 <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">

@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
			 @if(23 == Auth::user()->teammember_id || Auth::user()->teammember_id == $localconveyance->createdby)
			 @if($localconveyance->Status=='0' || $localconveyance->Status=='4')
            <li class="btn btn-info ml-2"><a href="{{route('localconveyance.edit', $localconveyance->id ??'')}}" style="color:white;">Edit
                    </a></li>
			   @endif
			   @endif
			<li>     <a class="btn btn-success ml-2" href="{{ url('localconveyance') }}">
          Back</a></li>

        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Local Conveyance
                    List</small>
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
            <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:710px;">
              
                <div class="card-body">
  
                    <fieldset class="form-group">

                        <table class="table display table-bordered table-striped table-hover">

                            <tbody>
                           
                                <tr>
                                    <td><b>Name of Client : </b></td>
                                    <td>{{ $localconveyance->client_name}}</td>
                                    <td><b>Audit Place :</b></td>
                                    <td>{{$localconveyance->place }}</td>
                                </tr>
                                <tr>  
                                    <td><b>Date Assignment : </b></td>
                                    <td>{{ $localconveyance->dateassignment ??''}}</td>
                                    <td><b>Nature :</b></td>
                                    <td>{{$localconveyance->Nature }}</td>
                                </tr>
                                <tr>
                                <td><b>Audit Period from Date : </b></td>
                                    <td>{{ date('F d,Y', strtotime($localconveyance->Audit_from_date)) }}</td>
                                    <td><b>Audit Period to Date : </b></td>
                                    <td>{{ date('F d,Y', strtotime($localconveyance->Audit_from_date)) }}</td>
                                 </tr>
                             
                                <tr>
                                   <td><b>Remarks : </b></td>
                                    <td>{{ $localconveyance->Remarks ??''}}</td>
                                    <td><b>Createdby : </b></td>
                                    <td>{{ App\Models\Teammember::select('team_member')->where('id',$localconveyance->createdby)->first()->team_member ?? ''}}</td>
                                </tr>
                                <tr>
                                <td><b>Visiting from Date : </b></td>
                                    <td>{{ date('F d,Y', strtotime($localconveyance->Visiting_from_date)) }}</td>
                                    <td><b>Visiting Period to Date :</b></td>
                                    <td>{{ date('F d,Y', strtotime($localconveyance->Visiting_date)) }}</td>
                                 </tr>
                                <tr>
                                    <td><b>Leave Day : </b></td>
                                    <td>{{ $localconveyance->leave_day}}</td>
                                    <td><b>Total Days :</b></td>
                                    <td>{{$localconveyance->totaldays }}</td>
                                </tr>
                                <tr>
                                    <td><b>Approved Conveyance (Rs) : </b></td>
                                    <td>{{ $localconveyance->Approved_Conveyance}}</td>
                                    <td><b>Total Value :</b></td>
                                    <td>{{$localconveyance->Total_Value }}</td>
                                </tr>
                                <tr>
                                <td><b>Bill Paid : </b></td>
                                    <td>{{ $localconveyance->billpaid}}</td>
                                    <td><b>Client Invoice Number :</b></td>
                                    <td>{{$localconveyance->Client_Invoice_Number }}</td>
                                 </tr>
                                <tr> 
                                    <td><b>Attachment : </b></td>
                                    <td><a style="color: #37A000" data-toggle="modal" data-target="#exampleModal1" 
                                        >View</a></td>
                                    <td><b>Recoverable :</b></td>
                                    <td>{{$localconveyance->Recoverable }}</td>
                                </tr>
                                <tr>
                                    <td><b>Passed : </b></td>
                                    <td>{{ $localconveyance->Passed}}</td>
                                    <td><b>Approved :</b></td>
                                    <td>{{$localconveyance->Approved }}</td>
                                </tr>
                                <tr>
                                <td><b>Total Amount Payable : </b></td>
                                    <td>{{ $localconveyance->Total_Amount_Payable}}</td>
                                    @if($localconveyance->correction != null)
                                    <td>
                                    <b>Correction/Clarification : </b></td>
                                    <td>{{ $localconveyance->correction}}</td>
                                    @endif
                               </tr>
                               <tr>
                               
                                  
                                    <td><b>Status : </b></td>
                                    <td>@if($localconveyance->Status==0)
                                    <span class="badge badge-info">Created</span>
                                    @elseif($localconveyance->Status==1)
                                    <span class="badge badge-success">Approved</span>
                                    @elseif($localconveyance->Status==2)
                                    <span class="badge badge-danger">Rejected</span>
                                    @elseif($localconveyance->Status==4)
                                    <span class="badge badge-secondary">Pending For Correction/Clarification</span>
                                    @else
                                    <span class="badge badge-warning">Submitted</span>
                                    @endif</td>
                               </tr>
                                <tr>
                                   
                                    @if(Request::is('localconveyance/*'))  
                                    @if(23 == Auth::user()->teammember_id)
                                    
                                        @if($localconveyance->Status=='0')
                                        <td><b>Action :</b></td>
                                        <td>  
                                            <div class="row">
                                      
                                        <form method="post" action="{{ route('localconveyance.update', $localconveyance->id)}}"  enctype="multipart/form-data">
                                            @method('PATCH') 
                                            @csrf   
                                        <button type="submit" class="btn btn-success" > Approve</button>
                                        <input type="text" hidden id="example-date-input" name="Status" value="1" class="form-control"
                                        placeholder="Enter Location">
                                        </form>
                                        <form method="post" action="{{ route('localconveyance.update', $localconveyance->id)}}"  enctype="multipart/form-data">
                                            @method('PATCH') 
                                            @csrf 
                                        <button style="margin-left:11px;" type="submit" class="btn btn-danger" > Reject</button>
                                        <input hidden type="text" id="example-date-input" name="Status" value="2" class="form-control"
                                        placeholder="Enter Location">
                                    </form>
                                 
                                    <button style="margin-left:11px;height: 35px;"  data-toggle="modal"    data-target="#exampleModal12" class="btn btn-info" >Clarification</button>
                                   
                              
                                        @endif
                                        </div>
                                        </td>
    
                                  
                               
                                @endif
                                @endif
                                </tr>
                              
                            </tbody>
                           
                        </table>
                       
                        
                    </fieldset>
                    
                </div>
            </div>
        </div>
    </div>

</div>


<script>
    function myFunction() {
      document.getElementById("panel").style.display = "block";
    }
	</script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="{{ url('backEnd/ckeditor/ckeditor.js')}}"></script>
    
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
            })
            .then(editor => {
                window.editor = editor;
            })
            .catch(err => {
                console.error(err.stack);
            });
    
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor1'), {
                // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
            })
            .then(editor => {
                window.editor = editor;
            })
            .catch(err => {
                console.error(err.stack);
            });
    
    </script>
    
@endsection

<!--Page Active Scripts(used by this page)-->
<script src="{{ url('backEnd/dist/js/pages/forms-basic.active.js')}}"></script>
<!--Page Scripts(used by all page)-->
<script src="{{ url('backEnd/dist/js/sidebar.js')}}"></script>
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('viewassignment/contactupdate') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background:#37A000 ">
                    <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Local Conveyance Files</h5>
                    <div>
                        <ul>
                            @foreach ($errors->all() as $e)
                            <li style="color:red;">{{$e}}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
              <div class="modal-body">
                    <div class="table-responsive">

                        <table class="table display table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>File</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($localconveyancefile as $localconveyancefiles)
                                <tr>
                                    <td><a target="blank" href="{{url('/backEnd/image/localconveyance/'.$localconveyancefiles->attachment)}}">{{ $localconveyancefiles->attachment??''}}</a></td>
                                   
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
  <!-- Small modal -->
  <div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
            <div class="modal-header" style="background:#37A000">
                <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel1">Ask for Correction/Clarification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ route('localconveyance.update', $localconveyance->id)}}"  enctype="multipart/form-data">
                @method('PATCH') 
                @csrf   
            <div class="modal-body">
                <div class="row row-sm">
                    <div class="col-12">
                        <div class="form-group">
                            <textarea rows="6" name="correction" class="form-control"
                                placeholder="Enter Reason"></textarea>
                                <input hidden type="text" id="example-date-input" name="Status" value="4" class="form-control"
                                placeholder="Enter Location">
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