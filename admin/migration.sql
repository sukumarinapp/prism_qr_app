alter table posout add sesson int(1) default 0;
alter table posmas add STKOUT int(1) default 0;
alter table posord add OTP varchar(10) default NULL;

alter table posord add ORDNUB varchar(20) default NULL;
ALTER TABLE posord AUTO_INCREMENT = 101;
http://prismblr.com/kot/clear_table.php?ordnub=ORDPRISMAPP-101