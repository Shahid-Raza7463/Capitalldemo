
 <!--Third party Styles(used by this page)--> 
 <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<div class="body-content">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header" style="background: #37A000;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="col-md-6">
                            <h6 style="color: white" class="fs-17 font-weight-600 mb-0">Edit Fullandfinal</h6>
						 </div>
                         @if($fullandfinal->Final_Status_of_Full_and_Final=='2')
						<div class="col-md-6">
							<p style="float: right;color: white;"><a data-toggle="modal" data-target="#exampleModal12" ><b>Reminder</b></a></p>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('fullandfinal.update', $fullandfinal->id)}}"  enctype="multipart/form-data">
                        @method('PATCH') 
                        @csrf            
                        @component('backEnd.components.alert')

                        @endcomponent   
                    @include('backEnd.fullandfinal.form')
                </form>
                    <hr class="my-4">

                </div>
            </div>
        </div>
    </div>
</div>
<!--/.body content-->
<!-- Modal -->
<div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('/fullandfinal/reminder')}}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background:#37A000;color:white;">
                    <h5 class="modal-title font-weight-600" id="exampleModalLabel4">Send Reminder Mail</h5>
                    <div>
                        <ul>
                            @foreach ($errors->all() as $e)
                            <li style="color:red;">{{$e}}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button style="color: white" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row row-sm">
                        {{-- <label for="name" class="col-sm-3 col-form-label font-weight-600">Name :</label> --}}
                        <div class="col-sm-12">
                            <input placeholder=" Enter Subject" value="Kgs Fullandfinal Reminder"  class="form-control" name="subject" type="text">
                        </div>
                     
                    </div>
                  <br>
                    <div class="row row-sm">
                        <div class="col-sm-12"> 
                            <textarea rows="4" name="description" value="  " class="centered form-control" id="summernote"
                                placeholder="Enter Description"><h3><b>Dear Sir/Madam</b></h3> <br><br>
                            This is Reminder to provide an account clearance for <b>{{ $employee->Name ??''}}</b></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
						  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
            </form>
				     
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
        var fieldHTML = '<div class="row row-sm "><div class="col-4"><div class="form-group"><label class="font-weight-600">Document Name </label><input type="text" class="form-control key" name="document_name[]" id="key" value=""  placeholder="Enter Document Name"></div></div><div class="col-3"> <div class="form-group"> <label class="font-weight-600">File * </label>  <input type="file" class="form-control key" name="filess[]" id="key" value=""  placeholder="Enter Document Name"> </div> </div><div class="col-4"> <div class="form-group"> <label class="font-weight-600"> Document Type </label>  <input type="text" class="form-control key" name="type[]" id="key" value=""  placeholder="Enter Document Type"> </div> </div><a style="margin-top: 36px;" href="javascript:void(0);" class="remove_button"><img src="{{ url('backEnd/image/remove-icon.png')}}"/></a></div></div>'; //New input field html 
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