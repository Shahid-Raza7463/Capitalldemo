<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Client <span style="color:red;">*</span></label>
            <select class="language form-control" required name="client_id" id="client"
                @if(Request::is('travelform/*/edit'))> <option disabled style="display:block">Select
                Client
                </option>

                @foreach($client as $clientData)
                <option value="{{$clientData->id}}"
                    {{$travelform->client_id== $clientData->id??'' ?'selected="selected"' : ''}}>
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
            <label class="font-weight-600">Assignment Name <span style="color:red;">*</span></label>
            <select required class="form-control key" name="assignment" id="assignment">


            </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Partner <span style="color:red;">*</span></label>
            <select required class="form-control key" name="partener" id="partener">

            </select>
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Mode of Transport <span style="color:red;">*</span></label>
            <select name="mode_of_transport" required id="modeoftransport" class="form-control">

                <option value="">Please Select One</option>
                <option value="0">Flight</option>
                <option value="1">Train</option>

            </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Budget <span style="color:red;">*</span></label>
            <input type="number" name="budget" value="" required class="form-control" placeholder="Enter Your Budget">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Destination <span style="color:red;">*</span></label>
            <input type="text" name="destination" value="" required class="form-control" placeholder="Enter Your Destination">
        </div>
    </div>
    <div class="col-4" id="flightfood" style="display: none">
        <div class="form-group">
            <label class="font-weight-600">Food</label>
            <select name="flightfood1" required class="form-control">

                <option value="">Please Select One</option>
                <option value="Meal Include">Meal Include</option>
                <option value="Meal Exclude">Meal Exclude</option>
                <option value="Veg">Veg</option>
                <option value="Non-Veg">Non-Veg</option>
            </select>
        </div>
    </div>
   
</div>

<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Duration From <span style="color:red;">*</span></label>
            <input type="date" name="duration_from" value="" class="form-control" placeholder="">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Duration To <span style="color:red;">*</span></label>
            <input type="date" name="duration_to" value="" class="form-control" placeholder="">
        </div>
    </div>

</div>
<div class="field_wrapper">
    <div class="row row-sm">
    <div class="col-6">
            <div class="form-group">
                <label class="font-weight-600">Team Member <span style="color:red;">*</span></label>
                <select class="language form-control" name="member_name[]" 
                @if(Request::is('travelform/*/edit'))>
                    <option disabled style="display:block">Please Select One</option>
    
                    @foreach($teammember as $teammemberData)
                    <option value="{{$teammemberData->id}}" 
                        @if(($travelform->teammember_id) == $teammemberData->id) selected
                        @endif>
                      {{ $teammemberData->team_member }}  
                    </option>
                    @endforeach
    
                    @else
                    <option></option>
                    <option value="">Please Select One</option>
                    @foreach($teammember as $teammemberData)
                    <option value="{{$teammemberData->id}}">
                        {{ $teammemberData->team_member }} </option>
    
                    @endforeach
                    @endif
                </select>
                <!-- <input type="text" required  name="member_name[]" id="key" value="" class="form-control"
                placeholder="Enter Your Member Name"> -->
            </div>
        </div>
        <div class="col-1">
                <div class="form-group" style="margin-top: 36px;">
                    <a href="javascript:void(0);" class="add_button" title="Add field"><img
                            src="{{ url('backEnd/image/add-icon.png')}}" /></a>
                </div>
            </div>
        </div>
        </div>
<b style="font-weight: 800;font-size: 18px;">Travel</b>
<hr>
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Accomodation <span style="color:red;">*</span></label>
            <select name="accomodation" required id="accomodation" class="form-control">

                <option value="">Please Select One</option>
                <option value="0">Arrange by Self</option>
                <option value="1">Arrange by client</option>

            </select>
        </div>
    </div>
    <div class="col-4" id="noofrooms" style="display: none">
        <div class="form-group">
            <label class="font-weight-600">No of Rooms <span style="color:red;">*</span></label>
            <input type="number" name="no_of_rooms" value="" class="form-control"
                placeholder="Enter No of Rooms">
        </div>
    </div>
    <div class="col-4" id="noofhotel" style="display: none">
        <div class="form-group">
            <label class="font-weight-600">Hotel Type <span style="color:red;">*</span></label>
           
                <select name="no_of_hotel_type"  class="form-control">

                    <option value="">Please Select One</option>
                    <option value="3">5 Star</option>
                    <option value="1">3 Star</option>
                    <option value="2">1 Star</option>
    
                </select>
        </div>
    </div>
    <div class="col-4" id="budget" style="display: none">
        <div class="form-group">
            <label class="font-weight-600">Budget <span style="color:red;">*</span></label>
            <input type="text" name="hotel_budget" value="" class="form-control" placeholder="Enter Your Budget">
        </div>
    </div>
    <div class="col-4" id="from" style="display: none">
        <div class="form-group">
            <label class="font-weight-600">From <span style="color:red;">*</span></label>
            <input type="date" name="hotel_from" value="" class="form-control" placeholder="Enter Your Budget">
        </div>
    </div>
    <div class="col-4" id="to" style="display: none">
        <div class="form-group">
            <label class="font-weight-600">To <span style="color:red;">*</span></label>
            <input type="date" name="hotel_to" value="" class="form-control" placeholder="Enter Your Budget">
        </div>
    </div>
    <div class="col-4" id="hotellocation" style="display: none">
        <div class="form-group">
            <label class="font-weight-600">Hotel Location <span style="color:red;">*</span></label>
            <input type="text" name="hotellocation" value="" class="form-control" placeholder="Enter Your Hotel Location">
        </div>
    </div>
    <div class="col-4" id="plan" style="display: none">
        <div class="form-group">
            <label class="font-weight-600">Meal Plan <span style="color:red;">*</span></label>
             <select name="meal_plan"  class="form-control">

                <option value="">Please Select One</option>
                <option value="1">Breakfast Include</option>
                <option value="2">Breakfast Exclude</option>

            </select>
        </div>
    </div>
</div>
<br>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('contract') }}">
        back</a>

</div>
