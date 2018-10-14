SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE TABLE IF NOT EXISTS `session` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NULL,
  `ip` VARCHAR(255) NOT NULL,
  `browser` VARCHAR(255) NULL,
  `viewport_width` CHAR(3) NULL,
  `orientation` VARCHAR(255) NULL,
  `updated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `action` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `type` ENUM('click', 'hover', 'check') NULL,
  `session_id` INT NOT NULL,
  `value` TEXT NULL,
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `referer` VARCHAR(400) NULL,
  `domain_origin` VARCHAR(200) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_action_session_idx` (`session_id` ASC),
  INDEX `refereedomain` (`referer` ASC, `domain_origin` ASC),
  INDEX `domainee` (`domain_origin` ASC),
  INDEX `actiontype` (`type` ASC),
  INDEX `actiontyperefereedomain` (`type` ASC, `referer` ASC, `domain_origin` ASC),
  INDEX `actiontypedomain` (`type` ASC, `domain_origin` ASC),
  CONSTRAINT `fk_action_session`
    FOREIGN KEY (`session_id`)
    REFERENCES `session` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
