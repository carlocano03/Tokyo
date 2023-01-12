@extends('layouts/index')
@section('content')


<!-- mobile transition -->
<!-- <div class="mobile-header">
                    <div class="logo-title">
                        <div class="mp-pb4  mp-text-center logo-text">
                                <img src="{!! asset('assets\favicon\ms-icon-310x310.png') !!}" alt="UPPFI">
                                <br>
                                <label for="">
                                       UP Provident Fund
                                </label>
                              
                        </div>
                    </div>
                </div> -->
<!-- <div class="transition-background">

            </div> -->
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

        <div id="registrationform" hidden="hidden" class="container-fluid relative pv-3-auto" style="height: calc(100% - 53px)">
            @section('registration-personal-form')
            @show
        </div>
        <div class="mv-5-auto items-between  bg-white mt-auto d-none flex-column mb-5" id="control">
            <div class="d-flex items-between bg-cyan-50 mp-pb2 mp-pt2 mp-pv3">
                <a class="up-button btn-md button-animate-left hover-back" id="back" value="">
                    <span>Back</span>
                </a>
                <a class="up-button btn-md button-animate-right " type="submit" value="step-2" id="next-btn">
                    <span>Next</span>
                </a>
            </div>
        </div>

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
    $(document).on('click', '#back', function(e) {
        var backValue = $(this).attr('value')
        if (backValue == 'step-1') {
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

    $(document).on('click', '#next-btn', function(e) {
        var nextValue = $(this).attr('value')
        if (nextValue == 'step-2') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (!personnel_id) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('add_member') }}",
                    data: $('#member_forms').serialize(),
                    success: function(data) {
                        if (data.success != '') {
                            reference_no = data.randomnum;
                            mem_id = data.mem_id;
                            personnel_id = data.success;
                            Swal.fire({
                                title: 'This is your reference code:' + reference_no,
                                icon: 'success'
                            });
                        }
                    }
                });
            } else {
                $("#member_forms").on("change", "input", function() {
                    alert("Data in the form has been changed!");
                });
                //     var formDatas = $("#member_forms").serialize();
                //     var additionalData = {
                //         'mem_id': mem_id,
                //         'personnel_id': personnel_id,
                //     };
                //     formDatas += '&' + $.param(additionalData);
                //     $.ajax({
                //     type: 'POST',
                //     url: "{{ route('add_member_update') }}",
                //     data: formDatas,
                //     success: function(data) {
                //         if (data.success != '') {
                //             reference_no = data.randomnum;
                //             mem_id = data.mem_id;
                //             personnel_id = data.success;
                //             Swal.fire({
                //                 title: 'This is your reference code:'+ reference_no,
                //                 icon: 'success'
                //                 });
                //         }
                //     }
                // });
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
                    }
                }
            });
            $("#step-2").removeClass('d-flex').addClass("d-none");
            $("#step-3").removeClass('d-none').addClass("d-flex");
            $("#back").attr('value', 'step-2')
            $("#member_forms_con").removeClass('mh-reg-form');
            $("#member_forms_3").addClass('mh-reg-form');
            $(this).attr('value', 'step-end')
            $("#line").removeClass('step-2').addClass('step-3')
            $("#registration-title").text(stepTitle[2])
            $("#stepper-3").addClass("active")
        } else if (nextValue == 'step-end') {
            // alert('end')
            $("#btn-submit").click()
        }
        scrollToTop()
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
                    relation: relation
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
        var tableDependent = $('#dependentTable').DataTable({
            ordering: false,
            info: false,
            searching: false,
            paging: false,
            processing: true,
            serverSide: true,
            ajax: "{{ route('getBeneficiary') }}",
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
                var valueAfterTargetChar = myString4 + ' ' + myString3 + ' ' + myString2.split(targetChar)[1] + ' ' + myString1.split(targetChar)[1] + ' ' + myString.split(targetChar)[1];
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


    function scrollToTop() {
        $('html, body, div, div, div, form').animate({
            scrollTop: $('#leftsection').offset().top - 20
        }, 300);
    }
</script>
@endsection