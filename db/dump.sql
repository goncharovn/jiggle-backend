create table products
(
    id          int auto_increment
        primary key,
    title       text   null,
    price       double null,
    description text   null
);

create table img
(
    id         int auto_increment
        primary key,
    img_name   text null,
    product_id int  null,
    constraint img_products_id_fk
        foreign key (product_id) references products (id)
);

create table users
(
    id              int auto_increment
        primary key,
    name            text             null,
    email           varchar(100)     null,
    password        varchar(255)     null,
    hash            varchar(255)     null,
    email_confirmed bit default b'0' not null
);