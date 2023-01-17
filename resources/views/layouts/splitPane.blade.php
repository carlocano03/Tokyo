@extends('layouts/index')
@section('content')


    <!-- mobile transition -->
    <div class="mobile-header">
        <div class="logo-title">
            <div class="mp-pb4  mp-text-center logo-text">
                <img src="{!! asset('assets\favicon\ms-icon-310x310.png') !!}" alt="UPPFI">
                <br>
                <label for="">
                    UP Provident Fund
                </label>

            </div>
        </div>
    </div>
    <div class="transition-background">

    </div>
    <div class="custom-modal not-visible" id="modal_name">
        <div class="modal-container">
            <div class="modal-content">
                <div class="modal-header">
                    MODAL HEADER
                </div>
                <div class="modal-body">
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Hic maiores ut consectetur qui animi corporis
                    rem eveniet dolorem quia, esse velit iure, suscipit accusamus dignissimos natus dolorum deleniti iusto
                    delectus?
                </div>

                <div class="modal-footer">
                    <div class="mp-container">
                        <div class="row">
                            <button class="up-button btn-md " id="modal_name_close" value="">
                                <span>Close</span>
                            </button>
                            <button class="up-button btn-md  " type="submit" value="" id="modal_name_close">
                                <span>Ok</span>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="mp-split-pane">
        <div class="mp-split-pane__left transition-all d-flex flex-column" id="leftsection">
            <div class="container-fluid mp-pt3 mp-pb5 mp-mvauto mp-mhauto" id="loginform">
                <div class="row align-items-center justify-content-center">
                    <div class="col-12 col-sm-10">
                    @section('loginForm')
                    @show

                </div>
            </div>
        </div>

        <div id="statusTrailForm" hidden="hidden" class="container-fluid relative pv-3">
            @section('status-trail-form')
            @show
        </div>

        <div id="registrationform" hidden="hidden" class="container-fluid relative pv-3-auto"
            style="height: calc(100% - 53px)">
            @section('registration-personal-form')
            @show

        </div>
        <!-- <div class="mv-5-auto items-between  bg-white mt-auto d-none flex-column mb-5" id="control">
            <div class="d-flex items-between  mp-pb2 mp-pt2 mp-pv3 border-style">
                <a class="up-button btn-md button-animate-left hover-back" id="back" value="">
                    <span>Back</span>
                </a>
                <a class="up-button btn-md button-animate-right " type="submit" value="step-2" id="next-btn">
                    <span>Next</span>
                </a>
            </div>
        </div> -->

        <div id="resetPasswordForm" hidden="hidden" class="container-fluid relative pv-3">
            @section('reset-password-form')
            @show
        </div>

        <div class="mp-split-pane__right">
            @section('right')
            @show
        </div>
    </div>

