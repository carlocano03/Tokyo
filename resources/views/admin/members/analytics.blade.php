@extends('layouts/main')
@section('content_body')
<style>
    .card-container {
        display: flex;
        flex-direction: column;
    }

    .card-header {
        border-top-left-radius: 7px;
        border-top-right-radius: 7px;
        background-color: gray;
        padding: 5px 10px;
        color: white;
    }

    .card-body {
        display: flex;
        flex-direction: row;
        border-bottom-left-radius: 7px;
        border-bottom-right-radius: 7px;
        padding: 5px 10px;
        background-color: white;
    }

    .card-body>span {
        font-size: 20px;
    }

    .card-body>h1 {
        width: 60px;
    }

    .font-15 {
        font-size: 18px;
    }

    .font-13 {
        font-size: 13px;
    }

    .history-item {
        padding: 3px;
        padding: 10px 10px;
    }

    .history-container {
        min-height: calc(57vh - 10px);
        max-height: calc(57vh - 10px);
        overflow: auto;
        padding: 0;

    }

    .table-container {
        /* min-height: calc(60vh - 220px);
        max-height: calc(60vh - 50px);
        overflow: auto; */
    }

    .summary-container {
        max-height: calc(60vh - 220px);
        overflow: auto;
    }

    .record-container {
        min-height: 65vh;
        max-height: 65vh;
    }


    .p-0 {
        padding: 0;
    }

    .record-container {
        min-height: 65vh;
        max-height: 65vh;
    }


    .f-button {
        background-color: #6c1242;
        color: white;
        padding-left: 15px;
        padding-right: 15px;
        border-radius: 20px;
        font-size: 14px;
    }

    .history-logs {
        background-color: #1a8981;
    }

    .filtering {
        background-color: #894168;
    }

    /* .members-table {
        border-collapse: collapse;
        margin: 0;
        padding: 0;
        width: 100%;
        table-layout: fixed;
        border: 1px solid #ececec;
    }

    .members-table>thead>tr>th {
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
    }

    .members-table>thead>tr>th:first-child {
        border-left: 1px solid #1a8981;
    }

    .members-table>thead>tr>th:last-child {
        border-right: 1px solid #1a8981;
    }

    .members-table>thead>tr>th>span {
        display: flex;
        height: 100%;
    }

    .members-table>tbody>tr>td>span {
        display: flex;
        padding: 5px 2px;

    }

    .members-table>tbody>tr>td {
        font-size: 12px;
        padding-left: 5px;
        padding-right: 5px;
    } */


    .view {
        padding: 0;
        margin: 0;
        width: 100%;
        text-align: center;
        justify-self: center;
        align-self: center;
    }

    .member-name {
        font-weight: 700;
    }

    .filtering-section-body {
        padding: 10px;
        display: flex;
    }

    .percent {
        width: 150px;
        height: 150px;
        position: relative;
    }

    .percent svg {
        width: 150px;
        height: 150px;
        position: relative;
    }

    .percent svg circle {
        width: 150px;
        height: 150px;
        fill: none;
        stroke-width: 10;
        stroke: #000;
        transform: translate(5px, 5px);
        stroke-dasharray: 440;
        stroke-dashoffset: 440;
        stroke-linecap: round;
    }

    .percent svg circle:nth-child(1) {
        stroke-dashoffset: 0;
        stroke: #f3f3f3;
    }



    .percent .num {
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        position: absolute;
        color: #111;
    }

    .percent .num h2 {
        font-size: 48px;
    }

    .percent .num h2 span {
        font-size: 24px;
    }

    .text {
        padding: 10px 0 0;
        color: #999;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .blue-bg {
        background-color: #3fa9c9;
        color: white;
    }

    .green-bg {
        background-color: #39b74d;
        color: white;
    }

    .green.ldBar path.mainline {
        stroke-width: 10;
        stroke: #39b74d;
        stroke-linecap: round;
    }

    .magenta.ldBar path.mainline {
        stroke-width: 10;
        stroke: #1a8981;
        stroke-linecap: round;
    }

    .magenta-clr {
        color: #1a8981;
    }

    .green-clr {
        color: #39b74d;
    }

    .orage-clr {
        color: rgb(247, 163, 92);
    }

    .maroon.ldBar path.mainline {
        stroke-width: 10;
        stroke: #894168;
        stroke-linecap: round;
    }

    .red.ldBar path.mainline {
        stroke-width: 10;
        stroke: #de2e4f;
        stroke-linecap: round;
    }

    .ldBar path.baseline {
        stroke-width: 10;
        stroke: #f1f2f3;
        stroke-linecap: round;
    }

    .button-view {
        border-bottom-left-radius: 7px;
        border-bottom-right-radius: 7px;
        color: white;
    }

    .magenta-bg {
        background-color: #1a8981;
    }

    .maroon-bg {
        background-color: #894168;
    }

    .red-bg {
        background-color: #de2e4f;
    }

    .link-style {
        color: #1a8981;
    }

    .link-style:hover {
        text-decoration: underline;
        color: #1a8981;
    }

    .font-sm {
        font-size: 13px;
    }

    .font-md {
        font-size: 15px;
    }

    .text-center {
        text-align: center;
    }

    .ml-auto {
        margin-left: auto;
    }

    .middle-content {
        width: calc(80% - 10px);
        transition: all .5s;
    }

    .middle-content.full {
        width: 100%;
        transition: all .5s;
    }

    .right-content {
        width: 20%;
        opacity: 1;
        transition: all .2s;
    }

    .right-content.full {
        width: -1%;
        opacity: 0;
    }

    .d-none {
        display: none !important;
    }

    .w-full {
        width: 100%;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    .w-auto {
        width: 100%;
    }

    .w-80 {
        width: calc(88% - 10px);
    }

    .table-form {
        display: grid;
        grid-template-columns: repeat(12, 1fr);
    }

    .span-1 {
        grid-column: span 1;
    }

    .span-2 {
        grid-column: span 2;
    }

    .span-3 {
        grid-column: span 3;
    }

    .span-4 {
        grid-column: span 4;
    }

    .span-5 {
        grid-column: span 5;
    }

    .span-6 {
        grid-column: span 6;
    }

    .span-7 {
        grid-column: span 7;
    }

    .span-8 {
        grid-column: span 8;
    }

    .span-9 {
        grid-column: span 9;
    }

    .span-10 {
        grid-column: span 10;
    }

    .span-11 {
        grid-column: span 11;
    }

    .span-12 {
        grid-column: span 12;
    }

    .color-white {
        color: white;
    }

    .orage-bg {
        background-color: rgb(247, 163, 92);
    }

    .w-input {
        width: 95%;
        border-radius: 5px;
        border: 1px solid gray;
    }

    .min-h-50vh {
        min-height: 50vh;
        max-height: 50vh;
        overflow-y: auto;
    }

    .border-content>div {
        border-top: 1px solid gray;
        border-right: 1px solid gray;
    }

    .border-content>div:last-child {
        border-bottom: 1px solid gray;
    }

    .border-content>div>div {
        border-left: 1px solid gray;
    }

    .border-content>div>div:first-child {
        border-left: 0px
    }

    .circle {
        height: 15px;
        width: 15px;
        border-radius: 50%;
        background-color: #6c1242;
        align-self: center;

    }

    .top-circle {
        top: -6px;
    }

    .line-trail {
        margin-bottom: 20px;
        height: 2px;
        background-color: red;
    }

    .line-child {
        background-color: #6c1242;
        height: 100%;
    }

    .white {
        background-color: white;
    }

    .trail {
        overflow: hidden;
        transition: all .5s;
    }

    .trail.close-trail {
        height: 50px;
    }

    .trail-details.hidden-details {
        opacity: 0;
    }

    .font-bold {
        font-weight: 500;
    }

    .status-title {
        font-size: 12pt;
        padding: 3px 10px;
        border-radius: 12px;
        color: white;
    }


    .gray-bg {
        background-color: #ececec;
    }

    .w-trail {
        width: 98%;
    }

    .justify-items-center {
        justify-items: center;
    }


    .font-lg {
        font-size: 30px;
    }


    .opacity-0 {
        opacity: 0 !important;
    }

    #summaryModal {
        position: absolute;
        width: calc(100vw - 250px);
        height: 100vh;
        background-color: rgba(0, 0, 0, .1);
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all .5s;
        opacity: 1;
    }

    .modalContent {
        position: absolute;
        display: flex;
        flex-direction: column;
        min-width: 400px;
        width: 40vw;
        height: auto;
        background-color: white;
        margin-bottom: 100px;
        padding: 0;
        border-radius: 17px;
        transition: all .5s;
        padding-bottom: 30px;
    }

    .modalBody {
        height: 90%;
        display: flex;
        align-items: center;
        padding: 40px;
    }

    .modalFooter {
        display: flex;
        justify-content: center;
        flex-direction: row;
        gap: 10px;
    }

    .modalFooter>button {
        font-size: 25px;
        padding-left: 20px;
        padding-right: 20px;
        background-color: #894168;
        font-weight: 400;
        color: white;
        border-radius: 17px;
    }

    .modalFooter>#cancel-button {
        font-size: 25px;
        padding-left: 20px;
        padding-right: 20px;
        background-color: #f0e7ec;
        font-weight: 400;
        color: black;
        border-radius: 17px;
    }

    .modalHeader {
        background-color: #1a8981;
        color: white;
        border-top-left-radius: 17px;
        border-top-right-radius: 17px;
        padding: 10px;
        padding-left: 20px;
        padding-right: 20px;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }


    .table-component {
        border-collapse: collapse;
        margin: 0;
        padding: 0;
        width: 100%;
        table-layout: fixed;
        border: 1px solid #ececec;
    }

    .table-component>thead>tr>th {
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
    }

    .table-component>thead>tr>th:first-child {
        border-left: 1px solid #1a8981;
    }

    .table-component>thead>tr>th:last-child {
        border-right: 1px solid #1a8981;
    }

    .table-component>thead>tr>th>span {
        display: flex;
        height: 100%;
    }

    .table-component>tbody>tr>td>span {
        display: flex;
        padding: 5px 2px;

    }

    .table-component>tbody>tr>td {
        font-size: 12px;
        padding-left: 5px;
        padding-right: 5px;
    }

    #summaryModal {
        display: none;
    }

    .members-module {
        height: 100%;
        width: 100%;
        min-height: 95vh;
        display: flex;
        flex-direction: row;
        margin-top: 10px;
        position: relative;
        gap: 5px;
    }

    @media (max-width:652px) {
        .members-module {
            margin-top: 53px;
        }

        .siderbar {
            position: absolute;
            height: 100%;
            min-height: 95vh;
            z-index: 100;
        }
    }

    .siderbar {
        max-width: 15px;
        min-width: 15px;
        height: auto;
        background-color: white;
    }

    .siderbar.showed {
        max-width: 250px;
        min-width: 250px;
        height: auto;
        background-color: white;
    }

    .siderbar.showed div {
        display: flex;
    }

    .siderbar>div {
        border: 1px solid #e9dfdf;
        display: none;
    }

    .siderbar>.item {
        cursor: pointer;
    }

    .siderbar>.item:hover {
        background-color: #f6f6f6;
    }

    .members-content {
        width: 100%;
        height: auto;
    }

    .item.active {
        background-color: #6c1242;
        color: white;
    }

    .item.active:hover {
        background-color: #6c1242;
        color: white;
    }

    .toggle-icon {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        position: absolute;
        right: -7px;
        top: 20px;
    }
