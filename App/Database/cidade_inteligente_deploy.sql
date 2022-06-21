-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema epiz_30694311_cidade_inteligente
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema epiz_30694311_cidade_inteligente
-- -----------------------------------------------------
CREATE DATABASE IF NOT EXISTS `epiz_30694311_cidade_inteligente` DEFAULT CHARACTER SET utf8 ;
USE `epiz_30694311_cidade_inteligente` ;

-- -----------------------------------------------------
-- Table `epiz_30694311_cidade_inteligente`.`areas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `epiz_30694311_cidade_inteligente`.`areas` (
  `id_area` INT NOT NULL AUTO_INCREMENT,
  `area` VARCHAR(10) NOT NULL,
  PRIMARY KEY (`id_area`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `epiz_30694311_cidade_inteligente`.`courses`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `epiz_30694311_cidade_inteligente`.`courses` (
  `id_course` INT NOT NULL AUTO_INCREMENT,
  `course` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_course`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `epiz_30694311_cidade_inteligente`.`projects`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `epiz_30694311_cidade_inteligente`.`projects` (
  `id_project` INT NOT NULL AUTO_INCREMENT,
  `id_area` INT NOT NULL,
  `id_course` INT NOT NULL,
  `title` VARCHAR(60) NOT NULL,
  `description` VARCHAR(300) NOT NULL,
  `date` DATE NOT NULL,
  PRIMARY KEY (`id_project`),
  INDEX `fk_projects_areas1_idx` (`id_area` ASC),
  INDEX `fk_projects_courses1_idx` (`id_course` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `epiz_30694311_cidade_inteligente`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `epiz_30694311_cidade_inteligente`.`users` (
  `id_user` INT NOT NULL AUTO_INCREMENT,
  `id_course` INT NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(60) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `type` TINYINT NOT NULL COMMENT '1 - Admin/Professor\n0 - Normal/Aluno',
  `token` CHAR(156) NULL,
  `token_expiration` DATETIME NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  INDEX `fk_users_courses1_idx` (`id_course` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `epiz_30694311_cidade_inteligente`.`medias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `epiz_30694311_cidade_inteligente`.`medias` (
  `id_media` INT NOT NULL AUTO_INCREMENT,
  `id_project` INT NOT NULL,
  `name` VARCHAR(60) NOT NULL,
  `type` VARCHAR(15) NOT NULL,
  `path` CHAR(28) NOT NULL,
  `description` VARCHAR(300) NOT NULL,
  PRIMARY KEY (`id_media`),
  INDEX `fk_medias_projects_idx` (`id_project` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `epiz_30694311_cidade_inteligente`.`projects_users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `epiz_30694311_cidade_inteligente`.`projects_users` (
  `id_project_user` INT NOT NULL AUTO_INCREMENT,
  `id_project` INT NOT NULL,
  `id_user` INT NOT NULL,
  PRIMARY KEY (`id_project_user`),
  INDEX `fk_projects_users_projects1_idx` (`id_project` ASC),
  INDEX `fk_projects_users_users1_idx` (`id_user` ASC))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


-- INSERTS
INSERT INTO courses (course) VALUES ("Análise e Desenvolvimento de Sistemas");
INSERT INTO courses (course) VALUES ("Gestão Empresarial");
INSERT INTO courses (course) VALUES ("Gestão da Produção Indústrial");
INSERT INTO courses (course) VALUES ("Gestão da Qualidade");
INSERT INTO courses (course) VALUES ("Logística");
INSERT INTO courses (course) VALUES ("Sistema para Internet");
INSERT INTO courses (course) VALUES ("Professor(a)");

INSERT INTO areas (area) VALUES ("Industrial");
INSERT INTO areas (area) VALUES ("Rural");
INSERT INTO areas (area) VALUES ("Urbana");

-- SENHA DO ADMINISTRADOR: 123
INSERT INTO users (id_course, name, email, password, type) VALUES (7, "Mário Guilherme", "marioguifatec2021@gmail.com", "$2y$10$amLSaXM/l4MJy.X8Pjnq7.3KBFOKyP9bKxyZfPQu3HXp4Lwhp63ZG", 1);