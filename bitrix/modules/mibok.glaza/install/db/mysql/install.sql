CREATE TABLE IF NOT EXISTS mibok_special_exclusion
(
	ID		int(11)		NOT NULL AUTO_INCREMENT PRIMARY KEY,
	ACTIVE		CHAR(1)		DEFAULT 'Y' NOT NULL,
	COMPONENT varchar(255),
	TEMPLATE varchar(255),
	MESSAGE text NULL,
    DEFINED_VALUE		CHAR(1)		DEFAULT 'N' NOT NULL
);
INSERT INTO mibok_special_exclusion (`ID`, `ACTIVE`, `COMPONENT`, `TEMPLATE`, `MESSAGE`, `DEFINED_VALUE`) VALUES
(1,	'Y',	'gosportal:informers',	'.default',	'Возникновение ошибки Jquery', 'Y');