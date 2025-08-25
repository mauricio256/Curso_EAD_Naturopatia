<?php
require __DIR__ . '/vendor/autoload.php';

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;

MercadoPagoConfig::setAccessToken("APP_USR-847752454485401-082414-8a9d0b30f992f249ecc2b6a924f11efc-1353462493");

$client = new PaymentClient();
$id = $_GET['id'] ?? null;

if ($id) {
    $payment = $client->get($id);
    echo json_encode([
        "status" => $payment->status
    ]);
}

if($payment->status == "approved"){
    echo "Pagamento aprovado com sucesso!";
}
?>
