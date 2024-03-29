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
            Benefits Claims
            <span style="position: relative; float: right;">
                <!-- <a href="{{ url('/member/new-loan') }}" class="mp-button mp-button--primary">
                        Apply for Loan
                    </a> -->

            </span>
        </div>

    </div>
    <div class="row no-gutters mp-mb4">
        <div class="col-12 mp-ph2 mp-pv2">
            <div class="card-container card p-0">
                <div class="card-header filtering items-between d-flex">
                    <span>Filtering Section</span>
                    <span class="mp-pr2">
                        <button class="f-button font-bold">Export</button>
                        <button class="f-button font-bold up-button-green">Print</button>
                    </span>
                </div>


                <div class="card-body filtering-section-body justify-content-center gap-10 flex-row">
                    <div class="d-flex flex-row flex-wrap gap-10 w-full" style="font-size:12px;">
                        <span class="d-flex flex-column span-2 mp-pv2 flex-nowrap">
                            <span>Mode of Separation</span>
                            <select name="" class="radius-1 outline select-field" style="width: 100%; height: 30px" id="mode_of_seperation_select">
                                <option value="">Show All</option>
                                <option value="RETIREMENT">Retirement</option>
                                <option value="RESIGNATION">Resignation</option>
                                <option value="DEATH">Death</option>
                                <option value="OTHER">Other</option>
                            </select>
                        </span>
                        <span class="d-flex flex-column span-2 mp-pv2 flex-nowrap">
                            <span>Status</span>
                            <select name="" class="radius-1 outline select-field" style="width: 100%; height: 30px" id="status_select">
                                <option value="">Show All</option>
                                <option value="NEW APPLICATION">New Application</option>
                                <option value="PROCESSING">Processing</option>
                                <option value="REJECTED">Rejected</option>

                            </select>
                        </span>
                        <span class="d-flex flex-column span-3 mp-pv2 flex-nowrap date-selector">
                            <span>Date Created</span>
                            <div class="date_range d-flex">
                                <input type="date" id="membership_date_from_select" class="radius-1 border-1 date-input outline" style="height: 30px;">
                                <span for="" class="self_center mv-1" style="margin-left:5px; margin-right:5px;">to</span>
                                <input type="date" id="membership_date_to_select" class="radius-1 border-1 date-input outline" style="height: 30px;">
                            </div>
                        </span>
                        <!-- <span class="d-flex flex-column span-2 mp-pv2 flex-nowrap">
                                <span>Status</span>
                                <select name="" class="radius-1 outline select-field" style="width: 100%; height: 30px" id="status_select">
                                    <option value="">Show All</option>
                                    <option value="DRAFT APPLICATION">DRAFT APPLICATION</option>
                                    <option value="NEW APPLICATION">NEW APPLICATION</option>
                                    <option value="PROCESSING">PROCESSING</option>
                                    <option value="REJECTED">REJECTED</option>
                                </select>
                            </span> -->

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row no-gutters mp-mb4">
        <div class="col-12 mp-ph2 mp-pv2">

            <div class="card-container card p-0">
                <div class="card-header d-flex maroon-bg">
                    <span>Benefit List</span>
                </div>

                <div class="card-body justify-content-center gap-10 flex-row p-0 mp-ph2">
                    <div class="container-fluid no-gutters black-clr">
                        <div class="row">
                            <div class="col-12">
                                <div class="mp-mt2 d-flex apply-button">
                                    <span class="">
                                        <a href="/member/benefits/claim" class="mp-button mp-button--primary" style="color:white;">
                                            Claim Benefits
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="overflow-y: auto;">
                            <div class="col-1g-12" style="padding:15px;">
                                <div class="d-flex flex-column">
                                    <div class="header-table">
                                        <table class="payroll-table" id="benefit_applications_table" style="height: auto;" width="100%">
                                            <thead>
                                                <tr>
                                                    <th style="width: 60px">
                                                        <span>Action</span>
                                                    </th>
                                                    <th>
                                                        <span>Mode of Seperation</span>
                                                    </th>
                                                    <th>
                                                        <span>Effectivity Date</span>
                                                    </th>
                                                    <th>
                                                        <span>Remarks</span>
                                                    </th>

                                                    <th>
                                                        <span>Date Created</span>
                                                    </th>
                                                    <th>
                                                        <span>Status</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- <tr>
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
                                                </tr> -->
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
    benefit_applications_table = $('#benefit_applications_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('getBenefitApplications') }}",
            "data": function(data) {
                data.mode_of_seperation_select = $('#mode_of_seperation_select').val();
                data.status_select = $('#status_select').val();
                data.membership_date_from_select = $('#membership_date_from_select').val();
                data.membership_date_to_select = $('#membership_date_to_select').val();

            },
        },
        columns: [{
                data: 'action',
                name: 'action',

            },
            {
                data: 'mode_of_seperation',
                name: 'mode_of_seperation',

            },
            {
                data: 'effectivity',
                name: 'effectivity',

            },
            {
                data: 'remarks',
                name: 'remarks',

            },
            {
                data: 'date_created',
                name: 'date_created',

            },
            {
                data: 'status',
                name: 'status',

            },






        ]
    });
    $('#mode_of_seperation_select').on('change', function() {
        benefit_applications_table.draw();
    });
    $('#status_select').on('change', function() {
        benefit_applications_table.draw();
    });



    $('#membership_date_from_select').on('change', function() {
        benefit_applications_table.draw();
    });
    $('#membership_date_to_select').on('change', function() {
        benefit_applications_table.draw();
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