@extends('layouts/centerPane')

@section('loginForm')
<div class="logo-title">
    <div class="mp-pb4 mp-text-center">
        <img src="{!! asset('assets/images/uppfi-logo-sm.png') !!}" alt="UPPFI">
    </div>
    <div class="mp-pb4 mp-text-fs-large mp-text-center mp-split-pane__title mp-text-c-primary">
        {{ Request::route()->getName() == 'admin' ? 'Admin' : 'Member' }} Login
    </div>
</div>

<div class="mp-text-fs-small">
    @if (Session::get('error'))
    <div class='mp-flash mp-flash--danger'>
        {{ Session::get('error') }}
    </div>
    @endif
    @if (session('status'))
    <div class="mp-flash mp-flash--success">
        {{ session('status') }}
    </div>
    @endif
</div>
<!-- <button id="modal_name_pop">Show Modal</button> -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<form id="loginForm" class="mp-pt4 mp-mb5" method="post" action="{{ url('/login') }}">
    {{ csrf_field() }}
    <div class="mp-pb4 mp-input-group" data-set="email">
        <label class="mp-input-group__label" for="email">
            {{ Request::route()->getName() == 'admin' ? 'Email' : "Member's ID Number" }}
        </label>
        <input type="hidden" name="usertype" value="{{ Request::route()->getName() == 'admin' ? 'admin' : 'member' }}">
        <input class="mp-input-group__input mp-text-field input" type="{{ Request::route()->getName() == 'admin' ? 'email' : 'text' }}" id="{{ Request::route()->getName() == 'admin' ? 'email' : 'memberNo' }}" name="{{ Request::route()->getName() == 'admin' ? 'email' : 'memberNo' }}" maxlength="{{ Request::route()->getName() == 'admin' ? ' ' : '9' }}" value="{{ Session::get('user') }}" autofocus required />
        <label id="err-msg" class="mp-input-group__label red-clr d-none"></label>
    </div>
    <div class="mp-pb4 mp-input-group" data-set="password">
        <label class="mp-input-group__label" for="password">Password</label>
        <input class="mp-input-group__input mp-text-field input" type="password" id="password" name="password" required />
        <label id="err-msg" class="mp-input-group__label red-clr d-none"></label>
    </div>
    <div class="col col-auto">

        <div class="row">
            <div class="col-6" style="padding:0px;">
                <label class="mp-text-fs-small mp-link link_style" style="padding-top:10px;" id="forgot_password">
                    Forgot password?
                </label>
            </div>

            <div class="col-6" style="text-align:right; padding: 0px;">
                <button type="submit" class="mp-button mp-button--accent">Login</button>
            </div>



        </div>
    </div>
    <div class="mp-pt3 row justify-content-between grid mp-pv-1">
        <div class="col">
            <div class="row flex-column">


                <br />
                <br />
                @if (Request::route()->getName() == 'admin')
                <a class="mp-text-fs-small mp-link link_style" href="https://www.upprovidentfund.com/">
                    Back to www.upprovidentfund.com
                </a>
                @else
                <label class="mp-text-fs-small">
                    <span>If you are not yet a member? </span><span class="mp-link link_style" id="register">Click
                        here</span>
                </label>
                <label class="mp-text-fs-small">
                    <span>Do you want to check your application status? </span><span class="mp-link link_style" id="status_trail">Click here</span>
                </label>
                <a class="mp-text-fs-small mp-link link_style" href="https://www.upprovidentfund.com/">
                    Back to www.upprovidentfund.com
                </a>
                @endif
            </div>
        </div>
    </div>

</form>
@endsection

@section('status-trail-form')
<div class="mp-pb4  mp-text-center">
    <img src="{!! asset('assets/images/uppfi-logo-sm.png') !!}" alt="UPPFI">
</div>
<div class="mp-pb4 mp-text-fs-large mp-text-center mp-split-pane__title mp-text-c-primary">
    Application Status Trail
</div>

{{-- <label class="mp-text-fs-medium">
        Abutin ang pangarap kasama ang
        <a href="https://www.upprovidentfund.com/" target="_blank">
            UP PROVIDENT FUND INC.
        </a>
    </label> --}}

<div class="mp-input-group mp-mt3 mp-text-center qr">
    <label class="mp-input-group__label">Scan QR</label>
    <br>
    <img src="{!! asset('assets/icons/qr-icon.svg') !!}" alt="UPPFI">
</div>

<div class="mp-input-group mp-mt2" id="input-app">
    <label class="mp-input-group__label">Application Number</label>
    <input class="mp-input-group__input mp-text-field" type="text" id="app_no_trail" required />
</div>

<div class="col col-auto">
    <div class="row" style="float:left;">
        <button class="up-button btn-md mp-mt3 button-animate-left  hover-back" id="fp_back" value="">
            <span>Back</span>
        </button>
    </div>

    <div class="row" style="float:right;">
        <button class="up-button btn-md mp-mt3 mp-mb3 button-animate-right " id="search_btn">
            <span>Search</span>
        </button>
    </div>
</div>

<div class="status-result">
    <div class="status-title">
        Online Membership Application Status
        <br>
        <div class="status-icon">
            <i class="fa fa-frown-o" aria-hidden="true" id="icon_status"></i>
        </div>
        <div class="status-text">
            <span id="found_remarks">Not Found</span>
        </div>
    </div>
    <div class="status-info">
        <div class="row">
            <div class="col">
                <label>Application No. : </label>
            </div>
            <div class="col">
                <label id="appNo_label"></label>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label>First Name : </label>
            </div>
            <div class="col">
                <label id="fname_label"></label>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label>Middle Name : </label>
            </div>
            <div class="col">
                <label id="mname_label"></label>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label>Last Name : </label>
            </div>
            <div class="col">
                <label id="lname_label"></label>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label>Suffix : </label>
            </div>
            <div class="col">
                <label id="suffix_label"></label>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label>Birth date : </label>
            </div>
            <div class="col">
                <label id="bdate_label"></label>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label>Appointment : </label>
            </div>
            <div class="col">
                <label id="appointment_label"></label>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label>Tin No : </label>
            </div>
            <div class="col">
                <label id="tin_no_label"></label>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label>Contact No. : </label>
            </div>
            <div class="col">
                <label id="contact_no_label"></label>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label>Land line no. : </label>
            </div>
            <div class="col">
                <label id="landlineno_label"></label>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label>Email Address : </label>
            </div>
            <div class="col">
                <label id="email_add_label"></label>
            </div>
        </div>

        <div class="row">
            <div class="col-12 status-title" style="margin-bottom: -20px;">
                <Label>Status : </Label>
                <label class="status-text" id="application_status"></label>
            </div>
            <div class="col-12 status-title">
                <Label>Remarks : </Label>
                <label class="status-text"></label>
            </div>
        </div>


        <div class="container" style="text-align:center;">
            <div class="row">
                <div class="col-6">
                    <button class="up-button btn-md mp-mt3  hover-back" id="fp_back" value="" style="float:right;">
                        <span>Close</span>
                    </button>
                </div>

                <div class="col-6">
                    <button class="up-button btn-md mp-mt3 mp-mb3" style="float:left;" id="print_app">Print</button>
                    <button class="up-button btn-md mp-mt3 mp-mb3" style="float:left;" id="cont_app">Continue the
                        application</button>
                </div>
            </div>
        </div>

    </div>


</div>
@endsection

@section('registration-personal-form')
<script>
    $(document).on('click', '#back-to-home', function(e) {
        window.location.href = '/login';
    })
    $(document).on('click', '#back-to-home-okay', function(e) {
        window.location.href = '/login';
    })