</div>
<script>
    // $("#loginform").attr("hidden", true);
    // // var $ids = $('[id="loginForm"]');

    // // $ids.each(function(i, e) {
    // //     $(e).attr("hidden", true);
    // // });
    // $("#step-1").attr("hidden", true);
    // // var $ids = $('[id="loginForm"]');

    // // $ids.each(function(i, e) {
    // //     $(e).attr("hidden", true);
    // // });
    // $("#registrationform").removeAttr("hidden");
    // // var $ids = $('[id="registrationform"]');
    // // $ids.each(function(i, e) {
    // //     $(e).removeAttr("hidden");
    // // });

    var stepTitle = ["Personal Information", "Employment Details", "Membership Details"]

    var my_handlers = {

        fill_provinces: function() {
            var region = $(this).val().split('|');
            var region_code = region[0];
            $('#province').ph_locations('fetch_list', [{
                "region_code": region_code
            }]);

        },

        fill_cities: function() {
            var prov = $(this).val().split('|');
            var province_code = prov[0];
            $('#city').ph_locations('fetch_list', [{
                "province_code": province_code
            }]);
        },

        fill_barangays: function() {
            var city = $(this).val().split('|');
            var city_code = city[0];
            $('#barangay').ph_locations('fetch_list', [{
                "city_code": city_code
            }]);
        },

        fill_present_provinces: function() {
            var region = $(this).val().split('|');
            var region_code = region[0];
            $('#present_province').ph_locations('fetch_list', [{
                "region_code": region_code
            }]);

        },

        fill_present_cities: function() {
            var prov = $(this).val().split('|');
            var province_code = prov[0];
            $('#present_city').ph_locations('fetch_list', [{
                "province_code": province_code
            }]);
        },

        fill_present_barangays: function() {
            var city = $(this).val().split('|');
            var city_code = city[0];
            $('#present_barangay').ph_locations('fetch_list', [{
                "city_code": city_code
            }]);
        }
    };

    $(function() {
        $('#province').on('change', my_handlers.fill_cities);
        $('#city').on('change', my_handlers.fill_barangays);

        $('#province').ph_locations({
            'location_type': 'provinces'
        });
        $('#city').ph_locations({
            'location_type': 'cities'
        });
        $('#barangay').ph_locations({
            'location_type': 'barangays'
        });

        $('#province').ph_locations('fetch_list');

        $('#present_province').on('change', my_handlers.fill_present_cities);
        $('#present_city').on('change', my_handlers.fill_present_barangays);

        $('#present_province').ph_locations({
            'location_type': 'provinces'
        });
        $('#present_city').ph_locations({
            'location_type': 'cities'
        });
        $('#present_barangay').ph_locations({
            'location_type': 'barangays'
        });

        $('#present_province').ph_locations('fetch_list');
    });

    $(document).on('click', '#modal_name_pop', function(e) {
        $("#modal_name").addClass("visible")
        $("#modal_name").removeClass("not-visible")
    })
    $(document).on('click', '#modal_name_close', function(e) {
        $("#modal_name").addClass("not-visible")
        $("#modal_name").removeClass("visible")
    })

    $(document).on('click', '#status_trail', function(e) {
        $("#loginform").attr("hidden", true);
        $("#statusTrailForm").removeAttr("hidden");
        $("#leftsection").removeClass("transition-all").addClass("transition-all-cubic");
        $("#leftsection").addClass("mw-600").addClass("w-600");

        // $("#control").removeClass("d-none").addClass("d-flex");
    })

    //forgot password
    $(document).on('click', '#forgot_password', function(e) {
        $("#loginform").attr("hidden", true);
        $("#resetPasswordForm").removeAttr("hidden");
        $("#leftsection").removeClass("transition-all").addClass("transition-all-cubic");
        $("#leftsection").addClass("mw-600").addClass("w-600");
        // $("#control").removeClass("d-none").addClass("d-flex");

    })

    $(document).on('click', '#fp_back', function(e) {
        $("#resetPasswordForm").attr("hidden", true);
        $("#statusTrailForm").attr("hidden", true);
        $("#loginform").removeAttr("hidden");
        $("#leftsection").removeClass("mw-600").removeClass("w-600");
        setTimeout(function timout() {
            $("#leftsection").removeClass("transition-all-cubic").addClass("transition-all");
        }, 400)
    })

    $(document).on('click', '#register', function(e) {
        $("#loginform").attr("hidden", true);
        $("#registrationform").removeAttr("hidden");
        $("#leftsection").addClass("mw-600").addClass("w-600");
        $("#control").removeClass("d-none").addClass("d-flex");

    })
    var reference_code;
    var originalData_ext;
    $(document).on('click', '#back', function(e) {
        var backValue = $(this).attr('value')
        if (backValue == 'step-1') {
            originalData = $("#member_forms").serialize();
            console.log(originalData);
            $("#step-1").removeClass('d-none').addClass("d-flex");
            $("#step-2").removeClass('d-flex').addClass("d-none");
            $("#back").attr('value', "")
            $("#next-btn").attr('value', 'step-2')
            $("#line").removeClass('step-2').addClass('step-1')
            $("#registration-title").text(stepTitle[0])
            $("#stepper-2").removeClass("active")
            $("#member_forms_con").removeClass('mh-reg-form');
            $("#member_forms").addClass('mh-reg-form');
        } else if (backValue == 'step-2') {
            originalData_ext = $("#member_forms_con").serialize();
            $("#step-2").removeClass('d-none').addClass("d-flex");
            $("#step-3").removeClass('d-flex').addClass("d-none");
            $("#back").attr('value', "step-1")
            $("#next-btn").attr('value', 'step-3')
            $("#line").removeClass('step-3').addClass('step-2')
            $("#registration-title").text(stepTitle[1])
            $("#stepper-3").removeClass("active");
            $("#member_forms_3").removeClass('mh-reg-form');
            $("#member_forms_con").addClass('mh-reg-form');
        } else {
            $("#registrationform").attr("hidden", true);
            $("#statusTrailForm").attr("hidden", true);
            $("#loginform").removeAttr("hidden");
            $("#next-btn").attr('value', 'step-2');
            $("#leftsection").removeClass("mw-600").removeClass("w-600");
            $("#control").removeClass("d-flex").addClass("d-none");
        }
        scrollToTop()
    })
    var reference_no;
    var mem_id;
    var personnel_id;
    var employee_no;
    var employee_details_ID;
    var originalData;

    $(document).on('click', '#next-btn', function(e) {
        var nextValue = $(this).attr('value')
        if (nextValue == 'step-2') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (!personnel_id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You want to continue this will generate your application number.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('add_member') }}",
                            data: $('#member_forms').serialize(),
                            beforeSend: function() {
                                $('#loading').show();
                            },
                            success: function(data) {
                                if (data.success != '') {
                                    reference_no = data.randomnum;
                                    mem_id = data.mem_id;
                                    personnel_id = data.success;
                                    Swal.fire({
                                        text: 'This is your reference code:' + ' ' +
                                            reference_no,
                                        icon: 'success'
                                    });
                                    $('.applicationNo').show(200);
                                    $('#application_no').text(reference_no);
                                    $('#app_no').val(reference_no);
                                    $('#test').val(reference_no);
                                }
                            },
                            complete: function(data) {
                                $('#loading').hide();
                            },
                        });
                    } else {
                        swal.fire("You cancelled your transaction.");
                    }
                });
            } else {
                if (originalData !== $("#member_forms").serialize()) {
                    Swal.fire({
                        title: 'Changes have been detected',
                        text: 'Would you like to apply the updates?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var formDatas = $("#member_forms").serialize();
                            var additionalData = {
                                'mem_id': mem_id,
                                'personnel_id': personnel_id,
                            };
                            formDatas += '&' + $.param(additionalData);
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('add_member_update') }}",
                                data: formDatas,
                                success: function(data) {
                                    if (data.success != '') {
                                        mem_id = data.mem_id;
                                        personnel_id = data.success;
                                        Swal.fire({
                                            title: 'Updates applied successfully.',
                                            icon: 'success'
                                        });
                                    }
                                }
                            });
                        } else {
                            Swal.fire('Warning!',
                                'Update was cancelled by the user. No changes were made.', 'warning'
                            );
                        }
                    });

                }
            }
            $("#step-1").removeClass('d-flex').addClass("d-none");
            $("#member_forms").removeClass('mh-reg-form');
            $("#member_forms_con").addClass('mh-reg-form');
            $("#step-2").removeClass('d-none').addClass("d-flex");
            $("#back").attr('value', 'step-1')
            $(this).attr('value', 'step-3')
            $("#line").removeClass('step-1').addClass('step-2')
            $("#registration-title").text(stepTitle[1])
            $("#stepper-2").addClass("active")
        } else if (nextValue == 'step-3') {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            if (!employee_details_ID) {
                var formData = $("#member_forms_con").serialize();
                var additionalData = {
                    'mem_id': mem_id,
                };
                formData += '&' + $.param(additionalData);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('add_member_con') }}",
                    data: formData,
                    success: function(data) {
                        if (data.success != '') {
                            employee_no = data.emp_no;
                            employee_details_ID = data.success;
                            $("#step-2").removeClass('d-flex').addClass("d-none");
                            $("#step-3").removeClass('d-none').addClass("d-flex");
                            $("#back").attr('value', 'step-2')
                            $("#member_forms_con").removeClass('mh-reg-form');
                            $("#member_forms_3").addClass('mh-reg-form');
                            $(this).attr('value', 'step-end')
                            $("#line").removeClass('step-2').addClass('step-3')
                            $("#registration-title").text(stepTitle[2])
                            $("#stepper-3").addClass("active")
                        } else {
                            Swal.fire({
                                title: 'Employee No are already used.',
                                icon: 'error'
                            });

                            $('#employee_no').focus();
                        }
                    }
                });
            } else {
                if (originalData_ext !== $("#member_forms_con").serialize()) {
                    Swal.fire({
                        title: 'Changes have been detected.',
                        text: 'Would you like to apply the updates?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var formData = $("#member_forms_con").serialize();
                            var additionalData = {
                                'mem_id': mem_id,
                                'employee_details_ID': employee_details_ID,
                            };
                            formData += '&' + $.param(additionalData);
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('add_member_con_up') }}",
                                data: formData,
                                success: function(data) {
                                    if (data.success != '') {
                                        employee_no = data.emp_no;
                                        employee_details_ID = data.success;
                                        Swal.fire({
                                            title: 'Updates applied successfully.',
                                            icon: 'success'
                                        });
                                        $("#step-2").removeClass('d-flex').addClass(
                                            "d-none");
                                        $("#step-3").removeClass('d-none').addClass(
                                            "d-flex");
                                        $("#back").attr('value', 'step-2')
                                        $("#member_forms_con").removeClass('mh-reg-form');
                                        $("#member_forms_3").addClass('mh-reg-form');
                                        $(this).attr('value', 'step-end')
                                        $("#line").removeClass('step-2').addClass('step-3')
                                        $("#registration-title").text(stepTitle[2])
                                        $("#stepper-3").addClass("active")
                                    } else {
                                        Swal.fire({
                                            title: 'Employee No are already used.',
                                            icon: 'error'
                                        });

                                        $('#employee_no').focus();
                                    }
                                }
                            });
                        } else {
                            swal.fire("Update was cancelled by the user. No changes were made.");
                            $("#step-2").removeClass('d-flex').addClass("d-none");
                            $("#step-3").removeClass('d-none').addClass("d-flex");
                            $("#back").attr('value', 'step-2')
                            $("#member_forms_con").removeClass('mh-reg-form');
                            $("#member_forms_3").addClass('mh-reg-form');
                            $(this).attr('value', 'step-end')
                            $("#line").removeClass('step-2').addClass('step-3')
                            $("#registration-title").text(stepTitle[2])
                            $("#stepper-3").addClass("active")
                        }
                    });

                } else {
                    $("#step-2").removeClass('d-flex').addClass("d-none");
                    $("#step-3").removeClass('d-none').addClass("d-flex");
                    $("#back").attr('value', 'step-2')
                    $("#member_forms_con").removeClass('mh-reg-form');
                    $("#member_forms_3").addClass('mh-reg-form');
                    $(this).attr('value', 'step-end')
                    $("#line").removeClass('step-2').addClass('step-3')
                    $("#registration-title").text(stepTitle[2])
                    $("#stepper-3").addClass("active")
                }

            }

        }
        scrollToTop()
    });

    $(document).on('submit', '#member_forms_3', function(e) {
        e.preventDefault();

        $.ajax({
            method: 'POST',
            url: "{{ route('add_member_details') }}",
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(data) {
                if (data.success != '') {
                    Swal.fire({
                        title: 'Thank you!',
                        text: "Registration completed",
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.open();
                        }
                    })
                    $("#step-2").removeClass('d-flex').addClass("d-none");
                    $("#step-3").removeClass('d-none').addClass("d-flex");
                    $("#back").attr('value', 'step-2')
                    $("#member_forms_con").removeClass('mh-reg-form');
                    $("#member_forms_3").addClass('mh-reg-form');
                    $(this).attr('value', 'step-end')
                    $("#line").removeClass('step-2').addClass('step-3')
                    $("#registration-title").text(stepTitle[2])
                    $("#stepper-3").addClass("active")
                } 
            }
        });

    });

    $(document).on('click', '#add_dependent', function() {
        var name = $('#dependent_name').val();
        var bday = $('#dependent_bday').val();
        var relation = $('#dependent_relation').val();
        // var member_id = mem_id

        if (name != '' && bday != '' && relation != '') {
            $.ajax({
                url: "{{ route('add_benefeciaries') }}",
                data: {
                    name: name,
                    bday: bday,
                    relation: relation,
                    employee_no: employee_no
                },
                method: "POST",
                success: function(data) {
                    if (data.success == 'Exists') {
                        Swal.fire('Error!', 'Benefeciary already exists.', 'error');
                    } else {
                        var table = $('#dependentTable').DataTable();
                        table.draw();
                        $('#dependent_name').val('');
                        $('#dependent_bday').val('');
                        $('#dependent_relation').val('');
                    }
                }
            });
        } else {
            Swal.fire('Warning!', 'Please filled up dependent fields.', 'warning');
        }
    });

    $(document).ready(function() {
        // $('.applicationNo').hide();
        var id = employee_no;
        console.log(id);
        var tableDependent = $('#dependentTable').DataTable({
            ordering: false,
            info: false,
            searching: false,
            paging: false,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('getBeneficiary') }}",
                data: function(d) {
                    d.employee_no = employee_no
                }
            },
            columns: [{
                    data: 'fullname',
                    name: 'fullname'
                },
                {
                    data: 'date_birth',
                    name: 'date_birth'
                },
                {
                    data: 'relationship',
                    name: 'relationship'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $(document).on('click', '.delete', function() {
            var ben_ID = $(this).attr('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to remove this beneficiary.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('remove_benefeciaries') }}",
                        data: {
                            ben_ID: ben_ID
                        },
                        method: "POST",
                        success: function(data) {
                            if (data.success != '') {
                                var table = $('#dependentTable').DataTable();
                                table.draw();
                            }
                        }
                    });
                }
            })
        });

        $("#monthly_salary").keyup(function() {
            var inputValue = $(this).val();
            inputValue = inputValue.replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            var decimalAdded = inputValue.split(".");
            if (decimalAdded[1] && decimalAdded[1].length > 2) {
                inputValue = decimalAdded[0] + "." + decimalAdded[1].substring(0, 2);
            }
            $(this).val(inputValue);
        });
    });

    $(document).on('click', '#perm_add_check', function(e) {
        if ($(this).prop("checked")) {
            var myString = $('#present_province').val();
            var myString1 = $('#present_city').val();
            var myString2 = $('#present_barangay').val();
            var myString3 = $('#present_bldg_street').val();
            var myString4 = $('#present_zipcode').val();
            var targetChar = '|';
            var index = myString.indexOf(targetChar);
            var index1 = myString1.indexOf(targetChar);
            var index2 = myString2.indexOf(targetChar);
            if (index !== -1) {
                var valueAfterTargetChar = myString4 + ' ' + myString3 + ' ' + myString2.split(targetChar)[1] +
                    ' ' + myString1.split(targetChar)[1] + ' ' + myString.split(targetChar)[1];
                $('#same_add').val(valueAfterTargetChar);
                $('.same_div').hide();
            } else {
                Swal.fire({
                    title: 'Please complete your Present Address',
                    text: 'Thank you!',
                    icon: 'error'
                });
            }
        } else {
            $('.same_div').show();
        }
    });
    $(document).on('click', '#percentage_check', function(e) {
        if ($(this).prop("checked")) {
            $('#fixed_amount').prop('disabled', true);
        } else {
            $('#fixed_amount').prop('disabled', false);
        }
    });
    $(document).on('click', '#fixed_amount_check', function(e) {
        if ($(this).prop("checked")) {
            $('#percentage_bsalary').prop('disabled', true);
        } else {
            $('#percentage_bsalary').prop('disabled', false);
        }
    });

    $('#percentage_bsalary').on('keypress', function(event) {
        var key = event.which;
        if ((key >= 48 && key <= 57) || key === 8) {
            var value = parseInt($(this).val() + String.fromCharCode(key));
            if (value < 1 || value > 100) {
                return false;
            }

        } else {
            return false;
        }
    });
    $(document).on('input', '#percentage_bsalary', function(e) {
        var input1 = $("#percentage_bsalary").val();
        var input2 = $("#monthly_salary").val().replace(/,/g, '');
        var percentage = (input1 / 100) * input2;
        $('#computed_amount').html(percentage);
        $('#percent_amt').val(percentage);
    });

    function scrollToTop() {
        $('html, body, div, div, div, form').animate({
            scrollTop: $('#leftsection').offset().top - 20
        }, 300);
    }
</script>
@endsection
