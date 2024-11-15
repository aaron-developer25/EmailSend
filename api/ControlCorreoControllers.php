<?php

header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With, Authorization");
header("Access-Control-Allow-Credentials: true");

require '../librerias/PHPMailer/src/PHPMailer.php';
require '../librerias/PHPMailer/src/SMTP.php';
require '../librerias/PHPMailer/src/Exception.php';

$smtpHost = $_GET['smtpHost'];
$smtpUsername = $_GET['smtpUsername'];
$smtpPassword = $_GET['smtpPassword'];
$smtpPort = $_GET['smtpPort'];

$asunto = $_GET['asunto'];
$mensaje = $_GET['mensaje'];
$piePagina = $_GET['piePagina'];
$destinatario = $_GET['destinatario'];
$nombreEmpresa = $_GET['nombreEmpresa'];
$direccionEmpresa = $_GET['direccionEmpresa'];

$mail = new PHPMailer\PHPMailer\PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = $smtpHost;
    $mail->SMTPAuth = true;
    $mail->Username = $smtpUsername;
    $mail->Password = $smtpPassword;
    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = $smtpPort;

    $mail->setFrom($smtpUsername, $nombreEmpresa);
    $mail->addAddress($destinatario);
    $mail->Subject = $asunto;
    $mail->isHTML(true);


    $mail->Body = '
    <html>
    <head>
    <style>
      table, tr, td {
        vertical-align: top;
        border-collapse: collapse;
      }
      .contenedor {
        min-width: 320px;
        max-width: 600px;
        margin: 0 auto;
        background-color: #ffffff;
        border: solid 4px #8d95ff;
      }
      .contenedor-interno {
        padding: 30px 10px 20px;
        text-align: center;
      }
      .encabezado {
        padding: 10px 40px;
        text-align: center;
      }
      .pie-de-pagina {
        padding: 10px 40px;
        text-align: center;
        background-color: #8d95ff;
        color: #ffffff;
      }
      .separador {
        border-top: 2px solid #8d95ff;
      }
      .iconos-sociales {
        display: table;
        margin: 0 auto;
      }
      .iconos-sociales td {
        padding-right: 10px;
      }
      .iconos-sociales img {
        width: 36px;
        height: 36px;
      }
      .imagen {
        max-width: 100px;
        max-height: 90px;
      }
      .imagen-completa {
        width: 100%;
        max-width: 600px;
        background: url("cid:fondo") no-repeat center center;
        background-size: cover;
      }
      .contenido {
        padding: 20px 40px;
      }
      .titulo {
        font-family: \'Raleway\', sans-serif;
        font-size: 23px;
        font-weight: 700;
        line-height: 140%;
      }
      .mensaje {
        font-family: \'Raleway\', sans-serif;
        font-size: 15px;
        line-height: 140%;
      }
      .texto {
        font-family: \'Raleway\', sans-serif;
        font-size: 16px;
        color: #ffffff;
        text-align: center;
      }
    </style>
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700&display=swap" rel="stylesheet" type="text/css">
    </head>
    <body>
      <table class="contenedor" cellpadding="0" cellspacing="0">
        <tr>
          <td>
            <div class="contenedor-interno">
              <img src="cid:logo" alt="imagen" class="imagen"/>
              <div class="titulo">'.$nombreEmpresa.'</div>
              <div class="texto">'.$direccionEmpresa.'</div>
            </div>
            <div class="separador"></div>
            <div class="encabezado">
              <div class="titulo">'.$asunto.'</div>
            </div>
            <div class="contenido">
              <div class="mensaje">'.$mensaje.'</div>
            </div>
            <div class="separador"></div>
            <div class="contenedor-interno">
              <img src="cid:fondo" alt="imagen" class="imagen-completa"/>
            </div>
            <div class="pie-de-pagina">
              <div class="iconos-sociales">
                <table cellpadding="0" cellspacing="0">
                  <tr>
                    <td><a href="https://www.facebook.com/" target="_blank"><img class="icoFacebook" src="cid:icoFacebook" alt="Facebook" title="Facebook"></a></td>
                    <td><a href="https://www.instagram.com/" target="_blank"><img class="icoInstagram" src="cid:icoInstagram" alt="Instagram" title="Instagram"></a></td>
                    <td><a href="https://whatsapp.com/" target="_blank"><img class="icoWhatsapp" src="cid:icoWhatsapp" alt="WhatsApp" title="WhatsApp"></a></td>
                    <td><a href="https://twitter.com/" target="_blank"><img class="icoTwitter" src="cid:icoTwitter" alt="Twitter" title="Twitter"></a></td>
                  </tr>
                </table>
              </div>
              <label class="texto">'. $piePagina .'</label>
            </div>
          </td>
        </tr>
      </table>
    </body>
    </html>';

    $mail->addEmbeddedImage('../archivos/imagenes/imagenes/logotipo.png', 'logo');
    $mail->addEmbeddedImage('../archivos/imagenes/iconos/ico_facebook.png', 'icoFacebook');
    $mail->addEmbeddedImage('../archivos/imagenes/iconos/ico_instagram.png', 'icoInstagram');
    $mail->addEmbeddedImage('../archivos/imagenes/iconos/ico_whatsapp.png', 'icoWhatsapp');
    $mail->addEmbeddedImage('../archivos/imagenes/iconos/ico_twitter.png', 'icoTwitter');
    $mail->addEmbeddedImage('../archivos/imagenes/imagenes/fondoCorreo.png', 'fondo');

    $mail->send();

    echo json_encode(['Validacion' => 'Exitoso']);
} 
catch (PHPMailer\PHPMailer\Exception $e) {
  echo json_encode([
    'Validacion' => 'Error',
    'ErrorInfo' => $mail->ErrorInfo
]);
}
?>
