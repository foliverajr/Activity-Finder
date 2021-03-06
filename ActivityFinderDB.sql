-- MySQL Script generated by MySQL Workbench
-- Fri Jun 28 17:13:33 2019
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering
DROP DATABASE IF EXISTS ActivityFinderDB;
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema ActivityFinderDB
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema ActivityFinderDB
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `ActivityFinderDB` DEFAULT CHARACTER SET utf8 ;
USE `ActivityFinderDB` ;

-- -----------------------------------------------------
-- Table `ActivityFinderDB`.`Users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ActivityFinderDB`.`Users` ;

CREATE TABLE IF NOT EXISTS `ActivityFinderDB`.`Users` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `contact_name` VARCHAR(45) NOT NULL,
  `username` VARCHAR(20) NOT NULL,
  `password` VARCHAR(12) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `dob` DATE NULL,
  `phone_number` VARCHAR(14) NOT NULL,
  `address` VARCHAR(45) NOT NULL,
  `description` VARCHAR(170) NULL,
  `profile_name` VARCHAR(20) NULL,
  `profile_location` VARCHAR(170) NULL,
  `profile_contact_info` VARCHAR(170) NULL,
  PRIMARY KEY (`user_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ActivityFinderDB`.`Event_Enrollment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ActivityFinderDB`.`Event_Enrollment` ;

CREATE TABLE IF NOT EXISTS `ActivityFinderDB`.`Event_Enrollment` (
  `record_id` INT AUTO_INCREMENT NOT NULL, 
  `user_id` INT NOT NULL,
  `event_id` INT NOT NULL,
  PRIMARY KEY (`record_id`),
  CONSTRAINT `fk_user_id`
    FOREIGN KEY (`user_id`)
    REFERENCES `ActivityFinderDB`.`Users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ActivityFinderDB`.`User_Hobbies`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ActivityFinderDB`.`User_Interests` ;

CREATE TABLE IF NOT EXISTS `ActivityFinderDB`.`User_Interests` (
  `record_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `interest` VARCHAR(50) NOT NULL,
  CONSTRAINT `fk2_user_id`
    FOREIGN KEY (`user_id`)
    REFERENCES `ActivityFinderDB`.`Users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ActivityFinderDB`.`Markers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ActivityFinderDB`.`Markers` ;

CREATE TABLE IF NOT EXISTS `ActivityFinderDB`.`Markers` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR( 60 ) NOT NULL ,
  `address` VARCHAR( 80 ) NOT NULL ,
  `lat` FLOAT( 10, 6 ) NOT NULL ,
  `lng` FLOAT( 10, 6 ) NOT NULL ,
  `description` VARCHAR(400) NOT NULL,
  `date` DATE NOT NULL,
  `start_time` TIME NOT NULL,
  `end_time` TIME NULL,
  `tags` VARCHAR(100) NULL,
  `creator_id` INT NOT NULL,
    CONSTRAINT `fk_creator_id`
    FOREIGN KEY (`creator_id`)
    REFERENCES `ActivityFinderDB`.`Users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = MYISAM ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


INSERT INTO markers VALUES(1,'Pick-up Soccer Game','10 Longbride Rd, Holmdel, NJ 07734, USA', 40.339733, -74.165237, 'Pick up soccer games every Friday afternoon! All age groups are welcome, please bring your own playing gear and water.', '2019-08-30', '03:00:00', '06:30:00', 'soccer, sports, pick-up, holmdel', 2);
INSERT INTO markers VALUES(2,'Computer Science Club Meeting', 'Museum Dr, Lincroft, NJ 07738, USA', '40.327793', '-74.133598', 'Come join us for our first meeting of the Fall semester. Free drinks and food will be available!', '2019-09-10', '12:00', '1:00', 'brookdale, comp sci, club, meeting, college', 1);
INSERT INTO `markers` (`id`, `name`, `address`, `lat`, `lng`, `description`, `date`, `start_time`, `end_time`, `tags`, `creator_id`) VALUES ('0', 'Fireworks Show', '275 Beachway Ave, Keansburg, NJ 07734, USA', '40.454742', '-74.138191', 'Bring your family to a fireworks show by the beach!', '2019-08-15', '08:00:00', '09:00:00', 'fireworks, beach, outdoors, amusement park', '3');
INSERT INTO `markers` (`name`, `address`, `lat`, `lng`, `description`, `date`, `start_time`, `end_time`, `tags`, `creator_id`) VALUES ('Peach Picking', '320 NJ-34, Colts Neck, NJ 07722, USA', '40.282990', '-74.173561', 'Enjoy a day out in a scenic orchard and pick your own peaches and apples! We are offering a 20% discount for every 2 pounds you pick for one day only!', '2019-08-20', '12:00:00', '04:00:00', 'orchard, peach picking, outdoors', 1);
INSERT INTO `markers` (`id`, `name`, `address`, `lat`, `lng`, `description`, `date`, `start_time`, `end_time`, `tags`, `creator_id`) VALUES ('0', 'Fall 2019 Hackathon', 'New Brunswick, NJ, USA', '40.500820', '-74.447395', 'Hackathon open to all current college students from around the country. Join us for a two day event to showcase your coding skills!', '2019-10-08', '10:00:00', '', 'comp sci, programming, technology, college students', '3');
INSERT INTO `users` (`user_id`, `contact_name`, `username`, `password`, `email`, `dob`, `phone_number`, `address`, `description`, `profile_name`, `profile_location`, `profile_contact_info`) VALUES ('1', 'Jacob Smith', 'hobbyist102', 'test', 'jsmith@mail.com', '1999-01-01', '123-456-7891', 'Highlands, New Jersey, USA', 'Avid mountain biker with a variety of other interests.','Jacob Smith', 'Highlands, New Jersey', 'jsmith@mail.com');
INSERT INTO `users` (`user_id`, `contact_name`, `username`, `password`, `email`, `dob`, `phone_number`, `address`, `description`, `profile_name`, `profile_location`, `profile_contact_info`) VALUES ('2', 'Fernando O.', 'fo', 'test', 'fo@mail.com', '1999-01-01', '123-456-7891', 'Lincroft, New Jersey, USA', 'Hobbyist looking for fun events in the Lincroft area.','Fernando O.', 'Lincroft, New Jersey', 'fo@mail.com');
INSERT INTO `users` (`user_id`, `contact_name`, `username`, `password`, `email`, `dob`, `phone_number`, `address`, `description`, `profile_name`, `profile_location`, `profile_contact_info`) VALUES ('3', 'Susan P.', 'sp123', 'test', 'susanp@mail.com', '1999-01-01', '123-456-7891', 'Middletown, New Jersey, USA', 'Hobbyist looking for fun events in the Middletown area.','Susan P.', 'Middletown, New Jersey', 'susanp@mail.com');
INSERT INTO `event_enrollment` (`record_id`, `user_id`, `event_id`) VALUES ('1', '1', '1'), ('2', '3', '1');
INSERT INTO `user_interests` (`user_id`, `interest`) VALUES ('2', 'basketball'), ('2', 'soccer'), ('2', 'programming'), ('2', 'guitar playing'), ('2', 'music'), ('2', 'hiking');
INSERT INTO `user_interests` (`user_id`, `interest`) VALUES ('1', 'moutain biking'), ('1', 'competitive swimming'), ('1', 'board games'), ('1', 'basketball');
