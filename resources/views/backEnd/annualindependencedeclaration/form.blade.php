<div class="form-group row">
    <label for="example-text-input" class="col-sm-7  font-weight-600">Choose Year For Annual Independence Declaration:</label>
    <div class="col-sm-2">
        <select required class=" form-control" name="year">
            <option value="">Please Select One</option>
            <option value="2023-24">2023-24</option>
            <option value="2022-23">2022-23</option>
        </select>
    </div>

</div>
<div class="form-group row">
    <label for="example-text-input" class="col-sm-7  font-weight-600">Name of Partner :</label>
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
    <label for="example-text-input" class="col-sm-7  font-weight-600">Do you have a direct or indirect
        holding of more than 2% Capital of any client or its subsidiaries/affiliates?</label>
    <div class="col-sm-2">
        <select required name="subsidiaries" required id="subsidiaries" class="form-control">
            <!--placeholder-->
            <option value="">Please Select One</option>
            <option value="1">Yes</option>
            <option value="2">No</option>

        </select>
    </div>
    <div class="col-sm-3" id='subsidiariesother' style="display: none;">
        <input type="text" id="subsidiariesothers" name="subsidiariesother" class="form-control"
            placeholder="If Yes, Please Provide Details">
    </div>
</div>
<div class="form-group row">
    <label for="example-search-input" class="col-sm-7  font-weight-600">Do you have a financial interest
        of more than 2% in any major competitors, investors in or affiliates of any client of the Firm?</label>
    <div class="col-sm-2">
        <select name="financial"  required  id="financial" class="form-control">
            <!--placeholder-->
            <option value="">Please Select One</option>
            <option value="1">Yes</option>
            <option value="2">No</option>

        </select>
    </div>
    <div class="col-sm-3" id='financialother' style="display: none;">
        <input type="text" id="financialothers" name="financialother" class="form-control"
            placeholder="If Yes, Please Provide Details">
    </div>
</div>
<div class="form-group row">
    <label for="example-email-input" class="col-sm-7  font-weight-600">Do you have any outside business
        relationship with any client of the Firm or an officer, director or principal shareholder of any Clients of the
        Firm having the objective of financial gain?</label>
    <div class="col-sm-2">
        <select required name="outside" id="outside" class="form-control">
            <!--placeholder-->
            <option value="">Please Select One</option>
            <option value="1">Yes</option>
            <option value="2">No</option>

        </select>
    </div>
    <div class="col-sm-3" id='outsideother' style="display: none;">
        <input type="text" id="outsideothers" name="outsideother" class="form-control"
            placeholder="If Yes, Please Provide Details">
    </div>
</div>
<div class="form-group row">
    <label for="example-url-input" class="col-sm-7  font-weight-600">Do you owe any client any
        amount?</label>
    <div class="col-sm-2">
        <select required name="client" id="client" class="form-control">
            <!--placeholder-->
            <option value="">Please Select One</option>
            <option value="1">Yes</option>
            <option value="2">No</option>

        </select>
    </div>
    <div class="col-sm-3" id='clientother' style="display: none;">
        <input type="text" id="clientothers" name="clientother" class="form-control"
            placeholder="If Yes, Please Provide Details">
    </div>
</div>
<div class="form-group row">
    <label for="example-tel-input" class="col-sm-7  font-weight-600">Do you have the authority to sign
        cheques for any client of the Firm?</label>
    <div class="col-sm-2">
        <select required name="authority" id="authority" class="form-control">
            <!--placeholder-->
            <option value="">Please Select One</option>
            <option value="1">Yes</option>
            <option value="2">No</option>

        </select>
    </div>
    <div class="col-sm-3" id='authorityother' style="display: none;">
        <input type="text" id="authorityothers" name="authorityother" class="form-control"
            placeholder="If Yes, Please Provide Details">
    </div>
</div>
<div class="form-group row">
    <label for="example-password-input" class="col-sm-7  font-weight-600">Are you connected with any
        client of the Firm as a promoter, underwriter or voting trustee, director, partner, officer or in any capacity
        equivalent to a member of management or an employee?</label>
    <div class="col-sm-2">
        <select required name="underwriter" id="underwriter" class="form-control">
            <!--placeholder-->
            <option value="">Please Select One</option>
            <option value="1">Yes</option>
            <option value="2">No</option>

        </select>
    </div>
    <div class="col-sm-3" id='underwriterother' style="display: none;">
        <input type="text" id="underwriterothers" name="underwriterother" class="form-control"
            placeholder="If Yes, Please Provide Details">
    </div>
