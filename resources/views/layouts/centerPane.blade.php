@extends('layouts/index')
@section('content')



<!-- mobile transition -->
{{-- <div class="mobile-header">
        <div class="logo-title">
            <div class="mp-pb4  mp-text-center logo-text">
                <img src="{!! asset('assets\favicon\ms-icon-310x310.png') !!}" alt="UPPFI">
                <br>
                <label for="">
                    UP Provident Fund
                </label>

            </div>
        </div>
    </div> --}}
<div class="transition-background">

</div>
<div class="custom-modal not-visible" id="modal_name">
    <div class="modal-container">
        <div class="modal-content">
            <div class="modal-header">
                Generate AXA Form
            </div>
            <div class="modal-body">
                <form id="generateAxa" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="app_number" id="app_number">
                    <div class="mp-input-group">
                        <label class="mp-input-group__label">Place of Birth</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="place_birth" id="place_birth" />
                    </div>
                    <div class="mp-input-group">
                        <label class="mp-input-group__label">Employer/Union/Association</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="emp_union_assoc" id="emp_union_assoc" />
                    </div>
                    <div class="mp-input-group">
                        <label class="mp-input-group__label">Occupation</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="occupation" id="occupation" />
                    </div>
                    <div class="mp-input-group">
                        <label class="mp-input-group__label">SSS/GSIS No.</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="sss_gsis" id="sss_gsis" />
                    </div>
                    <div class="mp-input-group">
                        <label class="mp-input-group__label">Name of Spouse</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="spouse_name" id="spouse_name" />
                    </div>
                    <div class="mp-input-group">
                        <label class="mp-input-group__label">Mother's Maiden Name</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="maiden_name" id="maiden_name" />
                    </div>
                    <div class="mp-input-group">
                        <label class="mp-input-group__label">Insured Type</label>
                        <!-- <input class="mp-input-group__input mp-text-field" type="text" name="occupation" id="occupation" /> -->
                        <select name="insuted_type" id="insuted_type" class="radius-1 outline select-field" style="font-size: normal;">
                            <option value="INSURED">INSURED</option>
                            <option value="DEPENDENT">DEPENDENT</option>
                        </select>
                    </div>
                    <div class="mp-input-group">
                        <label class="mp-input-group__label">PERSON TO BE CONTACED IN CASE OF EMERGENCY</label><br>
                        <label class="mp-input-group__label">Last Name</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="last_name" id="last_name" />
                    </div>
                    <div class="mp-input-group">
                        <label class="mp-input-group__label">First Name</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="first_name" id="first_name" />
                    </div>
                    <div class="mp-input-group">
                        <label class="mp-input-group__label">Middle Name</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="middle_name" id="middle_name" />
                    </div>
                    <div class="mp-input-group">
                        <label class="mp-input-group__label">Relationship to the member</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="relationship_tomember" id="relationship_tomember" />
                    </div>
                    <div class="mp-input-group">
                        <label class="mp-input-group__label">Contact No.</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="axa_contact_no" id="axa_contact_no" />
                    </div>
                    <div class="mp-input-group">
                        <label class="mp-input-group__label">Email Address</label>
                        <input class="mp-input-group__input mp-text-field" type="text" name="email_add" id="email_add" />
                    </div>
                    <div class="mp-input-group">
                        <label class="mp-input-group__label">Upload Signature</label>
                        <input class="mp-input-group__input mp-text-field" type="file" name="sign_electronic" id="sign_electronic" accept="image/png, image/gif, image/jpeg, image/jpg" />
                        <input type="hidden" name="person_id" id="person_id">
                    </div>

            </div>

            <div class="modal-footer">
                <div class="mp-container" style="display: flex; justify-content: center;">
                    <div class="row">
                        <button class="up-button btn-md " id="modal_name_close" type="button">
                            <span>Close</span>
                        </button>
                        <button class="up-button btn-md" type="button" id="btn-axa">
                            <span>Generate</span>
                        </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="mp-center-pane mp-bg--registration">
    <div class="mp-split-pane__center transition-all d-flex flex-column mw-600 w-600" id="leftsection">

        <!-- <div id="statusTrailForm" hidden="hidden" class="container-fluid relative pv-3">
            @section('status-trail-form')
            @show
        </div> -->
        <div class="ft-card border-bottom-0">
            <div class="mp-pb2 mp-text-center d-flex flex-row mp-pv3 mp-ph3 relative">
                <img src="{!! asset('assets/images/uppfi-logo-sm.png') !!}" alt="UPPFI" style="width: 50px; height: 50px" class="absolute">
                <div class="d-flex flex-column mp-text-center" style="color: white; width: 100%">
                    <span class=" top-items">
                        University of the Philippines Provident Fund Inc.
                    </span>
                    <span class=" top-items">
                        Become a UP Provident Fund Member
                    </span>
                </div>
            </div>

        </div>
        <button class="scroll-top-button" id="up-scroll">
            <i class="fa fa-arrow-up" aria-hidden="true"></i>
        </button>
        <script>
            $("#up-scroll").on("click", function() {
                $('html, body, .mp-center-pane').animate({
                    scrollTop: 0
                }, '300');

            });
        </script>
        <div id="registrationform" hidden="hidden" class="container-fluid relative pv-3-auto" style="height: calc(100% - 0px)">
            @section('registration-personal-form')
            @show
        </div>
    </div>

