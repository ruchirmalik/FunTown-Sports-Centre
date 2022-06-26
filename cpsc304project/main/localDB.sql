CREATE DATABASE localDB;

USE localDB;

CREATE TABLE Sport_Center_Branch
(
    address char(40),
    name    char(20),
    PRIMARY KEY (address)
);

CREATE TABLE Admin
(
    AID   integer,
    name  char(20),
    phone char(12) UNIQUE,
    PRIMARY KEY (AID)
);

CREATE TABLE Coach
(
    CID   integer,
    name  char(20),
    phone char(12) UNIQUE,
    PRIMARY KEY (CID)
);


CREATE TABLE Customer_Phone
(
    Phone char(12),
    Name  char(20),
    PRIMARY KEY (phone)
);

CREATE TABLE Customer_Age
(
    DOB date,
    Age integer,
    PRIMARY KEY (DOB)
);

CREATE TABLE Customer
(
    email char(30),
    phone char(12) UNIQUE,
    DOB   date,
    PRIMARY KEY (email),
    FOREIGN KEY (phone) REFERENCES Customer_Phone (phone)
        ON DELETE SET NULL
        ON UPDATE Cascade,
    FOREIGN KEY (DOB) REFERENCES Customer_Age (DOB)
        ON DELETE SET NULL
        ON UPDATE Cascade
);

CREATE TABLE Membership_Level
(
    Level char(20),
    Fee   float,
    PRIMARY KEY (Level)
);

CREATE TABLE Membership
(
    ID         integer NOT NULL AUTO_INCREMENT,
    start_date date,
    end_date   date,
    Level      char(20) NOT NULL,
    email      char(30) NOT NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY (Level) REFERENCES Membership_Level (Level)
        ON DELETE Cascade
        ON UPDATE Cascade,
    FOREIGN KEY (email) REFERENCES Customer (email)
        ON DELETE Cascade
        ON UPDATE Cascade
);

CREATE TABLE Activity
(
    name     char(20),
    capacity integer,
    PRIMARY KEY (name)
);

CREATE TABLE type
(
    Level char(20),
    PRIMARY KEY (Level)
);

CREATE TABLE Studio
(
    Number integer,
    PRIMARY KEY (Number)
);

CREATE TABLE Appointment_Happens_In
(
    CustEmail char(30),
    ApptDate date,
    ApptTime time,
    SNumber  integer NOT NULL,
    CoachID integer,
    PRIMARY KEY (CustEmail, ApptDate, ApptTime),
    FOREIGN KEY (CustEmail) REFERENCES Customer (email)
        ON DELETE Cascade ON UPDATE Cascade,
    FOREIGN KEY (SNumber) REFERENCES Studio (Number)
        ON DELETE Cascade ON UPDATE Cascade,
    FOREIGN KEY (CoachID) REFERENCES Coach (CID)
        ON DELETE Cascade ON UPDATE Cascade
);

CREATE TABLE Appointment_Happens_In_Slots
(
    ApptTime time,
    PRIMARY KEY ( ApptTime)
);

CREATE TABLE EmergencyContact
(
    Name      char(20),
    CustEmail char(30),
    Phone     char(12) UNIQUE,
    PRIMARY KEY (Name, CustEmail),
    FOREIGN KEY (CustEmail) REFERENCES Customer (Email)
        ON DELETE Cascade
        ON UPDATE Cascade
);

CREATE TABLE Offers
(
    ActName char(20),
    CoachID integer,
    PRIMARY KEY (ActName, CoachID),
    FOREIGN KEY (ActName) REFERENCES Activity (Name)
        ON DELETE Cascade
        ON UPDATE Cascade,
    FOREIGN KEY (CoachID) REFERENCES Coach (CID)
        ON DELETE Cascade
        ON UPDATE Cascade
);

CREATE TABLE Has
(
    SCAddress char(40),
    SNumber   integer,
    PRIMARY KEY (SCAddress, SNumber),
    FOREIGN KEY (SCAddress) REFERENCES Sport_Center_Branch (Address)
        ON DELETE Cascade
        ON UPDATE Cascade,
    FOREIGN KEY (SNumber) REFERENCES Studio (Number)
        ON DELETE Cascade
        ON UPDATE Cascade
);


CREATE TABLE Attends
(
    SCAddress char(40),
    CustEmail char(30),
    PRIMARY KEY (SCAddress, CustEmail),
    FOREIGN KEY (SCAddress) REFERENCES Sport_Center_Branch (Address)
        ON DELETE Cascade
        ON UPDATE Cascade,
    FOREIGN KEY (CustEmail) REFERENCES Customer (Email)
        ON DELETE Cascade
        ON UPDATE Cascade
);

