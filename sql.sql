-- Created by Vertabelo (http://vertabelo.com)
-- Last modification date: 2016-07-11 09:05:47.829

-- tables
-- Table: changed_time
CREATE TABLE changed_time (
    id int NOT NULL,
    check_in_id int NOT NULL,
    check_out_id int NOT NULL,
    time datetime NOT NULL,
    user_id int NOT NULL,
    CONSTRAINT changed_time_pk PRIMARY KEY (id)
);

-- Table: check_in
CREATE TABLE check_in (
    id int NOT NULL,
    user_id int NOT NULL,
    time datetime NOT NULL,
    CONSTRAINT id PRIMARY KEY (id)
);

-- Table: check_out
CREATE TABLE check_out (
    id int NOT NULL,
    user_id int NOT NULL,
    time datetime NOT NULL,
    CONSTRAINT check_out_pk PRIMARY KEY (id)
);

-- Table: login_logout
CREATE TABLE login_logout (
    id int NOT NULL,
    user_id int NOT NULL,
    login_time datetime NOT NULL,
    logout_time datetime NOT NULL,
    CONSTRAINT login_logout_pk PRIMARY KEY (id)
);

-- Table: user
CREATE TABLE `user` (
    id int NOT NULL,
    username varchar(50) NOT NULL,
    password varchar(70) NOT NULL,
    salt int(32) NOT NULL,
    role bit NOT NULL,
    fullname varchar(100) NOT NULL,
    date_of_birth datetime NOT NULL,
    created_date datetime NOT NULL,
    CONSTRAINT user_pk PRIMARY KEY (id)
);

-- foreign keys
-- Reference: Check_in_user (table: check_in)
ALTER TABLE check_in ADD CONSTRAINT Check_in_user FOREIGN KEY Check_in_user (user_id)
    REFERENCES `user` (id);

-- Reference: Check_out_user (table: check_out)
ALTER TABLE check_out ADD CONSTRAINT Check_out_user FOREIGN KEY Check_out_user (user_id)
    REFERENCES `user` (id);

-- Reference: changed_time_check_in (table: changed_time)
ALTER TABLE changed_time ADD CONSTRAINT changed_time_check_in FOREIGN KEY changed_time_check_in (check_in_id)
    REFERENCES check_in (id);

-- Reference: changed_time_check_out (table: changed_time)
ALTER TABLE changed_time ADD CONSTRAINT changed_time_check_out FOREIGN KEY changed_time_check_out (check_out_id)
    REFERENCES check_out (id);

-- Reference: changed_time_user (table: changed_time)
ALTER TABLE changed_time ADD CONSTRAINT changed_time_user FOREIGN KEY changed_time_user (user_id)
    REFERENCES `user` (id);

-- Reference: login_logout_user (table: login_logout)
ALTER TABLE login_logout ADD CONSTRAINT login_logout_user FOREIGN KEY login_logout_user (user_id)
    REFERENCES `user` (id);

-- End of file.

