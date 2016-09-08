-- 创建booking数据库
create database booking charset utf8;

-- 使用booking数据库
use booking;

-- 创建管理员表
create table cl_admin(
ad_id int not null primary key auto_increment,
ad_num char(11) not null comment '管理员账号',
ad_name varchar(10) not null comment '用户名',
ad_pass char(40) not null comment '用户密码SHA1加密',
ad_sex char(1) not null default 'f' comment '性别f为女m为男',
ad_email varchar(60) not null comment '邮箱',
ad_level tinyint not null default 2 comment '用户级别 2'

)charset utf8 engine = innodb;

-- 插入一个管理员用户
insert into cl_admin values (null,121,'admin',SHA1('admin'),default,'12115011064@qq.com',2);

-- 创建学生表
create table cl_student(
stu_id int not null primary key auto_increment,
stu_num char(11) not null comment '学生学号',
stu_name varchar(10) not null comment '学生姓名',
stu_pass char(40) not null comment '学生密码',
stu_sex char(1) not null default 'm' comment '性别f为女m为男',
stu_coll_name varchar(20) not null comment '所在系名称',
stu_grade_name varchar(20) not null comment '班级名称',
stu_email varchar(60) not null comment '邮箱',
stu_level tinyint not null default 1 comment '用户级别 1'
)charset utf8 engine = innodb;

-- 创建教师表
create table cl_teacher(
tea_id int not null primary key auto_increment,
tea_num char(11) not null comment '教师工号',
tea_name varchar(10) not null comment '教师姓名',
tea_pass char(40) not null comment '教师密码',
tea_sex char(1) not null default 'm' comment '性别f为女m为男',
tea_coll_name varchar(20) comment '所在系名称',
tea_department varchar(20) comment '所在部门',
tea_email varchar(60) not null comment '邮箱',
tea_level tinyint not null default 1 comment '用户级别' 
)charset utf8 engine = innodb;

-- 创建教学楼表
create table cl_building(
build_id int not null primary key auto_increment,
build_name varchar(20) not null comment '教学楼名称',
build_num char(1) not null comment '教学楼编号',
build_pic varchar(255) not null comment '图片路径'
)charset utf8 engine = innodb;
alter table cl_building add column build_text text(65535) not null comment '教学楼简介';
-- 创建课室表
create table cl_class(
class_id int not null primary key auto_increment,
build_name varchar(20) not null comment '教学楼名称',
build_num char(1) not null comment '教学楼编号',
class_num int not null comment '课室号',
class_contain_num int not null comment '课室容纳人数',
class_type char(1) not null comment '课室类型c（common）为普通，s（standar）为标准',
class_status char(1) not null default 'o' comment '课室状态f（free）为空闲状态，o（occupy）为占用状态'
)charset utf8 engine = innodb;
-- 增加字段
alter table cl_class add column class_time char(11) not null comment '课室可使用的时间';
-- 创建订单表
create table cl_order(
order_id int not null primary key auto_increment,
build_name varchar(20) not null comment '教学楼名称',
build_num char(4) not null comment '教学楼编号',
class_num int not null comment '课室号',
class_type char(1) not null comment '课室类型C（common）为普通，S（standar）为标准',
order_time char(11) not null comment '预定时间段',
order_date datetime not null comment '预定日期',
order_username varchar(10) not null comment '预定者姓名'
)charset utf8 engine = innodb;
-- 增加字段
alter table cl_order add column order_status char(3) not null default 'on' comment '预约信息是否已经处理，on代表正在，off代表已经处理';
alter table cl_order add column order_result varchar(6) not null default 'reject' comment '预约信息处理结果，pass代表通过，reject代表拒绝';
alter table cl_order add column time_out varchar(3) not null default 'no' comment '今日日期是否大于预定日期，on代表没有，yes代表超时';
alter table cl_order add column order_usernum char(11) not null comment '申请人的账号，用户确认申请人的唯一性';