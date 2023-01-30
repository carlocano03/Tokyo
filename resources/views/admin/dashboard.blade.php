@extends('layouts/main')
@section('content_body')
    <style>

        .card-header {
            border-top-left-radius: 7px;
            border-top-right-radius: 7px;
            background-color: gray;
            padding: 5px 10px;
            color: white;
        }
     
        .dashboard {
            height: calc(100% - 131px);
            overflow-x: hidden;
        }

        /* .calendar>.wrapper {
                width: 100%;
                background: #fff;
                border-radius: 10px;
                box-shadow: 0 0px 5px rgba(0, 0, 0, 0.12);
                display: flex;
                flex-direction: column;
              }

              .calendar>.wrapper header {
                display: flex;
                align-items: center;
                padding: 25px 30px 10px;
                justify-content: space-between;
              } */

        header .icons {
            display: flex;
        }

        header .icons span {
            height: 38px;
            width: 38px;
            margin: 0 1px;
            cursor: pointer;
            color: #878787;
            text-align: center;
            line-height: 38px;
            font-size: 1.9rem;
            user-select: none;
            border-radius: 50%;
        }

        .p-0 {
            padding: 0;
        }

        .icons span:last-child {
            margin-right: -10px;
        }

        header .icons span:hover {
            background: #f2f2f2;
        }

        header .current-date {
            font-size: 1.45rem;
            font-weight: 500;
        }

        /*
              .calendar ul {
                display: flex;
                flex-wrap: wrap;
                list-style: none;
                text-align: center;
              }

              .calendar .days {
                margin-bottom: 20px;
              }

              .calendar li {
                color: #333;
                width: calc(100% / 7);
                font-size: 1.07rem;
              }

              .calendar .weeks li {
                font-weight: 500;
                cursor: default;
              }

              .calendar .days li {
                z-index: 1;
                cursor: pointer;
                position: relative;
                margin-top: 30px;
              }

              .calendar>.days li.default {
                color: #aaa;
              }

              .calendar>.days li.selected {
                color: #fff;
              }

              .calendar>.days li::before {
                position: absolute;
                content: "";
                left: 50%;
                top: 50%;
                height: 40px;
                width: 40px;
                z-index: -1;
                border-radius: 50%;
                transform: translate(-50%, -50%);
              }

              .calendar>.days li.selected::before {
                background: #6c1242;
              }

              .calendar>.days li:not(.selected):hover::before {
                background: #f2f2f2;
              } */

        .side-dashboard {
            grid-template-columns: 1fr 1fr;
        }

        .right-dashboard {
            padding-left: 0;
        }

        .user-details {
            grid-template-columns: 2fr 1fr;
        }



        .highcharts-figure,
        .highcharts-data-table table {
            min-width: 310px;
            max-width: 800px;
            margin: 1em auto;
        }

        #container {
            height: 400px;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }

        #container {
            width: 100%;
        }

        text.highcharts-credits {
            display: none;
        }

        .main-dashboard {
            grid-template-columns: repeat(12, 1fr);
            padding-left: 15px;
            padding-right: 15px;
        }

        .campus-content {
            grid-template-columns: repeat(12, 1fr);
        }

        .col-campus:nth-child(1) {
            grid-column: span 4;
        }

        .col-campus:nth-child(2) {
            grid-column: span 4;
        }

        .col-campus:nth-child(3) {
            grid-column: span 4;
        }


        .col {
            padding: 0
        }

        .col:nth-child(1) {
            grid-column: span 9;
        }

        .col:nth-child(2) {
            grid-column: span 3;
        }

        .col:nth-child(3) {
            grid-column: span 6;
        }

        .col:nth-child(4) {
            grid-column: span 6;
        }

        .content-right {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .ml-auto {
            margin-left: auto;
        }

        .total-loans {
            display: flex;
        }

        .total-loans-child:nth-child(1) {
            grid-column: span 2;
        }

        .total-loans-child:nth-child(2) {
            grid-column: span 5;
        }

        .total-loans-child:nth-child(3) {
            grid-column: span 12;
        }

        @media (max-width:1300px) {
            .col:nth-child(2) {
                grid-column: span 12;
            }

            .col:nth-child(1) {
                grid-column: span 12;
            }

            .total-loans {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .title-total {
                text-align: center;
            }

            .total-loans>.ml-auto {
                margin-left: 0;
                margin-bottom: 10px;
            }


            .col-campus:nth-child(1) {
                grid-column: span 12;
            }

            .col-campus:nth-child(2) {
                grid-column: span 6;
            }

            .col-campus:nth-child(3) {
                grid-column: span 6;
            }

            #campusSelector {
                display: flex;
                justify-content: center;
            }

            .side-dashboard {
                grid-template-columns: 1fr 1fr 1fr 1fr;
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
        }


        @media (max-width:984px) {


            .right-dashboard {
                padding-left: 15px;
                margin-top: 10px;
                margin-bottom: 25px;
            }

            .col:nth-child(2) {
                grid-column: span 12;
            }

            .col:nth-child(1) {
                grid-column: span 12;
            }


        }


        @media (max-width:700px) {

            .col:nth-child(1) {
                grid-column: span 12;
            }

            .col:nth-child(2) {
                grid-column: span 12;
            }

            .col:nth-child(3) {
                grid-column: span 12;
            }

            .col:nth-child(4) {
                grid-column: span 12;
            }
        }


        @media (max-width:500px) {
            .user-details {
                grid-template-columns: 1fr;
            }

            .details {
                grid-template-columns: 1fr;
                grid-row: 2;

            }

            .image-profile {
                display: none;
            }

            .side-dashboard>.card>.content-right {
                margin-top: 0px;
                padding-left: 10px;
                padding-right: 10px;

                display: flex;
                justify-content: space-between;
                flex-direction: row;
            }

            .side-dashboard>.card>.content-right>label {
                margin-bottom: 0px;
                margin-top: 0px !important;
            }


        }

        .right-dashboard {
            padding-left: 0;
        }

        .user-details {
            grid-template-columns: 2fr 1fr;
        }


        @media (max-width:500px) {
            .user-details {
                grid-template-columns: 1fr;
            }

            .details {
                grid-template-columns: 1fr;
                grid-row: 2;

            }

            .image-profile {
                grid-row: 1;
            }

        }

        .highcharts-figure,
        .highcharts-data-table table {
            min-width: 310px;
            max-width: 800px;
            margin: 1em auto;
        }

        #container {
            height: 400px;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }

        #container {
            width: 100%;
        }

        text.highcharts-credits {
            display: none;
        }

        .w-full {
            width: 100%;
        }

        .pb-1px {
            padding-bottom: 1px;
        }

        .h-42px {
            height: 42px;
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

        .green-bg {
            background-color: #39b74d;
            color: white;
        }

        .font-sm {
            font-size: 13px;
        }

        .card-body {
            display: flex;
            flex-direction: row;
            border-bottom-left-radius: 7px;
            border-bottom-right-radius: 7px;
            padding: 5px 10px;
            background-color: white;
            height: 100%;
            align-items: center;
        }

        .card-body>span {
            font-size: 20px;
        }

        .card-body>h1 {
            width: 60px;
        }


        .ldBar-label {
            font-size: 17px;
        }

        .text-center {
            text-align: center;
        }



    </style>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="{{ asset('/dist/adminDashboard.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/dist/loading-bar/loading-bar.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('/dist/loading-bar/loading-bar.css') }}">

    <div class="filler"></div>
    <div class="col-12 mp-ph2 mp-pv2 mp-text-fs-large mp-text-c-accent mp-overflow-y dashboard mh-content">
        <div class="row no-gutter mp-pt1 main-dashboard grid gap-10">
            <div class="col">
                <div class="row no-gutter gap-10">
                    <div class="col-12">
                        <div class="card d-flex flex-row items-between">
                           <div class="">
                                <h2 class="font-lg mb-0">
                                    Welcome! {{ Auth::user()->last_name }} {{ Auth::user()->first_name }}
                                </h2>
                                <span class="mp-text-c-gray">
                                    UP diliman Administrator
                                </span>
                           </div>
                           <div class="d-flex flex-column">
                             
                                   <div class="h-42px d-flex flex-row align-items-center w-full justify-content-end">
                                    <button class="pb-1px mp-button mp-button--primary mp-button--ghost mp-button--raised mp-button--mini mp-text-fs-small up-button-green">View my
                                            Profile
                                    </button>
                                   </div>
                                   <span>
                                     <label
                                            style=" color: var(--c-primary);
                                            font-size: 15px;">{{ date('F j, Y H:i:s A', strtotime($login)) }} <span class="up-color">: Last Login</span></label>
                                </span>
                           </div>
                           
                            
                            <!-- <div class="image-profile items-center" style="width: 100%; height: 100%; ">
                          <div class="" style="width: 100%; height: 100%; background-color: blue; color: white">
                            image here
                          </div>
                        </div> -->
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card grid campus-content" style="min-height: 134px;">
                            <div class="col-campus">
                                <div id="campusSelector" class="mp-dropdown">
                                    <a class="mp-dropdown__toggle mp-link mp-link--accent">
                                        <span class="mp-text-fs-xxlarge campus_title text_link_primary">
                                            All UP Campuses
                                        </span>
                                        <i class="mp-icon icon-arrow-down mp-ml2" style="cursor: pointer;"></i>
                                    </a>
                                    <div class="mp-dropdown__menu">
                                        <a value=""
                                            class="text_link mp-dropdown__item mp-link mp-link--normal campus_change"
                                            style="cursor: pointer">All UP Campuses</a>
                                        @foreach ($campuses as $row)
                                            <a value="{{ $row->id }}"
                                                class="text_link mp-dropdown__item mp-link mp-link--normal campus_change"
                                                style="cursor: pointer">
                                                {{ $row->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-lg-4" hidden>
                                <select name="" class="mp-text-field mp-ph3 mp-link mp-link--accent"
                                    style="width: 100%; font-size:20px" id="campuses_select">
                                    <option value="">All Campuses</option>
                                    @foreach ($campuses as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            </div>

                           

                            <div class="col-campus">
                                <div class=" mp-pv3">
                                    <div class="mp-text-c-gray mp-text-fs-small mp-pt3 title-total">
                                        Total Members
                                    </div>
                                    <div class="total-loans">
                                        <span class="d-flex total-loans-child">
                                            <span class="mp-mr2 mp-dashboard__icon">
                                                @include('layouts.icons.i-members')
                                            </span>
                                            <span class="mp-text-fs-xlarge total-loans-child" id="totalMember">100</span>
                                        </span>
                                        <span class="ml-auto total-loans-child">
                                            <button href="{{ url('/admin/members') }}" style="height: 25px;"
                                                class=" mp-button mp-button--primary mp-button--ghost mp-button--raised mp-button--mini mp-text-fs-small up-button-green">
                                                <!-- mp-button mp-button--primary mp-button--ghost mp-button--raised mp-button--mini mp-text-fs-small -->
                                                View All Members
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-campus">
                                <div class=" mp-pv3">
                                    <div class="mp-text-c-gray mp-text-fs-small mp-pt3 title-total">
                                        Total Loans Granted
                                    </div>
                                    <div class="total-loans">
                                        <span class="d-flex total-loans-child">
                                            <span class="mp-mr2 mp-dashboard__icon total-loans-child">
                                                @include('layouts.icons.i-loans')
                                            </span>
                                            <span class="mp-text-fs-xlarge total-loans-child" id="totalMember">100m</span>
                                        </span>
                                        <span class="ml-auto total-loans-child">
                                            <button href="{{ url('/admin/members') }}" style="height: 25px;"
                                                class="mp-button mp-button--primary mp-button--ghost mp-button--raised mp-button--mini mp-text-fs-small up-button-green">
                                                <!-- mp-button mp-button--primary mp-button--ghost mp-button--raised mp-button--mini mp-text-fs-small -->
                                                View All Loans
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="right-dashboard col grid side-dashboard gap-10 font-sm">
                <div class="card-container card p-0 ">
                    <div class="card-header green-bg text-center">
                        New
                    </div>
                    <div class="card-body justify-content-center">
                        <div class="ldBar green label-center" data-preset="circle" data-value="0" id="new_app" style="width: 60px; height:60px"></div>
                    </div> 
                    <button class="green-bg button-view mt-auto">
                        View
                    </button>
                </div>
                <div class="card-container card p-0">
                    <div class="card-header magenta-bg text-center">
                        Processing
                    </div>
                    <div class="card-body justify-content-center">
                        <div class="ldBar magenta label-center" data-preset="circle" data-value="0" id="forApproval" style="width: 60px; height:60px"></div>
                    </div>
                    <button class="magenta-bg button-view mt-auto">
                        View
                    </button>
                </div>
                <div class="card-container card p-0">
                    <div class="card-header maroon-bg text-center">
                        Approved
                    </div>
                    <div class="card-body justify-content-center">
                        <div class="ldBar maroon label-center" data-preset="circle" data-value="0" id="draft" style="width: 60px; height:60px"></div>
                    </div>
                    <button class="maroon-bg button-view mt-auto">
                        View
                    </button>
                </div>
                <div class="card-container card p-0">
                    <div class="card-header red-bg text-center">
                        Rejected
                    </div>
                    <div class="card-body justify-content-center">
                        <div class="ldBar red label-center" data-preset="circle" data-value="0" id="rejected" style="width: 60px; height:60px"></div>
                    </div>
                    <button class="red-bg button-view mt-auto">
                        View
                    </button>
                </div>
            </div>
            <div class="col">
                <div class="card" style="min-height: 300px;">
                    <figure class="highcharts-figure" style="width: 100%">
                        <div id="container">
                            <div id="chart-members" style="width: 100%">

                            </div>
                        </div>
                    </figure>
                </div>
            </div>
            <div class="col">
                <div class="card" style="min-height: 300px;">
                    <figure class="highcharts-figure" style="width: 100%">
                        <div id="container" style="width: 100%">
                            <div id="chart" style="width: 100%">

                            </div>
                        </div>
                    </figure>
                </div>
            </div>
            <!-- <div class="calendar">
                    <div class="wrapper">
                      <header>
                        <p class="current-date"></p>
                        <div class="icons">
                          <span id="prev" class="material-symbols-rounded"><i class="fa fa-chevron-left" aria-hidden="true"></i></span>
                          <span id="next" class="material-symbols-rounded"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>
                        </div>
                      </header>
                      <div class="calendar">
                        <ul class="weeks">
                          <li>Sun</li>
                          <li>Mon</li>
                          <li>Tue</li>
                          <li>Wed</li>
                          <li>Thu</li>
                          <li>Fri</li>
                          <li>Sat</li>
                        </ul>
                        <ul class="days"></ul>
                      </div>
                    </div>
                  </div> -->
            <script>
                Highcharts.chart('chart-members', {
                    chart: {
                        type: 'bar'
                    },
                    title: {
                        text: 'Members Per Campus',
                        align: 'left'
                    },
                    // subtitle: {
                    //   text: 'Source: <a ' +
                    //     'href="https://en.wikipedia.org/wiki/List_of_continents_and_continental_subregions_by_population"' +
                    //     'target="_blank">Wikipedia.org</a>',
                    //   align: 'left'
                    // },
                    xAxis: {
                        categories: [

                            'UP Diliman',
                            'UP Los Baños',
                            'PGH',
                            'UP Manila',
                            'UP Visayas',
                            'System Admin',
                            'UP Baguio',
                            'UP Cebu',
                            'UP Mindanao',
                            'UP Open University',
                        ],
                        title: {
                            text: null
                        }
                    },
                    // yAxis: {
                    //   min: 0,
                    //   title: {
                    //     text: 'Population (members)',
                    //     align: 'high'
                    //   },
                    //   labels: {
                    //     overflow: 'justify'
                    //   }
                    // },
                    tooltip: {
                        valueSuffix: ' members'
                    },
                    plotOptions: {
                        bar: {
                            dataLabels: {
                                enabled: true
                            }
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'top',
                        x: -40,
                        y: 80,
                        floating: true,
                        borderWidth: 1,
                        backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
                        shadow: true
                    },
                    credits: {
                        enabled: false
                    },
                    series: [{
                        name: 'Members',
                        color: 'rgb(124, 181, 236)',
                        data: [
                            { y: 631, color: 'rgb(247, 163, 92)' },
                            { y: 1300, color: '#071e22'},
                            { y: 3202, color: 'rgb(124, 181, 236)'},
                            { y: 721, color: 'rgb(247, 163, 92)'},
                            { y: 300, color: 'rgb(144, 237, 125)'},
                            { y: 631, color: 'rgb(247, 163, 92)'},
                            { y: 727, color: 'rgb(247, 163, 92)'},
                            { y: 3202, color: 'rgb(124, 181, 236)'},
                            { y: 2000, color: '#071e22'},
                            { y: 50, color: 'rgb(144, 237, 125)'}

                       ]
                    }, ]
                });
            </script>
            <!-- <script>
                const daysTag = document.querySelector(".days"),
                    currentDate = document.querySelector(".current-date"),
                    prevNextIcon = document.querySelectorAll(".icons span");
                // getting new date, current year and month
                let date = new Date(),
                    currYear = date.getFullYear(),
                    currMonth = date.getMonth();
                // storing full name of all months in array
                const months = ["January", "February", "March", "April", "May", "June", "July",
                    "August", "September", "October", "November", "December"
                ];
                const renderCalendar = () => {
                    let firstDayofMonth = new Date(currYear, currMonth, 1).getDay(), // getting first day of month
                        lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(), // getting last date of month
                        lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay(), // getting last day of month
                        lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate(); // getting last date of previous month
                    let liTag = "";
                    for (let i = firstDayofMonth; i > 0; i--) { // creating li of previous month last days
                        liTag += `<li class="default">${lastDateofLastMonth - i + 1}</li>`;
                    }
                    for (let i = 1; i <= lastDateofMonth; i++) { // creating li of all days of current month
                        // adding selected class to li if the current day, month, and year matched
                        let isToday = i === date.getDate() && currMonth === new Date().getMonth() &&
                            currYear === new Date().getFullYear() ? "selected" : "";
                        liTag += `<li class="${isToday}">${i}</li>`;
                    }
                    for (let i = lastDayofMonth; i < 6; i++) { // creating li of next month first days
                        liTag += `<li class="default">${i - lastDayofMonth + 1}</li>`
                    }
                    currentDate.innerText =
                        `${months[currMonth]} ${currYear}`; // passing current mon and yr as currentDate text
                    daysTag.innerHTML = liTag;
                }
                renderCalendar();
                prevNextIcon.forEach(icon => { // getting prev and next icons
                    icon.addEventListener("click", () => { // adding click event on both icons
                        // if clicked icon is previous icon then decrement current month by 1 else increment it by 1
                        currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;
                        if (currMonth < 0 || currMonth > 11) { // if current month is less than 0 or greater than 11
                            // creating a new date of current year & month and pass it as date value
                            date = new Date(currYear, currMonth, new Date().getDate());
                            currYear = date.getFullYear(); // updating current year with new date year
                            currMonth = date.getMonth(); // updating current month with new date month
                        } else {
                            date = new Date(); // pass the current date as date value
                        }
                        renderCalendar(); // calling renderCalendar function
                    });
                });
            </script> -->
            <script>
                Highcharts.chart('chart', {
                    chart: {
                        type: 'column',
                        renderTo: 'chart',
                    },
                    title: {
                        text: 'Contributions, Equity, and Loans '
                    },
                    subtitle: {
                        text: 'Edit dashboard script'
                    },
                    xAxis: {
                        categories: [
                            'Jan',
                            'Feb',
                            'Mar',
                            'Apr',
                            'May',
                            'Jun',
                            'Jul',
                            'Aug',
                            'Sep',
                            'Oct',
                            'Nov',
                            'Dec'
                        ],
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Rainfall (mm)'
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    series: [{
                        name: 'Tokyo',
                        data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4,
                            194.1, 95.6, 54.4
                        ]

                    }, {
                        name: 'New York',
                        data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5,
                            106.6, 92.3
                        ]

                    }, {
                        name: 'London',
                        data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3,
                            51.2
                        ]

                    }, {
                        name: 'Berlin',
                        data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8,
                            51.1
                        ]

                    }]
                });
            </script>

        </div>

    </div>

    <!-- <div id="myItem1"></div> -->
    <script>
        $(document).ready(function() {
            load_apllicationList_count();

            $('.campus_change').on('click', function(e) {
                var select = document.querySelector('#campuses_select')
                select.value = e.target.getAttribute('value');
                select.dispatchEvent(new Event('change'));
            });
        });

        function load_apllicationList_count(view = '') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('count_application') }}",
                method: "POST",
                data: {
                    view: view
                },
                dataType: "json",
                success: function(data) {
                    // $('#new_app').attr("data-value", );
                    // $('#forApproval').attr("data-value", data.forApproval > 0 ? data.forApproval : "0");
                    // $('#draft').attr("data-value", data.draft > 0 ? data.draft : "0");
                    // $('#rejected').attr("data-value", data.rejected > 0 ? data.rejected : "0");
                    var bar1 = new ldBar("#new_app");
                    bar1.set(data.new_app > 0 ? data.new_app : 0);
                    var bar2 = new ldBar("#forApproval");
                    bar2.set(data.forApproval > 0 ? data.forApproval : 0);
                    var bar3 = new ldBar("#draft");
                    bar3.set(data.draft > 0 ? data.draft : 0);
                    var bar4 = new ldBar("#rejected");
                    bar4.set(data.rejected > 0 ? data.rejected : 0);
                }
            });
        }
    </script>
@endsection
