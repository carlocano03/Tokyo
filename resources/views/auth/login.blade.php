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
    <form id="loginForm" class="mp-pt4 mp-mb5" method="post" action="{{ url('/login') }}">
        {{ csrf_field() }}
        <div class="mp-pb4 mp-input-group">
            <label class="mp-input-group__label" for="email">
                {{ Request::route()->getName() == 'admin' ? 'Email' : "Member's ID Number" }}
            </label>
            <input type="hidden" name="usertype" value="{{ Request::route()->getName() == 'admin' ? 'admin' : 'member' }}">
            <input class="mp-input-group__input mp-text-field"
                type="{{ Request::route()->getName() == 'admin' ? 'email' : 'text' }}"
                id="{{ Request::route()->getName() == 'admin' ? 'email' : 'memberNo' }}"
                name="{{ Request::route()->getName() == 'admin' ? 'email' : 'memberNo' }}"
                maxlength="{{ Request::route()->getName() == 'admin' ? ' ' : '9' }}" value="{{ Session::get('user') }}"
                autofocus required />
        </div>
        <div class="mp-pb4 mp-input-group">
            <label class="mp-input-group__label" for="password">Password</label>
            <input class="mp-input-group__input mp-text-field" type="password" id="password" name="password" required />
        </div>
        <div class="col col-auto">
        
            <div class="row">
                <div class="col-6" style="padding:0px;">
                     <label class="mp-text-fs-small mp-link link_style" 
                     style="padding-top:10px;"
                     id="forgot_password">
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
                            <span>Do you want to check your application status? </span><span class="mp-link link_style"
                                id="status_trail">Click here</span>
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

    <label class="mp-text-fs-medium">
        Abutin ang pangarap kasama ang
        <a href="https://www.upprovidentfund.com/" target="_blank">
            UP PROVIDENT FUND INC.
        </a>
    </label>
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
                        <button class="up-button btn-md mp-mt3  hover-back" id="fp_back" value=""
                            style="float:right;">
                            <span>Back</span>
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
            </ul>
            <div class="line step-1" id="line"></div>
        </div>
        <div class="applicationNo">
            <label>Application No </label><br>
            <span id="application_no"></span>
        </div>

        <label class="mp-text-fs-medium mp-ph2 mp-split-pane__title mp-text-c-primary mb-0 mp-pv2 br-top-2 mp-mt2"
            id="registration-title">Personal Information</label>
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
                <label class="mp-input-group__label">Middle Name</label>
                <input class="mp-input-group__input mp-text-field" type="text" name="middlename" required />
            </div>
            <div class="mp-input-group">
                <label class="mp-input-group__label">Suffix</label>
                <input class="mp-input-group__input mp-text-field" type="text" name="suffix" />
            </div>
            <div class="mp-input-group">
                <label class="mp-input-group__label">Date of Birth</label>
                <input class="mp-input-group__input mp-text-field" type="date" name="date_birth" required />
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
                    <option>Registered Ppartnership</option>
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
                <input class="mp-input-group__input mp-text-field" type="text" name="dual_citizenship" id="d_citizen"
                    disabled />
            </div>
            <div class="mp-input-group">
                <label class="mp-input-group__label">Present Address</label><br>
                <label class="mp-input-group__label">Province</label>
                <select class="mp-input-group__input mp-text-field" id="present_province" name="present_province"
                    required>
                    <option></option>
                </select>
            </div>
            <div class="mp-input-group">
                <label class="mp-input-group__label">Municipality</label>
                <select class="mp-input-group__input mp-text-field" id="present_city" name="present_municipality"
                    required>
                    <option></option>
                </select>
            </div>
            <div class="mp-input-group">
                <label class="mp-input-group__label">Barangay</label>
                <select class="mp-input-group__input mp-text-field" id="present_barangay" name="present_barangay"
                    required>
                    <option></option>
                </select>
            </div>
            <div class="mp-input-group">
                <label class="mp-input-group__label">Bldg No. St. No.</label>
                <input class="mp-input-group__input mp-text-field" type="text" id="present_bldg_street"
                    name="present_bldg_street" />
            </div>
            <div class="mp-input-group">
                <label class="mp-input-group__label">Zipcode</label>
                <input class="mp-input-group__input mp-text-field" type="text" id="present_zipcode"
                    name="present_zipcode" maxlength="5"
                    onkeypress='return event.charCode >= 48 && event.charCode <= 57' />
            </div>

            <div class="mp-input-group">
                <label class="mp-input-group__label">Permanent Address</label>
                <div class="d-flex gap-5">
                    <input type="checkbox" value="1" id="perm_add_check" name="perm_add_check" />
                    <label class="mp-input-group__label" style="margin-top: 5px;">(Same as above)</label>

                </div>
                <input class="mp-input-group__input mp-text-field" type="text" name="same_add" id="same_add"
                    readonly />
            </div>
            <div class="mp-input-group same_div">
                <label class="mp-input-group__label">Province</label>
                <select class="mp-input-group__input mp-text-field" id="province" name="province" required>
                    <option></option>
                </select>
            </div>
            <div class="mp-input-group same_div">
                <label class="mp-input-group__label">Municipality</label>
                <select class="mp-input-group__input mp-text-field" id="city" name="municipality" required>
                    <option></option>
                </select>
            </div>
            <div class="mp-input-group same_div">
                <label class="mp-input-group__label">Barangay</label>
                <select class="mp-input-group__input mp-text-field" id="barangay" name="barangay" required>
                    <option></option>
                </select>
            </div>
            <div class="mp-input-group same_div">
                <label class="mp-input-group__label">Bldg No. St. No.</label>
                <input class="mp-input-group__input mp-text-field" type="text" id="bldg_street" name="bldg_street" />
            </div>
            <div class="mp-input-group same_div">
                <label class="mp-input-group__label">Zipcode</label>
                <input class="mp-input-group__input mp-text-field" type="text" id="zipcode" name="zipcode"
                    maxlength="5" onkeypress='return event.charCode >= 48 && event.charCode <= 57' />
            </div>
            <div class="mp-input-group">
                <label class="mp-input-group__label">Cellphone Number</label>
                <input class="mp-input-group__input mp-text-field" type="text" name="contact_no" maxlength="11"
                    onkeypress='return event.charCode >= 48 && event.charCode <= 57' required />
            </div>
            <div class="mp-input-group">
                <label class="mp-input-group__label">Landline Number</label>
                <input class="mp-input-group__input mp-text-field" type="text" name="landline_no" />
            </div>
            <div class="mp-input-group">
                <label class="mp-input-group__label">Email Address</label>
                <input class="mp-input-group__input mp-text-field" type="email" name="email" required />
            </div>
            <a class="up-button btn-md button-animate-right mp-text-center" type="submit" value="step-2"
                id="next-btn">
                <span>Next</span>
            </a>
            <!-- <button type="submit" class="sss" id="btn-submit">Submit</button> -->

        </div>

    </form>
    <form id="member_forms_con">
        <!-- <label class="mp-text-fs-medium">Employment Details</label> -->
        <div class="mp-pt3 d-none gap-10 flex-column mp-pb5 member-form mp-pv2 shadow-inset-1" id="step-2">
            <div class="mp-input-group">
                <label class="mp-input-group__label">Campus</label>
                <select class="mp-input-group__input mp-text-field" name="campus" id="campus" required>
                    <option>Select Campus</option>
                    {{-- @foreach ($campuses as $row)
                    <option value="{{ $row->campus_key }}">{{ $row->name }}</option>
                @endforeach --}}
                </select>
            </div>
            <div class="mp-input-group">
                <label class="mp-input-group__label">Employee Classification</label>
                <select class="mp-input-group__input mp-text-field" name="classification">
                    <option>Select Classification</option>
                    <option>Class A </option>
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
                <select class="mp-input-group__input mp-text-field" name="college_unit">
                    <option>Select Unit</option>
                    <option>Unit </option>
                </select>
            </div>
            <div class="mp-input-group">
                <label class="mp-input-group__label">Department</label>
                <select class="mp-input-group__input mp-text-field" name="department" required>
                    <option>Select Department</option>
                    <option>DEPED </option>
                </select>
            </div>
            <div class="mp-input-group">
                <label class="mp-input-group__label">Academic Rank/ Position</label>
                <select class="mp-input-group__input mp-text-field" name="rank_position">
                    <option>Select Unit</option>
                    <option>Top Global Layla </option>
                </select>
            </div>
            <div class="mp-input-group">
                <label class="mp-input-group__label">Date of Appointment</label>
                <input class="mp-input-group__input mp-text-field" type="date" name="date_appointment" />
            </div>
            <div class="mp-input-group">
                <label class="mp-input-group__label">Appointment Status</label>
                <select class="mp-input-group__input mp-text-field" name="appointment" required>
                    <option>Select Status</option>
                    <option>Regular Employee</option>
                </select>
            </div>
            <div class="mp-input-group">
                <label class="mp-input-group__label">Other Status (Please Specify)</label>
                <input class="mp-input-group__input mp-text-field" type="text" />
            </div>
            <div class="mp-input-group">
                <label class="mp-input-group__label">Monthly Salary</label>
                <input class="mp-input-group__input mp-text-field" type="text" name="monthly_salary"
                    id="monthly_salary" required />
            </div>
            <div class="mp-input-group">
                <label class="mp-input-group__label">Salary Grade</label>
                <input class="mp-input-group__input mp-text-field" type="text" name="salary_grade" id="salary_grade"
                    readonly />
            </div>
            <div class="mp-input-group">
                <label class="mp-input-group__label">Salary Grade Category</label>
                <input class="mp-input-group__input mp-text-field" type="text" name="sg_category" id="sg_category"
                    readonly />
                {{-- <select class="mp-input-group__input mp-text-field" name="sg_category">
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
                    (Contribution will be deducted from your salary every month; Choose between: (a) Percentage of basic
                    salary, minimum of 1%; or (b) Fixed amount;
                    You may change this anytime by filling out the Member’s Data Updating Form; Amount is subject to the DBM
                    rule on net take-home pay threshold.)
                </label>
            </div>
            <div class="mp-input-group">
                <div class="d-flex gap-5">
                    <input type="checkbox" class="options" id="percentage_check" name="percentage_check"
                        value="percentage" onClick="ckChange(this)" />
                    <label class="mp-input-group__label" style="margin-top: 5px;">Percentage of Basic Salary ( Between 1%
                        - 100%)</label>
                </div>
                <input class="mp-input-group__input mp-text-field" type="number" name="percentage_bsalary"
                    id="percentage_bsalary" />
                <label class="mp-input-group__label" style="margin-top: 5px;">Equivalent:</label> <label
                    class="mp-input-group__label" id="computed_amount" style="margin-top: 5px;"></label>
            </div>
            <div class="mp-input-group">
                <div class="d-flex gap-5">
                    <input type="checkbox" class="options" id="fixed_amount_check" name="fixed_amount_check"
                        onClick="ckChange(this)" />
                    <label class="mp-input-group__label" style="margin-top: 5px;">Fixed Amount ( In Philippine Peso
                        )</label>
                </div>
                <input class="mp-input-group__input mp-text-field" type="text" name="fixed_amount"
                    id="fixed_amount" />
            </div>
            <div class="mp-input-group d-flex gap-5 flex-column">
                <label class="mp-input-group__label">Dependents</label>
                <input class="mp-input-group__input mp-text-field" type="text" id="dependent_name"
                    placeholder="Name" />
                <input class="mp-input-group__input mp-text-field" type="text" id="dependent_bday"
                    onfocus="(this.type='date')" placeholder="Birthday" />
                <input class="mp-input-group__input mp-text-field" type="text" id="dependent_relation"
                    placeholder="Relationship" />
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

            <div class="mp-input-group">
                <label class="mp-input-group__label">Supporting Document</label>
            </div>

            <div class="supporting_docu">
                <input type="hidden" name="app_no" id="app_no">
                <input type="hidden" name="percent_amt" id="percent_amt">
                <div class="mp-input-group">
                    <label class="mp-input-group__label">
                        <a href="{{ route('download_coco') }}" class="mp-link link_style">Click here</a><span> to
                            download Cocolife Form for manual signature (Optional) </span>
                    </label>
                </div>
                <div class="mp-input-group">
                    {{-- <input class="mp-input-group__input mp-mt1 mp-mb3" type="file" name="documents[]" required accept="application/pdf" multiple/> --}}
                    <input class="mp-input-group__input mp-mt1 mp-mb3" type="file" id="coco" name="coco"
                        required accept="application/pdf" />
                </div>

                <div class="mp-input-group">
                    <label class="mp-input-group__label">
                        <a href="{{ route('download_proxy') }}" class="mp-link link_style">Click here</a><span> to
                            download Proxy Form for manual signature (Optional) </span>
                    </label>
                </div>
                <div class="mp-input-group">
                    {{-- <input class="mp-input-group__input mp-mt1 mp-mb3" type="file" name="documents[]" required accept="application/pdf" multiple/> --}}
                    <input class="mp-input-group__input mp-mt1 mp-mb3" type="file" id="proxy_form" name="proxy"
                        required accept="application/pdf" />
                </div>
            </div>


            <div class="mp-input-group">
                <div class="d-flex gap-5">
                    <input type="checkbox" id="generateForm" name="generateForm" value="generateForm"/>
                    <label class="mp-input-group__label" style="margin-top: 5px;">Generate Cocolife and Proxy Form</label>
                </div>

                <div id="proxy">
                    <label class="mp-input-group__label" style="margin-top: 5px;">Upload Signature</label>
                    <input class="mp-input-group__input mp-mt1 mp-mb3" type="file" name="proxy_sign" id="file"
                        accept="image/png, image/gif, image/jpeg, image/jpg" />
                    <input type="hidden" name="appNo" id="appNo">
                    <button class="up-button btn-md button-animate-right mp-text-center" id="save_sign" type="button">
                        <span>Generate Proxy Form</span>
                    </button>
                </div>
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
    <div class="mp-bg {{ Request::route()->getName() == 'admin' ? 'mp-bg--admin' : 'mp-bg--member' }}"
        style="background-image:url({{ Request::route()->getName() == 'admin' ? 'assets/images/bg-admin.svg' : 'assets/images/bg-member.svg' }})">
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
