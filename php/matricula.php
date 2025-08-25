<?php
include_once('conn.php');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

if(isset($_POST['submit']) == NULL){
    header('Location:../matricula.html');
}
$curso = $_POST['curso'];
$nome = $_POST['nome'];
$endereco = $_POST['endereco'];
$cidade = $_POST['cidade'];
$CEP = $_POST['CEP'];
$UF = $_POST['UF'];
$estadoCivil = $_POST['estadoCivil'];
$atividade = $_POST['atividade'];
$CPF = $_POST['CPF'];
$CRT = $_POST['CRT'];
$nascimento = $_POST['nascimento'];
$whatsapp = $_POST['whatsapp'];
$email = $_POST['email'];
$password = $_POST['password'];
$escolaridade = $_POST['escolaridade'];

/*
echo $curso."<br>";
echo $nome."<br>";
echo $endereco."<br>"; 
echo $cidade."<br>"; 
echo $CEP."<br>"; 
echo $UF."<br>"; 
echo $estadoCivil."<br>"; 
echo $atividade."<br>"; 
echo $complemento."<br>";  
echo $CPF."<br>"; 
echo $CRT."<br>"; 
echo $nascimento."<br>"; 
echo $whastapp."<br>"; 
echo $email."<br>"; 
echo $password."<br>"; 
echo $escolaridade."<br>";
*/

// Verifica se o CPF já está cadastrado
$sql = "SELECT * FROM Aluno WHERE CPF = '$CPF'";
$checaCPF = $conn->query($sql);

if($checaCPF->rowCount() > 0){
    echo "<script>
            alert('CPF JÁ CADASTRADO, tente novamente com outro CPF.');
            javascript:window.location='../matricula.html';
          </script>";
    exit();
}

// Verifica se o email já está cadastrado
$sql = "SELECT * FROM Usuario WHERE Email = '$email'";
$checaEmail = $conn->query($sql);

if($checaEmail->rowCount() > 0){
    echo "<script>
            alert('EMAIL JÁ CADASTRADO, tente novamente com outro email.');
            javascript:window.location='../matricula.html';
          </script>";
    exit();
}

// Criptografa a senha
///$senhaHash = password_hash($password, PASSWORD_DEFAULT);



try {

    // Insere o usuário na tabela Usuario
    $sql = "INSERT INTO `Usuario` (`ID_Usuario`, `Email`, `Senha_Hash`, `Tipo`, `Data_Cadastro`) VALUES 
           (NULL, '$email', '$password', 'Aluno', NOW())";

    if($conn->exec($sql)):

        // Obtém o ID do usuário recém-criado
        $idUsuario = $conn->lastInsertId();

        // Insere o aluno na tabela Aluno com o ID do usuário
        $sql = "INSERT INTO `Aluno` (`ID_Aluno`, `Nome`, `Data_Nascimento`, `Curso`, `Endereco`, `Cidade`, `CEP`, `UF`, `Estado_Civil`, `Atividade`, `CPF`, `CRT`, `WhatsApp`, `ID_Usuario`) VALUES 
                (NULL, '$nome', '$nascimento', '$curso', '$endereco', '$cidade', '$CEP', '$UF', '$estadoCivil', '$atividade', '$CPF', '$CRT', '$whatsapp', '$idUsuario')";
        if($conn->exec($sql)):
            
            // Obtém o ID do aluno recém-criado
            $idAluno = $conn->lastInsertId();

            // Insere a matrícula na tabela Matricula com o curso escolhido
            $sql = "INSERT INTO `Matricula` (`ID_Matricula`, `ID_Aluno`, `ID_Curso`, `Data_Matricula`,`Progresso`) VALUES 
                    (NULL, '$idAluno', '$curso', NOW(), '0')";
            $conn->exec($sql);

            // Redireciona para a página de pagamento
            echo "<script>
                    javascript:window.location='mercado_pago/pix_mercadopago.php?ID_Usuario=$idUsuario';
                  </script>";
            exit();
        else:
            // Se falhar ao inserir na tabela Aluno, remove o usuário criado na tabela Usuario
            $conn->exec("DELETE FROM Usuario WHERE ID_Usuario = '$idUsuario'");
            echo "<script> 
                    alert('ERRO AO CADASTRAR USUÁRIO, tente novamente.');
                    javascript:window.location='../matricula.html';
                  </script>";
            exit();
        endif;

    else:
        echo "<script>
                alert('ERRO AO CADASTRAR USUÁRIO, tente novamente.');
                javascript:window.location='../matricula.html';
              </script>";
        exit();
    endif;
} catch (Exception $e) {  
    echo "<div style='padding:10%; background-color:red; color:yellow;'>
            <h2>Erro! </h2><p>Não foi possível realizar o cadastro do usuário. 
            <br><br><b>Diagnóstico:</b> ".$e->getMessage()."</p><br>
            <a href='../index.html' style='text-decoration:none; border-radius: 5px; color:white; background-color:gray; padding: 10px; '>Sair</a>
          </div>";
    exit();
}


?>