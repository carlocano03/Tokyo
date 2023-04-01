<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Axa Form</title>
    <style>
        * {
            font-family: 'Fira Sans', sans-serif;
            font-weight: bold;
        }

        .pdf-container img {
            transform: scale(1.15);
            position: absolute;
            z-index: -1;
        }

        .value-container {
            position: absolute;
            font-family: calibri;
            font-size: 14px;
        }

        .col-1 {
            margin-top: 124px;
        }

        .col-1 .firstname_value {
            margin-left: 200px;
            font-family: 'Fira Sans', sans-serif;
        }

        .col-1 .middlename_value {
            margin-left: 207px;
        }

        .col-2 {
            margin-top: 27px;
        }

        .col-3 {
            margin-top: 27px;
        }

        .col-4 {
            margin-top: 27px;
        }

        .col-5 {
            margin-top: 27px;
        }

        .col-6 {
            margin-top: 27px;
        }

        .col-7 {
            margin-top: 7px;
        }

        .col-7 input {
            position: absolute;
        }

        .col-8 {
            margin-top: 69px;
        }

        .col-9 {
            margin-top: 24px;
        }

        .col-10 {
            position: absolute;
            margin-top: -49px;
            width: 2000px;
            display: inline-block;
        }

        .col-10 .col {
            margin-top: 14px;
        }

        .signature {
            position: absolute;
            margin-top: 345px;
        }

        .signature .col-1 {
            position: absolute;
            text-align: center;
            margin-left: -100px;
            width: 500px;
            display: inline-block;
        }

        .signature .col-2 {
            position: absolute;
            text-align: center;
            margin-left: 300px;
            margin-top: 175px;
            width: 500px;
            display: inline-block;
        }

        .dot {
            height: 15px;
            width: 15px;
            background-color: black;
            border-radius: 50%;
            display: inline-block;
            position: absolute;
            margin-top: 4px;

        }
    </style>
</head>

