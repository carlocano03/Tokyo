@extends('layouts/splitPane')

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
<script>
    // $(document).ready(function(e) {
    //     $("[data-set=email]>#err-msg").removeClass('d-none')
    //     $("[data-set=email]>#err-msg").removeClass('d-none').text("Invalid Member's ID number")
    //     $("[data-set=email]>.input").addClass('input-error')
    // })
</script>
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
                    <span>Not yet a member? </span><span class="mp-link link_style" id="register-link">Sign up</span>
                </label>
                <label class="mp-text-fs-small">
                    <span>Want to continue your application or check your application status? </span><span class="mp-link link_style" id="status_trail">Click here</span>
                </label>
                <br>
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
<div class="mp-pb4  mp-text-center mp-mt5">
    <img src="{!! asset('assets/images/uppfi-logo-sm.png') !!}" alt="UPPFI">
</div>
<div class="mp-pb4 mp-text-fs-large mp-text-center mp-split-pane__title mp-text-c-primary">
    Continue your application / Check your application status
</div>

<!-- <label class="mp-text-fs-medium">
        Abutin ang pangarap kasama ang
        <a href="https://www.upprovidentfund.com/" target="_blank">
            UP PROVIDENT FUND INC.
        </a>
    </label> --}}

<div class="mp-input-group mp-mt3 mp-text-center qr">
    <label class="mp-input-group__label">Scan QR</label>
    <br>
    <img src="{!! asset('assets/icons/qr-icon.svg') !!}" alt="UPPFI">
</div> -->

<div class="mp-input-group mp-mt2" id="input-app" data-set="input-app">
    <label class="mp-input-group__label">Enter your application number.<br> Make sure to use the format xxxx-xxxx <br>ex. 2023-0024</label>
    <br><br><br><input class="mp-input-group__input mp-text-field" type="text" id="app_no_trail" placeholder="Enter your Application Number XXXX-XXXX" required />
    <label id="err-msg" class="mp-input-group__label red-clr d-none"></label>
    <label class="mp-input-group__label">(Your application number was emailed to your emailed provided at signup.)</label>

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

    <div class="d-flex flex-column">
        <div class="ft-card border-bottom-0 mp-pv2 mp-ph2 fs-large">
            Online Membership Application Status
        </div>
        <div class="card-body d-flex flex-column card border-top-0 gap-5">
            <div class="d-flex flex-row gap-10">
                <span>Status : </span>
                <span class="font-bold" id="application_status"></span>
            </div>
            <div class="d-flex flex-row gap-10">
                <span>Remarks : </span>
                <span class="font-bold" id="validator_status"></span>
            </div>
            <div class="d-flex flex-row gap-10">
                <span>Application No. : </span>
                <span class="font-bold" id="appNo_label"></span>
            </div>
            <div class="d-flex flex-row gap-10">
                <span>First Name : </span>
                <span class="font-bold" id="fname_label"></span>
            </div>
            <div class="d-flex flex-row gap-10">
                <span>Middle Name : </span>
                <span class="font-bold" id="mname_label"></span>
            </div>
            <div class="d-flex flex-row gap-10">
                <span>Last Name : </span>
                <span class="font-bold" id="lname_label"></span>
            </div>
            <div class="d-flex flex-row gap-10">
                <span>Suffix : </span>
                <span class="font-bold" id="suffix_label"></span>
            </div>
            <div class="d-flex flex-row gap-10">
                <span>Birth date : </span>
                <span class="font-bold" id="bdate_label"></span>
            </div>
            <div class="d-flex flex-row gap-10">
                <span>Appointment : </span>
                <span class="font-bold" id="appointment_label"></span>
            </div>
            <div class="d-flex flex-row gap-10">
                <span>Tin No : </span>
                <span class="font-bold" id="tin_no_label"></span>
            </div>
            <div class="d-flex flex-row gap-10">
                <span>Contact No. : </span>
                <span class="font-bold" id="contact_no_label"></span>
            </div>
            <div class="d-flex flex-row gap-10">
                <span>Land line no. : </span>
                <span class="font-bold" id="landlineno_label"></span>
            </div>
            <div class="d-flex flex-row gap-10">
                <span>Email Address : </span>
                <span class="font-bold" id="email_add_label"></span>
            </div>
        </div>
    </div>


    <div class="mp-mt5 d-flex flex-row justify-content-end mp-mb5">
        <button style="width:100%" class="up-button-green btn-md mp-mt3 mp-mb3 mp-mb5" id="print_app">Print</button>
        <button style="width:100%" class="up-button btn-md mp-mt3 mp-mb3 magenta-bg mp-mb5" id="cont_app">Continue the
            application</button>
    </div>