</style>
<div id="summaryModal" class="">

    <div class="modalContent">
        <div class="modalHeader">
            Summary Result
            <a class="cursor-pointer mp-ph0 mp-pv0"><i class="fa fa-times-circle-o " aria-hidden="true"></i></a>
        </div>
        <div class="modalBody">
            <div class="mp-mt3 summary-container">
                <table class="table-component" style="height: auto;" width="100%" id="forward_tbl">
                    <thead>
                        <tr>
                            <th>
                                <span>Application No.</span>
                            </th>
                            <th>
                                <span>Date of Application</span>
                            </th>
                            <th>
                                <span>Full Name</span>
                            </th>

                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <div class="w-full mp-mt3 mp-mb3 mp-pv1 font-md">
                    <p>
                        Endorsement Date: <span>{{ date('F d,Y H:i:s') }}</span>
                    </p>
                    <p>
                        Endorsed by: <span>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                    </p>
                    <!-- <p>
                        Endorse to: 
                        <select name="" id="" class="radius-1 outline select-field mp-pr2"
                            style="height: 30px;margin-top: auto;margin-bottom: auto;">
                            <option value="">
                                All Records
                            </option>
                            <option value="">
                                AA
                            </option>
                            <option value="">
                                CFM
                            </option>
                            <option value="">
                                HRDO
                            </option>
                        </select>
                    </p> -->
                    <p>
                        <span id="campus_userlevel">Campus:</span>
                        <select name="hrdo_user" id="hrdo_user" class="radius-1 outline select-field mp-pr2" style="height: 30px;margin-top: auto;margin-bottom: auto;">
                            <option value="">
                                Please select
                            </option>

                        </select>
                    </p>
                </div>
            </div>
        </div>
        <div class="modalFooter">
            <button id="foward_confirm">
                Proceed
            </button>
            <button class="cancel_modal" id="cancel-button">
                Cancel
            </button>
        </div>
    </div>
