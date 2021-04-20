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
-- Table `cidade-inteligente`.`area`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cidade-inteligente`.`area` (
  `id_area` INT NOT NULL,
  `descricao` LONGTEXT NOT NULL,
  PRIMARY KEY (`id_area`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cidade-inteligente`.`projeto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cidade-inteligente`.`projeto` (
  `id_projeto` INT NOT NULL AUTO_INCREMENT,
  `id_area` INT NOT NULL,
  `descricao_geral` MEDIUMTEXT NOT NULL,
  `descricao_detalhe` LONGTEXT NOT NULL,
  `data` DATE NOT NULL,
  PRIMARY KEY (`id_projeto`),
  INDEX `fk_projeto_area_idx` (`id_area` ASC),
  CONSTRAINT `fk_projeto_area`
    FOREIGN KEY (`id_area`)
    REFERENCES `cidade-inteligente`.`area` (`id_area`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cidade-inteligente`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cidade-inteligente`.`usuario` (
  `id_usuario` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `email` VARCHAR(55) NOT NULL,
  `senha` VARCHAR(55) NOT NULL,
  `tipo` CHAR(5) NOT NULL,
  `nivel` VARCHAR(40) NOT NULL,
  PRIMARY KEY (`id_usuario`))
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
    REFERENCES `cidade-inteligente`.`projeto` (`id_projeto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_projeto_has_usuario_usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `cidade-inteligente`.`usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cidade-inteligente`.`midia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cidade-inteligente`.`midia` (
  `id_midia` INT NOT NULL AUTO_INCREMENT,
  `id_projeto` INT NOT NULL,
  `nome` VARCHAR(100) NOT NULL,
  `tipo` CHAR(5) NOT NULL,
  `path` LONGBLOB NOT NULL,
  `descricao` LONGTEXT NOT NULL,
  PRIMARY KEY (`id_midia`),
  INDEX `fk_midia_projeto1_idx` (`id_projeto` ASC),
  CONSTRAINT `fk_midia_projeto1`
    FOREIGN KEY (`id_projeto`)
    REFERENCES `cidade-inteligente`.`projeto` (`id_projeto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;