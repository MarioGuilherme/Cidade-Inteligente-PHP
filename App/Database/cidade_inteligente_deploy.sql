-- -----------------------------------------------------
-- Table `id19357226_cidade_inteligente`.`areas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `id19357226_cidade_inteligente`.`areas` (
  `id_area` INT NOT NULL AUTO_INCREMENT,
  `area` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_area`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `id19357226_cidade_inteligente`.`courses`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `id19357226_cidade_inteligente`.`courses` (
  `id_course` INT NOT NULL AUTO_INCREMENT,
  `course` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_course`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `id19357226_cidade_inteligente`.`projects`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `id19357226_cidade_inteligente`.`projects` (
  `id_project` INT NOT NULL AUTO_INCREMENT,
  `id_area` INT NOT NULL,
  `id_course` INT NOT NULL,
  `title` VARCHAR(120) NOT NULL,
  `description` VARCHAR(800) NOT NULL,
  `registeredDate` DATE NOT NULL DEFAULT NOW(),
  `startDate` DATE NOT NULL,
  `endDate` DATE NOT NULL,
  PRIMARY KEY (`id_project`),
  INDEX `fk_projects_areas1_idx` (`id_area` ASC),
  INDEX `fk_projects_courses1_idx` (`id_course` ASC),
  CONSTRAINT `fk_projects_areas1`
    FOREIGN KEY (`id_area`)
    REFERENCES `id19357226_cidade_inteligente`.`areas` (`id_area`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_projects_courses1`
    FOREIGN KEY (`id_course`)
    REFERENCES `id19357226_cidade_inteligente`.`courses` (`id_course`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `id19357226_cidade_inteligente`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `id19357226_cidade_inteligente`.`users` (
  `id_user` INT NOT NULL AUTO_INCREMENT,
  `id_course` INT NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(60) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `isAdmin` TINYINT(1) NOT NULL,
  `token` CHAR(156) NULL,
  `token_expiration` DATETIME NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  INDEX `fk_users_courses1_idx` (`id_course` ASC),
  CONSTRAINT `fk_users_courses1`
    FOREIGN KEY (`id_course`)
    REFERENCES `id19357226_cidade_inteligente`.`courses` (`id_course`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `id19357226_cidade_inteligente`.`medias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `id19357226_cidade_inteligente`.`medias` (
  `id_media` INT NOT NULL AUTO_INCREMENT,
  `id_project` INT NOT NULL,
  `name` VARCHAR(60) NOT NULL,
  `type` VARCHAR(15) NOT NULL,
  `size` INT NOT NULL,
  `fileName` VARCHAR(28) NOT NULL,
  `description` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`id_media`),
  INDEX `fk_medias_projects_idx` (`id_project` ASC),
  CONSTRAINT `fk_medias_projects`
    FOREIGN KEY (`id_project`)
    REFERENCES `id19357226_cidade_inteligente`.`projects` (`id_project`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `id19357226_cidade_inteligente`.`projects_users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `id19357226_cidade_inteligente`.`projects_users` (
  `id_project` INT NOT NULL,
  `id_user` INT NOT NULL,
  INDEX `fk_projects_users_projects1_idx` (`id_project` ASC),
  INDEX `fk_projects_users_users1_idx` (`id_user` ASC),
  CONSTRAINT `fk_projects_users_projects1`
    FOREIGN KEY (`id_project`)
    REFERENCES `id19357226_cidade_inteligente`.`projects` (`id_project`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_projects_users_users1`
    FOREIGN KEY (`id_user`)
    REFERENCES `id19357226_cidade_inteligente`.`users` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- INSERTS
INSERT INTO courses (course) VALUES ("Análise e Desenvolvimento de Sistemas");
INSERT INTO courses (course) VALUES ("Gestão Empresarial");
INSERT INTO courses (course) VALUES ("Gestão da Produção Indústrial");
INSERT INTO courses (course) VALUES ("Gestão da Qualidade");
INSERT INTO courses (course) VALUES ("Logística");
INSERT INTO courses (course) VALUES ("Sistema para Internet");

INSERT INTO areas (area) VALUES ("Industrial");
INSERT INTO areas (area) VALUES ("Rural");
INSERT INTO areas (area) VALUES ("Urbana");

INSERT INTO users (id_course, name, email, password, isAdmin) VALUES (1, "João Luís Cardoso Moraes", "joao.lcmoraes@fatec.sp.gov.br", "$2y$10$fMkd.xanCkLQpsCBnyH8Ee0/OEe.rFS9B2yDbevHRZ7g1gaUARp52", 1);