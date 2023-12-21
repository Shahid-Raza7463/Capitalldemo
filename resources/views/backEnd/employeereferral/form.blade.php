<div class="row row-sm">
  <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Name of Candidate. *</label>
            <input type="text"  required name="Name" value="{{ $employeereferral->Name ??''}}" class="form-control"
            placeholder="Enter Name of Candidate">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Contact Number of Candidate. *</label>
            <input type="number" required name="Contact" value="{{ $employeereferral->Contact ??''}}" class="form-control"
            placeholder="Enter Contact Number of Candidate">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Position Referred For. *</label>
            <select required name="Position_Referred" id="Position_Referred" class="form-control">
            <!--placeholder-->
            @if(Request::is('employeereferral/*/edit')) >
            @if($employeereferral->Position_Referred=='Chartered Accountant')
            <option value="Chartered Accountant">Chartered Accountant</option>
            <option value="Semi Qualified Chartered Accountant">Semi Qualified Chartered Accountant</option>
            <option value="Articled Trainee">Articled Trainee</option>
            <option value="Consultant">Consultant</option>
            <option value="Intern">Intern</option>
            <option value="Other">Other </option>
			
            @elseif($employeereferral->Position_Referred=='Semi Qualified Chartered Accountant')
            <option value="Semi Qualified Chartered Accountant">Semi Qualified Chartered Accountant</option>
            <option value="Chartered Accountant">Chartered Accountant</option>
           
            <option value="Articled Trainee">Articled Trainee</option>
            <option value="Consultant">Consultant</option>
            <option value="Intern">Intern</option>
            <option value="Other">Other </option>
			
            @elseif($employeereferral->Position_Referred=='Articled Trainee')
            <option value="Articled Trainee">Articled Trainee</option>
            <option value="Semi Qualified Chartered Accountant">Semi Qualified Chartered Accountant</option>
            <option value="Chartered Accountant">Chartered Accountant</option>
           
            
            <option value="Consultant">Consultant</option>
            <option value="Intern">Intern</option>
            <option value="Other">Other </option>
			
            @elseif($employeereferral->Position_Referred=='Consultant')
            <option value="Consultant">Consultant</option>
            <option value="Articled Trainee">Articled Trainee</option>
            <option value="Semi Qualified Chartered Accountant">Semi Qualified Chartered Accountant</option>
            <option value="Chartered Accountant">Chartered Accountant</option>
           
            
            
            <option value="Intern">Intern</option>
            <option value="Other">Other </option>

			@elseif($employeereferral->Position_Referred=='Intern')
            <option value="Intern">Intern</option>
            <option value="Consultant">Consultant</option>
            <option value="Articled Trainee">Articled Trainee</option>
            <option value="Semi Qualified Chartered Accountant">Semi Qualified Chartered Accountant</option>
            <option value="Chartered Accountant">Chartered Accountant</option>
           
            
            
            
            <option value="Other">Other </option>
			
            @else
            <option value="Other">Other </option>
            <option value="Intern">Intern</option>
            <option value="Consultant">Consultant</option>
            <option value="Articled Trainee">Articled Trainee</option>
            <option value="Semi Qualified Chartered Accountant">Semi Qualified Chartered Accountant</option>
            <option value="Chartered Accountant">Chartered Accountant</option>
           
            
            
            
            
			
            @endif
            @else
            <option value="Chartered Accountant">Chartered Accountant</option>
            <option value="Semi Qualified Chartered Accountant">Semi Qualified Chartered Accountant</option>
            <option value="Articled Trainee">Articled Trainee</option>
            <option value="Consultant">Consultant</option>
            <option value="Intern">Intern</option>
            <option value="Other">Other </option>
			
            @endif
        </select>
        </div>
        </div>
        <div class="col-4" id='other'  style="display: none;" >
    <div class="form-group">
        <label class="font-weight-600">Other Position*</label>
    
            <input type="text" name="other" id="others" class="form-control" value="{{ $employeereferral->other ??'' }}"
            placeholder="Enter Other Position">
    </div>
</div>
</div>
<div class="row row-sm">
  <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Current Organization.</label>
            <input type="text"  name="Current_Organization" value="{{ $employeereferral->Current_Organization ??''}}" class="form-control"
            placeholder="Enter Current Organization">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Relationship with Candidate. *</label>
            <input type="text" required name="Relationship" value="{{ $employeereferral->Relationship ??''}}" class="form-control"
            placeholder="Enter Relationship with Candidate">
        </div>
    </div>
    <div class="col-4">
    <div class="form-group">
            <label class="font-weight-600">Email Address of Candidate. *</label>
            <input type="email" id="reimbursementclaim-img" required name="Email" value="{{ $employeereferral->Email ??''}}" class="form-control"
                placeholder="Enter Email">
        </div>
        </div>
         
</div>
<div class="row row-sm">
  <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Department Referred For (If any). *</label>
            <input type="text"  name="Department" required value="{{ $employeereferral->Department ??''}}" class="form-control"
            placeholder="Enter Department Referred">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Current Designation. *</label>
            <input type="text"  required name="Designation" value="{{ $employeereferral->Designation ??''}}" class="form-control"
            placeholder="Enter Current Designation">
        </div>
    </div>
    <div class="col-3">
    <div class="form-group">
            <label class="font-weight-600">Comment ( If Any). </label>
            <input type="text"  name="Comment" value="{{ $employeereferral->Comment ??''}}" class="form-control"
            placeholder="Enter Comment">
        </div>
        </div>
           <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Attach Resume. *</label>
            <input type="file" @if(Request::is('employeereferral/create')) required @endif name="attachresume" class="form-control"
                placeholder="Enter Position Referred.">
        </div>
        </div>
</div>
@if(Auth::user()->role_id == 18 )
<div class="form-group">
   <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Feedback. *</label>
            <input type="text" required name="feedback" class="form-control"
                placeholder="Enter Feedback">
        </div>
        </div>
</div>
@endif
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('employeereferral') }}">
        Back</a>

</div>
	<script>
        $(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});
        </script>