<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')
    <!--Content Header (Page header)-->
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Home</h1>
                    <small> Candidate Onboarding List</small>
                </div>
            </div>
        </div>
    </div>
    <!--/.Content Header (Page header)-->
    <div class="body-content">
        <div class="card mb-4">

            <div class="card-body">
                @component('backEnd.components.alert')
                @endcomponent
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-manager"
                            role="tab" aria-controls="pills-manager" aria-selected="true">Candidate</a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" id="pills-user-tab" data-toggle="pill" href="#pills-article" role="tab"
                            aria-controls="pills-article" aria-selected="false">Article </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-user-tab" data-toggle="pill" href="#pills-interns" role="tab"
                            aria-controls="pills-interns" aria-selected="false">Intern</a>
                    </li>

                </ul>

                <br>
                <hr>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-manager" role="tabpanel"
                        aria-labelledby="pills-home-tab">
                        <div class="table-responsive example">
                            <form method="post">
                                @csrf
                                <div class="table-responsive">
                                    <table id="examplee" class="display nowrap">
                                        <thead>
                                            <tr>
                                                <th style="display: none;">id</th>
                                                @if (Auth::user()->role_id == 18 || Auth::user()->teammember_id == 434)
                                                    <th>Action</th>
                                                @endif
                                                <th>Submission Date</th>
                                                <th>Joining Date</th>
                                                <th> Full Name</th>
                                                <th> Date Of Birth </th>
                                                <th> Highest Qualification</th>
                                                <th> Membership Number (If CA/CMA/CS). </th>
                                                <th> Role </th>
                                                <th> Department </th>
                                                <th>Personal Email ID</th>
                                                <th>Phone No</th>
                                                <th>Designation</th>
                                                <th>Adhar Card No</th>
                                                <th>Current Address</th>
                                                <th>Permanent Address</th>
                                                <th>Resume</th>
                                                <th>NDA (Non-Disclosure Agreement)</th>
                                                <th>Providend Fund Applicable</th>
                                                <th>PF Form 11</th>
                                                <th>UAN No.</th>
                                                <th>Opt Out - PF Declaration</th>
                                                <th>Marksheet of X</th>
                                                <th>Marksheet of XII</th>
                                                <th>Degree of Bachelors</th>
                                                <th>Degree of Masters</th>
                                                <th>Marksheet of CA IPCC</th>
                                                <th>Marksheet of CA Final</th>
                                                <th>Membership Certificate</th>
                                                <th>Additional Qualifications certificate if any</th>
                                                <th>Offer Letter/Appointment Letter of current/last organisation</th>
                                                <th>Payslips 1</th>
                                                <th>Payslips 2</th>
                                                <th>Payslips 3</th>
                                                <th>Experience letter/Relieving letter of last organisation</th>
                                                <th>Residence Proof 1</th>
                                                <th>Residence Proof 2</th>
                                                <th>PAN Number</th>
                                                <th>PAN Card</th>
                                                <th>Photograph</th>
                                                <th>Your name as per the Bank Account </th>
                                                <th>Name of Bank</th>
                                                <th>Account Number</th>
                                                <th>IFSC Code</th>
                                                <th>Branch</th>
                                                <th>Emergency Contact Numbe</th>
                                                <th>Father Name</th>
                                                <th>Father Contact No.</th>
                                                <th>Mother Name</th>
                                                <th>Mother Contact No</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($candidateDatasManager as $candidateData)
                                                <tr>
                                                    <td style="display: none;">{{ $candidateData->id }}</td>
                                                    @if (Auth::user()->role_id == 18 || Auth::user()->teammember_id == 434)
                                                        <td> <a class="btn btn-success"
                                                                onclick="return confirm('Are you sure you want to convert this item?');"
                                                                href="{{ url('candidateconvert/') }}/{{ $candidateData->id }}">
                                                                Convert</a> <a id="editCompany"
                                                                data-id="{{ $candidateData->id }}" data-toggle="modal"
                                                                data-target=".bd-example-modal-xl"
                                                                style="color: white;margin-left: 6px;"
                                                                class="btn btn-success">
                                                                Edit</a></td>
                                                    @endif
                                                    <td>{{ date('F d,Y', strtotime($candidateData->created_at)) }}</td>
                                                    <td>{{ date('F d,Y', strtotime($candidateData->dateofjoining)) ?? '' }}
                                                    </td>
                                                    <td> {{ $candidateData->your_full_name ?? '' }}</td>
                                                    <td>
                                                        @if ($candidateData->dateofbirth != null)
                                                            {{ date('F d,Y', strtotime($candidateData->dateofbirth)) }}
                                                        @endif
                                                    </td>
                                                    <td> {{ $candidateData->highestqualification ?? '' }}</td>
                                                    <td> {{ $candidateData->membershipnumber ?? '' }}</td>
                                                    <td> {{ $candidateData->rolename ?? '' }}</td>
                                                    <td>
                                                        @if ($candidateData->department == 1)
                                                            <span>IDT</span>
                                                        @elseif($candidateData->department == 2)
                                                            <span>ASM</span>
                                                        @elseif($candidateData->department == 3)
                                                            <span>Audit</span>
                                                        @elseif($candidateData->department == 4)
                                                            <span>Statutory Audit</span>
                                                        @elseif($candidateData->department == 5)
                                                            <span>Internal Audit</span>
                                                        @elseif($candidateData->department == 6)
                                                            <span>Taxation</span>
                                                        @elseif($candidateData->department == 7)
                                                            <span>Valuation</span>
                                                        @elseif($candidateData->department == 8)
                                                            <span>It</span>
                                                        @elseif($candidateData->department == 9)
                                                            <span>Accounts</span>
                                                        @elseif($candidateData->department == 10)
                                                            <span>Forensic Audit</span>
                                                        @elseif($candidateData->department == 11)
                                                            <span>Administration</span>
                                                        @elseif($candidateData->department == 12)
                                                            <span>Data Management</span>
                                                        @elseif($candidateData->department == 13)
                                                            <span>Digital Marketing</span>
                                                        @elseif($candidateData->department == 14)
                                                            <span>IBC</span>
                                                        @elseif($candidateData->department == 15)
                                                            <span>Direct Taxation</span>
                                                        @elseif($candidateData->department == 16)
                                                            <span>HR</span>
                                                        @else
                                                            <span>Management</span>
                                                        @endif
                                                    </td>
                                                    <td> {{ $candidateData->personal_email }}</td>
                                                    <td> {{ $candidateData->phoneno }}</td>
                                                    <td> {{ $candidateData->designation }}</td>
                                                    <td> {{ $candidateData->adharcardno }}</td>
                                                    <td> {{ $candidateData->currentaddress }}</td>
                                                    <td> {{ $candidateData->permanentaddress }}</td>
                                                    <td><a target="blank"
                                                            href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->resume, now()->addMinutes(30)) }}">
                                                            {{ $candidateData->resume ?? 'Not Uploaded' }} </a></td>

                                                    <td><a target="blank"
                                                            href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->nda, now()->addMinutes(30)) }}">
                                                            {{ $candidateData->nda ?? 'Not Uploaded' }} </a>
                                                    </td>
                                                   <td>
                                                        @if ($candidateData->providend === 0)
                                                            <span>Yes</span>
                                                        @elseif($candidateData->providend === 1)
                                                            <span>No</span>
                                                        @else
                                                            <span>N/A</span>
                                                        @endif
                                                    </td>
                                                    <td><a target="blank"
                                                            href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->pfformupload, now()->addMinutes(30)) }}">
                                                            {{ $candidateData->pfformupload ?? 'Not Uploaded' }} </a>
                                                    </td>
                                                    <td> {{ $candidateData->uan }}</td>
                                                    <td><a target="blank"
                                                            href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->outupload, now()->addMinutes(30)) }}">
                                                            {{ $candidateData->outupload ?? 'Not Uploaded' }} </a>
                                                    </td>
                                                    <td><a target="blank"
                                                            href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->marksheet_x, now()->addMinutes(30)) }}">
                                                            {{ $candidateData->marksheet_x ?? 'Not Uploaded' }} </a>
                                                    </td>
                                                    <td><a target="blank"
                                                            href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->marksheet_xii, now()->addMinutes(30)) }}">
                                                            {{ $candidateData->marksheet_xii ?? 'Not Uploaded' }} </a>
                                                    </td>
                                                    <td><a target="blank"
                                                            href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->bachelor_degree, now()->addMinutes(30)) }}">
                                                            {{ $candidateData->bachelor_degree ?? 'Not Uploaded' }} </a>
                                                    </td>
                                                    <td><a target="blank"
                                                            href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->master_degree, now()->addMinutes(30)) }}">
                                                            {{ $candidateData->master_degree ?? 'Not Uploaded' }} </a> ,
                                                    </td>
                                                    <td><a target="blank"
                                                            href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->marksheet_ipcc, now()->addMinutes(30)) }}">
                                                            {{ $candidateData->marksheet_ipcc ?? 'Not Uploaded' }} </a>
                                                    </td>
                                                    <td><a target="blank"
                                                            href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->ca_final, now()->addMinutes(30)) }}">
                                                            {{ $candidateData->ca_final ?? 'Not Uploaded' }} </a>
                                                    </td>
                                                    <td><a target="blank"
                                                            href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->membership_certificate, now()->addMinutes(30)) }}">
                                                            {{ $candidateData->membership_certificate ?? 'Not Uploaded' }}
                                                        </a>
                                                    </td>
                                                    <td><a target="blank"
                                                            href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->addidation_qualification, now()->addMinutes(30)) }}">
                                                            {{ $candidateData->addidation_qualification ?? 'Not Uploaded' }}
                                                        </a>
                                                    </td>
                                                    <td><a target="blank"
                                                            href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->offerappointmentletter, now()->addMinutes(30)) }}">
                                                            {{ $candidateData->offerappointmentletter ?? 'Not Uploaded' }}
                                                        </a>
                                                    </td>
                                                    <td><a target="blank"
                                                            href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->payslipsone, now()->addMinutes(30)) }}">
                                                            {{ $candidateData->payslipsone ?? 'Not Uploaded' }} </a>
                                                    </td>
                                                    <td><a target="blank"
                                                            href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->payslipstwo, now()->addMinutes(30)) }}">
                                                            {{ $candidateData->payslipstwo ?? 'Not Uploaded' }} </a>
                                                    </td>
                                                    <td><a target="blank"
                                                            href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->payslipsthree, now()->addMinutes(30)) }}">
                                                            {{ $candidateData->payslipsthree ?? 'Not Uploaded' }} </a>
                                                    </td>
                                                    <td><a target="blank"
                                                            href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->relieving_letter, now()->addMinutes(30)) }}">
                                                            {{ $candidateData->relieving_letter ?? 'Not Uploaded' }} </a>
                                                    </td>
                                                    <td><a target="blank"
                                                            href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->residence_proofone, now()->addMinutes(30)) }}">
                                                            {{ $candidateData->residence_proofone ?? 'Not Uploaded' }} </a>
                                                    </td>
                                                    <td><a target="blank"
                                                            href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->residence_prooftwo, now()->addMinutes(30)) }}">
                                                            {{ $candidateData->residence_prooftwo ?? 'Not Uploaded' }} </a>
                                                    </td>
                                                    <td> {{ $candidateData->pancardno }}</td>
                                                    <td><a target="blank"
                                                            href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->pancard, now()->addMinutes(30)) }}">
                                                            {{ $candidateData->pancard ?? 'Not Uploaded' }} </a>
                                                    </td>
                                                    <td><a target="blank"
                                                            href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->photograph, now()->addMinutes(30)) }}">
                                                            {{ $candidateData->photograph ?? 'Not Uploaded' }} </a>
                                                    </td>
                                                    <td> {{ $candidateData->bankholder_name }}</td>
                                                    <td> {{ $candidateData->bank_name }}</td>
                                                    <td> {{ $candidateData->account_number }}</td>
                                                    <td> {{ $candidateData->ifsc_code }}</td>
                                                    <td> {{ $candidateData->branch }}</td>
                                                    <td> {{ $candidateData->emergency_contact_number }}</td>
                                                    <td> {{ $candidateData->father_name }}</td>
                                                    <td> {{ $candidateData->fathercontactno }}</td>
                                                    <td> {{ $candidateData->mother_name }}</td>
                                                    <td> {{ $candidateData->mothecontactno }}</td>

                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>

                            </form>
                        </div>
                    </div>

                    <br>
                    <div class="tab-pane fade" id="pills-article" role="tabpanel" aria-labelledby="pills-user-tab">

                        <div class="table-responsive">
                            <form method="post">
                                @csrf
                                <table id="exampleee" class="display nowrap">
                                    <thead>
                                        <tr>
                                            <th style="display: none;">id</th>
                                            @if (Auth::user()->role_id == 18 || Auth::user()->teammember_id == 434)
                                                <th>Action</th>
                                            @endif
                                            <th>Name</th>
                                            <th>Contact</th>
                                            <th>Email</th>
                                            <th>CRO/NRO No</th>
                                            <th>Date Of Birth</th>
                                            <th>Date Of Joining</th>
                                            <th>Highest Qualification</th>
                                            <th>Father Name</th>
                                            <th>Contact Of Father</th>
                                            <th> Mother Name</th>
                                            <th>Contact Of Mother</th>
                                            <th>Mark Sheet Of 10th</th>
                                            <th>Mark Sheet Of 12th</th>
                                            <th>Degree Of Bachelor</th>

                                            <th>Foundation Marksheet</th>
                                            <th>IPCC Group 1 Marksheet</th>
                                            <th>IPCC Group 2 Marksheet</th>
                                            <th>OC Training Certificate</th>
                                            <th>ITT Training Certificate</th>
                                            <th>Residence Proof 1</th>
                                            <th>Residence Proof 2</th>
                                            <th>Pan number</th>
                                            <th>Pan Card</th>
                                            <th>Aadhar number</th>
                                            <th>Photograph</th>
                                            <th>Copy Of 102 Form</th>
                                            <th>Copy Of 103 Form</th>
                                            <th>Additional qualification Certificate/If Any</th>
                                            <th>Bank Account Holder Name</th>
                                            <th>Bank Account Name</th>
                                            <th>Bank Account Number</th>
                                            <th>IFSC Code</th>
                                            <th>Branch Name</th>
                                            <th>Name of Previous Organization Form</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($candidateDatasArticle as $articlebordingData)
                                            <tr>
                                                <td style="display: none;">{{ $articlebordingData->id }}</td>
                                                @if (Auth::user()->role_id == 18 || Auth::user()->teammember_id == 434)
                                                    <td> <a class="btn btn-success" id="capitallarticle"
                                                            data-toggle="modal" data-id="{{ $articlebordingData->id }}"
                                                            data-target="#exampleModalcred" style="color:white;">
                                                            Convert</a> <a id="editCompany2"
                                                            data-id="{{ $articlebordingData->id }}" data-toggle="modal"
                                                            data-target=".bd-examplee-modal-xl"
                                                            style="color: white;margin-left: 6px;"
                                                            class="btn btn-success">
                                                            Edit</a></td>
                                                @endif

                                                <td> {{ $articlebordingData->name ?? '' }}</td>
                                                <td> {{ $articlebordingData->contactno ?? '' }}</td>
                                                <td> {{ $articlebordingData->emailid ?? '' }}</td>
                                                <td> {{ $articlebordingData->cro_nro_no ?? '' }}</td>
                                                <td> {{ date('F d,Y', strtotime($articlebordingData->dob)) ?? '' }}</td>
                                                <td> {{ date('F d,Y', strtotime($articlebordingData->doj)) ?? '' }}</td>
                                                <td>{{ $articlebordingData->qualification ?? '' }}</td>
                                                <td>{{ $articlebordingData->fathersname ?? '' }}</td>
                                                <td> {{ $articlebordingData->emergencycontactnumber ?? '' }}</td>
                                                <td> {{ $articlebordingData->mothersname ?? '' }}</td>
                                                <td> {{ $articlebordingData->emergencycontactnumbertwo ?? '' }}</td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $articlebordingData->document10th, now()->addMinutes(30)) }}">
                                                        {{ $articlebordingData->document10th ?? 'Not Uploaded' }} </a></td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $articlebordingData->document12th, now()->addMinutes(30)) }}">
                                                        {{ $articlebordingData->document12th ?? 'Not Uploaded' }} </a></td>
                                                <td>
                                                    @if ($articlebordingData->documentbachelor == 0)
                                                        <span class="badge badge-pill badge-warning">Pursuing</span><br>
                                                        <span>Type of Course :
                                                            @if ($articlebordingData->documentbcom == 0)
                                                                <span class="badge badge-pill badge-warning">Regular</span>
                                                                <br>
                                                                <span>Mark Sheet :</span>
                                                                <a target="blank"
                                                                    href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $articlebordingData->bcomcertificate, now()->addMinutes(30)) }}">
                                                                    {{ $articlebordingData->bcomcertificate ?? 'Not Uploaded' }}
                                                                </a><br>
                                                                <span>NOC : </span>
                                                                <a target="blank"
                                                                    href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $articlebordingData->noc, now()->addMinutes(30)) }}">
                                                                    {{ $articlebordingData->noc ?? 'Not Uploaded' }} </a>
                                                            @elseif($articlebordingData->documentbcom == 1)
                                                                <span
                                                                    class="badge badge-pill badge-warning">Distance</span>
                                                                <br><span>Mark Sheet :</span>
                                                                <a target="blank"
                                                                    href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $articlebordingData->bcomcertificate, now()->addMinutes(30)) }}">
                                                                    {{ $articlebordingData->bcomcertificate ?? 'Not Uploaded' }}
                                                                </a>
                                                            @endif
                                                        </span>
                                                    @elseif($articlebordingData->documentbachelor == 1)
                                                        <span class="badge badge-pill badge-success">Not Pursuing</span>
                                                    @elseif($articlebordingData->documentbachelor == 2)
                                                        <span class="badge badge-pill badge-danger">Completed</span>
                                                        <br><span> Attached Degree Mark Sheet : </span> <a target="blank"
                                                            href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $articlebordingData->bachelorattached, now()->addMinutes(30)) }}">
                                                            {{ $articlebordingData->bachelorattached ?? 'Not Uploaded' }}
                                                        </a>
                                                    @endif
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $articlebordingData->cptcertificate, now()->addMinutes(30)) }}">
                                                        {{ $articlebordingData->cptcertificate ?? 'Not Uploaded' }} </a>
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $articlebordingData->ipcccertificate, now()->addMinutes(30)) }}">
                                                        {{ $articlebordingData->ipcccertificate ?? 'Not Uploaded' }} </a>
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $articlebordingData->ipcccertificatetwo, now()->addMinutes(30)) }}">
                                                        {{ $articlebordingData->ipcccertificatetwo ?? 'Not Uploaded' }}
                                                    </a></td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $articlebordingData->octrainingcertificate, now()->addMinutes(30)) }}">
                                                        {{ $articlebordingData->octrainingcertificate ?? 'Not Uploaded' }}
                                                    </a></td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $articlebordingData->itttrainingcertificate, now()->addMinutes(30)) }}">
                                                        {{ $articlebordingData->itttrainingcertificate ?? 'Not Uploaded' }}
                                                    </a></td>

                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $articlebordingData->residenceproof, now()->addMinutes(30)) }}">
                                                        {{ $articlebordingData->residenceproof ?? 'Not Uploaded' }} </a>
                                                </td>

                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $articlebordingData->residenceprooftwo, now()->addMinutes(30)) }}">
                                                        {{ $articlebordingData->residenceprooftwo ?? 'Not Uploaded' }}
                                                    </a>
                                                </td>
                                                <td> {{ $articlebordingData->pancardno }}</td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $articlebordingData->pancard, now()->addMinutes(30)) }}">
                                                        {{ $articlebordingData->pancard ?? 'Not Uploaded' }} </a></td>
                                                <td> {{ $articlebordingData->aadharno }}</td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $articlebordingData->photograph, now()->addMinutes(30)) }}">
                                                        {{ $articlebordingData->photograph ?? 'Not Uploaded' }} </a></td>

                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $articlebordingData->copyof, now()->addMinutes(30)) }}">
                                                        {{ $articlebordingData->copyof ?? 'Not Uploaded' }} </a></td>

                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $articlebordingData->copyoftwo, now()->addMinutes(30)) }}">
                                                        {{ $articlebordingData->copyoftwo ?? 'Not Uploaded' }} </a></td>

                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $articlebordingData->additional, now()->addMinutes(30)) }}">
                                                        {{ $articlebordingData->additional ?? 'Not Uploaded' }} </a></td>

                                                <td> {{ $articlebordingData->accountholder }}</td>
                                                <td> {{ $articlebordingData->accountname }}</td>
                                                <td> {{ $articlebordingData->accountnumber }}</td>
                                                <td> {{ $articlebordingData->ifsccode }}</td>
                                                <td> {{ $articlebordingData->branch }}</td>
                                                <td> <a class="btn btn-success" id="editss" data-toggle="modal"
                                                        data-id="{{ $articlebordingData->id }}"
                                                        data-target="#exampleModal122" style="color: white">View</a></td>


                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </form>
                        </div>

                    </div>
                    <br>
                   <!--end start-->

