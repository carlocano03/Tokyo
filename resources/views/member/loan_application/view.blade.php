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


    .info-pdf {
        display: grid;
        /* font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; */
        font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    }

    .info-pdf label {
        padding: 0;
        margin-bottom: 0px;
        color: #7c7272;
        font-size: 10px;
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

    .font-p>label {
        font-size: 9px !important;
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>

<div class="filler"></div>
<div class="col-12 padding-content mp-text mp-text-c-accent dashboard mh-content">
    <div class="d-flex flex-wrap">
        <div class="col-lg-4 mp-pr0 mp-mt2" style="width: 100%;">
            <div class="mp-card mp-p4 h-auto mp-mb2">
                <div class="container-fluid">
                    <div class="row" style="padding:20px;">
                        <div class="col-lg-5">

                            <div class="profile-img">
                                <img style="width: 100px; height: 100px;" src="{!! asset('assets/images/user-default.png') !!}" alt="">
                            </div>
                        </div>
                        <div class=" col-lg-7">
                            <div class="profile-text" style="display: inline-grid;">
                                <span style="font-size: 15px;
                                                                color: black;
                                                                font-weight: bold;">Member Status</span>

                                @if ($member->membership_status == 'ACTIVE')
                                <span style="   margin-top: -5px;
                                                                    color: var(--c-primary);
                                                                    font-size: 25px;
                                                                    font-weight: 500;"> {{ $member->membership_status }}</span>
                                @else
                                <span style="   margin-top: -5px;
                                                                    color: red;
                                                                    font-size: 25px;
                                                                    font-weight: 500;"> {{ $member->membership_status }}</span>
                                @endif



                                <span style="color: #7c7272;"> Member ID: </span>

                                <span style="font-size: 25px;
                                                                margin-top:-5px;
                                                                color: black;
                                                                font-weight: bold;"> {{ $member->member_no }}</span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">

                            <div class="info-text">
                                <h1> {{ $member->last_name }}, {{ $member->first_name }} {{ $member->middle_name}}</h1>
                                <label>{{ $member->campus_name }}</label>
                                <label>{{ $member->position_id }}</label>
                            </div>

                            <div class="info-text-number">

                                <label><i class="fa fa-envelope-o" aria-hidden="true"></i> {{ $member->email }}</label>
                                <label style="float:right;"><i class="fa fa-phone" aria-hidden="true"></i>+63{{ $member->contact_no }}</label>
                            </div>




                        </div>
                    </div>
                </div>

            </div>
            <div class="mp-card h-auto" class="">
                <div class="container-fluid mp-mt2 gap-10">
                    <div class="row">
                        <div class="col-12 mp-mt2 d-flex flex-row justify-content-between">
                            <span>
                                <h3 class="magenta-clr">
                                    Loan Balance:
                                </h3>
                            </span>
                            <span>
                                <h3 class="black-clr">
                                    PHP {{ number_format($totalloanbalance)}}
                                </h3>
                            </span>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="info-text">
                                        <label>Loan Application Number: </label>
                                        <label>{{$loan_details->control_number}}</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="info-text">
                                        <label>Application Date: </label>
                                        <label>{{$loan_details->date_created}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mp-mt2">
                                <div class="col-lg-6">
                                    <div class="info-text">
                                        <label>Terms of Payment: </label>

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="info-text">
                                        <label>{{$loan_details->year_terms}} Years</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="info-text">
                                        <label>Interest Rate: </label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="info-text">
                                        <label>{{$loan_details->loan_interest}}%</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="info-text">
                                        <label>UP service to date: </label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="info-text">
                                        <!-- <label>5 Years</label> -->
                                    </div>
                                </div>
                            </div>
                            <div class="row mp-mt2">
                                <div class="col-lg-6">
                                    <div class="info-text">
                                        <label>Account Number: </label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="info-text">
                                        <label>{{$loan_details->account_number}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="info-text">
                                        <label>Account Name: </label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="info-text">
                                        <label>{{$loan_details->account_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="info-text">
                                        <label>Bank: </label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="info-text">
                                        <label>{{$loan_details->bank}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mp-mt2">
                                <div class="col-lg-6">
                                    <div class="info-text">
                                        <label>Type of Application: </label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="info-text">
                                        <label>{{$loan_details->type}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mp-mt2">
                        <div class="col-12 mp-mt2">
                            <div class="info-text">
                                <h3 class="magenta-clr mp-mb0">
                                    Loan Status:
                                </h3>
                                <h3 class="black-clr mp-mb0">
                                    {{$loan_details->status}}
                                </h3>
                                <label for="">As of May 4, 2023 11:06 AM</label>
                            </div>

                        </div>
                        <!-- <div class="col-12 mp-mt3">
                            <div class="info-text">
                                <label for="">Computed by: JOE3 / Doe, John V. / Staff</label>
                                <label for="">May 4, 2023 11:06 AM</label>
                            </div>
                        </div>
                        <div class="col-12 mp-mt2">
                            <div class="info-text">
                                <label for="">Checked and Approved by: Joe, John D.</label>
                                <label for="">Designation: Staff</label>
                                <label for="">May 4, 2023 11:06 AM</label>
                            </div>
                        </div> -->
                        <div class="col-lg-12 d-flex mp-mh4 flex-column">
                            <a href="/admin/monthly_payment/{{$loan_details->loan_app_id}}" target="_blank" class="up-button btn-md mp-text-center w-100 mp-mt2 mp-mvauto magenta-bg">
                                <span class="save_up">VIEW AMORTIZATION SCHEDULE</span>
                            </a>
                            <a id="generate-loan-form" class="up-button btn-md mp-text-center w-100 mp-mt2 mp-mvauto magenta-bg">
                                <span class="save_up">GENERATE LOAN APPLICATION FORM</span>
                            </a>
                            <a href="/member/loan/info-slip" class="up-button btn-md mp-text-center w-100 mp-mt2 mp-mvauto gray-bg">
                                <span class="save_up">GENERATE LOAN INFORMATION SLIP</span>
                            </a>
                        </div>


                    </div>
                </div>
            </div>

        </div>


        <div class="col-lg-8 d-flex justify-content-center">
            <div style="max-width: 21cm; overflow-y:auto; box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);" class="mp-mh2">
                <page size="A4" class="mp-pv3 mp-ph3 relative" id="pdf-js">
                    <div class="container-fluid">
                        <div class="row mp-mt3">
                            <div class="col-12">
                                <img src="{!! asset('assets/images/loan_info_logo.png') !!}" style=" width: 250px;" alt="UPPFI">
                                <span class="" style="position: absolute; right:20px; top: 0px">
                                    <div class="info-pdf">
                                        <label for="">UPPFI FORM NO .02</label>
                                        <label for="">January 2018</label>
                                    </div>
                                </span>
                            </div>
                            <div class="col-12 mp-mt1">
                                <div class="row">
                                    <div class="col-8">
                                        <label class=" font-bold black-clr mp-ml5" style="font-size: 18px; margin-bottom: 0">
                                            PERSONAL EQUITY APPLICATION FORM
                                        </label>
                                    </div>
                                    <div class="col-4">
                                        <div class="info-pdf">
                                            <label for="">Part I. (To be filled up by the borrower)</label>
                                        </div>
                                        <div class="info-pdf mp-mt1 d-flex flex-row">
                                            <label for="">DATE: </label>
                                            <div class="underline">
                                                {{ date('Y-m-d H:i:s') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="info-pdf d-flex flex-row">
                                            <label for="">NAME: </label>
                                            <div class="underline">
                                                {{ $member->last_name }}, {{ $member->first_name }} {{ $member->middle_name}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="info-pdf d-flex flex-row">
                                            <label for="" class="mp-ml5">Last Name </label>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="info-pdf d-flex flex-row">
                                            <label for="">First Name </label>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="info-pdf d-flex flex-row">
                                            <label for="">Middle Name </label>


                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="info-pdf mp-mt1 d-flex flex-row">
                                    <label for="">ACCOUNT NAME: </label>
                                    <div class="underline">
                                        {{ $loan_details->account_name }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="info-pdf d-flex flex-row">
                                            <label for="">UNIT: </label>
                                            <div class="underline">
                                                {{ $member->position_id }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="info-pdf d-flex flex-row">
                                            <label for="">CAMPUS: </label>
                                            <div class="underline">
                                                {{ $member->campus_name }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="info-pdf d-flex flex-row">
                                    <label for="">MEMBER ID NUMBER: </label>
                                    <div class="underline">
                                        {{$member->member_no}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mp-mt1">
                                <div class="info-pdf d-flex flex-row">
                                    <label for="">I hearby apply for a loan of PESOS: </label>
                                    <div class="underline">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mp-mt1">
                                <div class="info-pdf d-flex flex-row mp-pv5 flex-wrap">
                                    <label for="">(Php</label>
                                    <span style="width: 110px; border-bottom: 1px solid black; margin-left: 10px; margin-right: 10px">{{ $loan_details->amount }}</span>
                                    <label for="">). Payable in </label>
                                    <span style="width: 60px; border-bottom: 1px solid black; margin-left: 10px; margin-right: 10px"> {{ $loan_details->year_terms }}</span>
                                    <label for=""> year(s) subject to the terms and conditions required by the UPPFI.</label>
                                    <!-- <div class="underline">
                                </div> -->
                                </div>
                            </div>
                            <div class="col-5 mp-mt2 ml-auto mp-mr5">
                                <div class="underline">
                                    {{ $member->last_name }}, {{ $member->first_name }} {{ $member->middle_name}}
                                </div>
                                <div class="row info-pdf">
                                    <label class="font-bold black-clr ml-auto mr-auto mp-mt1" style="font-size: 11px">Signature of Borrower Over Printed Name</label>
                                </div>
                            </div>
                        </div>
                        <hr class="mp-mt2 black-bg">
                        <div class="row mp-mt1">
                            <div class="col-4 ml-auto">
                                <div class="info-pdf">
                                    <label for="">Part I. (To be filled up by the borrower)</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="row">
                                    <div class="col-4 d-flex">
                                        <div class="info-pdf mp-mt1 d-flex flex-row w-100">
                                            <label class="mt-auto" for="" style="width: 70px">Total Equity to Date: </label>
                                            <div class="underline mp-ml0 mp-mr0 d-flex align-items-end">
                                                {{$loan_details->date_created}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 d-flex">
                                        <div class="info-pdf mp-mt1 d-flex flex-row w-100">
                                            <label class="mt-auto" for="">Net Pay: </label>
                                            <div class="underline mp-ml0 mp-mr0 d-flex align-items-end">
                                                {{$loan_details->net_proceeds}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 d-flex">
                                        <div class="info-pdf mp-mt1 d-flex flex-row w-100">
                                            <label class="mt-auto" for="" style="width: 70px">U.P Service to Date (yrs): </label>
                                            <div class="underline mp-ml0 mp-mr0 d-flex align-items-end">
                                                {{$years}} Years
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 d-flex">
                                <div class="row w-100">
                                    <div class="col-6 d-flex ">
                                        <div class="info-pdf mp-mt1 d-flex flex-row w-100">
                                            <label class="mt-auto" for="" style="width: 40px">Interest Rate: </label>
                                            <div class="underline mp-ml0 mp-mr0 d-flex">
                                                {{$loan_details->loan_interest}}%
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 d-flex">
                                        <div class="info-pdf mp-mt1 d-flex flex-row w-100">
                                            <label class="mt-auto" for="">Term: </label>
                                            <div class="underline mp-ml0 mp-mr0 d-flex">
                                                {{$loan_details->year_terms}} Years
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="font-md font-bold black-clr mp-mt1 mp-mb0">A.) LOANABLE AMOUNT: </label>
                                <div class="row">
                                    <div class="col-6 mp-ml5">
                                        <div class="info-pdf d-flex flex-row w-100">
                                            <label class="mt-auto">75% Equity (if less than 4 years of service) </label>
                                        </div>
                                        <div class="info-pdf d-flex flex-row w-100">
                                            <label class="mt-auto">85% Equity (if with less than 4 but less than 15 years of service) </label>
                                        </div>
                                        <div class="info-pdf d-flex flex-row w-100">
                                            <label class="mt-auto">100% x Equity (if with at least 15 years of service) </label>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="info-pdf d-flex flex-row w-100">
                                            <label class="mt-auto">Php </label>
                                            <div class="underline mp-ml2 mp-mr0 d-flex">
                                                <span>PHP {{number_format($totalcontributions*.75, 2)  }}</span>
                                            </div>
                                        </div>
                                        <div class="info-pdf d-flex flex-row w-100">
                                            <label class="mt-auto">Php </label>
                                            <div class="underline mp-ml2 mp-mr0 d-flex">
                                                <span>PHP {{number_format($totalcontributions*.85, 2)  }}</span>
                                            </div>
                                        </div>
                                        <div class="info-pdf d-flex flex-row w-100">
                                            <label class="mt-auto">Php </label>
                                            <div class="underline mp-ml2 mp-mr0 d-flex">
                                                <span>PHP {{number_format($totalcontributions*1, 2)  }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-9">
                                                <label class="font-md font-bold black-clr mp-mt1 mp-mb0">B.) AMOUNT GRANTED: </label>
                                            </div>
                                            <div class="col-3">
                                                <div class="info-pdf mp-mt1 d-flex flex-row w-100">
                                                    <label class="mt-auto fs-italic" for="">As of(mm-yr) </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-6">
                                            </div>
                                            <div class="col-6">
                                                <div class="info-pdf mp-mt1 d-flex flex-row w-100">
                                                    <label class="mt-auto" for="">Php </label>
                                                    <div class="underline"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-7 ml-auto">
                                                <div class="info-pdf d-flex flex-row w-100">
                                                    <label class="mt-auto" for="">Less Service Fee </label>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <!-- <div class="info-pdf d-flex flex-row w-100 h-100">
                                                    <div class="underline mt-auto"></div>
                                                </div> -->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-7 ml-auto">
                                                <div class="info-pdf d-flex flex-row w-100">
                                                    <label class="mt-auto" for="">Outstanding Loan - Principal (PEL) </label>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="info-pdf d-flex flex-row w-100 h-100">
                                                    <div class="underline mt-auto">asd</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-7 ml-auto">
                                                <div class="info-pdf d-flex flex-row w-100">
                                                    <label class="mt-auto" for="">Outstanding Loan - Principal (BL) </label>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="info-pdf d-flex flex-row w-100 h-100">
                                                    <div class="underline mt-auto"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-7 ml-auto">
                                                <div class="info-pdf d-flex flex-row w-100">
                                                    <label class="mt-auto" for="">Outstanding Loan - Principal (EML) </label>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="info-pdf d-flex flex-row w-100 h-100">
                                                    <div class="underline mt-auto"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-7 ml-auto">
                                                <div class="info-pdf d-flex flex-row w-100">
                                                    <label class="mt-auto" for="">Outstanding Loan - Principal (CBL) </label>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="info-pdf d-flex flex-row w-100 h-100">
                                                    <div class="underline mt-auto"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-7 ml-auto">
                                                <div class="info-pdf d-flex flex-row w-100">
                                                    <label class="mt-auto" for="">Interest - PEL </label>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="info-pdf d-flex flex-row w-100 h-100">
                                                    <div class="underline mt-auto"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-7 ml-auto">
                                                <div class="info-pdf d-flex flex-row w-100">
                                                    <label class="mt-auto" for="">Interest - BL </label>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="info-pdf d-flex flex-row w-100 h-100">
                                                    <div class="underline mt-auto"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-7 ml-auto">
                                                <div class="info-pdf d-flex flex-row w-100">
                                                    <label class="mt-auto" for="">Interest - EML </label>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="info-pdf d-flex flex-row w-100 h-100">
                                                    <div class="underline mt-auto"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-7 ml-auto">
                                                <div class="info-pdf d-flex flex-row w-100">
                                                    <label class="mt-auto" for="">Interest - CBL </label>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="info-pdf d-flex flex-row w-100 h-100">
                                                    <div class="underline mt-auto"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-7 ml-auto">
                                                <div class="info-pdf d-flex flex-row w-100">
                                                    <label class="mt-auto" for="">Surcharge </label>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="info-pdf d-flex flex-row w-100 h-100">
                                                    <div class="underline mt-auto"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mp-mt1">
                                            <div class="col-7 ml-auto">
                                                <div class="info-pdf d-flex flex-row w-100">
                                                    <label class="mt-auto font-bold black-clr" for="">Net Proceeds </label>
                                                </div>
                                            </div>
                                            <div class="col-4">

                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="info-pdf d-flex flex-row w-100">
                                                    <label class="mt-auto" for="">Php </label>
                                                    <div class="underline mt-auto mp-text-right">200</div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <!-- <div class="info-pdf d-flex flex-row w-100 h-100">
                                                    <div class="underline mt-auto"></div>
                                                </div> -->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="info-pdf d-flex flex-row w-100">
                                                    <div class="underline mt-auto"></div>
                                                </div>
                                            </div>
                                            <div class="col-4">

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="info-pdf d-flex flex-row w-100">
                                                    <div class="underline mt-auto"></div>
                                                </div>
                                            </div>
                                            <div class="col-6">

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="info-pdf d-flex flex-row w-100">
                                                    <div class="underline mt-auto"></div>
                                                </div>
                                            </div>
                                            <div class="col-6">

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="info-pdf d-flex flex-row w-100">
                                                    <div class="underline mt-auto"></div>
                                                </div>
                                            </div>
                                            <div class="col-6">

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="info-pdf d-flex flex-row w-100">
                                                    <div class="underline mt-auto"></div>
                                                </div>
                                            </div>
                                            <div class="col-6">

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="info-pdf d-flex flex-row w-100">
                                                    <div class="underline mt-auto"></div>
                                                </div>
                                            </div>
                                            <div class="col-6">

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="info-pdf d-flex flex-row w-100">
                                                    <div class="underline mt-auto"></div>
                                                </div>
                                            </div>
                                            <div class="col-6">

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="info-pdf d-flex flex-row w-100">
                                                    <div class="underline mt-auto"></div>
                                                </div>
                                            </div>
                                            <div class="col-6">

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="info-pdf d-flex flex-row w-100">
                                                    <div class="underline mt-auto"></div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="info-pdf d-flex flex-row w-100 h-100">
                                                    <div class="underline mt-auto mp-text-right">200</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mp-mt1">
                                            <div class="col-6">
                                            </div>
                                            <div class="col-6">
                                                <div class="info-pdf d-flex flex-row w-100 h-100">
                                                    <label for="">Php</label>
                                                    <div class="underline mt-auto mp-text-right"> {{$loan_details->net_proceeds}}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                            </div>
                                            <div class="col-6">
                                                <div class="info-pdf d-flex flex-row w-100 h-100">
                                                    <label for="" style="color: white; height: 1px">Php</label>
                                                    <div class="underline mt-auto mp-text-right" style="height: 2px"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-4 mp-ml3">
                                        <div class="info-pdf d-flex flex-row w-100 h-100">
                                            <label for="">Monthly Amortization</label>
                                            <div class="underline mt-auto"></div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="info-pdf d-flex flex-row w-100 h-100">
                                            <label for="">Collection Period</label>
                                            <div class="underline mt-auto"></div>
                                            <label for="">to</label>
                                            <div class="underline mt-auto"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="info-pdf d-flex flex-row w-100">
                                            <label class="mt-auto font-bold black-clr" for="">Per Amortization Schedule:</label>
                                        </div>
                                    </div>
                                    <div class="col-4 mp-ml3">
                                        <div class="info-pdf d-flex flex-row w-100">
                                            <label class="mt-auto mp-text-right" for="" style="width: 80px">Principal</label>
                                            <div class="underline mp-text-right"></div>
                                        </div>
                                        <div class="info-pdf d-flex flex-row w-100">
                                            <label class="mt-auto mp-text-right" for="" style="width: 80px">Total Interest</label>
                                            <div class="underline mp-text-right"></div>
                                        </div>
                                        <div class="info-pdf d-flex flex-row w-100">
                                            <label class="mt-auto mp-text-right" for="" style="width: 80px">Total Payments</label>
                                            <div class="underline mp-text-right"></div>
                                        </div>
                                        <div class="info-pdf d-flex flex-row w-100">
                                            <label class="mt-auto mp-text-right" for="" style="width: 80px; height: 1px; color: white">Total Payments</label>
                                            <div class="underline mp-text-right" style="height: 2px"></div>
                                        </div>
                                    </div>
                                    <div class="col-4 d-flex">
                                        <div class="info-pdf d-flex flex-row w-100 mp-mhauto">
                                            <label class="mt-auto" for="" style="width: 80px">Date Release</label>
                                            <div class="underline mp-text-right"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="info-pdf mp-mt2 d-flex flex-row">
                                            <label for="" style="width: 100px">Computed by: </label>
                                            <div class="underline">
                                            </div>
                                        </div>
                                        <div class="info-pdf mp-mt1 d-flex flex-row">
                                            <label for="" style="width: 100px">Signature: </label>
                                            <div class="underline">
                                            </div>
                                        </div>
                                        <div class="info-pdf mp-mt1 d-flex flex-row">
                                            <label for="" style="width: 100px">Designation: </label>
                                            <div class="underline">
                                            </div>
                                        </div>
                                        <div class="info-pdf mp-mt1 d-flex flex-row">
                                            <label for="" style="width: 100px">Date: </label>
                                            <div class="underline">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="info-pdf mp-mt3 d-flex flex-row">
                                            <label for="" style="width: 150px">Checked and Approved by: </label>
                                            <div class="underline">
                                            </div>
                                        </div>
                                        <div class="info-pdf mp-mt1 d-flex flex-row">
                                            <label for="" style="width: 150px">Signature: </label>
                                            <div class="underline">
                                            </div>
                                        </div>
                                        <div class="info-pdf mp-mt1 d-flex flex-row">
                                            <label for="" style="width: 150px">Designation: </label>
                                            <div class="underline">
                                            </div>
                                        </div>
                                        <div class="info-pdf mp-mt1 d-flex flex-row">
                                            <label for="" style="width: 150px">Date: </label>
                                            <div class="underline">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="mp-mt3 black-bg">
                        <div class="row ">
                            <div class="col-12">
                                <div class="info-pdf font-p">
                                    <label for="" class="fs-italic mp-mt2">
                                        I acknowledge receipt of a copy of this Personal Equity Loan computation prior to the consumation of the loan/credit transaction and that I fully understand and agree to the terms and
                                        conditions thereof
                                    </label>
                                    <label for="" class="fs-italic mp-mt2">
                                        Furthermore, I authorize the UP Provident Fund, Inc. (UPPFI) to obtain access of my payroll information from the UP Accounting Office to verify my creditworthiness upon application and to
                                        review my paying capacity in case of default or failure to pay the amortizations of this loan.

                                    </label>
                                    <label for="" class="fs-italic mp-mt2">
                                        I also authorize UPPFI to credit the savings account number I have written above for the net proceeds of this loan. And, I fully understand that I am holding UPPFI free from any liability
                                        and/or damages that may happen arising from this authorization.
                                    </label>
                                    <label for="" class="fs-italic mp-mt2">
                                        I authorize the UP Payroll Section to deduct from my salaries, emoluments and other benefits, dues and loan amortizations owing to the UPPFI before any and all deductions owing to third
                                        parties, except those deductions owing to government agencies and/or other deductions mandated by existing laws
                                    </label>
                                    <label for="" class="fs-italic mp-mt2">
                                        Failure to pay the required monthly amorization after 3 months is considered delinquent and is subject to surcharge of 1/2 of 1% per month, compounded monthly. Further, I hereby
                                        authorize UPPFI to offset my equity (earnings and member's contributions, in this order of application) against the outanding loan balance (principal plus interest and surcharge, one (1)
                                        year from the date of default.
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="col-5 mp-mt2 ml-auto mp-mr5">
                                    <div class="underline"> {{ $member->last_name }}, {{ $member->first_name }} {{ $member->middle_name}}</div>
                                    <div class="row info-pdf">
                                        <label class="font-bold black-clr ml-auto mr-auto mp-mt1" style="font-size: 11px">Signature of Borrower Over Printed Name</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </page>
            </div>

        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // var element = document.getElementById('pdf-js');
        // var opt = {
        //     margin:       0,
        //     filename:     'sample.pdf',
        //     image:        { type: 'jpeg', quality: 0.98 },
        //     html2canvas:  { scale: 2 },
        //     jsPDF:        { unit: 'in', format: 'A4', orientation: 'portrait' }
        // };
        // html2pdf().set(opt).from(element).save();
        $('#generate-loan-form').on('click', function(e) {
            var element = document.getElementById('pdf-js');
            var opt = {
                margin: 0,
                filename: 'sample.pdf',
                image: {
                    type: 'jpeg',
                    quality: 1
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'in',
                    format: 'A4',
                    orientation: 'portrait'
                }
            };
            html2pdf().set(opt).from(element).save();
        });
        $('#back').on('click', function(e) {
            $('.loan-submission').addClass("d-none")
            $('.loan-calculator').removeClass("d-none")
            $('input').first().focus()
        });
        $('#recompute').on('click', function(e) {
            $('.loan-submission').addClass("d-none")
            $('.loan-calculator').removeClass("d-none")
            $('input').first().focus()
        });
        $('#continue').on('click', function(e) {
            $('.loan-submission').removeClass("d-none")
            $('.loan-calculator').addClass("d-none")
            $('input').first().focus()
            $('#back').focus()
        });
    });
</script>
@endsection