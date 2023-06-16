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
</style>
<script src="{{ asset('/dist/adminDashboard.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('/dist/loading-bar/loading-bar.css') }}" />
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
        console.log('123')
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

    const links = [
        'new-members',
        '',
        'summary-reports',
        'contribution-reports',
        'insurance-reports',
        'voter-list'
    ]

    $(document).on('click', '#sider-item', function(e) {
        const dataSet = $(this).attr('data-set')
        window.location.href = '/admin/members/' + links[dataSet]
    })
</script>
<div class="filler"></div>
<div class="col-12 padding-content mp-text mp-text-c-accent dashboard mh-content">
    <div class="d-flex flex-wrap">
        <div class="col-lg-5 mp-pr0 mp-mt2" style="width: 100%;">
            <div class="mp-card mp-p4 h-auto mp-mb2">
                <div class="container-fluid">
                    <div class="row" style="padding:20px;">
                        <div class="col-lg-5">

                            <div class="profile-img">
                                <img style="width: 100px; height: 100px;" src="{!! asset('assets/images/user-default.png') !!}" alt="">
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

                            <div class="profile-buttons  col-12 mp-mt2">
                                <button class="up-button btn-md button-animate-right mp-text-center" id="view_profile" type="button">
                                    <span>View Profile</span>
                                </button>
                                <button class="up-button-green btn-md button-animate-right mp-text-center" id="view_beneficiaries" type="button">
                                    <span>View Beneficiaries</span>
                                </button>
                                <!-- <button class="up-button btn-md button-animate-right mp-text-center" id="modify_contributions" type="button">
                                                        <span>Modify Contributions</span>
                                                    </button> -->
                                <button class="up-button-grey btn-md button-animate-right mp-text-center" id="view_password">
                                    <span>Change Password</span>
                                </button>
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
                            <label for="" class="font-bold dashboard-total-title black-clr">Php 100,100.00</label>

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
                            <label for="" class="font-bold dashboard-total-title black-clr">Php 100,100.00</label>
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
                            <label for="" class="font-bold dashboard-total-title black-clr">Php 100,100.00</label>
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
                            <label for="" class="font-bold dashboard-total-title black-clr">Php 100,100.00</label>
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
                            <label for="" class="font-bold dashboard-total-title">Php 100,100.00</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-7 mp-pr0 mp-mt2 " id="statementDiv" style="width: 100%;">
            <div class="row mp-mb2">
                <div class="col-md-12">
                    <div class="mp-card h-auto">
                        <div class="container-fluid mp-mt2">
                            <div class="row">
                                <div class="col-4 mp-pl5 font-bold">
                                    <label for="" class="mp-dashboard__title">PEL</label>
                                </div>
                                <div class="col-8">
                                    <div class="row justify-content-end">
                                        <div class="col-12 mp-text-right">
                                            <label for="" class="font-bold mp-mb0 magenta-clr">Loan Balance</label>
                                        </div>
                                    </div>
                                    <div class="row justify-content-end">
                                        <div class="col-12 mp-text-right">
                                            <label for="" class="font-bold dashboard-total-title black-clr">Php 100,100.00</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mp-card mp-mt2 h-auto">
                        <div class="container-fluid mp-mt2">
                            <div class="row">
                                <div class="col-4 mp-pl5 font-bold">
                                    <label for="" class="mp-dashboard__title">CBL</label>
                                </div>
                                <div class="col-8">
                                    <div class="row justify-content-end">
                                        <div class="col-12 mp-text-right">
                                            <label for="" class="font-bold mp-mb0 magenta-clr">Loan Balance</label>
                                        </div>
                                    </div>
                                    <div class="row justify-content-end">
                                        <div class="col-12 mp-text-right">
                                            <label for="" class="font-bold dashboard-total-title black-clr">Php 100,100.00</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mp-card mp-mt2 h-auto">
                        <div class="container-fluid mp-mt2">
                            <div class="row">
                                <div class="col-4 mp-pl5 font-bold">
                                    <label for="" class="mp-dashboard__title">EML</label>
                                </div>
                                <div class="col-8">
                                    <div class="row justify-content-end">
                                        <div class="col-12 mp-text-right">
                                            <label for="" class="font-bold mp-mb0 magenta-clr">Loan Balance</label>
                                        </div>
                                    </div>
                                    <div class="row justify-content-end">
                                        <div class="col-12 mp-text-right">
                                            <label for="" class="font-bold dashboard-total-title black-clr">Php 100,100.00</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mp-card mp-mt2 h-auto magenta-bg">
                        <div class="container-fluid mp-mt2">
                            <div class="row justify-content-end">
                                <div class="col-12 mp-text-right">
                                    <label for="" class="font-bold mp-mb0">Your Outstanding Loan</label>
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <div class="col-12 mp-text-right">
                                    <label for="" class="font-bold dashboard-total-title">Php 100,100.00</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="right-dashboard col grid side-dashboard gap-10 font-sm card mp-mb2" style="color: black;">
                <div class="text-center d-flex flex-column justify-content-center">
                    <div>
                        <span class="font-bold font-lg magenta-clr" id="new_app">0</span>
                    </div>
                    <span class="font-sm">New Loan Application</span>
                </div>
                <div class="text-center d-flex flex-column justify-content-center">
                    <div>
                        <span class="font-bold font-lg magenta-clr" id="forApproval">0</span>
                    </div>
                    <span class="font-sm">Processing Loan Application</span>
                </div>
                <div class="text-center d-flex flex-column justify-content-center">
                    <div>
                        <span class="font-bold font-lg magenta-clr" id="draft">0</span>
                    </div>
                    <span class="font-sm">Approved Loan Application</span>
                </div>
                <div class="text-center d-flex flex-column justify-content-center">
                    <div>
                        <span class="font-bold font-lg magenta-clr" id="rejected">0</span>
                    </div>
                    <span class="font-sm ">Rejected Loan Application</span>
                </div>
            </div>

            <div class="mp-card mp-p4 h-auto" style="padding:20px;">

                <!-- <div style="color: white;
                                            padding: 15px;
                                            background-color: var(--c-active-hover-bg);
                                            margin: 0;width: 100%;">Statement of Account
                                        <div class="info-text">
                                            <label style="color:white;">As of: May 6, 1999 - 10:00pm</label>
                                        </div>
                                    </div> -->


                <!-- <div class="row">
                                        <div class="col-lg-6" >
                                            <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3 member-form mp-pv2 shadow-inset-1">
                                                <h3>Your Members Equity</h3>
                                                <div class="mp-input-group details-div">
                                                    <label class="mp-input-group__label">Total Members Contribution</label>
                                                    <label class="mp-input-group__label value">PHP 100,000.00</label>
                                                </div>
                                                <div class="mp-input-group details-div">
                                                    <label class="mp-input-group__label">Total UP Contribution</label>
                                                    <label class="mp-input-group__label value">PHP 100,000.00</label>
                                                </div>
                                                <div class="mp-input-group details-div">
                                                    <label class="mp-input-group__label">Earnings on Members Contribution</label>
                                                    <label class="mp-input-group__label value">PHP 100,000.00</label>
                                                </div>
                                                <div class="mp-input-group details-div">
                                                    <label class="mp-input-group__label">Earnings on UP Contribution</label>
                                                    <label class="mp-input-group__label value">PHP 100,000.00</label>
                                                </div>

                                                <div class="mp-input-group details-div">
                                                    <label class="mp-input-group__label">Total Equity Balance</label>
                                                    <label class="mp-input-group__label value">PHP 400,000.00</label>
                                                </div>
                                                <div class="mp-input-group details-div">
                                                    <label class="mp-input-group__label">
                                                        Total Equity Balance
                                                    </label>
                                                    <label class="mp-input-group__label value">
                                                        <h2>PHP 600,000.00</h3>
                                                    </label>
                                                </div>


                                            </div>
                                        </div>
                                        <div class="col-lg-6" >
                                            <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3 member-form mp-pv2 shadow-inset-1" style="height: 100%;">
                                                <h3>Your Outstanding Loan</h3>
                                                <div class="mp-input-group details-div">
                                                    <label class="mp-input-group__label">PEL</label>
                                                    <label class="mp-input-group__label value">PHP 100,000.00</label>
                                                </div>

                                                <div class="mp-input-group details-div">
                                                    <label class="mp-input-group__label">
                                                        Total Outstanding Loan Balance
                                                    </label>
                                                    <label class="mp-input-group__label value">
                                                        <h2>PHP 200,000.00</h3>
                                                    </label>
                                                </div>


                                            </div>
                                        </div>
                                    </div> -->
                <div class="row">
                    <div class="col-12">
                        <div class="info-text">
                            <label class="black-clr font-bold">Monthly Contribution: Php 150,000.00</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="info-text">
                            <label class="black-clr font-bold">PEL Monthly Payment: Php 150,000.00</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>
                </div>

                <div class="row" style="overflow-y: auto;">
                    <div class="col-1g-12" style="padding:15px;">
                        <div class="d-flex flex-column">
                            <div class="header-table">
                                <h3>Member's Equity History</h3>
                                <div class="info-text">
                                    <label style="margin-top: -13px;margin-bottom: 10px;">Recent Transaction</label>
                                </div>
                                <div class="info-text">
                                    <label style="margin-top: -13px;margin-bottom: 10px;">As of: May 6, 1999 - 10:00pm</label>
                                </div>
                                <div class="info-text">
                                    <label class="link_style magenta-clr mp-text-right">View All</label>
                                </div>
                                <table class="payroll-table" style="height: auto;" width="100%">
                                    <thead>
                                        <tr>
                                            <th>
                                                <span>Date</span>
                                            </th>
                                            <th>
                                                <span>Transaction</span>
                                            </th>
                                            <th>
                                                <span>Account</span>
                                            </th>
                                            <th>
                                                <span>Debit</span>
                                            </th>
                                            <th>
                                                <span>Credit</span>
                                            </th>
                                            <th>
                                                <span>Balance</span>
                                            </th>

                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="body-table">
                                <table class="payroll-table" style="height: auto;" width="100%">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <span>May 6, 1999</span>
                                            </td>
                                            <td>
                                                <span>OR#210312</span>
                                            </td>
                                            <td>
                                                <span>Member Contribution</span>
                                            </td>
                                            <td>
                                                <span>PHP 655 </span>
                                            </td>
                                            <td>
                                                <span>PHP 123</span>
                                            </td>
                                            <td>
                                                <span>PHP 123,123 </span>
                                            </td>

                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row" style="overflow-y: auto;">
                    <div class="col-1g-12" style="padding:15px;">
                        <div class="d-flex flex-column">
                            <div class="header-table">
                                <h3>Loan Transaction History</h3>
                                <div class="info-text">
                                    <label style="margin-top: -13px;margin-bottom: 10px;">Recent Transaction</label>
                                </div>
                                <div class="info-text">
                                    <label style="margin-top: -13px;margin-bottom: 10px;">As of: May 6, 1999 - 10:00pm</label>
                                </div>
                                <div class="info-text">
                                    <label class="link_style magenta-clr mp-text-right">View All</label>
                                </div>
                                <table class="payroll-table" style="height: auto;" width="100%">
                                    <thead>
                                        <tr>
                                            <th>
                                                <span>Date</span>
                                            </th>
                                            <th>
                                                <span>Transaction</span>
                                            </th>
                                            <th>
                                                <span>Account</span>
                                            </th>
                                            <th>
                                                <span>Monthly Amortization</span>
                                            </th>
                                            <th>
                                                <span>interest</span>
                                            </th>


                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="body-table">
                                <table class="payroll-table" style="height: auto;" width="100%">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <span>May 6, 1999</span>
                                            </td>
                                            <td>
                                                <span>OR#210312</span>
                                            </td>
                                            <td>
                                                <span>PEL</span>
                                            </td>
                                            <td>
                                                <span>PHP -655 </span>
                                            </td>
                                            <td>
                                                <span>PHP -123</span>
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
        <div class="col-lg-7 mp-pr0 mp-mt2 d-none opacity-0" id="beneficiariesDiv" style="width: 100%;">
            <button class="up-button btn-md button-animate-left  hover-back mp-mb2" id="back" value="">
                <span>Back</span>
            </button>
            <div style="color: white;
                                            padding: 15px;
                                            background-color: var(--c-accent);
                                            margin: 0;width: 100%;">Add New Beneficiaries

            </div>
            <div class="mp-card mp-p4 h-auto" style="padding:20px;">

                <form id="users_form" class=" form-border-bottom">

                    <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3  mp-pv2 ">
                        <input type="hidden" id="users_id" name="users_id">
                        <!-- <label class="mp-text-fs-medium">Personal Information</label> -->
                        <div class="mp-input-group">
                            <label class="mp-input-group__label">Full Name</label>
                            <input class="mp-input-group__input mp-text-field" type="text" name="beneficiary-name" id="beneficiary-name" required />
                        </div>
                        <div class="mp-input-group">
                            <label class="mp-input-group__label">Relationship</label>
                            <input class="mp-input-group__input mp-text-field" type="text" name="beneficiary-relationship" id="beneficiary-relationship" required />
                        </div>
                        <div class="mp-input-group">
                            <label class="mp-input-group__label">Birthdate</label>
                            <input class="mp-input-group__input mp-text-field" type="date" name="beneficiary-birthday" id="beneficiary-birthday" required />
                        </div>

                        <a class="up-button btn-md button-animate-right mp-text-center" id="add-new-beneficiary" name="add-new-beneficiary" type="submit">
                            <span class="save_up">Add New Record</span>
                        </a>
                        <a class="up-button-grey btn-md button-animate-right mp-text-center" id="clear_beneficiaries">
                            <span class="clear_txt">Clear</span>
                        </a>
                        <!-- <button type="submit" class="sss" id="btn-submit">Submit</button> -->

                    </div>

                </form>
                <br>
                <div class="mp-input-group">
                    <label class="mp-input-group__label">Beneficiaries Records</label>
                    <table class="beneficiaries permission-table" id="beneficiaries-table" style="transform: scale(1); border: 0">
                        <thead>
                            <tr>

                                <th>FULL NAME</th>
                                <th>BIRTHDATE</th>
                                <th>RELATIONSHIP</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>




                    </table>

                </div>
            </div>
        </div>



        <div class="col-lg-7 mp-pr0 mp-mt2 d-none opacity-0" id="memberstatusDiv" style="width: 100%;">
            <button class="up-button btn-md button-animate-left  hover-back mp-mb2" id="back" value="">
                <span>Back</span>
            </button>
            <div style="color: white;
                                            padding: 15px;
                                            background-color: var(--c-accent);
                                            margin: 0;width: 100%;">My Profile

            </div>
            <div class="container-fluid mp-card mp-p4 h-auto">
                <div class="row mp-mh3">
                    <div class="col-12 mp-mb2">
                        <div class="tab-component">
                            <div class="header-tabs">
                                <span class="active relative" data-set="0">
                                    Employee and Personal Details
                                </span>
                                <span class="relative " data-set="1">
                                    Membership Details
                                    <!-- <div class="notification">3</div> -->
                                </span>
                                <span class="relative" data-set="2">
                                    File Attachment
                                    <!-- <div class="notification">3</div> -->
                                </span>
                            </div>
                            <div class="tab-body bg-white" data-set="0">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-11 mp-mvauto">
                                                    <div class="mp-input-group">
                                                        <label class="mp-input-group__label">First Name</label>

                                                        <input class="mp-input-group__input mp-text-field" type="text" name="first_name" id="first_name" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-11 mp-mvauto">
                                                    <div class="mp-input-group">
                                                        <label class="mp-input-group__label">Middle Name</label>
                                                        <input class="mp-input-group__input mp-text-field" type="text" name="middle_name" id="middle_name" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-11 mp-mvauto">
                                                    <div class="mp-input-group">
                                                        <label class="mp-input-group__label">Last Name</label>
                                                        <input class="mp-input-group__input mp-text-field" type="text" name="last_name" id="last_name" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-11 mp-mvauto">
                                                    <div class="mp-input-group">
                                                        <label class="mp-input-group__label">Campus</label>
                                                        <select disabled class="mp-input-group__input mp-text-field" name="campus" id="campus" required>
                                                            <option value="">Select Campus</option>
                                                            @foreach ($campuses as $row)
                                                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-11 mp-mvauto">
                                                    <div class="mp-input-group">
                                                        <label class="mp-input-group__label">Department</label>
                                                        <select disabled class="mp-input-group__input mp-text-field" name="department" id="department" required>
                                                            <option value="">Select Department</option>
                                                            @foreach ($department as $row)
                                                            <option value="{{ $row->dept_no }}">{{ $row->department_name }}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-11 mp-mvauto">
                                                    <div class="mp-input-group">
                                                        <label class="mp-input-group__label">Position</label>
                                                        <input class="mp-input-group__input mp-text-field" type="text" name="position" id="position" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-11 mp-mvauto">
                                                    <div class="mp-input-group">
                                                        <label class="mp-input-group__label">Appointment Date</label>
                                                        <input disabled class="mp-input-group__input mp-text-field" type="date" name="appointment_date" id="appointment_date" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-11 mp-mvauto">
                                                    <div class="mp-input-group">
                                                        <label class="mp-input-group__label">Membership Date</label>
                                                        <input disabled class="mp-input-group__input mp-text-field" type="date" name="membership_date" id="membership_date" />

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-11 mp-mvauto">
                                                    <div class="mp-input-group">
                                                        <label class="mp-input-group__label">Cellphone Number</label>
                                                        <input class="mp-input-group__input mp-text-field" type="text" name="contact_no" id="contact_no" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-11 mp-mvauto">
                                                    <div class="mp-input-group">
                                                        <label class="mp-input-group__label">Landline Number</label>
                                                        <input class="mp-input-group__input mp-text-field" type="text" name="landline_no" id="landline_no" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-11 mp-mvauto">
                                                    <div class="mp-input-group">
                                                        <label class="mp-input-group__label">Gender</label>
                                                        <select disabled class="mp-input-group__input mp-text-field w-100" name="gender" id="gender" required>
                                                            <option value="0">Select Gender</option>
                                                            <option value="1">Female</option>
                                                            <option value="2">Male</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-11 mp-mvauto">
                                                    <div class="mp-input-group">
                                                        <label class="mp-input-group__label">Employee Number</label>
                                                        <input class="mp-input-group__input mp-text-field" type="text" name="employee_no" id="employee_no" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-11 mp-mvauto">
                                                    <div class="mp-input-group">
                                                        <label class="mp-input-group__label">Status Appointment</label>
                                                        <select disabled class="mp-input-group__input mp-text-field" name="status" id="status" required>
                                                            <option value="">Select Status</option>
                                                            <option value="PERMANENT">PERMANENT</option>
                                                            <option value="CONTRACTUAL">CONTRACTUAL</option>
                                                            <option value="TEMPORARY">TEMPORARY</option>
                                                            <option value="JOB ORDER">JOB ORDER</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-11 mp-mvauto">
                                                    <div class="mp-input-group">
                                                        <label class="mp-input-group__label">Permanent Address</label>
                                                        <input class="mp-input-group__input mp-text-field" type="text" name="permanent_address" id="permanent_address" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-11 mp-mvauto">
                                                    <div class="mp-input-group">
                                                        <label class="mp-input-group__label">Current Address</label>
                                                        <input class="mp-input-group__input mp-text-field" type="text" name="current_address" id="current_address" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-11 mp-mvauto">
                                                    <div class="mp-input-group">
                                                        <label class="mp-input-group__label">Tin</label>
                                                        <input class="mp-input-group__input mp-text-field" type="text" name="tin_no" id="tin_no" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-11 mp-mvauto">
                                                    <div class="mp-input-group">
                                                        <label class="mp-input-group__label">Birthdate</label>
                                                        <input disabled class="mp-input-group__input mp-text-field" type="date" name="birthday" id="birthday" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-11 mp-mvauto">
                                                    <div class="mp-input-group">
                                                        <label class="mp-input-group__label">Email</label>
                                                        <input class="mp-input-group__input mp-text-field" type="email" name="email" id="email" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-11 mp-mvauto">
                                                    <a class="up-button btn-md mp-text-center w-100 mp-mt2" id="update_record" name="update_record" type="submit">
                                                        <span class="save_up">Update Record</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                            </div>
                            <div class="tab-body bg-white d-none" data-set="1">
                                <div class="container-fluid">
                                    <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3  mp-pv2 row">
                                        <input type="hidden" id="users_id" name="users_id">
                                        <!-- <label class="mp-text-fs-medium">Personal Information</label> -->
                                        <label class="mp-input-group__label">Membership Contribution Type</label>
                                        <select class="mp-input-group__input mp-text-field" name="contribution_type" id="contribution_type" required>
                                            @if ($member->contribution_type == "FIXED")
                                            <option value="FIXED" selected>FIXED</option>
                                            @else
                                            <option value="FIXED">FIXED</option>
                                            @endif

                                            @if ($member->contribution_type == "PERCENTAGE")
                                            <option value="PERCENTAGE" selected>PERCENTAGE</option>
                                            @else
                                            <option value="PERCENTAGE">PERCENTAGE</option>
                                            @endif
                                        </select>
                                        <div class="mp-input-group">
                                            <label class="mp-input-group__label">Monthly Contribution</label>
                                            <input value="{{$member->contribution}}" class="mp-input-group__input mp-text-field" type="{{$member->contribution_type == 'PERCENTAGE' ? 'number' : 'text'}}" name="contribution" id="firstname" required />
                                        </div>
                                        <!-- <div class="mp-input-group">
                                                                <label class="mp-input-group__label">Equivalent Value</label>
                                                                <input disabled value="{{$member->contribution_type == 'PERCENTAGE' ? $member->monthly_salary * (0.01 * $member->contribution) : $member->contribution}}" class="mp-input-group__input mp-text-field" type="text" name="middlename" id="middlename" required />
                                                            </div> -->
                                        <div class="input-group">
                                            <label class="mp-input-group__label">Cocolife Insurance</label>
                                            <select class="mp-input-group__input mp-text-field" name="with_cocolife_form" id="with_cocolife_form" required>
                                                @if ($member->with_cocolife_form == 1)
                                                <option value="1" selected>Yes</option>
                                                @else
                                                <option value="1">Yes</option>
                                                @endif

                                                @if ($member->with_cocolife_form == 0)
                                                <option value="0" selected>NO</option>
                                                @else
                                                <option value="0">NO</option>
                                                @endif
                                            </select>
                                        </div>
                                        <a class="up-button btn-md mp-text-center mp-mt3" id="update_membership" name="update_membership" type="submit">
                                            <span class="save_up">Update Record</span>
                                        </a>
                                        <!-- <button type="submit" class="sss" id="btn-submit">Submit</button> -->

                                    </div>
                                </div>
                            </div>
                            <div class="tab-body bg-white d-none" data-set="2">
                                <div class="tab-item">
                                    <div class="d-flex flex-column">
                                        <span class="mp-text-fs-small">
                                            Membership Form
                                        </span>
                                        <span class="mp-text-fw-medium">
                                            <a href="javascript:void(0)" onclick="window.open('{{ URL::to('/memberform/') }}/{{ $member->employee_no }}', 'targetWindow', 'resizable=yes,width=1000,height=1000');" class='view_member view-member' style='cursor: pointer; padding: 0'>
                                                <span class="mp-link link_style">View Membership form</span>
                                            </a>
                                        </span>
                                        <span>
                                            <input type="file" class="mp-mt2" style="font-size: 12px">
                                        </span>
                                    </div>
                                </div>
                                <div class="tab-item">
                                    <div class="d-flex flex-column">
                                        <span class="mp-text-fs-small">
                                            Proxy Form
                                        </span>
                                        <span class="mp-text-fw-medium">
                                            <a onclick="window.open('{{ URL::to('/generateProxyForm/') }}/{{ $member->app_no }}', 'targetWindow', 'resizable=yes,width=1000,height=1000');" class='view_member view-member' style='cursor: pointer; padding: 0'>
                                                <span class="mp-link link_style">View Proxy form</span>
                                            </a>
                                        </span>
                                        <span>
                                            <input type="file" class="mp-mt2" style="font-size: 12px">
                                        </span>
                                    </div>
                                </div>
                                <div class="w-full">
                                    <div class="col-lg-5 mp-mvauto">
                                        <a class="up-button btn-md mp-text-center w-100 mp-mt2" id="save_users" name="save_users" type="submit">
                                            <span class="save_up">Update Record</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-7 mp-pr0 mp-mt2 d-none opacity-0" id="resetPasswordDiv" style="width: 100%;">
            <button class="up-button btn-md button-animate-left  hover-back mp-mb2" id="back" value="">
                <span>Back</span>
            </button>
            <div style="color: white;
                                            padding: 15px;
                                            background-color: var(--c-accent);
                                            margin: 0;width: 100%;">Reset Password

            </div>
            <div class="mp-card mp-p4 h-auto" style="padding:20px;">

                <form id="users_form" class=" form-border-bottom">

                    <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3  mp-pv2 ">
                        <input type="hidden" id="users_id" name="users_id">
                        <!-- <label class="mp-text-fs-medium">Personal Information</label> -->
                        <div class="mp-input-group">
                            <label class="mp-input-group__label">Password</label>
                            <input class="mp-input-group__input mp-text-field" type="text" name="password" id="password" required />
                        </div>
                        <div class="mp-input-group">
                            <label class="mp-input-group__label">New Password</label>
                            <input class="mp-input-group__input mp-text-field" type="text" name="new-password" id="new-password" required />
                        </div>
                        <div class="mp-input-group">
                            <label class="mp-input-group__label">Confirm Password</label>
                            <input class="mp-input-group__input mp-text-field" type="text" name="confirm-password" id="confirm-password" required />
                        </div>

                        <a class="up-button btn-md mp-text-center" id="change-password" name="change-password" type="submit">
                            <span class="save_up">Update Password</span>
                        </a>
                        <!-- <button type="submit" class="sss" id="btn-submit">Submit</button> -->

                    </div>

                </form>
            </div>

        </div>

    </div>