</script>
<div class="d-flex gap-10 mp-pt2 bg-white flex-column ">
    <!-- <div style="width: 100%;" class="d-flex gap-10">
                        <div class="ml-auto">
                            <img src="{!! asset('assets/images/uppfi-logo-sm.png') !!}" alt="UPPFI">
                        </div>
                        <div class="d-flex flex-column justify-content-center mr-auto">
                            <div class="mp-mt2 up-color reg-title">University of the Philippines <br /> Provident Fund Inc.</div>
                            <span>Online Membership Application</span>
                        </div>
                    </div> -->
    <div class="mp-mt2 mp-mt2 d-flex items-between">
        <button class="d-flex flex-row align-items-center up-button mp-pl2 mp-pr2" id="back" value="" style="gap: 5px; font-size: 13px; border-radius: 10px; padding-top: 2px; padding-bottom: 2px">
            <span> <i class="fa fa-chevron-left " aria-hidden="true"></i> Back</span>
        </button>
        <button id="back-to-home" class="d-flex flex-row align-items-center up-button" style="gap: 5px; font-size: 13px; border-radius: 10px; padding-top: 2px; padding-bottom: 2px"><span>Back to Login </span> <i class="fa fa-home" aria-hidden="true" style="font-size: 15px; cursor: pointer;"></i></button>
    </div>
    <!-- <div class="mp-mt2 up-color reg-title mp-text-center">
        <div class="mp-pb2 mp-text-center">
            <img src="{!! asset('assets/images/uppfi-logo-sm.png') !!}" alt="UPPFI">
        </div>
        Online Membership Application
    </div> -->
    <!-- <span class="mp-pt2" id="step-title">Step 1: Enter your Personal Information</span> -->
    <div class="relative mp-mt2 w-90 d-flex ml-auto mr-auto" id="steps">
        <ul class="d-flex flex-row items-between w-100 stepper">
            <li class="circle active" id="stepper-1">1</li>
            <li class="circle" id="stepper-2">2</li>
            <li class="circle" id="stepper-3">3</li>
            <li class="circle" id="stepper-4">4</li>
            <li class="circle" id="stepper-5">5</li>
        </ul>
        <div class="line step-1" id="line"></div>
    </div>
    <div class="applicationNo">
        <label>Application No </label><br>
        <span id="application_no"></span>
    </div>

    <label class="mp-text-fs-medium mp-ph2 mp-split-pane__title mp-text-c-primary mb-0 mp-pv2 br-top-2 mp-mt2" id="registration-title">Step 1: Enter your Personal Information</label>

    <div id="message-box" style="display:none;" style="border: solid 2px #c6c1c1; padding: 35px;">
        <input type="hidden" id="application_number">
        <input type="hidden" id="employee_id">
        <br>
        <div class="axa-success">
            <i class="fa fa-check-circle" aria-hidden="true"></i>
        </div>
        <br>
        <h5 class="registration-last-text" style="font-size: 25px;text-align: center; font-weight: 450;">Registration Completed Successfully
            <label class="please-check"> Please Check your registered email for email verification.</label>
        </h5>
        <p>Click here to download your forms.</p>
        <label class="axa-links" id="axa_insurance_form_download">Insurance Form</label>
        <br>
        <label class="axa-links" id="proxy_form_download">Proxy Form</label>
        <br>
        <label class="axa-links" id="membership_form_download">Membership Application Form</label>
        <br>
        <button class="up-button" style="margin-top: 40px; width: 100%;padding: 5px 10px 5px 10px;border-radius: 39px;" id="back-to-home-okay">
            OKAY</button>
    </div>