</div>
<script>
    const inputField = document.querySelector('#contact-number-input');

    function formatInput() {
        let input = inputField.value;
        let formattedInput = input.replace(/\D/g, '');

        // Set placeholder
        inputField.placeholder = "XXXXXXXXXX";

        if (formattedInput === '') {
            // If the input is empty, display the "+63 " prefix
            formattedInput = '+63 ';
        } else if (formattedInput.startsWith('63')) {
            // If the input starts with "63", replace it with "+63 "
            formattedInput = '+63 ' + formattedInput.slice(2);
        } else if (formattedInput.length >= 4) {
            // If the input has at least 4 digits, add the country code and separate the digits with spaces
            formattedInput = '+63 ' + formattedInput.slice(3, 2) + ' ' + formattedInput.slice(3, 6) + ' ' + formattedInput.slice(6, 10);
        } else if (formattedInput.length >= 1) {
            // If the input has at least 1 digit, add the country code
            formattedInput = '+63 ' + formattedInput;
        }
        // Limit the formatted input to 10 digits
        formattedInput = formattedInput.slice(0, 14);

        inputField.value = formattedInput;
    }
    document.addEventListener('DOMContentLoaded', formatInput);
    inputField.addEventListener('input', formatInput);


    $(document).ready(function() {
        if ($(window).width() < 768) {
            $('.transition-background').hide();
            $("#loading").show();
            setTimeout(function() {
                $("#loading").hide();
            }, 1000);
        }

    });

    $(document).ready(function() {
        const searchParams = new URLSearchParams(window.location.search);
        var app_trailno = searchParams.get('draft');

        $.getJSON('/options_psgc', function(options) {
            $.each(options, function(index, option) {
                $('#present_province').append($('<option>', {
                    value: option.code,
                    text: option.name.toUpperCase()
                }));
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

        $.getJSON('/classification', function(options) {
            $.each(options, function(index, option) {
                $('#classification').append($('<option>', {
                    value: option.classification_name,
                    text: option.classification_name
                }));
            });
        });
        $.getJSON('/appointment', function(options) {
            $.each(options, function(index, option) {
                $('#appointment').append($('<option>', {
                    value: option.appoint_id,
                    text: option.appointment_name
                }));
            });
        });
        $.getJSON('/options_psgc', function(options) {
            $.each(options, function(index, option) {
                $('#province').append($('<option>', {
                    value: option.code,
                    text: option.name.toUpperCase()
                }));
            });
        });
        if (app_trailno) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('continued_trail') }}",
                data: {
                    app_trailno: app_trailno,
                },
                method: "POST",
                success: function(data) {
                    if (Object.keys(data).length > 0) {
                        pers_id = data.personal_id;
                        mems_id = data.employee_details_ID;
                        mem_id = data.mem_app_ID;
                        employee_no = data.employee_no == null ? '' : data.employee_no;
                        // reference_no = data.app_no == null ? '' : data.app_no;
                        reference_no = app_trailno == '' ? 'N/A' : app_trailno;
                        // $('#app_no').val(data.app_no == null ? 'N/A' : data.app_no);
                        $('#app_no').val(app_trailno == '' ? 'N/A' : app_trailno);
                        $('#employee_details_ID').val(data.employee_details_ID == null ? '' : data
                            .employee_details_ID);
                        // $('#app_trailNo').val(data.app_no == null ? '' : data.app_no);
                        $('#app_trailNo').val(app_trailno == '' ? 'N/A' : app_trailno);
                        $("[name='lastname']").val(data.lastname == null ? '' : data.lastname);
                        if (data.no_middlename == 1) {
                            $('#no_middlename').prop('checked', true);
                            $("[name='middlename']").val('N/A')
                            $('input[name="middlename"]').prop('disabled', true);
                        } else {
                            $('#no_middlename').prop('checked', false);
                            $('input[name="middlename"]').prop('disabled', false);
                            $("[name='middlename']").val(data.middlename == null ? '' : data.middlename);
                        }
                        if (data.no_suffix == 1) {
                            $('#no_suffix').prop('checked', true);
                            $("[name='suffix']").val('N/A')
                            $('input[name="suffix"]').prop('disabled', true);
                        } else {
                            $('#no_suffix').prop('checked', false);
                            $('input[name="suffix"]').prop('disabled', false);
                            $("[name='suffix']").val(data.suffix == null ? '' : data.suffix);
                        }
                        $("[name='firstname']").val(data.firstname == null ? '' : data.firstname);

                        var date_bd = new Date(data.date_birth);
                        $("[name='date_birth_years']").val(date_bd.getFullYear());
                        $("[name='date_birth_month']").val((date_bd.getMonth() + 1).toString().padStart(2, '0'));
                        $("[name='date_birth_days']").val(date_bd.getDate().toString().padStart(2, '0'));

                        $("[name='gender']").val(data.gender == null ? '' : data.gender);
                        // $("[name='civilstatus']").val(data.civilstatus == null ? '' : data.civilstatus);
                        if (data.civilstatus == 'Single') {
                            $('input[name="civilstatus"][value="Single"]').prop('checked', true);
                        } else if (data.civilstatus == 'Married') {
                            $('input[name="civilstatus"][value="Married"]').prop('checked', true);
                        } else if (data.civilstatus == 'Widowed') {
                            $('input[name="civilstatus"][value="Married"]').prop('checked', true);
                        }
                        if (data.citizenship == 'FILIPINO') {
                            $('input[name="citizenship"][value="FILIPINO"]').prop('checked', true);
                        } else if (data.citizenship == 'DUAL CITIZENSHIP') {
                            $('input[name="citizenship"][value="DUAL CITIZENSHIP"]').prop('checked',
                                true);
                        } else if (data.citizenship == 'OTHERS') {
                            $('input[name="citizenship"][value="OTHERS"]').prop('checked', true);
                        }
                        // $("[name='citizenship']").val(data.citizenship == null ? '' : data.citizenship).prop('checked', true);
                        // $('input[name="citizenship"][value="'+(data.citizenship == null ? '' : data.citizenship)+'"]').prop('checked', true);
                        $("[name='dual_citizenship']").val(data.dual_citizenship == null ? '' : data
                            .dual_citizenship);
                        $("[name='present_bldg_street']").val(data.present_bldg_street == null ? '' :
                            data.present_bldg_street);
                        $("[name='present_zipcode']").val(data.present_zipcode == null ? '' : data
                            .present_zipcode);
                        $("[name='bldg_street']").val(data.bldg_street == null ? '' : data.bldg_street);
                        $("[name='zipcode']").val(data.zipcode == null ? '' : data.zipcode);
                        $("[name='contact_no']").val(data.contact_no == null ? '' : data.contact_no);
                        $("[name='landline_no']").val(data.landline_no == null ? '' : data.landline_no);
                        $("[name='email']").val(data.email == null ? '' : data.email);

                        $("[name='employee_no']").val(data.employee_no == null ? '' : data.employee_no);
                        $("[name='campus']").val(data.campus == null ? '' : data.campus).trigger('change');
                        $("[name='classification']").val(data.classification == null ? '' : data
                            .classification);
                        $("[name='classification_others']").val(data.classification_others == null ?
                            '' : data.classification_others);
                        $("[name='college_unit']").val(data.college_unit == null ? '' : data.college_unit).trigger('change');
                        college_unit = data.college_unit == null ? '' : data.college_unit;
                        $("[name='rank_position']").val(data.rank_position == null ? '' : data
                            .rank_position);
                        $("[name='department']").val(data.department == null ? '' : data.department).trigger('change');
                        dept_no = data.department == null ? '' : data.department;
                        $("[name='appointment']").val(data.appointment == null ? '' : data.appointment);
                        var date_appoint = new Date(data.date_appointment);
                        $("[name='date_appoint_years']").val(date_appoint.getFullYear());
                        $("[name='date_appoint_months']").val((date_appoint.getMonth() + 1).toString().padStart(2, '0'));
                        $("[name='date_appoint_days']").val(date_appoint.getDate().toString().padStart(2, '0'));

                        $("[name='date_appointment']").val(data.date_appointment == null ? '' : moment(data.date_appointment).format('MMMM D, YYYY'));
                        var monthsalary = data.monthly_salary == null ? '' : data.monthly_salary;
                        var formattedNumber = monthsalary.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        $("[name='monthly_salary']").val(formattedNumber);
                        $("[name='salary_grade']").val(data.salary_grade == null ? '' : data
                            .salary_grade);
                        $("[name='sg_category']").val(data.sg_category == null ? '' : data.sg_category);
                        $("[name='tin_no']").val(data.tin_no == null ? '' : data.tin_no);
                        present_provcode = data.present_province_code;
                        $('#present_province').trigger('change');
                        $('#present_province').val(data.present_province_code);
                        $('#present_province_name').val(data.present_province);
                        present_muncode = data.present_municipality_code;
                        $('#present_city').val(data.present_municipality_code).trigger('change');
                        present_brgycode = data.present_barangay_code;
                        $('#present_municipality_name').val(data.present_municipality);

                        if (data.same_add == 1) {
                            $('#perm_add_check').prop("checked", true);
                            var valueAfterTargetChar = (data.bldg_street == null ? '' : data
                                    .bldg_street) + ' ' + data.present_barangay + ' ' + data
                                .present_municipality + ' ' + data.present_province + ', ' + (data
                                    .present_zipcode == null ? '' : data.present_zipcode) + ' ';
                            $('#same_add').val(valueAfterTargetChar);
                            $('.same_div').hide();
                        } else {
                            $('#perm_add_check').prop("checked", false);
                            $('#same_add').val('');
                            $('.same_div').show();
                            $('#province').val(data.province_code).trigger('change');
                            $('#province_name').val(data.province);
                            $('#city').val(data.municipality_code);
                            perm_muncode = data.municipality_code;
                            $('#municipality_name').val(data.municipality);
                            perm_brgycode = data.barangay_code;
                            $('#bldg_street').val(data.bldg_street);
                            $('#zipcode').val(data.zipcode);
                        }
                        if (data.contribution_set == 'Percentage of Basic Salary') {
                            $('#percentage_check').prop("checked", true);
                            $('#percentage_bsalary').val(data.percentage == null ? '' : data.percentage);
                            $('#computed_amount').text(data.amount == null ? '' : data.amount);
                        } else {
                            $('#fixed_amount_check').prop("checked", true);
                            $('#fixed_amount').val(data.amount == null ? '' : data.amount);
                            var amount = $('#monthly_salary').val().replace(/,/g, "");
                            var total = amount * 0.01;
                            $("#min_contri").text(total.toFixed(2));
                        }
                    }
                }
            });
        }
    });
    // window.onload = function() {
    //     $('#loading').show();
    //     setTimeout(function() {
    //         $('#loading').hide();
    //     }, 1000);
    // };

    // if ($(window).width() < 768) {
    //     $('#loading').show();
    //     window.onload = function() {
    //         setTimeout(function() {
    //             $('#loading').hide();
    //         }, 1500);
    //     };
    // }

    // function ckChange(ckType) {
    //     var ckName = document.getElementsByClassName(ckType.className);
    //     for (var i = 0; i < ckName.length; i++) {
    //         if (!ckType.checked) {
    //             ckName[i].disabled = false;
    //         } else {
    //             if (!ckName[i].checked) {
    //                 ckName[i].disabled = true;
    //             } else {
    //                 ckName[i].disabled = false;
    //             }
    //         }
    //     }
    // }
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

    var stepTitle = ["Step 1: Enter your Personal Information", "Step 2: Enter your Employment Details", "Step 3: Enter your Membership Details", "Step 4: Forms & Attachment"]
    var steps = ["Step 1: ", "Step 2: ", "Step 3: ", "Step 4: "]
    var present_provcode;
    $(document).on('change', '#present_province', function() {
        if (present_provcode) {
            var codes = present_provcode;
        } else {
            var codes = $(this).val();
        }
        var subss = codes.substring(0, 4);
        // console.log(subss);
        $.ajax({
            url: "{{ route('psgc_munc') }}",
            method: "POST",
            data: {
                codes: subss
            },
            success: function(data) {
                var options = '<option value="">Select Municipal</option>';
                $.each(data.data, function(index, item) {
                    options += '<option value="' + item.code + '">' + item.name
                        .toUpperCase() + '</option>';
                });
                $("#present_city").html(options);
                $("#present_province_name").val($("#present_province").find("option:selected")
                    .text());
                if (present_muncode) {
                    var mun_code = present_muncode;
                    $("#present_city").val(mun_code).change();
                }
                if ($('#present_province').val() != "") {
                    var listItems = '';
                    $.each(data.data, function(index, item) {
                        listItems += '<li>' + item.name.toUpperCase() + '</li>';
                    });
                    $('#list-container').html(listItems);
                    $("#province_text").text($("#present_province").find("option:selected").text());
                } else {
                    $('#list-container').empty();
                    $("#province_text").text('Municipality List');
                }

            }
        });
    });
    $(document).on('change', '#present_city', function() {
        if (present_muncode) {
            var codes = present_muncode;
        } else {
            var codes = $(this).val();
        }
        var subss = codes.substring(0, 6);
        // console.log(subss);
        $.ajax({
            url: "{{ route('psgc_brgy') }}",
            method: "POST",
            data: {
                codes: subss
            },
            success: function(data) {
                var options = '<option value="">Select Barangay</option>';
                $.each(data.data, function(index, item) {
                    options += '<option value="' + item.code + '">' + item.name
                        .toUpperCase() + '</option>';
                });
                $("#present_barangay").html(options);
                $("#present_municipality_name").val($("#present_city").find("option:selected")
                    .text());
                if (present_brgycode) {
                    var brgy_code = present_brgycode;
                    $("#present_barangay").val(brgy_code).change();
                }
            }
        });
    });
    $(document).on('change', '#present_barangay', function() {
        $("#present_barangay_name").val($("#present_barangay").find("option:selected").text());
    });
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    });


    $(document).on('change', '#province', function() {
        var codes = $(this).val();
        var subss = codes.substring(0, 4);
        // console.log(subss);
        $.ajax({
            url: "{{ route('psgc_munc') }}",
            method: "POST",
            data: {
                codes: subss
            },
            success: function(data) {
                var options = '<option value="">Select Municipal</option>';
                $.each(data.data, function(index, item) {
                    options += '<option value="' + item.code + '">' + item.name
                        .toUpperCase() + '</option>';
                });
                $("#city").html(options);
                $("#province_name").val($("#province").find("option:selected").text());
                if (perm_muncode) {
                    var mun_code = perm_muncode;
                    $("#city").val(mun_code).change();
                }
            }
        });
    });
    $(document).on('change', '#city', function() {
        var codes = $(this).val();
        var subss = codes.substring(0, 6);
        // console.log(subss);
        $.ajax({
            url: "{{ route('psgc_brgy') }}",
            method: "POST",
            data: {
                codes: subss
            },
            success: function(data) {
                var options = '<option value="">Select Barangay</option>';
                $.each(data.data, function(index, item) {
                    options += '<option value="' + item.code + '">' + item.name
                        .toUpperCase() + '</option>';
                });
                $("#barangay").html(options);
                $("#municipality_name").val($("#city").find("option:selected").text());
                if (perm_brgycode) {
                    var brgy_code = perm_brgycode;
                    $("#barangay").val(brgy_code).change();
                }
            }
        });
    });
    $(document).on('change', '#barangay', function() {
        $("#barangay_name").val($("#barangay").find("option:selected").text());
    });


    $(document).on('click', '#modal_name_pop', function(e) {
        var appNo = query;
        var ref = reference_no;
        console.log(query);
        if (ref != undefined) {
            $('#app_number').val(ref);
        } else {
            $('#app_number').val(query);
        }
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
        $('#input-app').show();
        $('#search_btn').show();
        $('.status-result').hide();
        $('#app_no_trail').val('');
        $("#resetPasswordForm").attr("hidden", true);
        $("#statusTrailForm").attr("hidden", true);
        $("#loginform").removeAttr("hidden");
        $("#leftsection").removeClass("mw-600").removeClass("w-600");
        setTimeout(function timout() {
            $("#leftsection").removeClass("transition-all-cubic").addClass("transition-all");
        }, 400)
    })

    $(document).ready(function(e) {
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
            $("#step-title").text(`${steps[0]}${stepTitle[0]}`)
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
            $("#step-title").text(`${steps[1]}${stepTitle[1]}`)
            $("#stepper-3").removeClass("active");
            $("#member_forms_3").removeClass('mh-reg-form');
            $("#member_forms_con").addClass('mh-reg-form');
        } else if (backValue == 'step-3') {
            $("#step-3").addClass('d-flex').removeClass("d-none");
            $("#step-4").addClass('d-none').removeClass("d-flex");
            $("#back").attr('value', 'step-2')
            // $("#member_forms_3").removeClass('mh-reg-form');
            // $("#member_forms_4").addClass('mh-reg-form');
            // $(this).attr('value', 'step-end')
            $("#line").addClass('step-3').removeClass('step-4')
            $("#registration-title").text(stepTitle[2])
            $("#step-title").text(`${steps[2]}${stepTitle[2]}`)
            $("#stepper-4").removeClass("active")
            // $("#registrationform").attr("hidden", true);
            // $("#statusTrailForm").attr("hidden", true);
            // $("#loginform").removeAttr("hidden");
            // $("#next-btn").attr('value', 'step-2');
            // $("#leftsection").removeClass("mw-600").removeClass("w-600");
            // $("#control").removeClass("d-flex").addClass("d-none");

            // if ($(window).width() < 768) {
            //     $('.mobile-header').show();
            // }
            // setTimeout(function() {
            //     $('.mobile-header').hide(300);
            // }, 1000);
        } else {
            window.location.href = "/login";
        }
        scrollToTop()
    })
    var reference_no;
    var mem_id;
    var personnel_id;
    var employee_no;
    var employee_details_ID;
    var originalData;
    var pers_id;
    var mems_id;
    var continued_trail = 0;
    var present_muncode;
    var present_brgycode;
    var perm_muncode;
    var perm_brgycode;
    var college_unit;
    var dept_no;
    var print_emp;

    function isValidEmail(email) {
        // Regular expression for email validation
        if (email.length == 0) {
            return false
        }
        var emailRegex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailRegex.test(email);
    }

    function clearErrorField(names) {
        names.map((name) => {
            try {
                $("[data-set=" + name + "]>#err-msg").addClass('d-none')
                $("[data-set=" + name + "]>select").removeClass('input-error')
                $("[data-set=" + name + "]>.input").removeClass('input-error')
                $("[data-set=" + name + "]>input").removeClass('input-error')
            } catch (e) {
                console.log(e)
            }
        })
    }
    $(document).on('click', '#next-btn', function(e) {
        var table = $('#dependentTable').DataTable();
        table.draw();
        var nextValue = $(this).attr('value');
        console.log($(this).attr('value'));
        if (nextValue == 'step-2') {
            // if ($('#terms').prop('checked')) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var empty = $('#member_forms').find("input[required]").filter(function() {
                return (!$.trim($(this).val()).length);
            });

            clearErrorField([
                'firstname',
                'middlename',
                'lastname',
                'gender',
                'present_province',
                'present_municipality',
                'present_barangay',
                'province',
                'municipality',
                'barangay',
                'contact_no',
                'email',
                'civilstatus',
                'dual_citizenship',
                'citizenship',
                'birthday'
            ])

            var gender = $('#member_forms').find("[name=gender]")
            if (gender.val() == "") {
                empty.push(gender[0])
            }
            var province = $('#member_forms').find("[name=present_province]")
            if (province.val() == "" || province.val() == null || province.val() == undefined) {
                empty.push(province[0])
            }
            var municipality = $('#member_forms').find("[name=present_municipality]")
            if (municipality.val() == "" || municipality.val() == null || municipality.val() == undefined) {
                empty.push(municipality[0])
            }
            var barangay = $('#member_forms').find("[name=present_barangay]")
            if (barangay.val() == "" || barangay.val() == null || barangay.val() == undefined) {
                empty.push(barangay[0])
            }

            var civilStatus = $('#member_forms').find("[name=civilstatus]")
            if (civilStatus.val() == "") {
                empty.push(civilStatus[0])
            }

            var citizenship = $('#member_forms').find("[name=citizenship]:checked")
            if (!citizenship.val()) {
                var newcitizenship = $('#member_forms').find("[name=citizenship]")
                empty.push(newcitizenship[0])
            }
            var dualcitizen = $('#member_forms').find("[name=dual_citizenship]")
            if ((citizenship.val() == "OTHERS" || citizenship.val() == "DUAL CITIZENSHIP") && dualcitizen.val() == "") {
                empty.push(dualcitizen[0])
            }

            var sameAddress = $("#perm_add_check").prop('checked')
            if (sameAddress == false) {
                var per_province = $('#member_forms').find("[name=province]")
                if ((per_province.val() == "" || per_province.val() == null || per_province.val() == undefined)) {
                    empty.push(per_province[0])
                }
                var per_municipality = $('#member_forms').find("[name=municipality]")
                if ((per_municipality.val() == "" || per_municipality.val() == null || per_municipality.val() == undefined)) {
                    empty.push(per_municipality[0])
                }
                var per_barangay = $('#member_forms').find("[name=barangay]")
                if ((per_barangay.val() == "" || per_barangay.val() == null || per_barangay.val() == undefined)) {
                    empty.push(per_barangay[0])
                }
            }

            var selectedDate = new Date($("#date_birth_month").val() + " " + $("#date_birth_days").val() + ", " + $("#date_birth_years").val());

            const fifteenYearsAgo = new Date();
            fifteenYearsAgo.setFullYear(fifteenYearsAgo.getFullYear() - 15);
            if (selectedDate > fifteenYearsAgo || selectedDate == "Invalid Date") {
                var birthday = $('#member_forms').find("[data-set=birthday]")
                empty.push(birthday[0])
            }

            var contact = $('#member_forms').find("[name=contact_no]")

            const mobile_number = contact.val()

            if (mobile_number.length == 14 && mobile_number.substring(4, 6) === "90" || mobile_number.substring(4, 6) === "91" || mobile_number.substring(4, 6) === "92" || mobile_number.substring(4, 6) === "93" || mobile_number.substring(4, 6) === "94" || mobile_number.substring(4, 6) === "95" || mobile_number.substring(4, 6) === "96" || mobile_number.substring(4, 6) === "97" || mobile_number.substring(0, 2) === "98") {} else {
                empty.push(contact[0])
            }


            var email = $('#member_forms').find("[name=email]")
            if (!isValidEmail(email.val())) {
                empty.push(email[0])
            }

            if (empty.length) {
                // var emptyFields = [];
                // empty.each(function() {
                // emptyFields.push($(this).attr("id"));
                // });
                empty.map((index, element) => {
                    const name = $(element).attr("name")
                    // if (name == 'contact_no') {
                    //     const mobile_number = $(element).val()
                    //     if (mobile_number.length === 11 && mobile_number.substring(4, 6) === "090" || mobile_number.substring(3, 2) === "091" || mobile_number.substring(3, 2) === "092" || mobile_number.substring(3, 2) === "093" || mobile_number.substring(3, 2) === "094" || mobile_number.substring(3, 2) === "095" || mobile_number.substring(3, 2) === "096" || mobile_number.substring(3, 2) === "097" || mobile_number.substring(3, 2) === "098") {
                    //         $("[data-set=" + name + "]>#err-msg").addClass('d-none')
                    //         $("[data-set=" + name + "]>select").removeClass('input-error')
                    //         return
                    //     } else {
                    //         $("[data-set=" + name + "]>#err-msg").removeClass('d-none').text("Please input valid cellphone number (Ex. 09xx-xxx-xxxx).")
                    //         $("[data-set=" + name + "]>select").addClass('input-error')
                    //         return
                    //     }
                    // }
                    if (name == 'email') {
                        const email = $(element).val()
                        if (!isValidEmail(email)) {
                            $("[data-set=" + name + "]>#err-msg").removeClass('d-none').text("Invalid input, please check your email address. (email address must contain @sample.com).")
                            $("[data-set=" + name + "]>select").addClass('input-error')
                            return
                        }
                        $("[data-set=" + name + "]>#err-msg").addClass('d-none')
                        $("[data-set=" + name + "]>select").removeClass('input-error')
                        return
                    }
                    if (name == 'gender') {
                        $("[data-set=" + name + "]>#err-msg").removeClass('d-none').text("Please select gender.")
                        $("[data-set=" + name + "]>select").addClass('input-error')
                        return
                    }
                    if (name == 'province') {
                        $("[data-set=" + name + "]>#err-msg").removeClass('d-none').text("Please select your province.")
                        $("[data-set=" + name + "]>select").addClass('input-error')
                        return
                    }
                    if (name == 'present_province') {
                        $("[data-set=" + name + "]>#err-msg").removeClass('d-none').text("Please select your province.")
                        $("[data-set=" + name + "]>select").addClass('input-error')
                        return
                    }
                    if (name == 'present_municipality') {
                        $("[data-set=" + name + "]>#err-msg").removeClass('d-none').text("Please select your municipality.")
                        $("[data-set=" + name + "]>select").addClass('input-error')
                        return
                    }
                    if (name == 'municipality') {
                        $("[data-set=" + name + "]>#err-msg").removeClass('d-none').text("Please select your municipality.")
                        $("[data-set=" + name + "]>select").addClass('input-error')
                        return
                    }
                    if (name == 'present_barangay') {
                        $("[data-set=" + name + "]>#err-msg").removeClass('d-none').text("Please select your barangay.")
                        $("[data-set=" + name + "]>select").addClass('input-error')
                        return
                    }
                    if (name == 'barangay') {
                        $("[data-set=" + name + "]>#err-msg").removeClass('d-none').text("Please select your barangay.")
                        $("[data-set=" + name + "]>select").addClass('input-error')
                        return
                    }
                    if (name == 'contact_no') {
                        $("[data-set=" + name + "]>#err-msg").removeClass('d-none').text("Invalid number.")
                        $("[data-set=" + name + "]>input").addClass('input-error')
                        return
                    }
                    if (name == 'civilstatus') {
                        $("[data-set=" + name + "]>#err-msg").removeClass('d-none').text("Please select your civil status.")
                        $("[data-set=" + name + "]>select").addClass('input-error')
                        return
                    }
                    if (name == 'citizenship') {
                        $("[data-set=" + name + "]>#err-msg").removeClass('d-none').text("Please select your citizenship.")
                        return
                    }
                    if (name == 'birthday') {
                        $("[data-set=" + name + "]>#err-msg").removeClass('d-none').text("Invalid Age, you must be 15 years old or older.")
                        return
                    }
                    console.log('name', name)
                    $("[data-set=" + name + "]>#err-msg").removeClass('d-none').text("Please fill out this field.")
                    $("[data-set=" + name + "]>input").addClass('input-error')
                    $("[data-set=" + name + "]>.input").addClass('input-error')
                })
                empty.first().focus();
                return
                // swal.fire("Error!", "Please fill out the required fields", "error");
            } else {
                if ($('#app_trailNo').val() !== '' && personnel_id == undefined) {
                    var formDatas = $("#member_forms").serialize();
                    var additionalData = {
                        'mem_id': mem_id,
                        'personnel_id': pers_id,
                    };
                    formDatas += '&' + $.param(additionalData);
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('update_trail_member') }}",
                        data: formDatas,
                        success: function(data) {
                            if (data.success != '') {
                                mem_id = data.mem_id;
                                personnel_id = data.success;
                                $("#step-1").removeClass('d-flex').addClass("d-none");
                                $("#member_forms").removeClass('mh-reg-form');
                                $("#member_forms_con").addClass('mh-reg-form');
                                $("#step-2").removeClass('d-none').addClass("d-flex");
                                $("#back").attr('value', 'step-1');
                                $(this).attr('value', 'step-3');
                                $("#line").removeClass('step-1').addClass('step-2');
                                $("#registration-title").text(stepTitle[1]);
                                $("#step-title").text(`${steps[1]}${stepTitle[1]}`)
                                $("#stepper-2").addClass("active");
                                // $("#back").removeClass("disabled");
                            }
                        }
                    });
                } else {
                    if (!personnel_id) {
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
                                    // Swal.fire({
                                    //     html: "<div class='d-flex flex-column' style='font-size: medium'><span>Your application number is</span><br><span style='font-size: x-large'>" + reference_no + "</span><br><span>Use this number to continue your application at any time. Once you complete the application process, you may also use this number to check the status of your application.</span>" +
                                    //         "<br><span>We have emailed your application number to the email you provided in the previous step. You may also take a screenshot or copy this number for future reference.</span>" +
                                    //         "</div>",
                                    //     icon: 'success',
                                    //     confirmButtonColor: '#3085d6',
                                    //     confirmButtonText: 'Proceed',
                                    // });
                                    Swal.fire({
                                        html: "<div class='d-flex flex-column' style='font-size: medium'><span>Your application number is</span><br><span style='font-size: x-large'>" + reference_no + "</span><br><span style='color:red'>Please screenshot or copy this number for future reference.</span>" +
                                            "<br><span><b>Use this number to:</b><br>&#x2713; Resume your application at any time<br> &#x2713; Check the status of your application</span>" +
                                            "<br><span>We have also emailed your application number to the email you provided in Step 1.</span>" +
                                            "</div>",
                                        icon: 'success',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Proceed',
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
                        $("#step-title").text(`${steps[1]}${stepTitle[1]}`)
                        $("#stepper-2").addClass("active");
                    } else {
                        if (originalData !== $("#member_forms").serialize()) {
                            Swal.fire({
                                text: 'Do you want to allow these changes on your application?',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes',
                                cancelButtonText: 'No',
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
                        $("#step-title").text(`${steps[1]}${stepTitle[1]}`)
                        $("#stepper-2").addClass("active")
                    }
                }
            }
            // } else {
            //     Swal.fire({
            //         title: 'Terms and Conditions!',
            //         text: 'Please check the terms and conditions before you proceed.',
            //         icon: 'warning'
            //     });
            // }
        } else if (nextValue == 'step-3') {
            var table = $('#dependentTable').DataTable();
            table.draw();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            clearErrorField([
                'campus',
                'classification',
                'college_unit',
                'appointment',
                'date_appoint_months',
                'monthly_salary',
                'tin_no',
                'employee_no'

            ])

            var empty = $('#member_forms_con').find("input[required]").filter(function() {
                return !$.trim($(this).val()).length;
            });

            console.log(mem_id);
            console.log(employee_details_ID);

            var campus = $('#member_forms_con').find("[name=campus]")
            if (campus.val() == "") {
                empty.push(campus[0])
            }
            var classification = $('#member_forms_con').find("[name=classification]")
            if (classification.val() == "") {
                empty.push(classification[0])
            }
            var college_unit = $('#member_forms_con').find("[name=college_unit]")
            if (college_unit.val() == "") {
                empty.push(college_unit[0])
            }
            var appointment = $('#member_forms_con').find("[name=appointment]")
            if (appointment.val() == "") {
                empty.push(appointment[0])
            }

            var selectedDate = new Date($("#date_appoint_months").val() + " " + $("#date_appoint_days").val() + ", " + $("#date_appoint_years").val());
            var currentDate = new Date();
            if (selectedDate > currentDate || selectedDate == "Invalid Date") {
                $("[data-set=date_appoint_months]>#err-msg").removeClass('d-none').text("Invalid appointment date, please check")
                $("[data-set=date_appoint_months]>.input").addClass('input-error')
                empty.push($("[data-set=date_appoint_months]"))
            } else {
                $("[data-set=date_appoint_months]>#err-msg").addClass('d-none')
                $("[data-set=date_appoint_months]>.input").removeClass('input-error')
            }

            if (empty.length) {
                empty.map((index, element) => {
                    //     'campus',
                    // 'classification',
                    // 'college_unit',
                    // '',
                    // 'date_appoint_months',
                    // '',
                    // '',
                    // ''
                    const name = $(element).attr("name")
                    $("[data-set=" + name + "]>#err-msg").removeClass('d-none').text("Please fill out this field.")
                    $("[data-set=" + name + "]>select").addClass('input-error')
                    $("[data-set=" + name + "]>input").addClass('input-error')
                    $("[data-set=" + name + "]>.input").addClass('input-error')
                    if (name == 'campus') {
                        $("[data-set=" + name + "]>#err-msg").text("Please select a campus.")
                    }
                    if (name == 'classification') {
                        $("[data-set=" + name + "]>#err-msg").text("Please select an employee classification.")
                    }
                    if (name == 'employee_no') {
                        $("[data-set=" + name + "]>#err-msg").text("Please input your employee number.")
                    }
                    if (name == 'monthly_salary') {
                        $("[data-set=" + name + "]>#err-msg").text("Please input your salary.")
                    }
                    if (name == 'tin_no') {
                        $("[data-set=" + name + "]>#err-msg").text("Please input your TIN number.")
                    }
                    if (name == 'appointment') {
                        $("[data-set=" + name + "]>#err-msg").text("Please select an appointment status.")
                    }

                })
                empty.first().focus();
                return
                // swal.fire("Error!", "Please fill out the required fields", "error");
            } else {
                if ($('#app_trailNo').val() !== '' && $('#employee_details_ID').val() !== '' &&
                    continued_trail == 0) {
                    var formData = $("#member_forms_con").serialize();
                    var additionalData = {
                        'mem_id': mem_id,
                        'employee_details_ID': $('#employee_details_ID').val(),
                    };
                    formData += '&' + $.param(additionalData);
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('update_trail_member_1') }}",
                        data: formData,
                        success: function(data) {
                            if (data.success != '') {
                                employee_no = data.emp_no;
                                employee_details_ID = data.success;
                                continued_trail = 1;
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
                                $("#step-title").text(`${steps[2]}${stepTitle[2]}`)
                                $("#stepper-3").addClass("active")
                            } else {
                                Swal.fire({
                                    title: 'Employee number has already been used.',
                                    icon: 'error'
                                });

                                $('#employee_no').focus();
                            }
                        }
                    });
                } else {
                    if (!employee_details_ID) {
                        var table = $('#dependentTable').DataTable();
                        table.draw();
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
                                    $("#step-title").text(`${steps[2]}${stepTitle[2]}`)
                                    $("#stepper-3").addClass("active")
                                } else {
                                    Swal.fire({
                                        title: 'Employee number has already been used.',
                                        icon: 'error'
                                    });

                                    $('#employee_no').focus();
                                }
                            }
                        });
                    } else {
                        var table = $('#dependentTable').DataTable();
                        table.draw();
                        if (originalData_ext !== $("#member_forms_con").serialize()) {
                            Swal.fire({
                                text: 'Do you want to allow these changes on your application?',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes',
                                cancelButtonText: 'No',
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
                                                $("#member_forms_3").addClass(
                                                    'mh-reg-form');
                                                // $(this).attr('value', 'step-end')
                                                $("#line").removeClass('step-2').addClass(
                                                    'step-3')
                                                $("#registration-title").text(stepTitle[2])
                                                $("#step-title").text(`${steps[2]}${stepTitle[2]}`)
                                                $("#stepper-3").addClass("active")
                                            } else {
                                                Swal.fire({
                                                    title: 'Employee number has already been used.',
                                                    icon: 'error'
                                                });

                                                $('#employee_no').focus();
                                            }
                                        }
                                    });
                                } else {
                                    swal.fire(
                                        "Update was cancelled by the user. No changes were made.");
                                    $("#step-2").removeClass('d-flex').addClass("d-none");
                                    $("#step-3").removeClass('d-none').addClass("d-flex");
                                    $("#back").attr('value', 'step-2')
                                    $("#member_forms_con").removeClass('mh-reg-form');
                                    $("#member_forms_3").addClass('mh-reg-form');
                                    // $(this).attr('value', 'step-end')
                                    $("#line").removeClass('step-2').addClass('step-3')
                                    $("#registration-title").text(stepTitle[2])
                                    $("#step-title").text(`${steps[2]}${stepTitle[2]}`)
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
                            $("#step-title").text(`${steps[2]}${stepTitle[2]}`)
                            $("#stepper-3").addClass("active")
                            // console.log($("#back").val());
                        }

                    }

                }
            }
            console.log($('#monthly_salary').val());
            $('#month_sal_text').text($('#monthly_salary').val());
        } else if (nextValue == 'step-4') {

            $("[data-set=percentage_check]>#err-msg").addClass('d-none')
            $("[data-set=percentage_check]>input").removeClass('input-error')
            $("[data-set=fixed_amount_check]>#err-msg").addClass('d-none')
            $("[data-set=fixed_amount_check]>input").removeClass('input-error')

            const percentage_check = $('#percentage_check').prop("checked");
            const percentage_bsalary = $('#percentage_bsalary').val();
            const fixed_amount_check = $('#fixed_amount_check').prop("checked");
            const fixed_amount = $('#fixed_amount').val();

            let hasError = false

            if (percentage_check && percentage_bsalary.trim() == "") {
                $("[data-set=percentage_check]>#err-msg").removeClass('d-none').text("Please input your desired monthly contribution.")
                $("[data-set=percentage_check]>input").addClass('input-error')
                hasError = true
            }
            if (fixed_amount_check && fixed_amount.trim() == "") {
                $("[data-set=fixed_amount_check]>#err-msg").removeClass('d-none').text("Please input your desired monthly contribution.")
                $("[data-set=fixed_amount_check]>input").addClass('input-error')
                hasError = true
            }
            if (hasError || (!percentage_check && !fixed_amount_check)) {
                // swal.fire("Error!", "Please fill out the required fields", "error");
                return false
            }

            $("#step-3").removeClass('d-flex').addClass("d-none");
            $("#step-4").removeClass('d-none').addClass("d-flex");
            $("#back").attr('value', 'step-3')
            // $("#member_forms_3").removeClass('mh-reg-form');
            // $("#member_forms_4").addClass('mh-reg-form');
            // $(this).attr('value', 'step-end')
            $("#line").removeClass('step-3').addClass('step-4')
            $("#registration-title").text(stepTitle[3])
            $("#step-title").text(`${steps[3]}${stepTitle[3]}`)
            $("#stepper-4").addClass("active")


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
            beforeSend: function() {
                $('#loading').show();
            },
            success: function(data) {
                console.log(data);
                if (data.success != '') {
                    Swal.fire({
                        title: 'Registration Success!',
                        text: "Your membership application has been successfully submitted. Check your email for your reference.",
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // window.open();
                            var url = "{{ URL::to('/memberform/') }}" + '/' +
                                employee_no; //YOUR CHANGES HERE...
                            window.open(url, 'targetWindow',
                                'resizable=yes,width=1000,height=1000');
                            setTimeout(function() {
                                window.location.href = "/login";
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
                    $("#step-title").text(`${steps[2]}${stepTitle[2]}`)
                    $("#stepper-3").addClass("active")
                }
            }
        });

    });

    $(document).on('click', '#add_dependent', function() {
        var year = $('#date_birth_dependent_years').val();
        var month = $('#date_birth_dependent_month').val();
        var day = $('#date_birth_dependent_days').val();
        // create a new date object with the year, month, and day values
        var date = new Date(year, month - 1, day);
        // format the date string as yyyy-mm-dd
        var formattedDate = date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2);
        var name = $('#dependent_name').val();
        var bday = formattedDate;
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
        // $('#proxy').hide();

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
            if (decimalAdded.length > 2) {
                inputValue = decimalAdded[0] + "." + decimalAdded[1].substring(0, 1);
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
                        $('#month_sal_text').text(inputValue);
                    } else {
                        $('#salary_grade').val('');
                    }
                }
            });
        });
        var errorDisplayed = false; // flag variable to keep track of whether the error message has been displayed
        $("#monthly_salary").blur(function() {
            var inputValue = $(this).val();
            inputValue = inputValue.replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            var decimalAdded = inputValue.split(".");
            if (decimalAdded.length > 2) {
                inputValue = decimalAdded[0] + "." + decimalAdded[1].substring(0, 1);
            }

            if (inputValue == '') {
                $('#sg_category').val('');
            }
            $(this).val(inputValue);
            if ($('#salary_grade').val() == '') {
                if (!errorDisplayed) {
                    Swal.fire({
                        title: 'Salary Grade is not available. Please contact UPPF administratior.',
                        text: 'Thank you!',
                        icon: 'error'
                    });
                    errorDisplayed = true; // set the flag variable to true to indicate that the error message has been displayed
                }
                $('#monthly_salary').val('');
                $('#sg_category').val('');
                $('#monthly_salary').focus();
            } else {
                errorDisplayed = false; // reset the flag variable to false
            }
        });

        $("#campus").change(function() {
            var campus_key = $(this).val();
            $('#college_unit').empty();
            $.getJSON('/college_unit', {
                campus_key: campus_key
            }, function(options) {
                $.each(options, function(index, option) {
                    $('#college_unit').append($('<option>', {
                        value: option.cu_no,
                        text: option.college_unit_name
                    }));
                });
                $('#college_unit').val(college_unit).change();
            });

        });
        $("#college_unit").change(function() {
            if (college_unit) {
                var college_id = college_unit;
            } else {
                var college_id = $(this).val();
            }
            $('#department').empty();
            $.getJSON('/department', {
                college_id: college_id
            }, function(options) {
                $.each(options, function(index, option) {
                    $('#department').append($('<option>', {
                        value: option.dept_no,
                        text: option.department_name
                    }));
                });
                $('#department').val(dept_no).change();
            });
        });
        // $.getJSON('/appointment', function(options) {
        //     $.each(options, function(index, option) {
        //         $('#appointment').append($('<option>', {
        //             value: option.appoint_id,
        //             text: option.appointment_name
        //         }));
        //     });
        // });

    });

    $(document).on('click', '#perm_add_check', function(e) {
        if ($(this).prop("checked")) {
            var myString = $('#present_province').find("option:selected").text();
            var myString1 = $("#present_city").find("option:selected").text();
            var myString2 = $('#present_barangay').find("option:selected").text();
            var myString3 = $('#present_bldg_street').val();
            var myString4 = $('#present_zipcode').val();
            if (myString !== "" && myString1 !== "" && myString2 !== "") {
                var valueAfterTargetChar = myString3 + ' ' + myString2 + ' ' + myString1 + ' ' + myString +
                    ' ,' + myString4 + ' ';
                $('#same_add').val(valueAfterTargetChar);
                $('.same_div').hide();
            } else {
                Swal.fire({
                    title: 'Please complete your Present Address',
                    text: 'Thank you!',
                    icon: 'error'
                });
                $(this).prop("checked", false);
            }
        } else {
            $('#same_add').val('');
            $('.same_div').show();
        }
    });
    $(document).on('change', '#percentage_check', function(e) {
        if ($(this).is(':checked')) {
            $('#fixed_amount').prop('disabled', true);
            $('#fixed_amount_check').prop('disabled', true);
        } else {
            $('#fixed_amount').prop('disabled', false);
            $('#fixed_amount_check').prop('disabled', false);
            $('#percentage_bsalary').val('');
            $('#computed_amount').text('');
        }
    });
    $(document).on('change', '#fixed_amount_check', function(e) {
        if ($(this).is(':checked')) {
            $('#percentage_bsalary').prop('disabled', true);
            $('#percentage_check').prop('disabled', true);
            var amount = $('#monthly_salary').val().replace(/,/g, "");
            var total = amount * 0.01;
            $("#min_contri").text(total.toFixed(2));
        } else {
            $('#percentage_bsalary').prop('disabled', false);
            $('#percentage_check').prop('disabled', false);
            $('#fixed_amount').val('');
            $("#min_contri").text('');
        }
    });
    $('#fixed_amount').on('blur', function(event) {
        var input1 = parseFloat($("#fixed_amount").val().replace(/,/g, ''));
        var input2 = parseFloat($("#monthly_salary").val().replace(/,/g, ''));
        var percentage = (input2 * 0.01);
        if (input1 < percentage) {
            swal.fire("Error!", "Please input fixed amount greater than 1% of your Monthly Salary", "error");
            $("#fixed_amount").val('');
        }
    });
    $("#fixed_amount").keyup(function() {
        var inputValue = $(this).val();
        inputValue = inputValue.replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        var decimalAdded = inputValue.split(".");
        if (decimalAdded.length > 2) {
            inputValue = decimalAdded[0] + "." + decimalAdded[1].substring(0, 1);
        }
        $(this).val(inputValue);
    });
    $('input[name="middlename"]').on("blur", function() {
        var middleName = $(this).val();
        if (middleName.length === 1) {
            swal.fire("Error!", "Please input your complete MIDDLE NAME (Ex. GOMEZ). Thank you.", "error");
            $('input[name="middlename"]').focus();
        }
    })
    $(document).on('click', '#citizenship', function(e) {
        var citizen = $(this).val();
        if (citizen == 'DUAL CITIZENSHIP' || citizen == 'OTHERS') {
            $('#d_citizen').prop('disabled', false);
        } else {
            $('#d_citizen').prop('disabled', true);
            $('#d_citizen').val('N/A');
        }
    });

    $('#percentage_bsalary').on('keypress keyup blur', function(event) {
        var $this = $(this);
        if ((event.which < 48 || event.which > 57) && (event.which != 0 && event.which != 8)) {
            event.preventDefault();
        }
        if (parseInt($this.val()) < 1 || parseInt($this.val()) > 100) {
            $this.val("");
            $('#computed_amount').html($this.val());
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
                        $('#found_remarks').css('color', '#1a8981');
                        $('#icon_status').css('color', '#1a8981');
                        print_emp = data.employee_no;
                        $('#app_no').val(data.app_no == null ? 'N/A' : data.app_no);
                        // $('#app_nox').val(data.app_no == null ? 'N/A' : data.app_no);
                        $('#appNo_label').text(data.app_no == null ? 'N/A' : data.app_no);
                        $('#lname_label').text(data.lastname == null ? 'N/A' : data.lastname);
                        $('#mname_label').text(data.middlename == null ? 'N/A' : data.middlename);
                        $('#fname_label').text(data.firstname == null ? 'N/A' : data.firstname);
                        $('#suffix_label').text(data.suffix == null ? 'N/A' : data.suffix);
                        $('#bdate_label').text(data.date_birth == null ? 'N/A' : moment(data.date_birth).format('MMMM D, YYYY'));
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
                        if (data.app_status == "DRAFT APPLICATION") {
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
    $(document).on('click', '#print_app', function(e) {
        // Swal.fire({
        //     title: 'Application has been submitted. Subject for review.',
        //     text: "Do you want to print your Membership Application?",
        //     icon: 'success',
        //     showCancelButton: true,
        //     confirmButtonColor: '#3085d6',
        //     confirmButtonText: 'OK'
        // }).then((result) => {
        //     if (result.isConfirmed) {
        //         // window.open();
        //         var url = "{{ URL::to('/memberform/') }}" + '/' + print_emp;
        //         window.open(url, 'targetWindow',
        //             'resizable=yes,width=1000,height=1000');
        //         setTimeout(function() {
        //             location.reload();
        //         }, 1000);
        //     }
        // })
        var url = "{{ URL::to('/memberform/') }}" + '/' + print_emp;
        window.open(url, 'targetWindow',
            'resizable=yes,width=1000,height=1000');
        setTimeout(function() {
            location.reload();
        }, 1000);
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
        $('#input-app').show();
        $('#search_btn').show();
        $('.status-result').hide();
        $('#app_no_trail').val('');
        var app_trailno = query;
        console.log(app_trailno);
        $.ajax({
            url: "{{ route('continued_trail') }}",
            data: {
                app_trailno: app_trailno,
            },
            method: "POST",
            success: function(data) {
                if (Object.keys(data).length > 0) {
                    pers_id = data.personal_id;
                    mems_id = data.employee_details_ID;
                    mem_id = data.mem_app_ID;
                    $('#employee_details_ID').val(data.employee_details_ID == null ? '' : data
                        .employee_details_ID);
                    $('#app_trailNo').val(data.app_no == null ? '' : data.app_no);
                    $("[name='lastname']").val(data.lastname == null ? '' : data.lastname);
                    if (data.no_middlename == 1) {
                        $('#no_middlename').prop('checked', true);
                        $("[name='middlename']").val('N/A')
                        $('input[name="middlename"]').prop('disabled', true);
                    } else {
                        $('#no_middlename').prop('checked', false);
                        $('input[name="middlename"]').prop('disabled', false);
                        $("[name='middlename']").val(data.middlename == null ? '' : data.middlename);
                    }
                    if (data.no_suffix == 1) {
                        $('#no_suffix').prop('checked', true);
                        $("[name='suffix']").val('N/A')
                        $('input[name="suffix"]').prop('disabled', true);
                    } else {
                        $('#no_suffix').prop('checked', false);
                        $('input[name="suffix"]').prop('disabled', false);
                        $("[name='suffix']").val(data.suffix == null ? '' : data.suffix);
                    }
                    $("[name='firstname']").val(data.firstname == null ? '' : data.firstname);

                    $("[name='date_birth']").val(data.date_birth == null ? '' : moment(data.date_birth).format('MMMM D, YYYY'));
                    $("[name='gender']").val(data.gender == null ? '' : data.gender);
                    $("[name='civilstatus']").val(data.civilstatus == null ? '' : data.civilstatus);
                    if (data.citizenship == 'FILIPINO') {
                        $('input[name="citizenship"][value="FILIPINO"]').prop('checked', true);
                    } else if (data.citizenship == 'DUAL CITIZENSHIP') {
                        $('input[name="citizenship"][value="DUAL CITIZENSHIP"]').prop('checked',
                            true);
                    } else if (data.citizenship == 'OTHERS') {
                        $('input[name="citizenship"][value="OTHERS"]').prop('checked', true);
                    }
                    // $("[name='citizenship']").val(data.citizenship == null ? '' : data.citizenship).prop('checked', true);
                    // $('input[name="citizenship"][value="'+(data.citizenship == null ? '' : data.citizenship)+'"]').prop('checked', true);
                    $("[name='dual_citizenship']").val(data.dual_citizenship == null ? '' : data
                        .dual_citizenship);
                    $("[name='present_bldg_street']").val(data.present_bldg_street == null ? '' :
                        data.present_bldg_street);
                    $("[name='present_zipcode']").val(data.present_zipcode == null ? '' : data
                        .present_zipcode);
                    $("[name='bldg_street']").val(data.bldg_street == null ? '' : data.bldg_street);
                    $("[name='zipcode']").val(data.zipcode == null ? '' : data.zipcode);
                    $("[name='contact_no']").val(data.contact_no == null ? '' : data.contact_no);
                    $("[name='landline_no']").val(data.landline_no == null ? '' : data.landline_no);
                    $("[name='email']").val(data.email == null ? '' : data.email);
                    employee_no = data.employee_no == null ? '' : data.employee_no;
                    $("[name='employee_no']").val(data.employee_no == null ? '' : data.employee_no);
                    $("[name='campus']").val(data.campus == null ? '' : data.campus).trigger('change');
                    $("[name='classification']").val(data.classification == null ? '' : data
                        .classification);
                    $("[name='classification_others']").val(data.classification_others == null ?
                        '' : data.classification_others);
                    $("[name='college_unit']").val(data.college_unit == null ? '' : data.college_unit).trigger('change');
                    college_unit = data.college_unit == null ? '' : data.college_unit;
                    $("[name='rank_position']").val(data.rank_position == null ? '' : data
                        .rank_position);
                    $("[name='department']").val(data.department == null ? '' : data.department).trigger('change');
                    dept_no = data.department == null ? '' : data.department;
                    $("[name='appointment']").val(data.appointment == null ? '' : data.appointment);
                    $("[name='date_appointment']").val(data.date_appointment == null ? '' : moment(data.date_appointment).format('MMMM D, YYYY'));
                    var monthsalary = data.monthly_salary == null ? '' : data.monthly_salary;
                    var formattedNumber = monthsalary.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    $("[name='monthly_salary']").val(formattedNumber);
                    $("[name='salary_grade']").val(data.salary_grade == null ? '' : data
                        .salary_grade);
                    $("[name='sg_category']").val(data.sg_category == null ? '' : data.sg_category);
                    $("[name='tin_no']").val(data.tin_no == null ? '' : data.tin_no);
                    present_provcode = data.present_province_code;
                    $('#present_province').trigger('change');
                    $('#present_province').val(data.present_province_code);
                    $('#present_province_name').val(data.present_province);
                    present_muncode = data.present_municipality_code;
                    $('#present_city').val(data.present_municipality_code).trigger('change');
                    present_brgycode = data.present_barangay_code;
                    $('#present_municipality_name').val(data.present_municipality);

                    if (data.same_add == 1) {
                        $('#perm_add_check').prop("checked", true);
                        var valueAfterTargetChar = (data.bldg_street == null ? '' : data
                                .bldg_street) + ' ' + data.present_barangay + ' ' + data
                            .present_municipality + ' ' + data.present_province + ', ' + (data
                                .present_zipcode == null ? '' : data.present_zipcode) + ' ';
                        $('#same_add').val(valueAfterTargetChar);
                        $('.same_div').hide();
                    } else {
                        $('#perm_add_check').prop("checked", false);
                        $('#same_add').val('');
                        $('.same_div').show();
                        $('#province').val(data.province_code).trigger('change');
                        $('#province_name').val(data.province);
                        $('#city').val(data.municipality_code);
                        perm_muncode = data.municipality_code;
                        $('#municipality_name').val(data.municipality);
                        perm_brgycode = data.barangay_code;
                        $('#bldg_street').val(data.bldg_street);
                        $('#zipcode').val(data.zipcode);
                    }
                    if (data.contribution_set == 'Percentage of Basic Salary') {
                        $('#percentage_check').prop("checked", true);
                        $('#percentage_bsalary').val(data.percentage == null ? '' : data.percentage);
                        $('#computed_amount').text(data.amount == null ? '' : data.amount);
                    } else {
                        $('#fixed_amount_check').prop("checked", true);
                        $('#fixed_amount').val(data.amount == null ? '' : data.amount);
                        var amount = $('#monthly_salary').val().replace(/,/g, "");
                        var total = amount * 0.01;
                        $("#min_contri").text(total.toFixed(2));
                    }
                }
            }

        });

    });

    $(document).on('click', '#save_sign', function() {
        var ref = reference_no;
        var id;
        if (ref != undefined) {
            id = ref;
        } else {
            id = query;
        }

        // var files = $('#file')[0].files;
        var esig = $('#e_sig').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var fd = new FormData();
        fd.append('esig', esig);
        fd.append('appNo', id);

        if (esig != '') {
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
                text: 'Please input your name as signature.',
                icon: 'warning'
            });
        }
    });

    // $(document).on('click', '#generateForm', function() {
    //     if ($(this).prop('checked')) {
    //         $('#proxy').show(300);
    //         $('.supporting_docu').hide(300);
    //         $('#coco').attr('required', false);
    //         $('#proxy_form').attr('required', false);
    //     } else {
    //         $('#proxy').hide(300);
    //         $('.supporting_docu').show(300);
    //         $('#coco').attr('required', true);
    //         $('#proxy_form').attr('required', true);
    //     }
    // });

    $(document).on('click', '#btn-axa', function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var id = pers_id;

        var formData = new FormData($("#generateAxa")[0]);
        var files = $('#sign_electronic')[0].files;
        formData.append('esig', files[0]);
        formData.append('personnel_id', personnel_id);

        // generateAxa
        // var formDatas = $("#generateAxa").serialize();
        // var additionalData = {
        //     'e_sig': $('#e_sig').val(),
        //     'personnel_id': pers_id,
        // };
        // formDatas += '&' + $.param(additionalData);

        $.ajax({
            url: "{{ route('add_cocolife') }}",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#loading').show();
            },
            success: function(data) {
                if (data.message == 'Exist') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'AXA form already generated.',
                        icon: 'error'
                    });
                    $("#modal_name").addClass("not-visible")
                    $("#modal_name").removeClass("visible")
                } else {
                    var url = "{{ URL::to('/axaform/') }}" + '/' +
                        $('#app_number').val(); //YOUR CHANGES HERE...
                    window.open(url, 'targetWindow', 'resizable=yes,width=1000,height=1000');
                    // $('#generateAxa').trigger('reset');
                    $("#modal_name").addClass("not-visible")
                    $("#modal_name").removeClass("visible")
                }
            },
            complete: function() {
                $('#loading').hide();
            }
        });
    })
    $(document).on('click', '#no_middlename', function() {
        if ($(this).is(':checked')) {
            $('input[name="middlename"]').val('N/A');
            $('input[name="middlename"]').prop('disabled', true);
        } else {
            $('input[name="middlename"]').val('');
            $('input[name="middlename"]').prop('disabled', false);
        }
    });

    $(document).on('click', '#no_suffix', function() {
        if ($(this).is(':checked')) {
            $('input[name="suffix"]').val('N/A');
            $('input[name="suffix"]').prop('disabled', true);
        } else {
            $('input[name="suffix"]').val('');
            $('input[name="suffix"]').prop('disabled', false);
        }
    });

    // $(document).on('submit', '#generateCoco', function(event) {
    //     event.preventDefault();
    //     var id = $('#app_number').val();

    //     $.ajax({
    //         url: "{{ route('add_cocolife') }}",
    //         method: "POST",
    //         data: new FormData(this),
    //         dataType: 'json',
    //         contentType: false,
    //         processData: false,
    //         beforeSend: function() {
    //             $('#loading').show();
    //         },
    //         success: function(data) {
    //             var url = "{{ URL::to('/generateCocolife/') }}" + '/' +
    //                 id; //YOUR CHANGES HERE...
    //             window.open(url, 'targetWindow', 'resizable=yes,width=1000,height=1000');
    //             $('#generateCoco').trigger('reset');
    //             $("#modal_name").addClass("not-visible")
    //             $("#modal_name").removeClass("visible")
    //         },
    //         complete: function() {
    //             $('#loading').hide();
    //         }
    //     });
    // })
</script>
@endsection