<?php
session_start();
include_once('conn.php');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

// VERIFICA SE O BOTÃO SUBMIT FOI CLICADO
if(!isset($_POST["submit"])){
    header('Location:../login_aluno.html');
}

$email = $_POST['email'];
$password = $_POST['password'];

/*
echo $email;
echo $password; 
*/

    $sql = "SELECT * FROM Usuario WHERE Email = '$email' AND senha_Hash = '$password'";
   
    $busca = $conn->prepare($sql);
    $busca->execute();

    $count = $busca->rowCount();

    if($count > 0){     
        //// puxa os dados do usuario e coloca na sessao 
        $_SESSION['Usuario'] = $busca->fetch(PDO::FETCH_ASSOC);

            //vefirica se o pagamento foi feito
            if($_SESSION['Usuario']['pagamento'] == TRUE){
                header('Location:../dashboard.php');
            }else{
                header('Location:../pagina_pagamento_pendente.html');
            }
        
       /// header('Location:dashboard.php');
    }else{
        $_SESSION['MSG_loginErro'] = "<div style='text-align:center; margin-top:20px;'> <p style='background-color:#fd3838; color:white; padding:5px;'>E-mail ou senha incorreto(s)</p></div>";
        header('Location:../login_aluno.php');
    };

    