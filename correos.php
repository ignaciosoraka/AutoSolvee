<?php
$servidor = "localhost";
$usuario = "root";
$clave = "";
$baseDeDatos = "ejemplo";
$enlace = mysqli_connect($servidor, $usuario, $clave, $baseDeDatos);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recopila los datos del formulario
    $nombre = $_POST['nombre'];
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $asunto = $_POST['asunto'];
    $mensaje = $_POST['mensaje'];

    // Almacena los datos en la base de datos
    $query = "INSERT INTO formulario (nombre, email, asunto, mensaje) VALUES ('$nombre', '$email', '$asunto', '$mensaje')";
    mysqli_query($enlace, $query);

    // Envía el correo electrónico
    $destinatario = 'ignaciosoraka@gmail.com';
    $mensajeCorreo = "Mensaje de contacto:\n\n";
    $mensajeCorreo .= "Nombre: " . $nombre . "\n";
    $mensajeCorreo .= "Correo Electrónico: " . $email . "\n";
    $mensajeCorreo .= "Asunto: " . $asunto . "\n";
    $mensajeCorreo .= "Mensaje: " . $mensaje;
    $cabecera = "From: " . $email . "\r\n";
    $cabecera .= "Reply-To: " . $email . "\r\n";
    $cabecera .= "MIME-Version: 1.0\r\n";
    $cabecera .= "Content-Type: text/plain; charset=UTF-8\r\n";
    if (mail($destinatario, $asunto, $mensajeCorreo, $cabecera)) {
        header('Location: gracias.html'); // Redirige a la página de agradecimiento
        exit;
    } else {
        echo "<h3 class='error'>Ocurrió un error, por favor, inténtalo de nuevo</h3>";
    }
}
?>
