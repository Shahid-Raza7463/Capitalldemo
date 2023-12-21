<div class="row row-sm">
  <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Name *</label>
            <input type="text"  name="name" value="{{ $leavetype->name ??''}}" class="form-control"
                placeholder="">       
          
        </div>
    </div> 
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Code</label>
            <input type="text"  name="code" value="{{ $leavetype->code ??''}}" class="form-control"
                placeholder="">  
        </div>
    </div>  
</div>
<br>
<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Type *</label>
            <select class="form-control" name="type" value="{{ $leavetype->type ??''}}">
                
                @if(Request::is('leavetype/*/edit')) >
                @if($leavetype->type=='Paid')
                <option value="Paid">Paid</option>
                <option value="Unpaid">Unpaid</option>
                

                @else
                <option value="Unpaid">Unpaid</option>
                <option value="Paid">Paid</option>
              
               

                @endif
                @else

                <option value="">Please Select One</option>
                <option value="Paid">Paid</option>
                <option value="Unpaid">Unpaid</option>

                @endif
            </select>
        </div>
    </div>
    <div class="col-6">
    <div class="form-group">
            <label class="font-weight-600">Unit *</label>
            <select class="form-control" name="unit">
                
                @if(Request::is('leavetype/*/edit')) >
                @if($leavetype->unit=='Yes')
                <option value="Days">Days</option>
                <option value="Hours">Hours</option>
                

                @else
                <option value="Hours">Hours</option>
                <option value="Days">Days</option>
                
              
               

                @endif
                @else

                <option value="Days">Days</option>
                <option value="Hours">Hours</option>

                @endif
            </select>
        </div>
        </div>        
</div>
<br>
<div class="row row-sm">
  <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Balance based on *</label>
           
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
        <input type="radio" id="html" name="Fixed" value="Fixed entitlement">
  <label for="html">Fixed entitlement</label><br>
        
        </div>
    </div>     
    <div class="col-4">
        <div class="form-group">
        <input type="radio" id="html" name="Leavegrant" value="Leave grant">
  <label for="html">Leave grant</label><br>
        
        </div>
    </div>     
</div>
<br>
<div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
        <label class="font-weight-600">Description</label>
        <textarea type="text"  name="description" class="form-control"
                placeholder="">{{ $leavetype->description ??''}}</textarea>  
        
        </div>
    </div>     
</div>
<br>
<div class="row row-sm">
  <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Validity </label><br>
            <small class="font-weight-600">Start Date </small>
            <input type="date"  name="startdate" value="{{ $leavetype->startdate ??''}}" class="form-control"
                placeholder="">
               
        </div>
    </div>
    <div class="col-6">
        <div class="form-group"><br>
        <label class="font-weight-600"></label><br>
            <small class="font-weight-600">End Date </small>
        <input type="date"  name="enddate" value="{{ $leavetype->enddate ??''}}" class="form-control"
                placeholder="">  
        
        </div>
    </div>     
</div>
<br>
<div class="card-body">
                                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Entitlement</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Applicable</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Restrictions</a>
                                            </li>
                                        </ul>
    <div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
   <hr>
    <div class="row row-sm">
  <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Effective After</label>
           
        </div>
    </div>
    <div class="col-1">
        <div class="form-group">
        <input type="number" name="effective" value="{{ $leavetype->effective ??''}}" class="form-control" style="height:35px;"
                placeholder=""> 
   </div>
    </div>     
    <div class="col-3">
        <div class="form-group">
        <select class="form-control" name="effective1" style="height:35px;">
                
                @if(Request::is('leavetype/*/edit')) >
                @if($leavetype->effective1=='Year(s)')
                <option value="Year(s)">Year(s)</option>
                <option value="Month(s)">Month(s)</option>
                <option value="Day(s)">Day(s)</option>
               
                @elseif($leavetype->effective1=='Day(s)')
                <option value="Day(s)">Day(s)</option>
                <option value="Year(s)">Year(s)</option>
                <option value="Month(s)">Month(s)</option>
              
                

                @else
                <option value="Month(s)">Month(s)</option>
                <option value="Year(s)">Year(s)</option>
                <option value="Day(s)">Day(s)</option>
              
               

                @endif
                @else

                <option value="Day(s)">Day(s)</option>
                <option value="Year(s)">Year(s)</option>
                <option value="Month(s)">Month(s)</option>

                @endif
            </select>
        </div>
    </div>
    <div class="col-1">
        <div class="form-group">
        <label class="font-weight-600">From</label>
        
   </div>
    </div>   
    <div class="col-3">
        <div class="form-group">
       
        <select class="form-control" name="effective2" style="height:35px;">
                
                @if(Request::is('leavetype/*/edit')) >
                @if($leavetype->effective2=='Yes')
                <option value="Date Of Joining">Date Of Joining</option>
                <option value="Date Of Confirmation">Date Of Confirmation</option>
                

                @else
                <option value="Date Of Confirmation">Date Of Confirmation</option>
                <option value="Date Of Joining">Date Of Joining</option>
             
              
               

                @endif
                @else

                <option value="Date Of Joining">Date Of Joining</option>
                <option value="Date Of Confirmation">Date Of Confirmation</option>

                @endif
            </select>
        </div>
    </div>          
