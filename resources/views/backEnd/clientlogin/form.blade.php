<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600"> Name *</label>
            <input type="text" name="name" value="{{ $clientlogin->name ?? ''}}" class="form-control"
                placeholder="Enter Name">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Email *</label>
            <input type="text" name="email" value="{{ $clientlogin->email ?? ''}}" class="form-control"
                placeholder="Enter Email">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Phoneno *</label>
            <input type="text" name="phoneno" value="{{ $clientlogin->phoneno ?? ''}}" class="form-control"
                placeholder="Enter Phoneno">
                <input hidden  class="form-control"  name="client_id" value="{{ $id }}" type="text">
        </div>
    </div>
</div>
<div class="row row-sm">
   
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Password *</label>
            <input type="password" name="password" value="" class="form-control"
                placeholder="Enter Password">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Permission *</label>
            <select name="permission" id="exampleFormControlSelect33" class="form-control">
                <!--placeholder-->
                @if(Request::is('clientloginuserlogin/create/*')) >
                @if($clientloginlogin->permission=='1')
                <option value="1">unlimited</option>
                <option value="2">limited</option>

                @else
               
                <option value="2">limited</option>
                <option value="1">unlimited</option>

                @endif
                @else
                <option value="1">unlimited</option>
                <option value="2">limited</option>
                @endif
            </select>   
        </div>
    </div>
	 <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Two Factor Authentication *</label>
            <select name="twofactorauthentication" id="exampleFormControlSelect33" class="form-control">
                <!--placeholder-->
                @if(Request::is('clientloginuserlogin/create/*')) >
                @if($clientloginlogin->permission=='1')
                <option value="1">Yes</option>
                <option value="2">No</option>

                @else
               
                <option value="2">No</option>
                <option value="1">Yes</option>

                @endif
                @else
                <option value="1">Yes</option>
                <option value="2">No</option>
                @endif
            </select>   
        </div>
    </div>
	 <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Assign Folder ( Optional )</label>
            <select class="form-control" name="folderid">
                <option value="">Please Select One</option>
                @foreach($ilrfolder as $ilrfolderData)
                <option value="{{$ilrfolderData->id}}">
                    {{ $ilrfolderData->name }}</option>

                @endforeach
            </select>  
        </div>
    </div>
    <div class="col-4" id='designationn' style="display: none;">
        <div class="form-group">
            <label class="font-weight-600">Access *</label>
            <input type="number" name="limitedaccess" value="" class="form-control"
                placeholder="Enter Limited Access">
        </div>
    </div>
</div>
  <div class="form-group">
      <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
      <a class="btn btn-secondary" href="{{ url('informationresources') }}">
          Back</a>
  
  </div>
  