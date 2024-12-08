create database if not exists db_journalling;
use db_journalling;

-- TASKS ----
create table tb_task (
	id integer not null auto_increment primary key,
    task_description varchar(50) not null,
    task_completed boolean default false,
    task_priority varchar(20) null,
    project_id integer null,
    deadline date null,
    created_at date
);
select * from tb_task;

-- USUÁRIOS ----
create table tb_user (
	id integer not null auto_increment primary key,
    name varchar(50) not null,
    email varchar(50) not null,
    senha varchar(50) not null,
    active boolean default true,
    daysBeforeDeadline int default 3
);

-- PROJETO ----
create table tb_project (
	id integer auto_increment primary key,
    project_name varchar(50) not null,
    project_priority varchar(50) DEFAULT('BAIXA'),
    project_status varchar(20) default('BACKLOG'),
    user_id integer null,
    project_description varchar(512),
    created_at date,
    start_date date,
    deadline date
);

-- STATUS DE PROJETOS ----
create table tb_status (
	id integer auto_increment primary key,
    status varchar(20) not null
);
INSERT INTO tb_status (status) VALUES 
('BACKLOG'),
('EM_PROGRESSO'),
('CONCLUIDO'),
('PARADO'),
('ATRASADO'),
('CANCELADO');

-- PRIORIDADES DE PROJETOS ----
create table tb_priorities (
	id integer not null auto_increment primary key,
    priority varchar(20) not null
);
INSERT INTO tb_priorities (priority) VALUES 
('BAIXA'),
('MEDIA'),
('ALTA'),
('CRITICA');

-- ANOTAÇÕES/DIÁRIO ----
create table tb_note (
 id integer auto_increment primary key,
 content varchar(2048) not null,
 created_at date
);
	
-- 	CATEGORIAS ----
create table tb_category (
	id integer primary key auto_increment,
    category varchar(20)
)
