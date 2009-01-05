SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `mymunin` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `mymunin`;

-- -----------------------------------------------------
-- Table `mymunin`.`server_category`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mymunin`.`server_category` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mymunin`.`servers`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mymunin`.`servers` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `server_category` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX server_category (`server_category` ASC) ,
  CONSTRAINT `server_category`
    FOREIGN KEY (`server_category` )
    REFERENCES `mymunin`.`server_category` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mymunin`.`services`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mymunin`.`services` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `title` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mymunin`.`graphtype`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mymunin`.`graphtype` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mymunin`.`profiles`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mymunin`.`profiles` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mymunin`.`server_service`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mymunin`.`server_service` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `server` INT NOT NULL ,
  `service` INT NOT NULL ,
  `graphtype` INT NOT NULL ,
  INDEX server_id (`server` ASC) ,
  INDEX services_id (`service` ASC) ,
  INDEX graphtype_id (`graphtype` ASC) ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX graph (`server` ASC, `service` ASC, `graphtype` ASC) ,
  CONSTRAINT `server_id`
    FOREIGN KEY (`server` )
    REFERENCES `mymunin`.`servers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `services_id`
    FOREIGN KEY (`service` )
    REFERENCES `mymunin`.`services` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `graphtype_id`
    FOREIGN KEY (`graphtype` )
    REFERENCES `mymunin`.`graphtype` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mymunin`.`service_profile`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mymunin`.`service_profile` (
  `profile` INT NOT NULL ,
  `service` INT NOT NULL ,
  `row` INT NOT NULL ,
  `column` INT NOT NULL ,
  INDEX profileFK (`profile` ASC) ,
  INDEX serviceFK (`service` ASC) ,
  PRIMARY KEY (`profile`, `service`) ,
  UNIQUE INDEX unique (`profile` ASC, `row` ASC, `column` ASC) ,
  CONSTRAINT `profileFK`
    FOREIGN KEY (`profile` )
    REFERENCES `mymunin`.`profiles` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `serviceFK`
    FOREIGN KEY (`service` )
    REFERENCES `mymunin`.`server_service` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Placeholder table for view `mymunin`.`v_collect`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mymunin`.`v_collect` (`id` INT);

-- -----------------------------------------------------
-- View `mymunin`.`v_collect`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mymunin`.`v_collect`;
CREATE OR REPLACE  VIEW `mymunin`.`v_collect` AS
select 
 server_category.name as category,
 servers.name as server,
 services.name as service,
 services.title as service_title,
 graphtype.name as graphtype,
 server_service.column as 'column',
 server_service.row as 'row',
 profiles.name as profile
from 
 server_service,
 servers,
 services,
 graphtype,
 server_category,
 service_profile,
 profiles
where
 server_service.server = servers.id
and
 server_service.service = services.id
and 
 server_service.graphtype = graphtype.id
and
 servers.server_category = server_category.id
and
 service_profile.service = server_service.id
and
 service_profile.profile = profiles.id
order by
 server_service.row,
 server_service.column;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
