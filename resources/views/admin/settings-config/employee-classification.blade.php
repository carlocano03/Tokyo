@extends('layouts/main')
@section('content_body')

<style>
  .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
  }

  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
    transform: scale(0.6);
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
  }

  input:checked+.slider {
    background-color: var(--c-accent);
  }

  input:focus+.slider {
    box-shadow: 0 0 1px #2196F3;
  }

  input:checked+.slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
  }

  /* Rounded sliders */
  .slider.round {
    border-radius: 34px;
  }

  .slider.round:before {
    border-radius: 50%;
  }
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
                <li class="options options-active" onclick="location.href='employee-classification'">
                  <a href="#" class="no-padding options-a-active">Employee Classification</a><br>
                  <label class="option-info options-info-active">Allow User to add and manage employee Classifications
                  </label>
                </li>
                <li class="options" onclick="location.href='manage-account'">
                  <a href="#" class="no-padding">Manage Accounts</a><br>
                  <label class="option-info">Allow User to create and manage system user accounts, You also can manage permissions and
                    authorizations.
                  </label>
                </li>
                <li class="options" onclick="location.href='campus-management'">
                  <a href="#" class="no-padding">Campus Management</a><br>
                  <label class="option-info">Allow User to manage respective campus; key, names, and clusters
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
                  <label>Employee Classification</label>
                  <label class="account-info">Allow user to add & manage employee Classifications
                  </label>
                  {{ csrf_field() }}
                  <form id="classif_form" class="mh-reg-form form-border-bottom" style="height: calc(100% - 100px) !important;">

                    <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3 member-form mp-pv2 shadow-inset-1">
                      <input type="hidden" id="app_trailNo">
                      <div class="mp-input-group">
                        <label class="mp-input-group__label">Classification Name</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="classif_name" id="classif_name" required="">
                      </div>
                      <div class="mp-input-group">
                        <label class="mp-input-group__label">Status</label>
                        <select class="mp-input-group__input mp-text-field" name="status" id="status" required>
                          <option value="1">Active</option>
                          <option value="0">In Active</option>
                        </select>
                      </div>





                      <a class="up-button-green btn-md button-animate-right mp-text-center" id="save_class" type="submit">
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
                    <!-- <label>Data Records</label> -->
                  </div>
                  <div class="mp-mt3 table-container" style="height:calc(100%-100px) !important;">
                    <table class="members-table" style="height: auto;" width="100%" id="classif-table">
                      <thead>
                        <tr>
                          <th>
                            <span>Classification Name</span>
                          </th>
                          <th>
                            <span>Status</span>
                          </th>

                          <th>
                            <span>Created time</span>
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

                    <a class="up-button btn-md    mp-text-center" style="margin-top:3px; width: 160px;" type="submit">
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
  $(document).on('click', '#save_class', function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    var formData = $("#classif_form").serialize();

    $.ajax({
      type: 'POST',
      url: "{{ route('save-class') }}",
      data: formData,
      success: function(data) {
        if (data.success != '') {
          Swal.fire({
            text: 'Classification Name has been added Successfully.',
            icon: 'success',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok',
          });
          tbl_clss.draw();
        }

      }
    });
  });
  var tbl_clss;
  $(document).ready(function() {
    tbl_clss = $('#classif-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: "{{ route('class_list') }}",
        type: 'GET',
      },
      columns: [{
          data: 'classification_name',
          name: 'classification_name'
        },
        {
          data: 'status',
          name: 'status'
        },
        {
          data: 'time_stamp',
          name: 'time_stamp'
        },
        {
          data: 'action',
          name: 'action'
        },
      ],
    });
  });
  $(document).on('click', '#up_status', function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    var data_id = $(this).attr('data-id');
    if ($(this).prop('checked')) {
      var status = 1;
    } else {
      var status = 0;
    }
    $.ajax({
      type: 'POST',
      url: "{{ route('update_status') }}",
      data: {
        data_id: data_id,
        status: status
      },
      success: function(data) {
        if (data.success != '') {
          Swal.fire({
            text: 'Status has been added Changed.',
            icon: 'success',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok',
          });
          tbl_clss.draw();
        }

      }
    });
  });
</script>


@endsection