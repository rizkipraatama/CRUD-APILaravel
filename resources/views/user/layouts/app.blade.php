<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSPINIA - @yield('title') </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{ url('css/vendor.css')}}" rel="stylesheet">
    <link href="{{ url('css/app.css')}}" rel="stylesheet">
    
     <link href="{{ url('css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
    
    <link  href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

</head>
<body>

  <!-- Wrapper-->
    <div id="wrapper">

        <!-- Navigation -->
        @include('user.layouts.navigation')

        <!-- Page wraper -->
        <div id="page-wrapper" class="gray-bg">

            <!-- Page wrapper -->
            @include('user.layouts.topnavbar')

            <!-- Main view  -->
            @yield('content')
            @stack('scripts')
            <!-- Footer -->
            @include('user.layouts.footer')

        </div>
        <!-- End page wrapper-->

    </div>
    <!-- End wrapper-->

<script src="{{ url('js/bootstrap.min.js') }}"></script> 
@section('scripts')
@show

</body>
</html>
