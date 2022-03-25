<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ setting('site_name') }} | {{ setting('site_title') }}</title>
    <!-- REQUIRED CSS -->
    <link rel="stylesheet" href="/css/app.css">
    <!-- Individual Page CSS -->
    @stack('styles')
    <!-- Livewire Style -->
    @livewireStyles
</head>
<body class="hold-transition sidebar-mini {{ setting('sidebar_collapse') ? 'sidebar-collapse' : '' }}">
<div class="wrapper">

    <!-- Navbar -->
    @include('layouts.partials.navbar')

    <!-- Main Sidebar Container -->
    @include('layouts.partials.aside')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    {{ $slot }}
    </div>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
        </div>
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    @include('layouts.partials.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<script src="/js/app.js"></script>

<!-- Custom Script -->
<script src="/js/backend.js"></script>

<!-- Individual Page Script -->
@stack('js')

<!-- Livewire Script -->
@livewireScripts

@stack('after-livewire-scripts')

<!-- Alpine.js -->
@stack('apline-plugins')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
