@extends('layouts/main')
@section('content_body')

<style>
  /* .card-container {
    display: flex;
    flex-direction: column;
  }

  .card-header {
    border-top-left-radius: 7px;
    border-top-right-radius: 7px;
    background-color: gray;
    padding: 5px 10px;
    color: white;
  }

  .card-body {
    display: flex;
    flex-direction: row;
    border-bottom-left-radius: 7px;
    border-bottom-right-radius: 7px;
    padding: 5px 10px;
    background-color: white;
  }

  .card-body>span {
    font-size: 20px;
  }

  .card-body>h1 {
    width: 60px;
  }

  .font-15 {
    font-size: 18px;
  }

  .font-13 {
    font-size: 13px;
  }

  .history-item {
    padding: 3px;
    padding: 10px 10px;
  }

  .history-container {
    min-height: 65vh;
    max-height: 65vh;
    overflow: auto;
    padding: 0;

  }

  .table-container {
    min-height: calc(65vh - 219px);
    max-height: calc(100vh - 219px);
    overflow: auto;
  }

  .record-container {
    min-height: 65vh;
    max-height: 65vh;
    overflow: auto;
  }


  .p-0 {
    padding: 0;
  }

  .record-container {
    min-height: 65vh;
    max-height: 65vh;
  }


  .f-button {
    background-color: #6c1242;
    color: white;
    padding-left: 15px;
    padding-right: 15px;
    border-radius: 20px;
    font-size: 14px;
  }

  .history-logs {
    background-color: #1a8981;
  }

  .filtering {
    background-color: #894168;
  }

  .members-table {
    border-collapse: collapse;
    margin: 0;
    padding: 0;
    width: 100%;
    table-layout: fixed;
    border: 1px solid #ececec;
  }

  .members-table>thead>tr>th {
    font-size: 13px;
    padding-left: 5px;
    padding-right: 5px;
    background-color: #1a8981;
    color: white !important;
    border-left: 1px solid white;
    font-weight: 500;
    border-top: 2px solid #1a8981;
    border-bottom: 2px solid #1a8981;
    height: auto;
  }

  .members-table>thead>tr>th:first-child {
    border-left: 1px solid #1a8981;
  }

  .members-table>thead>tr>th:last-child {
    border-right: 1px solid #1a8981;
  }

  .members-table>thead>tr>th>span {
    display: flex;
    height: 100%;
  }

  .members-table>tbody>tr>td>span {
    display: flex;
    padding: 5px 2px;

  }

  .members-table>tbody>tr>td {
    font-size: 12px;
    padding-left: 5px;
    padding-right: 5px;
  }

  .view {
    padding: 0;
    margin: 0;
    width: 100%;
    text-align: center;
    justify-self: center;
    align-self: center;
  }

  .member-name {
    font-weight: 700;
  }

  .filtering-section-body {
    padding: 10px;
    display: flex;
  }

  .percent {
    width: 150px;
    height: 150px;
    position: relative;
  }

  .percent svg {
    width: 150px;
    height: 150px;
    position: relative;
  }

  .percent svg circle {
    width: 150px;
    height: 150px;
    fill: none;
    stroke-width: 10;
    stroke: #000;
    transform: translate(5px, 5px);
    stroke-dasharray: 440;
    stroke-dashoffset: 440;
    stroke-linecap: round;
  }

  .percent svg circle:nth-child(1) {
    stroke-dashoffset: 0;
    stroke: #f3f3f3;
  }



  .percent .num {
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    position: absolute;
    color: #111;
  }

  .percent .num h2 {
    font-size: 48px;
  }

  .percent .num h2 span {
    font-size: 24px;
  }

  .text {
    padding: 10px 0 0;
    color: #999;
    font-weight: 700;
    letter-spacing: 1px;
  }

  .green-bg {
    background-color: #39b74d;
    color: white;
  }

  .green.ldBar path.mainline {
    stroke-width: 10;
    stroke: #39b74d;
    stroke-linecap: round;
  }

  .magenta.ldBar path.mainline {
    stroke-width: 10;
    stroke: #1a8981;
    stroke-linecap: round;
  }

  .maroon.ldBar path.mainline {
    stroke-width: 10;
    stroke: #894168;
    stroke-linecap: round;
  }

  .red.ldBar path.mainline {
    stroke-width: 10;
    stroke: #de2e4f;
    stroke-linecap: round;
  }

  .ldBar path.baseline {
    stroke-width: 10;
    stroke: #f1f2f3;
    stroke-linecap: round;
  }

  .button-view {
    border-bottom-left-radius: 7px;
    border-bottom-right-radius: 7px;
    color: white;
  }

  .magenta-bg {
    background-color: #1a8981;
  }

  .maroon-bg {
    background-color: #894168;
  }

  .red-bg {
    background-color: #de2e4f;
  }

  .link-style {
    color: #1a8981;
  }

  .link-style:hover {
    text-decoration: underline;
    color: #1a8981;
  }

  .settings-tab {

    margin-top: 20px;
  }

  .top-label {
    padding: 10px;
    font-weight: bold;
    font-size: 20px;
    color: var(--c-base-50);
  }

  .settings-tab label {
    margin-left: 20px;
  }

  .settings-tab a {
    margin-left: 20px;
  }

  .top-label i {
    float: right;
    margin-right: 22px;
    margin-top: 5px;
  }

  .no-padding {
    padding: 0px !important;
  }

  .options {
    padding: 20px;
    border: 1px solid #e9dfdf;

  }

  .options a {
    color: black;
  }

  .options:hover {
    background-color: #f6f6f6;
  }

  .options .option-info {
    font-size: 12px;
    color: var(--c-base-50);
    line-height: 1;
  }

  .options-active {
    background-color: var(--c-accent) !important;
  }

  .options-a-active {
    color: white !important;
  }

  .options-info-active {
    color: white !important;
  }

  .account-info {
    font-size: 12px;
    color: var(--c-base-50);
    line-height: 1;
    font-weight: 400;
  }

  */
