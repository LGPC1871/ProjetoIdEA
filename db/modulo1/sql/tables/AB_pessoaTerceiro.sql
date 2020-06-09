CREATE TABLE IF NOT EXISTS `AB_pessoaTerceiro` (
  `AA_id` INT NOT NULL,
  `AC_id` INT NOT NULL,
  `AB_pessoaTerceiroId` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`AA_id`, `AC_id`),
  INDEX `fk_AB_pessoaTerceiro_AA_pessoa_idx` (`AA_id` ASC) VISIBLE,
  INDEX `fk_AB_pessoaTerceiro_AC_terceiro1_idx` (`AC_id` ASC) VISIBLE,
  CONSTRAINT `fk_AB_pessoaTerceiro_AA_pessoa`
    FOREIGN KEY (`AA_id`)
    REFERENCES `mydb`.`AA_pessoa` (`AA_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_AB_pessoaTerceiro_AC_terceiro1`
    FOREIGN KEY (`AC_id`)
    REFERENCES `mydb`.`AC_terceiro` (`AC_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB