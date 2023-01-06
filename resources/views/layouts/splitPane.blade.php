@extends('layouts/index')
@section('content')
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
        <div id="registrationform" hidden="hidden" class="container-fluid relative pv-3">
            @section('registration-personal-form')
            @show
        </div>
        <div class="sticky bottom-0 mp-pv5 mp-ph1 items-between mp-pb2 bg-white mt-auto d-none" id="control">
            <a class="up-button btn-md" id="back" value="">
                Back
            </a>
            <a class="up-button btn-md" type="submit" value="step-2" id="next-btn">
                Next
            </a>
        </div>
    </div>
    <div class="mp-split-pane__right">
        @section('right')
        @show
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

    var my_handlers = {

        fill_provinces: function() {
            var region_code = $(this).val();
            $('#province').ph_locations('fetch_list', [{
                "region_code": region_code
            }]);

        },

        fill_cities: function() {
            var province_code = $(this).val();
            $('#city').ph_locations('fetch_list', [{
                "province_code": province_code
            }]);
        },

        fill_barangays: function() {
            var city_code = $(this).val();
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
        } else if (backValue == 'step-2') {
            $("#step-2").removeClass('d-none').addClass("d-flex");
            $("#step-3").removeClass('d-flex').addClass("d-none");
            $("#back").attr('value', "step-1")
            $("#next-btn").attr('value', 'step-3')
        } else {
            $("#registrationform").attr("hidden", true);
            $("#loginform").removeAttr("hidden");
            $("#next-btn").attr('value', 'step-2');
            $("#leftsection").removeClass("mw-600").removeClass("w-600");
            $("#control").removeClass("d-flex").addClass("d-none");
        }
    })
    $(document).on('click', '#next-btn', function(e) {
        var nextValue = $(this).attr('value')
        if (nextValue == 'step-2') {
            $("#step-1").removeClass('d-flex').addClass("d-none");
            $("#step-2").removeClass('d-none').addClass("d-flex");
            $("#back").attr('value', 'step-1')
            $(this).attr('value', 'step-3')
        } else if (nextValue == 'step-3') {
            $("#step-2").removeClass('d-flex').addClass("d-none");
            $("#step-3").removeClass('d-none').addClass("d-flex");
            $("#back").attr('value', 'step-2')
            $(this).attr('value', 'step-end')
        } else if (nextValue == 'step-end') {
            alert('end')
            $("#btn-submit").click()
        }

    })
</script>
@endsection
