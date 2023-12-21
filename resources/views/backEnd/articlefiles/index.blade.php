@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('articlefiles/create')}}">Add Article File</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Article Details</small>
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
            <div class="table-responsive">
                <table id="example" class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr>
							<!-- <th>Download</th> -->
							<th>Created Date</th>
                            <th>Employee Name</th>
                             <th>Father Name</th>
                            <th> Mother Name</th>
                             <th>Date Of Birth</th> 
                             <th>Date Of Joining</th>
                            <th>Contact Of Father</th>
                            <th>Contact Of Mother</th>
                            <th>Mark Sheet Of 10th</th>
                            <th>Mark Sheet Of 12th</th>
                            <th>Marksheet/Degree Of B.Com</th>
							  <th>Marksheet/Degree Of B.Com</th>
							  <th>Marksheet/Degree Of NOC</th>
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
                        <!--  <th>Agreement</th> -->
                            <th>Bank Account Holder Name</th>
                            <th>Bank Account Name</th>
                            <th>Bank Account Number</th>
                            <th>IFSC Code</th>
                            <th>Branch Name</th>
                          
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($articlefilesDatas as $articlefileData)
                        <tr>
                        <!--  <td>  <a href="{{url('/zip/'.$articlefileData->id ??'')}}" 
                        class="btn btn-success btn">Download</a></td> -->
							<td> {{ date('F d,Y', strtotime($articlefileData->updated_at)) }}</td>
                         <td> <a href="{{route('articlefiles.edit', $articlefileData->id)}}">{{ $articlefileData->team_member }}</a></td>
                           <td>{{ $articlefileData->fathersname }}</td>
                            <td> {{ $articlefileData->mothersname }}</td>
                           <td> {{ date('F d,Y', strtotime($articlefileData->dob)) }}</td>
                            <td> {{ date('F d,Y', strtotime($articlefileData->doj)) }}</td>
                            <td> {{ $articlefileData->emergencycontactnumber }}</td>
                            <td> {{ $articlefileData->emergencycontactnumbertwo }}</td>
                            <td><a target="blank" href="{{url('/backEnd/image/articlefiles/'.$articlefileData->document10th ??'')}}">{{url('/backEnd/image/articlefiles/'.$articlefileData->document10th ??'')}} </a></td>
                          
                            <td><a target="blank" href="{{url('/backEnd/image/articlefiles/'.$articlefileData->document12th ??'')}}">
                               {{url('/backEnd/image/articlefiles/'.$articlefileData->document12th ??'')}} </a>
                            </td>
                            <td>@if($articlefileData->documentbcom==0)
                                <span >Regular</span>
                            
                               
                                @elseif($articlefileData->documentbcom==1)
                                <span >Distance</span>
                               
                                @else
                                <span >Not Pursuing</span>
                                @endif

                            </td>
							<td>@if($articlefileData->bcomcertificate != null)<a target="blank" href="{{url('/backEnd/image/articlefiles/'.$articlefileData->bcomcertificate ??'')}}">
                                  {{url('/backEnd/image/articlefiles/'.$articlefileData->bcomcertificate ??'')}}  </a>@endif
							</td>
							<td>@if($articlefileData->noc != null)<a target="blank" href="{{url('/backEnd/image/articlefiles/'.$articlefileData->noc ??'')}}">
                                       {{url('/backEnd/image/articlefiles/'.$articlefileData->noc ??'')}} </a>@endif</td>
                            <td>
								@if($articlefileData->cptcertificate != null)<a target="blank" href="{{url('/backEnd/image/articlefiles/'.$articlefileData->cptcertificate ??'')}}">
                            {{url('/backEnd/image/articlefiles/'.$articlefileData->cptcertificate ??'')}} </a>@endif
                            </td>
                            <td>
								@if($articlefileData->ipcccertificate != null)<a target="blank" href="{{url('/backEnd/image/articlefiles/'.$articlefileData->ipcccertificate ??'')}}">
                            {{url('/backEnd/image/articlefiles/'.$articlefileData->ipcccertificate ??'')}} </a>
								@endif
                            </td>
                            <td>
							@if($articlefileData->ipcccertificatetwo != null)	<a target="blank" href="{{url('/backEnd/image/articlefiles/'.$articlefileData->ipcccertificatetwo ??'')}}">
                            {{url('/backEnd/image/articlefiles/'.$articlefileData->ipcccertificatetwo ??'')}} </a>@endif
                            </td>
                            <td>
								@if($articlefileData->octrainingcertificate != null)<a target="blank" href="{{url('/backEnd/image/articlefiles/'.$articlefileData->octrainingcertificate ??'')}}">
                            {{url('/backEnd/image/articlefiles/'.$articlefileData->octrainingcertificate ??'')}} </a>@endif
                            </td>
                            <td><a target="blank" href="{{url('/backEnd/image/articlefiles/'.$articlefileData->itttrainingcertificate ??'')}}">
                            {{url('/backEnd/image/articlefiles/'.$articlefileData->itttrainingcertificate ??'')}} </a>
                            </td>
                            <td><a target="blank" href="{{url('/backEnd/image/articlefiles/'.$articlefileData->residenceproof ??'')}}">
                            {{url('/backEnd/image/articlefiles/'.$articlefileData->residenceproof ??'')}} </a>
                            </td>
                            <td><a target="blank" href="{{url('/backEnd/image/articlefiles/'.$articlefileData->residenceprooftwo ??'')}}">
                            {{url('/backEnd/image/articlefiles/'.$articlefileData->residenceprooftwo ??'')}} </a>
                            </td>
                            <td>
								@if($articlefileData->pancard != null)<a target="blank" href="{{url('/backEnd/image/articlefiles/'.$articlefileData->pancard ??'')}}">
                            {{url('/backEnd/image/articlefiles/'.$articlefileData->pancard ??'')}} </a>@endif
                            </td>
                            <td><a target="blank" href="{{url('/backEnd/image/articlefiles/'.$articlefileData->photograph ??'')}}">
                            {{url('/backEnd/image/articlefiles/'.$articlefileData->photograph ??'')}} </a>
                            </td>
                            <td>
								@if($articlefileData->copyof != null)<a target="blank" href="{{url('/backEnd/image/articlefiles/'.$articlefileData->copyof ??'')}}">
                            {{url('/backEnd/image/articlefiles/'.$articlefileData->copyof ??'')}} </a>@endif
                            </td>
                            <td>@if($articlefileData->copyoftwo != null)<a target="blank" href="{{url('/backEnd/image/articlefiles/'.$articlefileData->copyoftwo ??'')}}">
                            {{url('/backEnd/image/articlefiles/'.$articlefileData->copyoftwo ??'')}} </a>@endif
                            </td>
                            <td>@if($articlefileData->additional != null)<a target="blank" href="{{url('/backEnd/image/articlefiles/'.$articlefileData->additional ??'')}}">
                            {{url('/backEnd/image/articlefiles/'.$articlefileData->additional ??'')}} </a>@endif
                            </td>
                     <!--   <td>@if($articlefileData->agreement != null)<a target="blank" href="{{url('/backEnd/image/articlefiles/'.$articlefileData->agreement ??'')}}">
                            {{url('/backEnd/image/articlefiles/'.$articlefileData->agreement ??'')}} </a>@endif
                            </td>  -->
                            <td> {{ $articlefileData->accountholder }}</td>
                            <td> {{ $articlefileData->accountname }}</td>
                            <td> {{ $articlefileData->accountnumber }}</td>
                            <td> {{ $articlefileData->ifsccode }}</td>
                            <td> {{ $articlefileData->branch }}</td>
                           
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
