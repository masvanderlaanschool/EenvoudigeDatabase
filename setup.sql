CREATE DATABASE IF NOT EXISTS contact_manager;

USE contact_manager;

CREATE TABLE IF NOT EXISTS studenten (
    StudentID INT AUTO_INCREMENT PRIMARY KEY,
    Voornaam VARCHAR(50) NOT NULL,
    Achternaam VARCHAR(100) NOT NULL,
    Geboortedatum DATE NOT NULL,
    Geslacht VARCHAR(10) DEFAULT NULL,
    Email VARCHAR(100) NOT NULL,
    Studierichting VARCHAR(100) DEFAULT NULL,
    Startjaar YEAR NOT NULL,
    HuidigJaar YEAR DEFAULT NULL,
    StudieStatus VARCHAR(50) DEFAULT NULL,
    AchterstalligStudiegeld DECIMAL(10,2) DEFAULT NULL
);