</div>                                           
<div class="row row-sm">
    <div class="col-2">
        <div class="form-group">
        <input type="checkbox" id="html" name="Accrual" value="HTML">
  <label for="html">Accrual</label><br>
        </div>
    </div>     
    <div class="col-2">
        <div class="form-group">
            <select  class="language form-control" id="exampleFormControlSelect1" name="leavetypemonth"
            @if(Request::is('leavetype/*/edit'))> <option disabled style="display:block">Please Select One</option>

            @foreach($leavetypemonth as $leavetypemonthData)
            <option value="{{$leavetypemonthData->id}}"
                {{$leavetype->leavetypemonth == $leavetypemonthData->id??'' ?'selected="selected"' : ''}}>
                {{$leavetypemonthData->name }}</option>
            @endforeach


            @else
            <option></option>
            <option value="">Please Select One</option>
            @foreach($leavetypemonth as $leavetypemonthData)
            <option value="{{$leavetypemonthData->id}}">
                {{ $leavetypemonthData->name }}  </option>

            @endforeach
            @endif
        </select>    
        </div>
    </div>
    <div class="col-0">
        <div class="form-group">
        <label class="font-weight-600">on</label>       
   </div>
    </div>   
    <div class="col-1">
        <div class="form-group">
       
            <select  class="language form-control" id="exampleFormControlSelect1" name="leavetypedays"
            @if(Request::is('leavetype/*/edit'))> <option disabled style="display:block">Please Select One</option>

            @foreach($leavetypedays as $leavetypedaysData)
            <option value="{{$leavetypedaysData->id}}"
                {{$leavetype->leavetypedays == $leavetypedaysData->id??'' ?'selected="selected"' : ''}}>
                {{$leavetypedaysData->name }}</option>
            @endforeach


            @else
            <option></option>
            <option value="">Please Select One</option>
            @foreach($leavetypedays as $leavetypedaysData)
            <option value="{{$leavetypedaysData->id}}">
                {{ $leavetypedaysData->name }}  </option>

            @endforeach
            @endif
        </select>    
        </div>
    </div>     
    <div class="col-2">
        <div class="form-group">
       
            <select  class="language form-control" id="exampleFormControlSelect1" name="leavetypemonthly"
            @if(Request::is('leavetype/*/edit'))> <option disabled style="display:block">Please Select One</option>

            @foreach($leavetypemonthly as $eavetypemonthlyData)
            <option value="{{$eavetypemonthlyData->id}}"
                {{$leavetype->leavetypemonthly == $eavetypemonthlyData->id??'' ?'selected="selected"' : ''}}>
                {{$eavetypemonthlyData->name }}</option>
            @endforeach


            @else
            <option></option>
            <option value="">Please Select One</option>
            @foreach($leavetypemonthly as $eavetypemonthlyData)
            <option value="{{$eavetypemonthlyData->id}}">
                {{ $eavetypemonthlyData->name }}  </option>

            @endforeach
            @endif
        </select>    
        </div>
    </div>     
    <div class="col-0">
        <div class="form-group">
        <label class="font-weight-600">No. of Days</label>       
   </div>
