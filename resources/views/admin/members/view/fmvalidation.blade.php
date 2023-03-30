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
        min-height: calc(60vh - 220px);
        max-height: calc(60vh - 220px);
        overflow: auto;
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

    .members-table {
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
    }


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


    .remarks-gray-bg {
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

    .color-black {
        color: black;
    }

    .member-detail-title {
        border-bottom-left-radius: 7px;
        border-bottom-right-radius: 7px;
    }

    .member-detail-title.open-details {
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }

    .member-detail-body {
        display: none !important;
    }

    .member-detail-body.open-details {
        display: flex !important;
    }

    .membership-title {
        border-bottom-left-radius: 7px;
        border-bottom-right-radius: 7px;
    }

    .membership-title.open-details {
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }

    .membership-body {
        display: none !important;
    }

    .membership-body.open-details {
        display: flex !important;
    }


    .forms_attachment-title {
        border-bottom-left-radius: 7px;
        border-bottom-right-radius: 7px;
    }

    .forms_attachment-title.open-details {
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }

    .forms_attachment-body {
        display: none !important;
    }

    .forms_attachment-body.open-details {
        display: flex !important;
    }


    .employee-title {
        border-bottom-left-radius: 7px;
        border-bottom-right-radius: 7px;
    }

    .employee-title.open-details {
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }

    .employee-body {
        display: none !important;
    }

    .employee-body.open-details {
        display: flex !important;
    }

    .employee-detail {
        display: none;
    }

    .employee-detail.open-detail {
        display: grid;
    }
</style>
<div id="summaryModal" class="d-none">
    <div class="modalContent">
        <div class="modalHeader">
            Summary Result
            <a class="cursor-pointer mp-ph0 mp-pv0"><i class="fa fa-times-circle-o " aria-hidden="true"></i></a>
        </div>
        <div class="modalBody">
            <div class="mp-mt3 summary-container">
                <table class="table-component" style="height: auto;" width="100%">
                    <thead>
                        <tr>
                            <th style="width: 30px">
                                <span></span>
                            </th>
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
                        <tr>
                            <td>
                                <span><input type="checkbox"></span>
                            </td>
                            <td>
                                <span>23781623</span>
                            </td>
                            <td>
                                <span>01-01-2023</span>
                            </td>
                            <td>
                                <span>Devance, Joe</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span><input type="checkbox"></span>
                            </td>
                            <td>
                                <span>23781623</span>
                            </td>
                            <td>
                                <span>01-01-2023</span>
                            </td>
                            <td>
                                <span>Devance, Joe</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span><input type="checkbox"></span>
                            </td>
                            <td>
                                <span>23781623</span>
                            </td>
                            <td>
                                <span>01-01-2023</span>
                            </td>
                            <td>
                                <span>Devance, Joe</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="w-full mp-mt3 mp-mb3 mp-pv1 font-md">
                    <p>
                        Endorsement Date: <span>February 10, 2021 10:44 AM</span>
                    </p>
                    <p>
                        Endorsed by: <span>Stepen Curry</span>
                    </p>
                    <p>
                        Endorse to:
                        <select name="" id="" class="radius-1 outline select-field mp-pr2" style="height: 30px;margin-top: auto;margin-bottom: auto;">
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
                    </p>
                    <p>
                        Camppus: <span>UP Diliman HRDO</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="modalFooter">
            <button id="agree">
                Proceed
            </button>
            <button id="cancel-button">
                Cancel
            </button>
        </div>
    </div>
</div>
<div class="filler"></div>
<script>
    $(document).on('click', '#trail-button', function(e) {
        if ($("#trail-body").hasClass("close-trail")) {
            $("#trail-body").removeClass("close-trail")
            $(".trail-details").removeClass("hidden-details")
            $(".trail-up").removeClass("d-none")
            $(".trail-down").addClass("d-none")

        } else {
            $("#trail-body").addClass("close-trail")
            $(".trail-details").addClass("hidden-details")
            $(".trail-down").removeClass("d-none")
            $(".trail-up").addClass("d-none")
        }
    })

    $(document).on('click', '#member-detail-toggle', function(e) {
        if ($(".member-detail-body").hasClass("open-details")) {
            $(".member-detail-body").removeClass("open-details")
            $(".member-detail-title").removeClass("open-details")
            $(".member-up").removeClass("d-none")
            $(".member-down").addClass("d-none")

        } else {
            $(".member-detail-body").addClass("open-details")
            $(".member-detail-title").addClass("open-details")
            $(".member-down").removeClass("d-none")
            $(".member-up").addClass("d-none")
        }
    })

    $(document).on('click', '#membership-toggle', function(e) {
        if ($(".membership-body").hasClass("open-details")) {
            $(".membership-body").removeClass("open-details")
            $(".membership-title").removeClass("open-details")
            $(".membership-up").removeClass("d-none")
            $(".membership-down").addClass("d-none")

        } else {
            $(".membership-body").addClass("open-details")
            $(".membership-title").addClass("open-details")
            $(".membership-down").removeClass("d-none")
            $(".membership-up").addClass("d-none")
        }
    })
    $(document).on('click', '#forms_attachment-toggle', function(e) {
        if ($(".forms_attachment-body").hasClass("open-details")) {
            $(".forms_attachment-body").removeClass("open-details")
            $(".forms_attachment-title").removeClass("open-details")
            $(".forms_attachment-up").removeClass("d-none")
            $(".forms_attachment-down").addClass("d-none")

        } else {
            $(".forms_attachment-body").addClass("open-details")
            $(".forms_attachment-title").addClass("open-details")
            $(".forms_attachment-down").removeClass("d-none")
            $(".forms_attachment-up").addClass("d-none")
        }
    })

    $(document).on('click', '#employee-toggle', function(e) {
        if ($(".employee-body").hasClass("open-details")) {
            $(".employee-body").removeClass("open-details")
            $(".employee-title").removeClass("open-details")
            $(".employee-up").removeClass("d-none")
            $(".employee-down").addClass("d-none")

        } else {
            $(".employee-body").addClass("open-details")
            $(".employee-title").addClass("open-details")
            $(".employee-down").removeClass("d-none")
            $(".employee-up").addClass("d-none")
        }
    })
</script>
<div class="row no-gutter ml-0 mr-0 p-5px mh-content" id="view-member-details">

    <div class="w-full">
        <div class="card relative" style="min-height: 200px;">
            <a class="cursor-pointer mp-ph0 mp-pv0 view-member" style="position: absolute; top: 7px; left: 10px; color: black" href="/admin/members/records">
                <i class="fa fa-times-circle-o " aria-hidden="true"></i>
            </a>
            <div class="d-flex flex-row mp-pt3 gap-10">
                <div class="w-auto">
                    <span class="font-sm">Membership Application Number</span>
                    <br />
                    <span class="magenta-clr font-bold">{{$rec->app_no}}</span>


                </div>
                <div class="w-auto">
                    <span class="font-sm">Application Date and Time</span>
                    <br />
                    <span class="magenta-clr font-bold">{{ date('F d, Y h:i a', strtotime($rec->app_date)) }}</span>
                </div>
                <div class="w-auto">
                    <span class="font-sm">Status</span>
                    <br />
                    @if ($status === 'APPROVED')
                    <span class="status-title green-bg">Approved Application</span> <span class="font-sm magenta-clr font-bold">{{ $status }}</span>
                    @else
                    <span class="status-title orage-bg">Processing</span> <span class="font-sm magenta-clr font-bold">{{ $status }}</span>
                    @endif

                </div>
                <div class="w-auto d-flex justify-content-end">
                    <span>
                        <a href="javascript:void(0)" onclick="window.open('{{ URL::to('/memberform/') }}/{{ $rec->employee_no }}', 'targetWindow', 'resizable=yes,width=1000,height=1000');" style='cursor: pointer; padding: 0'>
                            <button class="f-button up-button-green">
                                Print/Download
                            </button>
                        </a>
                        <button class="f-button up-button">
                            Download
                        </button>
                    </span>
                </div>
            </div>
            <div class="card-container card p-0 mp-mt3">
                <div class="card-header maroon-bg items-between d-flex">
                    <span>
                        Application Status Trail
                    </span>
                    <span>
                        <a class="cursor-pointer m-0 p-0 mp-mr2" id="trail-button">
                            <i class="fa fa-chevron-circle-up  trail-up" aria-hidden="true"></i>
                            <i class="fa fa-chevron-circle-down d-none trail-down" aria-hidden="true"></i>
                        </a>
                    </span>
                </div>
                <div class="card-body trail" id="trail-body">
                    <div class="table-form w-trail mp-pv2 mp-ph3">
                        @php
                        $counter = 0;
                        $total = count($trailing);
                        @endphp
                        @foreach ($trailing as $data)
                        @php
                        $counter++;
                        @endphp
                        <div class="span-2 d-flex flex-column relative">
                            <div class="d-flex flex-column absolute top-circle w-full">
                                <span class="circle"></span>
                            </div>
                            <div class="line-trail table-form w-full">
                                <span class="line-child span-6 {{ $counter == 1 ? 'white' : '' }}"></span>
                                <span class="line-child span-6 {{ $counter == $total ? 'white' : '' }}"></span>
                            </div>
                            <div class="table-form">
                                <div class="trail-details d-flex flex-column w-full" style="grid-column-start: 4; grid-column-end: 13">
                                    <span class="font-sm">Status</span>
                                    <span class="mp-mh1">
                                        @if ($data->status_remarks === 'APPROVED')
                                        <span class="status-title green-bg">
                                            APPROVED
                                        </span>
                                        @elseif ($data->status_remarks !== 'APPROVED BY HRDO' && $data->status_remarks !== 'NEW APPLICATION')
                                        <span class="status-title orage-bg">
                                            PROCESSING
                                        </span>
                                        @else
                                        <span class="status-title maroon-bg">
                                            NEW APPLICATION
                                        </span>
                                        @endif
                                    </span>
                                    <span class="font-sm">Remarks</span>
                                    <span class="magenta-clr font-bold ">{{ $data->status_remarks }}</span>
                                    <span class="font-sm">Date: <span>{{ date('F d, Y', strtotime($data->time_stamp)) }}</span></span>
                                    <span class="font-sm">Time: <span>{{ date('h:i a', strtotime($data->time_stamp)) }}</span></span>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
            <div class="card-container card p-0 mp-mt3 ">
                <div class="card-header magenta-bg d-flex items-between">
                    <span>Validation Process</span><span><button class="f-button">Show Details</button></span>
                </div>
                <div class="mp-pv5 mp-mt3">

                    <div class="card-container card p-0 mp-mt3">
                        <div class="card-header d-flex items-between maroon-bg member-detail-title open-details">
                            <span>Personal Details</span><span>
                                <span>
                                    <a class="cursor-pointer m-0 p-0 mp-mr2" id="member-detail-toggle">
                                        <i class="fa fa-chevron-circle-up  member-up" aria-hidden="true"></i>
                                        <i class="fa fa-chevron-circle-down d-none member-down" aria-hidden="true"></i>
                                    </a>
                                </span>
                            </span>
                        </div>
                        <div class="card-body mp-pv4 mp-ph3 d-flex flex-column member-detail-body open-details">
                            <div class="table-form">
                                <div class="span-8 font-sm">
                                    <div class="table-form" style="gap: 5px">
                                        <div class="span-4 d-flex flex-column">
                                            <span>
                                                Name
                                            </span>
                                            <span class="font-md color-black mp-pl2">
                                                {{$rec->lastname}}, {{$rec->firstname}} {{$rec->middlename}}
                                            </span>
                                        </div>
                                        <div class="span-4 d-flex flex-column">
                                            <span>
                                                Birthday
                                            </span>
                                            <span class="font-md color-black mp-pl2">
                                                {{ date('F d, Y', strtotime($rec->date_birth)) }}
                                            </span>
                                        </div>
                                        <div class="span-4 d-flex flex-column">
                                            <span>
                                                Gender
                                            </span>
                                            <span class="font-md color-black mp-pl2">
                                                {{$rec->gender}}
                                            </span>
                                        </div>
                                        <div class="span-4 d-flex flex-column">
                                            <span>
                                                Marital Status
                                            </span>
                                            <span class="font-md color-black mp-pl2">
                                                {{$rec->civilstatus}}
                                            </span>
                                        </div>
                                        <div class="span-4 d-flex flex-column">
                                            <span>
                                                Nationality
                                            </span>
                                            <span class="font-md color-black mp-pl2">
                                                {{$rec->citizenship}}
                                            </span>
                                        </div>
                                        <div class="span-4 d-flex flex-column">
                                            <span>
                                                Address
                                            </span>
                                            <span class="font-md color-black mp-pl2">
                                                {{$rec->bldg_street}}, {{$rec->barangay}}, {{$rec->municipality}}, {{$rec->province}}, {{$rec->zipcode}}
                                            </span>
                                        </div>
                                        <div class="span-4 d-flex flex-column">
                                            <span>
                                                Contact No.
                                            </span>
                                            <span class="font-md color-black mp-pl2">
                                                {{$rec->contact_no}}
                                            </span>
                                        </div>
                                        <div class="span-4 d-flex flex-column">
                                            <span>
                                                Email
                                            </span>
                                            <span class="font-md color-black mp-pl2">
                                                {{$rec->email}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="span-4 font-sm d-flex flex-column justify-content-around magenta-clr">
                                    <p class="mp-text-right">
                                        Endorsement Date
                                        <br>
                                        <span class="font-md font-bold">
                                            <span class="font-sm"> <span>{{ date('F d, Y', strtotime($data->time_stamp)) }}</span></span>
                                        </span>
                                    </p>
                                    <p class="mp-text-right">
                                        Evaluated by
                                        <br>
                                        <span class="font-md font-bold">
                                            <span class="magenta-clr font-bold ">{{ $data->status_remarks }}</span>

                                        </span>
                                    </p>
                                    <p class="mp-text-right">
                                        Result
                                        <br>
                                        <span class="font-md font-bold">
                                            @if ($data->status_remarks === 'APPROVED')
                                            <span class="status-title green-bg">
                                                APPROVED
                                            </span>
                                            @elseif ($data->status_remarks !== 'APPROVED BY HRDO' && $data->status_remarks !== 'NEW APPLICATION')
                                            <span class="status-title orage-bg">
                                                PROCESSING
                                            </span>
                                            @else
                                            <span class="status-title maroon-bg">
                                                NEW APPLICATION
                                            </span>
                                            @endif
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mp-pv5 mp-mb3">
                    <div class="card-container card p-0 mp-mt3">
                        <div class="card-header d-flex items-between maroon-bg membership-title open-details">

                            <span>Membership Details</span><span>
                                <span>
                                    <a class="cursor-pointer m-0 p-0 mp-mr2" id="membership-toggle">
                                        <i class="fa fa-chevron-circle-up membership-up" aria-hidden="true"></i>
                                        <i class="fa fa-chevron-circle-down d-none membership-down" aria-hidden="true"></i>
                                    </a>
                                </span>
                            </span>
                        </div>
                        <div class="card-body mp-pv4 mp-ph3 d-flex flex-column membership-body open-details">
                            <div class="d-flex flex-row items-between font-sm" style="gap: 5px">
                                <div class="d-flex flex-column items-center mp-text-center">
                                    <span>
                                        Monthly salary
                                    </span>
                                    <span class="font-md color-black">
                                        ₱{{ number_format($rec->monthly_salary, 2, '.', ',') }}
                                    </span>
                                </div>
                                <div class="d-flex flex-column items-center mp-text-center">
                                    <span>
                                        Salary Grade
                                    </span>
                                    <span class="font-md color-black">
                                        {{ $rec->salary_grade }}
                                    </span>
                                </div>
                                <div class="d-flex flex-column items-center mp-text-center">
                                    <span>
                                        Monthly Contributions
                                    </span>
                                    <span class="font-md color-black">
                                        {{ $rec->contribution_set }}
                                    </span>
                                </div>
                                <div class="d-flex flex-column items-center mp-text-center">
                                    <span>
                                        Equivalent Value
                                    </span>
                                    <span class="font-md color-black">
                                        {{ $rec->amount }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mp-pv5 mp-mb3">
                    <div class="card-container card p-0 mp-mt3">
                        <div class="card-header d-flex items-between maroon-bg forms_attachment-title open-details">
                            <span>Forms and Attachment</span><span>
                                <span>
                                    <a class="cursor-pointer m-0 p-0 mp-mr2" id="forms_attachment-toggle">
                                        <i class="fa fa-chevron-circle-up forms_attachment-up" aria-hidden="true"></i>
                                        <i class="fa fa-chevron-circle-down d-none forms_attachment-down" aria-hidden="true"></i>
                                    </a>
                                </span>
                            </span>
                        </div>
                        <div class="card-body mp-pv4 mp-ph3 d-flex flex-column forms_attachment-body open-details">
                            <div class="d-flex flex-row items-between font-sm" style="gap: 5px">
                                <div class="d-flex flex-column items-center mp-text-center">
                                    <span>
                                        Membership Form
                                    </span>
                                    <a class='view_member view-member' href="javascript:void(0)" onclick="window.open('{{ URL::to('/memberform/') }}/{{ $rec->employee_no }}', 'targetWindow', 'resizable=yes,width=1000,height=1000');" style='cursor: pointer; padding: 0'>
                                        <span class="mp-link link_style">View Membership form</span>
                                    </a>
                                </div>
                                <div class="d-flex flex-column items-center mp-text-center">
                                    <span>
                                        Proxy Form
                                    </span>
                                    <a class='view_member view-member' href="javascript:void(0)" onclick="window.open('{{ URL::to('/generateProxyForm/') }}/{{ $rec->app_no }}', 'targetWindow', 'resizable=yes,width=1000,height=1000');" style='cursor: pointer; padding: 0'>

                                        <span class="mp-link link_style">View Proxy form</span>
                                    </a>
                                </div>
                                <div class="d-flex flex-column items-center mp-text-center">
                                    <span>
                                        AXA Form
                                    </span>
                                    <a class='view_member view-member' href="javascript:void(0)" onclick="window.open('{{ URL::to('/axaform/') }}/{{ $rec->app_no }}', 'targetWindow', 'resizable=yes,width=1000,height=1000');" style='cursor: pointer; padding: 0'>
                                        <span class="mp-link link_style">View AXA form</span>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="mp-pv5 mp-mb3">
                    <div class="card-container card p-0 mp-mt3">
                        <div class="card-header d-flex items-between maroon-bg employee-title open-details">
                            <span>Employee Details</span><span>
                                <span>
                                    <a class="cursor-pointer m-0 p-0 mp-mr2" id="employee-toggle">
                                        <i class="fa fa-chevron-circle-up employee-up" aria-hidden="true"></i>
                                        <i class="fa fa-chevron-circle-down d-none employee-down" aria-hidden="true"></i>
                                    </a>
                                </span>
                            </span>
                        </div>
                        <div class="card-body mp-pv4 mp-ph3 d-flex flex-column employee-body open-details">
                            <div class="tab-body border-0">
                                <div class="tab-item">
                                    <div class="d-flex flex-column">
                                        <span class="mp-text-fs-small">
                                            Employee Number
                                        </span>
                                        <span class="mp-text-fw-medium">
                                            {{$rec->employee_no}}
                                        </span>
                                    </div>
                                </div>
                                <div class="tab-item">
                                    <div class="d-flex flex-column">
                                        <span class="mp-text-fs-small">
                                            Campus
                                        </span>
                                        <span class="mp-text-fw-medium">
                                            {{$rec->name}}
                                        </span>
                                    </div>
                                </div>
                                <div class="tab-item">
                                    <div class="d-flex flex-column">
                                        <span class="mp-text-fs-small">
                                            Classification
                                        </span>
                                        <span class="mp-text-fw-medium">
                                            {{$rec->classification}}
                                        </span>
                                    </div>
                                </div>
                                <div class="tab-item">
                                    <div class="d-flex flex-column">
                                        <span class="mp-text-fs-small">
                                            College/Unit
                                        </span>
                                        <span class="mp-text-fw-medium">
                                            {{$rec->college_unit_name}}
                                        </span>
                                    </div>
                                </div>
                                <div class="tab-item">
                                    <div class="d-flex flex-column">
                                        <span class="mp-text-fs-small">
                                            Department
                                        </span>
                                        <span class="mp-text-fw-medium">
                                            {{$rec->department_name}}
                                        </span>
                                    </div>
                                </div>
                                <div class="tab-item">
                                    <div class="d-flex flex-column">
                                        <span class="mp-text-fs-small">
                                            Rank/Position
                                        </span>
                                        <span class="mp-text-fw-medium">
                                            {{$rec->rank_position}}
                                        </span>
                                    </div>
                                </div>
                                <!-- <div class="tab-item">
                                    <input type="checkbox">
                                    <div class="d-flex flex-row flex-wrap gap-10">
                                        <div class="d-flex flex-column" style="min-width: 200px">
                                            <span class="mp-text-fs-small">
                                                Contact Number
                                            </span>
                                            <span class="mp-text-fw-medium">
                                                092323232323232
                                            </span>
                                        </div>
                                        <div class="d-flex flex-column" style="min-width: 200px">
                                            <span class="mp-text-fs-small">
                                                Landline Number
                                            </span>
                                            <span class="mp-text-fw-medium">
                                                1267835123675
                                            </span>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="tab-item">
                                    <div class="d-flex flex-column">
                                        <span class="mp-text-fs-small">
                                            Appointment Date
                                        </span>
                                        <span class="mp-text-fw-medium">
                                            {{ date('F d, Y', strtotime($rec->date_appointment)) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="tab-item">
                                    <div class="d-flex flex-column">
                                        <span class="mp-text-fs-small">
                                            Monthly Salary
                                        </span>
                                        <span class="mp-text-fw-medium">
                                            ₱{{ number_format($rec->monthly_salary, 2, '.', ',') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="tab-item">
                                    <div class="d-flex flex-column">
                                        <span class="mp-text-fs-small">
                                            Salary Grade
                                        </span>
                                        <span class="mp-text-fw-medium">
                                            {{$rec->salary_grade}}
                                        </span>
                                    </div>
                                </div>
                                <div class="tab-item">
                                    <div class="d-flex flex-column">
                                        <span class="mp-text-fs-small">
                                            Salary Grade Category
                                        </span>
                                        <span class="mp-text-fw-medium">
                                            {{$rec->sg_category}}
                                        </span>
                                    </div>
                                </div>
                                <div class="tab-item">
                                    <div class="d-flex flex-column">
                                        <span class="mp-text-fs-small">
                                            Tin Number
                                        </span>
                                        <span class="mp-text-fw-medium">
                                            {{$rec->tin_no}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form id="fm_validation">
                    {{ csrf_field() }}
                    <input type="hidden" name="app_no" id="app_no" value="{{$rec->app_no}}">
                    <input type="hidden" name="emp_no" id="emp_no" value="{{$rec->employee_no}}">
                    <div class="table-form form-header w-full remarks-gray-bg">
                        <div class="span-12 d-flex flex-column mp-pv3 mp-ph3 gap-10">
                            <span>General Remarks</span>
                            <textarea name="general_remarks" id="general_remarks" rows="3" readonly style="resize: none;">{{ (isset($rec->general_remarks)) ? $rec->general_remarks : '' }}</textarea>
                            <div class="d-flex flex-row items-between mp-pv1">
                                <div class="d-flex flex-column" style="gap: 5px;"></div>
                                @if ($rec->validator_remarks == 'FORWARDED TO FM')
                                <span class="d-flex" style="gap: 10px">
                                    <button class="f-button align-self-end" id="save_record">
                                        <span id="save_text">Verified / Saved to Payroll Advise</span>
                                    </button>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).on('click', '#employee-toggle', function(e) {
        if ($(".employee-detail").hasClass("open-detail")) {
            $(".employee-detail").removeClass("open-detail")
            $(".employee-toggle-plus").removeClass("d-none")
            $(".employee-toggle-minus").addClass("d-none")
        } else {
            $(".employee-detail").addClass("open-detail")
            $(".employee-toggle-plus").addClass("d-none")
            $(".employee-toggle-minus").removeClass("d-none")
        }
    })
    $(document).ready(function() {
        var tableMemberApp = $('.members-table').DataTable({
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
                }
            },
        });
        $('#campuses_select').on('change', function() {
            tableMemberApp.draw();
        });
        $('#search_value').on('change', function() {
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
    $('#save_record').click(function(event) {
        event.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formDatas = $("#fm_validation").serialize();

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to continue this transaction.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, continue'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('validate_step_reject') }}",
                    data: formDatas,
                    success: function(data) {
                        if (data.success == 1) {
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('save_fm_validation') }}",
                                data: formDatas,
                                beforeSend: function() {
                                    $('#loading').show();
                                },
                                success: function(data) {
                                    if (data.success != '') {
                                        Swal.fire({
                                            text: 'Application has been save successfully validated and ready to forward.',
                                            icon: 'success',
                                            confirmButtonColor: '#3085d6',
                                            confirmButtonText: 'Proceed',
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = "{{ route('admin.members_records') }}";
                                            }
                                        });
                                    } else {
                                        alert('Failed');
                                    }
                                }
                            });
                        } else {
                            Swal.fire("Error!", "You already forwarded this application to FM and cannot be changes.", "error");
                        }
                    }
                });
            }
        })

    });
</script>
@endsection