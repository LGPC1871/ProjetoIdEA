-- MySQL Script generated by MySQL Workbench
-- Wed Jun 10 19:24:12 2020
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema idea
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `idea` ;

-- -----------------------------------------------------
-- Schema idea
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `idea` DEFAULT CHARACTER SET utf8 ;
USE `idea` ;

-- -----------------------------------------------------
-- Table `idea`.`privilegio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `idea`.`privilegio` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `idea`.`pessoa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `idea`.`pessoa` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(50) NOT NULL,
  `nome_completo` VARCHAR(255) NOT NULL,
  `nome` VARCHAR(100) NOT NULL,
  `sobrenome` VARCHAR(155) NOT NULL,
  `senha` VARCHAR(255) NULL DEFAULT NULL,
  `created` DATETIME NOT NULL,
  `updated` DATETIME NOT NULL,
  `privilegio_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `AA_email_UNIQUE` (`email` ASC) VISIBLE,
  INDEX `fk_pessoa_privilegio1_idx` (`privilegio_id` ASC) VISIBLE,
  CONSTRAINT `fk_pessoa_privilegio1`
    FOREIGN KEY (`privilegio_id`)
    REFERENCES `idea`.`privilegio` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `idea`.`terceiro`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `idea`.`terceiro` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `idea`.`pessoa_terceiro`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `idea`.`pessoa_terceiro` (
  `terceiro_id` INT NOT NULL,
  `pessoa_id` INT NOT NULL,
  `id_pessoa_terceiro` TEXT NOT NULL,
  PRIMARY KEY (`terceiro_id`, `pessoa_id`),
  INDEX `fk_pessoa_terceiro_pessoa1_idx` (`pessoa_id` ASC) VISIBLE,
  CONSTRAINT `fk_pessoa_terceiro_terceiro`
    FOREIGN KEY (`terceiro_id`)
    REFERENCES `idea`.`terceiro` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pessoa_terceiro_pessoa1`
    FOREIGN KEY (`pessoa_id`)
    REFERENCES `idea`.`pessoa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Start Insert
-- -----------------------------------------------------

INSERT INTO `idea`.`terceiro` (`nome`) VALUES ('google');
INSERT INTO `idea`.`privilegio` (`nome`) VALUES ('admin');
INSERT INTO `idea`.`privilegio` (`nome`) VALUES ('palestrante');
INSERT INTO `idea`.`privilegio` (`nome`) VALUES ('participante');