@extends('client.layouts.layout') @section('client_content')
<style>
    a{
        cursor: pointer;
    }
</style>
<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">

    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Checklist List</small>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="card mb-4">

        <div class="card-body">
            <div>
                @if(session()->has('success'))
                <div class="alert alert-success">
                    @if(is_array(session()->get('success')))
                    @foreach (session()->get('success') as $message)
                    <p>{{ $message }}</p>
                    @endforeach
                    @else
                    <p>{{ session()->get('success') }}</p>
                    @endif
                </div>
                @endif
                @if(session()->has('statuss'))
                <div class="alert alert-danger">
                    @if(is_array(session()->get('statuss')))
                    @foreach (session()->get('statuss') as $message)
                    <p>{{ $message }}</p>
                    @endforeach
                    @else
                    <p>{{ session()->get('success') }}</p>
                    @endif
                </div>
                @endif
                <div>
                    <ul>
                        @foreach ($errors->all() as $e)
                        <li style="color:red;">{{$e}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="table-responsive">
               <table id="example" class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>S_No by</th>
                            <th style="padding-right: 150px;">Agreement</th>
                            <th>Agreement_With</th>
                            <th>Universities_Name</th>
                            <th style="padding-right: 200px;">Course_Name</th>
                            <th style="padding-right: 200px;">Certificate_Type</th>
                            <th>Certificate_issued_by</th>
                            <th>Date_of_Agreement</th>
                            <th>starting_date_for_the_course</th>
                            <th>End_date_for_the_course</th>
                            <th>Batch_No</th>
                            <th>Period_of_Course</th>
                            <th>Type_of_Agreement</th>
                            <th>Total_Fees_Fees_INR</th>
                            <th>Total_Fees_Fees_USD</th>
                            <th>Fees_rendered_to_the_university</th>
                            <th>Fees_rendered_to_the_AESPL</th>
                            <th>Installments</th>
                            <th>Date_of_Installments_upto</th>
                            <th>Amount_of_Installment_In_INR</th>
                            <th>Amount_of_Installment_In_USD</th>
                            <th>Total_value_of_contract</th>
                            <th>Total_value_of_collection</th>
                            <th>Total_Value_of_collection_up_31st_March</th>
                            <th>Total_Amount_to_be_collected</th>
                            <th style="padding-right: 700px;">Remarks_as_per_agreements</th>
                            <th>Other_Remarks</th>
                            <th style="padding-right: 700px;">Assignment Permitited or not</th>
                            <th style="padding-right: 700px;">Termination grounds by Arrina including notice period</th>
							 <th style="padding-right: 700px;">Termination grounds by Counterparties including notice period</th>
                            <th style="padding-right: 700px;">Termination consequences By Arrina</th>
							<th style="padding-right: 700px;">Termination_consequences_by_Counterparties</th>
							<th style="padding-right: 700px;">including_arbitration_Governing_law_Jurisdiction_of_courts</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ilrlist as $ilrlistData)
                        <tr>
                            <td>{{$ilrlistData->S_No ??''}}</td>
                            @if($ilrlistData->file == null)
                                <td><a data-toggle="modal" style="color: green" id="{{ $ilrlistData->id }}" onClick="reply_click(this.id)" data-target="#exampleModal12">{{$ilrlistData->Agreement ??''}}</a></td>
                           @else
                           <td><a data-toggle="tooltip"
                            title="{{ $ilrlistData->remark }}" class="btn btn-success"    href="{{ Storage::disk('s3')->temporaryUrl('talentedgeilr/'.$ilrlistData->file, now()->addMinutes(10)) }}"><i class="fas fa-download"></i> {{$ilrlistData->file ??''}}</a></td>
                           @endif
                            <td>{{$ilrlistData->Agreement_With ??''}}</td>
                            <td>{{$ilrlistData->Universities_Name ??''}}</td>
                            <td>{{$ilrlistData->Course_Name ??''}}</td>
                            <td>{{$ilrlistData->Certificate_Type ??''}}</td>
                            <td>{{$ilrlistData->Certificate_issued_by ??''}}</td>
                            <td>{{$ilrlistData->Date_of_Agreement ??''}}</td>
                            <td>{{$ilrlistData->starting_date_for_the_course ??''}}</td>
                            <td>{{$ilrlistData->End_date_for_the_course ??''}}</td>
                            <td>{{$ilrlistData->Batch_No ??''}}</td>
                            <td>{{$ilrlistData->Period_of_Course ??''}}</td>
                            <td>{{$ilrlistData->Type_of_Agreement ??''}}</td>
                            <td>{{$ilrlistData->Total_Fees_Fees_INR ??''}}</td>
                            <td>{{$ilrlistData->Total_Fees_Fees_USD ??''}}</td>
                            <td>{{$ilrlistData->Fees_rendered_to_the_university ??''}}</td>
                            <td>{{$ilrlistData->Fees_rendered_to_the_AESPL ??''}}</td>
                            <td>{{$ilrlistData->Installments ??''}}</td>
                            <td>{{$ilrlistData->Date_of_Installments_upto ??''}}</td>
                            <td>{{$ilrlistData->Amount_of_Installment_In_INR ??''}}</td>
                            <td>{{$ilrlistData->Amount_of_Installment_In_USD ??''}}</td>
                            <td>{{$ilrlistData->Total_value_of_contract ??''}}</td>
                            <td>{{$ilrlistData->Total_value_of_collection ??''}}</td>
                            <td>{{$ilrlistData->Total_Value_of_collection_up_31st_March ??''}}</td>
                            <td>{{$ilrlistData->Total_Amount_to_be_collected ??''}}</td>
                            <td>{{$ilrlistData->Remarks_as_per_agreements ??''}}</td>
                            <td>{{$ilrlistData->Other_Remarks ??''}}</td>
                          
							 <td>{{$ilrlistData->Assignment_Permitited_or_not ??''}}</td>
                            <td>{{$ilrlistData->Termination_grounds_by_Arrina_including_notice_period ??''}}</td>
							 <td>{{$ilrlistData->Termination_grounds_by_Counterparties_including_notice_period ??''}}</td>
                            <td>{{$ilrlistData->Termination_consequences_By_Arrina ??''}}</td>
							 <td>{{$ilrlistData->Termination_consequences_by_Counterparties ??''}}</td>
							 <td>{{$ilrlistData->including_arbitration_Governing_law_Jurisdiction_of_courts ??''}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!--/.body content-->

<!-- Modal -->
<div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('/client/ilrt/store')}}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background: #37A000">
                    <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel4">Add Remark</h5>
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

                    <div class="details-form-field form-group row">
                        <label for="name" class="col-sm-3 col-form-label font-weight-600">File :</label>
                        <div class="col-sm-9">
                            <input id="name" class="form-control" name="file" type="file">
                            <input id="editilrid" hidden class="form-control" name="ilrid" type="text">
                        </div>

                    </div>
                    <div class="details-form-field form-group row">
                        <label for="name" class="col-sm-3 col-form-label font-weight-600">Remark :</label>
                        <div class="col-sm-9">
                            <textarea rows="3" name="remark" class="form-control"
        placeholder="Enter Remarks"></textarea>
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
<script type="text/javascript">
    function reply_click(clicked_id)
    {
        document.getElementById('editilrid').value = clicked_id;
    }
  </script>
@endsection
