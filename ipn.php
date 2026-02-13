<?php

// PayTech envoie les données ici
$input = file_get_contents("php://input");
$data = json_decode($input, true);

// Vérification du statut
if ($data["status"] == "completed") {

    // Paiement validé
    file_put_contents("paiements.txt", 
        date("Y-m-d H:i:s") . " | Paiement OK | Ref: " . $data["ref_command"] . "\n",
        FILE_APPEND
    );

    http_response_code(200);
    echo "OK";
} else {

    // Paiement refusé
    file_put_contents("paiements.txt", 
        date("Y-m-d H:i:s") . " | Paiement NON VALIDE | Ref: " . $data["ref_command"] . "\n",
        FILE_APPEND
    );

    http_response_code(400);
    echo "FAILED";
}
?>
