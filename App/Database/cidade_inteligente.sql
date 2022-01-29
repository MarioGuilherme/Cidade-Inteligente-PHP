CREATE TABLE IF NOT EXISTS `cidade_inteligente`.`projects` (
  `id_project` INT NOT NULL AUTO_INCREMENT,
  `id_area` INT NOT NULL,
  `id_course` INT NOT NULL,
  `title` VARCHAR(60) NOT NULL,
  `description` VARCHAR(300) NOT NULL,
  `date` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id_project`),
  INDEX `fk_projects_areas1_idx` (`id_area` ASC),
  INDEX `fk_projects_courses1_idx` (`id_course` ASC),
  CONSTRAINT `fk_projects_areas1`
    FOREIGN KEY (`id_area`)
    REFERENCES `cidade_inteligente`.`areas` (`id_area`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_projects_courses1`
    FOREIGN KEY (`id_course`)
    REFERENCES `cidade_inteligente`.`courses` (`id_course`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `cidade_inteligente`.`users` (
  `id_user` INT NOT NULL AUTO_INCREMENT,
  `id_course` INT NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(60) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `type` VARCHAR(12) NOT NULL,
  `token` CHAR(156) NULL,
  `token_expiration` DATETIME NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  INDEX `fk_users_courses1_idx` (`id_course` ASC),
  CONSTRAINT `fk_users_courses1`
    FOREIGN KEY (`id_course`)
    REFERENCES `cidade_inteligente`.`courses` (`id_course`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `cidade_inteligente`.`medias` (
  `id_media` INT NOT NULL AUTO_INCREMENT,
  `id_project` INT NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `type` VARCHAR(15) NOT NULL,
  `path` CHAR(28) NOT NULL,
  `description` VARCHAR(300) NOT NULL,
  PRIMARY KEY (`id_media`),
  INDEX `fk_medias_projects_idx` (`id_project` ASC),
  CONSTRAINT `fk_medias_projects`
    FOREIGN KEY (`id_project`)
    REFERENCES `cidade_inteligente`.`projects` (`id_project`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `cidade_inteligente`.`projects_users` (
  `id_project` INT NOT NULL,
  `id_user` INT NOT NULL,
  INDEX `fk_projects_has_users_users1_idx` (`id_user` ASC),
  INDEX `fk_projects_has_users_projects1_idx` (`id_project` ASC),
  CONSTRAINT `fk_projects_has_users_projects1`
    FOREIGN KEY (`id_project`)
    REFERENCES `cidade_inteligente`.`projects` (`id_project`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_projects_has_users_users1`
    FOREIGN KEY (`id_user`)
    REFERENCES `cidade_inteligente`.`users` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;