<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Amount Received *</label>
            <input type="number" name="amountreceived" value="{{ $invoice->amountreceived ?? ''}}" class="form-control"
                placeholder="Enter Amount">
            <input type="number" name="invoice_id" value="{{ $invoice->invoice_id ?? ''}}" class="form-control"
                placeholder="Enter Amount">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Transaction ID *</label>
            <input type="number" name="transaction_id" value="{{ $invoice->transaction_id ?? ''}}" class="form-control"
                placeholder="Enter Transaction">
        </div>
    </div>
  
</div>
<div class="row row-sm">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Payment Date</label>
            <input type="date" name="paymentdate" value="{{ $invoice->paymentdate ?? ''}}"
            class="form-control" placeholder="Enter Associated From">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-600">Payment Mode *</label>
            <select name="status" id="exampleFormControlSelect3" class="form-control">
                <!--placeholder-->
                
                <option value="">Please Select One</option>
                <option value="0">Bank</option>
                <option value="1">Offline</option>
                <option value="2">cheque</option>

            </select>
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Leave a note</label>
            <textarea rows="4" name="comment" value="{{ $invoice->comment ?? ''}}" class="form-control"
                placeholder="Enter Comment">{!! $invoice->comment ??'' !!}</textarea>
        </div>
    </div>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('invoice') }}">
        Back</a>

</div>
