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
    min-height: 65vh;
    max-height: 65vh;
    overflow: auto;
    padding: 0;

  }

  .table-container {
    min-height: calc(65vh - 219px);
    max-height: calc(65vh - 219px);
    overflow: auto;
  }

  .record-container {
    min-height: 65vh;
    max-height: 65vh;
    overflow: auto;
  }

  .p-0 {
    padding: 0;
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
</style>
<div class="filler"></div>
<script type="text/javascript" src="{{ asset('/dist/loading-bar/loading-bar.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('/dist/loading-bar/loading-bar.css') }}">
</link>
<div class="row no-gutter ml-0 mr-0 p-5px">
  <div class="col-12 mp-pv0 mp-pr0">
    <span class="d-inline-flex align-items-center ">
      <a href="/dashboard" class="link-style">Dashboard</a>/ &nbsp; Membership Application Records
    </span>
  </div>
  <div class="col-12 mp-pr0" style="width: 100%;">
    <div class="row d-flex flex-row gap-10 mp-pr0" style="width: 100%;">
      <div style="width: 15%;" class="d-flex flex-column gap-10">
        <div class="card-container card p-0">
          <div class="card-header green-bg">
            New Application
          </div>
          <div class="card-body justify-content-center">
            <div class="ldBar green label-center" data-preset="circle" data-value="50"></div>
          </div>
          <button class="green-bg button-view">
            View
          </button>
        </div>
        <div class="card-container card p-0">
          <div class="card-header magenta-bg">
            Processing Application
          </div>
          <div class="card-body justify-content-center">
            <div class="ldBar magenta label-center" data-preset="circle" data-value="80"></div>
          </div>
          <button class="magenta-bg button-view">
            View
          </button>
        </div>
        <div class="card-container card p-0">
          <div class="card-header maroon-bg">
            Approved Application
          </div>
          <div class="card-body justify-content-center">
            <div class="ldBar maroon label-center" data-preset="circle" data-value="40"></div>
          </div>
          <button class="maroon-bg button-view">
            View
          </button>
        </div>
        <div class="card-container card p-0">
          <div class="card-header red-bg">
            Rejected Application
          </div>
          <div class="card-body justify-content-center">
            <div class="ldBar red label-center" data-preset="circle" data-value="10"></div>
          </div>
          <button class="red-bg button-view">
            View
          </button>
        </div>
      </div>
      <div style="width: calc(65% - 20px)" class="d-flex flex-column gap-10">
        <div class="card-container card p-0 ">
          <div class="card-header filtering">
            Filtering Section
          </div>
          <div class="card-body filtering-section-body justify-content-center gap-10">
            <div class="col-md-12 col-xl-6">
              <div class="row field-filter">
                <div class="col-md-12 p-0">
                  <label for="row">Filter By Campus</label>
                  <select name="" class="radius-1 outline select-field" style="width: 100%; height: 30px" id="campuses_select">
                    <option value="">Show All</option>
                  </select>
                </div>
                <div class="col-md-12 p-0">
                  <label for="row">Filter By Department</label>
                  <select name="" class="radius-1 outline select-field" style="width: 100%; height: 30px" id="department_select">
                    <option value="">Show All</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-12 col-xl-5">
              <div class="row">
                <label for="row">Filter by Membership Date</label>
              </div>
              <div class="row date_range">
                <input type="date" id="from" class="radius-1 border-1 date-input outline" style="height: 30px;">
                <span for="" class="self_center mv-1" style="margin-left:15px; margin-right:15px;">to</span>
                <input type="date" id="to" class="radius-1 border-1 date-input outline" style="height: 30px;">
              </div>
            </div>
          </div>
        </div>
        <div class="d-flex gap-10 flex-row justify-content-end mp-pr2">
          <button class="f-button">Export</button>
          <button class="f-button">Print</button>
        </div>
        <div class="card d-flex flex-column">
          <div class="d-flex flex-row items-between">
            <input class="mp-text-field mp-pt2 sticky top-0 " type="text" placeholder="Search here" />
            <select name="" id="" class="radius-1 outline select-field mp-pr2" style="height: 30px;margin-top: auto;margin-bottom: auto;">
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
          </div>
          <div class="mp-mt3 table-container">
            <table class="members-table" style="height: auto;">
              <thead>
                <tr>
                  <th style="width: 48px;">
                    <span>Action</span>
                  </th>
                  <th>
                    <span>Application No.</span>
                  </th>
                  <th>
                    <span>Date of Application</span>
                  </th>
                  <th>
                    <span>Full Name</span>
                  </th>
                  <th>
                    <span>Employee No</span>
                  </th>
                  <th>
                    <span>Class</span>
                  </th>
                  <th>
                    <span>Position</span>
                  </th>
                  <th>
                    <span>MC</span>
                  </th>
                  <th>
                    <span>Status</span>
                  </th>
                  <th>
                    <span>Remarks</span>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>

                    <span>
                      <a data-md-tooltip="View Member" class="md-tooltip--right view" style="cursor: pointer">
                        <i class="mp-icon md-tooltip--right icon-book-open mp-text-c-primary mp-text-fs-large"></i>
                      </a>
                    </span>
                  </td>
                  <td>
                    <span>23781623</span>
                  </td>
                  <td>
                    <span>01-01-2023</span>
                  </td>
                  <td>
                    <span class="member-name">Dela Cruz, Juan Abaa</span>
                  </td>
                  <td>
                    <span>acbc</span>
                  </td>
                  <td>
                    <span>Faculty</span>
                  </td>
                  <td>
                    <span>Position</span>
                  </td>
                  <td>
                    <span>1.5%</span>
                  </td>
                  <td>
                    <span>New Application</span>
                  </td>
                  <td>
                    <span>Forwarded to HRDO</span>
                  </td>

                </tr>
                <tr>
                  <td>

                    <span>
                      <a data-md-tooltip="View Member" class="md-tooltip--right view" style="cursor: pointer">
                        <i class="mp-icon md-tooltip--right icon-book-open mp-text-c-primary mp-text-fs-large"></i>
                      </a>
                    </span>
                  </td>
                  <td>
                    <span>23781623</span>
                  </td>
                  <td>
                    <span>01-01-2023</span>
                  </td>
                  <td>
                    <span class="member-name">Dela Cruz, Juan Abaa</span>
                  </td>
                  <td>
                    <span>acbc</span>
                  </td>
                  <td>
                    <span>Faculty</span>
                  </td>
                  <td>
                    <span>Position</span>
                  </td>
                  <td>
                    <span>1.5%</span>
                  </td>
                  <td>
                    <span>New Application</span>
                  </td>
                  <td>
                    <span>Forwarded to HRDO</span>
                  </td>

                </tr>
                <tr>
                  <td>

                    <span>
                      <a data-md-tooltip="View Member" class="md-tooltip--right view" style="cursor: pointer">
                        <i class="mp-icon md-tooltip--right icon-book-open mp-text-c-primary mp-text-fs-large"></i>
                      </a>
                    </span>
                  </td>
                  <td>
                    <span>23781623</span>
                  </td>
                  <td>
                    <span>01-01-2023</span>
                  </td>
                  <td>
                    <span class="member-name">Dela Cruz, Juan Abaa</span>
                  </td>
                  <td>
                    <span>acbc</span>
                  </td>
                  <td>
                    <span>Faculty</span>
                  </td>
                  <td>
                    <span>Position</span>
                  </td>
                  <td>
                    <span>1.5%</span>
                  </td>
                  <td>
                    <span>New Application</span>
                  </td>
                  <td>
                    <span>Forwarded to HRDO</span>
                  </td>

                </tr>
                <tr>
                  <td>

                    <span>
                      <a data-md-tooltip="View Member" class="md-tooltip--right view" style="cursor: pointer">
                        <i class="mp-icon md-tooltip--right icon-book-open mp-text-c-primary mp-text-fs-large"></i>
                      </a>
                    </span>
                  </td>
                  <td>
                    <span>23781623</span>
                  </td>
                  <td>
                    <span>01-01-2023</span>
                  </td>
                  <td>
                    <span class="member-name">Dela Cruz, Juan Abaa</span>
                  </td>
                  <td>
                    <span>acbc</span>
                  </td>
                  <td>
                    <span>Faculty</span>
                  </td>
                  <td>
                    <span>Position</span>
                  </td>
                  <td>
                    <span>1.5%</span>
                  </td>
                  <td>
                    <span>New Application</span>
                  </td>
                  <td>
                    <span>Forwarded to HRDO</span>
                  </td>

                </tr>
                <tr>
                  <td>

                    <span>
                      <a data-md-tooltip="View Member" class="md-tooltip--right view" style="cursor: pointer">
                        <i class="mp-icon md-tooltip--right icon-book-open mp-text-c-primary mp-text-fs-large"></i>
                      </a>
                    </span>
                  </td>
                  <td>
                    <span>23781623</span>
                  </td>
                  <td>
                    <span>01-01-2023</span>
                  </td>
                  <td>
                    <span class="member-name">Dela Cruz, Juan Abaa</span>
                  </td>
                  <td>
                    <span>acbc</span>
                  </td>
                  <td>
                    <span>Faculty</span>
                  </td>
                  <td>
                    <span>Position</span>
                  </td>
                  <td>
                    <span>1.5%</span>
                  </td>
                  <td>
                    <span>New Application</span>
                  </td>
                  <td>
                    <span>Forwarded to HRDO</span>
                  </td>

                </tr>
                <tr>
                  <td>

                    <span>
                      <a data-md-tooltip="View Member" class="md-tooltip--right view" style="cursor: pointer">
                        <i class="mp-icon md-tooltip--right icon-book-open mp-text-c-primary mp-text-fs-large"></i>
                      </a>
                    </span>
                  </td>
                  <td>
                    <span>23781623</span>
                  </td>
                  <td>
                    <span>01-01-2023</span>
                  </td>
                  <td>
                    <span class="member-name">Dela Cruz, Juan Abaa</span>
                  </td>
                  <td>
                    <span>acbc</span>
                  </td>
                  <td>
                    <span>Faculty</span>
                  </td>
                  <td>
                    <span>Position</span>
                  </td>
                  <td>
                    <span>1.5%</span>
                  </td>
                  <td>
                    <span>New Application</span>
                  </td>
                  <td>
                    <span>Forwarded to HRDO</span>
                  </td>

                </tr>
                <tr>
                  <td>

                    <span>
                      <a data-md-tooltip="View Member" class="md-tooltip--right view" style="cursor: pointer">
                        <i class="mp-icon md-tooltip--right icon-book-open mp-text-c-primary mp-text-fs-large"></i>
                      </a>
                    </span>
                  </td>
                  <td>
                    <span>23781623</span>
                  </td>
                  <td>
                    <span>01-01-2023</span>
                  </td>
                  <td>
                    <span class="member-name">Dela Cruz, Juan Abaa</span>
                  </td>
                  <td>
                    <span>acbc</span>
                  </td>
                  <td>
                    <span>Faculty</span>
                  </td>
                  <td>
                    <span>Position</span>
                  </td>
                  <td>
                    <span>1.5%</span>
                  </td>
                  <td>
                    <span>New Application</span>
                  </td>
                  <td>
                    <span>Forwarded to HRDO</span>
                  </td>

                </tr>
                <tr>
                  <td>

                    <span>
                      <a data-md-tooltip="View Member" class="md-tooltip--right view" style="cursor: pointer">
                        <i class="mp-icon md-tooltip--right icon-book-open mp-text-c-primary mp-text-fs-large"></i>
                      </a>
                    </span>
                  </td>
                  <td>
                    <span>23781623</span>
                  </td>
                  <td>
                    <span>01-01-2023</span>
                  </td>
                  <td>
                    <span class="member-name">Dela Cruz, Juan Abaa</span>
                  </td>
                  <td>
                    <span>acbc</span>
                  </td>
                  <td>
                    <span>Faculty</span>
                  </td>
                  <td>
                    <span>Position</span>
                  </td>
                  <td>
                    <span>1.5%</span>
                  </td>
                  <td>
                    <span>New Application</span>
                  </td>
                  <td>
                    <span>Forwarded to HRDO</span>
                  </td>

                </tr>
                <tr>
                  <td>

                    <span>
                      <a data-md-tooltip="View Member" class="md-tooltip--right view" style="cursor: pointer">
                        <i class="mp-icon md-tooltip--right icon-book-open mp-text-c-primary mp-text-fs-large"></i>
                      </a>
                    </span>
                  </td>
                  <td>
                    <span>23781623</span>
                  </td>
                  <td>
                    <span>01-01-2023</span>
                  </td>
                  <td>
                    <span class="member-name">Dela Cruz, Juan Abaa</span>
                  </td>
                  <td>
                    <span>acbc</span>
                  </td>
                  <td>
                    <span>Faculty</span>
                  </td>
                  <td>
                    <span>Position</span>
                  </td>
                  <td>
                    <span>1.5%</span>
                  </td>
                  <td>
                    <span>New Application</span>
                  </td>
                  <td>
                    <span>Forwarded to HRDO</span>
                  </td>

                </tr>
                <tr>
                  <td>

                    <span>
                      <a data-md-tooltip="View Member" class="md-tooltip--right view" style="cursor: pointer">
                        <i class="mp-icon md-tooltip--right icon-book-open mp-text-c-primary mp-text-fs-large"></i>
                      </a>
                    </span>
                  </td>
                  <td>
                    <span>23781623</span>
                  </td>
                  <td>
                    <span>01-01-2023</span>
                  </td>
                  <td>
                    <span class="member-name">Dela Cruz, Juan Abaa</span>
                  </td>
                  <td>
                    <span>acbc</span>
                  </td>
                  <td>
                    <span>Faculty</span>
                  </td>
                  <td>
                    <span>Position</span>
                  </td>
                  <td>
                    <span>1.5%</span>
                  </td>
                  <td>
                    <span>New Application</span>
                  </td>
                  <td>
                    <span>Forwarded to HRDO</span>
                  </td>

                </tr>
                <tr>
                  <td>

                    <span>
                      <a data-md-tooltip="View Member" class="md-tooltip--right view" style="cursor: pointer">
                        <i class="mp-icon md-tooltip--right icon-book-open mp-text-c-primary mp-text-fs-large"></i>
                      </a>
                    </span>
                  </td>
                  <td>
                    <span>23781623</span>
                  </td>
                  <td>
                    <span>01-01-2023</span>
                  </td>
                  <td>
                    <span class="member-name">Dela Cruz, Juan Abaa</span>
                  </td>
                  <td>
                    <span>acbc</span>
                  </td>
                  <td>
                    <span>Faculty</span>
                  </td>
                  <td>
                    <span>Position</span>
                  </td>
                  <td>
                    <span>1.5%</span>
                  </td>
                  <td>
                    <span>New Application</span>
                  </td>
                  <td>
                    <span>Forwarded to HRDO</span>
                  </td>

                </tr>
                <tr>
                  <td>

                    <span>
                      <a data-md-tooltip="View Member" class="md-tooltip--right view" style="cursor: pointer">
                        <i class="mp-icon md-tooltip--right icon-book-open mp-text-c-primary mp-text-fs-large"></i>
                      </a>
                    </span>
                  </td>
                  <td>
                    <span>23781623</span>
                  </td>
                  <td>
                    <span>01-01-2023</span>
                  </td>
                  <td>
                    <span class="member-name">Dela Cruz, Juan Abaa</span>
                  </td>
                  <td>
                    <span>acbc</span>
                  </td>
                  <td>
                    <span>Faculty</span>
                  </td>
                  <td>
                    <span>Position</span>
                  </td>
                  <td>
                    <span>1.5%</span>
                  </td>
                  <td>
                    <span>New Application</span>
                  </td>
                  <td>
                    <span>Forwarded to HRDO</span>
                  </td>

                </tr>
                <tr>
                  <td>

                    <span>
                      <a data-md-tooltip="View Member" class="md-tooltip--right view" style="cursor: pointer">
                        <i class="mp-icon md-tooltip--right icon-book-open mp-text-c-primary mp-text-fs-large"></i>
                      </a>
                    </span>
                  </td>
                  <td>
                    <span>23781623</span>
                  </td>
                  <td>
                    <span>01-01-2023</span>
                  </td>
                  <td>
                    <span class="member-name">Dela Cruz, Juan Abaa</span>
                  </td>
                  <td>
                    <span>acbc</span>
                  </td>
                  <td>
                    <span>Faculty</span>
                  </td>
                  <td>
                    <span>Position</span>
                  </td>
                  <td>
                    <span>1.5%</span>
                  </td>
                  <td>
                    <span>New Application</span>
                  </td>
                  <td>
                    <span>Forwarded to HRDO</span>
                  </td>

                </tr>
                <tr>
                  <td>
                    <span>
                      <a data-md-tooltip="View Member" class="md-tooltip--right view" style="cursor: pointer">
                        <i class="mp-icon md-tooltip--right icon-book-open mp-text-c-primary mp-text-fs-large"></i>
                      </a>
                    </span>
                  </td>
                  <td>
                    <span>23781623</span>
                  </td>
                  <td>
                    <span>01-01-2023</span>
                  </td>
                  <td>
                    <span class="member-name">Dela Cruz, Juan Abaa</span>
                  </td>
                  <td>
                    <span>acbc</span>
                  </td>
                  <td>
                    <span>Faculty</span>
                  </td>
                  <td>
                    <span>Position</span>
                  </td>
                  <td>
                    <span>1.5%</span>
                  </td>
                  <td>
                    <span>New Application</span>
                  </td>
                  <td>
                    <span>Forwarded to HRDO</span>
                  </td>

                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div style="width: 20%;">
        <div class="card-container card p-0">
          <div class="card-header history-logs">
            History Logs
          </div>
          <div class="card-body flex-column history-container ">
            <input class="mp-input-group__input mp-text-field mp-pt2 sticky top-0 " type="text" placeholder="Search here" style="width: 95% ;margin-left: auto;margin-right: auto" />
            <div class="history-item">
              <div>
                <span class="font-18">Dela Cruz, Juan</span>
              </div>
              <div>
                <span class="font-13">UP Head Office / Administrator</span>
              </div>
              <div>
                <span class="font-13">Signed in, January 2, 2023 Time: 02:00 pm</span>
              </div>
            </div>
            <div class="history-item">
              <div>
                <span class="font-18">Dela Cruz, Juan</span>
              </div>
              <div>
                <span class="font-13">UP Head Office / Administrator</span>
              </div>
              <div>
                <span class="font-13">Signed in, January 2, 2023 Time: 02:00 pm</span>
              </div>
            </div>
            <div class="history-item">
              <div>
                <span class="font-18">Dela Cruz, Juan</span>
              </div>
              <div>
                <span class="font-13">UP Head Office / Administrator</span>
              </div>
              <div>
                <span class="font-13">Signed in, January 2, 2023 Time: 02:00 pm</span>
              </div>
            </div>
            <div class="history-item">
              <div>
                <span class="font-18">Dela Cruz, Juan</span>
              </div>
              <div>
                <span class="font-13">UP Head Office / Administrator</span>
              </div>
              <div>
                <span class="font-13">Signed in, January 2, 2023 Time: 02:00 pm</span>
              </div>
            </div>
            <div class="history-item">
              <div>
                <span class="font-18">Dela Cruz, Juan</span>
              </div>
              <div>
                <span class="font-13">UP Head Office / Administrator</span>
              </div>
              <div>
                <span class="font-13">Signed in, January 2, 2023 Time: 02:00 pm</span>
              </div>
            </div>
            <div class="history-item">
              <div>
                <span class="font-18">Dela Cruz, Juan</span>
              </div>
              <div>
                <span class="font-13">UP Head Office / Administrator</span>
              </div>
              <div>
                <span class="font-13">Signed in, January 2, 2023 Time: 02:00 pm</span>
              </div>
            </div>
            <div class="history-item">
              <div>
                <span class="font-18">Dela Cruz, Juan</span>
              </div>
              <div>
                <span class="font-13">UP Head Office / Administrator</span>
              </div>
              <div>
                <span class="font-13">Signed in, January 2, 2023 Time: 02:00 pm</span>
              </div>
            </div>
            <div class="history-item">
              <div>
                <span class="font-18">Dela Cruz, Juan</span>
              </div>
              <div>
                <span class="font-13">UP Head Office / Administrator</span>
              </div>
              <div>
                <span class="font-13">Signed in, January 2, 2023 Time: 02:00 pm</span>
              </div>
            </div>
            <div class="history-item">
              <div>
                <span class="font-18">Dela Cruz, Juan</span>
              </div>
              <div>
                <span class="font-13">UP Head Office / Administrator</span>
              </div>
              <div>
                <span class="font-13">Signed in, January 2, 2023 Time: 02:00 pm</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection