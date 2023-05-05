/*==============================================================*/
/* Nom de SGBD :  Postgres 14                                   */
/* Date de création :  27/04/2023                               */
/*==============================================================*/

DROP DATABASE if EXISTS ecf_php_florian;
CREATE DATABASE ecf_php_florian;

drop table if exists borrowing;

drop table if exists goods;

drop table if exists __user;

drop table if exists category;

drop table if exists __role;


/*==============================================================*/
/* Table : __role                                               */
/*==============================================================*/

CREATE TABLE __role(
   id___role SERIAL,
   name___role VARCHAR(255)  NOT NULL,
   PRIMARY KEY(id___role)
);


/*==============================================================*/
/* Table : category                                             */
/*==============================================================*/

CREATE TABLE category(
   id_category SERIAL,
   name_category VARCHAR(255)  NOT NULL,
   valor_point_cat_egory INTEGER NOT NULL,
   PRIMARY KEY(id_category),
   UNIQUE(name_category)
);


/*==============================================================*/
/* Table : __user                                               */
/*==============================================================*/

CREATE TABLE __user(
   id___user SERIAL,
   name___user VARCHAR(255)  NOT NULL,
   password___user VARCHAR(255)  NOT NULL,
   quantity_points___user INTEGER DEFAULT 0 ,
   id___role INTEGER NOT NULL,
   PRIMARY KEY(id___user),
   FOREIGN KEY(id___role) REFERENCES __role(id___role)
);


/*==============================================================*/
/* Table : goods                                                */
/*==============================================================*/

CREATE TABLE goods(
   id_goods SERIAL,
   name_goods VARCHAR(255)  NOT NULL,
   img_goods VARCHAR(255)  NOT NULL,
   description_goods VARCHAR(255)  NOT NULL,
   status_goods BOOLEAN NOT NULL DEFAULT true,
   id_category INTEGER,
   id___user_lender INTEGER NOT NULL,
   PRIMARY KEY(id_goods),
   FOREIGN KEY(id_category) REFERENCES category(id_category),
   FOREIGN KEY(id___user_lender) REFERENCES __user(id___user)
);


/*==============================================================*/
/* Table : borrowing                                            */
/*==============================================================*/

CREATE TABLE borrowing(
   id_borrowing SERIAL,
   start_borrowing DATE NOT NULL,
   end_borrowing DATE NOT NULL,
   id___user_borrower INTEGER NOT NULL,
   id_goods INTEGER NOT NULL,
   PRIMARY KEY(id_borrowing),
   UNIQUE(id_goods),
   FOREIGN KEY(id___user_borrower) REFERENCES __user(id___user),
   FOREIGN KEY(id_goods) REFERENCES goods(id_goods)
);



