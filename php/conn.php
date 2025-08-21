<?php 

$user = "root";
$pass = "";

try {
    $conn = new PDO('mysql:host=localhost;dbname=curso_ead_naturopatia', $user, $pass);
} catch (PDOException $e) {
    echo"<h2>ERRO DE CONEXÃO COM BANCO DE DADOS</h2>";
    echo 'Exceção capturada: ',  $e->getMessage(), "\n";
}