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

    </style>
    <div class="filler"></div>
    <div class="container mp-container mh-content members-module">

        <div class="row no-gutters mp-mt5">
            <div class="col-12 mp-ph2 mp-pv2 mp-text-fs-large mp-text-c-primary members-header">
                Loan Application
                <span style="position: relative; float: right;">
                    <a href="{{ url('/member/new-loan') }}" class="mp-button mp-button--primary">
                        Apply for Loan
                    </a>
                </span>
            </div>

        </div>


        <div class="row no-gutters mp-mb4">
            <div class="col-12 mp-ph2 mp-pv2">
                <div class="row no-gutters">

                    <div class="col-6 col-lg-3">
                        <div class="mp-tab mp-tab--active">
                            <a class="mp-tab__link" href="#">
                                Loan Application
                            </a>
                        </div>
                        
                    </div>
                    <span style="margin-left: auto">
                        <a href="#" id="exportLoanApplication" 
                            class="toggle text_link mp-button mp-button--primary mp-button--ghost mp-button--raised mp-button--mini mp-text-fs-small up-button">Export
                            Data
                        </a>
                    </span>
                    <!--    <div class="col-6 col-lg-3">
              <div class="mp-tab ">
                <a class="mp-tab__link" href="#">
                  Co-Borrower Loan
                </a>
              </div>
            </div> -->

                </div>
                <div class="row no-gutters">
                    <div class="col">
                    <div class="mp-ph4 mp-pv4 ft-card border-bottom-0 border-top-left-0">
                            <div class="row mp-pv4">
                                <label for="" class="mp-text-fs-xlarge mp-text--c-white ">Filtering Section</label>
                            </div>
                            <div class="row items-between mp-pv4">
                                <div class="col-md-12 col-xl-6">
                                    <div class="row mp-text--c-white">
                                        <label for="row">Fields</label>
                                    </div>
                                    <div class="row field-filter">
                                        <select name="" class="radius-1 outline select-field"
                                            style="width: 100%; height: 30px" id="loan_type">
                                            <option value="">Filter By Loan Type</option>
                                            
                                        </select>
                                        <select name="" class="radius-1 outline select-field"
                                            style="width: 100%; height: 30px" id="loan_status">
                                            <option value="">Filter By Status</option>
                                            <option value="PROCESSING">PROCESSING</option>
                                            <option value="DONE">DONE</option>
                                            <option value="CONFIRMED">CONFIRMED</option>
                                            <option value="CANCELLED">CANCELLED</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-5">
                                    <div class="row mp-text--c-white">
                                        <label for="row">Date Range based on Date Applied Date</label>
                                    </div>
                                    <div class="row date_range">
                                        <input type="date" id="from"
                                            class="radius-1 border-1 date-input outline" style="height: 30px;">
                                        <span for="" class="self_center mh-1 mp-text--c-white">to</span>
                                        <input type="date" id="to"
                                            class="radius-1 border-1 date-input outline" style="height: 30px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mp-ph4 mp-pv4 tb-card border-top-0">

                            <div class="mp-text-fs-medium {{ Session::has('error') or (Session::has('success') ? 'mp-mb4' : '') }}"
                                align="center">
                                @if (Session::has('error'))
                                    <span style="color:red"><strong>{{ Session::get('error') }}</strong></span>
                                @endif
                                @if (Session::has('success'))
                                    <span style="color:green"><strong>{{ Session::get('success') }}</strong></span>
                                @endif
                            </div>


                            <br>

                            <div class="mp-overflow-x">
                                <!-- <div class="mp-ph4 mp-pv4 ft-card border-bottom-0">
                                    <div class="row mp-pv4">
                                        <label for="" class="mp-text-fs-xlarge mp-text--c-white ">Filtering
                                            Section</label>
                                    </div>
                                    <div class="row items-between mp-pv4">
                                        <div class="col-md-12 col-xl-6">
                                            <div class="row mp-text--c-white">
                                                <label for="row">Fields</label>
                                            </div>
                                            <div class="row field-filter">
                                                <select name="" class="radius-1 outline select-field"
                                                    style="width: 100%; height: 30px" id="loan_type">
                                                    <option value="">Filter By Loan Type</option>
                                                   
                                                </select>
                                                <select name="" class="radius-1 outline select-field"
                                                    style="width: 100%; height: 30px" id="loan_status">
                                                    <option value="">Filter By Status</option>
                                                    <option value="PROCESSING">PROCESSING</option>
                                                    <option value="DONE">DONE</option>
                                                    <option value="CONFIRMED">CONFIRMED</option>
                                                    <option value="CANCELLED">CANCELLED</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-xl-5">
                                            <div class="row mp-text--c-white">
                                                <label for="row">Date Range based on Date Applied Date</label>
                                            </div>
                                            <div class="row date_range">
                                                <input type="date" id="from"
                                                    class="radius-1 border-1 date-input outline" style="height: 30px;">
                                                <span for="" class="self_center mh-1 mp-text--c-white">to</span>
                                                <input type="date" id="to"
                                                    class="radius-1 border-1 date-input outline" style="height: 30px;">
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                           
                                <table class="mp-table mp-text-fs-small" id="member_loan_table" cellspacing="0"
                                    width="100%">
                                    <thead>
                                        <tr>
                                            <th class="mp-text-center"></th>
                                            <th class="mp-text-center">Date Applied</th>
                                            <th class="mp-text-center">Loan Application Number</th>
                                            <th class="mp-text-center">Loan Type</th>
                                            <th class="mp-text-center">Loan Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                            <a data-md-tooltip="View Details" href="#" id="member_loandet" data-id="47">
                                                <i class="mp-icon md-tooltip icon-book-open mp-text-c-primary mp-text-fs-large"></i>
                                            </a>
                                            </td>
                                            <td>
                                                asdasdsad
                                            </td>
                                            <td>
                                                asdasdsad
                                            </td>
                                            <td>
                                                asdasdsad
                                            </td>
                                            <td>
                                                asdasdsad
                                            </td>
                                           
                                        </tr>
                                        <tr>
                                            <td>
                                            <a data-md-tooltip="View Details" href="#" id="member_loandet" data-id="47">
                                                <i class="mp-icon md-tooltip icon-book-open mp-text-c-primary mp-text-fs-large"></i>
                                            </a>
                                            </td>
                                            <td>
                                                asdasdsad
                                            </td>
                                            <td>
                                                asdasdsad
                                            </td>
                                            <td>
                                                asdasdsad
                                            </td>
                                            <td>
                                                asdasdsad
                                            </td>
                                           
                                        </tr>
                                        <tr>
                                            <td>
                                            <a data-md-tooltip="View Details" href="#" id="member_loandet" data-id="47">
                                                <i class="mp-icon md-tooltip icon-book-open mp-text-c-primary mp-text-fs-large"></i>
                                            </a>
                                            </td>
                                            <td>
                                                asdasdsad
                                            </td>
                                            <td>
                                                asdasdsad
                                            </td>
                                            <td>
                                                asdasdsad
                                            </td>
                                            <td>
                                                asdasdsad
                                            </td>
                                           
                                        </tr>
                                        <tr>
                                            <td>
                                            <a data-md-tooltip="View Details" href="#" id="member_loandet" data-id="47">
                                                <i class="mp-icon md-tooltip icon-book-open mp-text-c-primary mp-text-fs-large"></i>
                                            </a>
                                            </td>
                                            <td>
                                                asdasdsad
                                            </td>
                                            <td>
                                                asdasdsad
                                            </td>
                                            <td>
                                                asdasdsad
                                            </td>
                                            <td>
                                                asdasdsad
                                            </td>
                                           
                                        </tr>
                                        <tr>
                                            <td>
                                            <a data-md-tooltip="View Details" href="#" id="member_loandet" data-id="47">
                                                <i class="mp-icon md-tooltip icon-book-open mp-text-c-primary mp-text-fs-large"></i>
                                            </a>
                                            </td>
                                            <td>
                                                asdasdsad
                                            </td>
                                            <td>
                                                asdasdsad
                                            </td>
                                            <td>
                                                asdasdsad
                                            </td>
                                            <td>
                                                asdasdsad
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
                ,
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
