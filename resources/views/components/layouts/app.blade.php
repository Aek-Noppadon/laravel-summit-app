<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/logo/favicon.png') }}" type="image/png" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('backend/admin-lte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('backend/admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('backend/admin-lte/dist/css/adminlte.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('backend/admin-lte/plugins/sweetalert2/sweetalert2.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('backend/admin-lte/plugins/toastr/toastr.min.css') }}">
    @livewireStyles
    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>
    <!-- Header Script -->
    @yield('header-script')
    <!-- ./Header Script -->

    @stack('styles')
</head>

<body class="hold-transition sidebar-mini sidebar-collapse layout-fixed">
    <div class="wrapper">
        <!-- Component Layout/Header -->
        @livewire('layout.header')
        <!-- ./Component Layout/Header -->

        <!-- Component Layout/Sidebar -->
        @livewire('layout.sidebar')
        <!-- ./Component Layout/Sidebar -->

        <!-- Content Start -->
        <div class="content-wrapper">
            {{ $slot }}
        </div>
        <!-- Content End -->

        <!-- Componetn Layout/Footer -->
        @livewire('layout.footer')
        <!-- ./Componetn Layout/Footer -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('backend/admin-lte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('backend/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('backend/admin-lte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('backend/admin-lte/plugins/toastr/toastr.min.js') }}"></script>
    <!-- bs-custom-file-input -->
    <script src="{{ asset('backend/admin-lte/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('backend/admin-lte/dist/js/adminlte.js') }}"></script>
    <!-- Plugins AlpineJS -->
    <script src="{{ asset('backend/plugins/alpine-js/number.js') }}"></script>

    <!-- Sweet Alert -->
    <script>
        document.addEventListener("sweet.success", event => {
            Swal.fire({
                position: event.detail.position,
                title: event.detail.title,
                text: event.detail.text,
                icon: event.detail.icon,
                timer: event.detail.timer,
            }).then(function() {
                if (event.detail.url) {
                    window.location = event.detail.url
                }
            })
        })

        document.addEventListener("sweet.error", event => {
            Swal.fire({
                position: event.detail.position,
                title: event.detail.title,
                text: event.detail.text,
                icon: event.detail.icon,
                timer: event.detail.timer,
            }).then(function() {
                if (event.detail.url) {
                    window.location = event.detail.url
                }
            })
        })
    </script>
    <!-- ./Sweet Alert -->

    <!-- Toastr Alert -->
    <script>
        document.addEventListener("toastr.success", event => {
            toastr.options = ({
                positionClass: event.detail.position,
                progressBar: event.detail.progressbar,
                timeOut: event.detail.timeout,
            })
            toastr.success(event.detail.message, event.detail.title)
        })

        document.addEventListener("toastr.info", event => {
            toastr.options = ({
                positionClass: event.detail.position,
                progressBar: event.detail.progressbar,
                timeOut: event.detail.timeout,
            })
            toastr.info(event.detail.message, event.detail.title)
        })

        document.addEventListener("toastr.warning", event => {
            toastr.options = ({
                positionClass: event.detail.position,
                progressBar: event.detail.progressbar,
                timeOut: event.detail.timeout,
            })
            toastr.warning(event.detail.message, event.detail.title)
        })
        document.addEventListener("toastr.error", event => {
            toastr.options = ({
                positionClass: event.detail.position,
                progressBar: event.detail.progressbar,
                timeOut: event.detail.timeout,
            })
            toastr.error(event.detail.message, event.detail.title)
        })
    </script>
    <!-- ./Toastr -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // เปิดใช้งาน Tooltip ของ Bootstrap
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    @livewireScripts
    @stack('scripts')
</body>

</html>
