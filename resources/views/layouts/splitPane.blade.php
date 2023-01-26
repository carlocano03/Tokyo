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
            style="height: calc(100% - 0px)">
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
    window.onload = function() {
        setTimeout(function() {
            $('.mobile-header').hide(300);
        }, 1000);
    };
    
    if ($(window).width() < 768) {
        $('.mobile-header').show();
        window.onload = function() {
            setTimeout(function() {
                $('.mobile-header').hide(300);
            }, 1000);
        };
    }

    function ckChange(ckType) {
        var ckName = document.getElementsByClassName(ckType.className);
        for (var i = 0; i < ckName.length; i++) {
            if (!ckType.checked) {
                ckName[i].disabled = false;
            } else {
                if (!ckName[i].checked) {
                    ckName[i].disabled = true;
                } else {
                    ckName[i].disabled = false;
                }
            }
        }
    }
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

    //Continue Application
    $(document).on('click', '#cont_app', function(e) {
        $("#loginform").attr("hidden", true);
        $("#registrationform").removeAttr("hidden");
        $("#leftsection").addClass("mw-600").addClass("w-600");
        $("#control").removeClass("d-none").addClass("d-flex");
    });

    var reference_code;
    var originalData_ext;
    $(document).on('click', '#back', function(e) {
        var backValue = $(this).attr('value')
        console.log(backValue);
        if (backValue == 'step-1') {
            originalData = $("#member_forms").serialize();
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

            if ($(window).width() < 768) {
                $('.mobile-header').show();
            }
            setTimeout(function() {
                $('.mobile-header').hide(300);
            }, 1000);
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
        var nextValue = $(this).attr('value');
        console.log($(this).attr('value'));
        if (nextValue == 'step-2') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var empty = $('#member_forms').find("input[required]").filter(function() {
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
                                            text: 'This is your application no.:' +
                                                ' ' +
                                                reference_no,
                                            icon: 'success'
                                        });
                                        $('.applicationNo').show(200);
                                        $('#application_no').text(reference_no);
                                        $('#app_no').val(reference_no);
                                        $('#appNo').val(reference_no);
                                        $('#test').val(reference_no);
                                    }
                                },
                                complete: function(data) {
                                    $('#loading').hide();
                                },
                            });
                            $("#step-1").removeClass('d-flex').addClass("d-none");
                            $("#member_forms").removeClass('mh-reg-form');
                            $("#member_forms_con").addClass('mh-reg-form');
                            $("#step-2").removeClass('d-none').addClass("d-flex");
                            $("#back").attr('value', 'step-1');
                            $(this).attr('value', 'step-3');
                            $("#line").removeClass('step-1').addClass('step-2');
                            $("#registration-title").text(stepTitle[1]);
                            $("#stepper-2").addClass("active");
                        } else {
                            swal.fire("You cancelled your transaction.");
                        }
                    });
                } else {
                    console.log('stepval2');
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
                                    'Update was cancelled by the user. No changes were made.',
                                    'warning'
                                );
                            }
                        });

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
                }
            }
        } else if (nextValue == 'step-3') {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var empty = $('#member_forms_con').find("input[required]").filter(function() {
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
                                // $(this).attr('value', 'step-end')
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
                    console.log('asdasd');
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
                                            $("#member_forms_con").removeClass(
                                                'mh-reg-form');
                                            $("#member_forms_3").addClass('mh-reg-form');
                                            // $(this).attr('value', 'step-end')
                                            $("#line").removeClass('step-2').addClass(
                                                'step-3')
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
                                // $(this).attr('value', 'step-end')
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
                        // $(this).attr('value', 'step-end')
                        $("#line").removeClass('step-2').addClass('step-3')
                        $("#registration-title").text(stepTitle[2])
                        $("#stepper-3").addClass("active")
                        // console.log($("#back").val());
                    }

                }

            }
        }
        scrollToTop()
    });

    $(document).on('submit', '#member_forms_3', function(e) {
        e.preventDefault();
        if ($('#terms').prop('checked')) {
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
                                // window.open();
                                var url = "{{ URL::to('/memberform/') }}" + '/' +
                                employee_no; //YOUR CHANGES HERE...
                                window.open(url, 'targetWindow', 'resizable=yes,width=1000,height=1000');
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
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
        } else {
            Swal.fire({
                title: 'Terms and Conditions!',
                text: 'Please check the terms and conditions before you proceed.',
                icon: 'warning'
            });
        }
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
        $('.applicationNo').hide();
        $('.status-result').hide();
        $('#proxy').hide();

        var id = employee_no;
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
            if (inputValue == '') {
                $('#sg_category').val('');
            }
            $(this).val(inputValue);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('check_sg') }}",
                type: 'POST',
                data: {
                    inputValue: inputValue
                },
                success: function(response) {
                    if (Object.keys(response).length > 0) {
                        $('#salary_grade').val(response.sg_no);
                        if (response.sg_no <= '15') {
                            $('#sg_category').val('1-15');
                        } else {
                            $('#sg_category').val('16-33');
                        }
                    } else {
                        $('#salary_grade').val('');
                    }
                }
            });
        });

        $.getJSON('/options', function(options) {
            $.each(options, function(index, option) {
                $('#campus').append($('<option>', {
                    value: option.campus_key,
                    text: option.name
                }));
            });
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
            $('#same_add').val('');
            $('.same_div').show();
        }
    });
    $(document).on('click', '#percentage_check', function(e) {
        if ($(this).prop("checked")) {
            $('#fixed_amount').prop('disabled', true);
        } else {
            $('#fixed_amount').prop('disabled', false);
            $('#percentage_bsalary').val('');
            $('#computed_amount').text('');
        }
    });
    $(document).on('click', '#fixed_amount_check', function(e) {
        if ($(this).prop("checked")) {
            $('#percentage_bsalary').prop('disabled', true);
        } else {
            $('#percentage_bsalary').prop('disabled', false);
            $('#fixed_amount').val('');
        }
    });
    $(document).on('click', '#citizenship', function(e) {
        var citizen = $(this).val();
        if (citizen == 'DUAL CITIZENSHIP') {
            $('#d_citizen').prop('disabled', false);
        } else {
            $('#d_citizen').prop('disabled', true);
            $('#d_citizen').val('');
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
        var inputValue = percentage.toFixed(2);
    if (inputValue !== null && inputValue !== undefined) {
        inputValue = inputValue.toString();
        // remove any existing commas
        inputValue = inputValue.replace(/,/g, "");
        // add commas every 3 digits to the left of the decimal point
        inputValue = inputValue.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        // check if there's a decimal point present
        if (inputValue.indexOf(".") !== -1) {
            // split the input value by the decimal point
            var decimalAdded = inputValue.split(".");
            // check if there are more than 2 decimal places
            if (decimalAdded[1] && decimalAdded[1].length > 2) {
                inputValue = decimalAdded[0] + "." + decimalAdded[1].substring(0, 2);
            }
        } else {
            inputValue += ".00";
        }
        percentage = inputValue;
    }
        $('#computed_amount').html(percentage);
        $('#percent_amt').val(percentage);
    });

    function scrollToTop() {
        $('html, body, div, div, div, form').animate({
            scrollTop: $('#leftsection').offset().top - 20
        }, 300);
    }
    $('#cont_app').hide();
    // status trail
    var query
    $(document).on('click', '#search_btn', function(e) {
        query = $('#app_no_trail').val();

        if (query != '') {


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('status_trail') }}",
                type: 'POST',
                data: {
                    query: query
                },
                success: function(data) {
                    if (Object.keys(data).length > 0) {
                        $('.status-result').show(200);
                        $('#input-app').hide(200);
                        $('#search_btn').hide(200);
                        $("#icon_status").removeClass("fa fa-frown-o").addClass("fa fa-smile-o");
                        $('#found_remarks').text('Record has been found');
                        $('#appNo_label').text(data.app_no == null ? 'N/A' : data.app_no);
                        $('#lname_label').text(data.lastname == null ? 'N/A' : data.lastname);
                        $('#mname_label').text(data.middlename == null ? 'N/A' : data.middlename);
                        $('#fname_label').text(data.firstname == null ? 'N/A' : data.firstname);
                        $('#suffix_label').text(data.suffix == null ? 'N/A' : data.suffix);
                        $('#bdate_label').text(data.date_birth == null ? 'N/A' : data.date_birth);
                        $('#appointment_label').text(data.appointment == null ? 'N/A' : data
                            .appointment);
                        $('#tin_no_label').text(data.tin_no == null ? 'N/A' : data.tin_no);
                        $('#contact_no_label').text(data.contact_no == null ? 'N/A' : data
                            .contact_no);
                        $('#landlineno_label').text(data.landline_no == null ? 'N/A' : data
                            .landline_no);
                        $('#email_add_label').text(data.email == null ? 'N/A' : data.email);
                        $('#application_status').text(data.app_status == null ? 'N/A' : data
                            .app_status);
                        if (data.app_status == "DRAFT") {
                            $('#cont_app').show();
                            $('#print_app').hide();
                        } else {
                            $('#cont_app').hide();
                            $('#print_app').show();
                        }
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'No application number found.',
                            icon: 'error'
                        });
                        $('#cont_app').hide();
                        $('#print_app').show();
                        $("#icon_status").removeClass("fa fa-smile-o").addClass("fa fa-frown-o");
                        $('#found_remarks').text('Not Found');
                        $('#lname_label').text('');
                        $('#mname_label').text('');
                        $('#fname_label').text('');
                        $('#suffix_label').text('');
                        $('#bdate_label').text('');
                        $('#appointment_label').text('');
                        $('#tin_no_label').text('');
                        $('#contact_no_label').text('');
                        $('#landlineno_label').text('');
                        $('#email_add_label').text('');
                        $('#application_status').text('');
                    }

                }
            });
        } else {
            Swal.fire({
                title: 'Warning!',
                text: 'Please input your application number.',
                icon: 'warning'
            });
        }
    });
    $(document).on('click', '#cont_app', function(e) {
        $("#resetPasswordForm").attr("hidden", true);
        $("#statusTrailForm").attr("hidden", true);
        $("#loginform").attr("hidden", true);
        $("#registrationform").removeAttr("hidden");
        $("#leftsection").addClass("mw-600").addClass("w-600");
        $("#control").removeClass("d-none").addClass("d-flex");
        setTimeout(function timout() {
            $("#leftsection").removeClass("transition-all-cubic").addClass("transition-all");
        }, 400)
        var app_trailno = query;
        $.ajax({
                url: "{{ route('continued_trail') }}",
                data: {
                    app_trailno: app_trailno,
                },
                method: "POST",
                success: function(data) {
                    if (Object.keys(data).length > 0) {
                        $('#app_trailNo').val(data.app_no == null ? 'N/A' : data.app_no);
                        $("[name='lastname']").val(data.lastname == null ? 'N/A' : data.lastname);
                        $("[name='tin_no']").val(data.tin_no == null ? 'N/A' : data.tin_no);
                        $('#present_province').val(data.present_province).trigger('change');
                        // $('#present_city').val(data.present_municipality).trigger('change');
                        // $('#present_barangay').val(data.present_barangay).trigger('change');
                        
                    } 
                }
            });

    });

    $(document).on('click', '#save_sign', function() {
        var id = reference_no;
        var files = $('#file')[0].files;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var fd = new FormData();
        fd.append('file', files[0]);
        fd.append('appNo', id);

        if (files.length > 0) {
            $.ajax({
                method: 'POST',
                url: "{{ route('add_proxyForm') }}",
                data: fd,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.success != '') {
                        var url = "{{ URL::to('/generateProxyForm/') }}" + '/' +
                            id; //YOUR CHANGES HERE...
                        window.open(url, '_blank');
                    }
                }
            });
        } else {
            Swal.fire({
                title: 'Warning!',
                text: 'Please upload your signature.',
                icon: 'warning'
            });
        }
    });

    $(document).on('click', '#generateForm', function() {
        if ($(this).prop('checked')) {
            $('#proxy').show(300);
            $('.supporting_docu').hide(300);
            $('#coco').attr('required', false);
            $('#proxy_form').attr('required', false);
        } else {
            $('#proxy').hide(300);
            $('.supporting_docu').show(300);
            $('#coco').attr('required', true);
            $('#proxy_form').attr('required', true);
        }
    });
</script>
@endsection
