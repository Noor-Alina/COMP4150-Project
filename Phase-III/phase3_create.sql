CREATE TABLE Staff_Advisor(
advisor_id VARCHAR(20) NOT NULL,
advisor_fname VARCHAR(20),
advisor_lname VARCHAR(20),
job_pos VARCHAR(20),
dept_name VARCHAR(20),
internal_ph VARCHAR(15),
room_number INTEGER(8),
PRIMARY KEY (advisor_id));

INSERT INTO Staff_Advisor VALUES('58173819', 'Jackie', 'wood','ResidenceAdvisor ','Residence',2265789876,234);
INSERT INTO Staff_Advisor VALUES('58173019', 'Binoy', 'Bennette','Advisor ','Hall',2265799876,284);

CREATE TABLE Advisor_Login(
advisor_id VARCHAR(8) NOT NULL,
username VARCHAR(10) NOT NULL,
password VARCHAR(10) NOT NULL,
FOREIGN KEY (advisor_id) references Staff_Advisor(advisor_id));

INSERT INTO Advisor_Login VALUES('58173819','jackwood','l%w#D075');
INSERT INTO Advisor_Login VALUES('58173019','binobenne','VJ8#8av9');

CREATE TABLE Student(
student_id VARCHAR(8) NOT NULL,
student_fname VARCHAR(8),
student_lname VARCHAR(8),
grade_12_num VARCHAR(8),
street VARCHAR(20),
city VARCHAR(10),
postal_code VARCHAR(8),
DOB DATE,
gender VARCHAR(8),
deg_category VARCHAR(20),
nationality VARCHAR(20),
special_needs VARCHAR(30),
additional_comments VARCHAR(30),
current_status VARCHAR(8) CHECK (current_status = 'placed' OR current_status = 'waiting'),
program VARCHAR(20),
advisor_id VARCHAR(8) NOT NULL,
PRIMARY KEY (student_id),
FOREIGN KEY (advisor_id) references Staff_Advisor(advisor_id));

INSERT INTO Student VALUES(11124376,'Connie','Tukcer',87,'305 14th Ave','Windsor ','N9C1A8E',DATE '2000-08-08','Female','Post Graduate','Canadian','Dietary','pollen Allergy','placed','Computer science',58173819);
INSERT INTO Student VALUES(12345678,'Jess','Yeck',90,'2023 Kitty Ave','Windsor ','N9b1w8',DATE '2002-12-18','Male','Undergraduate','Hungarian','Dietary','n/a','placed','Engineering',58173019);
INSERT INTO Student VALUES(11335578,'Ciara','Sean',74,'193 Streets Ave.','Windsor ','N99A4D',DATE '1998-10-01','Female','Post Graduate','Irish','Dietary','Asthma','waiting','Biochemisty',58173819);
INSERT INTO Student VALUES(22348768,'Andrea','Albert',75,'Gull Estate Lane','Windsor ','N1C33J',DATE '1998-10-01','Female','Post Graduate','Peruvian','N/A','Asthma','waiting','Biochemisty',58173819);
INSERT INTO Student VALUES(11112222,'Mohamed','Tadesse',99,'Atlantic View Drive','Windsor ','N9WW3E',DATE '2001-10-01','Male','Undergraduate','Ethiopian','N/A','N/A','waiting','Political Science',58173019);

CREATE TABLE Student_Login(
student_id VARCHAR(8) NOT NULL,
username VARCHAR(10) NOT NULL,
password VARCHAR(10) NOT NULL,
FOREIGN KEY (student_id) references Student(student_id));

INSERT INTO Student_Login VALUES(11124376,'contuck','!69Wma7%');
INSERT INTO Student_Login VALUES(12345678,'jessyeck','Z%2u*79T');
INSERT INTO Student_Login VALUES(11335578,'ciarsean','4v!E6*3m');
INSERT INTO Student_Login VALUES(22348768,'andralb','5RusM91#');
INSERT INTO Student_Login VALUES(11112222,'mohatad','4UI*4pn4');


