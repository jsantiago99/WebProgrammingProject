use jsantiago;

DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS customer;
DROP TABLE IF EXISTS product;
DROP TABLE IF EXISTS users;

CREATE TABLE Customer (
    id int AUTO_INCREMENT,
    first_name varchar(255),
    last_name varchar(255),
    email varchar(255),
    PRIMARY KEY (id)
);


CREATE TABLE Product (
    id int AUTO_INCREMENT,
    product_name varchar(255),
    image_name varchar(255),
    price decimal(6,2),
    in_stock int,
    inactive tinyint,
    PRIMARY KEY (id)
);

CREATE TABLE Orders (
    id int AUTO_INCREMENT,
    product_id int,
    customer_id int,
    quantity int,
    price decimal(6,2),
    tax decimal(6,2),
    donation decimal(4,2),
    timestamp bigint,
    PRIMARY KEY (id),
    FOREIGN KEY (product_id) REFERENCES Product(id),
    FOREIGN KEY (customer_id) REFERENCES Customer(id)
);

CREATE TABLE Users (
    id int AUTO_INCREMENT,
    first_name varchar(255),
    last_name varchar(255),
    password varchar(255),
    email varchar(255),
    role int,
    PRIMARY KEY (id)
);


INSERT INTO Customer (first_name,last_name,email)
VALUES('Mickey', 'Mouse', 'mmouse@mines.edu');

INSERT INTO Customer (first_name,last_name,email)
VALUES('Donald', 'Duck', 'dduck@mines.edu');

INSERT INTO Product (product_name, image_name, price, in_stock, inactive)
VALUES('Monopoly', 'Monopoly.jpg', 19.99, 25, 0);

INSERT INTO Product (product_name, image_name, price, in_stock, inactive)
VALUES('Toy Car', 'Toy Car.jpg', 9.99, 3, 0);

INSERT INTO Product (product_name, image_name, price, in_stock, inactive)
VALUES('Clue', 'Clue.jpg', 14.99, 0, 1);


INSERT INTO Users (first_name,last_name, password, email, role)
VALUES('Frodo', 'Baggins', 'fb', 'fb@mines.edu', 1);

INSERT INTO Users (first_name,last_name, password, email, role)
VALUES('Harry', 'Potter', 'hp', 'hp@mines.edu', 2);