</div>
<div class="filler"></div>
<script type="text/javascript" src="{{ asset('/dist/loading-bar/loading-bar.js') }}"></script>
<script>
    $(document).on('click', '#showLogs', function(e) {
        if ($(".middle-content").hasClass("full")) {
            $(".middle-content").removeClass("full")
            setTimeout(function() {
                $(".right-content").removeClass("d-none")
                $(".right-content").removeClass("full")
            }, 500)

            $("#showLogs").text("Hide history logs")
            // $(".view-options").removeClass("span-3")
            // $(".view-options").addClass("span-2")
            // $(".date-selector").removeClass("span-3")
            // $(".date-selector").addClass("span-5")
            // $(".select-dropdown").removeClass("span-3")
            // $(".select-dropdown").addClass("span-2")
        } else {

            $(".right-content").addClass("full")

            setTimeout(function() {
                $(".right-content").addClass("d-none")
                $(".middle-content").addClass("full")
            }, 200)


            $("#showLogs").text("Show history logs")
        }
    })

    $(document).on('click', '.toggle-icon', function(e) {
        if ($(".fa-chevron-circle-right").hasClass("d-none")) {
            $(".fa-chevron-circle-right").removeClass("d-none")
            $(".fa-chevron-circle-left").addClass("d-none")
            $(".siderbar").removeClass("showed")
            return
        }
        $(".fa-chevron-circle-right").addClass("d-none")
        $(".fa-chevron-circle-left").removeClass("d-none")
        $(".siderbar").addClass("showed")
    })

    const links = ['', '/payroll', '/movement', '/analytics']

    $(document).on('click', '#sider-item', function(e) {
        const dataSet = $(this).attr('data-set')
        window.location.href = '/admin/members/records' + links[dataSet]
    })
