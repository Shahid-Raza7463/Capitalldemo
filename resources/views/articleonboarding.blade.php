<!doctype html>
<html lang="en">

<head>
    <!--  meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body style="background-image:url('backEnd/image/unnamed.jpg');">
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-12 col-xl-12">
                    <div class="card shadow-2-strong card-registration">
                        <div class="card-header" style="background: #37A000;">

                            <div style="text-align: center;">
                                <h4 style="color: white" class="fs-17 font-weight-600 mb-0">ARTICLE
                                    ONBOARDING FORM</h4>
                            </div>

                        </div>
                        <div class="card-body p-md-5">

                            <form method="POST" action="{{ url('articleonboardingform/store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                @component('backEnd.components.alert')
                                @endcomponent
                                <b style="font-weight: 800;font-size: 18px; ">Personal Details</b>
                                <hr>
                                <div class="row row-sm">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Name *</label>
                                            <input type="text" required name="name" value=""
                                                class="form-control" placeholder="Enter Name">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Contact No. *</label>
                                            <input type="number" required name="contactno"
                                                value="{{ $articlefiles->mothersname ?? '' }}" class="form-control"
                                                placeholder="Enter Contact Number">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Email Id *</label>
                                            <input type="email" required name="emailid"
                                                value="{{ $articlefiles->dob ?? '' }}" class="form-control"
                                                placeholder="Enter Email">
                                        </div>
                                    </div>
                                </div>

                                <div class="row row-sm">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">CRO/NRO No. *</label>
                                            <input type="text" required name="cro_nro_no" value=""
                                                class="form-control" placeholder="Enter CRO/NRO No.">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Date Of Birth. *</label>
                                            <input type="date" required name="dob"
                                                value="{{ $articlefiles->dob ?? '' }}" class="form-control"
                                                placeholder="Enter Date of Birth">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Gender *</label>
                                            <select required name="gender" class="form-control">
                                                <!--placeholder-->

                                                <option value="">Please Select One</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>

                                            </select>
                                        </div>
                                    </div>
                                    {{-- <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Date Of Joining. *</label>
                                            <input type="date" required name="doj"
                                                value="{{ $articlefiles->doj ?? '' }}" class="form-control"
                                                placeholder="Enter Date of Joining">
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="row row-sm">



                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="font-weight-600">Linkedin Profile Link </label>
                                            <!--placeholder-->
                                            <input id="linkedin" placeholder=" Linkedin Profile Link" type="text"
                                                name="linkedin" class="form-control" value="" />
                                        </div>
                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="font-weight-600">Qualification *</label>
                                            <select required name="qualification" class="form-control">
                                                <!--placeholder-->

                                                <option value="">Please Select One</option>
                                                <option value="Intermediate - Single Group">Intermediate - Single Group
                                                </option>
                                                <option value="Intermediate - Both Group">Intermediate - Both Group
                                                </option>
                                                <option value="Direct Entry">Direct Entry</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">NDA (Non-Disclosure Agreement) *</label>
                                            <input type="file" name="nda" required class="form-control"
                                                value="" />
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label class="font-weight-600"> NDA</label><br>
                                            <a download href="{{ url('backEnd/NDA-Trainee.pdf') }}"
                                                class="btn btn-success btn"> <i class="fa fa-file-pdf-o"></i>
                                                Download</a>
                                        </div>
                                    </div>



                                </div>
                                <div class="row row-sm">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="font-weight-600">Current Address <span>*</span></label>
                                            <textarea rows="3" name="currentaddress" required class="form-control"
                                                placeholder="Enter Full Address With Pin Code"></textarea>
                                        </div>

                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="font-weight-600">Permanent Address <span>*</span></label>
                                            <textarea rows="3" name="permanentaddress" required class="form-control"
                                                placeholder="Enter Full  Permanent Address With Pin Code"></textarea>
                                        </div>

                                    </div>
                                </div>

                               
                                <div class="row row-sm">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="font-weight-600">Brief About Yourself <span>*</span></label>
                                            <textarea rows="3" name="about" required class="form-control" placeholder="Enter Brief About Yourself "></textarea>
                                        </div>

                                    </div>
                                </div>



                                <br>
                                <b style="font-weight: 800;font-size: 18px; ">Emergency Details</b>
                                <hr>
                                <div class="row row-sm">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Emergency Contact Number *</label>
                                            <input type="number" required name="emergency_contact_number"
                                                class="form-control" placeholder="Enter Number" value="" />

                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Name Of Father. *</label>
                                            <input type="text" required name="fathersname" id="key"
                                                value="" class="form-control"
                                                placeholder="Enter Name Of Father.">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Contact Of Father. *</label>
                                            <input type="number" required name="emergencycontactnumber"
                                                id="key" value="" class="form-control"
                                                placeholder="Enter Contact Of Father">
                                        </div>
                                    </div>
                                </div>
                                <div class="row row-sm">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Name Of Mother. *</label>
                                            <input type="text" required name="mothersname" id="key"
                                                value="" class="form-control"
                                                placeholder="Enter Name of Mother.">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Contact of Mother. *</label>
                                            <input type="number" required name="emergencycontactnumbertwo"
                                                id="key" value="" class="form-control"
                                                placeholder="Enter Contact of Mother">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <b style="font-weight: 800;font-size: 18px; ">Previous Training Details</b>
                                <hr>
                                <div class="field_wrapper">
                                    <div class="row row-sm">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label class="font-weight-600">Name of Previous Organization Form
                                                </label>
                                                <input type="text" name="previous_organization_form[]"
                                                    id="key" value="" class="form-control"
                                                    placeholder="Enter Name of Previous Organization Form.">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label class="font-weight-600">Date of Joining </label>
                                                <input type="date" name="date_of_joining[]" id="key"
                                                    value="" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="font-weight-600">Date of Leaving </label>
                                                <input type="date" name="date_of_leaving[]" id="key"
                                                    value="" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="form-group" style="margin-top: 36px;">
                                                <a href="javascript:void(0);" class="add_button"
                                                    title="Add field"><img
                                                        src="{{ url('backEnd/image/add-icon.png') }}" /></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <b style="font-weight: 800;font-size: 18px; ">Documents</b>
                                <hr>
                                <div class="row row-sm">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Mark Sheet Of 10th. *</label>
                                            <input type="file" required name="document10th"
                                                value="{{ $articlefiles->document10th ?? '' }}" class="form-control"
                                                placeholder="Enter Financial Year .">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Mark Sheet Of 12th. *</label>
                                            <input type="file" required name="document12th"
                                                value="{{ $articlefiles->document12th ?? '' }}" class="form-control"
                                                placeholder="Enter Financial Year .">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Degree Of Bachelor * </label>
                                            <select name="documentbachelor" required id="documentbachelor"
                                                class="form-control">

                                                <option value="">Please Select One</option>
                                                <option value="0">Pursuing</option>
                                                <option value="1">Not Pursuing</option>
                                                <option value="2">Completed</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row row-sm">
                                    <div class="col-4" id="bachelorcertificate" style="display: none">
                                        <div class="form-group">
                                            <label class="font-weight-600">Type of Course </label>
                                            <select name="documentbcom" id="documentbcom" class="form-control">

                                                <option value="">Please Select One</option>
                                                <option value="0">Regular</option>
                                                <option value="1">Distance</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4" id="bcomcertificate" style="display: none">
                                        <div class="form-group">
                                            <label class="font-weight-600">Mark Sheet </label>
                                            <input type="file" name="bcomcertificate"
                                                value="{{ $articlefiles->ipcccertificate ?? '' }}"
                                                class="form-control" placeholder="Enter Financial Year .">
                                        </div>
                                    </div>
                                    <div class="col-4" id="noc" style="display: none">
                                        <div class="form-group">
                                            <label class="font-weight-600">NOC </label>
                                            <input type="file" name="noc"
                                                value="{{ $articlefiles->ipcccertificate ?? '' }}"
                                                class="form-control" placeholder="Enter Financial Year .">
                                        </div>
                                    </div>
                                </div>
                                <div class="row row-sm">
                                    <div class="col-4" id="bachelorattached" style="display: none">
                                        <div class="form-group">
                                            <label class="font-weight-600">Attached Degree Mark Sheet </label>
                                            <input type="file" name="bachelorattached" value=""
                                                class="form-control" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row row-sm">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Foundation Marksheet</label>
                                            <input type="file" name="cptcertificate"
                                                value="{{ $articlefiles->cptcertificate ?? '' }}" class="form-control"
                                                placeholder="Enter Financial Year .">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">IPCC Group 1 Marksheet</label>
                                            <input type="file" name="ipcccertificate"
                                                value="{{ $articlefiles->ipcccertificate ?? '' }}"
                                                class="form-control" placeholder="Enter Financial Year .">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">IPCC Group 2 Marksheet</label>
                                            <input type="file" name="ipcccertificatetwo"
                                                value="{{ $articlefiles->ipcccertificate ?? '' }}"
                                                class="form-control" placeholder="Enter Financial Year .">
                                        </div>
                                    </div>

                                </div>
                                <div class="row row-sm">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">OC Training certificate. * </label>
                                            <input type="file" required name="octrainingcertificate"
                                                value="{{ $articlefiles->octrainingcertificate ?? '' }}"
                                                class="form-control" placeholder="Enter Financial Year.">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">ITT Training Certificate. * </label>
                                            <input type="file" required name="itttrainingcertificate"
                                                value="{{ $articlefiles->itttrainingcertificate ?? '' }}"
                                                class="form-control" placeholder="Enter Period of Appointment .">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Photograph. * </label>
                                            <input type="file" required name="photograph"
                                                value="{{ $articlefiles->photograph ?? '' }}" class="form-control"
                                                placeholder="Enter Financial Year .">
                                        </div>
                                    </div>
                                </div>
                                <div class="row row-sm">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Pan No *</label>
                                            <input type="text" pattern="[A-Za-z]{5}\d{4}[A-Za-z]{1}" required
                                                name="pancardno" id="pan" oninvalid="invalidPan()"
                                                class="form-control" value="{{ $articlefiles->pancardno ?? '' }}"
                                                placeholder="Enter PAN No" maxlength="10" />
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Pan Card *</label>
                                            <input type="file" name="pancard"
                                                value="{{ $articlefiles->pancard ?? '' }}" class="form-control"
                                                placeholder="Enter Financial Year .">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Aadhar Card No*</label>
                                            <input type="number" required name="aadharno" id="aadhar"
                                                min="100000000000" max="999999999999" oninvalid="invalidAadhar()"
                                                class="form-control" placeholder="Enter Aadhar No" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row row-sm">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Aadhar Card *</label>
                                            <input type="file" name="aadharcard"
                                                value="{{ $articlefiles->aadharcard ?? '' }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Temporary Residence Proof *</label>
                                            <input type="file" required name="residenceproof"
                                                value="{{ $articlefiles->residenceproof ?? '' }}"
                                                class="form-control" placeholder="Enter Period of Appointment .">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Permanent Residence Proof *</label>
                                            <input type="file" required name="residenceprooftwo"
                                                value="{{ $articlefiles->residenceprooftwo ?? '' }}"
                                                class="form-control" placeholder="Enter Period of Appointment .">
                                        </div>
                                    </div>

                                </div>
                                <div class="row row-sm">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Additional Qualification Certificate / If
                                                Any </label>
                                            <input type="file" name="additional"
                                                value="{{ $articlefiles->photograph ?? '' }}" class="form-control"
                                                placeholder="Enter Financial Year .">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Copy of 102 Form </label>
                                            <input type="file" name="copyof"
                                                value="{{ $articlefiles->copyof ?? '' }}" class="form-control"
                                                placeholder="Enter Branch .">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Copy of 103 Form </label>
                                            <input type="file" name="copyoftwo"
                                                value="{{ $articlefiles->copyof ?? '' }}" class="form-control"
                                                placeholder="Enter Branch .">
                                        </div>
                                    </div>

                                </div>
                                <br>
                                <b style="font-weight: 800;font-size: 18px;">Bank Account Details</b>
                                <hr>
                                <div class="row row-sm">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Bank Account Holder Name </label>
                                            <input type="text" required name="accountholder"
                                                value="{{ $articlefiles->accountholder ?? '' }}" class="form-control"
                                                placeholder="Enter Bank Account Holder Name  .">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Bank Account Name </label>
                                            <input type="text" required name="accountname"
                                                value="{{ $articlefiles->accountname ?? '' }}" class="form-control"
                                                placeholder="Enter Bank Account Name .">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Bank Account Number</label>
                                            <input type="text" required name="accountnumber"
                                                value="{{ $articlefiles->accountnumber ?? '' }}" class="form-control"
                                                placeholder="Enter Bank Account Number .">
                                        </div>
                                    </div>
                                </div>
                                <div class="row row-sm">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">IFSC Code </label>
                                            <input type="text" required name="ifsccode"
                                                value="{{ $articlefiles->ifsccode ?? '' }}" class="form-control"
                                                placeholder="Enter IFSC Code .">
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Branch Name</label>
                                            <input type="text" required name="branch"
                                                value="{{ $articlefiles->branch ?? '' }}" class="form-control"
                                                placeholder="Enter Branch .">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="mt-4 pt-2">
                                    <button type="submit" class="btn btn-success btn-block">SAVE</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#documentbachelor').on('change', function() {
            if (this.value == '0') {
                $("#bachelorcertificate").show();
                document.getElementById("bachelorcertificate").required = true;
                $("#bachelorattached").hide();
            } else if (this.value == '2') {
                $("#bachelorattached").show();
                document.getElementById("bachelorattached").required = true;
                $("#bachelorcertificate").hide();
                $("#bcomcertificate").hide();
                $("#noc").hide();
            } else {
                $("#bachelorattached").hide();
                $("#bachelorcertificate").hide();
                $("#bcomcertificate").hide();
                $("#noc").hide();
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#documentbcom').on('change', function() {
            if (this.value == '0') {
                $("#bcomcertificate").show();
                $("#noc").show();
                document.getElementById("bcomcertificate").required = true;
                document.getElementById("noc").required = true;
            } else if (this.value == '1') {
                $("#bcomcertificate").show();
                document.getElementById("bcomcertificate").required = true;
                $("#noc").hide();
            } else {
                $("#bcomcertificate").hide();
                $("#noc").hide();
            }
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML =
            '<div class="row row-sm "><div class="col-4"><div class="form-group"><label class="font-weight-600">Name of Previous Organization Form *</label><input type="text" class="form-control key" name="previous_organization_form[]" id="key" value=""  placeholder="Enter name of Previous organization Form"></div></div><div class="col-4"> <div class="form-group"> <label class="font-weight-600">Date of Joining * </label>  <input type="date" class="form-control key" name="date_of_joining[]" id="key" value=""  placeholder=""> </div> </div><div class="col-3"> <div class="form-group"> <label class="font-weight-600"> Date of Leaving *</label> <input type="date" class="form-control key" name="date_of_leaving[]" id="key" value=""  placeholder="">    </div> </div><a style="margin-top: 36px;" href="javascript:void(0);" class="remove_button"><img src="{{ url('backEnd/image/remove-icon.png') }}"/></a></div></div>'; //New input field html 
        var x = 1; //Initial field counter is 1

        //Once add button is clicked
        $(addButton).click(function() {
            //Check maximum number of input fields
            if (x < maxField) {
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e) {
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });

    function invalidAadhar() {
        // Get the input field and error message elements
        var aadharInput = document.getElementById('aadhar');

        // Check if the input value is not exactly 12 digits
        if (aadharInput.value.length !== 12) {
            // Display an error message
            aadharInput.setCustomValidity("Aadhar number must be exactly 12 digits");
        } else {
            // Clear the error message
            aadharInput.setCustomValidity("");
        }
    }

    function invalidPan() {
        var panInput = document.getElementById("pan");
        if (panInput.validity.patternMismatch) {
            panInput.setCustomValidity("Please enter a valid PAN card number");
        } else {
            panInput.setCustomValidity("");
        }
    }
</script>
