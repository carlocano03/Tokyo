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

    .x-button {
        float: right;
    }

    .x-button:hover {
        transform: scale(1.1);
    }

    .delete_btn {
        background-color: red;
        color: white;
        border-radius: 5px;
        font-size: 15px;
    }

    .delete_btn:hover {
        font-size: 17px;
    }
</style>

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
<div class="members-module">
    <div class="siderbar d-flex flex-column showed" style="position:relative">
        <span class="toggle-icon" style="cursor: pointer">
            <i class="fa fa-chevron-circle-left mp-text-fs-base magenta-clr " style="background-color: white;border-radius: 50%" aria-hidden="true"></i>
            <i class="fa fa-chevron-circle-right mp-text-fs-base magenta-clr d-none" style="background-color: white;border-radius: 50%" aria-hidden="true"></i>
        </span>
        <div class="title mp-text-fs-large mp-text-fw-heavy mp-ph3 mp-pv3">
            Members Module
        </div>
        <div class="item flex-column gap-5 mp-ph3 mp-pv3" id="sider-item" data-set="0">
            <span>
                New Members
            </span>

        </div>
        <div class="item flex-column gap-5 mp-ph3 mp-pv3 active" id="sider-item" data-set="1">
            <span>
                Master List
            </span>

        </div>
        <div class="item flex-column gap-5 mp-ph3 mp-pv3 " id="sider-item" data-set="2">
            <span>
                Members Summary Reports
            </span>

        </div>
        <div class="item flex-column gap-5 mp-ph3 mp-pv3" id="sider-item" data-set="3">
            <span>
                Contribution Reports
            </span>

        </div>
        <div class="item flex-column gap-5 mp-ph3 mp-pv3 " id="sider-item" data-set="4">
            <span>
                Insurance Reports
            </span>

        </div>
        <div class="item flex-column gap-5 mp-ph3 mp-pv3" id="sider-item" data-set="5">
            <span>
                Members Voter List asd
            </span>

        </div>
    </div>
    <div class="members-content mp-pr2 d-flex flex-column gap-5 mh-content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12 mp-mt3 gap-10" id="settingsContent">
                    <div class="no-gutter  ">

                        <a class="back-link-style" href="/admin/members">
                            <span style=" margin-bottom: 10px;" class="d-inline-flex align-items-center ">

                                < Back to Master List </span>
                        </a>
                        <div class="row">
                            <div class="col-lg-5 mp-pr0 mp-mt2" style="width: 100%;">
                                <div class="mp-card mp-p4 ">
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

                                                <div class="profile-buttons  col-12 mp-mb3 ">
                                                    <button class="up-button-green btn-md button-animate-right mp-text-center" id="view_beneficiaries" type="button">
                                                        <span>View Beneficiaries</span>
                                                    </button>
                                                    <button class="up-button btn-md button-animate-right mp-text-center" id="modify_contributions" type="button">
                                                        <span>Edit Member Details</span>
                                                    </button>
                                                    <button class="up-button-grey btn-md button-animate-right mp-text-center">
                                                        <span>Reset Password</span>
                                                    </button>
                                                </div>

                                                <div class="  mp-mt3">

                                                    <div class="card-container card p-0 mp-mt3">
                                                        <div class="card-header d-flex items-between bayabas-bg member-detail-title open-details">
                                                            <span>Personal Details</span><span>
                                                                <span>
                                                                    <a class="cursor-pointer m-0 p-0 mp-mr2" id="member-detail-toggle">
                                                                        <i class="fa fa-chevron-circle-down member-up" aria-hidden="true"></i>
                                                                        <i class="fa fa-chevron-circle-up  d-none member-down" aria-hidden="true"></i>
                                                                    </a>
                                                                </span>
                                                            </span>
                                                        </div>
                                                        <div class="card-body  mp-ph3 d-flex flex-column member-detail-body open-details">


                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label">Permanent Address:</label>
                                                                <label class="mp-input-group__label value">{{ $member->permanent_address == null ? 'N/A' : $member->permanent_address}}</label>
                                                            </div>
                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label">Current Address:</label>
                                                                <label class="mp-input-group__label value"> {{ $member->current_address }}</label>
                                                            </div>

                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label">Birthday </label>
                                                                <label class="mp-input-group__label value"> {{ $member->birth_date }}</label>
                                                            </div>
                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label"> Civil Status</label>
                                                                <label class="mp-input-group__label value">{{ $member->civil_status }}</label>
                                                            </div>
                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label">Landline No </label>
                                                                <label class="mp-input-group__label value">{{ $member->landline == null ? 'N/A' : $member->landline }}</label>
                                                            </div>
                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label">Gender</label>
                                                                <label class="mp-input-group__label value">{{ $member->gender }}</label>
                                                            </div>
                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label">Citizenship</label>
                                                                <label class="mp-input-group__label value">No Details</label>
                                                            </div>
                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label">Tin No</label>
                                                                <label class="mp-input-group__label value">{{ $member->tin }}</label>
                                                            </div>

                                                        </div>

                                                        <div class="card-body  mp-ph3 d-flex flex-column member-detail-body open-details">
                                                            <label class="personal-details-title">Employee Details</label>

                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label">Employee No.</label>
                                                                <label class="mp-input-group__label value">{{ $member->employee_no }}</label>
                                                            </div>
                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label">Original Appointment Date</label>
                                                                <label class="mp-input-group__label value">{{$member->original_appointment_date}}</label>
                                                            </div>

                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label">Appointment Status</label>
                                                                <label class="mp-input-group__label value">{{ $member->appointment_status ?$member->appointment_status : 'N/A'   }}</label>
                                                            </div>
                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label"> Monthly Salary</label>
                                                                <label class="mp-input-group__label value">{{ $member->monthly_salary }}</label>
                                                            </div>
                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label">Salary Grade</label>
                                                                <label class="mp-input-group__label value">{{ $member->salary_grade }}</label>
                                                            </div>
                                                            <!-- <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label">SG Category</label>
                                                                <label class="mp-input-group__label value">SG 1-15</label>
                                                            </div> -->


                                                        </div>

                                                        <div class="card-body  mp-ph3 d-flex flex-column member-detail-body open-details">
                                                            <label class="personal-details-title">Membership Details</label>

                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label">Membership Contribution Type</label>
                                                                <label class="mp-input-group__label value">{{ $member->contribution_type }}</label>
                                                            </div>
                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label">Monthly Contribution Amount</label>
                                                                <label class="mp-input-group__label value">PHP: {{ $member->contribution }}</label>
                                                            </div>

                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label">Cocolife Insurance</label>
                                                                <label class="mp-input-group__label value">{{ $member->with_cocolife_form == 1? 'Yes' : 'No' }}</label>
                                                            </div>
                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label">Proxy Form Validity</label>
                                                                <label class="mp-input-group__label value">No Details</label>
                                                            </div>



                                                        </div>



                                                    </div>
                                                </div>


                                                <br>


                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <div class="col-lg-7 mp-pr0 mp-mt2 " id="statementDiv" style="width: 100%;">
                                <div class="mp-card mp-p4" style="padding:20px;">

                                    <div style="color: white;
                                            padding: 15px;
                                            background-color: var(--c-active-hover-bg);
                                            margin: 0;width: 100%;">Statement of Account
                                        <div class="info-text">
                                            <label style="color:white;">As of: {{ date('m/d/Y') }}</label>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-lg-6" style="padding-right:0px;">
                                            <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3 member-form mp-pv2 shadow-inset-1">
                                                <h3>Your Members Equity</h3>
                                                <div class="mp-input-group details-div">
                                                    <label class="mp-input-group__label">Total Members Contribution</label>
                                                    <label class="mp-input-group__label value">PHP {{ number_format($contributions['membercontribution'], 2) }}</label>
                                                </div>
                                                <div class="mp-input-group details-div">
                                                    <label class="mp-input-group__label">Total UP Contribution</label>
                                                    <label class="mp-input-group__label value">PHP {{ number_format($contributions['upcontribution'], 2) }}</label>
                                                </div>
                                                <div class="mp-input-group details-div">
                                                    <label class="mp-input-group__label">Earnings on Members Contribution</label>
                                                    <label class="mp-input-group__label value">PHP {{ number_format($contributions['emcontribution'], 2) }}</label>
                                                </div>
                                                <div class="mp-input-group details-div">
                                                    <label class="mp-input-group__label">Earnings on UP Contribution</label>
                                                    <label class="mp-input-group__label value">PHP {{ number_format($contributions['eupcontribution'], 2) }}</label>
                                                </div>

                                                <div class="mp-input-group details-div">
                                                    <label class="mp-input-group__label">
                                                        Total Equity Balance
                                                    </label>
                                                    <label class="mp-input-group__label value">
                                                        <h2>PHP {{ number_format($totalcontributions, 2) }}</h2>
                                                    </label>

                                                </div>


                                            </div>
                                        </div>
                                        <div class="col-lg-6" style="padding-left:0px;">
                                            <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3 member-form mp-pv2 shadow-inset-1" style="height: 100%;">


                                                @if (!empty($outstandingloans))
                                                <h3>Your Outstanding Loan</h3>
                                                @foreach ($outstandingloans as $oloans)
                                                <div class="mp-input-group details-div">
                                                    <label class="mp-input-group__label">{{ $oloans->type }}</label>
                                                    <label class="mp-input-group__label value">PHP {{ number_format($oloans->balance, 2) }}</label>
                                                </div>
                                                @endforeach
                                                <hr class="mp-mt3">
                                                <div class="mp-input-group details-div">
                                                    <label class="mp-input-group__label">
                                                        Total Outstanding Loan Balance
                                                    </label>
                                                    <label class="mp-input-group__label value">
                                                        <h2>PHP {{ number_format($totalloanbalance, 2) }}</h3>
                                                    </label>
                                                </div>
                                                @endif



                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-1g-12" style="padding:15px;">
                                            <div class="d-flex flex-column">
                                                <div class="header-table">
                                                    <h3>Member's Equity History</h3>
                                                    <div class="info-text">
                                                        <label style="margin-top: -13px;margin-bottom: 10px;">Recent Transaction</label>
                                                    </div>
                                                    <div class="info-text">
                                                        <label style="margin-top: -13px;margin-bottom: 10px;">As of:
                                                            {{ date('m/d/Y', strtotime($recentcontributions[0]->date)) }}

                                                        </label>
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
                                                                    <span>Amount</span>
                                                                </th>

                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                <div class="body-table">
                                                    <table class="payroll-table" style="height: auto;" width="100%">
                                                        <tbody>
                                                            @foreach ($recentcontributions as $contribution)
                                                            <tr>
                                                                <td>{{ date('m/d/Y', strtotime($contribution->date)) }}</td>
                                                                <td>{{ $contribution->reference_no }}</td>
                                                                <td>{{ $contribution->name }}</td>
                                                                <td class="mp-text-right">PHP {{ number_format($contribution->amount, 2) }}
                                                                </td>
                                                            </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-1g-12" style="padding:15px;">
                                            <div class="d-flex flex-column">
                                                <div class="header-table">
                                                    <h3>Loan Transaction History</h3>
                                                    <div class="info-text">
                                                        <label style="margin-top: -13px;margin-bottom: 10px;">Recent Transaction</label>
                                                    </div>
                                                    <div class="info-text">
                                                        <label style="margin-top: -13px;margin-bottom: 10px;">As of:
                                                            @foreach ($recentloans as $loans)
                                                            @if ($loans[0] != null)
                                                            {{ $loans[0]->date  }}
                                                            @endif
                                                            @endforeach
                                                        </label>
                                                    </div>
                                                    <table class="payroll-table" style="height: auto;" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>Account</th>
                                                                <th class="mp-text-center">Monthly Amort.</th>
                                                                <th class="mp-text-center">Amount</th>
                                                                <th class="mp-text-right">Principal Balance</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                <div class="body-table">
                                                    <table class="payroll-table" style="height: auto;" width="100%">
                                                        <tbody>

                                                            <?php $date = ''; ?>
                                                            @foreach ($recentloans as $loans)
                                                            <?php
                                                            $samedate = true;
                                                            if ($date == date('m/d/Y', strtotime($loans->date))) {
                                                                $samedate = false;
                                                            } else {
                                                                $samedate = true;
                                                            }
                                                            $date = date('m/d/Y', strtotime($loans->date));
                                                            ?>
                                                            <tr>
                                                                <td>{{ date('m/d/Y', strtotime($date)) }}</td>
                                                                <td class="mp-text-center">{{ $loans->name }}</td>
                                                                <td class="mp-text-center">
                                                                    {{ $loans->amortization == 0 ? '' : 'PHP ' . number_format($loans->amortization, 2) }}
                                                                </td>
                                                                <td class="mp-text-center">{{ 'PHP ' . number_format($loans->amount, 2) }}
                                                                </td>
                                                                <td class="mp-text-right">
                                                                    {{ !$samedate ? '' : 'PHP ' . number_format($loans->balance, 2) }}
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                            <!-- <tr>
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


                                                            </tr> -->

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-7 mp-pr0 mp-mt2 d-none opacity-0" id="beneficiariesDiv" style="width: 100%;">
                                <div style="color: white;
                                            padding: 15px;
                                            background-color: var(--c-accent);
                                            margin: 0;width: 100%;">
                                    <label>Add New Beneficiaries</label>
                                    <label class="x-button" id="x-button"><i class="fa fa-times-circle" aria-hidden="true"></i></label>

                                </div>
                                <div class="mp-card mp-p4" style="padding:20px;">

                                    <form id="users_form" class=" form-border-bottom">

                                        <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3  mp-pv2 ">


                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Full Name</label>
                                                <input class="mp-input-group__input mp-text-field" type="text" name="bene_fullname" id="bene_fullname" required />
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Relationship</label>
                                                <input class="mp-input-group__input mp-text-field" type="text" name="bene_relationship" id="bene_relationship" required />
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Birthdate</label>
                                                <input class="mp-input-group__input mp-text-field" type="date" name="bene_birthdate" id="bene_birthdate" required />
                                            </div>

                                            <a id="save_beneficiaries" class="up-button btn-md button-animate-right mp-text-center" id="save_users" name="save_users" type="submit">
                                                <span class="save_beneficiaries">Add New Record</span>
                                            </a>
                                            <a id="clear_beneficiaries" class="up-button-grey btn-md button-animate-right mp-text-center" id="cancel">
                                                <span class="clear_beneficiaries">Clear</span>
                                            </a>


                                        </div>

                                    </form>
                                    <br>
                                    <div class="mp-input-group">
                                        <label class="mp-input-group__label">Beneficiaries Records</label>
                                        <table class="permission-table" style="width: 100%; transform: scale(1);" id="member-beneficiries">
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
                                <div style="color: white;
                                            padding: 15px;
                                            background-color: var(--c-accent);
                                            margin: 0;width: 100%;">
                                    <label>Membership Status</label>
                                    <label class="x-button" id="x-button"><i class="fa fa-times-circle" aria-hidden="true"></i></label>
                                </div>
                                <div class="mp-card mp-p4 mp-mb2" style="padding:20px; height:auto;">
                                    <div class="status-container">
                                        <div class="mp-input-group">
                                            <label class="mp-input-group__label">Current Status:</label>
                                            @if ($member->membership_status == 'ACTIVE')
                                            <label class="mp-input-group__label" style="font-weight: bold; color: var(--c-primary);">{{$member->membership_status }}</label>
                                            @else
                                            <label class="mp-input-group__label" style="font-weight: bold; color: red;">{{$member->membership_status }}</label>
                                            @endif

                                        </div>
                                        <div class="mp-input-group">
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label" style="margin-top: 10px;float: left;">Change Status</label>
                                                <select class="mp-input-group__input mp-text-field" value="{{$member->membership_status }}" name="status_select" id="status_select" required>
                                                    @if ($member->membership_status == 'ACTIVE')
                                                    <option value="ACTIVE" selected>ACTIVE</option>
                                                    @else
                                                    <option value="ACTIVE">ACTIVE</option>
                                                    @endif

                                                    @if ($member->membership_status == 'RETIRED')
                                                    <option value="RETIRED" selected>RETIRED</option>
                                                    @else
                                                    <option value="RETIRED">RETIRED</option>
                                                    @endif

                                                    @if ($member->membership_status == 'RESIGNED')
                                                    <option value="RESIGNED" selected>RESIGNED</option>
                                                    @else
                                                    <option value="RESIGNED">RESIGNED</option>
                                                    @endif

                                                    @if ($member->membership_status == 'WITHDREW')
                                                    <option value="WITHDREW" selected>WITHDREW</option>
                                                    @else
                                                    <option value="WITHDREW">WITHDREW</option>
                                                    @endif

                                                    @if ($member->membership_status == 'DECEASED')
                                                    <option value="DECEASED" selected>DECEASED</option>
                                                    @else
                                                    <option value="DECEASED">DECEASED</option>
                                                    @endif

                                                </select>
                                            </div>
                                        </div>
                                        <a class="up-button btn-md button-animate-right mp-text-center mp-mt2" id="update_status" name="update_status" type="submit">
                                            <span class="save_up">Update Status</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="mp-card mp-p4" style="padding:20px;">


                                    <div class="tab">
                                        <div class="tooltip">
                                            <button class="active-tab" id="update_personal_button" style="border-top-left-radius: 10px;">
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                            </button>
                                            <span class="tooltiptext">Personal & Employee Details</span>
                                        </div>

                                        <div class="tooltip">

                                            <button style="border-top-right-radius: 10px;" id="update_membership_button"><i class="fa fa-users" aria-hidden="true"></i></button>
                                            <span class="tooltiptext">Membership Details</span>
                                        </div>


                                    </div>
                                    <form id="users_form" class=" form-border-bottom">

                                        <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3  mp-pv2 " id="update_personal_div">
                                            <input type="hidden" id="users_id" name="users_id">
                                            <!-- <label class="mp-text-fs-medium">Personal Information</label> -->
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">First Name</label>
                                                <input class="mp-input-group__input mp-text-field" type="text" value="{{$member->first_name }}" name="first_name" id="first_name" />
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Middle Name</label>
                                                <input class="mp-input-group__input mp-text-field" type="text" value="{{$member->middle_name }}" name="middle_name" id="middle_name" />
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Last Name</label>
                                                <input class="mp-input-group__input mp-text-field" type="text" value="{{$member->last_name }}" name="last_name" id="last_name" />
                                            </div>
                                            <!-- <div class="mp-input-group">
                                                <label class="mp-input-group__label">Campus</label>
                                                <select class="mp-input-group__input mp-text-field" name="user_level" id="user_level" required>
                                                    <option value="">Select Campus</option>
                                                    <option value=" ">Campus 1</option>
                                                </select>
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Department</label>
                                                <select class="mp-input-group__input mp-text-field" name="user_level" id="user_level" required>
                                                    <option value="">Select Department</option>
                                                    <option value=" ">Department 1</option>
                                                </select>
                                            </div> -->
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Position</label>
                                                <input class="mp-input-group__input mp-text-field" value="{{ $member->position_id }}" type="text" name="position_id" id="position_id" />
                                            </div>
                                            <!-- <div class="mp-input-group">
                                                <label class="mp-input-group__label">Appointment Date</label>
                                                <input class="mp-input-group__input mp-text-field" type="date" name="email_add" id="email_add" />
                                            </div> -->
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Membership Date</label>
                                                <input class="mp-input-group__input mp-text-field" value="{{ $member->membership_date }}" type="date" name="membership_date" id="membership_date" />
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Cellphone Number</label>
                                                <input class="mp-input-group__input mp-text-field" type="text" value="{{ $member->contact_no }}" name="contact_no" id="contact_no" />
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Landline Number</label>
                                                <input class="mp-input-group__input mp-text-field" type="text" value="{{ $member->landline }}" name="landline" id="landline" />
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Gender</label>
                                                <select class="mp-input-group__input mp-text-field" id="gender" required>
                                                    @if ($member->gender == 'FEMALE')
                                                    <option value="FEMALE" selected>Female</option>
                                                    @else
                                                    <option value="FEMALE">Female</option>
                                                    @endif

                                                    @if ($member->gender == 'MALE')
                                                    <option value="MALE" selected>Male</option>
                                                    @else
                                                    <option value="MALE">Male</option>
                                                    @endif

                                                </select>
                                            </div>

                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Employee Number</label>
                                                <input class="mp-input-group__input mp-text-field" value="{{ $member->employee_no }}" type="text" id="employee_no" />
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Monthly Salary</label>
                                                <input class="mp-input-group__input mp-text-field" value="{{ $member->monthly_salary }}" type="text" id="monthly_salary" />
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Status Appointment</label>
                                                <select class="mp-input-group__input mp-text-field" value="{{ $member->appointment_status }}" name="appointment_status" id="appointment_status" required>

                                                    @if ($member->appointment_status == 'PERMANENT')
                                                    <option value="PERMANENT" selected>PERMANENT</option>
                                                    @else
                                                    <option value="PERMANENT">PERMANENT</option>
                                                    @endif

                                                    @if ($member->appointment_status == 'CONTRACTUAL')
                                                    <option value="CONTRACTUAL" selected>CONTRACTUAL</option>
                                                    @else
                                                    <option value="CONTRACTUAL">CONTRACTUAL</option>
                                                    @endif

                                                    @if ($member->appointment_status == 'TEMPORARY')
                                                    <option value="TEMPORARY" selected>TEMPORARY</option>
                                                    @else
                                                    <option value="TEMPORARY">TEMPORARY</option>
                                                    @endif

                                                    @if ($member->appointment_status == 'JOB ORDER')
                                                    <option value="JOB ORDER" selected>JOB ORDER</option>
                                                    @else
                                                    <option value="JOB ORDER">JOB ORDER</option>
                                                    @endif


                                                </select>
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Permanent Address</label>
                                                <input class="mp-input-group__input mp-text-field" value="{{ $member->permanent_address }}" type="text" id="permanent_address" />
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Current Address</label>
                                                <input class="mp-input-group__input mp-text-field" value="{{ $member->current_address }}" type="text" id="current_address" />
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Tin</label>
                                                <input class="mp-input-group__input mp-text-field" value="{{ $member->tin }}" type="text" id="tin" />
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Birthdate</label>
                                                <input class="mp-input-group__input mp-text-field" value="{{ $member->birth_date }}" type="date" id="birth_date" />
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Email</label>
                                                <input class="mp-input-group__input mp-text-field" value="{{ $member->email }}" type="email" id="email" />
                                            </div>
                                            <a class="up-button btn-md button-animate-right mp-text-center" id="update_member_details" name="update_member_details" type="submit">
                                                <span class="save_up">Update Record</span>
                                            </a>

                                            <!-- <button type="submit" class="sss" id="btn-submit">Submit</button> -->

                                        </div>


                                        <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3  mp-pv2 d-none opacity-0" id="update_membership_div">
                                            <div class="mp-input-group">
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
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Monthly Contribution Amount</label>
                                                <input class="mp-input-group__input mp-text-field" type="text" value="{{$member->contribution }}" name="contribution" id="contribution" />
                                            </div>
                                            <div class="mp-input-group">
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
                                            <!-- <div class="mp-input-group">
                                                <label class="mp-input-group__label">Proxy Form Validity</label>

                                            </div> -->

                                            <a class="up-button btn-md button-animate-right mp-text-center" id="update_other_member_details" name="update_other_member_details" type="submit">
                                                <span class="save_up">Update Record</span>
                                            </a>

                                            <!-- <button type="submit" class="sss" id="btn-submit">Submit</button> -->

                                        </div>

                                    </form>
                                    <br>

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





