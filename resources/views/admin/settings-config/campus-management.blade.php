@extends('layouts/main')
@section('content_body')

<style>
    /* .card-container {
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
    max-height: calc(100vh - 219px);
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

  .settings-tab {

    margin-top: 20px;
  }

  .top-label {
    padding: 10px;
    font-weight: bold;
    font-size: 20px;
    color: var(--c-base-50);
  }

  .settings-tab label {
    /* margin-left: 20px; */
    }

    .settings-tab a {
        /* margin-left: 20px; */
    }

    .top-label i {
        float: right;
        margin-right: 22px;
        margin-top: 5px;
    }

    .no-padding {
        padding: 0px !important;
    }

    .options {
        padding: 20px;
        border: 1px solid #e9dfdf;

    }

    .options a {
        color: black;
    }

    .options:hover {
        background-color: #f6f6f6;
    }

    .options .option-info {
        font-size: 12px;
        color: var(--c-base-50);
        line-height: 1;
    }

    .options-active {
        background-color: var(--c-accent) !important;
    }

    .options-a-active {
        color: white !important;
    }

    .options-info-active {
        color: white !important;
    }

    .account-info {
        font-size: 12px;
        color: var(--c-base-50);
        line-height: 1;
        font-weight: 400;
    }

    */
</style>



<div class="filler"></div>
<div class="col-12  mp-text-fs-large mp-text-c-accent  dashboard mh-content" style="padding:0px !important;">


    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2" style="padding:0px !important; height: 100%; overflow-y:auto; ">
                <div class="mp-card" style="padding-bottom:150px;">
                    <div class="settings-tab">
                        <div class="top-label">
                            <label>Settings</label>
                            <i class="fa fa-cog" aria-hidden="true"></i>
                        </div>

                        <div class="settings-buttons">
                            <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-start" id="menu">
                                <li class="options" onclick="location.href='manage-account'">
                                    <a href="#" class="no-padding">Manage Accounts</a><br>
                                    <label class="option-info">Allow User to create and manage system user accounts, You also can manage permissions and
                                        authorizations.
                                    </label>
                                </li>
                                <li class="options options-active" onclick="location.href='campus-management'">
                                    <a href="#" class="no-padding options-a-active">Campus Management</a><br>
                                    <label class="option-info options-info-active">Allow User to manage respective campus; key, names, and clusters
                                    </label>
                                </li>
                                <li class="options " onclick="location.href='employee-classification'">
                                    <a href="#" class="no-padding ">Employee Classification</a><br>
                                    <label class="option-info">Allow User to add and manage employee Classifications
                                    </label>
                                </li>
                                <li class="options " onclick="location.href='college-management'">
                                    <a href="#" class="no-padding">College / Unit Management</a><br>
                                    <label class="option-info">Allow User to manage respective College and units
                                    </label>
                                </li>
                                <li class="options" onclick="location.href='department-management'">
                                    <a href="#" class="no-padding ">Department Management</a><br>
                                    <label class="option-info ">Allow User to manage respective departments per campuses
                                    </label>
                                </li>
                                <li class="options " onclick="location.href='status-appointment'">
                                    <a href="#" class="no-padding ">Status and Appointments</a><br>
                                    <label class="option-info ">Allow User to pre-setup, manage the employee status and appointments.
                                    </label>
                                </li>
                                <li class="options " onclick="location.href='sg-modules'">
                                    <a href="#" class="no-padding ">SG Modules</a><br>
                                    <label class="option-info">Allow User to pre-setup salary grade range and assign salary grade category for election
                                        modules
                                    </label>
                                </li>
                                <li class="options " onclick="location.href='history-logs'">
                                    <a href="#" class="no-padding ">History Logs</a><br>
                                    <label class="option-info">Allow User to retrieve and monitor user activity using History logs module.
                                        modules
                                    </label>
                                </li>
                                <li class="options " onclick="location.href='backup-database'">
                                    <a href="#" class="no-padding ">Backup Database</a><br>
                                    <label class="option-info ">Allow User to download and backup system database for documentations and risk management
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-10 mp-mt3 gap-10">

                <div class="mp-card  mp-ph2 mp-pv2">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="top-label">
                                    <label>Create Account</label>
                                    <label class="account-info">Allow User to manage respective campus; key, names, and clusters
                                    </label>


                                </div>

                            </div>

                            <div class="col-lg-8">
                                <div>
                                    <div class="top-label">
                                        <label>Data Records</label>
                                    </div>
                                    <div class="mp-mt3 table-container" style="height:calc(100%-100px) !important;">
                                        <table class="members-table" style="height: auto;;" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <span>Username</span>
                                                    </th>
                                                    <th>
                                                        <span>Password</span>
                                                    </th>
                                                    <th>
                                                        <span>Fullname</span>
                                                    </th>
                                                    <th>
                                                        <span>Campus</span>
                                                    </th>
                                                    <th>
                                                        <span>User Level</span>
                                                    </th>
                                                    <th>
                                                        <span>Status</span>
                                                    </th>
                                                    <th>
                                                        <span>Action</span>
                                                    </th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @for ($i = 0; $i < 100; $i++) <tr>
                                                    <td>akosirr</td>
                                                    <td>asd</td>
                                                    <td>AKO SI RR</td>
                                                    <td>UP DILIMAN</td>
                                                    <td>Super admin</td>
                                                    <td>Pending</td>
                                                    <td>
                                                        <button class="up-button-green" style="border-radius: 10px;">
                                                            view <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </button>

                                                    </td>
                                                    </tr>

                                                    @endfor
                                            </tbody>
                                        </table>



                                    </div>
                                    <div class="records-button" style="transform: scale(0.7);">
                                        <a class="up-button btn-md   mp-text-center" style="margin-top:3px; width: 160px;" type="submit">
                                            <span>Print</span>
                                        </a>
                                        <br>
                                        <a class="up-button-green btn-md    mp-text-center" style="margin-top:3px; width: 160px;" type="submit">
                                            <span>Download</span>
                                        </a>
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



@endsection