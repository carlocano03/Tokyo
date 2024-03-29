@extends('layouts/main')
<div id="modalBackDrop" class="d-none opacity-0">
    <div class="modalContent">

        <div class="d-none opacity-0" id="electionModal">
            <div class="modalBody">

                <div class="d-flex flex-column gap-10" style="width: 700px;"> <span style="font-weight: bold; font-size: x-large"></span>
                    <label class="close-button" id="closeModal">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </label>
                    <div class="">
                        <label class="election_modal_title">Setup New Election Module</label>
                        <br>
                        <label class="account-info">
                        </label>
                        <form id="election_form" class=" form-border-bottom" style="height: calc(100% - 100px) !important;">
                            {{ csrf_field() }}
                            <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3 member-form mp-pv2 shadow-inset-1">

                                <div class="mp-input-group">
                                    <!-- <label class="mp-input-group__label">Election Reference No:</label>
                                    <label class="mp-input-group__label">102-2912</label> -->
                                </div>
                                <div class="mp-input-group">
                                    <label class="mp-input-group__label">Select Cluster</label>
                                    <select class=" mp-input-group__input mp-text-field" name="cluster_id" id="cluster_id" required>
                                        <option value="">Select Cluster No.</option>
                                        <option value="1">Cluster 1 - DSB</option>
                                        <option value="2">Cluster 2 - LBOU</option>
                                        <option value="3">Cluster 3 - MLAPGH</option>
                                        <option value="4">Cluster 4 - CVM</option>
                                    </select>
                                </div>
                                <div class="mp-input-group">
                                    <label class="mp-input-group__label">Election Year</label>
                                    <select class=" mp-input-group__input mp-text-field" name="election_year" id="election_year" required>
                                        @for ($i = 2023; $i <= 2099; $i++) <option value="{{ $i }}">
                                            {{ $i }}
                                            </option>
                                            @endfor
                                    </select>
                                </div>

                                <div class="mp-input-group">
                                    <label class="mp-input-group__label">Election Date</label>
                                    <input type="date" id="election_date" name="election_date" class="mp-input-group__input mp-text-field radius-1 border-1 date-input outline" style=" height: 30px;">
                                </div>

                                <div class="mp-input-group">
                                    <label class="mp-input-group__label">Time Open</label>
                                    <input type="time" name="time_open" id="time_open" class="mp-input-group__input mp-text-field radius-1 border-1 date-input outline" style=" height: 30px;">
                                </div>
                                <div class="mp-input-group">
                                    <label class="mp-input-group__label">Time Close</label>
                                    <input type="time" name="time_close" id="time_close" class="mp-input-group__input mp-text-field radius-1 border-1 date-input outline" style=" height: 30px;">
                                </div>

                                <div class="mp-input-group">
                                    <input type="checkbox" class="checkbox-color" style="margin-left:2px;margin-right:3px;" id="user_access" name="user_access">
                                    <label class="mp-input-group__label">Open Time / User Access</label>
                                </div>




                                <a class="up-button-green btn-md button-animate-right mp-text-center" id="save_election" type="submit">
                                    <span>CREATE ELECTION</span>
                                </a>
                                <!-- <a class="up-button btn-md button-animate-right mp-text-center" id="save_draft_election">
                                    <span>SAVE DRAFT ELECTION</span>
                                </a> -->
                                <a class="up-button-grey btn-md button-animate-right mp-text-center" id="clear_election">
                                    <span>CLEAR SETUP</span>
                                </a>


                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>


        <div class="d-none opacity-0" id="candidateModal">
            <div class="modalBody">

                <div class="d-flex flex-column gap-10" style="width: 700px;"> <span style="font-weight: bold; font-size: x-large"></span>
                    <label class="close-button" id="closeModal">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </label>
                    <div class="top-label">
                        <label class="election_modal_title">Manage Candidates</label>
                        <br>
                        <button class="mp-input-group__label button-active button-menu" id="sg15_button">1-15 Category</button>
                        <button class="mp-input-group__label button-menu" id="sg16_button">16 Above Category</button>

                        <div id="candidates_sg15">
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            <form id="addCandidateForm" method="" enctype="multipart/form-data" style="height: calc(100% - 100px) !important;">
                                @csrf

                                <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3 member-form mp-pv2 shadow-inset-1" style="margin-top: -2px;">
                                    <input type="hidden" id="app_trailNo">
                                    <div class="mp-input-group">
                                        <label class="mp-input-group__label">Salary Grade</label>
                                        <label class="mp-input-group__label">1-15 Category</label>

                                    </div>
                                    <div class="mp-input-group">
                                        <label class="mp-input-group__label">Select Candidate Name</label> <br>
                                        <select class="js-example-responsive mp-input-group__input mp-text-field " data-set="validate-election-field" style="width:100%; " name="candidates_dropdown" id="candidates_dropdown" required>

                                        </select>
                                    </div>
                                    <div class="mp-input-group">
                                        <label class="mp-input-group__label">Candidate Cluster</label>
                                        <input style="height: 40px; " type="text" id="candidate_cluster" disabled value="" data-set="validate-election-field" class="mp-input-group__input mp-text-field radius-1 border-1  " style=" height: 30px;">

                                    </div>
                                    <div class="mp-input-group">
                                        <label class="mp-input-group__label">Candidate Campus</label>
                                        <input style="height: 40px; " type="text" id="candidate_campus" disabled value="" data-set="validate-election-field" class="mp-input-group__input mp-text-field radius-1 border-1  " style=" height: 30px;">
                                    </div>
                                    <div class="mp-input-group">
                                        <label class="mp-input-group__label">Candidate Position</label>
                                        <input style="height: 40px; " type="text" id="candidate_position" disabled value="" data-set="validate-election-field" class="mp-input-group__input mp-text-field radius-1 border-1  " style=" height: 30px;">
                                    </div>



                                    <div class="mp-input-group">
                                        <label class="mp-input-group__label">Select Candidate Image/Photo *</label>
                                        <input style="height: 40px;border: none;" type="file" name="candidate_photo" data-set="validate-election-field" id="candidate_photo" accept=" image/png, image/gif, image/jpeg, image/jpg" class="mp-input-group__input mp-text-field radius-1 border-1 date-input outline">
                                    </div>
                                    <div class="mp-input-group">
                                        <label class="mp-input-group__label">File Attachment</label>
                                        <input style="height: 40px;border: none;" type="file" name="candidate_attachment" data-set="validate-election-field" id="candidate_attachment" accept="image/png, image/gif, image/jpeg, image/jpg" class="mp-input-group__input mp-text-field radius-1 border-1 date-input outline">
                                    </div>
                                    <a class="up-button btn-md button-animate-right mp-text-center" id="saveCandidateSG15">
                                        <span>ADD CANDIDATE</span>
                                    </a>
                                </div>
                            </form>
                        </div>

                        <div id="candidates_sg16" class="d-none opacity-0">
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            <form id="addCandidateFormSG16" method="" enctype="multipart/form-data" style="height: calc(100% - 100px) !important;">
                                @csrf

                                <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3 member-form mp-pv2 shadow-inset-1" style="margin-top: -2px;">

                                    <div class="mp-input-group">
                                        <label class="mp-input-group__label">Salary Grade</label>
                                        <label class="mp-input-group__label">1-16 Category</label>

                                    </div>
                                    <div class="mp-input-group">
                                        <label class="mp-input-group__label">Select Candidate Name</label> <br>
                                        <select class="js-example-responsive mp-input-group__input mp-text-field " data-set=validate-election-field2 style="width:100%; " name="candidates_dropdownSG16" id="candidates_dropdownSG16" required>

                                        </select>
                                    </div>
                                    <div class="mp-input-group">
                                        <label class="mp-input-group__label">Candidate Cluster</label>
                                        <input style="height: 40px; " type="text" id="candidate_clusterSG16" data-set=validate-election-field2 disabled value="" class="mp-input-group__input mp-text-field radius-1 border-1  " style=" height: 30px;">

                                    </div>
                                    <div class="mp-input-group">
                                        <label class="mp-input-group__label">Candidate Campus</label>
                                        <input style="height: 40px; " type="text" id="candidate_campusSG16" data-set=validate-election-field2 disabled value="" class="mp-input-group__input mp-text-field radius-1 border-1  " style=" height: 30px;">
                                    </div>
                                    <div class="mp-input-group">
                                        <label class="mp-input-group__label">Candidate Position</label>
                                        <input style="height: 40px; " type="text" id="candidate_positionSG16" data-set=validate-election-field2 disabled value="" class="mp-input-group__input mp-text-field radius-1 border-1  " style=" height: 30px;">
                                    </div>



                                    <div class="mp-input-group">
                                        <label class="mp-input-group__label">Select Candidate Image/Photo *</label>
                                        <input style="height: 40px;border: none;" type="file" name="candidate_photoSG16" data-set=validate-election-field2 id="candidate_photoSG16" accept=" image/png, image/gif, image/jpeg, image/jpg" class="mp-input-group__input mp-text-field radius-1 border-1 date-input outline">
                                    </div>
                                    <div class="mp-input-group">
                                        <label class="mp-input-group__label">File Attachment</label>
                                        <input style="height: 40px;border: none;" type="file" name="candidate_attachmentSG16" data-set=validate-election-field2 id="candidate_attachmentSG16" accept="image/png, image/gif, image/jpeg, image/jpg" class="mp-input-group__input mp-text-field radius-1 border-1 date-input outline">
                                    </div>
                                    <a class="up-button btn-md button-animate-right mp-text-center" id="saveCandidateSG16">
                                        <span>ADD CANDIDATE </span>
                                    </a>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- change attachment modal -->
        <div class="d-none opacity-0" id="changeModal">
            <div class="modalBody">

                <div class="d-flex flex-column gap-10" style="width: 700px;"> <span style="font-weight: bold; font-size: x-large"></span>
                    <label class="close-button" id="closeModal">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </label>
                    <div class="top-label">
                        <label class="election_modal_title"> Edit Info</label>
                        <br>
                        {{ csrf_field() }}
                        <form id="classif_form" class="mh-reg-form form-border-bottom" style="height: calc(100% - 100px) !important;">

                            <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3 member-form mp-pv2 shadow-inset-1" style="margin-top: -2px;">
                                <input type="hidden" id="app_trailNo">
                                <div class="mp-input-group">
                                    <label class="mp-input-group__label">Change Salary Grade</label>
                                    <select class="mp-input-group__input mp-text-field" name="status" id="status" required>
                                        <option value="1">1-15 Category</option>
                                        <option value="0">16-above Category</option>
                                    </select>


                                </div>
                                <div class="mp-input-group">
                                    <label class="mp-input-group__label">Change Candidate Name</label>
                                    <input class="mp-input-group__input mp-text-field" type="text" name="first_name" />
                                </div>
                                <div class="mp-input-group">
                                    <label class="mp-input-group__label">Change Cluster</label>
                                    <select class="mp-input-group__input mp-text-field" name="status" id="status" required>
                                        <option value="1">Cluster 1</option>
                                        <option value="0">Cluster 2</option>
                                    </select>
                                </div>
                                <div class="mp-input-group">
                                    <label class="mp-input-group__label">Change Campus</label>
                                    <select class="mp-input-group__input mp-text-field" name="status" id="status" required>
                                        <option value="1">Campus 1</option>
                                        <option value="0">Campus 2</option>
                                    </select>
                                </div>
                                <div class="mp-input-group">
                                    <label class="mp-input-group__label">Change Candidate Image/Photo *</label>
                                    <input style="height: 40px;border: none;" type="file" class="mp-input-group__input mp-text-field radius-1 border-1 date-input outline" style=" height: 30px;">
                                </div>
                                <div class="mp-input-group">
                                    <label class="mp-input-group__label">Change File Attachment</label>
                                    <input style="height: 40px;border: none;" type="file" class="mp-input-group__input mp-text-field radius-1 border-1 date-input outline" style=" height: 30px;">
                                </div>
                                <a class="up-button btn-md button-animate-right mp-text-center">
                                    <span>Change</span>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                <br>
            </div>
        </div>
        <!-- view attachment modal end -->

        <!-- view attachment modal -->
        <div class="d-none opacity-0" id="viewAttachmentModal">
            <div class="modalBody">

                <div class="d-flex flex-column gap-10" style="width: 700px;"> <span style="font-weight: bold; font-size: x-large"></span>
                    <label class="close-button" id="closeModal">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </label>
                    <div class="top-label">
                        <label class="election_modal_title">Denneb Gomez - President | Attachment</label>
                        <br>
                        {{ csrf_field() }}
                        <form id="classif_form" class="mh-reg-form form-border-bottom" style="height: calc(100% - 100px) !important;">

                            <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3 member-form mp-pv2 shadow-inset-1" style="margin-top: -2px;">
                                <input type="hidden" id="app_trailNo">
                                <div class="mp-input-group" style="text-align:center;">
                                    <label class="mp-input-group__label">Attachment Info</label>
                                </div>
                                <i class="fa fa-database db-text" style="text-align:center; margin:0px;" aria-hidden="true"></i>
                                <!-- <a id="closeModal" class="up-button btn-md button-animate-right mp-text-center">
                                    <span>Close</span>
                                </a> -->
                            </div>
                        </form>
                    </div>
                </div>
                <br>
            </div>
        </div>
        <!-- view attachment modal end -->


        <!-- <div class="modalFooter gap-10">
            <button id="agree">
                I Agree
            </button>
            <button id="disagree">
                I do not Agree
            </button>
        </div> -->
    </div>
