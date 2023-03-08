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
</style>





<div class="filler"></div>
<div class="col-12  mp-text-fs-large mp-text-c-accent  dashboard mh-content" style="padding:0px !important;">


    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-12 mp-mt5 gap-10" id="settingsContent">
                <label style="margin-left: 50px;
                font-size: 50px;">Under Development</label>
                <!-- <div class="mp-card  mp-ph2 mp-pv2">
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


                                        </div>

                                    </form>

                                </div>

                            </div>

                            <div class="col-lg-4">
                                <div class="top-label">
                                    <label>Manage Candidates</label>
                                    <br>
                                    <button class="mp-input-group__label button-active button-menu">1-15 Category</button>
                                    <button class="mp-input-group__label button-menu">16 Above Category</button>
                                    {{ csrf_field() }}
                                    <form id="classif_form" class="mh-reg-form form-border-bottom" style="height: calc(100% - 100px) !important;">

                                        <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3 member-form mp-pv2 shadow-inset-1" style="margin-top: -2px;">
                                            <input type="hidden" id="app_trailNo">
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Salary Grade</label>
                                                <label class="mp-input-group__label">1-15 Category</label>

                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Select Candidate Name</label>
                                                <select class="mp-input-group__input mp-text-field" name="status" id="status" required>
                                                    <option value="1">Name 1</option>
                                                    <option value="0">Name 2</option>
                                                </select>
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Select Cluster</label>
                                                <select class="mp-input-group__input mp-text-field" name="status" id="status" required>
                                                    <option value="1">Cluster 1</option>
                                                    <option value="0">Cluster 2</option>
                                                </select>
                                            </div>

                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Select Running Position</label>
                                                <input style="height: 40px;border: none;" type="file" class="mp-input-group__input mp-text-field radius-1 border-1 date-input outline" style=" height: 30px;">
                                            </div>

                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Select Campus</label>
                                                <select class="mp-input-group__input mp-text-field" name="status" id="status" required>
                                                    <option value="1">Campus 1</option>
                                                    <option value="0">Campus 2</option>
                                                </select>
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">Select Candidate Image/Photo *</label>
                                                <input style="height: 40px;border: none;" type="file" class="mp-input-group__input mp-text-field radius-1 border-1 date-input outline" style=" height: 30px;">
                                            </div>
                                            <div class="mp-input-group">
                                                <label class="mp-input-group__label">File Attachment</label>
                                                <input style="height: 40px;border: none;" type="file" class="mp-input-group__input mp-text-field radius-1 border-1 date-input outline" style=" height: 30px;">
                                            </div>







                                            <a class="up-button btn-md button-animate-right mp-text-center">
                                                <span>ADD CANDIDATE</span>
                                            </a>




                                        </div>

                                    </form>


                                </div>
                            </div>


                            <div class="col-lg-4">

                                <div class="top-label">
                                    <label>Candidates</label>
                                    <div class="mp-input-group">
                                        <label class="mp-input-group__label">PRESIDENTIAL CANDIDATES</label>

                                        <div class="candidates">
                                            <label>Candidate No 1:</label>
                                            <h5>Denneb Gomez</h5>
                                            <div class="profile-img">
                                                <img src="https://scontent.fmnl4-2.fna.fbcdn.net/v/t39.30808-6/333703943_879550633256042_5999893648977274305_n.jpg?_nc_cat=105&ccb=1-7&_nc_sid=09cbfe&_nc_eui2=AeEvDY9Oe-XZrHs-GDUojjSZgyayc5ndww6DJrJzmd3DDv3w58dPBBxi9TKP4f0RndihehBgfuodgKGh3phfTpJz&_nc_ohc=Rala1y4s5KoAX_E8fm3&_nc_ht=scontent.fmnl4-2.fna&oh=00_AfA9i2OQ2TviYLFewh1RsM4Hl-kAgHga0VpODOgsRh1NtQ&oe=640B1A9D" alt="">
                                            </div>

                                            <div class="candidate-button-container">
                                                <div> <button class="up-button-green edit_coll" style="border-radius: 5px;">
                                                        VIEW
                                                        <i style="float:none; margin:0px;" class=" fa fa-eye" aria-hidden="true"></i>

                                                    </button>
                                                </div>
                                                <div>
                                                    <button class="up-button-green edit_coll" style="border-radius: 5px;">
                                                        EDIT
                                                        <i style="float:none; margin:0px;" class=" fa fa-edit" aria-hidden="true"></i>

                                                    </button>
                                                </div>
                                                <div>
                                                    <button class="up-button" style="border-radius: 5px;">
                                                        DELETE
                                                        <i style="float:none; margin:0px;" class="fa fa-trash" aria-hidden="true"></i>

                                                    </button>
                                                </div>

                                            </div>




                                        </div>
                                        <div class="candidates">
                                            <label>Candidate No 2:</label>
                                            <h5>Denneb Gomez</h5>
                                            <div class="profile-img">
                                                <img src="https://scontent.fmnl4-2.fna.fbcdn.net/v/t39.30808-6/333703943_879550633256042_5999893648977274305_n.jpg?_nc_cat=105&ccb=1-7&_nc_sid=09cbfe&_nc_eui2=AeEvDY9Oe-XZrHs-GDUojjSZgyayc5ndww6DJrJzmd3DDv3w58dPBBxi9TKP4f0RndihehBgfuodgKGh3phfTpJz&_nc_ohc=Rala1y4s5KoAX_E8fm3&_nc_ht=scontent.fmnl4-2.fna&oh=00_AfA9i2OQ2TviYLFewh1RsM4Hl-kAgHga0VpODOgsRh1NtQ&oe=640B1A9D" alt="">
                                            </div>

                                            <div class="candidate-button-container">
                                                <div> <button class="up-button-green edit_coll" style="border-radius: 5px;">
                                                        VIEW
                                                        <i style="float:none; margin:0px;" class=" fa fa-eye" aria-hidden="true"></i>

                                                    </button>
                                                </div>
                                                <div>
                                                    <button class="up-button-green edit_coll" style="border-radius: 5px;">
                                                        EDIT
                                                        <i style="float:none; margin:0px;" class=" fa fa-edit" aria-hidden="true"></i>

                                                    </button>
                                                </div>
                                                <div>
                                                    <button class="up-button" style="border-radius: 5px;">
                                                        DELETE
                                                        <i style="float:none; margin:0px;" class="fa fa-trash" aria-hidden="true"></i>

                                                    </button>
                                                </div>

                                            </div>




                                        </div>


                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div> -->

            </div>
        </div>
    </div>
    <script>
        document.querySelector("input[type=number]")
            .oninput = e => console.log(new Date(e.target.valueAsNumber, 0, 1))
    </script>

    @endsection