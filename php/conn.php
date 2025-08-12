<?php 

$user = "root";
$pass = "";

try {
    $conn = new PDO('mysql:host=localhost;dbname=scciptv', $user, $pass);
} catch (PDOException $e) {
    echo"<h2>ERRO DE CONEXÃO COM BANCO DE DADOS</h2>";
    echo"<img src='../img/icon/erroBanco.png' width='100px' ><br><br>";
    echo 'Exceção capturada: ',  $e->getMessage(), "\n";
}