Create TABLE  Halls_of_Residence(
Hall_Name VARCHAR(20) NOT NULL PRIMARY KEY, 
street VARCHAR(20) NOT NULL, 
city VARCHAR(10) NOT NULL, 
postal_code VARCHAR(8) NOT NULL, 
Hall_ph VARCHAR(10) NOT NULL, 
Hall_manager VARCHAR(20) NOT NULL);

INSERT INTO Halls_of_Residence VALUES('MCD','476 lillian st','Toronto','N88C71',2564786535,'Corrie Smith');
INSERT INTO Halls_of_Residence VALUES('ECQ','222 meow st','Toronto','N88w23',2453555152,'Jim Couts');



Create TABLE Hall_rooms(
Place_num VARCHAR(10) NOT NULL PRIMARY KEY, 
Hall_Name VARCHAR(20) NOT NULL, 
monthly_rent DECIMAL(5,2), 
room_num VARCHAR(5),
FOREIGN KEY(Hall_Name) REFERENCES Halls_of_Residence(Hall_Name));

INSERT INTO Hall_rooms values(34,'MCD',800.89,34);
INSERT INTO Hall_rooms values(42,'MCD',600.23,24);
INSERT INTO Hall_rooms values(25,'ECQ',1000.00,1);



CREATE TABLE Flats(
flat_num VARCHAR(8) NOT NULL,
street VARCHAR(20),
city VARCHAR(10),
postal_code VARCHAR(8),
num_single_beds INT(8),
PRIMARY KEY (flat_num));

INSERT INTO Flats VALUES(56,'356 sandwich st','Windsor','N94A56',1);
INSERT INTO Flats VALUES(67,'788 Rosedale st','Windsor','N97F56',1);



CREATE TABLE Flat_rooms(
place_num VARCHAR(8) NOT NULL,
flat_num VARCHAR(8) NOT NULL,
room_num INT(8),
monthly_rent DECIMAL(5,2),
PRIMARY KEY (place_num),
FOREIGN KEY (flat_num) references Flats(flat_num));

INSERT INTO Flat_rooms VALUES(90,56,734,400.56);
INSERT INTO Flat_rooms VALUES(30,67,774,999.87);



Create Table Hostel_staff(
Staff_num VARCHAR(20) NOT NULL PRIMARY KEY, 
Staff_name VARCHAR(20) NOT NULL, 
street VARCHAR(20) NOT NULL, 
city VARCHAR(10) NOT NULL, 
postal_code VARCHAR(8) NOT NULL, 
DOB DATE, 
Gender VARCHAR(10), 
Job_position VARCHAR(20), 
Service_loc VARCHAR(30));

INSERT INTO Hostel_staff VALUES(2790,'Marie Jenkins','289 Dominain BLVD','Windsor','N987C5',DATE '2001-11-20','F','HallManager','Hall');
INSERT INTO Hostel_staff VALUES(2990,'Maria Cahoy','209 Industrila BLVD','Windsor','N907C5',DATE '1976-11-20','F','HallManager','Hall');

CREATE TABLE Staff_Login(
Staff_num VARCHAR(20) NOT NULL,
username VARCHAR(10) NOT NULL,
password VARCHAR(10) NOT NULL,
FOREIGN KEY (Staff_num) references Hostel_staff(Staff_num));

INSERT INTO Staff_Login VALUES(2790,'marijenk','6d2A!159');
INSERT INTO Staff_Login VALUES(2990,'maricaho','z5a@A84h');

Create Table Flat_Inspections(
flat_inspect_id VARCHAR(8),
DO_Inspection DATE, 
Satisfaction_cond VARCHAR(6) CHECK (Satisfaction_cond = 'Y' OR Satisfaction_cond = 'N'),
comments VARCHAR(50), 
Staff_num VARCHAR(10) NOT NULL, 
Flat_num VARCHAR(8) NOT NULL, 
FOREIGN KEY(Staff_num) REFERENCES Hostel_staff(Staff_num), 
FOREIGN KEY(Flat_num) REFERENCES Flats(Flat_num));

