-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 06/10/2025 às 01:11
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `curso_ead_naturopatia`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `Alternativa`
--

CREATE TABLE `Alternativa` (
  `ID_Alternativa` int(11) NOT NULL,
  `ID_Questao` int(11) DEFAULT NULL,
  `Texto` text DEFAULT NULL,
  `Correta` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Aluno`
--

CREATE TABLE `Aluno` (
  `ID_Aluno` int(11) NOT NULL,
  `Nome` varchar(100) NOT NULL,
  `Data_Nascimento` date DEFAULT NULL,
  `Curso` varchar(150) DEFAULT NULL,
  `Endereco` varchar(255) DEFAULT NULL,
  `Cidade` varchar(100) DEFAULT NULL,
  `CEP` varchar(15) DEFAULT NULL,
  `UF` char(2) DEFAULT NULL,
  `Estado_Civil` varchar(50) DEFAULT NULL,
  `Atividade` varchar(100) DEFAULT NULL,
  `CPF` varchar(20) DEFAULT NULL,
  `CRT` varchar(20) DEFAULT NULL,
  `WhatsApp` varchar(20) DEFAULT NULL,
  `ID_Usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `Aluno`
--

INSERT INTO `Aluno` (`ID_Aluno`, `Nome`, `Data_Nascimento`, `Curso`, `Endereco`, `Cidade`, `CEP`, `UF`, `Estado_Civil`, `Atividade`, `CPF`, `CRT`, `WhatsApp`, `ID_Usuario`) VALUES
(132, 'Mauricio Dos Santos França', '2005-06-01', '4', '', '', '48914-052', '', 'casado', 'programador', '861.362.545-22', '', '(74) 981237-0420', 50);

-- --------------------------------------------------------

--
-- Estrutura para tabela `Aula`
--

CREATE TABLE `Aula` (
  `ID_Aula` int(11) NOT NULL,
  `Titulo` varchar(150) NOT NULL,
  `Descricao` text DEFAULT NULL,
  `Ordem` int(11) DEFAULT NULL,
  `URL_Video` varchar(255) DEFAULT NULL,
  `ID_Curso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `Aula`
--

INSERT INTO `Aula` (`ID_Aula`, `Titulo`, `Descricao`, `Ordem`, `URL_Video`, `ID_Curso`) VALUES
(1, 'Aula 1 - Introdução a Naturopatia', 'DR WILSON DIAS INTRODUÇÃO À NATUROPATIA 1ª AULA DO CURSO', 1, 'https://www.youtube.com/embed/HYsAGQsn8Ds', 4),
(2, 'Aula 2 - Terapias Integrativas', 'Terapias Integrativas', 2, 'https://www.youtube.com/embed/7L-fC1lu1zk', 4),
(3, 'Aula 3 - Fitoterapia Prática', 'Fitoterapia Prática', 3, 'https://www.youtube.com/embed/zhuVszjkwnA', 4),
(4, 'Aula 4 - Não enconntrada ', 'aula nao encontrada', 4, 'https://www.youtube.com/embed/H1sTe73fdfdfds', 4),
(5, 'Aula 5 - Naturopatia Energética e Imunológica', 'Naturopatia Energética e Imunológica', 5, 'https://www.youtube.com/embed/H1sTe731Nbs', 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `Boleto`
--

CREATE TABLE `Boleto` (
  `ID_Boleto` int(11) NOT NULL,
  `ID_Usuario` int(11) NOT NULL,
  `payment_id` varchar(50) NOT NULL,
  `qrCodeBase64` longtext NOT NULL,
  `qrCodeText` text NOT NULL,
  `status` varchar(20) NOT NULL,
  `data_criacao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `Boleto`
--

INSERT INTO `Boleto` (`ID_Boleto`, `ID_Usuario`, `payment_id`, `qrCodeBase64`, `qrCodeText`, `status`, `data_criacao`) VALUES
(58, 50, '128778299762', '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', '00020126490014br.gov.bcb.pix0127mauricio256franca@gmail.com52040000530398654040.105802BR5923FRANAMAURCIO202304152106009Sao Paulo62250521mpqrinter1287782997626304A0A9', 'approved', '2025-10-05 22:07:30');

-- --------------------------------------------------------

--
-- Estrutura para tabela `Certificado`
--

CREATE TABLE `Certificado` (
  `ID_Certificado` int(11) NOT NULL,
  `ID_Aluno` int(11) DEFAULT NULL,
  `ID_Curso` int(11) DEFAULT NULL,
  `Data_Emissao` date DEFAULT NULL,
  `Codigo_Verificacao` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Comentario`
--

CREATE TABLE `Comentario` (
  `ID_Comentario` int(11) NOT NULL,
  `ID_Aluno` int(11) DEFAULT NULL,
  `ID_Aula` int(11) DEFAULT NULL,
  `Texto` text DEFAULT NULL,
  `Data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Curso`
--

CREATE TABLE `Curso` (
  `ID_Curso` int(11) NOT NULL,
  `Titulo` varchar(150) NOT NULL,
  `Descricao` text DEFAULT NULL,
  `Categoria` varchar(100) DEFAULT NULL,
  `ID_Professor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `Curso`
--

INSERT INTO `Curso` (`ID_Curso`, `Titulo`, `Descricao`, `Categoria`, `ID_Professor`) VALUES
(4, 'Curso Superior Sequencial em Naturopatia Clínica Científica', 'descricao do curso', 'Naturopatia', 3),
(5, 'curso 2', 'tedstte', 'naturopatia', 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `Material`
--

CREATE TABLE `Material` (
  `ID_Material` int(11) NOT NULL,
  `ID_Aula` int(11) DEFAULT NULL,
  `Tipo` varchar(50) DEFAULT NULL,
  `Descricao` text DEFAULT NULL,
  `URL_Arquivo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Matricula`
--

CREATE TABLE `Matricula` (
  `ID_Matricula` int(11) NOT NULL,
  `ID_Aluno` int(11) DEFAULT NULL,
  `ID_Curso` int(11) DEFAULT NULL,
  `Data_Matricula` date DEFAULT NULL,
  `Progresso` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `Matricula`
--

INSERT INTO `Matricula` (`ID_Matricula`, `ID_Aluno`, `ID_Curso`, `Data_Matricula`, `Progresso`) VALUES
(16, 132, 4, '2025-10-05', 0.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `Professor`
--

CREATE TABLE `Professor` (
  `ID_Professor` int(11) NOT NULL,
  `Nome` varchar(100) NOT NULL,
  `Especializacao` varchar(100) DEFAULT NULL,
  `ID_Usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `Professor`
--

INSERT INTO `Professor` (`ID_Professor`, `Nome`, `Especializacao`, `ID_Usuario`) VALUES
(3, 'Carlos DR. Wilsson Dias', 'Naturopata Clínico', 6);

-- --------------------------------------------------------

--
-- Estrutura para tabela `Progresso`
--

CREATE TABLE `Progresso` (
  `ID_Aluno` int(11) NOT NULL,
  `ID_Curso` int(11) NOT NULL,
  `ID_Aula` int(11) NOT NULL,
  `assistida` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Questao`
--

CREATE TABLE `Questao` (
  `ID_Questao` int(11) NOT NULL,
  `ID_Curso` int(11) DEFAULT NULL,
  `Enunciado` text DEFAULT NULL,
  `Tipo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `RespostaAluno`
--

CREATE TABLE `RespostaAluno` (
  `ID_Resposta` int(11) NOT NULL,
  `ID_Aluno` int(11) DEFAULT NULL,
  `ID_Questao` int(11) DEFAULT NULL,
  `ID_Alternativa` int(11) DEFAULT NULL,
  `Data_Resposta` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Usuario`
--

CREATE TABLE `Usuario` (
  `ID_Usuario` int(11) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Senha_Hash` varchar(255) NOT NULL,
  `Tipo` enum('Aluno','Professor','Admin') NOT NULL,
  `Data_Cadastro` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `Usuario`
--

INSERT INTO `Usuario` (`ID_Usuario`, `Email`, `Senha_Hash`, `Tipo`, `Data_Cadastro`) VALUES
(6, 'wilsson@gmail.com', '123456', 'Professor', '2025-01-05'),
(50, 'mauricio256franca@gmail.com', '123456', 'Aluno', '2025-10-05');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `Alternativa`
--
ALTER TABLE `Alternativa`
  ADD PRIMARY KEY (`ID_Alternativa`),
  ADD KEY `ID_Questao` (`ID_Questao`);

--
-- Índices de tabela `Aluno`
--
ALTER TABLE `Aluno`
  ADD PRIMARY KEY (`ID_Aluno`),
  ADD UNIQUE KEY `CPF` (`CPF`),
  ADD UNIQUE KEY `ID_Usuario` (`ID_Usuario`);

--
-- Índices de tabela `Aula`
--
ALTER TABLE `Aula`
  ADD PRIMARY KEY (`ID_Aula`),
  ADD KEY `ID_Curso` (`ID_Curso`);

--
-- Índices de tabela `Boleto`
--
ALTER TABLE `Boleto`
  ADD PRIMARY KEY (`ID_Boleto`),
  ADD UNIQUE KEY `ID_Usuario` (`ID_Usuario`) USING BTREE;

--
-- Índices de tabela `Certificado`
--
ALTER TABLE `Certificado`
  ADD PRIMARY KEY (`ID_Certificado`),
  ADD UNIQUE KEY `Codigo_Verificacao` (`Codigo_Verificacao`),
  ADD KEY `ID_Aluno` (`ID_Aluno`),
  ADD KEY `ID_Curso` (`ID_Curso`);

--
-- Índices de tabela `Comentario`
--
ALTER TABLE `Comentario`
  ADD PRIMARY KEY (`ID_Comentario`),
  ADD KEY `ID_Aluno` (`ID_Aluno`),
  ADD KEY `ID_Aula` (`ID_Aula`);

--
-- Índices de tabela `Curso`
--
ALTER TABLE `Curso`
  ADD PRIMARY KEY (`ID_Curso`),
  ADD KEY `ID_Professor` (`ID_Professor`);

--
-- Índices de tabela `Material`
--
ALTER TABLE `Material`
  ADD PRIMARY KEY (`ID_Material`),
  ADD KEY `ID_Aula` (`ID_Aula`);

--
-- Índices de tabela `Matricula`
--
ALTER TABLE `Matricula`
  ADD PRIMARY KEY (`ID_Matricula`),
  ADD KEY `ID_Aluno` (`ID_Aluno`),
  ADD KEY `ID_Curso` (`ID_Curso`);

--
-- Índices de tabela `Professor`
--
ALTER TABLE `Professor`
  ADD PRIMARY KEY (`ID_Professor`),
  ADD UNIQUE KEY `ID_Usuario` (`ID_Usuario`);

--
-- Índices de tabela `Progresso`
--
ALTER TABLE `Progresso`
  ADD KEY `ID_Aula` (`ID_Aula`),
  ADD KEY `ID_Curso` (`ID_Curso`),
  ADD KEY `ID_Aluno` (`ID_Aluno`);

--
-- Índices de tabela `Questao`
--
ALTER TABLE `Questao`
  ADD PRIMARY KEY (`ID_Questao`),
  ADD KEY `ID_Curso` (`ID_Curso`);

--
-- Índices de tabela `RespostaAluno`
--
ALTER TABLE `RespostaAluno`
  ADD PRIMARY KEY (`ID_Resposta`),
  ADD KEY `ID_Aluno` (`ID_Aluno`),
  ADD KEY `ID_Questao` (`ID_Questao`),
  ADD KEY `ID_Alternativa` (`ID_Alternativa`);

--
-- Índices de tabela `Usuario`
--
ALTER TABLE `Usuario`
  ADD PRIMARY KEY (`ID_Usuario`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `Alternativa`
--
ALTER TABLE `Alternativa`
  MODIFY `ID_Alternativa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Aluno`
--
ALTER TABLE `Aluno`
  MODIFY `ID_Aluno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT de tabela `Aula`
--
ALTER TABLE `Aula`
  MODIFY `ID_Aula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de tabela `Boleto`
--
ALTER TABLE `Boleto`
  MODIFY `ID_Boleto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de tabela `Certificado`
--
ALTER TABLE `Certificado`
  MODIFY `ID_Certificado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Comentario`
--
ALTER TABLE `Comentario`
  MODIFY `ID_Comentario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Curso`
--
ALTER TABLE `Curso`
  MODIFY `ID_Curso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `Material`
--
ALTER TABLE `Material`
  MODIFY `ID_Material` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Matricula`
--
ALTER TABLE `Matricula`
  MODIFY `ID_Matricula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `Professor`
--
ALTER TABLE `Professor`
  MODIFY `ID_Professor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `Questao`
--
ALTER TABLE `Questao`
  MODIFY `ID_Questao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `RespostaAluno`
--
ALTER TABLE `RespostaAluno`
  MODIFY `ID_Resposta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Usuario`
--
ALTER TABLE `Usuario`
  MODIFY `ID_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `Alternativa`
--
ALTER TABLE `Alternativa`
  ADD CONSTRAINT `Alternativa_ibfk_1` FOREIGN KEY (`ID_Questao`) REFERENCES `Questao` (`ID_Questao`);

--
-- Restrições para tabelas `Aluno`
--
ALTER TABLE `Aluno`
  ADD CONSTRAINT `Aluno_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `Usuario` (`ID_Usuario`);

--
-- Restrições para tabelas `Aula`
--
ALTER TABLE `Aula`
  ADD CONSTRAINT `Aula_ibfk_1` FOREIGN KEY (`ID_Curso`) REFERENCES `Curso` (`ID_Curso`);

--
-- Restrições para tabelas `Boleto`
--
ALTER TABLE `Boleto`
  ADD CONSTRAINT `Boleto_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `Usuario` (`ID_Usuario`);

--
-- Restrições para tabelas `Certificado`
--
ALTER TABLE `Certificado`
  ADD CONSTRAINT `Certificado_ibfk_1` FOREIGN KEY (`ID_Aluno`) REFERENCES `Aluno` (`ID_Aluno`),
  ADD CONSTRAINT `Certificado_ibfk_2` FOREIGN KEY (`ID_Curso`) REFERENCES `Curso` (`ID_Curso`);

--
-- Restrições para tabelas `Comentario`
--
ALTER TABLE `Comentario`
  ADD CONSTRAINT `Comentario_ibfk_1` FOREIGN KEY (`ID_Aluno`) REFERENCES `Aluno` (`ID_Aluno`),
  ADD CONSTRAINT `Comentario_ibfk_2` FOREIGN KEY (`ID_Aula`) REFERENCES `Aula` (`ID_Aula`);

--
-- Restrições para tabelas `Curso`
--
ALTER TABLE `Curso`
  ADD CONSTRAINT `Curso_ibfk_1` FOREIGN KEY (`ID_Professor`) REFERENCES `Professor` (`ID_Professor`);

--
-- Restrições para tabelas `Material`
--
ALTER TABLE `Material`
  ADD CONSTRAINT `Material_ibfk_1` FOREIGN KEY (`ID_Aula`) REFERENCES `Aula` (`ID_Aula`);

--
-- Restrições para tabelas `Matricula`
--
ALTER TABLE `Matricula`
  ADD CONSTRAINT `Matricula_ibfk_1` FOREIGN KEY (`ID_Aluno`) REFERENCES `Aluno` (`ID_Aluno`),
  ADD CONSTRAINT `Matricula_ibfk_2` FOREIGN KEY (`ID_Curso`) REFERENCES `Curso` (`ID_Curso`);

--
-- Restrições para tabelas `Professor`
--
ALTER TABLE `Professor`
  ADD CONSTRAINT `Professor_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `Usuario` (`ID_Usuario`);

--
-- Restrições para tabelas `Progresso`
--
ALTER TABLE `Progresso`
  ADD CONSTRAINT `Progresso_ibfk_1` FOREIGN KEY (`ID_Aluno`) REFERENCES `Aluno` (`ID_Aluno`),
  ADD CONSTRAINT `Progresso_ibfk_2` FOREIGN KEY (`ID_Aula`) REFERENCES `Aula` (`ID_Aula`),
  ADD CONSTRAINT `Progresso_ibfk_3` FOREIGN KEY (`ID_Curso`) REFERENCES `Curso` (`ID_Curso`);

--
-- Restrições para tabelas `Questao`
--
ALTER TABLE `Questao`
  ADD CONSTRAINT `Questao_ibfk_1` FOREIGN KEY (`ID_Curso`) REFERENCES `Curso` (`ID_Curso`);

--
-- Restrições para tabelas `RespostaAluno`
--
ALTER TABLE `RespostaAluno`
  ADD CONSTRAINT `RespostaAluno_ibfk_1` FOREIGN KEY (`ID_Aluno`) REFERENCES `Aluno` (`ID_Aluno`),
  ADD CONSTRAINT `RespostaAluno_ibfk_2` FOREIGN KEY (`ID_Questao`) REFERENCES `Questao` (`ID_Questao`),
  ADD CONSTRAINT `RespostaAluno_ibfk_3` FOREIGN KEY (`ID_Alternativa`) REFERENCES `Alternativa` (`ID_Alternativa`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
