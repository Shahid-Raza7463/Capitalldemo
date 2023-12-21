<div class="row row-sm">
  
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Connection Name <span class="tx-danger">*</span></label>
            <input type="text" name="connectionname" value="{{ $connection->connectionname ?? ''}}" class="form-control"
                placeholder="Enter Connection Name">
        </div>
    </div>
    
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Email <span class="tx-danger">*</span></label>
            <input type="email" name="emailid" value="{{ $connection->emailid ?? ''}}" class="form-control"
                placeholder="Enter Email ">
        </div>
    </div>
      <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Phone No<span class="tx-danger">*</span></label>
            <input type="number" name="phoneno" value="{{ $connection->phoneno ?? ''}}" class="form-control"
                placeholder="Enter Phone No">
        </div>
    </div>
</div>
<div class="field_wrapper">
    <div class="row row-sm">
        <div class="col-4">
            <div class="form-group">
                <label class="font-weight-600">Company Name</label>
                <input type="text" class="form-control key" name="companyname[]" id="key" value=""
                    placeholder="Enter Company Name">
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label class="font-weight-600">Designation</label>
                <input type="text" class="form-control key" name="designation[]" id="key" value=""
                    placeholder="Enter Designation">
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label class="font-weight-600">Expertise</label>
                <input type="text" class="form-control key" name="expertise[]" id="key" value=""
                    placeholder="Enter Expertise">
            </div>
        </div>

        <div class="col-1">
            <div class="form-group" style="margin-top: 36px;">
                <a href="javascript:void(0);" class="add_button" title="Add field"><img
                        src="{{ url('backEnd/image/add-icon.png')}}" /></a>
            </div>
        </div>

    </div>
</div> 
<div class="row row-sm">
  
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Connected  Through<span class="tx-danger">*</span></label>
            <input type="text" name="connectedthrough" value="{{ $connection->connectedthrough ?? ''}}" class="form-control"
                placeholder="Enter Connected  Through">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Connected Email <span class="tx-danger">*</span></label>
            <input type="email" name="connectedemail" value="{{ $connection->connectedemail ?? ''}}" class="form-control"
                placeholder="Enter Connected Email ">
        </div>
    </div>
      <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Connected Phone <span class="tx-danger">*</span></label>
            <input type="number" name="connectedphone" value="{{ $connection->connectedphone ?? ''}}" class="form-control"
                placeholder="Enter Connected Phone">
        </div>
    </div>
      <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Relationship  Through<span class="tx-danger">*</span></label>
            <input type="text" name="relationshipthrough" value="{{ $connection->relationshipthrough ?? ''}}" class="form-control"
                placeholder="Enter Relationship  Through">
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Other Comments <span class="tx-danger">*</span></label>
            <textarea rows="4" name="othercomments" value="" class="centered form-control" 
            placeholder="Enter Comments">{!! $connection->othercomments ??'' !!}</textarea>
        </div>
    </div>
</div>
<br>
@if(Request::is('connection/*/edit'))
<div class="table-responsive">
    <table class="table display table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th class="font-weight-600">Company Name</th>
                <th class="font-weight-600">Designation</th>
                <th class="font-weight-600">Expertise</th>
                <th class="font-weight-600">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($connectioncompanies as $connectioncompaniesData)
            <tr>
                <td>{{$connectioncompaniesData->companyname }}</td>
                <td>{{$connectioncompaniesData->designation }}</td>
                <td>{{$connectioncompaniesData->expertise }}</td>
                <td><a href="{{url('/connectioncompanies/destroy/'.$connectioncompaniesData->id)}}"
                    onclick="return confirm('Are you sure you want to delete this item?');"
                    class="btn btn-danger-soft btn-sm"><i class="far fa-trash-alt"></i></a></td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endif
<div class="form-group">
                                <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
                                <a class="btn btn-secondary" href="{{ url('connection') }}">
                                    Back</a>

                            </div>
                    
                            
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = '<div class="row row-sm "><div class="col-4"><div class="form-group"><label class="font-weight-600">Company Name </label><input type="text" class="form-control key" name="companyname[]" id="key" value=""  placeholder="Enter Company Name"></div></div><div class="col-4"> <div class="form-group"> <label class="font-weight-600">Designation * </label>  <input type="text" class="form-control key" name="designation[]" id="key" value=""  placeholder="Enter Designation"> </div> </div><div class="col-3"> <div class="form-group"> <label class="font-weight-600">Designation * </label>  <input type="text" class="form-control key" name="expertise[]" id="key" value=""  placeholder="Enter Exepertise"> </div> </div><a style="margin-top: 36px;" href="javascript:void(0);" class="remove_button"><img src="{{ url('backEnd/image/remove-icon.png')}}"/></a></div></div>'; //New input field html 
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
                          