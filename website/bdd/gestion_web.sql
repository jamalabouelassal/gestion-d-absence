CREATE DATABASE IF NOT EXISTS gestion_web;

USE gestion_web;

CREATE TABLE IF NOT EXISTS Filiere (
      idfiliere INT(4) AUTO_INCREMENT PRIMARY KEY,
      nomfiliere VARCHAR(50),
      niveau VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS Etudiant (
      idEtudiant INT(4) AUTO_INCREMENT PRIMARY KEY,
      nomEtudiant VARCHAR(50),
      prenomEtudiant VARCHAR(50),
      photo VARCHAR(100),
      idfiliere INT(4),
      FOREIGN KEY (idfiliere) REFERENCES Filiere(idfiliere)
);

CREATE TABLE IF NOT EXISTS Profile (
      iduser INT(4) AUTO_INCREMENT PRIMARY KEY,
      login VARCHAR(50),
      email VARCHAR(255),
      etat INT(1),
      passeword VARCHAR(255)
);

INSERT INTO Filiere(nomfiliere, niveau) VALUES 
    ('SMIA', 'SMI1'),
    ('SMIA', 'SMI2'),
    ('SMIA', 'SMI3'),
    ('SMIA', 'SMI4'),
    ('SMIA', 'SMI5'),
    ('SMIA', 'SMA1'),
    ('SMIA', 'SMA2'),
    ('SMIA', 'SMA3'),
    ('SMIA', 'SMA4');


INSERT INTO Profile(login, email, etat, passeword) VALUES 
      ('admin', 'admin@gmail.com', 1, MD5('123')),
      ('user1', 'user1@gmail.com', 0, MD5('123')),
      ('user2', 'user2@gmail.com', 1, MD5('123'));

 SELECT * FROM Filiere;
 SELECT * FROM Profile;
 SELECT * FROM Etudiant;


