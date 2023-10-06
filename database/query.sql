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
	name varchar(150) not null unique,
    Class_id int not null ,
	created_at timestamp,
	foreign key( Class_id) references Classroom(id)
);

create table Student_Exam_degree
(
	id int auto_increment primary key,
	Student_id int not null ,
    Exam_id int not null ,
    degree float ,
	foreign key( Student_id) references Student(id),
	foreign key( Exam_id) references Exam(id)

);