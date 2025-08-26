<?php
include_once('../../php/conn.php');
require __DIR__ . '/vendor/autoload.php';

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;

MercadoPagoConfig::setAccessToken("APP_USR-847752454485401-082414-8a9d0b30f992f249ecc2b6a924f11efc-1353462493");

$client = new PaymentClient();

$id = $_GET['id'] ?? null;

if(!$id){
    echo json_encode(["status" => "error", "message" => "ID não informado"]);
    exit;
}

$payment = $client->get($id);
$status  = $payment->status;

// Atualiza o banco com o novo status
$sql = "UPDATE Boleto SET status = :status WHERE payment_id = :id";
$stmt = $conn->prepare($sql);
$stmt->execute([
    ':status' => $status,
    ':id'     => $id
]);

echo json_encode(["status" => $status]);
