-- MySQL Script generated by MySQL Workbench
-- Fri Apr 24 15:09:01 2020
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
-- Table `cl16293`.`AA_pessoa`
-- -----------------------------------------------------
CREATE TABLE `AA_pessoa` (
  `AA_userId` int(11) NOT NULL AUTO_INCREMENT,
  `AA_googleId` varchar(50) DEFAULT NULL,
  `AA_email` varchar(255) NOT NULL,
  `AA_fullName` varchar(255) NOT NULL,
  `AA_firstName` varchar(100) DEFAULT NULL,
  `AA_lastName` varchar(155) DEFAULT NULL,
  `AA_password` varchar(255) DEFAULT NULL,
  `AA_picture` varchar(255) DEFAULT NULL,
  `AA_created` datetime NOT NULL,
  `AA_updated` datetime NOT NULL,
  PRIMARY KEY (`AA_userId`),
  UNIQUE KEY `AA_email_UNIQUE` (`AA_email`),
  UNIQUE KEY `AA_googleId_UNIQUE` (`AA_googleId`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;


-- -----------------------------------------------------
-- Table `cl16293`.`AB_admin`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cl16293`.`AB_admin` (
  `AB_id` INT NOT NULL AUTO_INCREMENT,
  `AA_id` INT NOT NULL,
  PRIMARY KEY (`AB_id`, `AA_id`),
  INDEX `fk_AB_admin_AA_pessoa_idx` (`AA_id` ASC),
  CONSTRAINT `fk_AB_admin_AA_pessoa`
    FOREIGN KEY (`AA_id`)
    REFERENCES `cl16293`.`AA_pessoa` (`AA_userId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cl16293`.`AC_palestrante`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cl16293`.`AC_palestrante` (
  `AC_id` INT NOT NULL AUTO_INCREMENT,
  `AA_id` INT NOT NULL,
  PRIMARY KEY (`AC_id`, `AA_id`),
  INDEX `fk_AC_palestrante_AA_pessoa1_idx` (`AA_id` ASC),
  CONSTRAINT `fk_AC_palestrante_AA_pessoa1`
    FOREIGN KEY (`AA_id`)
    REFERENCES `cl16293`.`AA_pessoa` (`AA_userId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cl16293`.`AD_participante`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cl16293`.`AD_participante` (
  `AD_id` INT NOT NULL AUTO_INCREMENT,
  `AA_id` INT NOT NULL,
  PRIMARY KEY (`AD_id`, `AA_id`),
  INDEX `fk_AD_participante_AA_pessoa1_idx` (`AA_id` ASC),
  CONSTRAINT `fk_AD_participante_AA_pessoa1`
    FOREIGN KEY (`AA_id`)
    REFERENCES `cl16293`.`AA_pessoa` (`AA_userId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
