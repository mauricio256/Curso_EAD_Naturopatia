<?php
include_once('../../php/conn.php');
require __DIR__ . '/vendor/autoload.php';

if(!isset($_GET['ID_Usuario'])){
     header('Location:../../matricula.html');
    exit;
};
   
// ID do usuário logado (exemplo)
$ID_usuario = $_GET['ID_Usuario'];

$sql = "SELECT ID_Usuario FROM `Boleto` WHERE ID_Usuario = $ID_usuario";
$result = $conn->query($sql);

if ($result->rowCount() > 0) {
    echo "Você já possui um pagamento pendente. Por favor, verifique seu e-mail ou entre em contato com o suporte.";
    exit;
}

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;

MercadoPagoConfig::setAccessToken("APP_USR-847752454485401-082414-8a9d0b30f992f249ecc2b6a924f11efc-1353462493");

$client = new PaymentClient();

// Cria o pagamento PIX
$payment = $client->create([
    "transaction_amount" => 0.10,
    "description" => "Matricula do Curso de Naturoterapia",
    "payment_method_id" => "pix",
    "payer" => [
        "email" => "aluno@email.com",
        "first_name" => "Aluno",
        "last_name" => "Teste"
    ]
]);

// Dados principais do pagamento
$paymentId   = $payment->id;
$qrCodeBase64 = $payment->point_of_interaction->transaction_data->qr_code_base64;
$qrCodeText   = $payment->point_of_interaction->transaction_data->qr_code;
$status       = $payment->status; // "pending" ou "approved"

try {
    $sql = "INSERT INTO `Boleto` 
        (`ID_Usuario`, `payment_id`, `qrCodeBase64`, `qrCodeText`, `status`, `data_criacao`) 
        VALUES (:usuario, :payment_id, :qrCodeBase64, :qrCodeText, :status, NOW())";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':usuario'      => $ID_usuario,
        ':payment_id'   => $paymentId,
        ':qrCodeBase64' => $qrCodeBase64,
        ':qrCodeText'   => $qrCodeText,
        ':status'       => $status
    ]);

    echo "✅ Dados do pagamento salvos com sucesso!";
} catch (Exception $e) {
    echo "❌ Erro ao salvar no banco: " . $e->getMessage();
}

// Exibir para o usuário pagar
echo "<h2>Pague o Curso via PIX</h2>";
echo "<img src='data:image/png;base64," . $qrCodeBase64 . "' alt='QR Code PIX'><br><br>";
echo "<textarea rows='6' cols='60'>" . $qrCodeText . "</textarea><br><br>";
echo "<p>Status inicial: <b>" . $status . "</b></p>";



//// falta verificar o status do pagamento periodicamente //// e atualizar o banco de dados quando for aprovado
/*
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
    */
?>
