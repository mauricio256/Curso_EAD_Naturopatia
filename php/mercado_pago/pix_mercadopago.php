<?php
include_once('../../php/conn.php');
require __DIR__ . '/vendor/autoload.php';

if(!isset($_GET['ID_Usuario'])){
     header('Location:../../matricula.html');
     exit;
};

if($_GET == ''){
    header('Location:../../matricula.html');
    exit;
}

$ID_usuario = $_GET['ID_Usuario'];

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;
////// AQUI VAI O ACCESS TOKEN DO Dr. Wilsson da conta do Mercado Pago
MercadoPagoConfig::setAccessToken("APP_USR-847752454485401-082414-8a9d0b30f992f249ecc2b6a924f11efc-1353462493"); //// ACCESS TOKEN da minha conta teste temporaria

$client = new PaymentClient();

// 🔎 Verifica se já existe boleto pendente
$sql = "SELECT * FROM Boleto WHERE ID_Usuario = :usuario AND status = 'pending' ORDER BY data_criacao DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute([':usuario' => $ID_usuario]);
$boletoExistente = $stmt->fetch(PDO::FETCH_ASSOC);

if ($boletoExistente) {
    // Já existe um boleto pendente → reaproveita ele
    $paymentId   = $boletoExistente['payment_id'];
    $qrCodeBase64 = $boletoExistente['qrCodeBase64'];
    $qrCodeText   = $boletoExistente['qrCodeText'];
    $status       = $boletoExistente['status'];
} else {
    // Cria o pagamento PIX
    $payment = $client->create([
        "transaction_amount" => 0.10, ///// valor para teste de R$0,10
        "description" => "Matrícula do Curso de Naturoterapia",
        "payment_method_id" => "pix",
        "payer" => [
            "email" => "alunodenaturopatia@email.com",
            "first_name" => "Aluno do curso",
            "last_name" => "de Naturoterapia"
        ]
    ]);

    $paymentId   = $payment->id;
    $qrCodeBase64 = $payment->point_of_interaction->transaction_data->qr_code_base64;
    $qrCodeText   = $payment->point_of_interaction->transaction_data->qr_code;
    $status       = $payment->status;

    // Salva no banco
    $sql = "INSERT INTO Boleto 
        (ID_Usuario, payment_id, qrCodeBase64, qrCodeText, status, data_criacao) 
        VALUES (:usuario, :payment_id, :qrCodeBase64, :qrCodeText, :status, NOW())";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':usuario'      => $ID_usuario,
        ':payment_id'   => $paymentId,
        ':qrCodeBase64' => $qrCodeBase64,
        ':qrCodeText'   => $qrCodeText,
        ':status'       => $status
    ]);
}

// Exibir QR Code para o usuário pagar
// Exibir QR Code com design amigável, responsivo e botão de copiar
echo "
<!DOCTYPE html>
<html lang='pt-BR'>
<head>
  <meta charset='UTF-8'>
  <title>Pagamento PIX</title>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(to right, #e0f7fa, #ffffff);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
      padding: 20px;
    }
    .container {
      background: #fff;
      padding: 25px;
      border-radius: 16px;
      box-shadow: 0 6px 16px rgba(0,0,0,0.15);
      text-align: center;
      max-width: 450px;
      width: 100%;
    }
    h2 {
      color: #00796b;
      margin-bottom: 12px;
      font-size: 1.5rem;
    }
    p {
      font-size: 1rem;
      color: #444;
      margin-bottom: 18px;
      line-height: 1.4;
    }
    img {
      max-width: 100%;
      width: 250px;
      height: auto;
      margin-bottom: 20px;
    }
    textarea {
      width: 100%;
      border-radius: 8px;
      border: 1px solid #ccc;
      padding: 10px;
      font-size: 0.9rem;
      resize: none;
      margin-bottom: 12px;
      box-sizing: border-box;
    }
    button {
      background: #00796b;
      color: #fff;
      border: none;
      padding: 10px 16px;
      border-radius: 8px;
      cursor: pointer;
      font-size: 0.95rem;
      transition: background 0.3s;
      margin-bottom: 15px;
    }
    button:hover {
      background: #005f4f;
    }
    .status {
      margin-top: 10px;
      font-weight: bold;
      color: #00796b;
      font-size: 1rem;
    }

    /* Ajustes para telas menores */
    @media (max-width: 480px) {
      h2 { font-size: 1.3rem; }
      p { font-size: 0.95rem; }
      img { width: 200px; }
      textarea { font-size: 0.85rem; }
      button { font-size: 0.85rem; padding: 8px 12px; }
    }
  </style>
