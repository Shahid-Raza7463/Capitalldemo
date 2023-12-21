
@extends('backEnd.layouts.layout') @section('backEnd_content')
<style>
    .wysihtml5-sandbox{
        height: 120px;
    }
</style>
<div class="body-content">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                   <div class="d-flex justify-content-between align-items-center">
                        <div class="col-4">
                            <h6 class="fs-17 font-weight-600 mb-0">Add Checklist</h6>
                       </div>
                       <div class="col-2">
                       <a data-toggle="modal" data-target="#exampleModal1"><h6 class="fs-17 font-weight-600 mb-0">Add Modify Checklist</h6></a>
                    </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('step.store')}}" enctype="multipart/form-data">
                        @csrf
                  @component('backEnd.components.alert')

                  @endcomponent
                  <div class="row row-sm">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="font-weight-600">Assignment Name</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="assignment_id"
                                @if(Request::is('step/*/edit'))> <option disabled style="display:block">Please Select One</option>
                
                                @foreach($assignment as $assignmentData)
                                <option value="{{$assignmentData->id}}"
                                    {{$step->assignment->id== $assignmentData->id??'' ?'selected="selected"' : ''}}>
                                    {{$assignmentData->assignment_name }}</option>
                                @endforeach
                
                
                                @else
                                <option></option>
                                <option value="">Please Select One</option>
                                @foreach($assignment as $assignmentData)
                                <option value="{{$assignmentData->id}}">
                                    {{ $assignmentData->assignment_name }}</option>
                
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="font-weight-600">Upload Excel</label>
                            <input type="file" class="form-control key" name="file"  value=""  placeholder="Enter Excel">
                     
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label class="font-weight-600">Upload Excel Template</label>
                            <br>
                            <a href="{{ url('backEnd/ChecklistFormat.xlsx')}}"
                            class="btn btn-success btn"><i class="fas fa-file-excel" style="margin-right: 4px;"></i>SAMPLE</a>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label class="font-weight-600">Action</label><br>
                            <button type="submit" class="btn btn-primary"> Submit</button>
                        </div>
                    </div>
                   
                </div>
            </form>
            <form method="post" action="{{ url('checklist/store')}}" enctype="multipart/form-data">
            @csrf
                <div class="row row-sm">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="font-weight-600">Financialstatement classification.</label>
                            <select class="form-control " name="financialstatemantclassfication_id" id="category">
                           
                            <option>Please Select One</option>
                            @foreach($financial as $financialData)
                            <option value="{{$financialData->id}}" @if(!empty($store->
                                financial) && $store->
                                financial==$financialData->id) selected @endif>
                                {{ $financialData->financial_name }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    
                    <div class="col-4">
                        <div class="form-group">
                            <label class="font-weight-600">Sub Financialstatementclassification.</label>
                            <select class="form-control" id="subcategory_id" name="subclassfied_id">
                                <option disabled style="display:block">Please Select One</option>
                                @if(!empty($store->city))
                                <option value="{{ $store->subcategory_id }}">
                                    {{ App\Location::where('id',$store->city)->first()->cityname ??'' }}
                                </option>
                
                                @endif 
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="font-weight-600">Step Name</label>
                            <select class="form-control" id="step_id" name="steplist_id">
                                <option disabled style="display:block">Please Select One</option>
                                @if(!empty($store->city))
                                <option value="{{ $store->subcategory_id }}">
                                    {{ App\Location::where('id',$store->city)->first()->cityname ??'' }}
                                </option>
                
                                @endif 
                            </select>
                        </div>
                    </div>
                    {{-- <div class="col-3">
                        <div class="form-group">
                            <label class="font-weight-600">Under Tab</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="tab_id" @if(Request::is('step/*/edit'))>
                                <option disabled style="display:block">Please Select One</option>
                
                                @foreach($tab as $tabData)
                                <option value="{{$tabData->id}}" {{$step->tab->id== $tabData->id??'' ?'selected="selected"' : ''}}>
                                    {{$tabData->tabname }}</option>
                                @endforeach
                
                
                                @else
                                <option></option>
                                <option value="">Please Select One</option>
                                @foreach($tab as $tabData)
                                <option value="{{$tabData->id}}">
                                    {{ $tabData->tabname }}</option>
                
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div> --}}
                   
                   
                   
                </div>
                <br>
                <div class="table-responsive">
                    <table class="table display table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="font-weight-600">Sr No.</th>
                                <th class="font-weight-600">Audit Procedure</th>
                            </tr>
                        </thead>
                        <tbody id="audit_id">
                      
                        </tbody>
                    </table>
                
                </div>
                
                <div class="row row-sm">
                    <div class="col-11">
                        <div class="form-group">
                            <label class="font-weight-600">Add Audit Procedure.</label>
                        
                            <textarea name="auditprocedure" value="{{ $step->c_address ?? ''}}" class="form-control"
                                placeholder="Enter Audit Procedure">{!! $step->c_address ??'' !!}</textarea>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <br><br>
                          <button type="submit" class="btn btn-info btn">+</button>
                        </div>
                    </div>
                </div>
            </form>
                
                   
                   
                    <hr class="my-4">

                </div>
            </div>
        </div>
    </div>
</div>
<!--/.body content-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(function(){
       $('#category').on('change',function(){
           var category_id =$(this).val();

        $.ajax({
            type: "GET",
            url: "{{ url('step/create') }}",
            data: "category_id="+category_id,
            success : function(res){
            
                $('#subcategory_id').html(res);

                
            },
            error : function(){

            },
        });
       });
       $('#subcategory_id').on('change',function(){
           var subcategory_id =$(this).val();

        $.ajax({
            type: "GET",
            url: "{{ url('step/create') }}",
            data: "subcategory_id="+subcategory_id,
            success : function(res){
            
                $('#step_id').html(res);

                
            },
            error : function(){

            },
        });
       });
       $('#step_id').on('change',function(){
           var step_id =$(this).val();

        $.ajax({
            type: "GET",
            url: "{{ url('step/create') }}",
            data: "step_id="+step_id,
            success : function(res){
            
                $('#audit_id').html(res);

                
            },
            error : function(){

            },
        });
       });
         $('#client').on('change',function(){
           var category_id =$(this).val();

        $.ajax({
            type: "GET",
            url: "{{ url('step/create') }}",
            data: "client_id="+category_id,
            success : function(res){
            
                $('#assignment_id').html(res);

                
            },
            error : function(){

            },
        });
       });
    }); 
    </script>
    
@endsection


  <!-- Modal -->
  <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('modify/excel')}}"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title font-weight-600" id="exampleModalLabel4">Add Excel</h5>
                <div >
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
                             <label for="name" class="col-sm-3 col-form-label font-weight-600">Client:</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="client" name="client_id"
                @if(Request::is('assignmentmapping/*/edit'))> <option disabled style="display:block">Please Select One
                </option>

                @foreach($client as $clientData)
                <option value="{{$clientData->id}}"
                    {{$assignmentmapping->client->id== $clientData->id??'' ?'selected="selected"' : ''}}>
                    {{$clientData->client_name }}</option>
                @endforeach


                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($client as $clientData)
                <option value="{{$clientData->id}}">
                    {{ $clientData->client_name }}</option>

                @endforeach
                @endif
            </select>
                        </div>
                           
                    </div> 
                    <div class="details-form-field form-group row">
                             <label for="name" class="col-sm-3 col-form-label font-weight-600">Assignment:</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="assignment_id" name="assignment_id"
                            > 
                         </select>
                        </div>
                           
                    </div> 
                    <div class="details-form-field form-group row">
                             <label for="name" class="col-sm-3 col-form-label font-weight-600">Upload Excel:</label>
                        <div class="col-sm-9">
                            <input id="name" class="form-control" name="file" type="file">
                        </div>
                           
                    </div> 
                
                    {{-- <div class="details-form-field form-group row">
                    <label for="address" class="col-sm-3 col-form-label font-weight-600">Sample Excel:</label>
                    <div class="col-sm-9">
                        <a href="{{ url('backEnd/kgsomaniclient.xlsx')}}" 
                        class="btn btn-success btn"  >Download<i class="fas fa-file-excel" style="margin-left: 3px;font-size: 20px;"></i></a>
                   
                        </div>
                    </div> --}}
             </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </form>
        </div>
    </div>
</div>