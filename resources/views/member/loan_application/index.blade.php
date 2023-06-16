@extends('layouts/main')
@section('content_body')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<style type="text/css">
    ul.pagination {
        list-style-type: none;
        margin: 0;
        padding: 0;
        text-align: center;
    }

    ul.pagination li {
        display: inline;
        padding: 2px 5px 0;
        text-align: center;
    }

    ul.pagination li a {
        padding: 2px;
    }

    @media (max-width:652px) {
        .members-module {
            padding-top: 53px;
            padding-bottom: 50px;
        }

        .members-header {
            justify-content: center;
            align-items: center;
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 20px;
        }

    }

    .side-dashboard {
        grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
    }

    .side-dashboard>.card>.content-right {
        margin-top: 10px;
        display: flex;
        justify-content: space-between;
        flex-direction: row;
    }

    .side-dashboard>.card>.content-right>label {
        margin-bottom: 0px;
        margin-top: 0px !important;
    }

    @media (max-width:652px) {
        .side-dashboard {
            grid-template-columns: 1fr 1fr
        }

        .members-header {
            justify-content: center;
            align-items: center;
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 20px;
        }

    }

    .payroll-table {
        border-collapse: collapse;
        margin: 0;
        padding: 0;
        width: 100%;
        table-layout: fixed;
        border: 1px solid #ececec;
    }

    .payroll-table>thead>tr>th {
        font-size: 13px;
        padding-left: 5px;
        padding-right: 5px;
        background-color: #1a8981;
        color: white !important;
        border-left: 1px solid white;
        font-weight: 500;
        border-top: 2px solid #1a8981;
        border-bottom: 2px solid #1a8981;
        height: auto;
        text-transform: uppercase;
        width: 100px;
    }

    .payroll-table>thead>tr>th:first-child {
        border-left: 1px solid #1a8981;
    }

    .payroll-table>thead>tr>th:last-child {
        border-right: 1px solid #1a8981;
    }

    .payroll-table>thead>tr>th>span {
        display: flex;
        height: 100%;
    }

    .payroll-table>tbody>tr>td>span {
        display: flex;
        padding: 5px 2px;

    }

    .payroll-table>tbody>tr>td {
        font-size: 12px;
        padding-left: 5px;
        padding-right: 5px;
        min-width: 100px;
    }

    .apply-button {
        justify-content: end;
    }


    @media (max-width:652px) {
        .apply-button {
            justify-content: center;
        }

    }
