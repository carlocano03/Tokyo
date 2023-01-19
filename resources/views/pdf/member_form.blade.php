<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- <link href="{{ public_path().'/dist/style.css' }}" rel="stylesheet"> -->
    <title>Membership Form</title>

    <style>
        .pdf-container img{
            transform:scale(1.2);
            margin-top:20px;
          
        }
        body {
            font-family: 'Fira Sans', sans-serif;
            font-weight:bold;
          
        
        }

        .text-container {
            position:absolute;
            z-index:10;
            width:100%;
            height:100%;
            left:0px;
            top:0px;
        }

        .black {
            color:black !important;
        }
        .white {
            color:white !important;
        }
        .top-text {
            width:100%;
        }
        .top-text .title {
            position:absolute;
            font-weight:bold;
            font-size:18px;
            left:380px;
            margin-top:-10px;
        }
        
        .top-text .info_text {
            width:500px;
            position:absolute;
            font-size:9px;
            font-style:italic;
            left:320px;
            margin-top:30px;
        }
        .personal-details .title{
            position:absolute;
            font-weight:bold;
            font-size:15px;
            left:300px;
            top:65px;
        }



        /* employment details css */
        .employment-details .title{
            position:absolute;
            font-weight:bold;
            font-size:15px;
            left:287px;
            top:312px;
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

        <div class="personal-details">
             <label class="title white">Personal Details</label>
             <label class="info_text black">Please write using BLOCK or CAPITAL LETTERS. Accomplish and submit one (1) copy</label>
        </div>

        <div class="employment-details">
             <label class="title white">Employment Details</label>
             <label class="info_text black">Please write using BLOCK or CAPITAL LETTERS. Accomplish and submit one (1) copy</label>
        </div>
    </div>
</body>
</html>

<!-- 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ public_path().'/dist/style.css' }}" rel="stylesheet">
    <title>Membership Form</title>

    <style>
        body {
            font-family: 'Fira Sans', sans-serif;
          
            font-size: 14px;
        }
        
        .pdf-container {
            height:100%;
        }
        .first-row {
            width:100%;
            height:250px;
        }

        .second-row {
            width:100%;
            height:200px;
            background-color:yellow;
        }

        .third-row {
            width:100%;
            height:200px;
            background-color:black;
        }

        .fourth-row {
            width:100%;
            height:200px;
            background-color:orange;
        }
        .fifth-row {
            width:100%;
            height:100px;
            background-color:pink;
        }
        .membership_title {
            background-color:black;
            color:white;
            font-size:20px;
            padding:8px;
            margin-right:10px;
            padding-left:50px;
            padding-right:50px;
            font-weight:bold;
            float:right;
        }
        .membership_info {
            font-size:10px;
            font-style:italic;
            float:right;
            margin-right:-390px;
            margin-top:60px;
        }
    </style>
</head>
<body>
    <div class="pdf-container"> 
        <div class="mp-container-fluid">
            <div class="row">
                <div class="first-row">
                    
                    <div class="mp-container">
                        <div class="row">
                            <div class="col-12">
                                 <img src="{{ public_path().'/assets/images/loan_info_logo.png' }}" width="43%" alt="UPPFI">
                                  <label class="membership_title">Membership Application Form</label> 
                                  <label class="membership_info">
                                        Please write using BLOCK or CAPITAL LETTERS. Accomplish and submit one (1) copy.
                                  </label>
                                   
                                    
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
            </div>

            <div class="row">
                <div class="second-row">
                    1
                </div>
            </div>

            <div class="row">
                <div class="third-row">
                    1
                </div>
            </div>

            <div class="row">
                <div class="fourth-row">
                    1
                </div>
            </div>

            <div class="row">
                <div class="fifth-row">
                    1
                </div>
            </div>
        </div>
    </div>
    

    
    
</body>
</html> -->