</script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('/dist/loading-bar/loading-bar.css') }}" />
<div class="members-module">
    <div class="siderbar d-flex flex-column showed" style="position:relative">
        <span class="toggle-icon" style="cursor: pointer">
            <i class="fa fa-chevron-circle-left mp-text-fs-base magenta-clr " style="background-color: white;border-radius: 50%" aria-hidden="true"></i>
            <i class="fa fa-chevron-circle-right mp-text-fs-base magenta-clr d-none" style="background-color: white;border-radius: 50%" aria-hidden="true"></i>
        </span>
        <div class="title mp-text-fs-large mp-text-fw-heavy mp-ph3 mp-pv3">
            Membership Application
        </div>
        <div class="item flex-column gap-5 mp-ph3 mp-pv3" id="sider-item" data-set="0">
            <span>
                Application Records
            </span>

        </div>
        <div class="item flex-column gap-5 mp-ph3 mp-pv3" id="sider-item" data-set="1">
            <span>
                Payroll Advise Reports
            </span>

        </div>
        <div class="item flex-column gap-5 mp-ph3 mp-pv3" id="sider-item" data-set="2">
            <span>
                Application Movement Reports
            </span>

        </div>
        <div class="item flex-column gap-5 mp-ph3 mp-pv3 active" id="sider-item" data-set="3">
            <span>
                Application Analytics
            </span>

        </div>
    </div>
    <div class="members-content mp-pr2 d-flex flex-column gap-5 mh-content">
        <div class="title mp-text-fs-large mp-text-fw-heavy mp-ph3 mp-pv3">
            Application Analytics Reports
        </div>
        <div class="card-container card p-0">
            <div class="card-header filtering items-between d-flex magenta-bg">
                <span>Filtering Section</span>
            </div>


            <div class="card-body filtering-section-body justify-content-center gap-10 flex-row">

                <div class="w-full d-flex flex-row flex-wrap gap-10">
                    <span class="d-flex flex-column span-3 mp-pv2 flex-nowrap date-selector">
                        <span>Application Date</span>
                        <div class="date_range d-flex">
                            <input type="date" id="from" class="radius-1 border-1 date-input outline" style="height: 30px;">
                            <span for="" class="self_center mv-1" style="margin-left:5px; margin-right:5px;">to</span>
                            <input type="date" id="to" class="radius-1 border-1 date-input outline" style="height: 30px;">
                        </div>
                    </span>
                    <span class="d-flex flex-column span-2 mp-pv2 flex-nowrap">
                        <span>Select Cluster</span>
                        <select name="" class="radius-1 outline select-field" style="width: 200px; height: 30px" id="remarks_select">
                            <option value="">Select Cluster No.</option>
                            <option value="1">Cluster 1 - DSB</option>
                            <option value="2">Cluster 2 - LBOU</option>
                            <option value="3">Cluster 3 - MLAPGH</option>
                            <option value="4">Cluster 4 - CVM</option>
                        </select>
                    </span>
                    <span class="d-flex flex-column span-2 mp-pv2 flex-nowrap">
                        <span>Select Campus</span>
                        <select name="" class="radius-1 outline select-field" style="width: 200px; height: 30px" id="remarks_select">
                            <option value="">Show All</option>
                            <option value="AA VERIFIED">AA VERIFIED</option>
                            <option value="FORWARDED TO HRDO">FORWARDED TO HRDO</option>
                            <option value="FORWARDED TO FM">FORWARDED TO FM</option>
                            <option value="HRDO RETURNED APPLICATIONS">HRDO RETURNED APPLICATIONS</option>
                        </select>
                    </span>

                </div>
                <!-- <div class="">
                                <label for="row">Membership Date</label>
                                <div class="row date_range">
                                    <input type="date" id="from" class="radius-1 border-1 date-input outline"
                                        style="height: 30px;">
                                    <span for="" class="self_center mv-1"
                                        style="margin-left:15px; margin-right:15px;">to</span>
                                    <input type="date" id="to" class="radius-1 border-1 date-input outline"
                                        style="height: 30px;">
                                </div>
                            </div> -->

            </div>
        </div>
        <div>
            <figure class="highcharts-figure">
                <div id="container"></div>
            </figure>
            <script>
                Highcharts.chart('container', {
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: '',
                        align: 'left'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    accessibility: {
                        point: {
                            valueSuffix: '%'
                        }
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: false
                            },
                            showInLegend: true
                        }
                    },
                    series: [{
                        name: 'Brands',
                        colorByPoint: true,
                        data: [{
                            name: 'New',
                            y: 74.77,
                            // sliced: true,
                            // selected: true
                        }, {
                            name: 'Processing',
                            y: 12.82
                        }, {
                            name: 'Approved',
                            y: 4.63
                        }, {
                            name: 'Draft',
                            y: 2.44
                        }, {
                            name: 'Returned',
                            y: 2.02
                        }, {
                            name: 'Rejected',
                            y: 3.28
                        }]
                    }]
                });
            </script>
        </div>
    </div>
