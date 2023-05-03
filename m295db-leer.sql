CREATE TABLE `users` (
  `uid` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `Benutzername` varchar(20)  NOT NULL,
  `Passwort` varchar(50)  NOT NULL,
  `Anrede` char(4) ,
  `Vorname` varchar(50)  NOT NULL,
  `Nachname` varchar(50)  NOT NULL,
  `Strasse` varchar(50) ,
  `PLZ` varchar(15) ,
  `Ort` varchar(50) ,
  `Land` varchar(50) ,
  `EMail_Adresse` varchar(30) ,
  `Telefon` int(11) 
) ;
CREATE TABLE `kategories` (
  `kid` int(10) unsigned NOT NULL,
  `kategorie` varchar(20) NOT NULL
) ;

CREATE TABLE `news` (
  `newsID` int(11) NOT NULL,
  `titel` varchar(255)  NOT NULL,
  `inhalt` text,
  `gueltigVon` date ,
  `gueltigBis` date ,
  `erstelltam` date ,
  `kid`  int(10) unsigned NOT NULL REFERENCES kategories(kid) ,
  `link` varchar(50) ,
  `bild` varchar(255) ,
  `autor` int(11)  REFERENCES users(uid)
);
