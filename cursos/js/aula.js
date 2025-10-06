function marcarAssistida(checkbox, videoSrc, aulaNum, titulo) {
  if (checkbox.checked) {
    document.getElementById("videoPrincipal").src = videoSrc + "?autoplay=1";
    aulaAtual = aulaNum;
    document.getElementById("tituloAula").textContent = titulo;
    toggleSidebar(); // Fecha a sidebar ao selecionar uma aula
  }

  // 🔹 Envia o progresso para o backend via AJAX
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "salvar_progresso.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send("aula=" + aulaNum + "&assistida=" + (checkbox.checked ? 1 : 0));

  xhr.onload = function () {
    if (xhr.status === 200) {
      console.log("Progresso salvo: " + xhr.responseText);
    } else {
      console.error("Erro ao salvar progresso");
    }
  };

  atualizarProgresso();
}

function atualizarProgresso() {
  const checks = document.querySelectorAll('.miniatura input[type="checkbox"]');
  const barra = document.getElementById("progresso-barra");
  const btn = document.getElementById("btnAvaliacao");
  const total = checks.length;
  let marcados = 0;

  checks.forEach(cb => { if (cb.checked) marcados++; });

  const perc = Math.round((marcados / total) * 100);
  barra.style.width = perc + "%";
  barra.textContent = perc + "%";

  if (marcados === total) {
    btn.classList.add("ativo");
    btn.disabled = false;
  } else {
    btn.classList.remove("ativo");
    btn.disabled = true;
  }
}

function toggleSidebar() {
  document.getElementById("sidebar").classList.toggle("aberta");
}
