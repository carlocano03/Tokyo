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
                <li class="options options-active" onclick="location.href='sg-modules'">
                  <a href="#" class="no-padding options-a-active">SG Modules</a><br>
                  <label class="option-info options-info-active">Allow User to pre-setup salary grade range and assign salary grade category for election
                    modules
                  </label>
                </li>
                <li class="options" onclick="location.href='manage-account'">
                  <a href="#" class="no-padding">Manage Accounts</a><br>
                  <label class="option-info">Allow User to create and manage system user accounts, You also can manage permissions and
                    authorizations.
                  </label>
                </li>
                <li class="options " onclick="location.href='campus-management'">
                  <a href="#" class="no-padding ">Campus Management</a><br>
                  <label class="option-info">Allow User to manage respective campus; key, names, and clusters
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
                <li class="options  " onclick="location.href='status-appointment'">
                  <a href="#" class="no-padding ">Status and Appointments</a><br>
                  <label class="option-info  ">Allow User to pre-setup, manage the employee status and appointments.
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
                  <label>Salary Grade Modules</label>
                  <label class="account-info">Allow User to pre-setup salary grade range and assign salary grade category for election
                    modules
                  </label>
                  {{ csrf_field() }}
                  <form id="salaryg_form" class="mh-reg-form form-border-bottom" style="height: calc(100% - 100px) !important;">

                    <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3 member-form mp-pv2 shadow-inset-1">
                      <input type="hidden" id="ref_sgid" name="ref_sgid">
                      <div class="mp-input-group">
                        <label class="mp-input-group__label">Salary Grade Number</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="salaryg_num" id="salaryg_num" required="">
                      </div>
                      <div class="mp-input-group">
                        <label class="mp-input-group__label">Salary Grade Amount(from)</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="salaryg_frm" id="salaryg_frm" required="">
                      </div>
                      <div class="mp-input-group">
                        <label class="mp-input-group__label">Salary Grade Amount(to)</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="slaryg_to" id="slaryg_to" required="">
                      </div>
                      <div class="mp-input-group">
                        <label class="mp-input-group__label">Salary Grade Category</label>
                        <select class="mp-input-group__input mp-text-field" name="salarycat" id="salarycat" required>
                          <option value="1-15">1-15</option>
                          <option value="16-33">16-33</option>
                        </select>
                      </div>


                      <a class="up-button-green btn-md button-animate-right mp-text-center" id="save_sg" type="submit">
                        <span class="save_text">Save Record</span>
                      </a>
                      <a class="up-button-grey btn-md button-animate-right mp-text-center" id="cancel">
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
                    <table class="members-table" style="height: auto;" width="100%" id="sg_table">
                      <thead>
                        <tr>
                          <th>
                            <span>SG</span>
                          </th>
                          <th>
                            <span>Range From</span>
                          </th>
                          <th>
                            <span>Range To</span>
                          </th>
                          <th>
                            <span>SG Category</span>
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
  var tbl_clss;
  $(document).ready(function() {
    tbl_clss = $('#sg_table').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: "{{ route('salaryg_list') }}",
        type: 'GET',
      },
      columns: [{
          data: 'sg_no',
          name: 'sg_no'
        },
        {
          data: 'min_bracket',
          name: 'min_bracket'
        },
        {
          data: 'max_bracket',
          name: 'max_bracket'
        },
        {
          data: 'salary_cat',
          name: 'salary_cat'
        },
        {
          data: 'action',
          name: 'action'
        },
      ],
    });
  });
  $(document).on('click', '#cancel', function() {
    $("#salaryg_form")[0].reset();
    $('#ref_sgid').val('');
    $('.save_text').text('Save Record');
    $('.clear_txt').text('Clear');
  });
  $(document).on('click', '#save_sg', function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    if ($('#salaryg_num').val() && $('#salaryg_frm').val() && $('#slaryg_to').val() && $('#salarycat').val()) {
      if ($('#ref_sgid').val()) {
        var formData = $("#salaryg_form").serialize();
        $.ajax({
          type: 'POST',
          url: "{{ route('update-salaryg') }}",
          data: formData,
          success: function(data) {
            if (data.error) {
              Swal.fire({
                text: 'Salary Grade already exist.',
                icon: 'error',
                confirmButtonColor: '#FF0000',
                confirmButtonText: 'Ok',
              });
            } else if (data.success != '') {
              Swal.fire({
                text: 'Salary Grade has been Updated Successfully.',
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok',
              });
              $("#salaryg_form")[0].reset();
              $('#ref_sgid').val('');
              $('.save_text').text('Save Record');
              $('.clear_txt').text('Clear');
              tbl_clss.draw();
            }
          }

        });
      } else {
        var formData = $("#salaryg_form").serialize();

        $.ajax({
          type: 'POST',
          url: "{{ route('save-salaryg') }}",
          data: formData,
          success: function(data) {
            if (data.error) {
              Swal.fire({
                text: 'Salary Grade already exist.',
                icon: 'error',
                confirmButtonColor: '#FF0000',
                confirmButtonText: 'Ok',
              });
            } else if (data.success != '') {
              Swal.fire({
                text: 'Salary Grade has been added Successfully.',
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok',
              });
              $("#salaryg_form")[0].reset();
              $('#ref_sgid').val('');
              $('.save_text').text('Save Record');
              $('.clear_txt').text('Clear');
              tbl_clss.draw();
            }
          }

        });
      }
    } else {
      Swal.fire('Error', 'Please Complete the Fields', 'error')
    }


  });
  $(document).on('click', '.update_sg', function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    var ref_sgno = $(this).data('id');
    $.ajax({
      type: 'POST',
      url: "{{ route('get_details_sg') }}",
      data: {
        ref_sgno: ref_sgno
      },
      success: function(data) {
        $('#ref_sgid').val(data.ref_sg_ID);
        $('#salaryg_num').val(data.sg_no);
        $('#salaryg_frm').val(data.min_bracket);
        $('#slaryg_to').val(data.max_bracket);
        $('#salarycat').val(data.salary_cat);
        $('.save_text').text('Update Record');
        $('.clear_txt').text('Cancel');
      }
    });

  });
</script>
@endsection