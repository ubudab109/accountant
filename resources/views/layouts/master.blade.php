<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Sistem Accountant</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">

        <!-- Bootstrap Css -->
        <link href="{{ asset('css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/sweetalert2.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.css') }}" />
    </head>

    <body class="">
        @include('sweetalert::alert')
        <div id="layout-wrapper">

            {{-- HEADER HERE --}}
            @include('layouts.component.header')
            {{-- END HEADER --}}

            {{-- SIDEBAR --}}
            @include('layouts.component.sidebar')
            {{-- END SIDEBAR --}}

            {{-- MAIN CONTENT --}}
                <div class="main-content">
                    <div class="page-content">
                        <div class="container-fluid">
                            @yield('content')
                        </div>
                    </div>
                </div>
            {{-- END MAIN CONTENT --}}

            {{-- FOOTER --}}
            @include('layouts.component.footer')
            {{-- END FOOTER --}}
        </div>

        <!-- JAVASCRIPT -->
        <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ asset('libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
        <script src="{{ asset('libs/jquery.counterup/jquery.counterup.min.js') }}"></script>

        <script src="{{ asset('js/libs/app.js') }}"></script>
        <script src="{{ asset('js/date.js') }}"></script>
        <script src="{{ mix('js/app.js') }}"></script>
        <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
        <script src="{{ asset('js/libs/jquery.validate.js') }}"></script>
        <script src="{{ asset('js/libs/dataTables.min.js') }}"></script>
        <script src="{{ asset('js/libs/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('js/libs/jszip.min.js') }}"></script>
        <script src="{{ asset('js/libs/pdfmake.min.js') }}"></script>
        <script src="{{ asset('js/libs/vfs_fonts.js') }}"></script>
        <script src="{{ asset('js/libs/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('js/libs/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('js/libs/bootstrap-datepicker.js') }}"></script>
        @yield('scripts')
    </body>
</html>
