 <link href="//cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css" rel="stylesheet">
 <style type="text/css">
   * {
     font-family: Fira Sans, sans-serif;
   }

   table {
     border-collapse: collapse;
   }

   th {
     color: #414042 !important;
     font-family: Fira Sans, sans-serif;
     font-size: 15px;
   }

   tr {
     color: #636569 !important;
     font-family: Fira Sans, sans-serif;
     font-size: 15px;
   }
 </style>

 <div class="">
   <div class="">
     <div class="">

       <img src="{{ public_path().'/assets/images/uppfi-logo.png' }}" width="15%" alt="UPPFI">
       <span class="" style="vertical-align: middle; font-size: 25px; color: #414042!important;">
         University of the Philippines Provident Fund Inc.
       </span>
     </div>
   </div>
 </div>
 <div class="">
   <div style="padding: 30px;">
     <div class="" style="color: #414042!important; font-family: Fira Sans,sans-serif; font-size: 15px;">
       As of Date: {{ date("m/d/Y") }}
     </div>

     <div class="" style="color: #414042!important; font-family: Fira Sans,sans-serif; font-size: 15px;">
       <div>
         Name: {{$member->first_name}}, {{$member->last_name}} {{$member->middle_name}}
       </div>
       <div>
         Member ID: {{ $member->member_no }}
       </div>
       <div>
         Loan Control Number: {{$loan_details->control_number}}
       </div>
       <div>
         Loan Type: {{$loan_details->loan_type_name}}
       </div>
       <div>
         Total Loan Amount: PHP {{ number_format($loan_details->approved_amount, 2)}}
       </div>

       <div>
         Monthly Amortization: PHP {{ number_format($loan_details->monthly_amort, 2) }}
       </div>
     </div>
   </div>

   <div align="center" class="">
     <div class="" style="color: #414042!important; font-family: Fira Sans,sans-serif; font-size: 20px;">
       Monthly Payment Schedule
     </div>



     <div class="mp-text-no-lh">

       <br>
       <div align="center" class="">


         <table class="" width="100%" style="padding-top:30px">
           <tr class="custom_table_header">
             <th>Date</th>
             <th>Payment Amount</th>
             <!-- <th>Status</th> -->

           </tr>
           <tr>
             <td colspan="7">
               <hr>
             </td>

           </tr>

           @foreach ($dates as $loan_payments)

           <tr>
             <td class="mp-text-center" style="text-align:center;">{{ $loan_payments  }}</td>
             <td class="mp-text-center" style="text-align:center;"> PHP {{ number_format($loan_details->monthly_amort, 2) }} </td>
           </tr>
           @endforeach
         </table>


       </div>

     </div>
     <br>
     <div class="underline"></div>


     <br>
     <br>
     <br>
     <br>
     <br>
     <br>
     <br>
     <p style="color:red!important; font-size:12px!important">Note: This is a computer generated document.<br>No signature required. For questions or clarifications, please contact us at www.upprovidentfund.com</p>
   </div>
 </div>

 <script>

 </script>