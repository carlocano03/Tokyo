@extends('layouts/main')
@section('content_body')

<style>
  .search-container {
    background-color: white;
    padding-top: 5px;
    padding-bottom: 10px;
  }

  .middle-content.full {
    width: 100%;
    transition: all .5s;
  }

  .right-content {
    width: 20%;
    opacity: 1;
    transition: all .2s;
  }

  .right-content.full {
    width: -1%;
    opacity: 0;
  }

  .d-none {
    transition: all .5s;
    display: none !important;

  }

  .w-full {
    width: 100%;
  }

  .transition {
    transition: 1s;
    -webkit-transition: 1s;
  }
</style>



<div class="filler"></div>
<div class="col-12  mp-text-fs-large mp-text-c-accent  dashboard mh-content" style="padding:0px !important;">


  <div class="container-fluid">
    <div class="row ">
      <div class="col-lg-2 transition" id="settingsTab" style="padding:0px !important; height: 100%; overflow-y:auto; ">
        <div class="mp-card admin-settingtab" style="padding-bottom:150px;">
          <div class="settings-tab">
            <div class="top-label">

              <label>Settings</label>
              <i class="fa fa-cog" aria-hidden="true"></i>
            </div>

            <div class="settings-buttons">
              <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-start" id="menu">
                <li class="options options-active" onclick="location.href='history-logs'">
                  <a href="#" class="no-padding options-a-active">History Logs</a><br>
                  <label class="option-info options-info-active">Allow User to retrieve and monitor user activity using History logs module.
                    modules
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
      <div class="col-lg-10 mp-mt3 gap-10  " id="settingsContent">
        <div class="button-container mp-mb3">
          <button class="f-button magenta-bg" id="showSettings">Hide Settings</button>
        </div>

        <div class="card-container card p-0">
          <div class="card-header history-logs">
            History Logs
          </div>
          <div class="card-body flex-column history-container ">
            <div class="search-container sticky top-0">
              <input class="mp-input-group__input mp-text-field mp-pt2  " type="text" placeholder="Search here" style="width: 95% ;margin-left: auto;margin-right: auto" />
            </div>
            <div class="history-item">
              <div>
                <span class="font-18">Dela Cruz, Juan</span>
              </div>
              <div>
                <span class="font-13">UP Head Office / Administrator</span>
              </div>
              <div>
                <span class="font-13">Signed in, January 2, 2023 Time: 02:00 pm</span>
              </div>
            </div>
            <div class="history-item">
              <div>
                <span class="font-18">Dela Cruz, Juan</span>
              </div>
              <div>
                <span class="font-13">UP Head Office / Administrator</span>
              </div>
              <div>
                <span class="font-13">Signed in, January 2, 2023 Time: 02:00 pm</span>
              </div>
            </div>
            <div class="history-item">
              <div>
                <span class="font-18">Dela Cruz, Juan</span>
              </div>
              <div>
                <span class="font-13">UP Head Office / Administrator</span>
              </div>
              <div>
                <span class="font-13">Signed in, January 2, 2023 Time: 02:00 pm</span>
              </div>
            </div>
            <div class="history-item">
              <div>
                <span class="font-18">Dela Cruz, Juan</span>
              </div>
              <div>
                <span class="font-13">UP Head Office / Administrator</span>
              </div>
              <div>
                <span class="font-13">Signed in, January 2, 2023 Time: 02:00 pm</span>
              </div>
            </div>
            <div class="history-item">
              <div>
                <span class="font-18">Dela Cruz, Juan</span>
              </div>
              <div>
                <span class="font-13">UP Head Office / Administrator</span>
              </div>
              <div>
                <span class="font-13">Signed in, January 2, 2023 Time: 02:00 pm</span>
              </div>
            </div>
            <div class="history-item">
              <div>
                <span class="font-18">Dela Cruz, Juan</span>
              </div>
              <div>
                <span class="font-13">UP Head Office / Administrator</span>
              </div>
              <div>
                <span class="font-13">Signed in, January 2, 2023 Time: 02:00 pm</span>
              </div>
            </div>
            <div class="history-item">
              <div>
                <span class="font-18">Dela Cruz, Juan</span>
              </div>
              <div>
                <span class="font-13">UP Head Office / Administrator</span>
              </div>
              <div>
                <span class="font-13">Signed in, January 2, 2023 Time: 02:00 pm</span>
              </div>
            </div>
            <div class="history-item">
              <div>
                <span class="font-18">Dela Cruz, Juan</span>
              </div>
              <div>
                <span class="font-13">UP Head Office / Administrator</span>
              </div>
              <div>
                <span class="font-13">Signed in, January 2, 2023 Time: 02:00 pm</span>
              </div>
            </div>
            <div class="history-item">
              <div>
                <span class="font-18">Dela Cruz, Juan</span>
              </div>
              <div>
                <span class="font-13">UP Head Office / Administrator</span>
              </div>
              <div>
                <span class="font-13">Signed in, January 2, 2023 Time: 02:00 pm</span>
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
</script>
@endsection