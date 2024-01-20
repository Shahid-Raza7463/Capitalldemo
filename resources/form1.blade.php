<style>
    .tbl-cus-short thead tr th {
        font-size: 13px;
        text-align: center;
    }
    .tbl-cus-short thead tr th span {
        display: block;
        font-weight: 400;
        font-size: 10px;
        color: #a3a2a2;
        line-height: 8px;
    }
   .select-design select {
        border: none;
        width: 100%;
    }
   .tbl-cus-short tr td input {
        border: none;
        width: 45px;
    }
    .select-design th {
        padding: 12px 10px;
    }
    .tbl-cus-short td:last-child{font-weight: 700;}
</style>
<div class="field_wrapper">
    <div class="row">
    <div class="col-sm-8">
    </div>
    <div class="col-sm-4">
    <div class="text-right">
    <div class="tab-navigation form-group" > 
        <select id="select-box" class="form-control">
            <option value="1">Daily Log</option>
            <option value="2">Weekly Log</option>
            <option value="3">Semi Monthly</option>
            <option value="4">Monthly Log</option>
        </select>
        </div>
    </div>
    
    </div>
    </div>
    <br>

<div class="row">
    
    <div class="col-sm-6">
        <div class="row row-sm">
            <div class="col-4">
                <div class="form-group">
                    <label class="font-weight-300">Client Name</label>
                    <select class="language form-control" name="client_id[]" id="client"
                        @if(Request::is('timesheet/*/edit'))> <option disabled style="display:block">Select
                        Client
                        </option>
        
                        @foreach($client as $clientData)
                        <option value="{{$clientData->id}}"
                            {{$timesheet->client_id== $clientData->id??'' ?'selected="selected"' : ''}}>
                            {{$clientData->client_name }}</option>
                        @endforeach
        
        
                        @else
                        <option></option>
                        <option value="">Select Client</option>
                        @foreach($client as $clientData)
                        <option value="{{$clientData->id}}">
                            {{ $clientData->client_name }}</option>
        
                        @endforeach
                        @endif
                    </select>   
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label class="font-weight-300">Project Name</label>
                     <select class="form-control key" name="project_id[]" id="project">
                     <option disabled style="display:block">Select
                        Project
                        </option>
                        
                    </select>
                   
                    <a href="{{url('project/create')}}">Add Project</a>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="font-weight-300" style="width:100px;">Job Name</label>
                    <select class="form-control key" name="job_id[]" id="job">
                       
                    </select>
                    <a href="{{url('job/create')}}">Add Job</a>
                </div>
            </div>    
            <div class="col-1">
                    <div class="form-group" style="margin-top: 36px;">
                        <a href="javascript:void(0);" class="add_button" title="Add field"><img
                                src="{{ url('backEnd/image/add-icon.png')}}" /></a>
                    </div>
                </div>
        </div>
        <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label class="font-weight-300" style="width:100px;">Work Item</label>
                <input type="text" name="workitem[]" id="key"
                    value="{{ $timesheet->workitem ?? ''}}" class="form-control key">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="font-weight-300">Billable Status</label>
                <select class="form-control key" name="billable_status[]" id="key" id="exampleFormControlSelect1">
                    @if(Request::is('timesheet/*/edit')) >
                    @if($timesheet->billable_status=='Billable')
                    <option value="Billable">Billable</option>
                    <option value="Non Billable">Non Billable</option>
    
    
                    @else
                    <option value="Non Billable">Non Billable</option>
                    <option value="Billable">Billable</option>
    
    
    
                    @endif
                    @else
                    <option value="Billable">Billable</option>
                    <option value="Non Billable">Non Billable</option>
    
                    @endif
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="font-weight-300">Description</label>
                <input type="text" name="description[]" id="key"
                    value="{{ $timesheet->description ?? ''}}" class="form-control key">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="font-weight-300">Hour</label>
                <input type="text" class="form-control key" id="endTime" name='hour[]' value="{{ $timesheet->hour ?? ''}}">
            </div>
        </div>
    </div>
