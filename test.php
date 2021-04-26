CREATE DEFINER=`keith`@`%` PROCEDURE `trade_stats`(
	in pid int,
	-- 日
	out user_num_d int,
	out user_d decimal(12,2),
	out course_num_d int,
	out course_d decimal(12,2),
	out train_num_d int,
	out train_d decimal(12,2),
	out test_num_d int,
	out test_d decimal(12,2),
	out goods_num_d int,
	out goods_d decimal(12,2),
	out total_num_d int,
	out total_d decimal(12,2),
	out user_num_d2 int,
	out user_d2 decimal(12,2),
	out course_num_d2 int,
	out course_d2 decimal(12,2),
	out train_num_d2 int,
	out train_d2 decimal(12,2),
	out test_num_d2 int,
	out test_d2 decimal(12,2),
	out goods_num_d2 int,
	out goods_d2 decimal(12,2),
	out total_num_d2 int,
	out total_d2 decimal(12,2),
	-- 月
	out user_num_m int,
	out user_m decimal(12,2),
	out course_num_m int,
	out course_m decimal(12,2),
	out train_num_m int,
	out train_m decimal(12,2),
	out test_num_m int,
	out test_m decimal(12,2),
	out goods_num_m int,
	out goods_m decimal(12,2),
	out total_num_m int,
	out total_m decimal(12,2),
	out user_num_m2 int,
	out user_m2 decimal(12,2),
	out course_num_m2 int,
	out course_m2 decimal(12,2),
	out train_num_m2 int,
	out train_m2 decimal(12,2),
	out test_num_m2 int,
	out test_m2 decimal(12,2),
	out goods_num_m2 int,
	out goods_m2 decimal(12,2),
	out total_num_m2 int,
	out total_m2 decimal(12,2),
	# 年
	out user_num_y int,
	out user_y decimal(12,2),
	out course_num_y int,
	out course_y decimal(12,2),
	out train_num_y int,
	out train_y decimal(12,2),
	out test_num_y int,
	out test_y decimal(12,2),
	out goods_num_y int,
	out goods_y decimal(12,2),
	out total_num_y int,
	out total_y decimal(12,2),
	out user_num_y2 int,
	out user_y2 decimal(12,2),
	out course_num_y2 int,
	out course_y2 decimal(12,2),
	out train_num_y2 int,
	out train_y2 decimal(12,2),
	out test_num_y2 int,
	out test_y2 decimal(12,2),
	out goods_num_y2 int,
	out goods_y2 decimal(12,2),
	out total_num_y2 int,
	out total_y2 decimal(12,2)
)
begin
declare repeat_vip decimal(12,2);
declare repeat_course decimal(12,2);
declare repeat_train decimal(12,2);
declare repeat_goods decimal(12,2);
declare repeat_test decimal(12,2);
declare month tinyint;
declare i int;
declare total decimal(12,2);
-- 日
declare c_user_d cursor for
select ifnull(count(*),0),ifnull(sum(price),0) from tt_online_order where status=1 and type!=0 and price!=0 and to_days(now())-to_days(from_unixtime(paytime))=0;
declare c_user_d2 cursor for
select ifnull(count(*),0),ifnull(sum(price),0) from tt_online_order where status=1 and type!=0 and price!=0 and to_days(now())-to_days(from_unixtime(paytime))=1;
declare c_course_d cursor for
select ifnull(count(*),0),ifnull(sum(price),0) from tt_online_order where status=1 and type=0 and price!=0 and to_days(now())-to_days(from_unixtime(paytime))=0;
declare c_course_d2 cursor for
select ifnull(count(*),0),ifnull(sum(price),0) from tt_online_order where status=1 and type=0 and price!=0 and to_days(now())-to_days(from_unixtime(paytime))=1;
declare c_train_d cursor for
select ifnull(count(*),0),ifnull(sum(order_price),0) from tt_pxorder_info where status=1 and order_price!=0 and to_days(now())-to_days(order_paytime)=0;
declare c_train_d2 cursor for
select ifnull(count(*),0),ifnull(sum(order_price),0) from tt_pxorder_info where status=1 and order_price!=0 and to_days(now())-to_days(order_paytime)=1;
declare c_test_d cursor for
select ifnull(count(*),0),ifnull(sum(price),0) from tt_test_order where status=1 and price!=0 and to_days(now())-to_days(from_unixtime(pay_time))=0;
declare c_test_d2 cursor for
select ifnull(count(*),0),ifnull(sum(price),0) from tt_test_order where status=1 and price!=0 and to_days(now())-to_days(from_unixtime(pay_time))=1;
declare c_goods_d cursor for
select ifnull(count(*),0),ifnull(sum(order_price),0) from tt_shop_order where order_status=1 and order_price!=0 and to_days(now())-to_days(order_paytime)=0;
declare c_goods_d2 cursor for
select ifnull(count(*),0),ifnull(sum(order_price),0) from tt_shop_order where order_status=1 and order_price!=0 and to_days(now())-to_days(order_paytime)=1;