</style>
<div class="filler"></div>
<div class="mp-container mh-content members-module">

    <div class="row no-gutters mp-mt5">
        <div class="col-12 mp-ph2 mp-pv2 mp-text-fs-large mp-text-c-primary members-header">
            Loan Application
            <span style="position: relative; float: right;">
                <!-- <a href="{{ url('/member/new-loan') }}" class="mp-button mp-button--primary">
                        Apply for Loan
                    </a> -->
                <button class="up-button f-button magenta-bg">Generate Loan Balance</button>
                <button class="up-button-grey f-button" id="reset">Export Records</button>
            </span>
        </div>

    </div>
    <div class="row no-gutters mp-mb4">
        <div class="col-12 mp-ph2 mp-pv2">
            <div class="card-container card p-0">
                <div class="card-header d-flex maroon-bg">
                    <span>Filtering Section</span>
                </div>
                <div class="card-body justify-content-center gap-10 flex-row p-0 mp-ph2">
                    <div class="container-fluid no-gutters black-clr">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mp-input-group">
                                    <label class="mp-input-group__label black-clr mp-mb2">Filter by Loan Type</label>
                                    <select class="js-example-responsive mp-input-group__input mp-text-field" style="width:100%; " required>
                                        <option value="">Select Loan Type</option>
                                        <option value="">(PEL) Personal Equity Loan</option>
                                        <option value="">(CBL) Co Borrower Plan</option>
                                        <option value="">(BL) Bridge Loan</option>
                                        <option value="">(EML) Emergency Loan</option>
                                        <option value="">(BTL) Balance Transfer Loan</option>
                                    </select>
                                </div>
                                <div class="mp-input-group mp-mt3">
                                    <label class="mp-input-group__label black-clr mp-mb2">Filter by Application Status</label>
                                    <select class="js-example-responsive mp-input-group__input mp-text-field" style="width:100%; " required>
                                        <option value="">Select Loan Type</option>
                                        <option value="">(PEL) Personal Equity Loan</option>
                                        <option value="">(CBL) Co Borrower Plan</option>
                                        <option value="">(BL) Bridge Loan</option>
                                        <option value="">(EML) Emergency Loan</option>
                                        <option value="">(BTL) Balance Transfer Loan</option>
                                    </select>
                                </div>
                                <div class="mp-input-group mp-mt3 mp-mb2">
                                    <label class="mp-input-group__label black-clr mp-mb2">Filter by Loan Application Date</label>
                                    <br>
                                    <span class="d-flex items-between flex-row">
                                        <label class="mp-input-group__label black-clr mp-ml2 align-self-center">Date From:</label>
                                        <input type="date" id="from" class="radius-1 border-1 date-input outline" style="height: 30px; width: 250px">
                                    </span>
                                    <br>
                                    <span class="d-flex items-between flex-row">
                                        <label class="mp-input-group__label black-clr mp-ml2 align-self-center">Date To:</label>
                                        <input type="date" id="from" class="radius-1 border-1 date-input outline" style="height: 30px; width: 250px">
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div>
                                    <h3 class="magenta-clr">
                                        Application Summary
                                    </h3>
                                </div>
                                <div class="right-dashboard col grid side-dashboard gap-10 font-sm card mp-mb2" style="color: black;">
                                    <div class="text-center d-flex flex-column justify-content-center">
                                        <div>
                                            <span class="font-bold font-lg magenta-clr" id="new_app">0</span>
                                        </div>
                                        <span class="font-sm min-h-40">New Loan Application</span>
                                    </div>
                                    <div class="text-center d-flex flex-column justify-content-center">
                                        <div>
                                            <span class="font-bold font-lg magenta-clr" id="forApproval">0</span>
                                        </div>
                                        <span class="font-sm min-h-40">Processing Loan Application</span>
                                    </div>
                                    <div class="text-center d-flex flex-column justify-content-center">
                                        <div>
                                            <span class="font-bold font-lg magenta-clr" id="draft">0</span>
                                        </div>
                                        <span class="font-sm min-h-40">For Review Loan Application</span>
                                    </div>
                                    <div class="text-center d-flex flex-column justify-content-center">
                                        <div>
                                            <span class="font-bold font-lg magenta-clr" id="draft">0</span>
                                        </div>
                                        <span class="font-sm min-h-40">Approved Loan Application</span>
                                    </div>
                                    <div class="text-center d-flex flex-column justify-content-center">
                                        <div>
                                            <span class="font-bold font-lg magenta-clr" id="rejected">0</span>
                                        </div>
                                        <span class="font-sm min-h-40 ">Rejected Loan Application</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row no-gutters mp-mb4">
        <div class="col-12 mp-ph2 mp-pv2">
            <div class="card-container card p-0">
                <div class="card-header d-flex maroon-bg">
                    <span>Loan Application</span>
                </div>
                <div class="card-body justify-content-center gap-10 flex-row p-0 mp-ph2">
                    <div class="container-fluid no-gutters black-clr">
                        <div class="row">
                            <div class="col-12">
                                <div class="mp-mt2 d-flex apply-button">
                                    <span class="">
                                        <button id="apply_loan" class="mp-button mp-button--primary" style="color:white;">
                                            Apply for Loan
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="overflow-y: auto;">
                            <div class="col-1g-12" style="padding:15px;">
                                <div class="d-flex flex-column">
                                    <div class="header-table">
                                        <table class="payroll-table" style="height: auto;" width="100%">
                                            <thead>
                                                <tr>
                                                    <th style="width: 60px">
                                                        <span>Action</span>
                                                    </th>
                                                    <th>
                                                        <span>Application Date</span>
                                                    </th>
                                                    <th>
                                                        <span>Loan Application Number</span>
                                                    </th>
                                                    <th>
                                                        <span>Loan Type</span>
                                                    </th>
                                                    <th>
                                                        <span>Loan Status</span>
                                                    </th>
                                                    <th>
                                                        <span>Remarks</span>
                                                    </th>
                                                    <th>
                                                        <span>Loanable Amount</span>
                                                    </th>
                                                    <th>
                                                        <span>Monthly Amortization</span>
                                                    </th>
                                                    <th>
                                                        <span>Interest Rate</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <a data-md-tooltip="View Loan" class="view_member md-tooltip--right" id="view-loan" style="cursor: pointer">
                                                            <i class="mp-icon md-tooltip--right icon-book-open mp-text-c-primary mp-text-fs-large"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <span>Date</span>
                                                    </td>
                                                    <td>
                                                        <span>123</span>
                                                    </td>
                                                    <td>
                                                        <span>PEL</span>
                                                    </td>
                                                    <td>
                                                        <span>ACT</span>
                                                    </td>
                                                    <td>
                                                        <span>GUD</span>
                                                    </td>
                                                    <td>
                                                        <span>PHP 123,123</span>
                                                    </td>
                                                    <td>
                                                        <span>PHP 123,123</span>
                                                    </td>
                                                    <td>
                                                        <span>PHP 123,123</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 60px">
                                                        <a data-md-tooltip="View Loan" class="view_member md-tooltip--right" id="view-loan" style="cursor: pointer">
                                                            <i class="mp-icon md-tooltip--right icon-book-open mp-text-c-primary mp-text-fs-large"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <span>Date</span>
                                                    </td>
                                                    <td>
                                                        <span>123</span>
                                                    </td>
                                                    <td>
                                                        <span>PEL</span>
                                                    </td>
                                                    <td>
                                                        <span>ACT</span>
                                                    </td>
                                                    <td>
                                                        <span>GUD</span>
                                                    </td>
                                                    <td>
                                                        <span>PHP 123,123</span>
                                                    </td>
                                                    <td>
                                                        <span>PHP 123,123</span>
                                                    </td>
                                                    <td>
                                                        <span>PHP 123,123</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
