@extends('layouts/main')
@section('content_body')

<script src="{{ asset('/dist/adminDashboard.js') }}"></script>
<div class="filler"></div>
<div class="col-12 mp-ph2 mp-pv2 mp-text mp-text-c-accent dashboard ">
  <div class="col-12 mp-ph2   mp-pv2 mp-text mp-text-c-accent dashboard " style=" margin-bottom: 32px;">
    <div class="row">
      <div class="col-lg-6 ">
        <div class="mp-card mp-mt3 default-padding">
          <div class="row">
            <div class="col-8">
              <label class="text-2xl mp-text-c-primary text-grey">
                Partial Return and Patronage Refund For 2021 is already available. (Deadline: February 13, 2022)
              </label>
            </div>
            <div class="col-4">
              <button class="up-button btn-md mp-mt3 button-animate-right  hover-back" style="float:right;" value="">
                <span>View</span>
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="mp-card mp-mt3 default-padding">
          <div class="row">
            <div class="col-8">
              <label class="text-2xl mp-text-c-primary text-grey">
                Pwede ka nang mag-apply ng loan online! Bisitahin lang ang “Loan Application” page at i-click ang “Apply for Loan” button.
              </label>
            </div>
            <div class="col-4">
              <button class="up-button btn-md mp-mt3 button-animate-right  hover-back" style="float:right;" value="">
                <span>Apply for Loan</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="mp-container mp-mt3" style="overflow:hidden;">
    <div class="row" style=" height: 100%;">
      <div class="col-lg-8">
        <div class="col-12 zero-padding">
          <div class="mp-ph4 mp-pv4 mp-card mp-card--plain">
            <div class="mp-text-no-lh">
              <div class="mp-mb1 mp-text-c-light-gray mp-text-fs-small">Member ID</div>
              <div class="mp-text-fs-large mp-text-fw-heavy">
                69696969

              </div>
            </div>
            <div class="mp-mh2 mp-text-no-lh mp-text-word-wrap mp-dashboard__title text-green">
              MARK DENNEB GOMEZ
            </div>
            <div class="mp-text-no-lh">
              <div class="mp-mb2 mp-text-fs-large">Up Diliman</div>
              <div class="mp-text-fs-large">Admin Officer 1</div>
            </div>


            <div class="mp-mt3">
              <i class="mp-icon icon-user mp-mr1 mp-text-fs-medium mp-text-c-primary"></i>


              <a href="{{url('/member/profile')}}" class="mp-link mp-link--primary " style="padding:0px !important;">
                Edit Member Details
              </a>


            </div>
            <div>
              <i class="mp-icon icon-envelope mp-mr1 mp-text-fs-medium mp-text-c-primary"></i>


              <label id="email" href="#" class="mp-link mp-link--primary ">
                markdennebg@gmail.com
              </label>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <i class="mp-icon icon-phone mp-mr1 mp-text-fs-medium mp-text-c-primary"></i>


              <alabel id="contactNo" href="#" class="mp-link mp-link--primary ">
                +63asdasd
                </label>
            </div>


          </div>
        </div>
        <div class="col-12 zero-padding mp-mt3">
          <div class="mp-ph4 mp-pv4 mp-card mp-card--plain">
            <div class="mp-mb2 mp-text-fs-medium">
              Your Member's Equity History
            </div>

            <div class="mp-mt3 table-container">
              <table class="members-table" style="height: auto;">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Transaction</th>
                    <th>Account</th>
                    <th class="mp-text-right">Amount</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>date</td>
                    <td>trans</td>
                    <td>asdasd</td>
                    <td class="mp-text-right">123123</td>
                  </tr>
                  <tr>
                    <td>date</td>
                    <td>trans</td>
                    <td>asdasd</td>
                    <td class="mp-text-right">123123</td>
                  </tr>
                  <tr>
                    <td>date</td>
                    <td>trans</td>
                    <td>asdasd</td>
                    <td class="mp-text-right">123123</td>
                  </tr>
                  <tr>
                    <td>date</td>
                    <td>trans</td>
                    <td>asdasd</td>
                    <td class="mp-text-right">123123</td>
                  </tr>
                  <tr>
                    <td>date</td>
                    <td>trans</td>
                    <td>asdasd</td>
                    <td class="mp-text-right">123123</td>
                  </tr>
                  <tr>
                    <td>date</td>
                    <td>trans</td>
                    <td>asdasd</td>
                    <td class="mp-text-right">123123</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="mp-mt1 mp-text-right">
              <a href="{{url('/member/equity')}}" class="mp-link mp-link--primary }}">
                See All
              </a>
            </div>

            <div class="mp-mt2 mp-mb2 mp-text-fs-medium">
              Your Loan Transactions History
            </div>
            <div class="mp-mt3 table-container">
              <table class="members-table" style="height: auto;">
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


                  <tr>
                    <td>date</td>
                    <td class="mp-text-center">zxc</td>
                    <td class="mp-text-center">qwe</td>
                    <td class="mp-text-center">qwe</td>
                    <td class="mp-text-right"> asd</td>
                  </tr>
                  <tr>
                    <td>date</td>
                    <td class="mp-text-center">zxc</td>
                    <td class="mp-text-center">qwe</td>
                    <td class="mp-text-center">qwe</td>
                    <td class="mp-text-right"> asd</td>
                  </tr>
                  <tr>
                    <td>date</td>
                    <td class="mp-text-center">zxc</td>
                    <td class="mp-text-center">qwe</td>
                    <td class="mp-text-center">qwe</td>
                    <td class="mp-text-right"> asd</td>
                  </tr>
                  <tr>
                    <td>date</td>
                    <td class="mp-text-center">zxc</td>
                    <td class="mp-text-center">qwe</td>
                    <td class="mp-text-center">qwe</td>
                    <td class="mp-text-right"> asd</td>
                  </tr>
                  <tr>
                    <td>date</td>
                    <td class="mp-text-center">zxc</td>
                    <td class="mp-text-center">qwe</td>
                    <td class="mp-text-center">qwe</td>
                    <td class="mp-text-right"> asd</td>
                  </tr>
                  <tr>
                    <td>date</td>
                    <td class="mp-text-center">zxc</td>
                    <td class="mp-text-center">qwe</td>
                    <td class="mp-text-center">qwe</td>
                    <td class="mp-text-right"> asd</td>
                  </tr>
                  <tr>
                    <td>date</td>
                    <td class="mp-text-center">zxc</td>
                    <td class="mp-text-center">qwe</td>
                    <td class="mp-text-center">qwe</td>
                    <td class="mp-text-right"> asd</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="mp-mt1 mp-text-right">
              <a href="#" class="mp-link mp-link--primary">See All</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">

        <div class=" mp-card">
          <div class="mp-text-fs-large mp-text-fw-heavy soa-title">Statement of Account
            <div class="mp-text-c-light-gray" style="font-size: 15px;
              color: white !important;"><label style=" font-size: 12px !important;">As of</label> January 25, 1969</div>
          </div>

          <div class="mp-ph4 mp-pv4">
            <div class="mp-card__header">

            </div>
            <div class="mp-card__body mp-mh5">
              <div class="mp-mb3 mp-text-fw-heavy  ">Your Member's Equity</div>
              <div class="row mp-mb2">
                <div class="col text-green">Total Member's Contribution</div>
                <div class="col-md-auto">1000</div>
              </div>
              <div class="row mp-mb2">
                <div class="col text-green">Total UP Contribution</div>
                <div class="col-md-auto"> 1000</div>
              </div>
              <div class="row mp-mb2">
                <div class="col text-green">Earnings on Member's Contribution</div>
                <div class="col-md-auto"> 1000</div>
              </div>
              <div class="row mp-mb3">
                <div class="col text-green">Earnings on UP Contribution</div>
                <div class="col-md-auto">1000 </div>
              </div>
              <hr>
              <div class="row mp-mt3 mp-mb2">
                <div class="col text-green">Total Equity Balance</div>
                <div class="col-md-auto"> 1000</div>
              </div>
              <div class="mp-mt5 mp-mb3 mp-text-fw-heavy">Your Outstanding Loans</div>
              <div class="row mp-mb2">
                <div class="col text-green"> Loan type</div>
                <div class="col-md-auto">Hulugan</div>
              </div>
              <hr class="mp-mt3">
              <div class="row mp-mt3 mp-mb2">
                <div class="col text-green">Total Outstanding Loan Balance</div>
                <div class="col-md-auto"> 69,999</div>
              </div>
            </div>
            <div class="mp-card__footer mp-text-right">
              <a href="#" target="_blank" class="mp-link mp-link--primary">
                Download PDF
              </a>
            </div>
          </div>

        </div>
      </div>

    </div>





  </div>

  @endsection