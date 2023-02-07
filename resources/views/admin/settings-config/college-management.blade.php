@extends('layouts/main')
@section('content_body')

<style>

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
                <li class="options  options-active" onclick="location.href='college-management'">
                  <a href="#" class="no-padding options-a-active">College / Unit Management</a><br>
                  <label class="option-info options-info-active">Allow User to manage respective College and units
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
                  <label>College / Unit Management</label>
                  <label class="account-info">Allow User to manage respective College and Units
                  </label>
                  {{ csrf_field() }}
                  <form id="college_form" class="mh-reg-form form-border-bottom" style="height: calc(100% - 100px) !important;">
                    <input type="hidden" name="cu_no" id="cu_no" value="">
                    <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3 member-form mp-pv2 shadow-inset-1">
                      <div class="mp-input-group">
                        <label class="mp-input-group__label">College / Unit Name</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="college_name" id="college_name" required="">
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

                      <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3 member-form mp-pv2 shadow-inset-1">
                        <input type="hidden" id="app_trailNo">
                        <div class="mp-input-group">
                          <label class="mp-input-group__label">College ID</label>
                          <input class="mp-input-group__input mp-text-field" type="text" name="campus_key" id="campus_key" required="">
                        </div>
                        <div class="mp-input-group">
                          <label class="mp-input-group__label">College / Unit Name</label>
                          <input class="mp-input-group__input mp-text-field" type="text" name="campus_key" id="campus_key" required="">
                        </div>
                        <div class="mp-input-group">
                          <label class="mp-input-group__label">Campus</label>
                          <select class="mp-input-group__input mp-text-field" name="civilstatus" required>
                            <option>campus 1</option>
                            <option>campus 1</option>
                            <option>campus 1</option>
                            <option>campus 1</option>

                          </select>
                        </div>




                        <a class="up-button-green btn-md button-animate-right mp-text-center" id="save_campus" type="submit">
                          <span>Save Record</span>
                        </a>
                        <a class="up-button-grey btn-md button-animate-right mp-text-center">
                          <span>Clear</span>
                        </a>
                        <!-- <button type="submit" class="sss" id="btn-submit">Submit</button> -->

                      </div>

                  </form>


                  <a class="up-button-green btn-md button-animate-right mp-text-center" id="save_college" type="submit">
                    <span class="save_up">Save Record</span>
                  </a>
                  <a class="up-button-grey btn-md button-animate-right mp-text-center" id="clear_btn">
                    <span class="clear_txt">Clear</span>
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
                  <table class="college-table" style="height: auto;" width="100%" id="college_table">
                    <thead>
                      <tr>
                        <th>
                          <span>College / Unit Name</span>
                        </th>
                        <th>
                          <span>Campus</span>
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
  $(document).on('click', '#save_college', function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    if ($('#campus').val() && $('#college_name').val()) {
      var formData = $("#college_form").serialize();
      if ($('#cu_no').val() != '') {
        $.ajax({
          type: 'POST',
          url: "{{ route('update-college') }}",
          data: formData,
          success: function(data) {
            if (data.success != '') {
              Swal.fire({
                text: 'College/Unit has been Updated Successfully.',
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok',
              });
              tbl_clss.draw();
            }
          }
        });
      } else {
        $.ajax({
          type: 'POST',
          url: "{{ route('save-college') }}",
          data: formData,
          success: function(data) {
            if (data.success != '') {
              Swal.fire({
                text: 'College/Unit has been added Successfully.',
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok',
              });
              tbl_clss.draw();
            }
          }
        });
      }
    } else {
      Swal.fire('Error', 'Please input College/Unit Name and Campus', 'error')
    }

  });
  var tbl_clss;
  $(document).ready(function() {
    tbl_clss = $('#college_table').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: "{{ route('college_list') }}",
        type: 'GET',
      },
      columns: [{
          data: 'college_unit_name',
          name: 'college_unit_name'
        },
        {
          data: 'camp_name',
          name: 'camp_name'
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
  $(document).on('click', '.remove_coll', function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    var id_college = $(this).data('id');
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
          url: "{{ route('delete_college') }}",
          data: {
            id_college: id_college
          },
          success: function(data) {
            if (data.success) {
              Swal.fire({
                text: 'College/Unit has been Removed Successfully.',
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

  $(document).on('click', '#clear_btn', function() {
    // $("#college_form").clear();
    $("#college_form")[0].reset();
    $('#cu_no').val('');
    $('.save_up').text('Save');
    $('.clear_txt').text('Clear');

  });
  $(document).on('click', '.edit_coll', function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    var id_college = $(this).data('id');
    $.ajax({
      type: 'POST',
      url: "{{ route('get_details_coll') }}",
      data: {
        id_college: id_college
      },
      success: function(data) {
        $('#cu_no').val(data.cu_no);
        $('#college_name').val(data.college_unit_name);
        $('#campus').val(data.camp_id);
        $('.save_up').text('Update');
        $('.clear_txt').text('Cancel');
      }
    });

  });
</script>

@endsection