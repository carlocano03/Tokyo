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
    <link href="https://fonts.googleapis.com/css2?family=Homemade+Apple&display=swap" rel="stylesheet">
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    {{-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> --}}
    <script src="//ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="{!! asset('dist/jquery.ph-locations.js') !!}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="{!! asset('dist/jquery.datetimepicker.js') !!}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://kit.fontawesome.com/f9fec12609.js" crossorigin="anonymous"></script>
    <script>
        WebFont.load({
            google: {
                families: ['Fira Sans:300,400,500,600,700']
            }
        });
        WebFont.load({
    google: {
      families: ['Droid Sans', 'Droid Serif']
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
            background-color: white;
            margin-bottom: 100px;
            padding: 40px;
            border-radius: 17px;
            transition: all .5s;
            gap: 30px;
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

        .cookie-drawer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: white;
            border-top: 1px solid #badcd9;
            padding: 10px 20px;
            font-size: 14px;
            transform: translateY(100%);
            z-index: 20;
            transition: transform 0.3s ease-in-out;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .cookie-drawer.show {
            transform: translateY(0);
        }


        /* .cookie-accept {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }

        .cookie-accept:hover {
            background-color: #0062cc;
        } */

        /* .cookie-learn-more {
            color: #007bff;
            text-decoration: none;
            border-bottom: 1px dotted #007bff;
            cursor: pointer;
        }

        .cookie-learn-more:hover {
            color: #0056b3;
            border-bottom-style: solid;
        } */

        .centered-text {
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        .cookie-body {
            display: flex;
            flex-direction: row;
            align-items: center;
            width: 100%;
        }

        .w-70 {
            width: 70%;
        }

        .w-30 {
            width: 30%;
        }

        .pl-15 {
            padding-left: 15px;
        }

        .cookie-buttons > button {
            padding-left: 20px;
            padding-right: 20px;
            background-color: #894168;
            color: white;
            border-radius: 17px;
        }

        .magenta-bg {
            background-color: #1a8981 !important;
        }


        

    </style>





</head>
<script>
    $(document).on('click', '#agree', function(e) {
        window.location.href = '/register';
        // $("#modalBackDrop").addClass("opacity-0")
        // setTimeout(function() {
        //     $("#modalBackDrop").addClass("d-none")
        // }, 500)
        // sessionStorage.setItem("agreeClicked", true)
    })
    $(document).on('click', '#disagree', function(e) {
        $("#modalBackDrop").addClass("opacity-0")
        setTimeout(function() {
            $("#modalBackDrop").addClass("d-none")
        }, 1000)
    })

    $(document).on('click', '#register-link', function(e) {
        $("#modalBackDrop").removeClass("d-none")
        setTimeout(function() {
            $("#modalBackDrop").removeClass("opacity-0")
        }, 100)
    })
    
    $(document).ready(function(e) {
        
        if (sessionStorage.getItem("cookieClicked") == null) {
            setTimeout(()=>{
                $(".cookie-drawer").addClass("transition-drawer");
                $(".cookie-drawer").addClass("show");
            },1000)
        } else {
            $(".cookie-drawer").removeClass("transition-drawer");
            $(".cookie-drawer").removeClass("show");
        }
    })
    $(document).ready(function() {
        $(".cookie-close").click(function() {
            $(".cookie-drawer").removeClass("show");
        })
        $(".cookie-accept").click(function() {
            $(".cookie-drawer").removeClass("show");
            sessionStorage.setItem("cookieClicked", true)
        });
        $(".cookie-decline").click(function() {
            $(".cookie-drawer").removeClass("show");
            sessionStorage.setItem("cookieClicked", "declined")
        });
    }); 
</script>

<body id="uppfi">
    <div id="loading" class="mx-auto" style="display:none;">
        <img id="loading-image" src="{{ asset('/img/logo_gif_blue.gif') }}" alt="Loading..." />
    </div>
    <div id="modalBackDrop" class="d-none opacity-0">
        <div class="modalContent">
            <div class="modalBody">
                <div class="d-flex flex-column gap-10"> <span style="font-weight: bold; font-size: x-large">Data Privacy Notice</span>

                    <span>
                        <span style="color:#1a8981; font-weight: bold">U.P. Provident Fund (UPPF)</span> upholds the <span style="font-style: italic; font-weight: bold">Data Privacy Act</span>, and is committed to the protection of the privacy rights of its members, employees, officers, or stakeholders from whom it processes personal information and sensitive personal information, guided all the time by the principles of legitimacy, transparency, and proportionality. 
                        <br/><br/>Thus, <span style="font-weight: bold">UPPF</span> has instituted strict measures to safeguard the sanctity and confidentiality of those data/information. The Company strictly adheres to the duties and responsibilities (before, during, and after processing of information), mandated by Republic Act 10173 and allied government regulations. <br/><br/> 
                        Kindly sign below to signify your free, prior, and informed consent for <span style="font-weight: bold">UPPF</span> to proceed with this personal data processing, and to allow <span style="font-weight: bold">UPPF</span> to use the information for 
                        (i)the appropriate delivery of its products and services,
                        (ii) necessary documentation or submission, and/ or (iii) pursuance of transactions expected from its position.
                    </span>
                </div>
            </div>
            <div class="modalFooter gap-10">
                <button id="agree">
                    I Agree
                </button>
                <button id="disagree">
                    I do not Agree
                </button>
            </div>
        </div>
    </div>
    <div class="cookie-drawer">
        <div class="d-flex flex-row items-between">
            <span class="centered-text">
                <img style="width: 30px; height: 30px; margin-right: 10px" src="{!! asset('assets/images/uppfi-logo-sm.png') !!}" alt="UPPFI"> <span style="font-size: large; font-weight: 700;"> We use cookies</span>
            </span>
            <span>
                <i class="fa fa-times-circle cursor-pointer cookie-close" aria-hidden="true"></i>
            </span>
        </div>
        <div class="cookie-body">
            <div class="w-70 mp-pl2 mp-mt3">By clicking "Accept", you agree to the storing of cookies on your device to enhance site navigation, analyze site usage, and assist in our marketing efforts. <span><a>Privacy and Cookies Policy</a></span></div>
            <div class="cookie-buttons w-30 d-flex flex-row justify-content-end gap-10 align-items-start mp-pr2">
                <button class="cookie-accept">Accept</button>
                <button class="magenta-bg cookie-decline">I do not accept</button>
            </div>
        </div>
        
    </div>
    @section('content')
    @extends('layouts/footer')
    @show
    @yield('scripts')

</body>

</html>