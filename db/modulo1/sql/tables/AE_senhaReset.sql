CREATE TABLE IF NOT EXISTS `AE_senhaReset` (
  `AA_id` INT NOT NULL,
  `AE_selector` TEXT NOT NULL,
  `AE_token` LONGTEXT NOT NULL,
  `AE_expires` TEXT NOT NULL,
  PRIMARY KEY (`AA_id`),
  CONSTRAINT `fk_AE_senhaReset_AA_pessoa1`
    FOREIGN KEY (`AA_id`)
    REFERENCES `AA_pessoa` (`AA_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB