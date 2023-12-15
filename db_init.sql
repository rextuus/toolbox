CREATE USER 'toolbox_user'@'localhost' IDENTIFIED BY 'password';
CREATE USER 'toolbox_user'@'%' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON * . * TO 'toolbox_user'@'%';
GRANT ALL PRIVILEGES ON * . * TO 'toolbox_user'@'localhost';
FLUSH PRIVILEGES;
CREATE DATABASE toolbox;