
<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Employee Name</label>
            <input type="text" readonly value="{{ $authname->team_member }}" placeholder="Enter Employee Name" 
                class="form-control">
        </div>
    </div>
  <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Your Role *</label>
          <select name="relation" required class="form-control">
                              
                                            <option value="">Please Select One</option>
                                            <option value="Partner">Partner</option>
                                            <option value="Manager">Manager</option>
                                            
                                        </select>
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Son/Daughter/Spouse of *</label>
            <input type="text" name="relative_name" placeholder="Enter Name" 
                class="form-control">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Are You Holding Any Directorship *</label>
            <select name="din" id="din" required class="form-control">
                              
                                            <option value="">Please Select One</option>
                                            <option value="Yes">If Yes</option>
                                            <option value="No">No</option>
                                            
                                        </select>
        </div>
    </div>
	<div class="col-4" id='dinno' style="display: none;">
    <div class="form-group">
        <label class="font-weight-600">Din No *</label>
        <input type="text" name="dinno" class="form-control"
            placeholder="Enter Din No">
    </div>
</div>
	  <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Place *</label>
            <input type="text" name="place" placeholder="Enter Delhi/Mumbai" value=""
                class="form-control">
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Resident</label>
            <textarea type="text" name="resident" placeholder="Enter Resident" value="" class="form-control"></textarea>
        </div>
    </div>
</div>
<br>

    <div class="row row-sm ">
    <div class="col-12">
        <table class="table table-bordered">
            <tr style="background: #37A000;color:#F4F4F5;">
               <th>Sr.No</th>    
                <th>Names of the Companies/ Bodies Corporate/ Firms / Society/ Trust /Co-operative Society / Association of Individuals</th>
                <th>Nature of interest or concern/ change in interest or concern (i.e., Director / Partner / Trustee / Office Bearer etc.)</th>
                <th>Shareholding, if any</th>
                <th>Date on which interest or concern arose/changed</th>
                <th> <button type="button" name="add_row" id="add_row"><i class="fe fe-plus"></i><img
                        src="{{ url('backEnd/image/add-icon.png')}}" /></button></th>
            </tr>
            <tbody id="declaration">
                <td><span id="sr_no">1</span></td>
                <td><input type="text" value="" name="company_name[]" data-srno="1" placeholder="Enter Names of the Companies" class="form-control" /></td>
                <td><input type="text" value="" name="interest[]" data-srno="1" placeholder="Enter Nature of interest or concern" class="form-control" />
                </td>
                <td><input type="text" value="" name="shareholding[]" data-srno="1" placeholder="Enter Shareholding" class="form-control" />
                </td>
                <td><input type="date" value="" name="date[]" data-srno="1" placeholder="Enter Date" class="form-control" />
                </td>
               <td><button type="button" name="remove_row" id="'+count+'" class="btn btn-danger btn-xs remove_row">X</button></td>
        </tbody>
        </table>
    </div>
</div>
<div class="form-group row">
 <div class="col-sm-12">
			   <br>
			
	  <p><strong style="color:rgb(0,31,95)">Note:</strong></p><br>
                                 <p><strong style="margin-left:40px;color:rgb(0,31,95)">1. Family here means Grand Parents, Father, Mother, Spouse, Son, Daughter, Brother, Sister</strong></p>
	   <p><strong style="margin-left:40px;color:rgb(0,31,95)">2. Form is to be submitted to the Nodal Partner looking after HR Department</strong></p>
	    <p><strong style="margin-left:40px;color:green"> The form will be E-Verified by you after Submission.</strong></p>
                                      
		 </div>	
</div>
<br>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right">Submit</button>
    <a class="btn btn-secondary" href="{{ url('declarationform') }}">Back</a>

</div>