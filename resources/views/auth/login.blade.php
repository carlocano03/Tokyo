@extends('layouts/splitPane')

@section('loginForm')

<div class="mp-pb4 mp-text-center">
    <img src="{!! asset('assets/images/uppfi-logo-sm.png') !!}" alt="UPPFI">
</div>
<div class="mp-pb4 mp-text-fs-large mp-text-center mp-split-pane__title mp-text-c-primary">
    {{ (Request::route()->getName() == 'admin' ? 'Admin' : 'Member')}} Login
</div>
<div class="mp-text-fs-small">
    @if(Session::get('error'))
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
<form id="loginForm" class="mp-pt4 mp-mb5" method="post" action="{{ url('/login') }}">
    {{ csrf_field() }}
    <div class="mp-pb4 mp-input-group">
        <label class="mp-input-group__label" for="email">
            {{ Request::route()->getName() == 'admin' ? 'Email' : "Member's ID Number" }}
        </label>
        <input type="hidden" name="usertype" value="{{ Request::route()->getName() == 'admin' ? 'admin' : 'member' }}">
        <input class="mp-input-group__input mp-text-field" type="{{ Request::route()->getName() == 'admin' ? 'email' : 'text' }}" id="{{ Request::route()->getName() == 'admin' ? 'email' : 'memberNo' }}" name="{{ Request::route()->getName() == 'admin' ? 'email' : 'memberNo' }}" maxlength="{{ Request::route()->getName() == 'admin' ? ' ' : '9' }}" value="{{ Session::get('user') }}" autofocus required />
    </div>
    <div class="mp-pb4 mp-input-group">
        <label class="mp-input-group__label" for="password">Password</label>
        <input class="mp-input-group__input mp-text-field" type="password" id="password" name="password" required />
    </div>
    <div class="mp-pt3 row justify-content-between grid mp-pv-1">

        <div class="col">
            <div class="row flex-column">
                <a class="mp-text-fs-small mp-link link_style" id="forgot_password">
                    Forgot password?
                </a>
                <br />
                <label class="mp-text-fs-small mp-link link_style"  id="register">
                    Register here
                </label>
                <label class="mp-text-fs-small mp-link link_style"  id="status_trail">
                    Check Application Status
                </label>
                <a class="mp-text-fs-small mp-link link_style" href="https://www.upprovidentfund.com/">
                    Back to www.upprovidentfund.com
                </a>
            </div>
        </div>
        <div class="col col-auto">
            <div class="row">
                <button type="submit" class="mp-button mp-button--accent">Login</button>
            </div>
        </div>

       
    </div>
     
</form>
@endsection

@section('status-trail-form')
  <button class="up-button btn-md mp-mt3" id="fp_back" value="">
                Back
    </button>
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
    <div class="mp-input-group mp-mt5">
            <label class="mp-input-group__label">Application Number</label>
            <input class="mp-input-group__input mp-text-field" type="text" required />
    </div>

    <div class="col col-auto">
            <div class="row" style ="float:right;" >
                <button class="up-button btn-md mp-mt3"  type="submit"  id="btn-submit">Search</button>
            </div>
    </div>
@endsection

@section('registration-personal-form')
<div class="d-flex gap-10 sticky mp-ph3 top-0 bg-white">
    <div>
        <img src="{!! asset('assets/images/uppfi-logo-sm.png') !!}" alt="UPPFI">
    </div>
    <div class="d-flex flex-column justify-content-center">
        <span>University of the Philippines Provident Fund Inc.</span>
        <span>Online Membership Application</span>
    </div>