</div>



@endsection

@section('registration-personal-form')
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
    <div class="mp-mt2 mp-mt2 ">

        <a class="up-button btn-md button-animate-left hover-back" id="back" value="">
            <span>Back</span>
        </a>
        <!-- <a class="up-color" id="back" value="">
                                   <span > <i class="fa fa-chevron-left" aria-hidden="true"></i> Back</span>
                        </a>  -->
    </div>
    <div class="mp-mt2 up-color reg-title mp-text-center">
        Online Membership Application
    </div>
    <div class="relative mp-mt2 w-90 d-flex ml-auto mr-auto">
        <ul class="d-flex flex-row items-between w-100 stepper">
            <li class="circle active" id="stepper-1">1</li>
            <li class="circle" id="stepper-2">2</li>
            <li class="circle" id="stepper-3">3</li>
            <li class="circle" id="stepper-4">4</li>
        </ul>
        <div class="line step-1" id="line"></div>
    </div>
    <div class="applicationNo">
        <label>Application No </label><br>
        <span id="application_no"></span>
    </div>

    <label class="mp-text-fs-medium mp-ph2 mp-split-pane__title mp-text-c-primary mb-0 mp-pv2 br-top-2 mp-mt2" id="registration-title">Personal Information</label>
</div>
<form id="member_forms" class="mh-reg-form form-border-bottom">
    {{ csrf_field() }}
    <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3 member-form mp-pv2 shadow-inset-1" id="step-1">
        <input type="hidden" id="app_trailNo">
        <!-- <label class="mp-text-fs-medium">Personal Information</label> -->
        <div class="mp-input-group">
            <label class="mp-input-group__label">Last Name</label>
            <input class="mp-input-group__input mp-text-field" type="text" name="lastname" required />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">First Name</label>
            <input class="mp-input-group__input mp-text-field" type="text" name="firstname" required />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Middle Name (Please input your complete middle name.)</label><br>
            <input type="checkbox" class="options" id="no_middlename" name="no_middlename" value="N/A" onClick="ckChange(this)" />
            <label class="mp-input-group__label" style="margin-top: 5px;">No Middle Name</label>
            <input class="mp-input-group__input mp-text-field" type="text" name="middlename" required />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Suffix</label>
            <input class="mp-input-group__input mp-text-field" type="text" name="suffix" />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Date of Birth</label>
            <input class="mp-input-group__input mp-text-field" type="text" name="date_birth" id="date_birth" readonly required />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Gender</label>
            <select class="mp-input-group__input mp-text-field" name="gender" required>
                <option>Select Gender</option>
                <option>Male</option>
                <option>Female</option>
            </select>
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Civil Status</label>
            <select class="mp-input-group__input mp-text-field" name="civilstatus" required>
                <option>Single</option>
                <option>Married</option>
                <option>Widowed</option>
                <option>Divorced</option>
                <option>Registered Partnership</option>
            </select>
        </div>
        <div class="mp-input-group ">
            <label class="mp-input-group__label">Citizenship</label>
            <div class="d-flex gap-5 mp-mb2">
                <input type="radio" value="FILIPINO" id="citizenship" name="citizenship" />
                <label class="mp-input-group__label" for="citizenship_d" style="margin-top: 5px;">Filipino</label>
                <input type="radio" value="DUAL CITIZENSHIP" id="citizenship" name="citizenship" />
                <label class="mp-input-group__label" for="citizenship_d" style="margin-top: 5px;">Dual
                    Citizenship</label>
                <input type="radio" value="OTHERS" id="citizenship" name="citizenship" />
                <label class="mp-input-group__label" for="citizenship_o" style="margin-top: 5px;">Others</label>
            </div>
            <label class="mp-input-group__label">Dual Citizenship / Other Citizenship</label>
            <input class="mp-input-group__input mp-text-field" type="text" name="dual_citizenship" id="d_citizen" disabled />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Present Address</label><br>
            <label class="mp-input-group__label">Province</label>
            <select class="js-example-responsive mp-input-group__input mp-text-field" style="width:100%;" id="present_province" name="present_province" required>
                <option value="">Select Province</option>
                {{-- @foreach ($psgc_prov as $row)
                    <option value="{{ $row->code }}">{{ mb_strtoupper($row->name) }}</option>
                @endforeach --}}
            </select>
            <input type="hidden" id="present_province_name" name="present_province_name">
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Municipality</label>
            <select class="js-example-responsive mp-input-group__input mp-text-field" style="width:100%;" id="present_city" name="present_municipality" required>
                <option value=""></option>
            </select>
            <input type="hidden" id="present_municipality_name" name="present_municipality_name">
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Barangay</label>
            <select class="js-example-responsive mp-input-group__input mp-text-field" style="width:100%;" id="present_barangay" name="present_barangay" required>
                <option></option>
            </select>
            <input type="hidden" id="present_barangay_name" name="present_barangay_name">
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Bldg No. St. No.</label>
            <input class="mp-input-group__input mp-text-field" type="text" id="present_bldg_street" name="present_bldg_street" />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Zipcode</label>
            <input class="mp-input-group__input mp-text-field" type="text" id="present_zipcode" name="present_zipcode" maxlength="5" onkeypress='return event.charCode >= 48 && event.charCode <= 57' />
        </div>

        <div class="mp-input-group">
            <label class="mp-input-group__label">Permanent Address</label>
            <div class="d-flex gap-5">
                <input type="checkbox" value="1" id="perm_add_check" name="perm_add_check" />
                <label class="mp-input-group__label" style="margin-top: 5px;">(Same as above)</label>

            </div>
            <input class="mp-input-group__input mp-text-field" type="text" name="same_add" id="same_add" readonly />
        </div>
        <div class="mp-input-group same_div">
            <label class="mp-input-group__label">Province</label>
            <select class="js-example-responsive mp-input-group__input mp-text-field" style="width:100%;" id="province" name="province" required>
                <option></option>
            </select>
            <input type="hidden" id="province_name" name="province_name">
        </div>
        <div class="mp-input-group same_div">
            <label class="mp-input-group__label">Municipality</label>
            <select class="js-example-responsive mp-input-group__input mp-text-field" style="width:100%;" id="city" name="municipality" required>
                <option></option>
            </select>
            <input type="hidden" id="municipality_name" name="municipality_name">
        </div>
        <div class="mp-input-group same_div">
            <label class="mp-input-group__label">Barangay</label>
            <select class="js-example-responsive mp-input-group__input mp-text-field" style="width:100%;" id="barangay" name="barangay" required>
                <option></option>
            </select>
            <input type="hidden" id="barangay_name" name="barangay_name">
        </div>
        <div class="mp-input-group same_div">
            <label class="mp-input-group__label">Bldg No. St. No.</label>
            <input class="mp-input-group__input mp-text-field" type="text" id="bldg_street" name="bldg_street" />
        </div>
        <div class="mp-input-group same_div">
            <label class="mp-input-group__label">Zipcode</label>
            <input class="mp-input-group__input mp-text-field" type="text" id="zipcode" name="zipcode" maxlength="5" onkeypress='return event.charCode >= 48 && event.charCode <= 57' />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Cellphone Number</label>
            <input class="mp-input-group__input mp-text-field" type="text" name="contact_no" maxlength="11" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Landline Number</label>
            <input class="mp-input-group__input mp-text-field" type="text" name="landline_no" />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Email Address</label>
            <input class="mp-input-group__input mp-text-field" type="email" name="email" required />
        </div>
        <div class="mp-input-group">
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
        </div>
        <a class="up-button btn-md button-animate-right mp-text-center" type="submit" value="step-2" id="next-btn">
            <span>Next</span>
        </a>
        <!-- <button type="submit" class="sss" id="btn-submit">Submit</button> -->

    </div>

