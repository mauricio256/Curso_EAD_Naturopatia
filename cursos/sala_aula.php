<?php
  session_start();
  include_once('php/conn.php');

  //// VERIFICA SE O USUÁRIO ESTÁ LOGADO
  if(!isset($_SESSION['Usuario'])) {
    header('Location: ../login_aluno.php');
    exit();
  }

  if(!isset($_GET['ID_Curso'])) {
    echo"<script>
    alert('Algo deu errado. ID do curso não identificado, Tente novamente!');
      window.location.href = '../dashboard.php';
    </script>";
    exit();
  }

  $sql = "SELECT * FROM `Aula` WHERE ID_Curso = 4";
  $busca = $conn->prepare($sql);
  $busca->execute();
  $aulas = $busca->fetchAll(PDO::FETCH_ASSOC);  

  echo "<script>console.log('Aulas: ".json_encode($aulas)."');</script>";
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

  <button class="btn-toggle-sidebar" onclick="toggleSidebar()">Aulas</button>
  

  <div class="sidebar" id="sidebar">
    <h2>Curso: Naturopatia Clínica</h2>

    <div class="progresso">
      <div class="progresso-barra" id="progresso-barra">0%</div>
    </div>

    <label class="miniatura" data-video="https://www.youtube.com/embed/HYsAGQsn8Ds" data-aula="1" data-titulo="Aula 1 - Alimentação Natural">
      <input type="checkbox" onclick="marcarAssistida(this, 'https://www.youtube.com/embed/HYsAGQsn8Ds', 1, 'Aula 1 - Alimentação Natural')" />
      Aula 1 - Alimentação Natural
    </label>
    <label class="miniatura" data-video="https://www.youtube.com/embed/7L-fC1lu1zk" data-aula="2" data-titulo="Aula 2 - Terapias Integrativas">
      <input type="checkbox" onclick="marcarAssistida(this, 'https://www.youtube.com/embed/7L-fC1lu1zk', 2, 'Aula 2 - Terapias Integrativas')" />
      Aula 2 - Terapias Integrativas
    </label>
    <label class="miniatura" data-video="https://www.youtube.com/embed/zhuVszjkwnA" data-aula="3" data-titulo="Aula 3 - Fitoterapia Prática">
      <input type="checkbox" onclick="marcarAssistida(this, 'https://www.youtube.com/embed/zhuVszjkwnA', 3, 'Aula 3 - Fitoterapia Prática')" />
      Aula 3 - Fitoterapia Prática
    </label>

    <button id="btnAvaliacao" class="botao-avaliacao"><a href="/cursos/avaliacoes/naturopatia_clinica.html">Fazer Avaliação</a></button>
  </div>
  <div class="container">
    <div class="video-section">
      <br> <a href="/dashboard.html">Sair da sala de aula</a> <br><br>
      <div class="video-player">
        <iframe id="videoPrincipal" src="https://www.youtube.com/embed/HYsAGQsn8Ds" allowfullscreen></iframe>
      </div>
      <div class="titulo-aula" id="tituloAula">Aula 1 - Alimentação Natural</div>

      <div class="comentarios">
        <h4>Comentários</h4>
        <div class="lista-comentarios" id="listaComentarios"></div>
        <div class="novo-comentario">
          <input type="text" id="inputComentario" placeholder="Escreva seu comentário..." />
          <button onclick="adicionarComentario()">Enviar</button>
        </div>
      </div>
    </div>
  </div>
  
  <script src="js/aula.js"></script>
</body>
</html>
