create database Student_Dashboard;
use Student_Dashboard;
create table Admin
(
	id int auto_increment primary key,
	name varchar(150) not null,
	password varchar(150) not null
);

create table Teacher
(
	id int auto_increment primary key,
	name varchar(150) not null,
	password varchar(150) not null,
    SSN varchar(150)not null,
    Email varchar(150) not null,
    created_at timestamp,
    updated_at timestamp,
    Admin_id int not null ,
    foreign key(Admin_id) references Admin(id)
);
create table Student
(
	id int auto_increment primary key,
	name varchar(150) not null,
	password varchar(150) not null,
    SSN varchar(150)not null,
    Email varchar(150) not null,
	PEmail varchar(150) not null,
	Pphone varchar(50) not null,
	Grade varchar(15) not null,
    created_at timestamp,
    updated_at timestamp,
    birth_date timestamp not null,
    Admin_id int not null ,
    foreign key(Admin_id) references Admin(id)
);


create table Classroom
(
	id int auto_increment primary key,
    name varchar(150) not null unique,
    Descriprion text not null ,
    Constrains text not null ,    
	created_at timestamp,
    updated_at timestamp,
    Teacher_id int not null,
    foreign key( Teacher_id) references Teacher(id)
);




create table Student_Class_registe 
(
	id int auto_increment primary key,
    Class_id int not null ,
    Student_id int not null ,
	created_at timestamp,
    foreign key( Student_id) references Student(id),
    foreign key( Class_id) references Classroom(id)
);

create table Student_Classroom_attend
(
	id int auto_increment primary key,
    Class_id int not null ,
    Student_id int not null ,
	created_at timestamp,
    status varchar(10),
    foreign key( Student_id) references Student(id),
    foreign key( Class_id) references Classroom(id)
);


create table Exam
(
	id int auto_increment primary key,
	name varchar(150) not null ,
    Class_id int not null ,
	created_at timestamp,
	total_degree float,
	updated_at timestamp,
	foreign key( Class_id) references Classroom(id)
);
alter table Exam 
add column  number int not null;
alter table Exam
add constraint unique_number_class_id UNIQUE (number, Class_id);
create table Student_Exam_degree
(
	id int auto_increment primary key,
	Student_id int not null ,
    Exam_id int not null ,
    degree float default 0 ,
	foreign key( Student_id) references Student(id),
	foreign key( Exam_id) references Exam(id)

);
alter table classroom
add column code varchar(15) not null unique;
use Student_Dashboard;
select * from Admin;
select *from Teacher;
select * from Student;
select * from classroom;
select * from Student_Class_registe;
select * from Exam;
select * from Student_Exam_degree;
select * from Student_Classroom_attend;

 /**********************************
ALTER TABLE Teacher AUTO_INCREMENT = 1;
ALTER TABLE Student AUTO_INCREMENT = 1;
ALTER TABLE classroom AUTO_INCREMENT = 1;
ALTER TABLE Student_Classroom_attend AUTO_INCREMENT = 1;
ALTER TABLE Student_Exam_degree AUTO_INCREMENT = 1;
ALTER TABLE Student_Class_registe AUTO_INCREMENT = 1;
ALTER TABLE Exam AUTO_INCREMENT = 1;
****************************************/