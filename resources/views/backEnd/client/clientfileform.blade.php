<style>
    #Div2 {
  display: none;
}
</style>
@extends('backEnd.layouts.layout') @section('backEnd_content')

    <div class="body-content">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fs-17 font-weight-600 mb-0">Add Client Document</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ url('/clientfile/store')}}" enctype="multipart/form-data">
                            @csrf
                      @component('backEnd.components.alert')
    
                      @endcomponent
                           
    <div class="row row-sm">
        <div class="col-5" id="Div1">
            <div class="form-group">
                <label class="font-weight-600">Client *</label>
                <select class="form-control" id="exampleFormControlSelect1" name="client_id"
                @if(Request::is('asset/*/edit'))> <option disabled style="display:block">Please Select One</option>
    
                @foreach($client as $clientData)
                <option value="{{$clientData->id}}"
                    {{$asset->client->id== $clientData->id??'' ?'selected="selected"' : ''}}>
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
        <div class="col-5" id="Div2">
            <div class="form-group">
                <label class="font-weight-600">Client Name </label>
                <input type="text" name="client_name" value="{{ $asset->client_name ?? ''}}" class="form-control"
                    placeholder="Enter Client Name">
            </div>
        </div>
            <div class="col-1">
                <div class="form-group" style="margin-top: 36px;">
                    <a  id="Button1" class="add_button" title="Add field" onclick="switchVisible();"><img src="{{ url('backEnd/image/add-icon.png')}}"/></a>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="font-weight-600">Document Name </label>
                    <input type="text" name="document_name" value="{{ $asset->document_name ?? ''}}" class="form-control"
                        placeholder="Enter Document Name">
                </div>
                </div>
    </div>
    <div class="row row-sm">
            <div class="col-6">
                <div class="form-group">
                    <label class="font-weight-600">Document File </label>
                    <input type="file" name="filess" value="{{ $asset->filess ?? ''}}" class="form-control"
                        placeholder="Enter Document Name">
                </div>
                </div>
        <div class="col-6">
            <div class="form-group">
                <label class="font-weight-600">Document Type *</label>
                <select name="type" id="exampleFormControlSelect1" class="form-control">
                    <option value="0">Permanent</option>
                    <option value="1">Temporary</option>
                </select>
            </div>
        </div>
       
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
        <a class="btn btn-secondary" href="{{ url('clientfile') }}">
            Back</a>
    
    </div>
                        </form>
                       
                        <hr class="my-4">
    
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    <script>
        function switchVisible() {
            if (document.getElementById('Div1')) {

                if (document.getElementById('Div1').style.display == 'none') {
                    document.getElementById('Div1').style.display = 'block';
                    document.getElementById('Div2').style.display = 'none';
                }
                else {
                    document.getElementById('Div1').style.display = 'none';
                    document.getElementById('Div2').style.display = 'block';
                }
            }
}
    </script>