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

    .back-link-style {
        color: black;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .back-link-style:hover {
        color: #484747;

    }

    .back-link-style span:hover {
        color: #484747;
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

    .col-lg-6:nth-child(1) {
        padding-right: 0px;
    }

    .col-lg-6:nth-child(2) {
        padding-left: 0px;
    }

    .padding-content {
        padding-bottom: 1rem;
        padding-top: 1rem;
    }

    @media (max-width:990px) {
        .col-lg-6:nth-child(1) {
            padding-right: 15px;
        }

        .col-lg-6:nth-child(2) {
            padding-left: 15px;
        }

        .padding-content {
            padding-bottom: 5rem;
            padding-top: 5rem;
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

    .info-text {
        display: grid;
    }

    .info-text label {
        margin-bottom: 0px;
        color: #7c7272;
        font-size: 13px;
    }

    .info-text h1 {
        margin-bottom: 0px;
    }

    .info-text-number {
        margin-top: 10px;
        display: inline-grid;
        margin-bottom: 10px;
        color: var(--c-primary);
    }

    .info-text-number label {

        margin: 0px;
    }

    .profile-buttons button {
        width: 100%;
        margin-bottom: 5px;
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

    .employee-detail {
        display: none;
    }

    .employee-detail.open-detail {
        display: grid;
    }

    .bayabas-bg {
        background-color: var(--c-primary);
        color: white;
    }

    .details-div {
        display: inline-grid;
    }

    .details-div .value {
        font-weight: bold;
        ;
    }

    .personal-details-title {
        font-size: 16px;
        background-color: var(--c-accent);
        color: white;
        padding: 10px;
        margin-left: -10px;
        margin-right: -10px;
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
    }

    .tab button {
        margin-right: -5px;
        font-size: 15px;
        padding: 5px 15px 5px 15px;


    }

    .tab button i {
        font-size: 20px;
    }

    .active-tab {
        color: white;
        background-color: var(--c-primary);
    }

    .status-container {
        text-align: center;
        padding: 20px;

    }

    .payroll-table>thead>tr>th {
        min-width: 100px;
    }

    .payroll-table>tbody>tr>td {
        min-width: 100px;
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


    @media (max-width:990px) {
        .payroll-table {
            width: auto;
            min-width: 100%;
        }



    }


    .underline {
        margin-top: auto;
        height: 17.5px;
        width: auto;
        margin-left: 10px;
        border-bottom: 1px solid black;
        flex: 1;
        font-size: 11px;
        color: black;
        font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    }
</style>
<script src="{{ asset('/dist/adminDashboard.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('/dist/loading-bar/loading-bar.css') }}" />
<script type="text/javascript" src="{{ asset('/dist/loading-bar/loading-bar.js') }}"></script>
<script>

</script>
<div class="filler"></div>
<div class="col-12 padding-content mp-text mp-text-c-accent dashboard mh-content">
    <div class="d-flex flex-wrap">
        <div class="col-lg-4 mp-pr0 mp-mt2" style="width: 100%;">
            <div class="mp-card mp-p4 h-auto mp-mb2">
                <div class="container-fluid">
                    <div class="row" style="padding:20px;">
                        <div class="col-lg-5">

                            <div class="profile-img">
                                <img style="width: 100px; height: 100px;" src="https://scontent.fmnl4-2.fna.fbcdn.net/v/t39.30808-6/333703943_879550633256042_5999893648977274305_n.jpg?_nc_cat=105&ccb=1-7&_nc_sid=09cbfe&_nc_eui2=AeEvDY9Oe-XZrHs-GDUojjSZgyayc5ndww6DJrJzmd3DDv3w58dPBBxi9TKP4f0RndihehBgfuodgKGh3phfTpJz&_nc_ohc=Rala1y4s5KoAX_E8fm3&_nc_ht=scontent.fmnl4-2.fna&oh=00_AfA9i2OQ2TviYLFewh1RsM4Hl-kAgHga0VpODOgsRh1NtQ&oe=640B1A9D" alt="">
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="profile-text" style="display: inline-grid;">
                                <span style="font-size: 15px;
                                                                color: black;
                                                                font-weight: bold;">Member Status</span>

                                <span style="   margin-top: -5px;
                                                                    color: var(--c-primary);
                                                                    font-size: 25px;
                                                                    font-weight: 500;"> <?php echo $member->membership_status ?></span>


                                <span style="color: #7c7272;"> Member ID: </span>

                                <span style="font-size: 25px;
                                                                margin-top:-5px;
                                                                color: black;
                                                                font-weight: bold;"><?php echo $member->member_no ?></span>


                            </div>
                            <div style="width: 400px">

                            </div>

                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <div class="info-text">
                                <label class="link_style magenta-clr mp-text-right">Generate SOA</label>
                            </div>
                            <div class="info-text">
                                <h1>{{ $member->last_name }}, {{ $member->first_name }} {{ $member->middle_name}}</h1>
                                <label>{{ $member->campus_name }}</label>
                                <label>{{ $member->position_id }}</label>
                            </div>

                            <div class="info-text-number">

                                <label><i class="fa fa-envelope-o" aria-hidden="true"></i> {{ $member->email }}</label>
                                <label style="float:right;"><i class="fa fa-phone" aria-hidden="true"></i> {{ $member->contact_no }}</label>
                            </div>


                            <br>


                        </div>
                    </div>
                </div>

            </div>
            <div class="mp-card h-auto">
                <div class="container-fluid mp-mt2">
                    <div class="row justify-content-end">
                        <div class="col-12 mp-text-right">
                            <label for="" class="font-bold mp-mb0 magenta-clr">Total Member's Contribution</label>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-12 mp-text-right">
                            <label for="" class="font-bold dashboard-total-title black-clr">PHP {{ number_format($contributions['membercontribution'], 2) }}</label>

                        </div>
                    </div>
                </div>
            </div>
            <div class="mp-card mp-mt2 h-auto">
                <div class="container-fluid mp-mt2">
                    <div class="row justify-content-end">
                        <div class="col-12 mp-text-right">
                            <label for="" class="font-bold mp-mb0 magenta-clr">Earnings on Member's Contribution</label>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-12 mp-text-right">
                            <label for="" class="font-bold dashboard-total-title black-clr">PHP {{ number_format($contributions['emcontribution'], 2) }}</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mp-card mp-mt2 h-auto">
                <div class="container-fluid mp-mt2">
                    <div class="row justify-content-end">
                        <div class="col-12 mp-text-right">
                            <label for="" class="font-bold mp-mb0">Total UP Contribution</label>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-12 mp-text-right">
                            <label for="" class="font-bold dashboard-total-title black-clr">PHP {{ number_format($contributions['upcontribution'], 2) }}</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mp-card mp-mt2 h-auto">
                <div class="container-fluid mp-mt2">
                    <div class="row justify-content-end">
                        <div class="col-12 mp-text-right">
                            <label for="" class="font-bold mp-mb0">Earnings on UP Contribution</label>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-12 mp-text-right">
                            <label for="" class="font-bold dashboard-total-title black-clr">PHP {{ number_format($contributions['eupcontribution'], 2) }}</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mp-card mp-mt2 h-auto magenta-bg">
                <div class="container-fluid mp-mt2">
                    <div class="row justify-content-end">
                        <div class="col-12 mp-text-right">
                            <label for="" class="font-bold mp-mb0">Total Equity Balance</label>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-12 mp-text-right">
                            <label for="" class="font-bold dashboard-total-title">PHP {{ number_format($totalcontributions, 2) }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-8 mp-pr0 mp-mt2 mp-mb4" id="beneficiariesDiv" style="width: 100%;">
            <div style="color: white;
                                            padding: 15px;
                                            background-color: var(--c-accent);
                                            margin: 0;width: 100%;">Benefits Claim

            </div>
            <div class="mp-card mp-p4 h-auto font-xs color-black" style="padding:20px;">
                <div class="container-fluid">
                    <div class="row">
                        Apply for benefits claim
                    </div>
                    <div class="row mp-pv2 mp-mh2">
                        <div class="mp-card ">
                            <div class="container-fluid">
                                <div class="row mp-pv2 mp-ph2 d-flex justify-content-center">
                                    <span>Total Equity as of</span>
                                    <div class="col-5 ">
                                        <input class="mp-input-group__input mp-text-field" type="text" required />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex flex-row justify-content-center gap-10">
                                        <div style="width: 15%" class="mp-text-field mp-text-center d-flex justify-content-end flex-column ">UP Share</div> <span style="color:white">+</span>
                                        <div style="width: 15%" class="mp-text-field mp-text-center d-flex justify-content-end flex-column ">Members Share</div> <span style="color:white">+</span>
                                        <div style="width: 15%" class="mp-text-field mp-text-center d-flex justify-content-end flex-column ">Earnings on UP Contribution</div> <span style="color:white">+</span>
                                        <div style="width: 15%" class="mp-text-field mp-text-center d-flex justify-content-end flex-column ">Earnings on Members Contribution</div><span style="color:white">+</span>
                                        <div style="width: 15%" class="mp-text-field mp-text-center d-flex justify-content-end flex-column ">Final Share this Year</div><span style="color:white">+</span>
                                        <div style="width: 15%" class="mp-text-field mp-text-center d-flex justify-content-end flex-column ">Total</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex flex-row justify-content-center gap-10">
                                        <div style="width: 15%"><input value="{{$contributions['upcontribution'] }}" class="mp-input-group__input mp-text-field mp-text-right" type="text" required /></div> +
                                        <div style="width: 15%"><input value="{{$contributions['membercontribution'] }}" class="mp-input-group__input mp-text-field mp-text-right" type="text" required /></div> +
                                        <div style="width: 15%"><input value="{{$contributions['eupcontribution']}}" class="mp-input-group__input mp-text-field mp-text-right" type="text" required /></div> +
                                        <div style="width: 15%"><input value="{{$contributions['emcontribution']}}" class="mp-input-group__input mp-text-field mp-text-right" type="text" required /></div> +
                                        <div style="width: 15%"><input class="mp-input-group__input mp-text-field mp-text-right" type="text" required /></div> =
                                        <div style="width: 15%"><input class="mp-input-group__input mp-text-field mp-text-right" type="text" required /></div>
                                    </div>
                                </div>
                                <div class="row mp-pb2">
                                    <div class="col-12 d-flex flex-row gap-10">
                                        <div style="width: 15%" class=" mp-text-center">Equity</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="row mp-pv2 mp-ph2 d-flex justify-content-center">
                                <span>COMPUTATION</span>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    Total Member's Share
                                </div>
                                <div class="col-4"></div>
                                <div class="col-4">
                                    <div class="row">
                                        Php <div class="underline col-5">asd</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mp-mb2">
                                <div class="col-4">
                                    Total UP Share
                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        Php <div class="underline col-5">asd</div>
                                    </div>
                                </div>
                                <div class="col-4"></div>
                            </div>
                            <div class="row gap-5 mp-mb2">
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-4">
                                            <span>
                                                Months of Service with UP:
                                            </span>
                                        </div>
                                        <div class="col-2 d-flex align-content-end">
                                            <div class="underline col-5 mp-text-center d-flex justify-content-center">0</div>
                                        </div>
                                        <div class="col-4 d-flex align-items-end">
                                            Percentage:
                                        </div>
                                        <div class="col-2 d-flex align-items-end">
                                            <span>
                                                0%
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mp-mb2">
                                <div class="col-4">
                                    Proceeds After Vesting Rights
                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        Php <div class="underline col-5">asd</div>
                                    </div>
                                </div>
                                <div class="col-4"></div>
                            </div>
                            <div class="row mp-mb2">
                                <div class="col-4">
                                    10% Withholding Tax
                                </div>
                                <div class="col-4" style="color:white">
                                    <div class="row">
                                        Php <div class="underline col-5 color-black"></div>
                                    </div>
                                </div>
                                <div class="col-4"></div>
                            </div>
                            <div class="row mp-mb2">
                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-6">
                                            General Reserve
                                        </div>
                                        <div class="col-6 d-flex align-content-end">
                                            <div class="underline mp-text-center d-flex justify-content-center align-cio">100</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">

                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        Php <div class="underline col-5 color-black"></div>
                                    </div>

                                </div>
                            </div>
                            <div class="row mp-mb2">
                                <div class="col-4 font-bold">
                                    Earnings
                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        Php <div class="underline col-5">asd</div>
                                    </div>
                                </div>
                                <div class="col-4"></div>
                            </div>
                            <div class="row mp-mb2">
                                <div class="col-4 font-bold">
                                    Due to Member
                                </div>
                                <div class="col-4">
                                    <div class="row" style="color: white">
                                        Php <div class="underline col-5 black-color">asd</div>
                                    </div>
                                </div>
                                <div class="col-4"></div>
                            </div>
                            <div class="row mp-mb2">
                                <div class="col-4">
                                    10% Withholding Tax
                                </div>
                                <div class="col-4">
                                    <div class="row" style="color: white">
                                        Php <div class="underline col-5 black-color">asd</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row" style="color:white">
                                        Php <div class="underline col-5 black-color">asd</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 font-bold">
                                    Patronage Refund
                                </div>
                            </div>
                            <div class="row mp-mb2">
                                <div class="col-4">
                                    Total Interest Payment this Year
                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        Php <div class="underline col-5 black-color">asd</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row" style="color:white">
                                        X5% <div class="underline col-5 black-color">asd</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mp-mb2">
                                <div class="col-4 font-bold">
                                    Total
                                </div>
                                <div class="col-4">
                                </div>
                                <div class="col-4">
                                    <div class="row" style="color:white">
                                        X5% <div class="underline col-5 black-color">asd</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mp-mb2">
                                <div class="col-4 font-bold">
                                    <div class="row">
                                        <div class="col-6">
                                            Less
                                        </div>
                                        <div class="col-6">
                                            Outstanding Loan:
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                </div>
                                <div class="col-4">
                                </div>
                            </div>
                            <div class="row mp-mb2">
                                <div class="col-4">
                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        Php <div class="underline col-5 black-color"></div>
                                    </div>
                                </div>
                                <div class="col-4">
                                </div>
                            </div>
                            <div class="row mp-mb2">
                                <div class="col-4">
                                </div>
                                <div class="col-4">
                                    <div class="row" style="color: white">
                                        Php <div class="underline col-5 black-color"></div>
                                    </div>
                                </div>
                                <div class="col-4">
                                </div>
                            </div>
                            <div class="row mp-mb2">
                                <div class="col-4">
                                </div>
                                <div class="col-4">
                                    <div class="row" style="color: white">
                                        Php <div class="underline col-5 black-color"></div>
                                    </div>
                                </div>
                                <div class="col-4">
                                </div>
                            </div>
                            <div class="row mp-mb2">
                                <div class="col-4">
                                </div>
                                <div class="col-4">
                                    <div class="row" style="color: white">
                                        Php <div class="underline col-5 black-color"></div>
                                    </div>
                                </div>
                                <div class="col-4">
                                </div>
                            </div>
                            <div class="row mp-mb2">
                                <div class="col-4">
                                </div>
                                <div class="col-4">
                                    <div class="row" style="color: white">
                                        Php <div class="underline col-5 black-color"></div>
                                    </div>
                                </div>
                                <div class="col-4">
                                </div>
                            </div>
                            <div class="row mp-mb2">
                                <div class="col-4">
                                </div>
                                <div class="col-4">
                                    <div class="row" style="color: white">
                                        Php <div class="underline col-5 black-color"></div>
                                    </div>
                                </div>
                                <div class="col-4">
                                </div>
                            </div>
                            <div class="row mp-mb2">
                                <div class="col-4">
                                </div>
                                <div class="col-4">
                                    <div class="row" style="color: white">
                                        Php <div class="underline col-5 black-color"></div>
                                    </div>
                                </div>
                                <div class="col-4">
                                </div>
                            </div>
                            <div class="row mp-mb2">
                                <div class="col-4">
                                </div>
                                <div class="col-4">
                                    <div class="row" style="color: white">
                                        Php <div class="underline col-5 black-color"></div>
                                    </div>
                                </div>
                                <div class="col-4">
                                </div>
                            </div>
                            <div class="row mp-mb2">
                                <div class="col-4">
                                </div>
                                <div class="col-4">
                                    <div class="row" style="color: white">
                                        Php <div class="underline col-5 black-color"></div>
                                    </div>
                                </div>
                                <div class="col-4">
                                </div>
                            </div>
                            <div class="row mp-mb2">
                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-6">

                                        </div>
                                        <div class="col-6">
                                            Service Fee
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row" style="color: white">
                                        Php <div class="underline col-5 black-color">200</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row" style="color: white">
                                        Php <div class="underline col-5 black-color">200</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 font-bold">
                                    Net Proceeds
                                </div>
                                <div class="col-4"></div>
                                <div class="col-4">
                                    <div class="row">
                                        Php <div class="underline col-5">200</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mp-mh2">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 mp-card magenta-bg mp-ph2 font-md">
                                    Requirements
                                </div>
                            </div>
                            <div class="row mp-mh2">
                                <div class="col-12">
                                    <div class="mp-input-group">
                                        <label class="mp-input-group__label">Upload Requirements</label>
                                        <input style="height: 40px;border: none;" type="file" class="mp-input-group__input mp-text-field radius-1 border-1 date-input outline" style=" height: 30px;">
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <button style="border-radius: 8px" class="font-bold font-md color-white magenta-bg mp-ph1 mp-pv4 ">Apply Benefits Claim</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

</script>
@endsection