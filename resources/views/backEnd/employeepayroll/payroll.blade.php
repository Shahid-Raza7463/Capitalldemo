<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">

@extends('backEnd.layouts.layout')
@section('backEnd_content')
   <style>
        .check-all {
            transform: scale(2.2);
            /* Adjust the scale value as needed */
        }

        .container {
            width: 100%;
        }

        .progressbar {
            list-style-type: none;
            display: flex;
            justify-content: space-between;
        }

        .progressbar li {
            position: relative;
            flex-basis: 33.33%;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .progressbar li:before {
            content: "";
            position: absolute;
            width: 100%;
            height: 2px;
            background-color: #ddd;
            top: 30%;
            transform: translateY(-50%);
            z-index: -1;
            left: -50%;
        }

        .progressbar li:first-child:before {
            content: none;
        }

        .progressbar li.active:before {
            background-color: green;
        }

        .progressbar li.active .tick {
            display: inline-block;
            width: 30px;
            height: 30px;
            line-height: 30px;
            border-radius: 100%;
            text-align: center;
            font-weight: bold;
            color: #fff;
            background-color: green;
            margin-bottom: 5px;
        }

        .progressbar li .tick {
            display: inline-block;
            width: 30px;
            height: 30px;
            line-height: 30px;
            border-radius: 100%;
            text-align: center;
            font-weight: bold;
            color: #fff;
            background-color: red;
            margin-bottom: 5px;
        }

        .progressbar li .text {
            margin-top: 5px;
        }


        .order-card {
            color: #fff;
        }

        .bg-c-blue {
            background: linear-gradient(45deg, #4099ff, #73b4ff);
        }

        .bg-c-green {
            background: linear-gradient(45deg, #2ed8b6, #59e0c5);
        }

        .bg-c-yellow {
            background: linear-gradient(45deg, #FFB64D, #ffcb80);
        }

        .bg-c-pink {
            background: linear-gradient(45deg, #FF5370, #ff869a);
        }


        .card {
            border-radius: 5px;
            -webkit-box-shadow: 0 1px 2.94px 0.06px rgba(4, 26, 55, 0.16);
            box-shadow: 0 1px 2.94px 0.06px rgba(4, 26, 55, 0.16);
            border: none;
            margin-bottom: 30px;
            -webkit-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
        }

        .card .card-block {
            padding: 25px;
        }

        .order-card i {
            font-size: 26px;
        }

        .f-left {
            float: left;
        }

        .f-right {
            float: right;
        }
    </style>
<!-- Content Header (Page header) -->
    <div class="body-content">
      <div class="container">
		  
        <ul class="progressbar">
            <li @if (isset($currentStep) && $currentStep >= 1) class="active" @endif>
                <div>
                    <span class="tick">@if (isset($currentStep) && $currentStep >= 1) &#10004; @else ! @endif</span>
                </div>
                <span class="text">HR Status</span>
            </li>
            <li @if (isset($currentStep) && $currentStep >= 2) class="active" @endif>
                <div>
                    <span class="tick">@if (isset($currentStep) && $currentStep >= 2) &#10004; @else ! @endif</span>
                </div>
                <span class="text">Accounts Status</span>
            </li>
            <li @if (isset($currentStep) && $currentStep >= 3) class="active" @endif>
                <div>
                    <span class="tick">@if (isset($currentStep) && $currentStep >= 3) &#10004; @else ! @endif</span>
                </div>
                <span class="text">Final Status</span>
            </li>
        </ul>
    </div>
    
    
    
    <div class="row">
            <div class="col-md-4 col-xl-3">
                <div class="card bg-c-blue order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">K G Somani & Co LLP</h6>
                        <h2 class="text-right"><i
                                class='fa fa-credit-card f-left'></i><span>₹{{ number_format($kgsSum, 2) }}</span></h2>
                        <p class="m-b-0">Final Approved<span class="f-right">{{ $kgSomaniCount }}</span></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-xl-3">
                <div class="card bg-c-green order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">KGS Advisors</h6>
                        <h2 class="text-right"><i
                                class="fa fa-credit-card f-left"></i><span>₹{{ number_format($advisorsSum, 2) }}</span></h2>
                        <p class="m-b-0">Final Approved<span class="f-right">{{ $kgsAdvisorsCount }}</span></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-xl-3">
                <div class="card bg-c-yellow order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">Capitall India Pvt. Ltd.</h6>
                        <h2 class="text-right"><i
                                class="fa fa-credit-card f-left"></i><span>₹{{ number_format($capitallSum, 2) }}</span></h2>
                        <p class="m-b-0">Final Approved<span class="f-right">{{ $capitallIndiaCount }}</span></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-xl-3">
                <div class="card bg-c-pink order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">Gvriksh</h6>
                        <h2 class="text-right"><i
                                class="fa fa-credit-card f-left"></i><span>₹{{ number_format($gvrikshSum, 2) }}</span></h2>
                        <p class="m-b-0">Final Approved<span class="f-right">{{ $gvrikshCount }}</span></p>
                    </div>
                </div>
            </div>
        </div>
    
    




        <div class="card mb-4">

            <div class="card-body">
                @component('backEnd.components.alert')
                @endcomponent
                <div style="float:right;">
					
                    <button class="btn btn-success" id="approveButton" data-toggle="modal"
                        data-target="#approvalModal">Approve</button>
					@if (auth()->user()->email == 'Sanjiv@kgsomani.com' || auth()->user()->email == 'vinita@kgsomani.com')
    @php
        $sendToBank = $employeepayrollDatas->where('level_three', 1)->count() > 0;
    @endphp

    @if ($sendToBank)
        <button class="btn btn-info" onclick="confirmSendToBank('{{ route('export') }}')">Send to Bank</button>
        <script>
            function confirmSendToBank(route) {
                if (confirm('Are you sure you want to send to the bank?')) {
                    window.location = route;
                }
            }
        </script>
					@else
					<button class="btn btn-info" onclick="confirmSendToBank('{{ route('export') }}')" readonly>Send to Bank</button>
        
					
    @endif
@endif
@if (auth()->user()->email == 'accounts@kgsomani.com' || auth()->user()->email == 'Sanjiv@kgsomani.com')
                        <button class="btn btn-danger" id="clarificationButton" data-toggle="modal"
                            data-target="#clarificationModal">Clarification Require</button>
                    @endif

                </div><br><br>

                <div class="table-responsive example" style="margin-top:5px;">
                    <div class="table-responsive">
                        <table id="exampleee" class="display nowrap">
                            <thead>
                                <tr>

                                    <th><input type="checkbox" id="masterCheckbox" class="check-all"></th>
                                    <th>Name of Employee</th>
                                    <th>Month</th>
									<th>Gross Salary</th>
                                    <th>Total no. of days</th>
                                    <th>No of Days Present</th>
                                    <th>Sick Leave</th>
                                    <th>Casual Leave</th>
                                    <th>Compensatory Off</th>
                                    <th>Birthday Leave</th>
                                    <th>Leave Without Pay</th>
                                    <th>No of Holidays</th>
                                    <th>Day to be paid</th>
                                    <th>Amount</th>
									<th>PF Applicable</th>
                                    <th>Employee Contribution</th>
                                    <th>Employer Contribution</th>
                                    <th>Advance</th>
                                    <th>TDS</th>
                                    <th>Arrear</th>
                                    <th>Bonus</th>
                                    <th>Total Amount to be Paid</th>
									<th>Entity</th>
                                   <!-- <th>Remark</th>-->
									<th>Hr Comment</th>
                                    <th>HR Status</th>
                                  
                                    <th>Account's Status</th>
                                    <th>Final Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employeepayrollDatas as $employeepayrollData)
                                    <tr>

                                        <td>
                                            @if ((auth()->user()->email == 'priyankasharma@kgsomani.com'||auth()->user()->email == 'vinita@kgsomani.com') && $employeepayrollData->level_one == 0)
                                                <input type="checkbox" name="approve[]"
                                                    value="{{ $employeepayrollData->id }}">
                                            @elseif(auth()->user()->email == 'accounts@kgsomani.com' &&
                                                    ($employeepayrollData->level_one == 1 && $employeepayrollData->level_two == 0))
                                                <input type="checkbox" name="approve[]"
                                                    value="{{ $employeepayrollData->id }}">
                                            @elseif(auth()->user()->email == 'Sanjiv@kgsomani.com' &&
                                                    $employeepayrollData->level_two == 1 &&
                                                    $employeepayrollData->level_three == 0)
                                                <input type="checkbox" name="approve[]"
                                                    value="{{ $employeepayrollData->id }}">
                                            @endif
                                        </td>
                                        <td><a
                                                href="{{ url('employeepayroll/view', $employeepayrollData->id) }}">{{ $employeepayrollData->team_member ?? '' }}</a>
                                        </td>
                                        <td>{{ $employeepayrollData->month ?? '' }}</td>
										<td>{{$employeepayrollData->monthly_gross_salary ??''}}</td>
                                        <td>{{ $employeepayrollData->totaldays ?? '' }}</td>
                                        <td>{{ $employeepayrollData->no_of_day_present ?? '' }}</td>
                                        <td>{{ $employeepayrollData->sl ?? '' }}</td>
                                        <td>{{ $employeepayrollData->cl ?? '' }}</td>
                                        <td>{{ $employeepayrollData->co ?? '' }}</td>
                                        <td>{{ $employeepayrollData->birthday ?? '' }}</td>
                                        <td>{{ $employeepayrollData->lwp ?? '' }}</td>
                                        <td>{{ $employeepayrollData->holiday ?? '' }}</td>
                                        <td>{{ $employeepayrollData->day_to_be_paid ?? '' }}</td>
										
                                        <td>{{ $employeepayrollData->amount ?? '' }}</td>
										<td>{{$employeepayrollData->pf_applicable ??''}}</td>
                                        <td>{{ $employeepayrollData->employee_contribution ?? 0 }}</td>
                                        <td>{{ $employeepayrollData->employer_contribution ?? 0 }}</td>
                                        <td>{{ $employeepayrollData->advance ?? 0 }}</td>
                                        <td>{{ $employeepayrollData->tds ?? 0 }}</td>
                                        <td>{{ $employeepayrollData->Arrear ?? 0 }}</td>
                                        <td>{{ $employeepayrollData->bonus ?? 0 }}</td>
                                        @if (auth()->user()->email == 'accounts@kgsomani.com' || auth()->user()->email == 'priyankasharma@kgsomani.com' ||auth()->user()->email == 'vinita@kgsomani.com')
                                            <td><a style="color:green" id="editCompany" data-toggle="modal"
                                                    data-id="{{ $employeepayrollData->id }}" data-target="#modaldemo1">
                                                    {{ $employeepayrollData->total_amount_to_paid ?? 0 }}
                                                </a>
                                            </td>
                                        @else
                                            <td>{{number_format(round($employeepayrollData->total_amount_to_paid),0) ?? 0 }} </td>
                                        @endif
										<td>{{$employeepayrollData->entity ?? ''}}</td>
                                        <td>{{ $employeepayrollData->comment ?? '' }}</td>
                                        @if ($employeepayrollData->level_one == 0)
                                            <td>
                                                <span class="badge badge-pill badge-warning">Pending</span>
                                            </td>
                                        @elseif($employeepayrollData->level_one == 1)
                                            <td>
                                                <span class="badge badge-pill badge-success">Approved</span>
                                            </td>
                                        @else
                                            <td>
                                                <span class="badge badge-pill badge-danger">Clarification Required</span>
                                            </td>
                                        @endif
                                       
                                        @if ($employeepayrollData->level_two == 0)
                                            <td>
                                                <span class="badge badge-pill badge-warning">Pending</span>
                                            </td>
                                        @elseif($employeepayrollData->level_two == 1)
                                            <td>
                                                <span class="badge badge-pill badge-success">Approved</span>
                                            </td>
                                        @else
                                            <td>
                                                <span class="badge badge-pill badge-danger">Clarification Required</span>
                                            </td>
                                        @endif

                                        @if ($employeepayrollData->level_three == 0)
                                            <td>
                                                <span class="badge badge-pill badge-warning">Pending</span>
                                            </td>
                                        @elseif($employeepayrollData->level_three == 1)
                                            @if ($employeepayrollData->send_to_bank == 1)
                                                <td>
                                                    <span class="badge badge-pill badge-success">Processed</span>
                                                </td>
                                            @else
                                                <td>
                                                    <span class="badge badge-pill badge-success">Approved</span>
                                                </td>
                                            @endif
                                        @else
										<td>
                                                <span class="badge badge-pill badge-danger">Clarification Required</span>
                                            </td>
                                        @endif


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!--edit modal-->

    <div class="modal fade bd-example-modal-sm" id="modaldemo1" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header" style="background: #37A000">
                    <h5 style="color: white"class="modal-title font-weight-600" id="exampleModalLabel1">Update Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" method="post" action="{{ url('employeepayroll_update') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="font-weight-600">Amount *</label>
                            <input type="text" name="amount" id="amount" readonly class="form-control"
                                placeholder="">
                        </div>
                        <br>
                        <div class="form-group">
                            <label class="font-weight-600">Employee Contribution *</label>
                            <input type="text" name="employee_contribution" id="employee_contribution"
                                class="form-control" placeholder="">
                        </div>
                        <br>
                        <div class="form-group">
                            <label class="font-weight-600">Employer Contribution *</label>
                            <input type="text" name="employer_contribution" id="employer_contribution"
                                class="form-control" placeholder="">
                        </div>
                        <br>
                        <input class="form-control" hidden value="" name="id" id="id" type="text">
                        <br>
                        <div class="form-group">
                            <label class="font-weight-600">Advance *</label>
                            <input type="text" name="advance" id="advance" class="form-control" placeholder="">
                        </div>
                        <br>
                        <div class="form-group">
                            <label class="font-weight-600">TDS *</label>
                            <input type="text" name="tds" id="tds" class="form-control" placeholder="">
                        </div>
                        <br>
                        <div class="form-group">
                            <label class="font-weight-600">Arrear *</label>
                            <input type="text" name="Arrear" id="Arrear" class="form-control" placeholder="">
                        </div>
                        <br>
                        <div class="form-group">
                            <label class="font-weight-600">Bonus *</label>
                            <input type="text" name="bonus" id="bonus" class="form-control" placeholder="">
                        </div>

                        <br>
                        <div class="form-group">
                            <label class="font-weight-600">HR Comment *</label>
                            <textarea class="form-control" name="comment" id="comment" rows="3"></textarea>
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

    <!--end edit modal-->
    <!-- Approval Modal -->
    <div class="modal fade" id="approvalModal" tabindex="-1" role="dialog" aria-labelledby="approvalModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="approvalForm" action="{{ route('payroll-approve') }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="approvalModalLabel">Approve Payroll</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="selectedPayrollDataIds" id="selectedPayrollDataIds" value="">
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <textarea class="form-control" name="remarks" id="remarks" rows="3">Approved</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" id="confirmApproval" value="Approve">
                        <!-- <button type="button" class="btn btn-danger" id="rejectApproval">Reject</button>-->
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Clarification Modal -->
    <!-- Clarification Modal -->
    <div class="modal fade" id="clarificationModal" tabindex="-1" role="dialog"
        aria-labelledby="clarificationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="clarificationForm" action="{{ route('payroll-clarification') }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="clarificationModalLabel">Clarification Required</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="selectedPayrollDataIds" id="selectedPayrollDataIdsClarification"
                            value="">
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <textarea class="form-control" name="remarks" id="remarksClarification" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-danger" id="confirmClarification" value="Clarification">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <script>
        $(function() {
            $('body').on('click', '#editCompany', function(event) {
                //        debugger;
                var id = $(this).data('id');
                debugger;
                $.ajax({
                    type: "GET",

                    url: "{{ url('employee_payroll') }}",
                    data: "id=" + id,
                    success: function(response) {
                        // alert(res);
                        debugger;
                        $("#id").val(response.id);
                        $("#amount").val(response.amount);
                        $("#advance").val(response.advance);
                        $("#tds").val(response.tds);
                        $("#Arrear").val(response.Arrear);
                        $("#bonus").val(response.bonus);
                        $("#comment").val(response.comment);
                        $("#employee_contribution").val(response.employee_contribution);
                        $("#employer_contribution").val(response.employer_contribution);


                    },
                    error: function() {

                    },
                });
            });
        });
    </script>
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function() {
        const userEmail = "{{ auth()->user()->email }}";

        const table = $('#exampleee').DataTable({
            "pageLength": 300,
            dom: 'Bfrtip',
            "order": [
                [0, "desc"]
            ],
            buttons: [{
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    },
                    enabled: userEmail === "priyankasharma@kgsomani.com"
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    },
                    enabled: userEmail === "priyankasharma@kgsomani.com"
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 5]
                    },
                    enabled: userEmail === "priyankasharma@kgsomani.com"
                },
                'colvis'
            ]
        });

        // Get the approve/reject button
        const approvalButton = document.getElementById("approveButton");

        // Get the selected payroll data IDs
        function getSelectedPayrollDataIds() {
            const selectedPayrollDataIds = [];
            $("input[name='approve[]']:checked").each(function() {
                selectedPayrollDataIds.push($(this).val());
            });
            return selectedPayrollDataIds.join(",");
        }

        // Add click event listener to the approve/reject button
        approvalButton.addEventListener("click", function() {
            const selectedPayrollDataIds = getSelectedPayrollDataIds();
            if (selectedPayrollDataIds.length > 0) {
                // Set the selected payroll data IDs in the hidden field
                document.getElementById("selectedPayrollDataIds").value = selectedPayrollDataIds;

                // Open the existing modal
                $('#approvalModal').modal('show');
            } else {
                alert("Please select at least one payroll data to approve/reject.");
            }
        });

        // Handle form submission
        document.getElementById("approvalForm").addEventListener("submit", function(event) {
            event.preventDefault();

            // Get the remarks from the modal
            const remarks = document.getElementById("remarks").value;

            // Validate the remarks if required
            if (remarks.trim() === "") {
                alert("Please enter remarks.");
                return;
            }



            // Submit the form
            document.getElementById("approvalForm").submit();
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Master checkbox change event
        $("#masterCheckbox").change(function() {
            // Get the state of the master checkbox
            var isChecked = $(this).is(":checked");

            // Update the state of all checkboxes in the table body
            $("input[name='approve[]']").prop("checked", isChecked);
        });

        // Individual checkbox change event
        $("input[name='approve[]']").change(function() {
            // Check if all checkboxes are checked
            var allChecked = ($("input[name='approve[]']").length === $(
                "input[name='approve[]']:checked").length);

            // Update the state of the master checkbox
            $("#masterCheckbox").prop("checked", allChecked);
        });
    });
</script>
<script>
    const clarificationButton = document.getElementById("clarificationButton");

    $(document).ready(function() {


        function getSelectedPayrollDataIds() {
            const selectedPayrollDataIds = [];
            $("input[name='approve[]']:checked").each(function() {
                selectedPayrollDataIds.push($(this).val());
            });

            return selectedPayrollDataIds.join(",");
        }
        // ...

        // Open the clarification modal when clarification button is clicked
        $('#clarificationButton').on('click', function() {
            var selectedPayrollDataIds = getSelectedPayrollDataIds();
            if (selectedPayrollDataIds.length > 0) {
                document.getElementById("selectedPayrollDataIdsClarification").value =
                    selectedPayrollDataIds;

                $('#clarificationModal').modal('show');
            } else {
                alert('Please select at least one payroll data.');
            }
        });

        // Submit the clarification form
        // Handle form submission
        document.getElementById("clarificationForm").addEventListener("submit", function(event) {
            event.preventDefault();

            // Get the remarks from the modal
            const remarks = document.getElementById("remarksClarification").value;

            // Validate the remarks if required
            if (remarks.trim() === "") {
                alert("Please enter remarks.");
                return;
            }



            // Submit the form
            document.getElementById("clarificationForm").submit();
        });
    });
</script>
