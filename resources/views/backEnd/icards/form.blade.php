
<b style="font-weight: 800;font-size: 18px; "> Details</b>
<hr>
<div class="row row-sm">
  <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Name oF Father. *</label>
            <input type="text"   name="fathersname" value="{{ $articlefiles->fathersname ?? ''}}" class="form-control"
            placeholder="Enter Name oF Father">
        </div>
    </div>
  <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Name Of Mother. *</label>
            <input type="text"   name="mothersname" value="{{ $articlefiles->mothersname ?? ''}}" class="form-control"
            placeholder="Enter Name Of Mother">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Date Of Birth. *</label>
            <input type="date"   name="dob" value="{{ $articlefiles->dob ?? ''}}" class="form-control"
            placeholder="Enter Date Of Birth">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Date Of Joining. *</label>
            <input type="date"   name="doj" value="{{ $articlefiles->doj ?? ''}}" class="form-control"
            placeholder="Enter Date Of Joining">
        </div>
    </div>
 
       
   
         
</div>
<div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Contact Of Father. *</label>
            <input type="number"   name="emergencycontactnumber" value="{{ $articlefiles->emergencycontactnumber ?? ''}}" class="form-control"
                placeholder="Enter Contact Of Father  ">
        </div>
        </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Contact Of Mother. *</label>
            <input type="number"   name="emergencycontactnumbertwo" value="{{ $articlefiles->emergencycontactnumbertwo ?? ''}}" class="form-control"
                placeholder="Enter Contact Of Mother ">
        </div>
    </div>
</div>
<br>
<b style="font-weight: 800;font-size: 18px; "> Documents</b>
<hr>
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Mark Sheet Of 10th. *</label>
            <input type="file"   name="document10th" value="{{ $articlefiles->document10th ?? ''}}" class="form-control"
                placeholder="Enter Financial Year .">
        </div>
        </div>
  <div class="col-4">
    <div class="form-group">
        <label class="font-weight-600">Mark Sheet Of 12th. *</label>
        <input type="file"   name="document12th" value="{{ $articlefiles->document12th ?? ''}}" class="form-control"
            placeholder="Enter Financial Year .">
    </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Marksheet / Degree Of B. Com. * </label>
            <select name="documentbcom"  id="documentbcom" class="form-control">
                <!--placeholder-->
                @if(Request::is('articlefiles/*/edit')) >
                @if($articlefiles->documentbcom=='0')
                <option value="0">Regular</option>
                <option value="1">Distance</option>
                <option value="2">Not Pursuing</option>

                @elseif($articlefiles->documentbcom=='1')
                <option value="1">Distance</option>
                <option value="0">Regular</option>
             <option value="2">Not Pursuing</option>

                @else
                <option value="2">Not Pursuing</option>
                <option value="1">Distance</option>
                <option value="0">Regular</option>
            
               

                @endif
                @else

                <option value="">Please Select One</option>
                <option value="0">Regular</option>
                <option value="1">Distance</option>
                <option value="2">Not Pursuing</option>
                @endif
            </select>
        </div>
    </div>
   
       
</div>
<div class="row row-sm" >
    <div class="col-4" id="bcomcertificate" style="display: none">
      <div class="form-group">
          <label class="font-weight-600">Mark Sheet </label>
          <input type="file"  name="bcomcertificate" value="{{ $articlefiles->ipcccertificate ?? ''}}" class="form-control"
              placeholder="Enter Financial Year .">
      </div>
      </div>
    <div class="col-4" id="noc" style="display: none">
      <div class="form-group">
          <label class="font-weight-600">NOC </label>
          <input type="file"  name="noc" value="{{ $articlefiles->ipcccertificate ?? ''}}" class="form-control"
              placeholder="Enter Financial Year .">
      </div>
      </div>
