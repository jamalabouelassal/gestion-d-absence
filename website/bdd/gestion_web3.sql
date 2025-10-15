DROP DATABASE IF EXISTS gestion_web3;

CREATE DATABASE IF NOT EXISTS gestion_web3;

USE gestion_web3;

CREATE TABLE IF NOT EXISTS Filiere (
      idfiliere INT(4) AUTO_INCREMENT PRIMARY KEY,
      departement VARCHAR(50),
      nomfiliere VARCHAR(50),
      niveau VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS Etudiant (
    code INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    sex VARCHAR(50),
    niveau VARCHAR(50),
    photo VARCHAR(100),
    date_naissance Varchar(100),
    lieu_naissance Varchar(50),
    cin VARCHAR(255),
    password VARCHAR(255),
    idfiliere INT,
    FOREIGN KEY (idfiliere) REFERENCES Filiere(idfiliere)
);


CREATE TABLE IF NOT EXISTS professeurmatiere (
      code INT() ,
      niveau VARCHAR(50),
      matiere VARCHAR(50)
);





INSERT INTO Etudiant (nom, prenom,sex,niveau,photo,date_naissance,lieu_naissance,cin,password) VALUES 
      ('Laabouli','imadeddine','M','SMI6','Desert.jpg','2003-07-27','casablanca','wa2001','123'),
      ('Hamouda','Oussama','F','SMI6','Penguins.jpg','2003-06-20','Marzouga','BE5001','123'),
      ('Abouelassal','jamal','M','SMI6','Chrysantheme.jpg','2004-01-01','taounet','AB20','123'),
      ('Elkbir','ABDELKABIR','M','SMI6','Desert.jpg','2002-05-19','Had soualem','wa2512','123'),
      ('?????','youssef','M','SMI6','Chrysantheme.jpg','2002-07-10','Taoujdate','wa6662','123');



INSERT INTO Filiere (departement, nomfiliere, niveau) VALUES 
    ('maths informatique','SMIA', 'SMI5'),
    ('maths informatique','SMIA', 'SMI6'),
    ('maths informatique','SMIA', 'SMA5'),
    ('physique chimie','SMPC', 'SMP4'),
    ('physique chimie','SMPC', 'SMC2'),
    ('physique chimie','SMPC', 'SMC100');

    CREATE TABLE IF NOT EXISTS Utilisateur (
      iduser INT(4) AUTO_INCREMENT PRIMARY KEY,
      login VARCHAR(50),
      email VARCHAR(255),
      etat INT(1),
      password VARCHAR(255)
);
  
INSERT INTO Utilisateur (login, email, etat, password) VALUES 
      ('admin', 'admin@gmail.com', 1, MD5('123')),
      ('user1', 'user1@gmail.com', 0, MD5('123')),
      ('user2', 'user2@gmail.com', 1, MD5('123'));

SELECT * FROM Filiere;
SELECT * FROM Profile;
SELECT * FROM Etudiant;
SELECT * FROM Utilisateur;