</form>
<form id="member_forms_con">
    <!-- <label class="mp-text-fs-medium">Employment Details</label> -->
    <input type="hidden" id="employee_details_ID">
    <div class="mp-pt3 d-none gap-10 flex-column mp-pb5 member-form mp-pv2 shadow-inset-1" id="step-2">
        <div class="mp-input-group">
            <label class="mp-input-group__label">Campus</label>
            <select class="js-example-responsive mp-input-group__input mp-text-field" style="width:100%;" name="campus" id="campus" required>
                <option value="">Select Campus</option>
                {{-- @foreach ($campuses as $row)
                    <option value="{{ $row->campus_key }}">{{ $row->name }}</option>
                @endforeach --}}
            </select>
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Employee Classification</label>
            <select class="js-example-responsive mp-input-group__input mp-text-field" style="width:100%;" name="classification" id="classification">
                <option value="">Select Classification</option>
                {{-- <option>Class A </option> --}}
            </select>
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Other Classification (Please Specify)</label>
            <input class="mp-input-group__input mp-text-field" type="text" name="classification_others" />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Employee Number</label>
            <input class="mp-input-group__input mp-text-field" type="text" name="employee_no" required />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">College Unit</label>
            <select class="js-example-responsive mp-input-group__input mp-text-field" style="width:100%;" name="college_unit" id="college_unit">
                <option value="">Select Unit</option>
                {{-- <option>Unit </option> --}}
            </select>
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Department</label>
            <select class="js-example-responsive mp-input-group__input mp-text-field" style="width:100%;" name="department" id="department" required>
                <option value="">Select Department</option>
                {{-- <option>DEPED </option> --}}
            </select>
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Academic Rank/ Position</label>
            <input class="mp-input-group__input mp-text-field" type="text" name="rank_position" id="rank_position" />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Date of Appointment</label>
            <input class="mp-input-group__input mp-text-field" type="text" name="date_appointment" id="date_appointment" />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Appointment Status</label>
            <select class="js-example-responsive mp-input-group__input mp-text-field" style="width:100%;" name="appointment" id="appointment" required>
                <option value="">Select Status</option>
                {{-- <option>Regular Employee</option> --}}
            </select>
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Other Status (Please Specify)</label>
            <input class="mp-input-group__input mp-text-field" type="text" />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Monthly Salary</label>
            <input class="mp-input-group__input mp-text-field" type="text" name="monthly_salary" id="monthly_salary" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Salary Grade</label>
            <input class="mp-input-group__input mp-text-field" type="text" name="salary_grade" id="salary_grade" readonly />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Salary Grade Category</label>
            <input class="mp-input-group__input mp-text-field" type="text" name="sg_category" id="sg_category" readonly />
            {{-- <select class="js-example-responsive mp-input-group__input mp-text-field" style="width:100%;" name="sg_category">
                    <option>Select Category</option>
                    <option>Yayamanin</option>
                </select> --}}
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Taxpayer Identification Number (TIN)</label>
            <input class="mp-input-group__input mp-text-field" type="text" name="tin_no" required />
        </div>
        <a class="up-button btn-md button-animate-right mp-text-center" type="submit" value="step-3" id="next-btn">
            <span>Next</span>
        </a>
    </div>
