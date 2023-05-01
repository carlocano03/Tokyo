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
    
    .payroll-table>thead>tr>th{
        min-width: 100px;
    }
    .payroll-table>tbody>tr>td{
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
        .payroll-table{
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

                                                


                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="mp-card h-auto">
                                    <div class="container-fluid mp-mt2 gap-10">
                                        <div class="row justify-content-end mp-mt2">
                                            <div class="col-12">
                                                <h2 for=""  class="font-bold mp-mb0 magenta-clr">SELECT LOAN OFFER</h2>
                                            </div>
                                        </div>
                                        <hr class="magenta-bg">
                                        <div class="row maroon-bg mp-mt3 cursor-pointer">
                                           <div class="col-12 mp-mt2">
                                                <label for="" class="white-clr font-bold mp-text-fs-medium">(PEL) Personal Equity Loan</label>
                                           </div>
                                        </div>
                                        <div class="row gray-bg-light mp-mt3 cursor-pointer">
                                           <div class="col-12 mp-mt2">
                                                <label for="" class="black-clr font-bold mp-text-fs-medium">(CBL) Co Borrower Plan</label>
                                           </div>
                                        </div>
                                        <div class="row gray-bg-light mp-mt3 cursor-pointer">
                                           <div class="col-12 mp-mt2">
                                                <label for="" class="black-clr font-bold mp-text-fs-medium">(BL) Bridge Loan</label>
                                           </div>
                                        </div>
                                        <div class="row gray-bg-light mp-mt3 cursor-pointer">
                                           <div class="col-12 mp-mt2">
                                                <label for="" class="black-clr font-bold mp-text-fs-medium">(EML) Emergency Loan</label>
                                           </div>
                                        </div>
                                        <div class="row gray-bg-light mp-mt3 cursor-pointer mp-mb3">
                                           <div class="col-12 mp-mt2">
                                                <label for="" class="black-clr font-bold mp-text-fs-medium">(BTL) Balance Transfer Loan</label>
                                           </div>
                                        </div>
                                        <div class="row mp-mb2">
                                            <div class="col-12">
                                                <div class="info-text">
                                                    <label class="link_style magenta-clr mp-text-right mp-text-fs-medium">Generate SOA</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>


                            <div class="col-lg-4 mp-pr0 mp-mt2 " id="statementDiv" style="width: 100%;">
                                <div class="row mp-mb2">
                                    <div class="col-md-12">
                                    <div class="card-container card p-0">
                                        <div class="card-header d-flex magenta-bg">
                                            <span>Personal Equity Loan (PEL)</span>
                                        </div>
                                            <div class="card-body justify-content-center gap-10 flex-row p-0 mp-ph2">
                                                <div class="container-fluid no-gutters black-clr">
                                                    <div class="row">
                                                        <div class="col-12 items-between d-flex mp-mt2">
                                                            <span for="" class="mp-text-fs-small font-bold mp-mt1">ELIGIBILITY</span>
                                                            <span for="" class="mp-text-fs-xsmall green-bg" style="padding: 5px; border-radius: 10px; margin-bottom: 0px; padding-top: 3px; padding-bottom: 2px">Qualified</span>
                                                        </div>
                                                    </div>
                                                    <div class="row mp-mt2">
                                                        <div class="col-12">
                                                            <div class="info-text">
                                                            <label for="">- Members must be in good standing</label>
                                                            <label for="">- The net take home pay for month is greater than P5,000.00 (Amount Changes, depending on General Appropriations Act  passed by Congress DBM rule)</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-12 items-between d-flex mp-mt2">
                                                            <span for="" class="mp-text-fs-small font-bold mp-mt1">AMOUNT OF LOAN</span>
                                                            <span for="" class="mp-text-fs-xsmall maroon-bg white-clr" style="padding: 5px; border-radius: 10px; margin-bottom: 0px; padding-top: 3px; padding-bottom: 2px">Not Qualified</span>
                                                        </div>
                                                    </div>
                                                    <div class="row mp-mt2">
                                                        <div class="col-12">
                                                            <div class="info-text">
                                                            <label for="">- Less than 4 years of service - up to 75% of equity</label>
                                                            <label for="">- 4 year but less than 15 years of service - up to 85% of equity</label>
                                                            <label for="">- At least 15 year of service - 100% of uquity.</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <span for="" class="mp-text-fs-small font-bold mp-mt1">OTHER DETAILS</span>
                                                        </div>
                                                    </div>
                                                    <div class="row mp-mt2">
                                                        <div class="col-5">
                                                            <div class="info-text">
                                                                <label for="" class="font-bold">Service Fee:</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-7">
                                                            <div class="info-text">
                                                                <label for="" class="">Php 200.00</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mp-mt2">
                                                        <div class="col-5">
                                                            <div class="info-text">
                                                            <label for="" class="font-bold">Interest Rates:</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-7">
                                                            <div class="info-text">
                                                                <label for="" class="">12% for annum for 1 to 3 yrs to pay</label>
                                                                <label for="" class="">13% for annum for 4 yrs to pay</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="info-text">
                                                                <label for="" class="font-bold">Payment Terms:</label>
                                                                <label for="" class="">P10,000 and below - one year (1)</label>
                                                                <label for="" class="">P10,001 - P29,999 - two year (2)</label>
                                                                <label for="" class="">P30,001 - 99,999 - three year (3)</label>
                                                                <label for="" class="">P100,001 - above - four year (4)</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mp-mt2">
                                                        <div class="col-6">
                                                            <div class="info-text">
                                                            <label for="" class="font-bold">Mode of Payment:</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="info-text">
                                                                <label for="" class="">Salary Deduction</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="info-text">
                                                            <label for="" class="font-bold">Repricing:</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="info-text">
                                                                <label for="" class="">None</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="info-text">
                                                            <label for="" class="font-bold">Co-Borrowers:</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="info-text">
                                                                <label for="" class="">None</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="info-text">
                                                            <label for="" class="font-bold">Reloan:</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mp-mt0">
                                                            <div class="info-text">
                                                            <label for="">- A member can reloan after paying the equivalent of three months amortization. Balance of the existing loan may not be deducted from the proceeds of the new loan.</label>
                                                            <label for="">- The borrower is allowed to use the proceeds of the renewed PEL to pay for the BL and EML.</label>
                                                            <label for="">- At least 15 year of service - 100% of uquity.</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mp-mt2">
                                                            <div class="info-text">
                                                            <label for="" class="font-bold">Delinquency:</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mp-mt0">
                                                            <div class="info-text">
                                                            <label for="">Borrowers who fail to pay after three (3) months of the required monthly ammortization is considered deliquent subject to surcharge of 1/2 of 1% per month, compounded family, applied to the amount due (principal + interest). Delinquent loans are offset against Member's Equity one (1) year from the date of default.</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mp-mt2">
                                                            <div class="info-text">
                                                            <label for="" class="font-bold">Surcharge:</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mp-mt0">
                                                            <div class="info-text">
                                                            <label for="">1/2 of 1% per month, compounded monthly</label>
                                                            </div>
                                                        </div>
                                                        <div class="profile-buttons  col-12 mp-mt2">
                                                            <button class="up-button btn-md mp-text-center" id="view_profile" type="button">
                                                                <span>APPLY FOR LOANS</span>
                                                            </button>    
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                
                            </div>
                            
                            <div class="col-lg-4 mp-pr0 mp-mt2" style="width: 100%;">
                                <div class="br-top-2 row" 
                                    style="color: white;
                                            padding: 5px 10px;
                                            background-color: var(--c-accent);
                                            margin: 0;width: 100%;">LOAN CALCULATOR

                                </div>
                                <div class="mp-card mp-p4 h-auto" style="padding:20px;">

                                  
                                        <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3  mp-pv2">
                                            <input type="hidden" id="users_id" name="users_id">
                                            <!-- <label class="mp-text-fs-medium">Personal Information</label> -->
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label font-bold magenta-clr mp-mb2">SELECT TYPE OF LOAN</label>
                                                <select class="js-example-responsive mp-input-group__input mp-text-field" style="width:100%; " required>
                                                    <option value="">Select Loan Type</option>
                                                    <option value="">(PEL) Personal Equity Loan</option>
                                                    <option value="">(CBL) Co Borrower Plan</option>
                                                    <option value="">(BL) Bridge Loan</option>
                                                    <option value="">(EML) Emergency Loan</option>
                                                    <option value="">(BTL) Balance Transfer Loan</option>
                                                </select>
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label font-bold magenta-clr">DESIRED AMOUNT</label>
                                                <input class="mp-input-group__input mp-text-field" type="text" name="middlename" id="middlename" required />
                                            </div>

                                            
                                            <!-- <button type="submit" class="sss" id="btn-submit">Submit</button> -->
                                            
                                        </div>

                                   
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-12">
                                                <h3>
                                                    Result
                                                </h3>
                                            </div>
                                            <div class="col-12 mp-mt2">
                                                <h4 class="mb-0">
                                                    Loan Type:
                                                </h4>
                                            </div>
                                            <div class="col-12">
                                                <h4>
                                                    (PEL) - Personal Equity Loan
                                                </h4>
                                            </div>
                                        </div>
                                        <div class="row" style="overflow-y: auto;">
                                            <div class="col-1g-12" style="padding:15px;">
                                                <div class="d-flex flex-column">
                                                    <div class="header-table">
                                                        <table class="payroll-table" style="height: auto;" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>
                                                                        <span>Matrix</span>
                                                                    </th>
                                                                    <th>
                                                                        <span>Requirements</span>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                    <div class="body-table black-clr">
                                                        <table class="payroll-table" style="height: auto;" width="100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <span class="font-bold">ELIGIBILITY</span>
                                                                    </td>
                                                                    <td>
                                                                        <span>Net Pay: Greater than PHP 5,000</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <span class="font-bold">AMOUNT OF LOAN</span>
                                                                    </td>
                                                                    <td>
                                                                        <span>PHP 100,000.00</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <span class="font-bold">TERMS OF PAYMENT</span>
                                                                    </td>
                                                                    <td>
                                                                        <span>48 Months</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <span class="font-bold">INTEREST RATE</span>
                                                                    </td>
                                                                    <td>
                                                                        <span>13%</span>
                                                                    </td>
                                                                </tr>
                                                                <tr class="maroon-bg-dark">
                                                                    <td>
                                                                        <span class="font-bold">INTEREST RATE VALUE</span>
                                                                    </td>
                                                                    <td>
                                                                        <span>PHP 13,000.00 / Annum</span>
                                                                    </td>
                                                                </tr>
                                                                <tr class="maroon-bg-dark">
                                                                    <td>
                                                                        <span class="font-bold">TOTAL INTEREST RATE VALUE</span>
                                                                    </td>
                                                                    <td>
                                                                        <span>PHP 52,000.00</span>
                                                                    </td>
                                                                </tr>
                                                                <tr class="magenta-bg-dark">
                                                                    <td>
                                                                        <span class="font-bold">AMOUNT OF LOAN + INTEREST</span>
                                                                    </td>
                                                                    <td>
                                                                        <span>PHP 152,000.00</span>
                                                                    </td>
                                                                </tr>
                                                                <tr class="magenta-bg-dark">
                                                                    <td>
                                                                        <span class="font-bold">MONTHLY AMORTIZATION</span>
                                                                    </td>
                                                                    <td>
                                                                        <span>PHP 3,166.66/ Month (Salary Deduction)</span>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <a class="up-button-grey btn-md mp-text-center w-100" id="save_users" name="save_users" type="submit">
                                                    <span class="save_up">CLEAR</span>
                                                </a>
                                                <a class="up-button btn-md mp-text-center w-100 mp-mt2" id="save_users" name="save_users" type="submit">
                                                    <span class="save_up">APPLY FOR LOAN</span>
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                
                            </div>
                            

                            
                        </div>
</div>
<script>
     function setActiveTab (tab) {
        const index = $(tab).attr("data-set")
        $('.header-tabs>span').map(function () {
            const dataSet  = $(this).attr("data-set")
            if(dataSet == index) {
                $(this).addClass('active')
                return
            }
            $(this).removeClass('active')
        })
        $('.tab-body').map(function() {
            const dataSet  = $(this).attr("data-set")
            if(dataSet == index) {
                $(this).removeClass('d-none')
                return
            }
            $(this).addClass('d-none')
        })
        
    }
   
     $(document).on('click', '.header-tabs > span', function(e) {
        // const linkSplit = window.location.href.split('/')
        // const length = linkSplit.length
        // const id = linkSplit[length-1]
        const element = $(this)
        setActiveTab(element)
        // window.location.href = '/admin/members/records/view/aa' + links[dataSet] + '/' + id
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