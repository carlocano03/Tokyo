<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Proxy Form</title>
    <style>
        /* Define your custom font */
        @font-face {
            font-family: 'MyCustomFont';
            src: url({{ storage_path("fonts/AuthenticSignature400.ttf") }}) format("truetype");
        }

        body {
            font-family: 'Fira Sans', sans-serif;
            margin-left: 40px;
            margin-right: 40px;
            font-size: 14px;
        }
        .logo {
            text-align: center;
            margin-bottom: 30px; 
        }

        .sign {
            font-family: 'MyCustomFont';
            font-size: 30px;
        }
    </style>
</head>
<body>
    <div class="logo">
        <img src="{{ public_path().'/assets/images/uppfi-logo.png' }}" width="15%" alt="UPPFI">
        <h2>PROXY FORM</h2>
    </div>
    <b>Know all men by these presents:</b>
    <div>
        <p style="text-align: justify;">
            I hereby nominate, constitute, and appoint the Chairman of UP Provident Fund, Inc.
            (UPPFI) to represent me and vote in my name on any matter at any and all regular and
            special meetings of members of UPPFI and/or at any adjournments, continuation, or
            postponements thereof. <br><br>

            In case of non-attendance of the above-named proxy, I authorize and empower the Vice
            Chairman of UPPFI, or in his absence, the Executive Director to fully exercise all rights
            as my proxy at such meeting. <br><br>

            Hereby giving and granting unto my proxy full power and authority whatsoever requisite
            or necessary or proper to be done in or about the premises, as fully to all intents and
            purposes as I might or could lawfully do if personally present, and hereby ratifying and
            confirming all that my proxy shall do or cause to be done. <br><br>

            This proxy revokes all proxies which I might have previously executed in favor of other
            persons. Should I personally attend any of the meetings or have given my proxy to
            another to represent me thereat, this proxy shall be deemed of no force and effect but
            only for said meeting and shall again be effective and in full force after its adjournment. <br><br>

            This proxy shall be effective for five (5) years from the date hereof, or until withdrawn by
            me through notice in writing delivered to the Secretary of the Corporation.
        </p>
    </div>
    <br>
    <div style="text-align: right;">

        {{-- <img src="{{ public_path().$member->sign_path }}" width="15%" alt="UPPFI"> --}}
        <label class="sign">{{ ucwords($member->sign) }}</label>
        <hr style="width: 50%; margin-right: 0px; margin-bottom:1px; margin-top:-5px;">
        Signature of Member
        <br><br><br>

        {{ $member->firstname }} {{ $member->middlename }} {{ $member->lastname }}
        <hr style="width: 50%; margin-right: 0px; margin-bottom:1px;">
        Name of Member
        <br><br><br>

        {{ $member->campus }}
        <hr style="width: 30%; margin-right: 0px; margin-bottom:1px;">
        Campus
        <br><br><br>

        {{ date('F j, Y') }}
        <hr style="width: 30%; margin-right: 0px; margin-bottom:-5px;">
        Date
    </div>
</body>
</html>