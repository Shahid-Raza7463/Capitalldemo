<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <!-- <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('candidate/create')}}">Add Contract and Subscription</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav> -->
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Article Onboarding List</small>
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
            <div class="table-responsive">
                <table id="example" class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>CRO/NRO No</th>
                            <th>Date Of Birth</th>
                            <th>Date Of Joining</th>
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
                            <th>Name of Previous Organization Form</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($articlebordingDatas as $articlebordingData)
                        <tr>
                            <td> {{ $articlebordingData->name }}</td>
                            <td> {{ $articlebordingData->contactno }}</td>
                            <td> {{ $articlebordingData->emailid }}</td>
                            <td> {{ $articlebordingData->cro_nro_no }}</td>
                            <td> {{ date('F d,Y', strtotime($articlebordingData->dob)) }}</td>
                            <td> {{ date('F d,Y', strtotime($articlebordingData->doj)) }}</td>
                            <td>{{ $articlebordingData->fathersname }}</td>
                            <td> {{ $articlebordingData->emergencycontactnumber }}</td>
                            <td> {{ $articlebordingData->mothersname }}</td>
                            <td> {{ $articlebordingData->emergencycontactnumbertwo }}</td>
                            <td><a target="blank"
                                    href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/'.$articlebordingData->document10th, now()->addMinutes(30)) }}">
                                    {{ $articlebordingData->document10th ??'Not Uploaded'}} </a></td>
                            <td><a target="blank"
                                    href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/'.$articlebordingData->document12th, now()->addMinutes(30)) }}">
                                    {{ $articlebordingData->document12th ??'Not Uploaded'}} </a></td>
                            <td>@if($articlebordingData->documentbachelor==0)
                                <span class="badge badge-pill badge-warning">Pursuing</span><br>
                                <span>Type of Course :
                                    @if($articlebordingData->documentbcom==0)
                                    <span class="badge badge-pill badge-warning">Regular</span>
                                    <br>
                                    <span>Mark Sheet :</span>
                                    <a target="blank"
                                        href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/'.$articlebordingData->bcomcertificate, now()->addMinutes(30)) }}">
                                        {{ $articlebordingData->bcomcertificate ??'Not Uploaded'}} </a><br>
                                    <span>NOC : </span>
                                    <a target="blank"
                                        href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/'.$articlebordingData->noc, now()->addMinutes(30)) }}">
                                        {{ $articlebordingData->noc ??'Not Uploaded'}} </a>
                                    @elseif($articlebordingData->documentbcom==1)
                                    <span class="badge badge-pill badge-warning">Distance</span>
                                    <br><span>Mark Sheet :</span>
                                    <a target="blank"
                                        href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/'.$articlebordingData->bcomcertificate, now()->addMinutes(30)) }}">
                                        {{ $articlebordingData->bcomcertificate ??'Not Uploaded'}} </a>
                                    @endif
                                </span>
                                @elseif($articlebordingData->documentbachelor==1)
                                <span class="badge badge-pill badge-success">Not Pursuing</span>
                                @elseif($articlebordingData->documentbachelor==2)
                                <span class="badge badge-pill badge-danger">Completed</span>
                                <br><span> Attached Degree Mark Sheet : </span> <a target="blank"
                                    href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/'.$articlebordingData->bachelorattached, now()->addMinutes(30)) }}">
                                    {{ $articlebordingData->bachelorattached ??'Not Uploaded'}} </a>
                                @endif</td>
                            <td><a target="blank"
                                    href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/'.$articlebordingData->cptcertificate, now()->addMinutes(30)) }}">
                                    {{ $articlebordingData->cptcertificate ??'Not Uploaded'}} </a></td>
                            <td><a target="blank"
                                    href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/'.$articlebordingData->ipcccertificate, now()->addMinutes(30)) }}">
                                    {{ $articlebordingData->ipcccertificate ??'Not Uploaded'}} </a></td>
                            <td><a target="blank"
                                    href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/'.$articlebordingData->ipcccertificatetwo, now()->addMinutes(30)) }}">
                                    {{ $articlebordingData->ipcccertificatetwo ??'Not Uploaded'}} </a></td>
                            <td><a target="blank"
                                    href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/'.$articlebordingData->octrainingcertificate, now()->addMinutes(30)) }}">
                                    {{ $articlebordingData->octrainingcertificate ??'Not Uploaded'}} </a></td>
                            <td><a target="blank"
                                    href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/'.$articlebordingData->itttrainingcertificate, now()->addMinutes(30)) }}">
                                    {{ $articlebordingData->itttrainingcertificate ??'Not Uploaded'}} </a></td>

                            <td><a target="blank"
                                    href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/'.$articlebordingData->residenceproof, now()->addMinutes(30)) }}">
                                    {{ $articlebordingData->residenceproof ??'Not Uploaded'}} </a></td>

                            <td><a target="blank"
                                    href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/'.$articlebordingData->residenceprooftwo, now()->addMinutes(30)) }}">
                                    {{ $articlebordingData->residenceprooftwo ??'Not Uploaded'}} </a></td>

                            <td><a target="blank"
                                    href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/'.$articlebordingData->pancard, now()->addMinutes(30)) }}">
                                    {{ $articlebordingData->pancard ??'Not Uploaded'}} </a></td>

                            <td><a target="blank"
                                    href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/'.$articlebordingData->photograph, now()->addMinutes(30)) }}">
                                    {{ $articlebordingData->photograph ??'Not Uploaded'}} </a></td>

                            <td><a target="blank"
                                    href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/'.$articlebordingData->copyof, now()->addMinutes(30)) }}">
                                    {{ $articlebordingData->copyof ??'Not Uploaded'}} </a></td>

                            <td><a target="blank"
                                    href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/'.$articlebordingData->copyoftwo, now()->addMinutes(30)) }}">
                                    {{ $articlebordingData->copyoftwo ??'Not Uploaded'}} </a></td>

                            <td><a target="blank"
                                    href="{{ Storage::disk('s3')->temporaryUrl('articleonboarding/'.$articlebordingData->additional, now()->addMinutes(30)) }}">
                                    {{ $articlebordingData->additional ??'Not Uploaded'}} </a></td>

                            <td> {{ $articlebordingData->accountholder }}</td>
                            <td> {{ $articlebordingData->accountname }}</td>
                            <td> {{ $articlebordingData->accountnumber }}</td>
                            <td> {{ $articlebordingData->ifsccode }}</td>
                            <td> {{ $articlebordingData->branch }}</td>
                          <td>    <a  class="btn btn-success"  id="editss" data-toggle="modal" data-id="{{ $articlebordingData->id }}"
                            data-target="#exampleModal122" style="color: white">View</a></td>


                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!--/.body content-->
@endsection
<div class="modal fade" id="exampleModal122" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
         
                <div class="modal-header" style="background: #37A000">
                    <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Previous Training Details</h5>
                    <div>
                        <ul>
                            @foreach ($errors->all() as $e)
                            <li style="color:red;">{{$e}}</li>
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
    $(function () {
        $('body').on('click', '#editss', function (event) {
    //        debugger;
            var id = $(this).data('id');
     debugger;
            $.ajax({
                type: "GET",

                url: "{{ url('articleprevious') }}",
                data: "id=" + id,
                success : function(response){
           // alert(res);
           debugger;
           $('#out_idd').html(response);
          


            
        },
                error: function () {

                },
            });
        });
    });

</script>
