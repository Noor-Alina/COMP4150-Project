
-- 1 Get details of if student is placed in room.
DECLARE
    s_id VARCHAR2(8);
    fname VARCHAR2(8);
    room_status VARCHAR2(8);
    dob DATE;
    room_num NUMBER;
    passed_inspection CHAR(1);
    placed BOOLEAN;

BEGIN
    SELECT student_id, student_fname, DOB, current_status INTO s_id, fname, dob, room_status FROM Student WHERE student_id = 12345678;

    IF room_status = 'placed' THEN
        placed := TRUE;
    END IF;
    
    IF placed THEN 
        SELECT fr.room_num, fi.Satisfaction_cond INTO room_num, passed_inspection FROM Leases le, Flats fl, Flat_rooms fr, Flat_Inspections fi WHERE s_id = le.student_id AND le.flat_place_num = fr.place_num AND fr.flat_num = fl.flat_num AND fl.flat_num = fi.Flat_num;
        dbms_output.put_line('Name - '||fname||' DOB - '||dob||' Room number - '||room_num||' Passed Inspection -'||passed_inspection);
    ELSE
        dbms_output.put_line(fname||' isnt placed in a room');
    END IF;

END;


-- 2 Check if a student id corresponds to a student.
ACCEPT x VARCHAR2(8) PROMPT 'Enter the student id';

DECLARE 
    s_id VARCHAR2(8):= &x;
    fname student.student_fname%TYPE;
    dob student.DOB%TYPE;
    student_exists NUMBER;

BEGIN
    SELECT COUNT(*) INTO student_exists FROM Student WHERE student_id = s_id;

    IF student_exists > 0 THEN
        SELECT student_fname, dob INTO fname, dob FROM Student WHERE student_id = s_id;
        dbms_output.put_line('ID '||s_id||' belongs to '||fname||' who was born ' ||dob);
    ELSE
        dbms_output.put_line('ID '||s_id||' doesnt belong to any student');
    END IF;

END;


-- 3 Check if a student is 21 yet.
DECLARE
    s_id VARCHAR2(8):= 11124376;
    fname student.student_fname%TYPE;
    dob student.DOB%TYPE;
    student_exists NUMBER;

BEGIN
    SELECT COUNT(*) INTO student_exists FROM Student WHERE student_id = s_id;

    IF student_exists > 0 THEN
        SELECT student_fname, dob INTO fname, dob FROM Student WHERE student_id = s_id;
        dbms_output.put_line('ID '||s_id||' belongs to '||fname||' who was born ' ||dob);
        
        IF dob > DATE '2002-01-01' THEN
            dbms_output.put_line('This student is not 21 yet.');
        ELSE
            dbms_output.put_line('This student is 21 or older.');
        END IF;
    ELSE
        dbms_output.put_line('ID '||s_id||' doesnt belong to any student');
    END IF;

END;

-- 4. Raise exception if advisor id < 0 and if id does not exist.
DECLARE
    a_id Staff_Advisor.advisor_id%type := &ad_id;
    a_fname Staff_Advisor.advisor_fname%type;
    a_lname Staff_advisor.advisor_lname%type;
    a_dptname Staff_Advisor.dept_name%type;
    
    -- User desfined Exceptions
         invalid_aid EXCEPTION;
         
BEGIN
    IF a_id <= 0 THEN 
        RAISE invalid_aid;
    
    ELSE
        SELECT advisor_fname, advisor_lname, deptname INTO a_fname, a_lname, a_dptname
        FROM Staff_Advisor
        WHERE advisor_id = a_id; 
        
        DBMS_OUTPUT.PUT_LINE ('Advisor ID:' || a_id);
        DBMS_OUTPUT.PUT_LINE ('Advisor Name:' || a_fname || ' ' || a_lname);
        DBMS_OUTPUT.PUT_LINE ('Advisors Department:' || a_dptname);
    END IF;
    
    
EXCEPTION
    WHEN invalid_id THEN
        DBMS_OUTPUT.PUT_LINE ('Advisor ID must be greater than Zaro.');
    WHEN no_data_found THEN
        DBMS_OUTPUT.PUT_LINE ('No Advisor with that ID exists.');
    WHEN others THEN
        DBMS_OUTPUT.PUT_LINE ('Error.');

END;
/


-- 5. Cursor for returning more than one row, returing all rows with advisor id, name and department name
DECLARE
    a_id Staff_Advisor.advisor_id%type;
    a_fname Staff_Advisor.advisor_fname%type;
    a_lname Staff_advisor.advisor_lname%type;
    a_dptname Staff_Advisor.dept_name%type;
    
    -- Declaring Explicit Cursor
         CURSOR a_advisors IS 
            SELECT advisor_id, advisor_fname, advisor_lname, dept_name FROM Staff_Advisor;
         
