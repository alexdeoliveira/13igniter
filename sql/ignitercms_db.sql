SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `ignitercms` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `ignitercms` ;

-- -----------------------------------------------------
-- Table `ignitercms`.`groups`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `ignitercms`.`groups` (
  `id` MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(20) NOT NULL ,
  `description` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`id`) )
COMMENT = 'Tabela dos recursos do sistema';


-- -----------------------------------------------------
-- Table `ignitercms`.`users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `ignitercms`.`users` (
  `id` MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `ip_address` VARBINARY(16) NULL ,
  `username` VARCHAR(100) NOT NULL ,
  `password` VARCHAR(80) NOT NULL ,
  `salt` VARCHAR(40) NULL DEFAULT NULL ,
  `email` VARCHAR(100) NOT NULL ,
  `activation_code` VARCHAR(40) NULL DEFAULT NULL ,
  `forgotten_password_code` VARCHAR(40) NULL DEFAULT NULL ,
  `forgotten_password_time` INT(11) UNSIGNED NULL DEFAULT NULL ,
  `remember_code` VARCHAR(40) NULL DEFAULT NULL ,
  `created_on` INT(11) UNSIGNED NOT NULL ,
  `last_login` INT(11) UNSIGNED NULL DEFAULT NULL ,
  `active` TINYINT(1) UNSIGNED NULL DEFAULT NULL ,
  `first_name` VARCHAR(50) NULL DEFAULT NULL ,
  `last_name` VARCHAR(50) NULL DEFAULT NULL ,
  `company` VARCHAR(100) NULL DEFAULT NULL ,
  `phone` VARCHAR(20) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) );


-- -----------------------------------------------------
-- Table `ignitercms`.`login_attempts`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `ignitercms`.`login_attempts` (
  `id` MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `ip_address` VARBINARY(16) NOT NULL ,
  `login` VARCHAR(100) NOT NULL ,
  `time` INT(11) UNSIGNED NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) );


-- -----------------------------------------------------
-- Table `ignitercms`.`users_groups`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `ignitercms`.`users_groups` (
  `user_id` MEDIUMINT(8) UNSIGNED NOT NULL ,
  `group_id` MEDIUMINT(8) UNSIGNED NOT NULL ,
  `id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  PRIMARY KEY (`id`, `user_id`, `group_id`) ,
  INDEX `fk_users_groups_groups1_idx` (`group_id` ASC) ,
  INDEX `fk_users_groups_users_idx` (`user_id` ASC) ,
  CONSTRAINT `fk_users_groups_users`
    FOREIGN KEY (`user_id` )
    REFERENCES `ignitercms`.`users` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_users_groups_groups1`
    FOREIGN KEY (`group_id` )
    REFERENCES `ignitercms`.`groups` (`id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE);


-- -----------------------------------------------------
-- Table `ignitercms`.`imagem`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `ignitercms`.`imagem` (
  `id` MEDIUMINT NOT NULL AUTO_INCREMENT ,
  `src` VARCHAR(255) NOT NULL ,
  `alt` VARCHAR(255) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `ignitercms`.`groups`
-- -----------------------------------------------------
START TRANSACTION;
USE `ignitercms`;
INSERT INTO `ignitercms`.`groups` (`id`, `name`, `description`) VALUES (1, 'admin', 'Administrador');
INSERT INTO `ignitercms`.`groups` (`id`, `name`, `description`) VALUES (2, 'members', 'Usuário normal');

COMMIT;

-- -----------------------------------------------------
-- Data for table `ignitercms`.`users`
-- -----------------------------------------------------
START TRANSACTION;
USE `ignitercms`;
INSERT INTO `ignitercms`.`users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES (1, NULL, 'administrador', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'admin@example.com', NULL, NULL, NULL, NULL, 1268889823, 1268889823, 1, 'Admin', 'istrador', NULL, NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `ignitercms`.`users_groups`
-- -----------------------------------------------------
START TRANSACTION;
USE `ignitercms`;
INSERT INTO `ignitercms`.`users_groups` (`user_id`, `group_id`, `id`) VALUES (1, 1, 1);
INSERT INTO `ignitercms`.`users_groups` (`user_id`, `group_id`, `id`) VALUES (2, 1, 2);

COMMIT;
