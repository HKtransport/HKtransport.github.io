<?php

// ⚠️ METS TES VRAIES CLÉS ICI
$api_key = "d9f2c4c89d05033ac5d3b1cbaa9eba42fcefc7d9dce1338ebdf45589c96b5b4c";
$secret_key = "6058a1e780aa99e4cd411b435c0bbd3f1299557ed9dc120d15b1cc8be41c3d9c";

// Récupération des données envoyées depuis paiement.html
$prix = $_POST["prix"];
$description = "Paiement Baba Colis";
$reference = "BC-" . time();

// URLS PayTech
$success_url = "https://hktransport.github.io/confirmation.html";
$cancel_url  = "https://hktransport.github.io/paiement.html";
$ipn_url     = "https://babacolis.wuaze.com/ipn.php";

// Création de la requête PayTech
$data = [
    "item_name" => $description,
    "item_price" => $prix,
    "currency" => "XOF",
    "ref_command" => $reference,
    "command_name" => "Paiement Baba Colis",
    "env" => "test", // mets "prod" quand tu es prêt
    "success_url" => $success_url,
    "cancel_url" => $cancel_url,
    "ipn_url" => $ipn_url,
    "channels" => ["WAVE", "OM"] // Wave + Orange Money
];

$payload = json_encode($data);

$ch = curl_init("https://paytech.sn/api/payment/request-payment");
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "API_KEY: $api_key",
    "API_SECRET: $secret_key",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

// Redirection vers la page de paiement PayTech
if (isset($result["redirect_url"])) {
    header("Location: " . $result["redirect_url"]);
    exit;
} else {
    echo "Erreur PayTech : ";
    print_r($result);
}
?>
