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
 title varchar(256) null,
 content varchar(2048) not null,
 created_at date
);
	
-- 	CATEGORIAS ----
create table tb_category (
	id integer primary key auto_increment,
    category varchar(20)
)



-- Migration --
INSERT INTO tb_user (name, email, senha, active, daysBeforeDeadline) VALUES
('João Silva', 'joao.silva@email.com', '897adfs', true, 3),
('Maria Oliveira', 'maria.oliveira@gmail.com', 'P@ssW0rD!', true, 3),
('Carlos Pereira', 'carlos.pereira@yahoo.com', '65dsgf4sda', true, 3),
('Ana Costa', 'ana.costa@email.com', 'senha101', true, 3),
('Fernanda Santos', 'fernanda.santos@example.com', 'senha', true, 3),
('Administrator', 'admin@journalling.com', '1A!dM1n#202$Sec', true, 3);

INSERT INTO tb_project (project_name, project_priority, project_status, user_id, project_description, created_at, start_date, deadline) VALUES
('Desenvolvimento de Aplicativo', 'ALTA', 'EM_PROGRESSO', 1, 'Aplicativo para gerenciamento de tarefas.', '2024-10-01', '2024-10-05', '2024-12-01'),
('Site Institucional', 'MEDIA', 'BACKLOG', 2, 'Criação de um site para a empresa.', '2024-10-02', '2024-10-10', '2024-11-15'),
('Sistema de Vendas', 'CRITICA', 'ATRASADO', 3, 'Sistema para controle de vendas e estoque.', '2024-09-15', '2024-09-20', '2024-10-30'),
('Atualização de Software', 'BAIXA', 'CONCLUIDO', 4, 'Atualização da versão do software existente.', '2024-08-01', '2024-08-05', '2024-09-01'),
('Pesquisa de Mercado', 'MEDIA', 'PARADO', 5, 'Pesquisa para entender o comportamento do consumidor.', '2024-09-10', '2024-09-15', '2024-10-10'),
('Implementação de CRM', 'ALTA', 'BACKLOG', 6, 'Implementação de um sistema de CRM para a equipe de vendas.', '2024-10-03', '2024-10-07', '2024-12-15');

INSERT INTO tb_task (task_description, task_completed, task_priority, project_id, deadline, created_at) VALUES
('Definir requisitos do aplicativo', false, 'ALTA', 1, '2023-10-15', '2023-10-01'),
('Criar layout do site', false, 'MEDIA', 2, '2023-10-20', '2023-10-02'),
('Desenvolver módulo de vendas', false, 'CRITICA', 3, '2023-10-25', '2023-09-15'),
('Testar nova versão do software', false, 'BAIXA', 4, '2023-09-10', '2023-08-01'),
('Analisar dados da pesquisa', false, 'MEDIA', 5, '2023-10-05', '2023-09-10'),
('Configurar sistema de CRM', false, 'ALTA', 6, '2023-12-01', '2023-10-03');
