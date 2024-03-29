<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- <link href="{{ public_path().'/dist/style.css' }}" rel="stylesheet"> -->
    <title>Membership Form</title>

    <style>
        /* #sign {
            font-family: 'Authentic';
            font-size: 30px;
        } */

        .pdf-container img {
            transform: scale(1.2);
            margin-top: 20px;

        }

        body {
            font-family: 'Fira Sans', sans-serif;
            font-weight: bold;
        }

        .text-container {
            position: absolute;
            z-index: 10;
            width: 100%;
            height: 100%;
            left: 0px;
            top: 0px;
        }

        .black {
            color: black !important;
        }

        .white {
            color: white !important;
        }

        .top-text {
            width: 100%;
        }

        .top-text .title {
            position: absolute;
            font-weight: bold;
            font-size: 18px;
            left: 380px;
            margin-top: -10px;
        }

        .top-text .info_text {
            width: 500px;
            position: absolute;
            font-size: 9px;
            font-style: italic;
            left: 320px;
            margin-top: 30px;
        }

        /* personal details css */
        .personal-details .title {
            position: absolute;
            font-weight: bold;
            font-size: 15px;
            left: 300px;
            top: 65px;
        }

        .lastname {
            margin-top: 84px;
        }

        .lastname .p-lastname_value {
            margin-top: 12px;
        }

        .suffix {
            padding-left: 550px;
            width: 300px;
        }

        .suffix .p-suffix {
            left: 580px;
            font-size: 10px !important;
        }

        .suffix .p-suffix_value {
            margin-top: 12px;
            margin-left: 29px;
        }

        /* employment details css */
        .employment-details {
            position: absolute;
            top: 312px;
            left: 287px;

        }

        .main_title {

            font-weight: bold;
            font-size: 15px;
            margin-left: -5px;
        }

        .title-font {
            position: absolute;
            font-size: 11px;
            font-weight: normal;
            width: 500px;
            display: inline-block;
        }

        .value-font {
            position: absolute;
            font-size: 11.5px;
            width: 2000px;
            display: inline-block;
        }

        .value-font-date {
            position: absolute;
            font-size: 11.5px;
            width: 1990px;
            display: inline-block;
        }

        .first_name {
            margin-top: 30px;
        }

        .first_name .p-firstname_value {
            margin-top: 12px;
        }

        .middle_name {
            margin-top: 0px;
            margin-left: 440px;
        }

        .middle_name .p-middlename_value {
            margin-top: 12px;
        }

        .date_of_birth {
            margin-top: 57px;
        }

        .date_of_birth .p-birth_month {
            margin-top: 32px;
        }

        .date_of_birth .p-birth_day {
            margin-top: 32px;
            margin-left: 100px;
        }

        .date_of_birth .p-birth_year {
            margin-top: 32px;
            margin-left: 135px;
        }

        .date_of_birth .p-birth_month_value {
            margin-top: 17px;
        }

        .date_of_birth .p-birth_day_value {
            margin-top: 17px;
            margin-left: 100px;
        }

        .date_of_birth .p-birth_year_value {
            margin-top: 17px;
            margin-left: 135px;
        }

        .sex {
            margin-left: 190px;
        }

        .sex .checkbox_male {
            margin-top: 20px;
        }

        .civil_status {
            margin-left: 280px;
            margin-top: -120px;
        }

        .civil_status .checkbox_single {
            margin-top: 20px;
        }

        .civil_status .checkbox_widowed {
            position: absolute;
            margin-top: -48px;
            margin-left: 80px;
        }

        .civil_status .checkbox_annulled {
            position: absolute;
            margin-top: -32px;
            margin-left: 80px;
            width: 100px;
        }

        .civil_status .checkbox_annulled label {
            font-size: 10px !important;
            width: 100px;
        }

        .citizenship {
            width: 1000px;
            margin-left: 500px;
            margin-top: -100px;
        }

        .citizenship .checkbox_filipino {
            position: absolute;
            margin-top: 17px;
        }

        .citizenship .checkbox_others {
            position: absolute;
            margin-top: 30px;
        }

        .citizenship .checkbox_dual_filipino {
            position: absolute;
            margin-top: 42px;
        }

        .p-dual_filipino_value {
            margin-left: 83px;
        }

        .p-others_value {
            margin-left: 37px;
        }

        .address {
            margin-top: 60px;
        }

        .cellphone {
            margin-left: 500px;
        }

        .landline {
            margin-left: 620px;
        }

        .permanent_address {
            margin-top: 60px;
        }

        .email_address {
            margin-left: 500px;
        }

        .p-cellphone_value {
            margin-top: 30px;
        }

        .p-address_value {
            margin-top: 30px;
            font-size: 9px;
            width: 480px;
        }

        .p-email_address_value {
            margin-top: 30px;
        }

        .univ {
            margin-left: -287px;
            margin-top: 5px;
        }

        .e-univ_value {
            margin-top: 15px;
        }

        .e-univ_value .col-1 {
            margin-top: 35px;
        }

        .e-univ_value .col-1 .choices {
            margin-top: -5px;
        }

        .e-univ_value .col-2 .choices {
            margin-top: -5px;
        }

        .e-univ_value .col-2 {
            margin-top: -55px;
            margin-left: 90px;
        }

        .e-univ_value .col-3 .choices {
            margin-top: -5px;
        }

        .e-univ_value .col-3 {
            margin-top: -55px;
            margin-left: 150px;
        }

        .e-univ_value .col-4 {
            margin-top: -55px;
            margin-left: 270px;
        }

        .e-univ_value .col-4 .choices {
            margin-top: -5px;
        }

        .e-univ_value .col-5 {
            margin-top: -55px;
            margin-left: 384px;
        }

        .e-univ_value .col-5 .choices {
            margin-top: -5px;
        }

        .e-univ_value .col-6 {
            margin-top: -55px;
            margin-left: 474px;
        }

        .e-univ_value .col-6 .choices {
            margin-top: -5px;
        }

        .e-univ_value .col-6 .choices .choices_others_value {
            position: absolute;
            margin-top: 15px;
            margin-left: -10px;
        }

        .emp_class {
            margin-left: 396px;
        }

        .e-emp_class_value {
            margin-top: 15px;
        }

        .emp_no {
            margin-left: 590px;
        }

        .e-emp_no_value {
            margin-top: 55px;
        }

        .college_unit {
            margin-top: 111px;


        }

        .e-college_unit_value {
            margin-top: 16px;
            width: 260px;
            font-size: 8px;
        }

        .department {
            margin-top: -111px;
            margin-left: 272px;
        }

        .e-department_value {
            margin-top: 16px;
            width: 260px;
            font-size: 8px;
        }

        .academic_rank {
            margin-top: -222px;
            margin-left: 540px;
        }

        .e-academic_rank_value {
            margin-top: 16px;
        }

        .status_appointment {
            margin-top: 44px;
        }

        .status_appointment .col-1 {
            margin-top: 20px;
        }

        .status_appointment .col-2 {
            position: absolute;
            margin-left: 100px;
            margin-top: -40px;
        }

        .status_appointment .col-2 .choices .choices_others_value {
            margin-top: 10px;
            margin-left: 20px;
        }

        .status_appointment .col-2 .choices {
            margin-top: -5px;
        }

        .date_of_appointment {
            margin-top: -66px;
            margin-left: 238px;
        }

        .e-dop_date {
            margin-top: 10px;
        }

        .e-dop_date_titles label {
            margin-top: 30px;
        }

        .e-dop_date_value label {
            margin-top: 20px;
        }

        .e-dop_date_day {
            margin-left: 50px;
        }

        .e-dop_date_year {
            margin-left: 100px;
        }

        .e-dop_date_day_value {
            margin-left: 50px;
        }

        .e-dop_date_year_value {
            margin-left: 100px;
        }

        .salary_grade {
            position: absolute;
            margin-top: -67px;
            margin-left: 378px;
        }

        .salary_grade .e-s_grade_value {
            margin-top: 20px;
            display: inline-block;
            width: 100px !important;
        }

        .monthly_salary {
            position: absolute;
            margin-top: -67px;
            margin-left: 478px;
        }

        .monthly_salary .e-monthly_salary_value {
            margin-top: 20px;
            display: inline-block;
            width: 100px !important;
        }

        .tin_id {
            position: absolute;
            margin-top: -67px;
            margin-left: 600px;
        }

        .tin_id .e-tin_id {
            font-size: 10px !important;
        }

        .tin_id .e-tin_id_value {
            margin-top: 20px;
            display: inline-block;
            width: 100px !important;
        }

        .membership-details .title {
            position: absolute;
            margin-top: -3px !important;
        }

        .md-title {
            position: absolute;
            margin-left: -292px;
            margin-top: 18px;
        }

        .info_text {
            font-weight: normal;
            font-size: 11px;
            font-style: italic;
        }

        .info_text .row-1 {
            display: inline-block;
            width: 2000px;
            margin-top: 30px;
            margin-left: -293px;
        }

        .info_text .row-2 {
            display: inline-block;
            width: 2000px;
            margin-top: 0px;
            margin-left: -293px;
        }

        .percentage .col-1 {
            margin-left: -290px;
            margin-top: 5px;
        }

        .percentage .col-1 .value {

            margin-top: 18px;
            padding-left: 10px;
            margin-left: 120px;
            width: 50px;
            padding-bottom: 3px;
            border-bottom: solid 1.2px;
            border-bottom-color: black;
        }

        .percentage .col-2 {
            margin-left: 60px;
            margin-top: -25px;
        }

        .percentage .col-3 {
            margin-left: 90px;
            margin-top: -25px;
        }

        .percentage .col-3 .value {
            margin-top: 18px;
            padding-left: 30px;
            margin-left: 80px;
            width: 100px;
            padding-bottom: 3px;
            border-bottom: solid 1.2px;
            border-bottom-color: black;
        }

        .benificiary {
            margin-top: 5px;
            margin-left: 2px;
        }

        .b-table {
            margin-left: -292px;
            margin-top: 5px;
        }

        .b-table .col-2 {
            margin-left: 365px;
        }

        .no_1 {
            margin-top: 25px;
        }

        .no_2 {
            margin-top: 55px;
        }

        .no_3 {
            margin-top: 25px;
        }

        .no_4 {
            margin-top: 55px;
        }

        .full_name {
            margin-left: 20px;

        }

        .full_name_value {
            width: 130px;
            font-size: 9px;
            margin-left: 20px;
            margin-top: 13px;
        }

        .date_of_birth {
            margin-left: 180px;
            margin-top: 1px;
        }

        .date_of_birth_value {
            display: inline-block;
            width: 200px;
            margin-left: 180px;
            margin-top: 25px;
        }

        .relationship {
            margin-left: 280px;
            margin-top: 1px;
        }

        .relationship_value {
            display: inline-block;
            width: 200px;
            margin-left: 280px;
            margin-top: 25px;
        }

        .by-signing {
            margin-top: 70px;
            margin-left: 8px;
        }

        .info_text_bottom {
            font-weight: normal;
            font-size: 11.6px;
            margin-left: 12px;
        }

        .info_text_bottom .row-1 {
            display: inline-block;
            width: 2000px;
            margin-top: 30px;
            margin-left: -293px;
        }

        .info_text_bottom .row-2 {
            display: inline-block;
            width: 2000px;
            margin-top: 0px;
            margin-left: -293px;
        }

        .by-signing .signatures {
            margin-top: 40px;
            margin-left: -110px;
        }

        .by-signing .signatures .value {
            position: absolute;
            z-index: 999;
            margin-top: -40px;
            margin-left: 60px;
        }

        .by-signing .dates {
            margin-top: -10px;
            margin-left: 190px;
        }

        .by-signing .dates .value {
            margin-top: -25px;
            margin-left: -35px;
        }

        .tbf-title {
            position: absolute;
            margin-left: -150px;
            margin-top: 37px;
        }

        .to-be-filled .title-labels {
            position: absolute;
            margin-top: 58px;
            margin-left: -290px;
        }

        .to-be-filled .title-labels .title-1 {
            position: absolute;
            margin-left: 20px;
        }

        .to-be-filled .title-labels .title-2 {
            position: absolute;
            margin-left: 290px;
        }

        .to-be-filled .title-labels .title-3 {
            position: absolute;
            margin-left: 500px;
        }

        .signature-labels {
            margin-top: 95px;
            margin-left: -300px;
        }

        .sig-1 {
            margin-left: 20px;
        }

        .date-sig-1 {
            margin-top: 2px;
            margin-left: 190px;
        }

        .sig-2 {
            margin-left: 262px;
        }

        .date-sig-2 {
            margin-top: 2px;
            margin-left: 432px;
        }

        .sig-3 {
            margin-left: 20px;
            margin-left: 502px;
        }

        .date-sig-3 {
            margin-top: 2px;
            margin-left: 682px;
        }

        .value_sign {
            margin-top: -65px;
            margin-left: 50px;
            font-family: 'Authentic';
            font-size: 30px;
        }

        .value_name {
            margin-top: -30px;
            margin-left: 45px;
            font-size: 20px;
        }

        .sign {
            margin-top: -40px;
            margin-left: 70px;
            font-family: 'Authentic';
            font-size: 20px;
        }
    </style>
