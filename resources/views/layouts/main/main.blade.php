<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'index')</title>

<!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,400i,700&amp;subset=latin-ext" rel="stylesheet">
    <link href="{{URL::asset('css/bootstrap/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- custom -->
    <link rel="stylesheet" href="{{URL::asset('css/ribbons.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/main_app_style.css')}}">
    <!-- /Styles -->

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
<div class="wrapper">

    @include('layouts.main.includes.header')

    @yield('content')

    <?php /* @include('lte.includes.footer') */ ?>

    <?php /* @include('lte.includes.panel_right') */ ?>
</div>
<!-- ./wrapper -->

<!-- Scripts -->

<!-- jQuery 2.2.3 -->
<script src="{{URL::asset('js/plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{URL::asset('js/plugins/jQueryUI/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="{{URL::asset('js/bootstrap/bootstrap.min.js')}}"></script>

<script src="{{URL::asset('js/notify.min.js')}}"></script>
<script src="{{URL::asset('js/scrolling_nav.js')}}"></script>
<script src="{{URL::asset('js/contact_form.js')}}"></script>
<script src="{{URL::asset('js/main_app_js.js')}}"></script>

<!-- /Scripts -->

</body>
</html>
