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
   Id___role SERIAL,
   name___role VARCHAR(255)  NOT NULL,
   PRIMARY KEY(Id___role)
);


/*==============================================================*/
/* Table : category                                             */
/*==============================================================*/

CREATE TABLE category(
   Id_category SERIAL,
   name_category VARCHAR(255)  NOT NULL,
   valor_point_cat_egory INTEGER NOT NULL,
   PRIMARY KEY(Id_category),
   UNIQUE(name_category)
);


/*==============================================================*/
/* Table : __user                                               */
/*==============================================================*/

CREATE TABLE __user(
   Id___user SERIAL,
   name___user VARCHAR(255)  NOT NULL,
   password___user VARCHAR(255)  NOT NULL,
   quantity_points___user INTEGER NOT NULL,
   Id___role INTEGER NOT NULL,
   PRIMARY KEY(Id___user),
   FOREIGN KEY(Id___role) REFERENCES __role(Id___role)
);


/*==============================================================*/
/* Table : goods                                                */
/*==============================================================*/

CREATE TABLE goods(
   Id_goods SERIAL,
   img_goods VARCHAR(255)  NOT NULL,
   description_goods VARCHAR(255)  NOT NULL,
   status_goods BOOLEAN NOT NULL,
   Id_category INTEGER,
   Id___user_lender INTEGER NOT NULL,
   PRIMARY KEY(Id_goods),
   FOREIGN KEY(Id_category) REFERENCES category(Id_category),
   FOREIGN KEY(Id___user_lender) REFERENCES __user(Id___user)
);


/*==============================================================*/
/* Table : borrowing                                            */
/*==============================================================*/

CREATE TABLE borrowing(
   Id_borrowing SERIAL,
   start_borrowing DATE NOT NULL,
   end_borrowing DATE NOT NULL,
   Id___user_borrower INTEGER NOT NULL,
   Id_goods INTEGER NOT NULL,
   PRIMARY KEY(Id_borrowing),
   UNIQUE(Id_goods),
   FOREIGN KEY(Id___user_borrower) REFERENCES __user(Id___user),
   FOREIGN KEY(Id_goods) REFERENCES goods(Id_goods)
);



