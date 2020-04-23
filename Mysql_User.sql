# 사용자 계정용 DB CREATE 
CREATE DATABASE user default CHARACTER SET UTF8 collate utf8_general_ci;

# profile table 생성 쿼리문 

CREATE TABLE profile (
    id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(50) NOT NULL,
    nickname varchar(30) NOT NULL,
    password varchar(255) NOT NULL,
    tel varchar(20) NOT NULL,
    email varchar(255) NOT NULL,
    gender ENUM("F", "M"),
    creationtime TIMESTAMP  NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE blacklist (
    id int(11) NOT NULL AUTO_INCREMENT,
    token text NOT NULL,
    expireTime int(10) NOT NULL,
    creationtime TIMESTAMP  NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

# index 추가 
alter table profile add index nameindex (name);
alter table profile add index emailindex (email);



