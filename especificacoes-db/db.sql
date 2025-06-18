-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           9.2.0 - MySQL Community Server - GPL
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.11.0.7065
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para descubra_muriae
CREATE DATABASE IF NOT EXISTS `descubra_muriae` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `descubra_muriae`;

-- Copiando estrutura para tabela descubra_muriae.cargo
CREATE TABLE IF NOT EXISTS `cargo` (
  `cargo_id` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL,
  PRIMARY KEY (`cargo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela descubra_muriae.cargo: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela descubra_muriae.categoria_estabelecimento
CREATE TABLE IF NOT EXISTS `categoria_estabelecimento` (
  `categoria_estabelecimento_id` int NOT NULL AUTO_INCREMENT,
  `estabelecimento_id` int NOT NULL,
  `categoria_id` int NOT NULL,
  PRIMARY KEY (`categoria_estabelecimento_id`),
  KEY `idx_categoria_estabelecimento` (`estabelecimento_id`,`categoria_id`),
  CONSTRAINT `fk_estabelecimento_categoria` FOREIGN KEY (`estabelecimento_id`) REFERENCES `estabelecimento` (`estabelecimento_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1249 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela descubra_muriae.categoria_estabelecimento: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela descubra_muriae.cidade
CREATE TABLE IF NOT EXISTS `cidade` (
  `cidade_id` int NOT NULL AUTO_INCREMENT,
  `cidade` varchar(200) NOT NULL,
  `uf` char(2) NOT NULL,
  PRIMARY KEY (`cidade_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5565 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela descubra_muriae.cidade: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela descubra_muriae.clique_celular
CREATE TABLE IF NOT EXISTS `clique_celular` (
  `clique_celular_id` int NOT NULL AUTO_INCREMENT,
  `estabelecimento_id` int NOT NULL,
  `visitante_id` int NOT NULL,
  `celular` char(11) NOT NULL,
  `telefone_id` int DEFAULT NULL,
  `data_clique` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`clique_celular_id`),
  KEY `fk_estabelecimento_clique_celular_idx` (`estabelecimento_id`),
  KEY `fk_telefone_clique_celular_idx` (`telefone_id`),
  CONSTRAINT `fk_estabelecimento_clique_celular` FOREIGN KEY (`estabelecimento_id`) REFERENCES `estabelecimento` (`estabelecimento_id`),
  CONSTRAINT `fk_telefone_clique_celular` FOREIGN KEY (`telefone_id`) REFERENCES `telefone` (`telefone_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela descubra_muriae.clique_celular: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela descubra_muriae.clique_telefone
CREATE TABLE IF NOT EXISTS `clique_telefone` (
  `clique_telefone_id` int NOT NULL AUTO_INCREMENT,
  `estabelecimento_id` int NOT NULL,
  `visitante_id` int NOT NULL,
  `telefone` char(11) NOT NULL,
  `telefone_id` int DEFAULT NULL,
  `data_clique` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`clique_telefone_id`),
  KEY `fk_estabelecimento_clique_telefone_idx` (`estabelecimento_id`),
  KEY `fk_telefone_clique_telefone_idx` (`telefone_id`),
  CONSTRAINT `fk_estabelecimento_clique_telefone` FOREIGN KEY (`estabelecimento_id`) REFERENCES `estabelecimento` (`estabelecimento_id`),
  CONSTRAINT `fk_telefone_clique_telefone` FOREIGN KEY (`telefone_id`) REFERENCES `telefone` (`telefone_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela descubra_muriae.clique_telefone: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela descubra_muriae.curriculum
CREATE TABLE IF NOT EXISTS `curriculum` (
  `curriculum_id` int NOT NULL AUTO_INCREMENT,
  `pessoa_fisica_id` int NOT NULL,
  `logradouro` varchar(60) NOT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `complemento` varchar(20) DEFAULT NULL,
  `bairro` varchar(50) NOT NULL,
  `cep` varchar(8) NOT NULL,
  `cidade_id` int NOT NULL,
  `celular` varchar(11) NOT NULL,
  `dataNascimento` date NOT NULL,
  `sexo` char(1) NOT NULL COMMENT 'M=Masculino;F=Feminino',
  `foto` varchar(100) DEFAULT NULL,
  `email` varchar(120) NOT NULL,
  `apresentacaoPessoal` text,
  PRIMARY KEY (`curriculum_id`),
  KEY `fk_curriculum_cidade1_idx` (`cidade_id`),
  KEY `fk_curriculum_pessoa_fisica1_idx` (`pessoa_fisica_id`),
  CONSTRAINT `fk_curriculum_cidade1` FOREIGN KEY (`cidade_id`) REFERENCES `cidade` (`cidade_id`),
  CONSTRAINT `fk_curriculum_pessoa_fisica1` FOREIGN KEY (`pessoa_fisica_id`) REFERENCES `pessoa_fisica` (`pessoa_fisica_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela descubra_muriae.curriculum: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela descubra_muriae.curriculum_escolaridade
CREATE TABLE IF NOT EXISTS `curriculum_escolaridade` (
  `curriculum_escolaridade_id` int NOT NULL AUTO_INCREMENT,
  `curriculum_curriculum_id` int NOT NULL,
  `inicioMes` int NOT NULL,
  `inicioAno` int NOT NULL,
  `fimMes` int NOT NULL,
  `fimAno` int NOT NULL,
  `descricao` varchar(60) NOT NULL,
  `instituicao` varchar(60) NOT NULL,
  `cidade_id` int NOT NULL,
  `escolaridade_id` int NOT NULL,
  PRIMARY KEY (`curriculum_escolaridade_id`),
  KEY `fk_curriculum_escolaridade_cidade1_idx` (`cidade_id`),
  KEY `fk_curriculum_escolaridade_curriculum1_idx` (`curriculum_curriculum_id`),
  KEY `fk_curriculum_escolaridade_escolaridade1_idx` (`escolaridade_id`),
  CONSTRAINT `fk_curriculum_escolaridade_cidade1` FOREIGN KEY (`cidade_id`) REFERENCES `cidade` (`cidade_id`),
  CONSTRAINT `fk_curriculum_escolaridade_curriculum1` FOREIGN KEY (`curriculum_curriculum_id`) REFERENCES `curriculum` (`curriculum_id`),
  CONSTRAINT `fk_curriculum_escolaridade_escolaridade1` FOREIGN KEY (`escolaridade_id`) REFERENCES `escolaridade` (`escolaridade_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela descubra_muriae.curriculum_escolaridade: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela descubra_muriae.curriculum_experiencia
CREATE TABLE IF NOT EXISTS `curriculum_experiencia` (
  `curriculum_experiencia_id` int NOT NULL AUTO_INCREMENT,
  `curriculum_id` int NOT NULL,
  `inicioMes` int NOT NULL,
  `inicioAno` int NOT NULL,
  `fimMes` int DEFAULT NULL,
  `fimAno` int DEFAULT NULL,
  `estabelecimento` varchar(60) DEFAULT NULL,
  `cargo_id` int DEFAULT NULL,
  `cargoDescricao` varchar(50) DEFAULT NULL,
  `atividadesExercidas` text,
  PRIMARY KEY (`curriculum_experiencia_id`),
  KEY `fk_curriculum_experiencia_curriculum1_idx` (`curriculum_id`),
  KEY `fk_curriculum_experiencia_cargo1_idx` (`cargo_id`),
  CONSTRAINT `fk_curriculum_experiencia_cargo1` FOREIGN KEY (`cargo_id`) REFERENCES `cargo` (`cargo_id`),
  CONSTRAINT `fk_curriculum_experiencia_curriculum1` FOREIGN KEY (`curriculum_id`) REFERENCES `curriculum` (`curriculum_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela descubra_muriae.curriculum_experiencia: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela descubra_muriae.curriculum_qualificacao
CREATE TABLE IF NOT EXISTS `curriculum_qualificacao` (
  `curriculum_qualificacao_id` int NOT NULL AUTO_INCREMENT,
  `curriculum_id` int NOT NULL,
  `mes` int NOT NULL,
  `ano` int NOT NULL,
  `cargaHoraria` int NOT NULL,
  `descricao` varchar(60) NOT NULL,
  `estabelecimento` varchar(60) NOT NULL,
  PRIMARY KEY (`curriculum_qualificacao_id`),
  KEY `fk_curriculum_qualificacao_curriculum1_idx` (`curriculum_id`),
  CONSTRAINT `fk_curriculum_qualificacao_curriculum1` FOREIGN KEY (`curriculum_id`) REFERENCES `curriculum` (`curriculum_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela descubra_muriae.curriculum_qualificacao: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela descubra_muriae.escolaridade
CREATE TABLE IF NOT EXISTS `escolaridade` (
  `escolaridade_id` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL,
  PRIMARY KEY (`escolaridade_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela descubra_muriae.escolaridade: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela descubra_muriae.estabelecimento
CREATE TABLE IF NOT EXISTS `estabelecimento` (
  `estabelecimento_id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `endereco` varchar(200) DEFAULT NULL,
  `latitude` char(12) NOT NULL,
  `longitude` char(12) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`estabelecimento_id`),
  FULLTEXT KEY `ft_busca` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=1202 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela descubra_muriae.estabelecimento: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela descubra_muriae.pessoa_fisica
CREATE TABLE IF NOT EXISTS `pessoa_fisica` (
  `pessoa_fisica_id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  `cpf` char(11) DEFAULT NULL,
  `visitante_id` int DEFAULT NULL,
  PRIMARY KEY (`pessoa_fisica_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1257 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela descubra_muriae.pessoa_fisica: ~4 rows (aproximadamente)
INSERT IGNORE INTO `pessoa_fisica` (`pessoa_fisica_id`, `nome`, `cpf`, `visitante_id`) VALUES
	(1252, 'Bruno', '08417634614', NULL),
	(1253, 'abc', '084.176.346', NULL),
	(1255, 'abc', '084.176.346', NULL),
	(1256, 'abcs', '084.176.346', NULL);

-- Copiando estrutura para tabela descubra_muriae.telefone
CREATE TABLE IF NOT EXISTS `telefone` (
  `telefone_id` int NOT NULL AUTO_INCREMENT,
  `estabelecimento_id` int DEFAULT NULL,
  `usuario_id` int DEFAULT NULL,
  `numero` char(11) NOT NULL,
  `tipo` enum('m','f') NOT NULL,
  PRIMARY KEY (`telefone_id`),
  KEY `fk_estabelecimento_telefone` (`estabelecimento_id`),
  KEY `fk_usuario_telefone_idx` (`usuario_id`),
  CONSTRAINT `fk_estabelecimento_telefone` FOREIGN KEY (`estabelecimento_id`) REFERENCES `estabelecimento` (`estabelecimento_id`),
  CONSTRAINT `fk_usuario_telefone` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2429 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela descubra_muriae.telefone: ~0 rows (aproximadamente)
INSERT IGNORE INTO `telefone` (`telefone_id`, `estabelecimento_id`, `usuario_id`, `numero`, `tipo`) VALUES
	(2428, NULL, 1237, '32999999999', '');

-- Copiando estrutura para tabela descubra_muriae.termodeuso
CREATE TABLE IF NOT EXISTS `termodeuso` (
  `termodeuso_id` int NOT NULL AUTO_INCREMENT,
  `textoTermo` longtext NOT NULL,
  `statusRegistro` int NOT NULL DEFAULT '1' COMMENT '1=Ativo;2=Inativo;3=Alterado',
  `rascunho` int DEFAULT '1' COMMENT '1=Sim; 2=Não',
  `usuario_id` int NOT NULL,
  PRIMARY KEY (`termodeuso_id`,`usuario_id`),
  UNIQUE KEY `uk_termodeuso_id` (`termodeuso_id`),
  KEY `fk_termodeuso_usuario1` (`usuario_id`),
  CONSTRAINT `fk_termodeuso_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela descubra_muriae.termodeuso: ~1 rows (aproximadamente)
INSERT IGNORE INTO `termodeuso` (`termodeuso_id`, `textoTermo`, `statusRegistro`, `rascunho`, `usuario_id`) VALUES
	(2, 'Texto do termo', 1, 0, 1236),
	(3, 'Texto do termo', 1, 0, 1237);

-- Copiando estrutura para tabela descubra_muriae.termodeusoaceite
CREATE TABLE IF NOT EXISTS `termodeusoaceite` (
  `termodeuso_id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `dataHoraAceite` datetime NOT NULL,
  PRIMARY KEY (`termodeuso_id`,`usuario_id`),
  KEY `fk_termodeuso_has_usuario_usuario1_idx` (`usuario_id`),
  KEY `fk_termodeuso_has_usuario_termodeuso1_idx` (`termodeuso_id`),
  CONSTRAINT `fk_termodeuso_has_usuario_termodeuso1` FOREIGN KEY (`termodeuso_id`) REFERENCES `termodeuso` (`termodeuso_id`),
  CONSTRAINT `fk_termodeuso_has_usuario_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela descubra_muriae.termodeusoaceite: ~1 rows (aproximadamente)
INSERT IGNORE INTO `termodeusoaceite` (`termodeuso_id`, `usuario_id`, `dataHoraAceite`) VALUES
	(2, 1236, '2025-05-13 19:59:58'),
	(3, 1237, '2025-05-14 17:28:44');

-- Copiando estrutura para tabela descubra_muriae.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `usuario_id` int NOT NULL AUTO_INCREMENT,
  `pessoa_fisica_id` int NOT NULL,
  `login` varchar(50) DEFAULT NULL,
  `senha` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tipo` char(2) NOT NULL COMMENT 'A = Anunciante, G = Gestor, CN = Contribuinte normativo',
  PRIMARY KEY (`usuario_id`),
  KEY `fk_pessoa_fisica_usuario1_idx` (`pessoa_fisica_id`),
  CONSTRAINT `fk_pessoa_fisica_usuario1` FOREIGN KEY (`pessoa_fisica_id`) REFERENCES `pessoa_fisica` (`pessoa_fisica_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1238 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela descubra_muriae.usuario: ~3 rows (aproximadamente)
INSERT IGNORE INTO `usuario` (`usuario_id`, `pessoa_fisica_id`, `login`, `senha`, `tipo`) VALUES
	(1234, 1252, 'junior@gmail.com', '$2a$12$Zw9QCCdUosS5eGDxsYu9henviNeCV9cMnJhwDOiVGh1vkLSYQ6ZKm', 'CN'),
	(1236, 1255, 'brunocourii@gmail.com', '$2a$12$Zw9QCCdUosS5eGDxsYu9henviNeCV9cMnJhwDOiVGh1vkLSYQ6ZKm', 'G'),
	(1237, 1256, 'brunocourisch@gmail.com', '$2a$12$Zw9QCCdUosS5eGDxsYu9henviNeCV9cMnJhwDOiVGh1vkLSYQ6ZKm', 'G');

-- Copiando estrutura para tabela descubra_muriae.usuariorecuperasenha
CREATE TABLE IF NOT EXISTS `usuariorecuperasenha` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `chave` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `statusRegistro` int NOT NULL DEFAULT '1' COMMENT '1=Ativo;2=Inativo',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `chave` (`chave`) USING BTREE,
  KEY `FK1_usuariorecuperacaosenha` (`usuario_id`) USING BTREE,
  CONSTRAINT `FK1_usuariorecuperacaosenha` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela descubra_muriae.usuariorecuperasenha: ~0 rows (aproximadamente)
INSERT IGNORE INTO `usuariorecuperasenha` (`id`, `usuario_id`, `chave`, `statusRegistro`, `created_at`, `updated_at`) VALUES
	(3, 1236, '4e2dbed3ec5d99a015859a6f48cd10786252dea2', 1, '2025-06-17 20:45:22', NULL);

-- Copiando estrutura para tabela descubra_muriae.vaga
CREATE TABLE IF NOT EXISTS `vaga` (
  `vaga_id` int NOT NULL AUTO_INCREMENT,
  `cargo_id` int NOT NULL,
  `descricao` varchar(60) NOT NULL,
  `sobreaVaga` text NOT NULL,
  `modalidade` int NOT NULL COMMENT '1=Presencial; 2=Remoto;',
  `vinculo` int NOT NULL COMMENT '1=CLT; 2=Pessoa Jurídica;',
  `dtInicio` date NOT NULL,
  `dtFim` date NOT NULL,
  `estabelecimento_id` int NOT NULL,
  `statusVaga` int NOT NULL COMMENT '1=Pré Vaga; 11=Em aberto;91=Suspensa; 99=Finalizada;',
  PRIMARY KEY (`vaga_id`),
  KEY `fk_vaga_cargo1_idx` (`cargo_id`),
  KEY `fk_vaga_estabelecimento1_idx` (`estabelecimento_id`),
  CONSTRAINT `fk_vaga_cargo1` FOREIGN KEY (`cargo_id`) REFERENCES `cargo` (`cargo_id`),
  CONSTRAINT `fk_vaga_estabelecimento1` FOREIGN KEY (`estabelecimento_id`) REFERENCES `estabelecimento` (`estabelecimento_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela descubra_muriae.vaga: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela descubra_muriae.vaga_curriculum
CREATE TABLE IF NOT EXISTS `vaga_curriculum` (
  `vaga_id` int NOT NULL,
  `curriculum_id` int NOT NULL,
  `dateCandidatura` datetime NOT NULL,
  PRIMARY KEY (`vaga_id`,`curriculum_id`),
  KEY `fk_vaga_has_curriculum_curriculum1_idx` (`curriculum_id`),
  KEY `fk_vaga_has_curriculum_vaga1_idx` (`vaga_id`),
  CONSTRAINT `fk_vaga_has_curriculum_curriculum1` FOREIGN KEY (`curriculum_id`) REFERENCES `curriculum` (`curriculum_id`),
  CONSTRAINT `fk_vaga_has_curriculum_vaga1` FOREIGN KEY (`vaga_id`) REFERENCES `vaga` (`vaga_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela descubra_muriae.vaga_curriculum: ~0 rows (aproximadamente)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