</div>  
<div class="col-0">
        <div class="form-group">
        <input type="text"  name="noofdays" value="{{ $leavetype->noofdays ??''}}" class="form-control" style=" width:75px; height:35px;"
                placeholder=""> 
   </div>
    </div>
    <div class="col-0">
        <div class="form-group">
        <label class="font-weight-600">in</label>       
   </div>
    </div> 
    <div class="col-2">
        <div class="form-group">
       
        <select class="form-control" name="Accrualtype" style="height:35px;">
                
                @if(Request::is('localconveyance/*/edit')) >
                @if($localconveyance->Recoverable=='Yes')
                <option value="Current Accrual">Current Accrual</option>
                <option value="Next Accrual">Next Accrual</option>
                @else
                <option value="Next Accrual">Next Accrual</option>
                <option value="Current Accrual">Current Accrual</option>
                @endif
                @else
                <option value="Current Accrual">Current Accrual</option>
                <option value="Next Accrual">Next Accrual</option>

                @endif
            </select>
        </div>
    </div>     
    </div>
{{-- <div class="row row-sm">
  <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600"></label>
           
        </div>
    </div>
        
    <div class="col-2">
        <div class="form-group">
        <select class="form-control" name="" style=" width:145px; height:35px;">
                
                @if(Request::is('localconveyance/*/edit')) >
                @if($localconveyance->Recoverable=='Yes')
                <option value="Yes">Yes</option>
                <option value="No">No</option>
                

                @else
                <option value="No">No</option>
                <option value="Yes">Yes</option>
              
               

                @endif
                @else

                <option value="">Please Select One</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>

                @endif
            </select>
        </div>
    </div>
    <div class="col-1">
        <div class="form-group">
        <input type="text"  name="" value="" class="form-control" style=" width:70px; height:35px;"
                placeholder=""> 
   </div>
    </div>
    <div class="col-2">
        <div class="form-group">
        <select class="form-control" name="" style=" width:120px; height:35px;">
                
                @if(Request::is('localconveyance/*/edit')) >
                @if($localconveyance->Recoverable=='Yes')
                <option value="Yes">Yes</option>
                <option value="No">No</option>
                

                @else
                <option value="No">No</option>
                <option value="Yes">Yes</option>
              
               

                @endif
                @else

                <option value="">Please Select One</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>

                @endif
            </select>
        </div>
    </div>
    <div class="col-1">
        <div class="form-group">
        <label class="font-weight-600">Max Limit</label>
        
   </div>
    </div>   
    <div class="col-1">
        <div class="form-group">
        <input type="text"  name="" value="" class="form-control" style=" width:50px; height:35px;"
                placeholder=""> 
   </div>
    </div>
</div>        
<div class="row row-sm">
  <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600"></label>
           
        </div>
    </div>
        
    <div class="col-2">
        <div class="form-group">
        <label class="font-weight-600">Encashment</label>
        </div>
    </div>
    <div class="col-1">
        <div class="form-group">
        <input type="text"  name="" value="" class="form-control" style=" width:70px; height:35px;"
                placeholder=""> 
   </div>
    </div>
    <div class="col-2">
        <div class="form-group">
        <select class="form-control" name="" style=" width:120px; height:35px;">
                
                @if(Request::is('localconveyance/*/edit')) >
                @if($localconveyance->Recoverable=='Yes')
                <option value="Yes">Yes</option>
                <option value="No">No</option>
                

                @else
                <option value="No">No</option>
                <option value="Yes">Yes</option>
              
               

                @endif
                @else

                <option value="">Please Select One</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>

                @endif
            </select>
        </div>
    </div>
    <div class="col-1">
        <div class="form-group">
        <label class="font-weight-600">Max Limit</label>
        
   </div>
    </div>   
    <div class="col-1">
        <div class="form-group">
        <input type="text"  name="" value="" class="form-control" style=" width:50px; height:35px;"
                placeholder=""> 
   </div>
    </div>
</div>                                        --}}

    </div>
  <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
  <hr>
  <div class="card-body" style="padding:0px;">
                                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="pills-applicable-tab" data-toggle="pill" href="#pills-applicable" role="tab" aria-controls="pills-applicable" aria-selected="true">Applicable</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="pills-exceptions-tab" data-toggle="pill" href="#pills-exceptions" role="tab" aria-controls="pills-exceptions" aria-selected="false">Exceptions</a>
                                            </li>
                                        </ul>
                          <div class="tab-content" id="pills-tabContent">
                       <div class="tab-pane fade show active" id="pills-applicable" role="tabpanel" aria-labelledby="pills-applicable-tab">
 <hr>
 <div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
  <label for="html">Gender</label>
        </div>
    </div>     
    <div class="col-3">
        <div class="form-group">
         <input type="checkbox" id="html" name="gender" value="Male">
  <label for="html">Male</label>
        
        </div>
    </div> 
    <div class="col-3">
        <div class="form-group">
         <input type="checkbox" id="html" name="gender" value="Femal">
  <label for="html">Femal</label>
        
        </div>
    </div> 
    <div class="col-3">
        <div class="form-group">
         <input type="checkbox" id="html" name="gender" value="Others">
  <label for="html">Others</label>
        
        </div>
    </div> 
    </div>     
    <div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
  <label for="html">Marital Status</label>
        </div>
    </div>     
    <div class="col-3">
        <div class="form-group">
         <input type="checkbox" id="html" name="martialstatus" value="Single">
  <label for="html">Single</label>
        
        </div>
    </div> 
    <div class="col-3">
        <div class="form-group">
         <input type="checkbox" id="html" name="martialstatus" value="Married">
  <label for="html">Married</label>
        
        </div>
    </div> 
    </div>    
   
    <div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
  <label for="html">Role</label>
        </div>
    </div>     
    <div class="col-6">
        <div class="form-group">
      
            <select class="form-control basic-multiple"  multiple="multiple" name="role" @if(Request::is('leavetype/*/edit'))> <option disabled
            style="display:block">Please Select One</option>

            @foreach($teamrole as $teamroleData)
            <option value="{{$teamroleData->id}}"
                @foreach($leavetyperole as $leavetyperoles){{$leavetyperoles->role == $teamroleData->id ? 'selected': ''}}   @endforeach
                >
                {{$teamroleData->rolename }}</option>
            @endforeach


            @else
            <option></option>
            <option value="">Please Select One</option>
            @foreach($teamrole as $teamroleData)
            <option value="{{$teamroleData->id}}">
                {{ $teamroleData->rolename }}</option>

            @endforeach
            @endif
        </select>
        </div>
    </div> 
    </div>  
                                                            
                                        </div>
                                        </div>
                                    </div>                                            
    </div>
  <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab"> 
    <hr>   
    <div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
        <p class="font-weight-600">Weekends Between Leave Period :</p>
        <input type="radio" id="html" name="" value="HTML">
         <label for="html">Count as leave : Count after</label> 
       <input type="number" name="" value="" style="width:50px; height:25px;">
       <label for="html">days</label> <br>
       <input type="radio" id="html" name="" value="HTML">
         <label for="html">Don't count as leave</label>
        </div>
    </div>     
    <div class="col-6">
    <div class="form-group">
        <p class="font-weight-600">Holidays Between Leave Period :</p>
        <input type="radio" id="html" name="" value="HTML">
         <label for="html">Count as leave : Count after</label>
       <input type="number" name="" value="" style="width:50px; height:25px;">
       <label for="html">days</label> <br>
       <input type="radio" id="html" name="" value="HTML">
         <label for="html">Don't count as leave</label>
        </div>
    </div>         
