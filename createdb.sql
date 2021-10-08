drop database products;
create database products;
use products;


create table product_type
(
	id integer unsigned primary key,
	product_type_name varchar(64) not null,
	product_type_description varchar(64) not null,
	type_attributes_format_string varchar(64)
);


create table product 
(
	id integer unsigned auto_increment primary key ,
	product_sku varchar(128) not null,
	product_name varchar(64) not null,
	product_price double not null,
	product_type integer unsigned not null,
	
	foreign key (product_type) references product_type(id)
);


create table product_type_attribute
(
	id integer unsigned primary key,
	product_type_attribute_name varchar(64) not null,
	product_type_attribute_unit varchar(64),
	
	product_type_id integer unsigned not null,
	
	foreign key (product_type_id) references product_type(id)
);


create table product_and_product_attribute_value
(
	product_attribute_id integer unsigned not null,
	product_id integer unsigned not null,
	product_attribute_value double not null,
	
	foreign key (product_attribute_id) references product_type_attribute(id),
	foreign key (product_id) references product(id)
);


insert into product_type
(id, product_type_name, type_attributes_format_string, product_type_description)	values
(1, "DVD", "%sMB", "size"),
(2, "Book", "%sKG", "weight"),
(3, "Furniture", "%sx%sx%s", "dimensions");


insert into product_type_attribute
(id, product_type_attribute_name, product_type_id, product_type_attribute_unit) values
(100, "Size", 1, "MB"), /*dvd size*/
(101, "Weight", 2, "KG"),/*book weight*/
(102, "Height", 3, "CM"),/*furniture height*/
(103, "Width", 3, "CM"),/*furniture width*/
(104, "Length", 3, "CM");/*furniture length*/


insert into product
(id, product_sku, product_name, product_price, product_type) values
(10, "D394384", "DVD red", 3.99, 1),
(11, "B434K34", "Book green", 30.99, 2),
(12, "F343422", "Furniture blue", 300.99, 3),
(13, "D2342", "DVD pink", 7.99, 1),
(14, "D67353", "DVD grey", 8.99, 1),
(15, "D2345234567", "DVD gold", 17.99, 1),

(16, "D345345", "DVD yellow", 4.99, 1),
(17, "B55555", "Book cyan", 31.99, 2),
(18, "F345345", "Furniture black", 400.99, 3),
(19, "D66345", "DVD silver", 8.99, 1),
(20, "D55533322", "DVD wood", 9.99, 1),
(21, "D5533254", "DVD airplane", 18.99, 1),

(22, "DG34343", "DVD gerald", 17.99, 1);


insert into product_and_product_attribute_value
(product_attribute_id, product_id, product_attribute_value) values
(100, 10, 4700),/*dvd red size value*/
(101, 11, 0.820),/*book green weight*/
(102, 12, 22),/*furniture blue Height*/
(103, 12, 23),/*furniture blue Width*/
(104, 12, 24),/*furniture blue Length*/
(100, 13, 3700),/*dvd pink size value*/
(100, 14, 3700),/*dvd grey size value*/
(100, 15, 3700),/*dvd gold size value*/

(100, 16, 4700),/*dvd yellow size value*/
(101, 17, 0.820),/*book cyan weight*/
(102, 18, 22),/*furniture black Height*/
(103, 18, 23),/*furniture black Width*/
(104, 18, 24),/*furniture black Length*/
(100, 19, 3700),/*dvd silver size value*/
(100, 20, 3700),/*dvd wood size value*/
(100, 21, 3700),/*dvd airplane size value*/

(100, 22, 3700);/*dvd gerald size value*/