</div>
@section('content_body')

<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
        transform: scale(0.6);
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: var(--c-accent);
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

    .button-active {
        background-color: var(--c-accent);
        color: white;

    }

    .button-menu {
        font-weight: 600;
        border-radius: 5px;
    }

    .candidates {
        text-align: center;
        border: solid 1px #c6c6c6;
        margin: 20px;
    }

    .candidates label {
        font-size: 25px;
        width: 100%;
        color: white;
        background-color: var(--c-accent);
        border: solid 1px black;
    }

    .candidate-button-container {
        display: flex;
        flex-wrap: nowrap;
        margin: 5px;
    }

    .candidate-button-container>div {
        /* background-color: #f1f1f1; */
        width: 100%;
        margin: 1px;
        text-align: center;


        font-size: 12px;
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
        margin-top: 100px;
        padding: 0;
        border-radius: 17px;
        transition: all 1s;
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

    .create-button {
        text-align: center;
    }

    .create-button button {
        padding: 11px;
    }

    .profile-text span {
        margin-bottom: -10px;
    }

    .profile-text {
        display: inline-grid;
        margin-bottom: 20px;
    }

    .profile-button {
        display: inline-flex;
        font-size: 15px;
        gap: 5px;
    }

    .profile-button button {
        padding-left: 10px;
        padding-right: 10px;

        border-radius: 12px;
    }

    .close-button {
        position: absolute;
        right: 0;
        top: 0;
        margin: 10px;
        font-size: 25px;
    }

    .selection {
        font-size: 12px !important;
    }

    .empty-candidates {
        text-align: center;
        border: 1px solid #adaaaa;
        padding: 20px;
    }
</style>




<div class="filler"></div>

<div class="col-12  mp-text-fs-large mp-text-c-accent  dashboard mh-content" style="padding:0px !important;">


    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2" id="settingsTab" style="padding:0px !important; height: 100%; overflow-y:auto; ">
                <div class="mp-card admin-settingtab election-tab-shrink" style="padding-bottom:150px;">
                    <div class="settings-tab">
                        <div class="top-label">
                            <label>Election Module</label>

                        </div>

                        <div class="settings-buttons">
                            <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-start" id="menu">
                                <!-- <li class="options " onclick="location.href='/admin/create-election'">
                                    <a href="#" class="no-padding ">Create New Election</a><br>

                                </li> -->
                                <li class="options options-active" onclick="location.href='/admin/election-record'">
                                    <a href="#" class="no-padding options-a-active">Election Records</a><br>

                                </li>

                                <li class="options" onclick="location.href='/admin/election-analytics'">
                                    <a href="#" class="no-padding">Election Day Analytics</a><br>

                                </li>

                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-10 mp-mt3 gap-10" id="settingsContent">
                <div class="button-container mp-mb3">
                    <button class="f-button magenta-bg" id="showSettings">Hide Tab</button>
                </div>
                <div class="col-12 mp-pv0 mp-pr0 d-flex mp-mh3">
                    <a href="/admin/election-record/" style="margin-left:-10px;"><span class="  back-button-default">
                            < Back </span></a>

                </div>
                <div class="mp-card  mp-ph2 mp-pv2">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="top-label">

                                    <div class="setup-election">

                                        <form id="classif_form" class="mh-reg-form form-border-bottom" style="height: calc(50% - 100px) !important;">
                                            <h4 style="color: white;
                                            padding: 15px;
                                            background-color: var(--c-active-hover-bg);
                                            margin: 0;width: 100%;">Election Details
                                            </h4>
                                            <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3 member-form mp-pv2 shadow-inset-1">
                                                <input type="hidden" id="app_trailNo">
                                                <div class="mp-input-group">
                                                    <label class="mp-input-group__label">Election Reference No:</label>
                                                    <label class="mp-input-group__label"> {{$election_details->election_id}}</label>
                                                </div>
                                                <div class="mp-input-group">
                                                    <label class="mp-input-group__label">Cluster:</label>
                                                    <label class="mp-input-group__label">{{$election_details->cluster_name}}</label>
                                                </div>
                                                <div class="mp-input-group">
                                                    <label class="mp-input-group__label">Election Year:</label>
                                                    <label class="mp-input-group__label">{{$election_details->election_year}}</label>
                                                </div>
                                                <div class="mp-input-group">
                                                    <label class="mp-input-group__label">Election Date:</label>
                                                    <label class="mp-input-group__label">{{$election_details->election_date}}</label>
                                                </div>
                                                <div class="mp-input-group">


                                                    <label class="mp-input-group__label">Time Open: </label>
                                                    <label class="mp-input-group__label">{{$election_details->time_open == "" ? "Not Set" :$election_details->time_open }}</label>
                                                    <br>
                                                    <label class="mp-input-group__label">Time Closed: </label>
                                                    <label class="mp-input-group__label">{{$election_details->time_close == "" ? "Not Set" :$election_details->time_close }}</label>


                                                </div>

                                                <div class="mp-input-group">


                                                    <label class="mp-input-group__label">Status:</label>
                                                    <label class="mp-input-group__label">{{$election_details->status}}</label>


                                                </div>
                                                <!-- <div class="mp-input-group">


                                                    <label class="mp-input-group__label">Salary Grade Category:</label>
                                                    <label class="mp-input-group__label">Both SG 1-15 and SG 16 Above</label>


                                                </div> -->
                                                <br>


                                                <a class="up-button-green btn-md button-animate-right mp-text-center" id="open_election" type="submit">
                                                    <span>Open Election</span>
                                                </a>

                                                <!-- <a id="open_edit_modal" class="up-button btn-md button-animate-right mp-text-center">
                                                    <span>Update Election</span>
                                                </a> -->



                                            </div>

                                        </form>
                                    </div>


                                </div>
                            </div>
                            <div class="col-lg-8">

                                <div class="top-label">
                                    <label>Candidates</label>
                                    <br>
                                    <button class="up-button btn-md button-animate-right mp-text-center" id="addCandidates" type="button">
                                        <span>Add</span>
                                    </button>

                                    <div class="setup-election">
                                        <br>


                                        <form id="classif_form" class="mh-reg-form form-border-bottom" style="height: calc(50% - 100px) !important;  border-bottom: none;">

                                            <h4 style="color: white;
                                            padding: 15px;
                                            background-color: var(--c-accent);
                                            margin: 0;width: 100%;">Salary Grade 1-15
                                            </h4>

                                            @forelse($candidates_detailsSG15 as $candidate_rowSG15)

                                            <div class="container-fluid">
                                                <div class="row" style="padding: 25px;">
                                                    <div class="col-4">

                                                        <div class="profile-img">
                                                            <img src="{{ storage_path('app/public/candidates/'.$candidate_rowSG15->candidate_photo) }}" alt="">

                                                        </div>
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="profile-text">
                                                            <span>{{ $candidate_rowSG15->firstname }} {{ $candidate_rowSG15->middlename }} {{ $candidate_rowSG15->lastname }}</span>
                                                            <span> {{ $candidate_rowSG15->membership_id }}</span>
                                                            <span> {{ $candidate_rowSG15->campus_name }} / {{ $candidate_rowSG15->classification }}</span>

                                                        </div>
                                                        <div class="profile-button">

                                                            <button type="button" class="up-button" id="viewAttachmentButton">View Attachment</button>
                                                            <button type="button" class="up-button-green" id="changeButton">Change</button>
                                                            <button type="button" class="up-button-red" id="removeButton" value="{{$candidate_rowSG15->candidate_id}}">Remove</button>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            @empty
                                            <p class="empty-candidates">No SG 1-15 Candidates Yet</p>
                                            @endforelse


                                        </form>

                                    </div>


                                    <br>

                                    {{ csrf_field() }}

                                    <form id="classif_form" class="mh-reg-form form-border-bottom" style="height: calc(50% - 100px) !important; border-bottom: none;">

                                        <h4 style="color: white;
                                            padding: 15px;
                                            background-color: var(--c-accent);
                                            margin: 0;width: 100%;">Salary Grade 16-Above
                                        </h4>

                                        @forelse($candidates_detailsSG16 as $candidate_rowSG16)

                                        <div class="container-fluid">
                                            <div class="row" style="padding: 25px;">
                                                <div class="col-4">

                                                    <div class="profile-img">
                                                        <img src="{{ storage_path('app/public/candidates/'.$candidate_rowSG16->candidate_photo) }}" alt="">

                                                    </div>
                                                </div>
                                                <div class="col-8">
                                                    <div class="profile-text">
                                                        <span>{{ $candidate_rowSG16->firstname }} {{ $candidate_rowSG16->middlename }} {{ $candidate_rowSG16->lastname }}</span>
                                                        <span> {{ $candidate_rowSG16->membership_id }}</span>
                                                        <span> {{ $candidate_rowSG16->campus_name }} / {{ $candidate_rowSG16->classification }}</span>

                                                    </div>
                                                    <div class="profile-button">

                                                        <button type="button" class="up-button" id="viewAttachmentButton">View Attachment</button>
                                                        <button type="button" class="up-button-green" id="changeButton">Change</button>
                                                        <button type="button" class="up-button-red" id="removeButton" value="{{$candidate_rowSG16->candidate_id}}">Remove</button>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>


                                        @empty
                                        <p class="empty-candidates">No SG 16-33 Candidates Yet</p>
                                        @endforelse

                                    </form>

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
    function reset() {
        $("#election_year").val("").trigger("change");
        $("#cluster_id").val("").trigger("change");
        $("#election_date").val("").trigger("change");
        $("#election_year").val("2023").trigger("change");
        $("#time_open").val("").trigger("change");
        $("#time_close").val("").trigger("change");
        $("#user_access").val("").trigger("change");
    }

    function closeModal() {
        $("#modalBackDrop").addClass("opacity-0")
        $("#electionModal").addClass("opacity-0")
        $("#candidateModal").addClass("opacity-0")
        $("#viewAttachmentModal").addClass("opacity-0")
        $("#changeModal").addClass("opacity-0")

        setTimeout(function() {
            $("#modalBackDrop").addClass("d-none")
            $("#candidateModal").addClass("d-none")
            $("#electionModal").addClass("d-none")
            $("#viewAttachmentModal").addClass("d-none")
            $("#changeModal").addClass("d-none")
        }, 1000)
    }
    $(document).on('click', '#closeModal', function(e) {
        $("#modalBackDrop").addClass("opacity-0")
        $("#electionModal").addClass("opacity-0")
        $("#candidateModal").addClass("opacity-0")
        $("#viewAttachmentModal").addClass("opacity-0")
        $("#changeModal").addClass("opacity-0")

        setTimeout(function() {
            $("#modalBackDrop").addClass("d-none")
            $("#candidateModal").addClass("d-none")
            $("#electionModal").addClass("d-none")
            $("#viewAttachmentModal").addClass("d-none")
            $("#changeModal").addClass("d-none")
        }, 100)
    })

    $(document).on('click', '#open_edit_modal', function(e) {

        $("#modalBackDrop").removeClass("d-none")
        $("#candidateModal").addClass("d-none")
        $("#candidateModal").addClass("opacity-0")
        $("#electionModal").removeClass("d-none")
        $("#electionModal").removeClass("opacity-0")

        var cluster_id = <?php echo json_encode($election_details->cluster_id) ?>;
        var election_year = <?php echo json_encode($election_details->election_year) ?>;
        var election_date = <?php echo json_encode($election_details->election_date) ?>;
        var time_open = <?php echo json_encode($election_details->time_open) ?>;
        var time_close = <?php echo json_encode($election_details->time_close) ?>;
        var user_access = <?php echo json_encode($election_details->user_access) ?>;


        //realtime value
        $("#cluster_id").val(cluster_id).trigger("change");
        $("#election_year").val(election_year).trigger("change");
        $("#election_date").val(election_date).trigger("change");
        $("#time_open").val(time_open).trigger("change");
        $("#time_close").val(time_close).trigger("change");
        $("#user_access").val(user_access).trigger("change");



        setTimeout(function() {
            $("#modalBackDrop").removeClass("opacity-0")
        }, 100)
    })

    $(document).on('click', '#addCandidates', function(e) {
        $("#candidates_dropdown").html("");
        $("#candidates_dropdownSG16").html("");
        $("#modalBackDrop").removeClass("d-none")
        $("#electionModal").addClass("d-none")
        $("#electionModal").addClass("opacity-0")
        $("#candidateModal").removeClass("d-none")
        $("#candidateModal").removeClass("opacity-0")
        setTimeout(function() {
            $("#modalBackDrop").removeClass("opacity-0")
        }, 100)


        //get members dropdown serach
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: "{{ route('election_candidates_list') }}",
            data: {
                sg_category: "SG15"
            },
            success: function(data) {
                console.log(data)
                $.each(data, function(key, value) {
                    var fullname = value.firstname + " " + value.middlename + " " + value.lastname;
                    $("#candidates_dropdown").append("<option value='" + value.mem_id + "' data-cluster_id='" + value.cluster_id + "' data-campus_name='" +
                        value.campus_name + "' data-campus_id='" + value.campus_id + "' data-position='" + value.classification + "'" +
                        "data-personal_id='" + value.personal_id + "' >" + value.employee_no + "- " + fullname + "</option>");

                    if (key == 0) {
                        $("#candidate_cluster").val(clusterNameIdentifier(value.cluster_id)).trigger("change");
                        $("#candidate_campus").val(value.campus_name).trigger("change");
                        $("#candidate_position").val(value.classification).trigger("change");
                    }
                });
            }
        });

        $.ajax({
            type: 'POST',
            url: "{{ route('election_candidates_list') }}",
            data: {
                sg_category: "SG16"
            },
            success: function(data) {
                console.log(data)
                $.each(data, function(key, value) {

                    var fullname = value.firstname + " " + value.middlename + " " + value.lastname;
                    $("#candidates_dropdownSG16").append("<option value='" + value.mem_id + "' data-cluster_id='" + value.cluster_id + "' data-campus_name='" +
                        value.campus_name + "' data-campus_id='" + value.campus_id + "' data-position='" + value.classification + "'" +
                        "data-personal_id='" + value.personal_id + "' >" + value.employee_no + "- " + fullname + "</option>");
                    if (key == 0) {
                        $("#candidate_clusterSG16").val(clusterNameIdentifier(value.cluster_id)).trigger("change");
                        $("#candidate_campusSG16").val(value.campus_name).trigger("change");
                        $("#candidate_positionSG16").val(value.classification).trigger("change");
                    }

                });
            }
        });

    })



    function clusterNameIdentifier(id) {
        if (id == 1) {
            return "Cluster 1 - DSB";
        } else if (id == 2) {
            return "Cluster 2 - LBOU";
        } else if (id == 3) {
            return "Cluster 3 - MLAPGH";
        } else if (id == 4) {
            return "Cluster 4 - CVM";
        }
    }
    $("#candidates_dropdown").change(function() {
        console.log(selected_campus_id)
        var selected_cluster = $(this).find(':selected').data('cluster_id');
        var selected_campus_name = $(this).find(':selected').data('campus_name');
        var selected_position = $(this).find(':selected').data('position');
        var selected_campus_id = $(this).find(':selected').data('campus_id');
        var selected_membership_id = $(this).val();

        $("#candidate_cluster").val(clusterNameIdentifier(selected_cluster)).trigger("change");
        $("#candidate_campus").val(selected_campus_name).trigger("change");
        $("#candidate_position").val(selected_position).trigger("change");
    });


    $("#candidates_dropdownSG16").change(function() {
        var selected_cluster = $(this).find(':selected').data('cluster_id');
        var selected_campus_name = $(this).find(':selected').data('campus_name');
        var selected_position = $(this).find(':selected').data('position');
        var selected_campus_id = $(this).find(':selected').data('campus_id');
        var selected_membership_id = $(this).val();


        $("#candidate_clusterSG16").val(clusterNameIdentifier(selected_cluster)).trigger("change");
        $("#candidate_campusSG16").val(selected_campus_name).trigger("change");
        $("#candidate_positionSG16").val(selected_position).trigger("change");
    });
    $(document).on('click', '#saveCandidateSG15', function(e) {


        let hasError = false

        const elements = $(document).find(`[data-set=validate-election-field]`)

        elements.map(function() {

            if ($(this).attr('err-name')) {
                return
            }

            let status = true
            status = validateField({
                element: $(this),
                target: 'validate-election-field'
            })

            if (!hasError && status) {
                hasError = true
            }
        })

        if (hasError) return
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var form = $('#addCandidateForm')[0];
        var formData = new FormData(form);
        var photoFile = $('#candidate_photo')[0].files;
        var attachmentFile = $('#candidate_attachment')[0].files;

        var sg_category = "1-15";
        var selected_cluster = $('#candidates_dropdown').find(':selected').data('cluster_id');
        var selected_campus_id = $('#candidates_dropdown').find(':selected').data('campus_id');
        var selected_position = $('#candidates_dropdown').find(':selected').data('position');
        var selected_personal_id = $('#candidates_dropdown').find(':selected').data('personal_id');
        var selected_membership_id = $('#candidates_dropdown').val();

        formData.append('cluster_id', $('#candidates_dropdown').find(':selected').data('cluster_id'));
        formData.append('campus_id', $('#candidates_dropdown').find(':selected').data('campus_id'));
        formData.append('election_id', <?php echo json_encode($election_details->election_id) ?>);
        formData.append('membership_id', $('#candidates_dropdown').val());
        formData.append('sg_category', sg_category);
        formData.append('candidate_photo', photoFile[0]);
        formData.append('candidate_attachment', attachmentFile[0]);
        formData.append('personal_id', $('#candidates_dropdown').find(':selected').data('personal_id'));

        $.ajax({
            url: "{{ route('add_candidates') }}",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {
                console.log(data);
                closeModal();
                Swal.fire({
                    text: 'SG 1-15 Candidate has been created Successfully.',
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok',
                }).then(okay => {
                    if (okay) {
                        location.reload();
                    }
                });
            },
        });

    })

    $(document).on('click', '#saveCandidateSG16', function(e) {
        let hasError = false

        const elements = $(document).find(`[data-set=validate-election-field2]`)

        elements.map(function() {

            if ($(this).attr('err-name')) {
                return
            }

            let status = true
            status = validateField({
                element: $(this),
                target: 'validate-election-field2'
            })

            if (!hasError && status) {
                hasError = true
            }
        })

        if (hasError) return
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var form = $('#addCandidateFormSG16')[0];
        var formData = new FormData(form);
        var photoFile = $('#candidate_photoSG16')[0].files;
        var attachmentFile = $('#candidate_attachmentSG16')[0].files;

        var sg_categorySG16 = "16-33";
        var selected_cluster = $('#candidates_dropdownSG16').find(':selected').data('cluster_id');
        var selected_campus_id = $('#candidates_dropdownSG16').find(':selected').data('campus_id');
        var selected_position = $('#candidates_dropdownSG16').find(':selected').data('position');
        var selected_membership_id = $('#candidates_dropdownSG16').val();
        var selected_personal_id = $('#candidates_dropdown16').find(':selected').data('personal_id');

        formData.append('cluster_idSG16', $('#candidates_dropdownSG16').find(':selected').data('cluster_id'));
        formData.append('campus_idSG16', $('#candidates_dropdownSG16').find(':selected').data('campus_id'));
        formData.append('election_idSG16', <?php echo json_encode($election_details->election_id) ?>);
        formData.append('membership_idSG16', $('#candidates_dropdownSG16').val());
        formData.append('sg_category', sg_categorySG16);
        formData.append('candidate_photoSG16', photoFile[0]);
        formData.append('candidate_attachmentSG16', attachmentFile[0]);
        formData.append('personal_idSG16', $('#candidates_dropdownSG16').find(':selected').data('personal_id'));

        // console.log(election_id);
        // console.log(selected_membership_id);
        console.log(photoFile[0])
        $.ajax({
            url: "{{ route('add_candidates') }}",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {
                console.log(data);
                closeModal();
                Swal.fire({
                    text: 'SG 16-33 Candidate has been created Successfully.',
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok',
                }).then(okay => {
                    if (okay) {
                        location.reload();
                    }
                });
            },
        });

    })

    $(document).on('click', '#viewAttachmentButton', function(e) {

        $("#modalBackDrop").removeClass("d-none")
        $("#viewAttachmentModal").removeClass("d-none")
        $("#viewAttachmentModal").removeClass("opacity-0")
        setTimeout(function() {
            $("#modalBackDrop").removeClass("opacity-0")
        }, 100)
    })

    $(document).on('click', '#changeButton', function(e) {

        $("#modalBackDrop").removeClass("d-none")
        $("#changeModal").removeClass("d-none")

        setTimeout(function() {
            $("#modalBackDrop").removeClass("opacity-0")
            $("#changeModal").removeClass("opacity-0")
        }, 100)
    })

    $(document).on('click', '#removeButton', function(e) {
        Swal.fire({
            title: 'Do you want to delete this candidate?',
            showDenyButton: true,
            showCancelButton: true,
            showConfirmButton: false,
            denyButtonText: `Delete`,
        }).then((result) => {

            if (result.isDenied) {
                var value = $(this).attr("value");
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('delete-candidate') }}",
                    method: "POST",
                    data: {
                        candidate_id: value
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        if (data.success == true) {
                            Swal.fire({
                                text: 'Candidate has been deleted successfully.',
                                icon: 'success',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Ok',
                            }).then(okay => {
                                if (okay) {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire('Something went wrong!', '', 'error')
                        }
                    }
                });

            }
        })

    })

    $(document).on('click', '#showSettings', function(e) {
        if ($("#settingsTab").hasClass("col-lg-2")) {
            $("#settingsTab").addClass("d-none");
            $("#settingsTab").removeClass("col-lg-2");
            $("#settingsContent").removeClass("col-lg-10");
            $("#settingsContent").addClass("col-lg-12");

            $("#showSettings").text("Show Tab")

        } else {
            $("#settingsTab").removeClass("d-none");
            $("#settingsTab").addClass("col-lg-2");
            $("#settingsContent").removeClass("col-lg-12");
            $("#settingsContent").addClass("col-lg-10");

            $("#showSettings").text("Hide Tab")
        }

    })

    $(document).on('click', '#update_election_record', function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var formData = $("#election_form").serialize();
        console.log(formData)
        $.ajax({
            type: 'POST',
            url: "{{ route('update_election_record') }}",
            data: formData,
            success: function(data) {
                reset();
                if (data.success != '') {
                    console.log(data)
                    Swal.fire({
                        text: 'Election has been Updated Successfully.',
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok',
                    });

                    setTimeout(function() {
                        location.reload();
                    }, 500)

                }
                closeModal();

            }
        });
    });

    $(document).on('click', '#save_election', function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var formData = $("#election_form").serialize();
        $.ajax({
            type: 'POST',
            url: "{{ route('save_election') }}",
            data: formData,
            success: function(data) {
                reset();
                if (data.success != '') {
                    console.log(data)
                    Swal.fire({
                        text: 'Election has been saved as draft!',
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok',
                    });

                }
                closeModal();

            }
        });
    });



    $(document).on('click', '#open_election', function() {



        var formData = $("#election_id").serialize();
        getElectionStatus();
        console.log("click");




    });

    function getElectionStatus(view = '') {

        var election_id = <?php echo json_encode($election_details->election_id) ?>;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('election_validation') }}",
            method: "POST",
            data: {
                view: view,
                election_id: election_id
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
                if (data.open_election <= 0) {
                    Swal.fire({
                        text: 'Election is now open!',
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok',
                    });
                } else {
                    Swal.fire({
                        text: 'An existing election is open!',
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok',
                    });
                }
            }
        });
    }

    $(document).on('click', '#clear_election', function() {
        reset();
    });

    $(document).on('click', "#user_access", function() {
        if ($('#user_access').is(':checked')) {
            $("#time_open").prop("disabled", true);
            $("#time_close").prop("disabled", true);
            $("#user_access").val("OPEN");
        } else {
            $("#time_open").prop("disabled", false);
            $("#time_close").prop("disabled", false);
            $("#user_access").val(null);
        }
    });

    $(document).on('click', "#sg15_button", function() {
        showSG15();
        hideSG16();
        activeSG15();

    });

    $(document).on('click', "#sg16_button", function() {
        hideSG15();
        showSG16();
        activeSG16();

    });




    function hideSG15() {
        $("#candidates_sg15").addClass("d-none");
        $("#candidates_sg15").addClass("opacity-0");
    }

    function showSG15() {
        $("#candidates_sg15").removeClass("d-none");
        $("#candidates_sg15").removeClass("opacity-0");
    }

    function hideSG16() {
        $("#candidates_sg16").addClass("d-none");
        $("#candidates_sg16").addClass("opacity-0");
    }

    function showSG16() {
        $("#candidates_sg16").removeClass("d-none");
        $("#candidates_sg16").removeClass("opacity-0");
    }

    function activeSG15() {
        $("#sg15_button").addClass("button-active");
        $("#sg16_button").removeClass("button-active");
    }

    function activeSG16() {
        $("#sg15_button").removeClass("button-active");
        $("#sg16_button").addClass("button-active");
    }





    document.querySelector("input[type=number]")
        .oninput = e => console.log(new Date(e.target.valueAsNumber, 0, 1))
</script>

@endsection