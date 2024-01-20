<div class="row row-sm">
  <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Name *</label>
            <input type="text"  name="holidayname" value="{{ $holiday->holidayname ??''}}" class="form-control"
                placeholder="">   
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
        <label class="font-weight-600">Date *</label>
        <!-- <input type="date" name="startdate" class="form-control" value="01/01/2018 - 01/15/2018" />   -->
       <small class="font-weight-600">(Start Date)</small>
        <input type="date" name="startdate" class="form-control" value="{{ $holiday->startdate ??''}}" />          
        </div>
    </div>  
    <div class="col-3">
        <div class="form-group">
        <label class="font-weight-600">Date *</label>
        <!-- <input type="date" name="startdate" class="form-control" value="01/01/2018 - 01/15/2018" />   -->
        <small class="font-weight-600">(End Date)</small>
        <input type="date" name="enddate" class="form-control" value="{{ $holiday->enddate ??''}}" />          
        </div>
    </div>  
    <div class="col-3">
    <div class="form-group"><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input id="name" name="restricted" type="checkbox" {{ $holiday->restricted ??''}}>
        <label class="font-weight-300">Restricted</label>
        </div>
    </div>  
    <!-- <div class="col-3">
        <div class="form-group">
        <input type="text" name="qualification_other" id="qualification" plaaceholder="Highest Qualification" style='display:none; '/>   
        
        </div>
    </div>        -->
</div>
<div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
        <label class="font-weight-600">Description</label>
        <textarea type="text"  name="description" class="form-control"
                placeholder="">{{ $holiday->description ??''}}</textarea>  
        
        </div>
    </div>     
</div>

<!-- <div class="row row-sm">
  <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">No of day(s)before which the reminder should be send</label>
            
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
        <select class="form-control" name="sharewith" style="width:200px;">
                
                @if(Request::is('localconveyance/*/edit')) >
                @if($localconveyance->Recoverable=='Paid')
                <option value="Yes">Paid</option>
                <option value="No">Unpaid</option>
                

                @else
                <option value="No">Unpaid</option>
                <option value="Yes">Paid</option>
              
               

                @endif
                @else

                <option value="">Select</option>
                <option value="Yes">Paid</option>
                <option value="No">Unpaid</option>

                @endif
            </select><br>
            <input type="checkbox" id="html" name="fav_language" value="HTML">
  <label for="html">Notify Applicable Employees</label><br>
<input type="checkbox" id="html" name="fav_language" value="HTML">
  <label for="html">Reprocess leave applications based on this added holiday</label><br>
        </div>
    </div>
    </div> -->

    <!-- <div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
        <label class="font-weight-600">Description</label>
        <textarea type="text"  name="descripation" value="{{ $applyleave->descripation ??''}}" class="form-control"
                placeholder=""></textarea>  
        
        </div>
    </div>     
</div> -->
<div class="row row-sm">
  <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">No of day(s)before which the reminder should be send</label>
            
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
        <select class="form-control" name="number_of_dates" style="width:200px;">
                                @if(Request::is('holiday/*/edit')) >
                                @if($holiday->number_of_dates=='1')
                                  
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        @elseif($holiday->number_of_dates=='2')
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="1">1</option>
                                        @elseif($holiday->number_of_dates=='3')
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="2">2</option>
                                        <option value="5">5</option>
                                        <option value="1">1</option>
                                        @elseif($holiday->number_of_dates=='4')
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        @else
                                        <option value="5">5</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        @endif
                                       
                                        @else
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        
                                        @endif
            </select>
            
            <br>
 <input type="checkbox" id="name" name="notify" value="{{ $holiday->notify ??''}}">
  <label for="html">Notify Employees</label><br>
 </div>
    </div>
    </div>
<br>
    <p style="text-align:center; background-color:Gray; color:white;"><b>Note</b> : Shift based Holidays will override the location based Holidays.</p>
<br>

<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('holiday') }}">
        Cancel</a>

</div>

