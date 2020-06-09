CREATE TABLE IF NOT EXISTS `AA_pessoa` (
  `AA_id` INT NOT NULL AUTO_INCREMENT,
  `AA_email` VARCHAR(50) NOT NULL,
  `AA_nomeCompleto` VARCHAR(255) NOT NULL,
  `AA_nome` VARCHAR(100) NOT NULL,
  `AA_sobrenome` VARCHAR(155) NOT NULL,
  `AA_senha` VARCHAR(255) NULL,
  `AA_created` DATETIME NOT NULL,
  `AA_updated` DATETIME NOT NULL,
  `AD_id` INT NOT NULL,
  PRIMARY KEY (`AA_id`),
  UNIQUE INDEX `AA_email_UNIQUE` (`AA_email` ASC) VISIBLE,
  INDEX `fk_AA_pessoa_AD_privilegios1_idx` (`AD_id` ASC) VISIBLE,
  CONSTRAINT `fk_AA_pessoa_AD_privilegios1`
    FOREIGN KEY (`AD_id`)
    REFERENCES `mydb`.`AD_privilegios` (`AD_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB