CREATE TABLE `Player` (
`PlayerID` INT NOT NULL ,
`Name` VARCHAR( 255 ) NOT NULL ,
`Credits` DOUBLE NOT NULL ,
`LifetimeDeposit` DOUBLE NOT NULL ,
`LifetimeSpins` BIGINT NOT NULL ,
`SaltValue` VARCHAR( 255 ) NOT NULL ,
PRIMARY KEY ( `PlayerID` )
)

INSERT INTO `Player` ( `PlayerID` , `Name` , `Credits` , `LifetimeDeposit`, `LifetimeSpins` , `SaltValue` )
VALUES (
'1234', 'Joan Wang', '500', ‘400’, ’100', 'lowsodiumsalt'
);