<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cocolife Application Form</title>
    <style>
        .pdf-container img{
            transform:scale(1.1);
            margin-top:20px;
            margin-left:20px;
            
        }

        .titles {
            font-size:9.5px;
            display:inline-block;
            width:2000px;
    
        }
        .main-title {
            font-family:helvetica;
            font-weight:bold;
        }
        .absolute {
            position:absolute;
            z-index: 2;
            top:0px;
            left:0px;
        }

        .application_title{
            margin-top:117px;
            margin-left:263px;
        }
        .part1_title {
            margin-top:145px;
            margin-left:30px;
        }
        .part2_title {
            margin-top:257px;
            margin-left:30px;
        }
        .part3_title {
            margin-top:415px;
            margin-left:30px;
        }
        .exception_title {
            margin-top:515px;
            margin-left:30px;
        }
        .p-text {
            font-size:11px;
            font-family:helvetica;
            margin-top:550px;
        }
        .p-text .p-1 {
            margin-left:50px;
        }
        .p-text label {
            position:absolute;
            display:inline-block;
            width:2000px;
        }
         .p-text .p-2 {
            margin-top:14px;
         }
         .p-text .p-3 {
            margin-top:28px;
         }
         .p-text .p-4 {
            margin-top:42px;
         }
         
         .p-text2 {
            font-size:11px;
            font-family:helvetica;
            margin-top:80px;
        }
         .p-text2 .p-1 {
            margin-left:20px;
        }
        .p-text2 label {
            position:absolute;
            display:inline-block;
            width:2000px;
        }
         .p-text2 .p-2 {
            margin-top:14px;
         }
         .p-text2 .p-3 {
            margin-top:28px;
            margin-left:70px;
         }
         .p-text2 .p-4 {
            margin-top:42px;
         }
        .p-text2 .p-5 {
            margin-top:56px;
            margin-left:70px;
         }
         .values {
            margin-top:158px;
            font-size:11px;
            font-weight:bold;
            font-family:helvetica;
            margin-left:130px;
         }
         .values label {
            position:absolute;
            display:inline-block;
            width:2000px;
         }
         .residence {
            margin-top:14px;
            margin-left:45px;
         }

         .date_of_birth {
            margin-top:27px;
            margin-left:15px;
         }
          .place_of_birth {
            margin-top:27px;
            margin-left:185px;
         }
         .sex {
            position:absolute;
            margin-top:42px;
            margin-left:-34px;
         }
        .civil_status {
            position:absolute;
            margin-top:42px;
            margin-left:52px;
         }
        .height {
            position:absolute;
            margin-top:42px;
            margin-left:144px;
         }
        .weight {
            position:absolute;
            margin-top:42px;
            margin-left:229px;
         }
         .occupation{
            position:absolute;
            margin-top:55px;
            margin-left:5px;
         } 
         .nature_of_work{
            position:absolute;
            margin-top:55px;
            margin-left:265px;
         } 
         .ifseaman {
            position:absolute;
            margin-top:70px;
            margin-left:63px;
         }
         .ifocw{
            position:absolute;
            margin-top:70px;
            margin-left:353px;
         }
         .amount_of_insurance{
            position:absolute;
            margin-top:0px;
            margin-left:413px;
         }
         .term_of_coverage{
            position:absolute;
            margin-top:14px;
            margin-left:400px;
         }
        .premiums{
            position:absolute;
            margin-top:28px;
            margin-left:365px;
        }
        .telephone_number{
            position:absolute;
            margin-top:42px;
            margin-left:405px;
        }
        .name_values1{
            position:absolute;
            margin-top:314px;
            font-size:11px;
            font-weight:bold;
            font-family:helvetica;
            margin-left:10px;
            display:inline-block;
            width:2000px;
        }
          .name_values2{
            position:absolute;
            margin-top:332px;
            font-size:11px;
            font-weight:bold;
            font-family:helvetica;
            margin-left:10px;
            display:inline-block;
            width:2000px;
        }
          .name_values3{
            position:absolute;
            margin-top:350px;
            font-size:11px;
            font-weight:bold;
            font-family:helvetica;
            margin-left:10px;
            display:inline-block;
            width:2000px;
        }
          .name_values4{
            position:absolute;
            margin-top:365px;
            font-size:11px;
            font-weight:bold;
            font-family:helvetica;
            margin-left:10px;
            display:inline-block;
            width:2000px;
        }
          .name_values5{
            position:absolute;
            margin-top:383px;
            font-size:11px;
            font-weight:bold;
            font-family:helvetica;
            margin-left:10px;
            display:inline-block;
            width:2000px;
        }
        .name {
            position:absolute;
            margin-left:100px;
        }
        .age {
            position:absolute;
            margin-left:295px;
        }
        .relationship {
            position:absolute;
            margin-left:395px;
        }
        .remarks {
            position:absolute;
            margin-left:495px;
        }
        .exceptions {
            position:absolute;
            margin-top:510px;
            font-size:11px;
            font-weight:bold;
            font-family:helvetica;
            margin-left:100px;
            display:inline-block;
            width:2000px;
        }
        .exceptions_value {
            position:absolute;
        }
        .signed_at {
            position:absolute;
            margin-top:755px;
            font-size:11px;
            font-weight:bold;
            font-family:helvetica;
            margin-left:100px;
            display:inline-block;
            width:2000px;
        }
        .signed_at .sig-1 {
            position:absolute;
            margin-left:0px;
        }
         .signed_at .sig-2 {
            position:absolute;
            margin-left:220px;
        }
         .signed_at .sig-3 {
            position:absolute;
            margin-left:310px;
        }
         .signed_at .sig-4 {
            position:absolute;
            margin-left:450px;
        }
        .signatures {
            position:absolute;
            margin-top:760px;
            font-size:11px;
            font-weight:bold;
            font-family:helvetica;
            margin-left:160px;
            display:inline-block;
            width:2000px;
        }
        .signatures .img-1 {
            position:absolute;
        }
        .signatures .img-2 {
            position:absolute;
            margin-left:250px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
     <div class="pdf-container"> 
        <img src="{{ public_path().'/assets/pdf/cocolifeproxyformbase.svg' }}" width="100%" alt="UPPFI">
    </div> 

    <div class="absolute">
       <label  class="titles absolute main-title application_title">APPLICATION FOR GROUP LIFE INSURANCE</label> 
       <label  class="titles absolute main-title part1_title">PART I. APPLICANT'S PERSONAL DATA</label> 
       <label  class="titles absolute main-title part2_title">PART II. BENEFICIARIES</label> 
       <label  class="titles absolute main-title part3_title">PART III. HEALTH DECLARATION</label> 
       <label  class="titles absolute main-title exception_title">EXCEPTIONS:</label> 

       <div class="p-text">
            <label class="p-1">I hereby agree that the above questions and answers shall be considered in lieu of a medical examination as part of my application for</label>
            <label class="p-2">insurance. I hereby declare that all the foregoing answers and statements are complete, true and correct to the best of my knowledge and belief</label>
            <label class="p-3">I hereby agree that if there be any misinterpretation in the above statement material to the risk, United Coconut Planters Life Assurance</label>
            <label class="p-4">Corporation (COCOLIFE) shall have the right to reject and declare such insurance null and void.</label>
       </div>

       <div class="p-text2">
            <label class="p-1">“Disclosure: In accordance with the Insurance Commission’s Circular Letter No. 2016-54, your medical information will be uploaded to a</label>
            <label class="p-2">Medical Information Database accessible to life insurance companies for the purpose of enhancing risk assessment and preventing fraud.</label>
            <label class="p-3">Once uploaded, all Life Insurance companies will only have limited access to your information in order to protect your right to</label>
            <label class="p-4">privacy in accordance with law.</label>
            <label class="p-5">A copy of Circular Letter No. 2016-54 may be accessed at the Insurance Commission’s website at www.insurance.gov.ph.”</label>
       </div>
    </div>

    <div class="absolute">
        <div class="values">
            <label class="fullname"> {{ $member->lastname }}, {{ $member->firstname }} {{ $member->middlename }}</label>
            <label class="residence"><small>{{$member->bldg_street}} {{ $member->barangay}} {{ $member->municipality}} {{ $member->province}} {{$member->zipcode}}</small></label>
            <label class="date_of_birth">{{ $member->date_birth }}</label>
            <label class="place_of_birth">{{ $coco_details->place_birth }}</label>
            <label class="sex">Male</label>
            <label class="civil_status">{{ $member->gender }}</label>
            <label class="height">{{ $coco_details->height }}</label>
            <label class="weight">{{ $coco_details->weight }}</label>
            <label class="occupation">{{ $coco_details->occupation }}</label>
            <label class="nature_of_work">{{ $coco_details->nature_work }}</label>
            <label class="ifseaman">{{ $coco_details->seaman }}</label>
            <label class="ifocw">{{ $coco_details->ofw }}</label>

            <label class="amount_of_insurance">{{ $coco_details->amt_isurance }}</label>
            <label class="term_of_coverage">{{ $coco_details->term_coverage }}</label>
            <label class="premiums">{{ $coco_details->premiums }}</label>
            <label class="telephone_number">{{ $member->contact_no }}</label>
        </div>
    </div>

    <div class="absolute">
        @if(count($benificiary) > 0)
        @php
            $count = 1;
        @endphp

        @foreach($benificiary as $ben)
        @if($count == 1)
        <div class="name_values1">
            <label class="name">{{ $ben->fullname }}</label>
            <label class="age">69</label>
            <label class="relationship">{{ $ben->date_birth }}</label>
            <label class="remarks">{{ $ben->relationship }}</label>
        </div>
        
        @elseif($count == 2)
        <div class="name_values2">
            <label class="name">{{ $ben->fullname }}</label>
            <label class="age">69</label>
            <label class="relationship">{{ $ben->date_birth }}</label>
            <label class="remarks">{{ $ben->relationship }}</label>
        </div>

        @elseif($count == 3)
        <div class="name_values3">
            <label class="name">{{ $ben->fullname }}</label>
            <label class="age">69</label>
            <label class="relationship">{{ $ben->date_birth }}</label>
            <label class="remarks">{{ $ben->relationship }}</label>
        </div>

        @elseif($count == 4)
        <div class="name_values4">
            <label class="name">{{ $ben->fullname }}</label>
            <label class="age">69</label>
            <label class="relationship">{{ $ben->date_birth }}</label>
            <label class="remarks">{{ $ben->relationship }}</label>
        </div>
        @elseif($count > 4)
        @break
        @else
        @endif
        @php
            $count++;
            @endphp
        @endforeach
    </div>
    @else
    <div class="absolute">
        <div class="name_values1">
            <label class="name">NAME Value</label>
            <label class="age">69</label>
            <label class="relationship">Single</label>
            <label class="remarks">sample remarks</label>
        </div>
        
        <div class="name_values2">
            <label class="name">NAME Value</label>
            <label class="age">69</label>
            <label class="relationship">Single</label>
            <label class="remarks">sample remarks</label>
        </div>

        <div class="name_values3">
            <label class="name">NAME Value</label>
            <label class="age">69</label>
            <label class="relationship">Single</label>
            <label class="remarks">sample remarks</label>
        </div>

        <div class="name_values4">
            <label class="name">NAME Value</label>
            <label class="age">69</label>
            <label class="relationship">Single</label>
            <label class="remarks">sample remarks</label>
        </div>

    </div>
    @endif

    <div class="absolute">
        <div class="exceptions">
            <label class="exceptions_value">{{ $coco_details->exceptions }}</label>
        </div>

        <div class="signed_at">
            <label class="sig-1"></label>
            <label class="sig-2">this</label>
            <label class="sig-3"></label>
            <label class="sig-4"></label>
        </div>

        <div class="signatures">
            
            <img class="img-2" src="{{ public_path().$coco_details->sign_path }}" width="100" alt="UPPFI">
        </div>
    </div>
</body>
</html>