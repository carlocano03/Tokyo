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
            min-height: 65vh;
            max-height: 65vh;
            overflow: auto;
            padding: 0;

        }

        .table-container {
            min-height: calc(65vh - 219px);
            max-height: calc(65vh - 219px);
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
        .text-center {
            text-align: center;
        }
        .ml-auto {
            margin-left: auto;
        }
        .middle-content {
            width: calc(73% - 20px);
            transition: all .5s;
        }
        .middle-content.full {
            width: calc(88% - 10px);
            transition: all .5s;
        }
        .left-content {
            width: 15%;
            opacity: 1;
            transition: opacity .5s;
        }
        .left-content.full {
            width: 0px;
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
        .border-content > div {
            border-top: 1px solid gray;
            border-right: 1px solid gray;
        }
        .border-content > div:last-child {
            border-bottom: 1px solid gray;
        }

        .border-content > div > div {
            border-left: 1px solid gray;
        }

        .border-content > div > div:first-child {
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

        .w-trail{
            width: 98%;
        }


    </style>
    <div class="filler"></div>
    <script type="text/javascript" src="{{ asset('/dist/loading-bar/loading-bar.js') }}"></script>
    <script>
        $(document).on('click', '#showLogs', function(e) {
            if ($(".middle-content").hasClass("full")) {
            $(".middle-content").removeClass("full")
            $(".left-content").removeClass("d-none")
            setTimeout(function() {
                $(".left-content").removeClass("full")
            }, 500)
            $("#showLogs").text("Hide history logs")
            } else {
            $(".middle-content").addClass("full")
            
            $(".left-content").addClass("d-none")
            $(".left-content").addClass("full")
            $("#showLogs").text("Show history logs")
            }
        })
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
        $(document).on('click', '.view-member', function(e) {
            if ($("#view-member-details").hasClass("d-none")) {
                $("#view-member-details").removeClass("d-none")
                $("#view-all-members").removeClass("d-none")
            } else {
                $("#view-all-members").removeClass("d-none")
                $("#view-member-details").addClass("d-none")
            }
        })
        // $(document).ready(function () {
        //     $("#view-member-details").removeClass("d-none")
        //         $("#view-all-members").removeClass("d-none")
        // })
    </script>
    <link rel="stylesheet" type="text/css" href="{{ asset('/dist/loading-bar/loading-bar.css') }}">
    </link>
    <div class="row no-gutter ml-0 mr-0 p-5px mh-content d-none" id="view-member-details">
        <div class="w-full">
            <div class="card relative" style="min-height: 200px;">
                <a class="cursor-pointer mp-ph0 mp-pv0 view-member" style="position: absolute; top: 7px; left: 10px">
                    <i class="fa fa-times-circle-o " aria-hidden="true"></i>
                </a>
                <div class="d-flex flex-row mp-pt3 gap-10">
                   <div class="w-auto">
                        <span class="font-sm">Membership Application Number</span> 
                        <br/>
                        <span class="magenta-clr font-bold">asdasdasd-123123-asd</span> 
                    </div>
                    <div class="w-auto">
                        <span class="font-sm">Application Date and Time</span>
                        <br/>
                        <span class="magenta-clr font-bold">January 23, 2023 2:22PM</span> 
                    </div>
                    <div class="w-auto">
                        <span class="font-sm">Status</span>
                        <br/>
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
                        <div class="card-body trail"-trail id="trail-body">
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
                        <div class="card-header magenta-bg">
                            Validation Process
                        </div>
                        <div class="card-body mp-pv4 mp-ph3 d-flex flex-column min-h-50vh border-content">
                            <div class="table-form form-header w-full">
                                <div class="span-3 magenta-bg color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                                    <span>
                                        I. Personal Details
                                    </span>
                                </div>
                                <div class="span-9 color-white text-center orage-bg mp-ph1" style="border-bottom: 1px solid gray;">
                                    <span>
                                        AA Validation
                                    </span>
                                </div>
                                <div class="span-1 text-center mp-ph1">
                                    <span>
                                        Passed
                                    </span>
                                </div>
                                <div class="span-1 text-center mp-ph1">
                                    <span>
                                        Failed
                                    </span>
                                </div>
                                <div class="span-7 text-center mp-ph1">
                                    <span >
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
                                    <input type="checkbox"> 
                                </div>
                                <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                                    <input type="checkbox"> 
                                </div>
                                <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                                    <input type="text" class="w-input mp-pv2">
                                </div>
                                <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                                    <span>
                                        Dela Cruz, Juan G.
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
                                    <input type="checkbox"> 
                                </div>
                                <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                                    <input type="checkbox"> 
                                </div>
                                <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                                    <input type="text" class="w-input mp-pv2">
                                </div>
                                <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                                    <span>
                                        Dela Cruz, Juan G.
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
                                    <input type="checkbox"> 
                                </div>
                                <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                                    <input type="checkbox"> 
                                </div>
                                <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                                    <input type="text" class="w-input mp-pv2">
                                </div>
                                <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                                    <span>
                                        Dela Cruz, Juan G.
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
                                    <input type="checkbox"> 
                                </div>
                                <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                                    <input type="checkbox"> 
                                </div>
                                <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                                    <input type="text" class="w-input mp-pv2">
                                </div>
                                <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                                    <span>
                                        Dela Cruz, Juan G.
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
                                    <input type="checkbox"> 
                                </div>
                                <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                                    <input type="checkbox"> 
                                </div>
                                <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                                    <input type="text" class="w-input mp-pv2">
                                </div>
                                <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                                    <span>
                                        Dela Cruz, Juan G.
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
                                    <input type="checkbox"> 
                                </div>
                                <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                                    <input type="checkbox"> 
                                </div>
                                <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                                    <input type="text" class="w-input mp-pv2">
                                </div>
                                <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                                    <span>
                                        Dela Cruz, Juan G.
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
                                    <input type="checkbox"> 
                                </div>
                                <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                                    <input type="checkbox"> 
                                </div>
                                <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                                    <input type="text" class="w-input mp-pv2">
                                </div>
                                <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                                    <span>
                                        Dela Cruz, Juan G.
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
                                    <input type="checkbox"> 
                                </div>
                                <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                                    <input type="checkbox"> 
                                </div>
                                <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                                    <input type="text" class="w-input mp-pv2">
                                </div>
                                <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                                    <span>
                                        Dela Cruz, Juan G.
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
                                    <input type="checkbox"> 
                                </div>
                                <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                                    <input type="checkbox"> 
                                </div>
                                <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                                    <input type="text" class="w-input mp-pv2">
                                </div>
                                <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                                    <span>
                                        Dela Cruz, Juan G.
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
                                    <input type="checkbox"> 
                                </div>
                                <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                                    <input type="checkbox"> 
                                </div>
                                <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                                    <input type="text" class="w-input mp-pv2">
                                </div>
                                <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                                    <span>
                                        Dela Cruz, Juan G.
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
                                    <input type="checkbox"> 
                                </div>
                                <div class="span-1 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                                    <input type="checkbox"> 
                                </div>
                                <div class="span-7 color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                                    <input type="text" class="w-input mp-pv2">
                                </div>
                                <div class="span-3 text-center mp-ph1 font-sm d-flex align-items-center justify-content-center">
                                    <span>
                                        Dela Cruz, Juan G.
                                    </span>
                                </div>
                            </div>
                            <div class="table-form form-header w-full">
                                <div class="span-3 magenta-bg color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                                    <span>
                                        II. Employee Details
                                    </span>
                                </div>
                                <div class="span-1 text-center mp-ph1">
                                    <span>
                                        Passed
                                    </span>
                                </div>
                                <div class="span-1 text-center mp-ph1">
                                    <span>
                                        Failed
                                    </span>
                                </div>
                                <div class="span-7 text-center mp-ph1">
                                    <span >
                                        Remarks
                                    </span>
                                </div>
                            </div>  
                            <div class="table-form form-header w-full">
                                <div class="span-3 magenta-bg color-white text-center mp-ph1 d-flex align-items-center justify-content-center" style="grid-row: span 2 / span 1;">
                                    <span>
                                        III. Members Details
                                    </span>
                                </div>
                                <div class="span-1 text-center mp-ph1">
                                    <span>
                                        Passed
                                    </span>
                                </div>
                                <div class="span-1 text-center mp-ph1">
                                    <span>
                                        Failed
                                    </span>
                                </div>
                                <div class="span-7 text-center mp-ph1">
                                    <span >
                                        Remarks
                                    </span>
                                </div>
                            </div>                          
                        </div>
                        <div class="table-form form-header w-full gray-bg">
                            <div class="span-6 d-flex flex-column mp-pv3 mp-ph3 gap-10">
                                <span>General Remarks</span>
                                <div class="table-form">
                                    <span class="span-6"><input type="checkbox"> Forward to CFM</span>
                                    <span class="span-6"><input type="checkbox"> Reject Application</span>
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
                            </div>
                            <div class="span-6 d-flex flex-column mp-pv3 mp-ph3 gap-10">
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
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row no-gutter ml-0 mr-0 p-5px mh-content view-all-members">
        <div class="col-12 mp-pv0 mp-pr0 d-flex">
            <span class="d-inline-flex align-items-center ">
                <a href="/dashboard" class="link-style">Dashboard</a>/ &nbsp; Membership Application Records
            </span>
            <span class="d-inline-flex align-items-center ml-auto mp-mr3">
                <button class="f-button magenta-bg" id="showLogs">Show history logs</button>
            </span>
        </div>
        <div class="col-12 mp-pr0" style="width: 100%;">
            <div class="row d-flex flex-row gap-10 mp-pr0" style="width: 100%;">
                <div style="width: 12%;" class="d-flex flex-column gap-10">
                    <div class="card-container card p-0">
                        <div class="card-header font-sm text-center green-bg">
                            New Application
                        </div>
                        <div class="card-body justify-content-center">
                            <div class="ldBar green label-center" data-preset="circle" style="width: 60px; height: 60px" data-value="{{ $new_app }}">
                            </div>
                        </div>
                        <button class="green-bg button-view font-sm">
                            View
                        </button>
                    </div>
                    <div class="card-container card p-0">
                        <div class="card-header font-sm text-center magenta-bg">
                            Processing Application
                        </div>
                        <div class="card-body justify-content-center">
                            <div class="ldBar magenta label-center" data-preset="circle" style="width: 60px; height: 60px" data-value="{{ $forApproval }}">
                            </div>
                        </div>
                        <button class="magenta-bg button-view font-sm">
                            View
                        </button>
                    </div>
                    <div class="card-container card p-0">
                        <div class="card-header font-sm text-center maroon-bg">
                            Approved Application
                        </div>
                        <div class="card-body justify-content-center">
                            <div class="ldBar maroon label-center" data-preset="circle" style="width: 60px; height: 60px" data-value="{{ $approved }}">
                            </div>
                        </div>
                        <button class="maroon-bg button-view font-sm">
                            View
                        </button>
                    </div>
                    <div class="card-container card p-0">
                        <div class="card-header font-sm text-center red-bg">
                            Rejected Application
                        </div>
                        <div class="card-body justify-content-center">
                            <div class="ldBar red label-center" data-preset="circle" style="width: 60px; height: 60px" data-value="{{ $rejected }}"></div>
                        </div>
                        <button class="red-bg button-view font-sm">
                            View
                        </button>
                    </div>
                </div>
                <div class="d-flex flex-column gap-10 middle-content full">
                    <div class="card-container card p-0 ">
                        <div class="card-header filtering">
                            Filtering Section
                        </div>
                        <div class="card-body filtering-section-body justify-content-center gap-10">
                            <div class="col-md-12 col-xl-6">
                                <div class="row field-filter">
                                    <div class="col-md-12 p-0">
                                        <label for="row">Campus</label>
                                        <select name="" class="radius-1 outline select-field"
                                            style="width: 100%; height: 30px" id="campuses_select">
                                            <option value="">Show All</option>
                                            @foreach ($campuses as $row)
                                              <option value="{{ $row->campus_key }}">{{ $row->name }}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 p-0">
                                        <label for="row">Department</label>
                                        <select name="" class="radius-1 outline select-field"
                                            style="width: 100%; height: 30px" id="department_select">
                                            <option value="">Show All</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-5">
                                <div class="row">
                                    <label for="row">Membership Date</label>
                                </div>
                                <div class="row date_range">
                                    <input type="date" id="from" class="radius-1 border-1 date-input outline"
                                        style="height: 30px;">
                                    <span for="" class="self_center mv-1"
                                        style="margin-left:15px; margin-right:15px;">to</span>
                                    <input type="date" id="to" class="radius-1 border-1 date-input outline"
                                        style="height: 30px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-10 flex-row justify-content-end mp-pr2">
                        <button class="f-button">Export</button>
                        <button class="f-button">Print</button>
                    </div>
                    <div class="card d-flex flex-column">
                        <div class="d-flex flex-row items-between">
                            <input class="mp-text-field mp-pt2 sticky top-0 " type="text" placeholder="Search here" id="search_value"/>
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
                        </div>
                        <div class="mp-mt3 table-container">
                            <table class="members-table" style="height: auto;" width="100%">
                                <thead>
                                    <tr>
                                        <th style="width: 48px;">
                                            <span>Action</span>
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
                                        <th>
                                            <span>Employee No</span>
                                        </th>
                                        <th>
                                            <span>Class</span>
                                        </th>
                                        <th>
                                            <span>Position</span>
                                        </th>
                                        <th>
                                            <span>MC</span>
                                        </th>
                                        <th>
                                            <span>Status</span>
                                        </th>
                                        <th>
                                            <span>Remarks</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="left-content full d-none">
                    <div class="card-container card p-0">
                        <div class="card-header history-logs">
                            History Logs
                        </div>
                        <div class="card-body flex-column history-container ">
                            <input class="mp-input-group__input mp-text-field mp-pt2 sticky top-0 " type="text"
                                placeholder="Search here" style="width: 95% ;margin-left: auto;margin-right: auto" />
                            <div class="history-item">
                                <div>
                                    <span class="font-18">Dela Cruz, Juan</span>
                                </div>
                                <div>
                                    <span class="font-13">UP Head Office / Administrator</span>
                                </div>
                                <div>
                                    <span class="font-13">Signed in, January 2, 2023 Time: 02:00 pm</span>
                                </div>
                            </div>
                            <div class="history-item">
                                <div>
                                    <span class="font-18">Dela Cruz, Juan</span>
                                </div>
                                <div>
                                    <span class="font-13">UP Head Office / Administrator</span>
                                </div>
                                <div>
                                    <span class="font-13">Signed in, January 2, 2023 Time: 02:00 pm</span>
                                </div>
                            </div>
                            <div class="history-item">
                                <div>
                                    <span class="font-18">Dela Cruz, Juan</span>
                                </div>
                                <div>
                                    <span class="font-13">UP Head Office / Administrator</span>
                                </div>
                                <div>
                                    <span class="font-13">Signed in, January 2, 2023 Time: 02:00 pm</span>
                                </div>
                            </div>
                            <div class="history-item">
                                <div>
                                    <span class="font-18">Dela Cruz, Juan</span>
                                </div>
                                <div>
                                    <span class="font-13">UP Head Office / Administrator</span>
                                </div>
                                <div>
                                    <span class="font-13">Signed in, January 2, 2023 Time: 02:00 pm</span>
                                </div>
                            </div>
                            <div class="history-item">
                                <div>
                                    <span class="font-18">Dela Cruz, Juan</span>
                                </div>
                                <div>
                                    <span class="font-13">UP Head Office / Administrator</span>
                                </div>
                                <div>
                                    <span class="font-13">Signed in, January 2, 2023 Time: 02:00 pm</span>
                                </div>
                            </div>
                            <div class="history-item">
                                <div>
                                    <span class="font-18">Dela Cruz, Juan</span>
                                </div>
                                <div>
                                    <span class="font-13">UP Head Office / Administrator</span>
                                </div>
                                <div>
                                    <span class="font-13">Signed in, January 2, 2023 Time: 02:00 pm</span>
                                </div>
                            </div>
                            <div class="history-item">
                                <div>
                                    <span class="font-18">Dela Cruz, Juan</span>
                                </div>
                                <div>
                                    <span class="font-13">UP Head Office / Administrator</span>
                                </div>
                                <div>
                                    <span class="font-13">Signed in, January 2, 2023 Time: 02:00 pm</span>
                                </div>
                            </div>
                            <div class="history-item">
                                <div>
                                    <span class="font-18">Dela Cruz, Juan</span>
                                </div>
                                <div>
                                    <span class="font-13">UP Head Office / Administrator</span>
                                </div>
                                <div>
                                    <span class="font-13">Signed in, January 2, 2023 Time: 02:00 pm</span>
                                </div>
                            </div>
                            <div class="history-item">
                                <div>
                                    <span class="font-18">Dela Cruz, Juan</span>
                                </div>
                                <div>
                                    <span class="font-13">UP Head Office / Administrator</span>
                                </div>
                                <div>
                                    <span class="font-13">Signed in, January 2, 2023 Time: 02:00 pm</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   

    <script>
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
    </script>
@endsection
