 <!--Third party Styles(used by this page)-->
 <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">

 @extends('backEnd.layouts.layout') @section('backEnd_content')

 <!--Content Header (Page header)-->
 <div class="content-header row align-items-center m-0">
     <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
         {{-- <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('tax/create')}}">Add Investment Declaration</a></li>
         <li class="breadcrumb-item active">+</li>
         </ol> --}}
     </nav>
     <div class="col-sm-8 header-title p-0">
         <div class="media">
             <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
             <div class="media-body">
                 <h1 class="font-weight-bold">Home</h1>
                 <small>Investment Declaration Details</small>
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
             <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);">

                 <div class="card-body">


                     <fieldset class="form-group">

                         <table class="table display table-bordered table-striped table-hover">

                             <tbody>

                                 <tr>
                                     <td><b>Createdby : </b></td>
                                     <td>{{ App\Models\Teammember::select('team_member')->where('id',$tax->createdby)->first()->team_member ?? ''}}
                                     </td>
                                     <td><b>Created Date</b></td>
                                     <td>{{ date('F d,Y', strtotime($tax->created_at)) }}</td>
                                 </tr>
                                 <tr>
                                     <td><b>Gross Salary</b></td>
                                     <td>{{ $tax->gross_salary }}</td>
                                     <td><b>TDS</b></td>
                                     <td>{{ $tax->tds }}</td>
                                 </tr>

                                 <tr>
                                     <td><b>Tax Regime</b></td>
                                     <td>@if($tax->tax_regime==0)
                                         <span>Old</span>
                                         @elseif($tax->tax_regime==1)
                                         <span>New</span>
                                         @endif</td>
                                     @if($tax->anyotherincome != null)
                                     <td><b>Any Other Income</b></td>
                                     <td>{{ $tax->anyotherincome }}</td>
                                     @endif

                                 </tr>
								  @if($tax->year != null)
								   <tr>
                                     <td><b>Financial Year</b></td>
                                     <td>@if($tax->year==2022)
                                         <span>2022-23</span>
                                         @elseif($tax->year==2023)
                                         <span>2023-24</span>
                                         @endif</td>
								 </tr>
								 @endif


                             </tbody>

                         </table>
                         @if($tax->advancetaxamount != null )
                         <div class="row row-sm ">
                             <div class="col-12">
                                 <table class="table table-bordered">
                                     <tr>
                                         <td colspan="5" style="text-align:center;"><b>Deduction</b></td>
                                     </tr>
                                     <tr style="background: #37A000;color:#F4F4F5;">
                                         <th>Sr.No</th>
                                         <th>Section</th>
                                         <th>Description</th>
                                         <th>Deduction Amount</th>
                                         {{-- <th>Attachment</th> --}}
                                     </tr>
                                     <tbody>
                                         @php
                                         $taxData = DB::table('taxsection')
                                         ->where('taxid',$tax->id)->get();
                                         // dd($taxData);
                                         $i=1;
                                         @endphp
                                         @foreach($taxData as $taxDatas)
                                         <tr>
                                             <td>
                                                 <small>{{$i++}}</small>
                                             </td>
                                             <td>{{$taxDatas->section ??''}}</td>
                                             <td>{{$taxDatas->description ??''}}</td>
                                             <td>{{$taxDatas->deductionamount ??''}}</td>
                                             {{-- <td><a target="blank"
                                                     href="{{url('/backEnd/image/tax/'.$taxDatas->filess)}}">{{ $taxDatas->filess ??''}}</a>
                                             </td> --}}
                                         </tr>
                                         @endforeach
                                     </tbody>
                                 </table>
                             </div>
                         </div>
                         <br>

                         <table class="table display table-bordered table-striped table-hover">
                             <tr>
                                 <td colspan="5" style="text-align:center;background:#37A000;color:white;"><b>Any Other
                                         Income</b></td>
                             </tr>
                             <tbody>

                                 <tr>
                                     <td><b>Section : </b></td>
                                     <td>{{ $tax->othersection }}
                                     </td>
                                     <td><b>Description</b></td>
                                     <td>{{ $tax->otherdescription }}</td>
                                 </tr>
                                 <tr>
                                     <td><b>Tax Amount</b></td>
                                     <td>{{ $tax->taxamount }}</td>
                                     {{-- <td><b>Attachment</b></td>
                                     <td><a target="blank"
                                             href="{{url('/backEnd/image/tax/'.$tax->otherattachment)}}">{{ $tax->otherattachment ??''}}</a>
                                     </td> --}}
                                 </tr>

                             </tbody>

                         </table>
                         <br>
                         <table class="table display table-bordered table-striped table-hover">
                             <tr>
                                 <td colspan="5" style="text-align:center;background:#37A000;color:white;"><b>Approval
                                         Advance Tax</b></td>
                             </tr>
                             <tbody>

                                 <tr>
                                     <td><b>Amount : </b></td>
                                     <td>{{ $tax->advancetaxamount }}
                                     </td>
                                     {{-- <td><b>Attachment</b></td>
                                     <td><a target="blank"
                                             href="{{url('/backEnd/image/tax/'.$tax->advanceetaxattachment)}}">{{ $tax->advanceetaxattachment ??''}}</a>
                                     </td> --}}
                                 </tr>


                             </tbody>

                         </table>
                         @endif
                     </fieldset>
                 </div>
             </div>
         </div>
     </div>

 </div>
 @endsection
