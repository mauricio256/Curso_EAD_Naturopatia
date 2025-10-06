<?php
  session_start();

  // VERIFICA SE O USUÁRIO JÁ ESTÁ LOGADO
  if($_SESSION['Usuario']){
      header('Location:dashboard.php');
  }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/login_aluno.css" />
  <title>Login Responsivo</title>
  <style>
   
  </style>
</head>
<body>
  <div class="container">
    <!-- Lado esquerdo com imagem -->
    <div class="left-side"></div>

    <!-- Lado direito com o formulário -->
    <div class="right-side">
      <div class="form-box">
        <img src="img/estudante.png" alt="Estudante" class="logo">

        <h2>Acesso do Aluno</h2>
          <p>
              <?php 
              /// Exibe a mensagem de erro, se existir
              if(isset($_SESSION['MSG_loginErro'])){
                  echo $_SESSION['MSG_loginErro'];
                  unset($_SESSION['MSG_loginErro']);
                }
              ?>
          </p>
        <br>
        <form action="php/login.php" method="post">
          <div class="form-group">
            <span>usuario para teste: mauricio256franca@gmail.com senha:123456</span><br><br>
            <label for="email">Usuário</label>
            <input name="email" type="email" id="email" placeholder="Digite seu e-mail" required>
          </div>
          <div class="form-group">
            <label for="senha">Senha</label>
            <input name="password" type="password" id="senha" placeholder="Digite sua senha" required>
          </div>
            <div class="form-group"> <a href="#" class="forgot-password">Esqueci minha senha</a>
            
          </div>

          <button name="submit" type="submit">Entrar</button>
          <div class="register-link"><br>
            <p>Não tem uma conta? <a href="matricula.html">Inscreva-se</a></p><br>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
