
@extends('backEnd.layouts.layout') @section('backEnd_content')

<div class="body-content">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header" style="background: #37A000;">
                    <div class="d-flex justify-content-between align-items-center">
                      
						 <div class="col-md-6">
                            <h6 style="color: white" class="fs-17 font-weight-600 mb-0">Personal Information Details</h6>
                        </div>
						<div class="col-md-5">
						</div>
						<div class="col-md-1">
                            <h6 style="color: white" class="fs-17 font-weight-600 mb-0"><a href="{{ url()->previous() }}" >Back <i class="fa fa-reply"></i></a></h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                   
                        <div class="row row-sm">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Name
                                        </label>
                                    <input readonly type="text" name="name" value="{{ $personals->name ?? ''}}" class="form-control"
                                        placeholder="Enter Name">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Father’s Name                                        </label>
                                    <input readonly type="text" name="fathersname" value="{{ $personals->fathersname ?? ''}}" class="form-control"
                                        placeholder="Enter Father’s Name ">
                                        <input readonly type="text" hidden value="{{ $id }}" name="informationresource_id" class="form-control"
                                        placeholder="Enter Tenant Name ">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-600">Date of Birth</label>
                                    <input readonly type="date" name="dateofbirth" value="{{ $personals->dateofbirth ?? ''}}" class="form-control"
                                        placeholder="Enter Date of Birth">
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">PAN</label>
                                  
                                        <div class="row">

                                            <div class="col-sm-6">
                                                <input readonly type="text" name="pan" value="{{ $personals->pan ?? ''}}"
                                                    class="form-control" placeholder="Enter PAN">
                                            </div>
                                            @if(!empty($personals->panfile))
                                            <div class="col-sm-6">
                                               
    <a href="{{ url('backEnd/image/ilrper/'.$personals->panfile ??'')}}" target="blank" data-toggle="tooltip"
        title="{{ $personals->panfile ??'' }}" class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
                                            </div>
                                            @endif
                                        </div>
                                </div>
                            </div>
                            
                           
                        </div>
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Adhaar No</label>
                                  
                                        <div class="row">

                                            <div class="col-sm-6">
                                                <input readonly type="text" name="adharno" value="{{ $personals->adharno ?? ''}}"
                                                    class="form-control" placeholder="Enter Adhaar No">
                                            </div>
                                            @if(!empty($personals->adharnofile))
                                            <div class="col-sm-6">
                                    <a href="{{ url('backEnd/image/ilrper/'.$personals->adharnofile ??'')}}" target="blank" data-toggle="tooltip"
        title="{{ $personals->adharnofile ??'' }}" class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
                                            </div>
                                            @endif
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Address (Residence/ Office/ Owned/ Rented)
                                        </label>
                                    <textarea rows="4" readonly name="address" value="" class="centered form-control" id="editor"
                                        placeholder="Enter Address">{!! $personals->address ??'' !!}</textarea>
                                </div>
                            </div>
                        </div>
                  

                </div>
            </div>
        </div>
    </div>
</div>
<!--/.body content-->
@endsection
                      