CREATE TABLE Accesses
(
    ActName   char(20),
    CustEmail char(30),
    PRIMARY KEY (ActName, CustEmail),
    FOREIGN KEY (ActName) REFERENCES Activity (Name)
        ON DELETE Cascade
        ON UPDATE Cascade,
    FOREIGN KEY (CustEmail) REFERENCES Customer (Email)
        ON DELETE Cascade
        ON UPDATE Cascade
);


INSERT INTO Sport_Center_Branch
VALUES ('1100 No. 1', 'FunTown No. 1');
INSERT INTO Sport_Center_Branch
VALUES ('1234 Smith Ave', 'FunTown Smith');
INSERT INTO Sport_Center_Branch
VALUES ('3333 Kent St', 'FunTown Kent');
INSERT INTO Sport_Center_Branch
VALUES ('5544 Cambie St', 'FunTown Cambie');
INSERT INTO Sport_Center_Branch
VALUES ('9988 Granville St', 'FunTown Granville');

INSERT INTO Admin
VALUES (3399441, 'John', '1234567890');
INSERT INTO Admin
VALUES (2277442, 'David', '7783982904');
INSERT INTO Admin
VALUES (1100333, 'Amanda', '6043997647');
INSERT INTO Admin
VALUES (7744884, 'Bailee', '7083219382');
INSERT INTO Admin
VALUES (9933775, 'Amber', '6049981029');

INSERT INTO Coach
VALUES (11001, 'Kelani', '8823172920');
INSERT INTO Coach
VALUES (11002, 'Connie', '7782138992');
INSERT INTO Coach
VALUES (11003, 'Madi', '7783228919');
INSERT INTO Coach
VALUES (11004, 'Justin', '6049992901');
INSERT INTO Coach
VALUES (11005, 'Daniel', '6049381021');

INSERT INTO Customer_Phone
VALUES ('+11234567890', 'Jane D.');
INSERT INTO Customer_Phone
VALUES ('+17783562902', 'Ashley S.');
INSERT INTO Customer_Phone
VALUES ('+18892839944', 'Keagan S.');
INSERT INTO Customer_Phone
VALUES ('+15573992841', 'Raj M. N');
INSERT INTO Customer_Phone
VALUES ('+17437828940', 'Daniella L.');

INSERT INTO Customer_Age
VALUES ('2000-05-03', 21);
INSERT INTO Customer_Age
VALUES ('1998-09-06', 22);
INSERT INTO Customer_Age
VALUES ('1995-02-11', 25);
INSERT INTO Customer_Age
VALUES ('2002-10-05', 19);
INSERT INTO Customer_Age
VALUES ('2000-06-06', 20);

INSERT INTO Customer
VALUES ('janedabc123@gmail.com', '+11234567890', '2000-05-03');
INSERT INTO Customer
VALUES ('ashleys33@gmail.com', '+17783562902', '1998-09-06');
INSERT INTO Customer
VALUES ('keagan23@gmail.com', '+18892839944', '1995-02-11');
INSERT INTO Customer
VALUES ('rajsmn@gmail.com', '+15573992841', '2002-10-05');
INSERT INTO Customer
VALUES ('danillll@gmail.com', '+17437828940', '2000-06-06');

INSERT INTO Studio
VALUES (1);
INSERT INTO Studio
VALUES (2);
INSERT INTO Studio
VALUES (3);
INSERT INTO Studio
VALUES (4);
INSERT INTO Studio
VALUES (5);

INSERT INTO Membership_Level VALUES ('Silver', 249.99);
INSERT INTO Membership_Level VALUES ('Gold', 489.99);
INSERT INTO Membership_Level VALUES ('Platinum', 699.99);
INSERT INTO Membership_Level VALUES ('Bronze', 149.99);
INSERT INTO Membership_Level VALUES ('Diamond', 999.99);

INSERT INTO Membership
VALUES (100, '2020-10-05', '2021-10-05', 'Silver', 'janedabc123@gmail.com');
INSERT INTO Membership
VALUES (101, '2020-06-16', '2021-10-05', 'Silver', 'ashleys33@gmail.com');
INSERT INTO Membership
VALUES (102, '2020-10-09', '2022-10-09', 'Gold', 'keagan23@gmail.com');
INSERT INTO Membership
VALUES (103, '2020-07-28', '2023-07-23', 'Platinum', 'rajsmn@gmail.com');
INSERT INTO Membership
VALUES (104, '2020-12-20', '2022-12-20', 'Gold', 'danillll@gmail.com');

INSERT INTO Activity
VALUES ('Gym', 30);
INSERT INTO Activity
VALUES ('Yoga', 30);
INSERT INTO Activity
VALUES ('Martial Arts', 10);
INSERT INTO Activity
VALUES ('Pilates', 15);
INSERT INTO Activity
VALUES ('Kick Boxing', 15);

