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

    .color-black {
        color: black;
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
                    <span class="magenta-clr font-bold">{{ date('F d, Y', strtotime($rec->app_date)) }}</span>
                </div>
                <div class="w-auto">
                    <span class="font-sm">Status</span>
                    <br />
                    <span class="status-title orage-bg">Processing</span> <span class="font-sm magenta-clr font-bold">AA - Review Validation</span>
                </div>
                <div class="w-auto d-flex justify-content-end">
                    <span>
                        <button class="f-button">
                            Print
                        </button>
                        <button class="f-button green-bg">
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
                            <i class="fa fa-chevron-circle-up " aria-hidden="true"></i>
                            <i class="fa fa-chevron-circle-down d-none" aria-hidden="true"></i>
                        </a>
                    </span>
                </div>
                <div class="card-body trail" -trail id="trail-body">
                    <div class="table-form w-trail mp-pv2 mp-ph3">
                        <div class="span-2 d-flex flex-column relative">
                            <div class="d-flex flex-column absolute top-circle w-full">
                                <span class="circle"></span>
                            </div>
                            <div class="line-trail table-form w-full">
                                <span class="line-child span-6 white"></span>
                                <span class="line-child span-6"></span>
                            </div>
                            <div class="table-form">
                                <div class="trail-details d-flex flex-column w-full" style="grid-column-start: 4; grid-column-end: 13">
                                    <span class="font-sm">Status</span>
                                    <span class="mp-mh1">
                                        <span class="status-title maroon-bg">
                                            Pending
                                        </span>
                                    </span>
                                    <span class="font-sm">Remarks</span>
                                    <span class="magenta-clr font-bold ">New Application</span>
                                    <span class="font-sm">Date: <span>January 23, 2023</span></span>

                                </div>
                            </div>
                        </div>
                        <div class="span-2 d-flex flex-column relative">
                            <div class="d-flex flex-column absolute top-circle w-full">
                                <span class="circle"></span>
                            </div>
                            <div class="line-trail table-form w-full">
                                <span class="line-child span-6"></span>
                                <span class="line-child span-6"></span>
                            </div>
                            <div class="table-form">
                                <div class="trail-details d-flex flex-column w-full" style="grid-column-start: 4; grid-column-end: 13">
                                    <span class="font-sm">Status</span>
                                    <span class="mp-mh1">
                                        <span class="status-title orage-bg">
                                            Processing
                                        </span>
                                    </span>
                                    <span class="font-sm">Remarks</span>
                                    <span class="magenta-clr font-bold ">AA - Review Validation</span>
                                    <span class="font-sm">Date: <span>January 23, 2023</span></span>
                                </div>
                            </div>
                        </div>
                        <div class="span-2 d-flex flex-column relative">
                            <div class="d-flex flex-column absolute top-circle w-full">
                                <span class="circle"></span>
                            </div>
                            <div class="line-trail table-form w-full">
                                <span class="line-child span-6"></span>
                                <span class="line-child span-6"></span>
                            </div>
                            <div class="table-form">
                                <div class="trail-details d-flex flex-column w-full" style="grid-column-start: 4; grid-column-end: 13">
                                    <span class="font-sm">Status</span>
                                    <span class="mp-mh1">
                                        <span class="status-title orage-bg">
                                            Processing
                                        </span>
                                    </span>
                                    <span class="font-sm">Remarks</span>
                                    <span class="magenta-clr font-bold ">AA - Verified</span>
                                    <span class="font-sm">Date: <span>January 23, 2023</span></span>

                                </div>
                            </div>

                        </div>
                        <div class="span-2 d-flex flex-column relative">
                            <div class="d-flex flex-column absolute top-circle w-full">
                                <span class="circle"></span>
                            </div>
                            <div class="line-trail table-form w-full">
                                <span class="line-child span-6"></span>
                                <span class="line-child span-6"></span>
                            </div>
                            <div class="table-form">
                                <div class="trail-details d-flex flex-column w-full" style="grid-column-start: 4; grid-column-end: 13">
                                    <span class="font-sm">Status</span>
                                    <span class="mp-mh1">
                                        <span class="status-title orage-bg">
                                            Processing
                                        </span>
                                    </span>
                                    <span class="font-sm">Remarks</span>
                                    <span class="magenta-clr font-bold ">CFM - Review Validation</span>
                                    <span class="font-sm">Date: <span>January 23, 2023</span></span>

                                </div>
                            </div>
                        </div>
                        <div class="span-2 d-flex flex-column relative">
                            <div class="d-flex flex-column absolute top-circle w-full">
                                <span class="circle"></span>
                            </div>
                            <div class="line-trail table-form w-full">
                                <span class="line-child span-6"></span>
                                <span class="line-child span-6"></span>
                            </div>
                            <div class="table-form">
                                <div class="trail-details d-flex flex-column w-full" style="grid-column-start: 4; grid-column-end: 13">
                                    <span class="font-sm">Status</span>
                                    <span class="mp-mh1">
                                        <span class="status-title red-bg">
                                            Rejected
                                        </span>
                                    </span>
                                    <span class="font-sm">Remarks</span>
                                    <span class="magenta-clr font-bold ">Rejected by CFM</span>
                                    <span class="font-sm">Date: <span>January 23, 2023</span></span>

                                </div>
                            </div>
                        </div>
                        <div class="span-2 d-flex flex-column relative">
                            <div class="d-flex flex-column absolute top-circle w-full">
                                <span class="circle"></span>
                            </div>
                            <div class="line-trail table-form w-full">
                                <span class="line-child span-6"></span>
                                <span class="line-child span-6 white"></span>
                            </div>
                            <div class="table-form">
                                <div class="trail-details d-flex flex-column w-full" style="grid-column-start: 4; grid-column-end: 13">
                                    <span class="font-sm">Status</span>
                                    <span class="mp-mh1">
                                        <span class="status-title blue-bg">
                                            Approved
                                        </span>
                                    </span>
                                    <span class="font-sm">Remarks</span>
                                    <span class="magenta-clr font-bold ">Approved Application</span>
                                    <span class="font-sm">Date: <span>January 23, 2023</span></span>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-container card p-0 mp-mt3 ">
                <div class="card-header magenta-bg d-flex items-between">
                    <span>Validation Process</span>
                </div>
                <!-- <div class="mp-pv5 mp-mt3">
                    <div class="card-container card p-0 mp-mt3">
                        <div class="card-header d-flex items-between maroon-bg">
                            <span>Member Details</span><span>
                                <span>
                                    <a class="cursor-pointer m-0 p-0 mp-mr2" id="trail-button">
                                        <i class="fa fa-chevron-circle-up " aria-hidden="true"></i>
                                        <i class="fa fa-chevron-circle-down d-none" aria-hidden="true"></i>
                                    </a>
                                </span>
                            </span>
                        </div>
                        <div class="card-body mp-pv4 mp-ph3 d-flex flex-column ">
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
                                            February 14, 2023 10:11 AM
                                        </span>
                                    </p>
                                    <p class="mp-text-right">
                                        Evaluated by
                                        <br>
                                        <span class="font-md font-bold">
                                            AA/FCM Account
                                        </span>
                                    </p>
                                    <p class="mp-text-right">
                                        Result
                                        <br>
                                        <span class="font-md font-bold">
                                            Passed
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mp-pv5 mp-mb3">
                    <div class="card-container card p-0 mp-mt3">
                        <div class="card-header d-flex items-between maroon-bg">
                            <span>Membership Details</span><span>
                                <span>
                                    <a class="cursor-pointer m-0 p-0 mp-mr2" id="trail-button">
                                        <i class="fa fa-chevron-circle-up " aria-hidden="true"></i>
                                        <i class="fa fa-chevron-circle-down d-none" aria-hidden="true"></i>
                                    </a>
                                </span>
                            </span>
                        </div>
                        <div class="card-body mp-pv4 mp-ph3 d-flex flex-column">
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
                </div> -->
                <div class="card-body mp-pv4 mp-ph3 d-flex flex-column min-h-50vh border-content">
                    <div class="table-form form-header w-full">
                        <div class="span-12 color-white text-center orage-bg mp-ph1" style="border-left: 1px solid gray;">
                            <span>
                                AA Validation
                            </span>
                        </div>
                    </div>
                    <form id="aa_validation" >
                    {{ csrf_field() }}
                    <div class="table-form form-header w-full">
                        <input type="hidden" name="app_no" id="app_no" value="{{$rec->app_no}}" >
                        <div class="span-3 magenta-bg color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <span>
                                I. Personal Details
                            </span>
                        </div>
                        <div class="span-1 text-center mp-ph1 d-flex align-items-center justify-content-center" style="gap: 5px">
                            <span>
                                Passed 
                            </span>
                            <input type="radio" id="check_allppd" name="check_allpd">
                        </div>
                        <div class="span-1 text-center mp-ph1 d-flex align-items-center justify-content-center" style="gap: 5px">
                            <span>
                                Failed
                            </span>
                            <input type="radio" id="check_allfpd" name="check_allpd">
                        </div>
                        <div class="span-7 text-center mp-ph1">
                            <span>
                                Remarks
                            </span>
                        </div>
                    </div>
                    <div class="table-form form-header w-full">
                        <div class="span-3 maroon-bg color-white text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                                Name (Last, First, Middle Suffix)
                            </span>
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="pass_name" value= "1" name="pass_name">
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="fail_name" value= "2" name="pass_name">
                        </div>
                        <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="text" class="w-input mp-pv2" name="remarks_name">
                        </div>
                        <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                            {{$rec->lastname}}, {{$rec->firstname}} {{$rec->middlename}}
                            </span>
                        </div>
                    </div>
                    <div class="table-form form-header w-full">
                        <div class="span-3 maroon-bg color-white text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                                Date of Birth
                            </span>
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                        <input type="radio" id="pass_dob" value= "1" name="pass_dob">
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                        <input type="radio" id="fail_dob" value= "2" name="pass_dob">
                        </div>
                        <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                        <input type="text" class="w-input mp-pv2" name="remarks_dob">
                        </div>
                        <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                            {{ date('F d, Y', strtotime($rec->date_birth)) }}
                            </span>
                        </div>
                    </div>
                    <div class="table-form form-header w-full">
                        <div class="span-3 maroon-bg color-white text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                               Gender
                            </span>
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="pass_gender" value= "1" name="pass_gender">
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="fail_gender" value= "2" name="pass_gender">
                        </div>
                        <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                        <input type="text" class="w-input mp-pv2" name="remarks_gender">
                        </div>
                        <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                            {{$rec->gender}}
                            </span>
                        </div>
                    </div>
                    <div class="table-form form-header w-full">
                        <div class="span-3 maroon-bg color-white text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                                Civil Status
                            </span>
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="pass_civilstatus" value= "1" name="pass_civilstatus">
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="fail_civilstatus" value= "2" name="pass_civilstatus">
                        </div>
                        <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="text" class="w-input mp-pv2" name="remarks_civilstatus">
                        </div>
                        <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                            {{ $rec->civilstatus }}
                            </span>
                        </div>
                    </div>
                    <div class="table-form form-header w-full">
                        <div class="span-3 maroon-bg color-white text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                            Citizenship
                            </span>
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="pass_citizenship" value= "1" name="pass_citizenship">
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="fail_citizenship" value= "2" name="pass_citizenship">
                        </div>
                        <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="text" class="w-input mp-pv2" name="remarks_citizenship">
                        </div>
                        <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                            {{ $rec->citizenship }}
                            </span>
                        </div>
                    </div>
                    <div class="table-form form-header w-full">
                        <div class="span-3 maroon-bg color-white text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                                Current Address
                            </span>
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="pass_currentadd" value= "1" name="pass_currentadd">
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="fail_currentadd" value= "2" name="pass_currentadd">
                        </div>
                        <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="text" class="w-input mp-pv2" name="remarks_currentadd">
                        </div>
                        <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                            {{$rec->present_bldg_street}}, {{$rec->present_barangay}}, {{$rec->present_municipality}}, {{$rec->present_province}}, {{$rec->present_zipcode}}
                            </span>
                        </div>
                    </div>
                    <div class="table-form form-header w-full">
                        <div class="span-3 maroon-bg color-white text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                                Permanent Address
                            </span>
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="pass_permaadd" value= "1" name="pass_permaadd">
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="fail_permaadd" value= "2" name="pass_permaadd">
                        </div>
                        <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="text" class="w-input mp-pv2" name="remarks_permaadd">
                        </div>
                        <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                            {{$rec->bldg_street}}, {{$rec->barangay}}, {{$rec->municipality}}, {{$rec->province}}, {{$rec->zipcode}}
                            </span>
                        </div>
                    </div>
                    <div class="table-form form-header w-full">
                        <div class="span-3 maroon-bg color-white text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                                Contact Number
                            </span>
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="pass_contactnum" value= "1" name="pass_contactnum">
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="fail_contactnum" value= "2" name="pass_contactnum">
                        </div>
                        <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="text" class="w-input mp-pv2" name="review_contactnum">
                        </div>
                        <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                            {{$rec->contact_no}}
                            </span>
                        </div>
                    </div>
                    <div class="table-form form-header w-full">
                        <div class="span-3 maroon-bg color-white text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                                Landline Number
                            </span>
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="pass_landline" value= "1" name="pass_landline">
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="pass_landline" value= "2" name="pass_landline">
                        </div>
                        <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="text" class="w-input mp-pv2" name="review_landline">
                        </div>
                        <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                            {{ $rec->landline_no ? $rec->landline_no : 'N/A' }}
                            </span>
                        </div>
                    </div>
                    <div class="table-form form-header w-full">
                        <div class="span-3 maroon-bg color-white text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                                Email Address
                            </span>
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="pass_email" value= "1" name="pass_email">
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="fail_email" value= "2" name="pass_email">
                        </div>
                        <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="text" class="w-input mp-pv2" name="remarks_email">
                        </div>
                        <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                            {{$rec->email}}
                            </span>
                        </div>
                    </div>
                    <div class="table-form form-header w-full">
                        <div class="span-3 magenta-bg color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <span>
                                II. Employee Details
                            </span>
                        </div>
                        <div class="span-1 text-center mp-ph1 d-flex align-items-center justify-content-center" style="gap: 5px">
                            <span>
                                Passed 
                            </span>
                            <input type="radio" id="check_allped" name="check_all_ped">
                        </div>
                        <div class="span-1 text-center mp-ph1 d-flex align-items-center justify-content-center" style="gap: 5px">
                            <span>
                                Failed
                            </span>
                            <input type="radio" id="check_allfed" name="check_all_ped">
                        </div>
                        <div class="span-7 text-center mp-ph1">
                            <span>
                                Remarks
                            </span>
                        </div>
                    </div>
                    <div class="table-form form-header w-full">
                        <div class="span-3 maroon-bg color-white text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                                Employee Number
                            </span>
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="pass_emp_no" value= "1" name="pass_emp_no">
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="fail_emp_no" value= "2" name="pass_emp_no">
                        </div>
                        <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="text" class="w-input mp-pv2" name="remarks_emp_no">
                        </div>
                        <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                            {{$rec->employee_no}}
                            </span>
                        </div>
                    </div>
                    <div class="table-form form-header w-full">
                        <div class="span-3 maroon-bg color-white text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                                Campus
                            </span>
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="pass_campus" value= "1" name="pass_campus">
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="fail_campus" value= "2" name="pass_campus">
                        </div>
                        <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="text" class="w-input mp-pv2" name="remarks_campus">
                        </div>
                        <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                            {{$rec->name}}
                            </span>
                        </div>
                    </div>
                    <div class="table-form form-header w-full">
                        <div class="span-3 maroon-bg color-white text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                            Classification
                            </span>
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="pass_classification" value= "1" name="pass_classification">
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="fail_classification" value= "2" name="pass_classification">
                        </div>
                        <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="text" class="w-input mp-pv2" name="remarks_classification">
                        </div>
                        <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                            {{$rec->classification}}
                            </span>
                        </div>
                    </div>
                    <div class="table-form form-header w-full">
                        <div class="span-3 maroon-bg color-white text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                            College/Unit
                            </span>
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="pass_college_unit" value= "1" name="pass_college_unit">
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="fail_college_unit" value= "2" name="pass_college_unit">
                        </div>
                        <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="text" class="w-input mp-pv2" name="remarks_college_unit">
                        </div>
                        <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                            {{$rec->college_unit_name}}
                            </span>
                        </div>
                    </div>
                    <div class="table-form form-header w-full">
                        <div class="span-3 maroon-bg color-white text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                            Department
                            </span>
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="pass_department" value= "1" name="pass_department">
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="pass_department" value= "2" name="pass_department">
                        </div>
                        <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="text" class="w-input mp-pv2" name="remarks_department">
                        </div>
                        <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                            {{$rec->department_name}}
                            </span>
                        </div>
                    </div>
                    <div class="table-form form-header w-full">
                        <div class="span-3 maroon-bg color-white text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                            Rank/Position
                            </span>
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="pass_rankpos" value= "1" name="pass_rankpos">
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="fail_rankpos" value= "2" name="pass_rankpos">
                        </div>
                        <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="text" class="w-input mp-pv2" name="remarks_rankpos">
                        </div>
                        <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                            {{$rec->rank_position}}
                            </span>
                        </div>
                    </div>
                    <div class="table-form form-header w-full">
                        <div class="span-3 maroon-bg color-white text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                            Appointment
                            </span>
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="pass_appointment" value= "1" name="pass_appointment">
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="fail_appointment" value= "2" name="pass_appointment">
                        </div>
                        <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="text" class="w-input mp-pv2" name="remarks_appointment">
                        </div>
                        <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                            {{$rec->appointment}}
                            </span>
                        </div>
                    </div>
                    <div class="table-form form-header w-full">
                        <div class="span-3 maroon-bg color-white text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                            Appointment Date
                            </span>
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="pass_appointdate" value= "1" name="pass_appointdate">
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="fail_appointdate" value= "2" name="pass_appointdate">
                        </div>
                        <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="text" class="w-input mp-pv2" name="remarks_appointdate">
                        </div>
                        <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                            {{ date('F d, Y', strtotime($rec->date_appointment)) }}
                            </span>
                        </div>
                    </div>
                    <div class="table-form form-header w-full">
                        <div class="span-3 maroon-bg color-white text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                            Monthly Salary
                            </span>
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="pass_monthlysalary" value= "1" name="pass_monthlysalary">
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="fail_monthlysalary" value= "2" name="pass_monthlysalary">
                        </div>
                        <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="text" class="w-input mp-pv2" name="remarks_monthlysalary">
                        </div>
                        <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                            ₱{{ number_format($rec->monthly_salary, 2, '.', ',') }}
                            </span>
                        </div>
                    </div>
                    <div class="table-form form-header w-full">
                        <div class="span-3 maroon-bg color-white text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                             Salary Grade
                            </span>
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="pass_sg" value= "1" name="pass_sg">
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="fail_sg" value= "2" name="pass_sg">
                        </div>
                        <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="text" class="w-input mp-pv2" name="remarks_sg">
                        </div>
                        <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                            {{$rec->salary_grade}}
                            </span>
                        </div>
                    </div>
                    <div class="table-form form-header w-full">
                        <div class="span-3 maroon-bg color-white text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                             Salary Grade Category
                            </span>
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="pass_sgcat" value= "1" name="pass_sgcat">
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="fail_sgcat" value= "2" name="pass_sgcat">
                        </div>
                        <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="text" class="w-input mp-pv2" name="remarks_sgcat">
                        </div>
                        <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                            {{$rec->sg_category}}
                            </span>
                        </div>
                    </div>
                    <div class="table-form form-header w-full">
                        <div class="span-3 maroon-bg color-white text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                             Tin Number
                            </span>
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="pass_tin_no" value= "1" name="pass_tin_no">
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="fail_tin_no" value= "2" name="pass_tin_no">
                        </div>
                        <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="text" class="w-input mp-pv2" name="remarks_tin_no">
                        </div>
                        <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                            {{$rec->tin_no}}
                            </span>
                        </div>
                    </div>
                    <div class="table-form form-header w-full">
                        <div class="span-3 magenta-bg color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <span>
                                III. Members Details
                            </span>
                        </div>
                        <div class="span-1 text-center mp-ph1 d-flex align-items-center justify-content-center" style="gap: 5px">
                            <span>
                                Passed 
                            </span>
                            <input type="radio" id="check_allpmd" name="check_all_pmd">
                        </div>
                        <div class="span-1 text-center mp-ph1 d-flex align-items-center justify-content-center" style="gap: 5px">
                            <span>
                                Failed
                            </span>
                            <input type="radio" id="check_allfmd" name="check_all_pmd">
                        </div>
                        <div class="span-7 text-center mp-ph1">
                            <span>
                                Remarks
                            </span>
                        </div>
                    </div>
                    <div class="table-form form-header w-full">
                        <div class="span-3 maroon-bg color-white text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                             Monthly Contribution
                            </span>
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="pass_monthlycontri" value= "1" name="pass_monthlycontri">
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="fail_monthlycontri" value= "2" name="pass_monthlycontri">
                        </div>
                        <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="text" class="w-input mp-pv2" name="remarks_monthlycontri">
                        </div>
                        <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                            {{$rec->contribution_set}}
                            </span>
                        </div>
                    </div>
                    <div class="table-form form-header w-full">
                        <div class="span-3 maroon-bg color-white text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                             Equivalent Value
                            </span>
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="pass_equivalent" value= "1" name="pass_equivalent">
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="fail_equivalent" value= "2" name="pass_equivalent">
                        </div>
                        <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="text" class="w-input mp-pv2" name="remarks_equivalent">
                        </div>
                        <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                            {{$rec->amount}}
                            </span>
                        </div>
                    </div>
                    <div class="table-form form-header w-full">
                        <div class="span-3 magenta-bg color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <span>
                                IV. Supporting Document
                            </span>
                        </div>
                        <div class="span-1 text-center mp-ph1 d-flex align-items-center justify-content-center" style="gap: 5px">
                            <span>
                                Passed 
                            </span>
                            <input type="radio" id="check_allpsd" name="check_all_psd">
                        </div>
                        <div class="span-1 text-center mp-ph1 d-flex align-items-center justify-content-center" style="gap: 5px">
                            <span>
                                Failed
                            </span>
                            <input type="radio" id="check_allfsd" name="check_all_psd">
                        </div>
                        <div class="span-7 text-center mp-ph1">
                            <span>
                                Remarks
                            </span>
                        </div>
                    </div>
                    <div class="table-form form-header w-full">
                        <div class="span-3 maroon-bg color-white text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                             Membership Form
                            </span>
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="pass_membershipf" value= "1" name="pass_membershipf">
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="fail_membershipf" value= "2" name="pass_membershipf">
                        </div>
                        <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="text" class="w-input mp-pv2" name="remarks_membershipf">
                        </div>
                        <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                        <a data-md-tooltip='View Membership Form' class='view_member md-tooltip--right view-member' 
                            href="javascript:void(0)" onclick="window.open('{{ URL::to('/memberform/') }}/{{ $rec->employee_no }}', 'targetWindow', 'resizable=yes,width=1000,height=1000');"
                            style='cursor: pointer'>
                            <i class='mp-icon md-tooltip--right icon-book-open mp-text-c-primary mp-text-fs-large'></i>
                            <span>View Membership form</span>
                        </a>
                        
                        </div>
                    </div>
                    <div class="table-form form-header w-full">
                        <div class="span-3 maroon-bg color-white text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                            <span>
                             Proxy form
                            </span>
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="pass_proxyform" value= "1" name="pass_proxyform">
                        </div>
                        <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="radio" id="fail_proxyform" value= "2" name="pass_proxyform">
                        </div>
                        <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                            <input type="text" class="w-input mp-pv2" name="remarks_proxyform">
                        </div>
                        <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                        <a data-md-tooltip='View Proxy Form' class='view_member md-tooltip--right view-member' 
                            href="javascript:void(0)" onclick="window.open('{{ URL::to('/generateProxyForm/') }}/{{ $rec->app_no }}', 'targetWindow', 'resizable=yes,width=1000,height=1000');"
                            style='cursor: pointer'>
                            <i class='mp-icon md-tooltip--right icon-book-open mp-text-c-primary mp-text-fs-large'></i>
                            <span>View Proxy form</span>
                        </a>
                        </div>
                    </div>
                </div>
                <div class="table-form form-header w-full gray-bg">
                    <div class="span-12 d-flex flex-column mp-pv3 mp-ph3 gap-10">
                        <span>General Remarks</span>
                        <!-- <div class="table-form">
                            <span class="span-6"><input type="checkbox"> Forward to CFM</span>
                            <span class="span-6"><input type="checkbox"> Reject Application</span>
                        </div> -->
                        <textarea name="general_remarks" id="general_remarks" rows="3" style="resize: none;"></textarea>
                        <div class="d-flex flex-row items-between mp-pv1">
                            <div class="d-flex flex-column" style="gap: 5px;">
                                <div class="">
                                    Evaluation Summary
                                </div>
                                <div class="d-flex flex-column font-sm">
                                    <div class="d-flex flex-row mp-text-center" style="width: 100px">
                                            <span>Passed: <span class="font-md font-bold color-black" id="pass_count"></span></span>
                                           
                                        </div>
                                        <div class="d-flex flex-row mp-text-center" style="width: 100px">
                                            <span>Failed: <span class="font-md font-bold color-black" id="failed_count"></span></span>
                                        </div>
                                </div>
                            </div>
                            <span class="d-flex" style="gap: 10px">
                                <button class="f-button align-self-end magenta-bg" id="return_app">
                                    Return Application
                                </button>
                                <button class="f-button align-self-end" id="save_record">
                                    Save Record
                                </button>
                            </span>
                            
                        </div>
                        
                        </form>
                    </div>
                    <!-- <div class="span-6 d-flex flex-column mp-pv3 mp-ph3 gap-10">
                        <span>General Remarks</span>
                        <div class="table-form">
                            <span class="span-6"><input type="checkbox"> Forward to HRDO</span>
                            <span class="span-6"><input type="checkbox"> Return to AA</span>
                        </div>
                        <textarea name="" id="" rows="3" style="resize: none;"></textarea>
                        <div class="d-flex flex-row items-between mp-pv1">
                            <div class="d-flex flex-column">
                                <span class="font-sm ">Validated by: Mark Zuckingbird</span>
                                <span class="font-sm ">Validated Date: January, 23, 2023</span>
                            </div>
                            <span class="d-flex">
                                <button class="f-button align-self-end">
                                    Submit
                                </button>
                            </span>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>


<script>
     $(document).on('click', '#trail-button', function(e) {
        if ($("#trail-body").hasClass("close-trail")) {
            $("#trail-body").removeClass("close-trail")
            $(".trail-details").removeClass("hidden-details")
            $(".fa-chevron-circle-up").removeClass("d-none")
            $(".fa-chevron-circle-down").addClass("d-none")

        } else {
            $("#trail-body").addClass("close-trail")
            $(".trail-details").addClass("hidden-details")
            $(".fa-chevron-circle-down").removeClass("d-none")
            $(".fa-chevron-circle-up").addClass("d-none")
        }
    })
var passCount = 0;
var failCount = 0;
// $(document).ready(function() {
$('#aa_validation input[type="radio"]').click(function() {
    passCount = 0;
    failCount = 0;
    $('#aa_validation input[type="radio"]').each(function() {
        if ($(this).is(':checked')) {
        if ($(this).val() == 1) {
            passCount++;
        } else if ($(this).val() == 2) {
            failCount++;
        }
        }
    });
    $('#pass_count').text(passCount);
    $('#failed_count').text(failCount);
});
// });
$('#check_allppd').click(function() {
  if ($(this).is(':checked')) {
    $('input[name="pass_name"][value="1"]').prop('checked', true);
    $('input[name="pass_dob"][value="1"]').prop('checked', true);
    $('input[name="pass_gender"][value="1"]').prop('checked', true);
    $('input[name="pass_civilstatus"][value="1"]').prop('checked', true);
    $('input[name="pass_citizenship"][value="1"]').prop('checked', true);
    $('input[name="pass_currentadd"][value="1"]').prop('checked', true);
    $('input[name="pass_permaadd"][value="1"]').prop('checked', true);
    $('input[name="pass_contactnum"][value="1"]').prop('checked', true);
    $('input[name="pass_landline"][value="1"]').prop('checked', true);
    $('input[name="pass_email"][value="1"]').prop('checked', true);
  }
});
$('#check_allped').click(function() {
  if ($(this).is(':checked')) {
    $('input[name="pass_emp_no"][value="1"]').prop('checked', true);
    $('input[name="pass_campus"][value="1"]').prop('checked', true);
    $('input[name="pass_classification"][value="1"]').prop('checked', true);
    $('input[name="pass_college_unit"][value="1"]').prop('checked', true);
    $('input[name="pass_department"][value="1"]').prop('checked', true);
    $('input[name="pass_rankpos"][value="1"]').prop('checked', true);
    $('input[name="pass_appointment"][value="1"]').prop('checked', true);
    $('input[name="pass_appointdate"][value="1"]').prop('checked', true);
    $('input[name="pass_monthlysalary"][value="1"]').prop('checked', true);
    $('input[name="pass_sg"][value="1"]').prop('checked', true);
    $('input[name="pass_sgcat"][value="1"]').prop('checked', true);
    $('input[name="pass_tin_no"][value="1"]').prop('checked', true);
  }
});
$('#check_allpmd').click(function() {
  if ($(this).is(':checked')) {
    $('input[name="pass_monthlycontri"][value="1"]').prop('checked', true);
    $('input[name="pass_equivalent"][value="1"]').prop('checked', true);
  }
});
$('#check_allpsd').click(function() {
  if ($(this).is(':checked')) {
    $('input[name="pass_membershipf"][value="1"]').prop('checked', true);
    $('input[name="pass_proxyform"][value="1"]').prop('checked', true);
  }
});
$('#check_allfpd').click(function() {
  if ($(this).is(':checked')) {
    $('input[name="pass_name"][value="2"]').prop('checked', true);
    $('input[name="pass_dob"][value="2"]').prop('checked', true);
    $('input[name="pass_gender"][value="2"]').prop('checked', true);
    $('input[name="pass_civilstatus"][value="2"]').prop('checked', true);
    $('input[name="pass_citizenship"][value="2"]').prop('checked', true);
    $('input[name="pass_currentadd"][value="2"]').prop('checked', true);
    $('input[name="pass_permaadd"][value="2"]').prop('checked', true);
    $('input[name="pass_contactnum"][value="2"]').prop('checked', true);
    $('input[name="pass_landline"][value="2"]').prop('checked', true);
    $('input[name="pass_email"][value="2"]').prop('checked', true);
  }
});
$('#check_allfed').click(function() {
  if ($(this).is(':checked')) {
    $('input[name="pass_emp_no"][value="2"]').prop('checked', true);
    $('input[name="pass_campus"][value="2"]').prop('checked', true);
    $('input[name="pass_classification"][value="2"]').prop('checked', true);
    $('input[name="pass_college_unit"][value="2"]').prop('checked', true);
    $('input[name="pass_department"][value="2"]').prop('checked', true);
    $('input[name="pass_rankpos"][value="2"]').prop('checked', true);
    $('input[name="pass_appointment"][value="2"]').prop('checked', true);
    $('input[name="pass_appointdate"][value="2"]').prop('checked', true);
    $('input[name="pass_monthlysalary"][value="2"]').prop('checked', true);
    $('input[name="pass_sg"][value="2"]').prop('checked', true);
    $('input[name="pass_sgcat"][value="2"]').prop('checked', true);
    $('input[name="pass_tin_no"][value="2"]').prop('checked', true);
  }
});
$('#check_allfmd').click(function() {
  if ($(this).is(':checked')) {
    $('input[name="pass_monthlycontri"][value="2"]').prop('checked', true);
    $('input[name="pass_equivalent"][value="2"]').prop('checked', true);
  }
});
$('#check_allfsd').click(function() {
  if ($(this).is(':checked')) {
    $('input[name="pass_membershipf"][value="2"]').prop('checked', true);
    $('input[name="pass_proxyform"][value="2"]').prop('checked', true);
  }
});
$('#save_record').click(function() {
    event.preventDefault();
    // alert('gg');
$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        var formDatas = $("#aa_validation").serialize();
        $.ajax({
            type: 'POST',
            url: "{{ route('save_aa_validation') }}",
            data: formDatas,
            success: function(data) {
                if (data.success != '') {
                    alert('Success');
                }else{
                    alert('Failed');
                }
            }
        });

});
</script>
@endsection