</div>
</div>
@endsection
@section('scripts')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var member_loan_table = $('#member_loan_table').DataTable({
            language: {
                search: '',
                searchPlaceholder: "Search Loan Application No.",
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><br>Loading...',
            },
            "ordering": false,
            "processing": true,
            "serverSide": true,

        });
        $(document).on('change', '#loan_type', function(e) {
            member_loan_table.draw();
        });
        $(document).on('change', '#loan_status', function(e) {
            member_loan_table.draw();
        });
        $('#from').on('change', function() {
            if ($('#from').val() > $('#to').val() && $('#to').val() != '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Invalid Date Range,Please Check the date. Thank you!',
                });
                $('#from').val('');
            } else {
                member_loan_table.draw();
            }

        });
        $('#to').on('change', function() {
            if ($('#to').val() < $('#from').val()) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Invalid Date Range,Please Check the date. Thank you!',
                });
                $('#to').val('');
            } else {
                member_loan_table.draw();
            }
        });
    });
    $(document).on('click', '#member_loandet', function(e) {
        var id = $(this).attr('data-id');
        console.log(id);
        var url = "#" + '/' + id; //YOUR CHANGES HERE...
        // window.location.href = url;
        window.open(url, '_blank');
    });

    $(document).on('click', '#view-loan', function(e) {
        var id = $(this).attr('data-id');
        console.log(id);
        var url = "#" + '/' + id; //YOUR CHANGES HERE...
        // window.location.href = url;
        window.open(url, '_blank');
    });


    $(document).on('click', '#apply_loan', function(e) {
        Swal.fire({
            title: 'Select Loan Type',
            input: 'select',
            inputOptions: {
                'PEL': 'NEW PEL',
                'RENEW PEL': 'RENEW PEL',
                'CBL ': 'CBL',
                'BL  ': 'BL',
                'EML  ': 'EML',
                'BTL': 'BTL'
            },

            showCancelButton: true,
            inputValidator: function(value) {
                return new Promise(function(resolve, reject) {

                    if (value !== '') {
                        resolve();
                    } else {
                        reject('You need to select loan type :)')
                    }
                })
            }
        }).then(function(result) {
            if (result.value === 'PEL') {
                window.location = '/member/loan/application';
            }
            console.log(result);
            // 
        })
    })


    $(document).on('click', '#exportLoanApplication', function(e) {
        if ($('#loan_type').val() != "") {
            var loan = $('#loan_type').val();
        } else {
            var loan = 0;
        }

        if ($('#loan_status').val() != "") {
            var stat = $('#loan_status').val();
        } else {
            var stat = 0;
        }

        if ($('#from').val() != "" && $('#to').val() != "") {
            var dt_from = $('#from').val();
            var dt_to = $('#to').val();
        } else {
            var dt_from = 0;
            var dt_to = 0;
        }
        // console.log(id);
        var url = "#" + '/' + loan + '/' + stat + '/' + dt_from + '/' + dt_to; //YOUR CHANGES HERE...
        window.open(url, '_blank');
    });
</script>
@endsection