INSERT INTO EmergencyContact
VALUES ('Kamryn', 'janedabc123@gmail.com', '7783172809');
INSERT INTO EmergencyContact
VALUES ('Roni', 'ashleys33@gmail.com', '7783179899');
INSERT INTO EmergencyContact
VALUES ('Kaithlynn', 'keagan23@gmail.com', '7083182799');
INSERT INTO EmergencyContact
VALUES ('Ibbie', 'rajsmn@gmail.com', '7383123409');
INSERT INTO EmergencyContact
VALUES ('Anastasia', 'danillll@gmail.com', '6083172324');

INSERT INTO Has VALUES('3333 Kent St', 1);
INSERT INTO Has VALUES('5544 Cambie St', 4);
INSERT INTO Has VALUES('5544 Cambie St', 3);
INSERT INTO Has VALUES('9988 Granville St', 2);
INSERT INTO Has VALUES('1234 Smith Ave', 5);

INSERT INTO Appointment_Happens_In_Slots VALUES('12:30');
INSERT INTO Appointment_Happens_In_Slots VALUES('9:30');
INSERT INTO Appointment_Happens_In_Slots VALUES('10:30');
INSERT INTO Appointment_Happens_In_Slots VALUES('11:30');
INSERT INTO Appointment_Happens_In_Slots VALUES('13:30');

INSERT INTO Appointment_Happens_In VALUES('ashleys33@gmail.com','2021-06-29','12:30',3,11001);
INSERT INTO Appointment_Happens_In VALUES('ashleys33@gmail.com','2021-07-29','12:30',3,11001);
INSERT INTO Appointment_Happens_In VALUES('ashleys33@gmail.com','2021-08-01','12:30',4,11003);
INSERT INTO Appointment_Happens_In VALUES('ashleys33@gmail.com','2021-06-29','11:30',3,11002);
INSERT INTO Appointment_Happens_In VALUES('ashleys33@gmail.com','2021-07-06','10:30',1,11002);


INSERT INTO Accesses VALUES ('Gym', 'janedabc123@gmail.com');
INSERT INTO Accesses VALUES ('Gym', 'ashleys33@gmail.com');
INSERT INTO Accesses VALUES ('Yoga', 'ashleys33@gmail.com');
INSERT INTO Accesses VALUES ('Pilates', 'ashleys33@gmail.com');
INSERT INTO Accesses VALUES ('Martial Arts', 'ashleys33@gmail.com');
INSERT INTO Accesses VALUES ('Kick Boxing', 'ashleys33@gmail.com');
INSERT INTO Accesses VALUES ('Gym', 'keagan23@gmail.com');
INSERT INTO Accesses VALUES ('Martial Arts', 'janedabc123@gmail.com');

INSERT INTO type VALUES ('Silver');
INSERT INTO type VALUES ('Gold');
INSERT INTO type VALUES ('Platinum');
INSERT INTO type VALUES ('Bronze');
INSERT INTO type VALUES ('Diamond');


INSERT INTO Offers VALUES('Gym', 11001);
INSERT INTO Offers VALUES('Yoga', 11001);
INSERT INTO Offers VALUES('Martial Arts', 11001);
INSERT INTO Offers VALUES('Pilates', 11001);
INSERT INTO Offers VALUES('Kick Boxing', 11001);
INSERT INTO Offers VALUES('Kick Boxing', 11002);
INSERT INTO Offers VALUES('Kick Boxing', 11003);
INSERT INTO Offers VALUES('Kick Boxing', 11004);
INSERT INTO Offers VALUES('Kick Boxing', 11005);

INSERT INTO Attends VALUES('1234 Smith Ave', 'janedabc123@gmail.com');
INSERT INTO Attends VALUES('9988 Granville St','keagan23@gmail.com');
INSERT INTO Attends VALUES('5544 Cambie St','rajsmn@gmail.com');
INSERT INTO Attends VALUES('5544 Cambie St', 'ashleys33@gmail.com');
INSERT INTO Attends VALUES('3333 Kent St', 'danillll@gmail.com');

SELECT *
from Appointment_Happens_In;
SELECT *
from Accesses;
SELECT *
from Activity;
SELECT *
from Admin;
SELECT *
from Attends;
SELECT *
from Coach;
SELECT *
from Customer;
SELECT *
from Customer_Age;
SELECT *
from Customer_Phone;
SELECT *
from EmergencyContact;
SELECT *
from Has;
SELECT *
from Membership;
SELECT *
from Membership_Level;
SELECT *
from Offers;
SELECT *
from Sport_Center_Branch;
SELECT *
from Studio;
SELECT *
from type;