</div>
<form id="loginForm" method="post" action="{{ url('/register') }}">
    {{ csrf_field() }}
    <div class="mp-pt3 d-flex gap-10 flex-column mp-pb5" id="step-1">
        <label class="mp-text-fs-medium">Personal Information</label>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Last Name</label>
            <input class="mp-input-group__input mp-text-field" type="text" required />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">First Name</label>
            <input class="mp-input-group__input mp-text-field" type="text" required />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Middle Name</label>
            <input class="mp-input-group__input mp-text-field" type="text" required />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Suffix</label>
            <input class="mp-input-group__input mp-text-field" type="text" required />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Date of Birth</label>
            <input class="mp-input-group__input mp-text-field" type="date" required />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Gender</label>
            <select class="mp-input-group__input mp-text-field">
                <option>Select Gender</option>
                <option>Male</option>
                <option>Female</option>
            </select>
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Civil Status</label>
            <select class="mp-input-group__input mp-text-field">
                <option>Single</option>
                <option>Married</option>
                <option>Widowed</option>
                <option>Divorced</option>
                <option>Registered Ppartnership</option>
            </select>
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Dual Citizenship / Other Citizenship</label>
            <input class="mp-input-group__input mp-text-field" type="text" required />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Province</label>
            <select class="mp-input-group__input mp-text-field" id="province">
                <option></option>
            </select>
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Municipality</label>
            <select class="mp-input-group__input mp-text-field" id="city">
                <option></option>
            </select>
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Barangay</label>
            <select class="mp-input-group__input mp-text-field" id="barangay">
                <option></option>
            </select>
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Bldg No. St. No.</label>
            <input class="mp-input-group__input mp-text-field" type="text" required />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Zipcode</label>
            <input class="mp-input-group__input mp-text-field" type="text" required />
        </div>

        <div class="mp-input-group">
            <label class="mp-input-group__label">Permanent Address</label>
            <div class="d-flex gap-5">
                <input type="checkbox" />
                <label class="mp-input-group__label" style="margin-top: 5px;">(Same as above)</label>

            </div>
            <input class="mp-input-group__input mp-text-field" type="text" required />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Cellphone Number</label>
            <input class="mp-input-group__input mp-text-field" type="text" required />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Landline Number</label>
            <input class="mp-input-group__input mp-text-field" type="text" required />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Email Address</label>
            <input class="mp-input-group__input mp-text-field" type="email" required />
        </div>
    </div>
    <div class="mp-pt3 d-none gap-10 flex-column mp-pb5" id="step-2">
        <label class="mp-text-fs-medium">Employment Details</label>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Campus</label>
            <select class="mp-input-group__input mp-text-field">
                <option>Select Campus</option>
                <option>Campus </option>
                <option>Campus </option>
                <option>Campus </option>
                <option>Campus </option>
            </select>
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Employee Classification</label>
            <select class="mp-input-group__input mp-text-field">
                <option>Select Classification</option>
                <option>Class A </option>
            </select>
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Other Classification (Please Specify)</label>
            <input class="mp-input-group__input mp-text-field" type="text" required />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Employee Number</label>
            <input class="mp-input-group__input mp-text-field" type="text" required />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">College Unit</label>
            <select class="mp-input-group__input mp-text-field">
                <option>Select Unit</option>
                <option>Unit </option>
            </select>
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Department</label>
            <select class="mp-input-group__input mp-text-field">
                <option>Select Department</option>
                <option>DEPED </option>
            </select>
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Academic Rank/ Position</label>
            <select class="mp-input-group__input mp-text-field">
                <option>Select Unit</option>
                <option>Top Global Layla </option>
            </select>
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Date of Appointment</label>
            <input class="mp-input-group__input mp-text-field" type="date" required />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Appointment Status</label>
            <select class="mp-input-group__input mp-text-field">
                <option>Select Status</option>
                <option>Regular Employee</option>
            </select>
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Other Status (Please Specify)</label>
            <input class="mp-input-group__input mp-text-field" type="text" required />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Monthly Salary</label>
            <input class="mp-input-group__input mp-text-field" type="text" required />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Salary Grade</label>
            <input class="mp-input-group__input mp-text-field" type="text" required />
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Salary Grade Category</label>
            <select class="mp-input-group__input mp-text-field">
                <option>Select Category</option>
                <option>Yayamanin</option>
            </select>
        </div>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Taxpayer Identification Number (TIN)</label>
            <input class="mp-input-group__input mp-text-field" type="text" required />
        </div>
    </div>
    <div class="mp-pt3 d-none gap-10 flex-column mp-pb5" id="step-3">
        <label class="mp-text-fs-medium">Membership Details</label>
        <div class="mp-input-group">
            <div class="d-flex gap-5">
                <input type="checkbox" />
                <label class="mp-input-group__label" style="margin-top: 5px;">Percentage of Basic Salary ( Between 1% - 100%)</label>
            </div>
            <input class="mp-input-group__input mp-text-field" type="text" required />
        </div>
        <div class="mp-input-group">
            <div class="d-flex gap-5">
                <input type="checkbox" />
                <label class="mp-input-group__label" style="margin-top: 5px;">Fixed Amount ( In Philippine Peso )</label>
            </div>
            <input class="mp-input-group__input mp-text-field" type="text" required />
        </div>
        <div class="mp-input-group d-flex gap-5 flex-column">
            <label class="mp-input-group__label">Dependents</label>
            <input class="mp-input-group__input mp-text-field" type="text" required placeholder="Name" />
            <input class="mp-input-group__input mp-text-field" type="text" required placeholder="Birthday" />
            <input class="mp-input-group__input mp-text-field" type="text" required placeholder="Relationship" />
            <a class="up-button mw-200 btn-md self-end mp-mt2">Add Dependent</a>
        </div>
        <table class="mp-table mp-text-fs-small table_style mp-mh2" id="campusTable" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Birthday</th>
                    <th>Relationship</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Samplee D. Luffy</td>
                    <td>January-1-2000</td>
                    <td>Son</td>
                </tr>
            </tbody>
        </table>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Supporting Document</label>
            <input class="mp-input-group__input mp-mt3" type="file" required />
        </div>
        <div class="mp-input-group mp-mt2">
            <label for="" class="mp-input-group__label"><input class="" type="checkbox" required /> By checking this box, I hearby certify that all information provided is true, acurate, and complete.</label>
        </div>
    </div>
    <button type="submit" class="d-none" id="btn-submit">Submit</button>
