CREATE  TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL ,
  `username` VARCHAR(45) NULL ,
  `password` VARCHAR(45) NULL ,
  `isAdmin` TINYINT NULL ,
  PRIMARY KEY (`id`) )
  ENGINE = InnoDB;


CREATE  TABLE IF NOT EXISTS `courses` (
  `id` INT NULL AUTO_INCREMENT ,
  `date` TIMESTAMP NULL ,
  `price` VARCHAR(45) NULL ,
  `totalSlots` INT NULL ,
  `freeSlots` INT NULL ,
  `title` VARCHAR(45) NULL ,
  `description` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
  ENGINE = InnoDB;


CREATE  TABLE IF NOT EXISTS `registrations` (
  `id` INT NULL AUTO_INCREMENT ,
  `courses_id` INT NOT NULL ,
  `users_id` INT NOT NULL ,
  PRIMARY KEY (`id`, `courses_id`, `users_id`) ,
  INDEX `fk_registrations_courses` (`courses_id` ASC) ,
  INDEX `fk_registrations_users1` (`users_id` ASC) ,
  CONSTRAINT `fk_registrations_courses`
  FOREIGN KEY (`courses_id` )
  REFERENCES `courses` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_registrations_users1`
  FOREIGN KEY (`users_id` )
  REFERENCES `users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB;