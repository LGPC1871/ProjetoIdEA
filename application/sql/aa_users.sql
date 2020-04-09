CREATE TABLE `aa_users` (
  `AA_id` int NOT NULL AUTO_INCREMENT,
  `AA_username` varchar(45) NOT NULL,
  `AA_password` varchar(255) NOT NULL,
  PRIMARY KEY (`AA_id`),
  UNIQUE KEY `A_userName_UNIQUE` (`AA_username`)
)