-- 月
declare c_user_m cursor for
select ifnull(count(*),0),ifnull(sum(price),0) from tt_online_order where status=1 and type!=0 and price!=0 and from_unixtime(paytime,'%Y-%m')=date_format(curdate(),'%Y-%m');
declare c_user_m2 cursor for
select ifnull(count(*),0),ifnull(sum(price),0) from tt_online_order where status=1 and type!=0 and price!=0 and period_diff(date_format(now(),'%Y%m'),from_unixtime(paytime,'%Y%m'))=1;
declare c_course_m cursor for
select ifnull(count(*),0),ifnull(sum(price),0) from tt_online_order where status=1 and type=0 and price!=0 and from_unixtime(paytime,'%Y-%m')=date_format(curdate(),'%Y-%m');
declare c_course_m2 cursor for
select ifnull(count(*),0),ifnull(sum(price),0) from tt_online_order where status=1 and type=0 and price!=0 and period_diff(date_format(now(),'%Y%m'),from_unixtime(paytime,'%Y%m'))=1;
declare c_train_m cursor for
select ifnull(count(*),0),ifnull(sum(order_price),0) from tt_pxorder_info where status=1 and order_price!=0 and date_format(order_paytime,'%Y-%m')=date_format(curdate(),'%Y-%m');
declare c_train_m2 cursor for
select ifnull(count(*),0),ifnull(sum(order_price),0) from tt_pxorder_info where status=1 and order_price!=0 and period_diff(date_format(now(),'%Y%m'),date_format(order_paytime,'%Y%m'))=1;
declare c_test_m cursor for
select ifnull(count(*),0),ifnull(sum(price),0) from tt_test_order where status=1 and price!=0 and from_unixtime(pay_time,'%Y-%m')=date_format(curdate(),'%Y-%m');
declare c_test_m2 cursor for
select ifnull(count(*),0),ifnull(sum(price),0) from tt_test_order where status=1 and price!=0 and period_diff(date_format(now(),'%Y%m'),from_unixtime(pay_time,'%Y%m'))=1;
declare c_goods_m cursor for
select ifnull(count(*),0),ifnull(sum(order_price),0) from tt_shop_order where order_status=1 and order_price!=0 and date_format(order_paytime,'%Y-%m')=date_format(curdate(),'%Y-%m');
declare c_goods_m2 cursor for
select ifnull(count(*),0),ifnull(sum(order_price),0) from tt_shop_order where order_status=1 and order_price!=0 and period_diff(date_format(now(),'%Y%m'),date_format(order_paytime,'%Y%m'))=1;