<body>
    <div class="pdf-container">
        <img src="{{ public_path().'/assets/pdf/axa-form-base.jpg' }}" width="100%" alt="UPPFI">
    </div>
    <div class="value-container">
        <div class="col-1">
            <label class="lastname_value" style="font-size:10px;">{{$member->lastname}}</label>
            <label class="firstname_value" style="margin-left:210px; font-size:10px;">{{$member->firstname}}</label>
            <label class="middlename_value" style="margin-left:200px; font-size:10px;">{{$member->middlename}}</label>
        </div>
        <div class="col-2">
            <label class="sex_value" style="font-size:10px;">{{$member->gender}}</label>
            <label class="civilstatus_value" style="margin-left:30px; font-size:10px;">{{$member->civilstatus}}</label>
            <label class="dob_value" style="margin-left:35px; font-size:10px;">{{ date('m/d/Y', strtotime($member->date_birth)) }}</label>
            <label class="age" style="margin-left:110px; font-size:10px;">{{ \Carbon\Carbon::parse($member->date_birth)->age }}</label>
            <label class="pob_value" style="margin-left:50px; font-size:10px;">{{$member->place_birth}}</label>
            <label class="nationality_value" style="margin-left:95px; font-size:10px;">{{$member->citizenship}}</label>


        </div>
        <div class="col-3">
            <label class="address_value" style="font-size:10px;">{{$member->bldg_street}} {{ $member->barangay}} {{ $member->municipality}} {{ $member->province}} {{$member->zipcode}}</label>

        </div>
        <div class="col-4">
            <label class="email_value" style="font-size:10px;">{{$member->email}}</label>
            <label class="contactNo_value" style="margin-left:100px; font-size:10px;">{{$member->contact_no}}</label>
            <label class="mobileNo_value" style="margin-left:185px; font-size:10px;">{{$member->contact_no}}</label>
        </div>
        <div class="col-5">
            <label class="lastname_value" style="font-size:10px;">{{$member->emp_union_assoc}}</label>
            <label class="firstname_value" style="margin-left:138px; font-size:10px;">{{$member->occupation}}</label>
            <label class="middlename_value" style="margin-left:80px; font-size:10px;">{{$member->tin_no}}</label>
            <label class="middlename_value" style="margin-left:120px; font-size:10px;">{{$member->sss_gsis}}</label>
        </div>
        <div class="col-6">
            <label class="" style="font-size:10px;">{{$member->spouse_name}}</label>
            <label class="" style="margin-left:265px; font-size:10px;">{{$member->maiden_name}}</label>
        </div>
        <div class="col-7">

            <span class="{{ $member->monthly_salary < 25000 ? 'dot' : '' }}" style="margin-left:103px;  "></span>
            <span class="{{ $member->monthly_salary > 25000 && $member->monthly_salary <= 50000 ? 'dot' : '' }}" style="margin-left:192px;  "></span>
            <span class="{{ $member->monthly_salary > 50000 ? 'dot' : '' }}" style="margin-left:325px; "></span>
            <span class="{{ $member->insuted_type == 'INSURED' ? 'dot' : '' }}" style="margin-left:528px;  "></span>
            <span class="{{ $member->insuted_type == 'DEPENDENT' ? 'dot' : '' }}" style="margin-left:608px;  "></span>
            <!-- <input type="radio" style="margin-left:103px;" {{ $member->monthly_salary < 25000 ? 'checked' : 'checked' }}> -->
            <!-- <input type="radio" style="margin-left:192px;" {{ $member->monthly_salary > 25000 && $member->monthly_salary <= 50000 ? 'checked' : '' }}>
            <input type="radio" style="margin-left:325px;" {{ $member->monthly_salary > 50000 ? 'checked' : '' }}>
            <input type="radio" style="margin-left:528px;" {{ $member->insuted_type == 'INSURED' ? 'checked' : '' }}>
            <input type="radio" style="margin-left:608px;" {{ $member->insuted_type == 'DEPENDENT' ? 'checked' : '' }}> -->
        </div>
        <div class="col-8">
            <label class="" style="font-size:10px;">{{$member->last_name}}</label>
            <label class="" style="margin-left:205px; font-size:10px;">{{$member->first_name}}</label>
            <label class="" style="margin-left:178px; font-size:10px;">{{$member->middle_name}}</label>
        </div>
        <div class="col-9">
            <label class="" style="font-size:10px;">{{$member->relationship_tomember}}</label>
            <label class="" style="margin-left:180px; font-size:10px;">{{$member->contact_no}}</label>
            <label class="" style="margin-left:170px; font-size:10px;">{{$member->email_add}}</label>
        </div>

        <div class="col-10" style="font-size:8px;  margin-top:60px;">
            @for ($i = 0; $i <= 5; $i++) <div class="col" style="margin-top:16px;">
                <label class="b_lastname_value">
                    asdasd
                </label>
                <label class="b_firstname_value" style="margin-left:75px;">
                    asdasd
                </label>
                <label class="b_initials_value" style="margin-left:86px;">
                    R
                </label>
                <label class="b_dob_value" style="margin-left:15px;">
                    asdasd
                </label>
                <label class="b_relationship_value" style="margin-left:35px;">
                    asdasd
                </label>
                <label class="b_benifit_value" style="margin-left:70px;">
                    asdasd
                </label>
                <label class="b_primary_value" style="margin-left:35px;">
                    asdasd
                </label>
                <label class="b_secondary_value" style="margin-left:20px;">
                    asdasd
                </label>
                <label class="b_revocable_value" style="margin-left:20px;">
                    asdasd
                </label>
                <label class="b_irrevocable_value" style="margin-left:20px;">
                    asdasd
                </label>

        </div>
        @endfor
    </div>

    <div class="signature">
        <div class="col-1">
            <!-- <img src="{{ asset($member->signature) }}" width="50px" height="50px" alt="UPPFI"> -->
            <img src="{{ public_path($member->signature)}}" width="50px" height="50px" alt="UPPFI">
            <br>
            <label>{{ $member->sign }}</label>
        </div>

        <div class="col-2">
            <!-- <img src="{{ public_path().'/assets/images/uppfi-logo.png' }}" width="50px" height="50px" alt="UPPFI">
                <br> -->
            <label>{{ date('m/d/Y', strtotime($member->time_stamp_datesigned)) }}</label>
        </div>
    </div>
    </div>



</body>

</html>