@extends('backEnd.layouts.layout') @section('backEnd_content')

<div class="body-content">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header" style="background-color: #36ce1a4f;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0"><i class="far fa-edit"></i>Critical Notes
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <fieldset class="form-group">
                        <table class="table display table-bordered table-striped table-hover">
                            <tbody>
                                <tr>
                                    <td><b>Financial Statement Classification Name :</b></td>
                                    <td>{{ $auditchecklistAnswer->financial_name}}</td>
                                </tr>
                                <tr>
                                    <td><b>Sub Financial Classfication Name :</b></td>
                                    <td>{{ $auditchecklistAnswer->subclassficationname}}</td>
                                </tr>
                                <tr>
                                    <td><b>Steplist Name :</b></td>
                                    <td>{{$auditchecklistAnswer->stepname}}</td>

                                </tr>
                                <tr>
                                    <td><b>Audit Question  :</b></td>
                                    <td>{{$auditchecklistAnswer->auditprocedure}}

                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </fieldset>
                    <div class="col-12">
                        <form method="post" action="{{ url('criticalnotes/store')}}" enctype="multipart/form-data">
                            @csrf
                            @component('backEnd.components.alert')
    
                            @endcomponent
                        <div class="row row-sm" >
                            <div class="col-12" >
                                <div class="form-group">
                                    <label class="font-weight-600"><b style="color: red;">Critical Notes
                                            :</b></label>
                                    <textarea id="summernote" rows="14" class="form-control" name="criticalnotes" value=""
                                      >{!! $criticalnotes->criticalnotes ??'' !!}</textarea>
                                      <input type="text" hidden name="auditquestionid" value="{{$auditchecklistAnswer->id}}"
                                      class="form-control">
                                      <input type="text" hidden name="assignmentgenerateid" value="{{$assignmentgenerateid}}"
                                      class="form-control">
                                </div>
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
                        
                        
                        </div>
                        </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/.body content-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
var theTotal = 0;
$('button').click(function(){
   theTotal = Number(theTotal) + Number($(this).val());
    $('#tussenstand').val(+theTotal);        
});

$('#tussenstand').val(+theTotal);
</script>
@endsection
