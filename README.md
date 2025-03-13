# airbnb-db-maker
Converts flat files from http://insideairbnb.com/get-the-data/ into a relational database


## Steps

* install mysql locally
* create mysql user `CREATE USER 'newusername'@'localhost' IDENTIFIED BY 'secure_password';`
* create database in mysql `CREATE DATABASE fakeAirbnb CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;`
* grant privileges `grant all privileges on fakeAirbnb.* to 'user'@'%' identified by 'password' ;`
* load schema from .sql schema file
