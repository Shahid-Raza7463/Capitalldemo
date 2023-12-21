<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')
    <!--Content Header (Page header)-->
    <div class="content-header row align-items-center m-0">
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Home</h1>
                    <small> Employee Onboarding List</small>
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
                            role="tab" aria-controls="pills-manager" aria-selected="true">Employee</a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" id="pills-user-tab" data-toggle="pill" href="#pills-article" role="tab"
                            aria-controls="pills-article" aria-selected="false">Article Trainee</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-user-tab" data-toggle="pill" href="#pills-interns" role="tab"
                            aria-controls="pills-interns" aria-selected="false">Intern</a>
                    </li>

                </ul>

                <br>

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-manager" role="tabpanel"
                        aria-labelledby="pills-home-tab">
                        <div class="table-responsive example">
                            <form method="post">
                                @csrf
                                <div class="table-responsive">
                                    <table id="examplee" class="table display table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                @if (auth()->user()->role_id == 18)
                                                    <th>Send Introduction Email </th>
                                                    <th>Send Capitall Credentials</th>
                                                @endif
                                                <th>Submission Date</th>
                                                <th>Joining Date</th>
                                                <th> Full Name</th>
                                                <th>Date of Birth</th>
                                                <th>Highest Qualification</th>
                                                <th> Membership Number (If CA/CMA/CS). </th>
                                                <th> Role </th>
                                                <th> Department </th>
                                                <th> Designation</th>
                                                <th>Personal Email ID</th>
                                                <th>Phone No</th>
                                                <th>Current Address</th>
                                                <th>Permanent Address</th>
                                                <th>Adhar Card No</th>
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
                                           
                                            @foreach ($employeeonboardingDatasManager as $employeeonboardingData)
                                                <tr>
                                                    @php
                                                        //$id=$employeeonboardingData->id;
                                                        //dd($id);
                                                        /* $status=DB::table('employeeonboardingmail')
                              ->where('employeeonboarding_id',$employeeonboardingData->id)
                              ->select('status')->pluck('status')
                              ->first();
                             // dd($status);*/
                                                    @endphp
                                                   
                                                    @if (auth()->user()->role_id == 18)
                                                        <td>

                                                            @if ($employeeonboardingData->mail_status == 1)
                                                                <span class="btn btn-success"
                                                                    style="width: 133px; ">Sent</span>
                                                            @else
                                                                <a
                                                                    href="{{ url('employeeonboarding/sendmail', $employeeonboardingData->id) }}">
                                                                    <span class="btn btn-success"
                                                                        style="width: 133px; height: 50px;">Send
                                                                        Introduction Mail</span></a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($employeeonboardingData->cred_status == 1)
                                                                <span class="btn btn-success"
                                                                    style="width: 133px; ">Sent</span>
                                                            @else
                                                                <a id="capitallcred" data-toggle="modal"
                                                                    data-id="{{ $employeeonboardingData->id }}"
                                                                    data-target="#exampleModalcred"> <span
                                                                        class="btn btn-success"
                                                                        style="width: 133px; height: 50px;"
                                                                        style="width: 133px; height: 50px;">Send Capitall
                                                                        Credentials
                                                                    </span></a>
                                                        </td>
                                                    @endif
                                            @endif

                                            <td>{{ date('F d,Y', strtotime($employeeonboardingData->created_at)) }}</td>
                                            <td>{{ date('F d,Y', strtotime($employeeonboardingData->dateofjoining)) }}</td>
                                            <td>
                                                {{ $employeeonboardingData->your_full_name }}

                                            </td>
                                            <td>{{ $employeeonboardingData->dob ?? '' }}</td>
                                            <td>{{ $employeeonboardingData->highestqualification ?? '' }}</td>
                                            <td>{{ $employeeonboardingData->membershipnumber ?? '' }}</td>
                                            <td> {{ $employeeonboardingData->rolename }}</td>
                                            <td>
                                                @if ($employeeonboardingData->department == 1)
                                                    <span>IDT</span>
                                                @elseif($employeeonboardingData->department == 2)
                                                    <span>ASM</span>
                                                @elseif($employeeonboardingData->department == 3)
                                                    <span>Audit</span>
                                                @elseif($employeeonboardingData->department == 4)
                                                    <span>Statutory Audit</span>
                                                @elseif($employeeonboardingData->department == 5)
                                                    <span>Internal Audit</span>
                                                @elseif($employeeonboardingData->department == 6)
                                                    <span>Taxation</span>
                                                @elseif($employeeonboardingData->department == 7)
                                                    <span>Valuation</span>
                                                @elseif($employeeonboardingData->department == 8)
                                                    <span>It</span>
                                                @elseif($employeeonboardingData->department == 9)
                                                    <span>Accounts</span>
                                                @elseif($employeeonboardingData->department == 10)
                                                    <span>Forensic Audit</span>
                                                @elseif($employeeonboardingData->department == 11)
                                                    <span>Administration</span>
                                                @elseif($employeeonboardingData->department == 12)
                                                    <span>Data Management</span>
                                                @elseif($employeeonboardingData->department == 13)
                                                    <span>Digital Marketing</span>
                                                @elseif($employeeonboardingData->department == 14)
                                                    <span>IBC</span>
                                                @elseif($employeeonboardingData->department == 15)
                                                    <span>Direct Taxation</span>
                                                @elseif($employeeonboardingData->department == 16)
                                                    <span>HR</span>
                                                @else
                                                    <span>Management</span>
                                                @endif
                                            </td>
                                            <td> {{ $employeeonboardingData->designation }}</td>
                                            <td> {{ $employeeonboardingData->personal_email }}</td>
                                            <td> {{ $employeeonboardingData->phoneno }}</td>
                                            <td> {{ $employeeonboardingData->currentaddress }}</td>
                                            <td> {{ $employeeonboardingData->permanentaddress }}</td>
                                            <td> {{ $employeeonboardingData->adharcardno }}</td>
                                            <td><a target="blank"
                                                    href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->resume, now()->addMinutes(30)) }}">
                                                    {{ $employeeonboardingData->resume ?? 'Not Uploaded' }} </a></td>

                                            <td><a target="blank"
                                                    href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->nda, now()->addMinutes(30)) }}">
                                                    {{ $employeeonboardingData->nda ?? 'Not Uploaded' }} </a>
                                            </td>
                                            <td>
                                                @if ($employeeonboardingData->providend == 0)
                                                    <span>Yes</span>
                                                @elseif($employeeonboardingData->providend == 1)
                                                    <span>No</span>
                                                @elseif($employeeonboardingData->providend == null)
                                                    <span>N/A</span>
                                                @endif
                                            </td>
                                            <td><a target="blank"
                                                    href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->pfformupload, now()->addMinutes(30)) }}">
                                                    {{ $employeeonboardingData->pfformupload ?? 'Not Uploaded' }} </a>
                                            </td>
                                            <td> {{ $employeeonboardingData->uan }}</td>
                                            <td><a target="blank"
                                                    href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->outupload, now()->addMinutes(30)) }}">
                                                    {{ $employeeonboardingData->outupload ?? 'Not Uploaded' }} </a>
                                            </td>
                                            <td><a target="blank"
                                                    href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->marksheet_x, now()->addMinutes(30)) }}">
                                                    {{ $employeeonboardingData->marksheet_x ?? 'Not Uploaded' }} </a>
                                            </td>
                                            <td><a target="blank"
                                                    href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->marksheet_xii, now()->addMinutes(30)) }}">
                                                    {{ $employeeonboardingData->marksheet_xii ?? 'Not Uploaded' }} </a>
                                            </td>
                                            <td><a target="blank"
                                                    href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->bachelor_degree, now()->addMinutes(30)) }}">
                                                    {{ $employeeonboardingData->bachelor_degree ?? 'Not Uploaded' }} </a>
                                            </td>
                                            <td><a target="blank"
                                                    href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->master_degree, now()->addMinutes(30)) }}">
                                                    {{ $employeeonboardingData->master_degree ?? 'Not Uploaded' }} </a> ,
                                            </td>
                                            <td><a target="blank"
                                                    href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->marksheet_ipcc, now()->addMinutes(30)) }}">
                                                    {{ $employeeonboardingData->marksheet_ipcc ?? 'Not Uploaded' }} </a>
                                            </td>
                                            <td><a target="blank"
                                                    href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->ca_final, now()->addMinutes(30)) }}">
                                                    {{ $employeeonboardingData->ca_final ?? 'Not Uploaded' }} </a>
                                            </td>
                                            <td><a target="blank"
                                                    href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->membership_certificate, now()->addMinutes(30)) }}">
                                                    {{ $employeeonboardingData->membership_certificate ?? 'Not Uploaded' }}
                                                </a>
                                            </td>
                                            <td><a target="blank"
                                                    href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->addidation_qualification, now()->addMinutes(30)) }}">
                                                    {{ $employeeonboardingData->addidation_qualification ?? 'Not Uploaded' }}
                                                </a>
                                            </td>
                                            <td><a target="blank"
                                                    href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->offerappointmentletter, now()->addMinutes(30)) }}">
                                                    {{ $employeeonboardingData->offerappointmentletter ?? 'Not Uploaded' }}
                                                </a>
                                            </td>
                                            <td><a target="blank"
                                                    href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->payslipsone, now()->addMinutes(30)) }}">
                                                    {{ $employeeonboardingData->payslipsone ?? 'Not Uploaded' }} </a>
                                            </td>
                                            <td><a target="blank"
                                                    href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->payslipstwo, now()->addMinutes(30)) }}">
                                                    {{ $employeeonboardingData->payslipstwo ?? 'Not Uploaded' }} </a>
                                            </td>
                                            <td><a target="blank"
                                                    href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->payslipsthree, now()->addMinutes(30)) }}">
                                                    {{ $employeeonboardingData->payslipsthree ?? 'Not Uploaded' }} </a>
                                            </td>
                                            <td><a target="blank"
                                                    href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->relieving_letter, now()->addMinutes(30)) }}">
                                                    {{ $employeeonboardingData->relieving_letter ?? 'Not Uploaded' }} </a>
                                            </td>
                                            <td><a target="blank"
                                                    href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->residence_proofone, now()->addMinutes(30)) }}">
                                                    {{ $employeeonboardingData->residence_proofone ?? 'Not Uploaded' }} </a>
                                            </td>
                                            <td><a target="blank"
                                                    href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->residence_prooftwo, now()->addMinutes(30)) }}">
                                                    {{ $employeeonboardingData->residence_prooftwo ?? 'Not Uploaded' }} </a>
                                            </td>
                                            <td> {{ $employeeonboardingData->pancardno }}</td>
                                            <td><a target="blank"
                                                    href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->pancard, now()->addMinutes(30)) }}">
                                                    {{ $employeeonboardingData->pancard ?? 'Not Uploaded' }} </a>
                                            </td>
                                            <td><a target="blank"
                                                    href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->photograph, now()->addMinutes(30)) }}">
                                                    {{ $employeeonboardingData->photograph ?? 'Not Uploaded' }} </a>
                                            </td>
                                            <td> {{ $employeeonboardingData->bankholder_name }}</td>
                                            <td> {{ $employeeonboardingData->bank_name }}</td>
                                            <td> {{ $employeeonboardingData->account_number }}</td>
                                            <td> {{ $employeeonboardingData->ifsc_code }}</td>
                                            <td> {{ $employeeonboardingData->branch }}</td>
                                            <td> {{ $employeeonboardingData->emergency_contact_number }}</td>
                                            <td> {{ $employeeonboardingData->father_name }}</td>
                                            <td> {{ $employeeonboardingData->fathercontactno }}</td>
                                            <td> {{ $employeeonboardingData->mother_name }}</td>
                                            <td> {{ $employeeonboardingData->mothecontactno }}</td>

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
                                <table id="exampleee" class="table display table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            @if (auth()->user()->role_id == 18)
                                                <th>Send Introduction Mail</th>
                                                <th>Send Capitall Credentials</th>
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

                                            <th>Foundation Martsheet</th>
                                            <th>IPCC Group 1 Martsheet</th>
                                            <th>IPCC Group 2 Martsheet</th>
                                            <th>OC Training Certificate</th>
                                            <th>ITT Training Certificate</th>
                                            <th>Residence Proof 1</th>
                                            <th>Residence Proof 2</th>
                                            <th>PAN Number</th>
                                            <th>Pan Card</th>
                                            <th>Photograph</th>
                                            <th>Copy Of 102 Form</th>
                                            <th>Copy Of 103 Form</th>
                                            <th>Additional qualification Certificate/If Any</th>
                                            <th>Bank Account Holder Name</th>
                                            <th>Bank Account Name</th>
                                            <th>Bank Account Number</th>
                                            <th>IFSC Code</th>
                                            <th>Branch Name</th>
                                            <th hidden>Name of Previous Organization Form</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employeeonboardingDatasStaff as $employeeonboardingData)
                                            <tr>
                                                @php
                                                    $id = $employeeonboardingData->id;
                                                    //dd($id);
                                                    $status = DB::table('employeeonboardingmail')
                                                        ->where('employeeonboarding_id', $id)
                                                        ->first();
                                                    // dd($status);
                                                @endphp


                                                @if (auth()->user()->role_id == 18)
                                                    <td>

                                                        @if ($status != null)
                                                            <span class="btn btn-success"
                                                                style="width: 133px; ">Sent</span>
                                                        @else
                                                            <a
                                                                href="{{ url('employeeonboarding/sendmail', $employeeonboardingData->id) }}">
                                                                <span class="btn btn-success"
                                                                    style="width: 133px; height: 50px;">Send Introduction
                                                                    Mail</span></a>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if ($employeeonboardingData->cred_status == 1)
                                                            <span class="btn btn-success"
                                                                style="width: 133px; ">Sent</span>
                                                        @else
                                                            <a id="capitallcred" data-toggle="modal"
                                                                data-id="{{ $employeeonboardingData->id }}"
                                                                data-target="#exampleModalcred"> <span
                                                                    class="btn btn-success"
                                                                    style="width: 133px; height: 50px;"
                                                                    style="width: 133px; height: 50px;">Send Capitall
                                                                    Credentials
                                                                </span></a>
                                                    </td>
                                                @endif
                                        @endif
                                        <td>
                                            {{ $employeeonboardingData->your_full_name ?? '' }}
                                        </td>
                                        <td>{{ $employeeonboardingData->phoneno ?? '' }}</td>
                                        <td> {{ $employeeonboardingData->personal_email }}</td>
                                        <td> {{ $employeeonboardingData->cro_nro_no ?? '' }}</td>
                                        <td> {{ date('F d,Y', strtotime($employeeonboardingData->dob ?? '')) }}</td>
                                        <td> {{ date('F d,Y', strtotime($employeeonboardingData->dateofjoining)) }}</td>
                                        <td> {{ $employeeonboardingData->qualification ?? '' }}</td>
                                        <td> {{ $employeeonboardingData->father_name ?? '' }}</td>
                                        <td> {{ $employeeonboardingData->emergency_contact_number ?? '' }}</td>

                                        <td> {{ $employeeonboardingData->mother_name ?? '' }}</td>
                                        <td> {{ $employeeonboardingData->emergency1_number ?? '' }}</td>

                                        <td><a target="blank"
                                                href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->marksheet_x, now()->addMinutes(30)) }}">
                                                {{ $employeeonboardingData->marksheet_x ?? 'Not Uploaded' }} </a></td>

                                        <td><a target="blank"
                                                href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->marksheet_xii, now()->addMinutes(30)) }}">
                                                {{ $employeeonboardingData->marksheet_xii ?? 'Not Uploaded' }} </a>
                                        </td>
                                        <td>
                                            @if ($employeeonboardingData->documentbachelor == 0)
                                                <span class="badge badge-pill badge-warning">Pursuing</span><br>
                                                <span>Type of Course :
                                                    @if ($employeeonboardingData->documentbcom == 0)
                                                        <span class="badge badge-pill badge-warning">Regular</span>
                                                        <br>
                                                        <span>Mark Sheet :</span>
                                                        <a target="blank"
                                                            href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $employeeonboardingData->bcomcertificate, now()->addMinutes(30)) }}">
                                                            {{ $employeeonboardingData->bcomcertificate ?? 'Not Uploaded' }}
                                                        </a><br>
                                                        <!--<span>NOC : </span>
                                        <a target="blank"
                                            href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $employeeonboardingData->bcomcertificate, now()->addMinutes(30)) }}">
                                            {{ $employeeonboardingData->bcomcertificate ?? 'Not Uploaded' }} </a>-->
                                                    @elseif($employeeonboardingData->documentbcom == 1)
                                                        <span class="badge badge-pill badge-warning">Distance</span>
                                                        <br><span>Mark Sheet :</span>
                                                        <a target="blank"
                                                            href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $employeeonboardingData->bcomcertificate, now()->addMinutes(30)) }}">
                                                            {{ $employeeonboardingData->bcomcertificate ?? 'Not Uploaded' }}
                                                        </a>
                                                    @endif
                                                </span>
                                            @elseif($employeeonboardingData->documentbachelor == 1)
                                                <span class="badge badge-pill badge-success">Not Pursuing</span>
                                            @elseif($employeeonboardingData->documentbachelor == 2)
                                                <span class="badge badge-pill badge-danger">Completed</span>
                                                <br><span> Attached Degree Mark Sheet : </span> <a target="blank"
                                                    href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $employeeonboardingData->bachelor_degree, now()->addMinutes(30)) }}">
                                                    {{ $employeeonboardingData->bachelor_degree ?? 'Not Uploaded' }} </a>
                                            @endif
                                        </td>

                                        <td><a target="blank"
                                                href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $employeeonboardingData->cptcertificate, now()->addMinutes(30)) }}">
                                                {{ $employeeonboardingData->cptcertificate ?? 'Not Uploaded' }} </a></td>
                                        <td><a target="blank"
                                                href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $employeeonboardingData->ipcccertificate, now()->addMinutes(30)) }}">
                                                {{ $employeeonboardingData->ipcccertificate ?? 'Not Uploaded' }} </a></td>
                                        <td><a target="blank"
                                                href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $employeeonboardingData->ipcccertificatetwo, now()->addMinutes(30)) }}">
                                                {{ $employeeonboardingData->ipcccertificatetwo ?? 'Not Uploaded' }} </a>
                                        </td>
                                        <td><a target="blank"
                                                href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $employeeonboardingData->octrainingcertificate, now()->addMinutes(30)) }}">
                                                {{ $employeeonboardingData->octrainingcertificate ?? 'Not Uploaded' }} </a>
                                        </td>
                                        <td><a target="blank"
                                                href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $employeeonboardingData->itttrainingcertificate, now()->addMinutes(30)) }}">
                                                {{ $employeeonboardingData->itttrainingcertificate ?? 'Not Uploaded' }}
                                            </a></td>

                                        <td><a target="blank"
                                                href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $employeeonboardingData->residenceproof, now()->addMinutes(30)) }}">
                                                {{ $employeeonboardingData->residenceproof ?? 'Not Uploaded' }} </a></td>

                                        <td><a target="blank"
                                                href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $employeeonboardingData->residenceprooftwo, now()->addMinutes(30)) }}">
                                                {{ $employeeonboardingData->residenceprooftwo ?? 'Not Uploaded' }} </a>
                                        </td>
                                        <td> {{ $employeeonboardingData->pancardno }}</td>
                                        <td><a target="blank"
                                                href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $employeeonboardingData->pancard, now()->addMinutes(30)) }}">
                                                {{ $employeeonboardingData->pancard ?? 'Not Uploaded' }} </a></td>

                                        <td><a target="blank"
                                                href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $employeeonboardingData->photograph, now()->addMinutes(30)) }}">
                                                {{ $employeeonboardingData->photograph ?? 'Not Uploaded' }} </a></td>

                                        <td><a target="blank"
                                                href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $employeeonboardingData->copyof, now()->addMinutes(30)) }}">
                                                {{ $employeeonboardingData->copyof ?? 'Not Uploaded' }} </a></td>

                                        <td><a target="blank"
                                                href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $employeeonboardingData->copyoftwo, now()->addMinutes(30)) }}">
                                                {{ $employeeonboardingData->copyoftwo ?? 'Not Uploaded' }} </a></td>

                                        <td><a target="blank"
                                                href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/' . $employeeonboardingData->additional, now()->addMinutes(30)) }}">
                                                {{ $employeeonboardingData->additional ?? 'Not Uploaded' }} </a></td>

                                        <td> {{ $employeeonboardingData->bankholder_name }}</td>
                                        <td> {{ $employeeonboardingData->bank_name }}</td>
                                        <td> {{ $employeeonboardingData->account_number }}</td>
                                        <td> {{ $employeeonboardingData->ifsc_code }}</td>
                                        <td> {{ $employeeonboardingData->branch }}</td>
                                        <td hidden> <a class="btn btn-success" id="editss" data-toggle="modal"
                                                data-id="{{ $employeeonboardingData->id }}"
                                                data-target="#exampleModal122" style="color: white">View</a></td>



                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </form>
                        </div>

                    </div>
                    <br>
                    <div class="tab-pane fade" id="pills-interns" role="tabpanel" aria-labelledby="pills-user-tab">

                        <div class="table-responsive">
                            <form method="post">
                                @csrf
                                <table id="exampleeee" class="table display table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            @if (auth()->user()->role_id == 18)
                                                <th>Send Introduction Email </th>
                                                <th>Send Capitall Credentials</th>
                                            @endif
                                            <th>Submission Date</th>
                                            <th>Joining Date</th>
                                            <th> Full Name</th>
                                            <th> Role </th>
                                            <th> Department </th>
                                            <th> Designation</th>
                                            <th>Personal Email ID</th>
                                            <th>Phone No</th>
                                            <th>Current Address</th>
                                            <th>Permanent Address</th>
                                            <th>Adhar Card No</th>
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
                                        @foreach ($employeeonboardingDatasIntern as $employeeonboardingData)
                                            <tr>
                                                @if (auth()->user()->role_id == 18)
                                                        <td>

                                                            @if ($employeeonboardingData->mail_status == 1)
                                                                <span class="btn btn-success"
                                                                    style="width: 133px; ">Sent</span>
                                                            @else
                                                                <a
                                                                    href="{{ url('employeeonboarding/sendmail', $employeeonboardingData->id) }}">
                                                                    <span class="btn btn-success"
                                                                        style="width: 133px; height: 50px;">Send
                                                                        Introduction Mail</span></a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($employeeonboardingData->cred_status == 1)
                                                                <span class="btn btn-success"
                                                                    style="width: 133px; ">Sent</span>
                                                            @else
                                                                <a id="capitallcred" data-toggle="modal"
                                                                    data-id="{{ $employeeonboardingData->id }}"
                                                                    data-target="#exampleModalcred"> <span
                                                                        class="btn btn-success"
                                                                        style="width: 133px; height: 50px;"
                                                                        style="width: 133px; height: 50px;">Send Capitall
                                                                        Credentials
                                                                    </span></a>
                                                        </td>
                                                            @endif
                                                    @endif
                                                <td>{{ date('F d,Y', strtotime($employeeonboardingData->created_at)) }}
                                                </td>
                                                <td>{{ date('F d,Y', strtotime($employeeonboardingData->dateofjoining)) }}
                                                </td>
                                                <td> {{ $employeeonboardingData->your_full_name }}</td>
                                                <td> {{ $employeeonboardingData->rolename }}</td>
                                                <td>
                                                    @if ($employeeonboardingData->department == 1)
                                                        <span>IDT</span>
                                                    @elseif($employeeonboardingData->department == 2)
                                                        <span>ASM</span>
                                                    @elseif($employeeonboardingData->department == 3)
                                                        <span>Audit</span>
                                                    @elseif($employeeonboardingData->department == 4)
                                                        <span>Statutory Audit</span>
                                                    @elseif($employeeonboardingData->department == 5)
                                                        <span>Internal Audit</span>
                                                    @elseif($employeeonboardingData->department == 6)
                                                        <span>Taxation</span>
                                                    @elseif($employeeonboardingData->department == 7)
                                                        <span>Valuation</span>
                                                    @elseif($employeeonboardingData->department == 8)
                                                        <span>It</span>
                                                    @elseif($employeeonboardingData->department == 9)
                                                        <span>Accounts</span>
                                                    @elseif($employeeonboardingData->department == 10)
                                                        <span>Forensic Audit</span>
                                                    @elseif($employeeonboardingData->department == 11)
                                                        <span>Administration</span>
                                                    @elseif($employeeonboardingData->department == 12)
                                                        <span>Data Management</span>
                                                    @elseif($employeeonboardingData->department == 13)
                                                        <span>Digital Marketing</span>
                                                    @elseif($employeeonboardingData->department == 14)
                                                        <span>IBC</span>
                                                    @elseif($employeeonboardingData->department == 15)
                                                        <span>Direct Taxation</span>
                                                    @elseif($employeeonboardingData->department == 16)
                                                        <span>HR</span>
                                                    @else
                                                        <span>Management</span>
                                                    @endif
                                                </td>
                                                <td> {{ $employeeonboardingData->designation }}</td>
                                                <td> {{ $employeeonboardingData->personal_email }}</td>
                                                <td> {{ $employeeonboardingData->phoneno }}</td>
                                                <td> {{ $employeeonboardingData->currentaddress }}</td>
                                                <td> {{ $employeeonboardingData->permanentaddress }}</td>
                                                <td> {{ $employeeonboardingData->adharcardno }}</td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->resume, now()->addMinutes(30)) }}">
                                                        {{ $employeeonboardingData->resume ?? 'Not Uploaded' }} </a></td>

                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->nda, now()->addMinutes(30)) }}">
                                                        {{ $employeeonboardingData->nda ?? 'Not Uploaded' }} </a>
                                                </td>
                                                <td>
                                                    @if ($employeeonboardingData->providend == 0)
                                                        <span>Yes</span>
                                                    @elseif($employeeonboardingData->providend == 1)
                                                        <span>No</span>
                                                    @elseif($employeeonboardingData->providend == null)
                                                        <span>N/A</span>
                                                    @endif
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->pfformupload, now()->addMinutes(30)) }}">
                                                        {{ $employeeonboardingData->pfformupload ?? 'Not Uploaded' }} </a>
                                                </td>
                                                <td> {{ $employeeonboardingData->uan }}</td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->outupload, now()->addMinutes(30)) }}">
                                                        {{ $employeeonboardingData->outupload ?? 'Not Uploaded' }} </a>
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->marksheet_x, now()->addMinutes(30)) }}">
                                                        {{ $employeeonboardingData->marksheet_x ?? 'Not Uploaded' }} </a>
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->marksheet_xii, now()->addMinutes(30)) }}">
                                                        {{ $employeeonboardingData->marksheet_xii ?? 'Not Uploaded' }}
                                                    </a>
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->bachelor_degree, now()->addMinutes(30)) }}">
                                                        {{ $employeeonboardingData->bachelor_degree ?? 'Not Uploaded' }}
                                                    </a>
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->master_degree, now()->addMinutes(30)) }}">
                                                        {{ $employeeonboardingData->master_degree ?? 'Not Uploaded' }}
                                                    </a>
                                                    ,
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->marksheet_ipcc, now()->addMinutes(30)) }}">
                                                        {{ $employeeonboardingData->marksheet_ipcc ?? 'Not Uploaded' }}
                                                    </a>
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->ca_final, now()->addMinutes(30)) }}">
                                                        {{ $employeeonboardingData->ca_final ?? 'Not Uploaded' }} </a>
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->membership_certificate, now()->addMinutes(30)) }}">
                                                        {{ $employeeonboardingData->membership_certificate ?? 'Not Uploaded' }}
                                                    </a>
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->addidation_qualification, now()->addMinutes(30)) }}">
                                                        {{ $employeeonboardingData->addidation_qualification ?? 'Not Uploaded' }}
                                                    </a>
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->offerappointmentletter, now()->addMinutes(30)) }}">
                                                        {{ $employeeonboardingData->offerappointmentletter ?? 'Not Uploaded' }}
                                                    </a>
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->payslipsone, now()->addMinutes(30)) }}">
                                                        {{ $employeeonboardingData->payslipsone ?? 'Not Uploaded' }} </a>
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->payslipstwo, now()->addMinutes(30)) }}">
                                                        {{ $employeeonboardingData->payslipstwo ?? 'Not Uploaded' }} </a>
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->payslipsthree, now()->addMinutes(30)) }}">
                                                        {{ $employeeonboardingData->payslipsthree ?? 'Not Uploaded' }}
                                                    </a>
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->relieving_letter, now()->addMinutes(30)) }}">
                                                        {{ $employeeonboardingData->relieving_letter ?? 'Not Uploaded' }}
                                                    </a>
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->residence_proofone, now()->addMinutes(30)) }}">
                                                        {{ $employeeonboardingData->residence_proofone ?? 'Not Uploaded' }}
                                                    </a>
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->residence_prooftwo, now()->addMinutes(30)) }}">
                                                        {{ $employeeonboardingData->residence_prooftwo ?? 'Not Uploaded' }}
                                                    </a>
                                                </td>
                                                <td> {{ $employeeonboardingData->pancardno }}</td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->pancard, now()->addMinutes(30)) }}">
                                                        {{ $employeeonboardingData->pancard ?? 'Not Uploaded' }} </a>
                                                </td>
                                                <td><a target="blank"
                                                        href="{{ Storage::disk('s3')->temporaryUrl('candidateonboarding/' . $employeeonboardingData->photograph, now()->addMinutes(30)) }}">
                                                        {{ $employeeonboardingData->photograph ?? 'Not Uploaded' }} </a>
                                                </td>
                                                <td> {{ $employeeonboardingData->bankholder_name }}</td>
                                                <td> {{ $employeeonboardingData->bank_name }}</td>
                                                <td> {{ $employeeonboardingData->account_number }}</td>
                                                <td> {{ $employeeonboardingData->ifsc_code }}</td>
                                                <td> {{ $employeeonboardingData->branch }}</td>
                                                <td> {{ $employeeonboardingData->emergency_contact_number }}</td>
                                                <td> {{ $employeeonboardingData->father_name }}</td>
                                                <td> {{ $employeeonboardingData->fathercontactno }}</td>
                                                <td> {{ $employeeonboardingData->mother_name }}</td>
                                                <td> {{ $employeeonboardingData->mothecontactno }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </form>
                        </div>

                    </div>
                    <div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!--/.body content-->
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


<script type="text/javascript">
    $(function() {
        $("#chkAlls").click(function() {
            $("input[name='ids[]']").attr("checked", this.checked);
        });
        $('#example11').DataTable({});
    });
</script>
<script>
    $(function() {
        $('body').on('click', '#capitallcred', function(event) {
            //        debugger;
            var id = $(this).data('id');
            debugger;
            $.ajax({
                type: "GET",

                url: "{{ url('capitallcred') }}",
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


<div class="modal fade" id="exampleModalcred" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header" style="background: #37A000">
                <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Send Capitall
                    Credentials</h5>
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
                <form method="post" action="{{ url('sendcapitallcred') }}">
                    @csrf
                    <div class="row row-sm">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="font-weight-600">Enter Official Emailid *</label>
                                <input type="text" hidden name="teamid" id="capitallcredid">
                                <input type="text" required name="email" class="form-control"
                                    placeholder="Enter Official Emailid ">
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