</form>
@endsection

@section('reset-password-form')
    <button class="up-button btn-md mp-mt3" id="fp_back" value="">
                Back
    </button>
    <div class="mp-pb4  mp-text-center">
        <img src="{!! asset('assets/images/uppfi-logo-sm.png') !!}" alt="UPPFI">
    </div>
    <div class="mp-pb4 mp-text-fs-large mp-text-center mp-split-pane__title mp-text-c-primary">
     Reset Your Password
    </div>
    
  
    <form id="resetPassword" method="post" action="{{ url('/register') }}">
    {{ csrf_field() }}
    <div class="mp-pt3 d-flex gap-10 flex-column mp-pb5" id="step-1">

        <label class="mp-text-fs-medium">
            Submit your email address and we'll send you a "Reset your Password" email. If you cannot find the email in your Inbox, wait a few minutes then refresh your Inbox or, alternatively, look for it in your Spam or Junk folder. If you do not remember your email address, please 
            <a href="https://www.upprovidentfund.com/contact-us/" target="_blank">contact us</a> us so we can assist you in resetting your password.
        </label>
        <div class="mp-input-group">
            <label class="mp-input-group__label">Email</label>
            <input class="mp-input-group__input mp-text-field" type="email" required />
        </div>

    </div>
     <div class="col col-auto">
            <div class="row" style ="float:right;" >
                <button class="up-button btn-md"  type="submit"  id="btn-submit">Send Email</button>
            </div>
    </div>
  
    
</form>
@endsection


@section('right')
<div class="mp-bg {{ Request::route()->getName() == 'admin' ? 'mp-bg--admin' : 'mp-bg--member' }}" style="background-image:url({{ Request::route()->getName() == 'admin' ? 'assets/images/bg-admin.svg' : 'assets/images/bg-member.svg'}})">
    <div class="mp-mhauto mp-pv5">
        <div class="mp-hide-xs mp-hide-sm mp-text-fs-xxxlarge mp-text-fw-heavy mp-text-c-white mp-text-shadow">
            Welcome to UP Provident Fund
        </div>
    </div>
</div>
@endsection