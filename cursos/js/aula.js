const comentariosPorAula = {
      1: [{ autor: "Maria", texto: "Ótima explicação do conteúdo!" }],
      2: [{ autor: "Ana", texto: "Muito claro e objetivo." }],
      3: [{ autor: "Carlos", texto: "Gostei dos exemplos práticos." }]
    };
    let aulaAtual = 1;

    function mostrarComentarios(aula) {
      const lista = document.getElementById("listaComentarios");
      lista.innerHTML = "";
      const comentarios = comentariosPorAula[aula] || [];
      if (comentarios.length === 0) {
        lista.innerHTML = "<p>Nenhum comentário ainda.</p>";
        return;
      }
      comentarios.forEach((c) => {
        const div = document.createElement("div");
        div.className = "comentario-item";
        div.innerHTML = `<strong>${c.autor}:</strong> ${c.texto}`;
        lista.appendChild(div);
      });
    }

    function adicionarComentario() {
      const input = document.getElementById("inputComentario");
      const texto = input.value.trim();
      if (texto === "") return alert("Digite um comentário.");
      if (!comentariosPorAula[aulaAtual]) comentariosPorAula[aulaAtual] = [];
      comentariosPorAula[aulaAtual].push({ autor: "Você", texto });
      input.value = "";
      mostrarComentarios(aulaAtual);
    }

    function marcarAssistida(checkbox, videoSrc, aulaNum, titulo) {
      if (checkbox.checked) {
        document.getElementById("videoPrincipal").src = videoSrc + "?autoplay=1";
        aulaAtual = aulaNum;
        document.getElementById("tituloAula").textContent = titulo;
        mostrarComentarios(aulaNum);
      }
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

    window.onload = () => {
      mostrarComentarios(aulaAtual);
    };