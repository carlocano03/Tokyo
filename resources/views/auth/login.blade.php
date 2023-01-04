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
        <input class="mp-input-group__input mp-text-field" type="text" id="password" name="password" required />
    </div>
    <div class="mp-pt3 row justify-content-between grid mp-pv-1">

        <div class="col">
            <div class="row flex-column">
                <a class="mp-text-fs-small mp-link" href="{{ url('/password/reset') }}{{ Request::route()->getName() == 'admin' ? '?admin=true' : '' }}">
                    Forgot password?
                </a>
                <br />
                <a class="mp-text-fs-small mp-link" id="register">
                    Register here
                </a>
                <a class="mp-text-fs-small mp-link" href="https://www.upprovidentfund.com/">
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

@section('registrationform')
<div class="d-flex gap-10 sticky mp-ph3 top-0 bg-white">
    <img src="{!! asset('assets/images/uppfi-logo-sm.png') !!}" alt="UPPFI">
    <div class="d-flex flex-column justify-content-center">
        <span>University of the Philippines Provident Fund Inc.</span>
        <span>Online Membership Application</span>
    </div>
</div>
<form id="loginForm" class="mp-pt3 d-flex gap-10 flex-column mp-pb3" method="post" action="{{ url('/login') }}">
    {{ csrf_field() }}
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
        <label class="mp-input-group__label">Address</label>
        <input class="mp-input-group__input mp-text-field" type="text" required />
    </div>
    <div class="mp-input-group">
        <label class="mp-input-group__label">Permanent Address</label>
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
        <input class="mp-input-group__input mp-text-field" type="text" required />
    </div>
    <div class="d-flex">
        <a class="up-button" id="back">
            Back
        </a>
        <a class="up-button">
            Next
        </a>
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