@extends('layouts/main')
@section('content_body')

<style>

</style>




<div class="filler"></div>
<div class="col-12  mp-text-fs-large mp-text-c-accent  dashboard mh-content" style="padding:0px !important;">


  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-2" id="settingsTab" style="padding:0px !important; height: 100%; overflow-y:auto; ">
        <div class="mp-card  admin-settingtab" style="padding-bottom:150px;">
          <div class="settings-tab">
            <div class="top-label">
              <label>Settings</label>
              <!-- <i class="fa fa-cog" aria-hidden="true"></i> -->
            </div>

            <div class="settings-buttons">
              <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-start" id="menu">
                <li class="options options-active" onclick="location.href='campus-management'">
                  <a href="#" class="no-padding options-a-active">Campus Management</a><br>

                </li>
                <li class="options" onclick="location.href='manage-account'">
                  <a href="#" class="no-padding">Manage Accounts</a><br>

                </li>

                <li class="options " onclick="location.href='employee-classification'">
                  <a href="#" class="no-padding ">Employee Classification</a><br>

                </li>
                <li class="options " onclick="location.href='college-management'">
                  <a href="#" class="no-padding">College / Unit Management</a><br>

                </li>
                <li class="options" onclick="location.href='department-management'">
                  <a href="#" class="no-padding ">Department Management</a><br>

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
                  <label>Create New Campus</label>
                  <label class="account-info">Allow User to manage respective campus; key, names, and clusters
                  </label>
                  {{ csrf_field() }}
                  <form id="campus_form" class="mh-reg-form form-border-bottom" style="height: calc(100% - 100px) !important;">

                    <div class="mp-pt3 d-flex gap-10 flex-column mp-pb3 member-form mp-pv2 shadow-inset-1">
                      <input type="hidden" id="campus_id" name="campus_id">
                      <div class="mp-input-group">
                        <label class="mp-input-group__label">Campus Key</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="campus_key" id="campus_key" required="" data-set="validate-campus">
                      </div>
                      <div class="mp-input-group">
                        <label class="mp-input-group__label">Campus Name</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="campus_name" id="campus_name" required="" data-set="validate-campus">
                      </div>
                      <div class="mp-input-group">
                        <label class="mp-input-group__label">Campus Cluster No.</label>
                        <select class="js-example-responsive mp-input-group__input mp-text-field" style="width:100%;" name="cluster_id" id="cluster_id" required data-set="validate-campus">
                          <option value="">Select Cluster No.</option>
                          <option value="1">Cluster 1 - DSB</option>
                          <option value="2">Cluster 2 - LBOU</option>
                          <option value="3">Cluster 3 - MLAPGH</option>
                          <option value="4">Cluster 4 - CVM</option>




                        </select>
                      </div>
                      <!-- <div class="mp-input-group">
                      <label class="mp-input-group__label">Last Name</label>
                      <input class="mp-input-group__input mp-text-field" type="text" name="lastname" required="">
                    </div> -->



                      <a class="up-button-green btn-md button-animate-right mp-text-center" id="save_campus" type="submit">
                        <span class="save_up">Save Record</span>
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
                            <span>Cluster ID</span>
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
  var campus_table;

  function change_button() {

  }

  window.onload = change_button();

  $(document).ready(function() {
    campus_table = $('#campus_table').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: "{{ route('campus_list') }}",
        type: 'GET',
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
          data: 'cluster_id',
          name: 'cluster_id'
        },
        {
          data: 'action',
          name: 'action',

        },
      ]
    });
  });
  $(document).on('click', '#cancel', function() {
    $("#campus_form")[0].reset();
    $('#campus_id').val('');
    $('.save_up').text('Save Record');
    $('.clear_txt').text('Clear');
    $('#cluster_id').val('').trigger("change");
  });
  $(document).on('click', '#save_campus', function() {

    let hasError = false

    const elements = $(document).find(`[data-set=validate-campus]`)

    elements.map(function() {
      if ($(this).attr('err-name')) {
        return
      }
      let status = true
      status = validateField({
        element: $(this),
        target: 'validate-campus'
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
    if ($('#campus_id').val()) {
      var formData = $("#campus_form").serialize();
      $.ajax({
        type: 'POST',
        url: "{{ route('update-campus') }}",
        data: formData,
        success: function(data) {
          if (data.success != '') {
            Swal.fire({
              text: 'Campus has been added Updated Successfully.',
              icon: 'success',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok',
            });
            $("#campus_form")[0].reset();
            $('#campus_id').val('').trigger("change");
            $('#cluster_id').val('').trigger("change");
            $('.save_up').text('Save Record');
            $('.clear_txt').text('Clear');

            campus_table.draw();
          }

        }
      });
    } else {
      var formData = $("#campus_form").serialize();
      $.ajax({
        type: 'POST',
        url: "{{ route('add_campus') }}",
        data: formData,
        success: function(data) {
          if (data.campus_key_exist == true) {
            $("[name=campus_key]").val("")
            status = validateField({
              element: $('[name=campus_key]'),
              target: 'validate-campus',
              errText: "Campus Key Already Exist!"
            })
            hasError = true
            $("[name=campus_key]").focus();
          }
          if (data.campus_name_exist == true) {
            $('#campus_name').val("").trigger("change");
            status = true;
            hasError = true
            status = validateField({
              element: $('#campus_name'),
              target: 'validate-campus',
              errText: "Campus Name Already Exist!"
            })
          }
          if (data.success == true) {
            Swal.fire({
              text: 'Campus has been added Successfully.',
              icon: 'success',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok',
            });
            $("#campus_form")[0].reset();
            $('#campus_id').val('').trigger("change");
            $('#cluster_id').val('').trigger("change");
            $('.save_up').text('Save Record');
            $('.clear_txt').text('Clear');
            campus_table.draw();
          }

        }
      });
    }

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
              $("#campus_form")[0].reset();
              $('#campus_id').val('').trigger("change");
              $('#cluster_id').val('').trigger("change");
              $('.save_up').text('Save Record');
              $('.clear_txt').text('Clear');
              campus_table.draw();
            }
          }
        });

      }
    });

  });
  $(document).on('click', '.edit_campus', function() {
    clearValidation('campus_key', 'validate-campus', $('[name=campus_key]'))
    clearValidation('campus_name', 'validate-campus', $('[name=campus_name]'))
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    var id_campus = $(this).attr('data-id');
    $.ajax({
      type: 'POST',
      url: "{{ route('get_details_campus') }}",
      data: {
        id_campus: id_campus
      },
      success: function(data) {
        $('#campus_id').val(data.id);
        $('#campus_key').val(data.campus_key);
        $('#campus_name').val(data.name);
        $('#cluster_id').val(data.cluster_id).trigger("change");
        $('.save_up').text('Update Record');
        $('.clear_txt').text('Cancel');
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