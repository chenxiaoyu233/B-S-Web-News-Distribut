set foreign_key_checks = 0;

drop table if exists User;
create table User (
	userName varchar(20) primary key,
	password varchar(20) not null,
	permission enum('root', 'admin', 'user', 'other') not null
) charset utf8;

drop table if exists UserMeta;
create table UserMeta (
	userName varchar(20),
	nickName varchar(20),
	photo mediumblob, 
	email varchar(40), 
	phoneNumber varchar(20),
	birthDay date,
	sex varchar(1),
	primary key (userName),
	foreign key (userName) references User(userName) 
	on delete cascade
	-- userName 不允许修改, 故不加on update选项
) charset utf8;

drop table if exists Follow;
create table Follow (
	followerID varchar(20),
	beFollowerID varchar(20),
	primary key (followerID, beFollowerID),
	foreign key (followerID) references User(userName) 
	on delete cascade,
	foreign key (beFollowerID) references User(userName) 
	on delete cascade
	-- userName 不允许修改, 故不加on update选项
) charset utf8;

drop table if exists Article;
create table Article (
	articleID varchar(20) primary key,
	`type` enum('news', 'comment') not null,
	articleStatus enum('accept', 'reject', 'verify') not null,
	title text not null,
	userName varchar(20) not null,
	time datetime not null,
	upVoteCount int not null default 0,
	foreign key (userName) references User(userName) 
	on delete cascade
	-- userName 不允许修改, 故不加on update选项
) charset utf8;

drop table if exists Manuscript;
create table Manuscript (
	userName varchar(20) not null,
	articleID varchar(20) not null,
	primary key (userName, articleID),
	foreign key (userName) references User(userName) 
	on delete cascade,
	foreign key (articleID) references Article(articleID) 
	on delete cascade
	-- userName 不允许修改, 故不加on update选项
	-- articleID 不允许修改, 故不加on update选项
) charset utf8;

drop table if exists Collection;
create table Collection (
	userName varchar(20) not null,
	articleID varchar(20) not null,
	primary key (userName, articleID),
	foreign key (userName) references User(userName) 
	on delete cascade,
	foreign key (articleID) references Article(articleID) 
	on delete cascade
	-- userName 不允许修改, 故不加on update选项
	-- articleID 不允许修改, 故不加on update选项
) charset utf8;

drop table if exists Category;
create table Category (
	categoryName varchar(255) primary key,
	fatherCategory varchar(255), 
	foreign key (fatherCategory) references Category(categoryName)
	on update cascade -- 目录更新的时候级联
	-- 删除目录的时候必须保证子目录下面没有东西了
) charset utf8;

drop table if exists Belong;
create table Belong (
	articleID varchar(20) not null,
	categoryName varchar(255) not null,
	primary key (articleID, categoryName),
	foreign key (articleID) references Article(articleID)
	on delete cascade, -- 文章删除的时候, 同时删除这条记录
					   -- 文章ID不允许修改, 所以不加上on update的操作
	foreign key (categoryName) references Category(categoryName)
	on delete cascade -- 目录删除之后, 属于关系解除
	on update cascade -- 目录名字修改过后, 在这个表里面跟进修改
) charset utf8;

drop table if exists `Comment`;
create table `Comment` (
	articleID varchar(20) not null primary key,
	commentID varchar(20) not null,
	foreign key (articleID) references Article(articleID) 
	on delete cascade, -- 文章删除之后, 两者之间的comment关系消失
	foreign key (commentID) references Article(articleID) 
	on delete cascade -- 评论删除之后, 两者之间的comment关系消失
) charset utf8;

drop table if exists ArticleMeta;
create table ArticleMeta (
	articleID varchar(20) not null primary key,
	articleContent longtext,
	foreign key (articleID) references Article(articleID) 
	on delete cascade -- 在文章被删除的时候, 同时删除内容
) charset utf8;

drop table if exists Material;
create table Material (
	materialID varchar(20) not null primary key,
	materialFileName varchar(255) not null,
	materialContent longblob
) charset utf8;

set foreign_key_checks = 1;