</div>
<div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">CPT Marksheet. * </label>
            <input type="file"   name="cptcertificate" value="{{ $articlefiles->cptcertificate ?? ''}}" class="form-control"
                placeholder="Enter Financial Year .">
        </div>
        </div>
    <div class="col-3">
      <div class="form-group">
          <label class="font-weight-600">IPCC Group 1 Marksheet. *</label>
          <input type="file"  name="ipcccertificate" value="{{ $articlefiles->ipcccertificate ?? ''}}" class="form-control"
              placeholder="Enter Financial Year .">
      </div>
      </div>
    <div class="col-3">
      <div class="form-group">
          <label class="font-weight-600">IPCC Group 2 Marksheet. *</label>
          <input type="file"  name="ipcccertificatetwo" value="{{ $articlefiles->ipcccertificate ?? ''}}" class="form-control"
              placeholder="Enter Financial Year .">
      </div>
      </div>
      <div class="col-3">
          <div class="form-group">
              <label class="font-weight-600">OC Training certificate. * </label>
              <input type="file"  name="octrainingcertificate" value="{{ $articlefiles->octrainingcertificate ?? ''}}" class="form-control"
                  placeholder="Enter Financial Year .">
          </div>
      </div>
     
         
  </div>
  <div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">ITT Training Certificate. * </label>
            <input type="file"  name="itttrainingcertificate" value="{{ $articlefiles->itttrainingcertificate ?? ''}}" class="form-control"
                placeholder="Enter Period of Appointment .">
        </div>
        </div>
      <div class="col-3">
          <div class="form-group">
              <label class="font-weight-600">Residence Proof 1. *</label>
              <input type="file"   name="residenceproof" value="{{ $articlefiles->residenceproof ?? ''}}" class="form-control"
                  placeholder="Enter Period of Appointment .">
          </div>
          </div>
      <div class="col-3">
          <div class="form-group">
              <label class="font-weight-600">Residence Proof 2. *</label>
              <input type="file"  name="residenceprooftwo" value="{{ $articlefiles->residenceprooftwo ?? ''}}" class="form-control"
                  placeholder="Enter Period of Appointment .">
          </div>
          </div>
          <div class="col-3">
            <div class="form-group">
                <label class="font-weight-600">Pan Card. * </label>
                <input type="file"  name="pancard" value="{{ $articlefiles->pancard ?? ''}}" class="form-control"
                    placeholder="Enter Financial Year .">
            </div>
            </div>
           
  </div>
  <div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Photograph. * </label>
            <input type="file"  name="photograph" value="{{ $articlefiles->photograph ?? ''}}" class="form-control"
                placeholder="Enter Financial Year .">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Copy of 102 Form. * </label>
            <input type="file"  name="copyof" value="{{ $articlefiles->copyof ?? ''}}" class="form-control"
                placeholder="Enter Branch .">
        </div>
    </div>
	  <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Copy of 103 Form. * </label>
            <input type="file"  name="copyoftwo" value="{{ $articlefiles->copyof ?? ''}}" class="form-control"
                placeholder="Enter Branch .">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Additional Qualification Certificate / If Any </label>
            <input type="file"  name="additional" value="{{ $articlefiles->photograph ?? ''}}" class="form-control"
                placeholder="Enter Financial Year .">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Agreement</label>
            <input type="file"  name="agreement" value="{{ $articlefiles->photograph ?? ''}}" class="form-control"
                placeholder="Enter Financial Year .">
        </div>
    </div>
  </div>
  <br>
<b style="font-weight: 800;font-size: 18px; "> Bank Account Details</b>
<hr>
  <div class="row row-sm">
   
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Bank Account Holder Name </label>
            <input type="text"   name="accountholder" value="{{ $articlefiles->accountholder ?? ''}}" class="form-control"
                placeholder="Enter Bank Account Holder Name  .">
        </div>
        </div>
      <div class="col-4">
          <div class="form-group">
              <label class="font-weight-600">Bank Account Name </label>
              <input type="text"   name="accountname" value="{{ $articlefiles->accountname ?? ''}}" class="form-control"
                  placeholder="Enter Bank Account Name .">
          </div>
          </div>
      <div class="col-4">
          <div class="form-group">
              <label class="font-weight-600">Bank Account Number</label>
              <input type="text"   name="accountnumber" value="{{ $articlefiles->accountnumber ?? ''}}" class="form-control"
                  placeholder="Enter Bank Account Number .">
          </div>
          </div>
          <div class="col-4">
            <div class="form-group">
                <label class="font-weight-600">IFSC Code </label>
                <input type="text"   name="ifsccode" value="{{ $articlefiles->ifsccode ?? ''}}" class="form-control"
                    placeholder="Enter IFSC Code .">
            </div>
            </div>
            
      <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Branch Name</label>
            <input type="text"   name="branch" value="{{ $articlefiles->branch ?? ''}}" class="form-control"
                placeholder="Enter Branch .">
        </div>
    </div>
  </div>

<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('articlefiles') }}">
        Back</a>

</div>