</div>


<script>
    var tableMemberApp;
    $(document).ready(function() {
        tableMemberApp = $('.members-table').DataTable({
            language: {
                search: '',
                searchPlaceholder: "Search Here...",
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><br>Loading...',
            },
            "ordering": false,
            "searching": false,
            "processing": true,
            "serverSide": true,
            "scrollX": true,
            "ajax": {
                "url": "{{ route('getMembers') }}",
                "data": function(data) {
                    data.campus = $('#campuses_select').val();
                    data.department = $('#department_select').val();
                    data.dt_from = $('#from').val();
                    data.dt_to = $('#to').val();
                    data.searchValue = $('#search_value').val();
                    data.status = $('#status_select').val();
                    data.remarks = $('#remarks_select').val();
                }
            },
            "drawCallback": function(settings) {
                if (tableMemberApp.data().length > 0) {
                    if ($('#campuses_select').val() != '') {
                        $('#check_all').css('background-color', '');
                        $('#check_all').prop('disabled', false);
                        campus_checked = $('#campuses_select').find(":selected").text();
                        clicked_check = 0;
                    } else {
                        $('#check_all').css('background-color', 'gray');
                        $('#check_all').prop('disabled', true);
                        clicked_check = 0;
                    }
                } else {
                    $('#check_all').css('background-color', 'gray');
                    $('#check_all').prop('disabled', true);
                    clicked_check = 0;
                }
            }
        });
        $('#check_all').click(function() {
            // Loop through all checkboxes in the table body
            $('.members-table tbody input[type="checkbox"]').each(function() {
                // Check the checkbox if it is not disabled
                if (!$(this).prop('disabled')) {
                    if (!$(this).prop('checked')) {
                        $(this).prop('checked', true);
                        clicked_check++;
                    }
                    if (clicked_check > 0) {
                        $('.proceed_fwd').css('background-color', '');
                        $('.proceed_fwd').prop('disabled', false);
                    } else {
                        $('.proceed_fwd').css('background-color', 'gray');
                        $('.proceed_fwd').prop('disabled', true);
                    }
                } else if ($(this).prop('checked')) {
                    clicked_check--;
                }
            });
        });

        $('#campuses_select').on('change', function() {
            tableMemberApp.draw();
            campus_checked = $(this).find(":selected").text();
        });
        $('#department_select').on('change', function() {
            tableMemberApp.draw();
        });
        $('#search_value').on('change', function() {
            tableMemberApp.draw();
        });
        $('#status_select').on('change', function() {
            tableMemberApp.draw();
        });
        $('#remarks_select').on('change', function() {
            tableMemberApp.draw();
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
                tableMemberApp.draw();
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
                tableMemberApp.draw();
            }
        });
    });
    $('#modal_proceed').on('click', function() {
        if ($('#forward_action').val()) {
            $('.select_item:checked').each(function() {
                var row = $(this).closest('tr');
                var col3 = row.find('td:eq(2)').text();
                var col4 = row.find('td:eq(3)').text();
                var col5 = row.find('td:eq(4)').text();
                var newRow = '<tr class="appended-row"><td>' + col3 + '</td><td>' + col4 + '</td><td>' + col5 + '</td></tr>';
                $('#forward_tbl').append(newRow);
            });
            var campusspan = campus_checked + ' ' + $('#forward_action').val();
            var forward_action = $('#forward_action').val();
            $('#summaryModal').css('display', 'flex');
            if ($('#forward_action').val() == 'FM') {
                $('#campus_userlevel').text('User:');
                $.getJSON('/hrdo_user', {
                    department: campus_checked,
                    forward_action: forward_action
                }, function(options) {
                    $.each(options, function(index, option) {
                        $('#hrdo_user').append($('<option>', {
                            value: option.id,
                            text: forward_action + ' ' + option.first_name + ' ' + option.last_name,
                        }));
                    });
                });
            } else {
                $('#campus_userlevel').text('Campus:');
                $.getJSON('/hrdo_user', {
                    department: campus_checked,
                    forward_action: forward_action
                }, function(options) {
                    $.each(options, function(index, option) {
                        $('#hrdo_user').append($('<option>', {
                            value: option.id,
                            text: campus_checked + ' ' + forward_action + ' ' + option.first_name + ' ' + option.last_name,
                        }));
                    });
                });
            }
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please select an action. Thank you!',
            });
        }
    });
    $('.cancel_modal').on('click', function() {
        $('#summaryModal').css('display', 'none');
        $('#forward_tbl tbody').empty();
        $('#hrdo_user').empty().append('<option value="">Please select</option>');
    });
    var campus_checked;
    var clicked_check = 0;
    $(document).ready(function() {
        $('.proceed_fwd').css('background-color', 'gray');
        $('.proceed_fwd').prop('disabled', true);
        $('#check_all').css('background-color', 'gray');
        $('#check_all').prop('disabled', true);
        $(document).on('change click', '.select_item', function() {
            clicked_check = 0;
            if ($(this).is(':checked')) {
                clicked_check++;
                var row = $(this).closest('tr');
                var campusValue = tableMemberApp.cell(row, 8).data();
                campus_checked = campusValue;
                // disable checkboxes in other rows that have different "campus" values
                $('input.select_item').each(function() {
                    var otherRow = $(this).closest('tr');
                    var otherCampusValue = tableMemberApp.cell(otherRow, 8).data();
                    if (otherCampusValue != campusValue) {
                        $(this).prop('disabled', true);
                    }
                });
            } else {
                clicked_check--;
                var row = $(this).closest('tr');
                $('input.select_item').each(function() {
                    var otherRow = $(this).closest('tr');
                    var evaluatedValue = tableMemberApp.cell(row, 10).data();
                    var otherevaluatedValue = tableMemberApp.cell(otherRow, 10).data();
                    if (otherevaluatedValue == evaluatedValue) {
                        $(this).prop('disabled', false);
                    }
                });
            }
            if (clicked_check > 0) {
                $('.proceed_fwd').css('background-color', '');
                $('.proceed_fwd').prop('disabled', false);
            } else {
                $('.proceed_fwd').css('background-color', 'gray');
                $('.proceed_fwd').prop('disabled', true);

            }
        });
        // 
        $(document).on('click', '#foward_confirm', function() {
            event.preventDefault();
            var formDatas = {};
            var appNos = [];
            if ($('#hrdo_user').val()) {
                $('#forward_tbl tbody tr').each(function() {
                    var appNo = $(this).find('td:eq(0)').text();
                    appNos.push(appNo);
                });
                formDatas.app_nos = appNos;
                formDatas.app_nos = appNos;
                formDatas.hrdo_user = $('#hrdo_user').val();
                formDatas.forward_action = $('#forward_action').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: "{{ route('forward_application') }}",
                    data: formDatas,
                    success: function(data) {
                        if (data.success != '') {
                            Swal.fire({
                                text: 'Application has been forwarded to ' + $('#forward_action').val() + ' successfully.',
                                icon: 'success',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Proceed',
                            });
                            tableMemberApp.draw();
                            $('#summaryModal').css('display', 'none');;
                            $('#forward_tbl tbody').empty();
                            $('#forward_action').val('');
                            $('.proceed_fwd').css('background-color', 'gray');
                            $('.proceed_fwd').prop('disabled', true);
                            $('#hrdo_user').empty().append('<option value="">Please select</option>');
                        } else {
                            swal.fire("Error!", "Saving failed", "error");
                        }
                    }
                });
            } else {
                swal.fire("Error!", "Please select an user to forward this transaction.", "error");
            }
        });

    });
</script>
@endsection