CREATE DATABASE gammascout;

CREATE USER gamma@localhost IDENTIFIED BY 'scout';
GRANT ALL ON gammascout.* TO gamma@localhost;
