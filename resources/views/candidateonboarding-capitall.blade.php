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
                                <h4 style="color: white" class="fs-17 font-weight-600 mb-0">CANDIDATE
                                    ONBOARDING FORM</h4>
                            </div>

                        </div>
                        <div class="card-body p-md-5">

                            <form method="POST" action="{{ url('candidateonboarding/store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                @component('backEnd.components.alert')
                                @endcomponent
                                <b style="font-weight: 800;font-size: 18px; ">Candidate Details</b>
                                <hr>
                                <div class="row row-sm">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="font-weight-600">Your Full Name *</label>
                                            <input type="text" required name="your_full_name" class="form-control"
                                                placeholder="Your Full Name" value="" />
                                        </div>
                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="font-weight-600">Personal Email ID *</label>
                                            <input type="email" required name="personal_email" class="form-control"
                                                placeholder="Personal Email Id" value="" />
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="font-weight-600">Resume <span>*</span></label>
                                            <input type="file" required name="resume" class="form-control"
                                                value="" />

                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="font-weight-600">Mobile No. <span>*</span></label>
                                            <input type="number" name="phoneno" required placeholder="Enter Phone No"
                                                class="form-control" value="" />

                                        </div>
                                    </div>
                                </div>
                                <div class="row row-sm">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Date Of Birth *</label>
                                            <input type="date" required name="dateofbirth" class="form-control"
                                                placeholder="Your Date Of Birth" value="" />
                                        </div>
                                    </div>


                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Highest Qualification. <span>*</span></label>
                                            <input type="text" name="highestqualification" required
                                                placeholder="Enter Highest Qualification" class="form-control"
                                                value="" />

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

                                    
                                </div>
                                <div class="row row-sm">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Linkedin Profile Link</label>
                                            <!--placeholder-->
                                            <input id="linkedin" placeholder="Linkedin Profile Link" type="text" name="linkedin"
                                                class="form-control" value="" />
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">NDA (Non-Disclosure Agreement) *</label>
                                            <input type="file" name="nda" required class="form-control"
                                                value="" />
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600"> NDA</label><br>
                                            <a download href="{{ url('backEnd/NDA-Capitall.pdf') }}"
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

                                    <div class="col-3" id="pfform" style="display: none">
                                        <div class="form-group">
                                            <label class="font-weight-600"> PF Form 11.*</label><br>
                                            <a download href="{{ url('backEnd/pfform.pdf') }}"
                                                class="btn btn-success btn"> <i class="fa fa-file-pdf-o"></i>
                                                Download</a>
                                        </div>
                                    </div>
                                    <div class="col-3" id="pfformupload" style="display: none">
                                        <div class="form-group">
                                            <label class="font-weight-600"> PF Form 11.*</label><br>
                                            <input id="pfformuploads" type="file" name="pfformupload"
                                                class="form-control" value="" />

                                        </div>
                                    </div>
                                    <div class="col-3" id="uan" style="display: none">
                                        <div class="form-group">
                                            <label class="font-weight-600"> UAN No.*</label><br>
                                            <input type="number" id="uans" name="uan"
                                                placeholder="Enter UAN No" class="form-control" value="" />

                                        </div>
                                    </div>
                                    <div class="col-3" id="out" style="display: none">
                                        <div class="form-group">
                                            <label class="font-weight-600"> Opt Out - PF Declaration </label><br>
                                            <a download href="{{ url('backEnd/optDeclaration.pdf') }}"
                                                class="btn btn-success btn"> <i class="fa fa-file-pdf-o"></i>
                                                Download</a>
                                        </div>
                                    </div>
                                    <div class="col-3" id="outupload" style="display: none">
                                        <div class="form-group">
                                            <label class="font-weight-600"> Opt Out - PF Declaration </label><br>
                                            <input id="outuploads" type="file" name="outupload"
                                                class="form-control" value="" />

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
                                <b style="font-weight: 800;font-size: 18px; ">Educational
                                    Documents</b>
                                <hr>
                                <div class="row row-sm">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="font-weight-600">Marksheet of X*</label>
                                            <input type="file" required name="marksheet_x" class="form-control"
                                                value="" />

                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="font-weight-600">Marksheet of XII*</label>
                                            <input type="file" required name="marksheet_xii" class="form-control"
                                                value="" />

                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="font-weight-600">Degree of Bachelors*</label>
                                            <input type="file" required name="bachelor_degree"
                                                class="form-control" value="" />

                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="font-weight-600">Degree of Masters</label>
                                            <input type="file" name="master_degree" class="form-control"
                                                value="" />

                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="row row-sm">

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="font-weight-600">Marksheet of CA IPCC (Applicable for
                                                Chartered Accountants)</label>
                                            <input type="file" name="marksheet_ipcc" class="form-control"
                                                value="" />

                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="font-weight-600">Marksheet of CA Final (Applicable for
                                                Chartered Accountants)</label>
                                            <input type="file" name="ca_final" class="form-control"
                                                value="" />

                                        </div>
                                    </div>
                                </div> --}}
                                <div class="row row-sm">
                                    {{-- <div class="col-6">
                                        <div class="form-group">
                                            <label class="font-weight-600">Membership Certificate (Applicable for
                                                Chartered Accountants)</label>
                                            <input type="file" name="membership_certificate" class="form-control"
                                                value="" />
                                        </div>
                                    </div> --}}
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="font-weight-600">Additional Qualifications certificate if
                                                any</label>
                                            <input type="file" name="addidation_qualification"
                                                class="form-control" value="" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="font-weight-600">Photograph*</label>
                                            <input type="file" required name="photograph" class="form-control"
                                                value="" />
                                        </div>
                                    </div>

                                </div>
                                <div class="row row-sm">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="font-weight-600">Offer Letter/Appointment Letter of
                                                current/last organisation</label>
                                            <input type="file" name="offerappointmentletter" class="form-control"
                                                value="" />
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="font-weight-600">Experience letter/Relieving letter of last
                                                organisation </label>
                                            <input type="file" name="relieving_letter" class="form-control"
                                                value="" />
                                        </div>
                                    </div>

                                </div>
                                <div class="row row-sm">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="font-weight-600">PAN Card No*</label>
                                            <input type="text" pattern="[A-Za-z]{5}\d{4}[A-Za-z]{1}" required
                                                name="pancardno" id="pan" oninvalid="invalidPan()"
                                                class="form-control" placeholder="Enter PAN No" maxlength="10" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="font-weight-600">PAN Card*</label>
                                            <input type="file" required name="pancard" class="form-control"
                                                value="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row row-sm">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="font-weight-600">Aadhar Card No*</label>
                                            <input type="number" required name="adharcardno" id="aadhar"
                                                min="100000000000" max="999999999999" oninvalid="invalidAadhar()"
                                                class="form-control" placeholder="Enter Aadhar No" value="">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="font-weight-600">Aadhar Card*</label>
                                            <input type="file" required name="aadharcard" class="form-control"
                                                value="" />
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <b style="font-weight: 800;font-size: 18px; "> Payslips of last 3 months of
                                    current/last
                                    organisation</b>
                                <hr>
                                <div class="row row-sm">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Payslips 1 </label>
                                            <input type="file" name="payslipsone" class="form-control"
                                                value="" />
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Payslips 2 </label>
                                            <input type="file" name="payslipstwo" class="form-control"
                                                value="" />
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Payslips 3 </label>
                                            <input type="file" name="payslipsthree" class="form-control"
                                                value="" />
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <b style="font-weight: 800;font-size: 18px; "> Two Residence Proof *</b>
                                <hr>
                                <div class="row row-sm">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="font-weight-600">Temporary Residence Proof *</label>
                                            <input type="file" required name="residence_proofone"
                                                class="form-control" value="" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="font-weight-600">Permanent Residence Proof *</label>
                                            <input type="file" required name="residence_prooftwo"
                                                class="form-control" value="" />
                                        </div>
                                    </div>

                                </div>
                                <br>
                                <b style="font-weight: 800;font-size: 18px; "> Bank Account Details</b>
                                <hr>
                                <div class="row row-sm">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Your name as per the Bank Account *</label>
                                            <input type="text" required name="bankholder_name"
                                                class="form-control" placeholder="Your name as per the Bank Account"
                                                value="" />

                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Name of Bank*</label>
                                            <input type="text" required name="bank_name" class="form-control"
                                                placeholder="Enter Name of Bank" value="" />

                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Account Number*</label>
                                            <input type="number" required name="account_number" class="form-control"
                                                placeholder="Enter Account Number" value="" />

                                        </div>
                                    </div>
                                </div>
                                <div class="row row-sm">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">IFSC Code *</label>
                                            <input type="text" required name="ifsc_code" class="form-control"
                                                placeholder="Enter IFSC Code" value="" />

                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Branch *</label>
                                            <input type="text" required name="branch" class="form-control"
                                                placeholder="Enter Branch" value="" />

                                        </div>
                                    </div>
                                </div>
                                <br>
                                <b style="font-weight: 800;font-size: 18px; ">Emergency Detail *</b>
                                <hr>
                                <div class="row row-sm">

                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Emergency Contact Number</label>
                                            <input type="number" required name="emergency_contact_number"
                                                class="form-control" placeholder="Enter Number" value="" />

                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Father Name</label>
                                            <input type="text" required name="father_name" class="form-control"
                                                placeholder="Enter Father Name" value="" />

                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Father Contact No.</label>
                                            <input type="number" required name="fathercontactno"
                                                class="form-control" placeholder="Enter Father Contact No."
                                                value="" />

                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Mother Name</label>
                                            <input type="text" required name="mother_name" class="form-control"
                                                placeholder="Enter Mother Name" value="" />

                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Mother Contact No</label>
                                            <input type="number" required name="mothecontactno" class="form-control"
                                                placeholder="Enter Mother Contact No" value="" />

                                        </div>
                                    </div>
                                </div>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#providend').on('change', function() {
            if (this.value == '0') {
                $("#out").hide();
                $("#outupload").hide();
                $("#pfform").show();
                $("#pfformupload").show();
                document.getElementById("pfformuploads").required = true;
                $("#uan").show();
                document.getElementById("uans").required = true;

            } else if (this.value == '1') {
                $("#out").show();
                $("#outupload").show();
                document.getElementById("outuploads").required = true;
                $("#pfform").hide();
                $("#pfformupload").hide();
                $("#uan").hide();
            } else if (this.value == '2') {
                $("#out").hide();
                $("#outupload").hide();
                $("#pfform").hide();
                $("#pfformupload").hide();
                $("#uan").hide();
                document.getElementById("outuploads").required = false;
                document.getElementById("pfformuploads").required = false;
                document.getElementById("uans").required = false;

            } else if (this.value == null) {
                $("#out").hide();
                $("#pfform").hide();
                $("#pfformupload").hide();
                $("#uan").hide();
                $("#outupload").hide();
                document.getElementById("providend").required = true;
            }
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

</html>
