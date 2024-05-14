CREATE TABLE roles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL
);

INSERT INTO roles (name) VALUES ('admin'), ('moderator'), ('employee'), ('customer');

create table user (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(320) NOT NULL,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    full_address VARCHAR(255),
    profile_picture VARCHAR(255),
    role_id INT NOT NULL REFERENCES Roles(id)
);

INSERT INTO user (username, email, password, role_id, profile_picture) VALUES ('admin', 'admin@admin.com', '$2y$10$eM66P7j29i1sV3/l/N1t9u.wf055h.TIosWCSjj0ay5WasB4H4wOq', 1, 'shrek.jpeg');

create table product_category (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL
);

INSERT INTO product_category (name) VALUES ('electronics'), ('clothing'), ('furniture'), ('food'), ('beauty'), ('sports');

create table product (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    company_price DECIMAL(10,2) NOT NULL,
    sale_price DECIMAL(10,2) NOT NULL,
    category_id INT NOT NULL REFERENCES product_category(id)
);

create table order_status (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL
);

INSERT INTO order_status (name) VALUES ('pending'), ('processing'), ('shipped'), ('delivered'), ('cancelled');

create table order_ (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL REFERENCES user(id),
    status VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

create table order_product (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL REFERENCES order_(id),
    product_id INT NOT NULL REFERENCES product(id),
    quantity INT NOT NULL,
    sale_price DECIMAL(10,2) NOT NULL,
    company_price DECIMAL(10,2) NOT NULL
);
