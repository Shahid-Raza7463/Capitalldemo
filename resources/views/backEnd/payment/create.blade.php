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
                            <input type="number" required name="amountreceived" value="{{ $invoice->amountreceived ?? ''}}" class="form-control"
                                placeholder="Enter Amount">
                       
                        </div>
                    </div>
                 
                      <div class="col-4">
                        <div class="form-group">
                            <label class="font-weight-600">TDS On Income Tax*</label>
                            <input type="number" name="tds" value="{{ $invoice->tds ?? ''}}" class="form-control"
                                placeholder="Enter TDS">
                        </div>
                    </div>
					     <div class="col-4">
                        <div class="form-group">
                            <label class="font-weight-600">Transaction ID *</label>
                            <input type="text" required name="transaction_id" value="{{ $invoice->transaction_id ?? ''}}" class="form-control"
                                placeholder="Enter Transaction">
                        </div>
                    </div>
                </div>
						   <div class="row row-sm">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="font-weight-600">TDS on CGST</label>
                            <input type="number" required name="tdscgst" value="{{ $invoice->tdscgst ?? ''}}" class="form-control"
                                placeholder="Enter TDS on CGST">
                       
                        </div>
                    </div>
                 
                      <div class="col-4">
                        <div class="form-group">
                            <label class="font-weight-600">TDS on IGST</label>
                            <input type="number" name="tdsigst" value="{{ $invoice->tdsigst ?? ''}}" class="form-control"
                                placeholder="Enter TDS on IGST">
                        </div>
                    </div>
					     <div class="col-4">
                        <div class="form-group">
                            <label class="font-weight-600">TDS on SGST</label>
                            <input type="text" required name="tdssgst" value="{{ $invoice->tdssgst ?? ''}}" class="form-control"
                                placeholder="Enter TDS on SGST">
                        </div>
                    </div>
                </div>
                <div class="row row-sm">
					 <div class="col-4">
                        <div class="form-group">
                            <label class="font-weight-600">Round Off</label>
                            <input type="number" name="roundoff" value="{{ $invoice->roundoff ?? ''}}"
                            class="form-control" placeholder="Enter Round Off">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="font-weight-600">Payment Date</label>
                            <input type="date" required name="paymentdate" value="{{ $invoice->paymentdate ?? ''}}"
                            class="form-control" placeholder="Enter Associated From">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="font-weight-600">Payment Mode *</label>
                            <select name="paymentmode" required id="exampleFormControlSelect3" class="form-control">
                                <!--placeholder-->
                                <option value="">Please Select</option>
                                <option value="0">Bank</option>
                                <option value="1">Online</option>
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

@endsection