-- 年
declare c_user_y cursor for
select ifnull(count(*),0),ifnull(sum(price),0) from tt_online_order where status=1 and type!=0 and price!=0 and from_unixtime(paytime,'%Y')=date_format(curdate(),'%Y');
declare c_user_y2 cursor for
select ifnull(count(*),0),ifnull(sum(price),0) from tt_online_order where status=1 and type!=0 and price!=0 and period_diff(date_format(now(),'%Y'),from_unixtime(paytime,'%Y'))=1;
declare c_course_y cursor for
select ifnull(count(*),0),ifnull(sum(price),0) from tt_online_order where status=1 and type=0 and price!=0 and from_unixtime(paytime,'%Y')=date_format(curdate(),'%Y');
declare c_course_y2 cursor for
select ifnull(count(*),0),ifnull(sum(price),0) from tt_online_order where status=1 and type=0 and price!=0 and period_diff(date_format(now(),'%Y'),from_unixtime(paytime,'%Y'))=1;
declare c_train_y cursor for
select ifnull(count(*),0),ifnull(sum(order_price),0) from tt_pxorder_info where status=1 and order_price!=0 and date_format(order_paytime,'%Y')=date_format(curdate(),'%Y');
declare c_train_y2 cursor for
select ifnull(count(*),0),ifnull(sum(order_price),0) from tt_pxorder_info where status=1 and order_price!=0 and period_diff(date_format(now(),'%Y'),date_format(order_paytime,'%Y'))=1;
declare c_test_y cursor for
select ifnull(count(*),0),ifnull(sum(price),0) from tt_test_order where status=1 and price!=0 and from_unixtime(pay_time,'%Y')=date_format(curdate(),'%Y');
declare c_test_y2 cursor for
select ifnull(count(*),0),ifnull(sum(price),0) from tt_test_order where status=1 and price!=0 and period_diff(date_format(now(),'%Y'),from_unixtime(pay_time,'%Y'))=1;
declare c_goods_y cursor for
select ifnull(count(*),0),ifnull(sum(order_price),0) from tt_shop_order where order_status=1 and order_price!=0 and date_format(order_paytime,'%Y')=date_format(curdate(),'%Y');
declare c_goods_y2 cursor for
select ifnull(count(*),0),ifnull(sum(order_price),0) from tt_shop_order where order_status=1 and order_price!=0 and period_diff(date_format(now(),'%Y'),date_format(order_paytime,'%Y'))=1;



-- 表
drop temporary table if exists trade_total_12month;
create temporary table trade_total_12month(
	month tinyint not null default 0,
	total decimal(12,2) not null default 0.00
);
drop temporary table if exists trade_user_12month;
create temporary table trade_user_12month(
	month tinyint not null default 0,
	total decimal(12,2) not null default 0.00
);
drop temporary table if exists trade_course_12month;
create temporary table trade_course_12month(
	month tinyint not null default 0,
	total decimal(12,2) not null default 0.00
);
drop temporary table if exists trade_train_12month;
create temporary table trade_train_12month(
	month tinyint not null default 0,
	total decimal(12,2) not null default 0.00
);
drop temporary table if exists trade_test_12month;
create temporary table trade_test_12month(
	month tinyint not null default 0,
	total decimal(12,2) not null default 0.00
);
drop temporary table if exists trade_goods_12month;
create temporary table trade_goods_12month(
	month tinyint not null default 0,
	total decimal(12,2) not null default 0.00
);





set i=11;
repeat

select ifnull(sum(price),0) into repeat_vip from tt_online_order where status=1 and type != 0 and period_diff(date_format(curdate(),'%Y%m'),from_unixtime(paytime,'%Y%m'))=i;
select ifnull(sum(price),0) into repeat_course from tt_online_order where status=1 and type=0 and period_diff(date_format(curdate(),'%Y%m'),from_unixtime(paytime,'%Y%m'))=i;
select ifnull(sum(order_price),0) into repeat_train from tt_pxorder_info where status=1 and period_diff(date_format(curdate(),'%Y%m'),date_format(order_paytime,'%Y%m'))=i;
select ifnull(sum(order_price),0) into repeat_goods from tt_shop_order where order_status=1 and period_diff(date_format(curdate(),'%Y%m'),date_format(order_paytime,'%Y%m'))=i;
select ifnull(sum(price),0) into repeat_test from tt_test_order where status=1 and period_diff(date_format(curdate(),'%Y%m'),date_format(from_unixtime(pay_time),'%Y%m'))=i;

set month=date_format(date_sub(curdate(),interval i month),'%m');

insert into trade_user_12month values (month,repeat_vip);
insert into trade_course_12month values (month,repeat_course);
insert into trade_train_12month values (month,repeat_train);
insert into trade_test_12month values (month,repeat_test);
insert into trade_goods_12month values (month,repeat_goods);