</head>
<body>
  <div class='container'>
    <h1>Finalize sua Matrícula</h1>
    <h3>Para confirmar sua matrícula e começar sua jornada de sucesso, realize o pagamento via PIX:</h3>
      <div style=\"
        color: #fff;
        font-size: 1.5rem;
        font-weight: bold;
        padding: 12px 20px;
        border-radius: 12px;
        display: inline-block;
        margin-bottom: 20px;
        background: linear-gradient(45deg, #00796b, #004d40);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        text-align: center;
        min-width: 180px;
      \">
        R$ 0,10
      </div>
    <img src='data:image/png;base64,$qrCodeBase64' alt='QR Code PIX'>
    <textarea id='pixCode' rows='4' readonly>$qrCodeText</textarea>
    <button id='btnCopiar' onclick=\"copiarPix()\">📋 Copiar Código PIX</button>
    <p></p>Use o QR Code acima ou copie o código PIX para realizar o pagamento através do seu aplicativo bancário.</p>

 
    <!-- Spinner de carregamento médio -->
    <div id='spinner' style='margin: 20px auto; width:40px; height:40px;'>
    <svg viewBox='0 0 50 50'>
        <circle cx='25' cy='25' r='16' fill='none' stroke='#00796b' stroke-width='4' stroke-linecap='round' stroke-dasharray='25.1 25.1' transform='rotate(-90 25 25)'>
        <animateTransform attributeName='transform' type='rotate' from='0 25 25' to='360 25 25' dur='1s' repeatCount='indefinite'/>
        </circle>
    </svg>
    </div>

    <h3>Aguardando pagamento...</h3><br>
    <!-- Link para voltar ao login -->
    <p>Se preferir, você pode deixar para pagar depois e acessar sua conta:</p>
    <a style='color:#fff; background: linear-gradient(45deg, #00796b, #004d40); padding: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.2);' href='../../login_aluno.php'>Deixar pra pagar depois</a>
    <br><br>
    <hr>
    <h2>Status de pagamento: <span id='status'>$status</span></h2>
  </div>

  <script>
    function copiarPix() {
      const textarea = document.getElementById('pixCode');
      const btn = document.getElementById('btnCopiar');

      navigator.clipboard.writeText(textarea.value).then(() => {
        btn.textContent = '✅ Copiado';
        btn.disabled = true;
        setTimeout(() => {
          btn.textContent = '📋 Copiar Código PIX';
          btn.disabled = false;
        }, 2500);
      });
    }
  </script>
</body>
</html>
";


// Script JS para verificar status
?>
<script>
function verificarPagamento() {
  fetch("verifica_pagamento.php?id=<?php echo $paymentId; ?>")
    .then(response => response.json())
    .then(data => {
      document.getElementById("status").innerText = data.status;
      if (data.status === "approved") {
        alert("✅ Pagamento aprovado com sucesso! Clique em OK para continuar.");
        window.location.href = "../login.php"; // redireciona para página de login
      } else {
        setTimeout(verificarPagamento, 4000); // verifica a cada 4s
      }
    })
    .catch(err => console.error(err));
}
verificarPagamento();
</script>
