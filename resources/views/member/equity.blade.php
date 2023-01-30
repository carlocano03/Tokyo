@extends('layouts/main')
@section('content_body')


<div class="filler"></div>
  <div class="col-12 mp-ph2 mp-pv2 mp-text-fs-large mp-text-c-accent mp-overflow-y dashboard mh-content">
         <div class="row no-gutters mp-mt5">
            <div class="col-6 mp-ph2 mp-pv2 mp-text-fs-large mp-text-c-primary">
                Your Account History
            </div>
            <div class="col-6">
                <div class=" mp-top-button"
                    style="display: flex; flex-direction: row; gap: 10px; justify-content: right; margin-right:30px; ">
                    
                        <!-- <span>
                            <a href="{{ url('/admin/summary') }}"
                                class="toggle text_link mp-button mp-button--primary mp-button--ghost mp-button--raised mp-button--mini mp-text-fs-small">Generate
                                Summary Report</a>
                        </span> -->
                    
                    <span>
                        <a href="#" id="exportEquity"
                            class="toggle text_link mp-button mp-button--primary mp-button--ghost mp-button--raised mp-button--mini mp-text-fs-small">Export
                            Data</a>
                    </span>
                    {{-- <button type="button" id="printMember">Print</button> --}}
                </div>
            </div>
        </div>



        <div class="row no-gutters mp-mb4">
            <div class="col-12 mp-ph2 mp-pv2">

                <div class="row no-gutters">
                    <div class="col">
                        <div class="container">
                            <!-- filter section  -->
                            <div class="row no-gutters mp-mb4">
                                <div class="col-12 ">
                                    <div class="row no-gutters">
                                        <div class="col-6 col-lg-3">
                                            <div class="mp-tab active-tab">
                                                <a class="mp-tab__link" href="{{ url('/member/equity') }}">
                                                    Member's Equity History
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-6 col-lg-3">
                                            <div class="mp-tab unactive-tab">
                                                <a class="mp-tab__link" href="{{ url('/member/transaction') }}">
                                                    Loan Transactions
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row no-gutters custom_header">
                                        <div class="col m-5">
                                            <div class="container bottom-divider top-divider">

                                                <div class="row">
                                                    <div class="col">
                                                        <label for="" class="filter-text">Filtering Section</label>
                                                    </div>
                                                </div>
                                                <div class="row items-between " style="margin:15px">
                                                    <div class="col-md-12 col-xl-6">
                                                        <div class="row">
                                                            <label for="row">Filter By Account</label>
                                                        </div>
                                                        <div class="row field-filter">
                                                            <select name="" class="radius-1 outline select-field"
                                                                style="width: 100%; height: 30px" id="filter_account">
                                                                <option value="">Show all</option>
                                                                    <option value="{{ 1 }}">value
                                                                    </option>
                                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-xl-5">
                                                        <div class="row">
                                                            <label for="row">Date Filter</label>
                                                        </div>
                                                        <div class="row date_range">
                                                            <input type="date" id="from"
                                                                class="radius-1 border-1 date-input outline"
                                                                style="height: 30px;">
                                                            <span for="" class="self_center mv-1"
                                                                style="margin:5px;">to</span>
                                                            <input type="date" id="to"
                                                                class="radius-1 border-1 date-input outline"
                                                                style="height: 30px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row no-gutters">
                                        <div class="col ">
                                            <div class="mp-ph4 mp-pv4 mp-card mp-card--tabbed">
                                                <div class="row">
                                                    <div class="col-4 ">
                                                        <label for="" class="mp-text-c-accent mp-text-fs-large">Member's Equity</label>
                                                    </div>
                                                    <div class="col-8">
                                                        <input type="text" id="search_value"
                                                            placeholder="Search by transaction">
                                                    </div>
                                                </div>
                                                <div class="mp-overflow-x">

                                                    <table class="mp-table mp-text-fs-small" id="equityTable"
                                                        cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>Transaction</th>
                                                                <th>Account</th>
                                                                <th>Debit</th>
                                                                <th>Credit</th>
                                                                <th>Balance</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>asd</td>
                                                                <td>asd</td>
                                                                <td>asd</td>
                                                                <td>asd</td>
                                                                <td>asd</td>
                                                                <td>asd</td>
                                                                <td>asd</td>
                                                            </tr>
                                                            <tr>
                                                                <td>asd</td>
                                                                <td>asd</td>
                                                                <td>asd</td>
                                                                <td>asd</td>
                                                                <td>asd</td>
                                                                <td>asd</td>
                                                                <td>asd</td>
                                                            </tr>
                                                            <tr>
                                                                <td>asd</td>
                                                                <td>asd</td>
                                                                <td>asd</td>
                                                                <td>asd</td>
                                                                <td>asd</td>
                                                                <td>asd</td>
                                                                <td>asd</td>
                                                            </tr>
                                                            <tr>
                                                                <td>asd</td>
                                                                <td>asd</td>
                                                                <td>asd</td>
                                                                <td>asd</td>
                                                                <td>asd</td>
                                                                <td>asd</td>
                                                                <td>asd</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="mp-card__footer__pair">
                                                    <div class="mp-card__footer__split mp-text-left">
                                                        <a href="{{ url('/generate/equity') }}" target="_blank"
                                                            class="mp-link mp-link--primary">
                                                            Download PDF
                                                        </a>
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


 