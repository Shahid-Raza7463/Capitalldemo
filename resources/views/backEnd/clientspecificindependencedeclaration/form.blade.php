<div class="form-group row">
    <label for="example-text-input" class="col-sm-7  font-weight-600">Choose Year For Annual Independence
        Declaration:</label>
    <div class="col-sm-2">
        <select required class=" form-control" name="year">
            <option value="">Please Select One</option>
            <option value="2023-24">2023-24</option>
            <option value="2022-23">2022-23</option>
        </select>
    </div>

</div>
<div class="form-group row">
    <label for="example-text-input" class="col-sm-7  font-weight-600">Name of Engagement Partner :</label>
    <div class="col-sm-2">
        <select required class="language form-control" name="partner">
            <option value="">Please Select One</option>
            @foreach($partner as $teammemberData)
            <option value="{{$teammemberData->id}}">
                {{ $teammemberData->team_member }}</option>

            @endforeach

        </select>
    </div>

</div>
 <div class="form-group row">
    <label for="example-text-input" class="col-sm-7  font-weight-600">Do you have a direct or indirect holding of more
        than 2% in the Capital of the client or its subsidiaries/affiliates?</label>
    <div class="col-sm-2">
        <select required name="subsidiaries" required id="subsidiariess" class="form-control">
            <!--placeholder-->
            <option value="">Please Select One</option>
            <option value="1">Yes</option>
            <option value="2">No</option>

        </select>
    </div>
    <div class="col-sm-3" id='subsidiariesothers' style="display: none;">
        <input type="text" id="subsidiariesotherss" name="subsidiariesother" class="form-control"
            placeholder="If Yes, Please Provide Details">
    </div>
</div>

<div class="form-group row">
    <label for="example-search-input" class="col-sm-7  font-weight-600">Do you have a financial interest of more than 2%
        in any major competitors, investors in or affiliates of the client?</label>
    <div class="col-sm-2">
        <select name="financial" required id="financials" class="form-control">
            <!--placeholder-->
            <option value="">Please Select One</option>
            <option value="1">Yes</option>
            <option value="2">No</option>

        </select>
    </div>
    <div class="col-sm-3" id='financialothers' style="display: none;">
        <input type="text" id="financialotherss" name="financialother" class="form-control"
            placeholder="If Yes, Please Provide Details">
    </div>
</div>
<div class="form-group row">
    <label for="example-email-input" class="col-sm-7  font-weight-600">Do you have any outside business relationship
        with the client or an officer, director or principal shareholder of the client having the objective of financial
        gain?</label>
    <div class="col-sm-2">
        <select required name="outside" id="outsides" class="form-control">
            <!--placeholder-->
            <option value="">Please Select One</option>
            <option value="1">Yes</option>
            <option value="2">No</option>

        </select>
    </div>
    <div class="col-sm-3" id='outsideothers' style="display: none;">
        <input type="text" id="outsideotherss" name="outsideother" class="form-control"
            placeholder="If Yes, Please Provide Details">
    </div>
</div>
<div class="form-group row">
    <label for="example-url-input" class="col-sm-7  font-weight-600">Do you owe the client any amount?</label>
    <div class="col-sm-2">
        <select required name="client" id="clients" class="form-control">
            <!--placeholder-->
            <option value="">Please Select One</option>
            <option value="1">Yes</option>
            <option value="2">No</option>

        </select>
    </div>
    <div class="col-sm-3" id='clientothers' style="display: none;">
        <input type="text" id="clientotherss" name="clientother" class="form-control"
            placeholder="If Yes, Please Provide Details">
    </div>
</div>
<div class="form-group row">
    <label for="example-tel-input" class="col-sm-7  font-weight-600">Do you have the authority to sign cheques for the
        client?</label>
    <div class="col-sm-2">
        <select required name="authority" id="authoritys" class="form-control">
            <!--placeholder-->
            <option value="">Please Select One</option>
            <option value="1">Yes</option>
            <option value="2">No</option>

        </select>
    </div>
    <div class="col-sm-3" id='authorityothers' style="display: none;">
        <input type="text" id="authorityotherss" name="authorityother" class="form-control"
            placeholder="If Yes, Please Provide Details">
    </div>
