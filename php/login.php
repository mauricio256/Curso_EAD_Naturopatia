<?php
session_start();
include_once('conn.php');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

// VERIFICA SE O BOTÃO SUBMIT FOI CLICADO
if(!isset($_POST["submit"])){
    header('Location:../login_aluno.html');
}

$email = $_POST['email'];
$password = $_POST['password']; /// falta criptografar a senha com md5 ou sha1

/*
echo $email;
echo $password; 
*/
    // BUSCA O USUÁRIO NO BANCO DE DADOS
    $sql = "SELECT * FROM Usuario WHERE Email = '$email' AND senha_Hash = '$password'";
    $busca = $conn->prepare($sql);
    $busca->execute();



    // VERIFICA SE O USUÁRIO EXISTE
    $count = $busca->rowCount();
    if($count > 0){     
        //// puxa os dados do usuario e coloca na sessao usuario
        $_SESSION['Usuario'] = $busca->fetch(PDO::FETCH_ASSOC);

         $Usuario = $_SESSION['Usuario'];

            //vefirica se possui boleto pedente
            $sql = "SELECT status FROM `Boleto` WHERE ID_Usuario = '".$Usuario['ID_Usuario']."' ORDER BY data_criacao DESC LIMIT 1";
            $busca = $conn->prepare($sql);
            $busca->execute();
            $busca = $busca->fetchAll(PDO::FETCH_ASSOC);

                if($busca[0]['status'] == 'pending'){
                    header('Location:mercado_pago/pix_mercadopago.php?ID_Usuario='.$Usuario['ID_Usuario'].'');
                    unset($_SESSION['Usuario']);
                }else if($busca[0]['status'] == 'approved'){
                    header('Location:../dashboard.php');
                }else if($busca[0]['status'] == 'cancelled'){
                    $conn->exec("DELETE FROM Boleto WHERE ID_Usuario = '".$Usuario['ID_Usuario']."'");
                    header('Location:mercado_pago/pix_mercadopago.php?ID_Usuario='.$Usuario['ID_Usuario'].'');
                    unset($_SESSION['Usuario']);
                }else{
                   echo "
                            <div style=\"
                            background-color: #ffcccc;
                            color: #990000;
                            font-weight: bold;
                            padding: 15px 20px;
                            border-radius: 10px;
                            text-align: center;
                           font-size: 2.2rem;
                            margin: 30px auto;
                            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            gap: 10px;
                            \">
                            <span style='font-size:2.5rem;'>⚠️</span>
                            <span>Erro!!! Entre em contato com o suporte.<br> Não foi possível identificar o status do seu boleto.</span><br>
                            
                            <p><a  href='../login_aluno.php' style=\"
                                display:block;
                                margin-left: 15px;
                                padding: 8px 16px;
                                background-color: #007bff;
                                color: white;
                                text-decoration: none;
                                border-radius: 5px;
                                transition: background-color 0.3s ease;
                            \">Voltar</a></p>
                            </div>
                            ";
                     unset($_SESSION['Usuario']);
                }
      
    }else{
        $_SESSION['MSG_loginErro'] = "<div style='text-align:center; margin-top:20px;'> <p style='background-color:#fd3838; color:white; padding:5px;'>E-mail ou senha incorreto(s)</p></div>";
        header('Location:../login_aluno.php');
    };

    