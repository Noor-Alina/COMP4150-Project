CREATE TABLE Staff_Advisor(
advisor_id VARCHAR2(20) NOT NULL,
advisor_fname VARCHAR2(20),
advisor_lname VARCHAR2(20),
job_pos VARCHAR2(20),
dept_name VARCHAR2(20),
internal_ph VARCHAR2(15),
room_number NUMBER(8),
PRIMARY KEY (advisor_id));

INSERT INTO Staff_advisor VALUES('58173819', 'Jackie', 'wood','ResidenceAdvisor ','Residence',2265789876,234);
INSERT INTO Staff_advisor VALUES('58173019', 'Binoy', 'Bennette','Advisor ','Hall',2265799876,284);



CREATE TABLE Student(
student_id VARCHAR2(8) NOT NULL,
student_fname VARCHAR2(8),
student_lname VARCHAR2(8),
grade_12_num VARCHAR2(8),
street VARCHAR2(20),
city VARCHAR2(10),
postal_code VARCHAR2(8),
DOB DATE,
gender VARCHAR2(8),
deg_category VARCHAR2(20),
nationality VARCHAR2(20),
special_needs VARCHAR2(30),
additional_comments VARCHAR2(30),
current_status VARCHAR2(8),
program VARCHAR2(20),
advisor_id VARCHAR2(8) NOT NULL,
CONSTRAINT valid_values CHECK (current_status = 'placed' OR current_status = 'waiting'),
PRIMARY KEY (student_id),
FOREIGN KEY (advisor_id) references Staff_Advisor);

INSERT INTO student VALUES(11124376,'Connie','Tukcer',87,'305 - 14th Ave','Windsor ','N9C1A8E',DATE '2000-08-08','Female','Post Graduate','Canadian','Dietary','pollen Allergy','placed','Computer science',58173819);
INSERT INTO student VALUES(12345678,'Jess','Yeck',90,'2023 kitty Ave','Windsor ','N9b1w8',DATE '2002-12-18','Male','Undergraduate','Hungarian','Dietary','n/a','placed','Engineering',58173019);



Create TABLE  Halls_of_Residence(
Hall_Name varchar2(20) NOT NULL PRIMARY KEY, 
street VARCHAR2(20) NOT NULL, 
city VARCHAR2(10) NOT NULL, 
postal_code VARCHAR2(8) NOT NULL, 
Hall_ph varchar2(10) NOT NULL, 
Hall_manager varchar2(20) NOT NULL);

INSERT INTO Halls_of_Residence VALUES('MCD','476 lillian st','Toronto','N88C71',2564786535,'Corrie Smith');
INSERT INTO Halls_of_Residence VALUES('ECQ','222 meow st','Toronto','N88w23',2453555152,'Jim Couts');



Create TABLE Hall_rooms(
Place_num varchar2(10) NOT NULL PRIMARY KEY, 
Hall_Name varchar2(20) NOT NULL, 
monthly_rent DECIMAL(5,2), 
room_num varchar2(5),
FOREIGN KEY(Hall_Name) REFERENCES Halls_of_Residence);

INSERT INTO Hall_rooms values(34,'MCD',800.89,34);
INSERT INTO Hall_rooms values(42,'MCD',600.23,24);



CREATE TABLE Flats(
flat_num VARCHAR2(8) NOT NULL,
street VARCHAR2(20),
city VARCHAR2(10),
postal_code VARCHAR2(8),
num_single_beds NUMBER(8),
PRIMARY KEY (flat_num));

INSERT INTO Flats VALUES(56,'356 sandwich st','Windsor','N94A56',1);
INSERT INTO Flats VALUES(67,'788 Rosedale st','Windsor','N97F56',1);



CREATE TABLE Flat_rooms(
place_num VARCHAR2(8) NOT NULL,
flat_num VARCHAR2(8) NOT NULL,
room_num NUMBER(8),
monthly_rent DECIMAL(5,2),
PRIMARY KEY (place_num),
FOREIGN KEY (flat_num) references Flats);

