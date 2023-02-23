@extends('layouts/main')
@section('content_body')

<style>

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
                <li class="options options-active" onclick="location.href='department-management'">
                  <a href="#" class="no-padding options-a-active">Department Management</a><br>
                  <label class="option-info options-info-active">Allow User to manage respective departments per campuses
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
                  <label>Department Management</label>
                  <label class="account-info">Allow User to manage respective Departments for Campuses
                  </label>
                  {{ csrf_field() }}
                  <form id="dept_form" class="mh-reg-form form-border-bottom" style="height: calc(100% - 100px) !important;">

                    <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3 member-form mp-pv2 shadow-inset-1">
                      <input type="hidden" id="dept_no" name="dept_no">
                      <div class="mp-input-group">
                        <label class="mp-input-group__label">Department Name</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="dept_name" id="dept_name" required="">
                      </div>
                      <div class="mp-input-group">
                        <label class="mp-input-group__label">Campus</label>
                        <select class="mp-input-group__input mp-text-field" name="campus" id="campus" required>
                          <option value="">Select Campus</option>
                          @foreach($campus as $row)
                          <option value="{{ $row->id }}">{{ $row->name }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="mp-input-group">
                        <label class="mp-input-group__label">College / Unit</label>
                        <select class="mp-input-group__input mp-text-field" name="college_unit" id="college_unit" required>
                          <option value="">Select College/Unit</option>
                          @foreach($college_unit as $row)
                          <option value="{{ $row->cu_no }}">{{ $row->college_unit_name }}</option>
                          @endforeach
                        </select>
                      </div>




                      <a class="up-button-green btn-md button-animate-right mp-text-center" id="save_dept" type="submit">
                        <span class="save_dept">Save Record</span>
                      </a>
                      <a class="up-button-grey btn-md button-animate-right mp-text-center" id="cancel_dept">
                        <span class="clear_dept">Clear</span>
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
                    <table class="members-table" style="height: auto;" width="100%" id="department_table">
                      <thead>
                        <tr>
                          <th>
                            <span>Department Name</span>
                          </th>
                          <th>
                            <span>Campus</span>
                          </th>
                          <th>
                            <span>College</span>
                          </th>
                          <th>
                            <span>Created At</span>
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
  $(document).on('click', '#save_dept', function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    if ($('#campus').val() && $('#dept_name').val() && $('#college_unit').val()) {
      var formData = $("#dept_form").serialize();
      if ($('#dept_no').val() != '') {
        $.ajax({
          type: 'POST',
          url: "{{ route('update-department') }}",
          data: formData,
          success: function(data) {
            if (data.success != '') {
              Swal.fire({
                text: 'Department has been Updated Successfully.',
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok',
              });
              $("#dept_form")[0].reset();
              $('#dept_no').val('');
              $('.save_dept').text('Save');
              $('.clear_dept').text('Clear');
              tbl_clss.draw();
            }
          }
        });
      } else {
        $.ajax({
          type: 'POST',
          url: "{{ route('save-department') }}",
          data: formData,
          success: function(data) {
            if (data.success != '') {
              Swal.fire({
                text: 'Department has been added Successfully.',
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok',
              });
              $("#dept_form")[0].reset();
              $('#dept_no').val('');
              $('.save_dept').text('Save');
              $('.clear_dept').text('Clear');
              tbl_clss.draw();
            }
          }
        });
      }
    } else {
      Swal.fire('Error', 'Please input Department,College and Campus', 'error')
    }

  });
  var tbl_clss;
  $(document).ready(function() {
    tbl_clss = $('#department_table').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: "{{ route('department_list') }}",
        type: 'GET',
      },
      columns: [{
          data: 'department_name',
          name: 'department_name'
        },
        {
          data: 'camp_name',
          name: 'camp_name'
        },
        {
          data: 'college_unit_name',
          name: 'college_unit_name'
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
  $(document).on('click', '.remove_dept', function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    var id_dept = $(this).data('id');
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
          url: "{{ route('delete_department') }}",
          data: {
            id_dept: id_dept
          },
          success: function(data) {
            if (data.success) {
              Swal.fire({
                text: 'Department has been Removed Successfully.',
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok',
              });

              tbl_clss.draw();
            }
          }
        });

      }
    });
  });
  $(document).on('click', '#cancel_dept', function() {
    // $("#college_form").clear();
    $("#dept_form")[0].reset();
    $('#dept_no').val('');
    $('.save_dept').text('Save');
    $('.clear_dept').text('Clear');

  });
  $(document).on('click', '.edit_dept', function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    var id_department = $(this).data('id');
    $.ajax({
      type: 'POST',
      url: "{{ route('get_details_dept') }}",
      data: {
        id_department: id_department
      },
      success: function(data) {
        $('#dept_no').val(data.dept_no);
        $('#dept_name').val(data.department_name);
        $('#campus').val(data.campus_id);
        $('#college_unit').val(data.cu_no);
        $('.save_dept').text('Update');
        $('.clear_dept').text('Cancel');
      }
    });

  });
</script>


@endsection