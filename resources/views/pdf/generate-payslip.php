<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Proxy Form</title>
    <style>
        /* Define your custom font */


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

        .details-text {
            margin-top: 2px;
        }
    </style>
</head>

<body>
    <div class="logo">
        <img src="{{ storage_path('/assets/pdf/axa-form-base.jpg) }}" width="15%" alt="UPPFI">
        <!-- <img src="{!! asset('assets/images/bg-member.png') !!}" style=" width: 70%;" alt="UPPFI"> -->
        <h2>LOAN INFO SLIP</h2>
    </div>

    <div>


        <b style="float:right;">DATE FILED: 06/25/2020 03:18 PM</b>
        <br>
        <b>MEMBER DETAILS</b>
        <br><br>
        <div class="details-text">
            <label> <b>Name: </b>GARCIA, MARIA SANTOS</label>
        </div>
        <div class="details-text">
            <label> <b>UPPFI Member's ID No.: </b>200363202</label>
        </div>
        <div class="details-text">
            <label> <b>Campus: </b>UPB</label>
        </div>
        <div class="details-text">
            <label> <b>Unit: </b>ACCOUNTING OFFICE</label>
        </div>
        <div class="details-text">
            <label> <b>Employee No.: </b>123456789 </label>
        </div>
        <div class="details-text">
            <label> <b>Active Mobile Number: </b>09262586168</label>
        </div>

        <div class="details-text">
            <label> <b> Active Email Address:</b>garcia@gmail.com</label>
        </div>

        <br><br>
        <b>LOAN DETAILS</b>
        <br><br>
        <div class="details-text">
            <label> <b>Loan Application No.: </b>1-2020-06-00003</label>
        </div>
        <div class="details-text">
            <label> <b>Loan Type: </b>Personal Equity Loan</label>
        </div>
        <div class="details-text">
            <label> <b>New or Renewal: </b>RENEW</label>
        </div>
        <div class="details-text">
            <label> <b>Renewal Type:</b>FULL EQUITY</label>
        </div>
        <div class="details-text">
            <label> <b>Bank: </b>DEVELOPMENT BANK OF THE PHILIPPINES </label>
        </div>
        <div class="details-text">
            <label> <b>Account Number</b>123456789</label>
        </div>

        <div class="details-text">
            <label> <b> Account Name: </b>Re-Loan test</label>
        </div>
    </div>
    <br>

</body>

</html>