BEGIN
    -- Opening Cursor
    OPEN a_advisors;
    
    LOOP
    
    -- Fetching: accessing each row values into declared variables.
    FETCH a_advisors INTO a_id, a_fname, a_lname, a_dptname;
        EXIT WHEN a_advisors%NOTFOUND;

        DBMS_OUTPUT.PUT_LINE (a_id || ' ' || a_fname || ' ' || a_lname || ' ' ||a_dptname);
    END LOOP;
    
    -- close cursor to release allocated memory
    CLOSE a_advisors;
END;
/


-- 6.This Function would be helpful to find the advisor of a student based on the student Id 

 

CREATE OR REPLACE FUNCTION s_name(stuid NUMBER)  

RETURN VARCHAR2 IS  

	s_fname student.student_fname%TYPE;  

	s_lname student.student_lname%TYPE;  

	aid student.advisor_id%TYPE;  

BEGIN  

	SELECT student_fname,student_lname,advisor_id INTO s_fname,s_lname,aid FROM student   

	WHERE student.student_id=stuid;  

RETURN ('student ID:'||stuid||'---Student First Name:'||s_fname||'---Student Last Name:'||s_lname);  

END; 

 

-- Testing: 


DECLARE  

	stuid NUMBER := 11124376; -- pick an student ID to test the function  

BEGIN  

	DBMS_OUTPUT.PUT_LINE( s_name(stuid));  

END; 

 

 

-- 7. This procedure would be helpful if a new student needs to be added in the database  

 

CREATE OR REPLACE PROCEDURE student_details( 

stuid           IN Student.student_id%TYPE, 

sfname          IN Student.student_fname%TYPE, 

slname        IN Student.student_lname%TYPE, 

g12num          IN Student.grade_12_num%TYPE, 

st_num          IN Student.street%TYPE, 

city            IN Student.city%TYPE, 

postalcode      IN Student.postal_code%TYPE, 

D_O_B           IN Student.DOB%TYPE, 

Gen             IN Student.gender%TYPE, 

Degree          IN Student.deg_category%TYPE, 

s_nationality   IN Student.nationality%TYPE, 

s_needs         IN Student.special_needs %TYPE, 

comments        IN Student.additional_comments %TYPE, 

status          IN Student.current_status%TYPE, 

s_program       IN Student.program%TYPE, 

a_id            IN Student.advisor_id%TYPE 

) 

IS 

Begin 

	insert into student values(stuid,sfname,slname,g12num,st_num,city,postalcode,D_O_B,Gen,Degree,s_nationality,s_needs,comments,status,s_program,a_id); 

	dbms_output.put_line('Student table Updated'); 

end; 

 

-- Testing: 


BEGIN 

	student_details(11524376,'Smith','Will',107,'308 - 15th Ave','Windsor ','N9C1A9E',DATE '2002-08-08','Female','Post Graduate','Canadian','Dietary','pollen Allergy','placed','Computer science',58173019); 

END; 

 

   -- 8.This package counts the hostel staff and counts the student population so that its useful to compare the student to staff ratio.  
 
CREATE  
OR  
replace package staff_count IS FUNCTION count_staffRETURN number;FUNCTION count_studentRETURN number;END 
staff_count;CREATE  
OR  
replace package body staff_count IS FUNCTION count_staffRETURN number IS s_result number;BEGIN  
  SELECT Count(*)  
  INTO   s_result  
  FROM   hostel_staff ;  
    
  RETURN s_result;  
END;FUNCTION count_studentRETURN number IS stu_result number;BEGIN  
  SELECT Count(*)  
  INTO   stu_result  
  FROM   student ;  
    
  RETURN stu_result;  
END;END  
staff_count; 
 
TESTING: 
 
BEGIN  
  dbms_output.put_line ('Number of staff in the hostel residence is :');  
  dbms_output.put_line (staff_count.count_staff);  
  dbms_output.put_line ('Number of Students in the hostel residence is :');  
  dbms_output.put_line (staff_count.count_student);  
end; 

-- 9. Creating trigger for every insert, update and delete into Staff_Advisor table.
CREATE OR REPLACE TRIGGER display_advisor_changes
BEFORE DELETE OR INSERT OR UPDATE OF dept_name
ON Staff_Advisor
FOR EACH ROW
BEGIN
    CASE
    WHEN INSERTING THEN
        dbms_output.put_line('Inserting row into Staff_Advisor table');
       
    WHEN UPDATING('dept_name') THEN
        dbms_output.put_line('Updating Department for a row in Staff_Advisor');
        
    WHEN  DELETING THEN
        dbms_output.put_line('Deleting a row in Staff_Advisor table');
    END CASE;
END;
/

-- testing INSERT

INSERT INTO Staff_advisor VALUES('58134919', 'Jane', 'Doe','ResidenceAdvisor ','Residence',2265791236,254);
INSERT INTO Staff_advisor VALUES('53473019', 'Bob', 'Brent','Advisor ','Hall',2265723876,230);

Select * from Staff_Advisor;

-- testing UPDATE

UPDATE Staff_Advisor 
SET dept_name = 'Flats'
WHERE advisor_id = '58134919';

Select * from Staff_Advisor;

-- testing DELETE

DELETE FROM Staff_Advisor
WHERE Advisor_id = '53473019';

Select * from Staff_Advisor;
