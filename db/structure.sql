create database if not exists microcms character set utf8 collate utf8_unicode_ci;
use microcms;

grant all privileges on microcms.* to 'microcms_user'@'localhost' identified by 'secret';

drop table if exists t_comment;
drop table if exists t_article;

create table t_article (
    art_id integer not null primary key auto_increment,
    art_title varchar(100) not null,
    art_content varchar(2000) not null
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table t_comment (
    com_id integer not null primary key auto_increment,
    com_author varchar(100) not null,
    com_content varchar(500) not null,
    art_id integer not null,
    constraint fk_com_art foreign key(art_id) references t_article(art_id)
) engine=innodb character set utf8 collate utf8_unicode_ci;

insert into t_comment(art_id, com_author, com_content) values
(1, 'John Doe', 'Great! Keep up the good work.');
insert into t_comment(art_id, com_author, com_content) values
(1, 'Ann Yone', "Thank you, I'll try my best.");