</div>
    <div class="col-sm-6">
         <div id="tab-1" class="tab-1 tab-content">
             This is tab 1 for Daily Log content.

        </div>
         
      <div id="tab-2" class="tab-2 tab-content">
        <div class="table-responsive">
            <table class="table tbl-cus-short">
                <thead>
                    <tr>

                        <th>Dec 05<span>Sun</span></th>
                        <th>Dec 06<span>Mon</span></th>
                        <th>Dec 07<span>Tue</span></th>
                        <th>Dec 08<span>Wed</span></th>
                        <th>Dec 09<span>Thu</span></th>
                        <th>Dec 10<span>Fri</span></th>
                        <th>Dec 11<span>Sat</span></th>

                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>

                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td>00.00</td>

                    </tr>
                    <tr>

                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td>00.00</td>
                    </tr>
                    <tr>

                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td>00.00</td>
                    </tr>
                    <tr>

                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td>00.00</td>
                    </tr>
                    <tr>

                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td>00.00</td>
                    </tr>


                </tbody>
                <tfoot>
                    <tr>

                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>

                    </tr>
                </tfoot>

            </table>
</div>
      </div>
        
      <div id="tab-3" class="tab-3 tab-content">                                         
          <div class="table-responsive">
            <table class="table tbl-cus-short">
                <thead>
                    <tr>
                        <th>Dec 01<span>Wed</span></th>
                        <th>Dec 02<span>Tue</span></th>
                        <th>Dec 03<span>Fri</span></th>
                        <th>Dec 04<span>Sat</span></th>
                        <th>Dec 05<span>Sun</span></th>
                        <th>Dec 06<span>Mon</span></th>
                        <th>Dec 07<span>Tue</span></th>
                        <th>Dec 08<span>Wed</span></th>
                        <th>Dec 09<span>Thu</span></th>
                        <th>Dec 10<span>Fri</span></th>
                        <th>Dec 11<span>Sat</span></th>
                        <th>Dec 12<span>Sun</span></th>
                        <th>Dec 13<span>Mon</span></th>
                        <th>Dec 14<span>Tue</span></th>
                        <th>Dec 15<span>Wed</span></th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td>00.00</td>

                    </tr>
                    <tr>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td>00.00</td>
                    </tr>
                    <tr>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td>00.00</td>
                    </tr>
                    <tr>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td>00.00</td>
                    </tr>
                    <tr>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td>00.00</td>
                    </tr>


                </tbody>
                <tfoot>
                    <tr>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>

                    </tr>
                </tfoot>

            </table>
          </div>
      </div>
        
     <div id="tab-4" class="tab-4 tab-content">
        <div class="table-responsive">
            <table class="table tbl-cus-short">
                <thead>
                    <tr>
                        <th>Dec 01<span>Wed</span></th>
                        <th>Dec 02<span>Tue</span></th>
                        <th>Dec 03<span>Fri</span></th>
                        <th>Dec 04<span>Sat</span></th>
                        <th>Dec 05<span>Sun</span></th>
                        <th>Dec 06<span>Mon</span></th>
                        <th>Dec 07<span>Tue</span></th>
                        <th>Dec 08<span>Wed</span></th>
                        <th>Dec 09<span>Thu</span></th>
                        <th>Dec 10<span>Fri</span></th>
                        <th>Dec 11<span>Sat</span></th>
                        <th>Dec 12<span>Sun</span></th>
                        <th>Dec 13<span>Mon</span></th>
                        <th>Dec 14<span>Tue</span></th>
                        <th>Dec 15<span>Wed</span></th>
                        <th>Dec 16<span>Tue</span></th>
                        <th>Dec 17<span>Fri</span></th>
                        <th>Dec 18<span>Sat</span></th>
                        <th>Dec 19<span>Sun</span></th>
                        <th>Dec 20<span>Mon</span></th>
                        <th>Dec 21<span>Tue</span></th>
                        <th>Dec 22<span>Wed</span></th>
                        <th>Dec 23<span>Thu</span></th>
                        <th>Dec 24<span>Fri</span></th>
                        <th>Dec 25<span>Sat</span></th>
                        <th>Dec 26<span>Sun</span></th>
                        <th>Dec 27<span>Mon</span></th>
                        <th>Dec 28<span>Tue</span></th>
                        <th>Dec 29<span>Wed</span></th>
                        <th>Dec 30<span>Thu</span></th>
                        <th>Dec 31<span>Fri</span></th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td>00.00</td>

                    </tr>
                    <tr>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td>00.00</td>
                    </tr>
                    <tr>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td>00.00</td>
                    </tr>
                    <tr>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td>00.00</td>
                    </tr>
                    <tr>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td><input placeholder="00.00"></td>
                        <td>00.00</td>
                    </tr>


                </tbody>
                <tfoot>
                    <tr>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        <th>00:00</th>
                        

                    </tr>
                </tfoot>

            </table>
          </div>
      </div>
      
                                        </div>
    
</div>
</div>
<hr>
<div class="form-group">
    
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('timesheet') }}">
        Back</a>

</div>
