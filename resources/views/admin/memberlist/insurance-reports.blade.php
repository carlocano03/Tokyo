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
     <div class="col-lg-2" id="settingsTab" style="padding:0px !important; height: 100%; overflow-y:auto; ">
         <div class="mp-card admin-settingtab" style="padding-bottom:150px;">
             <div class="settings-tab">
                 <div class="top-label">
                     <label>Members Module</label>

                 </div>

                 <div class="settings-buttons">
                     <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-start" id="menu">
                         <li class="options " onclick="location.href='/admin/members/new-members'">
                             <a href="#" class="no-padding"> New Members</a><br>

                         </li>
                         <li class="options" onclick="location.href='/admin/members'">
                             <a href="#" class="no-padding"> Master List</a><br>

                         </li>
                         <li class="options" onclick="location.href='/admin/members/summary-reports'">
                             <a href="#" class="no-padding">Summary Reports</a><br>

                         </li>
                         <li class="options" onclick="location.href='/admin/members/contribution-reports'">
                             <a href="#" class="no-padding"> Contribution Reports</a><br>

                         </li>
                         <li class="options options-active" onclick="location.href='/admin/members/insurance-reports'">
                             <a href="#" class="no-padding options-a-active">Insurance Reports</a><br>
                         </li>
                         <li class="options" onclick="location.href='/admin/members/voter-list'">
                             <a href="#" class="no-padding"> Members Voter List</a><br>
                         </li>
                     </ul>
                 </div>
             </div>

         </div>
     </div>


     <div class="col-lg-10 mp-mt3 gap-10" id="settingsContent">
         <div class="button-container ">
             <button class="f-button magenta-bg" id="showSettings">Hide Settings</button>
         </div>
         <div class="no-gutter ml-0 mr-0 p-5px mh-content view-all-members ">
             <div class="col-12 mp-pv0 mp-pr0 d-flex mp-mh3">
                 <span class="d-inline-flex align-items-center " style="color: black;
                                font-weight: bold;
                                margin-bottom: 10px;">
                     Members Module > &nbsp; Insurance Reports
                 </span>

             </div>
             <div class="col-12 mp-pr0" style="width: 100%;">

                 <div class="w-full justify-content-center d-flex">
                     <div class="d-flex flex-row w-full gap-10">
                         <div class="d-flex flex-column gap-10 middle-content full">
                             <div class="card-container card p-0">
                                 <div class="card-header filtering items-between d-flex">
                                     <span>Filtering Section</span>
                                     <span class="mp-pr2">
                                         <button class="f-button font-bold">Export</button>
                                         <button class="f-button font-bold up-button-green">Print</button>
                                     </span>
                                 </div>


                                 <div class="card-body filtering-section-body justify-content-center gap-10 flex-row">

                                     <div class="table-form w-full" style="grid-template-columns: repeat(11, 1fr); font-size:12px;">
                                         <span class="d-flex flex-column span-2 mp-pv2 flex-nowrap">
                                             <span>Campus</span>
                                             <select name="" class="radius-1 outline select-field" style="width: 100%; height: 30px" id="campuses_select">
                                                 <option value="">Show All</option>

                                             </select>
                                         </span>
                                         <span class="d-flex flex-column span-2 mp-pv2 flex-nowrap">
                                             <span>Cluster</span>
                                             <select name="" class="radius-1 outline select-field" style="width: 100%; height: 30px" id="department_select">
                                                 <option value="">Show All</option>

                                             </select>
                                         </span>
                                         <span class="d-flex flex-column span-3 mp-pv2 flex-nowrap date-selector">
                                             <span>Membership Date</span>
                                             <div class="date_range d-flex">
                                                 <input type="date" id="from" class="radius-1 border-1 date-input outline" style="height: 30px;">
                                                 <span for="" class="self_center mv-1" style="margin-left:5px; margin-right:5px;">to</span>
                                                 <input type="date" id="to" class="radius-1 border-1 date-input outline" style="height: 30px;">
                                             </div>
                                         </span>
                                         <span class="d-flex flex-column span-2 mp-pv2 flex-nowrap">
                                             <span>Status</span>
                                             <select name="" class="radius-1 outline select-field" style="width: 100%; height: 30px" id="status_select">
                                                 <option value="">Show All</option>
                                                 <option value="DRAFT APPLICATION">W/ Insurance</option>
                                                 <option value="NEW APPLICATION">W/O Insurance</option>

                                             </select>
                                         </span>
                                         <span class="d-flex flex-column span-2 mp-pv2 flex-nowrap">
                                             <span>Mode Of Seperation</span>
                                             <select name="" class="radius-1 outline select-field" style="width: 100%; height: 30px" id="remarks_select">
                                                 <option value="">All</option>
                                                 <option value="AA VERIFIED">Retirement</option>
                                                 <option value="FORWARDED TO HRDO">Resignation</option>
                                                 <option value="FORWARDED TO FM">Withdrawal</option>
                                                 <option value="HRDO RETURNED APPLICATIONS">Death</option>
                                                 <option value="HRDO RETURNED APPLICATIONS">InActive</option>
                                             </select>
                                         </span>
                                         <span class="d-flex flex-column span-2 mp-pv2 flex-nowrap view-options">
                                             @if(Auth::user()->user_level == 'ADMIN')
                                             <span>View User Option</span>
                                             <select name="view_all" id="view_all" class="radius-1 outline select-field mp-pr2" style="height: 30px;margin-top: auto;margin-bottom: auto;" <?= Auth::user()->user_level != 'ADMIN' ? 'disabled' : '' ?>>
                                                 <option value="">All Records</option>
                                                 <option value="AA" <?= Auth::user()->user_level == 'AA' ? 'selected' : '' ?>>AO</option>
                                                 <option value="CFM" <?= Auth::user()->user_level == 'CFM' ? 'selected' : '' ?>>CFM</option>
                                                 <option value="HRDO" <?= Auth::user()->user_level == 'HRDO' ? 'selected' : '' ?>>HRDO</option>
                                             </select>
                                             @endif


                                         </span>
                                     </div>
                                 </div>
                             </div>
                             <div class="card d-flex flex-column">
                                 <div class="d-flex flex-row items-between">
                                     <input class="mp-text-field mp-pt2 sticky top-0 " type="text" placeholder="Search here" id="search_value" />


                                 </div>
                                 <div class="mp-mt3 table-container">
                                     <table class="members-table" style="height: auto;" width="100%">
                                         <thead>
                                             <tr>
                                                 <th style="width:40px">
                                                     <span>#</span>
                                                 </th>

                                                 <th>
                                                     <span>Members ID</span>
                                                 </th>
                                                 <th>
                                                     <span>Member Name</span>
                                                 </th>
                                                 <th>
                                                     <span>Membership Date</span>
                                                 </th>
                                                 <th>
                                                     <span>Campus</span>
                                                 </th>
                                                 <th>
                                                     <span>Class</span>
                                                 </th>
                                                 <th>
                                                     <span>Insurance</span>
                                                 </th>
                                                 <th>
                                                     <span>MO's</span>
                                                 </th>
                                                 <th>
                                                     <span>Action</span>
                                                 </th>

                                             </tr>
                                         </thead>

                                         <tbody>
                                             <tr>
                                                 <td>
                                                     <span>
                                                         1
                                                     </span>
                                                 </td>

                                                 <td>
                                                     <span>
                                                         1231232
                                                     </span>
                                                 </td>
                                                 <td>
                                                     <span>
                                                         Member Name
                                                     </span>
                                                 </td>
                                                 <td>
                                                     <span>
                                                         January 20, 1999
                                                     </span>
                                                 </td>
                                                 <td>
                                                     <span>
                                                         Up Diliman
                                                     </span>
                                                 </td>
                                                 <td>
                                                     <span>
                                                         Class A
                                                     </span>
                                                 </td>
                                                 <td>
                                                     <span>
                                                         Yes
                                                     </span>
                                                 </td>
                                                 <td>
                                                     <span>
                                                         Death
                                                     </span>
                                                 </td>
                                                 <td>
                                                     <span>
                                                         <button href="#" class="view_member md-tooltip--right view-member" style="cursor: pointer">

                                                             <i class="fa fa-file mp-icon mp-text-c-primary mp-text-fs-large" aria-hidden="true"></i>
                                                         </button>
                                                         <button href="#" class="view_member md-tooltip--right view-member" style="cursor: pointer">

                                                             <i class="fa fa-plus-square mp-icon mp-text-c-primary mp-text-fs-large" aria-hidden="true"></i>
                                                         </button>
                                                     </span>
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





 <script>
     $(document).on('click', '#showSettings', function(e) {
         if ($("#settingsTab").hasClass("col-lg-2")) {
             $("#settingsTab").addClass("d-none");
             $("#settingsTab").removeClass("col-lg-2");
             $("#settingsContent").removeClass("col-lg-10");
             $("#settingsContent").addClass("col-lg-12");

             $("#showSettings").text("Show Settings")

         } else {
             $("#settingsTab").removeClass("d-none");
             $("#settingsTab").addClass("col-lg-2");
             $("#settingsContent").removeClass("col-lg-12");
             $("#settingsContent").addClass("col-lg-10");

             $("#showSettings").text("Hide Settings")
         }

     })
 </script>
 @endsection