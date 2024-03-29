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
              <!-- <i class="fa fa-cog" aria-hidden="true"></i> -->
            </div>

            <div class="settings-buttons">
              <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-start" id="menu">
                <li class="options options-active" onclick="location.href='department-management'">
                  <a href="#" class="no-padding options-a-active">Department Management</a><br>

                </li>
                <li class="options" onclick="location.href='manage-account'">
                  <a href="#" class="no-padding">Manage Accounts</a><br>

                </li>
                <li class="options" onclick="location.href='campus-management'">
                  <a href="#" class="no-padding">Campus Management</a><br>

                </li>
                <li class="options" onclick="location.href='employee-classification'">
                  <a href="#" class="no-padding">Employee Classification</a><br>

                </li>
                <li class="options" onclick="location.href='college-management'">
                  <a href="#" class="no-padding">College / Unit Management</a><br>

                </li>

                <li class="options " onclick="location.href='status-appointment'">
                  <a href="#" class="no-padding ">Status and Appointments</a><br>

                </li>
                <li class="options " onclick="location.href='sg-modules'">
                  <a href="#" class="no-padding ">SG Modules</a><br>

                </li>
                <li class="options " onclick="location.href='history-logs'">
                  <a href="#" class="no-padding ">History Logs</a><br>

                </li>
                <li class="options " onclick="location.href='backup-database'">
                  <a href="#" class="no-padding ">Backup Database</a><br>

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
                        <input class="mp-input-group__input mp-text-field" type="text" name="dept_name" id="dept_name" required="" data-set="validate-department">
                      </div>
                      <div class="mp-input-group">
                        <label class="mp-input-group__label">Campus</label>
                        <select class="js-example-responsive mp-input-group__input mp-text-field" style="width:100%;" name="campus" id="campus" required data-set="validate-department">
                          <option value="">Select Campus</option>
                          <!-- <option value="all">All Campus</option> -->
                          @foreach($campus as $row)
                          <option value="{{ $row->id }}">{{ $row->name }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="mp-input-group">

                        <label class="mp-input-group__label">College / Unit</label>
                        <select class="js-example-responsive mp-input-group__input mp-text-field" style="width:100%;" name="college_unit" id="college_unit" required data-set="validate-department">
                          <option value="">Select College/Unit</option>
                          <!-- <option value="">Select College/Unit</option>
                          @foreach($college_unit as $row)
                          <option value="{{ $row->cu_no }}">{{ $row->college_unit_name }}</option>
                          @endforeach -->
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

  $(document).on('click', '#save_dept', function() {

    let hasError = false

    const elements = $(document).find(`[data-set=validate-department]`)

    elements.map(function() {
      if ($(this).attr('err-name')) {
        return
      }
      let status = true
      status = validateField({
        element: $(this),
        target: 'validate-department'
      })

      if (!hasError && status) {
        hasError = true
      }
    })

    if (hasError) return

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
              $('#campus').val('').change();
              $('.save_dept').text('Save');
              $('.clear_dept').text('Clear');
              $("#college_unit").html("<option selected value='' > Select College/Unit</option>");
              tbl_clss.draw();
            }
          },
          error: function() {
            Swal.fire({
              text: 'No Changes Made!',
              icon: 'error',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok',
            });
          }
        });
      } else {
        $.ajax({
          type: 'POST',
          url: "{{ route('save-department') }}",
          data: formData,
          success: function(data) {
            if (data.department_name_exist == true) {
              $('[name=dept_name]').val("").trigger("change");
              status = validateField({
                element: $('[name=dept_name]'),
                target: 'validate-department',
                errText: "Department Name Already Exist!"
              })

            }
            if (data.success != false) {
              Swal.fire({
                text: 'Department has been added Successfully.',
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok',
              });
              $("#dept_form")[0].reset();
              $('#dept_no').val('');
              $('#campus').val('').change();;
              $('.save_dept').text('Save');
              $('.clear_dept').text('Clear');
              $("#college_unit").html("<option selected value='' > Select College/Unit</option>");
              tbl_clss.draw();
            }
          },
          error: function() {
            Swal.fire({
              text: 'No Changes Made!',
              icon: 'error',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok',
            });
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
    $('#campus').val('').change();
    $('.save_dept').text('Save');
    $('.clear_dept').text('Clear');
    $("#college_unit").html("<option selected value='' > Select College/Unit</option>");
  });
  $(document).on('click', '.edit_dept', function() {
    clearValidation('dept_name', 'validate-department', $('[name=dept_name]'))
    var campus_id = $(this).data('campus_id');
    var college_unit_id = $(this).data('cu_no');
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
        $('#campus').val(data.campus_id).change();
        $('#college_unit').val(data.cu_no);
        $('.save_dept').text('Update');
        $('.clear_dept').text('Cancel');
      }

    });


    $("#college_unit").html("");

    console.log(campus_id)
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      type: 'POST',
      url: "{{ route('filter_college_unit') }}",
      data: {
        camp_id: campus_id
      },
      success: function(data) {

        $.each(data, function(key, value) {
          console.log(value.campus_id + '' + campus_id)
          if (value.cu_no == college_unit_id) {
            $("#college_unit").append('<option selected value=' + value.cu_no + "> " + value.college_unit_name + '</option>');
          } else {
            $("#college_unit").append('<option value=' + value.cu_no + "> " + value.college_unit_name + '</option>');
          }

        });
      }
    });

  });

  $("#campus").change(function() {
    var campus_id = $("#campus").val();
    $("#college_unit").html("");
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      type: 'POST',
      url: "{{ route('filter_college_unit') }}",
      data: {
        camp_id: campus_id
      },
      success: function(data) {

        $.each(data, function(key, value) {
          console.log(data)

          $("#college_unit").append('<option value=' + value.cu_no + "> " + value.college_unit_name + '</option>');
        });
      }
    });

  })
</script>


@endsection