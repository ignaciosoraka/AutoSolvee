<?php
$mensaje_exito = "";
$mensaje_error = "";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: index.html");
    exit;
}

require 'phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer;
// Configuración SMTP
$mail->isSMTP();
$mail->Host = 'c2100193.ferozo.com';
$mail->SMTPAuth = true;
$mail->Username = 'smtp@autosolve.com.ar';
$mail->Password = '5M7P4u7o5@LV3';
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;

// Parámetros de envío
$mail->setFrom('info@autosolve.com.ar', 'AutoSolve');
$mail->addAddress('info@autosolve.com.ar', 'AutoSolve');
$mail->isHTML(true);

// Limpiar los datos del formulario
$nombre = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : 'No especificado';
$email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : 'No especificado';
$asunto = isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : 'No especificado';
$empresa = isset($_POST['empresa']) ? htmlspecialchars($_POST['empresa']) : 'No especificado';
$mensaje = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : 'No especificado';

// Validacion de Captcha

$ip = $_SERVER['REMOTE_ADDR'];
$captcha = $_POST['g-recaptcha-response'];
$secretkey = "6LfejPIpAAAAAJ_73G-B7EkUGnO7afICFfbrm2aY";

$respuesta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$captcha&remoteip=$ip");

$atributos = json_decode($respuesta, TRUE);

if(!$atributos['success']){
    $errors[] = 'Verificar captcha'

}


// Personalizar el asunto del correo electrónico
$asuntoCorreo = "Consulta de " . $nombre;

// Construir el mensaje de correo electrónico
$mensajeCorreo = "<p>Mensaje de contacto:</p>";
$mensajeCorreo .= "<p><strong>Nombre:</strong> " . $nombre . "</p>";
$mensajeCorreo .= "<p><strong>Correo Electrónico:</strong> " . $email . "</p>";
$mensajeCorreo .= "<p><strong>Asunto:</strong> " . $asunto . "</p>";
$mensajeCorreo .= "<p><strong>Empresa:</strong> " . $empresa . "</p>";
$mensajeCorreo .= "<p><strong>Mensaje:</strong><br>" . nl2br($mensaje) . "</p>";

// Configurar el correo electrónico
$mail->Subject = $asuntoCorreo;
$mail->Body = $mensajeCorreo;
$mail->AltBody = strip_tags($mensajeCorreo);

// Enviar el correo electrónico y verificar si se envió correctamente
if ($mail->send()) {
    // Éxito en el envío del correo electrónico
    $mensaje_exito = "Tu mensaje ha sido enviado con éxito. ¡Gracias!";
    // Redireccionar a gracias.html
    header("Location: gracias.html");
    exit; // Asegura que el script se detenga después de la redirección
} else {
    // Error en el envío del correo electrónico
    $mensaje_error = "Ocurrió un error al enviar el mensaje. Por favor, inténtalo de nuevo más tarde.";
    echo "Mailer Error: " . $mail->ErrorInfo;
}
?>
