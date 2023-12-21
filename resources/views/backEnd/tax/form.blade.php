<div class="row row-sm">
	   <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Choose Financial Year *</label>
            <select class="form-control key" required name="year" >
                @if(Request::is('tax/*/edit')) >
                @if($tax->year=='2022')
                <option value="2022">2022-23</option>
                <option value="2023">2023-24</option>
                @else
                <option value="2023">2023-24</option>
                <option value="2022">2022-23</option>
               
                @endif
                @else
                <option value="">Please Select One</option>
                <option value="2022">2022-23</option>
                <option value="2023">2023-24</option>
                @endif
            </select>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Tax Regime *</label>
            <select class="form-control key" required name="tax_regime" id="tax_regime">
                @if(Request::is('tax/*/edit')) >
                @if($tax->billable_status=='Billable')
                <option value="0">Old</option>
                <option value="1">New</option>
                @else
                <option value="1">New</option>
                <option value="0">Old</option>
                @endif
                @else
                <option value="">Please Select One</option>
                <option value="0">Old</option>
                <option value="1">New</option>
                @endif
            </select>
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Gross Salary</label>
            <input type="text" readonly name="gross_salary" value="{{$team->taxgrosssalary ?? ''}}" class="form-control">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">TDS</label>
            <input type="text" readonly name="tds" value="{{$team->taxtds ?? ''}}" class="form-control">
        </div>
    </div>
    <div class="col-4" id="anyotherincome" style="display: none">
        <div class="form-group">
            <label class="font-weight-600">Any Other Income  *</label>
            <input type="text" name="anyotherincome" value="{{$tax->anyotherincome ?? ''}}" class="form-control">
        </div>
    </div>
</div>
<div id="Deduction" style="display: none">
<div class="row row-sm ">
    <div class="col-12"><br>
        <table class="table table-bordered">
            <fieldset class="form-group">
                <tbody>
                    <tr>
                        <td colspan="5" style="text-align:center;font-weight-600 mb-0"><b>Deduction</b></td>

                    </tr>
                </tbody>
				</fieldset>
        </table>

    </div>
</div>
<div class="row row-sm ">
    <div class="col-12">
        <table class="table table-bordered">
            <tr style="background: #37A000;color:#F4F4F5;">
                <th>Sr.No</th>   
                <th>Section *</th>
                <th>Description *</th>
                <th>Deduction Amount *</th>
              <!--  <th>Attachment *</th> -->
                <th> <button type="button" name="add_row" id="add_row"><i class="fe fe-plus"></i><img
                            src="{{ url('backEnd/image/add-icon.png')}}" /></button></th>
            </tr>
            <tbody id="performanceevaluation">
                <td><span id="sr_no">1</span></td>
                <td><input type="text" value="" name="section[]" data-srno="1"
                        placeholder="" class="form-control" /></td>
                <td><input type="text" value="" name="description[]" data-srno="1"
                        placeholder="" class="form-control" />
                </td>
                <td><input type="text" value="" name="deductionamount[]" data-srno="1" placeholder=""
                        class="form-control" />
                </td>
           <!--     <td><input type="file" value="" name="filess[]" data-srno="1"
                        placeholder="" class="form-control" /> -->
                </td>
                <td><button type="button" name="remove_row" id="'+count+'"
                        class="btn btn-danger btn-xs remove_row">X</button></td>
            </tbody>
        </table>
    </div>
</div>
<div class="row row-sm ">
    <div class="col-12"><br>
        <table class="table table-bordered">
            <fieldset class="form-group">
                <tbody>
                    <tr>
                        <td colspan="5" style="text-align:center;font-weight-600 mb-0""><b>Any Other Income</b></td>

                    </tr>
                </tbody>
        </table>

    </div>
</div>
<div class="row row-sm ">
    <div class="col-12">
        <table class="table table-bordered">
            <tr style="background: #37A000;color:#F4F4F5;">
               <th>Section *</th>
                <th>Description *</th>
                <th>Tax Amount *</th>
                {{-- <th>Attachment *</th> --}}
             
            </tr>
            <tbody >
                <td><input type="text" value="" name="othersection" 
                        placeholder="" class="form-control" /></td>
                <td><input type="text" value="" name="otherdescription" 
                        placeholder="" class="form-control" />
                </td>
                <td><input type="text" value="" name="taxamount"  placeholder=""
                        class="form-control" />
                </td>
                {{-- <td><input type="file" value="" name="otherattachment" 
                        placeholder="" class="form-control" />
                </td> --}}
               
            </tbody>
        </table>
    </div>
</div>
<br>

<div class="row row-sm ">
    <div class="col-12">
        <div class="form-group" style="text-align:center;">
            <label class="fs-17 font-weight-600 mb-0"><b>Approval Advance Tax</b></label>
        </div>
    </div>
</div>
<hr>
<div class="row row-sm">
 
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Amount *</label>
            <input type="text" name="advancetaxamount" value="{{$tax->tds ?? ''}}" class="form-control">
        </div>
    </div>
    {{-- <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Attachment *</label>
            <input type="file" name="advanceetaxattachment"  class="form-control">
        </div>
    </div> --}}
</div>
</div>
<hr>



<div class="form-group">

    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('tax') }}">
        Back</a>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
 $(document).ready(function () {
        $('#tax_regime').on('change', function () {
            if (this.value == '0') {
                $("#Deduction").show();
                $("#anyotherincome").hide();
                $("#otherss").hide();
            } 
            else if (this.value == '1') {

                $("#anyotherincome").show();
                $("#Deduction").hide();
            
            } else {
                $("#Deduction").hide();
            }
        });
        });
      

</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script>
     $(document).ready(function(){
      
       var count = 1;
       
       $(document).on('click', '#add_row', function(){
         count++;

         var html_code = '';
         html_code += '<tr id="row_id_'+count+'">';
         html_code += '<td><span id="sr_no">'+count+'</span></td>';
         html_code += '<td><input type="text" name="section[]" id="section'+count+'" data-srno="'+count+'" class="form-control" /></td>';
         html_code += '<td><input type="text" name="description[]" id="description'+count+'" data-srno="'+count+'" class="form-control" ></td>';
         html_code += '<td><input type="text" name="deductionamount[]" id="deductionamount'+count+'" data-srno="'+count+'" class="form-control"></td>';
         html_code += '<td><button type="button" name="remove_row" id="'+count+'" class="btn btn-danger btn-xs remove_row">X</button></td>';
         html_code += '</tr>';
         $('#performanceevaluation').append(html_code);
       });
       
       $(document).on('click', '.remove_row', function(){
         var row_id = $(this).attr("id");
         $('#row_id_'+row_id).remove();
         count--;
      //   $('#total_item').val(count);
       });
     });
   
</script>