-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema sistemahx
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema sistemahx
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `sistemahx` DEFAULT CHARACTER SET utf8 ;
USE `sistemahx` ;

-- -----------------------------------------------------
-- Table `sistemahx`.`roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistemahx`.`roles` (
  `id` INT NOT NULL,
  `role` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sistemahx`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistemahx`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `username` VARCHAR(45) NOT NULL,
  `password` CHAR(128) NOT NULL,
  `salt` CHAR(128) NOT NULL,
  `status` INT(1) NOT NULL DEFAULT 1,
  `role_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `users_role_id_idx` (`role_id` ASC),
  CONSTRAINT `users_role_id`
    FOREIGN KEY (`role_id`)
    REFERENCES `sistemahx`.`roles` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sistemahx`.`login_attempts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistemahx`.`login_attempts` (
  `id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`, `user_id`),
  INDEX `login_attempsts_user_id_idx` (`user_id` ASC),
  CONSTRAINT `login_attempsts_user_id`
    FOREIGN KEY (`user_id`)
    REFERENCES `sistemahx`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sistemahx`.`recoveries`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistemahx`.`recoveries` (
  `id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `status` INT(1) GENERATED ALWAYS AS (0) VIRTUAL,
  PRIMARY KEY (`id`, `user_id`),
  INDEX `recoveries_user_id_idx` (`user_id` ASC),
  CONSTRAINT `passwords_user_id`
    FOREIGN KEY (`user_id`)
    REFERENCES `sistemahx`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
