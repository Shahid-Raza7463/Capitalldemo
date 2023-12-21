<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
        <label class="font-weight-600">File Upload *</label>
            <input type="file"  name="file" value="{{ $applypolicy->file ??''}}" class="form-control"
                placeholder="">    
        
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
        <label class="font-weight-600">File Name *</label>
            <input type="text"  name="filename" value="{{ $applypolicy->filename ??''}}" class="form-control"
            placeholder="">
        </div>
        </div>
         
</div>
<div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Description *</label>
            <textarea type="text"  name="descripation" value="{{ $applypolicy->descripation ??''}}" class="form-control"
                placeholder=""></textarea>
           
        </div>
    </div>   
</div>
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Share with *</label>
            <select class="form-control basic-multiple"  multiple="multiple" name="sharewith[]"
                @if(Request::is('policy/*/edit'))> <option disabled style="display:block">Please Select One</option>

                @foreach($role as $roleData)
                <option value="{{$roleData->id}}"
                    {{$policy->sharewith == $roleData->id??'' ?'selected="selected"' : ''}}>
                    {{$roleData->rolename}}</option>
                @endforeach


                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($role as $roleData)
                <option value="{{$roleData->id}}">
                    {{ $roleData->rolename}} </option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-4" id="Div1">
        <div class="form-group">
            <label class="font-weight-600"> Folder*</label>
            <select class="language form-control" id="exampleFormControlSelect1" name="folder_id"
                @if(Request::is('policy/*/edit'))> <option disabled style="display:block">Please Select One</option>

                @foreach($folder as $folderData)
                <option value="{{$folderData->id}}"
                    {{$policy->sharewith == $folderData->id??'' ?'selected="selected"' : ''}}>
                    {{$folderData->foldername}}</option>
                @endforeach


                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($folder as $folderData)
                <option value="{{$folderData->id}}">
                    {{ $folderData->foldername}} </option>

                @endforeach
                @endif
            </select>    
        </div>
    </div>
    <div class="col-4" id="Div2" style="display: none">
        <div class="form-group">
            <label class="font-weight-600">Add Folder </label>
            <input type="text" name="foldername" value="{{ $policy->foldername ?? ''}}" class="form-control"
                placeholder="Enter Folder Name">
        </div>
    </div>
    <div class="col-1">
        <div class="form-group" style="margin-top: 36px;">
            <a id="Button1" class="add_button" title="Add field" onclick="switchVisible();"><img
                    src="{{ url('backEnd/image/add-icon.png')}}" /></a>
        </div>
    </div>
    
</div>
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Valid Until *</label>
            <input type="date"  name="date" value="{{ $applypolicy->reasonpolicy ??''}}" class="form-control"
            placeholder="Enter Reason for policy">
        </div>
    </div>  
    <div class="col-4">
        <div class="form-group form-check">
            <br><br>
            <input type="checkbox" value="1" name="markasacknowledge" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Mark As Acknowledge</label>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group form-check">
            <br><br>
            <input type="checkbox" value="1" name="notify" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Notify </label>
        </div>
    </div>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('policy') }}">
        Cancel</a>

</div>

<script>
    function switchVisible() {
        if (document.getElementById('Div1')) {

            if (document.getElementById('Div1').style.display == 'none') {
                document.getElementById('Div1').style.display = 'block';
                document.getElementById('Div2').style.display = 'none';
            } else {
                document.getElementById('Div1').style.display = 'none';
                document.getElementById('Div2').style.display = 'block';
            }
        }
    }

</script>