<div class="tab-pane fade" id="pills-interns" role="tabpanel" aria-labelledby="pills-user-tab">

                        <div class="table-responsive">
                            <form method="post">
                                @csrf
                                <table id="exampleeee" class="display nowrap">
                                    <thead>
                                        <tr>
                                            <th style="display: none;">id</th>
                                            @if (Auth::user()->role_id == 18 || Auth::user()->teammember_id == 434)
                                                <th>Action</th>
                                            @endif
                                            <th>Submission Date</th>
                                            <th>Joining Date</th>
                                            <th> Full Name</th>
                                            <th> Date Of Birth </th>
                                            <th> Highest Qualification</th>
                                            <th> Membership Number (If CA/CMA/CS). </th>
                                            <th> Role </th>
                                            <th> Department </th>
                                            <th>Personal Email ID</th>
                                            <th>Phone No</th>
                                            <th>Designation</th>
                                            <th>Current Address</th>
                                            <th>Permanent Address</th>
                                            <th>Resume</th>
                                            <th>NDA (Non-Disclosure Agreement)</th>
                                            <th>Providend Fund Applicable</th>
                                            <th>PF Form 11</th>
                                            <th>UAN No.</th>
                                            <th>Opt Out - PF Declaration</th>
                                            <th>Marksheet of X</th>
                                            <th>Marksheet of XII</th>
                                            <th>Degree of Bachelors</th>
                                            <th>Degree of Masters</th>
                                            <th>Marksheet of CA IPCC</th>
                                            <th>Marksheet of CA Final</th>
                                            <th>Membership Certificate</th>
                                            <th>Additional Qualifications certificate if any</th>
                                            <th>Offer Letter/Appointment Letter of current/last organisation</th>
                                            <th>Payslips 1</th>
                                            <th>Payslips 2</th>
                                            <th>Payslips 3</th>
                                            <th>Experience letter/Relieving letter of last organisation</th>
                                            <th>Temporary Residence Proof</th>
                                            <th>Permanant Residence Proof</th>
                                            <th>PAN Number</th>
                                            <th>PAN Card</th>
                                            <th>Aadhar Card No</th>
                                            <th>Aadhar Card</th>
                                            <th>Photograph</th>
                                            <th>Your name as per the Bank Account </th>
                                            <th>Name of Bank</th>
                                            <th>Account Number</th>
                                            <th>IFSC Code</th>
                                            <th>Branch</th>
                                            <th>Emergency Contact Number</th>
                                            <th>Father Name</th>
                                            <th>Father Contact No.</th>
                                            <th>Mother Name</th>
                                            <th>Mother Contact No</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($candidateDatasIntern as $candidateData)
                                            <tr>
                                                <td style="display: none;">{{ $candidateData->id }}</td>
                                                @if (Auth::user()->role_id == 18 || Auth::user()->teammember_id == 434)
                                                    <th> <a class="btn btn-success"m
                                                            onclick="return confirm('Are you sure you want to convert this item?');"
                                                            href="{{ url('candidateconvert/') }}/{{ $candidateData->id }}">
                                                            Convert</a> <a id="editCompany"
                                                            data-id="{{ $candidateData->id }}" data-toggle="modal"
                                                            data-target=".bd-example-modal-xl"
                                                            style="color: white;margin-left: 6px;"
                                                            class="btn btn-success">
                                                            Edit</a></th>
                                                @endif
                                                <td>{{ date('F d,Y', strtotime($candidateData->created_at)) }}</td>
                                                <td>{{ date('F d,Y', strtotime($candidateData->dateofjoining)) }}</td>
                                                <td> {{ $candidateData->your_full_name }}</td>
                                                <td>
                                                    @if ($candidateData->dateofbirth != null)
                                                        {{ date('F d,Y', strtotime($candidateData->dateofbirth)) }}
                                                    @endif
                                                </td>
                                                <td> {{ $candidateData->highestqualification }}</td>
                                                <td> {{ $candidateData->membershipnumber }}</td>
                                                <td> {{ $candidateData->rolename }}</td>
                                                <td>
                                                    @if ($candidateData->department == 1)
                                                        <span>IDT</span>
                                                    @elseif($candidateData->department == 2)
                                                        <span>ASM</span>
                                                    @elseif($candidateData->department == 3)
                                                        <span>Audit</span>
                                                    @elseif($candidateData->department == 4)
                                                        <span>Statutory Audit</span>
                                                    @elseif($candidateData->department == 5)
                                                        <span>Internal Audit</span>
                                                    @elseif($candidateData->department == 6)
                                                        <span>Taxation</span>
                                                    @elseif($candidateData->department == 7)
                                                        <span>Valuation</span>
                                                    @elseif($candidateData->department == 8)
                                                        <span>It</span>
                                                    @elseif($candidateData->department == 9)
                                                        <span>Accounts</span>
                                                    @elseif($candidateData->department == 10)
                                                        <span>Forensic Audit</span>
                                                    @elseif($candidateData->department == 11)
                                                        <span>Administration</span>
                                                    @elseif($candidateData->department == 12)
                                                        <span>Data Management</span>
                                                    @elseif($candidateData->department == 13)
                                                        <span>Digital Marketing</span>
                                                    @elseif($candidateData->department == 14)
                                                        <span>IBC</span>
                                                    @elseif($candidateData->department == 15)
                                                        <span>Direct Taxation</span>
                                                    @elseif($candidateData->department == 16)
                                                        <span>HR</span>
                                                    @else
                                                        <span>Management</span>
                                                    @endif
                                                </td>
                                                <td> {{ $candidateData->personal_email }}</td>
                                                <td> {{ $candidateData->phoneno }}</td>
                                                <td> {{ $candidateData->designation }}</td>
                                                <td> {{ $candidateData->currentaddress }}</td>
                                                <td> {{ $candidateData->permanentaddress }}</td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->resume, now()->addMinutes(30)) }}">
                                                        {{ $candidateData->resume ?? 'Not Uploaded' }} </a></td>

                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->nda, now()->addMinutes(30)) }}">
                                                        {{ $candidateData->nda ?? 'Not Uploaded' }} </a>
                                                </td>
                                                <td>
                                                    @if ($candidateData->providend === 0)
                                                   
                                                        <span>Yes</span>
                                                    @elseif($candidateData->providend === 1)
                                                        <span>No</span>
                                                    @else
                                                        <span>N/A</span>
                                                    @endif
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->pfformupload, now()->addMinutes(30)) }}">
                                                        {{ $candidateData->pfformupload ?? 'Not Uploaded' }} </a>
                                                </td>
                                                <td> {{ $candidateData->uan }}</td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->outupload, now()->addMinutes(30)) }}">
                                                        {{ $candidateData->outupload ?? 'Not Uploaded' }} </a>
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->marksheet_x, now()->addMinutes(30)) }}">
                                                        {{ $candidateData->marksheet_x ?? 'Not Uploaded' }} </a>
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->marksheet_xii, now()->addMinutes(30)) }}">
                                                        {{ $candidateData->marksheet_xii ?? 'Not Uploaded' }} </a>
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->bachelor_degree, now()->addMinutes(30)) }}">
                                                        {{ $candidateData->bachelor_degree ?? 'Not Uploaded' }} </a>
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->master_degree, now()->addMinutes(30)) }}">
                                                        {{ $candidateData->master_degree ?? 'Not Uploaded' }} </a> ,
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->marksheet_ipcc, now()->addMinutes(30)) }}">
                                                        {{ $candidateData->marksheet_ipcc ?? 'Not Uploaded' }} </a>
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->ca_final, now()->addMinutes(30)) }}">
                                                        {{ $candidateData->ca_final ?? 'Not Uploaded' }} </a>
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->membership_certificate, now()->addMinutes(30)) }}">
                                                        {{ $candidateData->membership_certificate ?? 'Not Uploaded' }}
                                                    </a>
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->addidation_qualification, now()->addMinutes(30)) }}">
                                                        {{ $candidateData->addidation_qualification ?? 'Not Uploaded' }}
                                                    </a>
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->offerappointmentletter, now()->addMinutes(30)) }}">
                                                        {{ $candidateData->offerappointmentletter ?? 'Not Uploaded' }}
                                                    </a>
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->payslipsone, now()->addMinutes(30)) }}">
                                                        {{ $candidateData->payslipsone ?? 'Not Uploaded' }} </a>
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->payslipstwo, now()->addMinutes(30)) }}">
                                                        {{ $candidateData->payslipstwo ?? 'Not Uploaded' }} </a>
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->payslipsthree, now()->addMinutes(30)) }}">
                                                        {{ $candidateData->payslipsthree ?? 'Not Uploaded' }} </a>
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->relieving_letter, now()->addMinutes(30)) }}">
                                                        {{ $candidateData->relieving_letter ?? 'Not Uploaded' }} </a>
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->residence_proofone, now()->addMinutes(30)) }}">
                                                        {{ $candidateData->residence_proofone ?? 'Not Uploaded' }} </a>
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->residence_prooftwo, now()->addMinutes(30)) }}">
                                                        {{ $candidateData->residence_prooftwo ?? 'Not Uploaded' }} </a>
                                                </td>
                                                <td> {{ $candidateData->pancardno }}</td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->pancard, now()->addMinutes(30)) }}">
                                                        {{ $candidateData->pancard ?? 'Not Uploaded' }} </a>
                                                </td>
                                                <td> {{ $candidateData->adharcardno }}</td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->aadharcard, now()->addMinutes(30)) }}">
                                                        {{ $candidateData->aadharcard ?? 'Not Uploaded' }} </a>
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $candidateData->photograph, now()->addMinutes(30)) }}">
                                                        {{ $candidateData->photograph ?? 'Not Uploaded' }} </a>
                                                </td>
                                                <td> {{ $candidateData->bankholder_name }}</td>
                                                <td> {{ $candidateData->bank_name }}</td>
                                                <td> {{ $candidateData->account_number }}</td>
                                                <td> {{ $candidateData->ifsc_code }}</td>
                                                <td> {{ $candidateData->branch }}</td>
                                                <td> {{ $candidateData->emergency_contact_number }}</td>
                                                <td> {{ $candidateData->father_name }}</td>
                                                <td> {{ $candidateData->fathercontactno }}</td>
                                                <td> {{ $candidateData->mother_name }}</td>
                                                <td> {{ $candidateData->mothecontactno }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </form>
                        </div>

                    </div>

                   <!--end intern-->
                    <div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!--/.body content-->
    <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background: #37A000">
                    <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel2">Edit Candidate
                        Onboarding Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ url('candidateonboarding/update') }}" enctype="multipart/form-data">
                    @csrf
                    @component('backEnd.components.alert')
                    @endcomponent
                    <div class="modal-body">


                        <b style="font-weight: 800;font-size: 18px; ">Candidate Details</b>
                        <hr>
                        <div class="row row-sm">
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="font-weight-600">Your Full Name *</label>
                                    <input type="text" id="your_full_name" name="your_full_name" class="form-control"
                                        placeholder="Your Full Name" value="" />
                                    <input type="text" hidden id="id" name="id" />
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="form-group">
                                    <label class="font-weight-600">Personal Email ID *</label>
                                    <input type="email" id="personal_email" name="personal_email" class="form-control"
                                        placeholder="Personal Email Id" value="" />
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="font-weight-600">Resume <span>*</span></label>
                                    <input type="file" name="resume" class="form-control" value="" />

                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="font-weight-600">Mobile No. <span>*</span></label>
                                    <input type="number" id="phoneno" name="phoneno" placeholder="Enter Phone No"
                                        class="form-control" value="" />

                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Current Address <span>*</span></label>
                                    <textarea rows="3" id="currentaddress" name="currentaddress" class="form-control"
                                        placeholder="Enter Full Address With Pin Code"></textarea>
                                </div>

                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Permanent Address <span>*</span></label>
                                    <textarea rows="3" id="permanentaddress" name="permanentaddress" class="form-control"
                                        placeholder="Enter Full  Permanent Address With Pin Code"></textarea>
                                </div>

                            </div>
                        </div>
                        <div class="row row-sm">

                            <div class="col-2">
                                <div class="form-group">
                                    <label class="font-weight-600">Date Of Joining *</label>
                                    <input type="date" id="dateofjoining" name="dateofjoining" class="form-control"
                                        value="" />
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">NDA (Non-Disclosure Agreement) *</label>
                                    <input type="file" name="nda" class="form-control" value="" />
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="font-weight-600"> NDA Employee</label><br>
                                    <a download href="{{ url('backEnd/NDA-Employees.pdf') }}"
                                        class="btn btn-success btn"> <i class="fa fa-file-pdf-o"></i>
                                        Download</a>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="font-weight-600"> NDA Intern</label><br>
                                    <a download href="{{ url('backEnd/NDA-intern.pdf') }}" class="btn btn-success btn">
                                        <i class="fa fa-file-pdf-o"></i>
                                        Download</a>
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
                                    <input type="file" name="marksheet_x" class="form-control" value="" />

                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="font-weight-600">Marksheet of XII*</label>
                                    <input type="file" name="marksheet_xii" class="form-control" value="" />

                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="font-weight-600">Degree of Bachelors*</label>
                                    <input type="file" name="bachelor_degree" class="form-control" value="" />

                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="font-weight-600">Degree of Masters</label>
                                    <input type="file" name="master_degree" class="form-control" value="" />

                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">

                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Marksheet of CA IPCC (Applicable for
                                        Chartered Accountants)</label>
                                    <input type="file" name="marksheet_ipcc" class="form-control" value="" />

                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Marksheet of CA Final (Applicable for
                                        Chartered Accountants)</label>
                                    <input type="file" name="ca_final" class="form-control" value="" />

                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Membership Certificate (Applicable for
                                        Chartered Accountants)</label>
                                    <input type="file" name="membership_certificate" class="form-control"
                                        value="" />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Additional Qualifications certificate if
                                        any</label>
                                    <input type="file" name="addidation_qualification" class="form-control"
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
                                    <input type="file" name="relieving_letter" class="form-control" value="" />
                                </div>
                            </div>

                        </div>
                        <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Photograph*</label>
                                    <input type="file" name="photograph" class="form-control" value="" />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">PAN Card*</label>
                                    <input type="file" name="pancard" class="form-control" value="" />
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Pan No *</label>
                                    <input type="text" pattern="[A-Za-z]{5}\d{4}[A-Za-z]{1}" required name="pancardno"
                                        id="panCandidate" oninvalid="invalidPanCandidate()" class="form-control" value=""
                                        placeholder="Enter PAN No" maxlength="10" />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Aadhar Card No*</label>
                                    <input type="number" required name="adharcardno" id="aadharCandidate" min="100000000000"
                                            max="999999999999" oninvalid="invalidAadharCandidate()" class="form-control"
                                            placeholder="Enter Aadhar No" value="{{ $articlefiles->adharcardno ?? '' }}">
                                </div>
                            </div>
                        </div>
                        <br>
                        <b style="font-weight: 800;font-size: 18px; "> Payslips of last 3 months of current/last
                            organisation</b>
                        <hr>
                        <div class="row row-sm">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Payslips 1 </label>
                                    <input type="file" name="payslipsone" class="form-control" value="" />
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Payslips 2 </label>
                                    <input type="file" name="payslipstwo" class="form-control" value="" />
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Payslips 3 </label>
                                    <input type="file" name="payslipsthree" class="form-control" value="" />
                                </div>
                            </div>
                        </div>
                        <br>
                        <b style="font-weight: 800;font-size: 18px; "> Two Residence Proof *</b>
                        <hr>
                        <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Residence Proof 1 </label>
                                    <input type="file" name="residence_proofone" class="form-control"
                                        value="" />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600">Residence Proof 2 </label>
                                    <input type="file" name="residence_prooftwo" class="form-control"
                                        value="" />
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
                                    <input type="text" id="bankholder_name" name="bankholder_name"
                                        class="form-control" placeholder="Your name as per the Bank Account"
                                        value="" />

                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Name of Bank*</label>
                                    <input type="text" id="bank_name" name="bank_name" class="form-control"
                                        placeholder="Enter Name of Bank" value="" />

                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Account Number*</label>
                                    <input type="number" id="account_number" name="account_number" class="form-control"
                                        placeholder="Enter Account Number" value="" />

                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">IFSC Code *</label>
                                    <input type="text" id="ifsc_code" name="ifsc_code" class="form-control"
                                        placeholder="Enter IFSC Code" value="" />

                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Branch *</label>
                                    <input type="text" id="branch" name="branch" class="form-control"
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
                                    <input type="number" id="emergency_contact_number" name="emergency_contact_number"
                                        class="form-control" placeholder="Enter Number" value="" />

                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Father Name</label>
                                    <input type="text" id="father_name" name="father_name" class="form-control"
                                        placeholder="Enter Father Name" value="" />

                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Father Contact No.</label>
                                    <input type="number" id="fathercontactno" name="fathercontactno"
                                        class="form-control" placeholder="Enter Father Contact No." value="" />

                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Mother Name</label>
                                    <input type="text" id="mother_name" name="mother_name" class="form-control"
                                        placeholder="Enter Mother Name" value="" />

                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Mother Contact No</label>
                                    <input type="number" id="mothecontactno" name="mothecontactno" class="form-control"
                                        placeholder="Enter Mother Contact No" value="" />

                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
        <!--modal 2-->

        <div class="modal fade bd-examplee-modal-xl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header" style="background: #37A000">
                        <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel2">Edit Article
                            Onboarding Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ url('articleonboarding/update') }}" enctype="multipart/form-data">
                        @csrf
                        @component('backEnd.components.alert')
                        @endcomponent
                        <div class="modal-body">

                            <b style="font-weight: 800;font-size: 18px; ">Article Details</b>
                            <hr>
                            <div class="row row-sm">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="font-weight-600">Name *</label>
                                        <input type="text" required id="name" name="name" value=""
                                            class="form-control" placeholder="Enter Name">
                                        <input type="text" hidden id="id1" name="id" />
                                    </div>
                                </div>

                                <div class="col-3">

                                    <div class="form-group">
                                        <label class="font-weight-600">Contact No. *</label>
                                        <input type="number" required id="contactno" name="contactno"
                                            value="{{ $articlefiles->mothersname ?? '' }}" class="form-control"
                                            placeholder="Enter Contact Number">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="font-weight-600">Email Id *</label>
                                        <input type="email" required id="emailid" name="emailid"
                                            value="{{ $articlefiles->dob ?? '' }}" class="form-control"
                                            placeholder="Enter Email">
                                    </div>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="font-weight-600">CRO/NRO No. *</label>
                                        <input type="text" required id="cro_nro_no" name="cro_nro_no" value=""
                                            class="form-control" placeholder="Enter CRO/NRO No.">
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="font-weight-600">Date Of Birth. *</label>
                                        <input type="date" required id="dob" name="dob"
                                            value="{{ $articlefiles->dob ?? '' }}" class="form-control"
                                            placeholder="Enter Date of Birth">
                                    </div>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="font-weight-600">Current Address <span>*</span></label>
                                        <textarea rows="3" id="currentaddresss" name="currentaddress" required class="form-control"
                                            placeholder="Enter Full Address With Pin Code"></textarea>
                                    </div>

                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="font-weight-600">Permanent Address <span>*</span></label>
                                        <textarea rows="3" id="permanentaddresss" name="permanentaddress" required class="form-control"
                                            placeholder="Enter Full Permanent Address With Pin Code"></textarea>
                                    </div>

                                </div>
                            </div>
                            <br>
                            <b style="font-weight: 800;font-size: 18px; ">Emergency Details</b>
                            <hr>
                            <div class="row row-sm">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="font-weight-600">Name Of Father. *</label>
                                        <input type="text" required name="fathersname" id="fathersname"
                                            value="" class="form-control" placeholder="Enter Name Of Father.">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="font-weight-600">Contact Of Father. *</label>
                                        <input type="number" required name="emergencycontactnumber"
                                            id="emergencycontactnumber" value="" class="form-control"
                                            placeholder="Enter Contact Of Father">
                                    </div>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="font-weight-600">Name Of Mother. *</label>
                                        <input type="text" required name="mothersname" id="mothersname"
                                            value="" class="form-control" placeholder="Enter Name of Mother.">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="font-weight-600">Contact of Mother. *</label>
                                        <input type="number" required name="emergencycontactnumbertwo"
                                            id="emergencycontactnumbertwo" value="" class="form-control"
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
                                            <label class="font-weight-600">Name of Previous Organization Form *</label>
                                            <input type="text" name="previous_organization_form[]"
                                                id="previous_organization_form" value="" class="form-control"
                                                placeholder="Enter Name of Previous Organization Form.">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Date of Joining *</label>
                                            <input type="date" name="date_of_joining[]" id="doj" value=""
                                                class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="font-weight-600">Date of Leaving * </label>
                                            <input type="date" name="date_of_leaving[]" id="date_of_leaving"
                                                value="" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div class="form-group" style="margin-top: 36px;">
                                            <a href="javascript:void(0);" class="add_button" title="Add field"><img
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
                                        <input type="file" name="document10th" id="document10th"
                                            value="{{ $articlefiles->document10th ?? '' }}" class="form-control"
                                            placeholder="Enter Financial Year .">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="font-weight-600">Mark Sheet Of 12th. *</label>
                                        <input type="file" name="document12th" id="document12th"
                                            value="{{ $articlefiles->document12th ?? '' }}" class="form-control"
                                            placeholder="Enter Financial Year .">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="font-weight-600">Degree Of Bachelor * </label>
                                        <select name="documentbachelor" id="documentbachelor" class="form-control">

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
                                            value="{{ $articlefiles->ipcccertificate ?? '' }}" class="form-control"
                                            placeholder="Enter Financial Year .">
                                    </div>
                                </div>
                                <div class="col-4" id="noc" style="display: none">
                                    <div class="form-group">
                                        <label class="font-weight-600">NOC </label>
                                        <input type="file" name="noc"
                                            value="{{ $articlefiles->ipcccertificate ?? '' }}" class="form-control"
                                            placeholder="Enter Financial Year .">
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
                                            value="{{ $articlefiles->ipcccertificate ?? '' }}" class="form-control"
                                            placeholder="Enter Financial Year .">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="font-weight-600">IPCC Group 2 Marksheet</label>
                                        <input type="file" name="ipcccertificatetwo"
                                            value="{{ $articlefiles->ipcccertificate ?? '' }}" class="form-control"
                                            placeholder="Enter Financial Year .">
                                    </div>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="font-weight-600">OC Training certificate. * </label>
                                        <input type="file" name="octrainingcertificate"
                                            value="{{ $articlefiles->octrainingcertificate ?? '' }}"
                                            class="form-control" placeholder="Enter Financial Year.">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="font-weight-600">ITT Training Certificate. * </label>
                                        <input type="file" name="itttrainingcertificate"
                                            value="{{ $articlefiles->itttrainingcertificate ?? '' }}"
                                            class="form-control" placeholder="Enter Period of Appointment .">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="font-weight-600">Photograph. * </label>
                                        <input type="file" name="photograph"
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
                                        <label class="font-weight-600">Pan Card </label>
                                        <input type="file" name="pancard" value="{{ $articlefiles->pancard ?? '' }}"
                                            class="form-control" placeholder="Enter Financial Year .">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="font-weight-600">Aadhar Card No*</label>
                                        <input type="number" required name="aadharno" id="aadhar" min="100000000000"
                                            max="999999999999" oninvalid="invalidAadhar()" class="form-control"
                                            placeholder="Enter Adhar No" value="{{ $articlefiles->aadharno ?? '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row row-sm">

                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="font-weight-600">Residence Proof 1(Aadhar card) *</label>
                                        <input type="file" name="residenceproof"
                                            value="{{ $articlefiles->residenceproof ?? '' }}" class="form-control"
                                            placeholder="Enter Period of Appointment .">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="font-weight-600">Residence Proof 2. *</label>
                                        <input type="file" name="residenceprooftwo"
                                            value="{{ $articlefiles->residenceprooftwo ?? '' }}" class="form-control"
                                            placeholder="Enter Period of Appointment .">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="font-weight-600">Additional Qualification Certificate / If Any
                                        </label>
                                        <input type="file" name="additional"
                                            value="{{ $articlefiles->photograph ?? '' }}" class="form-control"
                                            placeholder="Enter Financial Year .">
                                    </div>
                                </div>

                            </div>
                            <div class="row row-sm">

                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="font-weight-600">Copy of 102 Form </label>
                                        <input type="file" name="copyof" value="{{ $articlefiles->copyof ?? '' }}"
                                            class="form-control" placeholder="Enter Branch .">
                                    </div>
                                </div>
                                <div class="col-6">
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
                                        <input type="text" required id="accountholder" name="accountholder"
                                            value="{{ $articlefiles->accountholder ?? '' }}" class="form-control"
                                            placeholder="Enter Bank Account Holder Name  .">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="font-weight-600">Bank Account Name </label>
                                        <input type="text" required id="accountname" name="accountname"
                                            value="{{ $articlefiles->accountname ?? '' }}" class="form-control"
                                            placeholder="Enter Bank Account Name .">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="font-weight-600">Bank Account Number</label>
                                        <input type="text" required id="accountnumber" name="accountnumber"
                                            value="{{ $articlefiles->accountnumber ?? '' }}" class="form-control"
                                            placeholder="Enter Bank Account Number .">
                                    </div>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="font-weight-600">IFSC Code </label>
                                        <input type="text" required id="ifsccodes" name="ifsccode"
                                            value="{{ $articlefiles->ifsccode ?? '' }}" class="form-control"
                                            placeholder="Enter IFSC Code .">
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="font-weight-600">Branch Name</label>
                                        <input type="text" required id="branchs" name="branch"
                                            value="{{ $articlefiles->branch ?? '' }}" class="form-control"
                                            placeholder="Enter Branch.">
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--modal 2 end -->

        <!-- modal start for article convert section -->
        <div class="modal fade" id="exampleModalcred" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel4" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header" style="background: #37A000">
                        <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Add
                            Details
                        </h5>
                        <div>
                            <ul>
                                @foreach ($errors->all() as $e)
                                    <li style="color:red;">{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ url('capitallarticlepreview') }}">
                            @csrf
                            <div class="row row-sm">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="font-weight-600">Select Partner *</label>
                                        <input type="text" hidden name="articleid" id="capitallcredid">
                                        @php
                                            $partner = DB::table('teammembers')
                                                ->join('roles', 'roles.id', 'teammembers.role_id')
                                                ->where('teammembers.role_id', 13)
                                                ->select('teammembers.*', 'roles.rolename')
                                                ->get();
                                            
                                        @endphp
                                        <select class="form-control" name="partner" id="partner" required>
                                            <option value="">Select One</option>
                                            @foreach ($partner as $part)
                                                <option value="{{ $part->id }}">{{ $part->team_member ?? '' }}
                                                </option>
                                            @endforeach
                                            @endphp
                                        </select>
                                    </div>
                                </div>



                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="font-weight-600">Select Approval Status *</label>
                                        <select class="form-control" name="approvalstatus" id="approvalstatus"
                                            required>
                                            <option value="">Select one </option>
                                            <option value="Approved">Approved</option>
                                            <option value="Pending">Pending</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="font-weight-600">Select Articleship Completion Date*</label>
                                        <input type="date" class="form-control" name="date_of_completion"
                                            id="date_of_completion" required>

                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="font-weight-600">Date of Registration*</label>
                                        <input type="date" class="form-control" name="date_of_registration"
                                            id="date_of_registration" required>

                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="font-weight-600">Current Location *</label>
                                        <input type="text" class="form-control" name="location" id="location"
                                            required>

                                    </div>
                                </div>


                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success" style="float:right"> Send</button>

                            </div>


                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- modal end -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <script>
            $(function() {
                $('body').on('click', '#capitallarticle', function(event) {
                    //        debugger;
                    var id = $(this).data('id');
                    //alert(id);
                    debugger;
                    $.ajax({
                        type: "GET",

                        url: "{{ url('capitallarticle') }}",
                        data: "id=" + id,
                        success: function(response) {
                            // alert(res);
                            debugger;
                            $("#capitallcredid").val(response.id);
                            // $('#capitallcred').html(id);




                        },
                        error: function() {

                        },
                    });
                });
            });
        </script>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script>
            $(function() {
                $('body').on('click', '#editCompany', function(event) {
                    //        debugger;
                    var id = $(this).data('id');
                    debugger;
                    $.ajax({
                        type: "GET",

                        url: "{{ url('candidateupdate') }}",
                        data: "id=" + id,
                        success: function(response) {
                            debugger;
                            $("#id").val(response.id);
                            $("#your_full_name").val(response.your_full_name);
                            $("#personal_email").val(response.personal_email);
                            $("#phoneno").val(response.phoneno);
                            $("#bankholder_name").val(response.bankholder_name);
                            $("#bank_name").val(response.bank_name);
                            $("#account_number").val(response.account_number);
                            $("#ifsc_code").val(response.ifsc_code);
                            $("#branch").val(response.branch);
                            $("#emergency_contact_number").val(response.emergency_contact_number);
                            $("#father_name").val(response.father_name);
                            $("#fathercontactno").val(response.fathercontactno);
                            $("#mother_name").val(response.mother_name);
                            $("#mothecontactno").val(response.mothecontactno);
                            $("#currentaddress").val(response.currentaddress);
                            $("#permanentaddress").val(response.permanentaddress);
                            $("#dateofjoining").val(response.dateofjoining);
                            $("#aadharCandidate").val(response.adharcardno);
                            $("#panCandidate").val(response.pancardno);
                            //debugger;

                        },
                        error: function() {

                        },
                    });
                });
            });
        </script>

        <script>
            $(function() {
                $('body').on('click', '#editCompany2', function(event) {
                    //        debugger;
                    var id = $(this).data('id');
                    //debugger;
                    $.ajax({
                        type: "GET",

                        url: "{{ url('articleupdate') }}",
                        data: "id=" + id,
                        success: function(response) {

                            //console.log(response);
                            debugger;
                            $("#id1").val(response.id);
                            $("#name").val(response.name);
                            $("#contactno").val(response.contactno);
                            $("#emailid").val(response.emailid);
                            $("#cro_nro_no").val(response.cro_nro_no);
                            $("#dob").val(response.dob);
                            $("#currentaddresss").val(response.currentaddress);
                            $("#permanentaddresss").val(response.permanentaddress);
                            $("#fathersname").val(response.fathersname);
                            $("#mothersname").val(response.mothersname);
                            $("#emergencycontactnumber").val(response.emergencycontactnumber);
                            $("#emergencycontactnumbertwo").val(response.emergencycontactnumbertwo);
                            $("#previous_organization_form").val(response
                                .previous_organization_form);
                            $("#dateofjoining").val(response.dateofjoining);
                            $("#accountname").val(response.accountname);
                            $("#accountholder").val(response.accountholder);
                            $("#accountnumber").val(response.accountnumber);
                            $("#ifsccodes").val(response.ifsccode);
                            $("#branchs").val(response.branch);
                            $("#aadhar").val(response.aadharno);
                            $("#pan").val(response.pancardno);

                            //debugger;

                        },
                        error: function() {

                        },
                    });
                });
            });
        </script>
    @endsection
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#examplee').DataTable({
                "pageLength": 50,
                dom: 'Bfrtip',
                "order": [
                    [0, "desc"]
                ],

                buttons: [

                    {
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [0, ':visible']
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [0, 1, 2, 5]
                        }
                    },
                    'colvis'
                ]
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#exampleee').DataTable({
                "pageLength": 50,
                dom: 'Bfrtip',
                "order": [
                    [0, "desc"]
                ],

                buttons: [

                    {
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [0, ':visible']
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [0, 1, 2, 5]
                        }
                    },
                    'colvis'
                ]
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#exampleeee').DataTable({
                "pageLength": 50,
                dom: 'Bfrtip',
                "order": [
                    [0, "desc"]
                ],

                buttons: [

                    {
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [0, ':visible']
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [0, 1, 2, 5]
                        }
                    },
                    'colvis'
                ]
            });
        });
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


    <script type="text/javascript">
        $(function() {
            $("#chkAlls").click(function() {
                $("input[name='ids[]']").attr("checked", this.checked);
            });
            $('#example11').DataTable({});
        });
    </script>
    <div class="modal fade" id="exampleModal122" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel4" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header" style="background: #37A000">
                    <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Previous
                        Training Details</h5>
                    <div>
                        <ul>
                            @foreach ($errors->all() as $e)
                                <li style="color:red;">{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">

                        <table class="table display table-bordered table-striped table-hover">
                            <thead>
                                <tr>

                                    <th>Name of Previous Organization </th>
                                    <th>Date of Joining</th>
                                    <th>Date of Leaving</th>
                                </tr>
                            </thead>
                            <tbody id="out_idd">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script>
        $(function() {
            $('body').on('click', '#editss', function(event) {
                //        debugger;
                var id = $(this).data('id');
                debugger;
                $.ajax({
                    type: "GET",

                    url: "{{ url('articleprevious') }}",
                    data: "id=" + id,
                    success: function(response) {
                        // alert(res);
                        debugger;
                        $('#out_idd').html(response);




                    },
                    error: function() {

                    },
                });
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

        function invalidAadharCandidate() {
            // Get the input field and error message elements
            var aadharInput = document.getElementById('aadharCandidate');

            // Check if the input value is not exactly 12 digits
            if (aadharInput.value.length !== 12) {
                // Display an error message
                aadharInput.setCustomValidity("Aadhar number must be exactly 12 digits");
            } else {
                // Clear the error message
                aadharInput.setCustomValidity("");
            }
        }

        function invalidPanCandidate() {
            var panInput = document.getElementById("panCandidate");
            if (panInput.validity.patternMismatch) {
                panInput.setCustomValidity("Please enter a valid PAN card number");
            } else {
                panInput.setCustomValidity("");
            }
        }
    </script>
