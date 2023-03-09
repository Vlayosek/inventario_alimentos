<!DOCTYPE html>
<html>
    <head>
        <title>Be right back.</title>

        {{--<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">--}}

        <style>

            html, body {
                height: 100%;
                background-image: url(/img/hero-background.png);
                background-size: 100%;
                background-position: center;
                background-color: #0009;
                position: absolute;
                top: 0;
                width: 100%;
                height: 100vh;
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-position: center;
                background-size: cover;
                overflow: hidden;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #7b212194;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content" style="background-color: #ffffffc4">
                <div style="margin:50px" >
                    <div class="title"><strong>
                            Error en su acceso .</strong></div>
                    <h2><strong>No tiene permiso para acceder</strong></h2>
                    <h4>Porfavor Intente Iniciar Sesión de Nuevo <a href="<?php echo e(url('/login')); ?>">Click Aquí</a>
                    </h4>
                    <h4>o Consulte con su Administrador del Sistema en Caso de Bloqueo</h4>


                </div>

            </div>
        </div>
    </body>
</html>
