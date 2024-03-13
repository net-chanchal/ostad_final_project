<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Employer : : @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('storage/uploads/' .  CoreHelper::getSetting('SETTING_SITE_FAVICON')) }}" type="image/x-icon">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset("assets/modules/datatables/datatables.min.css") }}"/>
    @stack('css-libraries')

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.black.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

    @stack('styles')
</head>

<body>
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        @include('employer.layouts.nav')
        @include('employer.layouts.aside')
        @yield('content')
        @include('employer.layouts.footer')
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Action URL get from Javascript -->
            <form action="" id="deleteModelForm" method="post">
                @csrf
                @method("delete")
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Do you want to delete?</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pb-0">
                    You cannot restore after deletion.<br>
                    Type <b>CONFIRM DELETE</b> for delete and submit Delete button.
                    <div class="form-group">
                        <label for="deleteModalInput"></label>
                        <input type="text" class="form-control" id="deleteModalInput">
                    </div>

                    <b class="text-danger" id="deleteModalMessage"></b>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger"  id="deleteModalButton">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- General JS Scripts -->
<script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
<script src="{{ asset('assets/modules/popper.js') }}"></script>
<script src="{{ asset('assets/modules/tooltip.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('assets/modules/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/stisla.js') }}"></script>

<!-- JS Libraries -->
<script src="{{ asset("assets/modules/datatables/datatables.min.js") }}"></script>
@stack('js-libraries')

<!-- Page Specific JS File -->

<!-- Template JS File -->
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>

@stack('scripts')
</body>
</html>