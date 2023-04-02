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
            margin-top: 128px;
        }

        .col-1 .firstname_value {
            margin-left: 200px;
            font-family: 'Fira Sans', sans-serif;
        }

        .col-1 .middlename_value {
            margin-left: 207px;
        }

        .col-2 {
            margin-top: 45px;
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

        .absolute {
            position: absolute;
        }

        .gg-check {
            box-sizing: border-box;
            position: relative;
            display: block;
            transform: scale(var(--ggs, 1));
            width: 22px;
            height: 22px;
            border: 2px solid transparent;
            border-radius: 100px
        }

        .gg-check::after {
            content: "";
            display: block;
            box-sizing: border-box;
            position: absolute;
            left: 3px;
            top: -1px;
            width: 6px;
            height: 10px;
            border-width: 0 2px 2px 0;
            border-style: solid;
            transform-origin: bottom left;
            transform: rotate(45deg)
        }
    </style>
</head>

<body>

    <div class="pdf-container">
        <img src="{{ public_path().'/assets/pdf/axa-form-base.jpg' }}" width="100%" alt="UPPFI">
    </div>
    <div class="value-container">
        <div class="col-1">
            <label class="lastname_value absolute " style="font-size:10px;">{{$member->lastname}}</label>
            <label class="firstname_value absolute " style="margin-left:240px; font-size:10px;">{{$member->firstname}}</label>
            <label class="middlename_value absolute " style="margin-left:480px; font-size:10px;">{{$member->middlename == ""? "N/A" : $member->middlename}} </label>
        </div>
        <div class="col-2">
            <label class="sex_value absolute " style="font-size:10px;">{{$member->gender}}</label>
            <label class="civilstatus_value absolute " style="margin-left:65px; font-size:10px;">{{$member->civilstatus}}</label>
            <label class="dob_value absolute " style="margin-left:135px; font-size:10px;">{{ date('m/d/Y', strtotime($member->date_birth)) }}</label>
            <label class="age absolute " style="margin-left:290px; font-size:10px;">{{ \Carbon\Carbon::parse($member->date_birth)->age }}</label>
            <label class="pob_value absolute " style="margin-left:355px; font-size:10px;">{{$axa_info->place_birth}}</label>
            <label class="nationality_value absolute " style="margin-left:525px; font-size:10px;">{{$member->citizenship}}</label>


        </div>
        <div class="col-3" style="margin-top:42px;">
            <label class="address_value absolute " style="font-size:10px;">{{$member->bldg_street}} {{ $member->barangay}} {{ $member->municipality}} {{ $member->province}} {{$member->zipcode}}</label>

        </div>
        <div class="col-4" style="margin-top:42px;">
            <label class="email_value absolute " style="font-size:10px;">{{$member->email}}</label>
            <label class="contactNo_value absolute " style="margin-left:245px; font-size:10px;">{{$axa_info->contact_no}}</label>
            <label class="mobileNo_value absolute " style="margin-left:485px; font-size:10px;">{{$axa_info->contact_no}}</label>
        </div>
        <div class="col-5" style="margin-top:45px;">
            <label class="lastname_value absolute " style="font-size:10px;">{{$member->emp_union_assoc}}</label>
            <label class="firstname_value absolute " style="margin-left:245px; font-size:10px;">{{$axa_info->occupation}}</label>
            <label class="middlename_value absolute " style="margin-left:400px; font-size:10px;">{{$member->tin_no}}</label>
            <label class="middlename_value absolute " style="margin-left:560px; font-size:10px;">{{$axa_info->sss_gsis}}</label>
        </div>
        <div class="col-6" style="margin-top:42px;">
            <label class=" absolute " style="font-size:10px;">{{$axa_info->spouse_name}}</label>
            <label class=" absolute " style="margin-left:362px; font-size:10px;">{{$axa_info->maiden_name}}</label>
        </div>
        <div class="col-7" style="margin-top:24px;">

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
        <div class="col-8" style="margin-top:68px;">
            <label class=" absolute " style="font-size:10px;">{{$axa_info->last_name}}</label>
            <label class=" absolute " style="margin-left:245px; font-size:10px;">{{$axa_info->first_name}}</label>
            <label class=" absolute " style="margin-left:478px; font-size:10px;">{{$axa_info->middle_name}}</label>
        </div>
        <div class="col-9" style="margin-top:42px;">
            <label class=" absolute " style="font-size:10px;">{{$axa_info->relationship_tomember}}</label>
            <label class=" absolute " style="margin-left:240px; font-size:10px;">{{$axa_info->contact_no}}</label>
            <label class=" absolute " style="margin-left:480px; font-size:10px;">{{$axa_info->email_add}}</label>
        </div>

        <div class="col-10" style="font-size:8px;  margin-top:65px;">
            @foreach($benificiary as $key => $ben)
            <div class="col" style="margin-top:26px;">
                <label class=" absolute b_lastname_value">
                    {{ $ben->last_name }}
                </label>
                <label class=" absolute b_firstname_value" style="margin-left:110px;">
                    {{ $ben->first_name }}
                </label>
                <label class=" absolute b_initials_value" style="margin-left:218px;">
                    {{ $ben->middle_name }}
                </label>
                <label class=" absolute b_dob_value" style="margin-left:258px;">
                    {{ $ben->date_of_bday }}
                </label>
                <label class=" absolute b_relationship_value" style="margin-left:325px;">
                    {{ $ben->ben_relationship }}
                </label>
                <label class=" absolute b_benifit_value" style="margin-left:435px;">
                    {{ $member->percentage }} %
                </label>
                <label class=" absolute b_primary_value" style="margin-left:510px;">
                    <span class="{{ $ben->insured_type == 'PRIMARY' ? 'gg-check' : '' }}"></span>
                </label>
                <label class=" absolute b_secondary_value" style="margin-left:569px;">
                    <span class="{{ $ben->insured_type == 'SECONDARY' ? 'gg-check' : '' }}"></span>
                </label>
                <label class=" absolute b_revocable_value" style="margin-left:625px;">
                    <span class="{{ $ben->according_rights == 'REVOCABLE' ? 'gg-check' : '' }}"></span>
                </label>
                <label class=" absolute b_irrevocable_value" style="margin-left:675px;">
                    <span class="{{ $ben->according_rights == 'IRREVOCABLE' ? 'gg-check' : '' }}"></span>
                </label>

            </div>
            @endforeach
        </div>

        <div class="signature absolute">
            <div class="col-1 absolute" style="margin-top:40px; margin-left:110px;">
                <!-- <img src="{{ asset($member->signature) }}" width="50px" height="50px" alt="UPPFI"> -->
                <div class="absolute" class="absolute" style="margin-top:110px; margin-left:-90px; z-index:10;width:270px;  ">
                    <img src="{{ public_path($axa_info->signature) }}" style=" display:flex; justify-content:center;" width="50px" height="50px" alt="UPPFI">
                </div>

                <br>
                <div class="absolute" style="margin-top:130px; margin-left:-90px; width:270px; ">
                    <label class="" style="display:flex; justify-content:center;">{{ $member->sign }}</label>
                </div>

            </div>

            <div class="col-2 absolute" style="margin-top:0px;">
                <!-- <img src="{{ public_path().'/assets/images/uppfi-logo.png' }}" width="50px" height="50px" alt="UPPFI">
                <br> -->
                <label class="absolute" style="margin-left:212px; margin-top:190px;">{{ date('m/d/Y', strtotime($member->time_stamp_datesigned)) }}</label>
            </div>
        </div>



</body>

</html>