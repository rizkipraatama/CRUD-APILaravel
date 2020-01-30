<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Login</title>

    <link href="{{ url('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ url('font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ url('css/animate.css')}}" rel="stylesheet">
    <link href="{{ url('css/style.css')}}" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">EMP</h1>

            </div>
            <h3>Perpustakaan</h3>
            <p>Jendela Ilmu
                <!--Continually expanded and constantly improved Inspinia Admin Them (IN+)-->
            </p>
            <p>Login in.</p>
             <form method="POST" action="{{ route($loginRoute) }}">

                        @csrf
                <div class="form-group">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                </div>
                <div class="form-group">
                    <input id="password" type="password" class="form-control" name="password" required>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary block full-width m-b">{{ __('Login') }}</button>
                </div>
            </form>
            <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{ url('js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{ url('js/bootstrap.min.js')}}"></script>
    <script src="{{ url('js/app.js') }}" defer></script>
</body>

</html>
