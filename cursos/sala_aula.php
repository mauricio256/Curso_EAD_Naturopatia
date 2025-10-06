<?php
  session_start();
  include_once('../php/conn.php');

  //// VERIFICA SE O USUÁRIO ESTÁ LOGADO
  if(!isset($_SESSION['Usuario'])) {
    header('Location: ../login_aluno.php');
    exit();
  }

  // VERIFICA SE O ID_DO_CURSO FOI PASSADO PELO GET
  if(!isset($_GET['ID_Curso'])) {
    echo"<script>
    alert('Algo deu errado. ID do curso não identificado, Tente novamente!');
      window.location.href = '../dashboard.php';
    </script>";
    exit();
  }

  // BUSCA AS AULAS DO CURSO
  $sql = "SELECT * FROM `Aula` WHERE ID_Curso = '".$_GET['ID_Curso']."' ORDER BY Ordem ASC";
  $busca = $conn->prepare($sql);
  $busca->execute();
  $aulas = $busca->fetchAll(PDO::FETCH_ASSOC); 

  // BUSCA O PROGRESSO DO ALUNO NO CURSO
  $sql = "SELECT * FROM `Progresso` WHERE ID_Curso = ".$_GET['ID_Curso']." ";
  $busca = $conn->prepare($sql);
  $busca->execute();
  $progesso = $busca->fetchAll(PDO::FETCH_ASSOC);

  foreach($progesso as $p) {  
    $p['ID_Aula'];
  }
    
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="css/aula.css" />
  <title>Aula - Curso Online</title>
</head>
<body>

  <button id="btn-aulas" class="btn-toggle-sidebar" onclick="toggleSidebar()"><h4>Aulas</h4></button>
  

  <div class="sidebar" id="sidebar">
    <h2>Curso: Naturopatia Clínica</h2>

    <div class="progresso">
      <div class="progresso-barra" id="progresso-barra">0%</div>
    </div>

    <?php foreach($aulas as $aula) {   ?>

    <label class="miniatura" data-video="<?php echo $aula['URL_Video']; ?>" data-aula="1" data-titulo="<?php echo $aula['Titulo']; ?>">
      <input type="checkbox" onclick="marcarAssistida(this, '<?php echo $aula['URL_Video']; ?>', <?php echo $aula['Ordem']; ?>, '<?php echo $aula['Titulo']; ?>')" />
      <?php echo $aula['Titulo']; ?>
    </label>
  
    <?php } ?>
    <button id="btnAvaliacao" class="botao-avaliacao"><a href="avaliacoes/naturopatia_clinica.html">Fazer Avaliação</a></button>
  </div>
  <div class="container">
    <div class="video-section">
      <div class="video-player">
        <iframe id="videoPrincipal" src="https://www.youtube.com/embed/HYsAGQsn8Ds" allowfullscreen></iframe>
      </div>
      <div class="titulo-aula" id="tituloAula">DR WILSON DIAS | INTRODUÇÃO À NATUROPATIA</div>
       <p>Clique no botão "Aulas" acima, para começar</p>
      <br> <button><a href="../dashboard.php"><h4>Sair da sala de aula</h4></a></button><br><br>
    </div>
  </div>
  
  <script src="js/aula.js"></script>
</body>
</html>
