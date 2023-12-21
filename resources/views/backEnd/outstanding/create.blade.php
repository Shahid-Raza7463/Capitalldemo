 <!--Third party Styles(used by this page)--> 
  <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css')}}" rel="stylesheet">

@extends('backEnd.layouts.layout') @section('backEnd_content')

<div class="body-content">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">Record Payment for {{ $invoice->invoice_id }}</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="@if(Request::is('payment/create/*'))
                    {{ url('payments/store/'.$id) }} @endif" enctype="multipart/form-data">
                        @csrf
                  @component('backEnd.components.alert')

                  @endcomponent
                  <div class="row row-sm">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="font-weight-600">Amount Received *</label>
                            <input type="number" required name="amountreceived" value="{{ $invoice->total ?? ''}}" class="form-control"
                                placeholder="Enter Amount">
                       
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="font-weight-600">Transaction ID *</label>
                            <input type="text" required name="transaction_id" value="{{ $invoice->transaction_id ?? ''}}" class="form-control"
                                placeholder="Enter Transaction">
                        </div>
                    </div>
                  
                    <div class="col-4">
                        <div class="form-group">
                            <label class="font-weight-600">TDS *</label>
                            <input type="number" name="tds" value="{{ $invoice->tds ?? ''}}" class="form-control"
                                placeholder="Enter TDS">
                        </div>
                    </div>
                  
                </div>
                <div class="row row-sm">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="font-weight-600">Payment Date</label>
                            <input type="date" required name="paymentdate" value="{{ $invoice->paymentdate ?? ''}}"
                            class="form-control" placeholder="Enter Associated From">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="font-weight-600">Payment Mode *</label>
                            <select name="paymentmode" required id="exampleFormControlSelect3" class="form-control">
                                <!--placeholder-->
                                <option value="">Please Select</option>
                                <option value="0">Bank</option>
                                <option value="1">Offline</option>
                                <option value="2">Cheque</option>
                
                
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row row-sm">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="font-weight-600">Leave a note</label>
                            <textarea rows="4" name="note" value="{{ $invoice->comment ?? ''}}" class="form-control"
                                placeholder="Enter Comment">{!! $invoice->comment ??'' !!}</textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
              
                    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
                 
                    <a class="btn btn-secondary" href="{{ url('invoice') }}">
                        Back</a>
                
                </div>
                
                    </form>
                   
                    <hr class="my-4">

                </div>
            </div>
        </div>
    </div>
</div>
<!--/.body content-->
 <!-- Bootstrap DatePicker -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" type="text/css" />
 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js" type="text/javascript"></script>
 <!-- Bootstrap DatePicker -->
 <script type="text/javascript">
     $(function () {
         $('#txtDate').datepicker({
             format: "dd/mm/yyyy"
         });
     });
 </script>
@endsection
