<div class="row no-gutters">
      <div class="col-md-6">
        <img src="{{ url('backEnd/image.jpg')}}" style="height:400px;" class="card-img" alt="...">
      </div>
      <div class="col-md-6">
        <div class="card-body">
               <br>
        <div class="form-group">
            <label class="font-weight-600"><b>Employee Name</b></label>
         
      <input type="text" class="form-control" readonly value="{{$teammember->team_member ?? ''}}">
    </div>
    <br>
      <div class="form-group">
        <label class="font-weight-600"><b>Email</b></label>
      <input type="email" name="email" class="form-control" readonly value="{{$teammember->emailid ?? ''}}">
    </div>
    <br>
    
    <br>
    <hr>    
    <div class="form-group">
        <button type="submit" class="btn btn-success btn-block"> Click Here To Register</button>
       
      </div>
        </div>
      </div>
    </div>

    {{-- <div class="row row-sm">
        <div class="col-6">
            <div class="form-group">
                <label class="font-weight-600">Job Name</label>
                <input type="text" readonly value="{{$teammember->team_member ?? ''}}" class="form-control">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="font-weight-600">Job Name</label>
                <input type="text" readonly value="{{$teammember->emailid ?? ''}}" class="form-control">
            </div>
        </div>
    </div>
    
    <hr>
    
    
    
    <div class="form-group">
    
        <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
        <a class="btn btn-secondary" href="{{ url('job') }}">
            Back</a>
    
    </div> --}}
  