/*Creates the database & user*/
	CREATE DATABASE coursework_db COLLATE utf8_unicode_ci;

	GRANT SELECT, INSERT, UPDATE on coursework_db.* TO 'cw_user'@'localhost' IDENTIFIED BY 'cw_password';

/*Creates the table to hold the message info*/
	USE coursework_db;
	DROP TABLE IF EXISTS messages;
	CREATE TABLE messages (
		msg_timestamp varchar(128) COLLATE utf8_unicode_ci NOT NULL,
		msg_switch1 varchar(3) NOT NULL,
		msg_switch2 varchar(3) NOT NULL,
		msg_switch3 varchar(3) NOT NULL,
		msg_switch4 varchar(3) NOT NULL,
		msg_fan varchar(3) COLLATE utf8_unicode_ci NOT NULL,
		msg_temperature DOUBLE(8,2) NOT NULL,
		msg_keypad INT NOT NULL,
		CONSTRAINT msg_pk PRIMARY KEY (msg_keypad, msg_timestamp, msg_switch4)
	) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

/*Creates the table to hold account info*/
	USE coursework_db;
	DROP TABLE IF EXISTS accounts;
	CREATE TABLE accounts (
		acct_id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
		acct_name varchar(128) COLLATE utf8_unicode_ci NOT NULL,
		acct_password varchar(128) COLLATE utf8_unicode_ci NOT NULL
	) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
