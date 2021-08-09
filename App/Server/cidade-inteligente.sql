-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema cidade-inteligente
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema cidade-inteligente
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `cidade-inteligente` DEFAULT CHARACTER SET utf8 ;
USE `cidade-inteligente` ;

-- -----------------------------------------------------
-- Table `cidade-inteligente`.`areas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cidade-inteligente`.`areas` (
  `id_area` INT NOT NULL AUTO_INCREMENT,
  `descricao` TEXT NOT NULL,
  PRIMARY KEY (`id_area`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cidade-inteligente`.`cursos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cidade-inteligente`.`cursos` (
  `id_curso` INT NOT NULL AUTO_INCREMENT,
  `curso` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_curso`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cidade-inteligente`.`projetos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cidade-inteligente`.`projetos` (
  `id_projeto` INT NOT NULL AUTO_INCREMENT,
  `id_area` INT NOT NULL,
  `id_curso` INT NOT NULL,
  `descricao_geral` TEXT NOT NULL,
  `descricao_detalhe` TEXT NOT NULL,
  `data` DATE NOT NULL,
  PRIMARY KEY (`id_projeto`),
  INDEX `fk_projeto_area_idx` (`id_area` ASC),
  INDEX `fk_projetos_cursos1_idx` (`id_curso` ASC),
  CONSTRAINT `fk_projeto_area`
    FOREIGN KEY (`id_area`)
    REFERENCES `cidade-inteligente`.`areas` (`id_area`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_projetos_cursos1`
    FOREIGN KEY (`id_curso`)
    REFERENCES `cidade-inteligente`.`cursos` (`id_curso`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cidade-inteligente`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cidade-inteligente`.`usuarios` (
  `id_usuario` INT NOT NULL AUTO_INCREMENT,
  `id_curso` INT NOT NULL,
  `nome` VARCHAR(100) NOT NULL,
  `email` VARCHAR(55) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  `tipo` VARCHAR(12) NOT NULL,
  `nivel` VARCHAR(40) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  INDEX `fk_usuarios_cursos1_idx` (`id_curso` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  CONSTRAINT `fk_usuarios_cursos1`
    FOREIGN KEY (`id_curso`)
    REFERENCES `cidade-inteligente`.`cursos` (`id_curso`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cidade-inteligente`.`projeto_usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cidade-inteligente`.`projeto_usuario` (
  `id_projeto` INT NOT NULL,
  `id_usuario` INT NOT NULL,
  INDEX `fk_projeto_has_usuario_usuario1_idx` (`id_usuario` ASC),
  INDEX `fk_projeto_has_usuario_projeto1_idx` (`id_projeto` ASC),
  CONSTRAINT `fk_projeto_has_usuario_projeto1`
    FOREIGN KEY (`id_projeto`)
    REFERENCES `cidade-inteligente`.`projetos` (`id_projeto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_projeto_has_usuario_usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `cidade-inteligente`.`usuarios` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cidade-inteligente`.`midias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cidade-inteligente`.`midias` (
  `id_midia` INT NOT NULL AUTO_INCREMENT,
  `id_projeto` INT NOT NULL,
  `nome` VARCHAR(100) NOT NULL,
  `tipo` CHAR(5) NOT NULL,
  `path` CHAR(27) NOT NULL,
  `descricao` TEXT NOT NULL,
  PRIMARY KEY (`id_midia`),
  INDEX `fk_midia_projeto1_idx` (`id_projeto` ASC),
  CONSTRAINT `fk_midia_projeto1`
    FOREIGN KEY (`id_projeto`)
    REFERENCES `cidade-inteligente`.`projetos` (`id_projeto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;