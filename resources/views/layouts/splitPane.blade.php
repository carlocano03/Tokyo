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

        <div id="registrationform" hidden="hidden" class="container-fluid relative pv-3">
            @section('registration-personal-form')
            @show
        </div>
        <div class="sticky bottom-0 mp-pv5 items-between mp-pb2 bg-white mt-auto d-none mp-pt3" id="control">
            <a class="up-button btn-md button-animate-left hover-back" id="back" value="">
                <span>Back</span>
            </a>
            <a class="up-button btn-md button-animate-right " type="submit" value="step-2" id="next-btn">
                <span>Next</span>
            </a>
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
    });


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
    $(document).on('click', '#back', function(e) {
        var backValue = $(this).attr('value')
        if (backValue == 'step-1') {
            $("#step-1").removeClass('d-none').addClass("d-flex");
            $("#step-2").removeClass('d-flex').addClass("d-none");
            $("#back").attr('value', "")
            $("#next-btn").attr('value', 'step-2')
            $("#line").removeClass('step-2').addClass('step-1')
            $("#registration-title").text(stepTitle[0])


        } else if (backValue == 'step-2') {
            $("#step-2").removeClass('d-none').addClass("d-flex");
            $("#step-3").removeClass('d-flex').addClass("d-none");
            $("#back").attr('value', "step-1")
            $("#next-btn").attr('value', 'step-3')
            $("#line").removeClass('step-3').addClass('step-2')
            $("#registration-title").text(stepTitle[1])
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
    $(document).on('click', '#next-btn', function(e) {
        var nextValue = $(this).attr('value')
        if (nextValue == 'step-2') {
            $("#step-1").removeClass('d-flex').addClass("d-none");
            $("#step-2").removeClass('d-none').addClass("d-flex");
            $("#back").attr('value', 'step-1')
            $(this).attr('value', 'step-3')
            $("#line").removeClass('step-1').addClass('step-2')
            $("#registration-title").text(stepTitle[1])
        } else if (nextValue == 'step-3') {
            $("#step-2").removeClass('d-flex').addClass("d-none");
            $("#step-3").removeClass('d-none').addClass("d-flex");
            $("#back").attr('value', 'step-2')
            $(this).attr('value', 'step-end')
            $("#line").removeClass('step-2').addClass('step-3')
            $("#registration-title").text(stepTitle[2])
        } else if (nextValue == 'step-end') {
            alert('end')
            $("#btn-submit").click()
        }
        scrollToTop()
    })

    function scrollToTop() {
        $('html, body, div').animate({
            scrollTop: $('#leftsection').offset().top - 20 
        }, 300);
    }
</script>
@endsection