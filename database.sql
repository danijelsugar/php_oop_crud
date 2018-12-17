drop database if exists oop_crud;

create database oop_crud default character set utf8;

#sipanje baze
#c:\xampp\mysql\bin\mysql -uedunova -pedunova --default_character_set=utf8 < E:\htdocs\php_oop_crud_my\database.sql


use oop_crud;

CREATE TABLE products (
	id int not null primary key AUTO_INCREMENT,
	fullname varchar(32) not null,
	description text not null,
	price int not null,
	category_id int not null,
	created datetime,
	modified timestamp
);

create table category (
	id int not null primary key AUTO_INCREMENT,
	fullname varchar(256) not null,
	created datetime not null,
	modified timestamp not null
);

alter table products add foreign key (category_id) references category(id);