</div>
<script>
    function setActiveTab(tab) {
        const index = $(tab).attr("data-set")
        $('.header-tabs>span').map(function() {
            const dataSet = $(this).attr("data-set")
            if (dataSet == index) {
                $(this).addClass('active')
                return
            }
            $(this).removeClass('active')
        })
        $('.tab-body').map(function() {
            const dataSet = $(this).attr("data-set")
            if (dataSet == index) {
                $(this).removeClass('d-none')
                return
            }
            $(this).addClass('d-none')
        })

    }


    function clearBeneValidation() {
        clearValidation('beneficiary-name', 'bene_validation', $('[name=beneficiary-name]'))
        clearValidation('beneficiary-birthday', 'bene_validation', $('[name=beneficiary-birthday]'))
        clearValidation('beneficiary-relationship', 'bene_validation', $('[name=beneficiary-relationship]'))
    }

    function resetBeneficiaryForm() {
        $('#beneficiary-name').val('').trigger("change");
        $('#beneficiary-birthday').val('').trigger("change");
        $('#beneficiary-relationship').val('').trigger("change");
        clearBeneValidation();
    }

    $(document).ready(function() {
        console.log(JSON.parse("{{$member}}".replace(/&quot;/g, '"')))
    })

    //clear beneficiaries click
    $(document).on('click', '#clear_beneficiaries', function() {
        resetBeneficiaryForm();
    })

    //old beneficiaries delete clicked
    $(document).on('click', '#delete_beneficiaries', function() {
        var id = $('#delete_beneficiaries').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        Swal.fire({
            title: "Are you sure?",
            text: "You will delete this beneficiary!",
            icon: "question",
            confirmButtonColor: '#1a8981',
            confirmButtonText: 'Confirm',
            cancelButtonText: "Cancel",
            allowOutsideClick: false,
            allowEscapeKey: false,
            showCancelButton: true,
        }).then((okay) => {
            if (okay.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('delete_member_oldbeneficiaries') }}",
                    data: {
                        beneficiary_id: id,
                    },
                    success: function(data) {
                        console.log(data)
                        if (data.success == true) {
                            clearBeneValidation();
                            memberBeneficiaries.draw();
                        }
                    }
                });
            } else if (okay.isDenied) {
                Swal.close();
            }
        });

    });








    var memberBeneficiaries = $('#beneficiaries-table').DataTable({
        ordering: false,
        info: false,
        searching: false,
        paging: false,
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('get_member_beneficiary') }}",
            data: function(d) {
                d.member_no = <?php echo $member->member_no ?>
            }
        },
        columns: [{
                data: 'beni_name',
                name: 'beni_name'
            },
            {
                data: 'birth_date',
                name: 'birth_date'
            },
            {
                data: 'relationship',
                name: 'relationship'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    });

    function getBeneficiaries() {
        memberBeneficiaries.draw();
    }

    //update member details click
    $(document).on('click', '#update_record', function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var user_id = <?php echo $member->user_id ?>;
        var member_no = <?php echo $member->member_no ?>;

        var first_name = $('input[name=first_name]').val()
        var last_name = $('input[name=last_name]').val()
        var middle_name = $('input[name=middle_name]').val()
        // var sample = $('select[name=campus]').val()
        // var sample = $('select[name=department]').val()
        var position_id = $('input[name=position]').val()
        var appointment_date = "{{$member->original_appointment_date}}"
        var membership_date = "{{$member->membership_date}}"
        var contact_no = $('input[name=contact_no]').val()
        var landline = $('input[name=landline_no]').val()
        var gender = "{{$member->gender}}"

        var employee_no = "{{$member->employee_no}}"
        var current_address = $('input[name=current_address]').val()
        var permanent_address = $('input[name=permanent_address]').val()
        var tin = $('input[name=tin_no]').val()
        var birth_date = "{{$member->birth_date}}"
        var email = $('input[name=email]').val()
        var appointment_status = $('select[name=status]').val()



        Swal.fire({
            title: "Are you sure?",
            text: "You will change this member's details!",
            icon: "question",
            confirmButtonColor: '#1a8981',
            confirmButtonText: 'Confirm',
            cancelButtonText: "Cancel",
            showCancelButton: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
        }).then((okay) => {
            if (okay.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: "/member/member-update",
                    data: {
                        user_id: user_id,
                        member_no: member_no,
                        first_name: first_name,
                        middle_name: middle_name,
                        last_name: last_name,
                        position_id: position_id,
                        membership_date: membership_date,
                        contact_no: contact_no,
                        landline: landline,
                        gender: gender,
                        employee_no: employee_no,
                        appointment_status: appointment_status,
                        permanent_address: permanent_address,
                        current_address: current_address,
                        tin: tin,
                        birth_date: birth_date,
                        email: email,
                    },
                    success: function(data) {
                        console.log(data)
                        if (data.success == true) {
                            $('#loading').show();
                            location.reload();
                        } else {
                            Swal.fire({
                                title: "No Changes Made!",
                                type: "error",
                                confirmButtonColor: '#1a8981',
                            })
                        }
                    }
                });
            } else if (okay.isDenied) {
                Swal.close();
            }
        });
    });

    //update other member details click
    $(document).on('click', '#update_membership', function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var member_no = <?php echo $member->member_no ?>;
        var contribution_type = $('select[name=contribution_type]').val();
        var contribution = $('input[name=contribution]').val();
        var with_cocolife_form = $('select[name=with_cocolife_form]').val()
        Swal.fire({
            title: "Are you sure?",
            text: "You will change this member's membership details!",
            icon: "question",
            confirmButtonColor: '#1a8981',
            confirmButtonText: 'Confirm',
            cancelButtonText: "Cancel",
            showCancelButton: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
        }).then((okay) => {
            if (okay.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('update_other_member_details') }}",
                    data: {
                        member_no: member_no,
                        contribution_type: contribution_type,
                        contribution: contribution,
                        with_cocolife_form: with_cocolife_form,
                    },
                    success: function(data) {
                        console.log(data)
                        if (data.success == true) {
                            $('#loading').show();
                            location.reload();
                        } else {
                            Swal.fire({
                                title: "No Changes Made!",
                                type: "error",
                                confirmButtonColor: '#1a8981',
                            })
                        }
                    }
                });
            } else if (okay.isDenied) {
                Swal.close();
            }
        });
    });


    $(document).on('click', '.header-tabs > span', function(e) {
        // const linkSplit = window.location.href.split('/')
        // const length = linkSplit.length
        // const id = linkSplit[length-1]
        const element = $(this)
        setActiveTab(element)
        // window.location.href = '/admin/members/records/view/aa' + links[dataSet] + '/' + id

        $('input[name=first_name]').val("{{$member->first_name}}")


    })

    $(document).on('click', '#add-new-beneficiary', function() {

        let status = validateField({
            element: $('input[name=beneficiary-name]'),
            target: "beneficiary-name"
        })
        let status1 = validateField({
            element: $('input[name=beneficiary-relationship]'),
            target: "beneficiary-relationship"
        })
        let status2 = validateField({
            element: $('input[name=beneficiary-birthday]'),
            target: "beneficiary-birthday"
        })

        if (status || status1 || status2) {
            return false
        }

        Swal.fire({
            title: "Are you sure?",
            text: "You will add this beneficiary!",
            icon: "question",
            confirmButtonColor: '#1a8981',
            confirmButtonText: 'Confirm',
            cancelButtonText: "Cancel",
            showCancelButton: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
        }).then((okay) => {
            if (okay.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: "/member/add_old_member_beneficiary",
                    data: {
                        beni_name: $('input[name=beneficiary-name]').val(),
                        birth_date: $('input[name=beneficiary-birthday]').val(),
                        relationship: $('input[name=beneficiary-relationship]').val(),
                    },
                    success: function(data) {
                        console.log(data)
                        if (data.success == true) {
                            resetBeneficiaryForm();
                            getBeneficiaries();
                        }
                    }
                });
            } else if (okay.isDenied) {
                Swal.close();
            }
        });
    })

    $(document).on('click', '#change-password', function(e) {
        const password = $('input[name=password]').val()
        const newPassword = $('input[name=new-password]').val()
        const confirmPassword = $('input[name=confirm-password]').val()

        const isPasswordValid = checkPassword({
            newPassword,
            confirmPassword
        })



        let status = validateField({
            element: $('input[name=password]'),
            target: "password"
        })
        let status1 = validateField({
            element: $('input[name=new-password]'),
            target: "new-password"
        })
        let status2 = validateField({
            element: $('input[name=confirm-password]'),
            target: "confirm-password"
        })

        if (status || status1 || status2) {
            return false
        }

        if (newPassword != confirmPassword) {
            return Swal.fire({
                text: 'Password did not match.',
                icon: 'error',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok',
            });
        } else {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/change-password',
                method: 'POST',
                data: {
                    current_password: password,
                    new_password: newPassword,
                    new_password_confirmation: confirmPassword
                },
                success: function(response) {
                    Swal.fire({
                        text: 'Password changed successfully.',
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok',
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        text: xhr.responseJSON.message,
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok',
                    });
                    // Handle error response
                }
            });
        }

    })

    $(document).on('click', '#view_profile', function(e) {
        $("#beneficiariesDiv").addClass("d-none")
        $("#beneficiariesDiv").addClass("opacity-0")
        $("#memberstatusDiv").removeClass("d-none")
        $("#memberstatusDiv").removeClass("opacity-0")
        $("#statementDiv").addClass("d-none")
        $("#statementDiv").addClass("opacity-0")
        $("#resetPasswordDiv").addClass("d-none")
        $("#resetPasswordDiv").addClass("opacity-0")

        $('input[name=first_name]').val("{{$member->first_name}}")
        $('input[name=last_name]').val("{{$member->last_name}}")
        $('input[name=middle_name]').val("{{$member->middle_name}}")
        $('select[name=campus]').val("{{$member->campus_id}}")
        $('select[name=department]').val("{{$member->department_id}}")
        $('input[name=position]').val("{{$member->position_id}}")
        $('input[name=appointment_date]').val("{{$member->original_appointment_date}}")
        <?php
        $memberDate = new DateTime($member->membership_date);
        $memberDateString = $memberDate->format('Y-m-d');
        ?>
        $('input[name=membership_date]').val('{{$memberDateString}}')
        $('input[name=contact_no]').val("{{$member->contact_no}}")
        $('input[name=landline_no]').val("{{$member->landline}}")
        if ("{{$member->gender}}" == "FEMALE") {
            $('select[name=gender]').val(1)
        } else {
            $('select[name=gender]').val(2)
        }
        $('input[name=employee_no]').val("{{$member->employee_no}}")
        $('input[name=current_address]').val("{{$member->current_address}}")
        $('input[name=permanent_address]').val("{{$member->permanent_address}}")
        $('input[name=tin_no]').val("{{$member->tin}}")
        $('input[name=birthday]').val("{{$member->birth_date}}")
        $('input[name=email]').val("{{$member->email}}")
        $('select[name=status]').val("{{$member->appointment_status}}")


    })

    $(document).on('click', '#view_beneficiaries', function(e) {

        $("#beneficiariesDiv").removeClass("d-none")
        $("#beneficiariesDiv").removeClass("opacity-0")

        $("#memberstatusDiv").addClass("d-none")
        $("#memberstatusDiv").addClass("opacity-0")
        $("#statementDiv").addClass("d-none")
        $("#statementDiv").addClass("opacity-0")
        $("#resetPasswordDiv").addClass("d-none")
        $("#resetPasswordDiv").addClass("opacity-0")

    })

    $(document).on('click', '#view_password', function(e) {
        console.log('123')
        $("#beneficiariesDiv").addClass("d-none")
        $("#beneficiariesDiv").addClass("opacity-0")

        $("#memberstatusDiv").addClass("d-none")
        $("#memberstatusDiv").addClass("opacity-0")
        $("#statementDiv").addClass("d-none")
        $("#statementDiv").addClass("opacity-0")
        $("#resetPasswordDiv").removeClass("d-none")
        $("#resetPasswordDiv").removeClass("opacity-0")

    })


    $(document).on('click', '#back', function(e) {

        $("#beneficiariesDiv").addClass("d-none")
        $("#beneficiariesDiv").addClass("opacity-0")

        $("#memberstatusDiv").addClass("d-none")
        $("#memberstatusDiv").addClass("opacity-0")
        $("#statementDiv").removeClass("d-none")
        $("#statementDiv").removeClass("opacity-0")

    })

    $(document).on('click', '#modify_contributions', function(e) {

        $("#memberstatusDiv").removeClass("d-none")
        $("#memberstatusDiv").removeClass("opacity-0")

        $("#statementDiv").addClass("d-none")
        $("#statementDiv").addClass("opacity-0")
        $("#beneficiariesDiv").addClass("d-none")
        $("#beneficiariesDiv").addClass("opacity-0")

    })
</script>
@endsection