</div>
<div class="form-group row">
    <label for="example-number-input" class="col-sm-7  font-weight-600">Do you serve as a director,
        Partner, trustee, officer, or employee of any client of the Firm?</label>
    <div class="col-sm-2">
        <select required name="trustee" id="trustee" class="form-control">
            <!--placeholder-->
            <option value="">Please Select One</option>
            <option value="1">Yes</option>
            <option value="2">No</option>

        </select>
    </div>
    <div class="col-sm-3" id='trusteeother' style="display: none;">
        <input type="text" id="trusteeothers" name="trusteeother" class="form-control"
            placeholder="If Yes, Please Provide Details">
    </div>
</div>
<div class="form-group row">
    <label for="example-datetime-local-input" class="col-sm-7  font-weight-600">Has your spouse or
        children or relative is employed by any client of the Firm?</label>
    <div class="col-sm-2">
        <select required name="spouse" id="spouse" class="form-control">
            <!--placeholder-->
            <option value="">Please Select One</option>
            <option value="1">Yes</option>
            <option value="2">No</option>

        </select>
    </div>
    <div class="col-sm-3" id='spouseother' style="display: none;">
        <input type="text" id="spouseothers" name="spouseother" class="form-control"
            placeholder="If Yes, Please Provide Details">
    </div>
</div>
<div class="form-group row">
    <label for="example-date-input" class="col-sm-7  font-weight-600">Are you connected with any client of
        the Firm in any other capacity directly or indirectly which may compromise your independence?</label>
    <div class="col-sm-2">
        <select required name="compromise" id="compromisee" class="form-control">
            <!--placeholder-->
            <option value="">Please Select One</option>
            <option value="1">Yes</option>
            <option value="2">No</option>

        </select>
    </div>
    <div class="col-sm-3" id='compromiseotherr' style="display: none;">
        <input type="text" id="compromiseotherssss" name="compromiseother" class="form-control"
            placeholder="If Yes, Please Provide Details">
    </div>
</div>
<div class="form-group row">
    <label for="example-month-input" class="col-sm-7  font-weight-600">Do you have any pending litigation
        with any client of the Firm?</label>
    <div class="col-sm-2">
        <select required name="litigation" id="litigation" class="form-control">
            <!--placeholder-->
            <option value="">Please Select One</option>
            <option value="1">Yes</option>
            <option value="2">No</option>

        </select>
    </div>
    <div class="col-sm-3" id='litigationother' style="display: none;">
        <input type="text" id="litigationothers" name="litigationother" class="form-control"
            placeholder="If Yes, Please Provide Details">
    </div>
</div>
<div class="form-group row">
    <label for="example-week-input" class="col-sm-7  font-weight-600">Are you relative of any client of
        the Firm</label>
    <div class="col-sm-2">
        <select required name="relative" id="relative" class="form-control">
            <!--placeholder-->
            <option value="">Please Select One</option>
            <option value="1">Yes</option>
            <option value="2">No</option>

        </select>
    </div>
    <div class="col-sm-3" id='relativeotherrs' style="display: none;">
        <input type="text" id="relativeotherssss" name="relativeother" class="form-control"
            placeholder="If Yes, Please Provide Details">
    </div>
</div>

<br>
<hr>
<div class="form-group row">
 <div class="col-sm-12">
			   <br>
			     <p><strong style="color:rgb(0,31,95)">DECLARATION:</strong></p>
			   <p>

				   I <b>_____________</b> , do hereby declare that I will faithfully, truly and to the best of my skill and ability execute and perform the duties required of me as Partner/Qualified Chartered Accountant/Audit Assistant of the firm. </p>
			   <p>
				   I further declare that I will not communicate or allow to be communicated to any person, not legally entitled thereto, any information relating to the affairs of the Clients and our firm, neither will allow any such person to inspect or have access to any records or documents belonging to the clients nor the nature of the business of the client.
			   </p>
			   <p>
				   The acceptance of any gifts & hospitality from clients/ owners shall be declared as per the policy of the firm.
			   </p>
			   <p><strong style="color:rgb(0,31,95)">UNDERTAKING</strong></p>
			   <p>
				   I undertake that there are no adverse remarks/disciplinary proceeding pending / initiated against me as Partner/Qualified Chartered Accountant/Audit Assistant of the firm with any regulator/tribunal/court.
			   </p>
	  <p><strong style="color:rgb(0,31,95)">Note:</strong></p><br>
                                 <p><strong style="margin-left:40px;color:rgb(0,31,95)">1. Relative means a relative as
                                         defined in Companies Act 2013.</strong></p>
	   <p><strong style="margin-left:40px;color:rgb(0,31,95)">2. Where answer is yes, please provide complete details in a separate sheet.</strong></p>
	    <p><strong style="margin-left:40px;color:green"> The form will be E-Verified by you after Submission.</strong></p>
                                      
		 </div>	
</div>
<hr>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('annualindependencedeclaration') }}">
        Back</a>

</div>
