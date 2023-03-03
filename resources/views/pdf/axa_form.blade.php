<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Axa Form</title>
    <style>
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
    </style>
</head>

<body>
    <div class="pdf-container">
        <img src="{{ public_path().'/assets/pdf/axa-form-base.jpg' }}" width="100%" alt="UPPFI">
    </div>
    <div class="value-container">
        <div class="col-1">
            <label class="lastname_value">gomez</label>
            <label class="firstname_value">mark</label>
            <label class="middlename_value">ramirez</label>
        </div>
        <div class="col-2">
            <label class="sex_value">male</label>
            <label class="civilstatus_value" style="margin-left:37px;">single</label>
            <label class="dob_value" style="margin-left:30px;">05/06/1999</label>
            <label class="age" style="margin-left:100px;">72</label>
            <label class="pob_value" style="margin-left:35px; font-size:10px;">Nueva Ecija</label>
            <label class="nationality_value" style="margin-left:120px;">Filipino</label>


        </div>
        <div class="col-3">
            <label class="address_value">Purok 5 Sapang Jaen Nueva Ecija</label>

        </div>
        <div class="col-4">
            <label class="email_value">markdennebg@gmail.com</label>
            <label class="contactNo_value" style="margin-left:100px;">092626266262</label>
            <label class="mobileNo_value" style="margin-left:160px;">092626266262</label>
        </div>
        <div class="col-5">
            <label class="lastname_value">gomez</label>
            <label class="firstname_value">mark</label>
            <label class="middlename_value">ramirez</label>
        </div>
        <div class="col-6">
            <label class="">spouse name</label>
            <label class="" style="margin-left:285px">maiden name</label>
        </div>
        <div class="col-7">
            <input type="radio" style="margin-left:103px;" checked>
            <input type="radio" style="margin-left:192px;" checked>
            <input type="radio" style="margin-left:325px;" checked>
            <input type="radio" style="margin-left:528px;" checked>
            <input type="radio" style="margin-left:608px;" checked>
        </div>
        <div class="col-8">
            <label class="">gomez</label>
            <label class="" style="margin-left:200px;">mark</label>
            <label class="" style="margin-left:206px;">ramirez</label>
        </div>
        <div class="col-9">
            <label class="">gomez</label>
            <label class="" style="margin-left:200px;">mark</label>
            <label class="" style="margin-left:206px;">ramirez</label>
        </div>

        <div class="col-10" style="font-size:11px;">
            <div class="col-1">
                <label class="b_lastname_value">
                    lastname value
                </label>
                <label class="b_firstname_value" style="margin-left:40px;">
                    firstname value
                </label>
                <label class="b_initials_value" style="margin-left:35px;">
                    Dg
                </label>
                <label class="b_dob_value" style="margin-left:12px;">
                    05/06/1999
                </label>
                <label class="b_relationship_value" style="margin-left:10px;">
                    Daugther
                </label>
                <label class="b_benifit_value" style="margin-left:50px;">
                    benifit value
                </label>
                <label class="b_primary_value" style="margin-left:8px;">
                    primary
                </label>
                <label class="b_secondary_value" style="margin-left:8px;">
                    secondary
                </label>
                <label class="b_revocable_value" style="margin-left:5px;">
                    revocable
                </label>
                <label class="b_irrevocable_value" style="margin-left:2px;">
                    irrevocable
                </label>

            </div>
            <div class="col">
                <label class="b_lastname_value">
                    lastname value
                </label>
                <label class="b_firstname_value" style="margin-left:40px;">
                    firstname value
                </label>
                <label class="b_initials_value" style="margin-left:35px;">
                    Dg
                </label>
                <label class="b_dob_value" style="margin-left:12px;">
                    05/06/1999
                </label>
                <label class="b_relationship_value" style="margin-left:10px;">
                    Daugther
                </label>
                <label class="b_benifit_value" style="margin-left:50px;">
                    benifit value
                </label>
                <label class="b_primary_value" style="margin-left:8px;">
                    primary
                </label>
                <label class="b_secondary_value" style="margin-left:8px;">
                    secondary
                </label>
                <label class="b_revocable_value" style="margin-left:5px;">
                    revocable
                </label>
                <label class="b_irrevocable_value" style="margin-left:2px;">
                    irrevocable
                </label>

            </div>

            <div class="col">
                <label class="b_lastname_value">
                    lastname value
                </label>
                <label class="b_firstname_value" style="margin-left:40px;">
                    firstname value
                </label>
                <label class="b_initials_value" style="margin-left:35px;">
                    Dg
                </label>
                <label class="b_dob_value" style="margin-left:12px;">
                    05/06/1999
                </label>
                <label class="b_relationship_value" style="margin-left:10px;">
                    Daugther
                </label>
                <label class="b_benifit_value" style="margin-left:50px;">
                    benifit value
                </label>
                <label class="b_primary_value" style="margin-left:8px;">
                    primary
                </label>
                <label class="b_secondary_value" style="margin-left:8px;">
                    secondary
                </label>
                <label class="b_revocable_value" style="margin-left:5px;">
                    revocable
                </label>
                <label class="b_irrevocable_value" style="margin-left:2px;">
                    irrevocable
                </label>

            </div>

            <div class="col">
                <label class="b_lastname_value">
                    lastname value
                </label>
                <label class="b_firstname_value" style="margin-left:40px;">
                    firstname value
                </label>
                <label class="b_initials_value" style="margin-left:35px;">
                    Dg
                </label>
                <label class="b_dob_value" style="margin-left:12px;">
                    05/06/1999
                </label>
                <label class="b_relationship_value" style="margin-left:10px;">
                    Daugther
                </label>
                <label class="b_benifit_value" style="margin-left:50px;">
                    benifit value
                </label>
                <label class="b_primary_value" style="margin-left:8px;">
                    primary
                </label>
                <label class="b_secondary_value" style="margin-left:8px;">
                    secondary
                </label>
                <label class="b_revocable_value" style="margin-left:5px;">
                    revocable
                </label>
                <label class="b_irrevocable_value" style="margin-left:2px;">
                    irrevocable
                </label>

            </div>
            <div class="col">
                <label class="b_lastname_value">
                    lastname value
                </label>
                <label class="b_firstname_value" style="margin-left:40px;">
                    firstname value
                </label>
                <label class="b_initials_value" style="margin-left:35px;">
                    Dg
                </label>
                <label class="b_dob_value" style="margin-left:12px;">
                    05/06/1999
                </label>
                <label class="b_relationship_value" style="margin-left:10px;">
                    Daugther
                </label>
                <label class="b_benifit_value" style="margin-left:50px;">
                    benifit value
                </label>
                <label class="b_primary_value" style="margin-left:8px;">
                    primary
                </label>
                <label class="b_secondary_value" style="margin-left:8px;">
                    secondary
                </label>
                <label class="b_revocable_value" style="margin-left:5px;">
                    revocable
                </label>
                <label class="b_irrevocable_value" style="margin-left:2px;">
                    irrevocable
                </label>

            </div>
            <div class="col">
                <label class="b_lastname_value">
                    lastname value
                </label>
                <label class="b_firstname_value" style="margin-left:40px;">
                    firstname value
                </label>
                <label class="b_initials_value" style="margin-left:35px;">
                    Dg
                </label>
                <label class="b_dob_value" style="margin-left:12px;">
                    05/06/1999
                </label>
                <label class="b_relationship_value" style="margin-left:10px;">
                    Daugther
                </label>
                <label class="b_benifit_value" style="margin-left:50px;">
                    benifit value
                </label>
                <label class="b_primary_value" style="margin-left:8px;">
                    primary
                </label>
                <label class="b_secondary_value" style="margin-left:8px;">
                    secondary
                </label>
                <label class="b_revocable_value" style="margin-left:5px;">
                    revocable
                </label>
                <label class="b_irrevocable_value" style="margin-left:2px;">
                    irrevocable
                </label>

            </div>
        </div>

        <div class="signature">
            <div class="col-1">
                <img src="{{ public_path().'/assets/images/uppfi-logo.png' }}" width="50px" height="50px" alt="UPPFI">
                <br>
                <label>Printed Name</label>
            </div>

            <div class="col-2">
                <!-- <img src="{{ public_path().'/assets/images/uppfi-logo.png' }}" width="50px" height="50px" alt="UPPFI">
                <br> -->
                <label>05/06/1999</label>
            </div>
        </div>
    </div>



</body>

</html>