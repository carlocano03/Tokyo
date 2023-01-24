@extends('layouts/main')
@section('content_body')

<script src="{{ asset('/dist/adminDashboard.js') }}"></script>
<div class="filler"></div>
  <div class="col-12 mp-ph2 mp-pv2 mp-text-fs-large mp-text-c-accent mp-overflow-y dashboard ">
    <div class="container-fluid">
  <link href="/css/css-module/global_css/global.css" rel="stylesheet">
  <div class="row no-gutters mp-mt5">
    <div class="col-12 mp-ph2 mp-pv2 mp-text-fs-large mp-text-c-primary">
      <a class="mp-link mp-link--primary" href="{{url('/member/dashboard')}}">
        <i class="mp-icon icon-arrow-left mp-mr1 mp-text-fs-medium"></i>
        Back to Dashboard
      </a>
    </div>

  </div>

  <div class="row no-gutters">
    <div class="col-lg-8">
      <div class="row no-gutters">
        <div class="col-12 mp-ph2 mp-pv2">
          <div class="mp-ph4 mp-pv4 mp-card mp-card--plain">
            <div style="text-align:right!important;">
             <a class="mp-link mp-link--primary" href="{{ url('/member/update-password') }}">
              Change Password
            </a>
          </div>
          <div class="mp-text-no-lh">
            <div class="mp-mb1 mp-text-c-light-gray mp-text-fs-small">Member ID</div>
            <div class="mp-text-fs-large mp-text-fw-heavy">
              member id
            </div>
          </div>
          <div class="mp-mh2 mp-text-no-lh mp-text-word-wrap mp-dashboard__title">
            Gomez , Denneb
          </div>
          <div class="mp-text-no-lh">
            <div class="mp-mb2 mp-text-fs-large">Campus</div>
            <div class="mp-text-fs-large">position id</div>
          </div>
            

          </div>
        </div>
        <div class="col-12 mp-ph2 mp-pv2">
          <div class="mp-card mp-card--plain  mp-ph4 mp-pv4 " >
            <div class="mp-mb2 mp-text-fs-medium ">
              Beneficiaries
            </div>
            <div class="mp-overflow-x ">
              <table class="mp-table table_style" >
                <thead >
                  <tr>
                    <th class="thead_style">Name</th>
                    <th class="thead_style">Birth Date</th>
                    <th class="thead_style">Relationship to Member</th>
                  </tr>
                </thead>
                <tbody>
                 
                  <tr>
                    <td>asdasdsa</td>
                    <td>asdasdsa</td>
                    <td>asdasdsa</td>
                  </tr>
                  
                </tbody>
              </table>
            </div>
          <!--   <div class="mp-mt1 mp-text-right">
              <a href="{{url('/member/equity')}}" class="mp-link mp-link--primary }}">
                See All
              </a>
            </div> -->

            <!-- <div class="mp-mt2 mp-mb2 mp-text-fs-medium">
              Your Loan Transactions History
            </div>
            <div class="mp-overflow-x">
              <table class="mp-table mp-table--mini">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Account</th>
                    <th class="mp-text-center">Monthly Amort.</th>
                    <th class="mp-text-center">Amount</th>
                    <th class="mp-text-right">Principal Balance</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div> -->
            <div class="mp-mt1 mp-text-right  mp-ph4 mp-pv4 ">
              <a href="{{url('/member/edit_beneficiaries')}}" class="mp-link mp-link--primary">Edit</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 mp-ph2 mp-pv2">
      <div class="mp-card">
        <div class="mp-card__header" style="padding-bottom: 10px!important; margin-bottom:10px!important">
          <div class="mp-text-fs-medium mp_header_style">Member's Details</div>
          <!--   <div class="mp-text-c-light-gray">As of {{ date("m/d/Y") }}</div> -->
        </div>
        <div class="mp-card__body mp-mh5 mp-pb4 mp-pv4" style="padding-top: 0px!important; margin-top:0px!important" >
          <!--   <div class="mp-mb3 mp-text-fw-heavy">Your Member's Equity</div> -->
          
          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">Cellphone Number:</div>
            <div class="col-md-auto">+632323232</div>
          </div>
          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">Landline Number:</div>
            <div class="col-md-auto">123132</div>
          </div>
          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">Gender:</div>
            <div class="col-md-auto">male</div>
          </div>
          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">Employee Number:</div>
            <div class="col-md-auto">employee value</div>
          </div>

          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">Status of Appointment:</div>
            <div class="col-md-auto">status value</div>
          </div>
          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">TIN:</div>
            <div class="col-md-auto">tin id 123</div>
          </div>

          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">Permanent Address:</div>
            <div class="col-md-auto"  style="width:100%">permanent address</div>
          </div>
          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">Current Address:</div>
            <div class="col-md-auto"  style="width:100%" >address</div>
          </div>
          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">Birthday:</div>
            <div class="col-md-auto">date</div>
          </div>
          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">Monthly Salary:</div>
            <div class="col-md-auto">PHP 1231232</div>
          </div>
        </div>
        <div class="mp-card__footer mp-text-right mp-pb4 mp-pv4">
          <a href="{{url('/member/edit_details')}}" class="mp-link mp-link--primary">
            Edit
          </a>
        </div>
      </div>
    </div>

    <div class="col-8 mp-ph2 mp-pv2">
      <div class="mp-ph4 mp-pv4 " style="">

        <div class="mp-overflow-x">

        </div>
      </div>
    </div>

    <div class="col-lg-4 mp-ph2 mp-pv2">
      <div class="mp-card">
        <div class="mp-card__header" style="padding-bottom: 10px!important; margin-bottom:10px!important">
          <div class="mp-text-fs-medium mp_header_style">Member's Details (For Approval)</div>
          <!--   <div class="mp-text-c-light-gray">As of {{ date("m/d/Y") }}</div> -->
          <div class="mp-ph4 mp-pv4 ">
            <span style="font-size:14px;">To edit or change the following information, please fill out the <a class="mp-link mp-link--primary" href="https://www.upprovidentfund.com/forms/">Member's Updating Form</a> and submit to a UP Provident Fund office near you.</span>

          </div>
        </div>
        <div class="mp-card__body mp-mh5 mp-ph4 mp-pv4 " style="padding-top: 0px!important; margin-top:0px!important">
          <!--   <div class="mp-mb3 mp-text-fw-heavy">Your Member's Equity</div> -->
          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">Email:</div>
            <div class="col-md-auto">markdennebg@gmail.com</div>
          </div>

          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">Salary Grade:</div>
            <div class="col-md-auto">salary grade value</div>
          </div>

          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">Original Appointment Date:</div>
            <div class="col-md-auto">date</div>
          </div>

          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">Civil Status:</div>
            <div class="col-md-auto">single</div>
          </div>

          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">Member Contribution Type:</div>
            <div class="col-md-auto">type</div>
          </div>
          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">Member Monthly Contribution:</div>
            <div class="col-md-auto">123123</div>

            
              </div>
             
            </div>
          </div>

        </div>
      </div>
      @endsection

      @section('script')
      <script src="{{ asset('/dist/dashboard.js') }}"></script>   
      @endsection

  </div>