INSERT INTO Flat_rooms VALUES(90,56,734,400.56);
INSERT INTO Flat_rooms VALUES(30,67,774,999.87);



Create Table Hostel_staff(
Staff_num varchar2(20) NOT NULL PRIMARY KEY, 
Staff_name varchar2(20) NOT NULL, 
street VARCHAR2(20) NOT NULL, 
city VARCHAR2(10) NOT NULL, 
postal_code VARCHAR2(8) NOT NULL, 
DOB DATE, 
Gender varchar2(10), 
Job_position varchar2(20), 
Service_loc varchar2(30));

INSERT INTO Hostel_staff VALUES(2790,'Marie Jenkins','289 Dominain BLVD','Windsor','N987C5',DATE '2001-11-20','F','HallManager','Hall');
INSERT INTO Hostel_staff VALUES(2990,'Maria Cahoy','209 Industrila BLVD','Windsor','N907C5',DATE '1976-11-20','F','HallManager','Hall');



Create Table Flat_Inspections(
flat_inspect_id varchar2(8),
DO_Inspection DATE, 
Satisfaction_cond varchar2(6),
comments varchar2(50), 
Staff_num varchar2(10) NOT NULL, 
Flat_num varchar2(8) NOT NULL, 
CONSTRAINT CHK_cond CHECK (Satisfaction_cond = 'Y' OR Satisfaction_cond = 'N'),
FOREIGN KEY(Staff_num) REFERENCES Hostel_staff, 
FOREIGN KEY(Flat_num) REFERENCES Flats);

INSERT INTO Flat_Inspections VALUES(23456, DATE '2022-05-09', 'Y', 'excellent', '2790', '67');
INSERT INTO Flat_Inspections VALUES(12345, DATE '2022-06-20', 'Y', 'good', '2790', '56');



CREATE TABLE Leases(
lease_num VARCHAR2(8) NOT NULL,
hall_place_num VARCHAR2(8),
flat_place_num VARCHAR2(8),
student_id VARCHAR2(8) NOT NULL,
lease_duration VARCHAR2(20),
date_of_entry DATE,
date_of_exit DATE,
PRIMARY KEY (lease_num),
FOREIGN KEY (hall_place_num) references Hall_rooms(place_num),
FOREIGN KEY (flat_place_num) references Flat_rooms(place_num),
FOREIGN KEY (student_id) references Student,
CONSTRAINT map_one_room CHECK ( (hall_place_num IS NOT NULL AND flat_place_num IS NULL ) OR ( hall_place_num IS NULL AND flat_place_num IS NOT NULL) )
);

INSERT INTO Leases VALUES(890,34,NULL,11124376, '2 semesters',DATE '2022-09-01',DATE '2023-01-01');
INSERT INTO Leases VALUES(790,NULL,30,12345678, '1 semester', DATE '2022-08-28',DATE '2023-04-28');



CREATE TABLE Invoice(
invoice_num VARCHAR2(8) NOT NULL,
lease_num VARCHAR2(8) NOT NULL,
student_id VARCHAR2(8) NOT NULL,
payment_due DATE,
semester VARCHAR2(8),
PRIMARY KEY (invoice_num),
FOREIGN KEY (lease_num) references Leases,
FOREIGN KEY (student_id) references Student);

INSERT INTO INVOICE VALUES(789098,890,11124376, DATE '2022-10-01','Fall');
INSERT INTO INVOICE VALUES(678790,790,12345678, DATE '2022-09-28','Fall');



CREATE TABLE Receipt(
receipt_num VARCHAR2(8) NOT NULL,
invoice_num VARCHAR2(8) NOT NULL,
DO_payment DATE,
pay_method VARCHAR2(8),
first_remind_date DATE,
second_remind_date  DATE,
PRIMARY KEY (receipt_num),
FOREIGN KEY (invoice_num) references Invoice);

