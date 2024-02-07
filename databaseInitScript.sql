CREATE DATABASE IF NOT EXISTS YahrzeitsDatabase;
USE YahrzeitsDatabase;

DROP TABLE IF EXISTS HebrewMonths;
DROP TABLE IF EXISTS Yahrzeits;

CREATE TABLE HebrewMonths
(
    Id          INT AUTO_INCREMENT,
    DisplayName VARCHAR(25),
    APIName     VARCHAR(25),
    PRIMARY KEY (Id)
);

CREATE TABLE Yahrzeits
(
    Id            INT AUTO_INCREMENT,
    Prefix        VARCHAR(25),
    First         VARCHAR(25),
    Last          VARCHAR(25),
    HebrewName    VARCHAR(100),
    Notes         VARCHAR(255),
    RelatedTo     VARCHAR(100),
    Source        VARCHAR(100),
    HebrewMonthID INT,
    HebrewDay     INT,
    HebrewYear    INT,
    PRIMARY KEY (Id),
    FOREIGN KEY (HebrewMonthID) REFERENCES HebrewMonths (Id)
);

-- Inserting the Hebrew months along with their display names and API names
INSERT INTO HebrewMonths (DisplayName, APIName)
VALUES ('Nisan', 'Nisan');
INSERT INTO HebrewMonths (DisplayName, APIName)
VALUES ('Iyar', 'Iyar');
INSERT INTO HebrewMonths (DisplayName, APIName)
VALUES ('Sivan', 'Sivan');
INSERT INTO HebrewMonths (DisplayName, APIName)
VALUES ('Tammuz', 'Tammuz');
INSERT INTO HebrewMonths (DisplayName, APIName)
VALUES ('Av', 'Av');
INSERT INTO HebrewMonths (DisplayName, APIName)
VALUES ('Elul', 'Elul');
INSERT INTO HebrewMonths (DisplayName, APIName)
VALUES ('Tishrei', 'Tishrei');
INSERT INTO HebrewMonths (DisplayName, APIName)
VALUES ('Cheshvan', 'Cheshvan');
INSERT INTO HebrewMonths (DisplayName, APIName)
VALUES ('Kislev', 'Kislev');
INSERT INTO HebrewMonths (DisplayName, APIName)
VALUES ('Tevet', 'Tevet');
INSERT INTO HebrewMonths (DisplayName, APIName)
VALUES ('Shevat', 'Shevat');
INSERT INTO HebrewMonths (DisplayName, APIName)
VALUES ('Adar', 'Adar');
INSERT INTO HebrewMonths (DisplayName, APIName)
VALUES ('Adar II', 'AdarII');
