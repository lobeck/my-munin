SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `mymunin` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `mymunin`;

-- -----------------------------------------------------
-- Table `mymunin`.`domain`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mymunin`.`domain` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mymunin`.`host`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mymunin`.`host` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `domainID` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `server_category` (`domainID` ASC) ,
  CONSTRAINT `server_category`
    FOREIGN KEY (`domainID` )
    REFERENCES `mymunin`.`domain` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mymunin`.`service`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mymunin`.`service` (
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
-- Table `mymunin`.`profile`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mymunin`.`profile` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `baseURL` VARCHAR(80) NOT NULL ,
  `width` INT NOT NULL DEFAULT 1024 ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mymunin`.`node`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mymunin`.`node` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `hostID` INT NOT NULL ,
  `serviceID` INT NOT NULL ,
  `graphtypeID` INT NOT NULL ,
  INDEX `server_id` (`hostID` ASC) ,
  INDEX `services_id` (`serviceID` ASC) ,
  INDEX `graphtype_id` (`graphtypeID` ASC) ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `graph` (`hostID` ASC, `serviceID` ASC, `graphtypeID` ASC) ,
  CONSTRAINT `server_id`
    FOREIGN KEY (`hostID` )
    REFERENCES `mymunin`.`host` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `services_id`
    FOREIGN KEY (`serviceID` )
    REFERENCES `mymunin`.`service` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `graphtype_id`
    FOREIGN KEY (`graphtypeID` )
    REFERENCES `mymunin`.`graphtype` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mymunin`.`position`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mymunin`.`position` (
  `profileID` INT NOT NULL ,
  `nodeID` INT NOT NULL ,
  `order` INT NOT NULL ,
  INDEX `profileFK` (`profileID` ASC) ,
  INDEX `serviceFK` (`nodeID` ASC) ,
  PRIMARY KEY (`profileID`, `nodeID`) ,
  UNIQUE INDEX `unique` (`profileID` ASC, `order` ASC) ,
  CONSTRAINT `profileFK`
    FOREIGN KEY (`profileID` )
    REFERENCES `mymunin`.`profile` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `serviceFK`
    FOREIGN KEY (`nodeID` )
    REFERENCES `mymunin`.`node` (`id` )
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
CREATE  OR REPLACE VIEW `mymunin`.`v_collect` AS
select
 domain.name as domain,
 host.name as host,
 service.name as service,
 service.title as service_title,
 graphtype.name as graphtype,
 position.profileID as profileID,
 node.id as nodeID,
 position.order as 'order'
from
 position,
 node,
 service,
 host,
 domain,
 graphtype
where
 position.nodeID = node.id
and
 node.serviceID = service.id
and
 node.graphtypeID = graphtype.id
and 
 node.hostID = host.id
and 
 host.domainID = domain.id
order by
 position.order;
USE `mymunin`;

-- -----------------------------------------------------
-- Data for table `mymunin`.`graphtype`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
INSERT INTO `graphtype` (`id`, `name`) VALUES (1, 'day');
INSERT INTO `graphtype` (`id`, `name`) VALUES (2, 'week');
INSERT INTO `graphtype` (`id`, `name`) VALUES (3, 'month');
INSERT INTO `graphtype` (`id`, `name`) VALUES (4, 'year');

COMMIT;

-- -----------------------------------------------------
-- Data for table `mymunin`.`profile`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
INSERT INTO `profile` (`id`, `name`, `baseURL`, `width`) VALUES (1, 'default', 'http://example.org/munin/', );

COMMIT;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