</form>

<form id="member_forms_3" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mp-pt3 d-none gap-10 flex-column mp-pb5 member-form shadow-inset-1 mp-pv2 fill-block" id="step-3">
        <div class="mp-input-group">
            <label for="" class="mp-text-fs-medium mp-split-pane__title mp-text-c-primary">
                MONTHLY CONTRIBUTION
            </label>
            <label class="mp-input-group__label">
                (The amount that you decide here will serve as your monthly contribution to your UP Provident
                Fund account, and will be deducted from your salary every month. Choose between:<br><br>
                (a) Percentage of Basic Salary, minimum of 1%; or <br>
                (b) A Fixed amount <br><br>
                You may change this anytime by filling out the Member's Data Updating Form at any of our offices.
                <br><br>
                Amount is subject to the DBM rule on net take-home pay threshold.
                (Your net pay must not fall below P5,000 after all deductions).)
            </label>
        </div>
        <div class="mp-input-group">
            <div class="d-flex gap-5">
                <input type="checkbox" class="options" id="percentage_check" name="percentage_check" value="percentage" />
                <label class="mp-input-group__label" style="margin-top: 5px;">Percentage of Basic Salary ( Between 1%
                    - 100%)</label>
            </div>
            <input class="mp-input-group__input mp-text-field" type="text" name="percentage_bsalary" id="percentage_bsalary" />
            <label class="mp-input-group__label" style="margin-top: 5px;">Equivalent:</label> <label class="mp-input-group__label" id="computed_amount" style="margin-top: 5px;"></label>
        </div>
        <div class="mp-input-group">
            <div class="d-flex gap-5">
                <input type="checkbox" class="options" id="fixed_amount_check" name="fixed_amount_check" />
                <label class="mp-input-group__label" style="margin-top: 5px;">Fixed Amount ( In Philippine Peso
                    )</label>
            </div>
            <input class="mp-input-group__input mp-text-field" type="text" name="fixed_amount" id="fixed_amount" />
            <label class="mp-input-group__label" style="margin-top: 5px;">Minimum Contribution:</label> <label class="mp-input-group__label" id="min_contri" style="margin-top: 5px;"></label>
        </div>
        <div class="mp-input-group d-flex gap-5 flex-column">
            <label class="mp-input-group__label">Dependents</label>
            <input class="mp-input-group__input mp-text-field" type="text" id="dependent_name" placeholder="Name" />
            <input class="mp-input-group__input mp-text-field" type="text" id="dependent_bday" onfocus="(this.type='date')" placeholder="Birthday" />
            <input class="mp-input-group__input mp-text-field" type="text" id="dependent_relation" placeholder="Relationship" />
            <a class="up-button mw-200 btn-md self-end mp-mt2 button-animate-right">
                <span id="add_dependent">Add Dependent</span> </a>
        </div>
        <table class=" mp-mh2" id="dependentTable" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Birthday</th>
                    <th>Relationship</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>



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

        <a class="up-button btn-md button-animate-right mp-text-center" type="button" value="step-4" id="next-btn">
            <span>Next</span>
        </a>
    </div>

    <div class="mp-pt3 d-none gap-10 flex-column mp-pb5 member-form shadow-inset-1 mp-pv2 fill-block" id="step-4">

        <div class="mp-input-group">
            <label class="mp-input-group__label">Supporting Document</label>
        </div>

        <div class="mp-input-group">
            <label class="mp-input-group__label">Input your name as signature</label>
            <input class="mp-input-group__input mp-text-field" type="text" name="e_sig" id="e_sig" required />
        </div>
        <input type="hidden" name="app_no" id="app_no">
        <input type="hidden" name="percent_amt" id="percent_amt">
        <div class="mp-input-group">
            <div id="proxy">
                {{-- <input class="mp-input-group__input mp-mt1 mp-mb3" type="file" name="proxy_sign" id="file" accept="image/png, image/gif, image/jpeg, image/jpg" /> --}}
                <div class="mp-input-group">
                    <input type="hidden" name="appNo" id="appNo">
                    <button class="up-button btn-md button-animate-right mp-text-center" id="save_sign" type="button">
                        <span>Generate Proxy Form</span>
                    </button>
                </div>
                <hr>
                <button class="up-button btn-md button-animate-right mp-text-center" type="button" id="modal_name_pop">Generare Cocolife</button>
            </div>
        </div>


        <button class="up-button btn-md button-animate-right mp-text-center" type="submit" id="next-btn">
            <span>Submit</span>
        </button>
    </div>
</form>
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
<script></script>
@endsection