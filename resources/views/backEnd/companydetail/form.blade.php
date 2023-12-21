<div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
        <label class="font-weight-600">Company Name *</label>
            <input type="text" name="company_name" value="{{ $company->company_name ?? ''}}"class="form-control"
                placeholder="Enter Company Name">
        </div>
    </div>
    <div class="col-3">
            <div class="form-group">
                <label class="font-weight-600">Company Logo *</label>
                <input type="file" class="form-control key" name="companylogo" id="key" value=""
                    placeholder="Enter Document Name">
            </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">State*</label>
            <input type="text" name="state"  class="form-control" value="{{ $company->state ?? ''}}"
                placeholder="Enter State">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">City  *</label>
            <input type="text" name="city"  class="form-control" value="{{ $company->city ?? ''}}"
                placeholder="Enter City">
        </div>
    </div>
    
   
</div>
<div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-600"> Address</label>
            <textarea rows="4" name="address"  class="form-control" 
                placeholder="Enter Communication Address">{!! $company->address ?? ''!!}</textarea>
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Company Email *</label>
            <input type="email" name="company_email"  class="form-control" value="{{ $company->company_email ?? ''}}"
                placeholder="Enter Email">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Phone  *</label>
            <input type="text" name="phone_no"  class="form-control" value="{{ $company->phone_no ?? ''}}"
                placeholder="Enter Phone">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">GST no  *</label>
            <input type="text" name="gstno"  class="form-control" value="{{ $company->gstno ?? ''}}"
                placeholder="Enter GST number">
        </div>
    </div>
</div>

   <div class="col-md-12 col-lg-12">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">ADD Bank Detail </h6>
                        </div>
                    </div>
                </div>
   </div>
    <div class="row row-sm">

    <div class="col-3">
    
        <div class="form-group">
            <label class="font-weight-600">Pan Card Number*</label>
            <input type="text" name="pancard_no"  class="form-control" value="{{ $company->pancard_no ?? ''}}"
                placeholder="Enter Pan Card Number">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Website *</label>
            <input type="text" name="website"  class="form-control" value="{{ $company->website ?? ''}}"
                placeholder="Enter Website">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Bank Name  *</label>
            <input type="text" name="bankname"  class="form-control" value="{{ $company->bankname ?? ''}}"
                placeholder="Enter Bank Name">
        </div>

    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Account Name *</label>
            <input type="text" name="accountname"  class="form-control" value="{{ $company->accountname ?? ''}}"
                placeholder="Enter Account Name">
        </div>
    </div>
   
</div>
<div class="row row-sm">

    <div class="col-3">
            <div class="form-group">
                <label class="font-weight-600"> Account Type *</label>
                <select class="form-control key" name="accounttype" id="key" value="{{ $company->accounttype ?? ''}}" id="exampleFormControlSelect1">
                    <option value="Fixced Account">Fixced Account</option>
                    <option value="Current Account">Current Account</option>
                </select>
            </div>
        </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Account Number *</label>
            <input type="text" name="accountnumber"  class="form-control" value="{{ $company->accountnumber ?? ''}}"
                placeholder="Enter Account Number">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">IFSC Code *</label>
            <input type="text" name="ifsc_code"  class="form-control" value="{{ $company->ifsc_code?? ''}}"
                placeholder="Enter IFSC Code">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Bank Branch Address*</label>
            <input type="text" name="bankbranchaddress"  class="form-control" value="{{ $company->bankbranchaddress?? ''}}"
                placeholder="Enter Bank Branch">
        </div>
    </div>
</div>






<div class="form-group">
                                <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
                                <a class="btn btn-secondary" href="{{ url('companydetail') }}">
                                    Back</a>

                            </div>
                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script><script src="{{ url('backEnd/ckeditor/ckeditor.js')}}"></script>

                            <script>
                                ClassicEditor
                                    .create( document.querySelector( '#editor' ), {
                                        // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
                                    } )
                                    .then( editor => {
                                        window.editor = editor;
                                    } )
                                    .catch( err => {
                                        console.error( err.stack );
                                    } );
                            </script>
                            <script>
                                ClassicEditor
                                    .create( document.querySelector( '#editor1' ), {
                                        // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
                                    } )
                                    .then( editor => {
                                        window.editor = editor;
                                    } )
                                    .catch( err => {
                                        console.error( err.stack );
                                    } );
                            </script>