INSERT INTO Receipt VALUES (27869,789098, DATE '2022-09-18','cash',DATE '2022-09-15', NULL);
INSERT INTO Receipt VALUES (27969,678790, DATE '2022-09-27','visa',DATE '2022-09-12', DATE '2022-09-21');



CREATE INDEX Grade_12_num_idx ON Student(grade_12_num);
CREATE INDEX special_Needs_idx ON Student(special_needs);


CREATE VIEW Student_public_view AS
SELECT student_id, student_fname, student_lname, deg_category, program 
FROM Student;



CREATE VIEW student_lease_info AS
SELECT l.student_id, l.lease_num, h.hall_name, f.flat_num,
CONCAT(h.place_num, f.place_num) as place_num, 
CONCAT(h.room_num, f.room_num) as room_num, 
CONCAT(h.monthly_rent, f.monthly_rent) as monthly_rent,
l.date_of_entry as date_of_entry,
l.date_of_exit as date_of_exit,
l.date_of_exit - l.date_of_entry as lease_duration
FROM Leases l
LEFT JOIN Hall_rooms h ON hall_place_num = h.place_num
LEFT JOIN Flat_rooms f ON flat_place_num = f.place_num;




SELECT s.student_fname, s.student_lname, s.grade_12_num, l.date_of_entry, l.date_of_exit, sl.hall_name, sl.flat_num, sl.room_num, sl.monthly_rent
FROM Student s, student_lease_info sl, Leases l
WHERE s.student_id = sl.student_id AND l.lease_num = sl.lease_num;


SELECT SUM(rent) as total FROM (
SELECT (sl.monthly_rent*(sl.lease_duration/30)) as rent, s.student_fname
FROM Student s, student_lease_info sl, Invoice i, Receipt r
WHERE s.student_fname = 'Connie' AND s.student_id = sl.student_id AND sl.lease_num = i.lease_num AND i.invoice_num = r.invoice_num);


SELECT s.student_fname, s.student_lname, i.payment_due, (SELECT DO_payment FROM Receipt WHERE i.invoice_num=invoice_num) as date_payed
FROM Invoice i, Student s, Leases l 
WHERE i.invoice_num NOT IN (
    SELECT invoice_num
    FROM Receipt
    WHERE DATE '2022-09-20' > DO_payment ) 
AND i.lease_num = l.lease_num 
AND l.student_id = s.student_id;


SELECT fi.Satisfaction_cond, hs.Staff_name, fi.DO_Inspection as inspection_date, fi.comments, f.flat_num, f.street, f.city, f.postal_code
FROM Flat_Inspections fi, Hostel_staff hs, Flats f
WHERE fi.Satisfaction_cond = 'N' AND fi.Staff_num = hs.Staff_num AND fi.flat_num = f.flat_num;


SELECT s.student_fname, s.student_lname, s.grade_12_num, h.Hall_name, hr.place_num, hr.room_num
FROM Leases l, Hall_rooms hr, Halls_of_Residence h, Student s
WHERE l.hall_place_num = hr.place_num AND hr.Hall_name = h.Hall_name AND s.student_id = l.student_id  AND h.Hall_name = 'MCD';


SELECT s.student_fname, s.student_lname, s.grade_12_num, s.gender, s.nationality, s.program
FROM Student s
WHERE s.current_status = 'waiting';


SELECT deg_category, COUNT(*) AS Degree FROM student GROUP BY deg_category;


SELECT s.student_fname, s.student_lname, a.advisor_fname, a.advisor_lname, a.internal_ph
FROM Student s, Staff_Advisor a 
WHERE s.student_fname  = 'Jess' AND s.advisor_id = a.advisor_id;


SELECT min(monthly_rent) AS MIN_RENT, max(monthly_rent) AS MAX_RENT ,AVG(monthly_rent) AS AVG_RENT FROM Hall_rooms;


SELECT staff_num, staff_name, TRUNC( ( CURRENT_DATE-DOB )/365 ) AS age, street, city, postal_code FROM Hostel_Staff;

