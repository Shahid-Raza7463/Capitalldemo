 <!--Third party Styles(used by this page)--> 
 <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">


@extends('backEnd.layouts.layout') @section('backEnd_content')

<div class="body-content">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header" style="background: #37A000">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="col-md-6">
                            <h6 style="color:white;" class="fs-17 font-weight-600 mb-0">Edit Invoice</h6>
                        </div>
						<div class="col-md-2">
							<p style="float: right;color:white;"><a data-toggle="modal" data-target="#exampleModal1" ><b>Log</b></a></p>
                        </div>
						<div class="col-md-4">
							<p style="float: right;color:white;"><b>Created by : </b>{{ $invoice->teammember->team_member }} ( {{ $invoice->teammember->role->rolename }} )</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
					
                    @if(auth()->user()->role_id == 17 && $invoice->status == 2 && $invoice->invoice_id != null )
                    <form method="post" action="@if(Request::is('invoice/*/edit'))
                    {{ url('invoiceupdate/'.$id) }}@endif"  enctype="multipart/form-data">
                      
                        @csrf    
                      
                        @else
                    <form method="post" action="{{ route('invoice.update', $invoice->id)}}"  enctype="multipart/form-data">
                        @method('PATCH') 
                        @csrf  
						  @endif    
                        @component('backEnd.components.alert')

                        @endcomponent   
                    @include('backEnd.invoice.form')
                </form>
                    <hr class="my-4">

                </div>
            </div>
        </div>
    </div>
</div>
<!--/.body content-->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
         
                <div class="modal-header" style="background: #37A000">
                    <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Invoice log</h5>
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
                                    <th>Description</th>
                                    <th>Teammember</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoicelog as $invoicelogdata)
                              <tr>
                                  <td>{{ $invoicelogdata->description ??''}}</td>
                                  <td>{{ $invoicelogdata->team_member ??''}}</td>
                                  <td>{{ date('F d,Y', strtotime($invoicelogdata->created_at)) }}   {{ date('h:i A', strtotime($invoicelogdata->created_at)) }}</td>
                              </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
           
        </div>
    </div>
</div>
@endsection

<!--Page Active Scripts(used by this page)-->
<script src="{{ url('backEnd/dist/js/pages/forms-basic.active.js')}}"></script>
<!--Page Scripts(used by all page)-->
<script src="{{ url('backEnd/dist/js/sidebar.js')}}"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = '<div class="row row-sm "><div class="col-4"><div class="form-group"><label class="font-weight-600">Document Name </label><input type="text" class="form-control key" name="document_name[]" id="key" value=""  placeholder="Enter Document Name"></div></div><div class="col-3"> <div class="form-group"> <label class="font-weight-600">File * </label>  <input type="file" class="form-control key" name="filess[]" id="key" value=""  placeholder="Enter Document Name"> </div> </div><div class="col-4"> <div class="form-group"> <label class="font-weight-600"> Document Type </label>   <select class="form-control key" name="type[]" id="key" value="" id="exampleFormControlSelect1" ><option value="0">Permanent</option><option value="1">Temporary</option></select> </div> </div><a style="margin-top: 36px;" href="javascript:void(0);" class="remove_button"><img src="{{ url('backEnd/image/remove-icon.png')}}"/></a></div></div>'; //New input field html 
        var x = 1; //Initial field counter is 1
        
        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){ 
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });
        
        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });
    </script>