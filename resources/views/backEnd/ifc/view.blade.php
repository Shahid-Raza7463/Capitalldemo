@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">

    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">

            <li> <a class="btn btn-primary" href="{{ url('ifcfolders') }}">Back</a></li>

        </ol>
    </nav>

    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small> Details</small></a>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="card mb-4">
        @component('backEnd.components.alert')

        @endcomponent
        <div class="card-body">

            <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2); ">
                <div class="card-body">

                    <fieldset class="form-group">

                        <table class="table display table-bordered table-striped table-hover">

                            <tbody>

                                <tr>
                                    <td><b>Control Number : </b></td>

                                    <td>{{ $ifc->control_number??''}}</td>
                                    <td><b>Sub Process : </b></td>
                                    <td>{{ $ifc->sub_process??''}}</td>
                                </tr>
                                <tr>
                                    <td><b>Control Objective : </b></td>

                                    <td>{{ $ifc->control_objective??''}}</td>
                                    <td><b>Identification of Risk of Material Misstatement : </b></td>
                                    <td>{{ $ifc->identification_risk??''}}</td>
                                </tr>


                            </tbody>

                        </table>


                    </fieldset>

                </div>

            </div>


        </div>
        @if($ifc->assign_member == Auth::user()->teammember_id)
        <div class="card-body">

            <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:1200px;">
                <div class="card-body">
                    <form method="post" action="{{ url('ifc/update', $ifc->id)}}" enctype="multipart/form-data">
                       
                        @csrf
                        @component('backEnd.components.alert')

                        @endcomponent

                        <div class="row row-sm">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">As Is Control</label>
                                    <input type="text"  name="as_is_control" class="form-control" value="" />
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Fraud Risk</label>
                                    <select name="fraud_risk" class="form-control">
                                        <!--placeholder-->
                                        @if(Request::is('ifc/*/edit')) >
                                        @if($ifc->fraud_risk=='Yes')
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>

                                        @else
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>

                                        @endif
                                        @else
                                        <option value="">Please Select Open</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Risk Rating</label>
                                    <select name="risk_rating" class="form-control">
                                        <!--placeholder-->
                                        @if(Request::is('ifc/*/edit')) >
                                        @if($ifc->risk_rating=='High')
                                        <option value="High">High</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Low">Low</option>

                                        @elseif($template->risk_rating=='Medium')
                                        <option value="Medium">Medium</option>
                                        <option value="High">High</option>
                                        <option value="Low">Low</option>

                                        @else
                                        <option value="Low">Low</option>
                                        <option value="High">High</option>
                                        <option value="Medium">Medium</option>


                                        @endif
                                        @else
                                        <option value="">Please Select Open</option>
                                        <option value="High">High</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Low">Low</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm ">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="fs-17 font-weight-600 mb-0"><b>Control Framework</b></label>
                                </div>
                            </div>
                        </div>
                        <hr style="margin-top:-10px;">
                        <div class="row row-sm">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Whether Key Control</label>
                                    <select name="whether_key" class="form-control">
                                        <!--placeholder-->
                                        @if(Request::is('ifc/*/edit')) >
                                        @if($ifc->whether_key=='Yes')
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>

                                        @else
                                        <option value="No">No</option>
                                        <option value="Yes">Yes</option>
                                      

                                        @endif
                                        @else
                                        <option value="">Please Select Open</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Automated/Manual</label>
                                    <select name="automated_manual" class="form-control">
                                        <!--placeholder-->
                                        @if(Request::is('ifc/*/edit')) >
                                        @if($ifc->automated_manual=='Automated')
                                        <option value="Automated">Automated</option>
                                        <option value="Manual">Manual</option>
                                        <option value="Automated+Manual">Automated+Manual</option>

                                        @elseif($template->automated_manual=='Manual')
                                        <option value="Manual">Manual</option>
                                        <option value="Automated">Automated</option>
                                        <option value="Automated+Manual">Automated+Manual</option>

                                        @else
                                        <option value="Automated">Automated</option>
                                        <option value="Manual">Manual</option>
                                        <option value="Automated+Manual">Automated+Manual</option>

                                        @endif
                                        @else
                                        <option value="">Please Select Open</option>
                                        <option value="Automated">Automated</option>
                                        <option value="Manual">Manual</option>
                                        <option value="Automated+Manual">Automated+Manual</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Preventive/Detective</label>
                                    <select name="preventive_detective" class="form-control">
                                        <!--placeholder-->
                                        @if(Request::is('ifc/*/edit')) >
                                        @if($ifc->preventive_detective=='Preventive')
                                        <option value="Preventive">Preventive</option>
                                        <option value="Detective">Detective</option>

                                        @else
                                        <option value="Detective">Detective</option>
                                        <option value="Preventive">Preventive</option>
                                        

                                        @endif
                                        @else
                                        <option value="">Please Select Open</option>
                                        <option value="Preventive">Preventive</option>
                                        <option value="Detective">Detective</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Control Frequency</label>
                                    <select name="control_frequency" class="form-control">
                                        <option value="">Please Select Open</option>
                                        <option value="Daily">Daily</option>
                                        <option value="Weekly">Weekly</option>
                                        <option value="Fortnightly">Fortnightly</option>
                                        <option value="Monthly">Monthly</option>
                                        <option value="Quarterly">Quarterly</option>
                                        <option value="Half-Yearly">Half-Yearly</option>
                                        <option value="Yearly">Yearly</option>
                                        <option value="Event Basedy">Event Based</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Concerned person & Dept</label>
                                    <input type="text"  name="concerned_person"
                                        placeholder="Enter Name, Desgination, Department" class="form-control"
                                        value="" />
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm ">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="fs-17 font-weight-600 mb-0"><b>Design Gap</b></label>
                                </div>
                            </div>
                        </div>
                        <hr style="margin-top:-10px;">
                        <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Process Design Gap </label>
                                    <select name="process_design_gap" class="form-control" onchange='CheckColors(this.value);'>
                                        <option value="">Please select one</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-6" id="yes" style='display:none;'>
                                <div class="form-group">
                                    <label class="font-weight-600">Design Gap</label>
                                    <input type="text"  name="design_gap" class="form-control" value="" />
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm ">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="fs-17 font-weight-600 mb-0"><b>Test of Operating
                                            Effectiveness</b></label>
                                </div>
                            </div>
                        </div>
                        <hr style="margin-top:-10px;">
                        <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Methodology</label>
                                    <input type="text"  name="Methodology" placeholder="" class="form-control" value="" />
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm ">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="fs-17 font-weight-600 mb-0" style=" text-decoration: underline;">Add
                                        Document </label>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="field_wrapper">
                            <div class="row row-sm ">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="font-weight-600">File Name</label>
                                        <input type="text" class="form-control key" name="file_name[]" id="key" value=""
                                            placeholder="Enter File Name">
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <label class="font-weight-600">Attachment </label>
                                        <input type="file" class="form-control key" name="file[]" id="key"
                                            value="">
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
                        <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Result</label>
                                    <select name="Result" class="form-control">
                                        <!--placeholder-->
                                        @if(Request::is('ifc/*/edit')) >
                                        @if($ifc->Result=='Effective')
                                        <option value="Effective">Effective</option>
                                        <option value="Ineffective">Ineffective</option>

                                        @else
                                        <option value="Effective">Effective</option>
                                        <option value="Ineffective">Ineffective</option>

                                        @endif
                                        @else
                                        <option value="Effective">Effective</option>
                                        <option value="Ineffective">Ineffective</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Recommendations</label>
                                    <input type="text"  name="Recommendations" placeholder="Enter Recommendations"
                                        class="form-control" value="" />
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Remarks</label>
                                    <textarea type="text"  name="Remarks" placeholder="Enter Remarks"
                                        class="form-control" rows="5" value="" /></textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Management Comments</label>
                                    <textarea type="text"  name="Management_Comments" placeholder="Enter Management Comments"
                                        class="form-control" rows="5" value="" /></textarea>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
                            <a class="btn btn-secondary" href="{{ url('ifcfolders') }}">
                                back</a>

                        </div>
                </div>
            </div>
            </form>

        </div>
        @endif
    </div>

</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML ='<div class="row row-sm "><div class="col-6"><div class="form-group"><label class="font-weight-600">File Name </label><input type="text" class="form-control key" name="file_name[]" id="key" value=""  placeholder="Enter File Name"></div></div><div class="col-5"> <div class="form-group"> <label class="font-weight-600">Attachment * </label>  <input type="file" class="form-control key" name="file[]" id="key" value="" > </div> </div><a style="margin-top: 36px;" href="javascript:void(0);" class="remove_button"><img src="{{ url('backEnd/image/remove-icon.png')}}"/></a></div></div>'; //New input field html 
        var x = 1; //Initial field counter is 1

        //Once add button is clicked
        $(addButton).click(function () {
            //Check maximum number of input fields
            if (x < maxField) {
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function (e) {
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });

</script>
<script>
    function CheckColors(val) {
        var element = document.getElementById('yes');
        if (val == 'payment' || val == 'Yes')
            element.style.display = 'block';
        else
            element.style.display = 'none';


    }

</script>


@endsection
