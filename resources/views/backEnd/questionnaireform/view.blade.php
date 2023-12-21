 <!--Third party Styles(used by this page)--> 
 <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">

@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <!--<nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('task/create')}}">Add task</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>-->
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Target
                    Details</small>
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
            <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:950px;">
              <div class="card-header"
                            style="background: #37A000;color: white;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="col-md-6">
                            <h6 class="fs-17 font-weight-600 mb-0">Target Details</h6>
                        </div>
						<div class="col-md-2">
						 </div>
						<div class="col-md-4">
					  <a style="float: right;color:white;"  href="{{ url('target') }}">
        Back</a>
                        </div>
                            </div>
                        </div>
                <div class="card-body">
                   
  <div class="mailbox-sideber">
                        
                    <hr>

                    <fieldset    class="form-group">

                        <table class="table display table-bordered table-striped table-hover">

                            <tbody>

                                <tr>
                                    <td><b>Name of your Startup : </b></td>
                                    <td>{{ $target->startup_name ??''}}</td>

                                    <td><b>Category          :</b></td>
                                    <td>{{$target->category ??'' }}</td>

                                    
                                </tr>
                                <tr>
                                    <td><b>Sub Category :</b></td>
                                    <td>{{$target->subcategory ??''}}</td>
                                    <td><b>Raising ₹MM  : </b></td>
                                    <td>{{ $target->capital_req ??''}}</td>
                                </tr>
                                <tr>
                                    

                                    <td><b>Offered stake(% of the stake is being offered againts the investment ask.) :</b></td>
                                    <td>{{$target->offered_stake }}</td>
                                    <td><b>Location of the Headquarter :</b></td>
                                    <td>{{$target->headquarter_location ??''}}</td>

                                </tr>
                                <tr>
                                    <td><b>Deck  :</b></td>
                                    <td> <a href="{{ url('backEnd/image/deck/'.$target->deck ??'')}}" target="blank" >{{$target->deck ??''}}</a></td>
                                     
                                </tr>
                                <tr></tr>
                                <tr>
                                    

                                    <td><b>Name(s) of the founder(s) :</b></td>
                                    <td>{{$target->founder_name ??''}}</td>
                                    <td><b>Mobile Number of Founder(s)  :</b></td>
                                    <td>{{$target->founder_contact ??''}}</td>

                                </tr>
                               
                                <tr>
                                    

                                    <td><b>Email:</b></td>
                                    <td>{{$target->email ??''}}</td>
                                    <td><b>Website :</b></td>
                                    <td>{{$target->website ??'' }}</td>

                                </tr>
                               
                                  
                                <tr>
                                    

                                    <td><b>Source :</b></td>
                                    <td>{{$target->source ??'' }}</td>
                            
                                    <td><b>Problem Statement :</b></td>
                                    <td>{{$target->problem ??'' }}</td>

                                </tr>
                                <tr>
                                    

                                    <td><b>Market Size (Is there a big enough market available for this idea?) :</b></td>
                                    <td>{{$target->marget_size ??'' }}</td>
                               
                                    <td><b>Business Model :</b></td>
                                    <td>{{$target->business_model ??'' }}</td>

                                </tr>
                                <tr>
                                    

                                    <td><b>Can your idea scale through digital media? :</b></td>
                                    <td>{{$target->idea_scale_by_digitalmedia ??'' }}</td>
                              
                                    <td><b>How is the product market fit? :</b></td>
                                    <td>{{$target->market_fit ??'' }}</td>

                                </tr>
                                <tr>
                                    

                                    <td><b>USP and Patent :</b></td>
                                    <td>{{$target->usp_and_patent ??'' }}</td>
                          
                                    <td><b>Pre-Covid & Post-Covid revenue :</b></td>
                                    <td>{{$target->revenue ??'' }}</td>

                                </tr>
                                <tr>
                                    

                                    <td><b>Our Ticket Size and Your Valuation :</b></td>
                                    <td>{{$target->ticket_size_and_valuation ??'' }}</td>
                              
                                    <td><b>What is Your Exit Strategy for us? :</b></td>
                                    <td>{{$target->exit_strategy ??'' }}</td>

                                </tr>
                               

                            </tbody>
                           
                        </table>
                   
                       
                        
                    </fieldset>
                </div>
            </div>
        </div>
    </div>

</div>


<!-- Modal -->

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