</div>
<form id="member_forms" class="mh-reg-form form-border-bottom">
    {{ csrf_field() }}
    <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3 member-form mp-pv2 shadow-inset-1" id="step-1">
        <input type="hidden" id="app_trailNo">
        <!-- <label class="mp-text-fs-medium">Personal Information</label> -->
        <div class="mp-input-group" data-set="firstname">
            <label class="mp-input-group__label">First Name (Please input your complete first name/s)</label>
            <input class="mp-input-group__input mp-text-field" type="text" name="firstname" required />
            <label id="err-msg" class="mp-input-group__label red-clr d-none"></label>
        </div>

        <div class="mp-input-group" data-set="middlename">

            <label class="mp-input-group__label">Middle Name (Please input your complete middle name.)</label><br>
            <input type="checkbox" class="options" id="no_middlename" name="no_middlename" value="N/A" onClick="ckChange(this)" />
            <label class="mp-input-group__label" style="margin-top: 5px;">No Middle Name</label>
            <input class="mp-input-group__input mp-text-field" type="text" name="middlename" required />
            <label id="err-msg" class="mp-input-group__label red-clr d-none"></label>
        </div>

        <div class="mp-input-group" data-set="lastname">
            <label class="mp-input-group__label">Last Name</label>
            <input class="mp-input-group__input mp-text-field" type="text" name="lastname" required />
            <label id="err-msg" class="mp-input-group__label red-clr d-none"></label>
        </div>


        <div class="mp-input-group">
            <label class="mp-input-group__label">Suffix </label><br>
            <input type="checkbox" class="options" id="no_suffix" name="no_suffix" value="N/A" />
            <label class="mp-input-group__label" style="margin-top: 5px;">No Suffix</label>
            <input class="mp-input-group__input mp-text-field" type="text" name="suffix" />
        </div>

        <div class="mp-input-group input" data-set="birthday" name="birthday">
            <label class="mp-input-group__label mp-mb1">Date of Birth </label>
            <div class="d-flex flex-row gap-10 mb-pb1 mp-text-field input">
                <div class="d-flex flex-column" style="gap: 3px">
                    <label class="mp-input-group__label">Month </label>
                    <select name="date_birth_month" id="date_birth_month" class="radius-1 outline select-field" style="font-size: normal;">
                        <option value="">Month</option>
                        <option value="01">January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>
                <span><br />-</span>
                <div class="d-flex flex-column" style="gap: 3px">
                    <label class="mp-input-group__label">Day </label>
                    <select name="date_birth_days" id="date_birth_days" class="radius-1 outline select-field" style="font-size: normal;">
                        <option value="">Day</option>
                        @for($day = 1; $day <= 31; $day++) <option value="{{ sprintf('%02d', $day) }}">{{ sprintf('%02d', $day) }}</option>
                            @endfor
                    </select>
                </div>
                <span><br />-</span>
                <div class="d-flex flex-column" style="gap: 3px">
                    <label class="mp-input-group__label">Year </label>
                    <select name="date_birth_years" id="date_birth_years" class="radius-1 outline select-field" style="font-size: normal;">
                        <!-- options for years from 12 years ago until 70 years before the current year -->
                        <option value="">Year</option>
                        @for ($i = date('Y') - 12; $i >= date('Y') - 70; $i--)
                        <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>


                </div>
            </div>
            <label id="err-msg" class="mp-input-group__label red-clr d-none"></label>
        </div>
        <div class="mp-input-group input" data-set="gender">
            <label class="mp-input-group__label">Sex at Birth </label>
            <br>
            <div style="width: 100%; display: flex">
                <span>
                    <input type="radio" id="gender" name="gender" value="Male">
                    <label class="mp-input-group__label" for="single" style="margin-top: 1px;">Male</label>
                    <input type="radio" id="gender" name="gender" value="Female">
                    <label class="mp-input-group__label" for="single" style="margin-top: 1px;">Female</label>
                </span>
            </div>
            <label id="err-msg" class="mp-input-group__label red-clr d-none"></label>
        </div>
        <div class="mp-input-group" data-set="civilstatus">
            <label class="mp-input-group__label">Civil Status </label>
            <!-- <select class="mp-input-group__input mp-text-field" name="civilstatus" required>
                <option value="">Select Status</option>
                <option>Single</option>
                <option>Married</option>
                <option>Widowed</option>
                <option>Divorced</option>
                <option>Registered Partnership</option>
            </select> -->
            <div class="d-flex gap-5 mp-mb2">
                <input type="radio" value="Single" id="single" name="civilstatus" />
                <label class="mp-input-group__label" for="single" style="margin-top: 1px;">Single</label>

                <input type="radio" value="Married" id="married" name="civilstatus" />
                <label class="mp-input-group__label" for="married" style="margin-top: 1px;">Married</label>

                <input type="radio" value="Widowed" id="widowed" name="civilstatus" />
                <label class="mp-input-group__label" for="widowed" style="margin-top: 1px;">Widowed</label>

                <input type="radio" value="Annulled/Legally separated" id="anulled" name="civilstatus" />
                <label class="mp-input-group__label" for="anulled" style="margin-top: 1px;">Annulled/Legally separated</label>
            </div>
            <label id="err-msg" class="mp-input-group__label red-clr d-none"></label>
        </div>
        <div class="mp-input-group" data-set="citizenship">
            <label class="mp-input-group__label">Citizenship </label>
            <div class="d-flex gap-5">
                <input type="radio" value="FILIPINO" id="citizenship" name="citizenship" />
                <label class="mp-input-group__label" for="citizenship_d" style="margin-top: 1px;">Filipino</label>
                <input type="radio" value="DUAL CITIZENSHIP" id="citizenship" name="citizenship" />
                <label class="mp-input-group__label" for="citizenship_d" style="margin-top: 1px;">Dual
                    Citizenship</label>
                <input type="radio" value="OTHERS" id="citizenship" name="citizenship" />
                <label class="mp-input-group__label" for="citizenship_o" style="margin-top: 1px;">Others</label>
            </div>
            <label id="err-msg" class="mp-input-group__label red-clr d-none"></label>


        </div>
        <div class="mp-input-group" data-set="dual_citizenship">
            <label class="mp-input-group__label">Dual Citizenship / Other Citizenship</label>
            <input class="mp-input-group__input mp-text-field" type="text" name="dual_citizenship" id="d_citizen" disabled />
            <label id="err-msg" class="mp-input-group__label red-clr d-none"></label> <br />
        </div>
        <div class="mp-input-group" data-set="present_province">


            <label class="mp-input-group__label">Present Address </label><br>
            <label class="mp-input-group__label">Province
                <!-- <div class="tooltip">
                    <i class="fa fa-question-circle-o circle-design" aria-hidden="true"></i>
                    <div class="right">
                        <div class="text-content">
                            <h3 id="province_text">Municipality List </h3>
                            <ul id="list-container">
                            </ul>
                        </div>
                        <i></i>
                    </div>
                </div> -->
            </label>
            <select class="js-example-responsive mp-input-group__input mp-text-field" style="width:100%;" id="present_province" name="present_province">
                <option value="">Select Province </option>
                {{-- @foreach ($psgc_prov as $row)
                    <option value="{{ $row->code }}">{{ mb_strtoupper($row->name) }}</option>
                @endforeach --}}
            </select>
            <input type="hidden" id="present_province_name" name="present_province_name">
            <label id="err-msg" class="mp-input-group__label red-clr d-none"></label>
        </div>
        <div class="mp-input-group" data-set="present_municipality">
            <label class="mp-input-group__label">Municipality </label>
            <select class="js-example-responsive mp-input-group__input mp-text-field" style="width:100%;" id="present_city" name="present_municipality" required>
                <option value=""></option>
            </select>
            <input type="hidden" id="present_municipality_name" name="present_municipality_name">
            <label id="err-msg" class="mp-input-group__label red-clr d-none"></label>
        </div>
        <div class="mp-input-group" data-set="present_barangay">
            <label class="mp-input-group__label">Barangay </label>
            <select class="js-example-responsive mp-input-group__input mp-text-field" style="width:100%;" id="present_barangay" name="present_barangay" required>
                <option></option>
            </select>
            <input type="hidden" id="present_barangay_name" name="present_barangay_name">
            <label id="err-msg" class="mp-input-group__label red-clr d-none"></label>
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Bldg No. St. No. </label>
            <input class="mp-input-group__input mp-text-field" type="text" id="present_bldg_street" name="present_bldg_street" />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Zipcode </label>
            <input class="mp-input-group__input mp-text-field" type="text" id="present_zipcode" name="present_zipcode" maxlength="5" onkeypress='return event.charCode >= 48 && event.charCode <= 57' />
        </div>

        <div class="mp-input-group">
            <label class="mp-input-group__label">Permanent Address </label>
            <div class="d-flex gap-5">
                <input type="checkbox" value="1" id="perm_add_check" name="perm_add_check" />
                <label class="mp-input-group__label" style="margin-top: 5px;">(Same as above)</label>

            </div>
            <input class="mp-input-group__input mp-text-field" type="text" name="same_add" id="same_add" readonly />

        </div>
        <div class="mp-input-group same_div" data-set="province">
            <label class="mp-input-group__label">Province </label>
            <select class="js-example-responsive mp-input-group__input mp-text-field" style="width:100%;" id="province" name="province" required>
                <option></option>
            </select>
            <input type="hidden" id="province_name" name="province_name">
            <label id="err-msg" class="mp-input-group__label red-clr d-none"></label>
        </div>
        <div class="mp-input-group same_div" data-set="municipality">
            <label class="mp-input-group__label">Municipality </label>
            <select class="js-example-responsive mp-input-group__input mp-text-field" style="width:100%;" id="city" name="municipality" required>
                <option></option>
            </select>
            <input type="hidden" id="municipality_name" name="municipality_name">
            <label id="err-msg" class="mp-input-group__label red-clr d-none"></label>
        </div>
        <div class="mp-input-group same_div" data-set="barangay">
            <label class="mp-input-group__label">Barangay </label>
            <select class="js-example-responsive mp-input-group__input mp-text-field" style="width:100%;" id="barangay" name="barangay" required>
                <option></option>
            </select>
            <input type="hidden" id="barangay_name" name="barangay_name">
            <label id="err-msg" class="mp-input-group__label red-clr d-none"></label>
        </div>
        <div class="mp-input-group same_div">
            <label class="mp-input-group__label">Bldg No. St. No. </label>
            <input class="mp-input-group__input mp-text-field" type="text" id="bldg_street" name="bldg_street" />
        </div>
        <div class="mp-input-group same_div">
            <label class="mp-input-group__label">Zipcode </label>
            <input class="mp-input-group__input mp-text-field" type="text" id="zipcode" name="zipcode" maxlength="5" onkeypress='return event.charCode >= 48 && event.charCode <= 57' />
        </div>
        <div class="mp-input-group" data-set="contact_no">
            <label class="mp-input-group__label">Cellphone Number </label>
            <!-- <input class="mp-input-group__input mp-text-field" type="text" name="contact_no" maxlength="11" onkeypress='return event.charCode >= 48 && event.charCode <= 57' /> -->
            <input class="mp-input-group__input mp-text-field" type="text" name="contact_no" id="contact-number-input" />
            <label id="err-msg" class="mp-input-group__label red-clr d-none"></label>
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Landline Number </label>
            <span class="mp-input-group__input" style="width: 100%">
                <input class=" mp-text-field" type="text" placeholder="Area code" name="area_code" style="width: 30%; text-align:center" maxlength="3" /> -
                <input class=" mp-text-field" type="text" placeholder="(8676 - 1234)" name="landline" id="landline-format" style="width: 50%; padding-left: 10px;" />
                <!-- <input class=" mp-text-field" type="text" placeholder="Local" name="landline_no" id="landline-format" style="width: 20%; text-align:center"/> -->
            </span>
        </div>
        <div class="mp-input-group" data-set="email">
            <label class="mp-input-group__label">Email Address </label>
            <input class="mp-input-group__input mp-text-field" type="email" name="email" />
            <label id="err-msg" class="mp-input-group__label red-clr d-none"></label>
        </div>
        <div class="mp-input-group">
            <div class="mp-input-group  mp-input-group__label">
                <input type="checkbox" id="terms" name="terms" checked />
                I agree to receive emails on updates to my account<br><br>
                By clicking Next, you agree to UP Provident Fund Inc.’s <b class="mp-link link_style" id="termsbtn">Terms of Use</b> and <b id="privacybtn" class="mp-link link_style">Privacy Policy</b>.<br>
                <!--<a class="link_style" href="https://www.privacy.gov.ph/data-privacy-act/">Terms of Service</a> &
                <a class="link_style" href="https://www.privacy.gov.ph/data-privacy-act/">Privacy Policy</a>-->
                </label>
            </div>
            {{-- <button type="submit" class="d-none mp-text-center" id="btn-submit">Submit</button> --}}
            <hr>
        </div>

        <a class="up-button btn-md button-animate-right mp-text-center" style="width: 100%" type="submit" value="step-2" id="next-btn">
            <span>Next</span>
        </a>

        <!-- <button type="submit" class="sss" id="btn-submit">Submit</button> -->

    </div>