</head>

<body>
    <div class="pdf-container">
        <img src="{{ public_path().'/assets/pdf/member-form-base.svg' }}" width="100%" alt="UPPFI">
    </div>
    <div class="text-container">
        <div class="top-text">
            <label class="title white">Membership Application Form</label>
            <label class="info_text black">Please write using BLOCK or CAPITAL LETTERS. Accomplish and submit one (1) copy</label>
        </div>
        <!-- <label class="p-lastname_value  value-font"><pre>{{ print_r($member) }}</pre></label> -->
        <div class="personal-details">
            <label class="title white main_title">PERSONAL DETAILS</label>
            <!-- {{print_r($member)}} -->
            <div class="lastname">
                <label class="p-lastname title-font ">LAST NAME</label>
                <label class="p-lastname_value  value-font">{{$member->lastname}}</label>
            </div>

            <div class="suffix">
                <label class="p-suffix title-font">SUFFIX <i>(e.g.,JR.,SR.,IV)</i></label>
                <label class="p-suffix_value value-font">{{$member->suffix == ""? "N/A" : $member->suffix }}</label>
            </div>

            <div class="first_name">
                <label class="p-firstname title-font">FIRST NAME</label>
                <label class="p-firstname_value  value-font">{{$member->firstname}}</label>
            </div>

            <div class="middle_name">
                <label class="p-middlname title-font">MIDDLE NAME</label>
                <label class="p-middlename_value  value-font">{{$member->middlename == ""? "N/A" : $member->middlename }}</label>
            </div>

            <div class="date_of_birth" style="margin-left:0px !important; margin-top:27px !important;">
                <label class="p-birth title-font">DATE OF BIRTH</label>

                <label class="p-birth_month title-font">Month</label>
                <label class="p-birth_day title-font">Day</label>
                <label class="p-birth_year title-font">Year</label>

                <label class="p-birth_month_value  value-font">{{ date("F", strtotime($member->date_birth)) }}</label>
                <label class="p-birth_day_value  value-font">{{ date("d", strtotime($member->date_birth)) }}</label>
                <label class="p-birth_year_value  value-font">{{ date("Y", strtotime($member->date_birth)) }}</label>
            </div>

            <div class="sex">
                <label class="p-sex title-font">SEX</label>
                <div class="checkbox_male">
                    <input type="checkbox" {{ $member->gender == 'Male' ? 'checked' : '' }}>

                    <label class="p-male title-font value-font">Male</label>
                </div>

                <div class="checkbox_female">
                    <input type="checkbox" {{ $member->gender == 'Female' ? 'checked' : '' }}>
                    <label class="p-female title-font value-font">Female</label>
                </div>
            </div>

            <div class="civil_status">

                <label class="p-civil_status title-font">CIVIL STATUS</label>

                <div class="checkbox_single">
                    <input type="checkbox" {{ $member->civilstatus == 'Single' ? 'checked' : '' }}>
                    <label class="p-single title-font">Single</label>
                </div>

                <div class="checkbox_married">
                    <input type="checkbox" {{ $member->civilstatus == 'Married' ? 'checked' : '' }}>
                    <label class="p-married title-font">Married</label>
                </div>

                <div class="checkbox_widowed">
                    <input type="checkbox" {{ $member->civilstatus == 'Widowed' ? 'checked' : '' }}>
                    <label class="p-widowed title-font">Widowed
                    </label>
                </div>

                <div class="checkbox_annulled">
                    <input type="checkbox" {{ $member->civilstatus == 'Divorced' ? 'checked' : '' }} {{ $member->civilstatus == 'Registered Partnership' ? 'checked' : '' }}>
                    <label class="p-annulled title-font">Annulled/ Legally
                        Separated</label>
                </div>
            </div>

            <div class="citizenship">
                <label class="p-citizenship title-font">CITIZENSHIP</label>

                <div class="checkbox_filipino">
                    <input type="checkbox" {{ $member->citizenship == 'FILIPINO' ? 'checked' : '' }}>
                    <label class="p-filipino title-font">Filipino</label>
                </div>

                <div class="checkbox_dual_filipino">
                    <input type="checkbox" {{ $member->citizenship == 'DUAL CITIZENSHIP' ? 'checked' : '' }}>
                    <label class="p-dual_filipino title-font">Dual (Filipino and______________ )</label>
                    <label class="p-dual_filipino_value value-font">{{ $member->citizenship == 'DUAL CITIZENSHIP' ? $member->dual_citizenship : '' }}</label>
                </div>
                <div class="checkbox_others">
                    <input type="checkbox" {{ $member->citizenship == 'OTHERS' ? 'checked' : '' }}>
                    <label class="p-others title-font">Others ( ________________ )</label>
                    <label class="p-others_value value-font">{{ $member->citizenship == 'OTHERS' ? $member->dual_citizenship : '' }}</label>
                </div>
            </div>

            <div class="address">
                <label class="p-address title-font">CITY ADDRESS / CURRENT HOME ADDRESS </label>
                <label class="p-address_value value-font" style="font-size:9px;">{{$member->present_bldg_street}} {{ $member->present_barangay}} {{ $member->present_municipality}}
                    {{ $member->present_province}} {{$member->present_zipcode}}</label>
            </div>

            <div class="cellphone">
                <label class="p-cellphone title-font">CELLPHONE NO. </label>
                <label class="p-cellphone_value value-font">{{$member->contact_no}} </label>
            </div>

            <div class="landline">
                <label class="p-cellphone title-font">LANDLINE NO. </label>
                <label class="p-cellphone_value value-font">{{$member->landline_no}} </label>
            </div>

            <div class="permanent_address">
                <label class="p-address title-font">PERMANENT ADDRESS<i> (If different from above) </i></label>
                <label class="p-address_value value-font">{{$member->bldg_street}} {{ $member->barangay}} {{ $member->municipality}} {{ $member->province}} {{$member->zipcode}}</label>
            </div>

            <div class="email_address">
                <label class="p-email_address title-font">EMAIL ADDRESS</label>
                <label class="p-email_address_value value-font">{{$member->email}} </label>

            </div>

        </div>


    </div>

    <div class="employment-details">
        <label class="title white main_title">EMPLOYMENT DETAILS</label>

        <div class="univ">
            <label class="e-univ_tltle title-font">UP CAMPUS / UNIT / CONSTITUENT UNIVERSITY</label>
            <div class="e-univ_value value-font">
                <div class="col-1">
                    <div class="choices">
                        <input type="checkbox" {{ $member->campus_key == 'UPB' ? 'checked' : '' }}>
                        <label class="title-font">Baguio</label>
                    </div>
                    <div class="choices">
                        <input type="checkbox" {{ $member->campus_key == 'UPD' ? 'checked' : '' }}>
                        <label class="title-font">Diliman</label>
                    </div>
                    <div class="choices">
                        <input type="checkbox" {{ $member->campus_key == 'SYSAD' ? 'checked' : '' }}>
                        <label class="title-font">System Admin</label>
                    </div>
                </div>

                <div class="col-2">
                    <div class="choices">
                        <input type="checkbox" {{ $member->campus_key == 'UPM' ? 'checked' : '' }}>
                        <label class="title-font">Manila</label>
                    </div>
                    <div class="choices">
                        <input type="checkbox" {{ $member->campus_key == 'PGH' ? 'checked' : '' }}>
                        <label class="title-font">PGH</label>
                    </div>
                </div>

                <div class="col-3">
                    <div class="choices">
                        <input type="checkbox" {{ $member->campus_key == 'UPLB' ? 'checked' : '' }}>
                        <label class="title-font">Los Baños</label>
                    </div>
                    <div class="choices">
                        <input type="checkbox" {{ $member->campus_key == 'UPOU' ? 'checked' : '' }}>
                        <label class="title-font">Open University</label>
                    </div>
                </div>

                <div class="col-4">
                    <div class="choices">
                        <input type="checkbox" {{ $member->campus == 'UPC' ? 'checked' : '' }}>
                        <label class="title-font">Cebu</label>
                    </div>
                    <div class="choices">
                        <input type="checkbox" {{ $member->campus == 'UPMIN' ? 'checked' : '' }}>
                        <label class="title-font">Mindanao</label>
                    </div>
                    <div class="choices">
                        <input type="checkbox" {{ $member->campus == 'UPV' ? 'checked' : '' }}>
                        <label class="title-font">Visayas</label>
                    </div>
                </div>
                <div class="col-5">
                    <div class="choices">
                        <input type="checkbox" {{ $member->classification == 'ADMIN STAFF' ? 'checked' : '' }}>
                        <label class="title-font"> Admin Staff</label>
                    </div>
                    <div class="choices">
                        <input type="checkbox" {{ $member->classification == 'FACULTY' ? 'checked' : '' }}>
                        <label class="title-font">Faculty</label>
                    </div>
                </div>

                <div class="col-6">
                    <div class="choices">
                        <input type="checkbox" {{ $member->classification == 'REPS' ? 'checked' : '' }}>
                        <label class="title-font"> REPS</label>
                    </div>
                    <div class="choices">
                        <input type="checkbox" {{ $member->classification_others != '' ? 'checked' : '' }}>
                        <label class="title-font">Others</label>
                        <label class="choices_others_value">{{ $member->classification_others != ''  ? 
                             $member->classification_others : '_____________' }}</label>
                    </div>
                </div>
            </div>

            <div class="emp_class">
                <label class="e-emp_class title-font">EMPLOYEE CLASSIFICATION</label>
                <label class="e-emp_class_value value-font"></label>
            </div>

            <div class="emp_no">
                <label class="e-emp_no title-font">EMPLOYEE NO</label>
                <div class="e-emp_no_value value-font">{{$member->employee_no}}</div>
            </div>

            <div class="college_unit">
                <label class="e-college_unit title-font">COLLEGE / UNIT</label>
                <label class="e-college_unit_value value-font">{{$member->college_unit_name}}</label>
            </div>

            <div class="department">
                <label class="e-department title-font">DEPARTMENT</label>
                <label class="e-department_value value-font">{{$member->department_name}}</label>
            </div>

            <div class="academic_rank">
                <label class="e-academic_rank title-font">ACADEMIC RANK / POSITION</label>
                <label class="e-academic_rank_value value-font">{{$member->rank_position}}</label>
            </div>
            <div class="status_appointment">
                <label class="e-status_appointment title-font">STATUS APPOINTMENT</label>
                <div class="col-1">
                    <div class="choices">
                        <input type="checkbox" {{ $member->appointment_name == 'PERMANENT' ? 'checked' : '' }}>
                        <label class="title-font"> Permanent</label>
                    </div>
                    <div class="choices">
                        <input type="checkbox" {{ $member->appointment_name == 'TEMPORARY' ? 'checked' : '' }}>
                        <label class="title-font">Temporary</label>
                    </div>
                </div>
                <div class="col-2">
                    <div class="choices">
                        <input type="checkbox" {{ $member->appointment_name == 'CONTRACTUAL' ? 'checked' : '' }}>
                        <label class="title-font"> Contractual</label>
                    </div>
                    <div class="choices">
                        <input type="checkbox" {{ $member->appointment_name == 'OTHERS' || $member->appointment_name != 'PERMANENT'
                            || $member->appointment_name != 'TEMPORARY' || $member->appointment_name != 'CONTRACTUAL' ? 'checked' : '' }}>
                        <label class="title-font">Others</label>
                        <label class="choices_others_value value-font">{{ $member->appointment_name != 'OTHERS' || $member->appointment_name != 'PERMANENT'
                            || $member->appointment_name != 'TEMPORARY' || $member->appointment_name != 'CONTRACTUAL'
                             ?  $member->appointment_name : '_____________' }}</label>
                    </div>
                </div>

                <div class="date_of_appointment">
                    <label class="e-date_of_appointment title-font">DATE OF APPOINTMENT</label>
                    <div class="e-dop_date">
                        <div class="e-dop_date_titles">
                            <label class="e-dop_date_month  title-font">Month</label>
                            <label class="e-dop_date_day  title-font">Day</label>
                            <label class="e-dop_date_year  title-font">Year</label>
                        </div>

                        <div class="e-dop_date_value">
                            <label class="e-dop_date_month_value  value-font">{{ date("F", strtotime($member->date_appointment)) }}</label>
                            <label class="e-dop_date_day_value  value-font">{{ date("d", strtotime($member->date_appointment)) }}</label>
                            <label class="e-dop_date_year_value  value-font">{{ date("Y", strtotime($member->date_appointment)) }}</label>
                        </div>

                    </div>
                </div>

                <div class="salary_grade">
                    <label class="e-s_grade_title  title-font">SALARY GRADE</label>
                    <label class="e-s_grade_value  value-font"> {{$member->salary_grade}}</label>
                </div>
                <div class="monthly_salary">
                    <label class="e-monthly_salary  title-font">MONTHLY SALARY</label>
                    <label class="e-monthly_salary_value value-font">{{ number_format($member->monthly_salary, 2, '.', ',') }}</label>
                </div>
                <div class="tin_id">
                    <label class="e-tin_id  title-font">TAXPAYER ID NO. (TIN)</label>
                    <label class="e-tin_id_value value-font"> {{$member->tin_no}}</label>
                </div>
            </div>

        </div>


        <div class="membership-details">
            <label class="title white main_title">MEMBERSHIP DETAILS</label>
            <div class="monthly_contrib">

                <label class="md-title title-font">
                    MONTHLY CONTRIBUTION
                </label>
                <div class="info_text">
                    <label class="row-1">(Contribution will be deducted from your salary every month; Choose between: (a) Percentage of basic salary, minimum of 1%; or (b) Fixed amount;</label>
                    <label class="row-2">You may change this anytime by filling out the Member’s Data Updating Form; Amount is subject to the DBM rule on net take-home pay threshold.)</label>
                </div>

                <div class="percentage">
                    <div class="col-1">
                        <input type="checkbox" {{ $member->contribution_set == 'Percentage of Basic Salary' ? 'checked' : '' }}>
                        <label class="a-text title-font">

                            A. Percentage of Basic Salary (Between 1% and 100%)
                        </label>

                        <label class="value value-font">{{ $member->contribution_set == 'Percentage of Basic Salary' ? $member->percentage : '' }}% </label>
                    </div>

                    <div class="col-2">
                        <label class="or-text title-font">
                            OR
                        </label>
                    </div>

                    <div class="col-3">
                        <input type="checkbox" {{ $member->contribution_set == 'Fixed Amount' ? 'checked' : '' }}>
                        <label class="b-text title-font">
                            B. Fixed Amount (in Philippine Peso):
                        </label>
                        <label class="value value-font">PHP {{ $member->contribution_set == 'Fixed Amount' ? number_format($member->amount, 2, '.', ',') : '' }}</label>
                    </div>
                </div>

                <div class="benificiary">
                    <label class="md-title title-font">
                        MONTHLY CONTRIBUTION
                    </label>
                    <div class="info_text">
                        <label class="row-1">(Those who will receive the fund benefits in case of the member’s death; Please use additional sheet if necessary; If left blank, benefits shall be</label>
                        <label class="row-2">divided among heirs in accordance with the New Family Code.)</label>
                    </div>
                    <!-- <pre>{{ print_r($benificiary) }}</pre> -->
                    <div class="b-table">
                        @if(count($benificiary) > 0)
                        @php
                        $count = 1;
                        @endphp
                        @foreach($benificiary as $ben)
                        @if($count == 1)
                        <!-- <div class="col-{{ $count }}"> -->
                        <div class="col-1">
                            <div class="title">
                                <label class="no_1 title-font">{{ $count }}</label>
                                <label class="full_name title-font">Full Name</label>
                                <label class="full_name_value value-font" style="margin-top:18px;">{{ $ben->fullname }}</label>
                                <label class="date_of_birth title-font">Date of Birth </label>
                                <label class="date_of_birth_value value-font">{{ $ben->date_birth }} </label>
                                <label class="relationship title-font">Relationship </label>
                                <label class="relationship_value value-font">{{ $ben->relationship }} </label>

                                @elseif($count == 2)
                                <label class="no_2 title-font" style="margin-top:55px;">{{ $count }}</label>
                                <label class="full_name_value value-font" style="margin-top:47px;">{{ $ben->fullname }}</label>
                                <label class="date_of_birth_value value-font" style="margin-top:55px;">{{ $ben->date_birth }} </label>
                                <label class="relationship_value value-font" style="margin-top:55px;">{{ $ben->relationship }} </label>
                            </div>
                        </div>
                        @elseif($count == 3)
                        <div class="col-2">
                            <div class="title">
                                <label class="no_1 title-font">{{ $count }}</label>
                                <label class="full_name title-font">Full Name</label>
                                <label class="full_name_value value-font" style="margin-top:18px;">{{ $ben->fullname }}</label>
                                <label class="date_of_birth title-font">Date of Birth </label>
                                <label class="date_of_birth_value value-font">{{ $ben->date_birth }} </label>
                                <label class="relationship title-font">Relationship </label>
                                <label class="relationship_value value-font">{{ $ben->relationship }} </label>
                                @elseif($count == 4)
                                <label class="no_2 title-font" style="margin-top:47px;">{{ $count }}</label>
                                <label class="full_name_value value-font" style="margin-top:49px;">{{ $ben->fullname }}</label>
                                <label class="date_of_birth_value value-font" style="margin-top:47px;">{{ $ben->date_birth }} </label>
                                <label class="relationship_value value-font" style="margin-top:47px;">{{ $ben->relationship }} </label>
                            </div>
                        </div>
                        @elseif($count > 4)
                        @break
                        @else
                    </div>
                </div>
                @endif
                <!-- @if($count > 2)
                        <div class="col-{{ $count }}">
                            <div class="title">
                                <label class="no_{{ $count }} title-font">{{ $count }}</label>
                                <label class="full_name title-font">Full Name</label>
                                <label class="full_name_value value-font">{{ $ben->fullname }}</label>
                                <label class="date_of_birth title-font">Date of Birth </label>
                                <label class="date_of_birth_value value-font">{{ $ben->date_birth }} </label>
                                <label class="relationship title-font">Relationship </label>
                                <label class="relationship_value value-font">{{ $ben->relationship }} </label>
                            </div>
                        </div>
                    @endif -->
                @php
                $count++;
                @endphp

                @endforeach

                @else
                <div class="col-1">
                    <div class="title">
                        <label class="no_1 title-font">1</label>

                        <label class="full_name title-font">Full Name</label>
                        <label class="full_name_value value-font"></label>

                        <label class="date_of_birth title-font">Date of Birth </label>
                        <label class="date_of_birth_value value-font"> </label>

                        <label class="relationship title-font">Relationship </label>
                        <label class="relationship_value value-font"> </label>


                        <label class="no_2 title-font">2</label>
                        <label class="full_name_value value-font" style="margin-top:47px;">
                        </label>

                        <label class="date_of_birth_value value-font" style="margin-top:47px;"> </label>

                        <label class="relationship_value value-font" style="margin-top:47px;"> </label>
                    </div>
                </div>

                <div class="col-2">
                    <div class="title">
                        <label class="no_1 title-font">3</label>

                        <label class="full_name title-font">Full Name</label>
                        <label class="full_name_value value-font"></label>

                        <label class="date_of_birth title-font">Date of Birth </label>
                        <label class="date_of_birth_value value-font"> </label>

                        <label class="relationship title-font">Relationship </label>
                        <label class="relationship_value value-font"> </label>


                        <label class="no_2 title-font">4</label>
                        <label class="full_name_value value-font" style="margin-top:47px;">
                        </label>

                        <label class="date_of_birth_value value-font" style="margin-top:47px;"> </label>

                        <label class="relationship_value value-font" style="margin-top:47px;"> </label>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="by-signing">
        <div class="info_text_bottom">
            <label class="row-1">By signing this form, I hereby certify that all information provided above are true, accurate, and complete. I also consent to the</label>
            <label class="row-2">collection, recording, use, processing, storage, and retention of my personal data by UP Provident Fund for the purpose of my</label>
            <label class="row-2">membership with the Fund, subject to RA 10173 (“Data Privacy Act”). I authorize the company to disclose relevant personal</label>
            <label class="row-2">information to third parties only as necessary for the processing and execution of regular membership transactions (e.g., loans</label>
            <label class="row-2">disbursement, insurance application and claims processing, etc.) or as legally required by existing laws, ordinances, or regulations.</label>
        </div>
        <div class="signatures">
            <label for="e-sig">
                <label class="value_sign value-font">{{ $member->sign }}</label>
                <label class="value_name value-font">{{ $member->sign }}</label>
                <label class="title title-font">SIGNATURE OVER PRINTED NAME</label>
            </label>
        </div>

        <div class="dates">
            <label class="value value-font-date">{{ date("F d, Y", strtotime($member->date_accomplished)) }}</label>
            <label class="title title-font">DATE</label>
        </div>
    </div>

    <div class="to-be-filled">
        <label class="tbf-title main_title white">
            To be filled out by UP Provident Fund and UP HRDO Personnel
        </label>

        <div class="title-labels">
            <label class="title-1 title-font" style="font-size:8.5px !important;">Received and checked by: UP PROVIDENT STAFF</label>
            <label class="title-2 title-font" style="font-size:8.5px !important;">Verified by: UP HRDO DIRECTOR</label>
            <label class="title-3 title-font" style="font-size:8.5px !important;">Approved by: UP PROVIDENT FUND MANAGER</label>
        </div>
        <div class="signature-labels">
            <label class="sign value-font">{{ isset($AA_signatory->full_name) ? $AA_signatory->full_name : '' }}</label>
            <label class="value-font" style="margin-top:-15px; margin-left:70px;">{{ isset($AA_signatory->full_name) ? $AA_signatory->full_name : '' }}</label>
            <label class="sig-1 title-font">Signature over Printed Name</label>
            <img class="img-sig-1" src="" alt="">
            <label class="date-sig-1 title-font">Date</label>

            <label class="sign value-font" style="margin-left:270px;">{{ isset($HRDO_signatory->full_name) ? $HRDO_signatory->full_name : '' }}</label>
            <label class="value-font" style="margin-top:-15px; margin-left:270px;">{{ isset($HRDO_signatory->full_name) ? $HRDO_signatory->full_name : '' }}</label>
            <label class="sig-2 title-font">Signature over Printed Name</label>
            <img class="img-sig-2" src="" alt="">
            <label class="date-sig-2 title-font">Date</label>

            <label class="sign value-font" style="margin-left:520px;">{{ isset($FM_signatory->full_name) ? $FM_signatory->full_name : '' }}</label>
            <label class="value-font" style="margin-top:-15px; margin-left:520px;">{{ isset($FM_signatory->full_name) ? $FM_signatory->full_name : '' }}</label>
            <label class="sig-3 title-font">Signature over Printed Name</label>
            <img class="img-sig-3" src="" alt="">
            <label class="date-sig-3 title-font">Date</label>
        </div>
    </div>


    </div>
    </div>
</body>

</html>