INSERT INTO Flat_Inspections VALUES(23456, DATE '2022-05-09', 'Y', 'excellent', '2790', '67');
INSERT INTO Flat_Inspections VALUES(12345, DATE '2022-06-20', 'Y', 'good', '2790', '56');
INSERT INTO Flat_Inspections VALUES(65432, DATE '2020-05-19', 'N', 'horrific', '2990', '67');
INSERT INTO Flat_Inspections VALUES(99882, DATE '2021-05-15', 'Y', 'amazing condition', '2990', '67');



CREATE TABLE Leases(
lease_num VARCHAR(8) NOT NULL,
hall_place_num VARCHAR(8),
flat_place_num VARCHAR(8),
student_id VARCHAR(8) NOT NULL,
lease_duration VARCHAR(20),
date_of_entry DATE,
date_of_exit DATE,
CHECK ((hall_place_num IS NOT NULL AND flat_place_num IS NULL ) OR ( hall_place_num IS NULL AND flat_place_num IS NOT NULL) ),
PRIMARY KEY (lease_num),
FOREIGN KEY (hall_place_num) references Hall_rooms(place_num),
FOREIGN KEY (flat_place_num) references Flat_rooms(place_num),
FOREIGN KEY (student_id) references Student(student_id));

INSERT INTO Leases VALUES(890,34,NULL,11124376, '2 semesters',DATE '2022-09-01',DATE '2023-01-01');
INSERT INTO Leases VALUES(790,NULL,30,12345678, '1 semester', DATE '2022-08-28',DATE '2023-04-28');



CREATE TABLE Invoice(
invoice_num VARCHAR(8) NOT NULL,
lease_num VARCHAR(8) NOT NULL,
student_id VARCHAR(8) NOT NULL,
payment_due DATE,
semester VARCHAR(8),
PRIMARY KEY (invoice_num),
FOREIGN KEY (lease_num) references Leases(lease_num),
FOREIGN KEY (student_id) references Student(student_id));

INSERT INTO Invoice VALUES(789098,890,11124376, DATE '2022-10-01','Fall');
INSERT INTO Invoice VALUES(678790,790,12345678, DATE '2022-09-28','Fall');



CREATE TABLE Receipt(
receipt_num VARCHAR(8) NOT NULL,
invoice_num VARCHAR(8) NOT NULL,
DO_payment DATE,
pay_method VARCHAR(8),
first_remind_date DATE,
second_remind_date  DATE,
PRIMARY KEY (receipt_num),
FOREIGN KEY (invoice_num) references Invoice(invoice_num));

INSERT INTO Receipt VALUES (27869,789098, DATE '2022-09-18','cash',DATE '2022-09-15', NULL);
INSERT INTO Receipt VALUES (27969,678790, DATE '2022-09-27','visa',DATE '2022-09-12', DATE '2022-09-21');



CREATE INDEX Grade_12_num_idx ON Student(grade_12_num);
CREATE INDEX special_Needs_idx ON Student(special_needs);


CREATE VIEW Student_public_view AS
SELECT student_id, student_fname, student_lname, deg_category, program 
FROM Student;



CREATE VIEW student_lease_info AS
SELECT l.student_id, l.lease_num, h.hall_name, f.flat_num,
CONCAT(COALESCE(h.place_num, ''), COALESCE(f.place_num, '')) as place_num, 
CONCAT(COALESCE(h.room_num, ''), COALESCE(f.room_num, '')) as room_num, 
CONCAT(COALESCE(h.monthly_rent, ''), COALESCE(f.monthly_rent, '')) as monthly_rent,
l.date_of_entry as date_of_entry,
l.date_of_exit as date_of_exit,
l.date_of_exit - l.date_of_entry as lease_duration
FROM Leases l
LEFT JOIN Hall_rooms h ON hall_place_num = h.place_num
LEFT JOIN Flat_rooms f ON flat_place_num = f.place_num;


