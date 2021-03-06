<?php

function draw_reset_password_email_helper($link)
{
    return <<<GFG
    <html lang="es-ES">
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
        <title>Restablecer Contrase&ntilde;a</title>
        <meta name="description" content="Restablecer Contrase&ntilde;a.">
        <link rel="shortcut icon" href="https://www.accesorioseconomicos.com/wp-content/uploads/2021/02/logo-accesorioseconomicos-stroke-100x100-1.png" />
        <style type="text/css">
            a:hover {
                text-decoration: underline !important;
            }
        </style>
    </head>
    <body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0">
        <!--100% body table-->
        <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8"
            style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: 'Open Sans', sans-serif;">
            <tr>
                <td>
                    <table style="background-color: #f2f3f8; max-width:670px;  margin:0 auto;" width="100%" border="0"
                        align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="height:80px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">
                                <a href="https://www.accesorioseconomicos.com" title="logo" target="_blank">
                                    <img width="100"
                                        src="https://www.accesorioseconomicos.com/wp-content/uploads/2022/05/logo-accesorioseconomicos-stroke-150x150-1.png"
                                        title="logo" alt="logo">
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td style="height:20px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>
                                <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
                                    style="max-width:670px;background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
                                    <tr>
                                        <td style="height:40px;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:0 35px;">
                                            <h3 style="color:#494949; font-weight:200; margin:0;font-size:20px;font-family:'Rubik',sans-serif;">Sistema de Pedidos - Brokers</h3>
                                            <h1
                                                style="color:#1e1e2d; font-weight:500; margin:0;font-size:32px;font-family:'Rubik',sans-serif;">
                                                Has solicitado restablecer tu contrase&ntilde;a en nuestro Sistema de Pedidos</h1>
                                            <span
                                                style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; width:100px;"></span>
                                            <p style="color:#455056; font-size:15px;line-height:24px; margin:0;">
                                                Para restablecer su contrase&ntilde;a, haga clic en el siguiente enlace y
                                                siga las instrucciones.
                                            </p>
                                            <a href="$link"
                                                style="background:#F02325;text-decoration:none !important; font-weight:500; margin-top:35px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;">Restablecer
                                                Contrase&ntilde;a</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="height:40px;">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        <tr>
                            <td style="height:20px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">
                                <p
                                    style="font-size:14px; color:rgba(69, 80, 86, 0.7411764705882353); line-height:18px; margin:0 0 0;">
                                    &copy; <strong>www.accesorioseconomicos.com</strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td style="height:80px;">&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <!--/100% body table-->
    </body>
    </html>
    GFG;
}

function draw_activation_user_email_helper($link)
{
    return <<<GFG
    <html lang="es-ES">
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
        <title>Restablecer Contrase&ntilde;a</title>
        <meta name="description" content="Restablecer Contrase&ntilde;a.">
        <link rel="shortcut icon" href="https://www.accesorioseconomicos.com/wp-content/uploads/2021/02/logo-accesorioseconomicos-stroke-100x100-1.png" />
        <style type="text/css">
            a:hover {
                text-decoration: underline !important;
            }
        </style>
    </head>
    <body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0">
        <!--100% body table-->
        <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8"
            style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: 'Open Sans', sans-serif;">
            <tr>
                <td>
                    <table style="background-color: #f2f3f8; max-width:670px;  margin:0 auto;" width="100%" border="0"
                        align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="height:80px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">
                                <a href="https://www.accesorioseconomicos.com" title="logo" target="_blank">
                                    <img width="100"
                                        src="https://www.accesorioseconomicos.com/wp-content/uploads/2022/05/logo-accesorioseconomicos-stroke-150x150-1.png"
                                        title="logo" alt="logo">
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td style="height:20px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>
                                <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
                                    style="max-width:670px;background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
                                    <tr>
                                        <td style="height:40px;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:0 35px;">
                                            <h3 style="color:#494949; font-weight:200; margin:0;font-size:20px;font-family:'Rubik',sans-serif;">Sistema de Pedidos - Brokers</h3>
                                            <h1
                                                style="color:#1e1e2d; font-weight:500; margin:0;font-size:32px;font-family:'Rubik',sans-serif;">
                                                Activaci&oacute;n de usuario.</h1>
                                            <span
                                                style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; width:100px;"></span>
                                            <p style="color:#455056; font-size:15px;line-height:24px; margin:0;">
                                                Para activar su usuario y poderlo utilizar dentro de nuestra plataforma de click en el bot&oacute;n de abajo.
                                            </p>
                                            <a href="$link"
                                                style="background:#004fed;text-decoration:none !important; font-weight:500; margin-top:35px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;">Activar mi usuario</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="height:40px;">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        <tr>
                            <td style="height:20px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">
                                <p
                                    style="font-size:14px; color:rgba(69, 80, 86, 0.7411764705882353); line-height:18px; margin:0 0 0;">
                                    &copy; <strong>www.accesorioseconomicos.com</strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td style="height:80px;">&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <!--/100% body table-->
    </body>
    </html>
    GFG;
}

function draw_temporal_password_email_helper($email, $password)
{
    return <<<GFG
    <html lang="es-ES">
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
        <title>Restablecer Contrase&ntilde;a</title>
        <meta name="description" content="Restablecer Contrase&ntilde;a.">
        <link rel="shortcut icon" href="https://www.accesorioseconomicos.com/wp-content/uploads/2021/02/logo-accesorioseconomicos-stroke-100x100-1.png" />
        <style type="text/css">
            a:hover {
                text-decoration: underline !important;
            }
        </style>
    </head>
    <body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0">
        <!--100% body table-->
        <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8"
            style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: 'Open Sans', sans-serif;">
            <tr>
                <td>
                    <table style="background-color: #f2f3f8; max-width:670px;  margin:0 auto;" width="100%" border="0"
                        align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="height:80px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">
                                <a href="https://www.accesorioseconomicos.com" title="logo" target="_blank">
                                    <img width="100"
                                        src="https://www.accesorioseconomicos.com/wp-content/uploads/2022/05/logo-accesorioseconomicos-stroke-150x150-1.png"
                                        title="logo" alt="logo">
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td style="height:20px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>
                                <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
                                    style="max-width:670px;background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
                                    <tr>
                                        <td style="height:40px;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:0 35px;">
                                            <h3 style="color:#494949; font-weight:200; margin:0;font-size:20px;font-family:'Rubik',sans-serif;">Sistema de Pedidos - Brokers</h3>
                                            <h1
                                                style="color:#1e1e2d; font-weight:500; margin:0;font-size:32px;font-family:'Rubik',sans-serif;">
                                                Contrase&ntilde;a Temporal</h1>
                                            <span
                                                style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; width:100px;"></span>
                                            <p style="color:#455056; font-size:15px;line-height:24px; margin:0;">
                                                Estimado usuario propietario del email $email su contrase&ntilde;a temporal para acceder al sistema es : <strong>$password</strong>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="height:40px;">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        <tr>
                            <td style="height:20px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">
                                <p
                                    style="font-size:14px; color:rgba(69, 80, 86, 0.7411764705882353); line-height:18px; margin:0 0 0;">
                                    &copy; <strong>www.accesorioseconomicos.com</strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td style="height:80px;">&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <!--/100% body table-->
    </body>
    </html>
    GFG;
}
