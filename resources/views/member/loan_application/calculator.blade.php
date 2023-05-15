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
                                <div class="mp-card h-auto loan-submission d-none">
                                    <div class="container-fluid mp-mt2 gap-10">
                                        <div class="row mp-mh3" style="overflow-y: auto;">
                                            <div class="col-lg-12">
                                                <table class="payroll-table" style="height: auto;">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                <span>Principal Amount (Loanable)</span>
                                                            </th>
                                                            <th>
                                                                <span>Interest %</span>
                                                            </th>
                                                            <th>
                                                                <span>Interest Amount</span>
                                                            </th>
                                                            <th>
                                                                <span>Payment Terms</span>
                                                            </th>
                                                            <th>
                                                                <span>Monthly Amortization</span>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <span>PHP 35,000.00</span>
                                                            </td>
                                                            <td>
                                                                <span>12%</span>
                                                            </td>
                                                            <td>
                                                                <span>PHP 4,200.00</span>
                                                            </td>
                                                            <td>
                                                                <span>36 Months</span>
                                                            </td>
                                                            <td>
                                                                <span>PHP 3,266.67</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span>Service Fee</span>
                                                            </td>
                                                            <td colspan="4" >
                                                                <span class="justify-content-center black-clr font-bold">PHP 200.00</span>
                                                            </td>
                                                            
                                                        </tr>
                                                        <tr class="magenta-bg">
                                                            <td>
                                                                <span>Actual Amount for Release</span>
                                                            </td>
                                                            <td colspan="4" >
                                                                <span class="justify-content-center font-bold">PHP 34,800.00</span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 d-flex mp-pb3">
                                                <a class="up-button btn-md mp-text-center w-400-px mp-mt2 mp-mvauto" id="recompute" >
                                                    <span class="save_up">RE-COMPUTE LOAN</span>
                                                </a> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mp-card h-auto loan-calculator" class="">
                                    <div class="container-fluid mp-mt2 gap-10">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="info-text">
                                                <label for="">Appointment Date: January 10, 2023</label>
                                                <label for="">Years in Service: 2 Years</label>
                                                </div>
                                            </div>
                                            <div class="col-12 mp-mt2">
                                                <div class="info-text">
                                                <label for="">Salary Grade: 2</label>
                                                <label for="">Gross Monthly Salary: PHP 13,500.00</label>
                                                </div>
                                            </div>
                                            <div class="col-12 mp-mt2">
                                                <h3 class="magenta-clr">
                                                    Loan Balance: 
                                                </h3>
                                            </div>
                                            <div class="col-12 mp-mb3">
                                                <div class="row">
                                                    <div class="col-5 ">
                                                        <div class="info-text ">
                                                            <label for="" class="font-bold black-clr">PEL: PHP 0.00</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-7">
                                                        <div class="info-text">
                                                            <label for="" class="font-bold black-clr">Interest: 0%</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-5 ">
                                                        <div class="info-text ">
                                                            <label for="" class="font-bold black-clr">CBL: PHP 0.00</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-7">
                                                        <div class="info-text">
                                                            <label for="" class="font-bold black-clr">Interest: 0%</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-5 ">
                                                        <div class="info-text ">
                                                            <label for="" class="font-bold black-clr">BL: PHP 0.00</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-7">
                                                        <div class="info-text">
                                                            <label for="" class="font-bold black-clr">Interest: 0%</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-5 ">
                                                        <div class="info-text ">
                                                            <label for="" class="font-bold black-clr">EML: PHP 0.00</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-7">
                                                        <div class="info-text">
                                                            <label for="" class="font-bold black-clr">Interest: 0%</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-5 ">
                                                        <div class="info-text ">
                                                            <label for="" class="font-bold black-clr">BTL: PHP 0.00</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-7">
                                                        <div class="info-text">
                                                            <label for="" class="font-bold black-clr">Interest: 0%</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mp-mb2">
                                                <div class="info-text justify-content-end">
                                                    <label for="" class="">As of May 4, 2023 11:03 AM</label>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>


                            <div class="col-lg-8 mp-pr0 mp-mt2 loan-calculator" style="width: 100%;">
                                <div class="br-top-2 row" 
                                    style="color: white;
                                            padding: 5px 10px;
                                            background-color: var(--c-accent);
                                            margin: 0;width: 100%;">LOAN CALCULATOR

                                </div>
                                <div class="mp-card mp-p4 h-auto" style="padding:20px;">

                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="info-text">
                                                            <label for="" class="">Please provide necessary details for loan computation. All marked with (*) are required.</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 magenta-bg br-top-2 br-bottom-2 mp-mh2">
                                                        <div class="info-text">
                                                            <label for="" class="white-clr mp-ph2 font-md">Step 1. Input Details</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 mp-mt2">
                                                        <div class="row">
                                                            <div class="col-lg-4 d-flex flex-column justify-content-center">
                                                                <div class="info-text">
                                                                    <label for="" class="black-clr">Enter Net Pay (*)</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="w-auto radius-1 border-1 date-input outline mp-pb1 mp-pt1">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 mp-mt2">
                                                        <div class="row">
                                                            <div class="col-lg-4 d-flex flex-column justify-content-center">
                                                                <div class="info-text">
                                                                    <label for="" class="black-clr">Bank Account Number</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="w-auto radius-1 border-1 date-input outline mp-pb1 mp-pt1">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 mp-mt2">
                                                        <div class="row">
                                                            <div class="col-lg-4 d-flex flex-column justify-content-center">
                                                                <div class="info-text">
                                                                    <label for="" class="black-clr">Upload Image (Screenshot of your ATM/ Bank details showing clearly the account number)</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-8">
                                                                <input type="file" class="w-auto radius-1 border-1 date-input outline mp-pb1 mp-pt1">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 mp-mt2">
                                                        <div class="row">
                                                            <div class="col-lg-4 d-flex flex-column justify-content-center">
                                                                <div class="info-text">
                                                                    <label for="" class="black-clr">Enter your years of service</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="w-auto radius-1 border-1 date-input outline mp-pb1 mp-pt1">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 d-flex mp-ph2">
                                                        <a class="up-button btn-md mp-text-center w-400-px mp-mt2 mp-mvauto" id="save_users" name="save_users" type="submit">
                                                            <span class="save_up">COMPUTE LOAN</span>
                                                        </a> 
                                                    </div>
                                                    <div class="col-lg-12 magenta-bg br-top-2 br-bottom-2 mp-mh2">
                                                        <div class="info-text">
                                                            <label for="" class="white-clr mp-ph2 font-md">Step 2. Select Loanable Amount</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="info-text">
                                                            <label for="" class="">Amount of loan equity.</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="info-text">
                                                            <h4 for="" class="">Total Members Equity: PHP 350,000.00</h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="row" style="overflow-y: auto;">
                                                            <div class="col-lg-12">
                                                                <div class="d-flex flex-column">
                                                                    <div class="header-table">
                                                                        <table class="payroll-table" style="height: auto;" width="100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>
                                                                                        <span>Years of Service</span>
                                                                                    </th>
                                                                                    <th>
                                                                                        <span>Equity Percentage</span>
                                                                                    </th>
                                                                                    <th>
                                                                                        <span>Amount</span>
                                                                                    </th>
                                                                                    <th>
                                                                                        <span>Qualification</span>
                                                                                    </th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>
                                                                                        <span>Less Than 4 Years</span>
                                                                                    </td>
                                                                                    <td>
                                                                                        <span>75%</span>
                                                                                    </td>
                                                                                    <td>
                                                                                        <span>PHP 12,121.00</span>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div>
                                                                                            <div style="display: inline-flex" class="green-bg mp-ph1 mp-pv2 mp-ml2 br-top-2 br-bottom-2">
                                                                                                Qualified
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <span>4 - 14 Years</span>
                                                                                    </td>
                                                                                    <td>
                                                                                        <span>85%</span>
                                                                                    </td>
                                                                                    <td>
                                                                                        <span>PHP 12,121.00</span>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div>
                                                                                            <div style="display: inline-flex" class="green-bg mp-ph1 mp-pv2 mp-ml2 br-top-2 br-bottom-2">
                                                                                                Qualified
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <span>15 Years Above</span>
                                                                                    </td>
                                                                                    <td>
                                                                                        <span>100%</span>
                                                                                    </td>
                                                                                    <td>
                                                                                        <span>PHP 12,121.00</span>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div>
                                                                                            <div style="display: inline-flex" class="maroon-bg white-clr mp-ph1 mp-pv2 mp-ml2 br-top-2 br-bottom-2">
                                                                                                Not Qualified
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 mp-mh2">
                                                        <div class="info-text">
                                                            <label for="" class="">Notes</label>
                                                            <label for="" class="">Loan amount for 1 year term up to  PHP 10,000</label>
                                                            <label for="" class="">Loan amount for 2 years term up to  PHP 10,000 - 30,000</label>
                                                            <label for="" class="">Loan amount for 3 years term up to  PHP 30,001 - 99,999</label>
                                                            <label for="" class="">Loan amount for 4 years term up to  PHP 100,000 - above</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mp-mh2">
                                                        <div class="info-text">
                                                            <label for="" class="font-bold magenta-clr">Max Loanable Amount: PHP 35,000.00</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mp-mh2">
                                                        <div class="info-text">
                                                            <label for="" class="font-bold magenta-clr" >Max Payment Terms:  3 Years / 36 Months</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 mp-mt2">
                                                        <div class="row">
                                                            <div class="col-lg-4 d-flex flex-column justify-content-center">
                                                                <div class="info-text">
                                                                    <label for="" class="black-clr">Enter Desired Loanable Amount (*)</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="w-auto radius-1 border-1 date-input outline mp-pb1 mp-pt1">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 mp-mt2">
                                                        <div class="row">
                                                            <div class="col-lg-4 d-flex flex-column justify-content-center">
                                                                <div class="info-text">
                                                                    <label for="" class="black-clr">Select Terms of Payment</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-8">
                                                                <select class="js-example-responsive mp-input-group__input mp-text-field w-auto"  required>
                                                                    <option value="">Select Terms</option>
                                                                    <option value="">1 Year</option>
                                                                    <option value="">2 Years</option>
                                                                    <option value="">3 Years</option>
                                                                    <option value="">4 Years</option>
                                                                </select>
                                                                <!-- <input type="text" class=" radius-1 border-1 date-input outline mp-pb1 mp-pt1"> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 mp-mh2 mp-mt4">
                                                        <div class="info-text">
                                                            <label for="" class="">Notes</label>
                                                            <label for="" class="">Interest rate less than 4 years is 12%.</label>
                                                            <label for="" class="">Interest rate more than 4 years is 13%.</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="row" style="overflow-y: auto;">
                                                            <div class="col-lg-12">
                                                                <div class="d-flex flex-column">
                                                                    <div class="header-table">
                                                                        <table class="payroll-table" style="height: auto;" width="100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>
                                                                                        <span>Principal Amount (Loanable)</span>
                                                                                    </th>
                                                                                    <th>
                                                                                        <span>Interest %</span>
                                                                                    </th>
                                                                                    <th>
                                                                                        <span>Interest Amount</span>
                                                                                    </th>
                                                                                    <th>
                                                                                        <span>Payment Terms</span>
                                                                                    </th>
                                                                                    <th>
                                                                                        <span>Monthly Amortization</span>
                                                                                    </th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>
                                                                                        <span>PHP 35,000.00</span>
                                                                                    </td>
                                                                                    <td>
                                                                                        <span>12%</span>
                                                                                    </td>
                                                                                    <td>
                                                                                        <span>PHP 4,200.00</span>
                                                                                    </td>
                                                                                    <td>
                                                                                        <span>36 Months</span>
                                                                                    </td>
                                                                                    <td>
                                                                                        <span>PHP 3,266.67</span>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <span>Service Fee</span>
                                                                                    </td>
                                                                                    <td colspan="4" >
                                                                                        <span class="justify-content-center black-clr font-bold">PHP 200.00</span>
                                                                                    </td>
                                                                                    
                                                                                </tr>
                                                                                <tr class="magenta-bg">
                                                                                    <td>
                                                                                        <span>Actual Amount for Release</span>
                                                                                    </td>
                                                                                    <td colspan="4" >
                                                                                        <span class="justify-content-center font-bold">PHP 34,800.00</span>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 d-flex mp-ph2">
                                                        <a class="up-button btn-md mp-text-center w-400-px mp-mt2 mp-mvauto" id="continue" name="save_users" type="submit">
                                                            <span class="save_up">CONTINUE TO APPLICATION</span>
                                                        </a> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 mp-pr0 mp-mt2 loan-submission d-none" style="width: 100%;">
                                <button class="up-button btn-md button-animate-left hover-back mp-mb2" id="back" value="">
                                    <span>Back</span>
                                </button>
                                <div class="br-top-2 row" 
                                    style="color: white;
                                            padding: 5px 10px;
                                            background-color: var(--c-accent);
                                            margin: 0;width: 100%;">LOAN APPLICATION
                                </div>
                                <div class="mp-card mp-p4 h-auto" style="padding:20px;">

                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row">
                                                    
                                                    <div class="col-lg-7">
                                                        <div class="info-text">
                                                            <label for="" class="font-md">(PEL) Personal Equity Loan.</label>
                                                            <label for="" class="font-md">Loan Application Number: <span>PEL - 2023-2231</span></label>
                                                            <label for="" class="font-md">Loan Status: <span>New Application</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <div class="info-text mp-text-right">
                                                            <h3 for="" class="gray-clr  mp-pb0 mp-mb0">Loanable Amount:</h3>
                                                            <label for="" class="font-lg font-bold magenta-clr">PHP 34,000.00</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 magenta-bg br-top-2 br-bottom-2 mp-mh2">
                                                        <div class="info-text">
                                                            <label for="" class="white-clr mp-ph2 font-md">A. Bank Details</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 mp-mt2">
                                                        <div class="row">
                                                            <div class="col-lg-12 d-flex flex-column justify-content-center">
                                                                <div class="info-text">
                                                                    <label for="" class="black-clr">1. Please choose the bank where you want your loan proceeds deposited. (*)</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 mp-pv4 mp-ph2">
                                                                <div class="info-text">
                                                                    <span class="d-flex flex-row justify-items-center gap-10">
                                                                        <input type="radio" class="mp-pt1">
                                                                        <label for="" class="font-sm">(LPB) Land Bank of the Philippines</label>
                                                                    </span>
                                                                    <span class="d-flex flex-row justify-items-center gap-10">
                                                                        <input type="radio" class="mp-pt1">
                                                                        <label for="" class="font-sm">(PNB) Philippine National Bank</label>
                                                                    </span>
                                                                    <span class="d-flex flex-row justify-items-center gap-10">
                                                                        <input type="radio" class="mp-pt1">
                                                                        <label for="" class="font-sm">(DBP) Development Bank of the Philippines</label>
                                                                    </span>
                                                                    <span class="d-flex flex-row justify-items-center gap-10">
                                                                        <input type="radio" class="mp-pt1">
                                                                        <label for="" class="font-sm">(PVB) Philippine Veterans Bank</label>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12 d-flex flex-column justify-content-center">
                                                                <div class="info-text">
                                                                    <label for="" class="black-clr">2. Input the account number and the account name. (*)</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 mp-mt2">
                                                                <div class="row">
                                                                    <div class="col-lg-4 d-flex flex-column justify-content-center">
                                                                        <div class="info-text">
                                                                            <label for="" class="black-clr">Account Number: (*) </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-8">
                                                                        <input type="text" class="w-auto radius-1 border-1 date-input outline mp-pb1 mp-pt1">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 mp-mt2">
                                                                <div class="row">
                                                                    <div class="col-lg-4 d-flex flex-column justify-content-center">
                                                                        <div class="info-text">
                                                                            <label for="" class="black-clr">Account Name: (*) </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-8">
                                                                        <input type="text" class="w-auto radius-1 border-1 date-input outline mp-pb1 mp-pt1">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 magenta-bg br-top-2 br-bottom-2 mp-mh2 mp-mt3">
                                                        <div class="info-text">
                                                            <label for="" class="white-clr mp-ph2 font-md">B. Attachments</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-lg-12 mp-mt2">
                                                                <div class="row">
                                                                    <div class="col-lg-12 d-flex flex-column justify-content-center">
                                                                        <div class="info-text">
                                                                            <label for="" class="black-clr">1. UP Employee ID or any valid government issued ID (Drivers license, Passport, GSIS UMID, Philhealth, etc) (*)</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <div class="row mp-mt2">
                                                                            <div class="col-lg-6">
                                                                                <input type="file" class="w-80 radius-1 border-1 date-input outline mp-pb1 mp-pt1">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 mp-mt2">
                                                            <div class="row">
                                                                <div class="col-lg-12 d-flex flex-column justify-content-center">
                                                                    <div class="info-text">
                                                                        <label for="" class="black-clr">2. Last 2 months payslip (latest). (*)</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <div class="row mp-mt2">
                                                                        <div class="col-lg-6">
                                                                            <input type="file" class="w-80 radius-1 border-1 date-input outline mp-pb1 mp-pt1">
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <input type="file" class="w-80 radius-1 border-1 date-input outline mp-pb1 mp-pt1">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mp-mt2">
                                                                <div class="col-lg-12 d-flex flex-column justify-content-center">
                                                                    <div class="info-text">
                                                                        <label for="" class="black-clr">3. Passbook / ATM / any documents or proof showing bank account number where loan proceeds will be deposited. (*)</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <div class="row mp-mt2">
                                                                        <div class="col-lg-6">
                                                                            <input type="file" class="w-80 radius-1 border-1 date-input outline mp-pb1 mp-pt1">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 magenta-bg br-top-2 br-bottom-2 mp-mh2 mp-mt3">
                                                        <div class="info-text">
                                                            <label for="" class="white-clr mp-ph2 font-md">C. Additional Information</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 mp-mt2">
                                                        <div class="row">
                                                            <div class="col-lg-12 mp-mt2">
                                                                <div class="row">
                                                                    <div class="col-lg-4 d-flex flex-column justify-content-center">
                                                                        <div class="info-text">
                                                                            <label for="" class="black-clr">Active Email: (*) </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-8">
                                                                        <input type="text" class="w-auto radius-1 border-1 date-input outline mp-pb1 mp-pt1">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 mp-mt2">
                                                                <div class="row">
                                                                    <div class="col-lg-4 d-flex flex-column justify-content-center">
                                                                        <div class="info-text">
                                                                            <label for="" class="black-clr">Active Mobile Number: (*) </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-8">
                                                                        <input type="text" class="w-auto radius-1 border-1 date-input outline mp-pb1 mp-pt1">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 mp-ph4">
                                                        <div class="row">
                                                            <div class="col-lg-6 d-flex justify-content-center">
                                                                <div class="row f-flex">
                                                                    <span class="d-flex flex-row justify-content-center">
                                                                        <a class="up-button btn-md mp-text-center w-300-px mp-mt2 mp-mvauto gray-bg" id="save_users" name="save_users" type="submit">
                                                                            SAVE AS DRAFT APPLICATION
                                                                        </a>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 d-flex justify-content-center">
                                                                <div class="row f-flex">
                                                                    <span class="d-flex flex-row justify-content-center">
                                                                        <a class="up-button btn-md mp-text-center w-300-px mp-mt2 mp-mvauto" id="save_users" name="save_users" type="submit">
                                                                            SUBMIT THIS APPLICATION
                                                                        </a> 
                                                                    </span>
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
     $(document).ready(function() {

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