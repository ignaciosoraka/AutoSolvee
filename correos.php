<?php
$mensaje_exito = "";
$mensaje_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recopila y sanitiza los datos del formulario
    $nombre = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $asunto= htmlspecialchars($_POST['subject']);
    $mensaje = htmlspecialchars($_POST['message']);
    $empresa = htmlspecialchars($_POST['empresa']); 

    // Valida el email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<h3 class='error'>Correo electrónico inválido</h3>";
        exit;
    }

    // Conexión a la base de datos
    $enlace = mysqli_connect("localhost", "usuario", "contraseña", "nombre_base_datos");

    if (!$enlace) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    // Almacena los datos en la base de datos
    $query = "INSERT INTO formulario (nombre, email, asunto, mensaje, empresa) VALUES ('$nombre', '$email', '$asunto', '$mensaje', '$empresa')";
    if (mysqli_query($enlace, $query)) {
        // Envía el correo electrónico
        $destinatario = 'ignaciosoraka@gmail.com';
        $mensajeCorreo = "Mensaje de contacto:\n\n";
        $mensajeCorreo .= "Nombre: " . $nombre . "\n";
        $mensajeCorreo .= "Correo Electrónico: " . $email . "\n";
        $mensajeCorreo .= "Asunto: " . $asunto . "\n";
        $mensajeCorreo .= "Mensaje: " . $mensaje . "\n";
        $mensajeCorreo .= "Empresa: " . $empresa . "\n";
        $cabecera = "From: " . $email . "\r\n";
        $cabecera .= "Reply-To: " . $email . "\r\n";
        $cabecera .= "MIME-Version: 1.0\r\n";
        $cabecera .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Enviar el correo electrónico y verificar si se envió correctamente
        if (mail($destinatario, $asunto, $mensajeCorreo, $cabecera)) {
            // Éxito en el envío del correo electrónico
            $mensaje_exito = "Tu mensaje ha sido enviado con éxito. ¡Gracias!";
            // Redireccionar a gracias.html
            header("Location: gracias.html");
            exit; // Asegura que el script se detenga después de la redirección
        } else {
            // Error en el envío del correo electrónico
            $mensaje_error = "Ocurrió un error al enviar el mensaje. Por favor, inténtalo de nuevo más tarde.";
        }
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($enlace);
    }

    // Cierra la conexión a la base de datos
    mysqli_close($enlace);
}
?>

<!-- Mensajes de éxito o error -->
<?php if ($mensaje_exito): ?>
    <div class="alert alert-success"><?php echo $mensaje_exito; ?></div>
<?php endif; ?>

<?php if ($mensaje_error): ?>
    <div class="alert alert-danger"><?php echo $mensaje_error; ?></div>
<?php endif; ?>

