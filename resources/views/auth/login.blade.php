<!DOCTYPE html>
<html>

<head>
    <title>SIDMED</title>
    @include('partials.head')
    <link href="{{ url('adminlte3/bootstrap/bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ url('adminlte3/css/styleLogin.css') }}" rel="stylesheet">

    <style>
        html,
        body {
            min-height: 100%;
            font-family: Oxygen;
            font-weight: 300;
            font-size: 1em;
            color: #fff;
        }

        body {
            background: #36b3b9;
            background-image: none;
            background-image: -moz-radial-gradient(top, circle cover, #5292a8, #519b9b 80%);
        }

        .signin {
            display: block;
            position: relative;
            width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            -webkit-box-shadow: inset 1px 1px 0 0 rgba(255, 255, 255, 0.2), inset -1px -1px 0 0 rgba(0, 0, 0, 0.2);
            -moz-box-shadow: inset 1px 1px 0 0 rgba(255, 255, 255, 0.2), inset -1px -1px 0 0 rgba(0, 0, 0, 0.2);
            box-shadow: inset 1px 1px 0 0 rgba(255, 255, 255, 0.2), inset -1px -1px 0 0 rgba(0, 0, 0, 0.2);
        }

        .signin .avatar {
            width: 150px;
            height: 150px;
            margin: 0 auto 35px auto;
            border: 5px solid #36b3b9;
            -webkit-border-radius: 100%;
            -moz-border-radius: 100%;
            border-radius: 100%;
            -webkit-pointer-events: none;
            -moz-pointer-events: none;
            pointer-events: none;
        }

        .signin .avatar:before {
            text-align: center;
            font-family: Ionicons;
            display: block;
            height: 100%;
            line-height: 100px;
            font-size: 5em;
        }

        .signin .inputrow {
            position: relative;
        }

        .signin .inputrow label {
            position: absolute;
            top: 12px;
            left: 10px;
        }

        .signin .inputrow label:before {
            color: #538a9a;
            opacity: 0.4;
            -webkit-transition: opacity 300ms 0 ease;
            -moz-transition: opacity 300ms 0 ease;
            transition: opacity 300ms 0 ease;
        }

        .signin input[type="text"],
        .signin input[type="password"] {
            padding: 10px 12px 10px 32px;
            display: block;
            width: 100%;
            margin-bottom: 10px;
            border: 1px solid rgba(155, 155, 155, 0.5);
            background-color: #fff;
            color: #333;
            font-size: 1em;
            font-weight: 300;
            outline: none;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            -webkit-transition: border-color 300ms 0 ease;
            -moz-transition: border-color 300ms 0 ease;
            transition: border-color 300ms 0 ease;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            height: 40px !important;
        }

        .signin input[type="text"]:focus+label:before,
        .signin input[type="password"]:focus+label:before {
            opacity: 1;
        }

        .signin input[type="submit"] {
            -webkit-appearance: none;
            height: 40px;
            padding: 10px 12px;
            margin-bottom: 10px;
            background-color: #4bb3e6;
            text-transform: uppercase;
            color: #fff;
            border: 0px;
            float: right;
            margin: 0;
            outline: none;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 14px;
        }

        .signin input[type="submit"]:hover {
            background-color: #5e98a8;
        }

        .signin input[type="submit"]:active {
            background-color: #4a7b89;
        }

        input[type="checkbox"] {
            display: none;
        }

        input[type="checkbox"]+label {
            position: relative;
            padding-left: 36px;
            font-size: 0.6em;
            font-weight: normal;
            line-height: 16px;
            opacity: 0.8;
            text-transform: uppercase;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        input[type="checkbox"]+label:before,
        input[type="checkbox"]+label:after {
            content: "";
            position: absolute;
            display: block;
            height: 16px;
            -webkit-border-radius: 30px;
            -moz-border-radius: 30px;
            border-radius: 30px;
        }

        input[type="checkbox"]+label:before {
            left: 0;
            top: -2px;
            width: 30px;
            background: rgba(0, 0, 0, 0.3);
            -webkit-box-shadow: inset 1px 1px 1px 1px rgba(0, 0, 0, 0.3);
            -moz-box-shadow: inset 1px 1px 1px 1px rgba(0, 0, 0, 0.3);
            box-shadow: inset 1px 1px 1px 1px rgba(0, 0, 0, 0.3);
        }

        input[type="checkbox"]+label:after {
            opacity: 0.3;
            background: #fff;
            top: 0px;
            left: 2px;
            height: 12px;
            width: 12px;
            -webkit-transition: all 200ms 0 ease;
            -moz-transition: all 200ms 0 ease;
            transition: all 200ms 0 ease;
        }

        input[type="checkbox"]:checked+label {
            opacity: 1;
        }

        input[type="checkbox"]:checked+label:after {
            opacity: 1;
            left: 16px;
        }

        .cf:before,
        .cf:after {
            content: " ";
            display: table;
        }

        .cf:after {
            clear: both;
        }

        .cf {
            *zoom: 1;
        }
    </style>
    <style>
        /* #### Mobile Phones Landscape #### */
        @media screen and (max-device-width: 640px) and (orientation: landscape) {
            .signin {
                width: 100%;
                height: 100%;
                margin: 0px;

            }
        }

        /* #### Mobile Phones Portrait or Landscape #### */
        @media screen and (max-device-width: 640px) {
            .signin {
                width: 100%;
                height: 100%;
                margin: 0px;

            }
        }

        /* #### iPhone 4+ Portrait or Landscape #### */
        @media screen and (max-device-width: 480px) and (-webkit-min-device-pixel-ratio: 2) {
            .signin {
                width: 100%;
                height: 100%;
                margin: 0px;

            }
        }

        /* #### Tablets Portrait or Landscape #### */
        @media screen and (min-device-width: 768px) and (max-device-width: 1024px) {
            .signin {
                width: 100%;
                height: 100%;
                margin: 0px;
            }
        }
    </style>

</head>

<body>

    <link href="{{ url('css/font.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('css/ionicons.min.css') }}" rel="stylesheet" type="text/css" />
    <div class="signin cf">
        <div class="avatar">
            <h2 style="padding-top: 50px;
            padding-left: 22px;font-weight: bold;color:#36b3b9">SIMED</h2>
        </div>
        <form class="login100-form validate-form" role="form" method="POST" action="{{ url('login') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="inputrow">
                <input type="text" class="form-control" name="name" maxlength="13" value="{{ old('name') }}"
                    placeholder="username" id="name">
                <label class="ion-person" for="name"></label>
            </div>
            <div class="inputrow">
                <input type="password" id="pass" class="form-control" name="password" placeholder="password">
                <label class="ion-locked" for="pass"></label>
            </div>
            <input id="remember" type="checkbox" name="remember" />
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong></strong> Existe un problema con el dato ingresado:
                    <br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <input type="submit"style="width:100%" value="Iniciar Sesión" />

        </form>
    </div>
</body>

</html>
