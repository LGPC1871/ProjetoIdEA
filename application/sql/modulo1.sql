-- MySQL Script generated by MySQL Workbench
-- Thu May 21 22:35:39 2020
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema cl16293
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema cl16293
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `cl16293` DEFAULT CHARACTER SET utf8 ;
USE `cl16293` ;

-- -----------------------------------------------------
-- Table `cl16293`.`AD_privilegios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cl16293`.`AD_privilegios` ;

CREATE TABLE IF NOT EXISTS `cl16293`.`AD_privilegios` (
  `AD_id` INT NOT NULL AUTO_INCREMENT,
  `AD_nome` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`AD_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cl16293`.`AA_pessoa`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cl16293`.`AA_pessoa` ;

CREATE TABLE IF NOT EXISTS `cl16293`.`AA_pessoa` (
  `AA_id` INT NOT NULL AUTO_INCREMENT,
  `AA_email` VARCHAR(50) NOT NULL,
  `AA_nomeCompleto` VARCHAR(255) NOT NULL,
  `AA_nome` VARCHAR(100) NOT NULL,
  `AA_sobrenome` VARCHAR(155) NOT NULL,
  `AA_senha` VARCHAR(255) NULL DEFAULT NULL,
  `AA_created` DATETIME NOT NULL,
  `AA_updated` DATETIME NOT NULL,
  `AD_id` INT NOT NULL DEFAULT 3,
  PRIMARY KEY (`AA_id`),
  UNIQUE INDEX `AA_email_UNIQUE` (`AA_email` ASC) ,
  INDEX `fk_AA_pessoa_AD_privilegios1_idx` (`AD_id` ASC) ,
  CONSTRAINT `fk_AA_pessoa_AD_privilegios1`
    FOREIGN KEY (`AD_id`)
    REFERENCES `cl16293`.`AD_privilegios` (`AD_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cl16293`.`AC_terceiro`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cl16293`.`AC_terceiro` ;

CREATE TABLE IF NOT EXISTS `cl16293`.`AC_terceiro` (
  `AC_id` INT NOT NULL AUTO_INCREMENT,
  `AC_nome` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`AC_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cl16293`.`AB_pessoaTerceiro`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cl16293`.`AB_pessoaTerceiro` ;

CREATE TABLE IF NOT EXISTS `cl16293`.`AB_pessoaTerceiro` (
  `AA_id` INT NOT NULL,
  `AC_id` INT NOT NULL,
  `AB_pessoaTerceiroId` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`AA_id`, `AC_id`),
  INDEX `fk_AB_pessoaTerceiro_AA_pessoa_idx` (`AA_id` ASC) ,
  INDEX `fk_AB_pessoaTerceiro_AC_terceiro1_idx` (`AC_id` ASC) ,
  CONSTRAINT `fk_AB_pessoaTerceiro_AA_pessoa`
    FOREIGN KEY (`AA_id`)
    REFERENCES `cl16293`.`AA_pessoa` (`AA_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_AB_pessoaTerceiro_AC_terceiro1`
    FOREIGN KEY (`AC_id`)
    REFERENCES `cl16293`.`AC_terceiro` (`AC_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cl16293`.`AE_senhaReset`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cl16293`.`AE_senhaReset` ;

CREATE TABLE IF NOT EXISTS `cl16293`.`AE_senhaReset` (
  `AA_id` INT NOT NULL,
  `AE_selector` TEXT NOT NULL,
  `AE_token` LONGTEXT NOT NULL,
  `AE_expires` TEXT NOT NULL,
  PRIMARY KEY (`AA_id`),
  CONSTRAINT `fk_AE_senhaReset_AA_pessoa1`
    FOREIGN KEY (`AA_id`)
    REFERENCES `cl16293`.`AA_pessoa` (`AA_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