<script>
    //reusable functions
    function resetBeneficiaryForm() {
        $('#bene_fullname').val('').trigger("change");
        $('#bene_relationship').val('').trigger("change");
        $('#bene_birthdate').val('').trigger("change");
    }

    $(document).ready(function() {

        //disable letters function
        $(function() {
            var regExp = /[a-z]/i;
            $('#monthly_salary').on('keydown keyup', function(e) {
                var value = String.fromCharCode(e.which) || e.key;
                // No letters
                if (regExp.test(value)) {
                    e.preventDefault();
                    return false;
                }
            });
            $('#contribution').on('keydown keyup', function(e) {
                var value = String.fromCharCode(e.which) || e.key;
                // No letters
                if (regExp.test(value)) {
                    e.preventDefault();
                    return false;
                }
            });

        });


        var memberBeneficiaries = $('#member-beneficiries').DataTable({
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

        //old beneficiaries add clicked
        $(document).on('click', '#save_beneficiaries', function() {
            var member_no = <?php echo $member->member_no ?>;
            var fullname = $('#bene_fullname').val();
            var relationship = $('#bene_relationship').val();
            var birthdate = $('#bene_birthdate').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            Swal.fire({
                title: "Are you sure?",
                text: "You will add this beneficiary!",
                type: "warning",
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Confirm',
                cancelButtonText: "Cancel",
                showCancelButton: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
            }).then((okay) => {
                if (okay.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('add_member_oldbeneficiaries') }}",
                        data: {
                            member_no: member_no,
                            beni_name: fullname,
                            birth_date: birthdate,
                            relationship: relationship,
                        },
                        success: function(data) {
                            console.log(data)
                            if (data.success == true) {
                                resetBeneficiaryForm();
                                memberBeneficiaries.draw();
                            }
                        }
                    });
                } else if (okay.isDenied) {
                    Swal.close();
                }
            });

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
                type: "warning",
                confirmButtonColor: '#DD6B55',
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
                                memberBeneficiaries.draw();
                            }
                        }
                    });
                } else if (okay.isDenied) {
                    Swal.close();
                }
            });

        })


    });



    $(document).on('click', '#update_status', function(e) {
        var member_id = <?php echo $member->member_no ?>;
        var status = $('#status_select').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        Swal.fire({
            title: "Are you sure?",
            text: "You will change the status of this member!",
            type: "warning",
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Confirm',
            cancelButtonText: "Cancel",
            showCancelButton: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
        }).then((okay) => {
            if (okay.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('update_member_status') }}",
                    data: {
                        member_id: member_id,
                        status: status
                    },
                    success: function(data) {
                        if (data.success == true) {
                            $('#loading').show();
                            location.reload();
                        } else {
                            Swal.fire({
                                title: "No Changes Made!",
                                type: "error",
                                confirmButtonColor: '#DD6B55',
                            })
                        }
                    }
                });
            } else if (okay.isDenied) {
                Swal.close();
            }
        });

    })


    //clear beneficiaries click
    $(document).on('click', '#clear_beneficiaries', function() {
        resetBeneficiaryForm();
    })

    $(document).on('click', '#update_personal_button', function() {
        $('#update_personal_button').addClass('active-tab');
        $('#update_membership_button').removeClass('active-tab');

        $('#update_personal_div').removeClass("d-none");
        $('#update_personal_div').removeClass("opacity-0");

        if ($('#update_membership_div').hasClass('d-none') && $('#update_membership_div').hasClass('opacity-0')) {
            return
        } else {
            $('#update_membership_div').addClass("d-none");
            $('#update_membership_div').addClass("opacity-0");
        }

    })

    $(document).on('click', '#update_membership_button', function() {
        $('#update_membership_button').addClass('active-tab');
        $('#update_personal_button').removeClass('active-tab');

        $('#update_membership_div').removeClass("d-none");
        $('#update_membership_div').removeClass("opacity-0");

        if ($('#update_personal_div').hasClass('d-none') && $('#update_personal_div').hasClass('opacity-0')) {
            return
        } else {
            $('#update_personal_div').addClass("d-none");
            $('#update_personal_div').addClass("opacity-0");
        }

    })

    //update member details click
    $(document).on('click', '#update_member_details', function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var user_id = <?php echo $member->user_id ?>;
        var member_no = <?php echo $member->member_no ?>;
        var first_name = $('#first_name').val();
        var middle_name = $('#middle_name').val();
        var last_name = $('#last_name').val();
        var position_id = $('#position_id').val();
        var membership_date = $('#membership_date').val();
        var contact_no = $('#contact_no').val();
        var landline = $('#landline').val();
        var gender = $('#gender').val();
        var employee_no = $('#employee_no').val();
        var appointment_status = $('#appointment_status').val();
        var permanent_address = $('#permanent_address').val();
        var current_address = $('#current_address').val();
        var tin = $('#tin').val();
        var birth_date = $('#birth_date').val();
        var email = $('#email').val();
        var monthly_salary = $('#monthly_salary').val();

        Swal.fire({
            title: "Are you sure?",
            text: "You will change this member's details!",
            type: "warning",
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Confirm',
            cancelButtonText: "Cancel",
            showCancelButton: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
        }).then((okay) => {
            if (okay.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('update_member_details') }}",
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
                        monthly_salary: monthly_salary,
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
                                confirmButtonColor: '#DD6B55',
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
    $(document).on('click', '#update_other_member_details', function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var member_no = <?php echo $member->member_no ?>;
        var contribution_type = $('#contribution_type').val();
        var contribution = $('#contribution').val();
        var with_cocolife_form = $('#with_cocolife_form').val();
        Swal.fire({
            title: "Are you sure?",
            text: "You will change this member's membership details!",
            type: "warning",
            confirmButtonColor: '#DD6B55',
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
                                confirmButtonColor: '#DD6B55',
                            })
                        }
                    }
                });
            } else if (okay.isDenied) {
                Swal.close();
            }
        });
    });

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
    });

    $(document).on('click', '#view_beneficiaries', function(e) {

        $("#beneficiariesDiv").removeClass("d-none")
        $("#beneficiariesDiv").removeClass("opacity-0")

        $("#memberstatusDiv").addClass("d-none")
        $("#memberstatusDiv").addClass("opacity-0")
        $("#statementDiv").addClass("d-none")
        $("#statementDiv").addClass("opacity-0")

    })

    $(document).on('click', '#modify_contributions', function(e) {

        $("#memberstatusDiv").removeClass("d-none")
        $("#memberstatusDiv").removeClass("opacity-0")

        $("#statementDiv").addClass("d-none")
        $("#statementDiv").addClass("opacity-0")
        $("#beneficiariesDiv").addClass("d-none")
        $("#beneficiariesDiv").addClass("opacity-0")

    });
    $(document).on('click', '#x-button', function(e) {
        $("#statementDiv").removeClass("d-none")
        $("#statementDiv").removeClass("opacity-0")

        $("#memberstatusDiv").addClass("d-none")
        $("#memberstatusDiv").addClass("opacity-0")
        $("#beneficiariesDiv").addClass("d-none")
        $("#beneficiariesDiv").addClass("opacity-0")

    })
</script>
@endsection