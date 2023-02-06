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
        <div class="mp-card" style="padding-bottom:150px;">
          <div class="settings-tab">
            <div class="top-label">
              <label>Settings</label>
              <i class="fa fa-cog" aria-hidden="true"></i>
            </div>

            <div class="settings-buttons">
              <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-start" id="menu">
                <li class="options" onclick="location.href='manage-account'">
                  <a href="#" class="no-padding">Manage Accounts</a><br>
                  <label class="option-info">Allow User to create and manage system user accounts, You also can manage permissions and
                    authorizations.
                  </label>
                </li>
                <li class="options options-active" onclick="location.href='campus-management'">
                  <a href="#" class="no-padding options-a-active">Campus Management</a><br>
                  <label class="option-info options-info-active">Allow User to manage respective campus; key, names, and clusters
                  </label>
                </li>
                <li class="options " onclick="location.href='employee-classification'">
                  <a href="#" class="no-padding ">Employee Classification</a><br>
                  <label class="option-info">Allow User to add and manage employee Classifications
                  </label>
                </li>
                <li class="options " onclick="location.href='college-management'">
                  <a href="#" class="no-padding">College / Unit Management</a><br>
                  <label class="option-info">Allow User to manage respective College and units
                  </label>
                </li>
                <li class="options" onclick="location.href='department-management'">
                  <a href="#" class="no-padding ">Department Management</a><br>
                  <label class="option-info ">Allow User to manage respective departments per campuses
                  </label>
                </li>
                <li class="options " onclick="location.href='status-appointment'">
                  <a href="#" class="no-padding ">Status and Appointments</a><br>
                  <label class="option-info ">Allow User to pre-setup, manage the employee status and appointments.
                  </label>
                </li>
                <li class="options " onclick="location.href='sg-modules'">
                  <a href="#" class="no-padding ">SG Modules</a><br>
                  <label class="option-info">Allow User to pre-setup salary grade range and assign salary grade category for election
                    modules
                  </label>
                </li>
                <li class="options " onclick="location.href='history-logs'">
                  <a href="#" class="no-padding ">History Logs</a><br>
                  <label class="option-info">Allow User to retrieve and monitor user activity using History logs module.
                    modules
                  </label>
                </li>
                <li class="options " onclick="location.href='backup-database'">
                  <a href="#" class="no-padding ">Backup Database</a><br>
                  <label class="option-info ">Allow User to download and backup system database for documentations and risk management
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
                  <label>Create New Campus</label>
                  <label class="account-info">Allow User to manage respective campus; key, names, and clusters
                  </label>
                  {{ csrf_field() }}
                  <form id="campus_form" class="mh-reg-form form-border-bottom" style="height: calc(100% - 100px) !important;">

                  <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3 member-form mp-pv2 shadow-inset-1" >
                    <input type="hidden" id="app_trailNo">
                    <div class="mp-input-group">
                      <label class="mp-input-group__label">Campus Key</label>
                      <input class="mp-input-group__input mp-text-field" type="text" name="campus_key" id="campus_key" required="">
                    </div>
                    <div class="mp-input-group">
                      <label class="mp-input-group__label">Campus Name</label>
                      <input class="mp-input-group__input mp-text-field" type="text" name="campus_name" id="campus_name" required="">
                    </div>
                    <!-- <div class="mp-input-group">
                      <label class="mp-input-group__label">Last Name</label>
                      <input class="mp-input-group__input mp-text-field" type="text" name="lastname" required="">
                    </div> -->



                      <a class="up-button-green btn-md button-animate-right mp-text-center" id="save_campus" type="submit">
                        <span>Save Record</span>
                      </a>
                      <a class="up-button-grey btn-md button-animate-right mp-text-center">
                        <span>Clear</span>
                      </a>
                      <!-- <button type="submit" class="sss" id="btn-submit">Submit</button> -->

                    </div>

                  </form>

                </div>

              </div>

              <div class="col-lg-8">
                <div>
                  <div class="top-label">
                    <label>Data Records</label>
                  </div>
                  <div class="mp-mt3 table-container" style="height:calc(100%-100px) !important;">
                    <table class="members-table" style="height: auto;;" width="100%" id="campus_table">
                      <thead>
                        <tr>
                          <th>
                            <span>Campus Key</span>
                          </th>
                          <th>
                            <span>Name</span>
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
                    <a class="up-button btn-md   mp-text-center" style="margin-top:3px; width: 160px;" type="submit">
                      <span>Print</span>
                    </a>
                    <br>
                    <a class="up-button-green btn-md    mp-text-center" style="margin-top:3px; width: 160px;" type="submit">
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
  var campus_table;
  $(document).ready(function() {
    campus_table = $('#campus_table').DataTable({
      ordering: false,
      info: false,
      searching: true,
      paging: false,
      processing: true,
      serverSide: true,
      ajax: {
        url: "{{ route('campus_list') }}"
      },
      columns: [{
          data: 'campus_key',
          name: 'campus_key'
        },
        {
          data: 'name',
          name: 'name'
        },
        {
          data: 'action',
          name: 'action',

        },
      ]
    });
  });
  $(document).on('click', '#save_campus', function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    var formData = $("#campus_form").serialize();
    // var additionalData = {
    //     'mem_id': mem_id,
    // };
    // formData += '&' + $.param(additionalData);
    $.ajax({
      type: 'POST',
      url: "{{ route('add_campus') }}",
      data: formData,
      success: function(data) {
        if (data.success != '') {
          Swal.fire({
            text: 'Campus has been added Successfully.',
            icon: 'success',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok',
          });
          campus_table.draw();
        }

      }
    });
  });
  $(document).on('click', '.delete_campus', function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    var id_campus = $(this).data('id');
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
          url: "{{ route('delete_campus') }}",
          data: {
            id_campus: id_campus
          },
          success: function(data) {
            if (data.success != '') {
              Swal.fire({
                text: 'Campus has been Deleted Successfully.',
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok',
              });
              campus_table.draw();
            }
          }
        });

      }
    });
  });
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
</script>
@endsection