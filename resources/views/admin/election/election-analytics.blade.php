@extends('layouts/main')
@section('content_body')

<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
        transform: scale(0.6);
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: var(--c-accent);
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

    .button-active {
        background-color: var(--c-accent);
        color: white;

    }

    .button-menu {
        font-weight: 600;
        border-radius: 5px;
    }

    .candidates {
        text-align: center;
        border: solid 1px #c6c6c6;
        margin: 20px;
    }

    .candidates label {
        font-size: 25px;
        width: 100%;
        color: white;
        background-color: var(--c-accent);
        border: solid 1px black;
    }

    .candidate-button-container {
        display: flex;
        flex-wrap: nowrap;
        margin: 5px;
    }

    .candidate-button-container>div {
        /* background-color: #f1f1f1; */
        width: 100%;
        margin: 1px;
        text-align: center;


        font-size: 12px;
    }

    .search-container {
        background-color: white;
        padding-top: 5px;
        padding-bottom: 10px;
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
        transition: all .5s;
        display: none !important;

    }

    .w-full {
        width: 100%;
    }

    .transition {
        transition: 1s;
        -webkit-transition: 1s;
    }

    .db-text {
        font-size: 50px;
        margin-top: 20px;
        margin-bottom: 10px;
    }

    .backup-container {
        display: flex;
        justify-content: center;
        border: 1px solid #e3d1d1;
        padding: 10px;
    }

    .title-text {
        font-size: 20px;
        font-weight: bold;
    }

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

    .create-button {
        text-align: center;
    }

    .create-button button {
        padding: 11px;
    }

    .voters-text label {
        font-size: 12px;
        margin-bottom: -8px !important;
    }

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

    .font-bold {
        font-weight: 500;
    }

    .font-lg {
        font-size: 30px;
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

        .right-dashboard {
            padding-top: 10px;
            padding-bottom: 10px;
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
            padding-top: 10px;
            padding-bottom: 10px;
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

    .red-clr {
        color: #de2e4f;
    }

    .green-clr {
        color: #39b74d;
    }

    .maroon-clr {
        color: #894168;
    }

    .magenta-clr {
        color: #1a8981;
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

    .winner-info {
        text-align: center;
    }

    .name label {
        font-size: 40px;
        color: var(--c-accent);
    }

    .campus-role label {
        font-size: 15px;
    }

    .cluster-tab-button {
        border-top-right-radius: 10px;
        border-top-left-radius: 10px;
        padding-left: 20px;
        padding-right: 20px;
        border: 1px solid #cec7c7;
        margin-right: -5px !important;
    }

    .cluster-button-active {
        background-color: var(--c-accent) !important;
        color: white !important;
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

<div class="col-12  mp-text-fs-large mp-text-c-accent  dashboard mh-content" style="padding:0px !important;">


    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2" id="settingsTab" style="padding:0px !important; height: 100%; overflow-y:auto; ">
                <div class="mp-card admin-settingtab" style="padding-bottom:150px;">
                    <div class="settings-tab">
                        <div class="top-label">
                            <label>Election Module</label>
                            <i class="fa fa-cog" aria-hidden="true"></i>
                        </div>

                        <div class="settings-buttons">
                            <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-start" id="menu">
                                <li class="options options-active" onclick="location.href='election-analytics'">
                                    <a href="#" class="no-padding options-a-active">Election Day Analytics</a><br>
                                    <label class="option-info options-info-active">Allow User to view election day analytics
                                    </label>
                                </li>
                                <li class="options " onclick="location.href='create-election'">
                                    <a href="#" class="no-padding ">Create New Election</a><br>
                                    <label class="option-info ">Allow User to create new election
                                    </label>
                                </li>
                                <li class="options" onclick="location.href='election-record'">
                                    <a href="#" class="no-padding">Election Records</a><br>
                                    <label class="option-info ">Allow User to manage election records.
                                    </label>
                                </li>



                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-10 mp-mt3 " id="settingsContent">
                <div class="button-container mp-mb3">
                    <button class="f-button magenta-bg" id="showSettings">Hide Tab</button>
                </div>

                <button class="cluster-button-active cluster-tab-button">Cluster 1</button>
                <button class=" cluster-tab-button">Cluster 2</button>
                <button class=" cluster-tab-button">Cluster 3</button>
                <button class=" cluster-tab-button">Cluster 4</button>



                <div class="mp-card  mp-ph2 mp-pv2">
                    <div class="top-label">
                        <div class="mp-pt3 d-flex  flex-column mp-pb3 mp-pv2  ">
                            <input type="hidden" id="app_trailNo">
                            <div class="mp-input-group">
                                <label class="mp-input-group__label">Election Reference No:</label>
                                <label class="mp-input-group__label">102-2912</label>
                            </div>
                            <div class="mp-input-group">
                                <label class="mp-input-group__label">Cluster:</label>
                                <label class="mp-input-group__label">1 Up Diliman/ System Admin / Baguio</label>
                            </div>
                            <div class="mp-input-group">
                                <label class="mp-input-group__label">Election Year:</label>
                                <label class="mp-input-group__label">2022</label>
                            </div>
                            <div class="mp-input-group">
                                <label class="mp-input-group__label">Election Date:</label>
                                <label class="mp-input-group__label">March 2, 2023</label>
                            </div>
                            <div class="mp-input-group">


                                <label class="mp-input-group__label">Time Open: </label>
                                <label class="mp-input-group__label">10:00 am</label>

                                <label class="mp-input-group__label">Time Closed: </label>
                                <label class="mp-input-group__label">10:00 pm</label>

                            </div>

                            <div class="mp-input-group">


                                <label class="mp-input-group__label">Status:</label>
                                <label class="mp-input-group__label">Open Time</label>


                            </div>
                            <div class="mp-input-group">


                                <label class="mp-input-group__label">Salary Grade Category:</label>
                                <label class="mp-input-group__label">Both SG 1-15 and SG 16 Above</label>


                            </div>


                            <div class="buttons" style="display: flex;justify-content: right;gap: 10px;">
                                <button class="f-button font-bold" style="width: 100px; background-color: var(--c-primary);">Print</button>
                                <button class="f-button font-bold" style=" width: 100px;">Download</button>
                            </div>

                        </div>
                        <div class="row  mp-mb4">
                            <div class="col-4">
                                <div class="mp-card  mp-ph2 mp-pv2" style="border: solid var(--c-primary) 1px;">
                                    <div class="row">
                                        <div class="col-lg-6">


                                            <div class="voters-text">
                                                <label>Summary Of Voters
                                                    <br>(Members)</label>
                                                <br>
                                                <label>UP Manila</label>
                                                <label>- 1054</label>
                                                <br>
                                                <label>PGH</label>
                                                <label>- 3015</label>
                                            </div>

                                        </div>
                                        <div class="col-lg-6" style="text-align:center;">
                                            <i style="margin: 0px !important;float: none; font-size: 50px;" class="fa fa-users" aria-hidden="true"></i>
                                            <br>
                                            <label> Total Members <br>
                                                1000
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-4">
                                <div class="mp-card  mp-ph2 mp-pv2" style="border: solid var(--c-primary) 1px; color: var(--c-primary);">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="voters-text">
                                                <label>Total Voted
                                                    <br>4,050</label>
                                                <br>
                                                <label>Voted SG 1-15</label>
                                                <label>- 1054</label>
                                                <br>
                                                <label>Voted SG 16-Above</label>
                                                <label>- 3015</label>
                                            </div>

                                        </div>
                                        <div class="col-lg-6" style="text-align:center;">
                                            <i style="margin: 0px !important;float: none; font-size: 50px;" class="fa fa-users" aria-hidden="true"></i>
                                            <br>
                                            <label> Total Votes <br>
                                                4050
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mp-card  mp-ph2 mp-pv2" style="color: var(--c-accent);border: solid var(--c-accent) 1px;">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="voters-text">
                                                <label>Total Voters
                                                    <br>4090</label>
                                                <br>
                                                <label>Total Members No</label>
                                                <br>
                                                <label>UP Manila</label>
                                                <label>- 1054</label>
                                                <br>
                                                <label>PGH</label>
                                                <label>- 3015</label>
                                            </div>

                                        </div>
                                        <div class="col-lg-6" style="text-align:center;">
                                            <i style="margin: 0px !important;float: none; font-size: 50px;" class="fa fa-users" aria-hidden="true"></i>
                                            <br>
                                            <label> Total Members <br>
                                                1000
                                            </label>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class="tally">
                            {{ csrf_field() }}
                            <form id="classif_form" class="mh-reg-form form-border-bottom" style="height: calc(100% - 100px) !important;">
                                <h4 style="color: white;
                                            padding: 15px;
                                            background-color: var(--c-active-hover-bg);
                                            margin: 0;width: 100%;">Vote Tally Reports - Real Time Analytics
                                </h4>
                                <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3 member-form mp-pv2 shadow-inset-1">


                                    <figure class="highcharts-figure" style="width: 100%">
                                        <div id="container">
                                            <div id="chart-members" style="width: 100%">

                                            </div>
                                        </div>
                                    </figure>

                                    <div class="row  mp-mb4">
                                        <div class="col-4">
                                            <div class="mp-card  mp-ph2 mp-pv2" style="border: solid var(--c-primary) 1px;">
                                                <div class="row">
                                                    <div class="col-lg-6">


                                                        <div class="voters-text">
                                                            <label>Summary Of Voters
                                                                <br>(Members)</label>
                                                            <br>
                                                            <label>UP Manila</label>
                                                            <label>- 1054</label>
                                                            <br>
                                                            <label>PGH</label>
                                                            <label>- 3015</label>
                                                        </div>

                                                    </div>
                                                    <div class="col-lg-6" style="text-align:center;">
                                                        <i style="margin: 0px !important;float: none; font-size: 50px;" class="fa fa-users" aria-hidden="true"></i>
                                                        <br>
                                                        <label> Total Members <br>
                                                            1000
                                                        </label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="mp-card  mp-ph2 mp-pv2" style="border: solid var(--c-primary) 1px; color: var(--c-primary);">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="voters-text">
                                                            <label>Total Voted
                                                                <br>4,050</label>
                                                            <br>
                                                            <label>Voted SG 1-15</label>
                                                            <label>- 1054</label>
                                                            <br>
                                                            <label>Voted SG 16-Above</label>
                                                            <label>- 3015</label>
                                                        </div>

                                                    </div>
                                                    <div class="col-lg-6" style="text-align:center;">
                                                        <i style="margin: 0px !important;float: none; font-size: 50px;" class="fa fa-users" aria-hidden="true"></i>
                                                        <br>
                                                        <label> Total Votes <br>
                                                            4050
                                                        </label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mp-card  mp-ph2 mp-pv2" style="color: var(--c-accent);border: solid var(--c-accent) 1px;">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="voters-text">
                                                            <label>Total Voters
                                                                <br>4090</label>
                                                            <br>
                                                            <label>Total Members No</label>
                                                            <br>
                                                            <label>UP Manila</label>
                                                            <label>- 1054</label>
                                                            <br>
                                                            <label>PGH</label>
                                                            <label>- 3015</label>
                                                        </div>

                                                    </div>
                                                    <div class="col-lg-6" style="text-align:center;">
                                                        <i style="margin: 0px !important;float: none; font-size: 50px;" class="fa fa-users" aria-hidden="true"></i>
                                                        <br>
                                                        <label> Total Members <br>
                                                            1000
                                                        </label>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                    <br>
                                    <div class="results">
                                        <div class="winner-info">
                                            <div class="congrats">
                                                <label>Congratulations, you are now the newly Elected official of UP Provident Func Inc</label>
                                            </div>
                                            <div class="name">
                                                <label>GUANIO, VA</label>
                                            </div>

                                            <div class="campus-role">
                                                <label>UP Manila / System Admin</label>
                                            </div>
                                        </div>

                                    </div>


                                </div>

                            </form>
                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>


    <script>
        $(document).on('click', '#showSettings', function(e) {
            if ($("#settingsTab").hasClass("col-lg-2")) {
                $("#settingsTab").addClass("d-none");
                $("#settingsTab").removeClass("col-lg-2");
                $("#settingsContent").removeClass("col-lg-10");
                $("#settingsContent").addClass("col-lg-12");

                $("#showSettings").text("Show Tab")

            } else {
                $("#settingsTab").removeClass("d-none");
                $("#settingsTab").addClass("col-lg-2");
                $("#settingsContent").removeClass("col-lg-12");
                $("#settingsContent").addClass("col-lg-10");

                $("#showSettings").text("Hide Tab")
            }

        })


        Highcharts.chart('chart-members', {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Salary Grade 1-15',
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

                    'Dela Cruz, ABCD',
                    'Guanio, Va',
                    'Tani Mang Mang',
                    'Manolo, Borgi',

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
                valueSuffix: ' Votes'
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
                name: 'Votes',
                color: 'rgb(124, 181, 236)',
                data: [{
                        y: 631,
                        color: 'rgb(247, 163, 92)'
                    },
                    {
                        y: 1300,
                        color: '#1a8981'
                    },
                    {
                        y: 3202,
                        color: 'rgb(124, 181, 236)'
                    },
                    {
                        y: 721,
                        color: 'rgb(247, 163, 92)'
                    },


                ]
            }, ]
        });
        document.querySelector("input[type=number]")
            .oninput = e => console.log(new Date(e.target.valueAsNumber, 0, 1));
    </script>


    <!-- <div class="mp-card  mp-ph2 mp-pv2">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="top-label">
                                    <label>Setup New Election Module</label>
                                    <br>
                                    <label class="account-info">Allow user to create Election
                                    </label>
                                    {{ csrf_field() }}
                                    <form id="classif_form" class="mh-reg-form form-border-bottom" style="height: calc(100% - 100px) !important;">

                                        <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3 member-form mp-pv2 shadow-inset-1">
                                            <input type="hidden" id="app_trailNo">
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Election Reference No:</label>
                                                <label class="mp-input-group__label">102-2912</label>
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Select Cluster</label>
                                                <select class="mp-input-group__input mp-text-field" name="status" id="status" required>
                                                    <option value="1">Cluster 1</option>
                                                    <option value="0">Cluster 2</option>
                                                </select>
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Election Year</label>
                                                <select class="mp-input-group__input mp-text-field" name="status" id="status" required>
                                                    <option value="1">2020</option>
                                                    <option value="0">2021</option>
                                                </select>
                                            </div>

                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Election Date</label>
                                                <input type="date" id="from" class="mp-input-group__input mp-text-field radius-1 border-1 date-input outline" style=" height: 30px;">
                                            </div>

                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Time Open</label>
                                                <input type="time" id="from" class="mp-input-group__input mp-text-field radius-1 border-1 date-input outline" style=" height: 30px;">
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Time Close</label>
                                                <input type="time" id="from" class="mp-input-group__input mp-text-field radius-1 border-1 date-input outline" style=" height: 30px;">
                                            </div>

                                            <div class="mp-input-group">
                                                <input type="checkbox" class="checkbox-color " style="margin-left:2px;margin-right:3px;" id="terms" name="terms">
                                                <label class="mp-input-group__label">Open Time / User Access</label>
                                            </div>




                                            <a class="up-button-green btn-md button-animate-right mp-text-center" id="save_class" type="submit">
                                                <span>OPEN THIS ELECTION</span>
                                            </a>
                                            <a class="up-button btn-md button-animate-right mp-text-center">
                                                <span>SAVE DRAFT ELECTION</span>
                                            </a>
                                            <a class="up-button-grey btn-md button-animate-right mp-text-center">
                                                <span>CLEAR SETUP</span>
                                            </a>


                                        </div>

                                    </form>

                                </div>

                            </div>

                            <div class="col-lg-4">
                                <div class="top-label">
                                    <label>Manage Candidates</label>
                                    <br>
                                    <button class="mp-input-group__label button-active button-menu">1-15 Category</button>
                                    <button class="mp-input-group__label button-menu">16 Above Category</button>
                                    {{ csrf_field() }}
                                    <form id="classif_form" class="mh-reg-form form-border-bottom" style="height: calc(100% - 100px) !important;">

                                        <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3 member-form mp-pv2 shadow-inset-1" style="margin-top: -2px;">
                                            <input type="hidden" id="app_trailNo">
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Salary Grade</label>
                                                <label class="mp-input-group__label">1-15 Category</label>

                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Select Candidate Name</label>
                                                <select class="mp-input-group__input mp-text-field" name="status" id="status" required>
                                                    <option value="1">Name 1</option>
                                                    <option value="0">Name 2</option>
                                                </select>
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Select Cluster</label>
                                                <select class="mp-input-group__input mp-text-field" name="status" id="status" required>
                                                    <option value="1">Cluster 1</option>
                                                    <option value="0">Cluster 2</option>
                                                </select>
                                            </div>

                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Select Running Position</label>
                                                <input style="height: 40px;border: none;" type="file" class="mp-input-group__input mp-text-field radius-1 border-1 date-input outline" style=" height: 30px;">
                                            </div>

                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Select Campus</label>
                                                <select class="mp-input-group__input mp-text-field" name="status" id="status" required>
                                                    <option value="1">Campus 1</option>
                                                    <option value="0">Campus 2</option>
                                                </select>
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Select Candidate Image/Photo *</label>
                                                <input style="height: 40px;border: none;" type="file" class="mp-input-group__input mp-text-field radius-1 border-1 date-input outline" style=" height: 30px;">
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">File Attachment</label>
                                                <input style="height: 40px;border: none;" type="file" class="mp-input-group__input mp-text-field radius-1 border-1 date-input outline" style=" height: 30px;">
                                            </div>







                                            <a class="up-button btn-md button-animate-right mp-text-center">
                                                <span>ADD CANDIDATE</span>
                                            </a>




                                        </div>

                                    </form>


                                </div>
                            </div>


                            <div class="col-lg-4">

                                <div class="top-label">
                                    <label>Candidates</label>
                                    <div class="mp-input-group">
                                        <label class="mp-input-group__label">PRESIDENTIAL CANDIDATES</label>

                                        <div class="candidates">
                                            <label>Candidate No 1:</label>
                                            <h5>Denneb Gomez</h5>
                                            <div class="profile-img">
                                                <img src="https://scontent.fmnl4-2.fna.fbcdn.net/v/t39.30808-6/333703943_879550633256042_5999893648977274305_n.jpg?_nc_cat=105&ccb=1-7&_nc_sid=09cbfe&_nc_eui2=AeEvDY9Oe-XZrHs-GDUojjSZgyayc5ndww6DJrJzmd3DDv3w58dPBBxi9TKP4f0RndihehBgfuodgKGh3phfTpJz&_nc_ohc=Rala1y4s5KoAX_E8fm3&_nc_ht=scontent.fmnl4-2.fna&oh=00_AfA9i2OQ2TviYLFewh1RsM4Hl-kAgHga0VpODOgsRh1NtQ&oe=640B1A9D" alt="">
                                            </div>

                                            <div class="candidate-button-container">
                                                <div> <button class="up-button-green edit_coll" style="border-radius: 5px;">
                                                        VIEW
                                                        <i style="float:none; margin:0px;" class=" fa fa-eye" aria-hidden="true"></i>

                                                    </button>
                                                </div>
                                                <div>
                                                    <button class="up-button-green edit_coll" style="border-radius: 5px;">
                                                        EDIT
                                                        <i style="float:none; margin:0px;" class=" fa fa-edit" aria-hidden="true"></i>

                                                    </button>
                                                </div>
                                                <div>
                                                    <button class="up-button" style="border-radius: 5px;">
                                                        DELETE
                                                        <i style="float:none; margin:0px;" class="fa fa-trash" aria-hidden="true"></i>

                                                    </button>
                                                </div>

                                            </div>




                                        </div>
                                        <div class="candidates">
                                            <label>Candidate No 2:</label>
                                            <h5>Denneb Gomez</h5>
                                            <div class="profile-img">
                                                <img src="https://scontent.fmnl4-2.fna.fbcdn.net/v/t39.30808-6/333703943_879550633256042_5999893648977274305_n.jpg?_nc_cat=105&ccb=1-7&_nc_sid=09cbfe&_nc_eui2=AeEvDY9Oe-XZrHs-GDUojjSZgyayc5ndww6DJrJzmd3DDv3w58dPBBxi9TKP4f0RndihehBgfuodgKGh3phfTpJz&_nc_ohc=Rala1y4s5KoAX_E8fm3&_nc_ht=scontent.fmnl4-2.fna&oh=00_AfA9i2OQ2TviYLFewh1RsM4Hl-kAgHga0VpODOgsRh1NtQ&oe=640B1A9D" alt="">
                                            </div>

                                            <div class="candidate-button-container">
                                                <div> <button class="up-button-green edit_coll" style="border-radius: 5px;">
                                                        VIEW
                                                        <i style="float:none; margin:0px;" class=" fa fa-eye" aria-hidden="true"></i>

                                                    </button>
                                                </div>
                                                <div>
                                                    <button class="up-button-green edit_coll" style="border-radius: 5px;">
                                                        EDIT
                                                        <i style="float:none; margin:0px;" class=" fa fa-edit" aria-hidden="true"></i>

                                                    </button>
                                                </div>
                                                <div>
                                                    <button class="up-button" style="border-radius: 5px;">
                                                        DELETE
                                                        <i style="float:none; margin:0px;" class="fa fa-trash" aria-hidden="true"></i>

                                                    </button>
                                                </div>

                                            </div>




                                        </div>


                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div> -->




    @endsection