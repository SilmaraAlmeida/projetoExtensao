-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema descubra_muriae
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema descubra_muriae
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `descubra_muriae` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
USE `descubra_muriae` ;

-- -----------------------------------------------------
-- Table `descubra_muriae`.`estabelecimento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `descubra_muriae`.`estabelecimento` (
  `estabelecimento_id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(50) NOT NULL,
  `endereco` VARCHAR(200) NULL DEFAULT NULL,
  `latitude` CHAR(12) NOT NULL,
  `longitude` CHAR(12) NOT NULL,
  `email` VARCHAR(150) NULL DEFAULT NULL,
  PRIMARY KEY (`estabelecimento_id`),
  FULLTEXT INDEX `ft_busca` (`nome`) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 1202
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `descubra_muriae`.`categoria_estabelecimento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `descubra_muriae`.`categoria_estabelecimento` (
  `categoria_estabelecimento_id` INT NOT NULL AUTO_INCREMENT,
  `estabelecimento_id` INT NOT NULL,
  `categoria_id` INT NOT NULL,
  PRIMARY KEY (`categoria_estabelecimento_id`),
  INDEX `idx_categoria_estabelecimento` (`estabelecimento_id` ASC, `categoria_id` ASC) VISIBLE,
  CONSTRAINT `fk_estabelecimento_categoria`
    FOREIGN KEY (`estabelecimento_id`)
    REFERENCES `descubra_muriae`.`estabelecimento` (`estabelecimento_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 1249
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `descubra_muriae`.`cidade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `descubra_muriae`.`cidade` (
  `cidade_id` INT NOT NULL AUTO_INCREMENT,
  `cidade` VARCHAR(200) NOT NULL,
  `uf` CHAR(2) NOT NULL,
  PRIMARY KEY (`cidade_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 5565
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `descubra_muriae`.`pessoa_fisica`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `descubra_muriae`.`pessoa_fisica` (
  `pessoa_fisica_id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(150) NOT NULL,
  `cpf` CHAR(11) NULL DEFAULT NULL,
  `visitante_id` INT NULL DEFAULT NULL,
  PRIMARY KEY (`pessoa_fisica_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 1252
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `descubra_muriae`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `descubra_muriae`.`usuario` (
  `usuario_id` INT NOT NULL AUTO_INCREMENT,
  `pessoa_fisica_id` INT NOT NULL,
  `login` VARCHAR(50) NULL DEFAULT NULL,
  `senha` VARCHAR(50) NULL DEFAULT NULL,
  `tipo` CHAR(2) NOT NULL COMMENT 'A = Anunciante, G = Gestor, CN = Contribuinte normativo',
  PRIMARY KEY (`usuario_id`),
  INDEX `fk_pessoa_fisica_usuario1_idx` (`pessoa_fisica_id` ASC) VISIBLE,
  CONSTRAINT `fk_pessoa_fisica_usuario1`
    FOREIGN KEY (`pessoa_fisica_id`)
    REFERENCES `descubra_muriae`.`pessoa_fisica` (`pessoa_fisica_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 1234
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `descubra_muriae`.`telefone`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `descubra_muriae`.`telefone` (
  `telefone_id` INT NOT NULL AUTO_INCREMENT,
  `estabelecimento_id` INT NULL DEFAULT NULL,
  `usuario_id` INT NULL DEFAULT NULL,
  `numero` CHAR(11) NOT NULL,
  `tipo` ENUM('m', 'f') NOT NULL,
  PRIMARY KEY (`telefone_id`),
  INDEX `fk_estabelecimento_telefone` (`estabelecimento_id` ASC) VISIBLE,
  INDEX `fk_usuario_telefone_idx` (`usuario_id` ASC) VISIBLE,
  CONSTRAINT `fk_estabelecimento_telefone`
    FOREIGN KEY (`estabelecimento_id`)
    REFERENCES `descubra_muriae`.`estabelecimento` (`estabelecimento_id`),
  CONSTRAINT `fk_usuario_telefone`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `descubra_muriae`.`usuario` (`usuario_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 2428
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `descubra_muriae`.`clique_celular`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `descubra_muriae`.`clique_celular` (
  `clique_celular_id` INT NOT NULL AUTO_INCREMENT,
  `estabelecimento_id` INT NOT NULL,
  `visitante_id` INT NOT NULL,
  `celular` CHAR(11) NOT NULL,
  `telefone_id` INT NULL DEFAULT NULL,
  `data_clique` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`clique_celular_id`),
  INDEX `fk_estabelecimento_clique_celular_idx` (`estabelecimento_id` ASC) VISIBLE,
  INDEX `fk_telefone_clique_celular_idx` (`telefone_id` ASC) VISIBLE,
  CONSTRAINT `fk_estabelecimento_clique_celular`
    FOREIGN KEY (`estabelecimento_id`)
    REFERENCES `descubra_muriae`.`estabelecimento` (`estabelecimento_id`),
  CONSTRAINT `fk_telefone_clique_celular`
    FOREIGN KEY (`telefone_id`)
    REFERENCES `descubra_muriae`.`telefone` (`telefone_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 32
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `descubra_muriae`.`clique_telefone`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `descubra_muriae`.`clique_telefone` (
  `clique_telefone_id` INT NOT NULL AUTO_INCREMENT,
  `estabelecimento_id` INT NOT NULL,
  `visitante_id` INT NOT NULL,
  `telefone` CHAR(11) NOT NULL,
  `telefone_id` INT NULL DEFAULT NULL,
  `data_clique` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`clique_telefone_id`),
  INDEX `fk_estabelecimento_clique_telefone_idx` (`estabelecimento_id` ASC) VISIBLE,
  INDEX `fk_telefone_clique_telefone_idx` (`telefone_id` ASC) VISIBLE,
  CONSTRAINT `fk_estabelecimento_clique_telefone`
    FOREIGN KEY (`estabelecimento_id`)
    REFERENCES `descubra_muriae`.`estabelecimento` (`estabelecimento_id`),
  CONSTRAINT `fk_telefone_clique_telefone`
    FOREIGN KEY (`telefone_id`)
    REFERENCES `descubra_muriae`.`telefone` (`telefone_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 15
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `descubra_muriae`.`curriculum`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `descubra_muriae`.`curriculum` (
  `curriculum_id` INT NOT NULL AUTO_INCREMENT,
  `pessoa_fisica_id` INT NOT NULL,
  `logradouro` VARCHAR(60) NOT NULL,
  `numero` VARCHAR(10) NULL,
  `complemento` VARCHAR(20) NULL,
  `bairro` VARCHAR(50) NOT NULL,
  `cep` VARCHAR(8) NOT NULL,
  `cidade_id` INT NOT NULL,
  `celular` VARCHAR(11) NOT NULL,
  `dataNascimento` DATE NOT NULL,
  `sexo` CHAR(1) NOT NULL COMMENT 'M=Masculino;F=Feminino',
  `foto` VARCHAR(100) NULL,
  `email` VARCHAR(120) NOT NULL,
  `apresentacaoPessoal` TEXT NULL,
  PRIMARY KEY (`curriculum_id`),
  INDEX `fk_curriculum_cidade1_idx` (`cidade_id` ASC) VISIBLE,
  INDEX `fk_curriculum_pessoa_fisica1_idx` (`pessoa_fisica_id` ASC) VISIBLE,
  CONSTRAINT `fk_curriculum_cidade1`
    FOREIGN KEY (`cidade_id`)
    REFERENCES `descubra_muriae`.`cidade` (`cidade_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_curriculum_pessoa_fisica1`
    FOREIGN KEY (`pessoa_fisica_id`)
    REFERENCES `descubra_muriae`.`pessoa_fisica` (`pessoa_fisica_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `descubra_muriae`.`escolaridade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `descubra_muriae`.`escolaridade` (
  `escolaridade_id` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`escolaridade_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `descubra_muriae`.`curriculum_escolaridade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `descubra_muriae`.`curriculum_escolaridade` (
  `curriculum_escolaridade_id` INT NOT NULL AUTO_INCREMENT,
  `curriculum_curriculum_id` INT NOT NULL,
  `inicioMes` INT NOT NULL,
  `inicioAno` INT NOT NULL,
  `fimMes` INT NOT NULL,
  `fimAno` INT NOT NULL,
  `descricao` VARCHAR(60) NOT NULL,
  `instituicao` VARCHAR(60) NOT NULL,
  `cidade_id` INT NOT NULL,
  `escolaridade_id` INT NOT NULL,
  PRIMARY KEY (`curriculum_escolaridade_id`),
  INDEX `fk_curriculum_escolaridade_cidade1_idx` (`cidade_id` ASC) VISIBLE,
  INDEX `fk_curriculum_escolaridade_curriculum1_idx` (`curriculum_curriculum_id` ASC) VISIBLE,
  INDEX `fk_curriculum_escolaridade_escolaridade1_idx` (`escolaridade_id` ASC) VISIBLE,
  CONSTRAINT `fk_curriculum_escolaridade_cidade1`
    FOREIGN KEY (`cidade_id`)
    REFERENCES `descubra_muriae`.`cidade` (`cidade_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_curriculum_escolaridade_curriculum1`
    FOREIGN KEY (`curriculum_curriculum_id`)
    REFERENCES `descubra_muriae`.`curriculum` (`curriculum_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_curriculum_escolaridade_escolaridade1`
    FOREIGN KEY (`escolaridade_id`)
    REFERENCES `descubra_muriae`.`escolaridade` (`escolaridade_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `descubra_muriae`.`cargo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `descubra_muriae`.`cargo` (
  `cargo_id` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`cargo_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `descubra_muriae`.`curriculum_experiencia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `descubra_muriae`.`curriculum_experiencia` (
  `curriculum_experiencia_id` INT NOT NULL AUTO_INCREMENT,
  `curriculum_id` INT NOT NULL,
  `inicioMes` INT NOT NULL,
  `inicioAno` INT NOT NULL,
  `fimMes` INT NULL,
  `fimAno` INT NULL,
  `estabelecimento` VARCHAR(60) NULL,
  `cargo_id` INT NULL,
  `cargoDescricao` VARCHAR(50) NULL,
  `atividadesExercidas` TEXT NULL,
  PRIMARY KEY (`curriculum_experiencia_id`),
  INDEX `fk_curriculum_experiencia_curriculum1_idx` (`curriculum_id` ASC) VISIBLE,
  INDEX `fk_curriculum_experiencia_cargo1_idx` (`cargo_id` ASC) VISIBLE,
  CONSTRAINT `fk_curriculum_experiencia_curriculum1`
    FOREIGN KEY (`curriculum_id`)
    REFERENCES `descubra_muriae`.`curriculum` (`curriculum_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_curriculum_experiencia_cargo1`
    FOREIGN KEY (`cargo_id`)
    REFERENCES `descubra_muriae`.`cargo` (`cargo_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `descubra_muriae`.`curriculum_qualificacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `descubra_muriae`.`curriculum_qualificacao` (
  `curriculum_qualificacao_id` INT NOT NULL AUTO_INCREMENT,
  `curriculum_id` INT NOT NULL,
  `mes` INT NOT NULL,
  `ano` INT NOT NULL,
  `cargaHoraria` INT NOT NULL,
  `descricao` VARCHAR(60) NOT NULL,
  `estabelecimento` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`curriculum_qualificacao_id`),
  INDEX `fk_curriculum_qualificacao_curriculum1_idx` (`curriculum_id` ASC) VISIBLE,
  CONSTRAINT `fk_curriculum_qualificacao_curriculum1`
    FOREIGN KEY (`curriculum_id`)
    REFERENCES `descubra_muriae`.`curriculum` (`curriculum_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `descubra_muriae`.`vaga`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `descubra_muriae`.`vaga` (
  `vaga_id` INT NOT NULL AUTO_INCREMENT,
  `cargo_id` INT NOT NULL,
  `descricao` VARCHAR(60) NOT NULL,
  `sobreaVaga` TEXT NOT NULL,
  `modalidade` INT NOT NULL COMMENT '1=Presencial; 2=Remoto;',
  `vinculo` INT NOT NULL COMMENT '1=CLT; 2=Pessoa Jurídica;',
  `dtInicio` DATE NOT NULL,
  `dtFim` DATE NOT NULL,
  `estabelecimento_id` INT NOT NULL,
  `statusVaga` INT NOT NULL COMMENT '1=Pré Vaga; 11=Em aberto;91=Suspensa; 99=Finalizada;',
  PRIMARY KEY (`vaga_id`),
  INDEX `fk_vaga_cargo1_idx` (`cargo_id` ASC) VISIBLE,
  INDEX `fk_vaga_estabelecimento1_idx` (`estabelecimento_id` ASC) VISIBLE,
  CONSTRAINT `fk_vaga_cargo1`
    FOREIGN KEY (`cargo_id`)
    REFERENCES `descubra_muriae`.`cargo` (`cargo_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_vaga_estabelecimento1`
    FOREIGN KEY (`estabelecimento_id`)
    REFERENCES `descubra_muriae`.`estabelecimento` (`estabelecimento_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `descubra_muriae`.`vaga_curriculum`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `descubra_muriae`.`vaga_curriculum` (
  `vaga_id` INT NOT NULL,
  `curriculum_id` INT NOT NULL,
  `dateCandidatura` DATETIME NOT NULL,
  PRIMARY KEY (`vaga_id`, `curriculum_id`),
  INDEX `fk_vaga_has_curriculum_curriculum1_idx` (`curriculum_id` ASC) VISIBLE,
  INDEX `fk_vaga_has_curriculum_vaga1_idx` (`vaga_id` ASC) VISIBLE,
  CONSTRAINT `fk_vaga_has_curriculum_vaga1`
    FOREIGN KEY (`vaga_id`)
    REFERENCES `descubra_muriae`.`vaga` (`vaga_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_vaga_has_curriculum_curriculum1`
    FOREIGN KEY (`curriculum_id`)
    REFERENCES `descubra_muriae`.`curriculum` (`curriculum_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `descubra_muriae`.`termodeuso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `descubra_muriae`.`termodeuso` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `textoTermo` LONGTEXT NOT NULL,
  `statusRegistro` INT NOT NULL DEFAULT 1 COMMENT '1=Ativo;2=Inativo;3=Alterado',
  `rascunho` INT NULL DEFAULT 1 COMMENT '1=Sim; 2=Não',
  `usuario_id` INT NOT NULL,
  PRIMARY KEY (`usuario_id`),
  CONSTRAINT `fk_termodeuso_usuario1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `descubra_muriae`.`usuario` (`usuario_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `descubra_muriae`.`termodeusoaceite`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `descubra_muriae`.`termodeusoaceite` (
  `termodeuso_id` INT NOT NULL,
  `usuario_id` INT NOT NULL,
  `dataHoraAceite` DATETIME NOT NULL,
  PRIMARY KEY (`termodeuso_id`, `usuario_id`),
  INDEX `fk_termodeuso_has_usuario_usuario1_idx` (`usuario_id` ASC) VISIBLE,
  INDEX `fk_termodeuso_has_usuario_termodeuso1_idx` (`termodeuso_id` ASC) VISIBLE,
  CONSTRAINT `fk_termodeuso_has_usuario_termodeuso1`
    FOREIGN KEY (`termodeuso_id`)
    REFERENCES `descubra_muriae`.`termodeuso` (`usuario_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_termodeuso_has_usuario_usuario1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `descubra_muriae`.`usuario` (`usuario_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