</form>
<form id="member_forms_con">
    <!-- <label class="mp-text-fs-medium">Employment Details</label> -->
    <input type="hidden" id="employee_details_ID">
    <div class="mp-pt3 d-none gap-10 flex-column mp-pb5 member-form mp-pv2 shadow-inset-1" id="step-2">
        <div class="mp-input-group" data-set="campus">
            <label class="mp-input-group__label">Campus </label>
            <select class="js-example-responsive mp-input-group__input mp-text-field" style="width:100%;" name="campus" id="campus" required>
                <option value="">Select Campus</option>
                {{-- @foreach ($campuses as $row)
                    <option value="{{ $row->campus_key }}">{{ $row->name }}</option>
                @endforeach --}}
            </select>
            <label id="err-msg" class="mp-input-group__label red-clr d-none"></label>
        </div>
        <div class="mp-input-group" data-set="classification">
            <label class="mp-input-group__label">Employee Classification </label>
            <select class="js-example-responsive mp-input-group__input mp-text-field" style="width:100%;" name="classification" id="classification">
                <option value="">Select Classification</option>
                <option value="OTHER">Others</option>
                {{-- <option>Class A </option> --}}
            </select>
            <label id="err-msg" class="mp-input-group__label red-clr d-none"></label>
        </div>
        <div class="mp-input-group d-none opacity-0" id="other_classification">
            <label class="mp-input-group__label">Other Classification (Please Specify)</label>
            <input class="mp-input-group__input mp-text-field" type="text" name="classification_others" />
        </div>
        <div class="mp-input-group" data-set="employee_no">
            <label class="mp-input-group__label">Employee Number (Please refer to your UP ID)</label>
            <input class="mp-input-group__input mp-text-field" type="number" name="employee_no" required />
            <label id="err-msg" class="mp-input-group__label red-clr d-none"></label>
        </div>
        <div class="mp-input-group" data-set="college_unit">
            <label class="mp-input-group__label">College / Unit </label>
            <select class="js-example-responsive mp-input-group__input mp-text-field" style="width:100%;" name="college_unit" id="college_unit">
                <option value="">Select Unit</option>
                {{-- <option>Unit </option> --}}
            </select>
            <label id="err-msg" class="mp-input-group__label red-clr d-none"></label>
        </div>
        <div class="mp-input-group" data-set="department">
            <label class="mp-input-group__label">Department </label>
            <select class="js-example-responsive mp-input-group__input mp-text-field" style="width:100%;" name="department" id="department" required>
                <option value="">Select Department</option>
                <option value="OTHER">Others</option>
                {{-- <option>DEPED </option> --}}
            </select>
            <div id="other-dept-div" class=" d-none opacity-0">
                <label class="mp-input-group__label">Other Department (Please Specify)</label>
                <input class="mp-input-group__input mp-text-field" type="text" value="" name="other_department" id="other_department" />
            </div>
            <label id="err-msg" class="mp-input-group__label red-clr d-none"></label>
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Academic Rank/ Position </label>
            <input class="mp-input-group__input mp-text-field" type="text" name="rank_position" id="rank_position" />
        </div>
        <div class="mp-input-group" data-set="date_appoint_months">
            <label class="mp-input-group__label mp-mb1">Date of Appointment (Please refer to your appointment papers)</label>
            <div class="d-flex flex-row gap-10 mb-pb1 mp-text-field input">
                <div class="d-flex flex-column" style="gap: 3px">
                    <label class="mp-input-group__label">Month </label>
                    <select name="date_appoint_months" id="date_appoint_months" class="radius-1 outline select-field" style="font-size: normal;">
                        <option value="">Month</option>
                        <option value="01">January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>
                <span><br />-</span>
                <div class="d-flex flex-column" style="gap: 3px">
                    <label class="mp-input-group__label">Day </label>
                    <select name="date_appoint_days" id="date_appoint_days" class="radius-1 outline select-field" style="font-size: normal;">
                        <option value="">Day</option>
                        @for($day = 1; $day <= 31; $day++) <option value="{{ sprintf('%02d', $day) }}">{{ sprintf('%02d', $day) }}</option>
                            @endfor
                    </select>
                </div>
                <span><br />-</span>
                <div class="d-flex flex-column" style="gap: 3px">
                    <label class="mp-input-group__label">Year </label>
                    <select name="date_appoint_years" id="date_appoint_years" class="radius-1 outline select-field" style="font-size: normal;">
                        <!-- options for years from 12 years ago until 70 years before the current year -->
                        <!-- options for years from current year down to 70 years ago -->
                        <option value="">Year</option>
                        @for ($i = date('Y'); $i >= date('Y') - 70; $i--)
                        <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <label id="err-msg" class="mp-input-group__label red-clr d-none"></label>
        </div>
        <div class="mp-input-group" data-set="appointment">
            <label class="mp-input-group__label">Appointment Status </label>
            <div class="dflex">
                <span class="appointment">
                </span>
            </div>
            <!-- <select class="js-example-responsive mp-input-group__input mp-text-field" style="width:100%;" required>
                <option value="">Select Status</option>
                <option value="OTHER">Other Status Please Specify</option>
            </select> -->
            <label id="err-msg" class="mp-input-group__label red-clr d-none"></label>
        </div>
        <div class="mp-input-group d-none opacity-0" id="other_status">
            <label class=" mp-input-group__label">Other Status (Please Specify) </label>
            <input class="mp-input-group__input mp-text-field" type="text" />
        </div>
        <div class="mp-input-group" data-set="monthly_salary">

            <label class="mp-input-group__label">Monthly Salary (Please refer to the basic salary on your pay slip)</label>
            <input class="mp-input-group__input mp-text-field" type="text" name="monthly_salary" id="monthly_salary" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required />
            <label id="err-msg" class="mp-input-group__label red-clr d-none"></label>
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Salary Grade </label>
            <input class="mp-input-group__input mp-text-field" type="text" name="salary_grade" id="salary_grade" readonly />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Salary Grade Category </label>
            <input class="mp-input-group__input mp-text-field" type="text" name="sg_category" id="sg_category" readonly />
            {{-- <select class="js-example-responsive mp-input-group__input mp-text-field" style="width:100%;" name="sg_category">
                    <option>Select Category</option>
                    <option>Yayamanin</option>
                </select> --}}
        </div>
        <div class="mp-input-group" data-set="tin_no">
            <label class="mp-input-group__label">Taxpayer Identification Number (TIN) </label>
            <input class="mp-input-group__input mp-text-field" type="number" name="tin_no" required />
            <label id="err-msg" class="mp-input-group__label red-clr d-none"></label>
        </div>
        <a class="up-button btn-md mp-text-center magenta-bg" style="width: 100%" id="save_as_draft_1">
            <span>Save as draft</span>
        </a>
        <a class="up-button btn-md button-animate-right mp-text-center" type="submit" value="step-3" id="next-btn">
            <span>Next</span>
        </a>
    </div>
</form>

