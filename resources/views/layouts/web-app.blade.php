<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Business Directory & Listing</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('web/img/favicon.png') }}">
    <!-- Custom CSS -->
    <link href="{{ asset('web/css/styles.css') }}" rel="stylesheet">
    <!-- Individual Page CSS -->
    @stack('styles')
    <!-- Livewire Style -->
    @livewireStyles
</head>

<body>

<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader"></div>

<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper">

    <!-- ============================================================== -->
    <!-- Top header  -->
    <!-- ============================================================== -->
    <!-- Start Navigation -->
    @include('layouts.web-partials.navbar')

    <div class="clearfix"></div>
    <!-- ============================================================== -->
    <!-- Top header  -->
    <!-- ============================================================== -->

    {{ $slot }}

    <!-- ============================ Footer Start ================================== -->
    @include('layouts.web-partials.footer')


    <!-- Log In Modal -->
    <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="loginmodal" aria-hidden="true">
        <div class="modal-dialog login-pop-form" role="document">
            <div class="modal-content" id="loginmodal">
                <div class="modal-headers">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span class="ti-close"></span>
                    </button>
                </div>

                <div class="modal-body p-5">
                    <div class="text-center mb-4">
                        <h4 class="m-0 ft-medium">Login Your Account</h4>
                    </div>

                    <form class="submit-form">
                        <div class="form-group">
                            <label class="mb-1">User Name</label>
                            <input type="text" class="form-control rounded bg-light" placeholder="Username*">
                        </div>

                        <div class="form-group">
                            <label class="mb-1">Password</label>
                            <input type="password" class="form-control rounded bg-light" placeholder="Password*">
                        </div>

                        <div class="form-group">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="flex-1">
                                    <input id="dd" class="checkbox-custom" name="dd" type="checkbox" checked>
                                    <label for="dd" class="checkbox-custom-label">Remember Me</label>
                                </div>
                                <div class="eltio_k2">
                                    <a href="#" class="theme-cl">Lost Your Password?</a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-md full-width theme-bg text-light rounded ft-medium">Sign In</button>
                        </div>

                        <div class="form-group text-center mb-0">
                            <p class="extra">Or login with</p>
                            <div class="option-log">
                                <div class="single-log-opt"><a href="javascript:void(0);" class="log-btn"><img src="{{ asset('web/') }}/img/c-1.png" class="img-fluid" alt="" />Login with Google</a></div>
                                <div class="single-log-opt"><a href="javascript:void(0);" class="log-btn"><img src="{{ asset('web/') }}/img/facebook.png" class="img-fluid" alt="" />Login with Facebook</a></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <a id="tops-button" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>


</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="{{ asset('web/js/jquery.min.js') }}"></script>
<script src="{{ asset('web/js/popper.min.js') }}"></script>
<script src="{{ asset('web/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('web/js/slick.js') }}"></script>
<script src="{{ asset('web/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('web/js/dropzone.js') }}"></script>
<script src="{{ asset('web/js/counterup.js') }}"></script>
<script src="{{ asset('web/js/lightbox.js') }}"></script>
<script src="{{ asset('web/js/moment.min.js') }}"></script>
<script src="{{ asset('web/js/daterangepicker.js') }}"></script>
<script src="{{ asset('web/js/lightbox.js') }}"></script>
<script src="{{ asset('web/js/jQuery.style.switcher.js') }}"></script>
<script src="{{ asset('web/js/custom.js') }}"></script>
<!-- Individual Page Script -->
@stack('js')
<!-- Livewire Script -->
@livewireScripts
<!-- ============================================================== -->
<!-- This page plugins -->
<!-- ============================================================== -->

</body>
</html>
