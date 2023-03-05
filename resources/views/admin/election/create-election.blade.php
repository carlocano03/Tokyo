@extends('layouts/main')
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
</style>





<div class="filler"></div>
<div class="col-12  mp-text-fs-large mp-text-c-accent  dashboard mh-content" style="padding:0px !important;">


    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-12 mp-mt5 gap-10" id="settingsContent">
                <div class="mp-card  mp-ph2 mp-pv2">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="top-label">
                                    <label>Setup New Election Module</label>
                                    <br>
                                    <label class="account-info">Allow user to create Election
                                    </label>
                                    {{ csrf_field() }}
                                    <form id="classif_form" class="mh-reg-form form-border-bottom" style="height: calc(100% - 100px) !important;">

                                        <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3 member-form mp-pv2 shadow-inset-1">
                                            <input type="hidden" id="app_trailNo">
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Election Reference No:</label>
                                                <label class="mp-input-group__label">102-2912</label>
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Select Cluster</label>
                                                <select class="mp-input-group__input mp-text-field" name="status" id="status" required>
                                                    <option value="1">Cluster 1</option>
                                                    <option value="0">Cluster 2</option>
                                                </select>
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Election Year</label>
                                                <select class="mp-input-group__input mp-text-field" name="status" id="status" required>
                                                    <option value="1">2020</option>
                                                    <option value="0">2021</option>
                                                </select>
                                            </div>

                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Election Date</label>
                                                <input type="date" id="from" class="mp-input-group__input mp-text-field radius-1 border-1 date-input outline" style=" height: 30px;">
                                            </div>

                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Time Open</label>
                                                <input type="time" id="from" class="mp-input-group__input mp-text-field radius-1 border-1 date-input outline" style=" height: 30px;">
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Time Close</label>
                                                <input type="time" id="from" class="mp-input-group__input mp-text-field radius-1 border-1 date-input outline" style=" height: 30px;">
                                            </div>

                                            <div class="mp-input-group">
                                                <input type="checkbox" class="checkbox-color " style="margin-left:2px;margin-right:3px;" id="terms" name="terms">
                                                <label class="mp-input-group__label">Open Time / User Access</label>
                                            </div>




                                            <a class="up-button-green btn-md button-animate-right mp-text-center" id="save_class" type="submit">
                                                <span>OPEN THIS ELECTION</span>
                                            </a>
                                            <a class="up-button btn-md button-animate-right mp-text-center">
                                                <span>SAVE DRAFT ELECTION</span>
                                            </a>
                                            <a class="up-button-grey btn-md button-animate-right mp-text-center">
                                                <span>CLEAR SETUP</span>
                                            </a>

                                            <!-- <button type="submit" class="sss" id="btn-submit">Submit</button> -->

                                        </div>

                                    </form>

                                </div>

                            </div>

                            <div class="col-lg-5">
                                <div class="top-label">
                                    <label>Manage Candidates</label>
                                    <br>

                                    <label class="account-info">Allow user to manage Candidates
                                    </label>
                                    {{ csrf_field() }}
                                    <form id="classif_form" class="mh-reg-form form-border-bottom" style="height: calc(100% - 100px) !important;">

                                        <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3 member-form mp-pv2 shadow-inset-1">
                                            <input type="hidden" id="app_trailNo">
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Salary Grade</label>
                                                <label class="mp-input-group__label">102-2912</label>
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Select Cluster</label>
                                                <select class="mp-input-group__input mp-text-field" name="status" id="status" required>
                                                    <option value="1">Cluster 1</option>
                                                    <option value="0">Cluster 2</option>
                                                </select>
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Election Year</label>
                                                <select class="mp-input-group__input mp-text-field" name="status" id="status" required>
                                                    <option value="1">2020</option>
                                                    <option value="0">2021</option>
                                                </select>
                                            </div>

                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Election Date</label>
                                                <input type="date" id="from" class="mp-input-group__input mp-text-field radius-1 border-1 date-input outline" style=" height: 30px;">
                                            </div>

                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Time Open</label>
                                                <input type="time" id="from" class="mp-input-group__input mp-text-field radius-1 border-1 date-input outline" style=" height: 30px;">
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Time Close</label>
                                                <input type="time" id="from" class="mp-input-group__input mp-text-field radius-1 border-1 date-input outline" style=" height: 30px;">
                                            </div>

                                            <div class="mp-input-group">
                                                <input type="checkbox" class="checkbox-color " style="margin-left:2px;margin-right:3px;" id="terms" name="terms">
                                                <label class="mp-input-group__label">Open Time / User Access</label>
                                            </div>




                                            <a class="up-button-green btn-md button-animate-right mp-text-center" id="save_class" type="submit">
                                                <span>OPEN THIS ELECTION</span>
                                            </a>
                                            <a class="up-button btn-md button-animate-right mp-text-center">
                                                <span>SAVE DRAFT ELECTION</span>
                                            </a>
                                            <a class="up-button-grey btn-md button-animate-right mp-text-center">
                                                <span>CLEAR SETUP</span>
                                            </a>

                                            <!-- <button type="submit" class="sss" id="btn-submit">Submit</button> -->

                                        </div>

                                    </form>


                                </div>
                            </div>


                            <div class="col-lg-3">

                                <div class="top-label">
                                    <label>Candidates</label>


                                    <label class="account-info">Allow user to create Election
                                    </label>
                                    {{ csrf_field() }}
                                    <form id="classif_form" class="mh-reg-form form-border-bottom" style="height: calc(100% - 100px) !important;">

                                        <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3 member-form mp-pv2 shadow-inset-1">
                                            <input type="hidden" id="app_trailNo">
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Election Reference No:</label>
                                                <label class="mp-input-group__label">102-2912</label>
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Select Cluster</label>
                                                <select class="mp-input-group__input mp-text-field" name="status" id="status" required>
                                                    <option value="1">Cluster 1</option>
                                                    <option value="0">Cluster 2</option>
                                                </select>
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Election Year</label>
                                                <select class="mp-input-group__input mp-text-field" name="status" id="status" required>
                                                    <option value="1">2020</option>
                                                    <option value="0">2021</option>
                                                </select>
                                            </div>

                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Election Date</label>
                                                <input type="date" id="from" class="mp-input-group__input mp-text-field radius-1 border-1 date-input outline" style=" height: 30px;">
                                            </div>

                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Time Open</label>
                                                <input type="time" id="from" class="mp-input-group__input mp-text-field radius-1 border-1 date-input outline" style=" height: 30px;">
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Time Close</label>
                                                <input type="time" id="from" class="mp-input-group__input mp-text-field radius-1 border-1 date-input outline" style=" height: 30px;">
                                            </div>

                                            <div class="mp-input-group">
                                                <input type="checkbox" class="checkbox-color " style="margin-left:2px;margin-right:3px;" id="terms" name="terms">
                                                <label class="mp-input-group__label">Open Time / User Access</label>
                                            </div>




                                            <a class="up-button-green btn-md button-animate-right mp-text-center" id="save_class" type="submit">
                                                <span>OPEN THIS ELECTION</span>
                                            </a>
                                            <a class="up-button btn-md button-animate-right mp-text-center">
                                                <span>SAVE DRAFT ELECTION</span>
                                            </a>
                                            <a class="up-button-grey btn-md button-animate-right mp-text-center">
                                                <span>CLEAR SETUP</span>
                                            </a>

                                            <!-- <button type="submit" class="sss" id="btn-submit">Submit</button> -->

                                        </div>

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
    document.querySelector("input[type=number]")
        .oninput = e => console.log(new Date(e.target.valueAsNumber, 0, 1))
</script>

@endsection