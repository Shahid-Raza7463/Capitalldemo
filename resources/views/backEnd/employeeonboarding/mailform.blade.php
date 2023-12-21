<div class="row row-sm">
  <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Name *</label>
            <input type="text"  required name="name" value="{{ $employeeonboarding->your_full_name ??''}}" class="form-control"
            placeholder="Enter Name ">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Gender *</label>
           <select name="gender" class="form-control"  id="">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
           </select>
        </div>
    </div>
  
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Photograph *</label>
            <input type="file" required  name="photograph" value="{{ $employeeonboarding->photograph ??''}}" class="form-control"
            placeholder="Enter Contact Number of Candidate">
        </div>
    </div>
        
        
</div>
<div class="row row-sm">
<div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Designation *</label>
            <input type="text" required name="designation" value="{{ $employeeonboarding->designation ??''}}" class="form-control"
            placeholder="Enter Designation">
        </div>
    </div>
    
  <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Degree *</label>
           <select class="form-control" name="degree" id="">
            <option value="Bachelors Degree">Bachelors Degree</option>
            <option value="Masters Degree">Masters Degree</option>
            <option value="Others">Others</option>
           </select>       
        
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Stream *</label>
            <input type="text" required name="Stream" value="{{ $employeeonboarding->Relationship ??''}}" class="form-control"
            placeholder="Enter Stream">
        </div>
    </div>
    <div class="col-3">
    <div class="form-group">
            <label class="font-weight-600">Name of University *</label>
            <input type="text" id="university" required name="university" value="{{ $employeeonboarding->Email ??''}}" class="form-control"
                placeholder="Name of University ">
        </div>
        </div>
         
</div>
<div class="row row-sm">
<div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Location</label>
            <input type="text"  name="location"  value="{{ $employeeonboarding->Department ??''}}" class="form-control"
            placeholder="Enter Location">
        </div>
    </div>
  
  <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Total Experience in years *</label>
            <input type="number"  name="exp_year" required value="{{ $employeeonboarding->Department ??''}}" class="form-control"
            placeholder="Total Experience in years">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Experience in Month *</label>
            <input type="number" max="12" required name="exp_month" value="{{ $employeeonboarding->Designation ??''}}" class="form-control"
            placeholder="Total Experience in month">
        </div>
    </div>
    <div class="col-3">
    <div class="form-group">
            <label class="font-weight-600">Name of previous Organization * </label>
            <input type="text"  required name="pre_org" value="{{ $employeeonboarding->Comment ??''}}" class="form-control"
            placeholder="Enter Name of previous Organization ">
        </div>
        </div>
        
    </div>
    <div class="row row-sm">
<div class="col-3">
        <div class="form-group">
        <label class="font-weight-600">Designation in previous Organization *</label>
            <input type="text"  name="pre_des" value="{{ $employeeonboarding->Comment ??''}}" class="form-control"
            placeholder="Enter Designation">

        </div>
    </div>
  
  <div class="col-3">
        <div class="form-group">
        <label class="font-weight-600">Areas worked in * </label>
            <input type="text" required  name="work_area" value="{{ $employeeonboarding->Comment ??''}}" class="form-control"
            placeholder="Enter Areas worked in">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
        <label class="font-weight-600">Hobbies *</label>
            <input type="text" required name="hobbies" value="{{ $employeeonboarding->Comment ??''}}" class="form-control"
            placeholder="Enter Hobbies">
        </div>
    </div>
    <div class="col-3">
    <div class="form-group">
            <label class="font-weight-600">Official Email ID *</label>
            <input type="text" required name="off_email" value="{{ $employeeonboarding->Comment ??''}}" class="form-control"
            placeholder="Enter Official Email ID">
        </div>
        </div>
        
    </div>
           </div>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Save and Preview</button>
    <a class="btn btn-secondary" href="{{ url('employeeonboarding') }}">
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