<?php
session_start();
include_once('../../php/conn.php');

// Exibe erros para debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 🔹 Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
  http_response_code(403);
  echo "Usuário não autenticado";
  exit;
}

$id_usuario = intval($_SESSION['id_usuario']);
$id_aula = isset($_POST['aula']) ? intval($_POST['aula']) : 0;
$assistida = isset($_POST['assistida']) ? intval($_POST['assistida']) : 0;

if ($id_aula <= 0) {
  http_response_code(400);
  echo "Dados inválidos";
  exit;
}

try {
  // 🔹 Verifica se já existe o registro para essa aula e usuário
  $sql = "SELECT id FROM progresso_aulas WHERE id_usuario = ? AND id_aula = ?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$id_usuario, $id_aula]);

  if ($stmt->rowCount() > 0) {
    // Atualiza o status da aula
    $update = "UPDATE progresso_aulas 
               SET assistida = ?, atualizado_em = NOW() 
               WHERE id_usuario = ? AND id_aula = ?";
    $stmtUp = $conn->prepare($update);
    $stmtUp->execute([$assistida, $id_usuario, $id_aula]);
  } else {
    // Insere novo progresso
    $insert = "INSERT INTO progresso_aulas (id_usuario, id_aula, assistida, atualizado_em)
               VALUES (?, ?, ?, NOW())";
    $stmtIn = $conn->prepare($insert);
    $stmtIn->execute([$id_usuario, $id_aula, $assistida]);
  }

  echo "OK";
} catch (PDOException $e) {
  http_response_code(500);
  echo "Erro ao salvar: " . $e->getMessage();
}
?>
