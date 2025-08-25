<?php
  session_start();

  //// VERIFICA SE O USUÁRIO ESTÁ LOGADO
  if(!isset($_SESSION['Usuario'])) {
    header('Location: login_aluno.php');
    exit();
  }
  
  // CONEXÃO COM O BANCO DE DADOS
  include_once('php/conn.php');

  $ID_Usuario = $_SESSION['Usuario']['ID_Usuario'];

  //// PUXA OS DADOS DO ALUNO
  $sql_aluno = "SELECT * FROM Aluno WHERE ID_Usuario = '$ID_Usuario'";
  $busca = $conn->prepare($sql_aluno);
  $busca->execute();
  $aluno = $busca->fetch(PDO::FETCH_ASSOC);

  //// PUXA OS ID`S DOS CURSOS DO ALUNO
  $sql_aluno_cursos = "SELECT ID_Curso FROM `Matricula` WHERE ID_Aluno = '".$aluno['ID_Aluno']."'";
  $busca_cursos = $conn->prepare($sql_aluno_cursos);
  $busca_cursos->execute();
  $cursos = $busca_cursos->fetchAll(PDO::FETCH_ASSOC);
  
  ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="css/dashboard.css" />
  <title>Dashboard do Aluno</title>
  <style>
  
  </style>
</head>
<body>
<div class="container">
  <nav class="sidebar" id="sidebar">
    <img src="img/estudante.png" width="50px">
    <a href="dashboard.php">Início</a>
    <a href="#">Meus Cursos</a>
    <a href="#">Meus Certificados</a>
    <a href="#">Minhas Notas</a>
    <a href="#">Novos Cursos</a>
    <a href="#">Configurações</a>
  </nav>

  <header class="header">
    <span class="menu-toggle" id="menu-toggle">&#9776;</span>
    <div class="user-profile" id="user-profile">
      <img src="https://i.pravatar.cc/150?img=12" alt="Foto do Aluno" />
      <span><?php echo $aluno['Nome']; ?></span>
      <div class="profile-dropdown" id="profile-dropdown">
        <a href="#">Meu Perfil</a>
        <a href="#">Comprovante de Matricula</a>
        <a href="php/encerra_sessao.php">Sair</a>
      </div>
    </div>
  </header>

  <main class="main">
    <h1>Bem-vindo (a), <?php echo $aluno['Nome']; ?>!</h1>
    <p>Aqui está sua visão geral dos estudos.</p>

    <div class="cards" >
       <!-- Botões dos Modais -->
    <button class="open-modal-btn" data-modal="modal1">Meus Cursos</button>
    <button class="open-modal-btn" data-modal="modal2">Em fase de construção.</button>
    <button class="open-modal-btn" data-modal="modal3">Em fase de construção.</button>
  </main>
    </div>

</div>

<!-- Modal 1 -->
<div id="modal1" class="modal">
  <div class="modal-content">
    <span class="close" data-close="modal1">&times;</span>
    <h2>Cursos em Andamento</h2>
    <ul>
      <!-- Listar os cursos do aluno com um foreach porem so tras o ID do curso e nao o titulo-->
      <?php foreach($cursos as $curso) { ?>

        <!-- Puxa o título do curso usado o ID que esta na variavel -> $curso['ID_Curso'] do foreach -->
        <li> <a href="cursos/sala_aula.html"> <?php $sql_curso = "SELECT * FROM Curso WHERE ID_Curso = '".$curso['ID_Curso']."'";  $busca_cursos = $conn->prepare($sql_curso);$busca_cursos->execute();   $titulo_cursos = $busca_cursos->fetchAll(PDO::FETCH_ASSOC); 
          
          /// Mostra o título do curso para cada ID de curso rodado no foreach que o aluno está matriculado
          echo $titulo_cursos[0]['Titulo']?> 
          
        </a></li>
      <?php } ?>
    </ul>
  </div>
</div>

<!-- Modal 2 -->
<div id="modal2" class="modal">
  <div class="modal-content">
    <span class="close" data-close="modal2">&times;</span>
    <h2>Funcao em desenvolvimento</h2>
    <p>Em fase de construção.</p>
  </div>
</div>

<!-- Modal 3 -->
<div id="modal3" class="modal">
  <div class="modal-content">
    <span class="close" data-close="modal3">&times;</span>
    <h2>Funcao em desenvolvimento</h2>
    <p>Em fase de construção.</p>
  </div>
</div>

<script src="js/dashboard.js"></script>
<script>
  // Abrir modais
  document.querySelectorAll('.open-modal-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const modalId = btn.getAttribute('data-modal');
      const modal = document.getElementById(modalId);
      if (modal) modal.style.display = 'block';
    });
  });

  // Fechar modais
  document.querySelectorAll('.close').forEach(span => {
    span.addEventListener('click', () => {
      const modalId = span.getAttribute('data-close');
      const modal = document.getElementById(modalId);
      if (modal) modal.style.display = 'none';
    });
  });

  // Fechar clicando fora
  window.onclick = function(event) {
    document.querySelectorAll('.modal').forEach(modal => {
      if (event.target === modal) {
        modal.style.display = 'none';
      }
    });
  };
</script>
</body>
</html>
