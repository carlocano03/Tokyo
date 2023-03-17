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

    const links = ['', '', '', '']

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
            <span class="mp-text-fs-small">
                Lorem ipsum dolor sit am
            </span>
        </div>
        <div class="item flex-column gap-5 mp-ph3 mp-pv3 active" id="sider-item" data-set="1">
            <span>
                Master List
            </span>
            <span class="mp-text-fs-small">
                Lorem ipsum dolor sit amet
            </span>
        </div>
        <div class="item flex-column gap-5 mp-ph3 mp-pv3 " id="sider-item" data-set="2">
            <span>
                Members Summary Reports
            </span>
            <span class="mp-text-fs-small">
                Lorem ipsum dolor sit amet
            </span>
        </div>
        <div class="item flex-column gap-5 mp-ph3 mp-pv3" id="sider-item" data-set="3">
            <span>
                Contribution Reports
            </span>
            <span class="mp-text-fs-small">
                Lorem ipsum dolor sit amet
            </span>
        </div>
        <div class="item flex-column gap-5 mp-ph3 mp-pv3" id="sider-item" data-set="3">
            <span>
                Insurance Reports
            </span>
            <span class="mp-text-fs-small">
                Lorem ipsum dolor sit amet
            </span>
        </div>
        <div class="item flex-column gap-5 mp-ph3 mp-pv3" id="sider-item" data-set="3">
            <span>
                Members Voter List
            </span>
            <span class="mp-text-fs-small">
                Lorem ipsum dolor sit amet
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
                                                                    font-weight: 500;"> Active</span>


                                                    <span style="color: #7c7272;"> Member ID: </span>

                                                    <span style="font-size: 25px;
                                                                margin-top:-5px;
                                                                color: black;
                                                                font-weight: bold;">20022232</span>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="info-text">
                                                    <h1>Gomez, Mark Denneb</h1>
                                                    <label>System Admin</label>
                                                    <label>ADMINISTRITIVE OFFICE IV</label>
                                                </div>

                                                <div class="info-text-number">

                                                    <label><i class="fa fa-envelope-o" aria-hidden="true"></i> markdennebg@gmail.com</label>
                                                    <label style="float:right;"><i class="fa fa-phone" aria-hidden="true"></i>+639262586168</label>
                                                </div>

                                                <div class="profile-buttons  col-12 mp-mb3 ">
                                                    <button class="up-button-green btn-md button-animate-right mp-text-center" id="save_class" type="submit">
                                                        <span>View Beneficiaries</span>
                                                    </button>
                                                    <button class="up-button btn-md button-animate-right mp-text-center">
                                                        <span>Modify Contributions</span>
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
                                                                <label class="mp-input-group__label value">Purok 5 Sapang Jaen Nueva Ecija</label>
                                                            </div>
                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label">Current Address:</label>
                                                                <label class="mp-input-group__label value">Purok 5 Sapang Jaen Nueva Ecija</label>
                                                            </div>

                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label">Birthday </label>
                                                                <label class="mp-input-group__label value">May 6, 1999</label>
                                                            </div>
                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label"> Civil Status</label>
                                                                <label class="mp-input-group__label value">Single</label>
                                                            </div>
                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label">Landline No </label>
                                                                <label class="mp-input-group__label value">12313128</label>
                                                            </div>
                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label">Gender</label>
                                                                <label class="mp-input-group__label value">Male</label>
                                                            </div>
                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label">Citizenship</label>
                                                                <label class="mp-input-group__label value">FIlipino</label>
                                                            </div>
                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label">Tin No</label>
                                                                <label class="mp-input-group__label value">123123123</label>
                                                            </div>

                                                        </div>

                                                        <div class="card-body  mp-ph3 d-flex flex-column member-detail-body open-details">
                                                            <label class="personal-details-title">Employee Details</label>

                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label">Employee No.</label>
                                                                <label class="mp-input-group__label value">12312312</label>
                                                            </div>
                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label">Original Appointment Date</label>
                                                                <label class="mp-input-group__label value">May 6, 1999</label>
                                                            </div>

                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label">Appointment Status</label>
                                                                <label class="mp-input-group__label value">May 6, 1999</label>
                                                            </div>
                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label"> Monthly Salary</label>
                                                                <label class="mp-input-group__label value">16,000</label>
                                                            </div>
                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label">Salary Grade</label>
                                                                <label class="mp-input-group__label value">6</label>
                                                            </div>
                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label">SG Category</label>
                                                                <label class="mp-input-group__label value">SG 1-15</label>
                                                            </div>


                                                        </div>

                                                        <div class="card-body  mp-ph3 d-flex flex-column member-detail-body open-details">
                                                            <label class="personal-details-title">Membership Details</label>

                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label">Membership Contribution Type</label>
                                                                <label class="mp-input-group__label value">Fixed</label>
                                                            </div>
                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label">Monthly Contribution Amount</label>
                                                                <label class="mp-input-group__label value">PHP: 1,600</label>
                                                            </div>

                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label">AXA Insurance</label>
                                                                <label class="mp-input-group__label value">Yes</label>
                                                            </div>
                                                            <div class="mp-input-group details-div">
                                                                <label class="mp-input-group__label">Proxy Form Validity</label>
                                                                <label class="mp-input-group__label value">May 6, 1999</label>
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
                            <div class="col-lg-7 mp-pr0 mp-mt2" style="width: 100%;">
                                <div class="mp-card mp-p4" style="padding:20px;">

                                    <div style="color: white;
                                            padding: 15px;
                                            background-color: var(--c-active-hover-bg);
                                            margin: 0;width: 100%;">Statement of Account
                                        <div class="info-text">
                                            <label style="color:white;">As of: May 6, 1999 - 10:00pm</label>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-lg-6" style="padding-right:0px;">
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
                                        <div class="col-lg-6" style="padding-left:0px;">
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
                                                        <label style="margin-top: -13px;margin-bottom: 10px;">As of: May 6, 1999 - 10:00pm</label>
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


                                    <div class="row">
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
                        </div>


                    </div>


                </div>

            </div>
        </div>

    </div>
</div>





<script>
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
</script>
@endsection