<form id="member_forms_3" method="post" enctype="multipart/form-data">
    <input type="hidden" name="app_no" id="app_no">
    <input type="hidden" name="percent_amt" id="percent_amt">
    <div class="mp-pt3 d-none gap-10 flex-column mp-pb5 member-form shadow-inset-1 mp-pv2 fill-block" id="step-3">
        <div class="mp-input-group">
            <label for="" class="mp-text-fs-medium mp-split-pane__title mp-text-c-primary">
                MONTHLY CONTRIBUTION
            </label>
            <label class="mp-input-group__label">
                The amount that you decide here will serve as your monthly contribution to your UP Provident
                Fund account, and will be deducted from your salary every month. Choose between:<br><br>
                (a) Percentage of Basic Salary, minimum of 1%; or <br>
                (b) A Fixed amount, must also be a minimum of 1% of your basic salary <br><br>
                You may change this anytime by filling out the Member's Data Updating Form at any of our offices.
                <br><br>
                Amount is subject to the DBM rule on net take-home pay threshold.
                (Your net pay must not fall below P5,000 after all deductions)
            </label><br><br>
            <label class="mp-input-group__label">
                Your Monthly Salary is:
            </label>
            <label class="mp-input-group__label" id="month_sal_text">
            </label>
        </div>
        <div class="mp-input-group" data-set="percentage_check">
            <div class="d-flex gap-5">
                <input type="checkbox" class="options" id="percentage_check" name="percentage_check" value="percentage" />
                <label class="mp-input-group__label" style="margin-top: 5px;">Percentage of Basic Salary ( Between 1%
                    - 100%) </label>
            </div>
            <input class="mp-input-group__input mp-text-field" type="text" name="percentage_bsalary" id="percentage_bsalary" />
            <label class="mp-input-group__label" style="margin-top: 5px;">Equivalent:</label> <label class="mp-input-group__label" id="computed_amount" style="margin-top: 5px;"></label>
            <br />
            <label id="err-msg" class="mp-input-group__label red-clr d-none"></label>
        </div>
        <div class="mp-input-group" data-set="fixed_amount_check">
            <div class="d-flex gap-5">
                <input type="checkbox" class="options" id="fixed_amount_check" name="fixed_amount_check" />
                <label class="mp-input-group__label" style="margin-top: 5px;">Fixed Amount ( In Philippine Peso
                    )</label>
            </div>
            <input class="mp-input-group__input mp-text-field" type="text" name="fixed_amount" id="fixed_amount" />
            <label class="mp-input-group__label" style="margin-top: 5px;">Minimum Contribution:</label> <label class="mp-input-group__label" id="min_contri" style="margin-top: 5px;"></label>
            <br />
            <label id="err-msg" class="mp-input-group__label red-clr d-none"></label>
        </div>
        <div class="mp-input-group d-flex gap-5 flex-column">
            <label class="mp-input-group__label mp-mb2" style="font-style: italic">(The beneficiary/ies you indicate below shall receive your UP Provident Fund
                benefits (your retirement savings and earnings thereon) in the event of your
                death. If left blank, your benefits shall be divided among your heirs in
                accordance with the New Family Code.)
            </label>
            <label class="mp-input-group__label mp-mb2" style="font-style: italic">Please enter your beneficiary/ies’ full name, date of birth, and relationship to
                you. You may add as many beneficiaries as you like
            </label>
            <label for="" class="mp-text-fs-medium mp-split-pane__title mp-text-c-primary">
                BENEFICIARY/IES
            </label>
            <br>
            <label class="mp-input-group__label">
                The beneficiary/ies you indicate below shall receive your AXA insurance benefits in the event of your death. Please fill
                out all the fields for each beneficiary listed below:
            </label>
            <input class="mp-input-group__input mp-text-field" type="text" id="dependent_name" name="dependent_name" placeholder="Name" data-set="validate_dependent_3" />
            <label id="err-msg" class="mp-input-group__label red-clr d-none" name="dependent_name"></label>
            <div class="mp-input-group">
                <label class="mp-input-group__label mp-mb1">Birthday </label>
                <div class="d-flex flex-row gap-10 mb-pb1 mp-text-field" name="birthday_3">
                    <div class="d-flex flex-column" style="gap: 3px">
                        <label class="mp-input-group__label">Month </label>
                        <select name="date_birth_dependent_month" id="date_birth_dependent_month" class="radius-1 outline select-field" style="font-size: normal;" data-set="validate_dependent_3">
                            <option value="">Month</option>
                            <option value="01">January</option>
                            <option value="02">February</option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>
                    <span><br />-</span>
                    <div class="d-flex flex-column" style="gap: 3px">
                        <label class="mp-input-group__label">Day </label>
                        <select name="date_birth_dependent_days" id="date_birth_dependent_days" class="radius-1 outline select-field" style="font-size: normal;" data-set="validate_dependent_3">
                            <option value="">Day</option>
                            @for($day = 1; $day <= 31; $day++) <option value="{{ sprintf('%02d', $day) }}">{{ sprintf('%02d', $day) }}</option>
                                @endfor
                        </select>
                    </div>
                    <span><br />-</span>
                    <div class="d-flex flex-column" style="gap: 3px">
                        <label class="mp-input-group__label">Year </label>
                        <select name="date_birth_dependent_years" id="date_birth_dependent_years" class="radius-1 outline select-field" style="font-size: normal;" data-set="validate_dependent_3">
                            <!-- option for current year -->
                            <!-- options for years from current year down to 70 years ago -->
                            <option value="">Year</option>
                            @for ($i = date('Y'); $i >= date('Y') - 70; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>

                    </div>
                </div>
            </div>
            <label id="err-msg" class="mp-input-group__label red-clr d-none" name="birthday_3"></label>
            <input class="mp-input-group__input mp-text-field" type="text" id="dependent_relation" name="dependent_relation" placeholder="Relationship" data-set="validate_dependent_3" />
            <label id="err-msg" class="mp-input-group__label red-clr d-none" name="dependent_relation"></label>
            <a class="up-button mw-200 btn-md self-end mp-mt2 button-animate-right">
                <span id="add_dependent">Add Beneficiary</span> </a>
        </div>
        <div class="dflex flex-row" style="overflow-y: auto;">
            <table class=" mp-mh2" id="dependentTable" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th style="width: 30%"><span class="mp-text-no-wrap">Full Name</span></th>
                        <th style="width: 20%"><span class="mp-text-no-wrap">Date of Birth</span></th>
                        <th style="width: 20%"><span class="mp-text-no-wrap">Relationship</span></th>
                        <th style="width: 20%"></th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>




        <!-- <div class="mp-input-group">
            <div class="mp-input-group mp-mt5">
                <input type="checkbox" class="checkbox-color margin-10" id="terms" name="terms">
                By signing up, you agree to University of the Philippines
                Provident Fund Inc.'s
                <a class="link_style" href="https://www.privacy.gov.ph/data-privacy-act/">Terms of Service</a> &
                <a class="link_style" href="https://www.privacy.gov.ph/data-privacy-act/">Privacy Policy</a>
                </label>
            </div>
            {{-- <button type="submit" class="d-none mp-text-center" id="btn-submit">Submit</button> --}}
            <hr>
        </div> -->
        <a class="up-button btn-md mp-text-center magenta-bg" style="width: 100%" id="save_as_draft_2">
            <span>Save as draft</span>
        </a>
        <a class="up-button btn-md button-animate-right mp-text-center" type="button" value="step-4" id="next-btn">
            <span>Next</span>
        </a>
    </div>
</form>
<!--   -->
<div class="mp-pt3 gap-10  d-none flex-column mp-pb5 member-form shadow-inset-1 mp-pv2 fill-block" id="step-4">

    <div class="mp-input-group">
        <label class="mp-input-group__label">Supporting Document </label>

    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <form id="generateNewAxa" method="post" enctype="multipart/form-data">
        <div class="mp-input-group">

            <div class="mp-input-group">

                <hr>

                <label for="" class="mp-text-fs-medium mp-split-pane__title mp-text-c-primary">
                    INSURANCE FORM
                </label>
                <ul>
                    <li style="font-size: 13px; text-align: justify;">
                        Becoming a member of the UP Provident Fund automatically entitles you to life insurance coverage of P100,000 from

                        our accredited insurance provider, AXA Philippines. In the event of your death, your beneficiaries will receive a lump

                        sum of P100,000. You are also entitled to other benefits in addition to life insurance

                        (visit <a href="https://www.upprovidentfund.com/insurance-benefit/ ">https://www.upprovidentfund.com/insurance-benefit/</a>
                        to see full list of insurance benefits).
                        <br><br>
                        Kindly fill out the fields below to enroll in AXA’s group life insurance
                    </li>
                    <input type="hidden" name="test_no" id="test_no">
                    <div class="mp-input-group">
                        <label class="mp-input-group__label">Place of Birth</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="place_birth" id="place_birth" data-set="step-4-validation" />
                        <label id="err-msg" class="mp-input-group__label red-clr d-none" name="place_birth"></label>
                    </div>
                    <div class="mp-input-group">
                        <label class="mp-input-group__label">Employer/Union/Association</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="emp_union_assoc" id="emp_union_assoc" data-set="step-4-validation" />
                        <label id="err-msg" class="mp-input-group__label red-clr d-none" name="emp_union_assoc"></label>
                    </div>
                    <div class="mp-input-group">
                        <label class="mp-input-group__label">Occupation</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="occupation" id="occupation" data-set="step-4-validation" />
                        <label id="err-msg" class="mp-input-group__label red-clr d-none" name="occupation">
                    </div>
                    <div class="mp-input-group">
                        <label class="mp-input-group__label">SSS/GSIS No.</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="gsis_no" id="gsis_no" data-set="step-4-validation" />
                        <label id="err-msg" class="mp-input-group__label red-clr d-none" name="spouse_name">
                    </div>
                    <div class="mp-input-group">
                        <label class="mp-input-group__label">Name of Spouse</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="spouse_name" id="spouse_name" data-set="step-4-validation" />
                    </div>
                    <div class="mp-input-group">
                        <label class="mp-input-group__label">Mother's Maiden Name</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="maiden_name" id="maiden_name" data-set="step-4-validation" />
                        <label id="err-msg" class="mp-input-group__label red-clr d-none" name="maiden_name">
                    </div>
                    <div class="mp-input-group">
                        <label class="mp-input-group__label mp-mt2 d-none opacity-0">Insured Type</label>
                        <!-- <input class="mp-input-group__input mp-text-field" type="text" name="occupation" id="occupation" /> -->
                        <select name="insured_type" id="insured_type" class="radius-1 outline select-field mp-mt2 d-none opacity-0" style="font-size: normal;" data-set="step-4-validation">
                            <option value="INSURED" selected>INSURED</option>
                            <option value="DEPENDENT">DEPENDENT</option>
                        </select>
                        <label id="err-msg" class="mp-input-group__label red-clr d-none" name="insured_type">
                    </div>
                    <div class="mp-input-group"><br>
                        <label for="" class="mp-text-fs-medium mp-split-pane__title mp-text-c-primary">
                            PERSON TO BE CONTACED IN CASE OF EMERGENCY
                        </label>
                        <!-- <label class="mp-input-group__label"><b></b></label> -->
                        <br>
                        <label class="mp-input-group__label">Last Name</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="last_name" id="last_name" data-set="step-4-validation" />
                        <label id="err-msg" class="mp-input-group__label red-clr d-none" name="last_name">
                    </div>
                    <div class="mp-input-group">
                        <label class="mp-input-group__label">First Name</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="first_name" id="first_name" data-set="step-4-validation" />
                        <label id="err-msg" class="mp-input-group__label red-clr d-none" name="first_name">
                    </div>
                    <div class="mp-input-group">
                        <label class="mp-input-group__label">Middle Name</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="middle_name" id="middle_name" data-set="step-4-validation" />
                        <label id="err-msg" class="mp-input-group__label red-clr d-none" name="middle_name">
                    </div>
                    <div class="mp-input-group">
                        <label class="mp-input-group__label">Relationship to the member</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="relationship_tomember_axa" id="relationship_tomember_axa" data-set="step-4-validation" />
                        <label id="err-msg" class="mp-input-group__label red-clr d-none" name="relationship_tomember_axa">
                    </div>
                    <div class="mp-input-group">
                        <label class="mp-input-group__label">Contact No.</label>
                        <input class="mp-input-group__input mp-text-field axa_contact_no" type="text" name="axa_contact_no" id="axa_contact_no" data-set="step-4-validation" />
                        <label id="err-msg" class="mp-input-group__label red-clr d-none" name="axa_contact_no">
                    </div>
                    <div class="mp-input-group">
                        <label class="mp-input-group__label">Email Address</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="email_add" id="email_add" data-set="step-4-validation" />
                        <label id="err-msg" class="mp-input-group__label red-clr d-none" name="email_add">
                    </div>

                    <div class="mp-input-group d-flex gap-5 flex-column">
                        <label class="mp-input-group__label mp-mb2" style="font-style: italic">(Those who will receive the fund benefits in case of the member's death; Please use add your dependents; If left blank, benefits shall be divided among heirs in accordance with the New Family Code.)</label>

                        <!-- <label class="mp-input-group__label" style="
                background-color: var(--c-active-hover-bg);
                color: white;
                padding: 10px;
                margin-left: -8px;
                font-size: 15px;
                margin-right: -8px;">
                            Dependents </label> -->
                        <label for="" class="mp-text-fs-medium mp-split-pane__title mp-text-c-primary">
                            DEPENDENTS
                        </label>

                        <input class="mp-input-group__input mp-text-field" type="text" id="dependent_last_name" name="dependent_last_name" placeholder="Last Name" data-set="validate_dependent" />
                        <label id="err-msg" class="mp-input-group__label red-clr d-none" name="dependent_last_name"></label>
                        <input class="mp-input-group__input mp-text-field" type="text" id="dependent_first_name" name="dependent_first_name" placeholder="First Name" data-set="validate_dependent" />
                        <label id="err-msg" class="mp-input-group__label red-clr d-none" name="dependent_first_name"></label>
                        <input class="mp-input-group__input mp-text-field" type="text" id="dependent_middle_name" name="dependent_middle_name" placeholder="Middle Initial" data-set="validate_dependent" />
                        <label id="err-msg" class="mp-input-group__label red-clr d-none" name="dependent_middle_name"></label>
                        <input class="mp-input-group__input mp-text-field" type="number" id="benefit_percent" min="1" max="100" required name="benefit_percent" placeholder="Benefit Percent" data-set="validate_dependent" />
                        <label id="err-msg" class="mp-input-group__label red-clr d-none" name="dependent_middle_name"></label>
                        <div class="mp-input-group">
                            <label class="mp-input-group__label mp-mb1">Date Of Birth </label>
                            <div class="d-flex flex-row gap-10 mb-pb1 mp-text-field" name="birth_day">
                                <div class="d-flex flex-column" style="gap: 3px">
                                    <label class="mp-input-group__label">Month </label>
                                    <select name="birth_month" id="birth_month" class="radius-1 outline select-field" style="font-size: normal;" data-set="validate_dependent">
                                        <option value="">Month</option>
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                                <span><br />-</span>
                                <div class="d-flex flex-column" style="gap: 3px">
                                    <label class="mp-input-group__label">Day </label>
                                    <select name="birth_date" id="birth_date" class="radius-1 outline select-field" style="font-size: normal;" data-set="validate_dependent">
                                        <option value="">Day</option>
                                        @for($day = 1; $day <= 31; $day++) <option value="{{ sprintf('%02d', $day) }}">{{ sprintf('%02d', $day) }}</option>
                                            @endfor
                                    </select>
                                </div>
                                <span><br />-</span>
                                <div class="d-flex flex-column" style="gap: 3px">
                                    <label class="mp-input-group__label">Year </label>
                                    <select name="birth_year" id="birth_year" class="radius-1 outline select-field" style="font-size: normal;" data-set="validate_dependent">
                                        <!-- option for current year -->
                                        <!-- options for years from current year down to 70 years ago -->
                                        <option value="">Year</option>
                                        @for ($i = date('Y'); $i >= date('Y') - 70; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>

                                </div>
                            </div>
                        </div>
                        <label id="err-msg" class="mp-input-group__label red-clr d-none" name="birth_day"></label>
                        <input class="mp-input-group__input mp-text-field" type="text" id="dependent_relationship" name="dependent_relationship" placeholder="Relationship" data-set="validate_dependent" />
                        <label id="err-msg" class="mp-input-group__label red-clr d-none" name="dependent_relationship"></label>

                        <div class="mp-input-group">
                            <label class="mp-input-group__label mp-mt2">Insured Type</label> <br>
                            <!-- <input class="mp-input-group__input mp-text-field" type="text" name="occupation" id="occupation" /> -->
                            <select name="dependent_insurance" id="dependent_insurance" class="radius-1 outline select-field mp-mt2" style="font-size: normal;" data-set="validate_dependent">
                                <option value="PRIMARY">PRIMARY</option>
                                <option value="SECONDARY">SECONDARY</option>
                            </select>
                        </div>
                        <label id="err-msg" class="mp-input-group__label red-clr d-none" name="dependent_insurance"></label>
                        <div class="mp-input-group">
                            <label class="mp-input-group__label mp-mt2">ACCORDING TO RIGHTS</label><br>
                            <!-- <input class="mp-input-group__input mp-text-field" type="text" name="occupation" id="occupation" /> -->
                            <select name="dependent_rights" id="dependent_rights" class="radius-1 outline select-field mp-mt2" style="font-size: normal;" data-set="validate_dependent">
                                <option value="REVOCABLE">REVOCABLE</option>
                                <option value="IRREVOCABLE">IRREVOCABLE</option>
                            </select>
                        </div>
                        <!-- <label id="err-msg" class="mp-input-group__label red-clr d-none" name="dependent_rights"></label>
                            <input class="mp-input-group__input mp-text-field" type="text" id="dependent_relation" placeholder="Relationship" /> -->
                        <a class="up-button mw-200 btn-md self-end mp-mt2 button-animate-right">
                            <span id="add_dependent_axa">Add Dependent</span> </a>
                    </div>
                    <br>
                    <table class="axa-table" style="height: auto; font-size: 13px;" width="100%">
                        <thead>
                            <tr>
                                <th>
                                    <span>Name</span>
                                </th>
                                <th>
                                    <span>Date Of Birth</span>
                                </th>
                                <th>
                                    <span>Relationship</span>
                                </th>
                                <th>
                                    <span>Benefit %</span>
                                </th>
                                <th>
                                    <span>Actions</span>
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            <!-- <tr>
                                    <td>Sample Name</td>
                                    <td>May 6, 1999</td>
                                    <td>Mother</td>
                                    <td>
                                        <button class="view_button_axa">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </button>
                                        <button class="edit_button_axa">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </button>
                                        <button class="delete_button_axa">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </td>
                                </tr> -->

                        </tbody>
                    </table>

                    <br>
                    <div class="mp-input-group" style=" font-size: 13px; text-align:justify;">
                        <label for="" class="mp-text-fs-medium mp-split-pane__title mp-text-c-primary">
                            AXA BENEFICIARY DESIGNATION GUIDELINES:
                        </label>

                        <li style=" font-size: 13px;">
                            <b>What’s the difference between the beneficiaries I indicated in the previous step and the beneficiaries in the current
                                step?</b><br><br>
                            In the event of your death, the beneficiaries you indicated in the previous step will receive your UP Provident Fund
                            retirement savings and earnings thereon, while the beneficiaries indicated in this step will receive your AXA insurance
                            benefits.
                            <br> <br>
                            <b>Can I choose the same or different beneficiaries for Steps 3 and 4?</b>
                            <br><br>
                            Yes. You may choose to designate the same beneficiaries, or you may choose to designate different beneficiaries. It is up
                            to you
                            <br><br>
                            <b>Who is a beneficiary as defined by the AXA beneficiary designation guidelines?</b>

                            <br> <br>
                            The beneficiary is the person designated by the insured to receive the death proceeds of the policy. An insurable interest
                            of the beneficiary must be clearly established. Insurable interest exists if the beneficiary will suffer economic loss upon
                            the death of the insured.
                            <br> <br>
                            Any person may be named beneficiary as long as he or she does not fall under any of those prohibited under Article 739
                            of the Civil Code (e.g., extramarital partner / mistress / paramour, etc.). Common law partner should not be designated
                            as beneficiary.
                            <br> <br>
                            In general the following are acceptable to be designated as beneficiaries:
                            <label>
                                <ol>
                                    <li>1. legal spouse</li>
                                    <li>2. children, natural or legally adopted</li>
                                    <li>3. parents</li>
                                    <li>4. siblings</li>
                                    <li>5. grandparents & grandchildren</li>
                                </ol>
                            </label>

                            <br> <br>

                            <label>
                                The customer may also opt to choose “Standard Beneficiary” wherein the persons designated to receive the death
                                proceeds shall follow the order of preference as shown below:
                                <ol>
                                    <li>1. spouse</li>
                                    <li>2. children</li>
                                    <li>3. parents</li>
                                    <li>4. siblings</li>
                                    <li>5. estate</li>
                                </ol>
                            </label>
                            <br> <br>
                            <b>Can I choose the same or different beneficiaries for Steps 3 and 4?</b>
                            <br> <br>
                            If no designated beneficiary is indicated in the application, Underwriting will assign Estate as a default beneficiary.
                            <br><br>

                            <b>What details must I supply for my listed beneficiary/ies?</b>
                            <br> <br>
                            A beneficiary designation should be in such a way that no one can mistake the intention of the policy owner as to who
                            should receive the insurance proceeds.
                            <br>
                            <label>
                                <ol>
                                    <li>1. The given name and surname and the relationship to the insured must be supplied</li>
                                    <li>2. For minor beneficiary, the date of birth may be indicated</li>
                                </ol>
                            </label>
                            <br><br>
                            <b>What is the difference between a primary and a secondary beneficiary?</b>
                            <br> <br>
                            This pertains to classification of beneficiary/ies according to priority:
                            <br><br>
                            <label>
                                <ol>
                                    <li>1. <b>Primary</b> – This beneficiary will have first priority in receiving the death proceeds of an insurance policy.</li>
                                    <li>2. <b>Secondary</b> – This beneficiary will only receive the death proceeds if the primary beneficiary pre-deceases the
                                        insured and no other primary beneficiary had been designated anew.</li>
                                </ol>
                            </label>

                            <br><br>
                            <b>Can I designate all my beneficiaries as primary?</b>
                            <br> <br>
                            Yes. You may designate all your beneficiaries as primary. The designation of secondary beneficiary/ies is not mandatory.
                            <br><br>
                            <b>What is the difference between a revocable and an irrevocable beneficiary?</b>
                            <br> <br>
                            This pertains to classification of beneficiary/ies according to rights:
                            <br><br>
                            <label>
                                <ol>
                                    <li>1. <b>Revocable</b> – At any time while the policy is in force, the beneficiary may be changed (mere <b>expectancy rights</b>)
                                        and the policy owner may exercise any and every right on the policy without this beneficiary’s written consent</li>
                                    <li>2. <b>Irrevocable</b> –This beneficiary has vested rights over the policy and, therefore, the policy owner cannot exercise
                                        his rights over the policy without the written consent of this beneficiary. After initial designation, members
                                        cannot add other beneficiaries or change a beneficiary designation, without the express consent of all the listed
                                        irrevocable beneficiary/ies.
                                        <br><br>
                                        Minor children (less than 18 years old) cannot give valid consent to any transaction. Hence, it is not
                                        recommended to designate children as irrevocable beneficiaries to avoid problems in future policy transactions.
                                    </li>
                                </ol>
                            </label>
                            <br><br>
                            Care and prudence must be exercised in thinking about who to designate as revocable/irrevocable beneficiary/ies.
                            <br><br>
                            Please refer to the following table for further guidance:
                            <br><br>
                            <div class="step4-image" style="text-align:center;">
                                <img src="{!! asset('assets/images/image1-step4.jpg') !!}" style=" width: 300px;" alt="UPPFI">
                            </div>
                            <br><br>
                            <b> How do I fill out the “benefit %” column?</b>
                            <br> <br>
                            For 2 or more persons as designated beneficiaries, the shares of the proceeds must be ideally specified for each
                            beneficiary usually expressed as fraction or percentage rather than the absolute amounts. In the absence of any
                            stipulation, benefits shall be shared equally by all of the named beneficiaries. You may also opt to give the full
                            percentage to one beneficiary only.
                            <br> <br>
                            <b> For any further questions, kindly contact any of our offices.</b>
                            <br> <br>

                        </li>
                    </div>
                    <li style=" font-size: 13px;text-align:justify;">
                        <b>I HEREBY DECLARE AND AGREE THAT:</b><br>
                        All information in the enrollment whether or not written by my hand are to the best of my knowledge and belief complete and true;
                        <br> <br>
                        Any of my personal information collected or held by AXA Philippines (whether contained in the application/s or otherwise), may be used in connection with
                        matching for whatever purpose with such other personal information and/or may be used, stored, disclosed, transferred (whether within or outside the
                        Philippines) to such persons as AXA Philippines may consider necessary including without limitation any of its afiliated companies, or any
                        individuals/organizations associated with AXA Philippines:
                        <br> <br>
                        (i) to process and deal with the enrollment
                        (ii) to provide all services related to the enrollment and promote and improve services by the Company and its affiliated companies
                        (iii) to communicate with me for any purpose and/or comply with the laws of any applicable jurisdiction
                        <br> <br>
                        If I fail to provide any information requested in the enrollment, it may result in AXA Philippines’ inability to process and to deal with the enrollment;
                        <br> <br>
                        I have the right to request access to and correct any of my personal information held by AXA Philippines. I understand that such request shall be made in writing and addressed to the head of the Account Services at AXA Philippines’ Home Office.
                        <br> <br>
                        I understand that AXA Philippines shall use my personal information to evaluate and assess my application and need for life insurance and investments, as well as to service any of my policies including the evaluation of any future claims. I also authorize AXA Philippines to disclose to afiliated entity(ies) or to persons or entities providing services on AXA Philippines’ behalf consistent with the purpose for which the information was obtained.
                        <br> <br>
                        I understand that company notices related to my policy may be sent to me through email or SMS in the address/number I provided above, otherwise,
                        sent to my residential address.

                        <br> <br>

                        <b> SIGNATURE</b>
                        <br> <br>
                        Please take a photo of your
                        <br> <br>
                        <ol>
                            <li>&#10004; handwritten signature</li>
                            <li>&#10004; printed name, and</li>
                            <li>&#10004; date today</li>
                        </ol>
                        <br>
                        and upload it below. Follow the format as follows:
                        <br> <br>
                        <div class="step4-image" style="text-align:center;">
                            <img src="{!! asset('assets/images/image2-step4.jpg') !!}" style=" width: 300px;" alt="UPPFI">
                        </div>
                        <br>
                    </li>
                </ul>
                <div class="mp-input-group">
                    <label class="mp-input-group__label">Upload Signature</label>
                    <input class="mp-input-group__input mp-text-field" type="file" name="e_sign_axa" id="e_sign_axa" accept="image/png, image/gif, image/jpeg, image/jpg" data-set="step-4-validation" />
                    <input type="hidden" name="person_id" id="person_id">
                </div>
                <!-- <button class="up-button btn-md button-animate-right mp-text-center" type="button" id="modal_name_pop">Generate AXA Insurance Form</button> -->
                <br>
                <!-- <div class="tooltip">
                    <i class="fa fa-question-circle-o circle-design" aria-hidden="true"></i>
                    <div class="right">

                        <div class="text-content">

                        </div>

                    </div>
                </div> -->
            </div>
        </div>

        <!-- <a class="up-button btn-md mp-text-center magenta-bg" style="width: 100%">
            <span>Save as draft</span>
        </a> -->
        <div class="mp-input-group">
            <a class="up-button btn-md mp-text-center magenta-bg" style=" display: block;margin-top: 10px;" id="save_as_draft_3">
                <span>Save as draft</span>
            </a>
            <br>
            <a class="up-button btn-md button-animate-right mp-text-center" style="display: block;  margin-top: -15px;" type="button" value="step-5" id="next-btn">
                <span>Next</span>
            </a>
        </div>

    </form>
    <!-- <button class="up-button btn-md button-animate-right mp-text-center" type="submit" id="next-btn">
            <span>Submit</span>
        </button> -->
</div>
</form>

<div class="mp-pt3 d-none gap-10 flex-column mp-pb5 member-form shadow-inset-1 mp-pv2 fill-block" id="step-5">
    <div id="proxy" style="margin-bottom: 20px; text-align: justify;">
        {{-- <input class="mp-input-group__input mp-mt1 mp-mb3" type="file" name="proxy_sign" id="file" accept="image/png, image/gif, image/jpeg, image/jpg" /> --}}
        <div class="mp-input-group" style="text-align:justify;">

            <ul>
                <li>
                    <div class="logo-img" style=" text-align: center; margin: 15px;">
                        <img src="{!! asset('assets/images/uppfi-logo-sm.png') !!}" alt="UPPFI" style=" width: 75px;height: 75px;">
                    </div>
                    The law allows UPPF Members to vote in person or by proxy. Much as physical voting is encouraged, there may be constraints in doing so. Good news is, through proxies, Members can ensure their participation and voting during the Annual General Membership Meeting, and protect their interest even though they may not be physically present.
                    <br> <br>
                    In addition, the system of proxy voting helps the Corporation achieve quorum during Members’ Meetings, and assists the Management secure the control of the Corporation.
                    <br> <br>
                    For purposes of efficiency, the Chairperson of UPPF Board of Trustees, or, in his absence, the Executive Director, shall represent the Member.
                    Know all men by these presents:
                    <br> <br>
                    <label for="" class="mp-text-fs-medium mp-split-pane__title mp-text-c-primary">
                        PROXY FORM
                    </label>
                    <br>

                    <b> Know all men by these presents:</b>
                    <br>
                    I hereby nominate, constitute, and appoint the Chairman of UP Provident Fund, Inc.
                    (UPPFI) to represent me and vote in my name on any matter at any and all regular and
                    special meetings of members of UPPFI and/or at any adjournments, continuation, or
                    postponements thereof.
                    <br> <br>
                    In case of non-attendance of the above-named proxy, I authorize and empower the Vice Chairman of UPPFI, or in his absence, the Executive Director to fully exercise all rights as my proxy at such meeting.
                    <br> <br>
                    Hereby giving and granting unto my proxy full power and authority whatsoever requisite
                    or necessary or proper to be done in or about the premises, as fully to all intents and
                    purposes as I might or could lawfully do if personally present, and hereby ratifying and
                    confirming all that my proxy shall do or cause to be done.
                    <br> <br>
                    This proxy revokes all proxies which I might have previously executed in favor of other
                    persons. Should I personally attend any of the meetings or have given my proxy to
                    another to represent me thereat, this proxy shall be deemed of no force and effect but
                    only for said meeting and shall again be effective and in full force after its adjournment.
                    <br> <br>
                    This proxy shall be effective for five (5) years from the date hereof, or until withdrawn by
                    me through notice in writing delivered to the Secretary of the Corporation

                    <br> <br>
                <li>
                    <b> Name Of Member: </b><label id="step5_name"></label>
                    <br>
                    <b> Campus: </b><label id="step5_campus"></label>
                    <br>
                    <b> Date: </b><label id="step5_date"></label>
                </li>
                <br>




                </li>

            </ul>
            <input type="hidden" name="appNo" id="appNo">
            <!-- <button class="up-button btn-md button-animate-right mp-text-center" id="save_sign" type="button">
                        <span>Generate Proxy Form</span>
                    </button> -->

            <!-- <div class="tooltip">
                        <i class="fa fa-question-circle-o circle-design" aria-hidden="true"></i>
                        <div class="right">

                            <div class="text-content">

                            </div>

                        </div>
                    </div> -->

        </div>
        <!-- <div class="tooltip">
                    <i class="fa fa-question-circle-o circle-design" aria-hidden="true"></i>
                    <div class="right">

                        <div class="text-content">
                            <h3>Electronic Signature</h3>
                            <ul>
                                <li>
                                    Electronic signatures have been expressly recognized as legally binding (Republic Act 8792).
                                    <br> <br>
                                    Electronic signature on the electronic document shall be equivalent to the signature of a person on a written document.
                                    <br> <br>
                                    By writing, typing your full name and the date, it is good as affixing your e-signature and agreeing to the above stipulations.
                                </li>
                            </ul>
                        </div>

                    </div>
                </div> -->




        <label for="" class="mp-text-fs-medium mp-split-pane__title mp-text-c-primary">
            ELECTRIC SIGNATURE
        </label>
        <!-- <h3>Electronic Signature</h3> -->
        <ul>
            <li>
                Electronic signatures have been expressly recognized as legally binding (Republic Act 8792).
                <br> <br>
                Electronic signature on the electronic document shall be equivalent to the signature of a person on a written document.
                <br> <br>
                By writing, typing your full name and the date, it is good as affixing your e-signature and agreeing to the above stipulations.
            </li>
        </ul>
        <br>

        <label class="mp-input-group__label" style="width: 100%;
                                                        background-color: var(--c-active-hover-bg);
                                                        color: white;
                                                        padding: 10px;
                                                        font-size: 15px;
                                                        margin-right: -2px;
                                                        margin-top: 20px;">
            Input your name as signature </label>

        <input class="mp-input-group__input mp-text-field" style="margin-top: 5px;" type="text" name="e_sig" id="e_sig" required />
        <br>
    </div>
    <button class="up-button btn-md button-animate-right mp-text-center" type="button" id="save_sign" style="width: 100%;">
        <span>Submit</span>
    </button>
</div>
</div>

@endsection

@section('reset-password-form')
<div class="mp-pb4  mp-mt5 mp-text-center">
    <img src="{!! asset('assets/images/uppfi-logo-sm.png') !!}" alt="UPPFI">
</div>
<div class="mp-pb4 mp-text-fs-large mp-text-center mp-split-pane__title mp-text-c-primary">
    Reset Your Password
</div>


<form id="resetPassword" method="post" action="{{ url('/register') }}">
    {{ csrf_field() }}
    <div class="mp-pt3 d-flex gap-10 flex-column mp-pb5" id="step-1">

        <label class="mp-text-fs-medium">
            Submit your email address and we'll send you a "Reset your Password" email. If you cannot find the email in
            your Inbox, wait a few minutes then refresh your Inbox or, alternatively, look for it in your Spam or Junk
            folder. If you do not remember your email address, please
            <a href="https://www.upprovidentfund.com/contact-us/" target="_blank">contact us</a> us so we can assist
            you in resetting your password.
        </label>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Email</label>
            <input class="mp-input-group__input mp-text-field" type="email" required />
        </div>
    </div>
    <div class="col col-auto">
        <button class="up-button btn-md button-animate-left  hover-back" id="fp_back" value="">
            <span>Back</span>
        </button>
        <div class="row" style="float:right;">
            <button class="up-button btn-md button-animate-right " type="submit" id="btn-submit">
                <span>Send Email</span>
            </button>
        </div>
    </div>


    </div>

</form>
@endsection


@section('right')
<div class="mp-bg {{ Request::route()->getName() == 'admin' ? 'mp-bg--admin' : 'mp-bg--member' }}" style="background-image:url({{ Request::route()->getName() == 'admin' ? 'assets/images/bg-admin.svg' : 'assets/images/bg-member.svg' }})">
    <div class="mp-mhauto mp-pv5">
        <div class="mp-hide-xs mp-hide-sm mp-text-fs-xxxlarge mp-text-fw-heavy mp-text-c-white mp-text-shadow">
            Welcome to UP Provident Fund
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('/dist/dashboard.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.js-example-responsive').select2();

    });
</script>
@endsection