</div>  
<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
        <p class="font-weight-600">WhileApplying Leave,Exceed Leave Balance :</p>
        <input type="radio" id="html" name="" value="HTML">
         <label for="html">Allow</label> <br>
       <input type="radio" id="html" name="" value="HTML">
         <label for="html">Don't Allow</label><br>
       <input type="radio" id="html" name="" value="HTML">
         <label for="html">Without limit</label><br>
       <input type="radio" id="html" name="" value="HTML">
         <label for="html">Until year end limit</label><br>
       <input type="radio" id="html" name="" value="HTML">
         <label for="html">Without limit and mark as LOP</label>
        </div>
    </div>     
    <div class="col-6">
        <div class="form-group">
        <p class="font-weight-600">Duration(s)Allowed :</p>
        <input type="checkbox" id="html" name="" value="HTML">
         <label for="html">Full Day</label> <br>
       <input type="checkbox" id="html" name="" value="HTML">
         <label for="html">Half Day</label><br>
       <input type="checkbox" id="html" name="" value="HTML">
         <label for="html">Qurter Day</label><br>
       <input type="checkbox" id="html" name="" value="HTML">
         <label for="html">Hourly</label><br>
        </div>
    </div>     
 </div>
 
 <p class="font-weight-600">Allow Requests For :</p>
 <div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
        <input type="checkbox" id="html" name="allow_past_days" value="{{ $leavetype->allow_past_days ??''}}">
         <label class="font-weight-600">Past dates</label> <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       <input type="checkbox" id="html" name="allow_past_days" value="{{ $leavetype->allow_past_days ??''}}">
         <label for="html">Past</label>
       <input type="number" id="html" name="allow_past_days" value="{{ $leavetype->allow_past_days ??''}}" style="width:50px; height:25px;">
       <label for="html">days</label> <br>
     </div>
    </div>     
    <div class="col-6">
        <div class="form-group">
       <input type="checkbox" id="html" name="allowfuture_date" value="{{ $leavetype->allowfuture_date ??''}}">
         <label class="font-weight-600">Future dates</label><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       <input type="checkbox" id="html" name="allowfuture_date" value="{{ $leavetype->allowfuture_date ??''}}">
         <label for="html">Next</label>
       <input type="number" id="html" name="allowfuture_date" value="{{ $leavetype->allowfuture_date ??''}}" style="width:50px; height:25px;">
       <label for="html">days</label> <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       <input type="checkbox" id="html" name="allowfuture_date" value="{{ $leavetype->allowfuture_date ??''}}">
         <label for="html">To be applied</label>
       <input type="number" id="html" name="allowfuture_date" value="{{ $leavetype->allowfuture_date ??''}}" style="width:50px; height:25px;">
       <label for="html">days in advance</label> <br>
        </div>
    </div>      
 </div>
 
 <div class="row row-sm">
    <div class="col-8">
        <div class="form-group">
       <input type="checkbox" id="html" name="" value="">
         <label for="html">Enable file upload option if the applled leave period exceeds</label>
       <input type="text" name="" value="" style="width:50px; height:25px;">
       <label for="html">days</label> 
    </div>
    </div>     
 </div>
 <div class="row row-sm">
  <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Maximum number of applications allowed within the specified period</label>
           
        </div>
    </div>
    <div class="col-1">
        <div class="form-group">
        <input type="text"  name="notificationdate" value="{{ $leavetype->notificationdate ??''}}" class="form-control"
                placeholder="" style="width:50px; height:30px;"> 
   </div>
    </div>  
      
    <div class="col-1">
        <div class="form-group">
        <select class="form-control" name="notificationdate1" style="width:120px; height:35px;">
                
                @if(Request::is('leavetype/*/edit')) >
                @if($leavetype->notificationdate1=='Week')
                <option value="Week">Week</option>
                <option value="Days">Days</option>
                

                @else
                <option value="Days">Days</option>
                <option value="Week">Week</option>
              
               

                @endif
                @else
                <option value="Week">Week</option>
                <option value="Days">Days</option>

                @endif
            </select>
        </div>
    </div>
</div>
 <!-- <div class="row row-sm">
 <div class="col-6">
        <div class="form-group">
        <label class="font-weight-600">This leave can be applied only on</label>   
    </div>
    </div>
 <div class="col-6">
        <div class="form-group">
       <input type="text" id="html" name="fav_language" value="" class="form-control" style="height:35px;">
       
    </div>
    </div>   
 </div>
 <div class="row row-sm">
 <div class="col-6">
        <div class="form-group">
        <label class="font-weight-600">This leave cannot be taken together with</label>   
    </div>
    </div>
 <div class="col-6">
        <div class="form-group">
       <input type="text" id="html" name="fav_language" value="" class="form-control" style="height:35px;">
       
    </div>
    </div>
 </div> -->
</div>
</div>
<br>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Apply</button>
    <a class="btn btn-secondary" href="{{ url('leavetype') }}">
        Cancel</a>

</div>