set total=repeat_vip+repeat_course+repeat_train+repeat_goods+repeat_test;
insert into trade_total_12month values (month,total);
set i=i-1;
until i<0 end repeat;


-- 赋值
open c_user_d;open c_user_d2;open c_course_d;open c_course_d2;open c_train_d;open c_train_d2;open c_test_d;open c_test_d2;open c_goods_d;open c_goods_d2;

fetch c_user_d into user_num_d,user_d;
fetch c_user_d2 into user_num_d2,user_d2;
fetch c_course_d into course_num_d,course_d;
fetch c_course_d2 into course_num_d2,course_d2;
fetch c_train_d into train_num_d,train_d;
fetch c_train_d2 into train_num_d2,train_d2;
fetch c_test_d into test_num_d,test_d;
fetch c_test_d2 into test_num_d2,test_d2;
fetch c_goods_d into goods_num_d,goods_d;
fetch c_goods_d2 into goods_num_d2,goods_d2;

set total_num_d=user_num_d+course_num_d+train_num_d+test_num_d+goods_num_d;
set total_d=user_d+course_d+train_d+test_d+goods_d;
set total_num_d2=user_num_d2+course_num_d2+train_num_d2+test_num_d2+goods_num_d2;
set total_d2=user_d2+course_d2+train_d2+test_d2+goods_d;

close c_user_d;close c_user_d2;close c_course_d;close c_course_d2;close c_train_d;close c_train_d2;close c_test_d;close c_test_d2;close c_goods_d;close c_goods_d2;

-- 月
open c_user_m;open c_user_m2;open c_course_m;open c_course_m2;open c_train_m;open c_train_m2;open c_test_m;open c_test_m2;open c_goods_m;open c_goods_m2;

fetch c_user_m into user_num_m,user_m;
fetch c_user_m2 into user_num_m2,user_m2;
fetch c_course_m into course_num_m,course_m;
fetch c_course_m2 into course_num_m2,course_m2;
fetch c_train_m into train_num_m,train_m;
fetch c_train_m2 into train_num_m2,train_m2;
fetch c_test_m into test_num_m,test_m;
fetch c_test_m2 into test_num_m2,test_m2;
fetch c_goods_m into goods_num_m,goods_m;
fetch c_goods_m2 into goods_num_m2,goods_m2;

set total_num_m=user_num_m+course_num_m+train_num_m+test_num_m+goods_num_m;
set total_m=user_m+course_m+train_m+test_m+goods_m;
set total_num_m2=user_num_m2+course_num_m2+train_num_m2+test_num_m2+goods_num_m2;
set total_m2=user_m2+course_m2+train_m2+test_m2+goods_m2;

close c_user_m;close c_user_m2;close c_course_m;close c_course_m2;close c_train_m;close c_train_m2;close c_test_m;close c_test_m2;close c_goods_m;close c_goods_m2;

-- 年
open c_user_y;open c_user_y2;open c_course_y;open c_course_y2;open c_train_y;open c_train_y2;open c_test_y;open c_test_y2;open c_goods_y;open c_goods_y2;

fetch c_user_y into user_num_y,user_y;
fetch c_user_y2 into user_num_y2,user_y2;
fetch c_course_y into course_num_y,course_y;
fetch c_course_y2 into course_num_y2,course_y2;
fetch c_train_y into train_num_y,train_y;
fetch c_train_y2 into train_num_y2,train_y2;
fetch c_test_y into test_num_y,test_y;
fetch c_test_y2 into test_num_y2,test_y2;
fetch c_goods_y into goods_num_y,goods_y;
fetch c_goods_y2 into goods_num_y2,goods_y2;

set total_num_y=user_num_y+course_num_y+train_num_y+test_num_y+goods_num_y;
set total_y=user_y+course_y+train_y+test_y+goods_y;
set total_num_y2=user_num_y2+course_num_y2+train_num_y2+test_num_y2+goods_num_y2;
set total_y2=user_y2+course_y2+train_y2+test_y2+goods_y;

close c_user_y;close c_user_y2;close c_course_y;close c_course_y2;close c_train_y;close c_train_y2;close c_test_y;close c_test_y2;close c_goods_y;close c_goods_y2;



end