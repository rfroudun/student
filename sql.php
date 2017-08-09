用户表：
create table user(
uid smallint primary key auto_increment,
username char(20) not null default "",
password char(255) not null default ""
);

班级表：
create table grade(
gid smallint primary key auto_increment,
gname char(20) not null default ''
);

学生表:
create table stu(
sid smallint primary key auto_increment,
sname char(15) not null default '',
birthday date,
sex enum('男','女') not null default '男',
hobby set('篮球','足球','乒乓球') not null default '篮球',
profile varchar(255) not null default '',
gid smallint unsigned not null default 0
);


素材表:
create table material(
mid smallint primary key auto_increment,
path varchar(255) not null default '',
create_time int unsigned not null default 0
);