</style>



<div class="filler"></div>
<div class="col-12  mp-text-fs-large mp-text-c-accent  dashboard mh-content" style="padding:0px !important;">


  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-2" id="settingsTab" style="padding:0px !important; height: 100%; overflow-y:auto; ">
        <div class="mp-card admin-settingtab" style="padding-bottom:150px;">
          <div class="settings-tab">
            <div class="top-label">
              <label>Settings</label>
              <i class="fa fa-cog" aria-hidden="true"></i>
            </div>

            <div class="settings-buttons">
              <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-start" id="menu">
                <li class="options options-active" onclick="location.href='manage-account'">
                  <a href="#" class="no-padding options-a-active">Manage Accounts</a><br>
                  <label class="option-info options-info-active">Allow User to create and manage system user accounts, You also can manage permissions and
                    authorizations.
                  </label>
                </li>
                <li class="options" onclick="location.href='campus-management'">
                  <a href="#" class="no-padding">Campus Management</a><br>
                  <label class="option-info">Allow User to manage respective campus; key, names, and clusters
                  </label>
                </li>
                <li class="options" onclick="location.href='employee-classification'">
                  <a href="#" class="no-padding">Employee Classification</a><br>
                  <label class="option-info">Allow User to add and manage employee Classifications
                  </label>
                </li>
                <li class="options" onclick="location.href='college-management'">
                  <a href="#" class="no-padding">College / Unit Management</a><br>
                  <label class="option-info">Allow User to manage respective College and units
                  </label>
                </li>
                <li class="options" onclick="location.href='department-management'">
                  <a href="#" class="no-padding">Department Management</a><br>
                  <label class="option-info">Allow User to manage respective departments per campuses
                  </label>
                </li>
                <li class="options" onclick="location.href='status-appointment'">
                  <a href="#" class="no-padding">Status and Appointments</a><br>
                  <label class="option-info">Allow User to pre-setup, manage the employee status and appointments.
                  </label>
                </li>
                <li class="options" onclick="location.href='sg-modules'">
                  <a href="#" class="no-padding">SG Modules</a><br>
                  <label class="option-info">Allow User to pre-setup salary grade range and assign salary grade category for election
                    modules
                  </label>
                </li>
                <li class="options" onclick="location.href='history-logs'">
                  <a href="#" class="no-padding">History Logs</a><br>
                  <label class="option-info">Allow User to retrieve and monitor user activity using History logs module.
                    modules
                  </label>
                </li>
                <li class="options" onclick="location.href='backup-database'">
                  <a href="#" class="no-padding">Backup Database</a><br>
                  <label class="option-info">Allow User to download and backup system database for documentations and risk management
                  </label>
                </li>
              </ul>
            </div>
          </div>

        </div>
      </div>
      <div class="col-lg-10 mp-mt3 gap-10" id="settingsContent">
        <div class="button-container mp-mb3">
          <button class="f-button magenta-bg" id="showSettings">Hide Settings</button>
        </div>
        <div class="mp-card  mp-ph2 mp-pv2">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-4">
                <div class="top-label">
                  <label>Create Account</label>
                  <label class="account-info">Allow User to manage respective campus; key, names, and clusters
                  </label>


                </div>
                <form id="users_form" class="mh-reg-form form-border-bottom" style="height: calc(100% - 100px) !important;">

                  <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3 member-form mp-pv2 shadow-inset-1" id="step-1">
                    <input type="hidden" id="users_id" name="users_id">
                    <!-- <label class="mp-text-fs-medium">Personal Information</label> -->
                    <div class="mp-input-group">
                      <label class="mp-input-group__label">First Name</label>
                      <input class="mp-input-group__input mp-text-field" type="text" name="firstname" id="firstname" required data-set="manage-account-validation" data-type="text"/>
                    </div>
                    <div class="mp-input-group">
                      <label class="mp-input-group__label">Middle Name</label>
                      <input class="mp-input-group__input mp-text-field" type="text" name="middlename" id="middlename" required data-set="manage-account-validation" data-type="text"/>
                    </div>
                    <div class="mp-input-group">
                      <label class="mp-input-group__label">Last Name</label>
                      <input class="mp-input-group__input mp-text-field" type="text" name="lastname" id="lastname" required data-set="manage-account-validation" data-type="text"/>
                    </div>


                    <div class="mp-input-group">
                      <label class="mp-input-group__label">Contact No.</label>
                      <input class="mp-input-group__input mp-text-field" type="text" name="contact_no" id="contact_no" required data-set="manage-account-validation"/>
                    </div>
                    <div class="mp-input-group">
                      <label class="mp-input-group__label">Username/Email</label>
                      <input class="mp-input-group__input mp-text-field" type="email" name="email" id="email" required data-set="manage-account-validation"/>
                    </div>
                    <div class="mp-input-group">
                      <label class="mp-input-group__label">Password</label>
                      <input class="mp-input-group__input mp-text-field" type="text" id="initial_pass" name="initial_pass" readonly placeholder="AUTO GENERATE" required data-set="manage-account-validation" data-type="text"/>

                    </div>
                    <a class="up-button-green btn-md button-animate-right mp-text-center" id="generate_password">
                      <span>Generate Initial Password</span>
                    </a>
                    <div class="mp-input-group">
                      <label class="mp-input-group__label">User Level</label>
                      <select class="js-example-responsive mp-input-group__input mp-text-field select-error" style="width:100%;" name="user_level" id="user_level" required data-set="manage-account-validation" data-type="text">
                        <option value="">Select User Level</option>
                        <option value="AO">AO</option>
                        <option value="CFM">CFM</option>
                        <option value="HRDO">HRDO</option>
                        <option value="FM">FM</option>
                        <option value="ADMIN">ADMIN</option>
                      </select>
                    </div>
                    <div class="mp-input-group cfm_div">
                      <label class="mp-input-group__label">AA/CFM Cluster No.</label>
                      <select class="js-example-responsive mp-input-group__input mp-text-field" style="width:100%;" name="cfm_cluster" id="cfm_cluster" required data-set="manage-account-validation" data-type="text">
                        <option value="">Select Cluster No.</option>
                        <option value="1">Cluster 1 - DSB</option>
                        <option value="2">Cluster 2 - LBOU</option>
                        <option value="3">Cluster 3 - MLAPGH</option>
                        <option value="4">Cluster 4 - CVM</option>
                      </select>
                    </div>

                    <div class="mp-input-group">
                      <label class="mp-input-group__label">Select Campus</label>

                      <select class="js-example-responsive mp-input-group__input mp-text-field" style="width:100%;" name="campus" id="campus" required data-set="manage-account-validation" data-type="text">
                        <option value="">Select Campus</option>
                        @foreach($campus as $row)
                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="mp-input-group">
                      <label class="mp-input-group__label">Manage Permission</label>
                      <table class="permission-table">
                        <tr>
                          <th>Modules</th>
                          <th>Full Access</th>
                          <th>View Only</th>
                        </tr>
                        <tr>
                          <td>Settings & Configuration</td>
                          <td>
                            <input class="checkbox-color" type="radio" value="1" name="setting_access" id="setting_access">
                          </td>
                          <td>
                            <input class="checkbox-color" type="radio" value="2" name="setting_access" id="setting_access2">
                          </td>
                        </tr>

                        <tr>
                          <td>Election Module</td>
                          <td>
                            <input class="checkbox-color" type="radio" value="1" name="election_access" id="election_access">
                          </td>
                          <td>
                            <input class="checkbox-color" type="radio" value="2" name="election_access" id="election_access2">
                          </td>
                        </tr>

                        <tr>
                          <td>Loan Module</td>
                          <td>
                            <input class="checkbox-color" type="radio" value="1" name="loan_access" id="loan_access">
                          </td>
                          <td>
                            <input class="checkbox-color" type="radio" value="2" name="loan_access" id="loan_access2">
                          </td>
                        </tr>

                        <tr>
                          <td>Benefits Module</td>
                          <td>
                            <input class="checkbox-color" type="radio" value="1" name="benifits_access" id="benifits_access">
                          </td>
                          <td>
                            <input class="checkbox-color" type="radio" value="2" name="benifits_access" id="benifits_access2">
                          </td>
                        </tr>
                        <tr>
                          <td>Transaction & Equity</td>
                          <td>
                            <input class="checkbox-color" type="radio" value="1" name="transaction_access" id="transaction_access">
                          </td>
                          <td>
                            <input class="checkbox-color" type="radio" value="2" name="transaction_access" id="transaction_access2">
                          </td>
                        </tr>
                        <tr>
                          <td>Membership Application</td>
                          <td>
                            <input class="checkbox-color" type="radio" value="1" name="memberapp_access" id="memberapp_access">
                          </td>
                          <td>
                            <input class="checkbox-color" type="radio" value="2" name="memberapp_access" id="memberapp_access2">
                          </td>
                        </tr>
                        <tr>
                          <td>Members Module</td>
                          <td>
                            <input class="checkbox-color" type="radio" value="1" name="membermod_access" id="membermod_access">
                          </td>
                          <td>
                            <input class="checkbox-color" type="radio" value="2" name="membermod_access" id="membermod_access2">
                          </td>
                        </tr>
                      </table>

                    </div>
                    <a class="up-button-green btn-md button-animate-right mp-text-center" id="save_users" name="save_users" type="submit">
                      <span class="save_up">Save Record</span>
                    </a>
                    <a class="up-button-grey btn-md button-animate-right mp-text-center" id="cancel">
                      <span class="clear_txt">Clear</span>
                    </a>
                    <!-- <button type="submit" class="sss" id="btn-submit">Submit</button> -->

                  </div>

                </form>
              </div>

              <div class="col-lg-8">
                <div>
                  <div class="top-label">
                    <label>Data Records</label>
                  </div>
                  <div class="mp-mt3 table-container" style="height:calc(100%-100px) !important;">
                    <table class="members-table" style="height: auto;;" width="100%" id="users_table">
                      <thead>
                        <tr>
                          <th>
                            <span>Username</span>
                          </th>
                          <th>
                            <span>Initial Password</span>
                          </th>
                          <th>
                            <span>Fullname</span>
                          </th>
                          <th>
                            <span>Campus</span>
                          </th>
                          <th>
                            <span>User Level</span>
                          </th>
                          <th>
                            <span>Status</span>
                          </th>
                          <th>
                            <span>Password Status</span>
                          </th>
                          <th>
                            <span>Action</span>
                          </th>

                        </tr>
                      </thead>
                      <tbody>

                      </tbody>
                    </table>



                  </div>
                  <div class="records-button" style="transform: scale(0.7);">
                    <a class="up-button-green btn-md   mp-text-center" style="margin-top:3px; width: 160px;" type="submit">
                      <span>Print</span>
                    </a>
                    <br>
                    <a class="up-button  btn-md    mp-text-center" style="margin-top:3px; width: 160px;" type="submit">
                      <span>Download</span>
                    </a>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

      </div>

    </div>
  </div>
