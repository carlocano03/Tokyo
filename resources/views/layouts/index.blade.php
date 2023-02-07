<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{!! csrf_token() !!}">
    <meta content="text/html; charset=utf-8">
    <meta name="keywords" content="UP Provident Fund Inc. Members Portal">
    <meta name="description" content="UP Provident Fund Inc. Members Portal">
    <meta name="author" content="White Widget">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>UP-PROVIDENT FUND INC.</title>
    <link href="{{ asset('/favicon.ico') }}" rel="icon">
    <link href="//cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css" rel="stylesheet">
    {{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> --}}
    <link href="{!! asset('dist/style.css') !!}" rel="stylesheet">
    <link href="{!! asset('dist/jquery.datetimepicker.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('dist/font-awesome-4.7.0/css/font-awesome.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('dist/select2-4.0.13/css/select2.min.css') !!}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    {{-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> --}}
    <script src="//ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="{!! asset('dist/jquery.ph-locations.js') !!}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="{!! asset('dist/jquery.datetimepicker.js') !!}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script>
        WebFont.load({
            google: {
                families: ['Fira Sans:300,400,500,600,700']
            }
        });
    </script>
    <script src="{{ asset('/dist/vendor.js') }}"></script>
    <script src="{{ asset('/dist/dashboard.js') }}"></script>
    <script src="{{ asset('/dist/select2-4.0.13/js/select2.min.js') }}"></script>
    <style>
        #loading {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            display: block;
            /* opacity: 0.7; */
            background-color: rgba(255, 255, 255, 0.9);
            z-index: 150;
        }

        #loading-image {
            position: absolute;
            margin-right: -50px;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
            width: 200px;

        }

        .opacity-0 {
            opacity: 0 !important;
        }

        #modalBackDrop {
            position: absolute;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, .3);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .5s;
            opacity: 1;
        }

        .modalContent {
            position: absolute;
            display: flex;
            flex-direction: column;
            width: 70vw;
            height: 23vh;
            background-color: white;
            margin-bottom: 100px;
            padding: 40px;
            border-radius: 17px;
            transition: all .5s;
        }

        .modalBody {
            height: 90%;
            display: flex;
            align-items: center;
        }

        .modalFooter {
            display: flex;
            justify-content: center;
        }

        .modalFooter>button {
            font-size: 25px;
            padding-left: 20px;
            padding-right: 20px;
            background-color: #894168;
            font-weight: 400;
            color: white;
            border-radius: 17px;
        }

        @media (max-width:500px) {
            .modalContent {
                width: 90vw;
                height: 30vh;
                padding: 20px;
                padding-bottom: 30px;
            }

            .modalBody {
                text-align: center;
            }
        }
    </style>





</head>
<script>
    $(document).on('click', '#agree', function(e) {
        $("#modalBackDrop").addClass("opacity-0")
        setTimeout(function() {
            $("#modalBackDrop").addClass("d-none")
        }, 500)
        sessionStorage.setItem("agreeClicked", true)
    })
    $(document).ready(function(e) {
        if (sessionStorage.getItem("agreeClicked") == null) {
            $("#modalBackDrop").removeClass("d-none")
            setTimeout(function() {
                $("#modalBackDrop").removeClass("opacity-0")
            }, 100)
        }
    })
</script>

<body id="uppfi">
    <div id="loading" class="mx-auto" style="display:none;">
        <img id="loading-image" src="{{ asset('/img/logo_gif_blue.gif') }}" alt="Loading..." />
    </div>
    <div id="modalBackDrop" class="d-none opacity-0">
        <div class="modalContent">
            <div class="modalBody">
                <p>UPPFI uses a third party service to analyze non-identifiable web traffic for us. This site uses cookies. Data generated is not disclosed not shared with any other party. For more information please see our <a href="#" class="link_style">Privacy Policy</a>.</p>
            </div>
            <div class="modalFooter">
                <button id="agree">
                    I Agree
                </button>
            </div>
        </div>
    </div>
    @section('content')
    @extends('layouts/footer')
    @show
    @yield('scripts')

</body>

</html>