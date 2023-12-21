
@extends('client.layouts.layout') @section('client_content')

<div class="body-content">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header" style="background: #37A000;">
                    <div class="d-flex justify-content-between align-items-center">
                        
						     
                        
                        <div class="col-md-6">
                            <h6 style="color: white" class="fs-17 font-weight-600 mb-0">Add Income from Other Sources</h6>
                        </div>
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-1">
                             <a data-toggle="modal" data-target="#exampleModal12" style="color:white;">Action</a>
                        </div>
                        <div class="col-md-1">

                            <h6 style="color: white" class="fs-17 font-weight-600 mb-0"><a
                                    href="{{ url('client/informationlist/'.$folderid->parent_id) }}">Back <i class="fa fa-reply"></i></a></h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
					  @if(empty($personals->type))
                    <form method="post" action="{{ url('client/incomefromsources/store')}}" enctype="multipart/form-data">
                        @csrf
                        @component('backEnd.components.alert')

                        @endcomponent
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Interest from Savings Bank A/C </label>
                                   
                                        <div class="row">

                                            <div class="col-sm-6">
                                                <input type="text" name="interestfromsaving" value="{{ $personals->interestfromsaving ?? ''}}"
                                                    class="form-control" placeholder="Enter Interest from Savings Bank A/C ">
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="file" name="interestfromsavingfile"
                                                    value="{{ $personals->interestfromsaving ?? ''}}" class="form-control"
                                                    placeholder="Enter Interest from Savings Bank a/c
    ">
    <input type="text" hidden value="{{ $id }}" name="informationresource_id" class="form-control"
    placeholder="Enter Tenant Name ">
 </div>
				 <div class="col-sm-3">
					   @if(!empty($personals->interestfromsavingfile))
                                        <div class="col-sm-6">
                                            <a href="{{ url('backEnd/image/ilrbp/'.$personals->interestfromsavingfile ??'')}}"
                                                target="blank" data-toggle="tooltip"
                                                title="{{ $personals->interestfromsavingfile ??'' }}"
                                                class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
                                        </div>
                                        @endif
											</div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Interest from FDR
                                        </label>
                                        
                                        <div class="row">

                                            <div class="col-sm-6">
                                                <input type="text" name="interestfromfdr" value="{{ $personals->interestfromfdr ?? ''}}"
                                                    class="form-control" placeholder="Enter Interest from FDR">
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="file" name="interestfromfdrfile"
                                                    value="{{ $personals->interestfromsaving ?? ''}}" class="form-control"
                                                    placeholder="Enter Interest from Savings Bank a/c
    ">
                                            </div>
											 <div class="col-sm-3">
												   @if(!empty($personals->interestfromfdrfile))
                                        <div class="col-sm-6">
                                            <a href="{{ url('backEnd/image/ilrbp/'.$personals->interestfromfdrfile ??'')}}"
                                                target="blank" data-toggle="tooltip"
                                                title="{{ $personals->interestfromfdrfile ??'' }}"
                                                class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
                                        </div>
                                        @endif
											</div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Other Interest (Please Specify)
                                        </label>
                                   
                                        <div class="row">

                                            <div class="col-sm-6">
                                                <input type="text" name="other" value="{{ $personals->other ?? ''}}"
                                                    class="form-control" placeholder="Enter Other Interest">
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="file" name="otherfile"
                                                    value="{{ $personals->interestfromsaving ?? ''}}" class="form-control"
                                                    placeholder="Enter Interest from Savings Bank a/c
    ">
                                            </div>
											<div class="col-sm-3">
												  @if(!empty($personals->otherfile))
                                        <div class="col-sm-6">
                                            <a href="{{ url('backEnd/image/ilrbp/'.$personals->otherfile ??'')}}"
                                                target="blank" data-toggle="tooltip"
                                                title="{{ $personals->otherfile ??'' }}"
                                                class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
                                        </div>
                                        @endif
											</div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Dividend Income </label>
                                   
                                        <div class="row">

                                            <div class="col-sm-6">
                                                <input type="text" name="dividend" value="{{ $personals->dividend ?? ''}}"
                                                    class="form-control" placeholder="Enter Dividend Income ">
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="file" name="dividendfile"
                                                    value="{{ $personals->interestfromsaving ?? ''}}" class="form-control"
                                                    placeholder="Enter Interest from Savings Bank a/c
    ">
                                            </div>
											<div class="col-sm-3">
											@if(!empty($personals->dividendfile))
                                        <div class="col-sm-6">
                                            <a href="{{ url('backEnd/image/ilrbp/'.$personals->dividendfile ??'')}}"
                                                target="blank" data-toggle="tooltip"
                                                title="{{ $personals->dividendfile ??'' }}"
                                                class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
                                        </div>
                                        @endif
											</div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Any Other Income Not Covered Above
                                        </label>
                                   
                                        <div class="row">

                                            <div class="col-sm-6">
                                                <input type="text" name="anyother" value="{{ $personals->anyother ?? ''}}"
                                                    class="form-control" placeholder="Enter Any Other Income Not Covered Above">
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="file" name="anyotherfile"
                                                    value="{{ $personals->interestfromsaving ?? ''}}" class="form-control"
                                                    placeholder="Enter Interest from Savings Bank a/c
    ">
                                            </div>
											 <div class="col-sm-3">
                                        @if(!empty($personals->anyotherfile))
                                        <div class="col-sm-6">
                                            <a href="{{ url('backEnd/image/ilrbp/'.$personals->anyotherfile ??'')}}"
                                                target="blank" data-toggle="tooltip"
                                                title="{{ $personals->anyotherfile ??'' }}"
                                                class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
                                        </div>
                                        @endif
                                    </div>
                                        </div>
                                </div>
                            </div>
                          
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
                           
                        
                        </div>

                    </form>
  @else
                    <h5 style="text-align: center"><span>Not Applicable</span></h5>

                  @endif

                </div>
            </div>
        </div>
    </div>
</div>
<!--/.body content-->
<div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{ url('client/incomefromsources/store')}}" enctype="multipart/form-data">

                @csrf
                <div class="modal-header" style="background:#37A000;color:white;">
                    <h5 class="modal-title font-weight-600" id="exampleModalLabel4">Action</h5>

                    <button style="color: white" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <select name="type" class="form-control">
                        <!--placeholder-->
                        <option value="0">Applicable</option>
                        <option value="1">Not Applicable</option>

                    </select>
                    <input type="text" hidden value="{{ $id }}" name="informationresource_id" class="form-control"
                        placeholder="Enter Tenant Name ">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
            </form>

        </div>
    </div>
</div>
@endsection
                      