</div>

<script>
  $(document).on('click', '#showSettings', function(e) {
    if ($("#settingsTab").hasClass("col-lg-2")) {
      $("#settingsTab").addClass("d-none");
      $("#settingsTab").removeClass("col-lg-2");
      $("#settingsContent").removeClass("col-lg-10");
      $("#settingsContent").addClass("col-lg-12");

      $("#showSettings").text("Show Settings")

    } else {
      $("#settingsTab").removeClass("d-none");
      $("#settingsTab").addClass("col-lg-2");
      $("#settingsContent").removeClass("col-lg-12");
      $("#settingsContent").addClass("col-lg-10");

      $("#showSettings").text("Hide Settings")
    }

  })
  var users_table;
  $(document).ready(function() {
    users_table = $('#users_table').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: "{{ route('users_list') }}",
        type: 'GET',
      },
      columns: [{
          data: 'email',
          name: 'email'
        },
        {
          data: 'intial_password',
          name: 'intial_password'
        },
        {
          data: 'full_name',
          name: 'full_name'
        },
        {
          data: 'camp_name',
          name: 'camp_name'
        },
        {
          data: 'user_level',
          name: 'user_level'
        },
        {
          data: 'status_flag',
          name: 'status_flag'
        },
        {
          data: 'password_set',
          name: 'password_set'
        },
        {
          data: 'action',
          name: 'action',

        },
      ]
    });
  });
  $('.cfm_div').hide();
  $(document).on('change', '#user_level', function() {
    clearValidation('cfm_cluster', 'manage-account-validation', $('[data-set=manage-account-validation][name=cfm_cluster]'))
    if ($(this).val() == 'CFM') {
      $('.cfm_div').show();
    } else if ($(this).val() == 'AA') {
      $('.cfm_div').show();
    } else {
      $('.cfm_div').hide();
    }
  });
  $(document).on('click', '#generate_password', function() {
    function randomString(length) {
      var result = '';
      var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
      var charactersLength = characters.length;
      for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
      }
      return result;
    }
    var random = randomString(6);
    $("#initial_pass").val(random);

  });

  const inputField = document.querySelector('[name=contact_no]');

  function formatInput(event) {
        if (event.inputType == 'deleteContentBackward') {
            let input = inputField.value;
            if (input.length <= 3) {
                inputField.value = '+63';
            }
            return
        }
        if (event.inputType == 'insertText') {
            let input = inputField.value;
            if (input == '+630' && input.length <= 4) {
                inputField.value = '+63';
                return
            }

        }

        let input = inputField.value;
        let formattedInput = input.replace(/\D/g, '');

        // Set placeholder
        inputField.placeholder = "XXXXXXXXXX";
        if (formattedInput === '') {
            // If the input is empty, display the "+63 " prefix
            formattedInput = '+63';
        } else if (formattedInput.startsWith('63')) {
            // If the input starts with "63", replace it with "+63 " 

            formattedInput = '+63' + formattedInput.slice(2);
            let newformat = []
            for (let x = 0; x < formattedInput.length; x++) {
                newformat.push(formattedInput[x])
                if (x == 2) {
                    newformat.push('-')
                }
                if (x == 5) {
                    newformat.push('-')
                }
                if (x == 8) {
                    newformat.push('-')
                }
            }
            formattedInput = newformat.toString().replace(/,/g, '')
        } else if (formattedInput.length >= 4) {
            // If the input has at least 4 digits, add the country code and separate the digits with spaces

            formattedInput = '+63' + formattedInput.slice(3, 2) + ' ' + formattedInput.slice(3, 6) + ' ' + formattedInput.slice(6, 10);
        } else if (formattedInput.length >= 1) {
            // If the input has at least 1 digit, add the country code
            formattedInput = '+63' + formattedInput;
        }
        // Limit the formatted input to 10 digits

        formattedInput = formattedInput.slice(0, 16);

        inputField.value = formattedInput;
    }
    document.addEventListener('DOMContentLoaded', formatInput);
    inputField.addEventListener('input', formatInput);

  $(document).on('click', '#save_users', function() {
    let hasError = false
    const elements = $(document).find(`[data-set=manage-account-validation]`)
    console.log(elements)
    elements.map(function (){
      if($(this).attr('err-name')) {
        return
      }
      if($(this).attr('data-type') != 'text') return 
      let status = true
      status = validateField({
        element: $(this),
        target: 'manage-account-validation'
      })
      
      if($(this).attr('name') == 'cfm_cluster') {
        if(status && $('[data-set=manage-account-validation][name=user_level]').val() == "CFM") {
          hasError = true
        }
        return
      }
      

      if(!hasError && status) {
        hasError = true
      }
    })
    const email = $('[name=email]').val()
    if (email.length == 0) {
      status = validateField({
        element:  $('[name=email]'),
        target: 'manage-account-validation',
        errText: "Invalid email."
      })
      hasError = true
    } else {
      var emailRegex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
      if(emailRegex.test(email) == false) {
        status = validateField({
          element:  $('[name=email]'),
          target: 'manage-account-validation',
          errText: "Invalid email."
        })
        hasError = true
      } else {
        clearValidation('email', 'manage-account-validation', $('[name=email]'))
      }
    }
    

    const phoneRegex = /^(09|\+639)\d{9}$/;
    const mobile_number = $("input[name=contact_no]")

    if (!phoneRegex.test(mobile_number.val().replace(/-/g, ''))) {
      status = validateField({
          element: mobile_number,
          target: 'manage-account-validation',
          errText: 'Invalid contact number.',
          isError: true
      })
      hasError = true
    }
    else {
      status = validateField({
          element: mobile_number,
          target: 'manage-account-validation',
          errText: 'Invalid contact number.',
      })
    }

    
    if(hasError) {
      return
    }
    console.log('no error')

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    var empty = $('#users_form').find("input[required]").filter(function() {
      return !$.trim($(this).val()).length;
    });
    if (empty.length) {
      // var emptyFields = [];
      // empty.each(function() {
      // emptyFields.push($(this).attr("id"));
      // });
      empty.first().focus();
      swal.fire("Error!", "Please fill out the required fields", "error");
    } else {
      if ($('#users_id').val()) {
        var formData = $("#users_form").serialize();
        $.ajax({
          type: 'POST',
          url: "{{ route('update-users') }}",
          data: formData,
          success: function(data) {
            if (data.success != '') {
              Swal.fire({
                text: 'Users has been added Updated Successfully.',
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok',
              });
              $("#users_form")[0].reset();
              $('#users_id').val('');
              $('.save_up').text('Save Record');
              $('.clear_txt').text('Clear');
              $('#user_level').val('').trigger("change");
              $('#campus').val('').trigger("change");
              $('#cfm_cluster').val('').trigger("change");
              users_table.draw();
            } else {
              Swal.fire({
                text: 'No Updates Made!',
                icon: 'error',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok',
              });
            }
          },
          error: function(data) {
            Swal.fire({
              text: 'No Updates Made!',
              icon: 'error',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok',
            });
          }
        });
      } else {
        var formData = $("#users_form").serialize();
        $.ajax({
          type: 'POST',
          url: "{{ route('add_users') }}",
          data: formData,
          success: function(data) {
            if (data.success != '') {
              Swal.fire({
                text: 'User has been added Successfully.',
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok',
              });
              $("#users_form")[0].reset();
              $('.save_up').text('Save Record');
              $('.clear_txt').text('Clear');
              $('#user_level').val('').trigger("change");
              $('#campus').val('').trigger("change");
              $('#cfm_cluster').val('').trigger("change");
              $("[name=contact_no]").val("+63")
             
              users_table.draw();
            }

          }
        });
      }
    }
  });
  $(document).on('click', '.edit_users', function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    var users_id = $(this).attr('data-id');
    $.ajax({
      type: 'POST',
      url: "{{ route('get_details_user') }}",
      data: {
        users_id: users_id
      },
      success: function(data) {
        $('#users_id').val(data.id);
        $('#email').val(data.email);
        $('#firstname').val(data.first_name);
        $('#middlename').val(data.middle_name);
        $('#lastname').val(data.last_name);
        $('#contact_no').val(data.contact_no);
        $('#initial_pass').val(data.intial_password);
        $('#user_level').val(data.user_level);

        if (data.user_level == "CFM") {
          $('.cfm_div').show();
          $('#cfm_cluster').val(data.cfm_cluster).trigger("change");
        } else if (data.user_level == "AO") {
          $('.cfm_div').show();
          $('#cfm_cluster').val(data.cfm_cluster).trigger("change");
        } else {
          $('.cfm_div').hide();
          $('#cfm_cluster').val('');
        }
        $('#campus').val(data.campus_id);
        if (data.setting_config == 1) {
          $('#setting_access').prop('checked', true);
        } else if (data.setting_config == 2) {
          $('#setting_access2').prop('checked', true);
        }
        if (data.election_mod == 1) {
          $('#election_access').prop('checked', true);
        } else if (data.election_mod == 2) {
          $('#election_access2').prop('checked', true);
        }
        if (data.loan_mod == 1) {
          $('#loan_access').prop('checked', true);
        } else if (data.loan_mod == 2) {
          $('#loan_access2').prop('checked', true);
        }
        if (data.benifits_mod == 1) {
          $('#benifits_access').prop('checked', true);
        } else if (data.benifits_mod == 2) {
          $('#benifits_access2').prop('checked', true);
        }
        if (data.trans_equity_mod == 1) {
          $('#transaction_access').prop('checked', true);
        } else if (data.trans_equity_mod == 2) {
          $('#transaction_access2').prop('checked', true);
        }
        if (data.memberapp_mod == 1) {
          $('#memberapp_access').prop('checked', true);
        } else if (data.memberapp_mod == 2) {
          $('#memberapp_access2').prop('checked', true);
        }
        if (data.member_mod == 1) {
          $('#membermod_access').prop('checked', true);
        } else if (data.member_mod == 2) {
          $('#membermod_access2').prop('checked', true);
        }
        $('.save_up').text('Update Record');
        $('.clear_txt').text('Cancel');
      }
    });

  });
  $(document).on('click', '#cancel', function() {
    $("#users_form")[0].reset();
    $('#users_id').val('');
    $('.save_up').text('Save Record');
    $('.clear_txt').text('Clear');
    $('#user_level').val('').trigger("change");
    $('#campus').val('').trigger("change");
    $('#cfm_cluster').val('').trigger("change");
  });
  $(document).on('click', '.remove_users', function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    var users_id = $(this).data('id');
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          type: 'POST',
          url: "{{ route('delete_users') }}",
          data: {
            users_id: users_id
          },
          success: function(data) {
            if (data.success != '') {
              Swal.fire({
                text: 'User has been Deleted Successfully.',
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok',
              });
              $("#users_form")[0].reset();
              $('#users_id').val('');
              $('.save_up').text('Save Record');
              $('.clear_txt').text('Clear');
              $('#user_level').val('').trigger("change");
              $('#campus').val('').trigger("change");
              $('#cfm_cluster').val('').trigger("change");
              users_table.draw();
            }
          }
        });

      }
    });

  });
</script>

@endsection