</div>
<div class="form-group row">
    <label for="example-password-input" class="col-sm-7  font-weight-600">Are you connected with the client as a
        promoter, underwriter or voting trustee, director, partner, officer or in any capacity equivalent to a member of
        management or an employee?</label>
    <div class="col-sm-2">
        <select required name="underwriter" id="underwriters" class="form-control">
            <!--placeholder-->
            <option value="">Please Select One</option>
            <option value="1">Yes</option>
            <option value="2">No</option>

        </select>
    </div>
    <div class="col-sm-3" id='underwriterothers' style="display: none;">
        <input type="text" id="underwriterotherss" name="underwriterother" class="form-control"
            placeholder="If Yes, Please Provide Details">
    </div>
</div>
<div class="form-group row">
    <label for="example-number-input" class="col-sm-7  font-weight-600">Do you serve as a director, partner, trustee,
        officer, or employee of the client?</label>
    <div class="col-sm-2">
        <select required name="trustee" id="trustees" class="form-control">
            <!--placeholder-->
            <option value="">Please Select One</option>
            <option value="1">Yes</option>
            <option value="2">No</option>

        </select>
    </div>
    <div class="col-sm-3" id='trusteeothers' style="display: none;">
        <input type="text" id="trusteeotherss" name="trusteeother" class="form-control"
            placeholder="If Yes, Please Provide Details">
    </div>
</div>
<div class="form-group row">
    <label for="example-datetime-local-input" class="col-sm-7  font-weight-600">Has your spouse or children or relative
        been employed with the client?</label>
    <div class="col-sm-2">
        <select required name="spouse" id="spouses" class="form-control">
            <!--placeholder-->
            <option value="">Please Select One</option>
            <option value="1">Yes</option>
            <option value="2">No</option>

        </select>
    </div>
    <div class="col-sm-3" id='spouseothers' style="display: none;">
        <input type="text" id="spouseotherss" name="spouseother" class="form-control"
            placeholder="If Yes, Please Provide Details">
    </div>
</div>
<div class="form-group row">
    <label for="example-date-input" class="col-sm-7  font-weight-600">Are you connected with the client in any other
        capacity directly or indirectly which may compromise your independence?</label>
    <div class="col-sm-2">
        <select required name="compromise" id="compromises" class="form-control">
            <!--placeholder-->
            <option value="">Please Select One</option>
            <option value="1">Yes</option>
            <option value="2">No</option>

        </select>
    </div>
    <div class="col-sm-3" id='compromiseothers' style="display: none;">
        <input type="text" id="compromiseotherss" name="compromiseother" class="form-control"
            placeholder="If Yes, Please Provide Details">
    </div>
</div>
<div class="form-group row">
    <label for="example-month-input" class="col-sm-7  font-weight-600">Do you have any pending litigation with the
        client?</label>
    <div class="col-sm-2">
        <select required name="litigation" id="litigations" class="form-control">
            <!--placeholder-->
            <option value="">Please Select One</option>
            <option value="1">Yes</option>
            <option value="2">No</option>

        </select>
    </div>
    <div class="col-sm-3" id='litigationothers' style="display: none;">
        <input type="text" id="litigationotherss" name="litigationother" class="form-control"
            placeholder="If Yes, Please Provide Details">
    </div>
</div>
<div class="form-group row">
    <label for="example-week-input" class="col-sm-7  font-weight-600">Are you relative of the client?</label>
    <div class="col-sm-2">
        <select required name="relative" id="relatives" class="form-control">
            <!--placeholder-->
            <option value="">Please Select One</option>
            <option value="1">Yes</option>
            <option value="2">No</option>

        </select>
    </div>
    <div class="col-sm-3" id='relativeothers' style="display: none;">
        <input type="text" id="relativeotherss" name="relativeother" class="form-control"
            placeholder="If Yes, Please Provide Details">
    </div>
</div> 
<hr>
<div class="form-group row">
    <div class="col-sm-12">
        <p><strong style="color:rgb(0,31,95)">Note:</strong></p><br>
        <p><strong style="margin-left:40px;color:rgb(0,31,95)">1. Relative means a relative as
                defined in Companies Act 2013.</strong></p>
        <p><strong style="margin-left:40px;color:rgb(0,31,95)">2. Where answer is yes, please
                provide complete details in a separate sheet.</strong></p><br>
		  <p><strong style="margin-left:40px;color:green"> The form will be E-Verified by you after Submission.</strong></p>
       
    </div>
</div>

<br>
<hr>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('clientspecificindependence') }}">
        Back</a>

</div>
